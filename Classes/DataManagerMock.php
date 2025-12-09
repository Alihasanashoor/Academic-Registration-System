<?php

class DataManagerMock implements IDataManager{
// Mock implementation of IDataManager used as a fallback

    public static function getstudents(): array {
        // Implementation to fetch and return a list of students
        // This method simulates database results when running without a live DB.
        $Students = [
            ["Student_ID" => "001" ,"Name" => "Yusuf","Phone_Number" => "555-0101","email" => "yusuf99@example.com", "Password" => "1234" , "Role" => "student" ],
            ["Student_ID" => "002" ,"Name" => "Khalid","Phone_Number" => "555-0120","email" => "khalid22@example.com", "Password" => "111" , "Role" => "student"],
            ["Student_ID" => "003" ,"Name" => "Tariq","Phone_Number" => "85-123","email" => "tariq01@example.com", "Password" => "1@@#" , "Role" => "student"],
            ["Student_ID" => "004" ,"Name" => "Sami","Phone_Number" => "00-8965", "email" => "sami44@example.com", "Password" => "0101", "Role" => "student"],
            ["Student_ID" => "005" ,"Name" => "Mariam","Phone_Number" => "564-8","email" => "mariam77@example.com", "Password" => "12356", "Role" => "student"],
            ["Student_ID" => "006" , "Name" => "Fahad","Phone_Number" => "8501-0","email" => "fahad33@example.com", "Password" => "ABCDEFG", "Role" => "student"],
            ["Student_ID" => "007" , "Name" => "Lina","Phone_Number" => "123-4", "email" => "lina88@example.com", "Password" => "123000", "Role" => "student"],
            ["Student_ID" => "008" , "Name" => "Layla","Phone_Number" => "1235-8", "email" => "layla21@example.com", "Password" => "12ss3", "Role" => "student"],
            ["Student_ID" => "009" , "Name" => "Adel","Phone_Number" => "1200-8", "email" => "AdelAA21@example.com", "Password" => "1250s3", "Role" => "student"],
            ["Student_ID" => "010" , "Name" => "Sara","Phone_Number" => "1035-8", "email" => "s3r3@example.com", "Password" => "ss3", "Role" => "student"],
            ["Student_ID" => "011" , "Name" => "Hassan ","Phone_Number" => "1135-8", "email" => "Hassan8520@example.com", "Password" => "12s", "Role" => "student"]
        ];
        return $Students;
    }

    public static function getTeachers(): array {
        // Implementation to fetch and return a list of teachers
    $Teachers = [
        ["Teacher_ID" => "T001", "Name" => "Dr. Nasser", "Phone_Number" => "555-0201", "email" => "nasser01@example.com", "Password" => "teach123", "Role" => "teacher"],
        ["Teacher_ID" => "T002", "Name" => "Prof. Amina", "Phone_Number" => "999-0011", "email" => "amina99@example.com", "Password" => "password1", "Role" => "teacher"],
        ["Teacher_ID" => "T003", "Name" => "Dr. Zayd", "Phone_Number" => "000-1122", "email" => "zayd33@example.com", "Password" => "z@ydpass", "Role" => "teacher"],
        ["Teacher_ID" => "T004", "Name" => "Dr. Salma", "Phone_Number" => "555-0999", "email" => "salma88@example.com", "Password" => "salmateach", "Role" => "teacher"],
        ["Teacher_ID" => "T005", "Name" => "Prof. Ali", "Phone_Number" => "123-4567", "email" => "ali77@example.com", "Password" => "alipass", "Role" => "teacher"],
        ["Teacher_ID" => "T006", "Name" => "Dr. Noor", "Phone_Number" => "000-0000", "email" => "noorlight@example.com", "Password" => "noor987", "Role" => "teacher"],
        ["Teacher_ID" => "T007", "Name" => "Prof. Rania", "Phone_Number" => "321-0001", "email" => "rania33@example.com", "Password" => "raniapass", "Role" => "teacher"],
        ["Teacher_ID" => "T008", "Name" => "Dr. Hassan", "Phone_Number" => "888-8888", "email" => "hassan22@example.com", "Password" => "h@ssan", "Role" => "teacher"],
        ["Teacher_ID" => "T009", "Name" => "Dr. Jass", "Phone_Number" => "88218-8888", "email" => "jas122@example.com", "Password" => "123", "Role" => "finance"]
    ];
    return $Teachers;
    }
    public static function ShowAvailableCourses(): array {
        // Implementation to fetch and return a list of courses available for enrollment
        $Coures=[
            ["Course ID" => "AI101", "Course Name" => "AI Basics", "Time" => "12:00 - 14:00", "Day" => "Sunday , Monday" ,"Price" => 20 . " BD" , "Capacity"=> 10  ],
            ["Course ID" => "CS001", "Course Name" => "Java Basics", "Time" => "9:00 - 10:00", "Day" => "Wednesday" ,"Price" => 10 . " BD"  , "Capacity"=> 10 ],
            ["Course ID" => "STATS215", "Course Name" => "Statistics", "Time" => "13:00 - 14:30", "Day" => "Sunday" ,"Price" => 10 . " BD" , "Capacity"=> 10 ],
            ["Course ID" => "VG500", "Course Name" => "Video Game Developement", "Time" => "16:00 - 17:00", "Day" => "Monday" ,"Price" => 16 .  " BD" , "Capacity"=> 10 ],
            ["Course ID" => "OOP410", "Course Name" => "Java Object Oriented Programming", "Time" => "17:00 - 20:00", "Day" => "Wednesday" ,"Price" => 15 . " BD" , "Capacity"=> 10 ]
        ];
        return $Coures;
    }

    public static function getAssignedCourses($TeacherID): array {
        // Implementation to fetch and return a list of courses assigned to teachers
        $AssignedCourses=[
            ["Teacher_ID" => "T001" , "Course ID" => "AI101", "Course Name" =>"AI Basics", "Time"=> "12:00 - 14:00"],
            ["Teacher_ID" => "T003" , "Course ID" => "CS001", "Course Name" => "Java Basics", "Time"=> "9:00 - 10:00"],
            ["Teacher_ID" => "T007" , "Course ID" => "STATS215", "Course Name" => "Statistics","Time"=> "13:00 - 14:30"],
            ["Teacher_ID" => "T001" , "Course ID" => "VG500", "Course Name" => "Video Game Developement","Time"=> "16:00 - 17:00"],
            ["Teacher_ID" => "T002" , "Course ID" => "OOP410", "Course Name"=> "Java Object Oriented Programming", "Time"=> "17:00 - 20:00"]
        ];
        return $AssignedCourses;
    }

    public static function getStudentINcourse($CouresID): array {
        // Implementation to fetch and return a list of students registered in courses
        $StudentINcourse=[
            ["Student_ID"=> "001","Name"=>"Yusuf","Course ID" => "AI101" ],
            ["Student_ID"=> "003","Name"=>"Tariq","Course ID" => "AI101" ],
            ["Student_ID"=> "004","Name"=>"Sami","Course ID" => "AI101" ],
            ["Student_ID"=> "006","Name"=>"Fahad","Course ID" => "AI101" ],
            ["Student_ID"=> "007","Name"=>"Lina","Course ID" => "AI101" ],
            ["Student_ID"=> "008","Name"=>"Layla","Course ID" => "AI101" ],
            // Duplicates intentionally kept for testing capacity/hold logic
            ["Student_ID"=> "002","Name"=>"Khalid","Course ID" => "CS001" ],
            ["Student_ID"=> "003","Name"=>"Tariq","Course ID" => "CS001" ],
            ["Student_ID"=> "005","Name"=>"Mariam","Course ID" => "CS001" ],
            ["Student_ID"=> "006","Name"=>"Fahad","Course ID" => "CS001" ],
            ["Student_ID"=> "007","Name"=>"Lina","Course ID" => "CS001" ],
            ["Student_ID"=> "008","Name"=>"Layla","Course ID" => "CS001" ],
            ["Student_ID"=> "003","Name"=>"Tariq","Course ID" => "CS001" ],
            ["Student_ID"=> "005","Name"=>"Mariam","Course ID" => "CS001" ],
            ["Student_ID"=> "006","Name"=>"Fahad","Course ID" => "CS001" ],
            ["Student_ID"=> "007","Name"=>"Lina","Course ID" => "CS001" ],
            ["Student_ID"=> "008","Name"=>"Layla","Course ID" => "CS001" ],
            
            
            ["Student_ID"=> "002","Name"=>"Khalid","Course ID" => "STATS215" ],
            ["Student_ID"=> "005","Name"=>"Mariam","Course ID" => "STATS215" ],
            
            ["Student_ID"=> "001","Name"=>"Yusuf","Course ID" => "VG500" ],
            ["Student_ID"=> "005","Name"=>"Mariam","Course ID" => "VG500" ],
            ["Student_ID"=> "006","Name"=>"Fahad","Course ID" => "VG500" ],
            
            // Duplicates intentionally kept for testing capacity/hold logic
            ["Student_ID"=> "003","Name"=>"Tariq","Course ID" => "OOP410" ],
            ["Student_ID"=> "004","Name"=>"Sami","Course ID" => "OOP410" ],
            ["Student_ID"=> "007","Name"=>"Lina","Course ID" => "OOP410" ],
            ["Student_ID"=> "008","Name"=>"Layla","Course ID" => "OOP410" ],
            ["Student_ID"=> "003","Name"=>"Tariq","Course ID" => "OOP410" ],
            ["Student_ID"=> "004","Name"=>"Sami","Course ID" => "OOP410" ],
            ["Student_ID"=> "007","Name"=>"Lina","Course ID" => "OOP410" ],
            ["Student_ID"=> "008","Name"=>"Layla","Course ID" => "OOP410" ],
            ["Student_ID"=> "003","Name"=>"Tariq","Course ID" => "OOP410" ],
            ["Student_ID"=> "004","Name"=>"Sami","Course ID" => "OOP410" ]
        ];
        return $StudentINcourse;
        
    }
    public static function ONHoldStudents($StudentID){
        // List of students placed on hold for specific courses.
        $OnHoldLsit=[
            ["Course ID" => "CS001" , "Course Name" => "Java Basics","Student_ID"=> "009","Name"=>"Adel" ],
            ["Course ID" => "VG500" , "Course Name" => "Video Game Developement","Student_ID"=> "010","Name"=>"Sara"],
            ["Course ID" => "OOP410" , "Course Name" => "Java Object Oriented Programming","Student_ID"=> "011","Name"=>"Hassan"]
        ];

        // Ensure the OnHoldList session storage is initialized as an array.
        if(!isset($_SESSION["OnHoldList"]) || !is_array($_SESSION["OnHoldList"])){
            $_SESSION["OnHoldList"]=[];
        }
        // Only process the on-hold records if the current logged-in student matches the given ID.
        if($_SESSION['User_ID']==$StudentID){
            // Loop through the mock list and add matching student entries to the session list.
            foreach($OnHoldLsit as $key=>$val){
                if($_SESSION['User_ID']==$val['Student_ID']){
                    $_SESSION["OnHoldList"][]=$val;

            }
        }
    }
        // Return the full on-hold list for the current session.
        return $_SESSION["OnHoldList"] ;
    }
    
    public static function ShowRegisteredCourse($Student_ID): array {
        // Implementation to fetch and return a list of registered courses for a user

          // Ensure the UserCourse session list exists and is an array.
          if (!isset($_SESSION['UserCourse']) || !is_array($_SESSION['UserCourse'])){
            $_SESSION['UserCourse'] = []; // Initialize empty list
            
            /*loop over the list and check student id in the list is the same as the one 
            who is loged in and add the course to $_SESSION["UserCourse"] */
            foreach(self::getStudentINcourse(null) as $ID){
                // Check if this record belongs to the selected student
                 if(($ID["Student_ID"] ?? '')==$Student_ID){
                    // Match the student's course with the available course data
                    foreach(self::ShowAvailableCourses() as $key=> $value){

                        if(($ID["Course ID"] ?? '')==($value["Course ID"] ?? '')){
                            // Add the full course details to the session list
                            $_SESSION["UserCourse"][]=$value;   
                        }
                       
                    }
                }

            }
        }
        // Return all registered courses stored for the user.
        return $_SESSION["UserCourse"] ;    
        }
}

?>