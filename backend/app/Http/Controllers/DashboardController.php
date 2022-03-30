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

        //The following codes may look STRANGE(do not usage loop) but it have to be so
        //The reponse data format must fit the frontend echarts usage.
        //Luckly enough as it is just a small array.
        $sab_data = $this->bss_instance->getStocksAndBorrowings();
        $sab_returns = [];
        $sab_returns[] = [
            'name' => trans('dashboard.bookstat.all_borrowings'),
            'value' => $sab_data['all_borrowings']
        ];
        $sab_returns[] = [
            'name' => trans('dashboard.bookstat.all_stocks'),
            'value' => $sab_data['all_stocks']
        ];
        $res['data']['stocks_and_borrowings'] = $sab_returns;

        $bbr_count_data = $this->bss_instance->getAllBorrowingReturnedCount();
        $bbr_count_returns = [];
        
        foreach($bbr_count_data as $_cnt){
            $bbr_count_returns[] = $_cnt;
        }
        $res['data']['bbr_count'] = $bbr_count_returns;

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
