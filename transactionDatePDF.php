
<?php
/**
 * Created by PhpStorm.
 * User: anjana
 * Date: 1/2/16
 * Time: 1:22 PM
 */
require_once 'core/init.php';
require_once 'fpdf/fpdf.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>All | transactions</title>
</head>
</html>

<?php
if(isset($_SESSION['date1'])) {
    $date = $_SESSION['date1'];
    $image = "images/ucsc.png";
    date_default_timezone_set("Asia/Colombo");
    $date_now = date("Y-m-d");
    $time_now = date("h:i:sa");
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->Image($image, 90, 7.5, 23);
    $pdf->SetFont('Arial','B',15);
    $pdf->SetTextColor(255,192,203);

    $pdf->Text(150,10,"www.easypaysl.com");
    $pdf->SetFont('Arial','B',15);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont("Arial", "B", "15");
    $pdf->Cell(0, 60, "University of Colombo School of Computing", 0, 1, "C");
    $pdf->SetY(50);
    $pdf->SetFont("Arial", "", "11");
    $pdf->Cell(0, 5, "All transactions on ".$date, 0, 1);
    $pdf->SetFont("Arial", "", "9");
    $pdf->Cell(0, 5, "Issued Date: " . $date_now."     Time: ".$time_now, 0, 1);
//    if (Input::exists()) {
//        if ($y = Input::get('year')) {
//            //        echo "Year: $y<br>";
//        }
//        if ($m = Input::get('month')) {
//            $month = "$m";
//            //        echo "Month: $month<br>";
//            //        echo "<script type='text/javascript'src='js/functions.js'> showElement('mt')</script>";
//        }
//        if ($d = Input::get('date')) {
//            //            echo $date;
//            $date = "$y-$m-$d";
//            //        echo "Date: $date<br>";
//        }
    $DayTra = DB::getInstance()->get('transaction', array('date', '=', $date));
    if (!$DayTra->count()) {
        // echo 'No transactions';
        $pdf->Cell(0, 60, "No transactions found", 0, 1, "C");
    } else {
        $pdf->SetY(65);
        $pdf->SetFont("Arial", "B", 10);
        $pdf->Cell(10, 10, " No.", 1, 0);
        $pdf->Cell(30, 10, " Transaction ID", 1, 0);
        $pdf->Cell(22, 10, " Date", 1, 0);
        $pdf->Cell(18, 10, " Time", 1, 0);
        $pdf->Cell(35, 10, " Payment type", 1, 0);
        $pdf->Cell(60, 10, " Status", 1, 0);
        $pdf->Cell(20, 10, " Amount", 1, 1);
        $counter = 0;
        foreach ($DayTra->results() as $t) {
            //payment type check
            $p1 = DB::getInstance()->get('ucsc_registration',array('transactionID','=',$t->transactionID))->count();
            $p2 = DB::getInstance()->get('new_academic_year',array('transactionID','=',$t->transactionID))->count();
            $p3 = DB::getInstance()->get('repeat_exam',array('transactionID','=',$t->transactionID))->count();
            if($p1>0){
                $paymentType = 'UCSC Registration';
            }elseif($p2>0){
                $paymentType = 'New Academic Year';
            }elseif($p3>0){
                $paymentType = 'Repeat Exam';
            }else{
                $paymentType = 'Other';
            }
            //
            $counter += 1;
            $date = $t->date;
            $time = $t->time;
            $transactionID = $t->transactionID;
//                $paymentType = $t->paymentType;
            $status = $t->statusDescription;
            $amount = $t->amount;
            $newID = Transaction::encodeEasyID("easyID_", $transactionID);
            $pdf->SetFont("Arial", "", 10);
            $pdf->Cell(10, 10, $counter, 1, 0);
            $pdf->Cell(30, 10, $newID, 1, 0);
            $pdf->Cell(22, 10, $date, 1, 0);
            $pdf->Cell(18, 10, $time, 1, 0);
            $pdf->Cell(35, 10, $paymentType, 1, 0);
            $pdf->Cell(60, 10, $status, 1, 0);
            $pdf->Cell(20, 10, "Rs.".$amount.".00", 1, 1);
        }
    }
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(255, 192, 203);

    $pdf->Output();
    ob_end_clean();
}
?>


