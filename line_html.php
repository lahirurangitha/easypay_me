<?php
require_once 'core/init.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Statistics | Page</title>
    <?php include 'headerScript.php'?>
</head>

<body>
<div id="wrapper">
    <?php
    include "header.php";
    ?>
</div>
<div class="backgroundImg container-fluid">
    <?php
    include "adminSidebar.php";
    ?>
    <br>
    <div class="container col-sm-5">
        <div class="box box-primary col-sm-6">
            <div class="box-header with-border">
                <h3 class="box-title"><strong>Payment Statistics</strong></h3>
            </div>
            <div class="box-body">
                <?php
                ///
                $user  = new User();
                $transaction = new Transaction();

                if(!$user->isLoggedIn()){Redirect::to('index.php');}
                if(!$user->hasPermission('admin')){Redirect::to('index.php');}
                $x = '2015';
                if(Input::exists()){
                    $x = Input::get('selector');
                } else {
                    $x = '2015';
                }
                $sql = "SELECT * FROM transaction WHERE date LIKE '$x%'";
                $traData = DB::getInstance()->query($sql);
                //print_r($traData);
                $tmp = $traData->results();
                //    print_r($tmp);
                $arr = array();
                foreach ($tmp as $t){
                    $tmp = $t->date[5].$t->date[6];
                    array_push($arr,$tmp);
                }
                $cnt = array(
                    '01'=>0,
                    '02'=>0,
                    '03'=>0,
                    '04'=>0,
                    '05'=>0,
                    '06'=>0,
                    '07'=>0,
                    '08'=>0,
                    '09'=>0,
                    '10'=>0,
                    '11'=>0,
                    '12'=>0
                );
                $tmp1 = array_count_values($arr);
                $cnt = array_replace($cnt,$tmp1);
                //    print_r($cnt);
                ?>
                <div class="col-sm-3">
                    <form name="data" action="" method="post">
                        <select name="selector" class="form-control" onchange="">
                            <?php
                            for($i = 2015 ; $i < date('Y')+1; $i++){
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <button class="btn btn-primary btn-xs col-sm-12" type="submit" value="Generate">Generate graph</button>
                    </form>
                </div>

                <div style="width:100%">
                    <div>
                        <canvas id="canvas" height="450" width="600"></canvas>
                    </div>
                </div>

                <script>
                    var phpCnt = <?php echo json_encode($cnt); ?>;
                    var randomScalingFactorDB = function(i){ return phpCnt[i]};
                    //    var randomScalingFactor = function(){ return Math.round(Math.random()*10)};
                    var lineChartData = {
                        labels : ["January","February","March","April","May","June","July","August","September","October","November","December"],
                        datasets : [
                            {
                                label: "My First dataset",
                                fillColor : "rgba(151,187,205,0.2)",
                                strokeColor : "rgba(151,187,205,1)",
                                pointColor : "rgba(151,187,205,1)",
                                pointStrokeColor : "#fff",
                                pointHighlightFill : "#fff",
                                pointHighlightStroke : "rgba(151,187,205,1)",
                                data : [randomScalingFactorDB("01"), //jan
                                    randomScalingFactorDB("02"), //feb
                                    randomScalingFactorDB("03"), //march
                                    randomScalingFactorDB("04"), //april
                                    randomScalingFactorDB("05"), //may
                                    randomScalingFactorDB("06"), //june
                                    randomScalingFactorDB("07"), //jule
                                    randomScalingFactorDB("08"), //aug
                                    randomScalingFactorDB("09"), //sept
                                    randomScalingFactorDB("10"), //oct
                                    randomScalingFactorDB("11"), //nov
                                    randomScalingFactorDB("12")] //dec
                            }
                        ]

                    }
                    window.onload = function(){
                        var ctx = document.getElementById("canvas").getContext("2d");
                        window.myLine = new Chart(ctx).Line(lineChartData, {
                            responsive: true
                        });
                    }

                </script>

            </div>
        </div>
        </div>
    <!--        pie chart-->
    <div class="col-sm-4">

        <div class="box box-primary col-sm-4">
            <div class="box-header with-border">
                <h3 class="box-title"><strong>Total Payment Statistics</strong></h3>
            </div>
            <div class="box-body">
                <?php

                $sql1 = "SELECT count(*) as c FROM new_academic_year WHERE paymentStatus=1";
                $new_aca_Data = DB::getInstance()->query($sql1);
                $d1 = $new_aca_Data->results()[0]->c;
                //echo($d1 . "<br />");

                $sql2 = "SELECT count(*) as c FROM ucsc_registration WHERE paymentStatus=1";
                $regis_Data = DB::getInstance()->query($sql2);
                $d2 = $regis_Data->results()[0]->c;
                //echo($d2 . "<br />");

                $sql3 = "SELECT count(*) as c FROM repeat_exam WHERE paymentStatus=1";
                $repeat_Data = DB::getInstance()->query($sql3);
                $d3 = $repeat_Data->results()[0]->c;
                //echo($d3 . "<br />");

                $arr  = array();
                array_push($arr,$d1);
                array_push($arr,$d2);
                array_push($arr,$d3);

                //print_r($arr);

                ?>


                <div style="width:100%">
                    <div>
                        <canvas id="skills" width="300" height="300"></canvas>
                    </div>
                </div>

                <script>
                    var phpCnt = <?php echo json_encode($arr); ?>;
                    var pieData = [
                        {
                            value: phpCnt[0],
                            label: 'pay for new academic year',
                            color: '#811BD6'
                        },
                        {
                            value: phpCnt[1],
                            label: 'pay for ucsc registration',
                            color: '#6AE128'
                        },
                        {
                            value: phpCnt[2],
                            label: 'pay for repeat exams',
                            color: '#D18177'
                        }

                    ];
                    var context = document.getElementById('skills').getContext('2d');
                    var skillsChart = new Chart(context).Pie(pieData);
                </script>

            </div>
        </div>
    </div>

</div>
<?php
include "footer.php";
?>



</body>
</html>