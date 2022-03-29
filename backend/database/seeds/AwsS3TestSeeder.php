<?php

use Illuminate\Database\Seeder;
use App\Service\AWSS3Service;

class AwsS3TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename = 'TMKKTF.jpg';
        $file = storage_path('app/public/images/').$filename;

        $aws3_url = AWSS3Service::getInstance()->uploadObject(md5($filename), $file);
        echo $aws3_url.PHP_EOL;
    }
}
