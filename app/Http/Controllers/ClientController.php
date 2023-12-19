<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Mail\ClientAccessMail;
use App\Models\Client;
use App\Models\Template;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();

        return Inertia::render('Clients/Index', [
            'clients' => $clients,
        ]);
    }

    public function create()
    {
        $templates = Template::all();

        return Inertia::render('Clients/Create', [
            'templates' => $templates,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email',
            'selectedTemplate' => 'nullable|exists:templates,id',
        ]);

        $client = new Client();
        $client->company_name = $validated['client_name'];
        $client->email = $validated['client_email'];
        $client->access_token = Str::random(40);

        if (!empty($validated['selectedTemplate'])) {
            $client->template_id = $validated['selectedTemplate'];
        }

        $client->save();

        Mail::to($client->email)->send(new ClientAccessMail($client));

        return redirect()->route('clients.index')->with('success', 'Client created successfully!');
    }

    public function update(Request $request, Client $client)
    {
        //TODO need to fix this, probably on frontend
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email',
            'selectedTemplate' => 'nullable|exists:templates,id',
        ]);

        $client->update([
            'company_name' => $validated['client_name'],
            'email' => $validated['client_email'],
            'template_id' => $validated['selectedTemplate'] ?? null,
        ]);

        return redirect()->route('clients.index')->with('success', 'Client updated successfully!');

    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client deleted successfully!');
    }


}
