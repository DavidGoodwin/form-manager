<?php

namespace FormManager\Elements;

use FormManager\InputInterface;
use FormManager\Traits\ValidateTrait;
use FormManager\Traits\StructureTrait;
use FormManager\Traits\LabelTrait;

class Input extends Element implements InputInterface
{
    use ValidateTrait;
    use StructureTrait;
    use LabelTrait;

    protected $name = 'input';

    /**
     * {@inheritdoc}
     */
    public function attr($name = null, $value = null)
    {
        if (is_string($name)) {
            if ($value === null) {
                if ($name === 'name' && $this->getParent()) {
                    return $this->getPath();
                }

                return parent::attr($name);
            }

            if ($name === 'name' && $this->getParent()) {
                throw new \InvalidArgumentException('The attribute "name" is read only!');
            }

            $value = $this->attrToValidator($name, $value);
        }

        return parent::attr($name, $value);
    }

    /**
     * Generate the right name attribute for this input.
     *
     * @return string
     */
    private function getNameAttr()
    {
        $name = $this->getPath();

        if ($this->attr('multiple')) {
            $name .= '[]';
        }

        return $name;
    }

    /**
     * Calculate the input name on print.
     *
     * {@inheritdoc}
     */
    protected function attrToHtml()
    {
        //Generate the name
        if (($name = $this->getPath()) !== null) {
            $this->attributes['name'] = $this->getNameAttr();
        }

        //Generate the aria attributes for labels http://www.html5accessibility.com/tests/mulitple-labels.html
        $labelled = [];

        foreach ($this->labels as $label) {
            if ($label->html()) {
                $labelled[] = $label->id();
            }
        }

        if (count($labelled)) {
            $this->attributes['aria-labelledby'] = $labelled;
        }

        //Generate the datalist attribute
        if (!empty($this->datalist) && $this->datalist->count() > 0) {
            $this->attributes['list'] = $this->datalist->id();
        }

        return parent::attrToHtml();
    }
}
