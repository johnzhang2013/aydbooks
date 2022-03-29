<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\AWSS3Service;

class UploadController extends CommonController
{
    public function uploadImage(Request $request) {
        $upload_result = [];
        $upload_result['status'] = false;
        $upload_result['code'] = 200;
        $upload_result['data'] = [];

        if(!($request->hasFile('uimage'))){
            $upload_result['code'] = 400;
            $upload_result['msg'] = trans('uploadimg.upload_failure');

            return response()->json($upload_result);
        }

        if(!($request->file('uimage')->isValid())){
            $upload_result['code'] = 401;
            $upload_result['msg'] = trans('uploadimg.upload_error');

            return response()->json($upload_result);
        }
        $uimage = $request->file('uimage');

        //step1 move this uploaded image to a path


        //step2 resize this image as we want
        //Todo use Intervention/image libiray to resize this image into large/medium/small images
        $image_path = $this->resizeImage($uimage->)

        //step3 save it to aws s3
        $aws3s_res = $this->uplaodToAwss3(md5($image_path), $image_path);
        if($aws3s_res['status'] == true){
            $upload_result['status'] = true;
            $upload_result['data']['img_url'] = $aws3s_res['data']['obj_url'];
        }else{
            $upload_result['code'] = 400;
            $upload_result['msg'] = $aws3s_res['msg'];
        }

        return response()->json($upload_result);
    }

    private function resizeImage($image_path = '', $image_size = ){


    }

    private function uplaodToAwss3($obj_key = '', $obj_fpath = ''){
        return AWSS3Service::getInstance()->uploadObject($obj_key, $obj_fpath);
    }
}
