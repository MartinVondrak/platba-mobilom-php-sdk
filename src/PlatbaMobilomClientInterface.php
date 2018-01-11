<?php

namespace MartinVondrak\PlatbaMobilom;

use MartinVondrak\PlatbaMobilom\Exception\InvalidSignatureException;
use MartinVondrak\PlatbaMobilom\Http\Request;
use MartinVondrak\PlatbaMobilom\Http\Response;

interface PlatbaMobilomClientInterface
{
    /**
     * PlatbaMobilomClientInterface constructor
     *
     * @param string $pwd secret key
     */
    public function __construct(string $pwd);

    /**
     * Prepare data and generate URL for redirect to gateway
     *
     * @param Request $request data for payment request
     * @param bool    $debug flag whether test gateway should be used
     * @return string gateway URL with parameters
     */
    public function getGatewayUrl(Request $request, bool $debug = false): string;

    /**
     * Verifies response signature and checks status
     *
     * @param Response $response
     * @return bool true if payment was successful false otherwise
     * @throws InvalidSignatureException if signature of response is not valid
     */
    public function checkResponse(Response $response): bool;
}
