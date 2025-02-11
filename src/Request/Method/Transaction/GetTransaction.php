<?php


namespace Electrum\Request\Method\Transaction;


use Electrum\Request\AbstractMethod;
use Electrum\Request\MethodInterface;

/**
 * Return all loaded wallets
 * @original_author Pascal Krason <p.krason@padr.io>
 */
class GetTransaction extends AbstractMethod implements MethodInterface
{

    private string $txId;

    /**
     * @var string
     */
    private $method = 'gettransaction';

    public function getTxId(): string
    {
        return $this->txId;
    }

    public function setTxId(string $txId): void
    {
        $this->txId = $txId;
    }

    /**
     * @return object
     * @throws \Electrum\Request\Exception\BadRequestException
     * @throws \Electrum\Response\Exception\ElectrumResponseException
     */
    public function execute(array $optional = [])
    {
        $data = $this->getClient()->execute($this->method, array_merge($optional, [
            'txid' => $this->getTxId(),
        ]));

        return $data;
    }
}