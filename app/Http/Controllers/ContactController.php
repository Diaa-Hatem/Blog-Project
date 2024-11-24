<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:Contacts,email',
            'subject' => 'required',
            'message' => 'required',
            
        ]);

        Contact::create($data);

        return back();
    }
}
