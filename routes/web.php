<?php
use App\Student;
use App\Grade;
use App\Course;

Route::get('/', function () {
    return view('index');
});

Route::get('/get-students', function () {
    try {
        $students = [];
        foreach(App\Grade::all()->all() as $index => $Grade) {
            $Student =  $Grade->student();
            if (! $Student instanceof Student) {
                throw new \Exception('Student not found');
            }

            $Course = $Grade->course();
            if (! $Course instanceof Course) {
                throw new \Exception('Course not found');
            }

            $students[] = [
                'id' => $Grade->id,
                'name' => $Student->name,
                'course' => $Course->name,
                'grade' => $Grade->grade,
            ];
        }
    } catch (Exception $e) {
        throw $e;
    }


    return response()->json($students);
});

Route::post('/create', function (\Illuminate\Http\Request $request) {
    $input = $request->all();

    $Student = new Student();
    $Student->name = $input['name'];
    $Student->active = true;
    $Student->save();

    $Course = new Course();
    $Course->name = $input['course'];
    $Course->save();

    $Grade = new Grade();
    $Grade->grade = (int)$input['grade'];
    $Grade->student_id = $Student->id;
    $Grade->course_id = $Course->id;
    $Grade->save();

    return response()->json(['success' => true]);
});

Route::post('/delete', function (\Illuminate\Http\Request $request) {
    $Grade = Grade::find($request->all()['grade_id']);
    if (! $Grade instanceof Grade) {
        throw new Exception('Grade Record not found');
    }

    $Grade->delete();
    return response()->json(['success' => true]);
});

