<!-- ДОДАВАННЯ НОВОГО КОРИСТУВАЧА СКРИПТ РНР -->
<?php
$user_name = $_POST['login'];
$user_password = $_POST['password'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];



   $host = "localhost";
   $dbUsername = "root";
   $dbPassword = "root";
   $dbName = "salary_department";


   $connection = new mysqli($host, $dbUsername, $dbPassword, $dbName);
   if(mysqli_connect_error())
   {
        die('Connect error.');
   };

   
   $SELECT = "SELECT user_name FROM accountant_users WHERE user_name = ? LIMIT 1";
   $INSERT = "INSERT INTO accountant_users (user_name, user_password, first_name, last_name, email)
    VALUES(?,?,?,?,?)";

    $stmt = $connection ->prepare($SELECT);
    $stmt ->bind_param("s", $user_name);
    $stmt -> execute();
    $stmt ->bind_result($user_name);
    $stmt ->store_result();
    $rnum = $stmt ->num_rows;

    if($rnum==0){
        $stmt ->close();

        $stmt = $connection -> prepare($INSERT);
        $stmt ->bind_param("sssss",
                                $user_name,
                                $user_password,
                                $first_name,
                                $last_name,
                                $email);
        $stmt -> execute();
        echo "Користувача додано.";
    } else echo "Користувач з таким логіном вже існує.";
    
    $stmt -> close();
    $connection -> close(); 



?>

<!-- Нtml частина -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Успіх!</title>
</head>
<body>
    <a href="/login_page.html"><button>Повернутися на головну</button></a>
</body>
</html>