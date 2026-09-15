<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body style="font-family: sans-serif; margin: 30px;">
    <h2>Edit Student</h2>

    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 12px;">
            <label>Name:</label><br>
            <input type="text" name="name" value="{{ old('name', $student->name) }}" required>
        </div>

        <div style="margin-bottom: 12px;">
            <label>Email:</label><br>
            <input type="email" name="email" value="{{ old('email', $student->email) }}" required>
        </div>

        <button type="submit">Update Student</button>
        <a href="{{ route('students.index') }}" style="margin-left: 10px;">Cancel</a>
    </form>
</body>
</html>