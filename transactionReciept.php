<?php
/**
 * Created by PhpStorm.
 * User: lasithniro
 * Date: 1/8/16
 * Time: 10:04 PM
 */
require_once 'core/init.php';
require_once 'fpdf/fpdf.php';
//include("qr/qrcode.php");
require_once 'qr/qrcode.php';
$qr = new qrcode();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Receipt</title>
</head>
</html>

<?php
/*
 * get session data
 */
$transID = $_SESSION['traID'];
$studentName = $_SESSION['sName'];
$paymentType = $_SESSION['pType'];
$paymentStatus = $_SESSION['stts'];
$amount = $_SESSION['amnt'];
$index = $_SESSION['index'];
//TESTING
/*
$transID = "easyID_002";
$studentName = "Lasith";
$paymentType = "Repeat exam fee";
$paymentStatus = "Completed";
$amount = '200.00';
$index = '13000829';
*/
$image = "images/ucsc.png";
date_default_timezone_set("Asia/Colombo");
$date_now = date("Y-m-d");
$time_now = date("h:i:sa");
$pdf = new FPDF();
$pdf->AddPage();
$pdf->Image($image, 90, 7.5, 23);
$pdf->SetFont("Arial", "B", "15");
$pdf->Cell(0, 60, "University of Colombo School of Computing", 0, 1, "C");
$pdf->SetY(50);
$pdf->SetFont("Arial", "B", "11");
$pdf->Cell(0, 5, "Transaction reciept for ".$paymentType ,0, 1);
$pdf->SetFont("Arial", "", "9");
$pdf->Cell(0, 5, "Issued Date: " . $date_now."     Time: ".$time_now, 0, 1);

//header of table
$pdf->SetY(65);
$pdf->SetFont("Arial", "B", 10);
//$pdf->Cell(10, 10, " No.", 1, 0);
$pdf->Cell(30, 10, " Transaction ID", 1, 0);
$pdf->Cell(35, 10, " Student Index No.", 1, 0);
$pdf->Cell(45, 10, " Payment type", 1, 0);
$pdf->Cell(50, 10, " Status", 1, 0);
$pdf->Cell(20, 10, " Amount", 1, 1);

//fill data
$pdf->SetFont("Arial", "", 10);
//    $pdf->Cell(10, 10, $counter, 1, 0);
$pdf->Cell(30, 10, $transID, 1, 0);
$pdf->Cell(35, 10, $index, 1, 0);
$pdf->Cell(45, 10, $paymentType, 1, 0);
$pdf->Cell(50, 10, $paymentStatus, 1, 0);
$pdf->Cell(20, 10, "Rs.".$amount.'.00', 1, 1);


$str = "Transaction ID = $transID \n Student Index Number = $index \n Payment type = $paymentType \n Amount = $amount \n Payment Status = $paymentStatus \n ";
$qr->text($str);
$file = $qr->get_image();
$qr->save_image($file,'images/QR.png');
$pdf->Image('images/QR.png',175, 12, 20);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(255, 192, 203);
$pdf->Text(160, 10, "www.easypaysl.com");
$pdf->Output();
ob_end_clean();
?>