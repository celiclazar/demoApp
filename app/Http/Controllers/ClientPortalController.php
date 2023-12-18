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
        }

        $validatedData = $request->validate($rules);
        foreach ($templateFields as $field) {
            if ($request->hasFile($field)) {
                $validatedData[$field] = $request->file($field)->store('uploads', 'public');
            } elseif (isset($validatedData[$field])) {
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
