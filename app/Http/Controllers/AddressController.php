<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Address;

class AddressController extends Controller
{
    public function import()
    {
        try {
            $jsonFilePath = storage_path('../app/json_data/id.json');
            $jsonContent = file_get_contents($jsonFilePath);
            $data = json_decode($jsonContent, true);

            $collection = collect($data);

            $results = [];

            foreach ($data as $item) {
                $query = DB::connection('sqlsrv')->select("SELECT
                        employeeid,
                        permanentaddress,
                        zipcode,
                        residentaddress,
                        telno
                        FROM dbo.employeedetail
                        WHERE employeeid = ?
                    ", [$item['employeeid']]);

                $resultObject = (object) $query[0];
                $results[] = $resultObject;

                $personalInformationIds[] = $item['personal_information_id'];
            }

            foreach ($results as $key => $value) {
                $address = new Address;
                $address->personal_information_id = $personalInformationIds[$key];
            
                if ($value->residentaddress == '' && $value->permanentaddress == '') {
                    $address->address = 'No Address';
                } else {
                    $address->address = $value->residentaddress === NULL || $value->residentaddress === '' ? 'None' : $value->residentaddress;
                    $address->is_residential_and_permanent = 1;
                    $address->is_residential = 1;
            
                    if ($value->residentaddress != $value->permanentaddress) {
                        $permanentAddress = clone $address;
                        $permanentAddress->is_residential = 0;
                        $permanentAddress->address = $value->permanentaddress === NULL || $value->permanentaddress === '' ? 'None' : $value->permanentaddress;
                        $permanentAddress->telephone_no = $value->telno;
                        $permanentAddress->save();
                    }
                }
            
                $address->telephone_no = $value->telno;
                $address->save();
            }

            return response()->json([
                'message' => 'Success'
            ]);

            // return response($results);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }
}
