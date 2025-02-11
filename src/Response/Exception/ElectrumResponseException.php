<?php

namespace Electrum\Response\Exception;

use Exception;
use Throwable;

/**
 * @author Pascal Krason <p.krason@padr.io>
 * @deprecated Use \Electrum\Response\Exception\BadResponseException instead
 */
class ElectrumResponseException extends Exception
{
    /**
     * Extract electrum error from response
     *
     *
     * @return ElectrumResponseException
     */
    public static function createFromElectrumResponse(array $response)
    {
        $message = '';
        $code = 0;

        if (isset($response['error'])) {
            $text = '';
            if(is_string($response['error'])) {
                $text = $response['error'];
            } elseif (is_array($response['error']) && isset($response['error']['message']) && is_string($response['error']['message'])) {
                $text = $response['error']['message'];
            }

            $message = 'Electrum API returned error: ' . $text;
        }

        if (isset($response['error']['code'])) {
            $code = $response['error']['code'];
        }

        return new self($message, $code);
    }
}
