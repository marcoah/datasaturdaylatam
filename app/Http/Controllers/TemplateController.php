<?php

namespace App\Http\Controllers;

use App\Mail\Agradecimiento;
use App\Mail\Basico;
use App\Mail\Bienvenida;
use App\Mail\Recordatorio;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $templates = Template::All();
        return view('templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Template $template)
    {
        $user = Auth::user();

        if (!$template->mailable_class) {
            abort(404, 'Template no tiene mailable asociado');
        }

        $mailableClass = "App\\Mail\\{$template->mailable_class}";

        if (!class_exists($mailableClass)) {
            abort(500, 'Mailable no existe');
        }

        return new $mailableClass($user, $template);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Template $template)
    {
        //
        return view('templates.edit', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Template $template)
    {
        //
        $request->validate([
            'title' => 'required'
        ]);

        $input = $request->all();

        if ($request->has('has_cta')) {
            $input['has_cta'] = 1;
            $input['button_text'] = $request->button_text;
            $input['button_link'] = $request->button_link;
        } else {
            $input['has_cta'] = 0;
            $input['button_text'] = '';
            $input['button_link'] = '';
        }

        $template->update($input);

        return redirect()->route('templates.index')->with('success', trans('Template succesfully edited.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template $template)
    {
        //
    }
}
