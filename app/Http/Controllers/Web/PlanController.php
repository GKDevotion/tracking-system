<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $plans = Plan::when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->orderBy('sort_order')
            ->paginate(10)
            ->withQueryString();

        return view('backend.pages.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.plans.form', ['plan' => new Plan()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'description' => 'required|string',
            'features' => 'required|string',
            'cta' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'is_highlighted' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $data['features'] = array_map('trim', explode("\n", $data['features']));

        Plan::create($data);

        return redirect()->route('web.plans.index')->with('success', 'Plan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        return view('backend.pages.plans.form', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'description' => 'required|string',
            'features' => 'required|string',
            'cta' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'is_highlighted' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        if( !isset( $request->is_highlighted ) && $request->is_highlighted !=1 ){
            $data['is_highlighted'] = 0;
        }

        $data['features'] = array_map('trim', explode("\n", $data['features']));
        // dd($data);
    
        $plan->update($data);

        return redirect()->route('web.plans.index')->with('success', 'Plan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();

        return redirect()->route('web.plans.index')->with('success', 'Plan deleted successfully.');
    }
}
