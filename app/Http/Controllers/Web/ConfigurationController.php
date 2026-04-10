<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $configurations = Configuration::with('user')->paginate(15);

        return view('backend.pages.configurations.index', compact('configurations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.pages.configurations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([  
            'key' => 'required|string|max:50',
            'value' => 'nullable', 
        ]);

        Configuration::create($request->all());

        return redirect()->route('web.configurations.index')->with('success', 'Configuration created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Configuration $configuration): View
    {
        return view('backend.pages.configurations.show', compact('configuration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Configuration $configuration): View
    {
        return view('backend.pages.configurations.edit', compact('configuration'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Configuration $configuration): RedirectResponse
    {
        $request->validate([ 
            'key' => 'required|string|max:50',
            'value' => 'nullable', 
        ]);

        $configuration->update($request->all());

        return redirect()->route('web.configurations.index')->with('success', 'Configuration updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Configuration $configuration): RedirectResponse
    {
        $configuration->delete();

        return redirect()->route('web.configurations.index')->with('success', 'Configuration deleted successfully.');
    }
}
