<?php
//ComputerLaboratory::validateAssignedClass('import');

// if (Form::validate(['import_class'])) {
//     UserManagement::importUser();
// }

// require_once "C:/xampp/htdocs/piratap/vendor/phpoffice/phpexcel/Classes/PHPExcel.php";
//
// $excel = new \PHPExcel();
//
// $excel -> setActiveSheetIndex(0)
//       ->setCellValue('A1', 'Hello')
//       ->setCellValue('B1', 'World');
//
// header('Content-Type: application/vnd.vnd.ms-excel');
// header('Content-Disposition: attachment; filename="test.xlsx"');
// header('Cache-Control: max-age=0');
//
// $file = \PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
// $file->save('php://output');

/** Include PHPExcel */
require_once "C:/xampp/htdocs/piratap/vendor/phpoffice/phpexcel/Classes/PHPExcel.php";

//db connections
$con = mysqli_connect("localhost", "root", "admin", "piratap_db");
// $select = "SELECT * FROM atd_users_attendance AS a
//               LEFT JOIN umg_users AS b ON a.user_id = b.id
//               LEFT JOIN clm_classes AS c ON a.class_id = c.id
//               LEFT JOIN acd_subjects AS d ON c.subject_id = d.id
//               LEFT JOIN clm_classes_schedules AS e ON e.class_id = c.id
//               LEFT JOIN acd_subject_legend AS f ON f.id = d.subject_legend_id;";
if(!$con)
{
  echo mysqli_error($con);
  exit;
}

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();


// Add some data
$objPHPExcel->setActiveSheetIndex(0);

//populate data
$query = mysqli_query($con, $select);
$row = 11;
while($data = mysql_fetch_object($query))
{
  $objPHPExcel = getActiveSheet()
        ->setCellValue('A'.$row, $data->)
}



// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="test.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
// header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
// header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
// header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
// header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
// header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
$objWriter->save('php://output');
exit;
?>
