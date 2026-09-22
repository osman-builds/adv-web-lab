<!DOCTYPE html>
<html>
<head>
    <title>Students</title>
</head>
<body>
    <h1>Student List</h1>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>No.</th>
                <th>Matric No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Enrolled Courses</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $student->matric_no }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->department->name }}</td>
                <td>
                    @foreach ($student->courses as $course)
                        <strong>{{ $course->code }}</strong> - {{ $course->name }}<br>
                        <small>Enrolled: {{ $course->pivot->enrolled_at }} | Grade: {{ $course->pivot->grade ?? 'Pending' }}</small><br>
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>