<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="password"] element
 */
class Password extends Input
{
	const INTR_VALIDATORS = [];

	const ATTR_VALIDATORS = [
		'maxlength',
        'minlength',
        'pattern',
	];
	
    public function __construct(array $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'password');
    }
}
