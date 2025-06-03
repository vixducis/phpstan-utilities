<?php

namespace Vixducis\PhpstanUtilities\Type;

use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;

class ArrayValuesType extends AbstractSimpleUtilityType
{
    protected function getResult(): Type
    {
        $type = $this->getInternalType();
        if ($type->isArray()->yes()) {
            return $type->getValuesArray();
        }

        return new ErrorType;
    }

    public static function getIdentifier(): string
    {
        return 'ArrayValues';
    }
}
