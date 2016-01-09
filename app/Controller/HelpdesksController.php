<?php
App::import('Controller', 'Hms');
class HelpdesksController extends HmsController {
var $helpers = array('Html', 'Form','Js');
public $components = array(
'Paginator',
'Session','Cookie','RequestHandler'
);


var $name = 'Helpdesks';



///////////////////////////////////////////////// Help Desk  Model Start //////////////////////////////////// //////////////////////////////////////////





function help_desk_r_open_ticket()
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();

$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');


$this->loadmodel('help_desk');
$conditions=array("help_desk_status" => 0,"society_id" => $s_society_id,"user_id" => $s_user_id,'help_desk_draft'=>0);
$order=array('help_desk.ticket_id'=> 'DESC');
$result=$this->help_desk->find('all',array('conditions'=>$conditions,'order' =>$order));
$this->set('result_help_desk',$result);


}






function help_desk_r_close_ticket()
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();

$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('help_desk');
$conditions=array("help_desk_status" => 1,"society_id" => $s_society_id,"user_id" => $s_user_id,'help_desk_draft'=>0);
$order=array('help_desk.ticket_id'=> 'DESC');
$result=$this->help_desk->find('all',array('conditions'=>$conditions,'order' =>$order));
$this->set('result_help_desk',$result);

}

function help_desk_r_all_ticket()
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();

$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('help_desk');
$conditions=array("society_id" => $s_society_id,"user_id" => $s_user_id,'help_desk_draft'=>0);
$order=array('help_desk.ticket_id'=> 'DESC');
$result=$this->help_desk->find('all',array('conditions'=>$conditions,'order' =>$order));
$this->set('result_help_desk',$result);


}

function help_desk_r_draft_ticket()
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();	
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$this->loadmodel('help_desk');
$conditions=array("help_desk_draft" =>1,"user_id" => $s_user_id);
$order=array('help_desk.help_desk_id'=> 'DESC');
$result=$this->help_desk->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('result_help_desk_draft',$result);
}


function help_desk_draft_delete()
{
$this->layout='blank';
$id=(int)$this->request->query('con');
$this->loadmodel('help_desk');
$this->help_desk->updateAll(array("help_desk_draft" =>2),array("help_desk_id" => $id));
$this->response->header('Location:help_desk_r_draft_ticket');

}


function help_desk_send_to_sm($id=null)
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();
$s_society_id= $this->Session->read('society_id');
$s_user_id= $this->Session->read('user_id');
$id=(int)$id;
$this->loadmodel('help_desk_category');
$order=array('help_desk_category.help_desk_category_name'=> 'ASC');					
$result=$this->help_desk_category->find('all',array('order'=>$order));					
$this->set('result_help_desk_category',$result);
$this->loadmodel('help_desk');
$conditions=array('help_desk_id'=>$id);
$result_help=$this->help_desk->find('all',array('conditions'=>$conditions));	
$this->set('result_help_desk_draft',$result_help);
foreach($result_help as $data)
{
	 $att=$data['help_desk']['help_desk_file'];
}

if(isset($this->request->data['sub']))
{
	
	$ip=$this->hms_email_ip();
	
 $category=(int)$this->request->data['category'];
 $textarea=htmlentities($this->request->data['comment']);
 $textarea=nl2br($textarea);
  $ticket_priority=(int)$this->request->data['priority'];
 $t=$this->autoincrement_with_society_ticket('help_desk','ticket_id');
 date_default_timezone_set('Asia/kolkata');
 $date=date("d-m-y");
 $time=date('h:i:a',time());
 $file=$this->request->form['file']['name'];
	if(empty($file))
	{
	$file=$att;	
	}
$target = "help_desk_file/";
$target=@$target.basename( @$this->request->form['file']['name']);
$ok=1;
move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target); 
$this->loadmodel('help_desk');

$this->help_desk->updateAll(array('ticket_id'=>$t,'help_desk_draft'=>0, "society_id" => $s_society_id , "user_id" => $s_user_id, "help_desk_complain_type_id" => $category,"help_desk_description" => $textarea, "help_desk_date" =>$date,"help_desk_assign_date" =>"", "help_desk_time" =>$time, "help_desk_status" => 0, "help_desk_service_provider_id" => 0,"help_desk_file"=>$file ,"help_desk_close_comment"=>"","help_desk_close_date"=>"","ticket_priority"=>$ticket_priority),array('help_desk_id'=>$id));


//------------------mail functinality  start SM -------------------
$user_mail=1;
if($user_mail==1)	
{
$this->loadmodel('society');
$conditions12=array('society_id'=>$s_society_id);
$result1=$this->society->find('all',array('conditions'=>$conditions12));

foreach ($result1 as $collection) 
{
$user=$collection['society']["user_id"];
$society_name=$collection['society']["society_name"];
}
$this->loadmodel('user');
$conditions2=array("user_id"=>$user);
$result_user=$this->user->find('all',array('conditions'=>$conditions2));
foreach ($result_user as $collection) 
{
$to=$collection['user']["email"];
$mobile=$collection['user']["mobile"];
}

$this->loadmodel('user');
$conditions3=array("user_id"=>$s_user_id);
$result3=$this->user->find('all',array('conditions'=>$conditions3));
foreach ($result3 as $collection) 
{
$user_name=$collection['user']["user_name"];
$reply=$collection['user']["email"];
$wing=(int)$collection['user']["wing"];
$flat=(int)$collection['user']["flat"];
$da_society_id=(int)$collection['user']['society_id'];
}

$this->loadmodel('wing');
$conditions4=array("wing_id"=>$wing);
$result_wing=$this->wing->find('all',array('conditions'=>$conditions4));
foreach ($result_wing as $collection) 
{
$wing_name=$collection['wing']["wing_name"];
}
$this->loadmodel('flat');
$conditions5=array("flat_id"=>$flat);
$result_flat=$this->flat->find('all',array('conditions'=>$conditions5));
foreach ($result_flat as $collection) 
{
$flat_name=$collection['flat']["flat_name"];
}
@$wing_flat=$wing_name.'-'.$flat_name;

if($ticket_priority==1)
{
$ticket_priority="Urgent";
}
else
{
$ticket_priority="Normal";
}
 $ticket_no=$t;
 $i=$id;
 $category_name=$this->help_desk_category_name($category);
$r_sms=$this->hms_sms_ip();
  $working_key=$r_sms->working_key;
 $sms_sender=$r_sms->sms_sender; 
 $sms_allow=(int)$r_sms->sms_allow;
if($sms_allow==1){
 $sms='New Helpdesk ticket '.$ticket_no.' - '.$category_name.' raised+by '.$user_name.' - '.$wing_flat.' Please log into HousingMatters for further action.';

$sms1=str_replace(' ', '+', $sms);
$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms1.'');	
}	
  $message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Dear Administrator,</p><br/>
<p>A new helpdesk ticket is raised in your society.</p>
<table  cellpadding='10' width='100%;' border='1' bordercolor='#e1e1e1'  >
<tr class='tr_heading' style='background-color:#00A0E3;color:white;'>
<td>HelpDesk Ticket</td>
<td>Priority </td>
<td>Posted by</td>
<td>Flat #</td>
</tr>
<tr class='tr_content' style=background-color:#E9E9E9;'>
<td>$ticket_no</td>
<td>$ticket_priority</td>
<td>$user_name</td>
<td>$wing_flat</td>
</tr>
</table>
<div>
<p style='font-size:16px;'> <strong>Ticket Description:</strong></p>
<p style='font-size:15px;'>$textarea</p><br/>
<center><p>To view the ticket or post response
<a href='$ip".$this->webroot."hms' ><button style='width:100px; height:30px;  background-color:#00A0E3;color:white'> Click Here </button></a></p></center><br/>
HousingMatters (Support Team)<br/>
www.housingmatters.co.in
</div>
</div>";

$from_name="HousingMatters";
$this->loadmodel('email');
$conditions6=array("auto_id"=>1);
$result4=$this->email->find('all',array('conditions'=>$conditions6));
foreach ($result4 as $collection) 
{
$from=$collection['email']["from"];

}
$this->loadmodel('notification_email');
$conditions7=array("module_id" =>1,"user_id"=>$user,'chk_status'=>0);
$result5=$this->notification_email->find('all',array('conditions'=>$conditions7));
$n=sizeof($result5);
if(1==1)
{
@$subject.= '['. $society_name . ']' . '- New Helpdesk Ticket : ' . '  #   ' .$ticket_no .'';
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$subject="";
}
}	
/////////////////////////////////// end sm mailfunctionality ////////////////////////

$user_will_get[]=$user;
$this->recent_activities('icon-barcode',$s_user_id,'lodge a new ticket','help_desk_sm_view?id='.$i.'&status=0',$user_will_get,1);



///////////////////////// Send Mail User ///////////////////////////	

$this->loadmodel('help_desk_category');
$conditions=array("help_desk_category_id" => $category);
$cursor=$this->help_desk_category->find('all',array('conditions'=>$conditions));
foreach ($cursor as $collection2) 
{
$help_desk_category_name=$collection2['help_desk_category']['help_desk_category_name'];
}

$user_d[]=$user;
$this->send_notification('<span class="label" style="background-color:#d43f3a;"><i class="icon-plus"></i></span>','New Help-desk ticket# <b>'.$t.'-'.$help_desk_category_name.'</b> lodged by',1,$i,$this->webroot.'HelpDesks/help_desk_sm_view/'.$i.'/0',$s_user_id,$user_d);


$user_mail=2;
if($user_mail==2)	
{
$to=$reply;
$from_name="HousingMatters";
$reply="donotreply@housingmatters.in";
$society_name_user=$this->society_name($da_society_id);

  $message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>

</br><p>Dear $user_name,</p><br/>
<p>Please find below details of new helpdesk ticket raised by you.</p>
<table  cellpadding='10' width='100%;' border='1' bordercolor='#e1e1e1'  >
<tr class='tr_heading' style='background-color:#00A0E3;color:white;'>
<td>HelpDesk Ticket</td>
<td>Priority </td>
<td>Description</td>

</tr>
<tr class='tr_content' style=background-color:#E9E9E9;'>
<td>$ticket_no</td>
<td>$ticket_priority</td>
<td>$textarea</td>
</tr>
</table>
<div>
<br/>
<center><p>To view status update or respond
<a href='$ip' ><button style='width:100px; height:30px;  background-color:#00A0E3;color:white'> Click Here </button></a></p></center><br/>
Thank you.<br/>
HousingMatters (Support Team)<br/>
www.housingmatters.co.in
</div ><br/>
</div>";
$this->loadmodel('notification_email');
$conditions8=array("module_id" =>1,"user_id"=>$s_user_id);
$result6=$this->notification_email->find('all',array('conditions'=>$conditions8));
$s=sizeof($result6);
if($s>0)
{

@$subject.= '['. $society_name . ']' . '- New Helpdesk Ticket : ' . '  #   ' .$ticket_no .'';
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$subject="";
}	
}

///////////////////////////////////////////////////////////////End Mail functionality ..../////////////////////////////////////////////////////////////////

?>
<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Your Ticket has been generated.<br/>
Your Ticket Id is: #<?php echo $t; ?> .
</div> 
<div class="modal-footer">
<a href="<?php echo $this->webroot;?>Helpdesks/help_desk_r_open_ticket" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php	
}
	
}


function help_desk_genarate_ticket()
{	

	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();

$s_society_id= $this->Session->read('society_id');
$s_user_id= $this->Session->read('user_id');

$this->loadmodel('help_desk_category');
$order=array('help_desk_category.help_desk_category_name'=> 'ASC');					
$result=$this->help_desk_category->find('all',array('order'=>$order));					
$this->set('result_help_desk_category',$result);

if(isset($this->request->data['sub']))
{
	
	$ip=$this->hms_email_ip();
	
$category=(int)$this->request->data['category'];
$textarea=htmlentities($this->request->data['description']);
$textarea=nl2br($textarea);
$ticket_priority=(int)$this->request->data['priority'];
$i=$this->autoincrement('help_desk','help_desk_id');
$t=$this->autoincrement_with_society_ticket('help_desk','ticket_id');
date_default_timezone_set('Asia/kolkata');
$date=date("d-m-Y");

$time=date('h:i:a',time());
$file=$this->request->form['file']['name'];
$target = "help_desk_file/";
$target=@$target.basename( @$this->request->form['file']['name']);
$ok=1;
move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target); 



$this->loadmodel('help_desk');
$this->help_desk->saveAll(array("help_desk_id" => $i, "ticket_id" => $t, "society_id" => $s_society_id , "user_id" => $s_user_id, "help_desk_complain_type_id" => $category,"help_desk_description" => $textarea, "help_desk_date" =>$date,"help_desk_assign_date" =>"", "help_desk_time" =>$time, "help_desk_status" => 0, "help_desk_service_provider_id" => 0,"help_desk_file"=>$file ,"help_desk_close_comment"=>"","help_desk_close_date"=>"","ticket_priority"=>$ticket_priority,'help_desk_draft'=>0));


//////////////////////////////////////////////////////////////  Mail Functionality starting /////////////////////////////////////////////////////////////////
//------------------mail functinality  start SM -------------------
$user_mail=1;
if($user_mail==1)	
{
$this->loadmodel('society');
$conditions12=array('society_id'=>$s_society_id);
$result1=$this->society->find('all',array('conditions'=>$conditions12));

foreach ($result1 as $collection) 
{
$user=$collection['society']["user_id"];
$society_name=$collection['society']["society_name"];
}
$this->loadmodel('user');
$conditions2=array("user_id"=>$user);
$result_user=$this->user->find('all',array('conditions'=>$conditions2));
foreach ($result_user as $collection) 
{
$to=$collection['user']["email"];
$mobile=$collection['user']["mobile"];
}
$this->loadmodel('user');
$conditions3=array("user_id"=>$s_user_id);
$result3=$this->user->find('all',array('conditions'=>$conditions3));
foreach ($result3 as $collection) 
{
$user_name=$collection['user']["user_name"];
$reply=$collection['user']["email"];
$wing=(int)$collection['user']["wing"];
$flat=(int)$collection['user']["flat"];
$da_society_id=(int)$collection['user']['society_id'];
}
$this->loadmodel('wing');
$conditions4=array("wing_id"=>$wing);
$result_wing=$this->wing->find('all',array('conditions'=>$conditions4));
foreach ($result_wing as $collection) 
{
$wing_name=$collection['wing']["wing_name"];
}
$this->loadmodel('flat');
$conditions5=array("flat_id"=>$flat);
$result_flat=$this->flat->find('all',array('conditions'=>$conditions5));
foreach ($result_flat as $collection) 
{
$flat_name=$collection['flat']["flat_name"];
}
@$wing_flat=$wing_name.'-'.$flat_name;
if($ticket_priority==1)
{
$ticket_priority="Urgent";
}
else
{
$ticket_priority="Normal";
}

$r_sms=$this->hms_sms_ip();
$working_key=$r_sms->working_key;
$sms_sender=$r_sms->sms_sender; 
$sms_allow=(int)$r_sms->sms_allow;

$ticket_no=$t;
$category_name=$this->help_desk_category_name($category);
$sms='New Helpdesk ticket '.$ticket_no.' - '.$category_name.' raised+by '.$user_name.' - '.$wing_flat.' Please log into HousingMatters for further action.';

$sms1=str_replace(' ', '+', $sms);
if($sms_allow==1){
$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms1.'');	
} 




$message_web='<table  align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
			<tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						
								<tr>
									<td colspan="2">
									<table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%">
										<tbody>
										<tr><td style="line-height:16px" colspan="4" height="16">&nbsp;</td></tr>
										<tr>
										<td style="height:32;line-height:0px" align="left" valign="middle" width="32"><a href="#150d7894359a47c6_" style="color:#3b5998;text-decoration:none"><img class="CToWUd" src="'.$ip.$this->webroot.'as/hm/HM-LOGO-small.jpg" style="border:0" height="50" width="50"></a></td>
										<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
										<td width="100%"><a href="#150d7894359a47c6_" style="color:#3b5998;text-decoration:none;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:19px;line-height:32px"><span style="color:#00a0e3">Housing</span><span style="color:#777776">Matters</span></a></td>
										<td align="right"><a href="https://www.facebook.com/HousingMatters.co.in" target="_blank"><img class="CToWUd" src="'.$ip.$this->webroot.'as/hm/SMLogoFB.png" style="max-height:30px;min-height:30px;width:30px;max-width:30px" height="30px" width="30px"></a>
											
										</td>
										</tr>
										<tr style="border-bottom:solid 1px #e5e5e5"><td style="line-height:16px" colspan="4" height="16">&nbsp;</td></tr>
										</tbody>
										</table>
									</td>
								</tr>
								
									
								
						</tbody>
					</table>
					
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span style="color:rgb(100,100,99)" align="justify"> Dear Administrator, </span> <br>
										</td>
								
								
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> A new helpdesk ticket is raised in your society. </span>
									</td>
																
								</tr>
								
								
								<tr>
									<td>
									
										<table  cellpadding="5" cellspacing="0" width="100%;"border="1" style="border:1px solid #e5e5e5;">
						
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" width="200" >HelpDesk Ticket</td>
										<td align="left" style="background-color:#f8f8f8;" width="500" >'.$ticket_no.'</td>
										</tr>
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Priority</td>
										<td align="left" style="background-color:#f8f8f8;" >'.$ticket_priority.'</td>
										</tr>
										
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Posted by	</td>
										<td align="left" style="background-color:#f8f8f8;" >'.$user_name.'</td>
										</tr>
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Flat #</td>
										<td align="left" style="background-color:#f8f8f8;" >'.$wing_flat.'</td>
										</tr>
									
										</table> 
									
									</td>
								
								
								
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<p style="font-size:16px;"> <strong> Ticket Description: </strong></p>
										<p align="justify">'.$textarea.'</p>
										</td>
								</tr>
					
								<tr>
										<td style="padding:10px;" width="100%" align="center">
										<a href="'.$ip.$this->webroot.'Helpdesks/help_desk_sm_view/'.$i.'/0" style="width: 100px; min-height: 30px; background-color: rgb(0, 142, 213); padding: 10px; font-family: Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif; white-space: nowrap; font-weight: bold; vertical-align: middle; font-size: 14px; line-height: 14px; color: rgb(255, 255, 255); border: 1px solid rgb(2, 106, 158); text-decoration: none;" target="_blank">view / response on HousingMtters</a>
										</td>
								</tr>
					

								<tr>
								<td style="" width="100%" align="left">
									HousingMatters (Support Team) <br/>
									www.housingmatters.in
								</td>
								</tr>

					
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';

$from_name="HousingMatters";
$this->loadmodel('email');
$conditions6=array("auto_id"=>1);
$result4=$this->email->find('all',array('conditions'=>$conditions6));
foreach ($result4 as $collection) 
{
$from=$collection['email']["from"];

}
$this->loadmodel('notification_email');
$conditions7=array("module_id" =>1,"user_id"=>$user,'chk_status'=>0);
$result5=$this->notification_email->find('all',array('conditions'=>$conditions7));
$n=sizeof($result5);
if(1==1)
{
		@$subject.= '['. $society_name . ']' . '- New Helpdesk Ticket : ' . '  #   ' .$ticket_no .'';

$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$subject="";
}
}	
/////////////////////////////////// end sm mailfunctionality ////////////////////////
$user_will_get[]=$user;
$this->recent_activities('icon-barcode',$s_user_id,'lodge a new ticket','help_desk_sm_view?id='.$i.'&status=0',$user_will_get,1);

///////////////////////// Send Mail User ///////////////////////////	

$this->loadmodel('help_desk_category');
$conditions=array("help_desk_category_id" => $category);
$cursor=$this->help_desk_category->find('all',array('conditions'=>$conditions));
foreach ($cursor as $collection2) 
{
$help_desk_category_name=$collection2['help_desk_category']['help_desk_category_name'];
}

$user_d[]=$user;
$this->send_notification('<span class="label" style="background-color:#d43f3a;"><i class="icon-plus"></i></span>','New Help-desk ticket# <b>'.$t.'-'.$help_desk_category_name.'</b> lodged by',1,$i,$this->webroot.'HelpDesks/help_desk_sm_view/'.$i.'/0',$s_user_id,$user_d);


$user_mail=2;
if($user_mail==2)	
{
$to=$reply;
$from_name="HousingMatters";
$reply="donotreply@housingmatters.in";
$society_name_user=$this->society_name($da_society_id);


$message_web='<table  align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
			<tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						
								<tr>
									<td colspan="2">
										<table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%">
										<tbody>
										<tr><td style="line-height:16px" colspan="4" height="16">&nbsp;</td></tr>
										<tr>
										<td style="height:32;line-height:0px" align="left" valign="middle" width="32"><a href="#150d7894359a47c6_" style="color:#3b5998;text-decoration:none"><img class="CToWUd" src="'.$ip.$this->webroot.'as/hm/HM-LOGO-small.jpg" style="border:0" height="50" width="50"></a></td>
										<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
										<td width="100%"><a href="#150d7894359a47c6_" style="color:#3b5998;text-decoration:none;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:19px;line-height:32px"><span style="color:#00a0e3">Housing</span><span style="color:#777776">Matters</span></a></td>
										<td align="right"><a href="https://www.facebook.com/HousingMatters.co.in" target="_blank"><img class="CToWUd" src="'.$ip.$this->webroot.'as/hm/SMLogoFB.png" style="max-height:30px;min-height:30px;width:30px;max-width:30px" height="30px" width="30px"></a>
											
										</td>
										</tr>
										<tr style="border-bottom:solid 1px #e5e5e5"><td style="line-height:16px" colspan="4" height="16">&nbsp;</td></tr>
										</tbody>
										</table>
									</td>
								</tr>
								
									
								
						</tbody>
					</table>
					
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span style="color:rgb(100,100,99)" align="justify"> Dear '.$user_name.', </span> <br>
										</td>
								
								
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> Please find below details of new helpdesk ticket raised by you.</span>
									</td>
																
								</tr>
								
								
								<tr>
									<td>
									
										<table  cellpadding="5" cellspacing="0" width="100%;"border="1" style="border:1px solid #e5e5e5;">
						
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" width="200" >HelpDesk Ticket</td>
										<td align="left" style="background-color:#f8f8f8;" width="600" >'.$ticket_no.'</td>
										</tr>
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Priority</td>
										<td align="left" style="background-color:#f8f8f8;" >'.$ticket_priority.'</td>
										</tr>
										
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Description</td>
										<td align="left" style="background-color:#f8f8f8;" ><p align="justify"> '.$textarea.' </p></td>
										</tr>
										
										
									
										</table> 
									
									</td>
								
								
								
								</tr>
								
												
								<tr>
										<td style="padding:10px;" width="100%" align="center">
										<a href="'.$ip.$this->webroot.'Helpdesks/help_desk_r_view/'.$i.'/0" style="width: 100px; min-height: 30px; background-color: rgb(0, 142, 213); padding: 10px; font-family: Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif; white-space: nowrap; font-weight: bold; vertical-align: middle; font-size: 14px; line-height: 14px; color: rgb(255, 255, 255); border: 1px solid rgb(2, 106, 158); text-decoration: none;" target="_blank">view / vote on HousingMtters</a>
										</td>
								</tr>
					

								<tr>
								<td style="" width="100%" align="left">
									Thank you.<br/>
									HousingMatters (Support Team) <br/>
									www.housingmatters.in
								</td>
								</tr>

					
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';

$this->loadmodel('notification_email');
$conditions8=array("module_id" =>1,"user_id"=>$s_user_id);
$result6=$this->notification_email->find('all',array('conditions'=>$conditions8));
$s=sizeof($result6);
if($s>0)
{
	@$subject.= '['. $society_name . ']' . '- New Helpdesk Ticket : ' . '  #   ' .$ticket_no .'';
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$subject="";
}	

}

///////////////////////////////////////////////////////////////End Mail functionality ..../////////////////////////////////////////////////////////////////


$aar=array(1,$t);
$this->Session->write('help_desk_status',$aar);
$this->response->header('Location', $this->webroot.'Helpdesks/help_desk_r_open_ticket');

?>
<!----alert--------------
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Your Ticket has been generated.<br/>
Your Ticket Id is: #<?php echo $t; ?> .
</div> 
<div class="modal-footer">
<a href="help_desk_r_open_ticket" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php	
}

if(isset($this->request->data['draft']))
{

$category=(int)$this->request->data['category'];
//@$file= $this->response->data['file_up']['name'];
$textarea=htmlentities($this->request->data['description']);
$textarea=nl2br($textarea);
$ticket_priority=(int)$this->request->data['priority'];
date_default_timezone_set('Asia/kolkata');
$date=date("d-m-Y");
$time=date('h:i:a',time());
$file=$this->request->form['file']['name'];
$target = "help_desk_file/";
$target=@$target.basename( @$this->request->form['file']['name']);
$ok=1;
move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target); 
$j=$this->autoincrement('help_desk','help_desk_id');
$this->loadmodel('help_desk');
$this->help_desk->saveAll(array("help_desk_id" => $j, "ticket_id" => 0, "society_id" => $s_society_id , "user_id" => $s_user_id, "help_desk_complain_type_id" => $category,"help_desk_description" => $textarea, "help_desk_date" =>$date,"help_desk_assign_date" =>"", "help_desk_time" =>$time, "help_desk_status" => 0, "help_desk_service_provider_id" => 0,"help_desk_file"=>$file ,"help_desk_close_comment"=>"","help_desk_close_date"=>"","ticket_priority"=>$ticket_priority,'help_desk_draft'=>1));


$this->Session->write('help_desk_draft_status',1);
$this->response->header('Location', $this->webroot.'Helpdesks/help_desk_r_draft_ticket');




?>
<!----alert--------------
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Your Ticket has been saved in draft folder.
</div> 
<div class="modal-footer">
<a href="help_desk_r_draft_ticket" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php
}


}




function help_desk_sm_open_ticket()
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();

$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('help_desk');
$conditions=array("help_desk_status" => 0,"society_id" => $s_society_id,'help_desk_draft'=>0);
$order=array('help_desk.ticket_id'=> 'DESC');
$result_help_desk=$this->help_desk->find('all',array('conditions'=>$conditions,'order' =>$order));
$this->set('result_help_desk',$result_help_desk);
foreach ($result_help_desk as $collection) 
{

$d_user_id=(int)$collection['help_desk']['user_id'];
$ticket_priority=$collection['help_desk']['ticket_priority'];
$ticket_id=(int)$collection['help_desk']['ticket_id'];
$help_generate_date=$collection['help_desk']['help_desk_date'];
$help_desk_description=$collection['help_desk']['help_desk_description'];
$da_society_id=(int)$collection['help_desk']['society_id'];

$result_user = $this->profile_picture($d_user_id);
foreach ($result_user as $collection) 
{
$user_name=$collection['user']['user_name'];
$email=$collection['user']['email'];
}
}




////////////////////////////////////////////////////////
////////////////////close ticket///////////////////////
///////////////////////////////////////////////////////
if (isset($this->request->data['close'])) 
{
	
	$ip=$this->hms_email_ip();
	
$hd_id=(int)$this->request->data['hd_id'];
$close_date=date("d-m-Y");
$massage_close=htmlspecialchars($_POST['close_msg']);
$to= $email;
if($ticket_priority==1)
{
$ticket_priority="Urgent";
}
else
{
$ticket_priority="Normal";
}

/* $message_web="<div style=' padding:25px;  font-size:14px; border:1px solid #BCE8F1; width:80%; background-color: #fcf8e3;'>
<p style='background-color:#60F;  font-size:16px; padding:10px;'><b style='color: white; '> HousingMatters</b></p><br/>
<p>Dear $user_name,</p><br/>
<p>Your helpdesk ticket has been resolved & closed.</p>
<table border='1' cellpadding='10' width='100%;'  style='margin-bottom:2px; ' >
<tr bgcolor='#717BD7'>
<td ><b style='color: white; '>HelpDesk Ticket</b></td>
<td><b style='color: white; '>Priority </b></td>
<td><b style='color: white; '>Ticket Date</b></td>
<td><b style='color: white; '>Closure Date</b></td>
</tr>
<tr bgcolor='#717BD7'>
<td ><b style=' '>$ticket_id</b></td>
<td><b style=' '>$ticket_priority</b></td>
<td><b style=' '>$help_generate_date</b></td>
<td><b style=' '>$close_date</b></td>
</tr>
</table>
<div style=' padding:5px;  font-size:14px; border:1px solid #BCE8F1; background-color:#B6AFF3;'>
<p style='font-size:16px;'> <strong>Ticket Description:</strong></p>
<p style='font-size:15px;'>$help_desk_description</p>
</div ><br/>
<div style=' padding:5px;  font-size:14px; border:1px solid #BCE8F1; background-color:#B6AFF3;'>
<p style='font-size:16px;'> <strong>Ticket Description by user:</strong></p>
<p style='font-size:15px;'>$massage_close</p>
</div ><br/>
</div>"; 

*/


$message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Dear $user_name,</p><br/>
<p>Your helpdesk ticket has been resolved & closed.</p>
<table  cellpadding='10' width='100%;' border='1' bordercolor='#e1e1e1'  >
<tr class='tr_heading' style='background-color:#00A0E3;color:white;'>
<td>HelpDesk Ticket</td>
<td>Priority </td>
<td>Ticket Date</td>
<td>Closure Date</td>
</tr>
<tr class='tr_content' style=background-color:#E9E9E9;'>
<td>$ticket_id</td>
<td>$ticket_priority</td>
<td>$help_generate_date</td>
<td>$close_date</td>
</tr>
</table>
<div>
<p style='font-size:16px;'> <strong>Ticket Description:</strong></p>
<p style='font-size:15px;'>$help_desk_description</p> <br/>
<p style='font-size:16px;'> <strong>Ticket Description by user:</strong></p>
<p style='font-size:15px;'>$massage_close</p>
<br/>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.co.in
</div>
</div>";


$reply="donotreply@housingmatters.in";
$from_name="HousingMatters";

$this->loadmodel('email');
$conditions=array("auto_id" => 1);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
}

$society_result=$this->society_name($da_society_id);
foreach($society_result as $data)
{
$society_name=$data['society']['society_name'];
}
$this->loadmodel('notification_email');
$conditions=array("module_id" =>1,"user_id"=>$d_user_id,'chk_status'=>0);
$n=$this->notification_email->find('count',array('conditions'=>$conditions));
if($n>0)
{
@$subject.= '['. $society_name . '] -' . ' Closure of Helpdesk Ticket: #'. '' .$ticket_id.'';

$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$subject="";
}
$close_date;
$massage_close;
$this->loadmodel('help_desk');
$this->help_desk->updateAll(array("help_desk_close_comment" => $massage_close,"help_desk_close_date"=>$close_date,"help_desk_status" => 1),array("help_desk_id" => $hd_id));
$this->response->header('Location:help_desk_sm_close_ticket');

}
////////////////////////////////////////////////////////
////////////////////close ticket///////////////////////
///////////////////////////////////////////////////////



}


function help_desk_sm_close_ticket()
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();

$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$this->loadmodel('help_desk');
$conditions=array("help_desk_status" =>1,"society_id" => $s_society_id,'help_desk_draft'=>0);
$order=array('help_desk.ticket_id'=> 'DESC');
$result=$this->help_desk->find('all',array('conditions'=>$conditions,'order' =>$order));
$this->set('result_help_desk',$result);


}





function help_desk_sm_all_ticket()
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();
 

$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('help_desk');
$conditions=array("society_id" => $s_society_id,'help_desk_draft'=>0);
$order=array('help_desk.ticket_id'=> 'DESC');
$result=$this->help_desk->find('all',array('conditions'=>$conditions,'order' =>$order));
$this->set('result_help_desk',$result);
foreach ($result as $collection) 
{
$d_user_id=(int)$collection['help_desk']['user_id'];
$ticket_priority=$collection['help_desk']['ticket_priority'];
$ticket_id=(int)$collection['help_desk']['ticket_id'];
$help_generate_date=$collection['help_desk']['help_desk_date'];
$help_desk_description=$collection['help_desk']['help_desk_description'];
$da_society_id=(int)$collection['help_desk']['society_id'];
$result_user = $this->profile_picture($d_user_id);
foreach ($result_user as $collection) 
{
$user_name=$collection['user']['user_name'];
$email=$collection['user']['email'];
}




}
/////////////////////////////////////////////////////// Close Ticket code and Email Code ///////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($this->request->data['close'])) 
{
	echo 'hi'; exit;
	
	$ip=$this->hms_email_ip();
	
$hd_id=(int)$this->request->data['hd_id'];
$close_date=date("d-m-Y");
$massage_close=htmlspecialchars($_POST['close_msg']);
$to= $email;
if($ticket_priority==1)
{
$ticket_priority="Urgent";
}
else
{
$ticket_priority="Normal";
}
$message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Dear $user_name,</p><br/>
<p>Your helpdesk ticket has been resolved & closed.</p>
<table  cellpadding='10' width='100%;' border='1' bordercolor='#e1e1e1'  >
<tr class='tr_heading' style='background-color:#00A0E3;color:white;'>
<td>HelpDesk Ticket</td>
<td>Priority </td>
<td>Ticket Date</td>
<td>Closure Date</td>
</tr>
<tr class='tr_content' style=background-color:#E9E9E9;'>
<td>$ticket_id</td>
<td>$ticket_priority</td>
<td>$help_generate_date</td>
<td>$close_date</td>
</tr>
</table>
<div>
<p style='font-size:16px;'> <strong>Ticket Description:</strong></p>
<p style='font-size:15px;'>$help_desk_description</p> <br/>
<p style='font-size:16px;'> <strong>Ticket Description by user:</strong></p>
<p style='font-size:15px;'>$massage_close</p>
<br/>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.co.in
</div>
</div>";

$reply="donotreply@housingmatters.in";
$from_name="HousingMatters";

$this->loadmodel('email');
$conditions=array("auto_id" => 1);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
}

$society_result=$this->society_name($da_society_id);
foreach($society_result as $data)
{
	$society_name=$data['society']['society_name'];
}

$this->loadmodel('notification_email');
$conditions=array("module_id" =>1,"user_id"=>$d_user_id,'chk_status'=>0);
$n=$this->notification_email->find('count',array('conditions'=>$conditions));
if($n>0)
{
@$subject.= '['. $society_name . '] -' . ' Closure of Helpdesk Ticket: #'. '' .$ticket_id.'';

$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$subject="";
}
$close_date;
$massage_close;
$this->loadmodel('help_desk');
$this->help_desk->updateAll(array("help_desk_close_comment" => $massage_close,"help_desk_close_date"=>$close_date,"help_desk_status" => 1),array("help_desk_id" => $hd_id));
$this->response->header('Location:help_desk_sm_close_ticket');
}
//////////////////////////////////////////////////////End close ticket code and Email functionality ///////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

}




function help_desk_r_view($id=null,$status=null)
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();
$hd_id=(int)$id;
$status=(int)$status;
$this->set('hd_id',$hd_id);
$this->set('status',$status);

$this->seen_notification(1,$hd_id);

$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('help_desk');
$conditions=array("help_desk_id" => $hd_id);
$result=$this->help_desk->find('all',array('conditions'=>$conditions));
foreach ($result as $collection) 
{
$this->set('help_desk_description',$collection['help_desk']['help_desk_description']);
$this->set('help_desk_file',$collection['help_desk']['help_desk_file']);
$this->set('ticket_id',(int)$collection['help_desk']['ticket_id']);
$this->set('help_desk_close_date',@$collection['help_desk']['help_desk_close_date']);
$this->set('help_desk_close_comment',@$collection['help_desk']['help_desk_close_comment']);
$help_desk_complain_type_id=(int)$collection['help_desk']['help_desk_complain_type_id'];
$this->set('help_desk_complain_type_id',$help_desk_complain_type_id);
$this->set('help_desk_date',$collection['help_desk']['help_desk_date']);
$this->set('help_desk_time',$collection['help_desk']['help_desk_time']);
}

$this->loadmodel('help_desk_category');
$conditions=array("help_desk_category_id" => $help_desk_complain_type_id);
$cursor=$this->help_desk_category->find('all',array('conditions'=>$conditions));
foreach ($cursor as $collection2) 
{
$this->set('help_desk_category_name',$collection2['help_desk_category']['help_desk_category_name']);
}

$this->loadmodel('help_desk_reply');
$conditions=array("help_desk_id" => $hd_id);
$this->set('result_reply',$this->help_desk_reply->find('all',array('conditions'=>$conditions)));

}


function help_desk_sm_view($id=null,$status=null)
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();

$hd_id=(int)$id;
$status=(int)$status;
$this->set('hd_id',$hd_id);

$this->set('status',$status);

$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->seen_notification(1,$hd_id);
////////////////////////////////////////////////////////
////////////////////close ticket///////////////////////
///////////////////////////////////////////////////////
$this->loadmodel('help_desk');
$conditions=array("help_desk_id" => $hd_id);
$result_help_desk=$this->help_desk->find('all',array('conditions'=>$conditions));
$this->set('result_help_desk',$result_help_desk);
foreach ($result_help_desk as $collection) 
{

$d_user_id=(int)$collection['help_desk']['user_id'];
$ticket_priority=$collection['help_desk']['ticket_priority'];
$ticket_id=(int)$collection['help_desk']['ticket_id'];
$help_generate_date=$collection['help_desk']['help_desk_date'];
$help_desk_description=$collection['help_desk']['help_desk_description'];
$da_society_id=(int)$collection['help_desk']['society_id'];

$result_user = $this->profile_picture($d_user_id);
foreach ($result_user as $collection) 
{
$user_name=$collection['user']['user_name'];
$email=$collection['user']['email'];
}
}
if (isset($this->request->data['close'])) 
{
	
	$ip=$this->hms_email_ip();
	$close_date=date("d-m-Y");
	$massage_close=htmlspecialchars($_POST['close_msg']);
	$to= $email;

if($ticket_priority==1)
{
$ticket_priority="Urgent";
}
else
{
$ticket_priority="Normal";
}
/* $message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Dear $user_name,</p><br/>
<p>Your helpdesk ticket has been resolved & closed.</p>
<table  cellpadding='10' width='100%;' border='1' bordercolor='#e1e1e1'  >
<tr class='tr_heading' style='background-color:#00A0E3;color:white;'>
<td>HelpDesk Ticket</td>
<td>Priority </td>
<td>Ticket Date</td>
<td>Closure Date</td>
</tr>
<tr class='tr_content' style=background-color:#E9E9E9;'>
<td>$ticket_id</td>
<td>$ticket_priority</td>
<td>$help_generate_date</td>
<td>$close_date</td>
</tr>
</table>
<div>
<p style='font-size:16px;'> <strong>Ticket Description:</strong></p>
<p style='font-size:15px;'>$help_desk_description</p> <br/>
<p style='font-size:16px;'> <strong>Ticket Description by user:</strong></p>
<p style='font-size:15px;'>$massage_close</p>
<br/>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.co.in
</div>
</div>";
*/

  $message_web='<table  align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
			<tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						
								<tr>
									<td colspan="2">
										<table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%">
										<tbody>
										<tr><td style="line-height:16px" colspan="4" height="16">&nbsp;</td></tr>
										<tr>
										<td style="height:32;line-height:0px" align="left" valign="middle" width="32"><a href="#150d7894359a47c6_" style="color:#3b5998;text-decoration:none"><img class="CToWUd" src="'.$ip.$this->webroot.'as/hm/HM-LOGO-small.jpg" style="border:0" height="50" width="50"></a></td>
										<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
										<td width="100%"><a href="#150d7894359a47c6_" style="color:#3b5998;text-decoration:none;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:19px;line-height:32px"><span style="color:#00a0e3">Housing</span><span style="color:#777776">Matters</span></a></td>
										<td align="right"><a href="https://www.facebook.com/HousingMatters.co.in" target="_blank"><img class="CToWUd" src="'.$ip.$this->webroot.'as/hm/SMLogoFB.png" style="max-height:30px;min-height:30px;width:30px;max-width:30px" height="30px" width="30px"></a>
											
										</td>
										</tr>
										<tr style="border-bottom:solid 1px #e5e5e5"><td style="line-height:16px" colspan="4" height="16">&nbsp;</td></tr>
										</tbody>
										</table>
									</td>
								</tr>
								
									
								
						</tbody>
					</table>
					
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span style="color:rgb(100,100,99)" align="justify"> Dear '.$user_name.', </span> <br>
										</td>
								
								
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> Your helpdesk ticket has been resolved & closed.</span>
									</td>
																
								</tr>
								
								
								<tr>
									<td>
									
										<table  cellpadding="5" cellspacing="0" width="100%" border="1" style="border:1px solid #e5e5e5;">
						
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" width="25%" >HelpDesk Ticket</td>
										<td align="left" style="background-color:#f8f8f8;" width="" >'.$ticket_id.'</td>
										</tr>
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Priority</td>
										<td align="left" style="background-color:#f8f8f8;">'.$ticket_priority.'</td>
										</tr>
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Ticket Date</td>
										<td align="left" style="background-color:#f8f8f8;">
										<p align="justify" >'.$help_generate_date.'</p></td>
										</tr>
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Closure Date</td>
										<td align="left" style="background-color:#f8f8f8;"> '.$close_date.' </td>
										</tr>

										</table> 
									
									</td>
						
								</tr>
								
								
					
					
					</table>
					<br/>
					<table width="100%" cellpadding="0" cellspacing="0">
					<tbody>
					
						<tr>
						<td style="padding:5px;" width="100%" align="left">
							<p style="font-size:16px;"> <strong>Ticket Description:</strong></p>
							<p style="font-size:15px;" align="justify">'.$help_desk_description.'</p>
						</td>
											
						</tr>
						
						<tr>
						<td style="padding:5px;" width="100%" align="left">
							<p style="font-size:16px;"> <strong>Ticket Description by user:</strong></p>
							<p style="font-size:15px;" align="justify">'.$massage_close.'</p>
						</td>
											
						</tr>
						
						
					</tbody>
					</table> <br/><br/>
					
					<table width="100%" cellpadding="0" cellspacing="0">
						<tbody>
						
								<tr>
									<td style="" width="100%" align="left">
										Thank you.<br/>
										HousingMatters (Support Team) <br/>
										www.housingmatters.in
									</td>
								</tr>
							
						</tbody>
					</table>
					
					
					
					
				</td>
			</tr>

        </tbody>
</table>';

$reply="donotreply@housingmatters.in";
$from_name="HousingMatters";

$this->loadmodel('email');
$conditions=array("auto_id" => 1);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
}

$society_result=$this->society_name($da_society_id);
foreach($society_result as $data)
{
$society_name=$data['society']['society_name'];
}
$this->loadmodel('notification_email');
$conditions=array("module_id" =>1,"user_id"=>$d_user_id,'chk_status'=>0);
$n=$this->notification_email->find('count',array('conditions'=>$conditions));
if($n>0)
{
@$subject.= '['. $society_name . '] -' . ' Closure of Helpdesk Ticket: #'. '' .$ticket_id.'';

$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$subject="";
}
$close_date;
$massage_close;
$this->loadmodel('help_desk');
$this->help_desk->updateAll(array("help_desk_close_comment" => $massage_close,"help_desk_close_date"=>$close_date,"help_desk_status" => 1),array("help_desk_id" => $hd_id));

$da_user_id[]=$d_user_id;
$this->send_notification('<span class="label" style="background-color:#4cae4c;"><i class="icon-ok"></i></span>','Your help-desk ticket#<b>'.$ticket_id.'</b> closed by ',1,$hd_id,$this->webroot.'HelpDesks/help_desk_r_view/'.$hd_id.'/1',$s_user_id,$da_user_id);


$this->redirect(array('controller' => 'Helpdesks','action' => 'help_desk_sm_close_ticket'));
}
////////////////////////////////////////////////////////
////////////////////close ticket///////////////////////
///////////////////////////////////////////////////////
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('help_desk');
$conditions=array("help_desk_id" => $hd_id);
$result=$this->help_desk->find('all',array('conditions'=>$conditions));
foreach ($result as $collection) 
{
$this->set('help_desk_description',$collection['help_desk']['help_desk_description']);
$this->set('help_desk_file',$collection['help_desk']['help_desk_file']);
$this->set('ticket_id',(int)$collection['help_desk']['ticket_id']);
$this->set('help_desk_close_date',@$collection['help_desk']['help_desk_close_date']);
$this->set('help_desk_close_comment',@$collection['help_desk']['help_desk_close_comment']);
$help_desk_complain_type_id=(int)$collection['help_desk']['help_desk_complain_type_id'];
$hd_sp_id=(int)$collection['help_desk']['help_desk_service_provider_id'];
$this->set('help_desk_complain_type_id',$help_desk_complain_type_id);
$this->set('help_desk_date',$collection['help_desk']['help_desk_date']);
$this->set('help_desk_time',$collection['help_desk']['help_desk_time']);
$this->set('d_user_id',$collection['help_desk']['user_id']);
$this->set('help_desk_status',$collection['help_desk']['help_desk_status']);
$this->set('hd_sp_id',(int)$collection['help_desk']['help_desk_service_provider_id']);
$this->set('help_desk_assign_date',$collection['help_desk']['help_desk_assign_date']);
}

$this->loadmodel('help_desk_category');
$conditions=array("help_desk_category_id" => $help_desk_complain_type_id);
$cursor=$this->help_desk_category->find('all',array('conditions'=>$conditions));
foreach ($cursor as $collection2) 
{
$this->set('help_desk_category_name',$collection2['help_desk_category']['help_desk_category_name']);
}

$this->loadmodel('help_desk_reply');
$conditions=array("help_desk_id" => $hd_id);
$this->set('result_reply',$this->help_desk_reply->find('all',array('conditions'=>$conditions)));

$this->loadmodel('vendor');
$conditions=array("category_id" => $help_desk_complain_type_id);
$result_vendor=$this->vendor->find('all',array('conditions'=>$conditions));
$this->set('result_vendor',$result_vendor);
foreach ($result_vendor as $collection)
{
    $vendor_id = (int)$collection['vendor']['vendor_id'];
}

$result_sp2=$this->fetch_service_provider_info_via_vendor_id(@$hd_sp_id);
foreach ($result_sp2 as $collection3)
{
$this->set('sp_name',$collection3['service_provider']['sp_name']);
}
}


function help_desk_reports()
{
$this->layout='session';
$this->ath();
}

function help_desk_report_1()
{
$this->layout='blank';
$this->ath();

$s_society_id=$this->Session->read('society_id');

$d1=$this->request->query('d1');
$d2=$this->request->query('d2');
if(empty($d1) || empty($d2)) { echo '<span style="color:red;">Please select Date-period.</span>'; exit;}
if(strtotime($d1)>strtotime($d2)) { echo '<span style="color:red;">Please select valid Date-period.</span>'; exit;}
$d1=date("Y-m-d",strtotime($d1));
$d2=date("Y-m-d",strtotime($d2));
$this->set('d1',$d1);
$this->set('d2',$d2);

	$this->loadmodel('help_desk');
	$conditions=array("society_id" => $s_society_id);
	$result_help_desk_report1=$this->help_desk->find('all',array('conditions'=>$conditions));
	$this->set('result_help_desk_report1',$result_help_desk_report1);
}

function help_desk_report_2()
{
$this->layout='blank';
$this->ath();

$s_society_id=$this->Session->read('society_id');

$d1=$this->request->query('d1');
$d2=$this->request->query('d2');
if(empty($d1) || empty($d2)) { echo '<span style="color:red;">Please select Date-period.</span>'; exit;}
if(strtotime($d1)>strtotime($d2)) { echo '<span style="color:red;">Please select valid Date-period.</span>'; exit;}
$d1=date("Y-m-d",strtotime($d1));
$d2=date("Y-m-d",strtotime($d2));
$this->set('d1',$d1);
$this->set('d2',$d2);

	$this->loadmodel('help_desk');
	$conditions=array("society_id" => $s_society_id,"help_desk_status" => 1);
	$result_help_desk_report1=$this->help_desk->find('all',array('conditions'=>$conditions));
	$this->set('result_help_desk_report1',$result_help_desk_report1);
}


function help_desk_report_3()
{
$this->layout='blank';
$this->ath();

$s_society_id=$this->Session->read('society_id');

$d1=$this->request->query('d1');
$d2=$this->request->query('d2');
if(empty($d1) || empty($d2)) { echo '<span style="color:red;">Please select Date-period.</span>'; exit;}
if(strtotime($d1)>strtotime($d2)) { echo '<span style="color:red;">Please select valid Date-period.</span>'; exit;}
$d1=date("Y-m-d",strtotime($d1));
$d2=date("Y-m-d",strtotime($d2));
$this->set('d1',$d1);
$this->set('d2',$d2);

	$this->loadmodel('help_desk');
	$conditions=array("society_id" => $s_society_id);
	$result_help_desk_report1=$this->help_desk->find('all',array('conditions'=>$conditions));
	$this->set('result_help_desk_report1',$result_help_desk_report1);
}

function help_desk_report_4()
{
$this->layout='blank';
$this->ath();

$s_society_id=$this->Session->read('society_id');

$d1=$this->request->query('d1');
$d2=$this->request->query('d2');
if(empty($d1) || empty($d2)) { echo '<span style="color:red;">Please select Date-period.</span>'; exit;}
if(strtotime($d1)>strtotime($d2)) { echo '<span style="color:red;">Please select valid Date-period.</span>'; exit;}
$d1=date("Y-m-d",strtotime($d1));
$d2=date("Y-m-d",strtotime($d2));
$this->set('d1',$d1);
$this->set('d2',$d2);

	$this->loadmodel('help_desk');
	$conditions=array("society_id" => $s_society_id);
	$result_help_desk_report1=$this->help_desk->find('all',array('conditions'=>$conditions));
	$this->set('result_help_desk_report1',$result_help_desk_report1);
}



function assign_ticket_to_sp_sms()
{
	$this->layout='blank';
	 $sp_id=(int)$this->request->query('sp_id');
	$mobile=$this->request->query('mob');
	$msg=$this->request->query('msg'); 
	$hd_id=(int)$this->request->query('hd_id');
	$date=date("d-m-Y");
	$r_sms=$this->hms_sms_ip();
	$working_key=$r_sms->working_key;
	$sms_sender=$r_sms->sms_sender; 
	$sms_allow=(int)$r_sms->sms_allow;

	$s_society_id=$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	
	$this->loadmodel('help_desk');
	$conditions=array("help_desk_id" => $hd_id);
	$result=$this->help_desk->find('all',array('conditions'=>$conditions));
	foreach ($result as $collection) 
	{
		 $ticket_id=(int)$collection['help_desk']['ticket_id'];
		 $d_user_id=(int)$collection['help_desk']['user_id'];
	}
	
	
	//$sms='New Helpdesk ticket '.$ticket_id.' assign ticket to you';
	$sms1=str_replace(' ', '+', $msg);
	if($sms_allow==1){
 $payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms1.'');
	}	
	$this->loadmodel('help_desk');
	$this->help_desk->updateAll(array("help_desk_service_provider_id" => $sp_id,"help_desk_assign_date" => $date),array("help_desk_id" => $hd_id));
	$this->response->header('Location:help_desk_sm_open_ticket');
}



function assign_ticket_to_sp()
{
	
$this->layout='blank';
$this->ath();
$sp_id=(int)$this->request->query('sp_id');

 $msg=$this->request->query('msg');
 $hd_id=(int)$this->request->query('hd_id');

$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$result_user=$this->profile_picture($s_user_id);
$email=$result_user[0]['user']['email'];
$date=date("d-m-Y");
$this->loadmodel('help_desk');
$conditions=array("help_desk_id" => $hd_id);
$result=$this->help_desk->find('all',array('conditions'=>$conditions));
foreach ($result as $collection) 
{
$ticket_id=(int)$collection['help_desk']['ticket_id'];
$d_user_id=(int)$collection['help_desk']['user_id'];
}
$this->loadmodel('service_provider');
$conditions=array("sp_id" => $sp_id,"society_id" => $s_society_id);
$result_sp=$this->service_provider->find('all',array('conditions'=>$conditions));
foreach ($result_sp as $collection) 
{
$sp_id=(int)$collection['service_provider']['sp_id']; 
$sp_name=$collection['service_provider']['sp_name'];
$sp_email=$collection['service_provider']['sp_email'];
$mobile=$collection['service_provider']['sp_mobile'];
$sp_user_id=$collection['service_provider']['user_id'];
$sp_society_id=(int)$collection['service_provider']['society_id'];
}
$to= $sp_email;
$sms="Assign Ticket";
$sms1=str_replace(' ', '+', $sms);
$from_name="HousingMatters";
$this->loadmodel('email');
$conditions=array("auto_id" => 1);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection2) 
{
$from=$collection2['email']['from'];
$sub=$collection2['email']['subject'];
}
$this->loadmodel('society');
$conditions=array("society_id"=>$sp_society_id);
$result_society=$this->society->find('all',array('conditions'=>$conditions));
foreach ($result_society as $collection3) 
{
$society_name=$collection3['society']['society_name'];
$society_user_id=(int)$collection3['society']['user_id'];
}

$ip=$this->hms_email_ip();

$r_sms=$this->hms_sms_ip();
$working_key=$r_sms->working_key;
$sms_sender=$r_sms->sms_sender; 
$sms_allow=(int)$r_sms->sms_allow;

$this->loadmodel('user');
$conditions=array("user_id"=>$society_user_id);
$result_user=$this->user->find('all',array('conditions'=>$conditions));
foreach ($result_user as $collection4) 
{
$adm_user_name=$collection4['user']['user_name'];
$adm_mobile=$collection4['user']['mobile'];
$reply=$collection4['user']['email'];
}
@$subject.= '['. $society_name . '] - ' . 'Helpdesk Ticket: #'. '' .$ticket_id.'';
$this->loadmodel('notification_email');
$conditions7=array("module_id" =>1,"user_id"=>$sp_user_id,'chk_status'=>1);
$result5=$this->notification_email->find('all',array('conditions'=>$conditions7));
$n=sizeof($result5);
if($n>0)
{
	if($sms_allow==1){
$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms.'');
	}
}

 $message_web='<table  align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
			<tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						
								<tr>
									<td colspan="2">
										<table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%">
										<tbody>
										<tr><td style="line-height:16px" colspan="4" height="16">&nbsp;</td></tr>
										<tr>
										<td style="height:32;line-height:0px" align="left" valign="middle" width="32"><a href="#150d7894359a47c6_" style="color:#3b5998;text-decoration:none"><img class="CToWUd" src="'.$ip.$this->webroot.'as/hm/HM-LOGO-small.jpg" style="border:0" height="50" width="50"></a></td>
										<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
										<td width="100%"><a href="#150d7894359a47c6_" style="color:#3b5998;text-decoration:none;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:19px;line-height:32px"><span style="color:#00a0e3">Housing</span><span style="color:#777776">Matters</span></a></td>
										<td align="right"><a href="https://www.facebook.com/HousingMatters.co.in" target="_blank"><img class="CToWUd" src="'.$ip.$this->webroot.'as/hm/SMLogoFB.png" style="max-height:30px;min-height:30px;width:30px;max-width:30px" height="30px" width="30px"></a>
											
										</td>
										</tr>
										<tr style="border-bottom:solid 1px #e5e5e5"><td style="line-height:16px" colspan="4" height="16">&nbsp;</td></tr>
										</tbody>
										</table>
									</td>
								</tr>
								
									
								
						</tbody>
					</table>
					
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span style="color:rgb(100,100,99)" align="justify"> Dear '.$sp_name.', </span> <br>
										</td>
								
								
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> Please find below details of our helpdesk ticket for your prompt action.</span>
									</td>
																
								</tr>
								
								
								<tr>
									<td>
									
										<table  cellpadding="5" cellspacing="0" width="100%" border="1" style="border:1px solid #e5e5e5;">
						
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" width="20%" >HelpDesk Ticket</td>
										<td align="left" style="background-color:#f8f8f8;" width="" >'.$ticket_id.'</td>
										</tr>
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Description</td>
										<td align="left" style="background-color:#f8f8f8;">
										<p align="justify" >'.$msg.'</p></td>
										</tr>

										</table> 
									
									</td>
						
								</tr>
								
								
					
					
					</table>
					<br/>
					<table width="100%" cellpadding="0" cellspacing="0">
					<tbody>
					
						<tr>
						<td style="padding:5px;" width="100%" align="left">
						<span style="color:rgb(100,100,99)"> Please quote the Helpdesk ticket number in your correspondence.</span>
						</td>
											
						</tr>
						
					</tbody>
					</table> <br/>
					
					<table width="100%" cellpadding="0" cellspacing="0">
					<tbody>
					
						<tr>
						<td style="padding:5px;" width="100%" align="left">
							<span> For '.$society_name.' </span><br/>
							<span> '.$adm_user_name.' </span><br/>
							<span>'.$adm_mobile.' </span> <br/>
						</td>
											
						</tr>
						
					</tbody>
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';

$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$this->send_email($email,$from,$from_name,$subject,$message_web,$reply);

$subject="";
$this->loadmodel('help_desk');
$this->help_desk->updateAll(array("help_desk_service_provider_id" => $sp_id,"help_desk_assign_date" => $date),array("help_desk_id" => $hd_id));

$da_user_id[]=$d_user_id;
$this->send_notification('<span class="label" style="background-color:#eea236;"><i class="icon-share"></i></span>','Your help-desk ticket#<b>'.$ticket_id.'</b> assigned to '.$sp_name,1,$hd_id,$this->webroot.'HelpDesks/help_desk_r_view/'.$hd_id.'/0',$s_user_id,$da_user_id);

$this->response->header('Location:help_desk_sm_open_ticket');
}







function save_reply_resident()
{
	$this->layout='blank';
	//$this->ath();
	
	$reply=htmlentities($this->request->query('con1'));
	$hd_id=(int)$this->request->query('con2');
  $reply=nl2br($reply);

//$rep=explode(' ',$reply);

$r=$this->content_moderation_society($reply);



$s_user_id=$this->Session->read('user_id');
date_default_timezone_set('Asia/Kolkata');
$date=date("d-m-Y");
 $time=date('h:i:a',time());

$t=$this->autoincrement('help_desk_reply','hd_reply_id');
$this->loadmodel('help_desk_reply');
$multipleRowData = Array( Array("hd_reply_id" => $t, "reply" => $reply , "help_desk_id" => $hd_id, "date" => $date,"time" => $time,"class" => "outt","user_id"=>$s_user_id));
if($r==0)
{
	echo'<span style="color:red;font-size:14px;">You have enter wrong word.</span>';	

}
else
{
 $this->help_desk_reply->saveAll($multipleRowData); 
}
$this->loadmodel('help_desk_reply');
$conditions=array("help_desk_id" => $hd_id);
$order=array('help_desk_reply.hd_reply_id'=>'ASC');
$this->set('result_reply',$this->help_desk_reply->find('all',array('conditions'=>$conditions,'order'=>$order)));


}



///////////////////////////////////////////////// Service Provider ///////////////////////////////...............................////////////////////////
function service_provider_add()
{

	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();

$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('help_desk_category');	
$order=array('help_desk_category.help_desk_category_name'=>'ASC');
$result=$this->help_desk_category->find('all',array('order'=>$order));
$this->set('result_help_desk_category',$result);
if($this->request->is('post')) 
{
$file_upload=$this->request['form']['file']['name'];
$pan_number=$this->request->data['pan_no'];
$text=htmlentities($this->request->data['name']);	
$name=wordwrap($text, 25, " ", true);
$text1=htmlentities($this->request->data['person']);
$person = wordwrap($text1, 25, " ", true);
$mobile=$this->request->data['mobile'];
$email=$this->request->data['email'];
@$cont_start=$this->request->data['cont_start'];
@$cont_end=$this->request->data['cont_end'];
	$target = "service_provider_file/";
	$target=@$target.basename( @$this->request->form['file']['name']);
	$ok=1;
	move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target); 



if(!empty($cont_start))
{
$contract_type="AMC";	
}
else
{
$contract_type="Adhoc";
}

$this->loadmodel('service_provider');
$i=$this->autoincrement('service_provider','sp_id');
date_default_timezone_set('Asia/kolkata');
$date=date("d-m-Y");
$time=date('h:i:a',time());
$this->service_provider->saveAll(array("sp_id" => $i, "sp_attachment" => $file_upload , 
"sp_name" => $name,"sp_date"=>$date,"user_id"=>$s_user_id,"society_id"=>$s_society_id,"sp_time"=>$time,
"sp_delete"=>0,"sp_cont_start"=>$cont_start,"sp_cont_end"=>$cont_end,"sp_person"=>$person,
"sp_email"=>$email,"sp_mobile"=>$mobile,"sp_contract_type"=>$contract_type,"pan_number"=>$pan_number));


//INSERT LEDGER SUB ACCOUNTS
$this->loadmodel('ledger_sub_account');
$ledger_sub_account_auto_id=$this->autoincrement('ledger_sub_account','auto_id');
$this->ledger_sub_account->saveAll(array("auto_id" => $ledger_sub_account_auto_id, 
"ledger_id" => 15 , "name" => $name,"society_id"=>$s_society_id,"sp_id"=>$i));

$this->loadmodel('help_desk_category');
$result=$this->help_desk_category->find('all');
foreach ($result as $collection)
{ 
$id=$collection['help_desk_category']['help_desk_category_id'];
$servies=$collection['help_desk_category']['help_desk_category_name'];
@$check_id=(int)$this->request->data[$id];
if(!empty($check_id))
{
$this->loadmodel('vendor');
$j=$this->autoincrement('vendor','auto_id');
$this->vendor->saveAll(array("auto_id" => $j, "vendor_id" => $i, "category_id" =>  $check_id));
}
}

?>

<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Successfully add service provider.
</div> 
<div class="modal-footer">
<a href="service_provider_view" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php			
}
}
function service_provider_vendor($auto_id)
{


$this->loadmodel('vendor');
$conditions=array("vendor_id" =>  $auto_id);
return $this->vendor->find('all',array('conditions'=>$conditions));                  


}

function service_provider_view()
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();

$s_society_id=$this->Session->read('society_id');
$this->set('role_id',$s_role_id=$this->Session->read('role_id'));
$this->loadmodel('service_provider');
$condition=array("sp_delete"=>0,"society_id"=>$s_society_id);
$this->set('result_service_provider',$this->service_provider->find('all',array('conditions'=>$condition)));

}

function service_provider_excel(){
	
$this->layout=null;	
$this->ath();	
$s_society_id=$this->Session->read('society_id');
$result_society=$this->society_name($s_society_id);
$this->set('society_name',$result_society[0]['society']['society_name']);
$this->set('role_id',$s_role_id=$this->Session->read('role_id'));
$this->loadmodel('service_provider');
$condition=array("sp_delete"=>0,"society_id"=>$s_society_id);
$this->set('result_service_provider',$this->service_provider->find('all',array('conditions'=>$condition)));
	
	
	
}



function service_provider_delete()
{
$this->layout='blank';	
$id=(int)$this->request->query('con');
$this->loadmodel('service_provider');
$this->service_provider->updateAll(array('sp_delete'=>1),array('sp_id'=>$id));
$this->redirect(array('controller' => 'Helpdesks','action' => 'service_provider_view'));
}

function service_provider_mail()
{

$this->layout='blank';
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$society_result= $this->society_name($s_society_id);
foreach($society_result as $data)
{
	$society_name=$data['society']['society_name'];
}
$subject="[$society_name]";
$ip=$this->hms_email_ip();
$text=htmlentities($this->request->query('con2'));
$message = wordwrap($text, 25, " ", true);
$to=$this->request->query('con3');
$this->loadmodel('user');
$conditions=array("user_id"=>$s_user_id);
$result=$this->user->find('all',array('conditions'=>$conditions));
foreach ($result as $collection) 
{ 
  $email=$collection['user']["email"];
}

$message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br></br><p>$message,</p><br/>
<br/>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.in
</div>
</div>";


$from_name="HousingMatters";
$from="support@housingmatters.in";
$reply=$email;
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);

}

function service_provider_edit($id=null)
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$id=(int)$id;
$this->loadmodel('service_provider');
$conditions=array("sp_id"=> $id);
$res= $this->service_provider->find('all',array('conditions'=>$conditions));
foreach ($res as $collection) 
{
$attachment=@$collection['service_provider']['sp_attachment'];
$Contract_start=@$collection['service_provider']['sp_cont_start'];
$Contract_end=@$collection['service_provider']['sp_cont_end'];
}
$this->set('result_sp',$this->service_provider->find('all',array('conditions'=>$conditions))); 
if($this->request->is('post'))
{


$pan_number = $this->request->data['pan_no'];

@$file_upload=$this->request['form']['file']['name'];
if(empty($file_upload))
{
$file_upload=$attachment;
}

$text=htmlentities($this->request->data['name']);	
$name=wordwrap($text, 25, " ", true);
$text1=htmlentities($this->request->data['person']);
$person = wordwrap($text1, 25, " ", true);
$mobile=$this->request->data['mobile'];
$email=$this->request->data['email'];
@$cont_start=$this->request->data['cont_start'];
@$cont_end=$this->request->data['cont_end'];
$radio=$this->request->data['amc'];
if($radio==1)
{
$Contract_type="AMC";
}
else
{
$Contract_type="Adhoc";
}
if(empty($cont_start))
{
$cont_start= $Contract_start;
$cont_end= $Contract_end;
}
	$target = "service_provider_file/";
	$target=@$target.basename( @$this->request->form['file']['name']);
	$ok=1;
	move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target); 

	
	
$this->loadmodel('service_provider');
$this->service_provider->updateAll(array("sp_name" => $name,"sp_mobile"=>$mobile,'sp_person'=> 
$person,"sp_email"=>$email,"sp_attachment"=>$file_upload,'sp_cont_start'=>$cont_start,
'sp_cont_end'=> $cont_end,'sp_contract_type'=> $Contract_type,"pan_number"=>$pan_number),array("sp_id" => $id));
		
$this->loadmodel('ledger_sub_account');
$this->ledger_sub_account->updateAll(array("name"=> $name),array("sp_id" => $id));
	

$this->loadmodel('vendor');
$conditions=array('vendor_id'=>$id);
$this->vendor->deleteAll($conditions);

$this->loadmodel('help_desk_category');
$result=$this->help_desk_category->find('all');
foreach ($result as $collection)
{ 
$id2=$collection['help_desk_category']['help_desk_category_id'];
$servies=$collection['help_desk_category']['help_desk_category_name'];
echo @$check_id=(int)$this->request->data[$id2];
if(!empty($check_id))
{
$this->loadmodel('vendor');
$j=$this->autoincrement('vendor','auto_id');
$this->vendor->saveAll(array("auto_id" => $j, "vendor_id" => $id, "category_id" =>  $check_id));
}
}
$this->redirect(array('controller' => 'Helpdesks','action' => 'service_provider_view'));
}
$this->loadmodel('help_desk_category');	
$order=array('help_desk_category.help_desk_category_name'=>'ASC');
$result=$this->help_desk_category->find('all',array('order'=>$order));
$this->set('result_help_desk_category',$result);

$this->loadmodel('vendor');	
$conditions=array('vendor_id'=>$id);
$vvndrr=$this->vendor->find('all',array('conditions'=>$conditions));
$this->set('vvndrr',$vvndrr);

}
///////////////////////////////////////////////// Service Provider End ///////////////////////////////...............................////////////////////////
/////////////////////////////////////////////////////End Help Desk /////////////////////////




}
?>