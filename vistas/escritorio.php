<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';

if ($_SESSION['escritorio']==1)
{
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" id="sistema">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Escritorio</h1>                     
                    </div>
                    
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body" id="listadoregistros">
                          <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <table id="triaje" class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                  <th style="font-size: 30px">#</th>
                                  <th style="font-size: 30px">Paciente</th>                           
                                </thead>
                                <tbody>                            
                                </tbody>
                                
                              </table>
                          </div>
                          <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <table id="plan" class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                  <th style="font-size: 30px">#</th>
                                  <th style="font-size: 30px">Paciente</th>                           
                                </thead>
                                <tbody>                            
                                </tbody>
                                
                              </table>
                          </div>
                        </div>
                    </div>                    
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/escritorio.js"></script>
<script>setTimeout('document.location.reload()',10000); </script>
<?php 
}
ob_end_flush();
?>


