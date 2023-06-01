<!-- Встановлення користувацької сесії -->
<?php
    session_start();
    $emp_id = $_SESSION['cur_id'];
?>

<!DOCTYPE html>
<html lang="ua">
    <head>
        <!-- Зовнішні ресурси -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <style><?php include 'css/show_list.css'; ?></style>
        <title>Інформація про працівника</title>
    </head>

    <body style = "margin:50px;">
    <div class="backgr">
        <!-- Верхня строчка --> 
        <div class="head">
        <h1 id="title">Звіти</h1>
                    <!-- Сортувальні функції -->
                    <div class="sort_backgr">
            <input type="text" id="searching_surname" onkeyup="SearchSurname()" placeholder = "   Пошук за прізвищем...">
            <select name="sort" id="sort" onchange="Sort()">
            <option value="surname" id="surname" disabled selected>за посадою</option>
            <?php
                        $connection = new mysqli("localhost", "root", "root")
                        or die('Connect error.');

                        mysqli_select_db($connection, 'salary_department');
                        $occup_request="
                        SELECT occupation_id, 
                        occupation_name FROM occupation;
                        "; 
                        
                        $result = mysqli_query($connection, $occup_request) or die('Connect error.') ;
                        while($row = $result -> fetch_assoc())
                        {
                    echo "<option value='".$row["occupation_name"]."'>" . $row["occupation_name"] . "</option>";
                        };
                        
                        ?>
            </select>
        </div>

        <div class="table_bck">
        <div class="info">
            <!--Таблиця з працівниками(PHP and MYSQL)-->
            
            <table class ="table" id="employers_edit">
                <thead>    
                    <tr>
                        <th>№ звіту</th>
                        <th>ID</th>
                        <th>Ім'я</th>
                        <th>Прізвище</th>
                        <th>По-батькові</th>
                        <th>Посада</th>
                        <th>Відпрацьовано годин</th>
                        <th>Період з</th>
                        <th>Період по</th>
                        <th>Чиста ставка, грн</th>
                        <th>Відпускні дні</th>
                        <th>Відпускні, грн</th>
                        <th>Дні непрацездатності</th>
                        <th>Компенсовані, грн</th>
                        <th>Індексація</th>
                        <th>Премія, грн</th>
                        <th>Брутто, грн</th>
                        <th>Аванс, грн</th>
                        <th>Соц. податки, грн</th>
                        <th>У розмірі, грн</th>
                        <th>Всього, грн</th>
                        <th>Категорія пільговика</th>
                        <th>Пільги, грн</th>
                        <th>До сплати, грн</th>
                        <th>Дата проведення операції</th>
                    </tr>
                </thead>
        
                <tbody>
                    <!-- connecting Table "employers" (PHP) -->
                    <?php
                    
                        $connection = new mysqli("localhost", "root", "root")
                        or die('Connect error(DB.)');
        
                        mysqli_select_db($connection, 'salary_department');
                    
                        $query = "
                        SELECT *
                        From receipt_pdf;
                        ";
        
                        $result = mysqli_query($connection, $query) or die('Connect error(nodata).') ;
                        while($row = $result -> fetch_assoc())
                        {
                            echo "<tr>
                                <td>" . $row["pdf_id"]. "</td>
                                <td>" . $row["emp_id"]. "</td>
                                <td>" . $row["first_name"]. "</td>
                                <td>" . $row["last_name"]. "</td>
                                <td>" . $row["patronymic"]. "</td>
                                <td>" . $row["occupation_name"]. "</td>
                                <td>" . $row["working_hours"]. "</td>
                                <td>" . $row["period_start"]. "</td>
                                <td>" . $row["period_finish"]. "</td>
                                <td>" . $row["first_rate"]. "</td>
                                <td>" . $row["vacation_days"]. "</td>
                                <td>" . $row["vacation_bonus"]. "</td>
                                <td>" . $row["disab_days"]. "</td>
                                <td>" . $row["disab_bonus"]. "</td>
                                <td>" . $row["indexation"]. "</td>
                                <td>" . $row["bonus"]. "</td>
                                <td>" . $row["brutto"]. "</td>
                                <td>" . $row["advance_paid"]. "</td>
                                <td>" . $row["stax_name"]. "</td>
                                <td>" . $row["staxes"]. "</td>
                                <td>" . $row["withdrawing"]. "</td>
                                <td>" . $row["benefit_name"]. "</td>
                                <td>" . $row["benefits"]. "</td>
                                <td>" . $row["salary"]. "</td>
                                <td>" . $row["receipt_date"]. "</td>
                            </tr>";
                        };
                        ?>
                </tbody>
            </table>
            </div>
        </div>
        
        <div class = "actions">
            <div class="del_backgr">
            <!-- Видалення звітів -->
            <form name="delete_action" action="del_data.php" method="post">
                <label for="del" id="del_txt">Видалення звіту за номером:</label>
                <input type="number" id="del_field" name="del" min=1 max=20>
                <input type="submit" value="видалити" id="del_butt">
            </form>
            </div>
            <!-- Період з - по -->
            <div class="period_backgr">
                <label for="start" id="start_txt">період з:</label><br>
                <input type="date" id="date_start"><br>
                <label for="finish" id="finish_txt">період по:</label><br>
                <input type="date" id="date_finish"><br>
                <button onclick="DateSort()" id="sort_show">показати</button>
            </div>

            <a href="/main.php"><button id="back">Назад</button></a>


            <!-- Пошук прізвища -->
            <script type="text/javascript">
                function SearchSurname() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("searching_surname");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("employers_edit");
                    tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[3];
                        if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                        }
                    }
                    };
            </script>


            <!-- Сортування за періодом -->
            <script type="text/javascript">
                function DateSort(){
                var start, finish, table, tr, td_start, td_finish, i, txtValue_start, txtValue_finish;
                start = document.getElementById("date_start").value;
                finish = document.getElementById("date_finish").value;
                table = document.getElementById("employers_edit");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td_start = tr[i].getElementsByTagName("td")[7];
                    td_finish = tr[i].getElementsByTagName("td")[8];
                if (td_start || td_finish) {
                    txtValue_start = td_start.textContent || td_start.innerText;
                    txtValue_finish = td_finish.textContent || td_finish.innerText;
                if (txtValue_start < start || txtValue_start > finish) {
                    tr[i].style.display = "none";
                } else {
                tr[i].style.display = "";
                 }
                }
                }
                }
                </script>


                <!-- Сортування за посадою -->
                <script type="text/javascript">
                    function Sort() {
                var input, table, tr, td, i, txtValue;
                input = document.getElementById("sort").value;
                table = document.getElementById("employers_edit");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[5];
                    if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue != input) {
                        tr[i].style.display = "none";
                    } else {
                        tr[i].style.display = "";
                    }
                    }
                }
                };
                </script>
                </div>
    </body>
</html>