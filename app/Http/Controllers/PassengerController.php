<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PassengerController extends Controller
{
    public function index()
    {
        return Inertia::render('Passengers', [
            'passengers' => Passenger::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Passenger::create($request->only(['name']));

        return back();
    }

    public function update(Request $request, Passenger $passenger)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $passenger->update($request->only(['name']));

        return back();
    }

    public function destroy(Passenger $passenger)
    {
        $passenger->delete();

        return back();
    }
}
