<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Invoice;
use App\Models\Room;
use App\Models\RoomRent;
use App\Models\User;
use Carbon\Carbon;
use Hamcrest\Core\HasToString;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use KhmerDateTime\KhmerDateTime;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->last_login = Carbon::now()->toDateTimeString();
        $user->device = $request->userAgent();
        $user->save();

        $apart = Apartment::find(Auth::user()->apartment_id);

        $userCount = User::count();
        $roomCount = Room::count();
        $roomRentCount = RoomRent::count();

        $total = Invoice::whereMonth('created_at', '=', date('m'))->pluck('total_amount');
        $total_sum = 0;
        foreach($total as $i => $sum){
            $t = explode('$', $sum);
            $total_sum += $t[1];
        }
        $total_sum_riel = $total_sum * $apart->exchange_riel;

        $chartjs = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 250])
        ->labels([__('app.label_room_rent'),__('app.label_room')])
        ->datasets([
            [
                'backgroundColor' => ['#0140ff', '#dde2e9'],
                'hoverBackgroundColor' => ['#0140ff','#dde2e9'],
                'data' => [$roomRentCount, $roomCount],
            ]
        ])
        ->options([]);

        $chartjs->optionsRaw([
            'legend' => [
                'display' => true,
                'labels' => [
                    'fontColor' => '#000',
                    'fontSize' => 16
                ]
            ],
            'scales' => [
            ]
        ]);

        $filteredInvoicesYear = Invoice::whereYear('created_at', '=', date('Y'))->get();
        $monthlyTotals = [];
        foreach($filteredInvoicesYear as $key => $year){
            $month = date('m', strtotime($year->created_at));
            if (!isset($monthlyTotals[$month])) {
                $monthlyTotals[$month] = 0;
            }
            $sum = explode('$', $year->total_amount);
            $monthlyTotals[$month] += number_format($sum[1],2); 
        }

        uksort($monthlyTotals, function($a, $b) {
            return strnatcmp($a, $b);
        });

        $chartLine = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 500, 'height' => 100])
        ->labels(array_keys($monthlyTotals))//;['មករា', 'កុម្ភៈ', 'មីនា', 'មេសា', 'ឧសភា', 'មិថុនា', 'កក្កដា', 'សីហា', 'កញ្ញា', 'តុលា','វិច្ឆិកា', 'ធ្នូ'])
        ->datasets([
            [
                "label" =>__('app.label_info_detail'),
                'backgroundColor' => "#0140ff",
                'borderColor' => "#fff",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' =>array_values($monthlyTotals)
            ]
        ])
        ->options([]);

        $data = [
            'room' => $roomCount,
            'room_rent' => $roomRentCount,
            'user' => $userCount,
            'total_riel' => $total_sum_riel,
            'total_dollar' => number_format($total_sum,2)
        ];

        return view('home', ['chartjs' => $chartjs,'chartLine' => $chartLine,'data' => $data]);
    }
}
