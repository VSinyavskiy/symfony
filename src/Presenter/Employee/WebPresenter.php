<?php

namespace App\Presenter\Employee;

use App\Presenter\Presenter;

class WebPresenter extends Presenter
{
    private $employeeWebPhones;

    public function getEmployeeWebPhones()
    {
        $html = '';
        foreach ($this->entity->getEmployeePhones()->toArray() as $item) {
            $html .= $item->getPhone() . '</br>';
        }

        return $html;
    }
}
