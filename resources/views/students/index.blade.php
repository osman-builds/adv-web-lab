<!DOCTYPE html>
<html>
<head>
    <title>Student Management</title>
</head>
<body style="font-family: sans-serif; margin: 30px;">
    <p><a href="{{ route('lecturers.index') }}">View Lecturer Directory &rarr;</a></p>

    <h2>Add New Student</h2>
    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        <div style="display: flex; gap: 10px; align-items: center;">
            <input type="text" name="name" placeholder="Student Name" required>
            <input type="email" name="email" placeholder="Student Email" required>
            
            <select name="course_id">
                <option value="">-- Select Course (Optional) --</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->title }}</option>
                @endforeach
            </select>

            <button type="submit">Add Student</button>
        </div>
    </form>

    <hr style="margin: 25px 0;">

    <h2>Enrolled Students</h2>
    <ul>
        @forelse($students as $student)
            <li style="margin-bottom: 12px;">
                <strong>{{ $student->name }}</strong> — {{ $student->email }}
                
                @if($student->course)
                    <span style="background: #e0f2fe; color: #0369a1; padding: 3px 8px; border-radius: 4px; font-size: 0.85em; font-weight: bold; margin-left: 8px;">
                        {{ $student->course->code }}
                    </span>
                @else
                    <span style="color: #9ca3af; font-size: 0.85em; margin-left: 8px;">(No Course)</span>
                @endif
                
                <a href="{{ route('students.edit', $student->id) }}" style="margin-left: 12px;">Edit</a>

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