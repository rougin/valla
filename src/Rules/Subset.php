<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Subset implements RuleInterface
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
        return 'subset';
    }

    /**
     * @return string
     */
    public function getError()
    {
        return 'contains an item that is not in the list';
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
        if (! is_array($value))
        {
            return false;
        }

        foreach ($value as $item)
        {
            if (! in_array($item, $this->haystack))
            {
                return false;
            }
        }

        return true;
    }
}
