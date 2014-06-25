<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
/*

  Author		Ulises Rodríguez
  Site:			http://www.ulisesrodriguez.com	
  Twitter:		https://twitter.com/#!/isc_ulises
  Facebook:		http://www.facebook.com/ISC.Ulises
  Github:		https://github.com/ulisesrodriguez
  Email:		ing.ulisesrodriguez@gmail.com
  Skype:		systemonlinesoftware
  Location:		Guadalajara Jalisco Mexíco

  	
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="utf-8">
	<title>Pro-ages <?php if( isset( $title ) ) echo $title ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="Ulises Rodriguez">

	<!-- The styles -->
	<link id="bs-css" href="<?php echo base_url() ?>style/bootstrap-cerulean.css" rel="stylesheet">
	<style type="text/css">
	  body {
		padding-bottom: 40px;
	  }
	  .sidebar-nav {
		padding: 9px 0;
	  }
	</style>
    <link href="<?php echo base_url() ?>bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>bootstrap/FortAwesome/css/font-awesome.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>style/charisma-app.css" rel="stylesheet">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <link href="<?php echo base_url() ?>bootstrap/Ui/css/custom-theme/jquery-ui-1.10.0.custom.css" rel="stylesheet">
	<link href='<?php echo base_url() ?>style/fullcalendar.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>style/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='<?php echo base_url() ?>style/chosen.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>style/uniform.default.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>style/colorbox.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>style/jquery.cleditor.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>style/jquery.noty.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>style/noty_theme_default.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>style/elfinder.min.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>style/elfinder.theme.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>style/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>style/opa-icons.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>style/uploadify.css' rel='stylesheet'>
	<link href="<?php echo base_url() ?>style/style.css" rel="stylesheet">
	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- The fav icon -->
	<!--<link rel="shortcut icon" href="img/favicon.ico">-->
	
    <?php if( isset( $css ) and !empty( $css ) ) foreach( $css as $value ) echo $value; ?>
    
    	
</head>

<body>
	<?php if(!isset($no_visible_elements) || !$no_visible_elements)	{ ?>
	<!-- topbar starts -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="<?php echo base_url(); ?>"> <img alt="Charisma Logo" src="<?php echo base_url() ?>images/logo20.png" /> <span>Proages</span></a>
				
				<!-- theme selector starts -->
				<div class="btn-group pull-right theme-container" >
					<!--<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-tint"></i><span class="hidden-phone"> Change Theme / Skin</span>
						<span class="caret"></span>
					</a>-->
					<ul class="dropdown-menu" id="themes">
						<!--<li><a data-value="classic" href="#"><i class="icon-blank"></i> Classic</a></li>
						<li><a data-value="cerulean" href="#"><i class="icon-blank"></i> Cerulean</a></li>
						<li><a data-value="cyborg" href="#"><i class="icon-blank"></i> Cyborg</a></li>
						<li><a data-value="redy" href="#"><i class="icon-blank"></i> Redy</a></li>
						<li><a data-value="journal" href="#"><i class="icon-blank"></i> Journal</a></li>
						<li><a data-value="simplex" href="#"><i class="icon-blank"></i> Simplex</a></li>
						<li><a data-value="slate" href="#"><i class="icon-blank"></i> Slate</a></li>
						<li><a data-value="spacelab" href="#"><i class="icon-blank"></i> Spacelab</a></li>
						<li><a data-value="united" href="#"><i class="icon-blank"></i> United</a></li>-->
					</ul>
				</div>
				<!-- theme selector ends -->
				
				<!-- user dropdown starts -->
				<div class="btn-group pull-right" >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="javascript: void(0);">
						<img src="<?php echo base_url() . 'usuarios/assets/profiles/' . $user['picture'] ?>" width="50" height="50">
                        <span class="hidden-phone"> <?php echo $user['name'] ?></span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url() ?>usuarios/editar_perfil/<?php echo $user['id']; ?>.html">Editar perfil</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo base_url() ?>usuarios/logout.html">Logout</a></li>
					</ul>
				</div>
                
				<!-- user dropdown ends -->
				
				<div class="top-nav nav-collapse">
					<!--<ul class="nav">
						<li><a href="#">Visit Site</a></li>
						<li>
							<form class="navbar-search pull-left">
								<input placeholder="Search" class="search-query span2" name="query" type="text">
							</form>
						</li>
					</ul>-->
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
	<!-- topbar ends -->
	<?php } ?>
	<div class="container-fluid">
		<div class="row-fluid">
		<?php if(!isset($no_visible_elements) || !$no_visible_elements) { ?>
		
			<!-- left menu starts -->
			<div class="span2 main-menu-span">
				<div class="well nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li class="nav-header hidden-tablet">Navegación</li>
                       
						<li><a class="ajax-link" href="<?php echo base_url() ?>"><i class="icon-home"></i><span class="hidden-tablet"> Proages</span></a></li>						
                        
                        <?php 
							/**
							 *	Check $roles_vs_access for setting or added navigation for an user
							 **/
						?>
												
						<?php if( !empty( $roles_vs_access ) ): foreach( $roles_vs_access  as $value ): if( in_array( 'Modulos', $value ) ): ?>
                        <li><a href="<?php echo base_url() ?>modulos.html"><i class="icon-th"></i><span class="hidden-tablet">Módulos</span></a></li>
                        <?php break; endif; endforeach; endif; ?>
                        
                        <?php if( !empty( $roles_vs_access ) ): foreach( $roles_vs_access  as $value ): if( in_array( 'Rol', $value ) ): ?>
                        <li><a href="<?php echo base_url() ?>roles.html"><i class="icon-th"></i><span class="hidden-tablet">Rol</span></a></li>
                        <?php break; endif; endforeach; endif; ?>
                        
                        <?php if( !empty( $roles_vs_access ) ): foreach( $roles_vs_access  as $value ): if( in_array( 'Usuarios', $value ) ): ?>
                        <li><a href="<?php echo base_url() ?>usuarios.html"><i class="icon-th"></i><span class="hidden-tablet">Usuarios</span></a></li>
                        <?php break; endif; endforeach; endif; ?>
                       
                        <?php if( !empty( $roles_vs_access ) ): foreach( $roles_vs_access  as $value ): if( in_array( 'Orden de trabajo', $value ) ): ?>
                        <li><a href="<?php echo base_url() ?>ot.html"><i class="icon-tablet"></i><span class="hidden-tablet">Orden trabajo</span></a></li>
                        <?php break; endif; endforeach; endif; ?>
                                               
                        <?php if( !empty( $roles_vs_access ) ): foreach( $roles_vs_access  as $value ): if( in_array( 'Orden de trabajo', $value ) ): ?>
                        <?php if( $value['action_name'] == 'Importar payments' ): ?>
                        <li><a href="<?php echo base_url() ?>ot/import_payments.html"><i class="icon-hdd"></i><span class="hidden-tablet">Importar Pagos</span></a></li>
                        <?php endif; ?>
                        <?php endif; endforeach; endif; ?>
                        
                        <?php if( !empty( $roles_vs_access ) ): foreach( $roles_vs_access  as $value ): if( in_array( 'Orden de trabajo', $value ) ): ?>
                        <?php if( $value['action_name'] == 'Ver reporte' ): ?>
                        <li><a href="<?php echo base_url() ?>ot/reporte.html"><i class="icon-tasks"></i><span class="hidden-tablet">Reporte resultados</span></a></li>
                        <?php endif; ?>
                        <?php endif; endforeach; endif; ?>
                        
                        <?php if( !empty( $roles_vs_access ) ): foreach( $roles_vs_access  as $value ): if( in_array( 'Actividades', $value ) ): ?>
                        <?php if( $value['action_name'] == 'Ver' ): ?>
                        <li><a href="<?php echo base_url() ?>activities.html"><i class="icon-tablet"></i><span class="hidden-tablet">Mis actividades</span></a></li>
                        <?php endif; ?>
                        <?php endif; endforeach; endif; ?>
                       
                        <?php if( !empty( $roles_vs_access ) ): foreach( $roles_vs_access  as $value ): if( in_array( 'Actividades', $value ) ): ?>
                        <?php if( $value['action_name'] == 'Ver reporte' ): ?>
                        <li><a href="<?php echo base_url() ?>activities/report.html"><i class="icon-tasks"></i><span class="hidden-tablet">Reporte actividades</span></a></li>
                        <li><a href="<?php echo base_url() ?>activities/sales_activities_stats.html"><i class="icon-tasks"></i><span class="hidden-tablet">Actividades de ventas</span></a></li>
                        <?php endif; ?>
                        <?php endif; endforeach; endif; ?>
                        
						<!--
                        <li><a class="ajax-link" href="form.html"><i class="icon-edit"></i><span class="hidden-tablet"> Forms</span></a></li>
						<li><a class="ajax-link" href="chart.html"><i class="icon-list-alt"></i><span class="hidden-tablet"> Charts</span></a></li>
						<li><a class="ajax-link" href="typography.html"><i class="icon-font"></i><span class="hidden-tablet"> Typography</span></a></li>
						<li><a class="ajax-link" href="gallery.html"><i class="icon-picture"></i><span class="hidden-tablet"> Gallery</span></a></li>
						<li class="nav-header hidden-tablet">Sample Section</li>
						<li><a class="ajax-link" href="table.html"><i class="icon-align-justify"></i><span class="hidden-tablet"> Tables</span></a></li>
						<li><a class="ajax-link" href="calendar.html"><i class="icon-calendar"></i><span class="hidden-tablet"> Calendar</span></a></li>
						<li><a class="ajax-link" href="grid.html"><i class="icon-th"></i><span class="hidden-tablet"> Grid</span></a></li>
						<li><a class="ajax-link" href="file-manager.html"><i class="icon-folder-open"></i><span class="hidden-tablet"> File Manager</span></a></li>
						<li><a href="tour.html"><i class="icon-globe"></i><span class="hidden-tablet"> Tour</span></a></li>
						<li><a class="ajax-link" href="icon.html"><i class="icon-star"></i><span class="hidden-tablet"> Icons</span></a></li>
						<li><a href="error.html"><i class="icon-ban-circle"></i><span class="hidden-tablet"> Error Page</span></a></li>
						<li><a href="login.html"><i class="icon-lock"></i><span class="hidden-tablet"> Login Page</span></a></li>-->
					</ul>
					<!--<label id="for-is-ajax" class="hidden-tablet" for="is-ajax"><input id="is-ajax" type="checkbox"> Ajax on menu</label>-->
				</div><!--/.well -->
			</div><!--/span-->
			<!-- left menu ends -->
			
						
			<div id="content" class="span10">
			<!-- content starts -->
			<?php } ?>
