<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Psy\Util\Json;
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
        // Retrieve the client by access token
        $client = Client::where('access_token', $token)->firstOrFail();
        $templateFields = json_decode($client->template->fields);

        // Construct validation rules based on template fields
        $rules = [];
        foreach ($templateFields as $field) {
            $rules[$field] = 'required'; // Placeholder, customize the validation rule for each field
            if ($field === 'email') {
                $rules[$field] = 'required|email';
            }

            // Add custom validation for phone
            if ($field === 'phone') {
                $rules[$field] = 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:8';
            }
        }

        // Validate the request with the constructed rules
        $validatedData = $request->validate($rules);

        // Handle file uploads if present in the request
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

        return response()->json([
            'message' => 'Client information updated successfully.'
        ]);
    }
}
