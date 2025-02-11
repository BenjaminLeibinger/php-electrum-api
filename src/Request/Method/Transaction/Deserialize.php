<?php


namespace Electrum\Request\Method\Transaction;


use Electrum\Request\AbstractMethod;
use Electrum\Request\MethodInterface;

/**
 * Return all loaded wallets
 * @original_author Pascal Krason <p.krason@padr.io>
 */
class Deserialize extends AbstractMethod implements MethodInterface
{

    private string $tx;

    /**
     * @var string
     */
    private $method = 'deserialize';

    public function getTx(): string
    {
        return $this->tx;
    }

    public function setTx(string $tx): void
    {
        $this->tx = $tx;
    }



    /**
     * @return object
     * @throws \Electrum\Request\Exception\BadRequestException
     * @throws \Electrum\Response\Exception\ElectrumResponseException
     */
    public function execute(array $optional = [])
    {
        $data = $this->getClient()->execute($this->method, array_merge($optional, [
            'tx' => $this->getTx(),
        ]));

        return $data;
    }
}