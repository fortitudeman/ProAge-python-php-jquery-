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
        <div class="span2"><input type="text" id="metas-prima-promedio" value="0" /></div> 
        
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
                <td class="bgestacionalidadlight"><?php echo $configs[$field] ?> %<input type="hidden" id="mes-<?php echo $i ?>" name="mes-<?php echo $i ?>" value="<?php echo $configs[$field] ?>" /></td>
                <td class="bgyelowlight">
                	
                   <div id="primas-solicitud-meta-text-<?php echo $i ?>" style="text-align: center !important"></div>  
                   <input type="hidden" name="primas-solicitud-meta-<?php echo $i ?>" id="primas-solicitud-meta-<?php echo $i ?>" value="0" />
                
                </td>
                <td class="bgyelowlight"></td>
                <td class="bgorangelight">
                	
                   <div id="primas-negocios-meta-text-<?php echo $i ?>" style="text-align: center !important"></div>  
                   <input type="hidden" name="primas-negocios-meta-<?php echo $i ?>" id="primas-negocios-meta-<?php echo $i ?>" value="0" />
                    
                
                </td>
                <td class="bgorangelight"></td>
                <td class="bggreenlight">
                	
                    
                    <div id="primas-meta-text-<?php echo $i ?>" style="text-align: right !important"></div>  
                    <input type="hidden" name="primas-meta-<?php echo $i ?>" id="primas-meta-<?php echo $i ?>" value="0" />
                
                    
                </td>
                <td class="bggreenlight"></td>
                               
            </tr> 
           
           <?php if( $i==3 ): ?>
                
            <tr>
            	<td><b>TOTAL 1er <br />trimestre</b></td>
                <td class="bgestacionalidadbold"><?php echo $total; $totalgeneral+=$total; $total=0; ?> %</td>
                <td class="bgyelowbold">
                	
                    <div id="primas-solicitud-meta-primer-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-solicitud-meta-primer" id="primas-solicitud-meta-primer" value="0" />
                    
                </td>
                <td class="bgyelowbold"></td>
                <td class="bgorangebold">
                	
                    <div id="primas-negocio-meta-primer-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-negocio-meta-primer" id="primas-negocio-meta-primer" value="0" />
                    
                </td>
                <td class="bgorangebold"></td>
                <td class="bggreenbold">
                	
                    <div id="primas-meta-primer-text" style="text-align: right !important"></div>  
                    <input type="hidden" name="primas-meta-primer" id="primas-meta-primer" value="0" />
                
                </td>
                <td class="bggreenbold"></td>                               
            </tr> 
                
           <?php endif; ?>   
           
           <?php if( $i==6 ): ?>
                
            <tr>
            	<td><b>TOTAL 2do <br />trimestre</b></td>
                <td class="bgestacionalidadbold"><?php echo $total; $totalgeneral+=$total; $total=0; ?> %</td>
                <td class="bgyelowbold">
                	
                    <div id="primas-solicitud-meta-segund-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-solicitud-meta-segund" id="primas-solicitud-meta-segund" value="0" />
                    
                </td>
                <td class="bgyelowbold"></td>
                <td class="bgorangebold">
                	
                    <div id="primas-negocio-meta-segund-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-negocio-meta-segund" id="primas-negocio-meta-segund" value="0" />
                    
                </td>
                <td class="bgorangebold"></td>
                <td class="bggreenbold">
                	
                    <div id="primas-meta-segund-text" style="text-align: right !important"></div>  
                    <input type="hidden" name="primas-segund-primer" id="primas-segund-primer" value="0" />
                
                </td>
                <td class="bggreenbold"></td>                              
            </tr> 
                
           <?php endif; ?>    
           
           
           <?php if( $i==9 ): ?>
                
              <tr>
            	<td><b>TOTAL 3er <br />trimestre</b></td>
                <td class="bgestacionalidadbold"><?php echo $total; $totalgeneral+=$total; $total=0; ?> %</td>
                <td class="bgyelowbold">
                	
                    <div id="primas-solicitud-meta-tercer-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-solicitud-meta-tercer" id="primas-solicitud-meta-tercer" value="0" />
                    
                </td>
                <td class="bgyelowbold"></td>
                <td class="bgorangebold">
                	
                    <div id="primas-negocio-meta-tercer-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-negocio-meta-tercer" id="primas-negocio-meta-tercer" value="0" />
                    
                </td>
                <td class="bgorangebold"></td>
                <td class="bggreenbold">
                	
                    <div id="primas-meta-tercer-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-tercer-primer" id="primas-tercer-primer" value="0" />
                    
                </td>
                <td class="bggreenbold"></td>                               
            </tr> 
                
           <?php endif; ?> 
           
           
           <?php if( $i==12 ): ?>
                                
               <tr>
            	<td><b>TOTAL 4to <br />trimestre</b></td>
                <td class="bgestacionalidadbold"><?php echo $total; $totalgeneral+=$total; $total=0; ?> %</td>
                <td class="bgyelowbold">
                	
                    <div id="primas-solicitud-meta-cuarto-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-solicitud-meta-cuarto" id="primas-solicitud-meta-cuarto" value="0" />
                    
                </td>
                <td class="bgyelowbold"></td>
                <td class="bgorangebold">
                	
                    <div id="primas-negocio-meta-cuarto-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-negocio-meta-cuarto" id="primas-negocio-meta-cuarto" value="0" />
                    
                </td>
                <td class="bgorangebold"></td>
                <td class="bggreenbold">
                	
                    <div id="primas-meta-cuarto-text" style="text-align: right !important"></div>  
                    <input type="hidden" name="primas-cuarto-primer" id="primas-cuarto-primer" value="0" />
                    
                </td>
                <td class="bggreenbold"></td>                               
            </tr>         
                
           <?php endif; ?>    
             
           <?php $i++; endforeach; endif; ?> 
              
          </tbody>
          
          
           <tr>
            	<td>&nbsp;</td>
                <td class="" style="font-size:18px;">&nbsp;</td>
                <td class=""></td>
                <td class=""></td>
                <td class=""></td>
                <td class=""></td>
                <td class=""></td>
                <td class=""></td>                               
            </tr>   
        
          <tr>
            	<td><b>TOTAL</b></td>
                <td class="bgestacionalidadbold" style="font-size:18px;"><?php echo $totalgeneral; ?> %</td>
                <td class="bgyelowbold">
                	
                    <div id="primas-solicitud-meta-total-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-solicitud-meta-total" id="primas-solicitud-meta-total" value="0" />
                    
                </td>
                <td class="bgyelowbold"></td>
                <td class="bgorangebold">
                	
                    <div id="primas-negocios-meta-total-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-negocios-meta-total" id="primas-negocios-meta-total" value="0" />
                    
                </td>
                <td class="bgorangebold"></td>
                <td class="bggreenbold">
                	
                    <div id="primas-meta-total-text" style="text-align: right !important"></div>  
                    <input type="hidden" name="primas-meta-total" id="primas-meta-total" value="0" />
                    
                </td>
                <td class="bggreenbold"></td>                               
            </tr> 
        
        
    </table>
</div>
</div>