<?php
App::import('Controller', 'Hms');
class BroadcastsController extends HmsController {
var $helpers = array('Html', 'Form','Js');
public $components = array(
'Paginator',
'Session','Cookie','RequestHandler'
);


var $name = 'Broadcasts';



////////////////////////////////////////////////////////////////////////////////////////	
/////////////////////////////////////////////////////start Message//////////////////////
////////////////////////////////////////////////////////////////////////////////////////	
function message()
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();

$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id'); 

$this->loadmodel('user');
$conditions=array("society_id"=>$s_society_id,'user.mobile'=> array('$ne' => ""));
$this->set('result_users',$this->user->find('all',array('conditions'=>$conditions))); 

$this->loadmodel('group');
$conditions=array("society_id"=>$s_society_id);
$result_group=$this->group->find('all',array('conditions'=>$conditions)); 
$this->set('result_group',$result_group); 

$this->loadmodel('role');
$conditions=array("society_id" => $s_society_id);
$role_result=$this->role->find('all',array('conditions'=>$conditions));
$this->set('role_result',$role_result);
$this->loadmodel('wing');
$wing_result=$this->wing->find('all');
$this->set('wing_result',$wing_result);


$this->loadmodel('template');
$conditions=array("cat"=>1);
$this->set('result_template1',$this->template->find('all',array('conditions'=>$conditions))); 

$this->loadmodel('template');
$conditions=array("cat"=>2);
$this->set('result_template2',$this->template->find('all',array('conditions'=>$conditions))); 

$this->loadmodel('template');
$conditions=array("cat"=>3);
$this->set('result_template3',$this->template->find('all',array('conditions'=>$conditions))); 

$this->loadmodel('template');
$conditions=array("cat"=>4);
$this->set('result_template4',$this->template->find('all',array('conditions'=>$conditions))); 

$this->loadmodel('template');
$conditions=array("cat"=>5);
$this->set('result_template5',$this->template->find('all',array('conditions'=>$conditions))); 

$this->loadmodel('template');
$conditions=array("cat"=>6);
$this->set('result_template6',$this->template->find('all',array('conditions'=>$conditions))); 

$this->loadmodel('template');
$conditions=array("cat"=>7);
$this->set('result_template7',$this->template->find('all',array('conditions'=>$conditions))); 

if (isset($this->request->data['send'])) 
{
$radio=$this->request->data['radio'];
$s_date=$this->request->data['date'];
$d = explode("-", $s_date);
$s_date_ex0=$d[0];
$s_date_ex1=$d[1];
$s_date_ex2=$d[2];
$time_h=$this->request->data['time_h'];
$time_m=$this->request->data['time_m'];
//$time_m=30;

$date=date("d-m-y");
$time=date('h:i:a',time());

$massage=$this->request->data['massage'];
$massage_str=str_replace(' ', '+', $massage);

$result_user_info=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($s_user_id)));
foreach ($result_user_info as $collection2) 
{
$name=$collection2["user"]["user_name"];
$wing=$collection2["user"]["wing"];
$flat=$collection2["user"]["flat"];
$sender_email=$collection2["user"]["email"];
$sender_mobile=$collection2["user"]["mobile"];
}



$r_sms=$this->hms_sms_ip();
  $working_key=$r_sms->working_key;
 $sms_sender=$r_sms->sms_sender; 
$sms_allow=(int)$r_sms->sms_allow;

if($radio==1)
{
$multi=$this->request->data['multi'];
$multi[]="$s_user_id,$sender_mobile";

$multi=array_unique($multi);

for($i=0; $i<sizeof($multi); $i++)
{
$multi_new=$multi[$i];
$ex = explode(",", $multi_new);
$mobile[]=$ex[1];
$user[]=$ex[0];
}
$mobile_im=implode(",", $mobile);
//$user=implode(",", $user); 

$s_date_ex0.$s_date_ex1.$s_date_ex2.$time_h.$time_m;
if($sms_allow==1){
$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile_im.'&message='.$massage_str.'&time='.$s_date_ex0.$s_date_ex1.$s_date_ex2.$time_h.$time_m);

}	


$sms_id=$this->autoincrement('sms','sms_id');
$this->loadmodel('sms');
$multipleRowData = Array( Array("sms_id" => $sms_id,"text"=>$massage,"user_id"=>$user,"date"=>$date,"time"=>$time,"society_id"=>$s_society_id,"type"=>1,"deleted"=>0));
$this->sms->saveAll($multipleRowData);
}

if($radio==2)
{
$user_new = array(); 
foreach ($result_group as $collection) 
{
$group_id=$collection["group"]["group_id"];

$g_id=@$this->request->data['grp'.$group_id];
if(!empty($g_id))
{
$groups_id[]=(int)$g_id;
$users=$collection["group"]["users"];
$user_new=array_merge($user_new,$users);
}
}
$result_user_unique = array_unique($user_new);


foreach ($result_user_unique as $data) 
{
$data=(int)$data;
$result_user_info=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($data)));
foreach ($result_user_info as $collection2) 
{
$mobile[]=$collection2["user"]["mobile"];
}
}
$mobile_im=implode(",", $mobile);

$r_sms=$this->hms_sms_ip();
  $working_key=$r_sms->working_key;
 $sms_sender=$r_sms->sms_sender; 
$sms_allow=(int)$r_sms->sms_allow;
if($sms_allow==1){
$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile_im.'&message='.$massage_str.'&time='.$s_date_ex0.$s_date_ex1.$s_date_ex2.$time_h.$time_m);
}
$sms_id=$this->autoincrement('sms','sms_id');
$this->loadmodel('sms');
$multipleRowData = Array( Array("sms_id" => $sms_id,"text"=>$massage,"user_id"=>$result_user_unique,"date"=>$date,"time"=>$timd,"type"=>2,"society_id"=>$s_society_id,"deleted"=>0));	
$this->sms->saveAll($multipleRowData);
}



if($radio==3)
{
$visible=(int)$this->request->data['visible'];
	if($visible==1)
	{	
	$visible=1;
	$sub_visible[]=0;
	/////////////////////////////////////////// All user ////////////////////////////
	$this->loadmodel('user');
	$conditions=array('society_id'=>$s_society_id,'deactive'=>0);
	$result_user=$this->user->find('all',array('conditions'=>$conditions));
	foreach($result_user as $data)
	{
	$da_to[]=$data['user']['mobile'];
	$da_user_name[]=$data['user']['user_name'];
	$da_user_id[]=$data['user']['user_id'];
	}
	/////////////////////////////////////////// All user ////////////////////////////
	}
	
	if($visible==4)
	{	
	$visible=4;
	$sub_visible[]=0;
	/////////////////////////////////////////// All Owners ////////////////////////////
	$this->loadmodel('user');
	$conditions=array('tenant'=>1,'society_id'=>$s_society_id,'deactive'=>0);
	$result_user=$this->user->find('all',array('conditions'=>$conditions));
	foreach($result_user as $data)
	{
	$da_to[]=$data['user']['mobile'];
	$da_user_name[]=$data['user']['user_name'];
	$da_user_id[]=$data['user']['user_id'];
	}
	/////////////////////////////////////////// All Owners ////////////////////////////
	}
	
	if($visible==5)
	{
	$visible=5;
	$sub_visible[]=0;
	/////////////////////////////////////////// All Tenant ////////////////////////////
	$this->loadmodel('user');
	$conditions=array('tenant'=>2,'society_id'=>$s_society_id,'deactive'=>0);
	$result_user=$this->user->find('all',array('conditions'=>$conditions));
	foreach($result_user as $data)
	{
	$da_to[]=$data['user']['mobile'];
	$da_user_name[]=$data['user']['user_name'];
	$da_user_id[]=$data['user']['user_id'];
	}
	/////////////////////////////////////////// All Tenant ////////////////////////////
	}
	
	if($visible==2)
	{	
	$visible=2;
	foreach ($role_result as $collection) 
	{
	$role_id=$collection["role"]["role_id"];

	$role_id=@(int)$this->request->data['role'.$role_id];
	if(!empty($role_id))
	{
	$sub_visible[]=(int)$role_id;

	/////////////////////////////////////////// All role  functionality  conditions /////////////////////////////////////////////
	$this->loadmodel('user');
	$conditions=array('role_id'=>$role_id,'society_id'=>$s_society_id,'deactive'=>0);
	$result_user=$this->user->find('all',array('conditions'=>$conditions));
	foreach($result_user as $data)
	{
	$da_to[]=$data['user']['mobile'];
	$da_user_name[]=$data['user']['user_name'];
	$da_user_id[]=$data['user']['user_id'];
	}

	//////////////////////////////// end mail ////////////////////////////////////////////////////////	


	}
	}
	$da_user_id=array_unique($da_user_id);
	}
	
	if($visible==3)
	{	
	$visible=3;
	foreach ($wing_result as $collection) 
	{
	$wing_id=$collection["wing"]["wing_id"];

	$wing=@(int)$this->request->data['wing'.$wing_id];
	if(!empty($wing))
	{
	$sub_visible[]=(int)$wing;


	/////////////////////////////////////////// All wing wise  functionality conditions //////////////////////////////////////////////////////
	$this->loadmodel('user');
	$conditions=array('wing'=>$wing_id,'society_id'=>$s_society_id,'deactive'=>0);
	$result_user=$this->user->find('all',array('conditions'=>$conditions));
	foreach($result_user as $data)
	{
		if(!empty($data['user']['mobile']))
		{
			$da_to[]=$data['user']['mobile'];
			$da_user_name[]=$data['user']['user_name'];
			$da_user_id[]=$data['user']['user_id'];
		}
	
	}
	}
	}
	}
$da_to[]=$sender_email;
$da_user_id=array_unique($da_user_id);	
$da_to=array_unique($da_to);	
$da_to=array_filter($da_to);
$mobile_im=implode(',',$da_to);

	$r_sms=$this->hms_sms_ip();
	$working_key=$r_sms->working_key;
	$sms_sender=$r_sms->sms_sender; 
	$sms_allow=(int)$r_sms->sms_allow;
	if($sms_allow==1){
	$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile_im.'&message='.$massage_str.'&time='.$s_date_ex0.$s_date_ex1.$s_date_ex2.$time_h.$time_m);
	}
$sms_id=$this->autoincrement('sms','sms_id');
$this->loadmodel('sms');
$multipleRowData = Array( Array("sms_id" => $sms_id,"text"=>$massage,"user_id"=>$da_user_id,"date"=>$date,"time"=>$time,"type"=>1,"society_id"=>$s_society_id,"deleted"=>0));	


$this->sms->saveAll($multipleRowData);

}

?>
<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Your SMS has been Sent.
</div> 
<div class="modal-footer">
<a href="message_view" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php	

}


}




function message_view()
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
}else{
	$this->layout='session';
}
$this->ath();
$this->check_user_privilages();
$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id'); 

$this->loadmodel('sms');
$conditions=array("society_id"=>$s_society_id,"deleted"=>0);
$order=array('sms.sms_id'=>'DESC');
$this->set('result_sms',$this->sms->find('all',array('conditions'=>$conditions,'order'=>$order))); 
}

function message_view_ajax()
{
$this->layout='blank';
$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id'); 

$id=(int)$this->request->query('id');

$this->loadmodel('sms');
$conditions=array("sms_id"=>$id);
$this->set('result_smsview',$this->sms->find('all',array('conditions'=>$conditions))); 

}

//////////////////////////////////////////////////////////////////////////////
///////////////////////////EMAIL///////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
function email()
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();

$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id'); 


$this->loadmodel('user');
$conditions=array("society_id"=>$s_society_id,'user.email'=> array('$ne' => ""));
$this->set('result_users',$this->user->find('all',array('conditions'=>$conditions))); 

$this->loadmodel('group');
$conditions=array("society_id"=>$s_society_id,"group_show_id"=>1);
$result_group=$this->group->find('all',array('conditions'=>$conditions)); 
$this->set('result_group',$result_group); 

$this->loadmodel('role');
$conditions=array("society_id" => $s_society_id);
$role_result=$this->role->find('all',array('conditions'=>$conditions));
$this->set('role_result',$role_result);
$this->loadmodel('wing');
$wing_result=$this->wing->find('all');
$this->set('wing_result',$wing_result);


$this->loadmodel('template');
$conditions=array("cat"=>1);
$this->set('result_template1',$this->template->find('all',array('conditions'=>$conditions))); 

$this->loadmodel('template');
$conditions=array("cat"=>2);
$this->set('result_template2',$this->template->find('all',array('conditions'=>$conditions))); 

$this->loadmodel('template');
$conditions=array("cat"=>3);
$this->set('result_template3',$this->template->find('all',array('conditions'=>$conditions))); 

$this->loadmodel('template');
$conditions=array("cat"=>4);
$this->set('result_template4',$this->template->find('all',array('conditions'=>$conditions))); 

$this->loadmodel('template');
$conditions=array("cat"=>5);
$this->set('result_template5',$this->template->find('all',array('conditions'=>$conditions))); 

$this->loadmodel('template');
$conditions=array("cat"=>6);
$this->set('result_template6',$this->template->find('all',array('conditions'=>$conditions))); 

$this->loadmodel('template');
$conditions=array("cat"=>7);
$this->set('result_template7',$this->template->find('all',array('conditions'=>$conditions))); 

if (isset($this->request->data['send'])) 
{
	$ip=$this->hms_email_ip();
 $radio=$this->request->data['radio'];
$message_db=$this->request->data['email'];
$file=$this->request->form['file']['name'];


$this->loadmodel('society');
$conditions12=array('society_id'=>$s_society_id);
$result12=$this->society->find('all',array('conditions'=>$conditions12));
foreach($result12 as $data)
{
$s_name=$data['society']['society_name'];
}


$result_user_info=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($s_user_id)));
foreach ($result_user_info as $collection2) 
{
$name=$collection2["user"]["user_name"];
$wing=$collection2["user"]["wing"];
$flat=$collection2["user"]["flat"];
$sender_email=$collection2["user"]["email"];

}
$wing_flat=$this->wing_flat($wing,$flat);
$result_society_info= $this->society_name($s_society_id);
foreach($result_society_info as $data_info)
{
	$society_name=$data_info['society']['society_name'];
}

$message_web='<div>
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
<br/>';

$message_web.='<table style="border-collapse: collapse; border: 1px solid rgb(204, 204, 204);" cellpadding="0" cellspacing="0" width="100%"><tbody>
		<tr>
			<td style="padding:5px" height="10">'.$message_db.'<br/><br/>
<div style="color: #7B7B7B;">Regards,</div>
<div style="color: #7B7B7B;">'.$name.'&nbsp;&nbsp;'.$wing_flat.'</div>
<div style="color: #7B7B7B;">'.$society_name.'</div>
</div >
</div></td>
		</tr>
	</tbody>
</table>';

if(!empty($file))
{
$message_web.='<br/><a href="'.$ip.'/'.$this->webroot.'email_file/'.$file.'" download>Download attachment</a>';
}


$message_web.='<br/><table>
<tr>
<td style="padding:10px;" width="100%" align="center">
<a href="'.$ip.$this->webroot.'Broadcasts/email_view" style="width: 100px; min-height: 30px; background-color: rgb(0, 142, 213); padding: 10px; font-family: Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif; white-space: nowrap; font-weight: bold; vertical-align: middle; font-size: 14px; line-height: 14px; color: rgb(255, 255, 255); border: 1px solid rgb(2, 106, 158); text-decoration: none;" target="_blank">view on HousingMtters</a>
</td>
</tr>

</table><br/>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td  width="15">&nbsp;&nbsp;&nbsp;</td>
	<td>
	<table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%">
		<tbody>
			
			<tr>
			<td  align="left" valign="middle" width="">
			Thank you <br/>HousingMatters (Support Team)<br/>www.housingmatters.in
			
			</td>
			<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
			
			
			</tr>
			
			</tbody>
	</table>
	</td>
			
</tr>
</table>';
$subject="[".$s_name."]-";
$subject.=htmlentities($this->request->data['subject']);

$target = "email_file/";
$target=@$target.basename( @$this->request->form['file']['name']);
$ok=1;
move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target); 

$date=date("d-m-y");
$time=date('h:i:a',time());

if($radio==1)
{
$multi=$this->request->data['multi'];
$multi[]="$s_user_id,$sender_email";
$multi=array_unique($multi);
foreach($multi as $data)
{
$ex = explode(",", $data);
$user[]=$ex[0];
$to=$ex[1];
//echo $email[$i];
$this->send_email($to,'support@housingmatters.in','HousingMatters',$subject,$message_web,'donotreply@housingmatters.in');
}
$email_id=$this->autoincrement('email_communication','email_id');
$this->loadmodel('email_communication');
$multipleRowData = Array( Array("email_id" => $email_id,"message_web"=>$message_web,"user_id"=>$user,"date"=>$date,"time"=>$time,"society_id"=>$s_society_id,"subject"=>$subject,"type"=>1,"file"=>$file,"deleted"=>0));
$this->email_communication->saveAll($multipleRowData); 

}

if($radio==2)
{
$user_new = array(); 
foreach ($result_group as $collection) 
{
$group_id=$collection["group"]["group_id"];

$g_id=@$this->request->data['grp'.$group_id];
if(!empty($g_id))
{
$groups_id[]=(int)$g_id;
$users=$collection["group"]["users"];
$user_new=array_merge($user_new,$users);
}
}
$result_user_unique = array_unique($user_new);

foreach ($result_user_unique as $data) 
{
$data=(int)$data;
$result_user_info=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($data)));
foreach ($result_user_info as $collection2) 
{
$to=$collection2["user"]["email"];
$this->send_email($to,'support@housingmatters.in','HousingMatters',$subject,$message_web,'donotreply@housingmatters.in');
}
}




$email_id=$this->autoincrement('email_communication','email_id');
$this->loadmodel('email_communication');
$multipleRowData = Array( Array("email_id" => $email_id,"message_web"=>$message_web,"user_id"=>$result_user_unique,"date"=>$date,"time"=>$time,"society_id"=>$s_society_id,"subject"=>$subject,"groups_id"=>$groups_id,"type"=>2,"file"=>$file,"deleted"=>0));
$this->email_communication->saveAll($multipleRowData); 
}

if($radio==3)
{
$visible=(int)$this->request->data['visible'];
	if($visible==1)
	{	
	$visible=1;
	$sub_visible[]=0;
	/////////////////////////////////////////// All user ////////////////////////////
	$this->loadmodel('user');
	$conditions=array('society_id'=>$s_society_id,'deactive'=>0);
	$result_user=$this->user->find('all',array('conditions'=>$conditions));
	foreach($result_user as $data)
	{
	$da_to[]=$data['user']['email'];
	$da_user_name[]=$data['user']['user_name'];
	$da_user_id[]=$data['user']['user_id'];
	}
	/////////////////////////////////////////// All user ////////////////////////////
	}
	
	if($visible==4)
	{	
	$visible=4;
	$sub_visible[]=0;
	/////////////////////////////////////////// All Owners ////////////////////////////
	$this->loadmodel('user');
	$conditions=array('tenant'=>1,'society_id'=>$s_society_id,'deactive'=>0);
	$result_user=$this->user->find('all',array('conditions'=>$conditions));
	foreach($result_user as $data)
	{
	$da_to[]=$data['user']['email'];
	$da_user_name[]=$data['user']['user_name'];
	$da_user_id[]=$data['user']['user_id'];
	}
	/////////////////////////////////////////// All Owners ////////////////////////////
	}
	
	if($visible==5)
	{
	$visible=5;
	$sub_visible[]=0;
	/////////////////////////////////////////// All Tenant ////////////////////////////
	$this->loadmodel('user');
	$conditions=array('tenant'=>2,'society_id'=>$s_society_id,'deactive'=>0);
	$result_user=$this->user->find('all',array('conditions'=>$conditions));
	foreach($result_user as $data)
	{
	$da_to[]=$data['user']['email'];
	$da_user_name[]=$data['user']['user_name'];
	$da_user_id[]=$data['user']['user_id'];
	}
	/////////////////////////////////////////// All Tenant ////////////////////////////
	}
	
	if($visible==2)
	{	
	$visible=2;
	foreach ($role_result as $collection) 
	{
	$role_id=$collection["role"]["role_id"];

	$role_id=@(int)$this->request->data['role'.$role_id];
	if(!empty($role_id))
	{
	$sub_visible[]=(int)$role_id;

	/////////////////////////////////////////// All role  functionality  conditions /////////////////////////////////////////////
	$this->loadmodel('user');
	$conditions=array('role_id'=>$role_id,'society_id'=>$s_society_id,'deactive'=>0);
	$result_user=$this->user->find('all',array('conditions'=>$conditions));
	foreach($result_user as $data)
	{
	$da_to[]=$data['user']['email'];
	$da_user_name[]=$data['user']['user_name'];
	$da_user_id[]=$data['user']['user_id'];
	}

	//////////////////////////////// end mail ////////////////////////////////////////////////////////	


	}
	}
	$da_user_id=array_unique($da_user_id);
	}
	
	if($visible==3)
	{	
	$visible=3;
	foreach ($wing_result as $collection) 
	{
	$wing_id=$collection["wing"]["wing_id"];

	$wing=@(int)$this->request->data['wing'.$wing_id];
	if(!empty($wing))
	{
	$sub_visible[]=(int)$wing;


	/////////////////////////////////////////// All wing wise  functionality conditions //////////////////////////////////////////////////////
	$this->loadmodel('user');
	$conditions=array('wing'=>$wing_id,'society_id'=>$s_society_id,'deactive'=>0);
	$result_user=$this->user->find('all',array('conditions'=>$conditions));
	foreach($result_user as $data)
	{
	$da_to[]=$data['user']['email'];
	$da_user_name[]=$data['user']['user_name'];
	$da_user_id[]=$data['user']['user_id'];
	}
	}
	}
	}
$da_to[]=$sender_email;
$da_user_id=array_unique($da_user_id);	
$da_to=array_unique($da_to);
$da_to=array_filter($da_to);


foreach($da_to as $data)
{

$ex = explode(",", $data);
if(!empty($ex[0])) { $to=$ex[0]; }


//echo $email[$i];
$this->send_email($to,'support@housingmatters.in','HousingMatters',$subject,$message_web,'donotreply@housingmatters.in');
}




$email_id=$this->autoincrement('email_communication','email_id');
$this->loadmodel('email_communication');
$multipleRowData = Array( Array("email_id" => $email_id,"message_web"=>$message_web,"user_id"=>$da_user_id,"date"=>$date,"time"=>$time,"society_id"=>$s_society_id,"subject"=>$subject,"type"=>1,"file"=>$file,"deleted"=>0));
$this->email_communication->saveAll($multipleRowData); 

}


?>
<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Your Email has been sent.
</div> 
<div class="modal-footer">
<a href="email_view" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php	

}
}


function email_view()
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();
$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id'); 

$this->loadmodel('email_communication');
$conditions=array("society_id"=>$s_society_id,"deleted"=>0);
$order=array('email_communication.email_id'=>'DESC');
$this->set('result_email',$this->email_communication->find('all',array('conditions'=>$conditions,'order'=>$order))); 
}



function email_view_ajax()
{
$this->layout='blank';
$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id'); 


$this->loadmodel('society');
$conditions12=array('society_id'=>$s_society_id);
$result12=$this->society->find('all',array('conditions'=>$conditions12));
foreach($result12 as $data)
{
$this->set('s_name',$data['society']['society_name']);
}


$id=(int)$this->request->query('id');

$this->loadmodel('email_communication');
$conditions=array("email_id"=>$id);
$this->set('result_eamilview',$this->email_communication->find('all',array('conditions'=>$conditions))); 

}

function email_delete()
{
$this->layout='blank';

$id=(int)$this->request->query('id');

$this->loadmodel('email_communication');
$this->email_communication->updateAll(array("deleted" => 1),array("email_id" => $id));

$this->response->header('Location', 'email_view');
}

function sms_delete()
{
$this->layout='blank';

$id=(int)$this->request->query('id');

$this->loadmodel('sms');
$this->sms->updateAll(array("deleted" => 1),array("sms_id" => $id));

$this->response->header('Location', 'message_view');
}


function testing_pdf(){
	
}
function email_view_pdf()
{
//$this->layout = 'pdf'; //this will use the pdf.ctp layout 
$this->ath(); 

$con=(int)$this->request->query('con');
$this->set('con',$con);

$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id'); 


$this->loadmodel('email_communication');
$conditions=array("email_id"=>$con);
$this->set('result_eamilview',$this->email_communication->find('all',array('conditions'=>$conditions))); 
}

function sms_view_pdf()
{
//$this->layout = 'pdf'; //this will use the pdf.ctp layout 
$this->ath(); 

$con=(int)$this->request->query('con');
$this->set('con',$con);

$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id'); 


$this->loadmodel('sms');
$conditions=array("sms_id"=>$con);
$this->set('result_smsview',$this->sms->find('all',array('conditions'=>$conditions))); 
}

////////////////////////////////////////////////////////////////////////////////////////	
/////////////////////////////////////////////////////start groups//////////////////////
////////////////////////////////////////////////////////////////////////////////////////
function groups()
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();
$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id'); 

if (isset($this->request->data['add'])) 
{
	$group_name=$this->request->data['group_name'];

	$this->loadmodel('group');
	$conditions=array("society_id"=>$s_society_id,"group_name"=>$group_name);
	$group_duplicate=$this->group->find('count',array('conditions'=>$conditions));

	
	if(!empty($group_name) and ($group_duplicate==0))
	{
	$group_id=$this->autoincrement('group','group_id');
	$this->loadmodel('group');
	$multipleRowData = Array( Array("group_id" => $group_id,"group_name"=>$group_name,'group_show_id'=>1,"society_id"=>$s_society_id,"users"=>array()));
	$this->group->saveAll($multipleRowData); 
	$this->response->header('Location', 'groupview/'.$group_id);
	}
	else{
		$this->set('error_addgroup','Group name should not be duplicate.');
	}
}

$this->loadmodel('group');
$conditions=array("society_id"=>$s_society_id,'group_show_id'=>1);
$order=array('group.group_id'=>'DESC');
$this->set('result_group',$this->group->find('all',array('conditions'=>$conditions,'order'=>$order))); 
}

function groupview($gid=null) 
{
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	
	$this->ath();
	//$this->check_user_privilages();
	$s_user_id=$this->Session->read('user_id'); 
	$s_society_id=$this->Session->read('society_id'); 
	$gid=(int)$gid;
	$this->set('gid',$gid);
	$group_name=$this->fetch_group_name_from_gruop_id($gid);
	$this->set('group_name',$group_name);
	
	if (isset($this->request->data['update_members'])) 
	{
		$all_users=$this->all_user_deactive();
		$members=array();
		foreach($all_users as $user)
		{
		
			$value=@$this->request->data['user'.$user['user']['user_id']];
			if(!empty($value)) { $members[]=$user['user']['user_id']; }
		}
		
		$this->loadmodel('group');
		$this->group->updateAll(array("users" =>$members),array("group_id" => $gid));
	}
	
	$this->loadmodel('group');
	$conditions=array("group_id" => $gid);
	$result_group_info=$this->group->find('all',array('conditions'=>$conditions));
	
	$result_group_info=$result_group_info[0]['group']['users'];

	$this->set('result_group_info',$result_group_info);
	$this->set('all_users',$this->all_user_deactive());
}


function fetch_group_name_from_gruop_id($group_id)
{


$this->loadmodel('group');
$conditions=array("group_id" => $group_id);
$result_group_name=$this->group->find('all',array('conditions'=>$conditions));

foreach ($result_group_name as $collection) 
{
return $group_name=$collection['group']['group_name'];
}
}

} ?>