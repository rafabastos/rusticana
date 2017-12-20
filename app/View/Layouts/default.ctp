<!DOCTYPE html>
<html lang="en-us">
	<head>
<?php
		//<meta charset="utf-8">
		echo $this->Html->charset('utf-8');
		
		echo '<title>';
		echo 'Rusticana Jardim'; 
		echo '</title>';
		
		echo $this->Html->meta(array('name' => 'description', 'content' => ''));
		echo $this->Html->meta(array('name' => 'author', 'content' => 'Rafael Bastos'));
		echo $this->Html->meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no'));
		
		//CAKE LINKS
			echo $this->fetch('meta');
			echo $this->fetch('css');
			echo $this->fetch('script');
		//END CAKE LINKS
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('font-awesome.min');
		echo $this->Html->css('smartadmin-production.min.css');
		echo $this->Html->css('smartadmin-skins.min.css');
		echo $this->Html->css('rodeo');
		echo $this->fetch('pageRelatedStyle');
		echo $this->Html->css('font-awesome-animation.min');
		echo $this->Html->meta('favicon.ico','img/favicon/logo.png',array('type'=>'icon'));
	?>
	</head>

	<body class="smart-style-2 fixed-header menu-on-top fixed-ribbon fixed-navigation">

		<header id="header">
			<div id="logo-group">
				<span id="logo"><img width="600" src="../app/webroot/img/logo.png"></span>
			</div>
		</header>

		<aside id="left-panel">
			<nav>
				<ul>
					<li class="pagesdisplay">
						<?php echo $this->Html->link('<i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Inicio</span>', ['controller'=> 'pages','action'=>'home'],['escape'=>false]); ?>
					</li>
					<li>
						<a href="#"> <i class="fa fa-lg fa-fw fa-group"></i><span class="menu-item-parent">Clientes</span></a>
						<ul>
							<li class="clientesindex">
								<?php echo $this->Html->link('<i class="fa fa-fw fa-list"></i> Lista', ['controller'=> 'clientes','action'=>'index'],['escape'=>false]); ?>
							</li>	
							<li class="clientesnuevo">
								<?php echo $this->Html->link('<i class="fa fa-fw fa-plus"></i> Nuevo', ['controller'=> 'clientes','action'=>'nuevo'],['escape'=>false]); ?>
							</li>	
						</ul>
					</li>
					<li>
						<a href="#"> <i class="fa fa-lg fa-fw fa-truck"></i><span class="menu-item-parent">Proveedores</span></a>
						<ul>
							<li class="clienteslistarproveedores">
								<?php echo $this->Html->link('<i class="fa fa-fw fa-list"></i> Lista', ['controller'=> 'clientes','action'=>'listarProveedores'],['escape'=>false]); ?>
							</li>
							<li class="clientesnuevo">
								<?php echo $this->Html->link('<i class="fa fa-fw fa-plus"></i> Nuevo', ['controller'=> 'clientes','action'=>'nuevo'],['escape'=>false]); ?>
							</li>	
						</ul>
					</li>
				</ul>
			</nav>

			<span class="minifyme" data-action="minifyMenu"> 
				<i class="fa fa-arrow-circle-left hit"></i> 
			</span>

		</aside>
		<!-- END NAVIGATION -->

		<!-- MAIN PANEL -->
		<div id="main" role="main">

		</div>

		<!-- PAGE FOOTER -->
		<div class="page-footer">
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<span class="txt-color-white">Sistema de Calculos de Rusticana Jardim <!-- © Elaborado por Rafael Bastos --></span>
				</div>
			</div>
		</div>
		<!-- END PAGE FOOTER -->

<?php
		echo $this->Html->script('libs/jquery-2.0.2.min');
		echo $this->Html->script('libs/jquery-ui-1.10.3.min');

		echo $this->Html->script('app.config');
	

		// <!-- BOOTSTRAP JS -->
		// <script src="js/bootstrap/bootstrap.min.js"></script>
		echo $this->Html->script('bootstrap/bootstrap.min');

		// <!-- CUSTOM NOTIFICATION -->
		// <script src="js/notification/SmartNotification.min.js"></script>
		echo $this->Html->script('notification/SmartNotification.min');

		// <!-- JARVIS WIDGETS -->
		// <script src="js/smartwidgets/jarvis.widget.min.js"></script>
		echo $this->Html->script('smartwidgets/jarvis.widget.min');

		// <!-- EASY PIE CHARTS -->
		// <script src="js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>
		echo $this->Html->script('plugin/easy-pie-chart/jquery.easy-pie-chart.min');

		// <!-- SPARKLINES -->
		// <script src="js/plugin/sparkline/jquery.sparkline.min.js"></script>
		echo $this->Html->script('plugin/sparkline/jquery.sparkline.min');	

		// <!-- JQUERY VALIDATE -->
		// <script src="js/plugin/jquery-validate/jquery.validate.min.js"></script>
		echo $this->Html->script('plugin/jquery-validate/jquery.validate.min');

		// <!-- JQUERY MASKED INPUT -->
		// <script src="js/plugin/masked-input/jquery.maskedinput.min.js"></script>
		echo $this->Html->script('plugin/masked-input/jquery.maskedinput.min');

		// <!-- JQUERY SELECT2 INPUT -->
		// <script src="js/plugin/select2/select2.min.js"></script>
		echo $this->Html->script('plugin/select2/select2.min');
		//Se incluye el LOCALE.ES para las traducciones al español.
		echo $this->Html->script('plugin/select2/select2.locale.es');

		// <!-- JQUERY UI + Bootstrap Slider -->
		// <script src="js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>
		echo $this->Html->script('plugin/bootstrap-slider/bootstrap-slider.min');

		// <!-- browser msie issue fix -->
		// <script src="js/plugin/msie-fix/jquery.mb.browser.min.js"></script>
		echo $this->Html->script('plugin/msie-fix/jquery.mb.browser.min');

		// <!-- FastClick: For mobile devices -->
		// <script src="js/plugin/fastclick/fastclick.min.js"></script>
		echo $this->Html->script('plugin/fastclick/fastclick.min');
		//control de carga de modales con peticiones AJAX pendientes
		echo $this->Html->script('rodeo/ajaxModalControl');
		//Price Format
		echo $this->Html->script('rodeo/jquery.price_format.2.0.min');
echo <<<EOT
		<!--[if IE 8]>

		<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

		<![endif]-->
EOT;
		
		

		// <!-- MAIN APP JS FILE -->
		// <script src="js/app.min.js"></script>
		echo $this->Html->script('app.min');
		$controller = $this->params->controller;
		$action = $this->params->action;
		echo '<script>$(".'.$controller.$action.'").attr("class","active")</script>';

		//Utilizamos este fetch para cargar plugins de particulares de las
		//vistas con cake.
		echo $this->fetch('pageRelatedPlugins');

		// <!-- CakePHP JS helper Output -->
		echo $this->Js->writeBuffer();
?>

		<script type="text/javascript">

			$(document).ready(function() {
			 					
				 pageSetUp();
				 var myVar=setInterval(function(){ CheckConnectionlayout()},30000);

				function CheckConnectionlayout(){
					
						SeHizoUnaConsultaPrevia=true;
						$.ajax({
								url:<?php echo "'".$this->Html->url(array("controller"=>"remates","action"=>"CheckConnection"))."'";?>,
								success: function(){
										//$('#EtiquetaEstadoDeConexion').addClass('bg-color-blueLigh').removeClass('bg-color-redLigh');
										$("#EtiquetaEstadoDeConexion").html('<span   class="text-center badge bg-color-blueLight dropdown-toggle">Online</span>');			
								},
								timeout:20000,
								error:function( xhr, text, status ) {
					    				console.clear();
					    				
					    				$("#EtiquetaEstadoDeConexion").html('<span   class="text-center badge bg-color-redLight dropdown-toggle">Offline</span>');
					        					//alert(xhr.status);
					   						
					   					}
						})
				}

				jQuery.validator.addMethod(
			    "dinero",
			    function(value, element) {
			        var isValidMoney = /(^-*\d+$)|(^-*\d+\.*\.)/.test(value);
			        return this.optional(element) || isValidMoney;
			    },
			    "Introduzca un número valido"
				);
				 


				 <?php echo $this->fetch('pageScripts'); ?>

			})
		
		</script>
<?php
		// CakePHP JS helper Output
		// Aquí se cargan todos los Js generados en las vistas y modales
		echo $this->Js->writeBuffer(array('onDomReady' => true));
		echo $this->Html->script('rodeo/ajaxModalControl');
		echo $this->Html->script('rodeo/focus');
?>
		<div  class="cargandoBlanket" mostrar="false">
			<div class="mensajeCargando" > 
				<p  align="center"><i  class="fa fa-circle-o-notch fa-spin fa-5x"></i></p>
				<p  align="center">Cargando..</p>
			</div>
		</div>

	</body>

</html>