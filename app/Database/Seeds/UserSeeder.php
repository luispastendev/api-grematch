<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Get the User Provider (UserModel by default)
        $users = auth()->getProvider();

        // $user = new User([
        //     'username' => 'grepmatch',
        //     'email'    => 'luispasten.dev@gmail.com',
        //     'password' => 'secret',
        // ]);
        // $users->save($user);

        $model = model('UserModel');
        $user = $model->find(1);
        dd($users);

        // To get the complete user object with ID, we need to get from the database
        // $user = $users->findById($users->getInsertID());

        // Add to default group
        $users->addToDefaultGroup($user);
    }
}
