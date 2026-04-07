<?php

namespace App\Http\Controllers\API;

use App\Models\Tracking;
use Illuminate\Http\Request;

class TrackingController extends BaseApiController
{
    public function index(Request $request)
    {
        $trackings = Tracking::with('user')
            ->when($request->search, fn($q) => $q->where('vendor', 'like', "%{$request->search}%"))
            ->when($request->date_from, fn($q) => $q->whereDate('date', '>=', $request->date_from))
            ->when($request->date_to, fn($q) => $q->whereDate('date', '<=', $request->date_to))
            ->latest('date')
            ->paginate(10);

        return $this->paginated('Trackings retrieved.', $trackings);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date'              => 'required|date',
            'vendor'            => 'required|string|max:150',
            'in_time'           => 'required',
            'out_time'          => 'nullable',
            'short_description' => 'nullable|string|max:500',
            'latitude'          => 'nullable|numeric|between:-90,90',
            'longitude'         => 'nullable|numeric|between:-180,180',
            'address'           => 'nullable|string|max:500',
        ]);

        $data['user_id'] = $request->user()->id;
        $data['status']  = 'in';

        $tracking = Tracking::create($data);

        return $this->success('Tracking created.', $tracking->load('user'), 201);
    }

    public function show(Tracking $tracking)
    {
        return $this->success('Tracking retrieved.', $tracking->load('user'));
    }

    public function update(Request $request, Tracking $tracking)
    {
        $data = $request->validate([
            'date'              => 'required|date',
            'vendor'            => 'required|string|max:150',
            'in_time'           => 'required',
            'out_time'          => 'nullable',
            'short_description' => 'nullable|string|max:500',
            'latitude'          => 'nullable|numeric|between:-90,90',
            'longitude'         => 'nullable|numeric|between:-180,180',
            'address'           => 'nullable|string|max:500',
            'status'            => 'in:in,out',
        ]);

        $tracking->update($data);

        return $this->success('Tracking updated.', $tracking->load('user'));
    }
}
