<?php
namespace App\Tools;

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;

use Picqer\Barcode\BarcodeGeneratorPNG;

class PDFMergeTool{
	private static $_instance;
	private $pdf = null;

	//provent the object to be cloned
	private function __clone(){}
	public function __construct(){
		$this->pdf = new Fpdi(); 
	}
	//Singleton use
	public static function getInstance(){
		if(!(self::$_instance instanceof self)){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
    public function merge($pdf_src_file = '', $new_logo_file = '', $number = ''){
        $merge_result = [];
        $merge_result['status'] = true;
        $merge_result['code'] = 200;
        $merge_result['msg'] = null;
        $merge_result['data'] = null;

        try{
            $pdf_dst_file  = public_path().'/'.md5(date('YmdHis').rand()).".pdf";

            $this->pdf->setSourceFile($pdf_src_file);

            $pdf_tplID = $this->pdf->importPage(1);
            $pdf_size = $this->pdf->getTemplateSize($pdf_tplID);

            $pdf_width = $pdf_size['width'];
            $pdf_height = $pdf_size['height'];

            $this->pdf->AddPage($pdf_size['orientation'], [$pdf_width, $pdf_height]);
            $this->pdf->useTemplate($pdf_tplID);
            $this->pdf->SetFont('Helvetica');

            //Step1 - Remove the original logo of source pdf file
            $this->pdf->SetFillColor(255, 255, 255);//set the fill color as white for the rectangle
            $this->pdf->Rect(20, 20, 50, 45, 'F');

            //Step2 - Insert a new logo
            $this->pdf->Image($new_logo_file, 20, 20, 50, 45);

            //Step3 - Generate a barcode based on the number
            $tmp_barcode_imginfo = $this->makeBarcodeImg($number);
            if($tmp_barcode_imginfo === null){//failed to generate
                $merge_result['status'] = false;
                $merge_result['code'] = 8888;

                $merge_result['msg'] = trans('pdfmerge.failure_generate_barcode');

                return $merge_result;
            }

            $tmp_barcode_w = $tmp_barcode_imginfo['width'];
            $tmp_barcode_h = $tmp_barcode_imginfo['height'];

            //Step4 - Insert the barcode image to a specific position
            $this->pdf->Image($tmp_barcode_imginfo['path'], 40, 200, $tmp_barcode_w * 0.7, $tmp_barcode_h * 0.7);

            //Step5 - Save the merged pdf file
            $this->pdf->Output($pdf_dst_file, "F");

            //Step6 - Delete the temporary barcode image file
            @unlink($tmp_barcode_imginfo['path']);

            $merge_result['data'] = $pdf_dst_file;
        }catch(CrossReferenceException $e){
            $merge_result['status'] = false;
            $merge_result['code'] = 9999;

            $merge_result['msg'] = trans('pdfmerge.source_pdf_encrypted');
        }

        return $merge_result;
    }

    public function makeBarcodeImg($number = ''){
        $bg = new BarcodeGeneratorPNG();

        $bar_data = $bg->getBarcode($number, $bg::TYPE_CODE_128);        
        $barcode_fpath = storage_path('app/').md5(date('YmdHis').rand()).'.png';  

        $res = file_put_contents($barcode_fpath, $bar_data);
        if($res == false){
            return null;
        }else{
            $img_info = getimagesize($barcode_fpath);

            $barcode_imginfo = [];
            $barcode_imginfo['path'] = $barcode_fpath;
            $barcode_imginfo['width'] = $img_info[0];
            $barcode_imginfo['height'] = $img_info[1];

            return $barcode_imginfo;
        }
    }
}