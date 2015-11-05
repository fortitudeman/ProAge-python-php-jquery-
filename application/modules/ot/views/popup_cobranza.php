<?php
$base_url = base_url();
?>

<link rel="stylesheet" href="<?php echo $base_url;?>ot/assets/style/main.css">
<link href="<?php echo $base_url;?>ot/assets/style/report.css" rel="stylesheet">
<script src="<?php echo $base_url;?>ot/assets/scripts/report.js"></script>
<style type="text/css">
	.payment_table th { width: 100px;}
	.payment_table td { padding: 0; margin: 0}

</style>

<?php if ($values):
foreach ($values as $key => $value)
{
	$policies = $value['policy_uid'];
	break;
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
            <th>Forma de pago</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($policies as $key => $value):
	$relative_paid = (int)(($value['paid'] / $value['prima_due']) * 100);
	if ($relative_paid > 99)
		$semaphore = $semaphores['green'];
	elseif ($relative_paid > 90)
		$semaphore = $semaphores['yellow'];
	else
		$semaphore = $semaphores['red'];
?>
        <tr class="payment_row" >
            <td><?php echo $semaphore ?></td>
            <td><?php echo $key ?></td>
			<td style="text-align: right; padding-right: 2.5em"><?php echo number_format(($value['prima_due'] - $value['paid']) , 2); ?></td>
            <td><?php echo $value['product_name']; ?></td>
            <td><?php if ($value['asegurado']) echo $value['asegurado'] ; else echo 'No disponible'; ?></td>
            <td>
<?php
if (isset($payment_interval_translate[$value['payment_interval_id']]))
	echo $payment_interval_translate[$value['payment_interval_id']];
else echo '-';
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
