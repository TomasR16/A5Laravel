<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    // Contructor method
    public function __construct()
    {
        // Must be logged in to see companies!
        $this->middleware('auth', ['except' => ['login', 'show']]);
    }
    // Methods voor Zoekopdracht
    public function index()
    {
        if (Auth::user()) {
            // Ophalen alle bedrijven uit model Company object
            $companies = Company::all();
            // Geef view companies.index met companies array
            return view('companies.index', compact('companies'));
        }
    }

    // Voor maken van nieuw bedrijf
    public function create()
    {
        if (Auth::user()) {
            // return view companies.create
            return view('companies.create');
        } else {
            // ophalen companies
            $companies = Company::all();
            // Stuur naar index
            return view('companies.index', compact('companies'));
        }
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
        // Check if user logged in
        if (Auth::user()) {
            // return view companies.edit
            return view('companies.edit', compact('company'));
        } else {
            // ophalen companies
            $companies = Company::all();
            // Stuur naar view companies.index
            return view('companies.index', compact('companies'));
        }
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
        return redirect()->route('companies.index')->with('succes', 'bedrijf is aangepast');
    }

    // Verwijderen van data
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect('/companies')->with('success', 'Bedrijf is verwijderd!');
    }
}
