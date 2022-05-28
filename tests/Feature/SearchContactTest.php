<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Contact;
use App\Models\Company;

class SearchContactTest extends TestCase
{
    use RefreshDatabase;

    public function testContactView()
    {
        // maken test user
        $user = User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel')
        ]);
        // ga naar route contacts\index.blade.php
        $response = $this->actingAs($user)->get(route('contacts.index'));
        // check success
        $response->assertSuccessful();
        // checken of view contacts.index.blade.php is 
        $response->assertViewIs('contacts.index');
        // kijken of er in de view het woord Contacten staan
        $response->assertSeeText('Contacten');
    }

    public function testSearchContactViewAll()
    {
        // maken test user
        $user = User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel')
        ]);
        // maken 5 test users 
        Contact::factory()->count(5)->create();
        // bewaren first name van eerste contact
        $randomName = Contact::all()->first()->first_name;
        // test contact met first_name => hhh
        $first = Contact::factory()->create(['first_name' => 'hhh']);
        // test contact met last_name => kkk
        $second = Contact::factory()->create(['last_name' => 'kkk']);
        // ophalen route contacts.index
        $response = $this->actingAs($user)->get(route('contacts.index'));
        // kijken of deze texten op pagina voorkomen 
        $response->assertSeeText('Contacten');
        $response->assertSeeText('hhh');
        $response->assertSeeText('kkk');
        $response->assertSeeText($randomName);
    }

    public function testSearchContactView()
    {
        // aanmaken test user
        $user = User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel')
        ]);
        // aanmaken 2 test bedrijven
        Company::factory()->count(2)->create();
        // opslaan eerste id
        $company_id = Company::all()->first()->id;
        // aanmaken 5 test contacten geef deze een company_id
        Contact::factory()->count(5)->create(["company_id" => $company_id]);
        // opslaan eerste naam uit first_name
        $randomName = Contact::all()->first()->first_name;
        // maken test user met first_name => hhh en een company_id
        $first = Contact::factory()
            ->create(['first_name' => 'hhh', "company_id" => $company_id]);
        // maken test user met last_name => hhh en een company_id
        $second = Contact::factory()
            ->create(['last_name' => 'hhh', "company_id" => $company_id]);
        // ophalen route contacts.index route met zoekwoord hhh voor zoekfunctie
        $response = $this->actingAs($user)->get(route('contacts.index') . '?keyword=hhh');
        // verwachten deze text
        $response->assertSeeText('Contacten');
        $response->assertSeeText('hhh');
        // verwachen niet deze text in view
        $response->assertDontSeeText($randomName);
    }
}
