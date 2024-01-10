<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonalInfoController extends Controller
{
    public function import(){
        try {
            $data = DB::connection('sqlsrv')->SELECT("SELECT
                emp.employeeid,
                firstname,
                lastname,
                middlename,
                emp.nameextension,
                birthdate
                gender,
                birthplace
                civilstatus,
                marriagedate,
                height,
                weight,
                agencyemployeeno,
                empNat.name
                FROM dbo.employee AS emp
                LEFT JOIN dbo.employeedetail AS empDet ON emp.employeeid = empDet.employeeid
                LEFT JOIN dbo.nationality as empNat ON empDet.nationalityid = empNat.nationalityid
            ");

            return response()->json($data);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th -> getMessage()
            ]);
        }
    }
}
