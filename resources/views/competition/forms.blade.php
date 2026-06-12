 <style>
     /* Modern Radio Button Design */
     .skin input[type="radio"] {
         display: none;
     }

     /* Modern Checkbox Design */
     .skin input[type="checkbox"] {
         display: none;
     }

     .skin label {
         display: inline-block;
         padding: 12px 24px;
         margin: 8px;
         border: 2px solid #e0e0e0;
         border-radius: 8px;
         background: #ffffff;
         color: #333;
         font-weight: 500;
         cursor: pointer;
         transition: all 0.3s ease;
         user-select: none;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
         position: relative;
         min-width: 90px;
         text-align: center;
     }

     .skin label:hover {
         border-color: #3498db;
         box-shadow: 0 4px 12px rgba(52, 152, 219, 0.15);
         transform: translateY(-2px);
         background: #f8fbff;
     }

     .skin input[type="radio"]:checked+label {
         background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
         color: #ffffff;
         border-color: #2980b9;
         box-shadow: 0 6px 16px rgba(52, 152, 219, 0.3);
         font-weight: 600;
     }

     .skin input[type="checkbox"]:checked+label {
         background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
         color: #ffffff;
         border-color: #2980b9;
         box-shadow: 0 6px 16px rgba(52, 152, 219, 0.3);
         font-weight: 600;
     }

     .skin input[type="radio"]:checked+label::before {
         content: "✓";
         position: absolute;
         right: 10px;
         top: 50%;
         transform: translateY(-50%);
         font-size: 18px;
         font-weight: bold;
     }

     .skin input[type="checkbox"]:checked+label::before {
         content: "✓";
         position: absolute;
         right: 10px;
         top: 50%;
         transform: translateY(-50%);
         font-size: 18px;
         font-weight: bold;
     }

     .skin input[type="radio"]:focus+label {
         outline: 2px solid #3498db;
         outline-offset: 2px;
     }

     .skin input[type="checkbox"]:focus+label {
         outline: 2px solid #3498db;
         outline-offset: 2px;
     }

     .skin.skin-square label {
         border-radius: 8px;
     }

     .controls {
         padding: 20px;
     }

     @media (max-width: 768px) {
         .skin label {
             padding: 10px 16px;
             margin: 6px;
             font-size: 14px;
             min-width: 70px;
         }
     }

     /* Center content on page */
     .card-header .card-title {
         text-align: center;
         margin: 0;
     }

     .card-body {
         text-align: center;
     }

     .form-group {
         text-align: center;
     }

     .form-group label {
         display: block;
         text-align: center;
         margin-bottom: 10px;
         font-weight: 500;
     }

     .form-group input[type="text"] {
         max-width: 400px;
         margin: 0 auto;
         display: block;
     }

     section.row {
         justify-content: center;
     }

     section.row .col-sm-12 {
         display: flex;
         justify-content: center;
     }

     section.row .card {
         width: 100%;
         max-width: 900px;
     }

     /* Submit button design */
     .btn-submit {
         display: block;
         width: 100%;
         max-width: 900px;
         padding: 14px 24px;
         margin: 22px auto;
         background: linear-gradient(135deg, #28a7e9 0%, #1f83c4 100%);
         color: #fff;
         border: none;
         border-radius: 10px;
         font-size: 18px;
         font-weight: 700;
         cursor: pointer;
         box-shadow: 0 8px 20px rgba(31, 131, 196, 0.25);
         transition: transform 0.15s ease, box-shadow 0.15s ease, opacity 0.15s ease;
         text-align: center;
     }

     .btn-submit:hover {
         transform: translateY(-3px);
         box-shadow: 0 12px 28px rgba(31, 131, 196, 0.28);
     }

     .btn-submit:active {
         transform: translateY(-1px);
         opacity: 0.95;
     }

     .btn-submit:focus {
         outline: 3px solid rgba(40, 167, 233, 0.18);
         outline-offset: 2px;
     }

     /* Required field asterisk in red */
     .required-star {
         color: #e74c3c;
         font-weight: bold;
     }

     /* Error messages styling */
     .error-message {
         color: #e74c3c;
         font-size: 14px;
         margin-top: 8px;
         display: block;
         text-align: center;
     }

     .alert-danger {
         background-color: #f8d7da;
         border: 1px solid #f5c6cb;
         border-radius: 8px;
         color: #721c24;
         padding: 15px;
         margin-bottom: 20px;
         text-align: center;
     }

     .alert-danger ul {
         list-style: none;
         padding: 0;
         margin: 0;
     }

     .alert-danger li {
         margin: 5px 0;
     }
 </style>

 <form class="form-horizontal" enctype="multipart/form-data" method="POST"
     action="{{ route('competition.store') }}">
    @csrf
    
    <!-- Loading overlay (hidden by default) -->
    <div id="loading-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:9999;align-items:center;justify-content:center;">
        <div style="background:#fff;padding:18px 22px;border-radius:10px;display:flex;align-items:center;gap:12px;box-shadow:0 6px 20px rgba(0,0,0,0.12);">
            <div style="width:28px;height:28px;border:4px solid #f3f3f3;border-top:4px solid #1f83c4;border-radius:50%;animation:spin 1s linear infinite"></div>
            <div style="font-weight:700;color:#333">جاري الرفع...</div>
        </div>
    </div>
    <style>@keyframes spin{to{transform:rotate(360deg)}}</style>
     @if ($errors->any())
         <section class="row">
             <div class="col-sm-12">
                 <div class="alert alert-danger">
                     <strong>يوجد أخطاء:</strong>
                     <ul>
                         @foreach ($errors->all() as $error)
                             <li>{{ $error }}</li>
                         @endforeach
                     </ul>
                 </div>
             </div>
         </section>
     @endif
     
     @if (session('success'))
         <section class="row">
             <div class="col-sm-12">
                 <div style="background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 8px; color: #155724; padding: 15px; margin-bottom: 20px; text-align: center;">
                     {{ session('success') }}
                 </div>
             </div>
         </section>
     @endif

     @if (session('error'))
         <section class="row">
             <div class="col-sm-12">
                 <div style="background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; color: #721c24; padding: 15px; margin-bottom: 20px; text-align: center;">
                     {{ session('error') }}
                 </div>
             </div>
         </section>
     @endif

     <section class="row">
         <div class="col-sm-12">
             <!-- Teacher Name -->
             <div id="teacher" class="card">
                 <div class="card-header">
                     <h5 class="card-title">اسم المعلم</h5>
                 </div>
                 <div class="card-body">
                     <div class="form-group">
                         <label for="teacher_name">اسم المعلم <span class="required-star">*</span></label>
                         <input type="text" class="form-control" id="teacher_name" name="teacher_name"
                             placeholder="أدخل اسم المعلم" value="{{ old('teacher_name') }}" required>
                     </div>

                     <div class="form-group">
                         <label for="shift"> الدوام <span class="required-star">*</span></label>
                         <div class="controls text-center">
                             <div class="skin skin-square d-inline-block">
                                 <input type="radio" value="صباحي" name="shift" required id="shift_morning" {{ old('shift') === 'صباحي' ? 'checked' : '' }}>
                                 <label for="shift_morning">صباحي</label>
                             </div>
                             <div class="skin skin-square d-inline-block">
                                 <input type="radio" value="مسائي" name="shift" id="shift_evening" required {{ old('shift') === 'مسائي' ? 'checked' : '' }}>
                                 <label for="shift_evening">مسائي</label>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>


     <section class="row">
         <div class="col-sm-12">
             <!-- Kick start -->
             <div id="kick-start" class="card">
                 <div class="card-header">
                     <h5 class="card-title">   الصف <span class="required-star">*</span></h5>
                 </div>

                 <div class="controls text-center">
                     <div class="skin skin-square d-inline-block">
                         <input type="radio" value="اول" name="grade" required id="grade_1" {{ old('grade') === 'اول' ? 'checked' : '' }}>
                         <label for="grade_1">اول</label>
                     </div>
                     <div class="skin skin-square d-inline-block">
                         <input type="radio" value="ثاني" name="grade" id="grade_2" required {{ old('grade') === 'ثاني' ? 'checked' : '' }}>
                         <label for="grade_2">ثاني</label>
                     </div>
                     <div class="skin skin-square d-inline-block">
                         <input type="radio" value="ثالث" name="grade" id="grade_3" required {{ old('grade') === 'ثالث' ? 'checked' : '' }}>
                         <label for="grade_3">ثالث</label>
                     </div>
                     <div class="skin skin-square d-inline-block">
                         <input type="radio" value="رابع" name="grade" id="grade_4" required {{ old('grade') === 'رابع' ? 'checked' : '' }}>
                         <label for="grade_4">رابع</label>
                     </div>
                     <div class="skin skin-square d-inline-block">
                         <input type="radio" value="خامس" name="grade" id="grade_5" required {{ old('grade') === 'خامس' ? 'checked' : '' }}>
                         <label for="grade_5">خامس</label>
                     </div>
                     <div class="skin skin-square d-inline-block">
                         <input type="radio" value="سادس" name="grade" id="grade_6" required {{ old('grade') === 'سادس' ? 'checked' : '' }}>
                         <label for="grade_6">سادس</label>
                     </div>
                     <div class="skin skin-square d-inline-block">
                         <input type="radio" value="سابع" name="grade" id="grade_7" required {{ old('grade') === 'سابع' ? 'checked' : '' }}>
                         <label for="grade_7">سابع</label>
                     </div>
                     <div class="skin skin-square d-inline-block">
                         <input type="radio" value="ثامن" name="grade" id="grade_8" required {{ old('grade') === 'ثامن' ? 'checked' : '' }}>
                         <label for="grade_8">ثامن</label>
                     </div>
                     <div class="skin skin-square d-inline-block">
                         <input type="radio" value="تاسع" name="grade" id="grade_9" required {{ old('grade') === 'تاسع' ? 'checked' : '' }}>
                         <label for="grade_9">تاسع</label>
                     </div>
                 </div>

             </div>
     </section>
     <section class="row">
         <div class="col-sm-12">
             <!-- Subjects -->
             <div id="subjects" class="card">
                 <div class="card-header">
                     <h5 class="card-title">المواد الدراسية <span class="required-star">*</span></h5>
                 </div>
                 <div class="card-body">
                     <div class="controls text-center">
                         <div class="skin skin-square d-inline-block">
                             <input type="radio" value="عربي" name="subject" required id="subject_1" {{ old('subject') === 'عربي' ? 'checked' : '' }}>
                             <label for="subject_1">عربي</label>
                         </div>
                         <div class="skin skin-square d-inline-block">
                             <input type="radio" value="انكليزي" name="subject" id="subject_2" required {{ old('subject') === 'انكليزي' ? 'checked' : '' }}>
                             <label for="subject_2">انكليزي</label>
                         </div>
                         <div class="skin skin-square d-inline-block">
                             <input type="radio" value="رياضيات" name="subject" id="subject_3" required {{ old('subject') === 'رياضيات' ? 'checked' : '' }}>
                             <label for="subject_3">رياضيات</label>
                         </div>
                         <div class="skin skin-square d-inline-block">
                             <input type="radio" value="تاريخ" name="subject" id="subject_4" required {{ old('subject') === 'تاريخ' ? 'checked' : '' }}>
                             <label for="subject_4">تاريخ</label>
                         </div>
                         <div class="skin skin-square d-inline-block">
                             <input type="radio" value="جغرافيا" name="subject" id="subject_5" required {{ old('subject') === 'جغرافيا' ? 'checked' : '' }}>
                             <label for="subject_5">جغرافيا</label>
                         </div>
                         <div class="skin skin-square d-inline-block">
                             <input type="radio" value="تربية" name="subject" id="subject_6" required {{ old('subject') === 'تربية' ? 'checked' : '' }}>
                             <label for="subject_6">تربية</label>
                         </div>
                         <div class="skin skin-square d-inline-block">
                             <input type="radio" value="علوم" name="subject" id="subject_7" required {{ old('subject') === 'علوم' ? 'checked' : '' }}>
                             <label for="subject_7">علوم</label>
                         </div>
                         <div class="skin skin-square d-inline-block">
                             <input type="radio" value="فيزياء" name="subject" id="subject_8" required {{ old('subject') === 'فيزياء' ? 'checked' : '' }}>
                             <label for="subject_8">فيزياء</label>
                         </div>
                         <div class="skin skin-square d-inline-block">
                             <input type="radio" value="كيمياء" name="subject" id="subject_9" required {{ old('subject') === 'كيمياء' ? 'checked' : '' }}>
                             <label for="subject_9">كيمياء</label>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>
     <section class="row">
         <div class="col-sm-12">
             <!-- Division -->
             <div id="division" class="card">
                 <div class="card-header">
                     <h5 class="card-title">الشعب(يمكن تحديد اكثر شعبة) <span class="required-star">*</span></h5>
                 </div>
                 <div class="card-body">
                     <div class="controls text-center">
                         <div class="skin skin-square d-inline-block">
                             <input type="checkbox" value="أ" name="divisions[]" id="division_1" {{ in_array('أ', old('divisions', [])) ? 'checked' : '' }}>
                             <label for="division_1">أ</label>
                         </div>
                         <div class="skin skin-square d-inline-block">
                             <input type="checkbox" value="ب" name="divisions[]" id="division_2" {{ in_array('ب', old('divisions', [])) ? 'checked' : '' }}>
                             <label for="division_2">ب</label>
                         </div>
                         <div class="skin skin-square d-inline-block">
                             <input type="checkbox" value="ج" name="divisions[]" id="division_3" {{ in_array('ج', old('divisions', [])) ? 'checked' : '' }}>
                             <label for="division_3">ج</label>
                         </div>
                         <div class="skin skin-square d-inline-block">
                             <input type="checkbox" value="د" name="divisions[]" id="division_4" {{ in_array('د', old('divisions', [])) ? 'checked' : '' }}>
                             <label for="division_4">د</label>
                         </div>
                         <div class="skin skin-square d-inline-block">
                             <input type="checkbox" value="و" name="divisions[]" id="division_5" {{ in_array('و', old('divisions', [])) ? 'checked' : '' }}>
                             <label for="division_5">و</label>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>
     <section class="row">
         <div class="col-sm-12">
             <!-- File Uploads -->
             <div id="uploads" class="card">
                 <div class="card-header">

                 </div>
                 <div class="card-body">
                     <div class="form-group">
                         <label for="competition_file">ملف المسابقة (PDF فقط) <span class="required-star">*</span></label>
                         <input type="file" class="form-control-file" id="competition_file"
                             name="competition_file" accept=".pdf" required>
                     </div>

                 </div>
             </div>
         </div>
     </section>
     <section class="row">
         <div class="col-sm-12">
             <!-- File Uploads -->
             <div id="uploads" class="card">
                 <div class="card-header">

                 </div>
                 <div class="card-body">

                     <div class="form-group">
                         <label for="answer_key_file">ملف الباريم (PDF فقط) <span class="required-star">*</span></label>
                         <input type="file" class="form-control-file" id="answer_key_file" name="answer_key_file"
                             accept=".pdf" required>
                     </div>
                 </div>
             </div>
         </div>
     </section>
    <button type="submit" class="btn-submit" id="submit-button">رفع</button>
    <script>
        (function(){
            document.addEventListener('DOMContentLoaded', function(){
                var form = document.querySelector('form.form-horizontal');
                var overlay = document.getElementById('loading-overlay');
                var submitBtn = document.getElementById('submit-button');

                if(!form || !overlay || !submitBtn) return;

                // Ensure overlay is hidden on initial load
                overlay.style.display = 'none';

                form.addEventListener('submit', function(){
                    // show overlay and disable button while submitting
                    overlay.style.display = 'flex';
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.8';
                });

                // If there is a success or error alert on the page (server response), stop loading
                setTimeout(function(){
                    var hasAlert = document.querySelector('.alert') || document.querySelector('[style*="background-color: #d4edda"]') || document.querySelector('[style*="background-color: #f8d7da"]');
                    if(hasAlert){
                        overlay.style.display = 'none';
                        submitBtn.disabled = false;
                        submitBtn.style.opacity = '';
                    }
                }, 50);
            });
        })();
    </script>
 </form>
