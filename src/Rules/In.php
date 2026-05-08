<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class In implements RuleInterface
{
    /**
     * @var mixed[]
     */
    protected $haystack;

    /**
     * @param mixed[] $haystack
     */
    public function __construct(array $haystack)
    {
        $this->haystack = $haystack;
    }

    /**
     * @return string
     */
    public static function getName()
    {
        return 'in';
    }

    /**
     * @return string
     */
    public function getError()
    {
        return 'contains invalid value';
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
        return in_array($value, $this->haystack);
    }
}
