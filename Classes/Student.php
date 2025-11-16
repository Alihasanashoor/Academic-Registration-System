<?php 
// Load all required class definitions used across the system.
require_once __DIR__ . '/../Classes/UserManager.php'; 
require_once __DIR__ .'/../Classes/User.php';         
require_once __DIR__ .'/../Classes/Course.php';
require_once __DIR__ .'/../Classes/Teacher.php';
require_once __DIR__ .'/../Classes/IDataManager.php';
require_once __DIR__ .'/../Classes/DataManagerMock.php';
require_once __DIR__ .'/../Classes/DataManager.php';

class Student extends User{
    
    // function for enrollment
    public function EnrollCourse(){

        if($this->Data->connection){
            // When database crated here will be using database process
        }
        
        else{
            //variable for message
            $Message="";
            // Loop over all Available Courses(hardcoded data)
            foreach(DataManagerMock::ShowAvailableCourses() as $key=> $value){
               
                    if($value["Course ID"] == $_POST["Course_ID"]){
                    //cheack if the session array exsist
                        if(!isset($_SESSION["UserCourse"]) ){
                            //crate session array if not exsist
                            $_SESSION["UserCourse"]=[];
                            
                        }
                    
                        // Collect all enrolled course IDs for this session
                        $enrolledIds=array_column($_SESSION["UserCourse"], "Course ID");
                        if(in_array($value["Course ID"], $enrolledIds)){
                            //for the message design
                            $status='already';
                            //save course name into variable
                            $CourseName=$value["Course Name"];
                            //save course ID into variable
                            $CourseID=$value["Course ID"];
                            //load message 
                            include __DIR__ . '/../View/Enroll-State.php';
                            return;

                        }       
                        //add the course if not in the array
                        else{
                            $studentsInCourse=DataManagerMock::getStudentINcourse(CouresID: $value["Course ID"]);
                            $studentCount=0;
                            //check if studnet course id matches the course that the user wants to enroll in
                            foreach($studentsInCourse as $student){
                                if($student['Course ID'] == $value["Course ID"]){
                                    $studentCount++;
                                }
                            }
                            if($studentCount < $value["Capacity"]){
                            //save selected course into array 
                            $_SESSION["UserCourse"][] = $value;
                            //for the message design
                            $status='success';
                            //save course name into variable
                            $CourseName=$value["Course Name"];
                            //save course ID into variable
                            $CourseID=$value["Course ID"];
                            //load message
                            include __DIR__ . '/../View/Enroll-State.php';
                            return;
                        }
                        
                            //check if on hold list exist if not crate it 
                            if(!isset($_SESSION["OnHoldList"])|| !is_array($_SESSION['OnHoldList'])){
                                $_SESSION["OnHoldList"]=[];
                            }
                            foreach ($_SESSION['OnHoldList'] as $row) {
                                /* Check if the logged-in student matches the entry
                                    AND if the course ID matches the course currently being processed. */
                            if (($row['Student ID'] ?? null) === $_SESSION['User_ID'] &&
                                ($row['Course ID']  ?? null) === $value['Course ID']) {
                                    //for the message design
                                    $status = 'already-OnHold';
                                    //save course ID into variable
                                    $CourseID = $value['Course ID'];
                                    //save course name into variable
                                    $CourseName = $value['Course Name'];
                                    //load message
                                    include __DIR__ . '/../View/Enroll-State.php';
                                    return;
                                    }
}
                            //add student if course is full
                            $_SESSION["OnHoldList"][]=
                            ["Course_ID" => $value["Course ID"],
                            "Course Name" => $value["Course Name"],
                            "Student_ID" => $_SESSION["User_ID"],
                            "Name" => $this->getName()
                        ];
                            //for the message design
                            $status='hold';
                            $CourseName=$value["Course Name"];
                            //save course ID into variable
                            $CourseID=$value["Course ID"];
                            //load message
                            include __DIR__ . '/../View/Enroll-State.php';
                            return;
                            

                        }
                
                    
            }
        }
    }
    }

    //function for drop course process
    public function DropCourse(){ 
        
            
           //save Coures ID into a variable for output message
            $id=$_POST['Course_ID'];
            //loop over session array
            foreach($_SESSION['UserCourse'] as $key=>$course){
                //check if the selected course id is the same as the one in the session array
                if($course["Course ID"]==$_POST['Course_ID']){
                    //remove the course
                    unset($_SESSION['UserCourse'][$key]);
                    echo'<div class="unenroll-success">';
                    echo '<b>'.$id.'</b>' . " has been droped";
                    echo '</div>';  
                } 
            }
            // Check if the OnHoldList session exists and is a valid array
            if(isset($_SESSION['OnHoldList']) && is_array($_SESSION['OnHoldList'])){
                // Loop through all on-hold course requests
                   foreach($_SESSION['OnHoldList'] as $on_hold => $course){
                        // Extract the course ID 
                        $course_id = $course['Course_ID'] ?? $course['Course_ID']??null;
                        // If the selected course matches the on-hold entry, remove it
                        if($course_id == $id){
                            unset($_SESSION['OnHoldList'][$on_hold]);
                            echo'<div class="unenroll-success">';
                            echo " The request has been canceled";
                            echo '</div>';  
                        }
                    }
            }
            
            
        
    
}

}

?>