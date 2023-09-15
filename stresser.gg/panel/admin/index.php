
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
include("header.php");?>


    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="../plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
			  <div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				  <li class="breadcrumb-item"><a href="#">Admin</a></li>
				  <li class="breadcrumb-item active">Dashboard</li>
				</ol>
			  </div><!-- /.col -->
			</div><!-- /.row -->
		  </div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content">
		  <div class="container-fluid">
			<!-- Info boxes -->
			<div class="row">
			  <div class="col-12 col-sm-6 col-md-4">
				<div class="info-box">
				  <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Users</span>
                <span class="info-box-number">
                  <?php 
$data = @mysqli_query($baglanti,"select * from user");
echo mysqli_num_rows($data);
?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-bolt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Attacks</span>
                <span class="info-box-number">
                  <?php 
$data = @mysqli_query($baglanti,"select * from log");
echo mysqli_num_rows($data);
?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-life-ring"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Tickets</span>
                <span class="info-box-number">
                  <?php 
$data = @mysqli_query($baglanti,"select * from destektalep");
echo mysqli_num_rows($data);
?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Attack Logs</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                
                                        <div id="statss"></div>
              </div>
              <!-- /.card-body -->
            </div>
			</div>
    <div class="col-md-6">
	<div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Last Members</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Member Mail</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
								  $data=mysqli_query($baglanti,"select * from user ORDER BY id DESC LIMIT 5"); 
												while($satir=mysqli_fetch_array($data))
												{
											
														echo '
                              <tr>
                                <td><a href="member-edit?id='.$satir['id'].'">'.$satir['id'].'</a></td>
                                <td>'.$satir['mail'].'</td>
                              </tr>';
												}
							
							?>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="members" class="btn btn-sm btn-info float-left">Show all members</a>
              </div>
              <!-- /.card-footer -->
            </div>
	</div>
    <div class="col-md-6">
	
	<div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Last Attacks</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                                                <th><div class="th-content">Attack IP</div></th>
                                                <th><div class="th-content th-heading">Date</div></th>
                                                <th><div class="th-content th-heading">Attack Time</div></th>
                                                <th><div class="th-content">Method</div></th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
										  $data=mysqli_query($baglanti,"select * from log ORDER BY id DESC LIMIT 5"); 
												while($satir=mysqli_fetch_array($data))
												{
												?>
     <tr>
                                                <td><div class="td-content product-name"><?php echo $satir["ip"];?>:<?php echo $satir["port"];?></div></td>
                                                <td><div class="td-content"><span class="pricing"><?php echo $satir["tarih"];?></span></div></td>
                                                <td><div class="td-content"><span class="discount-pricing"><?php echo $satir["sure"];?> Seconds</span></div></td>
                                                <td><div class="td-content"><?php echo $satir["method"];?></div></td>
                                            </tr>
<?php												
												}
												
												?>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="log" class="btn btn-sm btn-info float-left">List Logs</a>
              </div>
              <!-- /.card-footer -->
            </div>
	</div>
	</div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
 <?php include("footer.php");?>
 
    <script src="../plugins/apex/apexcharts.min.js"></script>
    <script src="../assets/js/dashboard/dash_1.js"></script>
	       <script>
var sLineAreas = {
    chart: {
        height: 350,
        type: 'area',
        toolbar: {
          show: false,
        }
    },
    dataLabels: {
        enabled: true
    },
    stroke: {
        curve: 'smooth'
    },
    series: [{
        name: 'Attack History',
        data: [<?php $tarih2=date("Y-m-d", strtotime("-6 day")); echo mysqli_num_rows(mysqli_query($baglanti,"select * from log where tarih between '$tarih2 00:00:00' and '$tarih2 23:59:59'"));?>, <?php $tarih2=date("Y-m-d", strtotime("-5 day")); echo mysqli_num_rows(mysqli_query($baglanti,"select * from log where tarih between '$tarih2 00:00:00' and '$tarih2 23:59:59'"));?>, <?php $tarih2=date("Y-m-d", strtotime("-4 day")); echo mysqli_num_rows(mysqli_query($baglanti,"select * from log where tarih between '$tarih2 00:00:00' and '$tarih2 23:59:59'"));?>, <?php $tarih2=date("Y-m-d", strtotime("-3 day")); echo mysqli_num_rows(mysqli_query($baglanti,"select * from log where tarih between '$tarih2 00:00:00' and '$tarih2 23:59:59'"));?>, <?php $tarih2=date("Y-m-d", strtotime("-2 day")); echo mysqli_num_rows(mysqli_query($baglanti,"select * from log where tarih between '$tarih2 00:00:00' and '$tarih2 23:59:59'"));?>, <?php $tarih2=date("Y-m-d", strtotime("-1 day")); echo mysqli_num_rows(mysqli_query($baglanti,"select * from log where tarih between '$tarih2 00:00:00' and '$tarih2 23:59:59'"));?>, <?php $tarih2=date("Y-m-d", strtotime("-0 day")); echo mysqli_num_rows(mysqli_query($baglanti,"select * from log where tarih between '$tarih2 00:00:00' and '$tarih2 23:59:59'"));?>]
    }],

    xaxis: {
        categories: ["<?php echo date("Y-m-d", strtotime("-7 day"));?>", "<?php echo date("Y-m-d", strtotime("-5 day"));?>", "<?php echo date("Y-m-d", strtotime("-4 day"));?>", "<?php echo date("Y-m-d", strtotime("-3 day"));?>", "<?php echo date("Y-m-d", strtotime("-2 day"));?>", "<?php echo date("Y-m-d", strtotime("-1 day"));?>", "<?php echo date("Y-m-d", strtotime("-0 day"));?>"],                
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    }
}

var chart = new ApexCharts(
    document.querySelector("#statss"),
    sLineAreas
);

chart.render();
	   </script>
 <script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label               : 'Digital Goods',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [28, 48, 40, 19, 86, 27, 90]
        },
        {
          label               : 'Electronics',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [65, 59, 80, 81, 56, 55, 40]
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,
      options: lineChartOptions
    })

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Chrome',
          'IE',
          'FireFox',
          'Safari',
          'Opera',
          'Navigator',
      ],
      datasets: [
        {
          data: [700,500,400,600,300,100],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

    //---------------------
    //- STACKED BAR CHART -
    //---------------------
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = $.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    new Chart(stackedBarChartCanvas, {
      type: 'bar',
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })
  })
</script>