<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarController extends Controller
{
    public function index()
    {
        return Inertia::render('Cars', [
            'cars' => Car::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'consumption' => 'required|numeric|min:0|max:20',
            'fuel_type' => 'required|in:e10,e5,diesel',
        ]);

        Car::create($request->only(['name', 'consumption', 'fuel_type']));

        return back();
    }

    public function update(Request $request, Car $car)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'consumption' => 'required|numeric|min:0|max:20',
            'fuel_type' => 'required|in:e10,e5,diesel',
        ]);

        $car->update($request->only(['name', 'consumption', 'fuel_type']));

        return back();
    }

    public function destroy(Car $car)
    {
        $car->delete();

        return back();
    }
}
