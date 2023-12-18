<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ReCaptcha\ReCaptcha;

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
        if (!empty($request->input('hp_field'))) {
            // Simply ignore the request or return an error response
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

        // Handle the PDF document upload
        if ($request->hasFile('document_file')) {
            $documentPath = $request->file('document_file')->store('client_documents', 'public');
            $client->document_file = $documentPath;
        }

        // Handle the driver's license image upload
        if ($request->hasFile('driver_license_image')) {
            $licenseImagePath = $request->file('driver_license_image')->store('client_licenses', 'public');
            $client->driver_license_image = $licenseImagePath;
        }

        // Update other fields
        foreach ($templateFields as $field) {
            if (isset($validatedData[$field]) && !$request->hasFile($field)) {
                $client->$field = $validatedData[$field];
            }
        }

        $client->save();

        // Remove the access token to prevent resubmission
        //$client->access_token = null;
        $client->save();

        return redirect()->route('home')->with('success', 'Client information updated successfully.');
    }
}
