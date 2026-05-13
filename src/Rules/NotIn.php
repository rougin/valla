<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class NotIn implements RuleInterface
{
    /**
     * @var mixed[]
     */
    protected $haystack;

    /**
     * Returns the name of the rule.
     *
     * @return string
     */
    public static function getName()
    {
        return 'notIn';
    }

    /**
     * @param mixed[] $haystack
     */
    public function __construct(array $haystack)
    {
        $this->haystack = $haystack;
    }

    /**
     * Returns the error message template.
     *
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
    public function passed($value, $data)
    {
        return ! in_array($value, $this->haystack);
    }
}
