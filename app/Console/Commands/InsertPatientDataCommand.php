<?php

namespace App\Console\Commands;

use App\Models\Allergy;
use App\Models\MedicalCondition;
use App\Models\Medication;
use App\Models\NextOfKin;
use App\Models\Patient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class InsertPatientDataCommand extends Command
{
    protected $signature = 'insert:patient-data {file : JSON file path}';

    protected $description = 'Insert patient data from a JSON file';

    public function handle()
    {
        $filePath = $this->argument('file');

        if (!File::exists($filePath)) {
            $this->write("File not found: $filePath",false);
            return;
        }

        $patientData = json_decode(File::get($filePath), true);

        if (empty($patientData)) {
            $this->write('Invalid JSON data.', false);
            return;
        }

        DB::beginTransaction();
        try {
            foreach ($patientData as $patientDataItem) {
                $patient = Patient::create([
                    'IdCard' => $patientDataItem['IdCard'],
                    'Gender' => $patientDataItem['Gender'],
                    'Name' => $patientDataItem['Name'],
                    'Surname' => $patientDataItem['Surname'],
                    'DateOfBirth' => $patientDataItem['DateOfBirth'],
                    'Address' => $patientDataItem['Address'],
                    'Postcode' => $patientDataItem['Postcode'],
                    'ContactNumber1' => $patientDataItem['ContactNumber1'],
                    'ContactNumber2' => $patientDataItem['ContactNumber2'],
                ]);

                foreach ($patientDataItem['NextOfKin'] as $nextOfKinData) {
                    NextOfKin::create([
                        'patient_id' => $patient->id,
                        'IdCard' => $nextOfKinData['IdCard'],
                        'Name' => $nextOfKinData['Name'],
                        'Surname' => $nextOfKinData['Surname'],
                        'ContactNumber1' => $nextOfKinData['ContactNumber1'],
                        'ContactNumber2' => $nextOfKinData['ContactNumber2'],
                    ]);
                }

                foreach ($patientDataItem['Medical']['Conditions'] as $conditionData) {
                    MedicalCondition::create([
                        'patient_id' => $patient->id,
                        'Name' => $conditionData['Name'],
                        'Notes' => $conditionData['Notes'],
                    ]);
                }

                foreach ($patientDataItem['Medical']['Alergies'] as $allergyData) {
                    Allergy::create([
                        'patient_id' => $patient->id,
                        'Name' => $allergyData['Name'],
                        'Notes' => $allergyData['Notes'],
                    ]);
                }

                foreach ($patientDataItem['Medical']['Medication'] as $medicationData) {
                    Medication::create([
                        'patient_id' => $patient->id,
                        'Name' => $medicationData['Name'],
                        'Notes' => $medicationData['Notes'],
                        'StartDate' => $medicationData['StartDate'],
                        'EndDate' => $medicationData['EndDate'],
                    ]);
                }
            }

            DB::commit();
            $this->write('Patient data inserted successfully.',true);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->write('Error inserting patient data: ' . $e->getMessage(),false);
        }
    }

    public function write(string $message, ?bool $success = null){
        if (!app()->environment('testing')) {
            $type = "";
            if($success !== null){
                $type = ($success === true) ? " Success" : " Error";
                $type = $type." =>";
            }
            fwrite(STDERR, $type.' '.$message."\n");
        }
    }
}
