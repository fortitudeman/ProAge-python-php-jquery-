<link rel="stylesheet" href="<?php echo base_url();?>ot/assets/style/main.css">
<link href="<?php echo base_url();?>ot/assets/style/report.css" rel="stylesheet">
<script src="<?php echo base_url();?>ot/assets/scripts/report.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>ot/assets/scripts/jquery.tablesorter.js"></script>

<style type="text/css">
    .bullet_red{background-color: #FF3300; border-radius: 50% 50% 50% 50%; float: left;height: 10px; margin-left: 20px; margin-top: -13px;position: absolute;width: 10px;}
    .bullet_yellow{background-color: yellow; border-radius: 50% 50% 50% 50%; float: left;height: 10px; margin-left: 20px; margin-top: -13px;position: absolute;width: 10px;}
    .bullet_green{background-color: green; border-radius: 50% 50% 50% 50%; float: left;height: 10px; margin-left: 20px; margin-top: -13px;position: absolute;width: 10px;}
    .bullet_black{background-color: black; border-radius: 50% 50% 50% 50%; float: left;height: 10px; margin-left: 20px; margin-top: -13px;position: absolute;width: 10px;}
    
</style>
<table border="0" cellspacing="0" cellpadding="0" class="sortable altrowstable tablesorter" id="popup_table">
    <thead>
        <tr id="popup_tr">
            <th style="width:80px;"><div></div></th>
            <th style="width:100px;"><div>OT</div></th>
            <th style="width:110px;"><div>Fecha de ingreso</div></th>
            <th style="width:90px;"><div>Estatus</div></th>
            <?php if($is_poliza == 'yes'){ ?>
            <th style="width:90px;"><div>Poliza</div></th>
            <?php } ?>
            <th style="width:90px;"><div>Asegurado</div></th>
            <th style="width:90px;"><div>Producto</div></th>
    <?php if($gmm !== '2') { ?>
            <th style="width:90px;"><div>Plazo</div></th>
    <?php } ?>
            <th style="width:90px;"><div>Forma de pago</div></th>
            <th style="width:90px;"><div>Conducto</div></th>
            <th style="width:90px;"><div>Moneda</div></th>
            <th style="width:90px;"><div>Prima</div></th>
        </tr>
    </thead>
    <tbody>
        <?php 
         if($values)
         {
            foreach($values as $value)
            {   
                ?>
                    <tr id="tr_<?php echo $value['general'][0]->work_order_uid;?>" class="tr_pop_class">
                        <td style="width:80px;">
                            <div>
                                <?php       
                                    if($value['general'][0]->comments)
                                    {
                                        echo '<img src="'.base_url().'ot/assets/images/comment.png" title="'.$value['general'][0]->comments.'" width="12" height="12"/>';
                                    }
                                
                                    if($value['general'][0]->work_order_status_id == 9 || $value['general'][0]->work_order_status_id == 5)
                                    {
                                        $result =  abs(strtotime($value['general'][0]->creation_date) - strtotime(date("Y-m-d H:i:s")));                                
                                        $date_diff =  floor($result/(60*60*24));

                                        if($date_diff>$value['general'][0]->duration)
                                        {
                                            echo '<div class="bullet_red"></div>';
                                        }  

                                        if($date_diff>($value['general'][0]->duration)/2 && $date_diff <= $value['general'][0]->duration)
                                        {
                                             echo '<div class="bullet_yellow"></div>'; 
                                        }

                                        if($date_diff <= ($value['general'][0]->duration)/2)
                                        {
                                            echo '<img src="'.base_url().'ot/assets/images/bullet-green.png" width="32" height="32"/>';
                                        } 
                                    } 

                                    if($value['general'][0]->work_order_status_id == 6)
                                    {
                                    ?>
                                            <img src="<?php echo base_url();?>ot/assets/images/bullet-black.png" width="32" height="32"/>                                
                                    <?php  
                                    }                                                     
                                ?>
                            </div>
                        </td>
                        <td style="width:100px;"><div><?php echo $value['general'][0]->work_order_uid;?></div></td>
                        <td style="width:110px;"><div><?php echo $value['general'][0]->creation_date;?></div></td>
                        <td style="width:90px;"><div><?php echo $value['general'][0]->work_order_status_name;?></div></td>
                        <td style="width:90px;"><div><?php echo $value['general'][0]->policies_uid;?></div></td>
                        <?php if($is_poliza == 'yes'){ ?>
                        <td style="width:90px;"><div><?php echo $value['general'][0]->policies_name;?></div></td>
                        <?php }?>
                        <td style="width:90px;"><div><?php echo $value['general'][0]->products_name;?></div></td>
                        <td style="width:90px;"><div><?php echo $value['general'][0]->policies_period;?></div></td>
                         <?php if($gmm !== '2') { ?>
                        <td style="width:90px;"><div><?php echo $value['general'][0]->payment_intervals_name;?></div></td>
                        <?php } ?>
                        <td style="width:90px;"><div><?php echo $value['general'][0]->payment_methods_name;?></div></td>
                        <td style="width:90px;"><div><?php echo $value['general'][0]->currencies_name;?></div></td>
                        <td style="width:90px;"><div><?php echo $value['general'][0]->prima;?></div></td>
                    </tr>
                    <tr style="display: none;" id="hide_<?php echo $value['general'][0]->work_order_uid;?>">
                        <td></td>
                        <td colspan="11" >
                            <div style="display: none;">
                                <span id="poliza_number"><?php echo $value['general'][0]->policies_uid;?></span>
                                <span id="ot_number"><?php echo $value['general'][0]->work_order_uid;?></span>
                                <span class="wrk_ord_ids" id="<?php echo $value['general'][0]->work_order_id;?>"></span>
                                <span class="poliza"><?php echo $is_poliza;?></span>
                                <span class="gmm"><?php echo $gmm;?></span>
                            </div>
                            
                            <a href="javascript:" class="btn btn-link btn-hide">
                                <i class="icon-arrow-up" id="<?php echo $value['general'][0]->work_order_uid;?>"></i>
                            </a>
                            <?php if($value['general'][0]->user != 0){?><a id="<?php echo $value['general'][0]->email; ?>" href="email_popup" class="btn btn-link send_message">Enviar mensaje al cordinador</a>|<?php }?>
                            <a id="<?php echo $value['general'][0]->agent_user_email; ?>" href="email_popup" class="btn btn-link send_message">Enviar mensaje al Agente</a>|                            
                            <a id ="<?php foreach($value['director'] as $demals){echo $demals->email.',';};?>" href="email_popup" class="btn btn-link send_message">Enviar mensaje al Director</a>                            
                        </td>
                    </tr>
                <?php     
            }
         }
         else
         {
             echo '<tr><td colspan="12">There is no data</td></tr>';
         }
        ?>
    </tbody>
</table>