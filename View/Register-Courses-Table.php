<!--for the table to be printed-->
<?php 
    require_once __DIR__ .'/../Classes/Course.php'; // Include the Course class
    require_once __DIR__ .'/../Classes/IDataManager.php'; //Include the IDataManager interface (ensures consistent DataManager structure)
    require_once __DIR__ .'/../Classes/DataManagerMock.php'; // Include the DataManagerMock class (provides mock/hardcoded data for testing)
    require_once __DIR__ .'/../Classes/DataManager.php'; // Include the DataManager class use hardcoded data if database failed
    ?>
<table class="course-table">
    <thead>
        <tr>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Time</th>
            <th>Day</th>
            <th>Price</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        //if there is database connection
        $Data= new Data();
        if($Data->connection):
            foreach(DataManager::ShowAvailableCourses() as $course):?>
            <tr>
                <td><?= htmlspecialchars($course["Course ID"]) ?></td>
                <td><?= htmlspecialchars($course["Course Name"]) ?></td>
                <td><?= htmlspecialchars($course["Time"]) ?></td>
                <td><?= htmlspecialchars($course["Day"]) ?></td>
                <td><?= htmlspecialchars($course["Price"]) ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="Course_ID" value= "<?=htmlspecialchars($course["Course ID"])?>">
                        <button type="submit" name="EnrollNow" class="enroll-btn">Enroll Now</button>
                
                    </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php else: ?>
        <div class="no-db-msg">No database connection detected. Showing default data.</div>
        <?php
        foreach (DataManagerMock::ShowAvailableCourses() as $Course):?>
        <tr>
            <td><?= htmlspecialchars($Course["Course ID"]) ?></td>
            <td><?= htmlspecialchars($Course["Course Name"]) ?></td>
            <td><?= htmlspecialchars($Course["Time"]) ?></td>
            <td><?= htmlspecialchars($Course["Day"]) ?></td>
            <td><?= htmlspecialchars($Course["Price"]) ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="Course_ID" value= "<?=htmlspecialchars($Course["Course ID"])?>">
                    <button type="submit" name="EnrollNow" class="enroll-btn">Enroll Now</button>
            </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>

</table>