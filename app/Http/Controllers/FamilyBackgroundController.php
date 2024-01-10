<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FamilyBackgroundController extends Controller
{
    public function import(){
        try {
            $data = DB::connection('sqlsrv')->SELECT("SELECT
                -- personal_information_id,
                -- splastname, spfirstname, spmiddlename
                spaddress,
                spzipcode,
                spbirthdate,
                spoccupation,
                spbusinessname,
                spbusinessaddress,
                spbusinesstelno,
                sptinno,
                sprdono,
                fafirstname,
                famiddlename,
                falastname,
                fanameExtension,
                mofirstname,
                momiddlename,
                molastname
                -- mother_ext_name
                FROM employeedetail
            ");

            return response()->json($data);

        } catch (\Throwable $th) {
           return response()->json([
            'message' => $th -> getMessage()
           ]);
        }
    }
}
