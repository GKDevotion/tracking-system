<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ForexUpdate; 
use Illuminate\Http\Request;

class ForexUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $plans = ForexUpdate::when($request->search, fn($q) => $q->where('take_profit', 'like', "%{$request->search}%"))
            ->orderBy('sort_order')
            ->paginate(10)
            ->withQueryString();

        return view('backend.pages.forex-update.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.forex-update.form', ['plan' => new ForexUpdate()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'signal_date' => 'required',
            'pair' => 'required', 
            'order_type' => 'required|integer', 
            'entry_price' => 'required|numeric',
            'stop_loss' => 'required|numeric',
            'take_profit' => 'required|numeric', 
            'profit'    =>  'required|numeric',
            'take_profit'   =>  'required',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:0,1',
            
        ]); 

        ForexUpdate::create($data);

        return redirect()->route('web.forex-update.index')->with('success', 'Forex Update created successfully.');
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
    public function edit(ForexUpdate $plan , $id)
    {
        $plan = ForexUpdate::findOrFail($id);
        return view('backend.pages.forex-update.form', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $plan = ForexUpdate::findOrFail($id);

        $data = $request->validate([
            'signal_date' => 'required',
            'pair' => 'required',
            'order_type' => 'required',
            'entry_price' => 'required|numeric',
            'stop_loss' => 'required|numeric',
            'take_profit' => 'required|numeric',
            'profit' => 'required|numeric',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:0,1',
        ]);

        $plan->update($data);

        return redirect()->route('web.forex-update.index')->with('success', 'Forex Data updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $plan = ForexUpdate::findOrFail($id);

        $plan->delete();

        return redirect()->route('web.forex-update.index')->with('success', 'Forex Update deleted successfully.');
    }
}
