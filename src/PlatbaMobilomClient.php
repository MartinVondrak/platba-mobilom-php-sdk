<?php

namespace MartinVondrak\PlatbaMobilom;

use MartinVondrak\PlatbaMobilom\Exception\InvalidSignatureException;
use MartinVondrak\PlatbaMobilom\Http\Request;
use MartinVondrak\PlatbaMobilom\Http\Response;

class PlatbaMobilomClient implements PlatbaMobilomClientInterface
{
    const GATEWAY = 'https://pay.platbamobilom.sk/pay/';
    const TEST_GATEWAY = 'https://pay.platbamobilom.sk/test/';

    /** @var string $gatewayUrl redirect to this URL for payment */
    private $gatewayUrl;

    /** @var int $pid merchant ID */
    private $pid;

    /** @var string $url redirect to this URL after payment */
    private $merchantUrl;

    /** @var string $email send notification to this email after payment */
    private $email;

    /** @var string $pwd secure key */
    private $pwd;


    /**
     * @inheritdoc
     */
    public function __construct(int $pid, string $url, string $pwd, string $email = null, bool $debug = false)
    {
        if ($debug) {
            $this->gatewayUrl = static::TEST_GATEWAY;
        } else {
            $this->gatewayUrl = static::GATEWAY;
        }

        $this->pid = $pid;
        $this->merchantUrl = $url;
        $this->email = $email;
        $this->pwd = $pwd;
    }

    /**
     * @inheritdoc
     */
    public function getGatewayUrl(Request $request): string
    {
        $queryString = http_build_query([
            'PID' => $this->pid,
            'ID' => $request->getId(),
            'DESC' => $request->getDescription(),
            'PRICE' => $request->getPrice(),
            'URL' => $this->merchantUrl,
            'EMAIL' => $this->email,
            'SIGN' => $this->calculateRequestSignature($request)
        ]);

        return sprintf('%s?%s', $this->gatewayUrl, $queryString);
    }

    /**
     * @inheritdoc
     */
    public function checkResponse(Response $response): bool
    {
        if (!$response->verifySignature($this->pwd)) {
            throw new InvalidSignatureException();
        }

        return $response->isSuccessful();
    }

    /**
     * Calculates signature for request data
     *
     * @param Request $request
     * @return string
     */
    private function calculateRequestSignature(Request $request)
    {
        $message = $this->pid . $request->getId() . $request->getDescription() . $request->getPrice() . $this->merchantUrl . $this->email;
        $sign = strtoupper(hash_hmac('sha256', $message, $this->pwd, false));
        return $sign;
    }
}
