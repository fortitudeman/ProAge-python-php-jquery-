<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo base_url() ?>">Proages</a>
        </li>
    </ul>
</div>
<div class="sortable row-fluid">
    <a data-rel="tooltip" title="<?php echo $rolcount['agents'] ?>." class="well span3 top-block" href="#">
        <span class="icon32 icon-red icon-user"></span>
        <div>Agentes</div>
        <div><?php echo $rolcount['agents'] ?></div>
        <span class="notification"><?php echo $rolcount['agents'] ?></span>
    </a>

    <a data-rel="tooltip" title="<?php echo $rolcount['coordinador'] ?>." class="well span3 top-block" href="#">
        <span class="icon32 icon-red icon-user"></span>
        <div>Coordinador</div>
        <div><?php echo $rolcount['coordinador'] ?></div>
        <span class="notification green"><?php echo $rolcount['coordinador'] ?></span>
    </a>

    <a data-rel="tooltip" title="<?php echo $rolcount['gerente'] ?>." class="well span3 top-block" href="#">
        <span class="icon32 icon-red icon-user"></span>
        <div>Gerente</div>
        <div><?php echo $rolcount['gerente'] ?></div>
        <span class="notification yellow"><?php echo $rolcount['gerente'] ?></span>
    </a>
    
    <a data-rel="tooltip" title="<?php echo $rolcount['director'] ?>." class="well span3 top-block" href="#">
        <span class="icon32 icon-red icon-user"></span>
        <div>Director</div>
        <div><?php echo $rolcount['director'] ?></div>
        <span class="notification red"><?php echo $rolcount['director'] ?></span>
    </a>
</div>


<div class="sortable row-fluid">
    <a data-rel="tooltip" title="<?php echo $rolcount['administrador'] ?>." class="well span3 top-block" href="#">
        <span class="icon32 icon-red icon-user"></span>
        <div>Administrador</div>
        <div><?php echo $rolcount['administrador'] ?></div>
        <span class="notification"><?php echo $rolcount['administrador'] ?></span>
    </a>
</div>




<div class="row-fluid">
    <div class="box span12">
        <div class="box-header well">
            <h2>Introducción</h2>
        </div>
        <div class="box-content">
            <h1>Proages <small>free, premium quality, responsive, multiple skin admin template.</small></h1>
            
            
            <?php // Show Messages ?>
            
            <?php if( isset( $message['type'] ) ): ?>
               
               
                <?php if( $message['type'] == true ): ?>
                    <div class="alert alert-success">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                          <img src="<?php echo base_url() ?>images/true.png" width="20" height="20" />
                          <strong>Correcto: </strong> <?php  echo $message['message']; // Show Dinamical message Success ?>
                    </div>
                <?php endif; ?>
               
                
                <?php if( $message['type'] == false ): ?>
                    <div class="alert alert-error">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                          <img src="<?php echo base_url() ?>images/false.png" width="20" height="20" />
                          <strong>Error: </strong> <?php  echo $message['message']; // Show Dinamical message error ?>
                    </div>
                <?php endif; ?>
            
			
			
			<?php endif; ?>
            
            
            
            <p>Its a live demo of the template. I have created Charisma to ease the repeat work I have to do on my projects. Now I re-use Charisma as a base for my admin panel work and I am sharing it with you :)</p>
            <p><b>All pages in the menu are functional, take a look at all, please share this with your followers.</b></p>
            
            
            
            
            <p class="center">
                
            </p>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
			
