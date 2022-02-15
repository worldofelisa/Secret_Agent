<?php

namespace App\Http\Controllers;

use App\Service\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function index()
    {
        return view("story.index");
    }

    public function startStory()
    {
        $story = new Story();
        $story->startMission();
        $story->meetTheTeam();
        $story->trickTheGuards();
        $story->timeToStart();
        $story->openVault();
        $story->getMoney();
        $story->leaveSafely();
    }
}
