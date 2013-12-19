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

 <div class="box-content">
	
    <!--style="margin-top:400px; position:fixed; z-index:1000; background:#F9F9F9; color:#fff; width:38%;"-->
    <table class="table-totals" style="background:#F9F9F9; color:#fff; width:73%;position:fixed !important;
	bottom:0px;">
    
     <tr>
           <td class="totales" style="width:650px;"><b style="color:#547EBD !important">INGRESO TOTAL:</b></td>

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
    
    
    
    
    
    
    <table class="table table-bordered">
		
        
        <tr>
           <td><label>Periodo:</label></td>
           <td><select name="periodo" id="periodo" class="input-small">

                 <option value="4" <?php if( isset( $data->periodo ) and $data->periodo == 4 ) echo 'selected="selected"'; ?>>CUATRIMESTRAL</option>

                 <option value="12" <?php if( isset( $data->periodo ) and $data->periodo == 12 ) echo 'selected="selected"'; ?>>ANUAL</option>

              </select></td>           
           <td><br></td>
           <td><br></td>
        </tr>
        
        <tr>
           <td><br></td>
           <td><br></td>           
           <td><br></td>
           <td><br></td>
        </tr>
        
        <tr>

           <td><label>Primas netas iniciales:</label></td>

           <td><input type="text" class="input-small" name="primasnetasiniciales" id="primasnetasiniciales" value="<?php if( isset( $data->primasnetasiniciales ) ) echo $data->primasnetasiniciales; else if( isset( $data->primasAfectasInicialesUbicar ) ) echo $data->primasAfectasInicialesUbicar; echo 0; ?>"></td>
		   
           <td><label>% de acotamiento:</label></td>

           <td><input type="text" class="input-small" name="porAcotamiento" id="porAcotamiento" value="<?php if( isset( $data->porAcotamiento ) ) echo $data->porAcotamiento; else echo 0; ?>"></td>
           
        </tr>
       
        <tr>
           <td><label>Primas promedio</label></td>
           <td><input type="text" class="input-small" name="primaspromedio" id="primaspromedio" value="<?php if( isset( $data->primaspromedio ) ) echo $data->primaspromedio; elseif( isset( $data->primas_promedio ) ) echo $data->primas_promedio; else echo 0; ?>"></td> 
           <td><label>No Negocios:</label></td>
           <td><input type="text" class="input-small" name="nonegocios" id="nonegocios" value="<?php if( isset( $data->nonegocios ) ) echo $data->nonegocios; else echo 0; ?>"></td>
        </tr>

        <tr>
           <td><label style="color:#547EBD !important">Primas afectas iniciales para pagos de bonos</label></td>		
           <td>			  
              <p style="color:#547EBD !important; float:right" id="primasAfectasInicialesPagar_text">$ <?php if( isset( $data->primasAfectasInicialesPagar ) ) echo $data->primasAfectasInicialesPagar; else echo 0; ?></p>	
              <input type="hidden" name="primasAfectasInicialesPagar" id="primasAfectasInicialesPagar" value="<?php if( isset( $data->primasAfectasInicialesPagar ) ) echo $data->primasAfectasInicialesPagar; else echo 0; ?>">
           </td>
           <td><br></td>
           <td><br></td>	           
        </tr>

      
        <tr>
           <td><br></td>
           <td><br></td>           
           <td><br></td>
           <td><br></td>
        </tr>

        <tr>
		   
                       
           <td><label>Primas de renovación:</label></td>

           <td>

              <input type="text" class="input-small" name="primasRenovacion" id="primasRenovacion" value="<?php if( isset( $data->primasRenovacion ) ) echo $data->primasRenovacion; else echo 0; ?>">

           </td>
		   
           <td><label>% de acotamiento:</label></td>

           <td>

              <input type="text" class="input-small" name="XAcotamiento" id="XAcotamiento" value="<?php if( isset( $data->XAcotamiento ) ) echo $data->XAcotamiento; else echo 0; ?>">

           </td>
           
        </tr>
		
        
        <tr>
           <td colspan="3"><label style="color:#547EBD !important">Primas de renovación para pagar:</label></td>
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
           <td colspan="2" align="left"><b style="color:#547EBD !important">COMISIONES</b></td>		
           <td><br></td>
           <td><br></td>  
        </tr>
        
         <tr>
           <td><label>% de comisión venta inicial:</label></td>
           <td>
              <input type="text" class="input-small" name="comisionVentaInicial" id="comisionVentaInicial" value="<?php if( isset( $data->comisionVentaInicial ) ) echo $data->comisionVentaInicial; else echo 0; ?>">
           </td>		   
           <td><label style="color:#547EBD !important">Ingreso por comisiones:</label></td>
           <td>			  
              <p style="color:#547EBD !important; float:right" id="ingresoComisionesVentaInicial_text">$ <?php if( isset( $data->ingresoComisionesVentaInicial ) ) echo $data->ingresoComisionesVentaInicial; else echo 0; ?></p>	
              <input type="hidden" name="ingresoComisionesVentaInicial" id="ingresoComisionesVentaInicial" value="<?php if( isset( $data->ingresoComisionesVentaInicial ) ) echo $data->ingresoComisionesVentaInicial; else echo 0; ?>">           
           </td>  
        </tr>
        
        <tr>        	
           <td><label>% de comisión venta de renovación:</label></td>
           <td>
              <input type="text" class="input-small" name="comisionVentaRenovacion" id="comisionVentaRenovacion" value="<?php if( isset( $data->comisionVentaRenovacion ) ) echo $data->comisionVentaRenovacion; else echo 0; ?>" >
           </td>   
           <td><label style="color:#547EBD !important">Ingreso por comisiones de renovación</label></td>
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
		   <td colspan="2" align="left"><b style="color:#547EBD !important">BONO DE PRIMER AÑO</b></td>
           <td><br></td>
           <td><br></td>
        </tr>

        <tr>
           <td><label>% de bono aplicado:</label></td>
           <td>
              <input type="text" class="input-small" name="bonoAplicado" id="bonoAplicado" value="<?php if( isset( $data->bonoAplicado ) ) echo $data->bonoAplicado; else echo 0; ?>" readonly="readonly">
           </td>              
           <td><label style="color:#547EBD !important">Ingreso por bono de productividad:</label></td>
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
           <td colspan="2" align="left"><b style="color:#547EBD !important">BONO DE RENTABILIDAD DE CARTERA</b></td>
		   <td><br></td>
           <td><br></td>
        </tr>

        <tr>

           <td><label>% de siniestridad:</label></td>
           <td>
			  <select name="porsiniestridad" id="porsiniestridad" class="input-small">
              		<option value="">Seleccione</option>
                    <option value="68" <?php if( isset( $data->porsiniestridad ) and $data->porsiniestridad == 68 ) echo 'selected="selected"'?>>68</option>
                    <option value="64" <?php if( isset( $data->porsiniestridad ) and $data->porsiniestridad == 64 ) echo 'selected="selected"'?>>64</option>
                    <option value="60" <?php if( isset( $data->porsiniestridad ) and $data->porsiniestridad == 60 ) echo 'selected="selected"'?>>60</option>
              </select>
              
           </td>           
           <td><label>% de bono ganado:</label></td>

           <td><input readonly="readonly" type="text" name="porbonoganado" id="porbonoganado" value="<?php if( isset( $data->porbonoganado ) ) echo $data->porbonoganado; else echo 0; ?>"></td>

        </tr>

        <tr>

           <td><label style="color:#547EBD !important">Ingreso por bono de renovación:</label></td>

           <td>
			  
              <p style="color:#547EBD !important; float:right" id="ingresoBonoRenovacion_text">$ <?php if( isset( $data->ingresoBonoRenovacion ) ) echo $data->ingresoBonoRenovacion; else echo 0; ?></p>	
              <input type="hidden" name="ingresoBonoRenovacion" id="ingresoBonoRenovacion" value="<?php if( isset( $data->ingresoBonoRenovacion ) ) echo $data->ingresoBonoRenovacion; else echo 0; ?>" >

           </td>
           
           <td><br></td>

           <td><br></td>

        </tr>
       
     </table>
	
     
    
        
 </div>    