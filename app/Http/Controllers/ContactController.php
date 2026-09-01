<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'phone'       => 'nullable|string|max:50',
            'message'     => 'required|string|max:2000',
            'property_id' => 'nullable|exists:properties,id',
        ];

        $secret = config('services.recaptcha.secret_key');
        if ($secret) {
            $token = $request->input('g-recaptcha-response');

            if ($token) {
                try {
                    $response = Http::asForm()->timeout(5)->post('https://www.google.com/recaptcha/api/siteverify', [
                        'secret'   => $secret,
                        'response' => $token,
                        'remoteip' => $request->ip(),
                    ]);

                    $result = $response->json();

                    // Se em produção falhar a verificação
                    if (!empty($result) && !($result['success'] ?? false) && !app()->environment('local')) {
                        return back()->withErrors(['g-recaptcha-response' => 'Falha na verificação de segurança. Por favor, tente novamente.'])->withInput();
                    }
                } catch (\Exception $e) {
                    Log::warning('reCAPTCHA verification error: ' . $e->getMessage());
                }
            }
        }

        $data = $request->validate($rules);

        ContactMessage::create($data);

        return back()->with('contact_success', 'Mensagem enviada com sucesso! Entraremos em contacto em breve.');
    }
}
