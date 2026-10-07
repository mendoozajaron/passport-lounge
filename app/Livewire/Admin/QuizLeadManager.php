<?php
namespace App\Livewire\Admin;

use App\Models\QuizLead;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class QuizLeadManager extends Component
{
    public function render()
    {
        return view('livewire.admin.quiz-lead-manager', [
            'leads' => QuizLead::latest()->get(),
            'types' => config('quiz.types'),
        ]);
    }
}