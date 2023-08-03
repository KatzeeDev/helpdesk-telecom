<?php
    # Llamamos a la cadena de conexion si existe una usu_id y hacemos una condicional. Esto se hace por temas de seguridad.
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usu_id"])){ 
?>
<!DOCTYPE html>
<html>
    <!--Head -->
    <?php require_once("../MainHead/head.php");?>
    <title>HelpDesk Consultar Ticket</title>
</head>
<body class="with-side-menu theme-side-litmus-blue chrome-browser">

    <!--. =============== Header =============== -->
    <?php require_once("../MainHeader/header.php");?>
	<div class="mobile-menu-left-overlay"></div>



    <!--. ===============  Nav  ===============  -->
    <?php require_once("../MainNav/nav.php");?>
  


    <!--  =============== Contenido Inicio ===============  -->

		<div class="page-content">
      <div class="container-fluid">
        <header class="section-header">
          <div class="tbl">
            <div class="tbl-row">
              <div class="tbl-cell">
                <h3>Consulltar Ticket</h3>
                <ol class="breadcrumb breadcrumb-simple">
                  <li><a href="#">Home</a></li>
                  <li class="active">Consultar Ticket</li>
                </ol>
              </div>
            </div>
          </div>
        </header>

        <div class="box-typical box-typical-padding">
          <table id="ticket_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
            <thead>
              <tr>
                <th style="width: 5%;">Nro.Ticket</th>
                <th style="width: 15%;">Categoria</th>
                <th style="width: 25%;">Titulo</th>
                <th style="width: 5%;">Prioridad</th>
                <th style="width: 5%;">Estado</th>
                <th style="width: 10%;">Fecha Creacion</th>
                <th style="width: 10%;">Fecha de Asignacion</th>
                <th style="width: 10%;">Fecha de Cierre</th>
                <th style="width: 10%;">Soporte</th>
                <th class="text-center" style="width: 15%;"></th>        
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>

      </div>
    </div>
	<!-- =============== Contenido Final ===============  -->


    

    
    <?php require_once("modalasignar.php");?>

    <!--. =============== Scripts  =============== -->
    <?php require_once("../MainJs/js.php");?>
    <script type="text/javascript" src="consultarticket.js"></script>

</body>
</html>
<?php
    # Sino mandara al index.
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>