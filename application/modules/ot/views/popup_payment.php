<link rel="stylesheet" href="<?php echo base_url();?>ot/assets/style/main.css">
<link href="<?php echo base_url();?>ot/assets/style/report.css" rel="stylesheet">
<script src="<?php echo base_url();?>ot/assets/scripts/report.js"></script>
<style type="text/css">
	.payment_table th { width: 150px;}
	.payment_table td { padding: 0; margin: 0}
</style>

<?php if ($values): ?>
<table class="altrowstable payment_table">
    <thead>
        <tr id="popup_tr">
            <th>Fecha de pago</th>
            <th>Poliza</th>
            <th style="text-align: right; padding-right: 3em">Prima (en $)</th>
            <th style="text-align: right; padding-right: 3em">Negocio</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($values as $value): ?>
        <tr>
            <td><?php echo $value->payment_date ?></td>
            <td><?php echo $value->policy_number ?></td>
			<td style="text-align: right; padding-right: 2.5em"><?php echo number_format($value->amount, 2);?></td>
			<td style="text-align: right; padding-right: 2.5em"><?php echo $value->business;?></td>
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
