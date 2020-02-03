<?php


namespace WirecardClient\Types;


final class Notifications extends Base
{
    /**
     * @var string
     */
    public $format;

    /**
     * @var array
     */
    public $notification = [];

    public function __construct(string $format = 'application/json')
    {
        $this->format = $format;
    }

    /**
     * @param string $url
     * @param string $transactionState
     * @return $this
     */
    public function addUrl(string $url, string $transactionState = 'any')
    {
        if (!in_array($transactionState, ['any', 'failed', 'success'], true)) {
            throw new \InvalidArgumentException('argument $state must be either any/failed/success');
        }
        $notification = new \stdClass();
        $notification->url = $url;
        if ($transactionState !== 'any') {
            $notification->{'transaction-state'} = $transactionState;
        }
        $this->notification[] = $notification;
        return $this;
    }
}