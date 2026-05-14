<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class SlugTest extends Testcase
{
    public function test_failed_if_slug_invalid()
    {
        $data = array('slug' => 'not a slug!');
        $valid = $this->resolveRule($data, 'slug', 'slug');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_slug_valid()
    {
        $data = array('slug' => 'my-slug_123');
        $valid = $this->resolveRule($data, 'slug', 'slug');
        $this->assertTrue($valid->passed());
    }

    public function test_failed_if_slug_is_array()
    {
        $data = array('slug' => array('a'));
        $valid = $this->resolveRule($data, 'slug', 'slug');
        $this->assertFalse($valid->passed());
    }
}
