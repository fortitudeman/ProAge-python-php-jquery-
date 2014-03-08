<link rel="stylesheet" href="<?php echo base_url();?>ot/assets/style/main.css">
<link href="<?php echo base_url();?>ot/assets/style/report.css" rel="stylesheet">
<script src="<?php echo base_url();?>ot/assets/scripts/report.js"></script>
<style type="text/css">
	.payment_table th { width: 150px;}
	.payment_table td { padding: 0; margin: 0}
</style>

<table class="altrowstable payment_table">
    <thead>
        <tr id="popup_tr">
            <th>Fecha de pago</th>
            <th>Poliza</th>
            <th style="text-align: right; padding-right: 3em">Prima</th>
        </tr>
    </thead>
    <tbody>
<?php 
if ($values)
{
	foreach ($values as $value)
	{   
?>
        <tr>
            <td><?php echo $value->payment_date ?></td>
            <td><?php echo $value->policy_number ?></td>
			<td style="text-align: right; padding-right: 2.5em">$<?php echo number_format($value->amount);?></td>
        </tr>
<?php     
	}
}
else
{
	echo '<tr><td colspan="3">No datos</td></tr>';
}
?>
    </tbody>
</table>
