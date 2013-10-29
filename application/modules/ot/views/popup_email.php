<link rel="stylesheet" href="<?php echo base_url();?>ot/assets/style/main.css">
<script src="<?php echo base_url();?>ot/assets/scripts/report.js"></script>
<div>
    <div style="float: left" class ="emal_popup_head">Mensaje al Director,Coordinador o Agente</div>
    <div style="float: left" class ="emal_popup_head">OT Numero  <span id="ot_numero"></span></div>
    <div style="float: left" class ="emal_popup_head">Poliza Numero  <span id="poliza_numero"></span></div>
</div>
       

<form id="popup_email">
    <input type="hidden" name="email_address" id="email_address"/>
    <input type="hidden" name="work_order_id" id="work_ord_array"/>
    <textarea id="email_form"></textarea>
    <br/>
    <input type="submit" value="Enviar"/>
</form>