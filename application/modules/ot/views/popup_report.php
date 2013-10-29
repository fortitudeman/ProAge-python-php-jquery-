<link rel="stylesheet" href="<?php echo base_url();?>ot/assets/style/main.css">
<link href="<?php echo base_url();?>ot/assets/style/report.css" rel="stylesheet">
<script src="<?php echo base_url();?>ot/assets/scripts/report.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>ot/assets/scripts/jquery.tablesorter.js"></script>

<table border="0" cellspacing="0" cellpadding="0" class="sortable altrowstable tablesorter" id="popup_table">
    <thead>
        <tr id="popup_tr">
            <th style="width:80px;"><div></div></th>
            <th style="width:100px;"><div>OT</div></th>
            <th style="width:110px;"><div>Fecha de ingreso</div></th>
            <th style="width:90px;"><div>Estatus</div></th>
            <th style="width:90px;"><div>Poliza</div></th>
            <th style="width:90px;"><div>Asegurado</div></th>
            <th style="width:90px;"><div>Producto</div></th>
            <th style="width:90px;"><div>Plazo</div></th>
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
            foreach($values[0]['general'] as $key=>$value)
            {
                //echo $value->work_order_uid;
                
                
                ?>
                    <tr id="tr_<?php echo $value->work_order_uid;?>" class="tr_pop_class">
                        <td style="width:80px;">
                            <div>
                                <?php       
                                    if($value->work_order_status_id == 9 || $value->work_order_status_id == 5)
                                    {
                                        $result =  abs(strtotime($value->creation_date) - strtotime(date("Y-m-d H:i:s")));                                
                                        $date_diff =  floor($result/(60*60*24));

                                        if($date_diff>$value->duration)
                                        {
                                            echo '<img src="'.base_url().'ot/assets/images/bullet-red.png" width="32" height="32"/>';
                                        }  

                                        if($date_diff>($value->duration)/2 && $date_diff <= $value->duration)
                                        {
                                            echo '<img src="'.base_url().'ot/assets/images/bullet-yellow.png" width="32" height="32"/>';
                                        }

                                        if($date_diff <= ($value->duration)/2)
                                        {
                                            echo '<img src="'.base_url().'ot/assets/images/bullet-green.png" width="32" height="32"/>';
                                        } 
                                    } 

                                    if($value->work_order_status_id == 6)
                                    {
                                    ?>
                                            <img src="<?php echo base_url();?>ot/assets/images/bullet-black.png" width="32" height="32"/>                                
                                    <?php  
                                    }                                                        

                                ?>
                            </div>
                        </td>
                        <td style="width:100px;"><div><?php echo $value->work_order_uid;?></div></td>
                        <td style="width:110px;"><div><?php echo $value->creation_date;?></div></td>
                        <td style="width:90px;"><div><?php echo $value->work_order_status_name;?></div></td>
                        <td style="width:90px;"><div><?php echo $value->policies_uid;?></div></td>
                        <td style="width:90px;"><div><?php echo $value->policies_name;?></div></td>
                        <td style="width:90px;"><div><?php echo $value->products_name;?></div></td>
                        <td style="width:90px;"><div><?php echo $value->policies_period;?></div></td>
                        <td style="width:90px;"><div><?php echo $value->payment_intervals_name;?></div></td>
                        <td style="width:90px;"><div><?php echo $value->payment_methods_name;?></div></td>
                        <td style="width:90px;"><div><?php echo $value->currencies_name;?></div></td>
                        <td style="width:90px;"><div><?php echo $value->prima;?></div></td>
                    </tr>
                    <tr style="display: none;" id="hide_<?php echo $value->work_order_uid;?>">
                        <td></td>
                        <td colspan="11" >
                            <div style="display: none;">
                                <span id="poliza_number"><?php echo $value->policies_uid;?></span>
                                <span id="ot_number"><?php echo $value->work_order_uid;?></span>
                                <span class="wrk_ord_ids" id="<?php echo $value->work_order_id;?>"></span>
                            </div>
                            
                            <a href="javascript:" class="btn btn-link btn-hide">
                                <i class="icon-arrow-up" id="<?php echo $value->work_order_uid;?>"></i>
                            </a>
                            <?php if($value->user != 0){?><a id="<?php echo $value->email; ?>" href="email_popup" class="btn btn-link send_message">Enviar mensaje al cordinador</a>|<?php }?>
                            <a id="<?php echo $value->agent_user_email; ?>" href="email_popup" class="btn btn-link send_message">Enviar mensaje al Agenta</a>|
                            
                            <a id ="<?php foreach($values[0]['director'] as $demals){echo $demals->email.',';}?>" href="email_popup" class="btn btn-link send_message">Enviar mensaje al Director</a>                            
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