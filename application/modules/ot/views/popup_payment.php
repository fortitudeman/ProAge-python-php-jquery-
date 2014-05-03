<link rel="stylesheet" href="<?php echo base_url();?>ot/assets/style/main.css">
<link href="<?php echo base_url();?>ot/assets/style/report.css" rel="stylesheet">
<script src="<?php echo base_url();?>ot/assets/scripts/report.js"></script>
<style type="text/css">
	.payment_table th { width: 150px;}
	.payment_table td { padding: 0; margin: 0}
</style>

<?php if ($values):
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
&nbsp;&nbsp;<img class="payment_delete action_option" alt="Borrar" title="Borrar" src="' . $base_url . 'images/payment_delete.jpg" />';
}
$ignore_image = '
<img class="mark_ignored action_option" alt="Ignorar" title="Ignorar" src="' . $base_url . 'images/payment_ignore.jpg" />';

?>
<table class="altrowstable payment_table">
    <thead>
        <tr id="popup_tr">
            <th>Fecha de pago</th>
            <th>Poliza</th>
            <th>Asegurado</th>
            <th style="text-align: right; padding-right: 3em">Prima (en $)</th>
            <th style="text-align: right; padding-right: 9.5em">Negocio</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($values as $value): ?>
        <tr class="payment_row" >
            <td><?php echo $value->payment_date ?></td>
            <td><?php echo $value->policy_number ?></td>
            <td><?php echo $value->asegurado ? $value->asegurado : 'No disponible'?></td>
			<td style="text-align: right; padding-right: 2.5em"><?php echo number_format($value->amount, 2);?></td>
			<td style="padding-right: 2.5em">
<span style="padding-left: 10em; padding-right: 3em; text-align: right;"><?php echo $value->business;?></span>
<?php
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
