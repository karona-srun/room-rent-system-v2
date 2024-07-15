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
use Illuminate\Support\Str;
use Magarrent\LaravelCurrencyFormatter\Facades\Currency;

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

        $userCount = User::where('apartment_id',Auth::user()->apartment_id)->count();
        $roomCount = Room::where('apartment_id',Auth::user()->apartment_id)->count();
        $roomRentCount = RoomRent::where('apartment_id',Auth::user()->apartment_id)->count();

        $roomAvailable = $roomCount - $roomRentCount;
        
        $total = Invoice::where('apartment_id',Auth::user()->apartment_id)->whereMonth('created_at', '=', date('m'))->pluck('total_amount');
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
                    'fontSize' => 14
                ]
            ],
            'scales' => [
            ]
        ]);

        $filteredInvoicesYear = Invoice::whereMonth('created_at', '=', date('m'))->get();
        $filteredInvoicesWaterCost = Invoice::whereMonth('created_at', '=', date('m'))->get()->sum('water_cost');
        $filterRoomCost = Invoice::whereMonth('created_at', '=', date('m'))->get()->sum('room_cost');
        $filterElectricityCost = Invoice::whereMonth('created_at', '=', date('m'))->get()->sum('electric_cost');
        $filterTrashCost = Invoice::whereMonth('created_at', '=', date('m'))->get()->sum('trash_cost');

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

        $WaterCost =  $filteredInvoicesWaterCost / $apart->exchange_riel;
        $RoomCost = $filterRoomCost;
        $ElectricityCost = $filterElectricityCost / $apart->exchange_riel;
        $TrashCost = $filterTrashCost / $apart->exchange_riel;
        
        $chartLine = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 500, 'height' => 180])
        // ->labels((['មករា', 'កុម្ភៈ', 'មីនា', 'មេសា', 'ឧសភា', 'មិថុនា', 'កក្កដា', 'សីហា', 'កញ្ញា', 'តុលា','វិច្ឆិកា', 'ធ្នូ']))
        ->datasets([
            [
                "label" => __('app.label_total_amount').'$',
                'backgroundColor' => ["#0140ff"],
                'borderColor' => "#fff",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => array_values([array_values($monthlyTotals)])
            ],
            [
                "label" => [__('app.room_cost').'$'],
                'backgroundColor' => ["#0dcaf0"],
                'borderColor' => "#fff",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => array_values([number_format($RoomCost,2)])
            ],
            [
                "label" => [__('app.invoice_water_cost').'$'],
                'backgroundColor' => ["#3a9da6"],
                'borderColor' => "#fff",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => array_values([number_format($WaterCost,2)])
            ],
            [
                "label" => [__('app.invoice_eletrotic_cost').'$'],
                'backgroundColor' => ["#e7c846"],
                'borderColor' => "#fff",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => array_values([number_format($ElectricityCost,2)])
            ],
            [
                "label" => [__('app.trash_cost').'$'],
                'backgroundColor' => ["#3bb001"],
                'borderColor' => "#3bb001",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => array_values([number_format($TrashCost,2)])
            ]
        ])
        ->options([]);

        $data = [
            'room' => $roomCount,
            'room_rent' => $roomRentCount,
            'roomAvailable' => $roomAvailable,
            'user' => $userCount,
            'total_riel' => $total_sum_riel,
            'total_dollar' => number_format($total_sum,2)
        ];

        return view('home', ['chartjs' => $chartjs,'chartLine' => $chartLine,'data' => $data]);
    }
}
