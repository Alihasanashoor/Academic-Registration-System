<?php
    require_once __DIR__ .'/../Classes/Course.php'; // Include the Course class
    require_once __DIR__ .'/../Classes/IDataManager.php'; //Include the IDataManager interface (ensures consistent DataManager structure)
    require_once __DIR__ .'/../Classes/DataManagerMock.php'; // Include the DataManagerMock class (provides mock/hardcoded data for testing)
    require_once __DIR__ .'/../Classes/DataManager.php'; // Include the DataManager class use hardcoded data if database failed
    require_once __DIR__ . '/../Classes/Teacher.php'
   ?>

<!--check if studentsInCourse is empty-->
 <?php if(!empty($Assigned_Courses)): ?>
    <!--crate a table-->

    <table class="Assigned-Courses-table"> 
        <!--table row-->
        <tr>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Time</th>
        </tr>
        <!--loop over the array-->
        <?php foreach($Assigned_Courses as $teacher):?> 

        <!--new table row--> 
        <tr>
        <!--table data from studentsInCourse array-->
            <td> <?= htmlspecialchars($teacher["Course ID"]);?></td>
            <td><?= htmlspecialchars($teacher["Course Name"])?></td>
            <td><?= htmlspecialchars($teacher["Time"]);?></td>
        </tr>
        <!--end loop-->
        <?php endforeach ; ?>
        <!--end table-->
    </table>

    <!--if array is empty output message-->
    <?php else: ?>
        <div class="msg-container">
        <div class="no-course">No Courses</div>
        </div>
    <!--end if-->
    <?php endif; ?>


    