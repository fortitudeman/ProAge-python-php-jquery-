<?php
$base_url = base_url();
?>

<link rel="stylesheet" href="<?php echo $base_url;?>ot/assets/style/main.css">
<link href="<?php echo $base_url;?>ot/assets/style/report.css" rel="stylesheet">
<script src="<?php echo $base_url;?>ot/assets/scripts/report.js"></script>
<script type="text/javascript">
	$( document ).ready(function() {

		$(".show-hide-due").bind( "click", function(){
			$(this).siblings().not('.detailed_dates').toggle();
			return false;
		});
	});
</script>

<style type="text/css">
	.payment_table th { width: 100px;}
	.payment_table td { padding: 0; margin: 0}

</style>

<?php if ($values):
$policies = array();
$posted = $this->input->post('for_agent_id');
foreach ($values as $key => $value)
{
	if ($posted == $key)
	{
		$policies = $value['policy_uid'];
		break;
	}
}
$payment_interval_translate = array(
	1 => 'Mensual',
	2 => 'Trimestrial',
	3 => 'Semestrial',
	4 => 'Anual');
$semaphores = array(
	'green' =>
'<div style="background-color:#0C0; width: 10px;  height: 10px; border-radius: 50%; float:left; margin-top:5px;"></div>',
	'yellow' =>
'<div style="background-color:#FF0; width: 10px;  height: 10px; border-radius: 50%; float:left; margin-top:5px;"></div>',
	'red' =>
'<div style="background-color:#F30; width: 10px;  height: 10px; border-radius: 50%; float:left; margin-top:5px;"></div>',
);
?>
<table class="altrowstable payment_table">
    <thead>
        <tr id="popup_tr">
            <th style="width: 20px"></th>
            <th>Poliza</th>
            <th style="text-align: right; padding-right: 3em">Cobranza instalada</th>
            <th>Producto</th>
            <th style="width: 220px">Asegurado</th>
            <th style="width: 150px">Forma de pago</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($policies as $key => $value):
	$relative_paid = (int)(($value['paid'] / $value['prima_due_past']) * 100);
	if ($relative_paid > 99)
		$semaphore = $semaphores['green'];
	elseif ($relative_paid > 90)
		$semaphore = $semaphores['yellow'];
	else
		$semaphore = $semaphores['red'];
		$policy_cobranza = $value['prima_due_future'] + $value['prima_due_past'] - $value['paid'];
?>
        <tr class="payment_row" >
            <td><?php echo $semaphore ?></td>
            <td><?php echo $key ?></td>
			<td style="text-align: right; padding-right: 2.5em">$ <?php echo number_format($policy_cobranza , 2); ?></td>
            <td><?php echo $value['product_name']; ?></td>
            <td><?php if ($value['asegurado']) echo $value['asegurado'] ; else echo 'No disponible'; ?></td>
            <td>
<?php
if (isset($payment_interval_translate[$value['payment_interval_id']]))
	echo '<a href="javascript: void(0);" class="show-hide-due">' . $payment_interval_translate[$value['payment_interval_id']] . '</a>';
else echo '-';
echo '<span style="display: none"> ($&nbsp;' . number_format($value['adjusted_prima'], 2) . ')</span>';
$past_due_dates_arr = explode('|', $value['due_dates_past']);
$future_due_dates_arr = explode('|', $value['due_dates_future']);
$paid_v = (int)$value['paid'];
$adjusted_prima = (int)$value['adjusted_prima'];
?>
				<ul class="detailed_dates" style="display: none">
<?php foreach($past_due_dates_arr as $date_value) :
if ($date_value) :
	if ($paid_v >= $adjusted_prima)
		$style = 'style="color: #0C0"';
	else
		$style = 'style="color: #F30"';
	$paid_v = $paid_v - $adjusted_prima;
?>
					<li <?php echo $style; ?>><?php echo $date_value ?></li>
<?php endif; ?>
<?php endforeach; ?>
<?php foreach($future_due_dates_arr as $date_value) :
if ($date_value) :
	if ($paid_v >= $adjusted_prima)
		$style = 'style="color: #0C0"';
	else
		$style = 'style="color: #F30"';
	$paid_v = $paid_v - $adjusted_prima;
?>
					<li <?php echo $style; ?>><?php echo $date_value ?></li>
<?php endif; ?>
<?php endforeach; ?>
				</ul>
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
