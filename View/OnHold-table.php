<?php
    require_once __DIR__ .'/../Classes/Course.php'; // Include the Course class
    require_once __DIR__ .'/../Classes/IDataManager.php'; //Include the IDataManager interface (ensures consistent DataManager structure)
    require_once __DIR__ .'/../Classes/DataManagerMock.php'; // Include the DataManagerMock class (provides mock/hardcoded data for testing)
    require_once __DIR__ .'/../Classes/DataManager.php'; // Include the DataManager class use hardcoded data if database failed
?>

<table class="OnHold-table">
    <thead>
        <tr>
            <th>Coures ID</th>
            <th>Coures Name</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $Data= new Data();
        if($Data->connection):
        foreach(DataManagerMock::ONHoldStudents($_SESSION['User_ID']) as $student): ?>
        <tr>
            <td><?= htmlspecialchars($student["Course ID"])?></td>
            <td><?= htmlspecialchars($student["Course Name"])?></td>
            <td>On hold</td>
            <td>
                <form method="POST">
                    <input type="hidden" name="Course_ID" value= "<?=htmlspecialchars($student["Course ID"])?>">
                    <button type="submit" name="cancel" class="cancel-btn">Cancel </button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php else: ?>
        <div class="no-db-msg">No database connection detected. Showing default data.</div>
        <?php foreach(DataManagerMock::ONHoldStudents($_SESSION['User_ID']) as $student):?>
        <tr>
            <td><?= htmlspecialchars($student["Course_ID"])?></td>
            <td><?= htmlspecialchars($student["Course Name"])?></td>
            <td>On hold</td>
            <td>
                <form method="POST">
                    <input type="hidden" name="Course_ID" value= "<?=htmlspecialchars($student["Course_ID"])?>">
                    <button type="submit" name="UnEnrollNow" class="Drop-btn">Cancel </button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
</table>
