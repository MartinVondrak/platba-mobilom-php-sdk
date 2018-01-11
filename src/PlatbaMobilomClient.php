<?php

namespace MartinVondrak\PlatbaMobilom;

use MartinVondrak\PlatbaMobilom\Http\Request;

class PlatbaMobilomClient implements PlatbaMobilomClientInterface
{
    const GATEWAY = 'https://pay.platbamobilom.sk/pay/';
    const TEST_GATEWAY = 'https://pay.platbamobilom.sk/test/';

    /**
     * @inheritdoc
     */
    public function getGatewayUrl(Request $request, string $pwd, bool $debug = false): string
    {
        if ($debug) {
            $host = static::TEST_GATEWAY;
        } else {
            $host = static::GATEWAY;
        }

        $queryString = http_build_query([
            'PID' => $request->getPid(),
            'ID' => $request->getId(),
            'DESC' => $request->getDescription(),
            'PRICE' => $request->getPrice(),
            'URL' => $request->getUrl(),
            'EMAIL' => $request->getEmail(),
            'SIGN' => $request->calculateSign($pwd)
        ]);

        return sprintf('%s?%s', $host, $queryString);
    }
}
