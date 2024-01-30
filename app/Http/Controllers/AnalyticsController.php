<?php

namespace App\Http\Controllers;

use App\Models\CategoryDescription;
use App\Models\GuestBook;
use App\Models\ProblemCategory;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AnalyticsController extends Controller
{

    public function index()
    {
        $keperluans = ProblemCategory::all();
        // foreach ($keperluan as $key => $value) {
        //     dd($value->guestBooks->count());
        // }
        return view('dashboard.analytics.index', ['keperluans' => $keperluans]);
    }

    public function categoryAnalytics(Request $request, $group_by)
    {
        $tanggal = explode(" to ", $request->tanggal);
        $tanggal_awal = Carbon::parse($tanggal[0])->format('Y-m-d');
        $tanggal_akhir = Carbon::parse($tanggal[1])->format('Y-m-d');

        if ($group_by == 'Harian') {
            return $this->dailyCategoryAnalysis($tanggal_awal, $tanggal_akhir);
        } else if ($group_by == 'Mingguan') {
            return $this->weeklyCategoryAnalysis($tanggal_awal, $tanggal_akhir);
        } else if ($group_by == 'Bulanan') {
            return $this->monthlyCategoryAnalysis($tanggal_awal, $tanggal_akhir);
        }
    }

    public function dailyCategoryAnalysis($tanggal_awal, $tanggal_akhir)
    {
        $data = [];
        $start_date = date('Y-m-d', strtotime($tanggal_awal));
        $end_date = date('Y-m-d', strtotime($tanggal_akhir));

        $days = $this->getDays($start_date, $end_date);

        $kategori = ProblemCategory::all();


        foreach ($kategori as $category) {
            $categoryData = [];
            foreach ($days as $day) {
                $categoryData[] = GuestBook::where('problem_category_id', $category->id)
                    ->whereDate('created_at', $day)
                    ->count();
            }

            $data[] = [
                'name' => $category->name,
                'data' => $categoryData
            ];
        }

        return response()->json([
            'status' => true,
            'data' => [
                'label' => $days,
                'data' => $data
            ]
        ], 200);
    }

    public function weeklyCategoryAnalysis($tanggal_awal, $tanggal_akhir)
    {
        $data = [];

        $start_date = date('Y-m-d', strtotime($tanggal_awal));
        $end_date = date('Y-m-d', strtotime($tanggal_akhir));

        $weeks = $this->getWeeks($start_date, $end_date);
        $categoryDistinct = ProblemCategory::all();

        foreach ($categoryDistinct as $category) {
            $categoryData = [];


            for ($i = 0; $i < count($weeks); $i++) {

                $start_week = $weeks[$i];
                $end_week = date('Y-m-d', strtotime("+6 day", strtotime($start_week)));

                $categoryData[] = GuestBook::where('problem_category_id', $category->id)
                    ->whereBetween('created_at', [$start_week, $end_week])
                    ->count();
            }

            $data[] = [
                'name' => $category->name,
                'data' => $categoryData
            ];
        }

        return response()->json([
            'status' => true,
            'data' => [
                'label' => $weeks,
                'data' => $data
            ]
        ], 200);
    }

    public function monthlyCategoryAnalysis($tanggal_awal, $tanggal_akhir)
    {
        $data = [];

        $start_date = date('Y-m-d', strtotime($tanggal_awal));
        $end_date = date('Y-m-d', strtotime($tanggal_akhir));

        $months = $this->getMonths($start_date, $end_date);

        $categoryDistinct = ProblemCategory::all();

        foreach ($categoryDistinct as $category) {
            $categoryData = [];

            for ($i = 0; $i < count($months); $i++) {

                $start_month = $months[$i];
                $end_month = date('Y-m-d', strtotime("+1 month", strtotime($start_month)));

                $categoryData[] = GuestBook::where('problem_category_id', $category->id)
                    ->whereBetween('created_at', [$start_month, $end_month])
                    ->count();
            }

            $data[] = [
                'name' => $category->name,
                'data' => $categoryData
            ];
        }


        return response()->json([
            'status' => true,
            'data' => [
                'label' => $months,
                'data' => $data
            ]
        ], 200);
    }

    public function getDistinctCategory($start_date, $end_date)
    {
        $start_date = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date = date('Y-m-d 23:59:59', strtotime($end_date));

        return Guest::select('description_id')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->groupBy('description_id')
            ->get();
    }


    public function getMonths($start_date, $end_date)
    {
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);

        $interval = DateInterval::createFromDateString('1 month');
        $period = new DatePeriod($start, $interval, $end);

        $months = [];
        foreach ($period as $dt) {
            $months[] = $dt->format("Y-m-d");
        }

        return $months;
    }

    public function getWeeks($start_date, $end_date)
    {
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);
        $interval = new DateInterval('P1W');
        $period = new DatePeriod($start, $interval, $end);

        $weeks = [];
        foreach ($period as $dt) {
            $weeks[] = $dt->format("Y-m-d");
        }

        return $weeks;
    }

    public function getDays($startDate, $endDate)
    {
        $days = array();
        $current = strtotime($startDate);
        $end = strtotime($endDate);

        while ($current <= $end) {
            $days[] = date('Y-m-d', $current);
            if (date('N', $current) < 5) {
                $current = strtotime('+1 day', $current);
            } else {
                $current = strtotime('+3 day', $current);
            }
        }

        return $days;
    }
}
