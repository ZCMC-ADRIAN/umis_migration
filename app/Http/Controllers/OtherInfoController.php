<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OtherInfoController extends Controller
{
    public function import(){
        try {
            $data = DB::connection('sqlsrv')->SELECT("SELECT
                -- personal_information_id,
                skill,
                recognition,
                organization
                FROM otherinformation
            ");
            
            return response()->json($data);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th -> getMessage()
            ]);
        }
    }
}
