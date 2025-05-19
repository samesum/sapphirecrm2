<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class GanttChartController extends Controller
{
    public function index()
    {
        $page_data['tasks'] = DB::table('project_tasks')->get();
        return view('projects.gantt_chart.index', $page_data);
    }
}
