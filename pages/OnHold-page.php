<?php
session_start();
//check role if not student exit the page; 
if(!($_SESSION['User_ID'] && $_SESSION['Password'])){
    header("Location: index.php");
}
$pageTitle="On Hold Coures"; //page title

// filesystem path to the css file
$cssFs= __DIR__.'/../Style/OnHold-Style.css';
$cssUrl = '/Academic%20Registration%20System/resturcterd/Style/OnHold-Style.css';
$styleSheet = $cssUrl . '?v=' . (is_file($cssFs) ? filemtime($cssFs) : time());
require_once __DIR__ . '/../View/Header.php' ; // Include the header template (contains HTML <head> and top structure)
//Models/Class
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

//rebulid object
if (isset($_SESSION['Role'], $_SESSION['User_ID'], $_SESSION['Password']) && $_SESSION['Role'] === 'student') {
    $UserManager = new UserManager();
    $student = $UserManager->CreateUser($_SESSION['User_ID'], $_SESSION['Password']);
}


//handel Drop butoon
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST["UnEnrollNow"])){
    if($student instanceof Student){
        $student->DropCourse();
    }
}

require_once __DIR__ . '/../view/OnHold-table.php';
require_once __DIR__ .'/../View/View-Registered-Courses-Button.php'; //load a button so it gose to View Registered Courses page
require_once __DIR__ .'/../View/Logout.php'; //load logout button

// Load the logout controller responsible for handling user sign-out actions.
require_once  __DIR__.'/../Controllers/LogoutController.php';
// Execute the logout handler to terminate the current user session
// and perform any necessary cleanup or redirection. 
LogoutController::handle();
?>
