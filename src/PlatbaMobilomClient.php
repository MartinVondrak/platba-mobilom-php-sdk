<?php

namespace MartinVondrak\PlatbaMobilom;

use MartinVondrak\PlatbaMobilom\Exception\InvalidSignatureException;
use MartinVondrak\PlatbaMobilom\Http\Request;
use MartinVondrak\PlatbaMobilom\Http\Response;

class PlatbaMobilomClient implements PlatbaMobilomClientInterface
{
    const GATEWAY = 'https://pay.platbamobilom.sk/pay/';
    const TEST_GATEWAY = 'https://pay.platbamobilom.sk/test/';

    /** @var string $pwd secure key */
    private $pwd;


    /**
     * @inheritdoc
     */
    public function __construct(string $pwd)
    {
        $this->pwd = $pwd;
    }

    /**
     * @inheritdoc
     */
    public function getGatewayUrl(Request $request, bool $debug = false): string
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
            'SIGN' => $request->calculateSign($this->pwd)
        ]);

        return sprintf('%s?%s', $host, $queryString);
    }

    /**
     * @inheritdoc
     */
    public function checkResponse(Response $response)
    {
        if (!$response->verifySignature($this->pwd)) {
            throw new InvalidSignatureException();
        }

        return $response->isSuccessful();
    }
}
