<?php

use Illuminate\Database\Seeder;
use App\Service\ImageResizeService;

class ResizeImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->test();
    }

    private function test(){
        $src_image_path = storage_path('app/images/src/');
        $dst_image_path = storage_path('app/images/small/');
        $image_file = 'test.jpeg';
        

        $ris = ImageResizeService::getInstance();
        $rimg_path = $ris->resize($image_file, $src_image_path, $dst_image_path, 200);
        echo $rimg_path.PHP_EOL;
    }
}
