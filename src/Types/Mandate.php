<?php


namespace WirecardClient\Types;


final class Mandate extends Base
{
    /**
     * Mandate constructor.
     * @param string $mandateId
     * @param string $signedDate
     */
    public function __construct(string $mandateId, string $signedDate)
    {
        $this->{'mandate-id'} = $mandateId;
        $this->{'signed-date'} = $signedDate;
    }

    /**
     * @return string
     */
    public function getMandateId(): string
    {
        return $this->{'mandate-id'};
    }

    /**
     * @return string
     */
    public function getSignedDate(): string
    {
        return $this->{'signed-date'};
    }
}