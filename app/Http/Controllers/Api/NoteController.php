<?php


namespace App\Http\Controllers\Api;


use App\Http\Request;
use App\Models\Note;
use App\Models\NoteCategory;
use Illuminate\Validation\ValidationException;
use Nette\Utils\JsonException;

class NoteController
{
    /**
     * @param Request $request
     * @throws JsonException
     */
    public function index(Request $request): void
    {
        $request->response()->jsonSuccess(Note::all());
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
            'category' => 'required|int|min:1'
        ]);

        if ($validator->fails()) {
            $validator->sendErrorResponse();
        }

        $request->response()->jsonSuccess(NoteCategory::query()->create([
            'name' => $request->post('name'),
            'category_id' => $request->post('category'),
            'user_id' => $request->auth()->user()['id'],
        ]));
    }
}