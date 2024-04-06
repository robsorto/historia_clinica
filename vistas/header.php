<?php
if (strlen(session_id()) < 1)
  session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dra | Ingrid Hernandez</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="../public/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/css/font-awesome.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../public/css/_all-skins.min.css">
  <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
  <!--<link rel="shortcut icon" href="../public/img/favicon.ico">-->
  <link rel="stylesheet" href="../public/css/other_styles.css">

  <!-- DATATABLES -->
  <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">
  <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet" />
  <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">

</head>

<body class="hold-transition skin-purple sidebar-mini">
  <div class="wrapper">

    <header class="main-header">

      <!-- Logo -->
      <a href="../vistas/escritorio.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="../public/images/logos/logo.jpg" width="80%" /></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="../public/images/logos/logo.jpg" width="80%" /></span>
      </a>

      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Navegación</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                <span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">

                  <p>
                    Dra. Ingrid Elizabeth Hernández de Castro
                    <small>Ginecología - Obstetricia - Laparoscopia</small>
                  </p>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer">

                  <div class="pull-right">
                    <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Cerrar</a>
                  </div>
                </li>
              </ul>
            </li>

          </ul>
        </div>

      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <?php
          if ($_SESSION['escritorio'] == 1) {
            echo '<li>
              <a href="escritorio.php">
                <i class="fa fa-tasks"></i> <span>Escritorio</span>
              </a>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['pacientes'] == 1) {
            echo '<li>
              <a href="paciente.php">
                <i class="fa fa-laptop"></i>
                <span>Pacientes</span>
              </a>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['clinica'] == 1) {
            echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-th"></i>
                <span>Clínica</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="configuracion.php"><i class="fa fa-circle-o"></i> Configuraciones</a></li>
                <li><a href="servicio.php"><i class="fa fa-circle-o"></i> Servicios</a></li>
                <li><a href="personal.php"><i class="fa fa-circle-o"></i> Personal</a></li>
                <li><a href="permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
                <li><a href="diagnostico.php"><i class="fa fa-circle-o"></i> Diagnóstico</a></li>
              </ul>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['atencion'] == 1) {
            echo '<li>
              <a href="atencion.php">
                <i class="fa fa-shopping-cart"></i>
                <span>Atención</span>
              </a>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['triaje'] == 1) {
            echo '<li>
              <a href="triaje.php">
                <i class="fa fa-folder"></i> <span>En espera</span>
              </a>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['resultado'] == 1) {
            echo '<li>
              <a href="plan.php">
                <i class="fa fa-heartbeat"></i> <span>Plan de Atención</span>
              </a>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['consultas'] == 1) {
            echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-bar-chart"></i> <span>Consultas</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="pagos.php"><i class="fa fa-circle-o"></i> Pagos</a></li>
                <li><a href="historias.php"><i class="fa fa-circle-o"></i> Historias</a></li>
                <li><a href="prenatal.php"><i class="fa fa-circle-o"></i> Control Prenatal</a></li>
                <li><a href="ginecologia.php"><i class="fa fa-circle-o"></i> Ginecologia</a></li>
              </ul>
            </li>';
          }
          ?>

          <li>
            <a id="descargar-documento" style="cursor: pointer;">
              <i class="fa fa-plus-square"></i> <span>Ayuda</span>
              <small class="label pull-right bg-red">PDF</small>
            </a>
          </li>
          <li style="display:none">
            <a href="#">
              <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
              <small class="label pull-right bg-yellow">IT</small>
            </a>
          </li>

        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>