<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
  
class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = [
            [
               'name'=>'Admin User',
               'email'=>'admin@itsolutionstuff.com',
               'type'=>1,
               'password'=> bcrypt('12345678'),
               'postcode' => '12345', // Add postcode field
            ],
        
            [
               'name'=>'Customer',
               'email'=>'customer@itsolutionstuff.com',
               'type'=>0,
               'password'=> bcrypt('123456'),
               'postcode' => '54321', // Add postcode field
            ],
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
