<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\PersonalInformaton;

class Extract extends Controller
{
    public function import(){
        try {

            $jsonFilePath = storage_path('../app/json_data/profiles.json');
            $jsonContent = file_get_contents($jsonFilePath);
            $data = json_decode($jsonContent, true); 

            $collection = collect($data);

            $names = $collection->map(function ($item) {
                return [
                    'firstname' => $item['Firstname'],
                    'middlename' => $item['Middle Name'] ?? null,
                    'lastname' => $item['Lastname'],
                ];
            })->toArray();
            
            // Fetch data from the database
            $result = collect([]);
            
            foreach ($names as $name) {
                $query = "SELECT
                            -- emp.employeeid AS employeeid,
                            firstname AS first_name,
                            lastname AS last_name,
                            middlename AS middle_name,
                            emp.nameextension AS name_extension,
                            birthdate AS date_of_birth,
                            gender AS sex,
                            birthplace AS place_of_birth,
                            civilstatus AS civil_status,
                            marriagedate AS date_of_marriage,
                            height,
                            weight,
                            bloodtype AS blood_type,
                            nametitle AS name_title,
                            empNat.name AS citizenship
                        FROM dbo.employee AS emp
                        LEFT JOIN dbo.employeedetail AS empDet ON emp.employeeid = empDet.employeeid
                        LEFT JOIN dbo.nationality as empNat ON empDet.nationalityid = empNat.nationalityid
                        WHERE firstname = ? AND middlename = ? AND lastname = ?";
            
                $employeeData = DB::connection('sqlsrv')->select($query, [
                    $name['firstname'],
                    $name['middlename'],
                    $name['lastname'],
                ]);

                foreach ($employeeData as $data){
                    switch ($data->blood_type) {
                        case 0:
                            $data->blood_type = '';
                            break;
                        case 1: 
                            $data->blood_type = 'A+';
                            break;
                        case 2: 
                            $data->blood_type = 'B+';
                            break;
                        case 3:
                            $data->blood_type = 'AB+';
                            break;
                        case 4:
                            $data->blood_type = 'O+';
                            break;
                        case 5:
                            $data->blood_type = 'A-';
                            break;
                        case 6:
                            $data->blood_type = 'B-';
                            break;
                        case 7:
                            $data->blood_type = 'AB-';
                            break;
                        case 8:
                            $data->blood_type = 'O-';
                            break;
                        default:
                            $data->blood_type = '';
                            break;
                    }

                    switch ($data->sex) {
                        case 0:
                            $data->sex = '';
                            break;
                        case 1:
                            $data->sex = 'Male';
                            break;
                        case 2:
                            $data->sex = 'Female';
                            break;
                        default:
                            $data->sex = '';
                            break;
                    }
                }
            
                $result = $result->merge($employeeData);
            }

            foreach ($result as $data){

                $personalInfo = new PersonalInformaton;
                // $personalInfo->employeeid       = $data->employeeid;
                $personalInfo->first_name       = $data->first_name;
                $personalInfo->last_name        = $data->last_name;
                $personalInfo->middle_name      = $data->middle_name;
                $personalInfo->name_extension   = $data->name_extension;
                $personalInfo->date_of_birth    = $data->date_of_birth;
                $personalInfo->sex              = $data->sex;
                $personalInfo->place_of_birth   = $data->place_of_birth;
                $personalInfo->civil_status     = $data->civil_status;
                $personalInfo->date_of_marriage = $data->date_of_marriage;
                $personalInfo->height           = $data->height;
                $personalInfo->weight           = $data->weight;
                $personalInfo->blood_type       = $data->blood_type;
                $personalInfo->name_title       = $data->name_title;
                $personalInfo->citizenship      = $data->citizenship;
                $personalInfo->save();

            }

            // $personalInfo->save();

            return response('Success');


        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th -> getMessage()
            ]);
        }
    }
}
