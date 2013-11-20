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
<div class="box">

 <div class="box-content">
	
    <!--style="margin-top:400px; position:fixed; z-index:1000; background:#F9F9F9; color:#fff; width:38%;"-->
    <table class="table-totals" style="background:#F9F9F9; color:#fff; width:73%;position:fixed !important;
	bottom:0px;">
    
     <tr>
           <td class="totales" style="width:750px;"><b style="color:#547EBD !important">INGRESO TOTAL:</b></td>

           <td style="text-align:right">
              <p style="color:#547EBD !important; float:right" id="ingresoTotal_text">$ <?php if( isset( $data->ingresoTotal ) ) echo $data->ingresoTotal; else echo 0; ?></p>	
              <input type="hidden" name="ingresoBonoRenovacion" id="ingresoTotal" value="<?php if( isset( $data->ingresoTotal ) ) echo $data->ingresoTotal; else echo 0; ?>">
           </td>
           
           <td rowspan="2" style="vertical-align:middle"><input type="button" value="Guardar Meta" class="pull-right btn-save-meta" style="margin-top:10px;" onclick="save();"/></td>

        </tr>

        <tr>

            <td class="totales"><b style="color:#547EBD !important">INGRESO PROMEDIO MENSUAL:</b></td>

           <td style="text-align:right">
			  <p style="color:#547EBD !important; float:right" id="inresoPromedioMensual_text">$ <?php if( isset( $data->ingresoBonoRenovacion ) ) echo $data->ingresoBonoRenovacion; else echo 0; ?></p>	
              <input type="hidden" name="ingresoBonoRenovacion" id="inresoPromedioMensual" value="<?php if( isset( $data->ingresoBonoRenovacion ) ) echo $data->ingresoBonoRenovacion; else echo 0; ?>">

           </td>

        </tr>
        
    </table>    
    
    
    <table>

        <tr>

           <td><label for="periodo">Periodo:</label></td>

           <td>

              <select name="periodo" id="periodo" onchange="ingresoPromedio(); ">

                 <option class="item-trimestre" value="3" <?php if( isset( $data->periodo ) and $data->periodo == 3 ) echo 'selected="selected"'; ?>>TRIMESTRAL</option>
                 
                 <option class="item-cuatrimestre" value="4" <?php if( isset( $data->periodo ) and $data->periodo == 4 ) echo 'selected="selected"'; ?>>CUATRIMESTRAL</option>

                 <option value="12" <?php if( isset( $data->periodo ) and $data->periodo == 12 ) echo 'selected="selected"'; ?>>ANUAL</option>

              </select>

           </td>
		   
           <td><label for="primasAfectasInicialesUbicar">Primas afectas iniciales(venta inicial):</label></td>

           <td>

              <input type="text" name="primasAfectasInicialesUbicar" id="primasAfectasInicialesUbicar" value="<?php if( isset( $data->primasAfectasInicialesUbicar ) ) echo $data->primasAfectasInicialesUbicar; else echo 0; ?>">

           </td>
           
        </tr>

        <tr>

           <td><br></td>

           <td><br></td>
           
           <td><br></td>

           <td><br></td>

        </tr>
       
        <tr>

           <td><label for="primas_promedio">Prima promedio:</label></td>

           <td>

              <input type="text" name="primas_promedio" id="primas_promedio" value="<?php if( isset( $data->primas_promedio ) ) echo $data->primas_promedio; else echo 0; ?>">

           </td>
           
           <td><label for="porAcotamiento">% de acotamiento:</label></td>

           <td>

              <input type="text" name="porAcotamiento" id="porAcotamiento" value="<?php if( isset( $data->porAcotamiento ) ) echo $data->porAcotamiento; else echo 0; ?>">

           </td>


        </tr>

        <tr>

           <td><label for="primasAfectasInicialesPagar" style="color:#547EBD !important">Primas afectas iniciales para bonos</label></td>

           <td>
			  
              <p style="color:#547EBD !important; float:right" id="primasAfectasInicialesPagar_text">$ <?php if( isset( $data->primasAfectasInicialesPagar ) ) echo $data->primasAfectasInicialesPagar; else echo 0; ?></p>	
              <input type="hidden" name="primasAfectasInicialesPagar" id="primasAfectasInicialesPagar" value="<?php if( isset( $data->primasAfectasInicialesPagar ) ) echo $data->primasAfectasInicialesPagar; else echo 0; ?>">
              

           </td>
		                         
        </tr>

      
        <tr>

           <td><br></td>

           <td><br></td>
           
           <td><br></td>

           <td><br></td>

        </tr>

        <tr>
		   
            <td><label for="noNegocios">No. de Negocios PAI:</label></td>

           <td>

              <input type="text" name="noNegocios" id="noNegocios" value="<?php if( isset( $data->noNegocios ) ) echo $data->noNegocios; else echo 0; ?>">

           </td>
           
           <td><label for="primasRenovacion">Primas de renovación:</label></td>

           <td>

              <input type="text" name="primasRenovacion" id="primasRenovacion" value="<?php if( isset( $data->primasRenovacion ) ) echo $data->primasRenovacion; else echo 0; ?>">

           </td>

        </tr>
		
        
        
        
        
        <tr>

           <td><label for="XAcotamiento">% de acotamiento:</label></td>

           <td>

              <input type="text" name="XAcotamiento" id="XAcotamiento" value="<?php if( isset( $data->XAcotamiento ) ) echo $data->XAcotamiento; else echo 0; ?>">

           </td>

        </tr>
		
        <tr>

           <td><br></td>

           <td><br></td>
           
           <td><br></td>

           <td><br></td>

        </tr>
        
        <tr>

           <td><label for="primasRenovacionPagar" style="color:#547EBD !important">Primas de renovación para pagar:</label></td>

           <td>
			  
              <p style="color:#547EBD !important; float:right" id="primasRenovacionPagar_text">$ <?php if( isset( $data->primasRenovacionPagar ) ) echo $data->primasRenovacionPagar; else echo 0; ?></p>	
              <input type="hidden" name="primasRenovacionPagar" id="primasRenovacionPagar" value="<?php if( isset( $data->primasRenovacionPagar ) ) echo $data->primasRenovacionPagar; else echo 0; ?>">
              

           </td>

        </tr>
		
        <tr>

           <td><br></td>

           <td><br></td>
           
           <td><br></td>

           <td><br></td>

        </tr>
        
        
        <tr>

           <td><label for="porcentajeConservacion">Porcentaje de conservación</label></td>

           <td>

              <select name="porcentajeConservacion" id="porcentajeConservacion">

                 <option value="0" <?php if( isset( $data->porcentajeConservacion ) and $data->porcentajeConservacion == 0 ) echo 'selected="selected"'; ?>>Sin base</option>

                 <option value="89" <?php if( isset( $data->porcentajeConservacion ) and $data->porcentajeConservacion == 89 ) echo 'selected="selected"'; ?>>89%</option>

                 <option value="91" <?php if( isset( $data->porcentajeConservacion ) and $data->porcentajeConservacion == 91 ) echo 'selected="selected"'; ?>>91%</option>

                 <option value="93" <?php if( isset( $data->porcentajeConservacion ) and $data->porcentajeConservacion == 93 ) echo 'selected="selected"'; ?>>93%</option>

                 <option value="95" <?php if( isset( $data->porcentajeConservacion ) and $data->porcentajeConservacion == 95 ) echo 'selected="selected"'; ?>>95%</option>

              </select>

           </td>

        </tr>

        <tr>

           <td><br></td>

           <td><br></td>

        </tr>

        <tr>
           <td colspan="2" align="left"><b style="color:#547EBD !important">COMISIONES</b></td>
		   <td colspan="2" align="left"><b style="color:#547EBD !important">BONO DE PRODUCTIVIDAD</b></td>
        </tr>

        <tr>

           <td><label for="comisionVentaInicial">% de comisión venta inicial:</label></td>

           <td>

              <input type="text" name="comisionVentaInicial" id="comisionVentaInicial" value="<?php if( isset( $data->comisionVentaInicial ) ) echo $data->comisionVentaInicial; else echo 0; ?>" onblur="ingresoTotal(); ">

           </td>
		   
           <td><label for="bonoAplicado">% de bono aplicado:</label></td>

           <td>

              <input type="text" name="bonoAplicado" id="bonoAplicado" class="camposSoloLectura" value="<?php if( isset( $data->bonoAplicado ) ) echo $data->bonoAplicado; else echo 0; ?>" readonly="readonly">

           </td>
          
        </tr>
		
        <tr>

           <td><br></td>

           <td><br></td>
           
           <td><br></td>

           <td><br></td>

        </tr>
        
        <tr>

           <td><label for="ingresoComisionesVentaInicial" style="color:#547EBD !important">Ingreso por comisiones de venta inicial:</label></td>

           <td>
			  
              <p style="color:#547EBD !important; float:right" id="ingresoComisionesVentaInicial_text">$ <?php if( isset( $data->ingresoComisionesVentaInicial ) ) echo $data->ingresoComisionesVentaInicial; else echo 0; ?></p>	
              <input type="hidden" name="ingresoComisionesVentaInicial" id="ingresoComisionesVentaInicial" value="<?php if( isset( $data->ingresoComisionesVentaInicial ) ) echo $data->ingresoComisionesVentaInicial; else echo 0; ?>">
           
           </td>
           
           <td><label for="ingresoBonoProductividad" style="color:#547EBD !important">Ingreso por bono de productividad:</label></td>

           <td>
			  
              <p style="color:#547EBD !important; float:right" id="ingresoBonoProductividad_text">$ <?php if( isset( $data->ingresoBonoProductividad ) ) echo $data->ingresoBonoProductividad; else echo 0; ?></p>	
              <input type="hidden" name="ingresoBonoProductividad" id="ingresoBonoProductividad" value="<?php if( isset( $data->ingresoBonoProductividad ) ) echo $data->ingresoBonoProductividad; else echo 0; ?>">
                         </td>

        </tr>

        <tr>

           <td><br></td>

           <td><br></td>
           
           <td><br></td>

           <td><br></td>

        </tr>

        <tr>

           <td><label for="comisionVentaRenovacion">% de comisión venta de renovación:</label></td>

           <td>

              <input type="text" name="comisionVentaRenovacion" id="comisionVentaRenovacion" value="<?php if( isset( $data->comisionVentaRenovacion ) ) echo $data->comisionVentaRenovacion; else echo 0; ?>"  onblur="ingresoTotal(); ingresoPromedio(); ">

           </td>

        </tr>
		
        <tr>

           <td><label for="ingresoComisionRenovacion" style="color:#547EBD !important">Ingreso por comisiones de renovación</label></td>

           <td>
			  
              <p style="color:#547EBD !important; float:right" id="ingresoComisionRenovacion_text">$ <?php if( isset( $data->ingresoComisionRenovacion ) ) echo $data->ingresoComisionRenovacion; else echo 0; ?></p>	
              <input type="hidden" name="ingresoComisionRenovacion" id="ingresoComisionRenovacion" value="<?php if( isset( $data->ingresoComisionRenovacion ) ) echo $data->ingresoComisionRenovacion; else echo 0; ?>">
              
           </td>

        </tr>

        <tr>

           <td><br></td>

           <td><br></td>
           
           <td><br></td>

           <td><br></td>

        </tr>





















        <tr>

           <td><br></td>

           <td><br></td>

        </tr>

        <tr>

           <td colspan="2" align="left"><b style="color:#547EBD !important">BONO DE RENOVACION</b></td>

        </tr>

        <tr>

           <td><label for="porbonoGanado">% de bono ganado:</label></td>

           <td>

              <input type="text" name="porbonoGanado" id="porbonoGanado" value="<?php if( isset( $data->porbonoGanado ) ) echo $data->porbonoGanado; else echo 0; ?>" readonly="readonly">

           </td>

        </tr>

        <tr>

           <td><label for="ingresoBonoRenovacion" style="color:#547EBD !important">Ingreso por bono de renovación:</label></td>

           <td>
			  
              <p style="color:#547EBD !important; float:right" id="ingresoBonoRenovacion_text">$ <?php if( isset( $data->ingresoBonoRenovacion ) ) echo $data->ingresoBonoRenovacion; else echo 0; ?></p>	
              <input type="hidden" name="ingresoBonoRenovacion" id="ingresoBonoRenovacion" value="<?php if( isset( $data->ingresoBonoRenovacion ) ) echo $data->ingresoBonoRenovacion; else echo 0; ?>">

           </td>

        </tr>

        <tr>

           <td><br></td>

           <td><br></td>

        </tr>
       
     </table>
	
     
    
        
 </div>    
</div>