<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class RequiredWithout implements RuleInterface
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
     * Returns the name of the rule.
     *
     * @return string
     */
    public static function getName()
    {
        return 'requiredWithout';
    }

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
        $required = false;

        foreach ($this->fields as $item)
        {
            if (! isset($data[$item]) || empty($data[$item]))
            {
                $required = true;

                break;
            }
        }

        if ($required)
        {
            $rule = new Required($this->strict);

            return $rule->passed($value, $data);
        }

        return true;
    }
}
