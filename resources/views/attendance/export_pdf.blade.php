<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Attendance Records</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <h2 style="text-align:center;">Attendance Records</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                @if ($user->role != 'Viewer')
                    <th>User</th>
                @endif
                <th>Date</th>
                <th>Status</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Total Hours</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $attendance)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    @if ($user->role != 'Viewer')
                        <td>{{ $attendance->user->name }}</td>
                    @endif
                    <td>{{ $attendance->date }}</td>
                    <td>{{ $attendance->status }}</td>
                    <td>{{ $attendance->check_in ?? '-' }}</td>
                    <td>{{ $attendance->check_out ?? '-' }}</td>
                    <td>{{ $attendance->total_hours ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
