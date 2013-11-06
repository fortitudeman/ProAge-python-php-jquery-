<link rel="stylesheet" href="<?php echo base_url();?>ot/assets/style/main.css">
<script src="<?php echo base_url();?>ot/assets/scripts/report.js"></script>

<script type="text/javascript">

    function report_popupa()
    {
        //alert(wrk_ord_ids); 
        var id = $('#user_id').val();
        var poliza = $('#poliza').val();    
        $.post("ot/reporte_popupa",{wrk_ord_ids:id,is_poliza:poliza},function(data)
        { 
            //alert(data);
            if(data)
            {
                $.fancybox(data);
                return false;
            }
        });
    }

</script>

<div>
    <div style="float: left" class ="emal_popup_head">Mensaje al Director,Coordinador o Agente</div>
    <div style="float: left" class ="emal_popup_head">OT Numero  <span id="ot_numero"></span></div>
    <div style="float: left" class ="emal_popup_head">Poliza Numero  <span id="poliza_numero"></span></div>
    <br/>
    <div style="float: left" class ="emal_popup_head"><?php echo $username ?> <span id="poliza_numero"></span></div>
</div>
       

<form id="popup_email">
    <input type="hidden" name="email_address" id="email_address"/>
    <input type="hidden" name="work_order_id" id="work_ord_array"/>
    <textarea id="email_form"></textarea>
    <br/>
    
    <div>
        <div id="register_but">
            <input type="hidden" name="user_id" id="user_id"/>
            <input type="hidden" name="poliza" id="poliza"/>
            
            <a class="numeros fancybox" onclick='report_popupa()' href="javascript:void" style="text-align:center;"> <?php echo '<img src="'.base_url().'ot/assets/style/register_button.png"/>';?></a>
        </div>
        <div style="float: right;padding-right: 20px;padding-top: 15px;">            
            <input type="submit" value="" id="mail_send_button"/>
        </div>
    </div>    
</form>