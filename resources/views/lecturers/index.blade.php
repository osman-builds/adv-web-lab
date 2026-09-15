<!DOCTYPE html>
<html>
<head>
    <title>Lecturer Directory</title>
</head>
<body style="font-family: sans-serif; margin: 30px;">
    <h2>Lecturer List</h2>
    <p><a href="{{ route('students.index') }}">&larr; Go to Students Management</a></p>

    <table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr style="background: #f3f4f6;">
                <th>ID</th>
                <th>Name</th>
                <th>Staff ID</th>
                <th>Email</th>
                <th>Total Assigned</th>
                <th>Assigned Courses</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lecturers as $lecturer)
                <tr>
                    <td>{{ $lecturer->id }}</td>
                    <td><strong>{{ $lecturer->name }}</strong></td>
                    <td>{{ $lecturer->staffID }}</td>
                    <td>{{ $lecturer->email }}</td>
                    <td>{{ $lecturer->courses->count() }} course(s)</td>
                    <td>
                        @forelse($lecturer->courses as $course)
                            <span style="background: #e0f2fe; color: #0369a1; padding: 2px 6px; border-radius: 4px; font-weight: bold; margin-right: 5px;">
                                {{ $course->code }}
                            </span>
                        @empty
                            <span style="color: #9ca3af;">No assigned courses</span>
                        @endforelse
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No lecturers registered.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>