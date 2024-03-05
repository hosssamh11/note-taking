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
    <title>Home Page</title>
</head>

<body>
    <div class="content">
        <?php include("include/errors.php"); ?>
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="success">
                <?php echo $_SESSION['success']; ?>
                <?php foreach ($success as $succes) : ?>
                    <?php echo $succes; ?>
                <?php endforeach ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif ?>
    </div>
    <?php include("include/navbar.php"); ?>
    <div class="header-reg">
        <h1>HOME</h1>
    </div>


    <!-- <h2>Your Tasks</h2> -->
    <!-- <table>
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Date</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                
            </tbody>
        </table> -->
    <div class="note-container">
        <h2>Your Notes</h2>
        <?php $tasks = gettasks($con); ?>
        <?php foreach ($tasks as $task) : ?>
            <div class="note" id="view<?php echo $task['id']; ?>">
                <h3>Last Update: <?php echo $task['date'] ?></h3>
                <p><?php echo $task['value'] ?></p>
                <form method="post" action="server.php">
                    <button class="btn" type="submit" name="delete" value="<?php echo $task['id']; ?>" style="background-color: red; color: white;">Delete</button>
                    <button class="btn" name="update" type="button" onclick="editfun(<?php echo $task['id']; ?>);" value="<?php echo $task['id']; ?>">Edit</button>
                </form>
            </div>
            <div class="edite" id="edit<?php echo $task['id']; ?>" style="display: none;">
                <h3>Last Update: <?php echo $task['date'] ?></h3>
                <form method="post" action="server.php">
                    <input type="text" name="updatevalue" value="<?php echo $task["value"] ?>">
                    <button class="btn" name="save" value="<?php echo $task['id']; ?>" type="submit" onclick="savefun(<?php echo $task['id']; ?>);">Save</button>
                </form>
            </div>
        <?php endforeach ?>
    </div>

    <script>
        function editfun(taskId) {
            // Hide the view form
            document.getElementById("view" + taskId).style.display = "none";

            // Show the edit form
            document.getElementById("edit" + taskId).style.display = "block";
        }

        function savefun(taskId) {
            // Hide the edit form
            document.getElementById("edit" + taskId).style.display = "none";

            // Show the view form
            document.getElementById("view" + taskId).style.display = "block";
        }
    </script>

</body>

</html>