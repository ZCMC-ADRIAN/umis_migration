<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CivilServiceEligibilityController extends Controller
{
    public function import(){
        try {
            $data = DB::connection('sqlsrv')->SELECT("SELECT
                emp.employeeid,
                career,
                rating,
                datetaken,
                placetaken,
                licenseno
                FROM dbo.employee AS emp
                LEFT JOIN employeedetail AS empDet ON emp.employeeid = empDet.employeeid
                LEFT JOIN civilserviceeligibility  AS cse ON empDet.employeedetailid = cse.employeedetailid
            ");
            
            return response()->json($data);

        } catch (\Throwable $th) {
           return response()->json([
            'message' => $th -> getMessage()
           ]);
        }
    }
}
