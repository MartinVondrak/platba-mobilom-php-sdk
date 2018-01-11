<?php

namespace MartinVondrak\PlatbaMobilom\Http;

/**
 * Class Request holds data for payment,
 * that are required by gateway.
 */
class Request
{
    /** @var int $pid merchant ID */
    private $pid;

    /** @var string unique ID of payment */
    private $id;

    /** @var string $description description of payment shown on the gateway */
    private $description;

    /** @var float $price amount to pay */
    private $price;

    /** @var string $url redirect to this URL after payment */
    private $url;

    /** @var string $email send notification to this email after payment */
    private $email;

    /**
     * Request constructor
     *
     * @param int    $pid
     * @param string $id
     * @param string $description
     * @param float  $price
     * @param string $url
     * @param string $email
     */
    public function __construct(int $pid, string $id, string $description, float $price, string $url, string $email)
    {
        $this->pid = $pid;
        $this->id = $id;
        $this->description = $description;
        $this->price = $price;
        $this->url = $url;
        $this->email = $email;
    }

    /**
     * Get pid
     *
     * @return int
     */
    public function getPid(): int
    {
        return $this->pid;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Calculate signature of a request
     *
     * @param string $pwd secure key
     * @return string
     */
    public function calculateSign(string $pwd): string
    {
        $message = $this->pid . $this->id . $this->description . $this->price . $this->url . $this->email;
        $sign = strtoupper(hash_hmac('sha256', $message, $pwd, false));
        return $sign;
    }
}
