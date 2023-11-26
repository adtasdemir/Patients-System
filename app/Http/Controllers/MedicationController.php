<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medication;
use PHPUnit\Exception;

class MedicationController extends Controller
{
    public function destroy(Request $request)
    {
        try {
            $id = (int)$request->input('id');
            if(empty($id)){
                return response()->json(['success' => false, 'message' => "Invalid Id"], 200);
            }
            $nextOfKin = Medication::findOrFail($id);
            $nextOfKin->delete();

            return response()->json(['success' => true, 'message' => "Deleted Successfully"], 200);
        }catch (Exception $e){
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
                'Name' => 'required|string|max:100',
                'Notes' => 'required|string|max:255',
                'StartDate' => 'required|date',
                'EndDate' => 'nullable|date',
            ]);

            $nextOfKin = Medication::findOrFail($id);
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
                'patient_id' => 'required|int',
                'Name' => 'required|string|max:100',
                'Notes' => 'required|string|max:255',
                'StartDate' => 'required|date',
                'EndDate' => 'nullable|date',
            ]);

             Medication::create($validatedData);

            return response()->json(['success' => true, 'message' => "Stored Successfully"], 200);
        }catch (Exception $e){
            return response()->json(['success' => false, 'message' => "Error: ".$e->getMessage()], 200);

        }
    }
}
