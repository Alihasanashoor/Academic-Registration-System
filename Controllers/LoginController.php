<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../Classes/UserManager.php';
require_once __DIR__ .'/../Classes/User.php';
require_once __DIR__ .'/../Classes/Student.php';
require_once __DIR__ .'/../Classes/Course.php';
require_once __DIR__ .'/../Classes/Teacher.php';

class LoginController{
    public function Login(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
        
        $User_ID=$_POST['User_ID']; //name of the felid must be User_ID
        $Password=$_POST['Password']; //name of the felid must be Password
        
        //call the CreateUser function and save the data in variable UserObj
        $UserManager = new UserManager();
        $UserObj = $UserManager->CreateUser($User_ID, $Password);
        
        //check if UserObj is student
        if($UserObj instanceof Student){
            //if yes set session user_id to user_id & set session role to student  
            
            $_SESSION['User_ID']=$User_ID;
            $_SESSION['Password']=$Password;
            $_SESSION['Role'] = "student";
            
            
            
            //go to Register Courses page
            header("Location: View-Registered-Courses.php"); //will change it to the correct page when its crated
            exit;
        }
        //check if UserObj is teacher
        elseif($UserObj instanceof Teacher){
            //if yes set session user_id to user_id 
            $_SESSION['Teacher_ID']=$User_ID;
            $_SESSION['User_ID']    = $User_ID;    // unify ID reference
            $_SESSION['Password']   = $Password;
            $_SESSION['Role']       = "teacher";
            //call authorizeAsTeacher from teacher class to check is the role teacher
            $UserObj->authorizeAsTeacher($_SESSION['Teacher_ID'],$Password);
        }
        
        }
        
    }
    //function to do the Logout process
    public function Logout(){
        if($_SERVER['REQUEST_METHOD']=="POST"&& isset($_POST["Logout"])){
            session_unset();    // Unset all session variables
            session_destroy();  // Then destroy the session
            session_regenerate_id(true); //delete old session for security 
            header('Location: /Academic%20Registration%20System/resturcterd/pages/index.php');
            exit;
        }
    }


}

?>