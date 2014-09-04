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
$base_url = base_url();
$this->load->helper('filter');
$selected_filter_period = get_selected_filter_period();
$segments = $this->uri->rsegment_array();
$export_segments = $segments;
$export_segments[2] = 'stat_recap_export';
$ramo = $this->uri->segment(3);
$recap_details = 0;
?>
            <div class="row">
              <div class="span6">
                <form id="operation-stats-form" method="post" action="<?php echo current_url()?>">
Período :&nbsp;<i class="icon-calendar" id="cust_update-period" title="Click para editar el período personalizado"></i><br />
                  <select class="filter-field" id="periodo" name="periodo" style="width: 9.5em">
                    <option value="1" <?php echo $selected_filter_period[1] ?>>Mes</option>
                    <option value="2" <?php echo $selected_filter_period[2] ?>>Trimestre</option>
                    <option value="3" <?php echo $selected_filter_period[3] ?>>Año</option>
                    <option value="4" id="period_opt4" <?php echo $selected_filter_period[4] ?>>Período personalizado</option>
                    <option value="5" <?php echo $selected_filter_period[5] ?>>Cuatrimestre</option>
                  </select>
                </form>
              </div>
              <div class="span6" style="text-align: right">			  

              </div>
            </div>				
            <div class="row" id="operations-stats">
		        <div class="span5" id="left-col">
                  <p><span>Nuevos de Negocios <?php echo ucfirst($segments[3]) ?></span>
<?php if ($this->access_export_xls) :?>
                <a href="<?php echo $base_url . implode('/', $export_segments); ?>.html" id="detail-export-xls" title="Exportar" style="font-size: larger;">
                    <img src="<?php echo $base_url ?>ot/assets/images/down.png" title="Exportar" />
				</a>
<?php endif; ?>
                  <p>
                  <table>
                      <tr style="background-color: white;">
                        <td>
                          <a class="stat-link" id="tramite_link" href="javascript:void(0);" class="btn btn-link" title="Ver Detalles">
                          En trámite</a>
                        </td>
                        <td>
<?php
$recap_details += $stats['per_status']['tramite'];
echo $stats['per_status']['tramite'];
?>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <a class="stat-link" id="pagada_link" href="javascript:void(0);" class="btn btn-link" title="Ver Detalles">
                          Pagados</a>
                        </td>
                        <td>
<?php
$recap_details += $stats['per_status']['pagada'];
echo $stats['per_status']['pagada'];
?>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <a class="stat-link" id="canceladas_link" href="javascript:void(0);" class="btn btn-link" title="Ver Detalles">
                          Cancelados</a>
                        </td>
                        <td>
<?php
$recap_details += $stats['per_status']['canceladas'];
echo $stats['per_status']['canceladas'];
?>
                        </td>
                      </tr>
                      <tr style="border-bottom: 2em solid white">
                        <td>
                          <a class="stat-link" id="NTU_link" href="javascript:void(0);" class="btn btn-link" title="Ver Detalles">
                          NTU</a>
                        </td>
                        <td>
<?php
$recap_details += $stats['per_status']['NTU'];
echo $stats['per_status']['NTU'];
?>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3"></td>
                      </tr>
                      <tr style="background-color: yellow;">
                        <td>Trámites de nuevos negocios:</td>
                        <td><?php echo $recap_details ?></td>
                      </tr>
                  </table>
		        </div>

		        <div class="span7" id="right-col">

		        </div>
            </div>			


<div style="margin-top: 10em">
<?php echo $period_form ?>

</div>
