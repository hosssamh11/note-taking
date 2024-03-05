<?php
session_start();
require("include/connectdb.php");
$username = "";
$email = "";
$password = "";
$task = "";
$success = array();
$errors = array();
if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirmpassword = mysqli_real_escape_string($con, $_POST['confirm-password']);
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
    if ($password != $confirmpassword) {
        array_push($errors, "Passwords must match");
    }
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) == 1) {
        array_push($errors, "Username is exist");
    }
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) == 1) {
        array_push($errors, "Email is exist");
    }
    if (count($errors) == 0) {
        //check for username && email uniqe

        $password = md5($password);
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        $result = mysqli_query($con, $query);
        if ($result) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "User registered successfully!";
            header('location: index.php');
        } else {
            array_push($errors, "Error registering user: " . mysqli_error($con));
        }
    }
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($con, $query);
        if (mysqli_num_rows($result) == 1) {

            $_SESSION['username'] = $username;
            $_SESSION['success'] = "User login successfully!";
            header('location: index.php');
        } else {
            array_push($errors, "Invalid username or password");
        }
    }
}
if (isset($_POST['add'])) {
    $query = "SELECT id FROM users WHERE username='" . $_SESSION['username'] . "'";
    $result = mysqli_query($con, $query);
    $u_id = mysqli_fetch_assoc($result);
    $u_id = $u_id['id'];
    // echo $u_id['id'];
    $task = mysqli_real_escape_string($con, $_POST['value']);
    if (empty($task)) {
        array_push($errors, "You must add task");
    } else {
        $query = "INSERT INTO tasks (value,u_id) VALUES ('$task','$u_id')";
        mysqli_query($con, $query);
    }
}

function gettasks($con)
{
    $query = "SELECT id FROM users WHERE username='" . $_SESSION['username'] . "'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $u_id_row = mysqli_fetch_assoc($result);
        $u_id = $u_id_row['id'];

        $query = "SELECT * FROM tasks WHERE u_id='$u_id' ORDER BY date DESC";
        $result = mysqli_query($con, $query);

        if ($result) {
            $tasks = [];

            while ($task = mysqli_fetch_assoc($result)) {
                $tasks[] = $task;
            }

            // Free the result set
            mysqli_free_result($result);

            return $tasks;
        } else {
            // Handle error if needed
            echo "Error retrieving tasks: " . mysqli_error($con);
        }
    } else {
        // Handle error if needed
        echo "Error retrieving user ID: " . mysqli_error($con);
    }

    return [];
}

if (isset($_POST['delete'])) {
    $idToDelete = mysqli_real_escape_string($con, $_POST['delete']);
    $query = "DELETE FROM tasks WHERE id='$idToDelete'";
    if (mysqli_query($con, $query)) {
        header('location: index.php');
    } else {
        echo "Error deleting task: " . mysqli_error($con);
    }
}
if (isset($_POST['save'])) {
    $updatedValue = mysqli_real_escape_string($con, $_POST['updatevalue']);
    $idToUpdate = mysqli_real_escape_string($con, $_POST['save']);
    $query = "UPDATE tasks SET value='$updatedValue',date=CURRENT_TIMESTAMP WHERE id='$idToUpdate'";
    if (mysqli_query($con, $query)) {
        array_push($success, "Task Updated Successfully");
        header('location: index.php');
    } else {
        array_push($errors, "Task not updated: " . mysqli_error($con));
    }
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header('location: login.php');
}
