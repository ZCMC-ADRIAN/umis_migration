<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IssuanceInfoController extends Controller
{
    public function import(){
        try {
           $data = DB::connection('sqlsrv')->SELECT("SELECT
                -- employee_profile_id,
                emp.employeeid,
                govtIssuedId,
                ctcissuedate,
                ctcissueplace,
                personAdministerOath,
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
