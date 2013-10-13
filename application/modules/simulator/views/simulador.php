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
	
    
    <table style="margin-top:400px; position:fixed; z-index:1000; background:#F9F9F9; color:#fff; width:38%;">
    
     <tr>
           <td class="totales" style="width:250px;"><b style="color:#547EBD !important">INGRESO TOTAL:</b></td>

           <td style="text-align:right">
              <p style="color:#547EBD !important; float:right" id="ingresoTotal_text">$ 0</p>	
              <input type="hidden" name="ingresoBonoRenovacion" id="ingresoTotal" value="0">
           </td>

        </tr>

        <tr>

            <td class="totales"><b style="color:#547EBD !important">INGRESO PROMEDIO MENSUAL:</b></td>

           <td style="text-align:right">
			  <p style="color:#547EBD !important; float:right" id="inresoPromedioMensual_text">$ 0</p>	
              <input type="hidden" name="ingresoBonoRenovacion" id="inresoPromedioMensual" value="0">

           </td>

        </tr>
        
    </table>    
    
    
    <table>

        <tr>

           <td width="60%"><label for="periodo">Periodo:</label></td>

           <td width="40%" >

              <select name="periodo" id="periodo" onchange="ingresoPromedio();">

                 <option value="3">TRIMESTRAL</option>

                 <option value="12">ANUAL</option>

              </select>

           </td>

        </tr>

        <tr>

           <td><br></td>

           <td><br></td>

        </tr>

        <tr>

           <td><label for="primasAfectasInicialesUbicar">Primas afectas iniciales(venta inicial):</label></td>

           <td>

              <input type="text" name="primasAfectasInicialesUbicar" id="primasAfectasInicialesUbicar" value="0">

           </td>

        </tr>
        
        <tr>

           <td><label for="primas_promedio">Primas promedio:</label></td>

           <td>

              <input type="text" name="primas_promedio" id="primas_promedio" value="0">

           </td>

        </tr>

        <tr>

           <td><label for="porAcotamiento">% de acotamiento:</label></td>

           <td>

              <input type="text" name="porAcotamiento" id="porAcotamiento" value="0">

           </td>

        </tr>

        <tr>

           <td><label for="primasAfectasInicialesPagar" style="color:#547EBD !important">Primas afectas iniciales para bonos</label></td>

           <td>
			  
              <p style="color:#547EBD !important; float:right" id="primasAfectasInicialesPagar_text">$ 0</p>	
              <input type="hidden" name="primasAfectasInicialesPagar" id="primasAfectasInicialesPagar">
              

           </td>

        </tr>

        <tr>

           <td><label for="noNegocios">No. de Negocios PAI:</label></td>

           <td>

              <input type="text" name="noNegocios" id="noNegocios" value="0">

           </td>

        </tr>

        <tr>

           <td><br></td>

           <td><br></td>

        </tr>

        <tr>

           <td><label for="primasRenovacion">Primas de renovación:</label></td>

           <td>

              <input type="text" name="primasRenovacion" id="primasRenovacion" value="0">

           </td>

        </tr>

        <tr>

           <td><label for="XAcotamiento">% de acotamiento:</label></td>

           <td>

              <input type="text" name="XAcotamiento" id="XAcotamiento" value="0">

           </td>

        </tr>

        <tr>

           <td><label for="primasRenovacionPagar" style="color:#547EBD !important">Primas de renovación para pagar:</label></td>

           <td>
			  
              <p style="color:#547EBD !important; float:right" id="primasRenovacionPagar_text">$ 0</p>	
              <input type="hidden" name="primasRenovacionPagar" id="primasRenovacionPagar">
              

           </td>

        </tr>

        <tr>

           <td><label for="porcentajeConservacion">Porcentaje de conservación</label></td>

           <td>

              <select name="porcentajeConservacion" id="porcentajeConservacion">

                 <option value="0">Sin base</option>

                 <option value="89">89%</option>

                 <option value="91">91%</option>

                 <option value="93">93%</option>

                 <option value="95">95%</option>

              </select>

           </td>

        </tr>

        <tr>

           <td><br></td>

           <td><br></td>

        </tr>

        <tr>

           <td colspan="2" align="left"><b style="color:#547EBD !important">COMISIONES</b></td>

        </tr>

        <tr>

           <td><label for="comisionVentaInicial">% de comisión venta inicial:</label></td>

           <td>

              <input type="text" name="comisionVentaInicial" id="comisionVentaInicial" value="0" onblur="ingresoTotal()">

           </td>

        </tr>

        <tr>

           <td><label for="ingresoComisionesVentaInicial" style="color:#547EBD !important">Ingreso por comisiones de venta inicial:</label></td>

           <td>
			  
              <p style="color:#547EBD !important; float:right" id="ingresoComisionesVentaInicial_text">$ 0</p>	
              <input type="hidden" name="ingresoComisionesVentaInicial" id="ingresoComisionesVentaInicial" value="0">
           
           </td>

        </tr>

        <tr>

           <td><br></td>

           <td><br></td>

        </tr>

        <tr>

           <td><label for="comisionVentaRenovacion">% de comisión venta de renovación:</label></td>

           <td>

              <input type="text" name="comisionVentaRenovacion" id="comisionVentaRenovacion" value="0"  onblur="ingresoTotal(); ingresoPromedio();">

           </td>

        </tr>

        <tr>

           <td><label for="ingresoComisionRenovacion" style="color:#547EBD !important">Ingreso por comisiones de renovación</label></td>

           <td>
			  
              <p style="color:#547EBD !important; float:right" id="ingresoComisionRenovacion_text">$ 0</p>	
              <input type="hidden" name="ingresoComisionRenovacion" id="ingresoComisionRenovacion" value="0">
              
           </td>

        </tr>

        <tr>

           <td><br></td>

           <td><br></td>

        </tr>

        <tr>

           <td colspan="2" align="left"><b style="color:#547EBD !important">BONO DE PRODUCTIVIDAD</b></td>

        </tr>

        <tr>

           <td><label for="bonoAplicado">% de bono aplicado:</label></td>

           <td>

              <input type="text" name="bonoAplicado" id="bonoAplicado" class="camposSoloLectura" value="0" readonly="readonly">

           </td>

        </tr>

        <tr>

           <td><label for="ingresoBonoProductividad" style="color:#547EBD !important">Ingreso por bono de productividad:</label></td>

           <td>
			  
              <p style="color:#547EBD !important; float:right" id="ingresoBonoProductividad_text">$ 0</p>	
              <input type="hidden" name="ingresoBonoProductividad" id="ingresoBonoProductividad" value="0">
                         </td>

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

              <input type="text" name="porbonoGanado" id="porbonoGanado" value="0" readonly="readonly">

           </td>

        </tr>

        <tr>

           <td><label for="ingresoBonoRenovacion" style="color:#547EBD !important">Ingreso por bono de renovación:</label></td>

           <td>
			  
              <p style="color:#547EBD !important; float:right" id="ingresoBonoRenovacion_text">$ 0</p>	
              <input type="hidden" name="ingresoBonoRenovacion" id="ingresoBonoRenovacion" value="0">

           </td>

        </tr>

        <tr>

           <td><br></td>

           <td><br></td>

        </tr>
       
     </table>
	
    
        
 </div>    
</div>