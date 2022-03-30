<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\BookStatisticService;

class DashboardController extends Controller
{
    private $bss_instance = null;
    /**
     * Create a new controller instance.
     *
     * @return void
     */    
    public function __construct()
    {
        $this->bss_instance = BookStatisticService::getInstance();
    }

    public function getBookStat(Request $request){
        $res = [];
        
        $res['status'] = true;
        $res['code'] = 200;
        $res['msg'] = null;
        $res['data'] = [];

        $res['data']['stocks_and_borrowings'] = $this->bss_instance->getStocksAndBorrowings();
        $res['data']['bbr_count'] = $this->bss_instance->getAllBorrowingReturnedCount();

        return response()->json($res);
    }

    public function getTopCount(Request $request){
        $res = [];
        
        $tops = ($request->tops) ?? 10;

        $res['status'] = true;
        $res['code'] = 200;
        $res['msg'] = null;
        $res['data'] = [];

        $res['data']['top_borrowed_books'] = $this->bss_instance->getTopBorrowedCountBooks($tops);
        $res['data']['top_overdued_books'] = $this->bss_instance->getTopOverduedCountBooks($tops);
        $res['data']['top_borrowed_bookcates'] = $this->bss_instance->getTopBorrowedCountBookCategories($tops);
        $res['data']['top_overdued_bookcates'] = $this->bss_instance->getTopOverduedCountBookCategories($tops);

        return response()->json($res);
    }
}
