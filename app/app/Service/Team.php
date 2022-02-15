<?php

namespace App\Service;

class Team
{
    public $team = [];


    public function createTeam()
    {
        $rollTheDice = new Dice();
        $diceValue = $rollTheDice->diceForRolling("d4");
        if (array_key_exists($diceValue, $this->team))
        {
            echo "No one else wants to work with you. Let's move on.\n";
            return false;

        }
        switch($diceValue)
        {
            case 1:
                $teamMemberName = "Alec";
                echo "Meet Alec Aldis, tech wizard extraordinaire. Having him inside with you will definitely help.\n";
                $this->team[$diceValue] = $teamMemberName;
                break;
            case 2:
                $teamMemberName = "Mary";
                echo "Meet Mary Monroe. Whatever you need: distractions, fighting, aerialist skills, she can do it.\n";
                $this->team[$diceValue] = $teamMemberName;
                break;
            case 3:
                $teamMemberName = "Kane";
                echo "Meet Kane Spencer. No one has gone up against his fists and walked away. No one.\n";
                $this->team[$diceValue] = $teamMemberName;
                break;
            case 4:
                $teamMemberName = "AJ";
                echo "Meet AJ. Wanted by countless worldwide agencies for various... misunderstandings. You're lucky to have them.\n";
                $this->team[$diceValue] = $teamMemberName;
                break;
        }
        return true;
    }

    public function countTeam()
    {
        $teamNumber = count($this->team);
        return $teamNumber;
    }
}
