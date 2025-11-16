<?php 
require_once __DIR__ . '/../Classes/UserManager.php';
require_once __DIR__ .'/../Classes/User.php';
require_once __DIR__ .'/../Classes/Student.php';
require_once __DIR__ .'/../Classes/Course.php';

class Teacher extends User{
    
    
    //function tp check if the role is teacher
    public function authorizeAsTeacher($User_ID, $Password) {
        
        //call getTeachers and save data in StuffDetails variable 
        $StuffDetails = DataManagerMock::getTeachers();
        //loop over the data
        foreach($StuffDetails as $stuff){
            //check the id if match and check role if teacher
            if($stuff['Teacher_ID']== $User_ID &&  $stuff['Password']==$Password &&$stuff['Role']=="teacher"){
                //if role is teacher set session role to teacher
                $_SESSION['Role']="teacher";
                $_SESSION['User_ID'] = $User_ID;
                $_SESSION['Teacher_ID'] = $User_ID;
                
                header("Location: Assigned_Courses.php"); //Show the assigned courses
                exit;
            }
            }
            
            echo " not a teacher";
            header("Location: index.php"); 
            
        
        }

    //function to get Assigned Courses for every teacher
    public function getAssignedCourses($TeacherID){
        if($this->Data->connection){
            //when database crated here will be using database process
        }
        
        //if no database connection
        else{
            $Assigned_Courses = [];
        /*loop over the static method in DataManagerMock
        and check if the id is the same and display the 
        courses if yes*/
        foreach(DataManagerMock::getAssignedCourses($TeacherID) as $course){
            if($course["Teacher_ID"]==$TeacherID){
                $Assigned_Courses[]=$course;
            }
        }
        return $Assigned_Courses;
    }
    }
    public function getStudentList($CouresID){
        if($this->Data->connection){
            //when database crated here will be using database process
        }

         else{ 
            $studentsInCourse = DataManagerMock::getStudentINcourse($CouresID);
            //empty array 
            $result=[];
            //loop in the $StudentINcourse array
            foreach($studentsInCourse as $student){
                //check for the course ID and add all students with the same Course ID in the array
                if($student['Course ID']==$CouresID)
                    $result[]=$student;
            }
            //return result array
            return $result;
        }
    }

    //function to view students on hold list 
    public function getOnHoldStudents($TeacherID, $CouresID){
        if($this->Data->connection){
            //when database crated here will be using database process
        }

        else{
            $OnHoldStudent=[];
            //call Assigned_Courses and give it the ID
            $Assigned_Courses=$this->getAssignedCourses($TeacherID);
            //call ONHoldStudents and save data in StuffDetails variable
            $OnHoldlist=DataManagerMock::ONHoldStudents($CouresID);
            //instand loop to check if the course id is the same 
            foreach($Assigned_Courses as $course){
                foreach($OnHoldlist as $entry){
                    if($course["Course ID"]==$entry["Course ID"]){
                        //if yes add them in list
                        $OnHoldStudent[]=[
                        "Student_ID" => $entry["Student_ID"],
                        "Name" => $entry["Name"],
                        "Course ID" => $entry["Course ID"]
                    ];
                        break;
                    }
                }
            }
            return $OnHoldStudent;}
    }
    

    //function to Accept student in on hold list
    public function AcceptOnHold($StudentID, $CouresID){
        if($this->Data->connection){
            //when database crated here will be using database process
        }

        else{
            //save ONHoldStudents in a variable
            $OnHoldlist=DataManagerMock::ONHoldStudents($CouresID);

            //save all StudentIncourse in session variable
            $_SESSION["StudentIncourse"]=DataManagerMock::getStudentINcourse($CouresID);
            
                //loop over On Hold list ($OnHoldlist) 
                foreach($OnHoldlist as $index => $OnHoldStudent){
                    //if the selected student id & the course id is the same as the one in the list 
                    if($OnHoldStudent["Student_ID"]== $StudentID && $OnHoldStudent["Coures ID"] == $CouresID){
                        //add them in the session list StudentIncourse
                    $_SESSION["StudentIncourse"][]=[
                        "Student_ID" => $OnHoldStudent["Student_ID"],
                        "Name" => $OnHoldStudent["Name"],
                        "Coures ID" => $OnHoldStudent["Coures ID"]
                    ];
                    // i need to  Remove from OnHoldList
                    unset($_SESSION["OnHoldList"][$index]);
                    //reindex the array (cleaner)
                    $_SESSION["OnHoldList"] = array_values($_SESSION["OnHoldList"]);
                    break;
                    }
                }
            } 
    }

    //function to reject student in on hold list
    public function RejectOnHold($StudentID, $CouresID){
        if($this->Data->connection){
            //when database crated here will be using database process
        }

        else{
            //save ONHoldStudents in a variable
            $OnHoldlist=DataManagerMock::ONHoldStudents($CouresID);
            //loop over ONHoldStudents and check if the selected student id is the same as the one in the list 
            foreach($OnHoldlist as $index => $OnHoldStudent){
                if($OnHoldStudent['Student_ID']==$StudentID){
                    //if yes remove the student from the list 
                    unset($_SESSION["OnHoldList"][$index]);
                    break;
                }
            }

        }
}
}
?>