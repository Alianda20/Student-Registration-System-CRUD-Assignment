<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location:login.php");
    exit();
}

include("db.php");

$message="";

if(isset($_POST['change'])){

    $old=$_POST['old_password'];
    $new=$_POST['new_password'];
    $confirm=$_POST['confirm_password'];

    $stmt=$conn->prepare("SELECT password,email FROM users WHERE full_name=?");
    $stmt->bind_param("s",$_SESSION['user']);
    $stmt->execute();

    $result=$stmt->get_result();

    if($result->num_rows>0){

        $user=$result->fetch_assoc();

        if(password_verify($old,$user['password'])){

            if($new==$confirm){

                $hash=password_hash($new,PASSWORD_DEFAULT);

                $update=$conn->prepare("UPDATE users SET password=? WHERE email=?");
                $update->bind_param("ss",$hash,$user['email']);

                if($update->execute()){

                    $message="<p style='color:green'>Password changed successfully.</p>";

                }else{

                    $message="<p style='color:red'>Failed to change password.</p>";

                }

            }else{

                $message="<p style='color:red'>New passwords do not match.</p>";

            }

        }else{

            $message="<p style='color:red'>Old password is incorrect.</p>";

        }

    }

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Change Password</title>

<link rel="stylesheet" href="style.css">

</head>

<body>

<?php include("menu.php"); ?>

<h2>Change Password</h2>

<?php echo $message; ?>

<form method="POST">

<label>Old Password</label><br>

<input type="password" name="old_password" required>

<br><br>

<label>New Password</label><br>

<input type="password" name="new_password" required>

<br><br>

<label>Confirm Password</label><br>

<input type="password" name="confirm_password" required>

<br><br>

<input type="submit" name="change" value="Change Password">

</form>

</body>
</html>
