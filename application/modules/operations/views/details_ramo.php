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
$na_value = 'N/D';
$segments = $this->uri->rsegment_array();
$is_director = ($segments[1] == 'director');
$segments[2] = 'stat_detail_export';
?>
                  <p>
<?php if ($this->access_export_xls) :?>
                    <a href="<?php echo $base_url . implode('/', $segments); ?>.html" id="detail_detail-export-xls" title="Exportar" style="font-size: larger;">
                        <img src="<?php echo $base_url ?>ot/assets/images/down.png" title="Exportar" />
				    </a>
<?php endif; ?>
                  </p>
                  <table style="font-size: 0.8em; border-collapse: separate; border-spacing: 1em 0; text-align: center">
<?php if ($is_director):?>
                      <tr style="background-color: #F0F8FF;">
                        <td>Producto&nbsp;</td>
                        <td>Negocios&nbsp;</td>
                        <td>%&nbsp;</td>
                        <td>Primas Totales&nbsp;</td>
                        <td>%&nbsp;</td>
                        <td>Prima Promedio&nbsp;</td>
                      </tr>

<?php endif ; ?>
<?php foreach ($stats as $key => $value) :
	if ($key && $value['value']):?>
                      <tr>
                        <td><?php echo $value['label'] ?></td>
                        <td><?php echo $value['value'] ?></td>
                        <td><?php $percent = $stats[0]['value'] ? round(100 * $value['value'] / $stats[0]['value']) . '%' : $na_value; echo $percent; ?></td>
<?php if ($is_director):?>
                        <td style="text-align: right">$ <?php echo number_format($value['prima'], 2) ?></td>
                        <td><?php $percent = $stats[0]['prima'] ? round(100 * $value['prima'] / $stats[0]['prima']) . '%' : $na_value; echo $percent; ?></td>
                        <td style="text-align: right"><?php $promedio = $value['value'] ? '$ ' . number_format($value['prima'] / $value['value'], 2) : $na_value; echo $promedio; ?></td>
<?php endif ; ?>
                      </tr>
<?php endif;
endforeach;?>	
                      <tr style="background-color: yellow">
                        <td>Total</td>
                        <td><?php echo $stats[0]['value'] ?></td>
                        <td><?php $percent = $stats[0]['value'] ? '100%' : $na_value; echo $percent; ?></td>
<?php if ($is_director):?>
                        <td style="text-align: right">$ <?php echo number_format($stats[0]['prima'], 2) ?></td>
                        <td><?php $percent = $stats[0]['prima'] ? '100%' : $na_value; echo $percent; ?></td>
                        <td style="text-align: right"><?php $promedio =  $stats[0]['value'] ? '$ ' . number_format($stats[0]['prima'] / $stats[0]['value'], 2) : $na_value; echo $promedio;  ?></td>
<?php endif ; ?>
                      </tr>
                  </table>
