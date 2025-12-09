<?php 
session_start();

$pageTitle="Assigned Courses"; //page title

// filesystem path to the css file
$cssFs = __DIR__ . '/../Style/Assigned_Courses_Style.css';
// public URL to the css file
$cssUrl = '/Academic%20Registration%20System/resturcterd/Style/Assigned_Courses_Style.css';

// append ?v=TIMESTAMP so the browser fetches the latest file
$styleSheet = $cssUrl . '?v=' . (is_file($cssFs) ? filemtime($cssFs) : time());
require_once __DIR__ . '/../View/Header.php' ; // Include the header template (contains HTML <head> and top structure)
// Models/Classes
require_once __DIR__ . '/../Classes/UserManager.php';
require_once __DIR__ .'/../Classes/User.php';
require_once __DIR__ .'/../Classes/Student.php';
require_once __DIR__ .'/../Classes/Course.php';
require_once __DIR__ .'/../Classes/Teacher.php';
require_once __DIR__ .'/../Classes/IDataManager.php';
require_once __DIR__ .'/../Classes/DataManagerMock.php';
require_once __DIR__ .'/../Classes/DataManager.php';
//load Controller for the logout button
require_once __DIR__ . '/../Controllers/LoginController.php';

//rebulid object
if (isset($_SESSION['Teacher_ID'], $_SESSION['Password']) && $_SESSION['Role'] === 'teacher') {
    $UserManager = new UserManager();
}


$Data = new Data();
if ($Data->connection) {
    // DB path later
} else {
    $teacher = $UserManager->CreateUser($_SESSION['Teacher_ID'], $_SESSION['Password']);
    $seed = $teacher->getAssignedCourses(TeacherID: $_SESSION['Teacher_ID']);
    $Assigned_Courses = $seed;
}

// Load the template that displays the students-in-course table
include __DIR__ . '/../View/Assigned-Course-template.php';

require_once __DIR__ .'/../View/Logout.php'; //load logout button

// Load the logout controller responsible for handling user sign-out actions.
require_once  __DIR__.'/../Controllers/LogoutController.php';
// Execute the logout handler to terminate the current user session
// and perform any necessary cleanup or redirection. 
LogoutController::handle();

?>
