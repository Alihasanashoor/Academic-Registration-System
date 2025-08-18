<?php 
session_start();

$pageTitle="Students in Coures"; //set page title
$styleSheet = "/Academic%20Registration%20System/resturcterd/Style/Student-Table.css"; //style path

require_once __DIR__ .'/..View/Header.php' ; // Include the header template (contains HTML <head> and top structure)

require_once __DIR__ .'/../Classes/IDataManager.php'; //Include the IDataManager interface (ensures consistent DataManager structure)

require_once __DIR__ .'../Classes/DataManagerMock.php'; // Include the DataManagerMock class (provides mock/hardcoded data for testing)

// Fetch the list of students enrolled in the specified course
$studentsInCourse = DataManagerMock::getStudentINcourse("AI101");

// Load the template that displays the students-in-course table
include __DIR__ . '../View/Students-in-Course-template.php';

?>
