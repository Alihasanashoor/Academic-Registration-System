<?php
session_start();
//AUTH CHECK
if(!($_SESSION['User_ID'] && $_SESSION['Password'])){
    header("Location: index.php");
}

$pageTitle="Register Courses"; //set page title
$cssFs = __DIR__ . '/../Style/Register-Courses-Style.css';// filesystem path to the css file
$cssUrl = '/Academic%20Registration%20System/resturcterd/Style/Register-Courses-Style.css'; //style path
// append ?v=TIMESTAMP so the browser fetches the latest file
$styleSheet = $cssUrl . '?v=' . (is_file($cssFs) ? filemtime($cssFs) : time());
// Models/Classes
require_once __DIR__ . '/../Classes/UserManager.php';
require_once __DIR__ .'/../Classes/User.php';
require_once __DIR__ .'/../Classes/Student.php';
require_once __DIR__ .'/../Classes/Course.php';
require_once __DIR__ .'/../Classes/Teacher.php';
require_once __DIR__ .'/../Classes/IDataManager.php';
require_once __DIR__ .'/../Classes/DataManagerMock.php';
require_once __DIR__ .'/../Classes/DataManager.php';
//load Controller login for the logout button
require_once __DIR__ . '/../Controllers/LoginController.php';


// Recreate student object if logged in as student

if (isset($_SESSION['Role'], $_SESSION['User_ID'], $_SESSION['Password']) && $_SESSION['Role'] === 'student') {
    $UserManager = new UserManager();
    $student = $UserManager->CreateUser($_SESSION['User_ID'], $_SESSION['Password']);
}
// Handle enroll action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['EnrollNow'])) {
    if ($student instanceof Student) {
        $student->EnrollCourse();
        
    } else {
        echo "<div style='color:red'>Error: Not logged in as student. Please re-login.</div>";
    }
}


//view
require_once __DIR__ .'/../View/Header.php' ; // Include the header template (contains HTML <head> and top structure)
require_once __DIR__ .'/../View/Register-Courses-Table.php'; //load courses data for enrollment
require_once __DIR__ .'/../View/View-Registered-Courses-Button.php'; //load a button so it gose to View Registered Courses page
require_once __DIR__ .'/../View/Logout.php'; //load logout button

// Load the logout controller responsible for handling user sign-out actions.
require_once  __DIR__.'/../Controllers/LogoutController.php';
// Execute the logout handler to terminate the current user session
// and perform any necessary cleanup or redirection. 
LogoutController::handle();


?>