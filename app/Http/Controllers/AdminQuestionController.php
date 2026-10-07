<?php
namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminQuestionController extends Controller
{
    public function index()
    {
        return [
            'questions' => Question::with('options')->orderBy('position')->orderBy('id')->get(),
            'types' => collect(config('quiz.types'))->map(fn ($t) => $t['name']),
        ];
    }

    public function store(Request $request)
    {
        $question = new Question(['position' => (Question::max('position') ?? 0) + 1]);

        return response()->json($this->save($question, $request->validate($this->rules())), 201);
    }

    public function update(Request $request, Question $question)
    {
        return $this->save($question, $request->validate($this->rules()));
    }

    public function destroy(Question $question)
    {
        $question->delete(); // options cascade

        return response()->noContent();
    }

    private function rules(): array
    {
        return [
            'text' => 'required|string|max:255',
            'options' => 'required|array|min:2|max:6',
            'options.*.text' => 'required|string|max:120',
            'options.*.type' => ['required', Rule::in(array_keys(config('quiz.types')))],
        ];
    }

    private function save(Question $question, array $data): Question
    {
        DB::transaction(function () use ($question, $data) {
            $question->fill(['text' => $data['text']])->save();
            $question->options()->delete();
            $question->options()->createMany($data['options']);
        });

        return $question->load('options');
    }
}
