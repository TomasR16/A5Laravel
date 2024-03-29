<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    // Contructor method 
    public function __construct()
    {
        // Must be logged in to see contacts!
        $this->middleware('auth', ['except' => ['login', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Wijst naar index.blade.php
    public function index(Request $request)
    {
        // ophalen $keyword uit Request object
        $keyword = $request->keyword;
        // Als $keyword gevuld is
        if (isset($keyword)) {
            // Roep Contact object static method aan en zoek voor $keyword
            $contacts = Contact::contactSearch($keyword);
        } else {
            // Haal alle Contacten
            $contacts = Contact::all();
        }
        //Send contacts to view contacts.index.blade.php
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Als je contacts.create aanroept in search
    public function create()
    {
        // Checken of user is ingelogd
        if (Auth::user()) {
            // Pak alle namen van het Company object op alfabetische volgorde
            // En pluck method voor het filteren van data uit array 
            $companies = Company::orderby('name', 'desc')->pluck('name', 'id');
            //Return View contacts.create.blade.php
            return view('contacts.create', compact('companies'));
        }
        // Ophalen alle contacten uit Contact Object
        $contacts = Contact::all();
        // Terug sturen naar contacts.index
        return redirect()->route('contacts.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // Als user op OK klikt in create.blade.php
    public function store(Request $request)
    {
        //Kijken of deze 3 velden ingevuld zijn 
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'company_id' => 'required'
        ]);
        // Contact object roept static method aan die stuurt alle gegevens naar database
        //send user input to Contact::create method pass $request->all
        Contact::create($request->all());
        // Go Back to contacts.index with message
        return redirect()->route('contacts.index')->with('success', 'Contact is bewaard!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Laat specifiek user zien zoals contacts/3
    public function show(Contact $contact)
    {
        // return view contacts.show.blade.php met contact
        return view('contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Als je contacts/2/edit aanroept in search
    public function edit(Contact $contact)
    {

        if (Auth::user()) {
            // Ophalen companies uit Company object
            $companies = Company::pluck('name', 'id');

            // return view contacts.edit.blade.php met contact array
            return view('contacts.edit', compact('contact', 'companies'));
        }

        $contacts = Contact::all();
        return redirect()->route('contacts.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //na edit komt update. valideren velden 
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'company_id' => 'required'
        ]);
        //updaten object geef alle velden mee
        $contact->update($request->all());
        //return view contacts met message
        return redirect('/contacts')->with('success', 'Contact is aangepast');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        //DELETE van $contact
        $contact->delete();
        return redirect('/contacts')->with('success', 'Contact is verwijderd');
    }
}
