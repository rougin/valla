<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class UrlActiveTest extends Testcase
{
    public function test_failed_if_urlactive_invalid()
    {
        $data = array('link' => 'not-a-url');
        $valid = $this->resolveRule($data, 'link', 'urlActive');
        $this->assertFalse($valid->passed());
    }

    public function test_failed_if_urlactive_non_string()
    {
        $data = array('link' => 123);
        $valid = $this->resolveRule($data, 'link', 'urlActive');
        $this->assertFalse($valid->passed());
    }

    public function test_failed_if_urlactive_no_dns()
    {
        $data = array('link' => 'http://nonexistent-domain.invalid');
        $valid = $this->resolveRule($data, 'link', 'urlActive');
        $this->assertFalse($valid->passed());
    }
}
