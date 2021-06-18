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
     * @throws JsonException
     */
    public function index(Request $request): void
    {
        $request->response()->jsonSuccess(NoteCategory::all());
    }

    /**
     * @param Request $request
     * @throws ValidationException
     * @throws JsonException
     */
    public function store(Request $request): void
    {
        $validator = $request->validate([
            'name' => 'required|min:3|max:100',
            'parent_id' => 'int|min:1'
        ]);

        if ($validator->fails()){
            $validator->sendErrorResponse();
        }

        $category = NoteCategory::query()->create([
            'user_id' => $request->auth()->user()['id'],
            'parent_id' => $request->post('parent_id'),
            'name' => $request->post('name')
        ]);

        $request->response()->jsonSuccess($category);
    }
}