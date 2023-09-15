<?php ob_start();
session_start();
include("../config.php");
include("../config2.php");
if(!isset($_SESSION["id"])){
	header("Location: ".$site."index");
	exit;
}
if($_SESSION["rank"]!=1){
	header("Location: ".$site."index");
	exit;
}
 
 ?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Stresser.gg - Admin Panel</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../../favicon.png" />
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
		  <li class="nav-header">General</li>
          <li class="nav-item">
            <a href="index" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
       <li class="nav-item">
            <a href="settings" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Settings
              </p>
            </a>
          </li>
       <li class="nav-item">
            <a href="adminlist" class="nav-link">
              <i class="nav-icon fas fa-user-md"></i>
              <p>
                Admin List
              </p>
            </a>
          </li>
       <li class="nav-item">
            <a href="news" class="nav-link">
              <i class="nav-icon fas fa-newspaper"></i>
              <p>
                News
              </p>
            </a>
          </li>
       <li class="nav-item">
            <a href="payment-history" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Payment History
              </p>
            </a>
          </li>
		  <li class="nav-header">Members</li>
          <li class="nav-item">
            <a href="members" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
               Members
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="tickets" class="nav-link">
              <i class="nav-icon fas fa-life-ring"></i>
              <p>
               Tickets
              </p>
            </a>
          </li>
		  <li class="nav-header">Settings</li>
          <li class="nav-item">
            <a href="plans" class="nav-link">
              <i class="nav-icon fas fa-tasks"></i>
              <p>
               Plans
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="servers" class="nav-link">
              <i class="nav-icon fas fa-server"></i>
              <p>
               Servers
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="methods" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
               Methods
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="log" class="nav-link">
              <i class="nav-icon fas fa-bolt"></i>
              <p>
              Attack Logs
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="blacklist" class="nav-link">
              <i class="nav-icon fas fa-lock"></i>
              <p>
              Blacklist
              </p>
            </a>
          </li>
		  <hr>
      <li class="nav-item">
            <a href="../index" class="nav-link">
              <i class="nav-icon fas fa-undo"></i>
              <p>
                Back to Client Area
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../logout" class="nav-link">
              <i class="nav-icon fas fa-times"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
