<?php

namespace Vixducis\PhpstanUtilities\Type;

use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\CompoundType;
use PHPStan\Type\GeneralizePrecision;
use PHPStan\Type\Generic\TemplateTypeVariance;
use PHPStan\Type\LateResolvableType;
use PHPStan\Type\Traits\LateResolvableTypeTrait;
use PHPStan\Type\Type;
use PHPStan\Type\TypeUtils;
use PHPStan\Type\VerbosityLevel;

abstract class AbstractSimpleUtilityType
implements LateResolvableType, CompoundType
{
    use LateResolvableTypeTrait;

    final public function __construct(private Type $type) {}

    abstract public static function getIdentifier(): string;

    /**
     * Obtain the embedded type.
     */
    protected function getInternalType(): Type
    {
        return $this->type;
    }

    public function equals(Type $type): bool
    {
        return $type instanceof self && $this->type->equals($type->type);
    }

    public function describe(VerbosityLevel $level): string
    {
        return $this->getIdentifier() . '<' . $this->type->describe($level) . '>';
    }

    public function isResolvable(): bool
    {
        return false === TypeUtils::containsTemplateType($this->type);
    }

    public function toPhpDocNode(): TypeNode
    {
        return new GenericTypeNode(
            new IdentifierTypeNode(static::getIdentifier()),
            [$this->type->toPhpDocNode()]
        );
    }

    public function generalize(GeneralizePrecision $precision): Type
    {
        return $this->type->generalize($precision);
    }

    /**
     * @param callable(Type): Type $cb
     */
    public function traverse(callable $cb): Type
    {
        $type = $cb($this->type);

        if ($this->type === $type) {
            return $this;
        }

        return new static($type);
    }

    public function traverseSimultaneously(Type $right, callable $cb): Type
    {
        if (!$right instanceof self) {
            return $this;
        }

        $type = $cb($this->type, $right->type);

        if ($this->type === $type) {
            return $this;
        }

        return new static($type);
    }

    public function getReferencedClasses(): array
    {
        return $this->type->getReferencedClasses();
    }

    public function getReferencedTemplateTypes(TemplateTypeVariance $positionVariance): array
    {
        return $this->type->getReferencedTemplateTypes($positionVariance);
    }
}