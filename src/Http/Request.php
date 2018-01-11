<?php

namespace MartinVondrak\PlatbaMobilom\Http;

/**
 * Class Request holds data for payment,
 * that are required by gateway.
 */
class Request
{
    /** @var string unique ID of payment */
    private $id;

    /** @var string $description description of payment shown on the gateway */
    private $description;

    /** @var float $price amount to pay */
    private $price;

    /**
     * Request constructor
     *
     * @param string $id
     * @param string $description
     * @param float  $price
     */
    public function __construct(string $id, string $description, float $price)
    {
        $this->id = $id;
        $this->description = $description;
        $this->price = $price;
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
}
