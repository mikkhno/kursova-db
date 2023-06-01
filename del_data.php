<!-- ВИДАЛЕННЯ ЗВІТУ З SHOW.PHP -->
<?php
$value_to_del = $_POST['del'];
$connection = new mysqli( 'localhost', 'root', 'root' )
or die( 'Connect error(DB.)' );

mysqli_select_db( $connection, 'salary_department' );

$query = "
DELETE FROM
salary_department.receipt_pdf
WHERE pdf_id = '$value_to_del';";

$result = mysqli_query( $connection, $query ) or die( 'Connect error(nodata).' ) ;
require('show.php');
?>