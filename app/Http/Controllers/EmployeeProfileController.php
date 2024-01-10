<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeProfileController extends Controller
{
    public function import(){
        try {
            $data = DB::connection('sqlsrv')->SELECT("SELECT
                emp.employeeid,
                -- personal_information_id,
                -- picture,
                -- job_type,
                -- password,
                -- password_created_date,
                -- password_expiration_date,
                -- employment_status,
                -- biometric_id,
                empJobApp.jobpositionid,
                empJobApp.departmentid,
                empJobApp.plantillaId,
                datehire,
                empJobApp.stationid
                FROM dbo.employee AS emp
                LEFT JOIN dbo.employeedetail AS empDet ON emp.employeeid = empDet.employeeid
                LEFT JOIN dbo.jobappointment AS empJobApp ON emp.employeeid = empJobApp.employeeid
                LEFT JOIN dbo.department AS empDept ON empJobApp.departmentid = empDept.departmentid
                LEFT JOIN dbo.plantilla AS empPlan  ON empJobApp.plantillaid =  empPlan.plantillaId
                LEFT JOIN dbo.station AS empSta ON empJobApp.stationId = empSta.stationid
            ");

            return response()->json($data);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th -> getMessage()
            ]);
        }
    }
}
