<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SiteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        // Ophalen webserver
        $response = $this->get('/');
        // Check HTTP status code 
        $response->assertStatus(200);
    }

    public function testBasicSite()
    {
        // Check of laravel op login begint 

        $response = $this->get('/');
        $response->assertSeeText('Laravel');
        $response->assertSeeText('Log in');
    }

    public function testContactsNotLoggedIn()
    {
        // Ophalen route contacts.index verwacht login scherm
        $response = $this->get(route('contacts.index'));
        $response->assertSeeText('Redirecting to');
        $response->assertSeeText('login');
    }

    public function testLogin()
    {
        // Ophalen route van login
        $response = $this->get(route('login'));
        // Check of in response email en password zit
        $response->assertSeeText('Email');
        $response->assertSeeText('Password');
    }
}
