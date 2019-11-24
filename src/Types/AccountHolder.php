<?php


namespace WirecardClient\Types;


final class AccountHolder extends Base
{
    public function __construct(string $firstName = null, string $lastName = null, string $email = null, string $phone = null, Address $address = null)
    {
        $firstName === null || $this->setFirstName($firstName);
        $lastName === null || $this->setLastName($lastName);
        $email === null || $this->setEmail($email);
        $phone === null || $this->setPhone($phone);
        $address === null || $this->setAddress($address);
    }

    /**
     * @return CardToken|null
     */
    public function getAddress()
    {
        if (!isset($this->address)) {
            return null;
        }
        return $this->address instanceof Address ? $this->address : Address::fromObject($this->address);
    }
}