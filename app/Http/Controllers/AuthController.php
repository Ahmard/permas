<?php


namespace App\Http\Controllers;


use App\Http\Request;
use App\Models\User;
use App\Utils\Auth;
use Illuminate\Validation\ValidationException;
use Nette\Utils\JsonException;
use Throwable;

class AuthController
{
    public function showLoginForm(Request $request): void
    {
        $request->response()
            ->view('auth/login', [
                'title' => 'Login'
            ]);
    }

    /**
     * @param Request $request
     * @throws JsonException
     * @throws ValidationException
     */
    public function doLogin(Request $request): void
    {
        $validator = $request->validate([
            'username' => 'required|min:3|max:30',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $validator->sendErrorResponse();
            return;
        }

        $request->response()->json(
            User::query()
                ->where('username', $request->post('username'))
                ->get()
                ->first()
        );
    }

    public function showRegisterForm(Request $request): void
    {
        $request->response()
            ->view('auth/register', [
                'title' => 'Register'
            ]);
    }

    /**
     * @param Request $request
     * @throws JsonException
     */
    public function doCreate(Request $request): void
    {
        $response = $request->response();
        $validator = $request->validate([
            'username' => 'required|min:3|max:50',
            'password' => 'required|min:4|max:150',
            'email' => 'required|min:7|max:150',
        ]);

        if ($validator->fails()) {
            $validator->sendErrorResponse();
            return;
        }

        try {
            $existingUser = User::query()
                ->select('username', 'email')
                ->where('username', $request->post('username'))
                ->orWhere('email', $request->post('email'))
                ->get()
                ->first();

            if ($existingUser) {
                if ($existingUser['username'] == $request->post('username')) {
                    $response->jsonError('User with such username already exists.');
                } elseif ($existingUser['email'] == $request->post('email')) {
                    $response->jsonError('User with such email address already exists.');
                }
                return;
            }

            $user = User::query()->create([
                'username' => $request->post('username'),
                'email' => $request->post('email'),
                'password' => Auth::makeHash($request->post('password')),
            ]);

            $response->jsonSuccess([
                'message' => 'Account has been created successfully',
                'user' => $user
            ]);
        } catch (Throwable $exception) {
            $response->jsonError($exception->getMessage());
        }
    }
}