<?php
//for the message design
$text='';
switch($status){
    //if student already enroll output Already Enrolled
    case 'already':
        $text = "Already Enrolled: <b>" . htmlspecialchars($CourseName) . " (" . htmlspecialchars($CourseID) . ")</b>";
        break;
    //if student is not already enroll output Successfully Enrolled
    case 'success':
        $text= "Successfully Enrolled: <b>" . htmlspecialchars($CourseName) . " (" . htmlspecialchars($CourseID) . ")</b>";
        break;
    //if the course is full output Course Full: You are now on hold 
    case 'hold':
        $text = "Course Full: You are now on hold for <b>" . htmlspecialchars($CourseName) . " (" . htmlspecialchars($CourseID) . ")</b>";
        break;
    case 'already-OnHold':
        $text = "your on hold in this course, please wait for an answer <b>" . htmlspecialchars($CourseName) . " (" . htmlspecialchars($CourseID) . ")</b>";
        break;
    default:
        $cssClass = 'info-message';
        $text = "Status unknown";
    }

?>
<div class="enroll-state">
    <?= $text ?>
</div>