<!DOCTYPE html>
<html>
<head>
    <title>Courses</title>
</head>
<body>
    <h1>Course List</h1>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>No.</th>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Credit Hours</th>
                <th>Enrolled Students</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $course->code }}</td>
                <td>{{ $course->name }}</td>
                <td>{{ $course->credit_hours }}</td>
                <td>{{ $course->students_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>