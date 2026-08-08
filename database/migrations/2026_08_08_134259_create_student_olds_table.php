<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_olds', function (Blueprint $table) {
            $table->id();
       
            // رقم الموحد / معرّف الاتصال
            $table->string('unified_number')->nullable();      // رقم الموحد
            $table->string('contact_id')->nullable();           // معرّف الاتصال (Contact ID)
 
            // بيانات التلميذ
            $table->string('first_name_ar')->nullable();        // الاسم الأوّل
            $table->string('first_name_en')->nullable();        // name
            $table->string('family_name_ar')->nullable();       // الشهرة
            $table->string('last_name_en')->nullable();         // last name
 
            // الصفوف والنتائج
            $table->string('previous_grade')->nullable();       // الصف القديم
            $table->string('current_grade')->nullable();        // الصف الحالي
            $table->string('previous_result')->nullable();      // النتيجة السابقة
 
            // بيانات شخصية
            $table->date('date_of_birth')->nullable();          // تاريخ الولادة
            $table->string('place_of_birth')->nullable();       // محلّ الولادة
            $table->string('gender')->nullable();                // الجنس
            $table->string('id_card_type')->nullable();         // نوع بطاقة التعريف
            $table->string('id_card_number')->nullable();       // رقم السجل/البطاقة
            $table->string('contact_location')->nullable();     // موقع الاتصال/البلدة
            $table->string('nationality')->nullable();          // الجنسية
 
            // بيانات الأب
            $table->string('father_name_ar')->nullable();       // اسم الأب
            $table->string('father_name_en')->nullable();       // father name
            $table->string('guardian_phone')->nullable();       // رقم هاتف ولي أمر التلميذ
            $table->string('father_work_sector')->nullable();   // قطاع عمل الأب
            $table->string('father_job_type')->nullable();   // قطاع عمل الأب
 
            // بيانات الأم
            $table->string('mother_first_name_ar')->nullable(); // اسم (الأم)
            $table->string('mother_name_en')->nullable();       // mothername
            $table->string('mother_family_name_ar')->nullable();    // شهرة الام
            $table->string('mother_family_name_ar_alt')->nullable(); // شهرة الام (مكرر في الملف الأصلي)
            $table->string('mother_family_name_en')->nullable();     // شهرة الام بالانكليزية
            $table->string('mother_work_sector')->nullable();   // قطاع عمل الأم
            $table->string('mother_nationality')->nullable();   // جنسية الأم
            $table->string('mother_job_type')->nullable();   // جنسية الأم
 $table->boolean('is_enable')->default(1);           // 1 = enable, 0 = disable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_olds');
    }
};
