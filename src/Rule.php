<?php

namespace Rougin\Valla;

use Rougin\Valla\Rules\Contains;
use Rougin\Valla\Rules\CreditCard;
use Rougin\Valla\Rules\Email;
use Rougin\Valla\Rules\In;
use Rougin\Valla\Rules\IsInstance;
use Rougin\Valla\Rules\LengthMax;
use Rougin\Valla\Rules\LengthMin;
use Rougin\Valla\Rules\NotIn;
use Rougin\Valla\Rules\Numeric;
use Rougin\Valla\Rules\Required;
use Rougin\Valla\Rules\RequiredWith;
use Rougin\Valla\Rules\RequiredWithout;
use Rougin\Valla\Rules\Subset;

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
        $texts = explode(':', $item);

        $name = trim($texts[0]);

        $value = '';

        $values = array();

        // Extract all dependency fields/values ---
        if (count($texts) > 1)
        {
            $texts[1] = trim($texts[1]);

            $values = explode(',', $texts[1]);

            $value = $values[count($values) - 1];
        }
        // ----------------------------------------

        $strict = trim($value) === 'true';

        $rule = null;

        if ($name === Contains::getName())
        {
            $rule = new Contains($values[0]);
        }

        if ($name === CreditCard::getName())
        {
            $rule = new CreditCard;
        }

        if ($name === Email::getName())
        {
            $rule = new Email;
        }

        if ($name === In::getName())
        {
            $rule = new In($values);
        }

        if ($name === IsInstance::getName())
        {
            $class = trim($values[0]);

            // TODO: Setup ContainerInterface for autowiring ---
            $value = new $class;
            // -------------------------------------------------

            $rule = new IsInstance($value);
        }

        if ($name === LengthMax::getName())
        {
            $rule = new LengthMax((int) $values[0]);
        }

        if ($name === LengthMin::getName())
        {
            $rule = new LengthMin((int) $values[0]);
        }

        if ($name === NotIn::getName())
        {
            $rule = new NotIn($values);
        }

        if ($name === Numeric::getName())
        {
            $rule = new Numeric;
        }

        if ($name === Required::getName())
        {
            $rule = new Required($strict);
        }

        if ($name === RequiredWith::getName())
        {
            $rule = new RequiredWith($values, $strict);
        }

        if ($name === RequiredWithout::getName())
        {
            $rule = new RequiredWithout($values, $strict);
        }

        if ($name === Subset::getName())
        {
            $rule = new Subset($values);
        }

        if ($rule === null)
        {
            $error = 'Rule "' . $name . '" not found';

            throw new \Exception($error);
        }

        $this->valid->add($rule, $field);
    }
}
