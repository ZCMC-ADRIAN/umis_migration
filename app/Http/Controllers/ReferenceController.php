<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReferenceController extends Controller
{
    public function import(){
        try {
            $data = DB::connection('sqlsrv')->SELECT("SELECT
                -- employee_profile_id,
                emp.employeeid,
                -- empDet.employeedetailid,
                name,
                address,
                ref.telno
                
                FROM dbo.reference AS ref
                LEFT JOIN dbo.employeedetail AS empDet ON empDet.employeedetailid = ref.employeedetailid
                LEFT JOIN dbo.employee AS emp ON empDet.employeeid = emp.employeeid
            ");

            return response()->json($data);

        } catch (\Throwable $th) {
            return response()->json([
                'message' =>$th -> getMessage()
            ]);
        }
    }
}
