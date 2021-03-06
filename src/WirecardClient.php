<?php

namespace WirecardClient;

use WirecardClient\Exceptions\DataNotFoundException;
use WirecardClient\Exceptions\RequestFailedException;
use WirecardClient\Types\Payment;

/**
 * Class WirecardClient
 * @package WirecardClient
 */
class WirecardClient
{
    /**
     * @var string
     */
    protected $eeUser;
    /**
     * @var string
     */
    protected $eePassword;

    protected $MAID;
    protected $secret;

    protected $apiUrl = 'https://api.wirecard.com/';
    protected $wppUrl = 'https://wpp.wirecard.com/api/';

    /**
     * WirecardClient constructor.
     * @param string $eeUser
     * @param string $eePassword
     * @param string $MAID
     * @param string $secret
     */
    public function __construct(string $eeUser, string $eePassword, string $MAID, string $secret)
    {
        $this->eeUser = $eeUser;
        $this->eePassword = $eePassword;
        $this->MAID = $MAID;
        $this->secret = $secret;
    }

    /**
     * @param string $url
     */
    public function setApiUrl(string $url)
    {
        $this->apiUrl = $url;
    }

    /**
     * @param string $url
     */
    public function setWppUrl(string $url)
    {
        $this->wppUrl = $url;
    }

    /**
     * @return resource
     */
    protected function initCurl()
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_USERPWD => $this->eeUser . ':' . $this->eePassword,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_CONNECTTIMEOUT => 60,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
            ],
        ]);

        return $ch;
    }

    /**
     * @param Payment $payment
     *
     * @return Payment
     * @throws RequestFailedException
     */
    public function registerPaymentWpp(Payment $payment): Payment
    {
        $payment->setMerchantAccountId($this->MAID);

        $ch = $this->initCurl();

        $payload = json_encode(
            ['payment' => $payment]
            , JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        curl_setopt_array($ch, [
            CURLOPT_URL => $this->wppUrl . 'payment/register',
            CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($payload),
            ],
            CURLOPT_POSTFIELDS => $payload,
        ]);
        return Payment::fromObject($this->getResponse($ch));
    }

    /**
     * @param Payment $payment
     *
     * @return Payment
     * @throws RequestFailedException
     */
    public function registerPayment(Payment $payment): Payment
    {
        $payment->setMerchantAccountId($this->MAID);

        $ch = $this->initCurl();

        $payload = json_encode(
            ['payment' => $payment]
            , JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);


        $url = $this->apiUrl . 'engine/rest/' . $payment->getRestMethod() . '/';

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($payload),
            ],
            CURLOPT_POSTFIELDS => $payload,
        ]);
        return Payment::fromObject($this->getResponse($ch));
    }

    /**
     * @param string $transaction
     *
     * @return Payment
     * @throws DataNotFoundException
     * @throws RequestFailedException
     */
    public function searchPaymentByTransactionId(string $transaction): Payment
    {
        $ch = $this->initCurl();
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->apiUrl . 'engine/rest/merchants/' . $this->MAID . '/payments/' . $transaction,
        ]);

        $response = $this->getResponse($ch);
        if (!(array)$response->payment) {
            throw new DataNotFoundException;
        }
        return Payment::fromObject($response->payment);
    }

    /**
     * @param string $requestId
     *
     * @return Payment
     * @throws DataNotFoundException
     * @throws RequestFailedException
     */
    public function searchPaymentByRequestId(string $requestId): Payment
    {
        $ch = $this->initCurl();
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->apiUrl . 'engine/rest/merchants/' . $this->MAID . '/payments/search?payment.request-id='
                . urlencode($requestId)
        ]);

        $response = $this->getResponse($ch);
        if (!(array)$response->payment) {
            throw new DataNotFoundException;
        }
        return Payment::fromObject($response->payment);
    }

    /**
     * @param resource $ch
     * @return mixed
     * @throws RequestFailedException
     */
    protected function getResponse($ch)
    {
        $response = curl_exec($ch);

        if ($response === false) {
            throw new RequestFailedException('Curl error #' . curl_errno($ch) . ': ' . curl_error($ch));
        }

        if (substr($response, 0, 5) === '<?xml') {
            $xml = simplexml_load_string($response);
            $object = self::xml2json($xml);
        } else {
            $object = json_decode($response, false, 512, JSON_THROW_ON_ERROR);
            if ($object === false) {
                throw new RequestFailedException('Malformed JSON');
            }
        }

        return $object;
    }

    /**
     * @param $xml
     *
     * @return \stdClass|string
     */
    protected static function xml2json($xml)
    {
        $object = new \stdClass();
        foreach ($xml as $prop => $value) {
            if ($value instanceof \SimpleXMLElement) {
                $value = self::xml2json($value);
            }
            $object->{$prop} = $value;
        }

        foreach ($xml->attributes() as $prop => $value) {
            if ($value instanceof \SimpleXMLElement) {
                $value = self::xml2json($value);
            }
            $object->{$prop} = $value;

        }

        $content = (string)$xml;
        if ($content !== '') {
            if (count((array)$object)) {
                $object->value = $content;
            } else {
                $object = $content;
            }
        }

        return $object;

    }

    /**
     * @return Payment|null
     */
    public function parseHttpPost()
    {
        $sig = base64_decode($_POST['response-signature-base64'] ?? '');
        //$sigArg = $_POST['response-signature-algorithm'] ?? '';
        $responseEncoded = $_POST['response-base64'] ?? '';
        if (!hash_equals(hash_hmac('sha256', $responseEncoded, $this->secret, true), $sig)) {
            return null;
        }
        $response = json_decode(base64_decode($responseEncoded));

        if (!isset($response->payment)) {
            return null;
        }

        return Payment::fromObject($response->payment);
    }
}
