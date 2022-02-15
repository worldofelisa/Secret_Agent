<?php

namespace App\Service;

class Points
{
    public function assignPoints()
    {
        $points = new Story;
        $story = $points->level;
        $money = $points->moneyTotal;
        $team = $points->teamMembers;
        echo "You received $story points for the level you got to.\nYou have $money in the bank.\nYou had $team team members left at the end.\n";
        //ToDo: feed to db table??
    }

    public function leaving()
    {
        exit("Heist unsuccessful. Try again next time.\n");
    }

    public function success()
    {
        exit("We look forward to working with you again in the future.\n");
    }
}
