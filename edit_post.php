<?php
    session_start();

    include("php/config.php");
    if(!isset($_SESSION['valid'])){
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Edit Profile</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">Logo</a></p>
        </div>

        <div class="right-links">
            <a href="">Change Profile</a>
            <a href="php/logout.php"> <button class="btn">Log Out </button></a>
        </div>
    </div>
    <div class="container">
        <div class="form-box box">
            <?php
                if (isset($_POST['submit'])) {
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $age = $_POST['age'];

                    $id = $_SESSION['id'];
                    $edit_query = mysqli_query($conn, "UPDATE users SET username='$username', email='$email', age='$age' WHERE id='$id'") or die("Error 404!");

                    if ($edit_query) {
                        echo "<div class='message-success'>
                                <p>Profile Updated!</p>
                            </div> <br>";
                    
                        echo "<a href='home.php'> <button class='btn'> Back Home! </button></a>";
                    }
                }else{
                    $id = $_SESSION['id'];
                    $query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id'");

                    while($result = mysqli_fetch_assoc($query)){
                        $res_uname = $result['username'];
                        $res_email = $result['email'];
                        $res_age = $result['age'];
                    }
            ?>
            <header>Change Profie</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?= $res_uname ?>" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" autocomplete="off" id="email" value="<?= $res_email ?>" required>
                </div>
                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" autocomplete="off" id="age" value="<?= $res_age ?>" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Update" required>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
</body>
</html>