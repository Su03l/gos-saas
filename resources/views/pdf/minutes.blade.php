<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: 'dejavusanscondensed', sans-serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .section-title {
            background-color: #f3f4f6;
            padding: 8px;
            font-weight: bold;
            border-right: 4px solid #1e3a8a;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 10px;
            text-align: right;
        }
        th {
            background-color: #f9fafb;
        }
        .footer {
            margin-top: 50px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
            font-size: 10pt;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>محضر اجتماع</h1>
        <h2>{{ $meeting->title }}</h2>
        <p>{{ $meeting->scheduled_start->format('Y-m-d') }}</p>
    </div>

    <div class="section-title">بيانات الاجتماع</div>
    <table>
        <tr>
            <th>اللجنة</th>
            <td>{{ $meeting->committee->name }}</td>
        </tr>
        <tr>
            <th>وقت البدء</th>
            <td>{{ $meeting->scheduled_start->format('H:i') }}</td>
        </tr>
        <tr>
            <th>وقت الانتهاء</th>
            <td>{{ $meeting->scheduled_end->format('H:i') }}</td>
        </tr>
    </table>

    <div class="section-title">الحضور</div>
    <ul>
        @foreach($meeting->committee->members as $member)
            <li>{{ $member->name }} - {{ $member->pivot->role_in_committee }}</li>
        @endforeach
    </ul>

    <div class="section-title">جدول الأعمال والقرارات</div>
    @foreach($meeting->agendaItems as $item)
        <div style="margin-bottom: 20px; border-bottom: 1px dashed #eee; padding-bottom: 10px;">
            <h3>{{ $item->order_index }}. {{ $item->title }}</h3>
            <p>{{ $item->description }}</p>
        </div>
    @endforeach

    <div class="footer">
        تم إنشاء هذا المستند تلقائياً عبر منصة حوكمة - {{ $date }}
    </div>
</body>
</html>
