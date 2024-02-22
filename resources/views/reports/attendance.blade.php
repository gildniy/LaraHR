<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
<h1>Attendance Report</h1>
<table>
    <thead>
    <tr>
        <th>Employee Name</th>
        <th>Check-In Time</th>
        <th>Check-Out Time</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($attendances as $attendance)
    <tr>
        <td>{{ $attendance->employee->names }}</td>
        <td>{{ $attendance->check_in }}</td>
        <td>{{ $attendance->check_out }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
