<!-- ShowRegisteredCourseTable_Template.php for View Registered Courses page-->
<?php
    require_once __DIR__ .'/../Classes/Course.php'; // Include the Course class
    require_once __DIR__ .'/../Classes/IDataManager.php'; //Include the IDataManager interface (ensures consistent DataManager structure)
    require_once __DIR__ .'/../Classes/DataManagerMock.php'; // Include the DataManagerMock class (provides mock/hardcoded data for testing)
    require_once __DIR__ .'/../Classes/DataManager.php'; // Include the DataManager class use hardcoded data if database failed
   ?>

<!--check if registeredCourses empty-->
<?php if(!empty($_SESSION["UserCourse"])): ?>

    <!--crate table-->
<table class="UserCoures-table"> 
    <thead>
    <!--make table row-->
        <tr>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Time</th>
            <th>Day</th>
            <th>Price</th>
            <th>Drop</th>
            <th>Payment</th>
        </tr> <!--end table row-->
    </thead>
    <tbody>
        <!--crate loop to print the data-->
        <?php foreach($_SESSION["UserCourse"] as $course):?>

        <!-- new table row-->
         <tr>
            
        <!--table data-->
            <td><?= htmlspecialchars($course["Course ID"])?></td>
            <td><?= htmlspecialchars($course["Course Name"])?></td>
            <td><?= htmlspecialchars($course["Time"])?></td>
            <td><?= htmlspecialchars($course["Day"])?></td>
            <td><?= htmlspecialchars($course["Price"])?></td>
            <td>
                <form method="POST" action="View-Registered-Courses.php">
                    <input type="hidden" name="Course_ID" value= "<?=htmlspecialchars($course["Course ID"])?>">
                    <button type="submit" name="UnEnrollNow" class="Drop-btn">Drop</button>
              </form>
            </td>
            <td>
                <form method="POST" action="../public/process_payment.php">
                    <!-- The controller expects these keys: Course_ID and Price -->
                    <input type="hidden" name="Course_ID" value="<?=htmlspecialchars($course["Course ID"])?>">
                    <input type="hidden" name="Price" value="<?=(float) str_replace(' BD','',$course['Price'])?>">
                    
                    <!-- Name the submit 'pay' so the controller's bootstrap can detect it if needed -->
                    <button type="submit" name="pay" class="Drop-btn">PAY</button>
                </form>
            </td>
         <!--end table row-->
         </tr>
        <!--end loop-->
         <?php endforeach;?> 
   
    <!--if empty output message-->
    <?php else: ?>
        <div class="msg-container">
        <div class="no-course">Registered courses found.</div>
        </div>
    <!--end if-->
    <?php endif; ?>
    </tbody>
     <!--end table-->
</table>
