<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class RequiredWith implements RuleInterface
{
    /**
     * @var string[]
     */
    protected $fields;

    /**
     * @var boolean
     */
    protected $strict;

    /**
     * @param string[] $fields
     * @param boolean  $strict
     */
    public function __construct(array $fields, $strict = false)
    {
        $this->fields = $fields;

        $this->strict = $strict;
    }

    /**
     * @return string
     */
    public static function getName()
    {
        return 'requiredWith';
    }

    /**
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
    public function pass($value, $data = array())
    {
        $required = false;

        foreach ($this->fields as $item)
        {
            if (isset($data[(string) $item]) && ! empty($data[(string) $item]))
            {
                $required = true;

                break;
            }
        }

        if ($required)
        {
            $rule = new Required($this->strict);

            return $rule->pass($value, $data);
        }

        return true;
    }
}
