<!DOCTYPE html>
<html>
<head>
    <title>Departments</title>
</head>
<body>
    <h1>Department List</h1>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>No.</th>
                <th>Code</th>
                <th>Name</th>
                <th>No. of Students</th>
                <th>Unique Enrolled Courses</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departments as $dept)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $dept->code }}</td>
                <td>{{ $dept->name }}</td>
                <td>{{ $dept->students->count() }}</td>
                <td>
                    {{-- Flatten all enrolled courses across students in this department and count unique IDs --}}
                    {{ $dept->students->flatMap->courses->unique('id')->count() }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>