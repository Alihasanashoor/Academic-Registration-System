<?php
session_start();

$pageTitle="Login"; //set page title
$styleSheet="/Academic%20Registration%20System/resturcterd/Style/Login-Style.css";

// Include core classes
require_once __DIR__ . '/../Classes/UserManager.php'; // Include the DataManagerMock class (provides mock/hardcoded data for testing)
require_once __DIR__ .'/../Classes/User.php'; // Include the User class
require_once __DIR__ .'/../Classes/Course.php'; // Include the Course class
require_once __DIR__ .'/../Classes/Student.php'; // Include the studentclass
require_once __DIR__ .'/../Classes/Teacher.php'; // Include the Teacher class
require_once __DIR__ .'/../Classes/IDataManager.php'; //Include the IDataManager interface (ensures consistent DataManager structure)
require_once __DIR__ .'/../Classes/DataManagerMock.php'; // Include the DataManagerMock class (provides mock/hardcoded data for testing)
require_once __DIR__ .'/../Classes/DataManager.php'; // Include the DataManager class use hardcoded data if database failed
require_once __DIR__ . '/../Controllers/LoginController.php';



// Include templates
require_once __DIR__ .'/../View/Header.php' ; // Include the header template (contains HTML <head> and top structure)
require_once __DIR__ .'/../View/Login-Form.php' ;// Include the Login template for the fileds

// Handle login
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['login'])){
    $controller = new LoginController();
    $controller->Login();
}
?>