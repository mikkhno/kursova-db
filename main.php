<!-- ГОЛОВНА СТОРІНКА. МЕНЮ ФУНКЦІОНАЛУ -->

<!-- Встановлення користувацької сесії -->
<?php
    session_start();
$_SESSION['cur_id'] = NULL;
?>

<!-- Початок HTML файлу -->
<!DOCTYPE html>
<html lang="ua">
<head>
    <meta charset="UTF-8">
    <title>Головна сторінка</title>
    <!-- Під'єднання BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- Під'єднання JS -->
    <script src="/main_script.js"></script>
    <!-- Під'єднання CSS -->
    <style><?php include 'css/main.css'; ?></style>
    
</head>

<body style="margin:50px;">
    <div class="backgr">

        <!-- Шапка сайту -->
        <div class="head">
            <h1 id="helloworld">Вітаємо, <?php echo $_SESSION["Username"]?>!</h1>
            <h2 id="Cathedra"> Кафедра НН ІАТЕ</h2>
            <h4 id="KPI">КПІ імені Ігоря Сікорського</h4>
            <img id="prometeus" src="iate-logo.svg" />
            <h3 id="accountant_department">Відділ бухгалтерії</h3>
        </div>
    
        <div class="table">

        <!-- Кнопки +/і -->
        <a href="/add_employer.php"><button id="add">+</button></a>
        <a href="/empedit.php"><button id="i">i</button></a>


        <!--Таблиця з працівниками кафедри(PHP and MYSQL)-->
        <table class="table" id="employers">
            
            <!-- Стовпці -->
            <thead> 
            <h2 id="list_title">Список працівників</h2>   
                <tr class="head" id = "head">
                    <th class="head" id="checkbox"></th>
                    <th class="head" id="id">Id</th>
                    <th class="head" id="name">Ім'я</th>
                    <th class="head" id="surname">Прізвище</th>
                    <th class="head" id="patronymic">По-батькові</th>
                    <th class="head" id="occupation">Посада</th>
                </tr>
            </thead>

            <!-- Список працівників -->
                <tbody id="content">
                
                    <!-- Підключення таблиці "employers" (PHP) -->
                    <?php
                        $connection = new mysqli("localhost", "root", "root")
                        or die('Connect error.');

                        mysqli_select_db($connection, 'cathedra_iate');
                    
                        $query = "
                        SELECT emp_id,
                        first_name,
                        last_name,
                        patronymic,
                        occupation_name
                    
                        FROM employers e
                        JOIN salary_department.occupation so
                            ON e.occupation_id = so.occupation_id;
                        ";

                        $result = mysqli_query($connection, $query) or die('Connect error.') ;
                        while($row = $result -> fetch_assoc())
                        {
                        echo
                            "<tr>
                                <td>" .'<input type="checkbox" name="checkboxes" onclick="getValue();">'."</td>
                                <td>" . $row["emp_id"]. "</td>
                                <td>" . $row["first_name"]. "</td>
                                <td>" . $row["last_name"]. "</td>
                                <td>" . $row["patronymic"]. "</td>
                                <td>" . $row["occupation_name"]. "</td>

                            </tr>";
                        }

                        ?>
                    </tbody>

                    <!-- Дії над таблицею -->
                    <a href="/oper_w_emp_page.php"><button id="SalaryWithdraw"> 
                    Розрахувати зарплатню</button></a>
                    
        </table>
    </div>

    <div class="right_buttons">

        <!-- керування сайтом, функціонал -->
        <a href="/logout.php" ><button id="exit">Вийти</button></a>
        <a href="/show.php"><button id="last_summary">Останні звіти</button></a>
        
        <!--Пошук працівника за прізвищем SearchSurname(JS)-->
        <input type="text" id="searching_surname" onkeyup="SearchSurname()" placeholder = "Пошук за прізвищем...">
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


  <!-- Додає ID працівника до адреси сторінки -->
    <script> 
        function getValue(){
            var grid = document.getElementById("employers");
            var checkBoxes = grid.getElementsByTagName("INPUT");
            var message = [];
            for (var i = 0; i < checkBoxes.length; i++) {
                if (checkBoxes[i].checked) {
                var row = checkBoxes[i].parentNode.parentNode;
                message = row.cells[1].innerHTML;
                }
            }
        //індикатор параметрів(тільки для демонстрації обраного айді)
        const nextURL = 'main.php?cur_id=' + message;
        const nextTitle = 'My new page title';
        const nextState = { additionalInformation: 'Updated the URL with JS' };
        window.history.pushState(nextState, nextTitle, nextURL);
        window.history.replaceState(nextState, nextTitle, nextURL);

        //задіяно cur_id_attr.php
        $.ajax({
    type: 'get', 
    url: 'cur_id_attr.php', 
    data: {
        'cur_id': message}});

    };

    </script>



<!-- Сортування за посадою -->
        <script type="text/javascript">
        function Sort() {
        var input, table, tr, td, i, txtValue;
        input = document.getElementById("sort").value;
        table = document.getElementById("employers");
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