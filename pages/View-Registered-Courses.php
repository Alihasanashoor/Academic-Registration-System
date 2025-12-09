<?php
session_start();

//check role if not student exit the page; 
if(!($_SESSION['User_ID'] && $_SESSION['Password'])){
    header("Location: index.php");
}

$pageTitle="View Registerd Coures"; //page title

// filesystem path to the css file
$cssFs = __DIR__ . '/../Style/View-Registerd-Courses-Style.css';
// public URL to the css file
$cssUrl = '/Academic%20Registration%20System/resturcterd/Style/View-Registerd-Courses-Style.css';

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
if (isset($_SESSION['Role'], $_SESSION['User_ID'], $_SESSION['Password']) && $_SESSION['Role'] === 'student') {
    $UserManager = new UserManager();
    $student = $UserManager->CreateUser($_SESSION['User_ID'], $_SESSION['Password']);
}

// Load the logout controller responsible for handling user sign-out actions.
require_once  __DIR__.'/../Controllers/LogoutController.php';
// Execute the logout handler to terminate the current user session
// and perform any necessary cleanup or redirection. 
LogoutController::handle();

//handel Drop butoon
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST["UnEnrollNow"])){
    if($student instanceof Student){
        $student->DropCourse();
    }
}

/*Checks if the current user’s registered courses are in the session.
If so, sets $registeredCourses to that list; otherwise, it’s just an empty array.*/
//for database connection 

$Data = new Data();
if ($Data->connection) {
    // DB path later
} else {
    $seed=DataManagerMock::ShowRegisteredCourse($_SESSION['User_ID']);
    $_SESSION['UserCourse'] = is_array($seed)? $seed :[];
    
}

//viwe
require_once __DIR__ . '/../view/ShowRegisteredCourseTable_Template.php';
require_once __DIR__ .'/../View/Register-Courses-Button.php'; //load a button so it gose to Register Courses page
require_once __DIR__ .'/../View/OnHold-Button.php'; //load a button so it gose to Register Courses page
require_once __DIR__ .'/../View/Logout.php'; //load logout button




?>