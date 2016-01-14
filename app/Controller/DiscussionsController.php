<?php
App::import('Controller', 'Hms');
class DiscussionsController extends HmsController {
var $helpers = array('Html', 'Form','Js');
public $components = array(
'Paginator',
'Session','Cookie','RequestHandler'
);


var $name = 'Discussions';




function index($id=null,$list=null){
	if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
	$this->ath();
	$this->set('id',$id);
	$id=(int)$this->decode($id,'housingmatters');
	$this->set('list',$list);
	
	
	$s_user_id=$this->Session->read('user_id'); 
	$s_society_id=$this->Session->read('society_id');
	$s_role_id=$this->Session->read('role_id');
	$this->set('s_user_id',$s_user_id);
	$tenant=$this->Session->read('tenant');
	$role_id=$this->Session->read('role_id');
	$wing=$this->Session->read('wing');

	$this->seen_notification(3,$id);

	//////////////////////current user info///////////////
	$result_self=$this->profile_picture($s_user_id);
	foreach($result_self as $data3)
	{
	$this->set('user_name',$data3["user"]["user_name"]);
	$wing=$data3["user"]["wing"];
	$flat=$data3["user"]["flat"];
	}
	$this->set('flat_info',$this->wing_flat($wing,$flat));
	//////////////////////current user info///////////////

	$this->loadmodel('role');
	$conditions=array("society_id" => $s_society_id);
	$role_result=$this->role->find('all',array('conditions'=>$conditions));
	$this->set('role_result',$role_result);

	$this->loadmodel('wing');
	$wing_result=$this->wing->find('all');
	$this->set('wing_result',$wing_result);

	//////////////////////view///////////////
	$this->loadmodel('discussion_post');

	if($list==0 or empty($list))
	{
		
		
		$conditions =array( '$or' => array( 
		array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>1,'users'=>$s_user_id),
		array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>2,'users'=>$s_user_id,'sub_visible' =>array('$in' => array($role_id))),
		array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>3,'users'=>$s_user_id,'sub_visible' =>array('$in' => array($wing))),
		array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>4,'users'=>$s_user_id),
		array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>5,'users'=>$s_user_id)
		));
		
	}
	if($list==1)
	{
		
		$conditions =array( '$or' => array( 
		array('user_id' =>$s_user_id,'delete_id' =>0,'visible' =>1,),
		array('user_id' =>$s_user_id,'delete_id' =>0,'visible' =>2,'sub_visible' =>array('$in' => array($role_id))),
		array('user_id' =>$s_user_id,'delete_id' =>0,'visible' =>3,'sub_visible' =>array('$in' => array($wing))),
		array('user_id' =>$s_user_id,'delete_id' =>0,'visible' =>4,),
		array('user_id' =>$s_user_id,'delete_id' =>0,'visible' =>5,)
		));
	}
	if($list==2)
	{
		$conditions =array( '$or' => array( 
		array('society_id' =>$s_society_id,'delete_id' =>1,'visible' =>1),
		array('society_id' =>$s_society_id,'delete_id' =>1,'visible' =>2,'sub_visible' =>array('$in' => array($role_id))),
		array('society_id' =>$s_society_id,'delete_id' =>1,'visible' =>3,'sub_visible' =>array('$in' => array($wing))),
		array('society_id' =>$s_society_id,'delete_id' =>1,'visible' =>4),
		array('society_id' =>$s_society_id,'delete_id' =>1,'visible' =>5)
		));
	}

	$order=array('discussion_post.discussion_post_id'=>'DESC');
	$this->set('result_discussion',$this->discussion_post->find('all',array('conditions'=>$conditions,'order'=>$order)));   


	$this->loadmodel('discussion_post');
	if(empty($id)){
		$conditions =array( '$or' => array( 
		array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>1),
		array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>2,'sub_visible' =>array('$in' => array($role_id))),
		array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>3,'sub_visible' =>array('$in' => array($wing))),
		array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>4),
		array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>5)
		));
	}
	else{
		$this->loadmodel('discussion_post');
		$conditions=array('discussion_post_id' =>$id,'users' =>array('$in' => array($s_user_id)));
		$count=$this->discussion_post->find('count',array('conditions'=>$conditions));
		if($count>0){ $conditions=array('discussion_post_id' =>$id);	}
		else{
			
			$conditions =array( '$or' => array( 
			array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>1),
			array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>2,'sub_visible' =>array('$in' => array($role_id))),
			array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>3,'sub_visible' =>array('$in' => array($wing))),
			array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>4),
			array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>5)
			));
		
		}
	}

	$order=array('discussion_post.discussion_post_id'=>'DESC');
	$result_discussion_last=$this->discussion_post->find('all',array('conditions'=>$conditions,'order'=>$order,'limit'=>1));
	foreach($result_discussion_last as $data2)
	{
	  $discussion_post_id=(int)$data2["discussion_post"]["discussion_post_id"];
	}
	$this->set('result_discussion_last',$result_discussion_last);
	$this->set('last_discussion_post_id',@$discussion_post_id); 	

	$this->loadmodel('discussion_comment');
	$conditions =array( '$or' => array( 
	array('discussion_post_id' =>@$discussion_post_id,'delete_id' =>0),array('discussion_post_id' =>@$discussion_post_id,'delete_id' =>2)));
	$this->set('result_comment_last',$this->discussion_comment->find('all',array('conditions'=>$conditions))); 
	
}

function new_topic(){
	if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
	$this->ath();
	
	
	
	$s_user_id=$this->Session->read('user_id'); 
	$s_society_id=$this->Session->read('society_id');
	$s_role_id=$this->Session->read('role_id');
	$this->set('s_user_id',$s_user_id);
	$tenant=$this->Session->read('tenant');
	$role_id=$this->Session->read('role_id');
	$wing=$this->Session->read('wing');


	//////////////////////current user info///////////////
	$result_self=$this->profile_picture($s_user_id);
	foreach($result_self as $data3)
	{
	$this->set('user_name',$data3["user"]["user_name"]);
	$wing=$data3["user"]["wing"];
	$flat=$data3["user"]["flat"];
	}
	$this->set('flat_info',$this->wing_flat($wing,$flat));
	//////////////////////current user info///////////////
	$this->loadmodel('role');
	$conditions=array("society_id" => $s_society_id);
	$role_result=$this->role->find('all',array('conditions'=>$conditions));
	$this->set('role_result',$role_result);

	$this->loadmodel('wing');
	$wing_result=$this->wing->find('all');
	$this->set('wing_result',$wing_result);
	///////////////////////start new topic//////////////////////////////////

	$result_soc=$this->society_name($s_society_id);
	foreach($result_soc as $data)
	{
		 @$discussion_forum1=$data['society']['discussion_forum'];
		 @$s_duser_id[]=$data['society']['user_id'];
	}
if($discussion_forum1==1 && $s_role_id!=3)
{
	
	if ($this->request->is('post')) 
	{
		
		 $text=htmlentities($this->request->data['topic']);
		$topic = wordwrap($text, 25, " ", true);

		$text12=htmlentities($this->request->data['description']);
		 $description = nl2br(wordwrap($text12, 25, " ", true));

		$file=$this->request->form['file']['name'];

		$target = "discussion_file/";
		$target=@$target.basename( @$this->request->form['file']['name']);
		$ok=1;
		move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target); 

		$date=date("d-m-y");
		 $time=date('h:i:a',time());
		$visible=(int)$this->request->data['visible'];
			if($visible==1)
			{	
			$visible=1;
			$sub_visible[]=0;
			}

			if($visible==4)
			{	
			$visible=4;
			$sub_visible[]=0;
			}

			if($visible==5)
			{
			$visible=5;
			$sub_visible[]=0;
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
							}
						}
					}
		
			if($visible==3)
					{	
					 $visible=3;
						foreach ($wing_result as $collection) 
						{
							$wing_id=(int)$collection["wing"]["wing_id"];

							$wing=@(int)$this->request->data['wing'.$wing_id];
							if(!empty($wing))
							{
								$sub_visible[]=(int)$wing;
							}
						}
					}
						
	$discussion_post_id=$this->autoincrement('discussion_post','discussion_post_id');
	$this->loadmodel('discussion_post');
	$multipleRowData = Array( Array("discussion_post_id" => $discussion_post_id, "user_id" => $s_user_id , "society_id" => $s_society_id, "topic" => $topic,"description" => $description, "file" =>$file,"delete_id" =>4, "date" =>$date, "time" => $time, "visible" => $visible, "sub_visible" => $sub_visible));
	$this->discussion_post->saveAll($multipleRowData); 
	
$this->send_notification('<span class="label" style="background-color:#269abc;"><i class="icon-comment"></i></span>','Approval request for discussion <b>'.$topic.'</b> created by',3,$discussion_post_id,$this->webroot.'Hms/discussion_forum_approval',$s_user_id,$s_duser_id);		
		
		$this->Session->write('discussion_forum_status1',2);
		$this->response->header('Location', $this->webroot.'Discussions/index');

	
		
		
	}
}
else
{	
if($this->request->is('post')) 
{
	
	
	$ip=$this->hms_email_ip();
	$text=htmlentities($this->request->data['topic']);
	$topic = wordwrap($text, 25, " ", true);

	$text12=htmlentities($this->request->data['description']);
	$description = nl2br(wordwrap($text12, 25, " ", true));

	$file=$this->request->form['file']['name'];

	$target = "discussion_file/";
	$target=@$target.basename( @$this->request->form['file']['name']);
	$ok=1;
	move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target); 

	$date=date("d-m-y");
	$time=date('h:i:a',time());

	$visible=(int)$this->request->data['visible'];
	if($visible==1)
	{	
	$visible=1;
	$sub_visible[]=0;
	/////////////////////////////////////////// All user ////////////////////////////
	$result_user=$this->all_user_deactive();
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
	$result_user=$this->all_owner_deactive();
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
	$result_user=$this->all_tenant_deactive();
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
	
	$result_user=$this->all_role_wise_deactive($role_id);
	foreach($result_user as $data)
	{
	$da_to[]=$data['user']['email'];
	$da_user_name[]=$data['user']['user_name'];
	$da_user_id[]=$data['user']['user_id'];
	}

	//////////////////////////////// end mail ////////////////////////////////////////////////////////	


	}
	}
	$da_to=array_unique($da_to);
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
	
	$result_user=$this->all_wing_wise_deactive($wing_id);
	foreach($result_user as $data)
	{
	$da_to[]=$data['user']['email'];
	$da_user_name[]=$data['user']['user_name'];
	$da_user_id[]=$data['user']['user_id'];
	}

	//////////////////////////////// end mail ////////////////////////////////////////////////////////	



	}
	}

	}
	

	$discussion_post_id=$this->autoincrement('discussion_post','discussion_post_id');
	
	$this->loadmodel('discussion_post');
	
	$multipleRowData = Array( Array("discussion_post_id" => $discussion_post_id, "user_id" => $s_user_id , "society_id" => $s_society_id, "topic" => $topic,"description" => $description, "file" =>$file,"delete_id" =>0, "date" =>$date, "time" => $time, "visible" => $visible, "sub_visible" => $sub_visible,"users"=>$da_user_id));
	
	$this->discussion_post->saveAll($multipleRowData); 
	$disc_id=(int)$this->encode($discussion_post_id,'housingmatters');

	$discussion_post_id; 
	$en_discussion_post_id=$this->requestAction(array('controller' => 'hms', 'action' => 'encode'), array('pass' => array($discussion_post_id,'housingmatters'))); 
	
	$this->send_notification('<span class="label" style="background-color:#269abc;"><i class="icon-comment"></i></span>','New Discussion <b>'.$topic.'</b> created by',3,$discussion_post_id,$this->webroot.'Discussions/index/'.$disc_id.'/0',$s_user_id,$da_user_id);


	////////////////////////////////////////////// Email Code Start ////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	$this->loadmodel('email');
	$conditions=array('auto_id'=>10);
	$result_email=$this->email->find('all',array('conditions'=>$conditions));
	foreach ($result_email as $collection) 
	{
	$from=$collection['email']['from'];
	}
	$reply="donotreply@housingmatters.in";
	$from_name="HousingMatters";
	$sub=$topic;
	$result= $this->society_name($s_society_id);
	foreach($result as $data)
	{
		$society_name=$data['society']['society_name'];
		$dis_email_setting=@$data['society']['discussion_forum_email'];

	}

	$result_user=$this->profile_picture($s_user_id);
	foreach($result_user as $data1)
	{
	$user_name_post=$data1['user']['user_name'];
	$wing=$data1['user']['wing'];
	$flat=$data1['user']['flat'];
	$profile_pic=$data1['user']['profile_pic'];
	}
	$wing_flat=$this->wing_flat($wing,$flat);
	if($dis_email_setting==1)
	{
		
		$newDate = date("d-m-y", strtotime($date));
		$newDate1 = date("d-m-Y", strtotime($newDate));

	for($k=0;$k<sizeof($da_to);$k++)
	{
	$to = @$da_to[$k];
	$d_user_id = @$da_user_id[$k];	 
	$user_name = @$da_user_name[$k];	

	
	
	
	 /*$message_web='<table  align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
			<tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						
								<tr>
									<td width="40%" style="padding: 10px 0px 0px 10px;"><img src="'.$ip.$this->webroot.'as/hm/hm-logo.png" style="max-height: 60px; " height="50px" width="150" /></td>
									<td width="60%" align="right" valign="middle"  style="padding: 7px 10px 0px 0px;">
									<a href="https://www.facebook.com/HousingMatters.co.in" target="_blank"><img src="'.$ip.$this->webroot.'as/hm/fb.png"></a>
									<a href="#" target="_blank"><img src="'.$ip.$this->webroot.'as/hm/tw.png"></a>
									<a href=""><img src="'.$ip.$this->webroot.'as/hm/ln.png" class="test" style="margin-left:5px;"></a>
									</td>
								</tr>
								
									
								
						</tbody>
					</table>
					
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span style="color:rgb(100,100,99)" align="justify"> Hello '.$user_name.' </span> <br>
										</td>
								
								
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> A new topic is posted in your society Discussion Forum. </span>
									</td>
																
								</tr>
								
								
								<tr>
									<td>
									
										<table  cellpadding="5" cellspacing="0" width="100%;"border="1" style="border:1px solid #e5e5e5;">
						
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >New Discussion Topic</td>
										<td align="left" style="background-color:#f8f8f8;" >'.$topic.'</td>
										</tr>
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Posted by</td>
										<td align="left" style="background-color:#f8f8f8;"  >'.$user_name_post.'</td>
										</tr>
										
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;">Flat #</td>
										<td align="left" style="background-color:#f8f8f8;" >'.$wing_flat.'</td>
										</tr>
										
										
									
										</table> 
									
									</td>
								
								
								
								</tr>
								
								
					
								<tr>
										<td style="padding:5px;" width="100%" align="center">
										<span style="color:rgb(100,100,99)">To view or post response  <a href="'.$ip.$this->webroot.'" style="width:100px; height:30px;"><span style="background-color:#00A0E3;color:white;"><button style="width:100px; height:30px;  background-color:#00A0E3;color:white" id="bg_color_m"> Click Here </button> </span></a> </span>
										</td>
								</tr>
					

								<tr>
								<td style="" width="100%" align="left">
								<p>Thank you. <br/> HousingMatters (Support Team)</p>
								<p align="justify">	www.housingmatters.co.in </p>
								</td>
								</tr>

					
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';*/

$message_web='<div style="margin:0;padding:0" dir="ltr" bgcolor="#ffffff">
	<table style="border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" width="100%;">
		<tbody>
			<tr>
				<td style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;background:#ffffff">
					<table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%">
						<tbody>
							<tr>
								<td style="line-height:20px" colspan="3" height="20">&nbsp;</td>
							</tr>
							<tr>
								<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
								<td>
								<table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%">
								<tbody>
								<tr><td style="line-height:16px" colspan="4" height="16">&nbsp;</td></tr>
								<tr>
								<td style="height:32;line-height:0px" align="left" valign="middle" width="32"><a href="#" style="color:#3b5998;text-decoration:none" target="_blank"><img src="'.$ip.$this->webroot.'as/hm/HM-LOGO-small.jpg" style="border:0" height="50" width="50"></a></td>
								<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
								<td width="100%"><a href="#" style="color:#3b5998;text-decoration:none;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:19px;line-height:32px" target="_blank"><span style="color:#00A0E3">Housing</span><span style="color:#777776">Matters</span></a></td>
								<td align="right"><a href="https://www.facebook.com/HousingMatters.co.in" target="_blank"><img  src="'.$ip.$this->webroot.'as/hm/SMLogoFB.png" style="max-height:30px;min-height:30px;width:30px;max-width:30px" height="30px" width="30px"></a>
									
								</td>
								</tr>
								<tr style="border-bottom:solid 1px #e5e5e5"><td style="line-height:16px" colspan="4" height="16">&nbsp;</td></tr>
								</tbody>
								</table>
								</td>
								<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
							</tr>
							<tr>
								<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
								<td><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="line-height:28px" height="28">&nbsp;</td></tr><tr><td><span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:16px;line-height:21px;color:#141823">Hello  '.$user_name.'<br/>A new topic created in Discussion Forum</span></td></tr><tr><td style="line-height:14px" height="14">&nbsp;</td></tr><tr><td><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;border:solid 1px #e5e5e5;border-radius:2px;display:block"><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="padding:5px 10px;background:#269ABC;border-top:#cccccc 1px solid;border-bottom:#cccccc 1px solid"><span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:16px;line-height:19px;color:#FFF">'.$topic.'</span></td></tr><tr>
								<td style="padding:5px;">
								<table style="border-collapse:collapse" cellpadding="0" cellspacing="0"><tbody><tr><td style="padding-right:10px;font-size:0px" valign="middle"><a href="#" style="color:#3b5998;text-decoration:none" target="_blank"><img  src="'.$ip.$this->webroot.'profile/'.$profile_pic.'" style="border:0" height="50" width="50"></a></td>
								<td style="width:100%" valign="middle">
								<table style="border-collapse:collapse" cellpadding="0" cellspacing="0"><tbody><tr><td colspan="2">
								<span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:16px;line-height:21px;color:#141823">'.$user_name_post.' '.$wing_flat.'</span><br/><span style="color:#ADABAB;font-size: 12px;">'.$newDate1.'&nbsp;&nbsp;'.$time.'</span></td></tr><tr><td style="line-height:10px" colspan="2" height="10">&nbsp;</td></tr><tr><td width="100%"></td></tr></tbody></table>
								</td>
								</tr></tbody></table>
								</td>
							</tr>
							<tr>
								<td style="padding:5px;" height="10">'.$description.'</td>
							</tr>
						</tbody>
					</table></td></tr></tbody></table></td></tr><tr><td style="line-height:14px" height="14">&nbsp;</td></tr></tbody></table></td>
								<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
</tr>						<tr>
								<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
								<td>
									<table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="line-height:2px" colspan="3" height="2">&nbsp;</td></tr><tr><td><a href="#" style="color:#3b5998;text-decoration:none" target="_blank"><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="border-collapse:collapse;border-radius:2px;text-align:center;display:block;border:1px solid #026A9E;background:#008ED5;padding:7px 16px 11px 16px"><a href="'.$ip.$this->webroot.'Discussions/index/'.$en_discussion_post_id.'/0" style="color:#3b5998;text-decoration:none;display:block" target="_blank"><center><font size="3"><span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;white-space:nowrap;font-weight:bold;vertical-align:middle;color:#ffffff;font-size:14px;line-height:14px">View on HousingMatters</span></font></center></a></td></tr></tbody></table></a></td><td style="display:block;width:10px" width="10">&nbsp;&nbsp;&nbsp;</td><td><a href="#" style="color:#3b5998;text-decoration:none" target="_blank"><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="border-collapse:collapse;border-radius:2px;text-align:center;display:block;border:solid 1px #c9ccd1;background:#f6f7f8;padding:7px 16px 11px 16px"><a href="'.$ip.$this->webroot.'Discussions/index/'.$en_discussion_post_id.'/0" style="color:#3b5998;text-decoration:none;display:block" target="_blank"><center><font size="3"><span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;white-space:nowrap;font-weight:bold;vertical-align:middle;color:#525252;font-size:14px;line-height:14px">Comment</span></font></center></a></td></tr></tbody></table></a></td><td width="100%"></td></tr><tr><td style="line-height:32px" colspan="3" height="32">&nbsp;</td></tr></tbody></table>
								</td>
								<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
							</tr>
							
							
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
							
							
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>';
	$this->loadmodel('notification_email');
	$conditions7=array("module_id" =>10,"user_id"=>$d_user_id,'chk_status'=>0);
	$result5=$this->notification_email->find('all',array('conditions'=>$conditions7));
	$n=sizeof($result5);
	if($n>0)
	{
	@$subject.= 'Discussion: ['. $society_name . ']' .'  -   '.'New Discussion: '.$sub.'';
	$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
	$subject="";
	}	
	}
	}


	////////////////////////////////////////////End Mail Functionality //////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////
	
	$this->Session->write('discussion_forum_status',1);
	$this->redirect(array('controller' => 'Discussions','action' => 'index'));

	}
		
		
		
	}



	///////////////////////End start new topic//////////////////////////////////
	
}



function delete_topic(){
$this->layout='blank';
$s_society_id=$this->Session->read('society_id'); 

$con=$this->request->query('con');
$con=(int)$this->decode($con,'housingmatters');

if($con==0) { $this->redirect(array('controller' => 'Discussions','action' => 'index')); }

$this->loadmodel('discussion_post');
$this->discussion_post->updateAll(array("delete_id" =>1),array("discussion_post_id" => $con));

$this->redirect(array('controller' => 'Discussions','action' => 'index/mytopics/1'));
}

function archive()
{
	$this->layout='blank';
	$s_society_id=$this->Session->read('society_id'); 
	$con=(int)$this->request->query('con');
	$con=(int)$this->decode($con,'housingmatters');
	if($con==0) { $this->redirect(array('controller' => 'Discussions','action' => 'index')); }
	$this->loadmodel('discussion_post');
	$this->discussion_post->updateAll(array("delete_id" =>2),array("discussion_post_id" => $con));
	$this->redirect(array('controller' => 'Discussions','action' => 'index/archives/2'));
	
}

function discussion_save_comment(){
$this->layout='blank';
$this->ath();
$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id'); 
$tid=(int)$this->request->query('tid');
 $g=$this->request->query('c'); 
$c=htmlentities(wordwrap($g, 25, " ", true));

$c=nl2br($c);

$date=date("d-m-y");
$time=date('h:i:a',time());
	
	$r=$this->content_moderation_society($g);
	
if($r==0)
{
echo $word='You have entered banned words. <br/> ';
exit;
	
}
else
{
	
$this->loadmodel('discussion_comment');
$conditions=array("delete_id"=>0);
$order=array('discussion_comment.discussion_comment_id'=>'DESC');
$cursor_last_color=$this->discussion_comment->find('all',array('conditions'=>$conditions,'order'=>$order,'limit'=>1));
foreach ($cursor_last_color as $collection_color) 
{
$last_color=$collection_color["discussion_comment"]["color"];
}
if(sizeof($cursor_last_color)==0) {  $last_color='blue'; }

	$color_in=$this->rendom_color($last_color);
//////////////////end color///////////////////

$discussion_comment_id=$this->autoincrement('discussion_comment','discussion_comment_id');
$this->loadmodel('discussion_comment');
$multipleRowData = Array( Array("discussion_comment_id" => $discussion_comment_id, "user_id" => $s_user_id , "society_id" => $s_society_id, "comment" => $c,"discussion_post_id" => $tid, "delete_id" =>0, "date" =>$date, "time" => $time, "color" => $color_in));
$this->discussion_comment->saveAll($multipleRowData); 

	
}


 //////////////// Moderation content check start ///////////////////////////
/*
$this->loadmodel('society');
$conditions=array('society_id'=>$s_society_id);
$result1=$this->society->find('all',array('conditions'=>$conditions));
foreach($result1 as $data)
{
  $content=$data['society']['content_moderation'];

}


foreach($c_mod as $c_moda)
{
if(in_array($c_moda,$content))
{
echo $word='You have enter wrong word  <br/> ';
exit;
}
}
*/
//////////////////color///////////////////




////////////////// Modaration content check End ///////////////////////


}

function discussion_comment_refresh(){
$this->layout='blank';
$this->ath();
$s_user_id=$this->Session->read('user_id'); 
$this->set('s_user_id',$s_user_id);
$s_society_id=$this->Session->read('society_id'); 
$t_id=(int)$this->request->query('con');
$this->set('t_id',$t_id);

$this->loadmodel('discussion_comment');
//$conditions=array("discussion_post_id"=>$t_id,"delete_id"=>0);
$conditions =array( '$or' => array( 
array('discussion_post_id' =>$t_id,'delete_id' =>0),array('discussion_post_id' =>$t_id,'delete_id' =>2)));
$order=array('discussion_comment.discussion_comment_id'=>'ASC');
$this->set('result_comment_ref',$this->discussion_comment->find('all',array('conditions'=>$conditions,'order'=>$order)));
}

function discussion_comment_delete_ajax(){
$this->layout='blank';

$s_society_id=$this->Session->read('society_id'); 

$c_id=(int)$this->request->query('c_id');

$this->loadmodel('discussion_comment');
$this->discussion_comment->updateAll(array("delete_id" =>1),array("discussion_comment_id" => $c_id));
//$this->response->header('Location', 'discussion');
}



function discussion_offensive_delete_ajax(){
$this->layout='blank';
$s_society_id=$this->Session->read('society_id'); 
$co_id=(int)$this->request->query('c_id');
$c_u_id=(int)$this->request->query('c_u_id');
$this->loadmodel('discussion_comment');
$conditions=array('discussion_comment_id' => $co_id);
$result= $this->discussion_comment->find('all',array('conditions'=>$conditions));
foreach($result as $data)
{
$r=$data['discussion_comment']['offensive_user'];	
}
if(!empty($r))
{
array_push($r,$c_u_id);
}
else
{
$r=array($c_u_id);
}
$this->loadmodel('discussion_comment');
$this->discussion_comment->updateAll(array("delete_id" =>2,'offensive_user'=>$r),array("discussion_comment_id" => $co_id));

}


function discussion_search_topic(){
$this->layout='blank';
$this->ath();
$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id');

$tenant=$this->Session->read('tenant');
$role_id=$this->Session->read('role_id');
$wing=$this->Session->read('wing');

$s=$this->request->query('s');
$regex = new MongoRegex("/.*$s.*/i");


$this->loadmodel('discussion_post');
$conditions =array( '$or' => array( 
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>1,'topic' =>$regex),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>2,'topic' =>$regex,'sub_visible' =>array('$in' => array($role_id))),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>3,'topic' =>$regex,'sub_visible' =>array('$in' => array($wing))),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>4,'topic' =>$regex),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>5,'topic' =>$regex)
));
$order=array('discussion_post.discussion_post_id'=>'DESC');
$this->set('result_all_topic',$this->discussion_post->find('all',array('conditions'=>$conditions,'order'=>$order))); 

}


}
?>