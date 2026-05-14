<?php

namespace Rougin\Valla;

use LegacyPHPUnit\TestCase as Legacy;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Testcase extends Legacy
{
    /**
     * Resolves a rule string and adds it to a Valid instance.
     *
     * @param array<string, mixed> $data
     * @param string               $field
     * @param string               $text
     *
     * @return \Rougin\Valla\Valid
     */
    protected function resolveRule($data, $field, $text)
    {
        $ruleset = new Ruleset;

        $valid = new Valid($data);

        $rules = $ruleset->resolve($text);

        foreach ($rules as $rule)
        {
            $valid->addRule($rule, $field);
        }

        return $valid;
    }

    /**
     * @param class-string $exception
     *
     * @return void
     */
    public function doExpectException($exception)
    {
        /** @phpstan-ignore-next-line */
        if (method_exists($this, 'expectException'))
        {
            /** @phpstan-ignore-next-line */
            $this->expectException($exception);

            return;
        }

        /** @phpstan-ignore-next-line */
        $this->setExpectedException($exception);
    }
}
