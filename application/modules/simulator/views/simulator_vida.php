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
?>  <input type="hidden" id="saves" name="saves" value="<?php if( !empty( $data ) ) echo 1; else echo 0; ?>" />    
 <div class="box-content">
	
    <!--style="margin-top:400px; position:fixed; z-index:1000; background:#F9F9F9; color:#fff; width:38%;"-->
    <table class="table-totals" style="background:#F9F9F9; color:#fff; width:73%;position:fixed !important;
	bottom:0px;">
    
     <tr>
           <td class="totales" style="width:33%"><b style="color:#547EBD !important">INGRESO TOTAL:</b></td>

           <td style="text-align:right; width:34%">
              <p style="color:#547EBD !important; float:right" id="ingresoTotal_text">$ <?php if( isset( $data->ingresoTotal ) ) echo $data->ingresoTotal; else echo 0; ?></p>	
              <input type="hidden" name="ingresoBonoRenovacion" id="ingresoTotal" value="<?php if( isset( $data->ingresoTotal ) ) echo $data->ingresoTotal; else echo 0; ?>">
           </td>
           
           <td style="vertical-align:middle"><input type="button" id="open_meta" value="Ver distribución anual" class="pull-right btn-save-meta" style="margin-top:10px;" /></td>

        </tr>

        <tr>

            <td class="totales"><b style="color:#547EBD !important">INGRESO PROMEDIO MENSUAL:</b></td>

           <td style="text-align:right">
			  <p style="color:#547EBD !important; float:right" id="inresoPromedioMensual_text">$ <?php if( isset( $data->ingresoBonoRenovacion ) ) echo $data->ingresoBonoRenovacion; else echo 0; ?></p>	
              <input type="hidden" name="ingresoBonoRenovacion" id="inresoPromedioMensual" value="<?php if( isset( $data->ingresoBonoRenovacion ) ) echo $data->ingresoBonoRenovacion; else echo 0; ?>">

           </td>
           <td style="vertical-align:middle"><input type="button" value="Guardar Meta" class="pull-right btn-save-meta" style="margin-top:10px;" onclick="save();"/></td>

        </tr>
        
    </table>    
    
    
    
    
    
    
    
    
    
    <table class="table table-bordered">
		
        <tr>
        	<td colspan="4"><h6>Primer trimestre:</h6></td>
        </tr>
        
        <tr>
           <td><p>Primas del trimestre:</p>
           <input type="hidden" name="simulatorprimasprimertrimestre" id="simulatorprimasprimertrimestre" value="<?php if( isset( $data->simulatorprimasprimertrimestre ) ) echo $data->simulatorprimasprimertrimestre; else echo 0; ?>" />
           </td>
           <td><div id="simulator-primas-primer-trimestre">$ <?php if( isset( $data->simulatorprimasprimertrimestre ) ) echo $data->simulatorprimasprimertrimestre; else echo 0; ?></div></td>		   
           <td><p>Ingresos del trimestre</p><input type="hidden" name="simulatoringresosprimertrimestre" id="simulatoringresosprimertrimestre" value="<?php if( isset( $data->simulatoringresosprimertrimestre ) ) echo $data->simulatoringresosprimertrimestre; else echo 0; ?>" /></td>
           <td><div id="simulator-ingresos-primer-trimestre">$ <?php if( isset( $data->simulatoringresosprimertrimestre ) ) echo $data->simulatoringresosprimertrimestre; else echo 0; ?></div></td>
        </tr>
        
        <tr>
        	<td colspan="4"><h6>Segundo trimestre:</h6></td>
        </tr>
        
        <tr>
           <td><p>Primas del trimestre:</p><input type="hidden" name="simulatorprimassegundotrimestre" id="simulatorprimassegundotrimestre" value="<?php if( isset( $data->simulatorprimassegundotrimestre ) ) echo $data->simulatorprimassegundotrimestre; else echo 0; ?>" /></td>
           <td><div id="simulator-primas-segundo-trimestre">$ <?php if( isset( $data->simulatorprimassegundotrimestre ) ) echo $data->simulatorprimassegundotrimestre; else echo 0; ?></div></td>		   
           <td><p>Ingresos del trimestre</p><input type="hidden" name="simulatoringresossegundotrimestre" id="simulatoringresossegundotrimestre" value="<?php if( isset( $data->simulatoringresossegundotrimestre ) ) echo $data->simulatoringresossegundotrimestre; else echo 0; ?>" /></td>
           <td><div id="simulator-ingresos-segundo-trimestre">$ <?php if( isset( $data->simulatoringresossegundotrimestre ) ) echo $data->simulatoringresossegundotrimestre; else echo 0; ?></div></td>
        </tr>
        
        <tr>
        	<td colspan="4"><h6>Tercer trimestre:</h6></td>
        </tr>
        
        <tr>
           <td><p>Primas del trimestre:</p><input type="hidden" name="simulatorprimastercertrimestre" id="simulatorprimastercertrimestre" value="<?php if( isset( $data->simulatorprimastercertrimestre ) ) echo $data->simulatorprimastercertrimestre; else echo 0; ?>" /></td>
           <td><div id="simulator-primas-tercer-trimestre">$ <?php if( isset( $data->simulatorprimastercertrimestre ) ) echo $data->simulatorprimastercertrimestre; else echo 0; ?></div></td>		   
           <td><p>Ingresos del trimestre</p><input type="hidden" name="simulatoringresostercertrimestre" id="simulatoringresostercertrimestre" value="<?php if( isset( $data->simulatoringresostercertrimestre ) ) echo $data->simulatoringresostercertrimestre; else echo 0; ?>" /></td>
           <td><div id="simulator-ingresos-tercer-trimestre">$ <?php if( isset( $data->simulatoringresostercertrimestre ) ) echo $data->simulatoringresostercertrimestre; else echo 0; ?></div></td>
        </tr>
        
        <tr>
        	<td colspan="4"><h6>Cuarto trimestre:</h6></td>
        </tr>
        
        <tr>
           <td><p>Primas del trimestre:</p><input type="hidden" name="simulatorprimascuartotrimestre" id="simulatorprimascuartotrimestre" value="<?php if( isset( $data->simulatorprimascuartotrimestre ) ) echo $data->simulatorprimascuartotrimestre; else echo 0; ?>" /></td>
           <td><div id="simulator-primas-tercer-trimestre">$ <?php if( isset( $data->simulatorprimascuartotrimestre ) ) echo $data->simulatorprimascuartotrimestre; else echo 0; ?></div></td>		   
           <td><p>Ingresos del trimestre</p><input type="hidden" name="simulatoringresoscuartotrimestre" id="simulatoringresoscuartotrimestre" value="<?php if( isset( $data->simulatoringresoscuartotrimestre ) ) echo $data->simulatoringresoscuartotrimestre; else echo 0; ?>" /></td>
           <td><div id="simulator-ingresos-tercer-trimestre">$ <?php if( isset( $data->simulatoringresoscuartotrimestre ) ) echo $data->simulatoringresoscuartotrimestre; else echo 0; ?></div></td>
        </tr>
        
        
        <tr>
           <td><br></td>
           <td><br></td>
           <td><br></td>
           <td><br></td>
        </tr>
        
        
        
        
        
		<!--<tr>
           <td><label>Periodo:</label></td>
           <td>
              <select name="periodo" id="periodo" class="input-small">
                 <option value="3" <?php if( isset( $data->periodo ) and $data->periodo == 3 ) echo 'selected="selected"'; ?>>TRIMESTRAL</option>
                 <option value="12" <?php if( isset( $data->periodo ) and $data->periodo == 12 ) echo 'selected="selected"'; ?>>ANUAL</option>
			  </select>
           </td>
           <td></td>
           <td></td>
        </tr>
        
        <tr>
           <td><br></td>
           <td><br></td>
           <td><br></td>
           <td><br></td>
        </tr>-->
        
        <tr>
           <td>
           <input type="hidden" name="periodo" id="periodo" value="12">
           <label>Primas afectas iniciales anuales (venta inicial):</label></td>
           <td><input type="text" class="input-small" name="primasAfectasInicialesUbicar" id="primasAfectasInicialesUbicar" value="<?php if( isset( $data->primasnetasiniciales ) ) echo $data->primasnetasiniciales; else if( isset( $data->primasAfectasInicialesUbicar ) ) echo $data->primasAfectasInicialesUbicar; else echo 0; ?>"></td>		   
           <td><label>% de acotamiento:</label></td>
           <td><input type="text" class="input-small" name="porAcotamiento" id="porAcotamiento" value="<?php if( isset( $data->porAcotamiento ) ) echo $data->porAcotamiento; else echo 0; ?>"></td>
        </tr>
       
        <tr>

           <td><label>Prima promedio:</label></td>

           <td>

              <input type="text" class="input-small" name="primas_promedio" id="primas_promedio" value="<?php if( isset( $data->primaspromedio ) ) echo $data->primaspromedio; elseif( isset( $data->primas_promedio ) ) echo $data->primas_promedio; else echo 0; ?>">

           </td>
           
           <td><label>No. de Negocios PAI:</label></td>

           <td> <input type="text" readonly="readonly" class="input-small" name="noNegocios" id="noNegocios" value="<?php if( isset( $data->noNegocios ) ) echo $data->noNegocios; else echo 0; ?>">
</td>
          
        </tr>

        <tr>
           <td><label style="color:#547EBD !important">Primas afectas iniciales para bonos</label></td>		
           <td class="2">			  
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
           <td><input type="text" class="input-small" name="primasRenovacion" id="primasRenovacion" value="<?php if( isset( $data->primasRenovacion ) ) echo $data->primasRenovacion; else echo 0; ?>"></td>           
           <td><label>% de acotamiento:</label></td>
           <td><input type="text" class="input-small" name="XAcotamiento" id="XAcotamiento" value="<?php if( isset( $data->XAcotamiento ) ) echo $data->XAcotamiento; else echo 0; ?>"></td>
        </tr>		
        
                
        <tr>
           <td><label style="color:#547EBD !important">Primas de renovación para pagar:</label></td>
           <td>			  
              <p style="color:#547EBD !important; float:right" id="primasRenovacionPagar_text">$ <?php if( isset( $data->primasRenovacionPagar ) ) echo $data->primasRenovacionPagar; else echo 0; ?></p>	
              <input type="hidden" name="primasRenovacionPagar" id="primasRenovacionPagar" value="<?php if( isset( $data->primasRenovacionPagar ) ) echo $data->primasRenovacionPagar; else echo 0; ?>">
           </td>
           <td><label>Porcentaje de conservación</label></td>
           <td><select name="porcentajeConservacion" id="porcentajeConservacion" class="input-small">

                 <option value="0" <?php if( isset( $data->porcentajeConservacion ) and $data->porcentajeConservacion == 0 ) echo 'selected="selected"'; ?>>Sin base</option>

                 <option value="89" <?php if( isset( $data->porcentajeConservacion ) and $data->porcentajeConservacion == 89 ) echo 'selected="selected"'; ?>>89%</option>

                 <option value="91" <?php if( isset( $data->porcentajeConservacion ) and $data->porcentajeConservacion == 91 ) echo 'selected="selected"'; ?>>91%</option>

                 <option value="93" <?php if( isset( $data->porcentajeConservacion ) and $data->porcentajeConservacion == 93 ) echo 'selected="selected"'; ?>>93%</option>

                 <option value="95" <?php if( isset( $data->porcentajeConservacion ) and $data->porcentajeConservacion == 95 ) echo 'selected="selected"'; ?>>95%</option>

              </select></td>
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
           <td><label style="color:#547EBD !important">Ingreso por comisiones de venta inicial:</label></td>
           <td>
              <p style="color:#547EBD !important; float:right" id="ingresoComisionesVentaInicial_text">$ <?php if( isset( $data->ingresoComisionesVentaInicial ) ) echo $data->ingresoComisionesVentaInicial; else echo 0; ?></p>	
              <input type="hidden" name="ingresoComisionesVentaInicial" id="ingresoComisionesVentaInicial" value="<?php if( isset( $data->ingresoComisionesVentaInicial ) ) echo $data->ingresoComisionesVentaInicial; else echo 0; ?>">
           </td>          
        </tr>
        
        <tr>
           <td><label>% de comisión venta de renovación:</label></td>
           <td>
              <input type="text" class="input-small" name="comisionVentaRenovacion" id="comisionVentaRenovacion" value="<?php if( isset( $data->comisionVentaRenovacion ) ) echo $data->comisionVentaRenovacion; else echo 0; ?>">
           </td>           
           <td><label style="color:#547EBD !important">Ingreso por comisiones de renovación</label></td>

           <td> <p style="color:#547EBD !important; float:right" id="ingresoComisionRenovacion_text">$ <?php if( isset( $data->ingresoComisionRenovacion ) ) echo $data->ingresoComisionRenovacion; else echo 0; ?></p>	
              <input type="hidden" name="ingresoComisionRenovacion" id="ingresoComisionRenovacion" value="<?php if( isset( $data->ingresoComisionRenovacion ) ) echo $data->ingresoComisionRenovacion; else echo 0; ?>"></td>

        </tr>
        
        <tr>
           <td><br></td>
           <td><br></td>           
           <td><br></td>
           <td><br></td>
        </tr>
        
        <tr>
           <td colspan="2" align="left"><b style="color:#547EBD !important">BONO DE PRODUCTIVIDAD</b></td>
           <td colspan="3" align="left"></td>
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
           <td colspan="2" align="left"><b style="color:#547EBD !important">BONO DE RENOVACION</b></td>
		   <td><br></td>
           <td><br></td>
        </tr>

        <tr>

           <td><label>% de bono ganado:</label></td>

           <td>

              <input type="text" class="input-small" name="porbonoGanado" id="porbonoGanado" value="<?php if( isset( $data->porbonoGanado ) ) echo $data->porbonoGanado; else echo 0; ?>" readonly="readonly">

           </td>
           
           <td><label style="color:#547EBD !important">Ingreso por bono de renovación:</label></td>

           <td><p style="color:#547EBD !important; float:right" id="ingresoBonoRenovacion_text">$ <?php if( isset( $data->ingresoBonoRenovacion ) ) echo $data->ingresoBonoRenovacion; else echo 0; ?></p>	
              <input type="hidden" name="ingresoBonoRenovacion" id="ingresoBonoRenovacion" value="<?php if( isset( $data->ingresoBonoRenovacion ) ) echo $data->ingresoBonoRenovacion; else echo 0; ?>" ></td>

        </tr>
       
     </table>
        
 </div>    