<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailer{
		
	var $mail;
 
    public function __construct()
    {
        require_once('PHPMailer/class.phpmailer.php');
 
        // the true param means it will throw exceptions on errors, which we need to catch
        $this->mail = new PHPMailer(true);
 
        $this->mail->IsSMTP(); // telling the class to use SMTP
 	    $this->mail->SMTPDebug  = 0;                     // enables SMTP debug information
        $this->mail->SMTPAuth   = false;                  // enable SMTP authentication
        $this->mail->CharSet = "utf-8";                  // 一定要設定 CharSet 才能正確處理中文
        $this->mail->SMTPDebug  = 0;                     // enables SMTP debug information
        // $this->mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
        // $this->mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
        // $this->mail->Port       = 465;                   // set the SMTP port for the GMAIL server
        $this->mail->AddReplyTo('info+proages@isinet.mx', 'Isinet');
        $this->mail->SetFrom('info+proages@isinet.mx', 'Isinet');
    }
 
 
// Send Notifications emails 
    public function notifications( $notification = array(), $razon = null, $responsable = null ){
        
		if( empty( $notification ) ) return false;
						
		$agentes = '';
		
		if( !empty( $notification[0]['agents'] ) ){
			foreach( $notification[0]['agents'] as $value ){
				if( !empty( $value['company_name'] ) )
					$agentes .=  $value['company_name'];
				else
					$agentes .=  $value['name'];	
		
		$status_name = '';
		
		if( $notification[0]['status_name'] == 'creada' )
			$status_name = 'Creación';
		if( $notification[0]['status_name'] == 'activada' )
			$status_name = 'Activación';
		if( $notification[0]['status_name'] == 'desactivada' )
			$status_name = 'Desactivación';
		if( $notification[0]['status_name'] == 'cancelada' )
			$status_name = 'Cancelación';
		if( $notification[0]['status_name'] == 'aceptada' )
			$status_name = 'Aceptación';
		if( $notification[0]['status_name'] == 'rechazada' )
			$status_name = 'Rechazo';					
		
		$body = '<div bgcolor="#f4f4f4">
					 <table width="650" cellspacing="0" cellpadding="0" border="0" align="center"><tbody><tr><td height="3"><img width="650" height="3" style="display:block" src="http://serviciosisinet.com/img/top.jpg"></td></tr></tbody></table>
					
					
					
					 <table width="650" cellspacing="0" cellpadding="0" border="0" align="center" style="border-left-width:1px;border-left-style:solid;border-left-color:rgb(197,197,197);border-right-width:1px;border-right-style:solid;border-right-color:rgb(197,197,197)"><tbody><tr><td bgcolor="#FFFFFF" align="center" height="50" style="line-height:29px"><span style="font-size:22px"><b><font color="#ff2600">
					
					'.$status_name.'</font></b></span><span style="color:rgb(25,25,25);font-family:Helvetica,arial,sans-serif;font-size:22px;font-weight:bold"> de la Orden de Trabajo '.$notification[0]['uid'].'</span></td></tr></tbody></table>
					
					
					 <table width="650" cellspacing="0" cellpadding="0" border="0" align="center" style="border-left:1px solid #c5c5c5;border-right:1px solid #c5c5c5"><tbody><tr><td bgcolor="#FFFFFF" height="20" valign="top"><img width="648" height="1" style="display:block" src="http://serviciosisinet.com/img/divider.jpg"></td>
					
					</tr></tbody></table>
					
					 <table width="650" cellspacing="0" cellpadding="0" border="0" align="center" style="border-left-width:1px;border-left-style:solid;border-left-color:rgb(197,197,197);border-right-width:1px;border-right-style:solid;border-right-color:rgb(197,197,197)">
					<tbody>
					  <tr>
						<td bgcolor="#FFFFFF" width="30">&nbsp;</td>
						<td bgcolor="#FFFFFF" align="left" style="font-family:Helvetica,arial,sans-serif;font-size:14px;line-height:15px">
							<p style="color:rgb(79,79,79)">'.$agentes.'</p>
							<p><font color="#4f4f4f">Le notificamos que la solicitud con la Orden de trabajo  '.$notification[0]['uid'].' fue </font><font color="#0433ff">'.$notification[0]['status_name'].'</font><font color="#4f4f4f">.</font></p>
							<p><font color="#008f00"><b>Razón</b>: '.$razon.'</font></p>
							<p><font color="#008f00"><b>Responsable</b>: '.$responsable.'</font></p><div><font color="#008f00"><b>Comentarios</b>: '.$notification[0]['comments'].'</font></div><div style="color:rgb(79,79,79)"><br></div>
							 <table width="80%" align="center" style="color:rgb(79,79,79)">
								  <tbody><tr>
									  <td colspan="2" align="center"><p><b>Detalles de la Orden de Trabajo</b></p>
									  </td>
								  </tr>
								  <tr>
									  <td width="30%"><b>Orden de Trabajo:</b></td>
									  <td width="70%"> '.$notification[0]['uid'].'</td>    
								  </tr>
								  <tr>
									  <td><b>Fecha de tramite:</b><br><small>(año-mes-dia)</small></td>
									  <td> '.date( 'Y-m-d', strtotime($notification[0]['creation_date'] ) ).'</td>
								  </tr>
								  <tr>
									  <td><b>Asegurado:</b></td>
									  <td> '.$notification[0]['policy'][0]['name'].'</td>    
								  </tr>
								  <tr>
									  <td><b>Ramo:</b></td>
									  <td>'.$notification[0]['group_name'].'</td>    
								  </tr>
								  <tr>
									  <td><b>Producto:</b></td>
									  <td>'.$notification[0]['policy'][0]['products'][0]['name'].'</td>    
								  </tr>
								  <tr>
									  <td><b>Prima:</b></td>
									  <td>'.$notification[0]['policy'][0]['prima'].'</td>    
								  </tr>
								  <tr>
									  <td><b>Forma de Pago:</b></td>
									  <td>'.$notification[0]['policy'][0]['payment_intervals_name'].'</td>    
								  </tr>
								  <tr>
									  <td><b>Conducto:</b></td>
									  <td>'.$notification[0]['policy'][0]['payment_method_name'].'</td>    
								  </tr>
							 </tbody></table>
					
						</td>
						<td bgcolor="#FFFFFF" width="30">&nbsp;</td>
					</tr>
					</tbody></table>
					
					
					 <table width="650" cellspacing="0" cellpadding="0" border="0" align="center" style="border-left:1px solid #c5c5c5;border-right:1px solid #c5c5c5"><tbody><tr> <td bgcolor="#FFFFFF" height="20" valign="top">&nbsp;</td></tr></tbody></table>
					
					
					
					 <table width="650" cellspacing="0" cellpadding="0" border="0" align="center"><tbody><tr><td height="22"><img width="650" height="22" style="display:block" src="http://serviciosisinet.com/img/bottom.jpg"></td></tr></tbody></table>
					
					
					<table width="650" cellspacing="0" cellpadding="0" border="0" align="center"><tbody><tr><td width="650" bgcolor="#f4f4f4" align="center"><span style="font-family:Helvetica,arial,sans-serif;font-size:11px;color:#636363;font-style:normal;line-height:16px">Si usted no puede ver el mensaje correctamente <a href="http://serviciosisinet.com/email/index.php?id=164" style="text-decoration:none;color:#315e8b;font-weight:bold" target="_blank">haga click aquí</a>. </span></td>
					
					</tr></tbody></table><div class="yj6qo"></div><div class="adL">
					</div></div>';
		
		
		
						
			try{
				
				$this->mail->AddAddress( $value['email'], $agentes);
	 
				$this->mail->Subject = $status_name. ' de la Orden de Trabajo '.$notification[0]['uid'];
				$this->mail->Body    = $body;
	 
				$this->mail->Send();
					echo "Message Sent OK</p>\n";
	 
			} catch (phpmailerException $e) {
				echo $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
				echo $e->getMessage(); //Boring error messages from anything else!
			}
			
		  
		  }
		
		}
    }
		
}

?>