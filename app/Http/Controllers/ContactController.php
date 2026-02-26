<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'banda' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'informacion' => 'required|string|max:2000',
        ]);

        try {
            Mail::to('pableras172@gmail.com')->send(
                new ContactForm(
                    $validated['nombre'],
                    $validated['banda'],
                    $validated['telefono'] ?? null,
                    $validated['email'],
                    $validated['informacion']
                )
            );

            return redirect()->back()->with('success', '¡Mensaje enviado correctamente! Nos pondremos en contacto contigo pronto.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ha ocurrido un error al enviar el mensaje. Por favor, inténtalo de nuevo más tarde.')->withInput();
        }
    }
}
