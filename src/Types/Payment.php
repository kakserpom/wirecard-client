<?php


namespace WirecardClient\Types;


final class Payment extends Base
{

    /**
     * @param string $requestId
     * @param Amount $amount
     * @return Payment
     */
    public static function make(string $requestId = null, Amount $amount = null)
    {
        $self = new self;
        $self->{'request-id'} = $requestId ?? self::guidv4();
        if ($amount) {
            $self->{'requested-amount'} = $amount;
        }
        return $self;
    }

    /**
     * @return bool
     */
    public function isFailed()
    {
        return substr($this->getTransactionState(), 0, 4) === 'fail';
    }

    /**
     * @return array
     */
    public function errors()
    {
        $errors = [];
        foreach ($this->statuses->status ?? [] as $status) {
            if ($status->severity === 'error') {
                $errors[] = '#' . $status->code . ': ' . $status->description;
            }
        }
        return $errors;
    }

    /**
     *
     */
    public function getIpAddress()
    {
        return $this->{'ip-address'} ?? null;
    }

    /**
     * @return string
     */
    public static function guidv4()
    {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * @param string $type
     */
    public function setTransactionType(string $type)
    {
        $this->{'transaction-type'} = $type;
    }


    /**
     * @param string $ipAddress
     */
    public function setIpAddress(string $ipAddress)
    {
        $this->{'ip-address'} = $ipAddress;
    }


    /**
     * @param Card $card
     */
    public function setCard(Card $card)
    {
        $this->card = $card;
    }


    /**
     * @return CardToken|null
     */
    public function getCardToken()
    {
        if (!isset($this->{'card-token'})) {
            return null;
        }
        return $this->{'card-token'} instanceof CardToken ? $this->{'card-token'} : CardToken::fromArray($this->{'card-token'});
    }


    /**
     * @return CardToken|null
     */
    public function getAccountHolder()
    {
        if (!isset($this->{'account-holder'})) {
            return null;
        }
        return $this->{'account-holder'} instanceof AccountHolder ? $this->{'account-holder'} : AccountHolder::fromArray($this->{'account-holder'});
    }

    /**
     * @param AccountHolder $holder
     */
    public function setAccountHolder(AccountHolder $holder)
    {
        $this->{'account-holder'} = $holder;
    }

    /**
     * @param string $type
     */
    public function setDevice(Device $device)
    {
        $this->device = $device;
    }

    /**
     * @param ThreeD $threeD
     */
    public function setThreeD(ThreeD $threeD)
    {
        $this->{'three-d'} = $threeD;
    }

    /**
     * @param PaymentMethods $methods
     */
    public function setPaymentMethods(PaymentMethods $methods)
    {
        $this->{'payment-methods'} = $methods;
    }

    /**
     * @param string $value
     */
    public function setOrderNumber(string $value)
    {
        $this->{'order-number'} = $orderNumber;
    }

    /**
     * @param string $value
     */
    public function setOrderDetail(string $value)
    {
        $this->{'order-detail'} = $value;
    }


    /**
     * @param string $url
     */
    public function setSuccessRedirectUrl(string $url)
    {
        $this->{'success-redirect-url'} = $url;
    }


    /**
     * @param string $url
     */
    public function setCancelRedirectUrl(string $url)
    {
        $this->{'cancel-redirect-url'} = $url;
    }


    /**
     * @param string $url
     */
    public function setFailRedirectUrl(string $url)
    {
        $this->{'fail-redirect-url'} = $url;
    }

    /**
     * @param string $MAID
     */
    public function setMerchantAccountId(string $MAID)
    {
        $this->{'merchant-account-id'} = ['value' => $MAID];
    }

    /**
     * @param object $statuses
     */
    protected function setStatuses($statuses)
    {
        $this->statuses = $statuses;
    }
}