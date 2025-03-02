<?php

namespace Electrum\Request\Method\Payment;

use Electrum\Request\AbstractMethod;
use Electrum\Request\MethodInterface;
use Electrum\Response\Exception\ElectrumResponseException;

/**
 * Return a payment request.
 * @author Pascal Krason <p.krason@padr.io>
 */
class PayTo extends AbstractMethod implements MethodInterface
{

    /**
     * @var string
     */
    private $method = 'payto';

    /**
     * @var string
     * '!' for  maximum available
     */
    private $amount = '!';

    /**
     * @var string
     */
    private $destination = '';

    /**
     * @return mixed
     * @throws ElectrumResponseException
     * @throws \Electrum\Request\Exception\BadRequestException
     */
    public function execute(array $optional = [])
    {
        return $this->getClient()->execute($this->method, array_merge([
            'destination' => $this->getDestination(),
            'amount'      => $this->getAmount()
        ], $optional));
    }

    /**
     * Get the value of Amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of Amount
     *
     * @param string amount
     *
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of Destination
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set the value of Destination
     *
     * @param string destination
     *
     * @return self
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

}
