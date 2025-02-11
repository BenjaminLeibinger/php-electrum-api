<?php


namespace Electrum\Request\Method\Transaction;


use Electrum\Request\AbstractMethod;
use Electrum\Request\MethodInterface;


class GetTransactionStatus extends AbstractMethod implements MethodInterface
{

    private string $txId;

    /**
     * @var string
     */
    private $method = 'get_tx_status';

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
    public function execute(array $optional = []): int
    {
        $data = $this->getClient()->execute($this->method, array_merge($optional, [
            'txid' => $this->getTxId(),
        ]));

        if (isset($data['confirmations'])) {
            return $data['confirmations'];
        }

        return 0;
    }
}