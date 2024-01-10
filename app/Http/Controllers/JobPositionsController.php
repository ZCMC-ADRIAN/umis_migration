<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobPositionsController extends Controller
{
    public function import(){
        try {
            $data = DB::connection('sqlsrv')->SELECT("SELECT
                -- salary_grade_id,
                name,
                code
                -- effective_date
                FROM jobposition
            ");

            return response()->json($data);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th -> getMessage()
            ]);
        }
    }
}
