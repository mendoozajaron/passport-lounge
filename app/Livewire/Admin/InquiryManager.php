<?php
namespace App\Livewire\Admin;

use App\Models\Inquiry;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class InquiryManager extends Component
{
    public function render()
    {
        return view('livewire.admin.inquiry-manager', [
            'inquiries' => Inquiry::latest()->get(),
        ]);
    }
}
