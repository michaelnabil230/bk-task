<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, School $school)
    {
        $students = $school->students()
            ->latest()
            ->paginate()
            ->appends($request->query());

        return view('schools.students.index', compact('students', 'school'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function create(School $school)
    {
        return view('schools.students.create', compact('school'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStudentRequest  $request
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentRequest $request, School $school)
    {
        $school->students()->create($request->validated());

        return to_route('dashboard.schools.students.index', $school);
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
        return view('schools.students.show', compact('school', 'student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\School  $school
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(School $school, Student $student)
    {
        return view('schools.students.edit', compact('school', 'student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStudentRequest  $request
     * @param  \App\Models\School  $school
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentRequest $request, School $school, Student $student)
    {
        $student->update($request->validated());

        return to_route('dashboard.schools.students.index', $school);
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

        return to_route('dashboard.schools.students.index', $school);
    }
}
