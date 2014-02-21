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
                <?php  if( !empty( $data ) ): ?>
                <?php  foreach( $data as $value ):  ?>
	            <?php 
				
				$new = false;
											
				if( $value['parent_type_name']['name'] == 'NUEVO NEGOCIO' )
				
					$new = true;
				$show_menu = ( ($value['work_order_status_id'] != 2 and $value['work_order_status_id'] != 8 and $value['work_order_status_id'] != 4 and $value['work_order_status_id'] != 7) or ($value['work_order_status_id'] == 7 and $new == true) );
				?>
				<tr class="data-row-class" id="data-row-<?php echo $value['id'] ?>">
                	<td class="center"><?php 
										    
					$color = diferenciaEntreFechas( date('Y-m-d H:i:s'), $value['creation_date'], "DIAS", FALSE );
					if( $value['work_order_status_id'] == 5 or $value['work_order_status_id'] == 9 ) {
						if( (float)$color <= 5 ) 
							echo '<div style="background-color:#0C0; width: 10px;  height: 10px; border-radius: 50%; float:left; margin-top:5px;"></div>';
						else if( (float)$color > 5 and (float)$color <= 10 )	
							echo '<div style="background-color:#FF0; width: 10px;  height: 10px; border-radius: 50%; float:left; margin-top:5px;"></div>';									
						else if( (float)$color > 10 )	
							echo '<div style="background-color:#F30; width: 10px;  height: 10px; border-radius: 50%; float:left; margin-top:5px;"></div>';
					}
											
					if( $value['work_order_status_id'] == 6 )
						echo '<div style="background-color:#000; width: 10px;  height: 10px; border-radius: 50%; float:left; margin-top:5px;"></div>';
					if ($show_menu)
						echo '<a href="#" class="toggle">' . $value['uid']. '</a>';
					else
						echo $value['uid'];
					?>
                    </td>
                    <td class="center"><?php if( $value['creation_date'] != '0000-00-00 00:00:00' ) echo $value['creation_date'] ?></td>
                    <td class="center">
						<?php 
							if( !empty( $value['agents'] ) )
								foreach( $value['agents'] as $agent ) 
									
									if( !empty( $agent['company_name'] ) )
										echo $agent['company_name'] . ' '. $agent['percentage'] . '% <br>';
									else
										echo $agent['name']. ' '. $agent['lastnames']. ' '. $agent['percentage'] . '% <br>'
						?>
                    </td>
                    <td class="center"><?php echo $value['group_name'] ?></td>
                    <td class="center"><?php echo $value['parent_type_name']['name'] ?></td>
                    <td class="center"><?php echo $value['policy'][0]['name'] ?></td>
                                       
                    <td class="center" ><?php echo ucwords(str_replace( 'desactivada', 'en trámite', $value['status_name'])); ?></td>
                </tr>
                <tr id="menu-<?php echo $value['id'] ?>" <?php if ( $show_menu ) echo 'class="tablesorter-childRow"'; else echo 'style="display: none"'; ?>>
                	<td colspan="8"><?php echo $value['uid'] ?>

                    <?php
					$scrips='';
					if( $this->access_activate == true and $value['work_order_status_id'] ==  9 )
						$scrips .= '<a href="javascript:void(0)" onclick="chooseOption(\'activar-'.$value['id'].'\', \''.$new.'\')">Activar</a>&nbsp;&nbsp; |&nbsp;&nbsp;';
					else if( $this->access_activate == true and $value['work_order_status_id'] ==  6 )
						$scrips .= '<a href="javascript:void(0)" onclick="chooseOption(\'desactivar-'.$value['id'].'\', \''.$new.'\')">Desactivar</a>&nbsp;&nbsp; | &nbsp;&nbsp;';
					else 
						$scrips .= '<a href="javascript:void(0)" onclick="chooseOption(\'activar-'.$value['id'].'\', \''.$new.'\')">Activar</a>&nbsp;&nbsp; | &nbsp;&nbsp;';
					if( $this->access_update == true ){
						$scrips .= '<a href="javascript:void(0)" onclick="chooseOption(\'aceptar-'.$value['id'].'\', \''.$new.'\')">Marcar como aceptada</a>&nbsp;&nbsp; | &nbsp;&nbsp;';
						$scrips .= '<a href="javascript:void(0)" onclick="chooseOption(\'rechazar-'.$value['id'].'\', \''.$new.'\')">Marcar como rechazada</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
						if( $value['work_order_status_id'] ==  7 and $new == true)
								echo '<a href="javascript:void(0)" onclick="setPay(\''.$value['id'].'\')">Marcar como pagada</a>&nbsp;&nbsp;|&nbsp;&nbsp;';	
					}
					if( $this->access_delete == true )
						$scrips .= '<a href="javascript:void(0)" onclick="chooseOption(\'cancelar-'.$value['id'].'\', \''.$new.'\')">Cancelar</a>&nbsp;&nbsp;';
					if( $value['work_order_status_id'] != 2 and $value['work_order_status_id'] != 7 and $value['work_order_status_id'] != 8 )
					echo $scrips;
					?>
                    
                    </td>
                </tr>
                <?php endforeach;  ?> 
                <?php else: ?>
		        <tr>
                	<td colspan="7">
                        <div class="alert alert-block">
                              <button type="button" class="close" data-dismiss="alert">×</button>
                              <strong>Atención: </strong> No se encontrarón registros, agregar uno <a href="<?php echo base_url() ?>ot/create.html" class="btn btn-link">Aquí</a>
                        </div>
                	</td>
                </tr>
                                
              <?php endif; ?>               
