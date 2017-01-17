<?php

namespace App\Http\Controllers;

use App\Course;
use App\Student;


class CourseStudentController extends Controller
{
    public function index($course_id)
    {
    	$course = Course::find($course_id);

        if($course)
        {
            $students = $course->students;

            return $this->createSuccessResponse($students, 200);
        }

        return $this->createErrorResponse('The course with the given id does not exist', 404);
    }

    public function store($course_id, $student_id)
    {
    	$course = Course::find($course_id);

        if($course)
        {
            $student = Student::find($student_id);

            if($student)
            {
                if($course->students()->find($student_id))
                {
                    return $this->createErrorResponse("The student with the id {$student_id} already exists in the course with id {$course_id}", 409);
                }
                $course->students()->attach($student_id);

                return $this->createSuccessResponse("The student with id {$student_id} has been added to the course with id {$course_id}", 201);
            }

            return $this->createErrorResponse("The student with the given id does not exist", 404);
        }

        return $this->createErrorResponse("The course with the given id does not exist", 404);
    }

    public function destroy($course_id, $student_id)
    {
    	$course = Course::find($course_id);

        if($course)
        {
            $student = Student::find($student_id);

            if($student)
            {
                if($course->students()->find($student_id))
                {
                    $course->students()->detach($student_id);
                    return $this->createSuccessResponse("The student with the id {$student_id} has been removed from the course with id {$course_id}", 200);
                }

                return $this->createErrorResponse("The student with id {$student_id} does not exist in the course with id {$course_id}", 409);
            }

            return $this->createErrorResponse("The student with the given id does not exist", 404);
        }

        return $this->createErrorResponse("The course with the given id does not exist", 404);
    }


}
