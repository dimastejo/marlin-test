<?php


namespace App\Http\Controllers;


use App\Services\OngkirService;
use Illuminate\Http\Request;

class MarlinController extends Controller
{


    /**
     * MarlinController constructor.
     */
    public function __construct()
    {
    }

    function index(OngkirService $service)
    {
        $data = [
            'province' => []//$service->getProvince()
        ];

        return view('marlin-test', $data);
    }

    public function city(Request $request, OngkirService $service)
    {
        $param = $request->all();
        $city = $service->getCity($param['province_id']);

        return response()->json($city);
    }

    public function getCost(Request $request, OngkirService $service)
    {
        $param = $request->all();

        return response()->json($service->getCost($param['city'], $param['weight'], $param['ekspedisi']));
    }

    public function loop(Request $request)
    {
        $loop = $request->all()['loop'];

        $marlin_booking_found = 0;
        for ($i = 1; $i <= $loop; $i++) {
            if ($i % 3 == 0 && $i % 5 == 0) {
                echo $i . ' Marlin Booking' . PHP_EOL.PHP_EOL;
                $marlin_booking_found++;
            }

            if ($marlin_booking_found >= 5) {
                break;
            }

            if ($marlin_booking_found >= 2) {
                if ($i % 5 == 0) {
                    echo $i . ' Marlin' . PHP_EOL;
                } else if ($i % 3 == 0) {
                    echo $i . ' Booking' . PHP_EOL;
                }
            } else {
                if ($i % 5 == 0) {
                    echo $i . ' Booking' . PHP_EOL;
                } else if ($i % 3 == 0) {
                    echo $i . ' Marlin' . PHP_EOL;
                }
            }
        }

    }
}
