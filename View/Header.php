<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle)? htmlspecialchars($pageTitle): "website"?></title>
    <?php if(isset($styleSheet)): ?>
        <link rel="stylesheet" href="<?= htmlspecialchars($styleSheet)?>">
    <?php endif?>
</head>

</html>