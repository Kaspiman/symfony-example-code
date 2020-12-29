<?php

namespace App\Shared\Controller\Request;

use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class RequestObjectArgumentValueResolver implements ArgumentValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return is_a($argument->getType(), RequestObject::class, true);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        /** @var RequestObject $class */
        $class = $argument->getType();

        yield $class::createFromRequestPayload(
            $request->request->all(),
            $request->query->all(),
            $request->attributes->all()
        );
    }
}
