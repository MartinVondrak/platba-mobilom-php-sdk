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
    public function getGatewayUrl(Request $request, bool $debug = false);

    /**
     * @param Response $response
     * @return mixed
     * @throws InvalidSignatureException
     */
    public function checkResponse(Response $response);
}
