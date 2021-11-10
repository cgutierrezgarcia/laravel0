<?php

//use App\Profession;
//use App\User;
use App\{Profession, User};
use Illuminate\Database\Seeder;
//use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $professionId = Profession::whereTitle('Desarrollador Back-End')->value('id');

        /*
        $professionId = DB::table('professions')
            // ->where('title', 'Desarrollador Back-End')
            ->whereTitle('Desarrollador Back-End')
            ->value('id');
            // ->select('id')
            // ->first();
        */
        // dd($professionId);
//        DB::table('users')->insert([
//            'name' => 'Pepe Pérez',
//            'email' => 'pepe@mail.es',
//            'password' => bcrypt('123456'),
//            // 'profession_id' => $profession->id,
//            'profession_id' => DB::table('professions')->whereTitle('Desarrollador Back-End')->value('id')
//        ]);
        // DB::insert('INSERT INTO users VALUES ()');
        $user = User::create([
            'name' => 'Pepe Pérez',
            'email' => 'pepe@mail.es',
            'password' => bcrypt('123456'),
            'role' => 'admin'
        ]);

        $user->profile()->create([
            'bio' => 'Programador',
            'profession_id' => $professionId,
        ]);

//        User::create([
//            'name' => 'Juan Martinez',
//            'email' => 'juan@mail.es',
//            'password' => bcrypt('123456'),
//            'profession_id' => Profession::whereTitle('Desarrollador Back-End')->value('id')
//        ]);
//
//        User::create([
//            'name' => 'Jaime Sánchez',
//            'email' => 'jaime@mail.es',
//            'password' => bcrypt('123456'),
//            'profession_id' => null
//        ]);

//        factory(User::class)->create([
//            'profession_id' => Profession::whereTitle('Desarrollador Back-End')->value('id'),
//        ]);

        factory(User::class, 49)->create()->each(function ($user) {
            $user->profile()->create(
                factory(App\UserProfile::class)->raw()
            );
        });
    }
}
