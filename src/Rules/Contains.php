<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Contains implements RuleInterface
{
    /**
     * @var string
     */
    protected $needle;

    /**
     * @return string
     */
    public static function getName()
    {
        return 'contains';
    }

    /**
     * @param string $needle
     */
    public function __construct($needle)
    {
        $this->needle = $needle;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return sprintf('must contain %s', $this->needle);
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

        return strpos($value, $this->needle) !== false;
    }
}
