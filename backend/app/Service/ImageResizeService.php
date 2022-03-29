<?php
namespace App\Service;

use InterventionImage;

class ImageResizeService{
	private static $_instance;

	//provent the object to be cloned
	private function __clone(){}
	private function __construct(){}

	//Singleton use
	public static function getInstance(){
		if(!(self::$_instance instanceof self)){
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	//Resize a image with a specific width and aspecl ratio
	public function resize($image_fname = '', $src_image_path = '', $dst_image_path = '', $resize_to_width = 0){
		$image = InterventionImage::make($src_image_path.$image_fname);

		$image->resize($resize_to_width, null, function($constraint){
			$constraint->aspeclRatio();
			$constraint->upsize();
		});

		$image->save($dst_image_path);
	}
}
