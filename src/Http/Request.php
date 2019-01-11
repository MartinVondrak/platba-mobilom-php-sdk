<?php
/*
 * PlatbaMobilom.sk PHP SDK
 *
 * This file is part of PlatbaMobilom.sk PHP SDK.
 * See LICENSE file for full license details.
 *
 * (c) 2019 Martin Vondrák
 */

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
     * Request constructor.
     *
     * @param string $id
     * @param string $description
     * @param float  $price
     */
    public function __construct(string $id, string $description, float $price)
    {
        $this->id = $id;
        $this->description = static::sanitizeDescription($description);
        $this->price = $price;
    }

    /**
     * Get id.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Get price.
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Sanitizes description according to rules of gateway.
     *
     * @param string $description
     * @return string
     */
    private static function sanitizeDescription(string $description): string
    {
        $allowedChars = array_merge(
            range('0', '9'),
            range('a', 'z'),
            range('A', 'Z'),
            ['-', ' ', '.']
        );

        $description = mb_substr($description, 0, 30);
        $chars = preg_split('//u', $description, null, PREG_SPLIT_NO_EMPTY);
        $newChars = [];

        foreach ($chars as $char) {
            if (!in_array($char, $allowedChars, true)) {
                $newChars[] = '-';
            } else {
                $newChars[] = $char;
            }
        }

        return implode($newChars);
    }
}
