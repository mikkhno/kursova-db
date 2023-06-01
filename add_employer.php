<!-- ДОДАВАННЯ НОВОГО ПРАЦІВНИКА -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <style><?php include 'css/newemp.css';?></style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новий працівник</title>
</head>

<body>
    <div class="backgr">
            <h2 id="Cathedra"> Кафедра НН ІАТЕ</h2>
            <h4 id="KPI">КПІ імені Ігоря Сікорського</h4>
            <img id="prometeus" src="iate-logo.svg" />
            <h3 id="accountant_department">Відділ бухгалтерії</h3>


        
        <div class="form_backgr"></div>
        <h1 id="title">Новий працівник</h1>
        <form name="new_employer" action="add-emp.php" method="post">
    
   

            
                <p id="surname">Прізвище:</p>

               <input type="text" name="last_name" id="last_name" required>

    

          
                <p id="name">Ім'я:</p>

               <input type="text" name="first_name" id="first_name" required>

          
                <p id="patr">По-батькові:</p>

                <input type="text" name="patronymic" id="patronymic" required>

         

            
                <p id="occupation">Посада:</p>

                    <select name="occupation_id" id="occ_name">
                    <option id="null" value = "0" disabled selected>оберіть...</option>
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
                            echo "<option value='".$row["occupation_id"]."'>" . $row["occupation_name"] . "</option>";
                            };
                            
                            ?>
                    </select>



            
                <p id="hiring">Працює з:</p>

                <input type="date" name="hiring_data" id="hire_data" required>

            
                <p id="taxes">Соціальні податки(якщо є):</p>
                    <select name="stax_id" id="stax_name">
                    <option id="null" value = "0" disabled selected>оберіть...</option>
                        <?php
                            $connection = new mysqli("localhost", "root", "root")
                            or die('Connect error.');

                            mysqli_select_db($connection, 'salary_department');
                            $occup_request="
                            SELECT stax_id, 
                            stax_name FROM social_taxes;
                            "; 
                            
                            $result = mysqli_query($connection, $occup_request) or die('Connect error.') ;
                            while($row = $result -> fetch_assoc())
                            {
                            echo "<option value='".$row["stax_id"]."'>" . $row["stax_name"] . "</option>";
                            };
                            
                            ?>
                    </select>

            
                <p id="benefits">Пільги(якщо є):</p>
                    <select name="benefit_id" id="ben_name">
                    <option id="null" value = "0" disabled selected>оберіть...</option>
                        <?php
                            $connection = new mysqli("localhost", "root", "root")
                            or die('Connect error.');

                            mysqli_select_db($connection, 'salary_department');
                            $occup_request="
                            SELECT benefit_id, 
                            benefit_name FROM social_benefits;
                            "; 
                            
                            $result = mysqli_query($connection, $occup_request) or die('Connect error.') ;
                            while($row = $result -> fetch_assoc())
                            {
                            echo "<option value='".$row["benefit_id"]."'>" . $row["benefit_name"] . "</option>";
                            };
                            
                            ?>
                    </select>

                <p id="bday">Дата народження:</p>

               <input type="date" name="birth_date" id="bday_date" >

                <p id="email">Пошта:</p>

                <input type="email" name="email" id="e-mail_field"required>


            
                <p id="phone">Мобільний:</p>
                <input type="number" name="phone" id="num" >

                <p id="adress">Домашня адреса:</p>
                <input type="text" name="adress" id="adr" required>

                <input type="submit" value="Додати" id="continue">
 

        

    </form>

    <a href="/main.php"><button id="exit">Назад</button></a>
</div>
</body>
</html>