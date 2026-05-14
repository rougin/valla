<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class UrlTest extends Testcase
{
    public function test_failed_if_url_invalid()
    {
        $data = array('link' => 'not-a-url');
        $valid = $this->resolveRule($data, 'link', 'url');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_url_valid()
    {
        $data = array('link' => 'https://example.com');
        $valid = $this->resolveRule($data, 'link', 'url');
        $this->assertTrue($valid->passed());
    }

    public function test_failed_if_url_non_string()
    {
        $data = array('link' => 123);
        $valid = $this->resolveRule($data, 'link', 'url');
        $this->assertFalse($valid->passed());
    }
}
