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
        // Maak 5 fake contacten met static factory class
        Contact::factory()->count(5)->create();
        // Make fake data Contact 1 met first_name => name
        $first = Contact::factory()->create(['first_name' => 'Name']);
        // Contact 2 met last_name => name
        $second = Contact::factory()->create(['last_name' => 'Name']);

        // Roep static method contactSearch aan geef argument "Name" mee
        // Deze zoekt door alle $contacts voor "Name"
        $contacts = Contact::contactSearch("Name");
        //var_dump($contacts);
        // kijken of er 2 contacten in de lijst zitten
        $this->assertEquals($contacts->count(), 2);
        //De eerste is bekend
        $this->assertEquals($contacts->first()->id, $first->id);

        //De tweede zou ook nog getest kunnen worden
        $this->assertEquals($contacts->last()->id, $second->id);
    }
}
