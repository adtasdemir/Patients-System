<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NextOfKin;
use PHPUnit\Exception;

class NextOfKinController extends Controller
{
    public function destroy(Request $request)
    {
        try {
            $id = (int)$request->input('id');
            if(empty($id)){
                return response()->json(['success' => false, 'message' => "Invalid Id"], 200);
            }
            $nextOfKin = NextOfKin::findOrFail($id);
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
                'Name' => 'required|string|max:50',
                'Surname' => 'required|string|max:50',
                'ContactNumber1' => 'required|string|max:25',
                'ContactNumber2' => 'nullable|string|max:25',
            ]);

            $nextOfKin = NextOfKin::findOrFail($id);
            $nextOfKin->update($validatedData);

            return response()->json(['success' => true, 'message' => "Stored Successfully"], 200);
        }catch (Exception $e){
            return response()->json(['success' => false, 'message' => "Error: ".$e->getMessage()], 200);

        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'patient_id' => 'required|int',
                'IdCard' => 'required|string|max:50',
                'Name' => 'required|string|max:50',
                'Surname' => 'required|string|max:50',
                'ContactNumber1' => 'required|string|max:25',
                'ContactNumber2' => 'nullable|string|max:25',
            ]);

             NextOfKin::create($validatedData);

            return response()->json(['success' => true, 'message' => "Updated Successfully"], 200);
        }catch (Exception $e){
            return response()->json(['success' => false, 'message' => "Error: ".$e->getMessage()], 200);

        }
    }
}
