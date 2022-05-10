<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    // Methods voor Zoekopdracht
    public function index()
    {
        // Ophalen alle bedrijven uit model Company object
        $companies = Company::all();
        // Geef view companies.index met companies array
        return view('companies.index', compact('companies'));
    }

    // Voor maken van nieuw bedrijf
    public function create()
    {
        // Geef view companies.create voor het toevoegen van een nieuw bedrijf
        return view('companies.create');
    }

    // voor opslaan van nieuw bedrijf 
    public function store(Request $request)
    {
        // Request zitten alle waardes in
        $request->validate([
            'name' => 'required'
        ]);
        // Aanmaken van nieuw Company object 
        Company::create($request->all());
        // Terug gaan naar companies.index met een bericht voor pop-up
        return redirect()->route('companies.index')->with('success', 'bedrijf is toegevoegd');
    }

    // Laten zien bepaalde company 
    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }

    // Editen van bepaalde company
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    // Updaten van een bedrijf krijgt waardes binnen met Request en Company 
    public function update(Request $request, Company $company)
    {
        //dd($request);
        // Request zitten alle waardes in kijken of is ingevuld
        $request->validate([
            'name' => 'required'
        ]);
        // Updaten alles van company object
        $company->update($request->all());
        // Terug naar companies.index met message
        return redirect()->route('/companies')->with('succes', 'bedrijf is aangepast');
    }

    // Verwijderen van data
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect('/companies')->with('success', 'Bedrijf is verwijderd!');
    }
}
