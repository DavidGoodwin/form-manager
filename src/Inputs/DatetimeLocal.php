<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="datetime-local"] element
 */
class DatetimeLocal extends Input
{
	const INTR_VALIDATORS = [
		'datetimeLocal'
	];

	const ATTR_VALIDATORS = [
		// 'step',
		'max',
		'min',
	];
	
    public function __construct(array $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'datetime-local');
    }
}
