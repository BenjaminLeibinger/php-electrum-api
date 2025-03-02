<?php

namespace Electrum\Request;

use Electrum\Client;
use Electrum\Response\ResponseInterface;
use Laminas\Hydrator\ReflectionHydrator;

/**
 * @author Pascal Krason <p.krason@padr.io>
 */
abstract class AbstractMethod
{

    /**
     * @var string
     */
    private $method = '';

    /**
     * @var array
     */
    private $params = [];

    /**
     * @var Client
     */
    private $client;


    public function __construct(?Client $client = null)
    {
        if($client instanceof Client) {
            $this->setClient($client);
        } else {
            $this->setClient(new Client());
        }
    }

    /**
     * Hydrate returned api data into our custom response models
     *
     * @param array|bool              $data
     * @param ReflectionHydrator|null $hydrator
     * @return ResponseInterface
     */
    public function hydrate(ResponseInterface $object, $data, $hydrator = null)
    {
        if(!$hydrator instanceof ReflectionHydrator) {
            $hydrator = new ReflectionHydrator();
        }

        if (!is_array($data)) {
            return $data;
        }

        return $hydrator->hydrate(
            $data,
            $object
        );
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     *
     * @return AbstractMethod
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

}