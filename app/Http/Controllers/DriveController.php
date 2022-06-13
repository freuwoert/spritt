<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Drive;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DriveController extends Controller
{
    public function index()
    {
        return Inertia::render('Drives', [
            'drives' => Drive::with(['car', 'passengers'])->orderBy('started_at')->get(),
            'passengers' => Passenger::orderBy('name')->get(),
            'cars' => Car::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'distance' => 'required|numeric',
            'passengers' => 'required|array|min:1|distinct',
            'passengers.*' => 'required|exists:passengers,id',
        ]);

        $drive = Drive::create([
            'car_id' => $request->car_id,
            'distance' => $request->distance,
            'started_at' => now(),
            'paid' => false,
        ]);
        
        $drive->passengers()->attach($request->passengers);

        return back();
    }

    public function update(Request $request, Drive $drive)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'distance' => 'required|numeric',
            'passengers' => 'required|array|min:1|distinct',
            'passengers.*' => 'required|exists:passengers,id',
        ]);

        $drive->update([
            'car_id' => $request->car_id,
            'distance' => $request->distance,
        ]);

        $drive->passengers()->sync($request->passengers);

        return back();
    }

    public function destroy(Drive $drive)
    {
        $drive->delete();

        return back();
    }
}
