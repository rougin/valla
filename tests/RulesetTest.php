<?php

namespace Rougin\Valla;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class RulesetTest extends Testcase
{
    /**
     * @return void
     */
    public function test_failed_if_rule_not_found()
    {
        $this->doExpectException('Exception');

        $ruleset = new Ruleset;

        $ruleset->resolve('nonexistent');
    }
}
