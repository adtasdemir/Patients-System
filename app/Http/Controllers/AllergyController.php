<?php

namespace App\Http\Controllers;

use App\Models\Allergy;
use Illuminate\Http\Request;
use PHPUnit\Exception;

class AllergyController extends Controller
{
    public function destroy(Request $request)
    {
        try {
            $id = (int)$request->input('id');
            if(empty($id)){
                return response()->json(['success' => false, 'message' => "Invalid Id"], 200);
            }
            $nextOfKin = Allergy::findOrFail($id);
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
            ]);

            $nextOfKin = Allergy::findOrFail($id);
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
            ]);

            Allergy::create($validatedData);

            return response()->json(['success' => true, 'message' => "Stored Successfully"], 200);
        }catch (Exception $e){
            return response()->json(['success' => false, 'message' => "Error: ".$e->getMessage()], 200);

        }
    }
}
