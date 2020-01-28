<?php


namespace WirecardClient\Types;


final class Payment extends Base
{

    /**
     * @param string $requestId
     * @param Amount $amount
     * @return Payment
     */
    public function __construct(string $requestId = null, Amount $amount = null)
    {
        $this->{'request-id'} = $requestId ?? self::guidv4();
        if ($amount) {
            $this->{'requested-amount'} = $amount;
        }
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
            if (($status->severity ?? '') === 'error') {
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
    public function setTransactionType(string $type): void
    {
        $this->{'transaction-type'} = $type;
    }

    /**
     * @param string $id
     */
    public function setCreditorId(string $id): void
    {
        $this->{'creditor-id'} = $id;
    }

    /**
     * @param string $descriptor
     */
    public function setDescriptor(string $descriptor): void
    {
        $this->{'descriptor'} = $descriptor;
    }

    /**
     * @param BankAccount $bankAccount
     */
    public function setBankAccount(BankAccount $bankAccount): void
    {
        $this->{'bank-account'} = $bankAccount;
    }

    /**
     * @param Mandate $mandate
     */
    public function setMandate(Mandate $mandate): void
    {
        $this->{'mandate'} = $mandate;
    }


    /**
     * @param string $ipAddress
     */
    public function setIpAddress(string $ipAddress): void
    {
        $this->{'ip-address'} = $ipAddress;
    }

    /**
     * @param string $transactionId
     */
    public function setParentTransactionId(string $transactionId): void
    {
        $this->{'parent-transaction-id'} = $transactionId;
    }


    /**
     * @param Card $card
     */
    public function setCard(Card $card): void
    {
        $this->card = $card;
    }


    /**
     * @param CardToken $cardToken
     */
    public function setCardToken(CardToken $cardToken): void
    {
        $this->{'card-token'} = $cardToken;
    }

    /**
     * @return CardToken|null
     */
    public function getCardToken()
    {
        if (!isset($this->{'card-token'})) {
            return null;
        }
        return $this->{'card-token'} instanceof CardToken ? $this->{'card-token'} : CardToken::fromObject($this->{'card-token'});
    }


    /**
     * @return CardToken|null
     */
    public function getAccountHolder()
    {
        if (!isset($this->{'account-holder'})) {
            return null;
        }
        return $this->{'account-holder'} instanceof AccountHolder ? $this->{'account-holder'} : AccountHolder::fromObject($this->{'account-holder'});
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
     * @return PaymentMethods
     */
    public function getPaymentMethods(): PaymentMethods
    {
        return $this->{'payment-methods'} ?? new PaymentMethods([]);
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