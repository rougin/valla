<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class LengthMin implements RuleInterface
{
    /**
     * @var integer
     */
    protected $min;

    /**
     * @param integer $min
     */
    public function __construct($min)
    {
        $this->min = (int) $min;
    }

    /**
     * @return string
     */
    public static function getName()
    {
        return 'lengthMin';
    }

    /**
     * @return string
     */
    public function getError()
    {
        return sprintf('must be at least %d characters long', $this->min);
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

        return strlen($value) >= $this->min;
    }
}
