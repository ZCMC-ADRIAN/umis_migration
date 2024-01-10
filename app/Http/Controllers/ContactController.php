<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Contact;

class ContactController extends Controller
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
                employeeid,
                mobileno,
                email
                FROM dbo.employeedetail
                WHERE employeeid = ?
            ",[$item['employeeid']]);

                $resultObject = (object) $query[0];
                $results[] = $resultObject;

                $personalInformationIds[] = $item['personal_information_id'];
            }

            foreach ($results as $key => $value) {
                $contact = new Contact();
                $contact->personal_information_id = $personalInformationIds[$key];
                $contact->phone_number = $value->mobileno;
                $contact->email_address = $value->email === NULL || '' ? 'None' : $value->email;
                $contact->save();
            }
            
            return response([
                'message' => 'Success'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th ->getMessage()
            ]);
        }
    }
}
