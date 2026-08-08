<!DOCTYPE html>
<html class="loading" lang="ar" data-textdirection="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>متوسطة سحمر الأولى الرسمية - سجل التلاميذ</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@500;700;800&family=IBM+Plex+Sans+Arabic:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/vendors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/css/style.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .registry {
            --ink: #223142; --paper: #fcfdff; --panel: #ffffff;
            --cedar: #2c7be5; --line: #d8dce3; --muted: #5f6b7a;
            direction: rtl; font-family: 'IBM Plex Sans Arabic', 'Tajawal', sans-serif;
            background: var(--paper); color: var(--ink); padding: 28px 20px 60px;
            max-width: 1080px; margin: 0 auto; border-radius: 18px;
        }
        .registry * { box-sizing: border-box; }
        .registry__search { background: var(--panel); border: 1px solid var(--line); border-radius: 14px; padding: 16px 18px; margin-bottom: 26px; }
        .registry .select2-container { width: 100% !important; }
        .registry__card { background: var(--panel); border: 1px solid var(--line); border-radius: 14px; padding: 20px; margin-bottom: 18px; border-right: 4px solid var(--accent, var(--cedar)); }
        .registry__card--student { --accent: #2c7be5; }
        .registry__card--father  { --accent: #1f5fb9; }
        .registry__card--mother  { --accent: #3b82f6; }
        .registry__card--status  { --accent: #5f6b7a; }
        .registry__grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px 16px; }
        @media (max-width: 720px) { .registry__grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 480px) { .registry__grid { grid-template-columns: 1fr; } }
        .registry__field { display: flex; flex-direction: column; margin-bottom: 10px; }
        .registry__field label { font-size: 12px; font-weight: 600; color: #2f3a4a; margin-bottom: 6px; }
        .registry__field input, .registry__field select { border: 1.5px solid var(--line); border-radius: 9px; padding: 9px 11px; font-size: 14px; background: var(--paper); outline: none; height: 42px; color: #223142; }
        .registry__field input:focus, .registry__field select:focus { border-color: #2c7be5; box-shadow: 0 0 0 2px rgba(44, 123, 229, 0.12); }
        .registry__field input[readonly] { background: #f5f8ff; color: var(--muted); cursor: not-allowed; }
        .btn-save { background: linear-gradient(135deg, #2c7be5 0%, #1f5fb9 100%); color: #fff; padding: 12px 30px; font-weight: bold; border-radius: 10px; border: none; cursor: pointer; font-size: 16px; box-shadow: 0 8px 20px rgba(44, 123, 229, 0.22); }
        .btn-save:hover { background: linear-gradient(135deg, #1f5fb9 0%, #174f95 100%); }
        .registry__note {
            text-align: center;
            margin: 0 0 18px;
            padding: 12px 16px;
            border-radius: 10px;
            background: #eef6ff;
            color: #1f5fb9;
            border: 1px solid #cfe0ff;
            font-weight: 600;
        }
        .alert-box { padding: 12px; border-radius: 8px; margin-bottom: 15px; display: none; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>

<body class="vertical-layout 1-column">
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-dark bg-cyan navbar-shadow navbar-brand-center">
        <div class="navbar-wrapper" style="width: 100%; display: flex; justify-content: center; align-items: center;">
            <li class="nav-item" style="list-style: none; margin: 0;">
                <a class="navbar-brand" style="display: flex; justify-content: center; align-items: center; width: 100%; margin: 0;">
                    <h3 class="brand-text" style="margin: 0; text-align: center;">متوسطة سحمر الأولى الرسمية </h3>
                </a>
            </li>
        </div>
    </nav>

    <div style="height: 8px; background: linear-gradient(90deg, #2c7be5, #5aa8ff); margin-top: 56px;"></div>

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="registry">
                
                <div id="responseMessage" class="alert-box"></div>

                <!-- البحث والتحديد -->
                <div class="registry__search">
                    <label for="student_id">بحث اسم التلميذ / رقم التلميذ (id)</label>
                    <select id="student_id" name="student_id">
                        <option value="">-- اكتب اسم  التلميذ --</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">
                                #{{ $student->id }} - {{ $student->first_name_ar }} {{ $student->father_name_ar }} {{ $student->family_name_ar }} 
                                (الصف: {{ $student->previous_grade ?? 'غير محدد' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- نموذج تعديل البيانات -->
                <form id="student_form">
                    @csrf
                    
                    <!-- الحقول المخفية لمراقبة البيانات/التتبع -->
                    <input type="hidden" id="unified_number" name="unified_number">
                    <input type="hidden" id="contact_id" name="contact_id">

                    <!-- 1. بيانات التلميذ -->
                    <div class="registry__card registry__card--student">
                        <h2>بيانات التلميذ الأساسية</h2>
                        <div class="registry__grid">
                            <div class="registry__field"><label>الاسم الأول (عربي) *</label><input type="text" id="first_name_ar" name="first_name_ar" readonly required></div>
                            <div class="registry__field"><label>الاسم الأول (إنكليزي) *</label><input type="text" id="first_name_en" name="first_name_en" required></div>
                            <div class="registry__field"><label>الشهرة (عربي) *</label><input type="text" id="family_name_ar" name="family_name_ar" readonly required></div>
                            <div class="registry__field"><label>الشهرة (إنكليزي) *</label><input type="text" id="last_name_en" name="last_name_en" required></div>
                            <div class="registry__field"><label>الصف السابق *</label><input type="text" id="previous_grade" name="previous_grade" readonly required></div>
                            <div class="registry__field"><label>تاريخ الولادة *</label><input type="date" id="date_of_birth" name="date_of_birth" readonly required></div>
                            <div class="registry__field"><label>مكان الولادة *</label><input type="text" id="place_of_birth" name="place_of_birth" readonly required></div>
                            <div class="registry__field"><label>الجنس *</label><input type="text" id="gender" name="gender" readonly required></div>
                            <div class="registry__field">
                                <label>نوع وثيقة التعريف *</label>
                                <select id="id_card_type" name="id_card_type" required>
                                    <option value="">--اختر نوع الوثيقة--</option>
                                    <option value="lebanese">السجل / لبناني</option>
                                    <option value="unhcr">امم</option>
                                    <option value="residence">اقامة</option>
                                </select>
                            </div>
                            <div class="registry__field"><label>رقم وثيقة التعريف/السجل *</label><input type="text" id="id_card_number" name="id_card_number" required></div>
                            <div class="registry__field"><label>مكان الإقامة *</label><input type="text" id="contact_location" name="contact_location" required></div>
                            <div class="registry__field"><label>الجنسية *</label><input type="text" id="nationality" name="nationality" required></div>
                        </div>
                    </div>

                    <!-- 2. بيانات الأب -->
                    <div class="registry__card registry__card--father">
                        <h2>بيانات الأب وولي الأمر</h2>
                        <div class="registry__grid">
                            <div class="registry__field"><label>اسم الأب (عربي) *</label><input type="text" id="father_name_ar" name="father_name_ar" required></div>
                            <div class="registry__field"><label>اسم الأب (إنكليزي) *</label><input type="text" id="father_name_en" name="father_name_en" required></div>
                            <div class="registry__field"><label>رقم هاتف ولي الأمر *</label><input type="text" id="guardian_phone" name="guardian_phone" required></div>
                            <div class="registry__field">
                                <label>قطاع عمل الأب *</label>
                                <select id="father_work_sector" name="father_work_sector" required>
                                    <option value="">--اختيار--</option>
                                    <option value="public">قطاع عام</option>
                                    <option value="private">قطاع خاص</option>
                                    <option value="self_employed">عمل حر</option>
                                    <option value="unemployed">عاطل عن العمل</option>
                                </select>
                            </div>
                            <div class="registry__field"><label>نوع عمل الأب / المهنة *</label><input type="text" id="father_job_type" name="father_job_type" required></div>
                        </div>
                    </div>

                    <!-- 3. بيانات الأم -->
                    <div class="registry__card registry__card--mother">
                        <h2>بيانات الأم</h2>
                        <div class="registry__grid">
                            <div class="registry__field"><label>اسم الأم الأول (عربي) *</label><input type="text" id="mother_first_name_ar" name="mother_first_name_ar" required></div>
                            <div class="registry__field"><label>اسم الأم (إنكليزي) *</label><input type="text" id="mother_name_en" name="mother_name_en" required></div>
                            <div class="registry__field"><label>عائلة الأم (عربي) *</label><input type="text" id="mother_family_name_ar" name="mother_family_name_ar" required></div>
                            <div class="registry__field"><label>عائلة الأم (إنكليزي) *</label><input type="text" id="mother_family_name_en" name="mother_family_name_en" required></div>
                            <div class="registry__field">
                                <label>قطاع عمل الأم *</label>
                                <select id="mother_work_sector" name="mother_work_sector" required>
                                    <option value="">--اختيار--</option>
                                    <option value="public">قطاع عام</option>
                                    <option value="private">قطاع خاص</option>
                                    <option value="self_employed">عمل حر</option>
                                    <option value="unemployed">عاطل عن العمل</option>
                                </select>
                            </div>
                            <div class="registry__field"><label>نوع عمل الأم / المهنة *</label><input type="text" id="mother_job_type" name="mother_job_type" required></div>
                            <div class="registry__field"><label>جنسية الأم *</label><input type="text" id="mother_nationality" name="mother_nationality" required></div>
                        </div>
                    </div>

                    <!-- 4. الحالة وأزرار الإرسال -->
                    <div class="registry__card registry__card--status">
                        <h2>الحالة والإجراءات</h2>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            {{-- <label><input type="checkbox" id="is_enable" name="is_enable" value="1"> الملف مفعّل</label> --}}
                            <button type="submit" class="btn-save">حفظ البيانات</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/app-assets/js/core/libraries/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

    <script>
        const students = @json($students->keyBy('id'));

        $(document).ready(function () {
            Swal.fire({
                title: 'تنبيه',
                text: 'عليك التأكد من المعلومات، ويمكن إدخال معلومات التلميذ مرة واحدة فقط.',
                icon: 'info',
                confirmButtonText: 'حسناً',
                customClass: {
                    confirmButton: 'btn-save'
                }
            });

            $('#student_id').select2({ placeholder: '--اختر اسم التلميذ بكتابة الاسم--', allowClear: true, dir: 'rtl' });

            const fields = [
                'unified_number', 'contact_id', 'first_name_ar', 'first_name_en',
                'family_name_ar', 'last_name_en', 'previous_grade',
                'place_of_birth', 'gender', 'id_card_type',
                'id_card_number', 'contact_location', 'nationality',
                'father_name_ar', 'father_name_en', 'guardian_phone', 'father_work_sector', 'father_job_type',
                'mother_first_name_ar', 'mother_name_en', 'mother_family_name_ar',
                'mother_family_name_en', 'mother_work_sector', 'mother_job_type',
                'mother_nationality'
            ];

            // جلب وتعبئة بيانات الطالب
            $('#student_id').on('change', function () {
                const selectedId = $(this).val();
                if (!selectedId || !students[selectedId]) {
                    $('#student_form')[0].reset();
                    return;
                }

                const s = students[selectedId];
                fields.forEach(f => $('#' + f).val(s[f] ?? ''));

                if (s.date_of_birth) {
                    $('#date_of_birth').val(s.date_of_birth.toString().split('T')[0].split(' ')[0]);
                }
                $('#is_enable').prop('checked', Boolean(s.is_enable));
            });

            // إرسال البيانات عبر AJAX للـ Controller
            $('#student_form').on('submit', function (e) {
                e.preventDefault();

                const studentId = $('#student_id').val();
                if (!studentId) {
                    alert('يرجى اختيار تلميذ أولاً!');
                    return;
                }

                $.ajax({
                  url: "{{ url('students') }}/" + studentId,
                    type: 'POST',
                    data: $(this).serialize() + '&_method=PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        $('#responseMessage').removeClass('alert-danger').addClass('alert-success')
                            .text(res.message).show();
                        window.scrollTo(0, 0);
                    },
                    error: function (xhr) {
                        let errors = xhr.responseJSON ? xhr.responseJSON.errors : null;
                        let msg = 'حدث خطأ أثناء الحفظ، يرجى التأكد من ملء جميع الحقول الإلزامية.';
                        if (errors) {
                            msg = Object.values(errors).flat().join('<br>');
                        }
                        $('#responseMessage').removeClass('alert-success').addClass('alert-danger')
                            .html(msg).show();
                        window.scrollTo(0, 0);
                    }
                });
            });
        });
    </script>
</body>
</html>