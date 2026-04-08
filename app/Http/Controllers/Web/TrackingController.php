<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Tracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;

class TrackingController extends Controller
{
    public function index(Request $request)
    {
        $trackings = Tracking::with('user')
            ->when($request->search, fn($q) => $q->where('vendor', 'like', "%{$request->search}%"))
            ->when($request->date_from, fn($q) => $q->whereDate('date', '>=', $request->date_from))
            ->when($request->date_to, fn($q) => $q->whereDate('date', '<=', $request->date_to))
            ->latest('date')
            ->paginate(10)
            ->withQueryString();

        return view('backend.pages.tracking.index', compact('trackings'));
    }

    public function create()
    {
        
        return view('backend.pages.tracking.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date'              => 'required|date',
            'vendor'            => 'required|string|max:150',
            'in_time'           => 'required',
            'out_time'          => 'nullable',
            'short_description' => 'nullable|string|max:500',
            // 'latitude'          => 'nullable|numeric|between:-90,90',
            // 'longitude'         => 'nullable|numeric|between:-180,180',
            // 'address'           => 'nullable|string|max:500',
        ]);

        // $data['user_id'] = Auth::id();
        // $data['status']  = 'in';

        // 🔥 Auto capture IP
        $ip = $request->ip();

        $tracking = new Tracking();
        $tracking->user_id = Auth::id();;
        $tracking->date = $request->date;
        $tracking->vendor = $request->vendor;
        $tracking->in_time = $request->in_time;
        $tracking->out_time = $request->out_time;
        $tracking->short_description = $request->short_description;
        $tracking->description = $request->description;
        $tracking->ip = $ip;

        if ( $ip == "127.0.0.1" ) {
            $ip = "122.173.87.53";
        }

        if ( $ip != "127.0.0.1" && strlen( $ip ) > 8) {

            $locationPosition = Location::get( $ip );
            $locationPosition = json_encode($locationPosition);
            $locationPosition = json_decode($locationPosition, 1);

            $tracking->areaCode = $locationPosition['areaCode'];
            $tracking->cityName = $locationPosition['cityName'];
            $tracking->countryCode = $locationPosition['countryCode'];
            $tracking->countryName = $locationPosition['countryName'];
            $tracking->ip = $locationPosition['ip'];
            $tracking->isoCode = $locationPosition['isoCode'];
            $tracking->latitude =  $request->latitude ?? $locationPosition['latitude'];
            $tracking->longitude = $request->longitude ?? $locationPosition['longitude'];
            $tracking->metroCode = $locationPosition['metroCode'];
            $tracking->postalCode = $locationPosition['postalCode'];
            $tracking->regionCode = $locationPosition['regionCode'];
            $tracking->regionName = $locationPosition['regionName'];
            $tracking->zipCode = $locationPosition['zipCode'];
            $tracking->address = $request->address ?? null;
        }


        $tracking->save();


        // Tracking::create($data);

        return redirect()->route('web.tracking.index')->with('success', 'Tracking entry created successfully.');
    }

    public function show(Tracking $tracking)
    {
        $tracking->load('user');
        return view('backend.pages.tracking.view', compact('tracking'));
    }

    public function edit(Tracking $tracking)
    {
        return view('backend.pages.tracking.form', compact('tracking'));
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
        ]);

        $tracking->update($data);

        return redirect()->route('web.tracking.index')->with('success', 'Tracking entry updated successfully.');
    }
}
