<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactTest extends TestCase
{
    // Na elke test database empty use trait RefreshDatabase
    use RefreshDatabase;

    public function test_contactSearch()
    {
        // Maak 5 fake 
        Contact::factory()->count(5)->create();
        // Make fake data
        $first = Contact::factory()->create(['first_name' => 'Name']);
        $second = Contact::factory()->create(['last_name' => 'Name']);
        $third = Contact::factory()->create(['email' => 'Name']);

        // Roep static method contactSearch aan
        $contacts = Contact::contactSearch("Name");
        //var_dump($contacts);
        // kijken of er 2 contacten in de lijst zitten
        $this->assertEquals($contacts->count(), 3);
        //De eerste is bekend
        $this->assertEquals($contacts->first()->id, $first->id);

        //De tweede zou ook nog getest kunnen worden
        $this->assertEquals($contacts->last()->id, $second->id);

        $this->assertEquals($contacts->third()->id, $third->id);
    }
}
