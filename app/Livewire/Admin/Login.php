<?php
namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public string $error = '';

    public function login()
    {
        $this->error = '';
        $data = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::attempt($data)) {
            $this->error = 'Wrong email or password.';
            return;
        }

        request()->session()->regenerate();

        return redirect()->route('admin.questions');
    }

    public function render()
    {
        return view('livewire.admin.login');
    }
}
