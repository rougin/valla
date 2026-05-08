<?php

namespace Rougin\Valla;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Rule
{
    /**
     * @var \Rougin\Valla\Valid
     */
    protected $valid;

    /**
     * @param \Rougin\Valla\Valid $valid
     */
    public function __construct(Valid $valid)
    {
        $this->valid = $valid;
    }

    /**
     * Parses the specified rule against its value.
     *
     * @param string $rule
     * @param string $value
     *
     * @return \Rougin\Valla\Valid
     */
    public function parse($rule, $value)
    {
        // Break down multiple rules ---
        $items = explode('|', $value);
        // -----------------------------

        foreach ($items as $item)
        {
            // Parse each rule --------
            $this->check($item, $rule);
            // ------------------------
        }

        return $this->valid;
    }

    /**
     * Checks the specified rules.
     *
     * @param string $item
     * @param string $field
     *
     * @return void
     */
    protected function check($item, $field)
    {
        $details = explode(':', $item);

        $name = trim($details[0]);

        $values = array();

        // Extract all dependency fields/values ---
        if (count($details) > 1)
        {
            $details[1] = trim($details[1]);

            /** @var string[] */
            $values = explode(',', $details[1]);
        }
        // ----------------------------------------

        $onlyOne = count($values) === 1;

        /** @var string */
        $value = end($values);

        $strict = trim($value) === 'true';

        if ($name === 'contains')
        {
            $this->valid->add($name, $field, $values, $strict);

            return;
        }

        if ($name === 'creditCard')
        {
            $values = $onlyOne ? trim($values[0]) : $values;

            $this->valid->add($name, $field, $values);

            return;
        }

        if ($name === 'in')
        {
            $this->valid->add($name, $field, $values);

            return;
        }

        if ($name === 'instanceOf')
        {
            $value = trim($values[0]);

            // TODO: Setup ContainerInterface for autowiring ---
            $value = new $value;
            // -------------------------------------------------

            $this->valid->add($name, $field, $value);

            return;
        }

        if ($name === 'notIn')
        {
            $this->valid->add($name, $field, $values);

            return;
        }

        if ($name === 'required')
        {
            $this->valid->add($name, $field, $strict);
        }

        if ($name === 'requiredWith')
        {
            $this->valid->add($name, $field, $values, $strict);

            return;
        }

        if ($name === 'requiredWithout')
        {
            $this->valid->add($name, $field, $values, $strict);

            return;
        }

        if ($name === 'subset')
        {
            $this->valid->add($name, $field, $values);

            return;
        }

        // Rule without fields/values --------
        if (count($values) === 0)
        {
            $this->valid->add($name, $field);
        }
        // -----------------------------------

        // Rule with only 1 value/field --------------
        if ($onlyOne && trim(end($values)) !== 'true')
        {
            $value = trim($values[0]);

            $this->valid->add($name, $field, $value);
        }
        // -------------------------------------------
    }
}
