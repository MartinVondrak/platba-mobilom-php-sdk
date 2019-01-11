<?php
/*
 * PlatbaMobilom.sk PHP SDK
 *
 * This file is part of PlatbaMobilom.sk PHP SDK.
 * See LICENSE file for full license details.
 *
 * (c) 2019 Martin Vondrák
 */

namespace MartinVondrak\PlatbaMobilom;

use MartinVondrak\PlatbaMobilom\Exception\InvalidSignatureException;
use MartinVondrak\PlatbaMobilom\Http\Request;
use MartinVondrak\PlatbaMobilom\Http\Response;

interface PlatbaMobilomClientInterface
{
    /**
     * PlatbaMobilomClientInterface constructor.
     *
     * @param int    $pid   merchant ID
     * @param string $url   merchant URL
     * @param string $pwd   secret key
     * @param string $email merchant e-mail
     * @param bool   $debug flag whether test gateway should be used
     */
    public function __construct(int $pid, string $url, string $pwd, string $email = null, bool $debug = false);

    /**
     * Prepare data and generate URL for redirect to gateway.
     *
     * @param Request $request data for payment request
     *
     * @return string gateway URL with parameters
     */
    public function getGatewayUrl(Request $request): string;

    /**
     * Verifies response signature and checks status.
     *
     * @param Response $response
     *
     * @throws InvalidSignatureException if signature of response is not valid
     *
     * @return bool true if payment was successful false otherwise
     */
    public function checkResponse(Response $response): bool;
}
