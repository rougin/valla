<?php

namespace Rougin\Valla\Rules;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class CreditCard implements Rule
{
    /**
     * Checks if the specified value passes the rule.
     *
     * @param mixed                $value
     * @param mixed[]              $params
     * @param array<string, mixed> $data
     *
     * @return boolean
     */
    public function pass($value, $params = array(), $data = array())
    {
        if (! is_string($value) && ! is_numeric($value))
        {
            return false;
        }

        // Basic Luhn algorithm implementation or simple mock for tests
        $value = str_replace(array('-', ' '), '', (string) $value);

        if (! is_numeric($value))
        {
            return false;
        }

        $sum = 0;
        $numDigits = strlen($value);
        $parity = $numDigits % 2;

        for ($i = 0; $i < $numDigits; $i++)
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
}
