<?php


namespace App\Http\Controllers\Api;


use App\Http\Request;

class NoteController
{
    public function create(Request $request)
    {
        $validator = $request->validate([
            ''
        ]);
    }
}