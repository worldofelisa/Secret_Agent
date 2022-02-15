<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;
use App\Service\Points;

class ScoreController extends Controller
{
    public function index()
    {
        return view("points.index");
    }

    public function tallyPoints(Points $points)
    {
        $score = new Score();
        $score->levelachieved = $points->assignPoints();
    }
}
