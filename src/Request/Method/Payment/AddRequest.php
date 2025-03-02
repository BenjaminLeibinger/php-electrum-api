<?php

namespace Electrum\Request\Method\Payment;

use Electrum\Request\AbstractMethod;
use Electrum\Request\MethodInterface;
use Electrum\Response\Model\Payment\PaymentRequest as PaymentRequestResponse;
use Electrum\Response\Model\Payment\PaymentRequest;

/**
 * Create a payment request.
 * @author Pascal Krason <p.krason@padr.io>
 */
class AddRequest extends AbstractMethod implements MethodInterface
{

    /**
     * @var string
     */
    private $method = 'add_request';

    /**
     * Bitcoin amount to request
     * @var float
     */
    private $amount = 0;

    /**
     * Description of the request
     */
    private $memo;

    /**
     * Time in seconds
     */
    private $expiration;

    /**
     * Force wallet creation, even if limit is exceeded
     * @var bool
     */
    private $force = false;

    /**
     * @return string
     */
    #[\Override]
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @return AddRequest
     */
    #[\Override]
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     *
     * @return AddRequest
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    public function getMemo()
    {
        return $this->memo;
    }

    /**
     * @return AddRequest
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;

        return $this;
    }

    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @return AddRequest
     */
    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;

        return $this;
    }

    /**
     * @return bool
     */
    public function isForced()
    {
        return $this->force;
    }

    /**
     * @param bool $force
     *
     * @return AddRequest
     */
    public function setForced($force)
    {
        $this->force = $force;

        return $this;
    }

    /**
     *
     * @return PaymentRequestResponse|null
     * @throws \Electrum\Request\Exception\BadRequestException
     * @throws \Electrum\Response\Exception\ElectrumResponseException
     */
    public function execute(array $optional = [])
    {
        $params = [
            'amount' => $this->getAmount(),
            'force' => $this->isForced(),
        ];

        if($this->getMemo() !== null) {
            $params['memo'] = $this->getMemo();
        }

        if($this->getExpiration()) {
            $params['expiration'] = $this->getExpiration();
        }

        $data = $this->getClient()->execute($this->method, array_merge($optional, $params));

        // Just return null when no unused addresses are available
        if($data === false) {
            return null;
        }

        return PaymentRequest::createFromArray($data);
    }
}