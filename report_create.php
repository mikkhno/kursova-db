<!-- СТВОРЕННЯ ЗВІТУ(ГОЛОВНИЙ СКРИПТ РНР) -->
<?php
session_start();
//під'єднання БД
$connection = new mysqli( 'localhost', 'root', 'root' )
or die( 'Connect error( DB. )' );
mysqli_select_db( $connection, 'salary_department' );

// Отримуємо нові дані для звіту
$period_start = $_POST[ 'period_start' ];
$period_finish = $_POST[ 'period_finish' ];
$working_hours = $_POST[ 'hours' ];
$vacation_days = $_POST[ 'vacation_days' ];
$disab_days = $_POST[ 'disab_days' ];
$emp_id = $_SESSION['cur_id'];

//запит на генерування звіту
$receipt_generate = "INSERT INTO receipt_pdf(
    emp_id,
    first_name,
    last_name,
    patronymic,
    occupation_name,
    working_hours,
    period_start,
    period_finish,
    first_rate,
    vacation_days,
    vacation_bonus,
    disab_days,
    disab_bonus,
    indexation,
    bonus,
    brutto,
    advance_paid,
    stax_name,
    staxes,
    withdrawing,
    benefit_name,
    benefits,
    salary,
    receipt_date)
    
        SELECT
        -- ОСНОВНА ІНФОРМАЦІЯ --
            '$emp_id',
            e.first_name,
            e.last_name,
            e.patronymic,
            o.occupation_name,
            '$working_hours',
            '$period_start',
            '$period_finish',
            @first_rate:= o.hour_rate * o.tariff * '$working_hours',
            
        -- ДНІ ВІДПУСТКИ/НЕПРАЦЕЗДАТНОСТІ --
            '$vacation_days',
            @vacation_bonus:= o.hour_rate * o.tariff * '$vacation_days' * o.workhours * o.vacation_paid,
            '$disab_days',
            @disab_bonus:= o.hour_rate * o.tariff * '$disab_days' * o.workhours * o.disab_benefits,
            o.indexation,
            @bonus:= @first_rate * o.bonus,
            @brutto:= (
                @first_rate + @vacation_bonus + @disab_bonus + @bonus
            ) * o.indexation,
    
        -- НАЛОГИ --           
        @advance_paid:= @first_rate * o.advance_paid,
        st.stax_name,
        @staxes:= CASE
        WHEN e.stax_id IS NULL
        THEN @staxes:=0
        ELSE @staxes:= @first_rate * st.stax_perc
        END,
    
            @withdrawing:= @advance_paid + @staxes,
            sb.benefit_name,
            @benefits:=
            CASE
            WHEN e.benefit_id IS NULL
            THEN @benefits:= 0
            ELSE @benefits:= sb.first_benefit_value * sb.percentage
            END,
            @salary:= @brutto + @benefits - @withdrawing,
            NOW()

        FROM cathedra_iate.employers e
        
        LEFT JOIN occupation o
            ON e.occupation_id = o.occupation_id
                
        LEFT JOIN social_taxes st
			 ON e.stax_id = st.stax_id
    
        LEFT JOIN social_benefits sb
            ON e.benefit_id = sb.benefit_id
            
		WHERE emp_id = '$emp_id';";

//Запити на виконання операцій
$new_receipt_added = mysqli_query( $connection, $receipt_generate ) or die( 'Connect error( New receipt was not generated ).');
echo 'Розраховано.'
;

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
    <a href="/show.php"><button>Розрахунки за цим працівником_цею</button></a>
</body>
</html>