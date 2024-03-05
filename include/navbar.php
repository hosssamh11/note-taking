<nav class="navbar">
    <a class="nav-link" href="index.php">Home</a>

    <?php if (isset($_SESSION['username'])) { ?>
        <a class="nav-link" href="add.php">Add Task</a>
        <a class="nav-link" href="index.php?logout='1'">Logout</a>
    <?php } else { ?>
        <a class="nav-link" href="login.php">Login</a>
    <?php } ?>


</nav>