<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\AWSS3Service;
use App\Service\ImageResizeService;

class UploadController extends CommonController
{
    public function uploadImage(Request $request) {
        $upload_result = [];
        $upload_result['status'] = false;
        $upload_result['code'] = 200;
        $upload_result['data'] = [];
        $upload_result['msg'] = trans('uploadimg.upload_success');

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
        $src_image_path = $uimage->store('images'.DIRECTORY_SEPARATOR.'src');

        //step2 resize this image as we want
        //Todo use Intervention/image libiray to resize this image into 3 size(large/medium/small) images
        $resized_image_paths = $this->resizeImage($src_image_path);

        //step3 save it to aws s3
        $aws3s_objurls = [];
        $upload_result['data']['local_img_urls'] = [];
        $upload_result['data']['s3_img_urls'] = [];
        foreach($resized_image_paths as $_resized_level => $_resized_imgpath){
            $aws3s_res = $this->uplaodToAwss3(md5($_resized_imgpath), $_resized_imgpath);
            if($aws3s_res['status'] == true){
                $upload_result['status'] = true;

                $upload_result['data']['local_img_urls'][] = url(str_replace(storage_path('app'), '', $_resized_imgpath));
                $upload_result['data']['s3_img_urls'][] = $aws3s_res['data']['obj_url'];
            }else{
                //Todo more logic for error handle

                //$upload_result['code'] = 400;
                //$upload_result['msg'] = $aws3s_res['msg'];
            }
        }
        
        return response()->json($upload_result);
    }

    private function resizeImage($src_image_path = ''){
        //we set fixed definitions for the size_level here, you can modify it as you want or config it in other places
        $size_levels = [
            [
                'size_width' => 200,
                'dst_subpath' => 'small'
            ],

            [
                'size_width' => 700,
                'dst_subpath' => 'medium'
            ],

            [
                'size_width' => 1000,
                'dst_subpath' => 'large'
            ]
        ];

        $irs = ImageResizeService::getInstance();

        $src_image_path_abs = storage_path('app'.DIRECTORY_SEPARATOR).$src_image_path;
        $dst_image_path = storage_path('app'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR);

        $resized_image_paths = [];        
        foreach($size_levels as $_slevel){
            $rdst_image_path = $dst_image_path.$_slevel['dst_subpath'].DIRECTORY_SEPARATOR;

            $resized_image_paths[$_slevel['dst_subpath']] = $irs->resize($src_image_path_abs, $rdst_image_path, $_slevel['size_width']);
        }

        return $resized_image_paths;
    }

    private function uplaodToAwss3($obj_key = '', $obj_fpath = ''){
        return AWSS3Service::getInstance()->uploadObject($obj_key, $obj_fpath);
    }
}
