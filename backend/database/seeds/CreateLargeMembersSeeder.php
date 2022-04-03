<?php

use Illuminate\Database\Seeder;

use Faker\Factory as FakerFactory;
use App\Service\MemberService;

class CreateLargeMembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $member_size = 1000;

        $this->buildMemberData($member_size);
    }

    private function buildMemberData($numbers = 0){
        $faker = FakerFactory::create();
        $i = 1;
        while($i <= $numbers){
            $m_email = $faker->email;
            $m_name = $faker->userName;
            $m_pwd = '12345678';
            $m_lqty = rand(1, 20);//the lendable_qty of a member
            $m_is_active = rand(0, 1);

            $member_data = [
                'name' => $m_name,
                'email' => $m_email,
                'password' => md5($m_pwd),
                'lendable_qty' => $m_lqty,
                'is_active' => $m_is_active
            ];

            $res = MemberService::getInstance()->register($member_data);
            if($res['status'] == true){
                echo 'Success to fake member['.$m_email.']['.$i.'/'.$numbers.']'.PHP_EOL;
            }else{
                echo 'Failure to fake member['.$m_email.']['.$i.'/'.$numbers.']'.PHP_EOL;
            }

            $i++;
        }
    }
}
