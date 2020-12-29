<?php

declare(strict_types=1);

namespace App\Shared\Controller\Response;

use App\Shared\Domain\Exception\BusinessLogicViolationException;
use App\Shared\Domain\Exception\DomainException;
use App\Shared\Domain\Exception\InvalidInputDataException;
use App\Shared\Domain\Exception\ResourceNotFoundException;
use App\Shared\Domain\Exception\UnexpectedDomainException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\ValidationFailedException as MessengerValidationFailedException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException as ValidatorValidationFailedException;
use Throwable;

final class ExceptionConverterSubscriber implements EventSubscriberInterface
{
    private NormalizerInterface $normalizer;

    public function __construct(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 10],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $throwable = $this->convertThrowable($event->getThrowable());

        $event->setResponse($this->composeResponse($throwable));
    }

    /*
     * @see Here i convert Domain (or any) exceptions into HTTP exceptions
     */
    private function convertThrowable(Throwable $throwable): HttpExceptionInterface
    {
        if ($throwable instanceof HandlerFailedException) {
            $throwable = $throwable->getPrevious();
        }

        $httpException = null;

        switch (true) {
            case $throwable instanceof ResourceNotFoundException:
                return new NotFoundHttpException($throwable->getMessage(), $throwable);
            case $throwable instanceof InvalidInputDataException:
            case $throwable instanceof ValidatorValidationFailedException:
            case $throwable instanceof MessengerValidationFailedException:
                return new BadRequestHttpException($throwable->getMessage(), $throwable);
            case $throwable instanceof BusinessLogicViolationException:
                return new UnprocessableEntityHttpException($throwable->getMessage(), $throwable);
            case $throwable instanceof UnexpectedDomainException:
            default:
                return new HttpException(500, $throwable->getMessage(), $throwable);
        }
    }

    private function composeResponse(HttpExceptionInterface $throwable): JsonResponse
    {
        $data = [
            'message' => $throwable->getMessage(),
        ];

        if (($previous = $throwable->getPrevious())) {
            if ($previous instanceof DomainException) {
                $errors = $previous->getErrors();
            } elseif ($previous instanceof ValidatorValidationFailedException || $previous instanceof MessengerValidationFailedException) {
                $errors = $previous->getViolations();
            } else {
                $errors = null;
            }

            if ($errors) {
                $data['errors'] = $this->normalizer->normalize($errors);
            }
        }

        return new JsonResponse(
            $data,
            $throwable->getStatusCode(),
        );
    }
}
