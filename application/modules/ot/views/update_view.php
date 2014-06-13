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

<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo base_url() ?>">Admin</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo base_url() ?>ot.html">Orden de trabajo</a> <span class="divider">/</span>
        </li>
        <li>
            <?php echo $title ?> número <b><?php echo $data['uid'] ?></b>
        </li>
    </ul>
</div>

<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2></h2>
            <?php if (( $function == 'editar') && !isset( $message['type'] ) ): ?>
            <p style="float: right;">
			  <a style="font-weight: normal" href="javascript:void(0)" class="btn" id="view-details">Mostrar / ocultar los detalles</a>
            </p>
            <?php endif; ?>

            <div class="box-icon">
            </div>
        </div>

        <div class="box-content">
           <?php $validation = validation_errors(); ?>
            
            <?php if( !empty( $validation ) ): ?>
            <div class="alert alert-error">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong>Error: </strong> <?php echo $validation; ?>
            </div>
            <?php endif; ?>

            <?php if( isset( $message['type'] ) ): ?>
                <?php if( $message['type'] == true ): ?>
                    <div class="alert alert-success">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                          <img src="<?php echo base_url() ?>images/true.png" width="20" height="20" />
                          <strong>Listo: </strong> <?php echo $message['message']; // Show Dinamical message Success ?>
                    </div>
                <?php elseif( $message['type'] == false ): ?>
                    <div class="alert alert-error">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                          <img src="<?php echo base_url() ?>images/false.png" width="20" height="20" />
                          <strong>Error: </strong> <?php  echo $message['message']; // Show Dinamical message error ?>
                    </div>
                <?php endif; ?>
			<?php else: ?>

            <form id="form" action="<?php echo current_url() ?>" class="form-horizontal" method="post">
                <fieldset>
                  <div class="control-group">
                    <label class="control-label text-error" for="inputError">Número OT</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="ot" name="ot" type="text" value="<?php echo $data['uid'] ?>" readonly="readonly">
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label text-error" for="inputError">Fecha de tramite</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="creation_date" name="creation_date" value="<?php echo substr($data['creation_date'], 0, 10) ?>" type="text" readonly="readonly">
                    </div>
                  </div>

                  <div class="control-group *new-bussiness">
                    <label class="control-label text-error" for="inputError">Agente</label>
                    <div class="controls">
                       <select class="input-xxlarge focused required" name="agent[]" id="agent-select" readonly="readonly" multiple="multiple">
<?php
$selected_agents = array();
foreach ($data['agents'] as $value)
	$selected_agents[ $value['agent_id'] ] = sprintf("%s %s (percentaje : %s)", $value['name'], $value['lastnames'], $value['percentage']);
foreach ($agents as $key => $value) {
	if (isset($selected_agents[$key]))
		echo '<option value="' . $key . '" selected="selected">' . $selected_agents[$key] . '</option>';
	else
		echo '<option value="' . $key . '" disabled="disabled">' . $value . '</option>';
}
?>
					   
                       </select>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label text-error" for="inputError">Ramo</label>
                    <div class="controls">
<?php
$checked = array();
$display = array();
for ( $i = 1; $i < 4; $i++) {
	$checked[$i] = '';
	$display[$i] = ' style="display: none" ';
}
$checked[ $data['product_group_id'] ] = ' checked="checked" ';
$display[ $data['product_group_id'] ] = '';
?>

                      <span <?php echo $display[1] ?>><input type="radio" value="1" name="ramo" class="ramo" <?php echo $checked[1] ?> readonly="readonly" />&nbsp;&nbsp;Vida</span>
                      <span <?php echo $display[2] ?>><input type="radio" value="2" name="ramo" class="ramo" <?php echo $checked[2] ?> readonly="readonly" />&nbsp;&nbsp;GMM</span>
                      <span <?php echo $display[3] ?>><input type="radio" value="3" name="ramo" class="ramo" <?php echo $checked[3] ?> readonly="readonly" />&nbsp;&nbsp;Auto</span>
					  </div>
                  </div>

                  <div class="control-group typtramite">
                    <label class="control-label text-error" for="inputError">Tipo tramite</label>
                    <div class="controls">
                      <select class="input-xlarge focused required" id="work_order_type_id" name="work_order_type_id" readonly="readonly">
<?php foreach ($tramite_types as $value) {
	if ($value->id == $data['parent_type_name']['id'])
		echo '<option value="' . $value->id . '" selected="selected">' . $value->name . '</option>';
	else
		echo '<option value="' . $value->id . '" disabled="disabled">' . $value->name . '</option>';
} ?>

                      </select>
                    </div>
                  </div>

                  <div class="control-group subtype">
                    <label class="control-label text-error" for="inputError">Sub tipo<br /><div id="loadsubtype"></div></label>
                    <div class="controls">
                      <select class="input-xlarge focused required" id="subtype" name="subtype" readonly="readonly">
<?php foreach ($sub_types as $value) {
	if ($value->id == $data['type_id'])
		echo '<option value="' . $value->id . '" selected="selected">' . $value->name . '</option>';
	else
		echo '<option value="' . $value->id . '" disabled="disabled">' . $value->name . '</option>';
} ?>

                      </select>
                    </div>
                  </div>

                  <div class="control-group typtramite">
                    <label class="control-label text-error" for="inputError">Producto<br /><div id="loadproduct"></div></label>
                    <div class="controls">
                      <select class="input-xlarge focused required" id="product_id" name="product_id" readonly="readonly">
<?php foreach ($products_by_group as $value) {
	if ($value['id'] == $data['policy'][0]['products'][0]['id'])
		echo '<option value="' . $value['id'] . '" selected="selected">' . $value['name'] . '</option>';
	else
		echo '<option value="' . $value['id'] . '" disabled="disabled">' . $value['name'] . '</option>';
} ?>

                      </select>
                    </div>
                  </div>

                  <div class="control-group period">
                    <label class="control-label text-error" for="inputError">Plazo</label>
                    <div class="controls">
                      <select class="input-xlarge focused required" id="period" name="period" readonly="readonly">
<?php foreach ($periods as $value) {
	if ($value == $data['policy'][0]['period'])
		echo '<option value="' . $value . '" selected="selected">' . $value . '</option>';
	else
		echo '<option value="' . $value . '" disabled="disabled">' . $value . '</option>';
} ?>

                      </select>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label text-error" for="inputError">Prima anual</label>
                    <div class="controls">
                      <input <?php if ($function == 'ver') echo 'readonly="readonly"' ?> style="height: 1.7em" type="number" pattern="[0-9]+([\.][0-9]+)?" step="0.01" value="<?php echo set_value('prima', $data['policy'][0]['prima']); ?>" class="input-xlarge focused required" id="prima" name="prima" />
                      <span id="prima-error" style="display: none">Campo invalido</span>
                    </div>
                  </div>

                  <div class="control-group typtramite">
                    <label class="control-label text-error" for="inputError">Moneda</label>
                    <div class="controls">
                      <select class="input-xlarge focused required" id="currency_id" name="currency_id" readonly="readonly">
<?php foreach ($currencies as $key => $value) {
	if ($key == $data['policy'][0]['currency_id'])
		echo '<option value="' . $key . '" selected="selected">' . $value . '</option>';
	else
		echo '<option value="' . $key . '" disabled="disabled">' . $value . '</option>';
} ?>

                      </select>
                    </div>
                  </div>

                  <div class="control-group typtramite">
                    <label class="control-label text-error" for="inputError">Conducto<br /></label>
                    <div class="controls">
                      <select class="input-xlarge focused required" id="payment_method_id" name="payment_method_id" readonly="readonly">
<?php foreach ($payment_conducts as $key => $value) {
	if ($key == $data['policy'][0]['payment_method_id'])
		echo '<option value="' . $key . '" selected="selected">' . $value . '</option>';
	else
		echo '<option value="' . $key . '" disabled="disabled">' . $value . '</option>';
} ?>

                      </select>
                    </div>
                  </div>

                  <div class="control-group typtramite">
                    <label class="control-label text-error" for="inputError">Forma de pago<br /></label>
                    <div class="controls">
                      <select <?php if ($function == 'ver') echo 'readonly="readonly"' ?> class="input-xlarge focused required" id="payment_interval_id" name="payment_interval_id">
<?php
if ($function == 'editar')
	foreach ($payment_intervals as $key => $value) {
		if ($key == $data['policy'][0]['payment_interval_id'])
			echo '<option value="' . $key . '" ' . set_select('payment_interval_id', $key, TRUE) . '>' . $value . '</option>';
		else
			echo '<option value="' . $key . '" ' . set_select('payment_interval_id', $key) . '>' . $value . '</option>';
	}
else
	foreach ($payment_intervals as $key => $value) {
		if ($key == $data['policy'][0]['payment_interval_id'])
			echo '<option value="' . $key . '" selected="selected">' . $value . '</option>';
		else
			echo '<option value="' . $key . '" disabled="disabled">' . $value . '</option>';
	}
 ?>

                      </select>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label text-error" for="inputError">Nombre del asegurado / contratante</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="name" name="name" type="text" value="<?php echo $data['policy'][0]['name'] ?>" readonly="readonly">
                    </div>
                  </div> 

                  <div class="control-group">
                    <label class="control-label text-error" for="inputError">Comentarios</label>
                    <div class="controls">
                      <textarea class="input-xlarge focused required" id="comments" name="comments" rows="6" readonly="readonly"><?php echo $data['comments'] ?></textarea>
                    </div>
                  </div>

                  <div id="actions-buttons-forms" class="form-actions">
<?php if ($function == 'editar') : ?>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <input type="button" class="btn" onclick="javascript: history.back();" value="Cancelar">
<?php else: ?>
                    <input type="button" class="btn" onclick="javascript: window.close();" value="Cancelar">
<?php endif; ?>
				</div>
                </fieldset>
              </form>
			<?php endif; ?>
			
        </div>
    </div><!--/span-->

</div><!--/row-->
			