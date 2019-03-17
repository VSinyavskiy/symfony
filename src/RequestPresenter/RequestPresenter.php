<?php

namespace App\RequestPresenter;

use Symfony\Component\HttpFoundation\Request;

abstract class RequestPresenter
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->request, $method], $args);
    }

    public function __get($name)
    {
        return $this->request->{$name};
    }
}
