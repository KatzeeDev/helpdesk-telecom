<?php
    # Llamamos a la cadena de conexion si existe una usu_id y hacemos una condicional. Esto se hace por temas de seguridad.
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usu_id"])){ 
?>
<!DOCTYPE html>
<html>
    <!--Head -->
    <?php require_once("../MainHead/head.php");?>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <title>HelpDesk Home</title>
</head>
<body class="with-side-menu theme-side-litmus-blue chrome-browser">

    <!--. =============== Header =============== -->
    <?php require_once("../MainHeader/header.php");?>
	<div class="mobile-menu-left-overlay"></div>



    <!--. ===============  Nav  ===============  -->
    <?php require_once("../MainNav/nav.php");?>
  


	<!-- Contenido -->
	  <div class="page-content">
		    <div class="container-fluid">
			      <div class="row">
				        <div class="col-xl-12">
					          <div class="row">
						            <div class="col-sm-4">
	                          <article class="statistic-box green">
	                            <div>
	                                <div class="number" id="lbltotal"></div>
	                                <div class="caption"><div>Total de Tickets</div></div>
	                            </div>
	                          </article>
	                      </div>
						            <div class="col-sm-4">
	                          <article class="statistic-box yellow">
	                             <div>
	                                  <div class="number" id="lbltotalabierto"></div>
	                                  <div class="caption"><div>Total de Tickets Abiertos</div></div>
	                             </div>
	                          </article>
	                      </div>
						            <div class="col-sm-4">
	                          <article class="statistic-box red">
	                              <div>
	                                  <div class="number" id="lbltotalcerrado"></div>
	                                  <div class="caption"><div>Total de Tickets Cerrados</div></div>
	                              </div>
	                        </article>
	                    </div>
					        </div>
				      </div>
			    </div>

			    <section class="card">
				      <header class="card-header">
					        Grafico Estadístico
				      </header>
				      <div class="card-block">
					        <div id="divgrafico" style="height: 250px;"></div>
				      </div>
			    </section>
			
		  </div>
	  </div>
	<!-- Contenido -->

    <!--. =============== Scripts  =============== -->
    <?php require_once("../MainJs/js.php");?>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <script type="text/javascript" src="home.js"></script>

</body>
</html>
<?php
    # Sino mandara al index.
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>