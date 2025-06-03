<?php

namespace Vixducis\PhpstanUtilities\Resolver;

use Vixducis\PhpstanUtilities\Type\UnionToIntersectionType;

class UnionToIntersectionTypeResolver extends AbstractSimpleUtilityResolver
{
	public static function getTypeClass()
	{
		return UnionToIntersectionType::class;
	}
}
