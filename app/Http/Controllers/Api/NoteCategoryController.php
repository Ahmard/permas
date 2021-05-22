<?php


namespace App\Http\Controllers\Api;


use App\Auth;
use App\Http\Request;
use App\Models\NoteCategory;
use Illuminate\Validation\ValidationException;
use Nette\Utils\JsonException;

class NoteCategoryController
{
    /**
     * @param Request $request
     * @throws ValidationException
     * @throws JsonException
     */
    public function store(Request $request): void
    {
        $validator = $request->validate([
            'name' => 'required|min:3|max:100'
        ]);

        if ($validator->fails()){
            $validator->sendErrorResponse();
        }

        $category = NoteCategory::query()->create([
            'user_id' => $request->auth()->user()['username']
        ]);

        $request->response()->jsonSuccess($category);
    }
}