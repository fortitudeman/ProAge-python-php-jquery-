<?php
$base_url = base_url();
?>
<link rel="stylesheet" href="<?php echo base_url();?>ot/assets/style/main.css">
<link href="<?php echo base_url();?>ot/assets/style/report.css" rel="stylesheet">

<script type="text/javascript">
	var currentModule = "";
<?php
	$segments = $this->uri->rsegment_array();
	if (isset($segments[1]))
		echo 'var currentModule = "' . $segments[1] . '";';

?>
</script>
<script type="text/javascript" src="<?php echo base_url();?>ot/assets/scripts/report.js"></script>
<style type="text/css">
	.payment_table th { width: 150px;}
	.payment_table td { padding: 0; margin: 0}
	.add-perc-show, add-perc-ok, .add-perc-show:hover, add-perc-ok:hover {text-decoration: none;}
</style>

<?php if ($values):
$is_cartera = ($this->input->post('type') === 'cartera');

$is_negocio_pai = !empty($values[0]->negocio_pai);
$base_url = base_url();
$additional_form_fields = '';
if (($for_agent_id = $this->input->post('for_agent_id')) !== FALSE)
	$additional_form_fields .= '
<input type="hidden" name="for_agent_id" value="' . $for_agent_id . '" />';
if (($type = $this->input->post('type')) !== FALSE)
	$additional_form_fields .= '
<input type="hidden" name="type" value="' .  $type . '" />';
$query = $this->input->post('query');
if (($query !== FALSE) && is_array($query))
{
	foreach ($query as $key => $value)
		$additional_form_fields .= '
<input type="hidden" name="query[' . $key . ']" value="' .  $value . '" />';
}
$delete_image = '';
if ( $access_delete )
{
	$delete_image = '
&nbsp;&nbsp;<img style="cursor: pointer" class="payment_delete action_option" alt="Borrar" title="Borrar" src="' . $base_url . 'images/payment_delete.jpg" />';
}
$ignore_image = '
<img style="cursor: pointer" class="mark_ignored action_option" alt="Ignorar" title="Ignorar" src="' . $base_url . 'images/payment_ignore.jpg" />';
?>
<div id="wait-response" style="display: none; text-align: center">Espere usted un momento, por favor...</div>
<table class="altrowstable payment_table" id="payment-table">
    <thead>
        <tr id="popup_tr">
            <?php if ($for_agent_id === FALSE) : ?><th width="200px">Agente</th><?php endif; ?>
            <th>
                <?php if ($is_negocio_pai): ?>
                    Fecha PAI
                <?php else: ?>
                    Fecha de pago
                <?php endif ?>
            </th>
            <th>Poliza</th>
<?php if ($is_negocio_pai): ?>
            <th>Negocio PAI</th>
<?php endif ?>
            <th>Asegurado</th>

            <th>Producto</th>
            <th>Plazo</th>

            <th>Agente importado</th>
            <th>Folio importado</th>
<?php if ($is_cartera): ?>
            <th>Año</th>
<?php endif ?>
            <th style="text-align: right; padding-right: 3em">Prima (en $)</th>
            <th style="text-align: right; padding-right: 3em">% para pago de bono (en %)</th>
            <th style="text-align: right; padding-right: 7em">Negocio</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($values as $value): ?>
        <tr class="payment_row" >
<?php if ($for_agent_id === FALSE) : ?>
            <td>
<?php
	if (!$value->first_name && !$value->last_name)
		echo $value->company_name;
	else
		echo $value->first_name . ' ' . $value->last_name;
?>
			
            </td>
<?php endif; ?>
            <td>
                <?php if ($is_negocio_pai)
                        echo $value->date_pai; 
                    else
                        echo $value->payment_date;
                ?>
                    
            </td>
            <td>
                <?php if($value->work_order_uid):?>
                    <?php $ot_url= $base_url."/ot/ver_ot/".$value->work_order_uid.".html"?>
                    <a href="<?php echo $ot_url ?>" class="payment_row" target="_blank"><?php echo $value->policy_number ?></a>
                <?php else:?>
                    <?php echo $value->policy_number ?>
                <?php endif?>
            </td>
<?php if ($is_negocio_pai): ?>
            <td>
<form class="negocio_pai_field">
<select class="span1" name="negocio_pai[<?php echo $value->policy_number ?>]">
<option value="1" <?php if ($value->negocio_pai == 1) echo 'selected="selected"'; ?>>1</option>
<option value="2" <?php if ($value->negocio_pai == 2) echo 'selected="selected"'; ?>>2</option>
<option value="3" <?php if ($value->negocio_pai == 3) echo 'selected="selected"'; ?>>3</option>
</select>
</form>
			</td>
<?php endif ?>
            <td><?php echo $value->asegurado ? $value->asegurado : 'No disponible'?></td>

            <td><?php echo $value->product_name ? $value->product_name : 'No disponible'?></td>
            <td><?php echo $value->plazo ? $value->plazo : 'No disponible'?></td>

            <td><?php echo $value->imported_agent_name ? $value->imported_agent_name : 'No disponible'?></td>
            <td><?php echo $value->imported_folio ? $value->imported_folio : 'No disponible'?></td>

<?php if ($is_cartera): ?>
            <td style="text-align: right; padding-right: 2.5em"><?php echo $value->year_prime ?></td>
<?php endif ?>

			<td class="prima-value" style="text-align: right; padding-right: 2.5em"><?php echo number_format($value->amount * (1 + ($value->add_perc / 100)), 2);?></td>
			<td style="text-align: right; padding-right: 2.5em">
<span style="display: none" class="ori-prima"><?php echo $value->amount; ?></span>
<span class="add-perc-display"><?php echo 100 + $value->add_perc;?></span>
&nbsp;
<a href="javascript: void(0);" class="add-perc-show"><i class="icon-edit" title="Editar"></i></a>
<form class="add-perc-edit" style="display: inline; white-space: nowrap;">
<input class="form-control input-sm perc-value" max="999" step="1" type="number" maxlength="3" style="font-size: 1em; width: 3.5em;" value="<?php echo 100 + $value->add_perc;?>">
<a href="javascript: void(0);" class="add-perc-ok"><i class="icon-ok" title="OK"></i></a>

<input class="add_perc_real" name="add_perc[<?php echo $value->pay_tbl_id ?>]" class="form-control input-sm" max="999" step="1" type="hidden" maxlength="3" style="font-size: 1em; width: 3.5em;" value="<?php echo $value->add_perc;?>">

</form>
			</td>
			<td style="width: 110px; text-align: right; padding-right: 2.5em">
<span style="padding-left: 2.5em; padding-right: 1.5em; text-align: right;"><?php echo $value->business;?></span>
<?php
if ($is_negocio_pai):
	echo "&nbsp;&nbsp;&nbsp;&nbsp;";
else:
if ( $access_update && $value->valid_for_report ) :
	echo $ignore_image;
endif;
echo $delete_image;
?>
<form class="payment_detail_form" method="post" action="#">
<input type="hidden" name="amount" value="<?php echo $value->amount ?>" />
<input type="hidden" name="payment_date" value="<?php echo $value->payment_date ?>" />
<input type="hidden" name="policy_number" value="<?php echo $value->policy_number ?>" />
<input type="hidden" class="payment_action" name="payment_action" value="" />
<?php
echo $additional_form_fields;
?>
</form>
<?php
endif;
?>
			</td>
        </tr>
<?php endforeach; ?>
    </tbody>
</table>

<?php else: ?>
	No hay datos.
<?php endif; ?>
<?php
// To make sure UTF8 w/o BOM ùà
?>
