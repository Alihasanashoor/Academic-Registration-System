<?php
interface IDataManager{
    /** Returns a list of users that can log in as students */
    public static function getstudents(): array;

    /**  return a list of Users that can log in as Teachers */
    public static function getTeachers(): array;
    
    /** return a list of courses that can be enrolled in */
    public static function ShowAvailableCourses(): array;

    /** return a list of courses that the teachers tech */
    public static function getAssignedCourses($TeacherID): array;

    /** return a list of students that are registered in courses */
    public static function getStudentINcourse($CouresID): array;

    /** return a list of registered courses a single user registered in */ 
    public static function ShowRegisteredCourse($Student_ID): array;

    

}


?>