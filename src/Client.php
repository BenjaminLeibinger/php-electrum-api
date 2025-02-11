<?php

namespace Electrum;

use Electrum\Request\Exception\BadRequestException;
use Electrum\Response\Exception\ElectrumResponseException;

/**
 * @author Pascal Krason <p.krason@padar.io>
 */
class Client
{
    /**
     * JSONRPC Host
     */
    private $host = '';

    /**
     * JSONRPC Port
     */
    private int $port = 0;

    /**
     * JSONRPC User Name
     */
    private ?string $rpcUsername = null;

    /**
     * JSONRPC Password
     */
    private ?string $rpcPassword = null;

    /**
     * Last Message-ID
     */
    private int $id = 0;


    public function __construct(
        string $host = 'http://127.0.0.1',
        int $port = 7777,
        int $id = 0,
        ?string $rpcUsername = null,
        ?string $rpcPassword = null
    ) {
        $this->setHost($host);
        $this->setPort($port);
        $this->setId($id);
        $this->setRpcUsername($rpcUsername);
        $this->setRpcPassword($rpcPassword);
    }

    /**
     * Execute JSONRPC Request
     *
     * @param       $method
     * @param array $params
     *
     * @return mixed
     * @throws BadRequestException
     * @throws ElectrumResponseException
     */
    public function execute($method, $params = [])
    {
        // Create request payload
        $request = $this->createRequest($method, $params);

        // Retrieve electrum api response
        $response = $this->executeCurlRequest($request);

        // Check if an error occured
        if(isset($response['error'])) {

            // ### Set message
            throw ElectrumResponseException::createFromElectrumResponse($response);
        }

        return $response['result'];
    }

    /**
     * Create request payload
     *
     * @param       $method
     *
     * @return mixed
     */
    private function createRequest($method, array $params)
    {
        // Build request string
        $request = json_encode([
            'method' => $method,
            'params' => $params,
            'id'     => $this->getNextId(),
        ]);

        // Replace braces
        return str_replace(['[{', '}]'], ['{', '}'], $request);
    }

    /**
     * Create curl instance & execute the request
     * @param $request
     *
     * @return mixed
     * @throws BadRequestException
     */
    private function executeCurlRequest($request)
    {
        // Create CURL instance
        $curl = curl_init(vsprintf(
            '%s:%s', [$this->getHost(), $this->getPort()]
        ));

        // Set some options we need
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $request,
        ]);

        // Authorization
        if ($this->getRpcUsername() && $this->getRpcPassword()) {
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, $this->getRpcUsername() . ":" . $this->getRpcPassword());
        }

        // Execute request & convert data to array
        $response = curl_exec($curl);

        // Catch error if occured
        $error = curl_error($curl);

        // Check if request was successfull
        if ($error !== '' && $error !== '0') {

            // Set last error, so user can catch it
            throw new BadRequestException($error);
        }

        // Return Data converted to an array
        return json_decode($response, true);
    }


    public function getHost(): string
    {
        return $this->host;
    }

    public function setHost(string $host): self
    {
        $this->host = $host;

        return $this;
    }


    public function getPort(): int
    {
        return $this->port;
    }


    public function setPort(int $port): self
    {
        $this->port = $port;

        return $this;
    }

    public function getRpcUsername(): ?string
    {
        return $this->rpcUsername;
    }


    public function setRpcUsername(?string $rpcUsername): self
    {
        $this->rpcUsername = $rpcUsername;

        return $this;
    }

    public function getRpcPassword(): ?string
    {
        return $this->rpcPassword;
    }

    public function setRpcPassword(?string $rpcPassword): self
    {
        $this->rpcPassword = $rpcPassword;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNextId(): int
    {
        return $this->id++;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}
