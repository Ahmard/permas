<?php


namespace App\Http\Controllers\User;


use App\Http\Request;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class NoteController
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(Request $request): void
    {
        $request->response()->view('user/note/index');
    }
}