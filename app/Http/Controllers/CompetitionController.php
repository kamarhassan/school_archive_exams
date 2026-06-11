<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function create()
    {
        return view('competition.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_name' => 'required|regex:/^[\x{0600}-\x{06FF}\s]+$/u',
            'shift' => 'required',
            'grade' => 'required',
            'subject' => 'required',
            'competition_file' => 'required|file|mimes:pdf',
            'answer_key_file' => 'required|file|mimes:pdf',
        ], [
            'teacher_name.required' => 'يجب إدخال اسم المعلم',
            'teacher_name.regex' => 'اسم المعلم يجب أن يكون بالعربية فقط',
            'shift.required' => 'يجب اختيار الدوام',
            'grade.required' => 'يجب اختيار الصف',
            'subject.required' => 'يجب اختيار المادة الدراسية',
            'competition_file.required' => 'يجب رفع ملف المسابقة',
            'competition_file.file' => 'يجب أن يكون ملف المسابقة ملف صحيح',
            'competition_file.mimes' => 'ملف المسابقة يجب أن يكون بصيغة PDF فقط',
            'answer_key_file.required' => 'يجب رفع ملف الباريم',
            'answer_key_file.file' => 'يجب أن يكون ملف الباريم ملف صحيح',
            'answer_key_file.mimes' => 'ملف الباريم يجب أن يكون بصيغة PDF فقط',
        ]);

        try {
            $folder = 'competitions/'
                . $request->shift . '/'
                . $request->grade . '/'
                . $request->subject;

            $competitionPath = $request->file('competition_file')
                ->storeAs(
                    $folder,
                    'المسابقة.' . $request->file('competition_file')->extension(),
                    'public'
                );

            $answerKeyPath = $request->file('answer_key_file')
                ->storeAs(
                    $folder,
                    'الباريم.' . $request->file('answer_key_file')->extension(),
                    'public'
                );

            Competition::create([
                'teacher_name' => $request->teacher_name,
                'shift' => $request->shift,
                'grade' => $request->grade,
                'subject' => $request->subject,
                'competition_file' => $competitionPath,
                'answer_key_file' => $answerKeyPath,
            ]);

            return back()->with('success', 'تم رفع الملفات بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء رفع الملفات: ' . $e->getMessage());
        }
    }
}
