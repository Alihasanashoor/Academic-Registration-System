<!-- ShowStudentsInCourseTemplate.php -->

<!--check if studentsInCourse is empty-->
 <?php if(!empty($studentsInCourse)): ?>
    <!--crate a table-->

    <table class="student-in-course-table"> 
        <!--table row-->
        <tr>
            <th>Student ID</th> 
            <th>Name</th>
            <th>Course ID</th>

            <!--for show info button-->
            <th></th> 

        </tr>
        <!--loop over the array-->
        <?php foreach($studentsInCourse as $student):?> 

        <!--new table row--> 
        <tr>
        <!--table data from studentsInCourse array-->
            <td> <?= htmlspecialchars($student["Student_ID"]);?></td>
            <td><?= htmlspecialchars($student["Name"])?></td>
            <td><?= htmlspecialchars($student["Course ID"]);?></td>
            <td>
                <!--button for show student Information-->
                <form method="POST">
                    <input type="hidden" name="Student_ID" value="<?= htmlspecialchars($student["Student_ID"]); ?>">
                    <button type="submit" name="ShowInfo">Show Student Information</button>
                </form>
            </td>
        </tr>
        <!--end loop-->
        <?php endforeach ; ?>
        <!--end table-->
    </table>

    <!--if array is empty output message-->
    <?php else: ?>
        <p>No student found for this Course</p>
    <!--end if-->
    <?php endif; ?>

<?php 
    // If Show Student Information button was clicked and Student_ID is present
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["ShowInfo"]) && isset($_POST["Student_ID"])){

        /* give value student id to the var studentID */
        $studentID=$_POST["Student_ID"];

        /* Fetch all students by calling getstudents (where the data is) function and add all to array allstudents */
        $allStudents = DataManagerMock::getstudents();

        //Find the selected student's details
        /* set studentDetails to null */
        $studentDetails=null;

        /* loop over allstudents array */
        foreach($allStudents as $student){

            /* check if student id is the same as selected */
            if($student["Student_ID"] == $studentID){

                /* set studentDetails to array that have student Information */
                $studentDetails=$student;

                /*braek the loop */
                break;
            }
        }
        /* display the student Information if found */
        if ($studentDetails) {
        echo "<div class='student-details'>";
        echo "<h3>Student Information</h3>";
        echo "<ul>";
        echo "<li><b>ID:</b> " . htmlspecialchars($studentDetails["Student_ID"]) . "</li>";
        echo "<li><b>Name:</b> " . htmlspecialchars($studentDetails["Name"]) . "</li>";
        echo "<li><b>Email:</b> " . htmlspecialchars($studentDetails["email"]) . "</li>";
        echo "<li><b>Phone:</b> " . htmlspecialchars($studentDetails["Phone_Number"]) . "</li>";
        echo "</ul></div>";
    }
}
?>
    