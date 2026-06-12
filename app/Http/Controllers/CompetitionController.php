<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    // Available options for shifts, grades, and subjects
    private $shifts = ['صباحي', 'مسائي'];
    private $grades = ['اول', 'ثاني', 'ثالث', 'رابع', 'خامس', 'سادس', 'سابع', 'ثامن', 'تاسع'];
    private $subjects = ['عربي', 'انكليزي', 'رياضيات', 'تاريخ', 'جغرافيا', 'تربية', 'علوم', 'فيزياء', 'كيمياء'];

    // Get divisions based on shift and grade
    private function getDivisions($shift, $grade)
    {
        if ($shift === 'صباحي') {
            // صباحي: جميع الصفوف أ، ب، ج + الصف الثامن أيضاً د
            if ($grade === 'ثامن') {
                return ['أ', 'ب', 'ج', 'د'];
            }
            return ['أ', 'ب', 'ج'];
        } elseif ($shift === 'مسائي') {
            // مسائي: الصفوف الأول-الرابع أ، ب + الخامس فما فوق فقط أ
            if (in_array($grade, ['اول', 'ثاني', 'ثالث', 'رابع'])) {
                return ['أ', 'ب'];
            }
            // الخامس والسادس والسابع والثامن والتاسع
            return ['أ'];
        }
        return [];
    }

    public function create()
    {
        return view('competition.create');
    }

    public function index()
    {
        $competitions = Competition::all();

        // Create a matrix of all possible combinations
        $allCombinations = [];
        foreach ($this->shifts as $shift) {
            foreach ($this->grades as $grade) {
                foreach ($this->subjects as $subject) {
                    $divisions = $this->getDivisions($shift, $grade);
                    foreach ($divisions as $division) {
                        $allCombinations[] = [
                            'shift' => $shift,
                            'grade' => $grade,
                            'subject' => $subject,
                            'division' => $division,
                        ];
                    }
                }
            }
        }

        // Check which combinations have been uploaded
        $uploaded = [];
        $notUploaded = [];

        foreach ($allCombinations as $combo) {
            $found = false;
            foreach ($competitions as $comp) {
                $divisions = $comp->divisions ?? [];
                if ($comp->shift === $combo['shift'] && 
                    $comp->grade === $combo['grade'] && 
                    $comp->subject === $combo['subject'] && 
                    in_array($combo['division'], $divisions)) {
                    $found = true;
                    break;
                }
            }
            if ($found) {
                $uploaded[] = $combo;
            } else {
                $notUploaded[] = $combo;
            }
        }

        $totalCombinations = count($allCombinations);
        $uploadedCount = count($uploaded);
        $remainingCount = count($notUploaded);
        $progress = ($uploadedCount / $totalCombinations) * 100;

        return view('competition.index', [
            'competitions' => $competitions,
            'uploaded' => $uploaded,
            'notUploaded' => $notUploaded,
            'totalCombinations' => $totalCombinations,
            'uploadedCount' => $uploadedCount,
            'remainingCount' => $remainingCount,
            'progress' => $progress,
        ]);
    }

    public function store(Request $request)
    {
        // Get valid divisions for this shift and grade
        $validDivisions = $this->getDivisions($request->shift, $request->grade);
        $validDivisionsString = implode(',', $validDivisions);

        $request->validate([
            'teacher_name' => 'required|regex:/^[\x{0600}-\x{06FF}\s]+$/u',
            'shift' => 'required|in:صباحي,مسائي',
            'grade' => 'required|in:اول,ثاني,ثالث,رابع,خامس,سادس,سابع,ثامن,تاسع',
            'subject' => 'required|in:عربي,انكليزي,رياضيات,تاريخ,جغرافيا,تربية,علوم,فيزياء,كيمياء',
            'divisions' => 'required|array|min:1',
            'divisions.*' => 'required|in:' . $validDivisionsString,
            'competition_file' => 'required|file|mimes:pdf',
            'answer_key_file' => 'required|file|mimes:pdf',
        ], [
            'teacher_name.required' => 'يجب إدخال اسم المعلم',
            'teacher_name.regex' => 'اسم المعلم يجب أن يكون بالعربية فقط',
            'shift.required' => 'يجب اختيار الدوام',
            'shift.in' => 'الدوام المختار غير صحيح',
            'grade.required' => 'يجب اختيار الصف',
            'grade.in' => 'الصف المختار غير صحيح',
            'subject.required' => 'يجب اختيار المادة الدراسية',
            'subject.in' => 'المادة المختارة غير صحيحة',
            'divisions.required' => 'يجب اختيار شعبة واحدة على الأقل',
            'divisions.array' => 'الشعب يجب أن تكون مصفوفة',
            'divisions.min' => 'يجب اختيار شعبة واحدة على الأقل',
            'divisions.*.in' => 'الشعب المختارة غير صحيحة لهذا الدوام والصف',
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

            // إنشاء اسم الشعب من المصفوفة
            $divisionsString = implode(',', $request->divisions);

            $competitionPath = $request->file('competition_file')
                ->storeAs(
                    $folder,
                    'المسابقة شعبة ' . $divisionsString . '.' . $request->file('competition_file')->extension(),
                    'public'
                );

            $answerKeyPath = $request->file('answer_key_file')
                ->storeAs(
                    $folder,
                    'الباريم شعبة ' . $divisionsString . '.' . $request->file('answer_key_file')->extension(),
                    'public'
                );

            Competition::create([
                'teacher_name' => $request->teacher_name,
                'shift' => $request->shift,
                'grade' => $request->grade,
                'subject' => $request->subject,
                'divisions' => $request->divisions,
                'competition_file' => $competitionPath,
                'answer_key_file' => $answerKeyPath,
            ]);

            return back()->with('success', 'تم رفع الملفات بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء رفع الملفات: ' . $e->getMessage());
        }
    }
}
