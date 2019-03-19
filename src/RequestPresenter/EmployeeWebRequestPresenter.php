<?php

namespace App\RequestPresenter;

use Symfony\Component\HttpFoundation\Request;

class EmployeeWebRequestPresenter
{
    protected $search;
    protected $order;

    public function __construct(string $search = null, string $order = null)
    {
        $this->setSearch($search);
        $this->setOrder($order);
    }

    public function getSearch(): string
    {
        return $this->search;
    }

    protected function setSearch($search): void
    {
        $this->search = $search ?? '';

        return;
    }

    public function getOrderField(): string
    {
        return $this->order['field'];
    }

    public function getOrderType(): string
    {
        return $this->order['type'];
    }

    protected function setOrder($order): void
    {
        if (isset($order)) {
            $orderArray = explode(':', $order);

            $this->order['field'] = $orderArray[0];
            $this->order['type']  = $orderArray[1];
        } else {
            $this->order['field'] = 'id';
            $this->order['type']  = 'ASC';
        }

        return;
    }
}
