<?php


namespace App\Http\Controllers;


use App\Http\Request;
use App\Http\Response;

class MainController
{
    public function index(Request $request): void
    {
        //$request->response()->dump([2,45], [94, 45], [74, 3]);

        $request->response()->view('index', [
            'name' => 'Ahmard'
        ]);
    }
}