<!-- ПРОЦЕС ВЕРИФІКАЦІЇ ТА ВСТАНОВЛЕННЯ КОРИСТУВАЦЬКОЇ СЕСІЇ -->
<?php
session_start();
$connection = new mysqli("localhost", "root", "root", "salary_department")
or die('Connect error.');

if(isset($_POST['login'])){

    $user_name = $_POST['login'];
    $user_password = $_POST['password'];

    $user_name = stripcslashes($user_name);
    $user_password = stripcslashes($user_password);
    $user_name = mysqli_real_escape_string($connection,$user_name);
    $user_password = mysqli_real_escape_string($connection,$user_password);


    $verificated = false;
   
    $query = "SELECT * from accountant_users
    WHERE user_name = '$user_name' and user_password = '$user_password' ";

    $RESULT = mysqli_query($connection, $query)
    or die("Connection failed.".mysqli_connect_error());
    $row = mysqli_fetch_array($RESULT);
    if ($row)
    {
    if($row['user_name'] == $user_name && $row['user_password'] == $user_password)
    $_SESSION["Username"] =$row['user_name'];
    $_SESSION["Password"] =$row['user_password'];
    $_SESSION["cur_id"] = NULL;
    header("Location:main.php");
    }
    else echo '<script>alert("Некорректно введено логін або пароль.")</script>';
}
?>

<!-- Нtml частина -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Невдала сесія.</title>
</head>
<body>
    <a href="/login_page.html"><button>Повернутися назад</button></a>
</body>
</html>