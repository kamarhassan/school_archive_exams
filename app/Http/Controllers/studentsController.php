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
        'first_name_en'         => ['required','string','max:255','regex:/^[A-Za-z\s\'-]+$/'],
        'last_name_en'          => ['required','string','max:255','regex:/^[A-Za-z\s\'-]+$/'],
        'id_card_type'          => 'required|in:lebanese,unhcr,residence',
        'id_card_number'        => 'required|string|max:255',
        'contact_location'      => 'required|string|max:255',
        'nationality'           => 'required|string|max:255',
        'father_name_ar'        => 'required|string|max:255',
        'father_name_en'        => ['required','string','max:255','regex:/^[A-Za-z\s\'-]+$/'],
        'guardian_phone'        => 'required|string|max:255',
        'father_work_sector'    => 'required|string|max:255',
        'father_job_type'       => 'required|string|max:255',
        'mother_first_name_ar'  => 'required|string|max:255',
        'mother_name_en'        => ['required','string','max:255','regex:/^[A-Za-z\s\'-]+$/'],
        'mother_family_name_ar' => 'required|string|max:255',
        'mother_family_name_en' => ['required','string','max:255','regex:/^[A-Za-z\s\'-]+$/'],
        'mother_work_sector'    => 'required|string|max:255',
        'mother_job_type'       => 'required|string|max:255',
        'mother_nationality'    => 'required|string|max:255',
    ], [
        'first_name_en.regex' => 'الاسم الأول بالإنكليزية يجب أن يحتوي على حروف إنجليزية فقط.',
        'last_name_en.regex' => 'الشهرة بالإنكليزية يجب أن تحتوي على حروف إنجليزية فقط.',
        'father_name_en.regex' => 'اسم الأب بالإنكليزية يجب أن يحتوي على حروف إنجليزية فقط.',
        'mother_name_en.regex' => 'اسم الأم بالإنكليزية يجب أن يحتوي على حروف إنجليزية فقط.',
        'mother_family_name_en.regex' => 'عائلة الأم بالإنكليزية يجب أن تحتوي على حروف إنجليزية فقط.',
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
