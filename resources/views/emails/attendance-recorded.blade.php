<!DOCTYPE html>
<html lang="en">
<head>
    <title>Attendance Record</title>
</head>
<body>
<h2>Attendance Recorded</h2>
<p>Hello {{ $attendance->employee->names }},</p>
<p>Your attendance has been recorded at {{ $attendance->check_in }}.</p>
</body>
</html>
