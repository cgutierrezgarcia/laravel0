<?php

namespace Tests\Feature\Admin;

use App\Profession;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUsersTest extends TestCase
{
    use RefreshDatabase;

    public function getValidData(array $custom = [])
    {
        return array_merge([
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
            'password' => '123456',
            'profession_id' => '',
            'bio' => 'Programador de Laravel y Vue.js',
            'twitter' => 'https://twitter.com/pepe',
            'role' => 'user',
        ], $custom);
    }

    /** @test */
    public function it_updates_a_user()
    {
        $user = factory(User::class)->create();

        $this->put('usuarios/' . $user->id, $this->getValidData())
            ->assertRedirect('usuarios/' . $user->id);

        $this->assertCredentials([
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
            'password' => '123456',
        ]);
    }

    /** @test */
    public function the_name_is_required()
    {
        $user = factory(User::class)->create();

        $this->from('usuarios/' . $user->id . '/editar')
            ->put('usuarios/' . $user->id, $this->getValidData([
                'name' => ''
            ]))->assertRedirect('usuarios/' . $user->id . '/editar')
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('users', ['email' => 'pepe@mail.es']);
    }

    /** @test */
    public function the_email_is_required()
    {
        $user = factory(User::class)->create();

        $this->from('usuarios/' . $user->id . '/editar')
            ->put('usuarios/' . $user->id, $this->getValidData([
                'email' => ''
            ]))->assertRedirect('usuarios/' . $user->id . '/editar');

        $this->assertDatabaseMissing('users', ['name' => 'Pepe']);
    }

    /** @test */
    public function the_email_must_be_valid()
    {
        $user = factory(User::class)->create();

        $this->from('usuarios/' . $user->id . '/editar')
            ->put('usuarios/' . $user->id, $this->getValidData([
                'email' => 'correo-no-valido'
            ]))->assertRedirect('usuarios/' . $user->id . '/editar')
            ->assertSessionHasErrors('email');

        $this->assertDatabaseMissing('users', ['name' => 'Pepe']);
    }

    /** @test */
    public function the_email_must_be_unique()
    {
//        self::markTestIncomplete();
//        return;
        factory(User::class)->create([
            'email' => 'existing_email@mail.es',
        ]);

        $user = factory(User::class)->create([
            'email' => 'pepe@mail.es',
        ]);

        $this->from('usuarios/' . $user->id . '/editar')
            ->put('usuarios/' . $user->id, $this->getValidData([
                'email' => 'existing_email@mail.es'
            ]))->assertRedirect('usuarios/' . $user->id . '/editar')
            ->assertSessionHasErrors('email');

        $this->assertDatabaseMissing('users', ['name' => 'Pepe']);
    }

    /** @test */
    public function the_password_is_optional()
    {
        // Self::markTestIncomplete();

        $oldPassword = 'CLAVE_ANTERIOR';

        $user = factory(User::class)->create([
            'password' => bcrypt($oldPassword),
        ]);

        $this->from('usuarios/' . $user->id . '/editar')
            ->put('usuarios/' . $user->id, $this->getValidData([
                'password' => ''
            ]))->assertRedirect('usuarios/' . $user->id);

        $this->assertCredentials([
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
            'password' => $oldPassword,
        ]);
    }

    /** @test */
    public function the_user_email_can_stay_the_same()
    {
        $user = factory(User::class)->create([
            'email' => 'pepe@mail.es',
        ]);

        $this->from('usuarios/' . $user->id . '/editar')
            ->put('usuarios/' . $user->id, $this->getValidData())
            ->assertRedirect('usuarios/' . $user->id);

        $this->assertDatabaseHas('users', [
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
        ]);
    }

    /** @test */
    public function only_not_deleted_can_be_selected()
    {
        $deletedProfession = factory(Profession::class)->create([
            'deleted_at' => now()->format('Y-m-d')
        ]);

        $this->from('usuarios/crear')
            ->post('usuarios', $this->getValidData([
                'profession_id' => $deletedProfession->id
            ]))->assertRedirect('usuarios/crear')
            ->assertSessionHasErrors(['profession_id']);

        $this->assertDatabaseEmpty('users');
    }
}
