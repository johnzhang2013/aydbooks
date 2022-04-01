<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tools\PDFMergeTool;

class PDFMergeController extends Controller
{
    private $pdf_tool = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */    
    public function __construct()
    {
        $this->pdf_tool = PDFMergeTool::getInstance();
    }

    public function merge(Request $request){
        $number = $request->number;

        $src_pdf_file = storage_path('app/test.pdf');
        $new_log_file = storage_path('app/ayd.png');

        $merge_result = $this->pdf_tool->merge($src_pdf_file, $new_log_file, $number);

        if($merge_result['status'] == true){
            //convert a relative url path
            $merge_result['data'] = str_replace(public_path(), '', $merge_result['data']);
            $merge_result['data']  = url($merge_result['data']);
        }

        return response()->json($merge_result);
    }
}
