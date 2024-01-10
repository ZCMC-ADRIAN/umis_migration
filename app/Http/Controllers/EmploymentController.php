<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmploymentController extends Controller
{
    public function import(){
        try {
            $data = DB::connection('sqlsrv')->SELECT("SELECT
                -- personal_information_id,
                employmentdate,
                separationdate,
                position,
                appointmentstatus,
                salary,
                salaryincstep,
                companyanddepartment,
                isgovernmentservice
                -- is_voluntary_work
                FROM dbo.employment
            ");

            return response()->json($data);

        } catch (\Throwable $th) {
            return response()->json([
                'messsage' => $th -> getMessage()
            ]);
        }
    }
}
