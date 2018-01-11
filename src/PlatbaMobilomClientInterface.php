<?php

namespace MartinVondrak\PlatbaMobilom;

use MartinVondrak\PlatbaMobilom\Http\Request;

interface PlatbaMobilomClientInterface
{
    /**
     * Prepare data and generate URL for redirect to gateway
     *
     * @param Request $request data for payment request
     * @param string  $pwd secure key
     * @param bool    $debug flag whether test gateway should be used
     * @return string gateway URL with parameters
     */
    public function getGatewayUrl(Request $request, string $pwd, bool $debug = false);
}
