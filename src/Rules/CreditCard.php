<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class CreditCard implements RuleInterface
{
    /**
     * Returns the error message template.
     *
     * @return string
     */
    public function getError()
    {
        return 'must be a valid credit card number';
    }

    /**
     * Returns the name of the rule.
     *
     * @return string
     */
    public function getName()
    {
        return 'creditCard';
    }

    /**
     * Checks if the specified value passes the rule.
     *
     * @param mixed                $value
     * @param array<string, mixed> $data
     *
     * @return boolean
     */
    public function passed($value, array $data)
    {
        if (! is_string($value) && ! is_numeric($value))
        {
            return false;
        }

        $value = str_replace(array('-', ' '), '', (string) $value);

        if (! is_numeric($value))
        {
            return false;
        }

        $sum = 0;

        $length = strlen($value);

        $parity = $length % 2;

        for ($i = 0; $i < $length; $i++)
        {
            $digit = (int) $value[$i];

            if ($i % 2 == $parity)
            {
                $digit *= 2;

                if ($digit > 9)
                {
                    $digit -= 9;
                }
            }

            $sum += $digit;
        }

        return $sum % 10 == 0;
    }

    /**
     * Sets the parameter values for the rule.
     *
     * @param string[] $values
     *
     * @return self
     */
    public function setValue(array $values)
    {
        return $this;
    }
}
