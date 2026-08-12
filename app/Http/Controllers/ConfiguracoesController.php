<?php

namespace App\Http\Controllers;

use App\Models\PageSection;
use Illuminate\Http\Request;

class ConfiguracoesController extends Controller
{
    public function index()
    {
        $settings = PageSection::getForPage('settings');

        return view('admin.configuracoes.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'company_name'   => 'nullable|string|max:255',
            'phone'          => 'nullable|string|max:100',
            'email'          => 'nullable|email|max:255',
            'address'        => 'nullable|string|max:255',
            'whatsapp'       => 'nullable|string|max:100',
            'website_url'    => 'nullable|string|max:255',
            'facebook'       => 'nullable|string|max:255',
            'instagram'      => 'nullable|string|max:255',
            'linkedin'       => 'nullable|string|max:255',
            'youtube'        => 'nullable|string|max:255',
            'default_seo_desc' => 'nullable|string',
            'default_seo_keys' => 'nullable|string',
        ]);

        foreach ($data as $field => $value) {
            PageSection::updateOrCreate(
                ['page' => 'settings', 'section' => 'global', 'field' => $field],
                ['value' => $value ?? '']
            );
        }

        // Upload custom logo if provided
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('settings', 'public');
            PageSection::updateOrCreate(
                ['page' => 'settings', 'section' => 'global', 'field' => 'logo'],
                ['value' => $path]
            );
        }

        return back()->with('success', 'Configurações globais actualizadas com sucesso!');
    }
}
