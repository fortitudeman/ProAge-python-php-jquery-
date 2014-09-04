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
$segments[2] = 'stat_detail_export';
?>
                  <p>
<?php if ($this->access_export_xls) :?>
                    <a href="<?php echo $base_url . implode('/', $segments); ?>.html" id="detail_detail-export-xls" title="Exportar" style="font-size: larger;">
                        <img src="<?php echo $base_url ?>ot/assets/images/down.png" title="Exportar" />
				    </a>
<?php endif; ?>
                  </p>
                  <table>
<?php foreach ($stats as $key => $value) :
	if ($key && $value['value']):?>
                      <tr>
                        <td><?php echo $value['label'] ?></td>
                        <td><?php echo $value['value'] ?></td>
                        <td><?php $percent = $stats[0]['value'] ? round(100 * $value['value'] / $stats[0]['value']) . '%' : $na_value; echo $percent; ?></td>
                      </tr>
<?php endif;
endforeach;?>	
                       <tr>
                        <td colspan="3"></td>
                      </tr>
                      <tr style="background-color: yellow">
                        <td>Total</td>
                        <td><?php echo $stats[0]['value'] ?></td>
                        <td><?php $percent = $stats[0]['value'] ? '100%' : $na_value; echo $percent; ?></td>
                      </tr>
                  </table>
