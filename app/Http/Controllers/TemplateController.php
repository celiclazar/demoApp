<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\Template;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = Template::all();

        return Inertia::render('Templates/Index', [
            'templates' => $templates,
        ]);
    }

    public function create()
    {
        return Inertia::render('Templates/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_name' => 'required|string',
            'selectedFields' => 'required|array',
        ]);

        $template = new Template();
        $template->name = $validated['template_name'];
        $template->fields = json_encode($validated['selectedFields']);
        $template->save();

        return redirect()->route('templates.index')->with('success', 'Template created successfully!');
    }

    public function update(Request $request, Template $template)
    {
        $data = json_decode($request->getContent(), true);
        $template->update([
            'name' => $data['name'],
            'fields' => json_encode($data['fields']),
        ]);

        return redirect()->route('templates.index')->with('success', 'Template updated successfully!');
    }

    public function destroy(Template $template)
    {
        $template->delete();

        return redirect()->route('templates.index')->with('success', 'Template deleted successfully!');
    }

    public function edit($id)
    {
        $template = Template::find($id);

        return Inertia::render('Templates/Edit', ['template' => $template]);
    }
}
