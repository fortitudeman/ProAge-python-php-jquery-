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
if ($data):
$total_negocios = 0;
$total_primas_iniciales = 0;
?>
<table class="sortable altrowstable tablesorter" id="sorter-meta" style="width:70%;">
  <colgroup>
    <col width="10%" />
    <col width="35%" />
    <col width="15%" />
    <col width="12%" />
    <col width="28%" />
  </colgroup>
  <thead class="head">
    <tr>
      <th><?php echo $data[0]['cua'];?></th>
      <th><?php echo $data[0]['name'];?></th> 
      <th><?php echo $data[0]['generacion'];?></th>
      <th><?php echo $data[0]['negocios'];?></th>
      <th><?php echo $data[0]['primas_iniciales'];?></th>
    </tr>
  </thead>
<?php
	$count = count($data);
	if ($count > 1):
?>
  <tbody class="tbody" id="data">
<?php for ($i = 1; $i < $count; $i++):
	$total_negocios += (int)$data[$i]['negocios'];
	$total_primas_iniciales += (float)$data[$i]['primas_iniciales'];	
?>
    <tr>
      <td><?php echo $data[$i]['cua'];?></td>
      <td>
<?php if (($ramo == 1) || ($ramo == 2)) :?>
	  <a href="#" class="toggle"><?php echo $data[$i]['name'];?></a>
<?php else:
	echo $data[$i]['name'];
endif; ?>	  
	  </td>
	  <td><?php echo $data[$i]['generacion'];?></td>
      <td style="padding-right: 3em; text-align: right"><?php echo number_format($data[$i]['negocios'], 2);?></td>
      <td style="padding-right: 6em; text-align: right"><?php echo number_format($data[$i]['primas_iniciales'], 2);?></td>
    </tr>
    <tr class="tablesorter-childRow">
      <td colspan="5" style="background-color: #E0E0E0; padding-left: 1.5em">
<?php if (($ramo == 1) || ($ramo == 2)) :
		$link_meta = $base_url . 'director/meta/' . $data[$i]['id'] . '/' . $ramo . '.html';
		$link_simulator = $base_url . 'director/simulator/' . $data[$i]['id'] . '/' . $ramo . '.html';
		echo '<a href="' . $link_meta . '">Modificar meta</a> | <a href="' . $link_simulator . '">Simular ingreso</a>';
endif; ?>
	  </td>
    </tr>
<?php endfor; ?>
  </tbody>
  <tbody style="font-size: 1.2em; font-weight: bold">
	<tr>
      <td></td>
      <td>TOTALES</td> 
      <td></td>
      <td style="padding-right: 3em; text-align: right"><?php echo number_format($total_negocios, 2);?></td>
      <td style="padding-right: 6em; text-align: right"><?php echo number_format($total_primas_iniciales, 2);?></td>
	</tr>
  </tbody>
<?php endif; ?>
 </table>
 <?php endif; ?>
