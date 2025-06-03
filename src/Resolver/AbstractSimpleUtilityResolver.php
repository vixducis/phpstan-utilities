<?php

namespace Vixducis\PhpstanUtilities\Resolver;

use PHPStan\Analyser\NameScope;
use PHPStan\PhpDoc\TypeNodeResolver;
use PHPStan\PhpDoc\TypeNodeResolverAwareExtension;
use PHPStan\PhpDoc\TypeNodeResolverExtension;
use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\Type;
use Vixducis\PhpstanUtilities\Type\AbstractSimpleUtilityType;

abstract class AbstractSimpleUtilityResolver
implements TypeNodeResolverExtension, TypeNodeResolverAwareExtension
{
    private TypeNodeResolver $typeNodeResolver;

    public function setTypeNodeResolver(TypeNodeResolver $typeNodeResolver): void
    {
        $this->typeNodeResolver = $typeNodeResolver;
    }

    /**
     * Returns the type classname that this should resolve to.
     * 
     * @return class-string<AbstractSimpleUtilityType>
     */
    abstract public static function getTypeClass();

    public function resolve(TypeNode $typeNode, NameScope $nameScope): ?Type
    {
        if (!$typeNode instanceof GenericTypeNode) {
            return null;
        }

        $typeName = $typeNode->type;
        $className = static::getTypeClass();
        if ($typeName->name !== $className::getIdentifier()) {
            return null;
        }

        $arguments = $typeNode->genericTypes;
        if (count($arguments) !== 1) {
            return null;
        }

        $type = $this->typeNodeResolver->resolve($arguments[0], $nameScope);
        return new $className($type);
    }
}
