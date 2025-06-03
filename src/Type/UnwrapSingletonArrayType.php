<?php

namespace Vixducis\PhpstanUtilities\Type;

use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;

class UnwrapSingletonArrayType extends AbstractSimpleUtilityType
{
    public static function getIdentifier(): string
    {
        return 'UnwrapSingletonArray';
    }

    protected function getResult(): Type
    {
        $type = $this->getInternalType();
        if ($type->isArray()->yes()) {
            $values = $type->getValuesArray();
            $size = $values->getArraySize();
            if (
                $size->equals(new ConstantIntegerType(1))
                && $values->isArray()->yes()
            ) {
                $arrayValueType = $values->getIterableValueType();
                return new UnionType(
                    $arrayValueType instanceof UnionType
                        ? [$type, ...$arrayValueType->getTypes()]
                        : [$type, $arrayValueType]
                );
            }
        }

        return $type;
    }
}
