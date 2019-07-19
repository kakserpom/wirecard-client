<?php


namespace WirecardClient\Types;


final class AccountHolder extends Base
{
    public static function make(string $firstName, string $lastName, string $email, string $phone, Address $address)
    {
        $self = new self;
        $firstName === null || $self->setFirstName($firstName);
        $lastName === null || $self->setLastName($lastName);
        $email === null || $self->setEmail($email);
        $phone === null || $self->setPhone($phone);
        $address === null || $self->setAddress($address);
        return $self;
    }

    /**
     * @return CardToken|null
     */
    public function getAddress()
    {
        if (!isset($this->address)) {
            return null;
        }
        return $this->address instanceof Address ? $this->address : Address::fromArray($this->address);
    }
}