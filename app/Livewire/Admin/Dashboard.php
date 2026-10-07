<?php
namespace App\Livewire\Admin;

use App\Models\Inquiry;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public string $tab = 'questions';

    public ?int $editingId = null;
    public string $text = '';
    public array $options = [];

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingId = null;
        $this->text = '';
        $firstType = array_key_first(config('quiz.types'));
        $this->options = [
            ['text' => '', 'type' => $firstType],
            ['text' => '', 'type' => $firstType],
        ];
        $this->resetErrorBag();
    }

    public function addOption()
    {
        if (count($this->options) >= 6) return;
        $this->options[] = ['text' => '', 'type' => array_key_first(config('quiz.types'))];
    }

    public function removeOption(int $i)
    {
        if (count($this->options) <= 2) return;
        unset($this->options[$i]);
        $this->options = array_values($this->options);
    }

    public function edit(int $id)
    {
        $question = Question::with('options')->findOrFail($id);
        $this->editingId = $question->id;
        $this->text = $question->text;
        $this->options = $question->options->map(fn ($o) => ['text' => $o->text, 'type' => $o->type])->toArray();
        $this->resetErrorBag();
    }

    public function save()
    {
        $data = $this->validate([
            'text' => 'required|string|max:255',
            'options' => 'required|array|min:2|max:6',
            'options.*.text' => 'required|string|max:120',
            'options.*.type' => 'required|in:' . implode(',', array_keys(config('quiz.types'))),
        ]);

        $question = $this->editingId
            ? Question::findOrFail($this->editingId)
            : new Question(['position' => (Question::max('position') ?? 0) + 1]);

        $question->fill(['text' => $data['text']])->save();
        $question->options()->delete();
        $question->options()->createMany($data['options']);

        $this->resetForm();
    }

    public function delete(int $id)
    {
        Question::findOrFail($id)->delete(); // options cascade
    }

    public function switchTab()
    {
        $this->tab = $this->tab === 'questions' ? 'inquiries' : 'questions';
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function render()
    {
        return view('livewire.admin.dashboard', [
            'questions' => Question::with('options')->orderBy('position')->orderBy('id')->get(),
            'inquiries' => Inquiry::latest()->get(),
            'types' => config('quiz.types'),
        ]);
    }
}
