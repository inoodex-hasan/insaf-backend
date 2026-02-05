<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Course, University};

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view-courses')->only(['index']);
        $this->middleware('can:create-course')->only(['create', 'store']);
        $this->middleware('can:update-course')->only(['edit', 'update']);
        $this->middleware('can:delete-course')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $this->authorize('view-courses');

        $query = Course::with('university');

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $courses = $query->latest()->paginate(15)->withQueryString();

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $this->authorize('create-course');

        $universities = University::where('status', 1)->orderBy('name')->get();

        return view('admin.courses.create', compact('universities'));
    }

    public function store(Request $request)
    {
        $this->authorize('create-course');

        $validated = $this->validateCourse($request);

        Course::create($validated);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        $this->authorize('update-course');

        $universities = University::where('status', 1)->orderBy('name')->get();

        return view('admin.courses.edit', compact('course', 'universities'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorize('update-course');

        $validated = $this->validateCourse($request);

        $course->update($validated);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete-course');

        $course->delete();

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    private function validateCourse(Request $request): array
    {
        return $request->validate([
            'university_id' => ['required', 'exists:universities,id'],
            'name' => ['required', 'string', 'max:255'],
            'degree_level' => ['nullable', 'string', 'max:100'],
            'duration' => ['nullable', 'string', 'max:100'],
            'tuition_fee' => ['nullable', 'numeric'],
            'intake' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'boolean'],
        ]);
    }
}
