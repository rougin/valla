<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class LengthMax implements RuleInterface
{
    /**
     * @var integer
     */
    protected $max;

    /**
     * @param integer $max
     */
    public function __construct($max)
    {
        $this->max = (int) $max;
    }

    /**
     * @return string
     */
    public static function getName()
    {
        return 'lengthMax';
    }

    /**
     * @return string
     */
    public function getError()
    {
        return sprintf('must not exceed %d characters', $this->max);
    }

    /**
     * Checks if the specified value passes the rule.
     *
     * @param mixed                $value
     * @param array<string, mixed> $data
     *
     * @return boolean
     */
    public function pass($value, $data = array())
    {
        if (! is_string($value))
        {
            return false;
        }

        return strlen($value) <= $this->max;
    }
}
