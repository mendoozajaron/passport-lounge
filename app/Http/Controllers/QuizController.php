<?php
namespace App\Http\Controllers;

use App\Mail\QuizResultMail;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\QuizLead;

class QuizController extends Controller
{
    // Public: questions and options only. Scoring types are never sent to the browser.
    public function index()
    {
        return Question::with('options:id,question_id,text')
            ->orderBy('position')->orderBy('id')->get(['id', 'text']);
    }

    public function result(Request $request)
    {
        $data = $request->validate($this->answerRules());

        return $this->resolveResult($data['answers']);
    }

    public function emailResult(Request $request)
    {
    $data = $request->validate($this->answerRules() + [
        'email' => 'required|email|max:150',
    ]);

    $result = $this->resolveResult($data['answers']);

    QuizLead::create(['email' => $data['email'], 'result_key' => $result['key']]);

    Mail::to($data['email'])->send(new QuizResultMail($result));

    return response()->json(array_merge($result, ['message' => 'Sent! Check your inbox.']));
    }

    private function answerRules(): array
    {
        return [
            'answers' => 'required|array|min:1|max:50',
            'answers.*' => 'integer|exists:question_options,id',
        ];
    }

    private function resolveResult(array $answerIds): array
    {
        $counts = QuestionOption::whereIn('id', $answerIds)->orderBy('id')->pluck('type')->countBy();
        $winner = $counts->sortDesc()->keys()->first();
        $total = $counts->sum();

        return array_merge(config("quiz.types.$winner"), [
            'key' => $winner,
            'match' => (int) round($counts[$winner] / $total * 100),
        ]);
    }
}