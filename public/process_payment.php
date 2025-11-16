<?php
//Require the controller class (adjust path if your tree differs)
require_once __DIR__ . '/../Controllers/PaymentsController.php';
//load the LoginController from the Controllers directory
require_once __DIR__ . '/../Controllers/LoginController.php';

//Only accept POST, reject direct GET access
//If someone accidentally navigates to process_payment.php directly, they’re sent back to a safe page instead of seeing a blank page or an error.

/*if($_SERVER['REQUEST_METHOD'] !=='POST'){
    header('Location: /Academic%20Registration%20System/resturcterd/View/View-Registered-Courses.php');
    exit;
}*/
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['Logout'])){
                $controller = new LoginController();
                $controller->Logout();
            }
//crate the controller
$paymentsController = new PaymentsController();
$paymentsController->payCourse();
?>