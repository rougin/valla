<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class IsInstance implements RuleInterface
{
    /**
     * @var string
     */
    protected $class;

    /**
     * Returns the name of the rule.
     *
     * @return string
     */
    public static function getName()
    {
        return 'instanceOf';
    }

    /**
     * @param object|string $class
     */
    public function __construct($class)
    {
        $this->class = is_object($class) ? get_class($class) : $class;
    }

    /**
     * Returns the error message template.
     *
     * @return string
     */
    public function getError()
    {
        return sprintf('must be an instance of \'%s\'', $this->class);
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
        if (! is_object($value))
        {
            return false;
        }

        return $value instanceof $this->class;
    }
}
