<!-- ІНФОРМАЦІЯ ПРО ОБРАНОГО ПРАЦІВНИКА -->
<!-- Встановлення користувацької сесії -->
<?php
    session_start();
    $emp_id = $_SESSION['cur_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style><?php include 'css/empinfo.css'; ?></style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Інформація про працівника</title>
</head>

<body style = "margin:50px;">
    <div class="backgr">
        <!--Таблиця з працівниками(PHP and MYSQL)-->
        <h1 id="title">Інформація про працівника</h1>
        <div class="table_backgr">
        <table class ="table" id="employers_edit">
             <thead>    
                <tr>
                    <th>ID</th>
                    <th>Ім'я</th>
                    <th>Прізвище</th>
                    <th>По-батькові</th>
                    <th>Дата народження</th>
                    <th>Посада</th>
                    <th>Кафедра</th>
                    <th>Дата працевлаштування</th>
                    <th>Соціальні податки</th>
                    <th>Вид пільг</th>
                    <th>Емейл</th>
                    <th>Номер телефону</th>
                    <th>Адреса проживання</th>
                </tr>
            </thead>
    
            <tbody>
                <!-- Приєднання таблиці "employers" (PHP) -->
                <?php
                
                    $connection = new mysqli("localhost", "root", "root")
                    or die('Connect error(DB.)');
    
                    mysqli_select_db($connection, 'cathedra_iate');
                
                    $query = "
                    SELECT emp_id,
                    first_name,
                    last_name,
                    patronymic,
                    birth_date,
                    occupation_name,
                    department,
                    hiring_data,
                    stax_name,
                    benefit_name,
                    email,
                    phone,
                    adress
                    FROM employers e
                    JOIN salary_department.occupation so
                        ON e.occupation_id = so.occupation_id
                    LEFT JOIN salary_department.social_taxes st 
                        ON e.stax_id = st.stax_id
                    LEFT JOIN salary_department.social_benefits sb
                        ON e.benefit_id = sb.benefit_id
                     WHERE e.emp_id = '$emp_id';
                    ";
    
                    $result = mysqli_query($connection, $query) or die('Connect error.') ;
                    while($row = $result -> fetch_assoc())
                    {
                        echo "<tr>
                            <td>" . $row["emp_id"]. "</td>
                            <td>" . $row["first_name"]. "</td>
                            <td>" . $row["last_name"]. "</td>
                            <td>" . $row["patronymic"]. "</td>
                            <td>" . $row["birth_date"]. "</td>
                            <td>" . $row["occupation_name"]. "</td>
                            <td>" . $row["department"]. "</td>
                            <td>" . $row["hiring_data"]. "</td>
                            <td>" . $row["stax_name"]. "</td>
                            <td>" . $row["benefit_name"]. "</td>
                            <td>" . $row["email"]. "</td>
                            <td>" . $row["phone"]. "</td>
                            <td>" . $row["adress"]. "</td>
                        </tr>";
                    };
                    ?>
                </tbody>
                </div>
        </table>
    
    </div>
        <a href="/main.php"><button id="exit">Назад</button></a>


</body>
</html>