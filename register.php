<?php
include("server.php");
if (isset($_SESSION['username'])) {
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Register Page</title>
</head>

<body>
    <?php include("include/navbar.php"); ?>
    <div class="header-reg">
        <h1>Register</h1>
    </div>
    <form method="post" class="sign">
        <?php include("include/errors.php"); ?>
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo $username ?>">
        </div>
        <div class="input-group">
            <label>Email</label>
            <input type="text" name="email" value="<?php echo $email ?>">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password">
        </div>
        <div class="input-group">
            <label>Confirm-Password</label>
            <input type="password" name="confirm-password">
        </div>
        <div class="input-group">
            <button class="btn" name="register" type="submit">Register</button>
        </div>
        <p>Already have an account? <a href="login.php">Sign in</a></p>
    </form>
</body>

</html>