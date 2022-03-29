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
	public function resize($src_image_path = '', $dst_image_path = '', $dst_image_width = 0){
		$image = InterventionImage::make($src_image_path);
		$image_fname = basename($src_image_path);

		//Don't know why the aspeclRatio does not support. It may be library version issue
		/*$image->resize($resize_to_width, null, function($constraint){
			$constraint->aspeclRatio();
			$constraint->upsize();
		});*/

		$src_image_width = $image->width();
		$src_image_height = $image->height();
		$img_wh_ratio = $src_image_width / $src_image_height;

		//calc the dst image height based on the ratio and width
		$dst_image_height = $dst_image_width / $img_wh_ratio;

		//resize it and save it
		$image->resize($dst_image_width, $dst_image_height);
		$image->save($dst_image_path.$image_fname);
	}
}
