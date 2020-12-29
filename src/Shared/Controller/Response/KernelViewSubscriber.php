<?php

declare(strict_types=1);

namespace App\Shared\Controller\Response;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class KernelViewSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['onKernelView', 16],
        ];
    }

    /*
     * @see Thanks to this subscriber i can directly return the object from the controller
     */
    public function onKernelView(ViewEvent $event): void
    {
        $controllerResult = $event->getControllerResult();

        if ($controllerResult instanceof Response) {
            return;
        }

        $event->setResponse(new JsonResponse($controllerResult));
    }
}
