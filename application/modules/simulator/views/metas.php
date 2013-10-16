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
	
  $field = 'vida';	

?>


<div style="overflow:scroll">
<div class="box" style="width:1200px;">

 <div class="box-content">
	
     <div class="row">     	
        <div class="span1 offset1"><h6>Efectividad</h6></div>
        <div class="span2"><input type="text" style="width:30px;" value="75%" /></div>
        <div class="span2"><h6>Primas promedio</h6></div>
        <div class="span2"><input type="text"  /></div> 
        
        <div class="span2"></div>
        <div class="span2"><input type="button" value="Guardar Meta" class="pull-right btn-save-meta"  /></div>        
     </div>
    
     <table class="table table-bordered" style="width:1200px; padding:0px;">
		
        <thead>
        	
            <tr>
            	<th class="bgblank">Mes</th>
                <th class="bglight">Estacionalidad</th>
                <th class="bglight">Solicitudes Meta</th>
                <th class="bglight">Solicitudes Logradas</th>
                <th class="bglight">Negocios Meta</th>
                <th class="bglight">Negocios Logrados</th>
                <th class="bglight">Primas Meta</th>
                <th class="bglight">Primas Logradas</th>
            </tr>
         
         </thead>
            
          <tbody>
             
             <?php 
			 	
				$i=1; $total=0;
				
				$totalgeneral=0;
			 
			 ?> 
              
             <?php  if( !empty( $config ) ): foreach( $config as $configs ): $total += (int)$configs[$field]; ?> 
              
             
              <tr>
            	<td><?php echo $configs['month'] ?></td>
                <td class="bgestacionalidadlight"><?php echo $configs[$field] ?> %</td>
                <td class="bgyelowlight"></td>
                <td class="bgyelowlight"></td>
                <td class="bgorangelight"></td>
                <td class="bgorangelight"></td>
                <td class="bggreenlight"></td>
                <td class="bggreenlight"></td>
                               
            </tr> 
           
           <?php if( $i==3 ): ?>
                
            <tr>
            	<td><b>TOTAL 1er <br />trimestre</b></td>
                <td class="bgestacionalidadbold"><?php echo $total; $totalgeneral+=$total; $total=0; ?> %</td>
                <td class="bgyelowbold"></td>
                <td class="bgyelowbold"></td>
                <td class="bgorangebold"></td>
                <td class="bgorangebold"></td>
                <td class="bggreenbold"></td>
                <td class="bggreenbold"></td>                               
            </tr> 
                
           <?php endif; ?>   
           
           <?php if( $i==6 ): ?>
                
            <tr>
            	<td><b>TOTAL 2do <br />trimestre</b></td>
                <td class="bgestacionalidadbold"><?php echo $total; $totalgeneral+=$total; $total=0; ?> %</td>
                <td class="bgyelowbold"></td>
                <td class="bgyelowbold"></td>
                <td class="bgorangebold"></td>
                <td class="bgorangebold"></td>
                <td class="bggreenbold"></td>
                <td class="bggreenbold"></td>                              
            </tr> 
                
           <?php endif; ?>    
           
           
           <?php if( $i==9 ): ?>
                
              <tr>
            	<td><b>TOTAL 3er <br />trimestre</b></td>
                <td class="bgestacionalidadbold"><?php echo $total; $totalgeneral+=$total; $total=0; ?> %</td>
                <td class="bgyelowbold"></td>
                <td class="bgyelowbold"></td>
                <td class="bgorangebold"></td>
                <td class="bgorangebold"></td>
                <td class="bggreenbold"></td>
                <td class="bggreenbold"></td>                               
            </tr> 
                
           <?php endif; ?> 
           
           
           <?php if( $i==12 ): ?>
                                
               <tr>
            	<td><b>TOTAL 4to <br />trimestre</b></td>
                <td class="bgestacionalidadbold"><?php echo $total; $totalgeneral+=$total; $total=0; ?> %</td>
                <td class="bgyelowbold"></td>
                <td class="bgyelowbold"></td>
                <td class="bgorangebold"></td>
                <td class="bgorangebold"></td>
                <td class="bggreenbold"></td>
                <td class="bggreenbold"></td>                               
            </tr>         
                
           <?php endif; ?>    
             
           <?php $i++; endforeach; endif; ?> 
              
          </tbody>
            
        
          <tr>
            	<td><b>TOTAL</b></td>
                <td class="bgestacionalidadbold" style="font-size:18px;"><?php echo $totalgeneral; ?> %</td>
                <td class="bgyelowbold"></td>
                <td class="bgyelowbold"></td>
                <td class="bgorangebold"></td>
                <td class="bgorangebold"></td>
                <td class="bggreenbold"></td>
                <td class="bggreenbold"></td>                               
            </tr> 
        
        
    </table>
</div>
</div>