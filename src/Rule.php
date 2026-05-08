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
     * Matches the specified rule against its value.
     *
     * @param string $field
     * @param string $value
     *
     * @return \Rougin\Valla\Valid
     */
    public function match($field, $value)
    {
        // Break down multiple rules ---
        $items = explode('|', $value);
        // -----------------------------

        foreach ($items as $item)
        {
            // Attach each specified rule -------
            $rule = $this->check($item);

            $this->valid->addRule($rule, $field);
            // ----------------------------------
        }

        return $this->valid;
    }

    /**
     * Checks the specified rules.
     *
     * @param string $item
     *
     * @return \Rougin\Valla\RuleInterface
     */
    protected function check($item)
    {
        $texts = explode(':', $item);

        $name = trim($texts[0]);

        $value = '';

        $values = array();

        // Extract all dependency fields/values ----
        if (count($texts) > 1)
        {
            $values = explode(',', trim($texts[1]));

            $value = $values[count($values) - 1];
        }
        // -----------------------------------------

        if ($name === Contains::getName())
        {
            return new Contains($values[0]);
        }

        if ($name === CreditCard::getName())
        {
            return new CreditCard;
        }

        if ($name === Email::getName())
        {
            return new Email;
        }

        if ($name === In::getName())
        {
            return new In($values);
        }

        if ($name === IsInstance::getName())
        {
            $class = trim($values[0]);

            // TODO: Setup ContainerInterface for autowiring ---
            $value = new $class;
            // -------------------------------------------------

            return new IsInstance($value);
        }

        if ($name === LengthMax::getName())
        {
            return new LengthMax((int) $values[0]);
        }

        if ($name === LengthMin::getName())
        {
            return new LengthMin((int) $values[0]);
        }

        if ($name === NotIn::getName())
        {
            return new NotIn($values);
        }

        if ($name === Numeric::getName())
        {
            return new Numeric;
        }

        $strict = trim($value) === 'true';

        if ($name === Required::getName())
        {
            return new Required($strict);
        }

        if ($name === RequiredWith::getName())
        {
            return new RequiredWith($values, $strict);
        }

        if ($name === RequiredWithout::getName())
        {
            return new RequiredWithout($values, $strict);
        }

        if ($name === Subset::getName())
        {
            return new Subset($values);
        }

        $error = 'Rule "' . $name . '" not found';

        throw new \Exception($error);
    }
}
