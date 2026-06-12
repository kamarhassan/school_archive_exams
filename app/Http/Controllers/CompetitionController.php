<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompetitionController extends Controller
{
    // Available options for shifts, grades, and subjects
    private $shifts = ['صباحي', 'مسائي'];
    private $grades = ['اول', 'ثاني', 'ثالث', 'رابع', 'خامس', 'سادس', 'سابع', 'ثامن', 'تاسع'];
    private $subjects = ['عربي', 'انكليزي', 'رياضيات', 'تاريخ', 'جغرافيا', 'تربية', 'علوم', 'فيزياء', 'كيمياء'];

    private $primaryGrades = ['Ø§ÙˆÙ„', 'Ø«Ø§Ù†ÙŠ', 'Ø«Ø§Ù„Ø«', 'Ø±Ø§Ø¨Ø¹', 'Ø®Ø§Ù…Ø³', 'Ø³Ø§Ø¯Ø³'];
    private $upperGradeOnlySubjects = ['ØªØ§Ø±ÙŠØ®', 'ÙÙŠØ²ÙŠØ§Ø¡', 'ÙƒÙŠÙ…ÙŠØ§Ø¡'];

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

    private function getSubjects($grade)
    {
        if (in_array($grade, $this->primaryGrades)) {
            return array_values(array_diff($this->subjects, $this->upperGradeOnlySubjects));
        }

        return $this->subjects;
    }

    public function create()
    {
        return view('competition.create');
    }

    public function index(Request $request)
    {
        $filters = [
            'shift' => $request->query('shift'),
            'grade' => $request->query('grade'),
            'subject' => $request->query('subject'),
            'division' => $request->query('division'),
        ];

        $filters['shift'] = in_array($filters['shift'], $this->shifts) ? $filters['shift'] : null;
        $filters['grade'] = in_array($filters['grade'], $this->grades) ? $filters['grade'] : null;
        $filters['subject'] = in_array($filters['subject'], $this->subjects) ? $filters['subject'] : null;
        $filters['division'] = in_array($filters['division'], ['Ø£', 'Ø¨', 'Ø¬', 'Ø¯']) ? $filters['division'] : null;

        $competitions = Competition::all();

        $filteredCompetitions = Competition::query()
            ->when($filters['shift'], fn ($query, $shift) => $query->where('shift', $shift))
            ->when($filters['grade'], fn ($query, $grade) => $query->where('grade', $grade))
            ->when($filters['subject'], fn ($query, $subject) => $query->where('subject', $subject))
            ->latest()
            ->get()
            ->when($filters['division'], function ($items, $division) {
                return $items->filter(function ($competition) use ($division) {
                    return in_array($division, $competition->divisions ?? []);
                })->values();
            });

        // Create a matrix of all possible combinations
        $allCombinations = [];
        foreach ($this->shifts as $shift) {
            foreach ($this->grades as $grade) {
                foreach ($this->getSubjects($grade) as $subject) {
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

        $competitionStatus = [];
        foreach ($this->shifts as $shift) {
            foreach ($this->grades as $grade) {
                foreach ($this->getSubjects($grade) as $subject) {
                    foreach ($this->getDivisions($shift, $grade) as $division) {
                        $isUploaded = false;
                        foreach ($competitions as $comp) {
                            $divisions = $comp->divisions ?? [];
                            if ($comp->shift === $shift &&
                                $comp->grade === $grade &&
                                $comp->subject === $subject &&
                                in_array($division, $divisions)) {
                                $isUploaded = true;
                                break;
                            }
                        }

                        $competitionStatus[$shift][$grade][$subject][] = [
                            'division' => $division,
                            'uploaded' => $isUploaded,
                        ];
                    }
                }
            }
        }

        $totalCombinations = count($allCombinations);
        $uploadedCount = count($uploaded);
        $remainingCount = count($notUploaded);
        $progress = $totalCombinations > 0 ? ($uploadedCount / $totalCombinations) * 100 : 0;

        return view('competition.index', [
            'competitions' => $filteredCompetitions,
            'uploaded' => $uploaded,
            'notUploaded' => $notUploaded,
            'competitionStatus' => $competitionStatus,
            'totalCombinations' => $totalCombinations,
            'uploadedCount' => $uploadedCount,
            'remainingCount' => $remainingCount,
            'progress' => $progress,
            'filters' => $filters,
            'shifts' => $this->shifts,
            'grades' => $this->grades,
            'subjects' => $this->subjects,
            'availableSubjectsByGrade' => collect($this->grades)->mapWithKeys(fn ($grade) => [$grade => $this->getSubjects($grade)])->all(),
            'divisions' => ['Ø£', 'Ø¨', 'Ø¬', 'Ø¯'],
        ]);
    }

    public function viewFile(Competition $competition, string $type)
    {
        $files = [
            'competition' => $competition->competition_file,
            'answer-key' => $competition->answer_key_file,
        ];

        abort_unless(array_key_exists($type, $files), 404);

        $path = ltrim((string) $files[$type], '/');
        abort_unless($path, 404);

        if (Storage::disk('public')->exists($path)) {
            return response()->file(Storage::disk('public')->path($path));
        }

        $publicStoragePath = public_path('storage/' . $path);
        if (file_exists($publicStoragePath)) {
            return response()->file($publicStoragePath);
        }

        abort(404, 'File not found on server storage.');
    }

    public function store(Request $request)
    {
        // Get valid divisions for this shift and grade
        $validDivisions = $this->getDivisions($request->shift, $request->grade);
        $validDivisionsString = implode(',', $validDivisions);
        $validSubjectsString = implode(',', $this->getSubjects($request->grade));

        $request->validate([
            'teacher_name' => 'required|regex:/^[\x{0600}-\x{06FF}\s]+$/u',
            'shift' => 'required|in:صباحي,مسائي',
            'grade' => 'required|in:اول,ثاني,ثالث,رابع,خامس,سادس,سابع,ثامن,تاسع',
            'subject' => 'required|in:' . $validSubjectsString,
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
