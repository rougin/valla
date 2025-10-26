<?php

namespace Rougin\Valla;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Request extends Check
{
    /**
     * @var array<string, string>
     */
    protected $aliases = array();

    /**
     * Returns the defined aliases.
     *
     * @return array<string, string>
     */
    public function aliases()
    {
        return $this->aliases;
    }

    /**
     * Checks if the data from getQueryParams() is valid.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return boolean
     */
    public function isParamsValid(ServerRequestInterface $request)
    {
        /** @var array<string, string> */
        $data = $request->getQueryParams();

        return $this->valid($this->setAlias($data));
    }

    /**
     * Checks if the data from getParsedBody() is valid.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return boolean
     */
    public function isParsedValid(ServerRequestInterface $request)
    {
        /** @var array<string, mixed> */
        $data = $request->getParsedBody();

        return $this->valid($this->setAlias($data));
    }

    /**
     * Sets the alias for the payload.
     *
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    protected function setAlias($data)
    {
        $aliases = $this->aliases();

        $items = array();

        foreach ($data as $key => $value)
        {
            $exists = array_key_exists($key, $aliases);

            if (! $exists)
            {
                $items[$key] = $value;

                continue;
            }

            $alias = $aliases[$key];

            $items[$alias] = $value;
        }

        return $items;
    }
}
