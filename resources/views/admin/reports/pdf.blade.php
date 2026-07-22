<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>PEL System Report</title>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .header {
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #1e3a8a;
            margin: 0 0 5px 0;
            font-size: 24px;
        }
        .header p {
            margin: 0;
            color: #64748b;
            font-size: 13px;
        }
        .stats-table {
            width: 100%;
            margin-bottom: 40px;
        }
        .stats-table td {
            width: 33.33%;
            padding: 15px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            text-align: center;
        }
        .stats-table h3 {
            margin: 0 0 5px 0;
            font-size: 28px;
            color: #0f172a;
        }
        .stats-table p {
            margin: 0;
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
        }
        .section-title {
            font-size: 16px;
            color: #0f172a;
            margin-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        .data-table th, .data-table td {
            border: 1px solid #cbd5e1;
            padding: 10px;
            text-align: left;
        }
        .data-table th {
            background-color: #f1f5f9;
            color: #334155;
            font-weight: bold;
        }
        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>PEL System Analytics Report</h1>
        <p>Generated on: {{ $date }}</p>
    </div>

    <table class="stats-table">
        <tr>
            <td>
                <h3>{{ $totalInterns }}</h3>
                <p>Total Interns</p>
            </td>
            <td>
                <h3>{{ $completedTasks }}</h3>
                <p>Completed Tasks</p>
            </td>
            <td>
                <h3>{{ $attendanceRate }}%</h3>
                <p>Avg Attendance Rate</p>
            </td>
        </tr>
    </table>

    <div class="section-title">Intern Directory</div>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
            @forelse($interns as $intern)
                <tr>
                    <td>{{ $intern->id }}</td>
                    <td>{{ $intern->name }}</td>
                    <td>{{ $intern->email }}</td>
                    <td>{{ $intern->department->name ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding: 20px;">No interns found in the system.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
