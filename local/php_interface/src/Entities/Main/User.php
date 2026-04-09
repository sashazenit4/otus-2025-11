<?php

namespace Otus\Entities\Main;

class User
{
    public string $email;
    public string $name;

    // пример магических функций в php
    public function __toString()
    {
        return $this->name . ' ' . $this->email;
    }
}
