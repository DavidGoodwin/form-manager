<?php
namespace FormManager\Fields;

use FormManager\Traits\ChildTrait;

use FormManager\Label;
use FormManager\Element;
use FormManager\InputInterface;

class Field implements InputInterface {
	use ChildTrait;

	public $input;

	public static function __callStatic ($name, $arguments) {
		$class = __NAMESPACE__.'\\'.ucfirst($name);

		if (class_exists($class)) {
			if (isset($arguments[0])) {
				return new $class($arguments[0]);
			}

			return new $class;
		}

		$input = 'FormManager\\Inputs\\'.ucfirst($name);

		if (class_exists($input)) {
			return new static(new $input);
		}
	}

	public function __construct (InputInterface $input = null) {
		if ($input) {
			$this->input = $input;
		}
	}

	public function __toString () {
		return $this->toHtml();
	}

	public function __call ($name, $arguments) {
		call_user_func_array([$this->input, $name], $arguments);

		return $this;
	}

	public function __clone () {
		$this->input = clone $this->input;

		if (isset($this->label)) {
			$this->label = clone $this->label;
			$this->label->setInput($this->input);
		}
	}

	public function __get ($name) {
		if ($name === 'label') {
			return $this->label = new Label($this->input);
		}

		if ($name === 'wrapper') {
			return $this->wrapper = new Element;
		}

		if (($name === 'errorLabel') && ($error = $this->error())) {
			return new Label($this->input, ['class' => 'error'], $error);
		}
	}

	public function label ($html = null) {
		if ($html === null) {
			return $this->label->html();
		}

		$this->label->html($html);

		return $this;
	}

	public function wrapper ($name, array $attributes = null) {
		$this->wrapper->setElementName($name, true);

		if ($attributes) {
			$this->wrapper->attr($attributes);
		}

		return $this;
	}

	public function error ($error = null) {
		if ($error === null) {
			return $this->input->error($error);
		}

		$this->input->error($error);

		return $this;
	}

	public function id ($id = null) {
		if ($id === null) {
			return $this->input->id();
		}

		$this->input->id($id);

		return $this;
	}

	public function attr ($name = null, $value = null) {
		if (($value !== null) || (is_array($name))) {
			$this->input->attr($name, $value);

			return $this;
		}

		return $this->input->attr($name);
	}

	public function removeAttr ($name) {
		$this->input->removeAttr($name);

		return $this;
	}

	public function load ($value = null, $file = null) {
		$this->input->load($value, $file);

		return $this;
	}

	public function sanitize (callable $sanitizer) {
		return $this->input->sanitize($sanitizer);
	}

	public function val ($value = null) {
		if ($value === null) {
			return $this->input->val();
		}

		$this->input->val($value);

		return $this;
	}

	public function isValid () {
		return $this->input->isValid();
	}

	public function toHtml () {
		$label = isset($this->label) ? (string)$this->label : '';
		$html = "{$label} {$this->input} {$this->errorLabel}";

		if (isset($this->wrapper)) {
			return $this->wrapper->toHtml($html);
		}

		return $html;
	}

	public function setKey ($key) {
		$this->input->setKey($key);

		return $this;
	}

	public function setParent (InputInterface $parent) {
		$this->input->setParent($parent);

		return $this;
	}

	public function getParent () {
		return $this->input->getParent();
	}

	public function getInputName () {
		return $this->input->getInputName();
	}

	public function generateInputName () {
		return $this->input->generateInputName();
	}
}
