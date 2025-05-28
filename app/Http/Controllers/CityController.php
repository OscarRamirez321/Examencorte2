<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use Maatwebsite\Excel\Facades\Excel; // Add this line
use App\Exports\CitiesExport; // Add this line

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $cities = City::orderBy('name', 'asc')->paginate(6);
            return view('cities.index', compact('cities'));
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error al obtener las ciudades: ' . $e->getMessage());}
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try{
            return view('cities.create');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error al cargar el formulario de creación: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            City::create($request->all());
            return redirect()->route('cities.index')->with('success', 'Ciudad creada con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear la ciudad: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $city = City::findOrFail($id);
            return view('cities.show', compact('city'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al obtener la ciudad: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $city = City::findOrFail($id);
            return view('cities.edit', compact('city'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar el formulario de edición: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            $city = City::findOrFail($id);
            $city->update($request->all());
            return redirect()->route('cities.index')->with('success', 'Ciudad actualizada con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la ciudad: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $city = City::findOrFail($id);
            $city->delete();
            return redirect()->route('cities.index')->with('success', 'Ciudad eliminada con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar la ciudad: ' . $e->getMessage());
        }
    }
 public function exportXls()
    {
        return Excel::download(new CitiesExport, 'cities.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new CitiesExport, 'cities.csv');
    }
    
}
