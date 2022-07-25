<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreStudentRequest;
use App\Http\Requests\Api\UpdateStudentRequest;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Response;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function index(School $school)
    {
        $students = $school->students()
            ->latest('order')
            ->paginate();

        return response()->json([
            'students' => $students,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\StoreStudentRequest  $request
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentRequest $request, School $school)
    {
        $student = $school->students()->create($request->validated());

        return response()->json([
            'student' => $student,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\School  $school
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(School $school, Student $student)
    {
        return response()->json([
            'student' => $student,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\StoreStudentRequest  $request
     * @param  \App\Models\School  $school
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentRequest $request, School $school, Student $student)
    {
        $student->update($request->validated());

        return response()->json([
            'student' => $student,
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\School  $school
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school, Student $student)
    {
        $student->delete();

        return response()->noContent();
    }
}
