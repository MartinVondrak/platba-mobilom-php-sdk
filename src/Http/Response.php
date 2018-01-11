<?php

namespace MartinVondrak\PlatbaMobilom\Http;

/**
 * Class Response holds data sent by gateway
 * after payment.
 */
class Response
{
    const OK = 'OK';
    const FAIL = 'FAIL';
    const TIMEOUT = 'TIMEOUT';

    /** @var string $id unique ID of a payment */
    private $id;

    /** @var string $result status of a payment */
    private $result;

    /** @var int $phone phone number used for payment */
    private $phone;

    /** @var string $sign signature of received data */
    private $sign;


    /**
     * Response constructor
     *
     * @param string   $id
     * @param string   $result
     * @param string   $sign
     * @param int|null $phone
     */
    public function __construct(string $id, string $result, string $sign, int $phone = null)
    {
        $this->id = $id;
        $this->result = $result;
        $this->phone = $phone;
        $this->sign = $sign;
    }

    /**
     * Get result
     *
     * @return string
     */
    public function getResult(): string
    {
        return $this->result;
    }

    /**
     * Check whether payment was successful
     *
     * @return bool true if successful false otherwise
     */
    public function isSuccessful(): bool
    {
        return $this->result == self::OK;
    }

    /**
     * Verify data signature
     *
     * @param string $pwd secure key
     * @return bool true if signature is valid false otherwise
     */
    public function verifySignature($pwd): bool
    {
        $message = $this->id . $this->result . $this->phone;
        $sign = strtoupper(hash_hmac('sha256', $message, $pwd, false));
        return $this->sign == $sign;
    }
}
