<?php include("header.php");
if (@$_GET["sil"] != Null) {
  $sil = htmlentities($_GET["sil"], ENT_QUOTES, "UTF-8");
  mysqli_query($baglanti, "DELETE FROM user WHERE id='" . $sil . "'");
  header("Location: members");
  exit;
} ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Members</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Members</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-12">

          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <?php if (@$_GET["islem"] == "basarili") {
                echo '<div class="alert alert-success">Member successfully added.</div>';
              }
              ?>
              <form method="get">
                <input type="submit" class="btn btn-info btn-md" style="float:right;" value="Search">
                <?php
                if (isset($_GET["filter"])) {
                  switch ($_GET["filter"]) {
                    case "ezbircir":
                      echo '<input class="btn btn-info btn-md" onclick="window.location=\'members\'" value="All Users">';
                      break;
                    default:
                      echo '<input class="btn btn-warning btn-md" onclick="window.location=\'members?filter=ezbircir\'" value="Paid Users">';
                      break;
                  }
                } else {
                  echo '<input class="btn btn-warning btn-md" onclick="window.location=\'members?filter=ezbircir\'" value="Paid Users">';
                }
                ?>
                <input type="text" class="form-control col-md-3 col-9" name="search" placeholder="ID or Mail" style="float:right;" required>
              </form><br><br>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Mail</th>
                    <th>Username</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $say = mysqli_query($baglanti, "select * from user ORDER BY id DESC");
                  if (@$_GET["search"] != Null) {
                    $search = htmlentities($_GET["search"], ENT_QUOTES, "UTF-8");
                    $say = mysqli_query($baglanti, "select * from user where mail LIKE '%$search%' or kadi LIKE '%$search%' ORDER BY id DESC");
                  }
                  $satir_sayisi = mysqli_num_rows($say);
                  if (isset($_GET['sayfa']) && is_numeric($_GET['sayfa'])) {
                    $sayfa = $_GET['sayfa'];
                    if ($sayfa < 0) {
                      $sayfa = 1;
                    }
                  } else {
                    $sayfa = 1;
                  }
                  $limit  = 10;
                  $ss     = ceil($satir_sayisi / $limit);
                  $sayfa  = ($sayfa > $ss ? 1 : $sayfa);
                  $goster = ($sayfa * $limit) - $limit;
                  if (isset($_GET["filter"])) {
                    if ($_GET["filter"] == "ezbircir") {
                      //$data=mysqli_query($baglanti,"select * from user WHERE uyelik != 0 and uyelik != 12 ORDER BY id DESC LIMIT $goster, $limit");
                      $data = mysqli_query($baglanti, "SELECT u.id, u.uyelik, u.mail, u.kadi, p.ad FROM user as u LEFT JOIN paketler as p ON u.uyelik = p.id WHERE u.uyelik != 0 AND u.uyelik != 12 ORDER BY u.id DESC");
                    } else {
                      //$data=mysqli_query($baglanti,"select * from user ORDER BY id DESC LIMIT $goster, $limit");
                      $data = mysqli_query($baglanti, "SELECT u.id, u.mail, u.kadi, p.ad FROM user as u LEFT JOIN paketler as p ON u.uyelik = p.id ORDER BY u.id DESC LIMIT $goster, $limit");
                    }
                  } else {
                    //$data=mysqli_query($baglanti,"select * from user ORDER BY id DESC LIMIT $goster, $limit");
                    $data = mysqli_query($baglanti, "SELECT u.id, u.mail, u.kadi, p.ad FROM user as u LEFT JOIN paketler as p ON u.uyelik = p.id ORDER BY u.id DESC LIMIT $goster, $limit");
                  }
                  if (@$_GET["search"] != Null) {
                    $search = htmlentities($_GET["search"], ENT_QUOTES, "UTF-8");
                    $data = mysqli_query($baglanti, "select * from user where mail LIKE '%$search%' or kadi LIKE '%$search%' ORDER BY id DESC");
                  }
                  while ($satir = mysqli_fetch_array($data)) {
                    echo '
                              <tr>
                                <td>' . $satir['id'] . '</td>
                                <td>' . $satir['mail'] . '</td>
                                <td>' . (isset($satir['ad']) && $satir['ad'] != null ? '<strong>' : '') . '' . $satir['kadi'] . '' . (isset($satir['ad']) && $satir['ad'] != null ? ' (' . $satir['ad'] . ')</strong>' : '') . '</td>
                                <td><a href="member-edit?id=' . $satir['id'] . '" class="btn btn-info">View</a> <a href="?sil=' . $satir['id'] . '" class="btn btn-danger">Delete</a></td>
                              </tr>';
                  }

                  ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              <ul class="pagination pagination-sm m-0 float-right">
                <?php
                for ($i = $sayfa - 1; $i < $sayfa + 2; $i++) {
                  if ($i > 0 && $i <= $ss) {
                    echo '<li class="page-item"><a class="page-link" href="?sayfa=' . $i . '">' . $i . '</a></li>';
                  }
                }
                ?>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>
    <!--/. container-fluid -->
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
<?php include("footer.php"); ?>