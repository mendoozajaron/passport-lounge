<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuizResultMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $result) {}

    public function build()
    {
        return $this->subject("You belong in {$this->result['name']} 🌍")
            ->view('emails.quiz-result')
            ->with(['result' => $this->result]);
    }
}