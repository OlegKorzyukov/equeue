<?php 
require_once('fpdf/fpdf.php');


class PDF extends FPDF
{


function Header()
{	$this->AddFont('Anonymous','','AnonymousPro-Regular.php');
    $this->SetFont('Anonymous', '', 14); 
    $this->SetFillColor(0, 0, 0); 
    $this->SetTextColor(225); 
    $this->Cell(0, 5, "УПРАВЛІННЯ ПРАЦІ ТА СОЦІАЛЬНОГО ЗАХИСТУ", 0, 1, 'C', true);
    $this->Cell(0, 5, "НАСЕЛЕННЯ ВИКОНАВЧОГО КОМІТЕТУ", 0, 1, 'C', true);
    $this->Cell(0, 5, "РАЙОННОЇ РАДИ", 0, 1, 'C', true);
    $this->Cell(0, 5, $address_mail, 0, 1, 'C', true);
}
function Footer() { 
    $this->SetFont('Anonymous', '', 12); 
    $this->SetTextColor(0); 
    $this->SetXY(10,-10); 
    $this->Cell(0, 0, "", 'T', 0, 'C'); 
}
}


$pdf = new PDF('P','mm','A5'); 
$pdf->AddFont('Anonymous','','AnonymousPro-Regular.php');
$pdf->SetFont('Anonymous', '', 12);
$pdf->AddPage(); 

$pdf->SetY(40);
$pdf->SetFont('Anonymous', '', 30);
$pdf->Cell(0, 10, $busy->codequeue ,1,'','C'); 

$pdf->SetY(60);
$pdf->SetFont('Anonymous', '', 12);
$pdf->Cell(40, 10, "Тип прийому",0,'','L');
$pdf->Cell(110, 10, $busy->services_type ,0,'','C'); 

$pdf->SetY(70);
$pdf->SetFont('Anonymous', '', 12);
$pdf->Cell(40, 10, "Дата прийому",0,'','L');
$pdf->Cell(110, 10, $busy->dataqueue ,0,'','C');

$pdf->SetY(80);
$pdf->Cell(40, 10, "Час прийому",0,'','L');
$pdf->Cell(110, 10, $busy->timequeue ,0,'','C');  

$pdf->SetY(90);
$pdf->Cell(40, 10, "ПІБ",0,'','L');
$pdf->MultiCell(110, 5, $fname ,0, "C",false);

$pdf->SetY(105);
$pdf->Cell(40, 10, "Адреса реєстрації",0,'','L');
$pdf->Cell(110, 10,  $address ,0,'','C');

$pdf->SetY(115);
$pdf->Cell(40, 10, "Примітки",0,'','L');
$pdf->SetFont('Anonymous', '', 8);
$pdf->MultiCell(110, 5, $prymitka ,0,"C",false);

$pdf->SetFont('Anonymous', '', 12);
$pdf->SetY(130);
$pdf->Cell(40, 10, "Телефон",0,'','L');
$pdf->Cell(110, 10, $telephone ,0,'','C');

$pdf->SetY(140);
$pdf->Cell(40, 10, "Зареєстровано",0,'','L');
$pdf->Cell(110, 10, $datetimereg ,0,'','C');  

$pdf->SetY(150);
$pdf->Cell(40, 10, "Кабінет",0,'','L');
$pdf->Cell(110, 10, $WorkPlace ,0,'','C'); 

/*$pdf->SetFont('Anonymous', '', 8);
$pdf->SetY(140);
$pdf->Cell(0, 10, "Даю згоду на обробку,",0,'','C');
$pdf->SetY(145);
$pdf->Cell(0, 10, "використання та зберігання моїх персональних даних",0,'','C');
*/

//$message = "Thank you for ordering at the Nettuts+ online store. Our policy is to ship your materials within two business days of purchase. On all orders over $20.00, we offer free 2-3 day shipping. If you haven't received your items in 3 busines days, let us know and we'll reimburse you 5%.We hope you enjoy the items you have purchased. If you have any questions, you can email us at the following email address:"; 
//$pdf->MultiCell(0, 15, $message);

$pdf->SetY(170);
$pdf->SetFont('Courier', 'U', 12); 
$pdf->SetTextColor(1, 162, 232); 
$pdf->Write(13, "test1@ukr.net", "mailto:test1@ukr.net");


$road_file = 'pdf/' . $_POST['fname'].$busy->codequeue.'.pdf';

$count= 1;

if(!file_exists($road_file)){
    $pdf->Output('F', $road_file);
}
else{
    $road_file = 'pdf/' . $_POST['fname'].$busy->codequeue.$count.'.pdf';
    $pdf->Output('F', $road_file);
    $count++;
}

 ?>
