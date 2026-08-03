<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Client;

class ServicesController extends Controller
{
    public function index()
    {
        return Service::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $service = Service::create($request->only('name'));

        return response()->json($service, 201);
    }

    public function show($id)
    {
        $service = Service::with('clients')->findOrFail($id);
        return response()->json($service);
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);

        $service->update($validatedData);

        return response()->json($service);
    }

    public function add_service_to_client(Request $request, $service_id, $client_id)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $service = Service::findOrFail($service_id);
        Client::findOrFail($client_id);
        $service->clients()->syncWithoutDetaching([$client_id => ['price' => $request->price]]);

        $client = $service->clients()->where('clients.id', $client_id)->first();

        return response()->json($client, 200);
    }

    public function remove_service_from_client($service_id, $client_id)
    {
        $service = Service::findOrFail($service_id);
        $service->clients()->detach($client_id);

        return response()->json(['message' => 'Client removed from service successfully.'], 200);
    }
}
