<?php 

require_once __DIR__ .'/../Classes/User.php';
require_once __DIR__ .'/../Classes/Student.php';
require_once __DIR__ .'/../Classes/Course.php';
require_once __DIR__ .'/../Classes/Teacher.php';
class UserManager{
    public $Data;
    //crate object to decides what data to use
    public function __construct(){
        $this->Data = new Data();
    }
    // function to crate object student or teacher
    public function CreateUser(string $User_ID, string $Password){
         // Loop over all students (hardcoded data)
        foreach(DataManagerMock::getstudents() as $UserData){
            // Check if credentials match and role is student
            if($UserData['Student_ID']==$User_ID && 
               $UserData['Password'] == $Password &&
               $UserData['Role']=="student"){
                // Found: Return a new Student object
                return $student= new Student(
                    $UserData['Name'],
                    $UserData['Student_ID'],
                    $UserData['Password'],
                    $UserData['email'],
                    $UserData['Role'],
                    $UserData['Phone_Number']
                );
                
            }
               
        }
        // Not found among students, check teachers
        foreach(DataManagerMock::getTeachers() as $UserData){
            // Check if ID matches  and password matches
            if($UserData['Teacher_ID'] == $User_ID 
            //check if the password is the same as the one in the data
            && $UserData['Password']==$Password){
                // Found: Return a new Teacher object 
                
                /* Note: Multiple teachers/staff may access,
                but not all may have the same permissions. */
                return new Teacher(
                    $UserData['Name'],
                    $UserData['Teacher_ID'],
                    $UserData['Password'],
                    $UserData['email'],
                    $UserData['Role'],
                    $UserData['Phone_Number']
                    
                );
            }
            
        }
             echo "<div style='color:red;font-weight:bold;'>User not found</div>";
             return null;
         
        
    }

    
    
}

?>