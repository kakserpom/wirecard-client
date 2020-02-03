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
    public function setTransactionType(string $type): self
    {
        $this->{'transaction-type'} = $type;
        return $this;
    }

    /**
     * @param string $id
     */
    public function setCreditorId(string $id): self
    {
        $this->{'creditor-id'} = $id;
        return $this;
    }

    /**
     * @param string $descriptor
     */
    public function setDescriptor(string $descriptor): self
    {
        $this->{'descriptor'} = $descriptor;
        return $this;
    }

    /**
     * @param BankAccount $bankAccount
     */
    public function setBankAccount(BankAccount $bankAccount): self
    {
        $this->{'bank-account'} = $bankAccount;
        return $this;
    }

    /**
     * @param Mandate $mandate
     */
    public function setMandate(Mandate $mandate): self
    {
        $this->{'mandate'} = $mandate;
        return $this;
    }


    /**
     * @param string $ipAddress
     */
    public function setIpAddress(string $ipAddress): self
    {
        $this->{'ip-address'} = $ipAddress;
        return $this;
    }

    /**
     * @param string $transactionId
     */
    public function setParentTransactionId(string $transactionId): self
    {
        $this->{'parent-transaction-id'} = $transactionId;
        return $this;
    }


    /**
     * @param Card $card
     */
    public function setCard(Card $card): self
    {
        $this->card = $card;
        return $this;
    }


    /**
     * @param CardToken $cardToken
     */
    public function setCardToken(CardToken $cardToken): self
    {
        $this->{'card-token'} = $cardToken;
        return $this;
    }

    /**
     * @return CardToken|null
     */
    public function getCardToken()
    {
        if (!isset($this->{'card-token'})) {
            return null;
        }
        return $this->{'card-token'} instanceof CardToken
            ? $this->{'card-token'}
            : CardToken::fromObject($this->{'card-token'});
    }


    /**
     * @return AccountHolder|null
     */
    public function getAccountHolder()
    {
        if (!isset($this->{'account-holder'})) {
            return null;
        }
        return $this->{'account-holder'} instanceof AccountHolder
            ? $this->{'account-holder'}
            : AccountHolder::fromObject($this->{'account-holder'});
    }

    /**
     * @param AccountHolder $holder
     * @return $this
     */
    public function setAccountHolder(AccountHolder $holder): self
    {
        $this->{'account-holder'} = $holder;
        return $this;
    }

    /**
     * @param Device $device
     * @return $this
     */
    public function setDevice(Device $device): self
    {
        $this->device = $device;
        return $this;
    }

    /**
     * @param ThreeD $threeD
     * @return $this
     */
    public function setThreeD(ThreeD $threeD): self
    {
        $this->{'three-d'} = $threeD;
        return $this;
    }

    /**
     * @param PaymentMethods $methods
     * @return $this
     */
    public function setPaymentMethods(PaymentMethods $methods): self
    {
        $this->{'payment-methods'} = $methods;
        return $this;
    }

    /**
     * @return PaymentMethods
     */
    public function getPaymentMethods(): PaymentMethods
    {
        return $this->{'payment-methods'} instanceof PaymentMethods
            ? $this->{'payment-methods'}
            : PaymentMethods::fromObject($this->{'payment-methods'});
    }

    /**
     * @param Notifications $notifications
     * @return $this
     */
    public function setNotifications(Notifications $notifications): self
    {
        $this->notifications = $notifications;
        return $this;
    }

    /**
     * @return Notifications
     */
    public function getNotifications(): Notifications
    {
        return $this->notifications instanceof Notifications
            ? $this->notifications
            : Notifications::fromObject($this->notifications);
    }

    /**
     * @param string $value
     */
    public function setOrderNumber(string $value): self
    {
        $this->{'order-number'} = $orderNumber;
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setOrderDetail(string $value): self
    {
        $this->{'order-detail'} = $value;
        return $this;
    }


    /**
     * @param string $url
     * @return $this
     */
    public function setSuccessRedirectUrl(string $url): self
    {
        $this->{'success-redirect-url'} = $url;
        return $this;
    }


    /**
     * @param string $url
     * @return $this
     */
    public function setCancelRedirectUrl(string $url): self
    {
        $this->{'cancel-redirect-url'} = $url;
        return $this;
    }


    /**
     * @param string $url
     * @return $this
     */
    public function setFailRedirectUrl(string $url): self
    {
        $this->{'fail-redirect-url'} = $url;
        return $this;
    }

    /**
     * @param string $MAID
     * @return $this
     */
    public function setMerchantAccountId(string $MAID): self
    {
        $this->{'merchant-account-id'} = ['value' => $MAID];
        return $this;
    }

    /**
     * @param $statuses
     * @return $this
     */
    protected function setStatuses($statuses): self
    {
        $this->statuses = $statuses;
        return $this;
    }
}