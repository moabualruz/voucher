<?php
declare(strict_types=1);

namespace Voucher\Message;

class OrderEvent
{
    private array $orderData;
    private string $action;

    public function __construct(array $orderData, string $action)
    {
        $this->orderData = $orderData;
        $this->action = $action;
    }

    /**
     * @return array
     */
    public function getOrderData(): array
    {
        return $this->orderData;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }


}