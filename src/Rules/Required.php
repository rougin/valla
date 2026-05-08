<?php

namespace Rougin\Valla\Rules;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Required implements Rule
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
        // Handled by RequiredWith/NotRequired if field is specified ---
        if (isset($params[1]) && is_scalar($params[1]))
        {
            return isset($data[(string) $params[1]]);
        }
        // -----------------------------------------------------------------

        if (isset($params[0]) && $params[0] === true)
        {
            // NOTE: This part is a bit tricky because we don't know the field name here.
            // However, the original validateRequired had $field, and checked $this->_data[$field].
            // If params[0] is true (strict), it means it must be present in data.
            // But 'pass' only gets $value (which is null if not present).
            // For now, let's assume if it's null, it's not present.
            return ! is_null($value);
        }

        return ! is_null($value) && (is_string($value) ? trim($value) !== '' : true);
    }
}
