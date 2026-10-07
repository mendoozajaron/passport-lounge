<?php
namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    // Public: the contact form on the site. (The admin dashboard reads inquiries directly via Livewire.)
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+()\-\s]{7,20}$/'],
        ], [
            'phone.regex' => 'Enter a valid contact number, like 0917 123 4567.',
        ]);

        Inquiry::create($data);

        return response()->json(['message' => 'Thanks! We’ll be in touch.'], 201);
    }
}
