<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Email implements RuleInterface
{
    /**
     * Returns the name of the rule.
     *
     * @return string
     */
    public static function getName()
    {
        return 'email';
    }

    /**
     * Returns the error message template.
     *
     * @return string
     */
    public function getError()
    {
        return 'is not a valid email address';
    }

    /**
     * Checks if the specified value passes the rule.
     *
     * @param mixed                $value
     * @param array<string, mixed> $data
     *
     * @return boolean
     */
    public function passed($value, $data)
    {
        if (! is_string($value))
        {
            return false;
        }

        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}
