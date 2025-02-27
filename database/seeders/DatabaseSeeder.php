<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    

    public function run()
    {
        // Manually create the first user as an admin
        User::create([
            'email' => 'admin@gmail.com',
            'is_admin' => true, 
            'password' => bcrypt('password'), 
        ]);
    
        // Now create the other users using the factory
        User::factory()->count(9)->create(); 

        $this->call([
            AccountsSeeder::class,
            TransactionSeeder::class,
        ]);
    }
    
}
