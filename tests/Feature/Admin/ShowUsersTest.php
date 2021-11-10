<?php

namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_the_user_details()
    {
        $user = factory(User::class)->create([
            'name' => 'Jose',
        ]);

        $this->get('usuarios/' . $user->id)
            ->assertStatus(200)
            ->assertSee($user->name);
    }

    /** @test */
    public function it_displays_a_404_error_if_the_user_is_not_found()
    {
        $this->get('usuarios/999')
            ->assertStatus(404)
            ->assertSee('Página no encontrada');
    }

    /** @test */
    public function it_load_the_edit_user_page()
    {
        $user = factory(User::class)->create();

        $this->get('usuarios/' . $user->id . '/editar')
            ->assertStatus(200)
            ->assertViewIs('users.edit')
            ->assertSee('Editar usuario')
            ->assertViewHas('user', function($viewUser) use ($user){
                return $viewUser->id === $user->id;
            });
    }
}
