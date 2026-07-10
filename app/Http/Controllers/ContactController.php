<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'phone'       => 'nullable|string|max:50',
            'message'     => 'required|string|max:2000',
            'property_id' => 'nullable|exists:properties,id',
        ]);

        ContactMessage::create($data);

        return back()->with('contact_success', 'Mensagem enviada com sucesso! Entraremos em contacto em breve.');
    }
}
