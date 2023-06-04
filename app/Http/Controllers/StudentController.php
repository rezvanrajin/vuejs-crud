<?php

namespace App\Http\Controllers;

use App\Models\student;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        if($students->count() > 0)
        {
            return response()->json([
                'status' => 200,
                'students' => $students
    
            ],200); 
        }
        else 
        {
            return response()->json([
                'status' => 404,
                'students' => 'No Record Found'
    
            ],404);
        }

    }


    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(),[
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'phone' => 'required|digits:11',
            'course' => 'required|string|max:50',
        ]);

        if($Validator->fails())
        {
            return response()->json([
                'status' => 422,
                'errors' => $Validator->messages()
            ],422);
        }
        else
        {
            $students = Student::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'course' => $request->course,
            ]);
            if($students)
            {
                return response()->json([
                    'status' => 200,
                    'message' => "Student Created Successfully"
                ],200);
            }
            else
            {       return response()->json([
                'status' => 500,
                'message' => "Student Not Created !!!"
            ],500);

            }
        }
    }

    public function show($id)
    {
        $student = Student::find($id);
        if($student){
            return response()->json([
                'status' => 200,
                'student' => $student
            ],200);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => "No Student Data found !!!"
            ],404);
        }
    }
    public function edit($id)
    {
        $student = Student::find($id);
        if($student){
            return response()->json([
                'status' => 200,
                'student' => $student
            ],200);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => "No Student Data found !!!"
            ],404);
        }
    }

    public function update(Request $request, $id)
    {
        $Validator = Validator::make($request->all(),[
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'phone' => 'required|digits:11',
            'course' => 'required|string|max:50',
        ]);

        if($Validator->fails())
        {
            return response()->json([
                'status' => 422,
                'errors' => $Validator->messages()
            ],422);
        }
        else
        {
            $students = Student::find($id);
            
            if($students)
            {
                $students->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'course' => $request->course,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Student Updated Successfully"
                ],200);
            }
            else
            {       return response()->json([
                'status' => 404,
                'message' => "No Student data Found !!!"
            ],404);

            }
        }
    }
    public function destroy($id)
    {
        $student = Student::find($id);
        if($student)
        {
            $student->delete();
            return response()->json([
                'status' => 200,
                'message' => "Data Deleted Successfully !!!"
            ],200);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => "No Student data Found !!!"
            ],404);

        }
    }
}
