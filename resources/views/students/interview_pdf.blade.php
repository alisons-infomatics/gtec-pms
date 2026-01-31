<!DOCTYPE html>
<html>
<head>
    <title>Student List PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h2>Student List</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th><th>Email</th><th>Phone</th><th>Attendance</th><th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($interviews as $interview)
                <tr>
                    <td>{{ $interview->GetStd->first_name.' '.$interview->GetStd->middle_name.' '.$interview->GetStd->last_name }}</td>
                    <td>{{ $interview->GetStd->email }}</td>
                    <td>{{ $interview->GetStd->mobile }}</td>
                    <td>{{ $interview->attendance }}</td>
                    <td>{{ $interview->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
