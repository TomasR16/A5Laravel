<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginView()
    {
        // Ophalen login rout
        $response = $this->get(route('login'));
        // Als dat goed gaat
        $response->assertSuccessful();
        // check of je op route auth.login.blade.php komt 
        $response->assertViewIs('auth.login');
        // Check og view login laat zien
        $response->assertSeeText('Login');
    }

    public function testCannotSeeLoginViewWhenLoggedIn()
    {
        // Maken test user die kan inlogen
        $user = User::factory()->create();
        // check of test user wordt doorgestuurd naar login 
        $response = $this->actingAs($user)->get(route('login'));
        // check of test user wordt geleid naar home route
        $response->assertRedirect(route('home'));
    }

    public function testUserLoggedIn()
    {
        // maken test user
        $user = User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel')
        ]);
        // user laten inloggen
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password,
        ]);

        // check of wordt doorverwezen naar home route
        $response->assertRedirect(route('home'));
        // check of je nog bent ingelogd
        $this->assertAuthenticatedAs($user);
    }

    public function testWrongUser()
    {
        // Maken test user
        $user = User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel')
        ]);
        // proberen inloggen met fout wachtwoord
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'secret',
        ]);
        // verwacht root van de app
        $response->assertRedirect('/');
        // user is niet authenticated
        $this->assertGuest(null);
    }
}
