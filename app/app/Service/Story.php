<?php

namespace App\Service;

use Illuminate\Routing\Pipeline;

class Story
{
    public $rollTheDice;
    public $agentName;
    public $teamMembers;
    public $teamSize;
    public $moneyTotal;
    public $level;
    private $vaultCode = [];
    const MAX_VAULT_CODE = 5;

    /**
     * Sets up the vault numbers to be three random numbers and stores them into the private array.
     * @return void
     */
    public function __construct()
    {
        for ($a = 0; $a < 3; $a++)
        {
            $this->vaultCode = [rand(1, self::MAX_VAULT_CODE), rand(1, self::MAX_VAULT_CODE), rand(1, self::MAX_VAULT_CODE)];
        }
        $rollTheDice = new Dice();
    }

    /**
     * Starts the mission, calls to User class for name then starts the mission.
     * @return void
     */
    public function startMission()
    {
        $username = new User();
        $username->setName();
        $this->agentName = $username->index();
        echo "Welcome, Agent $this->agentName. Are you ready to start your mission?\nRespond yes or no:\n";
        $response = readline(">> ");
        if ($response !== "yes") {
            $this->level = 0;
            echo "I see. On your way then.\n";
            $end = new Points();
            $end->assignPoints();
            $end->leaving();
        } else {
            echo "Good. Let's get started.\n";
            echo "You will be breaking into Currency Keepers, one of the biggest banks in the city.\n";
            echo "Given your reputation, this shouldn't be hard for you. Now, shall we go meet the team?\n";
        }
    }

    public function meetTheTeam()
    {
        $pickTeam = new Team();
        echo "There are four potential team members. At least one will work with you.\n";
        echo "Roll the die to see how many team members you will get.\n";
        echo "To roll, type roll in now:\n";
        $response = readline(">> ");

        if ($response != "roll") {
            $this->level = 0;
            echo "We only send in teams. Maybe you aren't right for this job after all.\n";
            $end = new Points();
            $end->assignPoints();
            $end->leaving();
        } else
        {
            $moreTeam = false;
            do
            {
                $team = $pickTeam->createTeam();
                if (!$team)
                {
                    $moreTeam = false;
                    continue;
                }

                echo "Do you want another teammate? Type yes or no in now:\n";
                $extraMember = readline(">> ");

                if ($extraMember == "no") {
                    $moreTeam = false;
                    return;
                } else
                {
                    $moreTeam = true;
                }
            } while ($moreTeam);

        }

        $teamNumber = $pickTeam->countTeam();
        $this->teamMembers = $teamNumber;
        $this->teamSize = $teamNumber + 1;
        echo "You have $this->teamMembers members in your team.\nHopefully the $this->teamSize of you can do it.\n";
        echo "Now that you have your team, let's go break into a bank!\n";
    }

    public function trickTheGuards()
    {
        echo "Time to move inside the bank. Let's see if you can make it past the guards.\n";
        echo "Roll a die to see if you can evade the guards. To roll, type roll in now:\n";
        $response = readline(">> ");

        if ($response != "roll")
        {
            $this->level = 1;
            echo "The bank is closed. Go home.\n";
            $end = new Points();
            $end->assignPoints();
            $end->leaving();
        } else
        {
            $rollResult = $this->rollTheDice->diceForRolling("d100");
        }

        if ($this->teamSize == 5)
        {
            $disadvantage = $this->rollTheDice->diceForRolling("d100");
            $diceResult = min($rollResult, $disadvantage);
        } elseif ($this->teamSize == 4)
        {
            $diceResult = $rollResult - 10;
        }elseif ($this->teamSize == 2)
        {
            $diceResult = $rollResult + 10;
        } else
        {
            $diceResult = $rollResult;
        }

        switch (true)
        {
            case $diceResult <= 25:
                $this->level = 2;
                echo "The gun fell out of your pocket as you entered the bank.\nThe guards noticed and arrested you and your team immediately.\nYou are now in jail... and you may need some protection!\n";
                $end = new Points();
                $end->assignPoints();
                $end->leaving();
                break;
            case $diceResult <= 50:
                $this->level = 2;
                echo "The guards found you suspicious. You and your team left the bank for fear of being caught.\n";
                $end = new Points();
                $end->assignPoints();
                $end->leaving();
                break;
            case $diceResult <= 100:
                echo "You're in. Well done! You tricked the guards, who are none the wiser. Now let's see if you can get to the vault.\n";
                break;

        }
    }

    public function timeToStart()
    {
        echo "You and your team need to distract the staff so you can sneak down to the vault.\n";
        echo "Roll to see how distracting your team is. Type roll in now:\n";
        $response = readline(">> ");

        if ($response != "roll")
        {
            $this->level = 2;
            echo "You and your team members begin to argue over who is meant to distract the staff. The guards hear you and arrest you. Good luck explaining this one!\n";
            $end = new Points();
            $end->assignPoints();
            $end->leaving();
        } else
        {
            $diceResult = $this->rollTheDice->diceForRolling("d20");
        }

        if ($diceResult >= 15)
        {
            echo ("Your team member successfully distracts the staff. You are able to slip into a back door and make your way to the vault.\n");
        } elseif ($diceResult >= 5)
        {
            echo "The staff are suspicious. Do you want to sacrifice a teammate to succeed?\nRespond yes or no:";
            $response = readline(">> ");
            if ($response != "yes")
            {
                $this->level = 3;
                echo "Well... you stuck with your team... and the police were called.\nLet's hope chivalry is rewarded in prison, because it did you no good this time.\n";
                $end = new Points();
                $end->assignPoints();
                $end->leaving();
            }else
            {
                $this->teamMembers = $this->teamMembers - 1;
                $this->teamSize = $this->teamSize -1;
                echo "You give up one of your team members, and successfully make it past the staff.\nHopefully this won't come back to bite you.\n";
            }

        }else
        {
            $this->level = 3;
            echo "The staff were suspicious and hit the alarm. You and your team made it out... barely.\n";
            $end = new Points();
            $end->assignPoints();
            $end->leaving();
        }

        echo "You currently have $this->teamMembers in your team.\nThis puts your team size at $this->teamSize.\nKeep that in mind for the future.\n";
    }

    public function openVault()
    {
        echo "You get past the vault, you will have to guess the code.\n";
        echo "There are three numbers in the lock combination between 1-" . self::MAX_VAULT_CODE . ". You must correctly guess all three for the lock to open.\n";
        echo "Be warned - you will only have three chances at each number before the vaults secondary locks are activated and the alarm is triggered.\n";
        echo "Good luck Agent. Begin your guesses now:\n";

        $yes = "Congratulations, you got it!\n";
        $no = "Incorrect passcode. Please try again.\n";
        $passCode = 1;
        $codeAttempt = 1;

        while ($passCode <= count($this->vaultCode))
        {
            $vaultGuess = readline(">> ");
            if ($vaultGuess != $this->vaultCode[$passCode - 1])
            {
                $codeAttempt++;
                echo $no;

                if ($codeAttempt > 3)
                {
                    $this->level = 4;
                    echo "Too many incorrect passcodes. Vault is now locked. You run as the alarm begins to sound, straight into the arms of the guards.\n";
                    $end = new Points();
                    $end->assignPoints();
                    $end->leaving();
                }
            } else
            {
                unset($codeAttempt);
                $codeAttempt = 1;
                echo $yes;
                $result[] = $vaultGuess;
                $passCode++;

                if (count($result) == 3)
                {
                    echo "You successfully guessed $result[0], $result[1], $result[2] and have cracked the code. Well done Agent $this->agentName!\n";
                    break;
                }
            }
        }
    }

    public function getMoney()
    {
        echo "The vault is open. Do you want to leave now?\n";
        $response = readline(">> ");

        if ($response == "yes")
        {
            $this->level = 5;
            echo "You got away... but you forgot to take money with you. So much for a heist. We'll hire better people next time.\n";
            $end = new Points();
            $end->assignPoints();
            $end->leaving();
        } else
        {
            echo "Let's grab the money then!\n";
        }

        echo "You are grabbing the money. Do you want to send your team member out now?\n";
        $response = readline(">> ");

        if ($response == "yes")
        {
            echo "Your team member was sent out too early. They run into cops on their break as they try to leave and you are all arrested.\n";
            if ($this->teamSize > 1)
            {
                echo "Do you want to sacrifice your team member to continue?\n Type yes or no in now:\n";
                $response = readline(">> ");
                if ($response != "yes")
                {
                    $this->level = 6;
                    echo "You go out to help your team member escape the cops and end up arrested as well.\n";
                    $end = new Points();
                    $end->assignPoints();
                    $end->leaving();
                } else
                {
                    $this->teamSize = $this->teamSize - 1;
                    $this->teamMembers = $this->teamMembers - 1;
                    echo "Your teammate has been successfully arrested but is none the wiser to your plan.\nLet's continue.\n";
                }
            }
        } else
        {
            $result = $this->rollTheDice->diceForRolling("d10");
            echo "With the help of your partner you acquire \$" . $result . ",000.";
        }

        echo "Do you want to send your team member out now?\n";
        $response = readline(">> ");

        if ($response == "no")
        {
            echo "Roll the die to see how much more money you get. Type roll in now:\n";
            readline(">> ");
            $money = $this->rollTheDice->diceForRolling("d10");
            echo "You have an extra \$" . $money . ",000 in your stash now!\n";
            $total = $result * 1000 + $money * 1000;
            $this->level = 7;
            echo "As you go to leave the bank with your \$" . $total . " you realize no one prepped the get away car.\nAs you climb inside you find yourself surrounded by the police, who have by now been alerted by the bank manager.\n";
            $end = new Points();
            $end->assignPoints();
            $end->leaving();
        } else
        {
            $money = $this->rollTheDice->diceForRolling("d4");
            $this->moneyTotal = $result * 1000 + $money * 1000;
            echo "Good. Your teammate leaves to go start the get away car.\nYou manage to get a bit more money into the bag before you follow after them.\n";
        }
    }

    public function leaveSafely()
    {
        $ending = new Ending();
        echo "While you finish in the bank, your teammate attempts to start the car. Roll to see how successful they are:\n";
        start:
        $response = readline(">> ");

        if ($response == "roll")
        {
            $result = $this->rollTheDice->diceForRolling("d4");
            switch ($result)
            {
                case 1:
                    echo "The car does not start. As you hear the alarm inside the bank begin to sound, you both get out and flee on foot, agreeing to meet up at base.\n";
                    $ending->footRace();
                    echo "You arrive at the rendezvous spot and count the money.\nYou manage to get away with $this->moneyTotal\n";
                    $this->level = 10;
                    echo "Well done, Agent $this->agentName.\nNow take your money and go.\n";
                    $end = new Points();
                    $end->assignPoints();
                    $end->success();
                    break;
                case 2:
                    if ($this->teamMembers > 1)
                    {
                        echo "The car does not start. Your teammate looks at you, offering themselves up as bait for the police.\nDo you send them out?\nRespond yes or no:";
                        $response = readline(">> ");
                        if ($response != "yes")
                        {
                            $this->level = 8;
                            echo "As you argue with them about being a martyr, the police close in on the car.\nYou are both arrested, and the money is returned to the bank.\nBetter luck next time!\n";
                            $end = new Points();
                            $end->assignPoints();
                            $end->leaving();
                        }else
                        {
                            $this->teamMembers = $this->teamMembers - 1;
                            $this->teamSize = $this->teamSize - 1;
                            echo "You let your teammate run out of the car, successfully distracting the police.\n";
                            echo "Your team is now $this->teamSize and you currently have $this->teamMembers team members";
                            echo "The car starts and you drive away.\nYou go back to base, where you hand over your prize.\n You manage to get away with $this->moneyTotal\n";
                            $this->level = 10;
                            echo "Well done, Agent $this->agentName.\nNow take your money and go.\n";
                            $end = new Points();
                            $end->assignPoints();
                            $end->success();
                        }
                    }else
                    {
                        echo "The car does not start. As you hear the alarm inside the bank begin to sound, you get out and flee on foot, trying to make it back to the base.\n";
                        $ending->footRace();
                        echo "You arrive at the rendezvous spot and count the money.\nYou manage to get away with $this->moneyTotal\n";
                        $this->level = 10;
                        echo "Well done, Agent $this->agentName.\nNow take your money and go.\n";
                        $end = new Points();
                        $end->assignPoints();
                        $end->success();
                    }
                    break;
                case 3:
                    echo "You car is idling as you leave the bank.\n You hop in and begin to drive away, but the police close in on you and begin to give chase.\n";
                    $ending->carChase();
                    echo "You arrive at the rendezvous spot and count the money.\nYou manage to get away with $this->moneyTotal\n";
                    $this->level = 10;
                    echo "Well done, Agent $this->agentName.\nNow take your money and go.\n";
                    $end = new Points();
                    $end->assignPoints();
                    $end->success();
                    break;
                case 4:
                    echo "The car is idling as you leave the bank. You hop in and drive away.\nYou go back to base, where you hand over your prize.\n You manage to get away with $this->moneyTotal\n";
                    $this->level = 10;
                    echo "Well done, Agent $this->agentName.\nNow take your money and go.\n";
                    $end = new Points();
                    $end->assignPoints();
                    $end->success();
                    break;
            }
        } else
        {
            echo "This is no time to play around! Roll now!";
            goto start;
        }
    }
}
