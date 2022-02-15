<?php

namespace App\Service;

class Ending extends Story
{
    public function footRace()
    {
        $end = new Points();
        echo "The police begin to chase you. You now need to roll off against the police to see if you escape. Type roll in now:\n";
        $response = readline(">> ");

        if ($response != "roll")
        {
            $this->level = 8;
            echo "You didn't even try to escape... but it didn't make the judge any less sympathetic. Enjoy prison!\n";
            $end->assignPoints();
            $end->leaving();
        } else
        {
            $userRoll = $this->rollTheDice->diceForRolling("d20");
            $policeRoll = $this->rollTheDice->diceForRolling("d20");

            if ($userRoll > $policeRoll)
            {
                echo "You escape to the rendezvous spot and count out the money.";
                return;
            } elseif ($userRoll < $policeRoll)
            {
                $this->level = 9;
                echo "The police are faster than you. They manage to tackle you to the ground, wrestling the money away. You are arrested... better luck next time!\n";
                $end->assignPoints();
                $end->leaving();
            } elseif ($userRoll == $policeRoll)
            {
                echo "The police close the distance. You throw the money at them, as a diversion. It works, and they stop to collect that, leaving you time to get away.\n";
                $this->level = 9;
                echo "You may have failed to get money, but at least you are free. You lay low for a while, biding your time until you can try again.\n";
                $end->assignPoints();
                $end->leaving();
            }
        }
    }

    public function carChase()
    {
        $end = new Points();
        echo "The police are hot on your heels. You now need to roll off against the police to see if you escape. Type roll in now:\n";
        $response = readline(">> ");

        if ($response != "roll")
        {
            $this->level = 8;
            echo "You didn't even try to escape... but it didn't make the judge any less sympathetic. Enjoy prison!\n";
            $end->assignPoints();
            $end->leaving();
        } else
        {
            $userRoll = $this->rollTheDice->diceForRolling("d20");
            $policeRoll = $this->rollTheDice->diceForRolling("d20");

            if ($userRoll > $policeRoll)
            {
                echo "You escape to the rendezvous spot and count out the money.\n";
                return;
            } elseif ($userRoll < $policeRoll)
            {
                echo "You were too focused on the police and not focused enough on the car. You crash into a wall. Roll to see if you survive:\n";
                $response = readline(">> ");
                if ($response == "roll")
                {
                    $survival = $this->rollTheDice->diceForRolling("d20");
                    if ($survival >= 10)
                    {
                        $this->level = 9;
                        echo "You survive, but are arrested. You are taken to the hospital, stabilised, and then put in prison.\n";
                        $end->assignPoints();
                        $end->leaving();
                    } else
                    {
                        $this->level = 9;
                        echo "You do not survive the crash, your vision blacking out just as you crash through the windshield.\nConsider wearing a seatbelt next time.\n";
                        $end->assignPoints();
                        $end->leaving();
                    }
                } else
                {
                    $this->level = 9;
                    echo "Your body was lodged in the car, and as you tried to assess the damage, you feel yourself forcibly ripped from the vehicle.\nEnjoy prison time.\n";
                    $end->assignPoints();
                    $end->leaving();
                }
            } elseif ($userRoll == $policeRoll)
            {
                echo "The police close the distance. To try and get away, you jump from the car as it slows on a turn, bag of money in hand.\nContinue on foot.\n";
                $this->footRace();
            }
        }
    }
}
