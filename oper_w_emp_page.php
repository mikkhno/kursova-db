<!-- НАДАННЯ ДАНИХ ДЛЯ РОЗРАХУНКУ І СТВОРЕННЯ ЗВІТУ -->
<!-- Встановлення користувацької сесії -->
<?php
session_start();
?>

<!DOCTYPE html>
<html lang = 'ua'>
    <meta charset = 'UTF-8'>
    <head>
        <title>Додати до звіту</title>
        <meta name = 'viewport' content = 'width=device-width,initial-scale=1'>
        <script src = '/sp.js'></script>
        <style><?php include 'css/salary.css';?></style>
        <link href = 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css' rel = 'stylesheet' integrity = 'sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65' crossorigin = 'anonymous'>
    </head>

    <body>
    <div class="backgr"></div>
            <h2 id="Cathedra"> Кафедра НН ІАТЕ</h2>
            <h4 id="KPI">КПІ імені Ігоря Сікорського</h4>
            <img id="prometeus" src="iate-logo.svg" />
            <h3 id="accountant_department">Відділ бухгалтерії</h3>

        <!--Таблиця з інформацією про працівника( PHP and MYSQL )-->
             <div class="table_backgr"></div>
            <table id = 'salary_dep'>
            
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ім'я</th>
                        <th>Прізвище</th>
                        <th>По-батькові</th>
                        <th>Посада</th>
                        <th>Кафедра</th>
                        <th>Соціальні податки</th>
                        <th>Вид пільг</th>
                    </tr>
                </thead>
        
                <tbody>
                    
                    <!-- Підключення таблиці інформації про працівника (PHP) -->
                    <?php
                        //Підключення до серверу
                        $connection = new mysqli("localhost", "root", "root")
                        or die('Connect error( DB. )');
                        mysqli_select_db($connection, 'cathedra_iate');
                        $emp_id = $_SESSION['cur_id'];
                        //Запит на інформацію
                        $show_info = "
                        SELECT emp_id,
                        first_name,
                        last_name,
                        patronymic,
                        occupation_name,
                        department,
                        stax_name,
                        benefit_name
                        FROM employers e
                        JOIN salary_department.occupation so
                            ON e.occupation_id = so.occupation_id
                        LEFT JOIN salary_department.social_taxes st 
                            ON e.stax_id = st.stax_id
                        LEFT JOIN salary_department.social_benefits sb
                            ON e.benefit_id = sb.benefit_id
                        WHERE e.emp_id = '$emp_id';
                        ";
        
                        $result = mysqli_query($connection, $show_info) or die('Connect error( No new info showed).') ;
                        //Висвітлення інформації
                        while( $row = $result -> fetch_assoc() )
                        {
                            echo "<tr>
                                <td>" . $_SESSION[ 'cur_id' ]. "</td>
                                <td>" . $row[ 'first_name' ]. "</td>
                                <td>" . $row[ 'last_name' ]. "</td>
                                <td>" . $row[ 'patronymic' ]. "</td>
                                <td>" . $row[ 'occupation_name' ]. "</td>
                                <td>" . $row[ 'department' ]. "</td>
                                <td>" . $row[ 'benefit_name' ]. "</td>
                                <td>" . $row[ 'stax_name' ]. "</td>
                            </tr>";
                        };
                    ?>
                </tbody>
            </table>
            <div class="data_backgr"></div>

            <!-- Додаємо форму для заповнення -->
            <h1 id="h_txt">Внесення даних</h1>
            <form action = 'report_create.php' method = 'post'>
                <table>

                    <tr>
                        <td id='start_txt'>Період з:<br></td>
                        <td><input type = 'date' name = 'period_start' id="period_start" required></td>
                    </tr>

                    <tr>
                        <td id='finish_txt'>Період по:<br /></td>
                        <td><input type = 'date' name = 'period_finish' id="period_finish" required></td>
                    </tr>

                    <tr>
                        <td id="hours_txt">Відпрацьовано, год.<br /></td>
                        <td><input type = 'number' name = 'hours' min = '1' id="hours" required></td>
                    </tr>

                    <tr>
                        <td id="vac_txt">Відпусткові:<br /></td>
                        <td><input type = 'number' name = 'vacation_days' min = '0' max = '20' id="vacation_days" required></td>
                    </tr>

                    <tr>
                        <td id="disab_txt">Лікарняні:<br /></td>
                        <td><input type = 'number' name = 'disab_days' min = '0' max = '20' id="disab_days" required></td>
                    </tr>

                    <tr><td><input type = 'submit' value = 'Додати і розрахувати' id="submit"></tr></td>

                </table>
            
            </form>
        
                    </div>

            <a href = '/main.php'><button id="back">Назад</button></a>
    </body>
</html>