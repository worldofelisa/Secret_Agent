<?php

namespace App\Service;

class Dice
{
    function diceForRolling($dice)
    {
        switch($dice)
        {
            case "d4":
                return rand(1, 4);
            case "d6":
                return rand(1, 6);
            case "d8":
                return rand(1, 8);
            case "d10":
                return rand(1, 10);
            case "d12":
                return rand(1, 12);
            case "d20":
                return rand(1, 20);
            case "d100":
                return rand(1, 100);
        }
    }
}
