<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Required implements RuleInterface
{
    /**
     * @var boolean
     */
    protected $strict;

    /**
     * Returns the name of the rule.
     *
     * @return string
     */
    public static function getName()
    {
        return 'required';
    }

    /**
     * @param boolean $strict
     */
    public function __construct($strict = false)
    {
        $this->strict = $strict;
    }

    /**
     * Returns the error message template.
     *
     * @return string
     */
    public function getError()
    {
        return 'is required';
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
        if ($this->strict)
        {
            return ! is_null($value);
        }

        return ! is_null($value) && (is_string($value) ? trim($value) !== '' : true);
    }
}
