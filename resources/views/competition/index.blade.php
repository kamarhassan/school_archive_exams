<!DOCTYPE html>
<html class="loading" lang="ar" data-textdirection="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="متوسطة سحمر الاولى الرسمية مسابقات اخر السنة">
    <meta name="author" content="PIXINVENT">
    <title>متوسطة سحمر الاولى الرسمية - عرض المسابقات</title>
    <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
        rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/vendors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/app-assets/css/core/menu/menu-types/vertical-compact-menu.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/app-assets/css/core/menu/menu-types/horizontal-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/core/colors/palette-gradient.css') }}">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            direction: rtl;
        }

        .navbar-brand {
            text-align: center;
            margin: 0 auto;
        }

        .brand-text {
            white-space: normal;
            word-break: break-word;
            overflow-wrap: anywhere;
            max-width: 820px;
            display: inline-block;
            text-align: center;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .stat-card h3 {
            margin: 0 0 10px 0;
            color: #667eea;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-card .number {
            font-size: 36px;
            font-weight: bold;
            color: #333;
            margin: 10px 0;
        }

        .stat-card .percentage {
            font-size: 12px;
            color: #999;
        }

        .progress-container {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .progress-bar {
            width: 100%;
            height: 40px;
            background: #f0f0f0;
            border-radius: 8px;
            overflow: hidden;
            margin: 15px 0;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
            transition: width 0.5s ease;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .table-container h3 {
            color: #333;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 20px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background: #f5f5f5;
        }

        table th {
            padding: 15px;
            text-align: right;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #ddd;
        }

        table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }

        table tbody tr:hover {
            background: #f9f9f9;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .back-button {
            display: inline-block;
            padding: 12px 24px;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            border: 2px solid #667eea;
        }

        .back-button:hover {
            background: #667eea;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #999;
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .divisions-list {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .division-tag {
            display: inline-block;
            padding: 4px 8px;
            background: #e8f4f8;
            color: #0066cc;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .nav-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .nav-btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .nav-btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .nav-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .nav-btn-secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .nav-btn-secondary:hover {
            background: #667eea;
            color: white;
        }

        .filters-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            align-items: end;
        }

        .filter-field label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }

        .filter-field select {
            width: 100%;
            height: 42px;
            padding: 8px 10px;
            border: 1px solid #d9d9d9;
            border-radius: 6px;
            background: white;
            color: #333;
            font-size: 14px;
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-button {
            height: 42px;
            padding: 0 18px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }

        .filter-button-primary {
            background: #667eea;
            color: white;
        }

        .filter-button-secondary {
            background: #f1f3f5;
            color: #333;
        }

        .file-link {
            display: inline-block;
            padding: 8px 12px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }

        .file-link:hover {
            background: #5268c9;
            color: white;
        }
    </style>
</head>

<body class="vertical-layout vertical-compact-menu 1-column menu-expanded fixed-navbar" data-open="click"
    data-menu="vertical-compact-menu" data-col="1-column"
    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;">

    <nav
        class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-dark bg-cyan navbar-shadow navbar-brand-center">
        <div class="navbar-wrapper">
            <li class="nav-item">
                <a class="navbar-brand">
                    <h3 class="brand-text">متوسطة سحمرالاولى الرسمية - عرض المسابقات</h3>
                </a>
            </li>
        </div>
    </nav>

    <div class="app-content content" style="background: transparent; margin-top: 80px;">
        <div class="content-wrapper">
            <div class="container">
                <!-- Navigation Buttons -->
                <div class="nav-buttons">


                </div>


                <!-- Not Uploaded Table -->
             

                <!-- Competitions Details -->
                <div class="table-container">
                    <h3>فلترة تفاصيل المسابقات المرفوعة</h3>
                    <form class="filters-form" method="GET" action="{{ route('competition.index') }}">
                        <div class="filter-field">
                            <label for="filter_shift">الدوام</label>
                            <select id="filter_shift" name="shift">
                                <option value="">الكل</option>
                                @foreach ($shifts as $shift)
                                    <option value="{{ $shift }}"
                                        {{ $filters['shift'] === $shift ? 'selected' : '' }}>{{ $shift }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-field">
                            <label for="filter_grade">الصف</label>
                            <select id="filter_grade" name="grade">
                                <option value="">الكل</option>
                                @foreach ($grades as $grade)
                                    <option value="{{ $grade }}"
                                        {{ $filters['grade'] === $grade ? 'selected' : '' }}>{{ $grade }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-field">
                            <label for="filter_subject">المادة</label>
                            <select id="filter_subject" name="subject">
                                <option value="">الكل</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject }}"
                                        {{ $filters['subject'] === $subject ? 'selected' : '' }}>{{ $subject }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-field">
                            <label for="filter_division">الشعبة</label>
                            <select id="filter_division" name="division">
                                <option value="">الكل</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division }}"
                                        {{ $filters['division'] === $division ? 'selected' : '' }}>{{ $division }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-actions">
                            <button class="filter-button filter-button-primary" type="submit">بحث</button>
                            <a class="filter-button filter-button-secondary"
                                href="{{ route('competition.index') }}">إلغاء الفلتر</a>
                        </div>
                    </form>
                </div>

                @php
                    $competitionTables = [
                        ['title' => 'تفاصيل المسابقات المرفوعة - صباحي', 'items' => $competitions->where('shift', $shifts[0])],
                        ['title' => 'تفاصيل المسابقات المرفوعة - مسائي', 'items' => $competitions->where('shift', $shifts[1])],
                    ];
                @endphp

                @foreach ($competitionTables as $competitionTable)
                    <div class="table-container">
                        <h3>📋 {{ $competitionTable['title'] }}</h3>
                        @if (count($competitionTable['items']) > 0)
                            <div style="overflow-x: auto;">
                            <table>
                                <thead>
                                    <tr>
                                        <th>اسم المعلم</th>
                                        <th>الدوام</th>
                                        <th>الصف</th>
                                        <th>المادة</th>
                                        <th>الشعب</th>
                                        <th>تاريخ الرفع</th>
                                        <th>ملف المسابقة</th>
                                        <th>ملف الباريم</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($competitionTable['items'] as $comp)
                                        <tr>
                                            <td>{{ $comp->teacher_name }}</td>
                                            <td>{{ $comp->shift }}</td>
                                            <td>{{ $comp->grade }}</td>
                                            <td>{{ $comp->subject }}</td>
                                            <td>
                                                <div class="divisions-list">
                                                    @forelse($comp->divisions ?? [] as $div)
                                                        <span class="division-tag">{{ $div }}</span>
                                                    @empty
                                                        <span style="color: #999;">لا توجد شعب</span>
                                                    @endforelse
                                                </div>
                                            </td>
                                            <td>{{ $comp->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <a class="file-link"
                                                    href="{{ route('competition.file', ['competition' => $comp->id, 'type' => 'competition']) }}"
                                                    target="_blank" rel="noopener">
                                                    عرض الملف
                                                </a>
                                            </td>
                                            <td>
                                                <a class="file-link"
                                                    href="{{ route('competition.file', ['competition' => $comp->id, 'type' => 'answer-key']) }}"
                                                    target="_blank" rel="noopener">
                                                    عرض الملف
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <p>لا توجد مسابقات مرفوعة تطابق الفلتر المحدد</p>
                            </div>
                        @endif
                    </div>
                @endforeach



   <div class="table-container">
                    <h3>❌ المسابقات المتبقية ({{ $remainingCount }})</h3>
                    @if (count($notUploaded) > 0)
                        <div style="overflow-x: auto; max-height: 600px; overflow-y: auto;">
                            <table>
                                <thead>
                                    <tr>
                                        <th>الدوام</th>
                                        <th>الصف</th>
                                        <th>المادة</th>
                                        <th>الشعبة</th>
                                        <th>الحالة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notUploaded as $item)
                                        <tr>
                                            <td>{{ $item['shift'] }}</td>
                                            <td>{{ $item['grade'] }}</td>
                                            <td>{{ $item['subject'] }}</td>
                                            <td>{{ $item['division'] }}</td>
                                            <td><span class="badge badge-danger">✗ متبقي</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <p>🎉 تم رفع جميع المسابقات بنجاح!</p>
                        </div>
                    @endif
                </div>


            </div>
        </div>
    </div>

</body>

</html>
