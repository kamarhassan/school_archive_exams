<?php

namespace App\Http\Controllers;

use App\Models\StudentOld;
use Illuminate\Http\Request;

class studentsController extends Controller
{
    public function index()
    {
        $students = StudentOld::where('is_enable', 1)
            ->orderBy('previous_grade', 'asc')
            ->orderBy('first_name_ar', 'asc')
            ->get();
        return view('students.students', compact('students'));
    }

    public function show(StudentOld $student)
    {
        abort_unless($student->is_enable, 404);

        return response()->json($student);
    }

 public function update(Request $request, $id)
{
    $validated = $request->validate([
        'first_name_en'         => 'required|string|max:255',
        'last_name_en'          => 'required|string|max:255',
        'id_card_type'          => 'required|in:lebanese,unhcr,residence',
        'id_card_number'        => 'required|string|max:255',
        'contact_location'      => 'required|string|max:255',
        'nationality'           => 'required|string|max:255',
        'father_name_ar'        => 'required|string|max:255',
        'father_name_en'        => 'required|string|max:255',
        'guardian_phone'        => 'required|string|max:255',
        'father_work_sector'    => 'required|string|max:255',
        'father_job_type'       => 'required|string|max:255',
        'mother_first_name_ar'  => 'required|string|max:255',
        'mother_name_en'        => 'required|string|max:255',
        'mother_family_name_ar' => 'required|string|max:255',
        'mother_family_name_en' => 'required|string|max:255',
        'mother_work_sector'    => 'required|string|max:255',
        'mother_job_type'       => 'required|string|max:255',
        'mother_nationality'    => 'required|string|max:255',
    ]);

    $student = StudentOld::findOrFail($id);

    // تحويل قيمة is_enable (إذا كانت المرسلة 1 تصبح 0)
    $validated['is_enable'] = $request->input('is_enable') == '1' ? 0 : 1;

    $student->update($validated);

    return response()->json([
        'status'  => 'success',
        'message' => 'تم تحديث بيانات التلميذ بنجاح!'
    ]);
}
}
