<?php

namespace Vixducis\PhpstanUtilities\Resolver;

use Vixducis\PhpstanUtilities\Type\ArrayValuesType;

class ArrayValuesTypeResolver extends AbstractSimpleUtilityResolver
{
	public static function getTypeClass()
	{
		return ArrayValuesType::class;
	}
}
