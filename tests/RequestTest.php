<?php

namespace Rougin\Valla;

use Rougin\Valla\Fixture\RequestCheck;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class RequestTest extends Testcase
{
    /**
     * @return void
     */
    public function test_aliases()
    {
        // Arrange
        $data = array('name' => 'John Doe');

        $data['email_add'] = 'johndoe@gmail.com';

        $http = $this->newHttp($data, true);

        // Act
        $check = new RequestCheck;

        $actual = $check->isParsedValid($http);

        // Assert
        $this->assertTrue($actual);
    }

    /**
     * @return void
     */
    public function test_parsed_body()
    {
        // Arrange
        $data = array('name' => 'John Doe');

        $data['email'] = 'johndoe@gmail.com';

        $http = $this->newHttp($data, true);

        // Act
        $check = new RequestCheck;

        $actual = $check->isParsedValid($http);

        // Assert
        $this->assertTrue($actual);
    }

    /**
     * @return void
     */
    public function test_query_params()
    {
        // Arrange
        $data = array('name' => 'John Doe');

        $data['email'] = 'johndoe@gmail.com';

        $http = $this->newHttp($data);

        // Act
        $check = new RequestCheck;

        $actual = $check->isParamsValid($http);

        // Assert
        $this->assertTrue($actual);
    }

    /**
     * @param array<string, mixed> $data
     * @param boolean              $parsed
     *
     * @return \Psr\Http\Message\ServerRequestInterface
     */
    protected function newHttp($data, $parsed = false)
    {
        $class = 'Psr\Http\Message\ServerRequestInterface';

        $http = $this->createMock($class);

        $method = $parsed ? 'getParsedBody' : 'getQueryParams';

        $http->method($method)->willReturn($data);

        /** @var \Psr\Http\Message\ServerRequestInterface */
        return $http;
    }
}
