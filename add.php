<?php
include("server.php");
if (empty($_SESSION['username'])) {
    header('location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>ADD TASK</title>
</head>

<body>
    <div class="content">
        <?php include("include/errors.php"); ?>
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="success">
                <?php echo $_SESSION['success']; ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif ?>
    </div>
    <?php include("include/navbar.php"); ?>
    <div class="header-reg">
        <h1>ADD TASK</h1>
    </div>



    <form method="post">
        <div class="addtask">
            <label>Your Task</label>
            <input type="text" name="value" placeholder="ENTER YOUR TASK">
            <button name="add" type="submit">ADD</button>
        </div>
    </form>
</body>

</html>