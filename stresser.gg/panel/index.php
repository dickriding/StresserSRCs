<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("header.php");
$paketid = $user["uyelik"];
$paket = @mysqli_query($baglanti, "select * from paketler where id='$paketid'");
$paket = $paket->fetch_assoc();
$tarih2 = date("Y-m-d");
$userid = $_SESSION["id"];
$log = mysqli_num_rows(mysqli_query($baglanti, "select * from log where user='$userid' and  tarih between '$tarih2 00:00:00' and '$tarih2 23:59:59'"));

?>
<link rel="stylesheet" type="text/css" href="assets/css/widgets/modules-widgets.css">
<style type="text/css">
    hr.style-three {
        border: 0;
        border-bottom: 1px dashed #ccc;
        background: #999;
    }

    .info-detail-1,
    .info-detail-2 {
        border-bottom: 1px solid white;
        margin-bottom: 15px;
    }

    .widget-account-invoice-one .invoice-box .acc-total-info {
        border-bottom: unset !important
    }

    .widget-account-invoice-one .invoice-box .inv-detail {
        border-bottom: unset !important
    }
</style>

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <h6 class="value"><?php echo mysqli_num_rows(mysqli_query($baglanti, "select * from user")); ?></h6>
                                <p class="">Total Members</p>
                            </div>
                            <div class="">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <h6 class="value"><?php echo mysqli_num_rows(mysqli_query($baglanti, "select * from log ")); ?></h6>
                                <p class="">Total Attacks</p>
                            </div>
                            <div class="">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart">
                                        <line x1="12" y1="20" x2="12" y2="10"></line>
                                        <line x1="18" y1="20" x2="18" y2="4"></line>
                                        <line x1="6" y1="20" x2="6" y2="16"></line>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <h6 class="value"><?php $tarih = date("Y-m-d H:i:s");
                                                    echo mysqli_num_rows(mysqli_query($baglanti, "select * from log where sonlanma > '$tarih'")); ?> <?php $deger = mysqli_fetch_array(mysqli_query($baglanti, "SELECT SUM(es_zaman) as toplam FROM sunucular")); // echo $deger['toplam'];
                                                                                                                                                                                    ?></h6>
                                <p class="">Running Attacks</p>
                            </div>
                            <div class="">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap">
                                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">

                                <h6 class="value">25</h6>
                                <p class="">Online Servers</p>
                            </div>
                            <div class="">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server">
                                        <rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect>
                                        <rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect>
                                        <line x1="6" y1="6" x2="6.01" y2="6"></line>
                                        <line x1="6" y1="18" x2="6.01" y2="18"></line>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-chart-one" style="padding: 60px 0;">
                    <div class="widget-heading" id="che">
                        <h5 style="text-align: center;
    font-size: 1.7rem;
    position: relative;
    top: -60px;
    background-color: #0E1727;
    border-radius: 6px;
    padding: 10px 10px;
    width: fit-content;
    margin: 0 auto;">Last 7 Days Attacks</h5>
                    </div>

                    <div class="widget-content">
                        <div class="tabs tab-content">
                            <div id="content_1" class="tabcontent">
                                <div id="statss"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">

                <div class="widget widget-account-invoice-one" style="padding:25px;">

                    <div class="widget-heading">
                        <img src="https://cdn-icons-png.flaticon.com/512/4289/4289784.png" alt="avatar" style="height: 75px; display: block; margin-left: auto; margin-right: auto; margin-bottom: 10px;">
                    </div>

                    <div class="widget-content" style="position: auto;">
                        <div class="invoice-box">

                            <div class="acc-total-info">
                                <h5>Balance</h5>
                                <p class="acc-amount">€<?php echo $user["bakiye"]; ?></p>
                            </div>
                            <div class="info-detail-2"></div>

                            <div class="inv-detail">
                                <?php if ($user["uyelik"] == "0") { ?>
                                    <div class="media">
                                        <div class="w-img">
                                            <img src="../img/fire.png" alt="avatar" style="height: 50px; display: block; margin-left: auto; margin-right: auto; margin-bottom: 10px;">
                                        </div>
                                        <div class="media-body">
                                            <cz2>Concurrents</cz2></br>
                                            <cz class="meta-date-time">n/a</cz>
                                        </div>
                                    </div>

                                    <div class="media">
                                        <div class="w-img">
                                            <img src="../img/clock.png" alt="avatar" style="height: 50px; display: block; margin-left: auto; margin-right: auto; margin-bottom: 10px;">
                                        </div>
                                        <div class="media-body">
                                            <cz2>Max Boot</cz2></br>
                                            <cz class="meta-date-time">n/a</cz>
                                        </div>
                                    </div>

                                    <div class="media">
                                        <div class="w-img">
                                            <img src="../img/network.png" alt="avatar" style="height: 50px; display: block; margin-left: auto; margin-right: auto; margin-bottom: 10px;">
                                        </div>
                                        <div class="media-body">
                                            <cz2>Premium Network</cz2></br>
                                            <cz class="meta-date-time">n/a</cz>
                                        </div>
                                    </div>

                                    <div class="media">
                                        <div class="w-img">
                                            <img src="../img/calendar.png" alt="avatar" style="height: 50px; display: block; margin-left: auto; margin-right: auto; margin-bottom: 10px;">
                                        </div>
                                        <div class="media-body">
                                            <cz2>Expire Date</cz2></br>
                                            <cz class="meta-date-time">n/a</cz>
                                        </div>
                                    </div>

                                <?php } else { ?>

                                    <div class="media">
                                        <div class="w-img">
                                            <img src="../img/fire.png" alt="avatar" style="height: 50px; display: block; margin-left: auto; margin-right: auto; margin-bottom: 10px;">
                                        </div>
                                        <div class="media-body">
                                            <cz2>Concurrents</cz2></br>
                                            <cz class="meta-date-time"><?php echo $paket["es_zaman"]; ?></cz>
                                        </div>
                                    </div>

                                    <div class="media">
                                        <div class="w-img">
                                            <img src="../img/clock.png" alt="avatar" style="height: 50px; display: block; margin-left: auto; margin-right: auto; margin-bottom: 10px;">
                                        </div>
                                        <div class="media-body">
                                            <cz2>Max Boot</cz2></br>
                                            <cz class="meta-date-time"><?php echo $paket["max_sure"]; ?></cz>
                                        </div>
                                    </div>

                                    <?php
                                    if ($paket["node"] == "VIP") {
                                        $satirSonuc = 'Enabled';
                                    } else {
                                        $satirSonuc = 'Disabled';
                                    }
                                    ?>

                                    <div class="media">
                                        <div class="w-img">
                                            <img src="../img/network.png" alt="avatar" style="height: 50px; display: block; margin-left: auto; margin-right: auto; margin-bottom: 10px;">
                                        </div>
                                        <div class="media-body">
                                            <cz2>Premium Network</cz2></br>
                                            <cz class="meta-date-time"><?php echo $satirSonuc ?></cz>
                                        </div>
                                    </div>

                                    <div class="media">
                                        <div class="w-img">
                                            <img src="../img/calendar.png" alt="avatar" style="height: 50px; display: block; margin-left: auto; margin-right: auto; margin-bottom: 10px;">
                                        </div>
                                        <div class="media-body">
                                            <cz2>Expire Date</cz2></br>
                                            <cz class="meta-date-time"><?php if ($user["uyelik_son"] != "0" && $user["uyelik"] != "1") {
                                                                            echo $user["uyelik_son"];
                                                                        } else {
                                                                            echo 'Lifetime';
                                                                        } ?></cz>
                                        </div>
                                    </div>


                                <?php } ?>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-three" style="padding:25px;">

                    <div class="widget-heading">
                        <h5 style="text-align: center;
    font-size: 1.7rem;
    position: relative;
    top: -24px;
    background-color: #0E1727;
    border-radius: 6px;
    padding: 10px 10px;
    width: fit-content;
    margin: 0 auto;"><a href="news">News</a></h5>
                    </div>

                    <div class="widget-content">

                        <div class="row">
                            <?php
                            $data = mysqli_query($baglanti, "select * from haberler ORDER BY id DESC LIMIT 3");
                            while ($satir = mysqli_fetch_array($data)) {
                            ?>
                                <div class="col-md-4">
                                    <div class="card-body" style="background: #191e3a;border: none;border-radius: 4px;margin-bottom: 30px;">

                                        <div class="task-header">

                                            <div class="">
                                                <h4 style="text-align: center !important"><?php echo $satir['baslik']; ?></h4>
                                            </div>

                                        </div>

                                        <div class="task-body" style="padding-top: 5px !important">

                                            <div class="task-content">
                                                <p class="" data-tasktext="<?php echo str_replace('"', "", html_entity_decode($satir['yazi'])); ?>">
                                                    <?php echo html_entity_decode($satir['yazi']); ?></p>


                                            </div>



                                        </div>

                                    </div>
                                </div>
                            <?php

                            }

                            ?>


                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="widget widget-chart-two" style="padding:25px;">
                    <div class="widget-heading" id="che">
                        <h5 style="text-align: center;
    font-size: 1.7rem;
    position: relative;
    top: -20px;
    background-color: #0E1727;
    border-radius: 6px;
    padding: 10px 10px;
    width: fit-content;
    margin: 0 auto;">Frequently Used Methods</h5>
                    </div>

                    <div class="widget-content">
                        <div id="statssx" class=""></div>
                    </div>


                </div>
            </div>
        </div>

    </div>
    <script src="assets/js/widgets/modules-widgets.js"></script>
    <?php include("footer.php"); ?>
    <script>
        var sLineAreas = {
            chart: {
                height: 350,
                widt: "full",
                type: 'area',
            },
            dataLabels: {
                enabled: false
            },
            markers: {
                discrete: [{
                    seriesIndex: 0,
                    dataPointIndex: 7,
                    fillColor: '#000',
                    strokeColor: '#000',
                    size: 5
                }, {
                    seriesIndex: 2,
                    dataPointIndex: 11,
                    fillColor: '#000',
                    strokeColor: '#000',
                    size: 4
                }]
            },
            stroke: {
                show: true,
                curve: 'smooth',
                width: 2,
                lineCap: 'square'
            },
            series: [{
                name: 'Attack History',
                data: [<?php $tarih2 = date("Y-m-d", strtotime("-6 day"));
                        echo mysqli_num_rows(mysqli_query($baglanti, "select * from log where tarih between '$tarih2 00:00:00' and '$tarih2 23:59:59'")); ?>, <?php $tarih2 = date("Y-m-d", strtotime("-5 day"));
                                                                                                                                                                                                                echo mysqli_num_rows(mysqli_query($baglanti, "select * from log where tarih between '$tarih2 00:00:00' and '$tarih2 23:59:59'")); ?>, <?php $tarih2 = date("Y-m-d", strtotime("-4 day"));
                                                                                                                                                                                                                                                                                                                                                                                                    echo mysqli_num_rows(mysqli_query($baglanti, "select * from log where tarih between '$tarih2 00:00:00' and '$tarih2 23:59:59'")); ?>, <?php $tarih2 = date("Y-m-d", strtotime("-3 day"));
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo mysqli_num_rows(mysqli_query($baglanti, "select * from log where tarih between '$tarih2 00:00:00' and '$tarih2 23:59:59'")); ?>, <?php $tarih2 = date("Y-m-d", strtotime("-2 day"));
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo mysqli_num_rows(mysqli_query($baglanti, "select * from log where tarih between '$tarih2 00:00:00' and '$tarih2 23:59:59'")); ?>, <?php $tarih2 = date("Y-m-d", strtotime("-1 day"));
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo mysqli_num_rows(mysqli_query($baglanti, "select * from log where tarih between '$tarih2 00:00:00' and '$tarih2 23:59:59'")); ?>, <?php $tarih2 = date("Y-m-d", strtotime("-0 day"));
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo mysqli_num_rows(mysqli_query($baglanti, "select * from log where tarih between '$tarih2 00:00:00' and '$tarih2 23:59:59'")); ?>]
            }],

            xaxis: {
                categories: ["<?php echo date("Y-m-d", strtotime("-7 day")); ?>", "<?php echo date("Y-m-d", strtotime("-5 day")); ?>", "<?php echo date("Y-m-d", strtotime("-4 day")); ?>", "<?php echo date("Y-m-d", strtotime("-3 day")); ?>", "<?php echo date("Y-m-d", strtotime("-2 day")); ?>", "Yesterday", "Today"],
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                offsetY: -50,
                fontSize: '16px',
                fontFamily: 'Quicksand, sans-serif',
                markers: {
                    width: 10,
                    height: 10,
                    strokeWidth: 0,
                    strokeColor: '#fff',
                    fillColors: undefined,
                    radius: 12,
                    onClick: undefined,
                    offsetX: 0,
                    offsetY: 0
                },
                itemMargin: {
                    horizontal: 0,
                    vertical: 20
                }
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            },
            responsive: [{
                breakpoint: 575,
                options: {
                    legend: {
                        offsetY: -30,
                    },
                },
            }]
        }

        var chart = new ApexCharts(
            document.querySelector("#statss"),
            sLineAreas
        );

        chart.render();
        <?php
        $chartMethods = [];
        try {
            $db = new PDO("mysql:host=localhost;dbname=web", "root", "");
        } catch (PDOException $e) {
            print $e->getMessage();
        }
        $getTotal = 4;
        $queryMethod = $db->query("SELECT * FROM method WHERE node != 'Free'", PDO::FETCH_ASSOC);
        if ($queryMethod->rowCount()) {
            foreach ($queryMethod as $row) {
                $method = $row["deger"];
                $total = $db->query("SELECT * FROM log WHERE method = '$method'", PDO::FETCH_ASSOC);
                $total = $total->rowCount();
                $chartMethods[$method] = $total;
                //$chartMethods[$row["deger"]] = ezbircir($db, $row["deger"]);

            }
        }
        arsort($chartMethods);
        /*$nChartMethods = $chartMethods;
$cmIndex = 0;
foreach($chartMethods as $k => $v) {
    if($cmIndex < $getTotal) {
        print_r($k.", ");
        $cmIndex++;

        <?php echo mysqli_num_rows(mysqli_query($baglanti,"select * from sunucular"));?> // online servers
    }
}*/
        $chartMethods = array_slice($chartMethods, 0, $getTotal, true);
        $cKeys = array_keys($chartMethods);
        $total = count($cKeys);
        $cValues = array_values($chartMethods);
        $cnKeys = "";
        $cnValues = "";
        foreach ($cKeys as $key) {
            $cnKeys = $cnKeys . "'" . $key . "', ";
        }
        $cKeys = substr($cnKeys, 0, -2);
        foreach ($cValues as $val) {
            $cnValues = $cnValues . "" . $val . ", ";
        }
        $cValues = substr($cnValues, 0, -2);

        function randomColor()
        {
            $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
            $color = '#' . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)];
            return $color;
        }

        $cColors = "";
        for ($i = 1; $i <= $total; $i++) {
            $cColors = $cColors . "'" . randomColor() . "', ";
        }
        $cColors = substr($cColors, 0, -2);
        ?>

        var sLineAreas2 = {
            chart: {
                type: 'donut',
                width: 450
            },
            colors: [<?= $cColors ?>],
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '14px',
                markers: {
                    width: 10,
                    height: 10,
                },
                itemMargin: {
                    horizontal: 0,
                    vertical: 8
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        background: 'transparent',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '29px',
                                fontFamily: 'Nunito, sans-serif',
                                color: undefined,
                                offsetY: -10
                            },
                            value: {
                                show: true,
                                fontSize: '26px',
                                fontFamily: 'Nunito, sans-serif',
                                color: '#bfc9d4',
                                offsetY: 16,
                                formatter: function(val) {
                                    return val
                                }
                            },
                            total: {
                                show: true,
                                showAlways: true,
                                label: 'Total',
                                color: '#888ea8',
                                formatter: function(w) {
                                    return w.globals.seriesTotals.reduce(function(a, b) {
                                        return a + b
                                    }, 0)
                                }
                            }
                        }
                    }
                }
            },
            stroke: {
                show: true,
                width: 25,
                colors: '#0e1726'
            },

            series: [<?= $cValues ?>],
            labels: [<?= $cKeys ?>],
            responsive: [{
                breakpoint: 1599,
                options: {
                    chart: {
                        width: '350px',
                        height: '400px'
                    },
                    legend: {
                        position: 'bottom'
                    }
                },

                breakpoint: 1439,
                options: {
                    chart: {
                        width: '250px',
                        height: '390px'
                    },
                    legend: {
                        position: 'bottom'
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '65%',
                            }
                        }
                    }
                },
            }]
        }

        var chart2 = new ApexCharts(
            document.querySelector("#statssx"),
            sLineAreas2
        );

        chart2.render();

        $(document).ready(() => {
            $("#che").removeClass("widget-heading")
        })
    </script>