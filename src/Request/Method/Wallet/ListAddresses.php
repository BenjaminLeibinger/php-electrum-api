<?php


namespace Electrum\Request\Method\Wallet;


use Electrum\Request\AbstractMethod;
use Electrum\Request\MethodInterface;

/**
 * Return all loaded wallets
 * @original_author Pascal Krason <p.krason@padr.io>
 */
class ListAddresses extends AbstractMethod implements MethodInterface
{

    /**
     * @var string
     */
    private $method = 'listaddresses';

    /**
     * @return object
     * @throws \Electrum\Request\Exception\BadRequestException
     * @throws \Electrum\Response\Exception\ElectrumResponseException
     */
    public function execute(array $optional = [])
    {
        return $this->getClient()->execute($this->method, $optional);
    }
}