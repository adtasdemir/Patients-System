<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function patientList(Request $request)
    {
        $numberPerPage = $request->input('numberPerPage', 10); // Default to 10 if not provided

        $patients = Patient::orderBy('id', 'desc')
            ->paginate((int)$numberPerPage);

        return view('patient.index', [
            'patients' => $patients,
            'currentPage' => $patients->currentPage(),
            'lastPage' => $patients->lastPage(),
            'numberPerPage' => $numberPerPage,
        ]);
    }

    public function getPatientData($patientId)
    {
        try {
            if (empty($patientId)) {
                return response()->json(['success' => false, 'message' => 'Patient not found.'], 404);
            }

            // Find the patient by ID along with related data
            $patient = Patient::with('nextOfKin', 'medicalCondition', 'medication', 'allergy')
                ->find($patientId);

            if (!$patient) {
                return response()->json(['success' => false, 'message' => 'Patient not found.'], 404);
            }

            return response()->json(['success' => true, 'data' => $patient], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => "Error: ".$e->getMessage()], 200);

        }
    }

    public function update(Request $request)
    {
        try {
            $id = (int)$request->input('id');
            if(empty($id)){
                return response()->json(['success' => false, 'message' => "Invalid Id"], 200);
            }

            // Validation
            $validatedData = $request->validate([
                'IdCard' => 'required|string|unique:patients,IdCard',
                'Gender' => 'required',
                'Name' => 'required|string|max:50',
                'Surname' => 'required|string|max:50',
                'DateOfBirth' => 'required|date',
                'Address' => 'nullable|string|max:255',
                'Postcode' => 'nullable|string|max:50',
                'ContactNumber1' => 'required|string|max:25',
                'ContactNumber2' => 'nullable|string|max:255',
            ]);

            $nextOfKin = Patient::findOrFail($id);
            $nextOfKin->update($validatedData);

            return response()->json(['success' => true, 'message' => "Updated Successfully"], 200);
        }catch (Exception $e){
            return response()->json(['success' => false, 'message' => "Error: ".$e->getMessage()], 200);

        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'IdCard' => 'required|string|unique:patients,IdCard',
                'Name' => 'required|string|max:50',
                'Gender' => 'required',
                'Surname' => 'required|string|max:50',
                'DateOfBirth' => 'required|date',
                'Address' => 'nullable|string|max:255',
                'Postcode' => 'nullable|string|max:50',
                'ContactNumber1' => 'required|string|max:25',
                'ContactNumber2' => 'nullable|string|max:255',
            ]);
            Patient::create($validatedData);

            return response()->json(['success' => true, 'message' => "Stored Successfully"], 200);
        }catch (Exception $e){
            return response()->json(['success' => false, 'message' => "Error: ".$e->getMessage()], 200);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $id = (int)$request->input('id');
            if(empty($id)){
                return response()->json(['success' => false, 'message' => "Invalid Id"], 200);
            }
            $nextOfKin = Patient::findOrFail($id);
            $nextOfKin->delete();

            return response()->json(['success' => true, 'message' => "Deleted Successfully"], 200);
        }catch (Exception $e){
            return response()->json(['success' => false, 'message' => "Error: ".$e->getMessage()], 200);

        }
    }
}
