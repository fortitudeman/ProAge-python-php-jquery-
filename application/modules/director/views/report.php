<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
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
$selected_period = get_filter_period();
$base_url = base_url();
?>
            <div class="row">
                <div class="span11" style="margin-left:40px; width:95%">
                    <div class="main-container">
<?php
$segments = $this->uri->rsegment_array();
if ((count($segments) >= 2) && 
	(($segments[2] == 'index') || ($segments[2] == 'sales_planning'))): ?>
<div>
<button id="add-payment-btn" class="btn btn-primary">Crear un pago</button>
</div>

<div style="display: none" id="add-payment-container" title="Crear un pago">
		<div id="add-payment-error" class="alert alert-error" style="display: none"></div>
        <form id="add-payment-form" class="form-horizontal" style="margin-left: -3em" method="post">
          <div class="control-group">
            <label class="control-label" for="payment-product-group">Ramo</label>
            <div class="controls">
              <select required class="span3 required" id="payment-product-group" name="product_group" placeholder="Ramo">                
                <option value="">Selecciona el ramo</option>
                <option value="1">Vida</option>
                <option value="2">GMM</option>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="payment-agent-id">Agente</label>
            <div class="controls">
              <input type="text" title="Escriba el nombre del agente que desea buscar y selecciónelo de la lista que aparece." required class="span3" id="payment-agent-id" name="agent_id" placeholder="Agente">                
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="payment-amount">Monto pagado</label>
            <div class="controls">
              <input type="text" required id="payment-amount" name="amount" placeholder="Monto pagado">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="payment-date">Fecha de pago</label>
            <div class="controls">
              <input type="text" required id="payment-date" name="payment_date" placeholder="Fecha de pago">
            </div>
          </div>
<!--
          <div class="control-group">
            <div class="controls">
              <label class="checkbox">
                <input type="checkbox" id="payment-business" name="business">¿Es negocio?
              </label>
            </div>
          </div>
-->
          <div class="control-group">
            <label class="control-label" for="payment-business">¿Es negocio?</label>
            <div class="controls">
              <input type="text" required id="payment-business" name="business" placeholder="¿Es negocio?">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="payment-policy-number">Número de póliza</label>
            <div class="controls">
              <input type="text" title="Escriba el número de póliza que desea buscar y selecciónelo de la lista que aparece." required id="payment-policy-number" name="policy_number" placeholder="Número de póliza">
            </div>
          </div>
          <div class="control-group">
            <div class="controls">
              <label class="checkbox">
                <input type="checkbox" id="payment-valid-for-report" name="valid_for_report" checked="checked">¿Valido para el reporte?
              </label>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="payment-year-prime">Año prima</label>
            <div class="controls">
              <input type="text" required id="payment-year-prime" name="year_prime" placeholder="Año prima">
            </div>
          </div>
        </form>
</div>
<?php endif; ?>
                        <div class="main clearfix">                               
                            <a href="javascript:void(0);" class="links-menu btn btn-link link-ramo" id="vida" <?php if ($other_filters['ramo'] == 1) echo 'style="color:#06F"' ?>>Vida</a>
                            <a href="javascript:void(0);" class="links-menu btn btn-link link-ramo" id="gmm" <?php if ($other_filters['ramo'] == 2) echo 'style="color:#06F"' ?>>GMM</a>
                            <a href="javascript:void(0);" class="links-menu btn btn-link link-ramo" id="autos" <?php if ($other_filters['ramo'] == 3) echo 'style="color:#06F"' ?>>Autos</a>

                            <p class="line">&nbsp; </p>
                            <form id="form" method="post">
								<input type="hidden" name="query[ramo]" id="ramo" value="<?php echo $other_filters['ramo'] ?>" />
								<input type="hidden" name="ver_meta" id="ver-meta" value="<?php echo $page ?>" />
                                <table class="filterstable" style="width:99%;">
                                    <thead>
                                        <tr style="vertical-align: top;">
                                            <th>
<?php echo $period_fields ?>
<select id="periodo_form" name="periodo" style="width: 175px" title="Período">
	  <option value="<?php echo $selected_period ?>"></option>
</select>
<input type="hidden" value="<?php echo $selected_period ?>" id="periodo" name="query[periodo]" />
                                            </th>
                                            <th>
                                                <input type="hidden" id="gerente_value" value="<?php echo $other_filters['gerente']; ?>" />
                                                <select id="gerente" name="query[gerente]" class="select" style="width:145px;" onchange="this.form.submit();">
                                                    <option value="">Todos los gerentes</option>                                        
                                                    <?php if (!empty($manager)): foreach ($manager as $value): ?>

                                                    <option <?php if ($other_filters['gerente'] == $value['id']) echo 'selected="selected"' ?> value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                                                    <?php endforeach;
                                                    endif; ?>
                                                </select>
                                            </th>
                                            <th>
                                                <select id="agent" name="query[agent]" class="select2" style="width:140px;" onchange="this.form.submit();">
                                                    <option value="" <?php if (!$other_filters['agent'] || ($other_filters['agent'] == 1)) echo 'selected="selected"' ?>>Todos los agentes</option>
                                                    <option value="2" <?php if ($other_filters['agent'] == 2) echo 'selected="selected"' ?>>Cancelados</option>
                                                    <option value="3" <?php if ($other_filters['agent'] == 3) echo 'selected="selected"' ?>>Vigentes</option>
                                                </select>
                                            </th>
                                            <th>
                                                <select id="generarion" name="query[generacion]" class="select3" style="width:180px;" onchange="this.form.submit();">
                                                    <option value="" <?php if (!$other_filters['generacion'] || ($other_filters['generacion'] == 1)) echo 'selected="selected"' ?>>Todas las Generaciónes</option>
                                                    <option value="3" <?php if ($other_filters['generacion'] == 3) echo 'selected="selected"' ?>>Generación 1</option>
                                                    <option value="4" <?php if ($other_filters['generacion'] == 4) echo 'selected="selected"' ?>>Generación 2</option>
                                                    <option value="5" <?php if ($other_filters['generacion'] == 5) echo 'selected="selected"' ?>>Generación 3</option>
                                                    <option value="2" <?php if ($other_filters['generacion'] == 2) echo 'selected="selected"' ?>>Consolidado</option>
                                                </select>
                                            </th>
                                            <th style="white-space:nowrap;" title="Escriba el nombre del agente que desea buscar y selecciónelo de la lista que aparece. Puede buscar más posteriormente en la siguiente línea.">
                                                <textarea placeholder="AGENTES" id="agent-name" name="query[agent_name]" rows="1" class="input-xlarge select4" style="min-width: 250px; height: 2.2em"><?php echo $other_filters['agent_name']; ?></textarea>
                                            </th>
                                            <th>
                                                <i style="cursor: pointer; vertical-align: top" class="icon-filter submit-form" id="submit-form1" title="Filtrar"></i>
                                                <br />
                                                <i style="cursor: pointer;" class="icon-list-alt" id="clear-agent-filter" title="Mostrar todos los agentes"></i>
                                            </th>
                                            <th style="white-space:nowrap;" title="Escriba el número de póliza que desea buscar y selecciónelo de la lista que aparece. Puede buscar más posteriormente en la siguiente línea.">
                                                <textarea placeholder="PÓLIZAS" id="policy-num" name="query[policy_num]" rows="1" class="input-small select4" style="min-width: 8em; height: 2.2em"><?php echo $other_filters['policy_num']; ?></textarea>
                                            </th>
                                            <th>
                                                <i style="cursor: pointer; vertical-align: top" class="icon-filter submit-form" id="submit-form2" title="Filtrar"></i>
                                                <br />
                                                <i style="cursor: pointer;" class="icon-list-alt" id="clear-policy-filter" title="Ningun filtro por el número de póliza"></i>
	                                        </th>
                                            <th>&nbsp; </th>
                                            <th></th>
                                            <th width="50%" align="right" >
<?php if ($export_xls): ?>
                                                <a href="javascript:void(0);" id="export">
                                                <img src="<?php echo $base_url ?>ot/assets/images/down.png"></a>
<?php endif; ?>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </form>

<?php
echo $report_lines;
?>
                        </div> <!-- #main -->
                    </div> <!-- #main-container -->
                </div>  <!-- .span11 -->
            </div> <!-- .row -->
