<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class ScoreController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function score(Request $request){
        $goodWords = $request['goodWords'];
        $badWords = $request['badWords'];
        dd($request);
        return view('score', array(
            'goodWords' => $goodWords,
            'badWords' => $badWords
         ));
    }
}
