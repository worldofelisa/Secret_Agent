<?php

namespace App\Service;

use App\Service\Story;

class Points
{
    public function assignPoints(Story $story)
    {

        $level = $story->level;
        $money = $story->moneyTotal;
        $team = $story->teamMembers;


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
