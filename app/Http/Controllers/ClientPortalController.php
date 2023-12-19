<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use ReCaptcha\ReCaptcha;
use App\Models\Client;

class ClientPortalController extends Controller
{
    public function showForm($token)
    {
        $client = Client::where('access_token', $token)->with('template')->firstOrFail();
        return Inertia::render('ClientPortal', [
            'client' => $client,
            'template_fields' => json_decode($client->template->fields)
        ]);
    }

    public function storeClientInfo(Request $request, $token)
    {
        //TODO replace it with reCaptcha
        if (!empty($request->input('hp_field'))) {
            return response()->json(['error' => 'Spam detected.'], 422);
        }

        $client = Client::where('access_token', $token)->firstOrFail();
        $templateFields = json_decode($client->template->fields);

        $rules = [];
        foreach ($templateFields as $field) {
            $rules[$field] = 'required'; // Placeholder, customize the validation rule for each field
            if ($field === 'email') {
                $rules[$field] = 'required|email';
            }

            if ($field === 'phone') {
                $rules[$field] = 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:8';
            }

            if ($field === 'document_file') {
                $rules[$field] = 'nullable|file|mimes:pdf|max:2048';
            }
        }

        $validatedData = $request->validate($rules);

        if ($request->hasFile('document_file')) {
            $documentPath = $request->file('document_file')->store('client_documents', 'public');
            $client->document_file = $documentPath;
        }

        if ($request->hasFile('driver_license_image')) {
            $licenseImagePath = $request->file('driver_license_image')->store('client_licenses', 'public');
            dd($licenseImagePath);
            $client->driver_license_image = $licenseImagePath;
        }

        foreach ($templateFields as $field) {
            if (isset($validatedData[$field]) && !$request->hasFile($field)) {
                $client->$field = $validatedData[$field];
            }
        }

        $client->save();

        // Remove the access token to prevent resubmission,
        // because of limited Mailtrap plan needed to leave like this
        //$client->access_token = null;
        $client->save();

        return redirect()->route('home')->with('success', 'Client information updated successfully.');
    }
}
