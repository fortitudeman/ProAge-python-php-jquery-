<link rel="stylesheet" href="<?php echo base_url();?>ot/assets/style/main.css">
<link href="<?php echo base_url();?>ot/assets/style/report.css" rel="stylesheet">
<script src="<?php echo base_url();?>ot/assets/scripts/report.js"></script>

<table border="0" cellspacing="0" cellpadding="0" id="popup_table">
    <thead>
        <tr id="popup_tr">
            <td style="width:100px;"><div></div></td>
            <td style="width:100px;"><div>OT</div></td>
            <td style="width:110px;"><div>Fecha de ingreso</div></td>
            <td style="width:90px;"><div>Estatus</div></td>
            <td style="width:90px;"><div>Poliza</div></td>
            <td style="width:90px;"><div>Asegurado</div></td>
            <td style="width:90px;"><div>Producto</div></td>
            <td style="width:90px;"><div>Plazo</div></td>
            <td style="width:90px;"><div>Forma de pago</div></td>
            <td style="width:90px;"><div>Conducto</div></td>
            <td style="width:90px;"><div>Moneda</div></td>
            <td style="width:90px;"><div>Prima</div></td>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach($values as $value)
            {
                ?>
                    <tr id="tr_<?php echo $value->work_order_uid;?>" class="tr_pop_class">
                        <td style="width:100px;">
                            <div>
                            <?php 
                                if($value->work_order_status_id == 6)
                                {
                                  ?>
                                        <img src="<?php echo base_url();?>ot/assets/images/bullet-black.png" width="32" height="32"/>                                
                                  <?php  
                                }
                                else
                                {
                                    ?>
                                        <img src="<?php echo base_url();?>ot/assets/images/bullet-red.png" width="32" height="32"/>
                                    <?php
                                }
                            ?>
                            </div>
                        </td>
                        <td style="width:100px;"><div><?php echo $value->work_order_uid;?></div></td>
                        <td style="width:100px;"><div><?php echo $value->creation_date;?></div></td>
                        <td style="width:100px;"><div><?php echo $value->work_order_status_name;?></div></td>
                        <td style="width:100px;"><div><?php echo $value->policies_uid;?></div></td>
                        <td style="width:100px;"><div><?php echo $value->policies_name;?></div></td>
                        <td style="width:100px;"><div><?php echo $value->products_name;?></div></td>
                        <td style="width:100px;"><div><?php echo $value->policies_period;?></div></td>
                        <td style="width:100px;"><div><?php echo $value->payment_intervals_name;?></div></td>
                        <td style="width:100px;"><div><?php echo $value->payment_methods_name;?></div></td>
                        <td style="width:100px;"><div><?php echo $value->currencies_name;?></div></td>
                        <td style="width:100px;"><div><?php echo $value->prima;?></div></td>
                    </tr>
                <?php     
            }
        ?>
    </tbody>
</table>