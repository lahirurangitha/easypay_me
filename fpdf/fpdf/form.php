<?php
/**
 * Created by PhpStorm.
 * User: Anjana
 * Date: 11/14/2015
 * Time: 10:10 AM
 */



if(!empty($_POST['submit'])) {
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $message = $_POST['msg'];

    require("fpdf/fpdf.php");

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont("Arial","B",16);
    $pdf->Cell(0,10,"Welcome {$name}",1,1);
    $pdf->Cell(0,10,"name : {$name}",1,1);
    $pdf->Cell(0,10,"mail : {$mail}",1,1);
    $pdf->Cell(0,10,"message : {$message}",1,0);
    $pdf->output();
}
?>