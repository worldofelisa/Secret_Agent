<?php

namespace App\Service;

class User
{
    private $name;

    /**
     * @return void
     */
    public function setName()
    {
        echo "What is your name, agent?\n";
        $this->name = readline(">> ");
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->name;
    }
}
