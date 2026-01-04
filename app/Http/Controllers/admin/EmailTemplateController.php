<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EmailTemplateController extends Controller
{
    // Show all templates
    public function index()
    {
        $templates = EmailTemplate::latest()->get();
        return view('admin.email_templates.index', compact('templates'));
    }

    // Show form for creating
    public function create()
    {
        return view('admin.email_templates.create');
    }

    // Store new template
   public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'type'    => 'required|string|max:255|unique:email_templates,type',
        'subject' => 'required|string|max:255',
        'body'    => 'required|string',
        'status'  => 'required|boolean',
    ]);

    if ($validator->fails()) {
        return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Generate slug from type
    $slug = Str::slug($request->type, '_');

    // Extra safety: ensure slug uniqueness
    if (EmailTemplate::where('slug', $slug)->exists()) {
        return redirect()
            ->back()
            ->withErrors(['type' => 'An email template with a similar name already exists.'])
            ->withInput();
    }

    EmailTemplate::create([
        'type'    => $request->type,
        'slug'    => $slug,
        'subject' => $request->subject,
        'body'    => $request->body,
        'status'  => $request->status,
    ]);

    return redirect()
        ->route('admin.email_templates.index')
        ->with('success', 'Email template created successfully!');
}


    // Show edit form
    public function edit($id)
    {
        $template = EmailTemplate::findOrFail($id);
        return view('admin.email_templates.edit', compact('template'));
    }

    // Update template
    public function update(Request $request, $id)
    {
        $template = EmailTemplate::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:255|unique:email_templates,type,' . $template->id,
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $template->update($request->only('type', 'subject', 'body', 'status'));
        return redirect()->route('admin.email_templates.index')->with('success', 'Email template updated successfully!');
    }

    // Delete
    public function destroy($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $template->delete();
        return redirect()->back()->with('success', 'Email template deleted successfully!');
    }
}
