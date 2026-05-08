<?php

namespace Rougin\Valla\Rules;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class NotRequired implements Rule
{
    /**
     * Checks if the specified value passes the rule.
     *
     * @param mixed                $value
     * @param mixed[]              $params
     * @param array<string, mixed> $data
     *
     * @return boolean
     */
    public function pass($value, $params = array(), $data = array())
    {
        if (! isset($params[0]))
        {
            return true;
        }

        $required = false;

        foreach ((array) $params[0] as $item)
        {
            if (is_scalar($item) && (! isset($data[(string) $item]) || empty($data[(string) $item])))
            {
                $required = true;

                break;
            }
        }

        if ($required)
        {
            $rule = new Required;

            return $rule->pass($value, array(), $data);
        }

        return true;
    }
}
