<?php

namespace App\Presenter;

abstract class Presenter
{
    protected $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function __call($method, $args)
    {
        $accessor = 'get' . ucfirst($method);

        return call_user_func_array([$this->entity, $accessor], $args);
    }

    public function __get($name)
    {
        if (!property_exists($this->entity, $name) && !property_exists($this, $name)) {
            throw new \InvalidArgumentException(
                "Getting the field '$name' is not valid for this entity"
            );
        }

        $accessor = 'get' . ucfirst($name);
        if (method_exists($this->entity, $accessor) && is_callable(array($this->entity, $accessor))) {
            $result = $this->entity->$accessor();
        }

        if (method_exists($this, $accessor) && is_callable(array($this, $accessor))) {
            $result = $this->$accessor();
        }

        return $result ?? $this->entity->{$name};
    }
}
