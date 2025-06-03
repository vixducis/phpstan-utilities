<?php

namespace Vixducis\PhpstanUtilities\Resolver;

use Vixducis\PhpstanUtilities\Type\UnwrapSingletonArrayType;

class UnwrapSingletonArrayResolver extends AbstractSimpleUtilityResolver
{
    public static function getTypeClass()
    {
        return UnwrapSingletonArrayType::class;
    }
}
