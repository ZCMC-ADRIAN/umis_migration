<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Identification;

class IdentificationNoController extends Controller
{
    public function import(){
        try {
            $jsonFilePath = storage_path('../app/json_data/id.json');
            $jsonContent = file_get_contents($jsonFilePath);
            $data = json_decode($jsonContent, true);

            $collection = collect($data);

            $results = [];

            foreach($data as $item){
                $query = DB::connection('sqlsrv')->SELECT("SELECT
                emp.employeeid,
                gsisno,
                pagibigcode,
                philhealthno,
                sssno,
                prcid,
                tinno,
                rdono,
                bankaccountno
                FROM dbo.employee AS emp
                LEFT JOIN dbo.employeedetail AS empDet ON emp.employeeid = empDet.employeeid
                WHERE empDet.employeeid = ?
            ",[$item['employeeid']]);

                $resultObject = (object) $query[0];
                $results[] = $resultObject;

                $personalInformationIds[] = $item['personal_information_id'];
            }

            foreach ($results as $key => $value) {
                $identification = new Identification();
                $identification->personal_information_id = $personalInformationIds[$key];
                $identification->gsis_id_no              = $value->gsisno;
                $identification->pag_ibig_id_no          = $value->pagibigcode;
                $identification->philhealth_id_no        = $value->philhealthno;
                $identification->sss_id_no               = $value->sssno;
                $identification->prc_id_no               = $value->prcid;
                $identification->tin_id_no               = $value->tinno;
                $identification->rdo_no                  = $value->rdono;
                $identification->bank_account_no         = $value->bankaccountno;
                $identification->save();
            }

            return response()->json([
                'message' => 'Success'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th ->getMessage()
            ]);
        }
    }
}
