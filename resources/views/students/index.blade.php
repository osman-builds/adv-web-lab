<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
</head>
<body style="font-family: sans-serif; margin: 30px;">
    <h2>Add New Student</h2>
    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        <div>
            <input type="text" name="name" placeholder="Student Name" required>
            <input type="email" name="email" placeholder="Student Email" required>
            <button type="submit">Add Student</button>
        </div>
    </form>

    <hr style="margin: 20px 0;">

    <h2>Enrolled Students</h2>
    <ul>
        @forelse($students as $student)
            <li style="margin-bottom: 8px;">
                <strong>{{ $student->name }}</strong> — {{ $student->email }}
                
                <a href="{{ route('students.edit', $student->id) }}" style="margin-left: 10px;">Edit</a>

                <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline; margin-left: 5px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @empty
            <li>No students added yet.</li>
        @endforelse
    </ul>
</body>
</html>