<?php

namespace Vixducis\PhpstanUtilities\Type;

use PHPStan\Type\ErrorType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\UnionType;
use PHPStan\Type\Type;

class UnionToIntersectionType
extends AbstractSimpleUtilityType
{
    public static function getIdentifier(): string
    {
        return 'UnionToIntersection';
    }

    protected function getResult(): Type
    {
        $type = $this->getInternalType();
        if ($type instanceof UnionType) {
            return new IntersectionType($type->getTypes());
        }

        return new ErrorType;
    }
}
