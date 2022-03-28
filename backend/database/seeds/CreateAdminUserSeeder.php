<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User as MemberModel;
use App\Models\Admin as AdminModel;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->createMember();
        //$this->createAdmin();
    }

    private function createMember(){
        $name = 'john';
        $email = 'john@qq.com';
        $password = '12345678';
        $lendable_qty = 100;
        $is_active = 1;

        $member = MemberModel::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'lendable_qty' => $lendable_qty,
            'is_active' => $is_active,
        ]);

        //var_dump($member);
    }

    private function createAdmin(){
        $name = 'admin';
        $email = 'admin@qq.com';
        $password = '87654321';

        $admin = AdminModel::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        //var_dump($admin);
    }
}
