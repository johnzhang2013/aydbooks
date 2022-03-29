<?php
namespace App\Service;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class AWSS3Service{
	private static $_instance;
	private $aws3_instance = null;
	private $aws3_cfg = [];

	//provent the object to be cloned
	private function __clone(){}
	private function __construct(){
		$this->aws_cfg = config('aws');

		$this->aws3_instance = S3Client::factory([
			'version' => $this->aws_cfg['version'],
		    'region'  => $this->aws_cfg['region'],
		    'key'     => $this->aws_cfg['credentials']['key'],
	        'secret'  => $this->aws_cfg['credentials']['secret'],
		]);
	}

	//Singleton use
	public static function getInstance(){
		if(!(self::$_instance instanceof self)){
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	//upload an object
	public function uploadObject($file_identifier = '', $file_path = '', $bucket_name = ''){
		$upload_result = [
			'status' => false,
			'msg' => null,
			'data' => null
		];

		try{
			$f = fopen($file_path, 'r');

			$bn = empty($bucket_name) ? $this->aws_cfg['bucket'] : $bucket_name;
			$obj_data = [
				'Bucket' => $bn,
				'Key' => $file_identifier,
				'Body' => $f,
				//'ACL' => 'public-read'
			];

		    $obj = $this->aws3_instance->putObject($obj_data);

		    $obj_url = $obj->get('ObjectURL');

		    $upload_result['status'] = true;
		    $upload_result['data'] = [
		    	'obj_url' => $obj_url
		    ];		    
		} catch (S3Exception $e) {
		    $upload_result['msg'] = trans('aws3s.upload_expection');
		}

		return $upload_result;
	}
}
