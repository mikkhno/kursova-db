<!-- СКРИПТ РНР ДОДАВАННЯ НОВОГО ПРАЦІВНИКА -->
<?php

$last_name = $_POST[ 'last_name' ];
$first_name = $_POST[ 'first_name' ];
$patronymic = $_POST[ 'patronymic' ];
$occupation_id = $_POST[ 'occupation_id' ];
$hiring_data = $_POST[ 'hiring_data' ];
$stax_id = $_POST[ 'stax_id' ];
$benefit_id = $_POST[ 'benefit_id' ];
$birth_date = $_POST[ 'birth_date' ];
$email = $_POST[ 'email' ];
$phone = $_POST[ 'phone' ];
$adress = $_POST[ 'adress' ];

$host = 'localhost';
$dbUsername = 'root';
$dbPassword = 'root';
$dbName = 'cathedra_iate';

$connection = new mysqli( $host, $dbUsername, $dbPassword, $dbName );
if ( mysqli_connect_error() ) {
    die( 'Connect error.' );
}
;

$SELECT = 'SELECT email FROM employers WHERE email = ? LIMIT 1';
$INSERT = "INSERT INTO employers
(last_name, first_name,
patronymic, occupation_id,
hiring_data, stax_id,
benefit_id, birth_date,
email, phone, adress)
    VALUES(?,?,?,?,?,?,?,?,?,?,?)";

$stmt = $connection ->prepare( $SELECT );
$hiring = date_create($hiring_data);
$hiring_res = date_format($hiring,"Y/m/d");
$bday = date_create($birth_date);
$bday_res = date_format($bday,"Y/m/d");

$stmt ->bind_param('s', $email);
$stmt -> execute();
$stmt ->bind_result( $email );
$stmt ->store_result();
$rnum = $stmt ->num_rows;

if($rnum==0){
    $stmt ->close();

    $stmt = $connection -> prepare($INSERT);
    $stmt ->bind_param("sssisiissis",
                            $last_name,
                            $first_name,
                            $patronymic,
                            $occupation_id,
                            $hiring_res,
                            $stax_id,
                            $benefit_id,
                            $bday_res,
                            $email,
                            $phone,
                            $adress
                                );
    $stmt -> execute();
    echo "Працівника додано.";
} else echo "Такий працівник вже є у базі даних.";


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
    <a href="/main.php"><button>Повернутися на головну</button></a>
</body>
</html>