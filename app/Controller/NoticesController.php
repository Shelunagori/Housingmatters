<?php
App::import('Controller', 'Hms');
class NoticesController extends HmsController {
var $helpers = array('Html', 'Form','Js');
public $components = array(
'Paginator',
'Session','Cookie','RequestHandler'
);


var $name = 'Notices';



//////////////////// Start notice Board ///////////////////////////////
function notice_category_name($category_id)
{

$this->loadmodel('master_notice_category');
$conditions=array("category_id" => $category_id);
$result_category=$this->master_notice_category->find('all',array('conditions'=>$conditions));
foreach ($result_category as $collection) 
{
return $notice_category_name=$collection['master_notice_category']['category_name'];
}

}

function notice_approval()
{
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
    $this->check_user_privilages();	
	$s_society_id=$this->Session->read('society_id'); 
	$this->loadmodel('notice');
	$conditions=array("n_draft_id" => 4, "n_delete_id" => 0,"society_id"=> $s_society_id);
	$order=array('notice_id'=>'DESC');
	$res_notice=$this->notice->find('all',array('conditions'=>$conditions,'order'=>$order));
	$this->set('result_notice_publish',$res_notice);	

}

function notice_approval_ajax($id=null)
{
	$this->layout='blank';
	$id=(int)$id;
	$s_society_id=$this->Session->read('society_id'); 
	$ip=$this->hms_email_ip();
	$this->loadmodel('notice');
	$conditions=array('notice_id'=>$id);
	$result=$this->notice->find('all',array('conditions'=>$conditions));
	foreach($result as $data)
	{
		
		$category=$data['notice']['n_category_id'];
		$user_id=$data['notice']['user_id'];
		$sub=$data['notice']['n_subject'];
		$date=$data['notice']['n_date'];
		$visible=(int)$data['notice']['visible'];
		$sub_visible=$data['notice']['sub_visible'];
		$message=$data['notice']['n_message'];
		
		if($visible==1)
		{	
		$send='All Users'; 
		$visible=1;
		$sub_visible[]=0;
		/////////////////////////////////////////// All user ////////////////////////////
		$result_user= $this->all_user_deactive();
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
		$send='All Owners';
		$visible=4;
		$sub_visible=1;
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
		 $send='All Tenants'; 
		$visible=5;
		$sub_visible=2;
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
			$send='Roll Wise'; 			
		$visible=2;
		foreach ($sub_visible as $collection) 
		{
		$role_id=$collection;
		
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
		$da_to=array_unique($da_to);
		}



		if($visible==3)
		{
		$send='Wing Wise'; 
		$visible=3;
		foreach ($sub_visible as $collection) 
		{
		$wing_id=$collection;

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
		
		 $da_to11=array_unique($da_user_id);

			$this->loadmodel('email');
			$conditions=array('auto_id'=>2);
			$result_email=$this->email->find('all',array('conditions'=>$conditions));
			foreach ($result_email as $collection) 
			{
			 $from=$collection['email']['from'];
			}
			$from_name="HousingMatters";
			$reply="donotreply@housingmatters.in";
			$category_name=$this->notice_category_name($category);
			$society_result=$this->society_name($s_society_id);
			foreach($society_result as $data)
			{
			  $society_name=$data['society']['society_name'];
			}
			for($k=0;$k<sizeof(@$da_to);$k++)
			{
			$to = @$da_to[$k];
			$d_user_id = @$da_user_id[$k];	 
			$user_name = @$da_user_name[$k];	

			$message_web="<div>
			<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
			<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
			<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
			
			</br><p>Dear  $user_name,</p>
			<p>A new notice has been posted on your society Notice Board.</p>
			<table  cellpadding='10' width='100%;' border='1' bordercolor='#e1e1e1'  >
			<tr class='tr_heading' style='background-color:#00A0E3;color:white;'>
			<td>Date</td>
			<td>Subject</td>
			<td>Category</td>
			<td>Sent to</td>
			</tr>
			<tr class='tr_content' style=background-color:#E9E9E9;'>
			<td>$date</td>
			<td>$sub</td>
			<td>$category_name</td>
			<td>$send</td>
			</tr>
			</table>
			<div>
			<p style='font-size:16px;'> <strong>Notice Description:</strong></p>
			<p style='font-size:15px;'>$message</p><br/><br/>
			<center><p>To view / respond
			<a href='$ip".$this->webroot."hms'><button style='width:100px; height:30px;  background-color:#00A0E3;color:white'> Click Here </button></a></p></center><br/>
			<br/>
			<p>For any software related queries, please contact <span style='color:#00A0E3;'> support@housingmatters.in </span></p>
			www.housingmatters.co.in
			</div>
			</div>";
			$this->loadmodel('notification_email');
			$conditions7=array("module_id" =>1,"user_id"=>$d_user_id,'chk_status'=>0);
			$result5=$this->notification_email->find('all',array('conditions'=>$conditions7));
			$n=sizeof($result5);
			if($n>0)
			{
		
			@$subject.= '['. $society_name . ']  - '.' New Notice : '.'     '.''.$sub.'';
			$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
			$subject="";
			}	
			}
			
			
////////// Send Notification code start ///////////////////////////////////////


$this->send_notification('<span class="label label-info" ><i class="icon-bullhorn"></i></span>','New Notice published - <b>'.$sub.'</b> by',2,$id,'notice_publish_view?con='.$id,$user_id,$da_to11);





//////////// End code notification ////////////////////////////			
			
		$this->loadmodel('notice');
		$this->notice->updateAll(array('visible_user_id' => $da_to11,'n_draft_id'=>0),array('notice_id'=>$id));
		//$this->response->header('location','notice_approval');
		$this->redirect(array("controller"=>"Notices","action"=>"notice_approval"));
		
	}
	
	
}

function notice_approval_reject($id=null)
{
	$this->layout="blank";
	$n_id=(int)$id;
	$this->loadmodel(notice);
	$this->notice->updateAll(array('n_draft_id'=>5),array('notice_id'=>$n_id));
	//$this->response->header('location','notice_approval');
	$this->redirect(array("controller"=>"Notices","action"=>"notice_approval"));
}



function notice_approval_view($id=null)
{
	
		if($this->RequestHandler->isAjax()){
		$this->layout='blank';
		}else{
		$this->layout='session';
		}
		$this->ath();
		$n_id=(int)$id;
		$this->set('n_id',$n_id);
		$this->loadmodel('notice');
		$conditions=array("notice_id" => $n_id);
		$this->set('result_view', $this->notice->find('all',array('conditions'=>$conditions)));
		$this->loadmodel('notice_board_reply');
		$conditions=array("notice_id" => $n_id);
		$this->set('result_reply',$this->notice_board_reply->find('all',array('conditions'=>$conditions)));

}


function create_notice() 
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$this->ath();
//$this->check_user_privilages();
$s_society_id=$this->Session->read('society_id');
$s_role_id=$this->Session->read('role_id'); 
$this->loadmodel('master_notice_category');
$this->set('result1', $this->master_notice_category->find('all'));
$this->loadmodel('role');
$conditions=array("society_id" => $s_society_id);
$role_result=$this->role->find('all',array('conditions'=>$conditions));
$this->set('role_result',$role_result);
$this->loadmodel('wing');
$wing_result=$this->wing->find('all');
$this->set('wing_result',$wing_result);
$s_user_id=$this->Session->read('user_id');
$date=date('d-m-Y');
$time = date(' h:i a', time());

$result=$this->society_name($s_society_id);
	foreach($result as $data)
	{
	@$notice=$data['society']['notice'];

	}
	if($notice==1 && $s_role_id!=3)
	{
		
		if(isset($this->request->data['publish']))
		{
			$category_id=(int)$this->request->data['notice_category'];
			$text=htmlentities($this->request->data['notice_subject']);
			$sub = wordwrap($text, 25, " ", true);
			$expire_date = new MongoDate(strtotime(date("Y-m-d", strtotime($this->request->data['notice_expire_date']))));
			 $message=$this->request->data['description'];
			$visible=(int)$this->request->data['visible'];
			$att=$this->request->form['file']['name'];
					if($visible==1)
					{	
					$visible=1;
					$sub_visible[]=0;
					}
					
					if($visible==4)
					{	
					$visible=4;
					$sub_visible=1;
					}
					
					if($visible==5)
					{
					$visible=5;
					$sub_visible=2;
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
					
						$target = "notice_file/";
						$target=@$target.basename( @$this->request->form['file']['name']);
						$ok=1;
						move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target); 
						$notice_id=$this->autoincrement('notice','notice_id');
						$this->loadmodel('notice');
						$this->notice->save(array('notice_id' => $notice_id, 'user_id' => $s_user_id, 'society_id' => $s_society_id, 'n_category_id' => $category_id ,'n_subject' => $sub , 'n_expire_date' => $expire_date, 'n_attachment' => $att , 'n_message' => $message,'n_date' => $date, 'n_time' => $time, 'n_delete_id' => 0,'n_draft_id' => 4,'visible' => $visible,'sub_visible' => $sub_visible));

					?>
                
				<!----alert-------------->
				<div class="modal-backdrop fade in"></div>
				<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
				<div class="modal-body" style="font-size:16px;">
				Notices are sent for approval
				</div> 
				<div class="modal-footer">
				<a href="create_notice" class="btn green">OK</a>
				</div>
				</div>
				<!----alert-------------->
				
                <?php		
			
					
					
			
		}
	}	
	else
	{
		
		
if(isset($this->request->data['publish']))
{
	@$ip=$this->hms_email_ip();
$category_id=(int)$this->request->data['notice_category'];
$text=htmlentities($this->request->data['notice_subject']);
$sub = wordwrap($text, 25, " ", true);
$expire_date = new MongoDate(strtotime(date("Y-m-d", strtotime($this->request->data['notice_expire_date']))));
$message=$this->request->data['description'];

$visible=(int)$this->request->data['visible'];
$att=$this->request->form['file']['name'];

if($visible==1)
{	
$visible=1;
$sub_visible[]=0;
/////////////////////////////////////////// All user ////////////////////////////
//$this->loadmodel('user');
//$conditions=array('society_id'=>$s_society_id);
//$result_user=$this->user->find('all',array('conditions'=>$conditions));
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
$sub_visible=1;
/////////////////////////////////////////// All Owners ////////////////////////////
//$this->loadmodel('user');
//$conditions=array('tenant'=>1,'society_id'=>$s_society_id);
//$result_user=$this->user->find('all',array('conditions'=>$conditions));
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
$sub_visible=2;
/////////////////////////////////////////// All Tenant ////////////////////////////
//$this->loadmodel('user');
//$conditions=array('tenant'=>2,'society_id'=>$s_society_id);
//$result_user=$this->user->find('all',array('conditions'=>$conditions));
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
//$this->loadmodel('user');
//$conditions=array('role_id'=>$role_id,'society_id'=>$s_society_id);
//$result_user=$this->user->find('all',array('conditions'=>$conditions));
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
$wing_id=(int)$collection["wing"]["wing_id"];

$wing=@(int)$this->request->data['wing'.$wing_id];
if(!empty($wing))
{
$sub_visible[]=(int)$wing;
/////////////////////////////////////////// All wing wise  functionality conditions //////////////////////////////////////////////////////
//$this->loadmodel('user');
//$conditions=array('wing'=>$wing_id,'society_id'=>$s_society_id);
//$result_user=$this->user->find('all',array('conditions'=>$conditions));
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


///////// creator send email code //////////////////

$result_user=$this->profile_picture($s_user_id);
foreach($result_user as $data)
{
	 $c_email=$data['user']['email'];
	 $c_user_id=$data['user']['user_id'];
	 $c_user_name=$data['user']['user_name'];
	
}
$da_to[]=$c_email;
$da_user_name[]=$c_user_name;
$da_user_id[]=$c_user_id;

$da_to=array_unique($da_to);
$da_user_name=array_unique($da_user_name);
$da_user_id=array_unique($da_user_id);

/////////////////////////  end code ////////////////////////////////


$da_to11=array_unique($da_user_id);

$target = "notice_file/";
$target=@$target.basename( @$this->request->form['file']['name']);
$ok=1;
move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target); 
$notice_id=$this->autoincrement('notice','notice_id');
$this->loadmodel('notice');
$this->notice->save(array('notice_id' => $notice_id, 'user_id' => $s_user_id, 'society_id' => $s_society_id, 'n_category_id' => $category_id ,'n_subject' => $sub , 'n_expire_date' => $expire_date, 'n_attachment' => $att , 'n_message' => $message,'n_date' => $date, 'n_time' => $time, 'n_delete_id' => 0,'n_draft_id' => 0,'visible' => $visible,'sub_visible' => $sub_visible,'visible_user_id' => $da_to11 ));

////////////////////////////////////////////// Email Code Start ////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$this->loadmodel('email');
$conditions=array('auto_id'=>2);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
}
$from_name="HousingMatters";
$reply="donotreply@housingmatters.in";
$category_name=$this->notice_category_name($category_id);
$society_result=$this->society_name($s_society_id);
foreach($society_result as $data)
{
$society_name=$data['society']['society_name'];
}

if($visible==1)
{
$send='All Users'; 
}
if($visible==2)
{
$send='Roll Wise'; 
}
if($visible==3)
{
$send='Wing Wise'; 
}

if($visible==4)
{
$send='All Owners'; 
}

if($visible==5)
{
$send='All Tenants'; 
}

for($k=0;$k<sizeof(@$da_to);$k++)
{
$to = @$da_to[$k];
$d_user_id = @$da_user_id[$k];	 
$user_name = @$da_user_name[$k];	

 $message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>

</br><p>Dear  $user_name,</p>
<p>A new notice has been posted on your society Notice Board.</p>
<table  cellpadding='10' width='100%;' border='1' bordercolor='#e1e1e1'  >
<tr class='tr_heading' style='background-color:#00A0E3;color:white;'>
<td>Date</td>
<td>Subject</td>
<td>Category</td>
<td>Sent to</td>
</tr>
<tr class='tr_content' style=background-color:#E9E9E9;'>
<td>$date</td>
<td>$sub</td>
<td>$category_name</td>
<td>$send</td>
</tr>
</table>
<div>
<p style='font-size:16px;'> <strong>Notice Description:</strong></p>
<p style='font-size:15px;'>$message</p><br/><br/>
<center><p>To view / respond
<a href='$ip".$this->webroot."hms'><button style='width:100px; height:30px;  background-color:#00A0E3;color:white'> Click Here </button></a></p></center><br/>
<br/>
<p>For any software related queries, please contact <span style='color:#00A0E3;'> support@housingmatters.in </span></p>
www.housingmatters.co.in
</div>
</div>";
$this->loadmodel('notification_email');
$conditions7=array("module_id" =>1,"user_id"=>$d_user_id,'chk_status'=>0);
$result5=$this->notification_email->find('all',array('conditions'=>$conditions7));
$n=sizeof($result5);
if($n>0)
{
@$subject.= '['. $society_name . ']  - '.' New Notice : '.'     '.''.$sub.'';
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$subject="";
}	
}


$da_user_id[]=$d_user_id;
$this->send_notification('<span class="label label-info" ><i class="icon-bullhorn"></i></span>','New Notice published - <b>'.$sub.'</b> by',2,$notice_id,$this->webroot.'notice_publish_view?con='.$notice_id,$s_user_id,$da_user_id);

?>
<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Your Notice has been Published.
</div> 
<div class="modal-footer">
<a href="notice_publish" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php	

}

		
		
}



if(isset($this->request->data['draft'])) 
{
$category_id=$this->request->data['notice_category'];
$text=htmlentities($this->request->data['notice_subject']);
$sub = wordwrap($text, 25, " ", true);
$expire_date = new MongoDate(strtotime(date("Y-m-d", strtotime($this->request->data['notice_expire_date']))));
$message=$this->request->data['description'];
$visible=(int)$this->request->data['visible'];
$att=$this->request->form['file']['name'];
if($visible==1)
{
$visible=1;
$sub_visible[]=0;
}
if($visible==4)
{
$visible=1;
$sub_visible=1;
}
if($visible==5)
{
$visible=1;
$sub_visible=2;
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
$wing_id=$collection["wing"]["wing_id"];
$wing=@(int)$this->request->data['wing'.$wing_id];
if(!empty($wing))
{
$sub_visible[]=(int)$wing;
}
}
}
$target = "notice_file/";
$target=@$target.basename( @$this->request->form['file']['name']);
$ok=1;
move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target); 
$notice_id=$this->autoincrement('notice','notice_id');	
$this->loadmodel('notice');
$this->notice->save(array('notice_id' => $notice_id, 'user_id' => $s_user_id, 'society_id' => $s_society_id, 'n_category_id' => $category_id ,'n_subject' => $sub , 'n_expire_date' => $expire_date, 'n_attachment' => $att , 'n_message' => $message,'n_date' => $date, 'n_time' => $time, 'n_delete_id' => 0,'n_draft_id' => 1,'visible' => $visible,'sub_visible' => $sub_visible ));

?>
<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Your Notice has been saved in Draft Folder.
</div> 
<div class="modal-footer">
<a href="notice_draft" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php
}


}


function notice_board() 
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();
$s_society_id=$this->Session->read('society_id');
$tenant=$this->Session->read('tenant');
$role_id=$this->Session->read('role_id');
$wing=$this->Session->read('wing');
$q=$this->request->query('con');
$cat=$this->decode($q,'housingmatters');
$this->set('blue_cat',$cat);
$current_date = new MongoDate(strtotime(date("Y-m-d")));

$this->loadmodel('master_notice_category');
$this->set('result1', $this->master_notice_category->find('all'));
$this->loadmodel('notice');
$conditions =array( '$or' => array( 
array('society_id' =>$s_society_id,'visible' =>1,'n_draft_id' =>0,'n_delete_id' =>0,'n_expire_date' => array('$gte'=>$current_date)),
array('society_id' =>$s_society_id,'visible' =>2,'n_draft_id' =>0,'n_delete_id' =>0,'sub_visible' =>array('$in' => array($role_id)),'n_expire_date' => array('$gte'=>$current_date)),
array('society_id' =>$s_society_id,'visible' =>3,'n_draft_id' =>0,'n_delete_id' =>0,'sub_visible' =>array('$in' => array($wing)),'n_expire_date' => array('$gte'=>$current_date)),
array('society_id' =>$s_society_id,'visible' =>4,'n_draft_id' =>0,'n_delete_id' =>0,'sub_visible' =>$tenant,'n_expire_date' => array('$gte'=>$current_date)),
array('society_id' =>$s_society_id,'visible' =>5,'n_draft_id' =>0,'n_delete_id' =>0,'sub_visible' =>$tenant,'n_expire_date' => array('$gte'=>$current_date))
));

$order=array('notice.notice_id'=>'DESC');

$this->set('result_notice_visible',$this->notice->find('all', array('conditions' => $conditions,'order' => $order)));


if(!empty($cat))
{
	
$this->set('red_cat',$cat);
$this->loadmodel('notice');
$conditions =array( '$or' => array( 
array('society_id' =>$s_society_id,'n_category_id'=>(int)$cat,'visible' =>1,'n_expire_date' => array('$gte'=>$current_date)),
array('society_id' =>$s_society_id,'n_category_id'=>(int)$cat,'visible' =>2,'sub_visible' =>array('$in' => array($role_id)),'n_expire_date' => array('$gte'=>$current_date)),
array('society_id' =>$s_society_id,'n_category_id'=>(int)$cat,'visible' =>3,'sub_visible' =>array('$in' => array($wing)),'n_expire_date' => array('$gte'=>$current_date)),
array('society_id' =>$s_society_id,'n_category_id'=>(int)$cat,'visible' =>4,'sub_visible' =>$tenant,'n_expire_date' => array('$gte'=>$current_date)),
array('society_id' =>$s_society_id,'n_category_id'=>(int)$cat,'visible' =>5,'sub_visible' =>$tenant,'n_expire_date' => array('$gte'=>$current_date))
));
$order=array('notice.notice_id'=>'DESC');
$this->set('result_notice_visible',$this->notice->find('all', array('conditions' => $conditions,'order' => $order)));
}
}

function notice_from_visible_to_notice($notice_id) 
{
$this->loadmodel('notice');
$conditions=array("notice_id" => $notice_id,"n_draft_id" => 0);
return $result=$this->notice->find('all',array('conditions'=>$conditions));
}

function notice_board_view() 
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();

$n_id=(int)$this->request->query['con'];
$this->set('n_id',$n_id);

$this->seen_notification(2,$n_id);

$this->loadmodel('notice');
$conditions=array("notice_id" => $n_id);
$this->set('result_view', $this->notice->find('all',array('conditions'=>$conditions)));

$this->loadmodel('notice_board_reply');
$conditions=array("notice_id" => $n_id);
$this->set('result_reply',$this->notice_board_reply->find('all',array('conditions'=>$conditions)));
}

function notice_publish_view($n_id=null) 
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();

$n_id=(int)$n_id;
$this->set('n_id',$n_id);

$this->seen_notification(2,$n_id);
$this->seen_alert(2,$n_id);

$this->loadmodel('notice');
$conditions=array("notice_id" => $n_id);
$this->set('result_view', $this->notice->find('all',array('conditions'=>$conditions)));

$this->loadmodel('notice_board_reply');
$conditions=array("notice_id" => $n_id);
$this->set('result_reply',$this->notice_board_reply->find('all',array('conditions'=>$conditions)));
}

function notice_save_reply()
{
		$this->layout='blank';
		$this->ath();
		$reply=htmlentities($this->request->query('reply'));
		$reply=nl2br($reply);
		//$rep=explode(' ',$reply);
		$r=$this->content_moderation_society($reply);
		
		

$n_id=(int)$this->request->query('n_id');

$s_user_id=$this->Session->read('user_id');


$date=date("d-m-Y");
$time=date('h:i:a',time());

$t=$this->autoincrement('notice_board_reply','reply_id');
$this->loadmodel('notice_board_reply');
$multipleRowData = Array( Array("reply_id" => $t, "reply" => $reply , "notice_id" => $n_id, "date" => $date,"time" => $time,"class" => "outt","user_id"=>$s_user_id));

if($r==0)
		{
			echo'<span style="color:red;font-size:14px;">You have enter wrong word.</span>';
		}
		else
		{
			$this->notice_board_reply->saveAll($multipleRowData); 
			
		}
$this->loadmodel('notice_board_reply');
$conditions=array("notice_id" => $n_id);
$order=array('notice_board_reply.notice_id'=>'ASC');
$this->set('result_reply',$this->notice_board_reply->find('all',array('conditions'=>$conditions,'order'=>$order)));

}

function notice_draft() 
{

if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}

 $q=$this->request->query('con');
	$this->ath();
$this->check_user_privilages();
$cat=$this->decode($q,'housingmatters');
$this->set('blue_cat',$cat);
$s_society_id=$this->Session->read('society_id');
$this->loadmodel('master_notice_category');
$this->set('result1', $this->master_notice_category->find('all'));
$this->loadmodel('notice');
$conditions=array("n_draft_id" => 1, "n_delete_id" => 0,"society_id"=> $s_society_id);
$order=array('notice_id'=>'DESC');
$this->set('result_notice_draft',$this->notice->find('all',array('conditions'=>$conditions,'order'=>$order)));
	if(!empty($cat))
	{
		$this->set('red_cat',$cat);	
		$this->loadmodel('notice');
		$conditions1=array('n_draft_id'=>1,'n_delete_id'=>0,'society_id'=>$s_society_id,'n_category_id'=>$cat);
		$result=$this->notice->find('all',array('conditions'=>$conditions1));
		$this->set('result_notice_draft',$result);
	}
	
}


function notice_edit($id=null) 
{
$this->layout='session';
$this->ath();
$s_society_id=$this->Session->read('society_id');
$notice_id=(int)$id;
$this->set('notice_id',$notice_id);
$this->loadmodel('notice');
$conditions=array("notice_id" => $notice_id);
$result5= $this->notice->find('all',array('conditions'=>$conditions));
$this->set('result_notices',$result5); 
$this->loadmodel('master_notice_category');
$this->set('result1', $this->master_notice_category->find('all'));
$this->loadmodel('role');
$conditions=array("society_id" => $s_society_id);
$role_result=$this->role->find('all',array('conditions'=>$conditions));
$this->set('role_result',$role_result);
$this->loadmodel('wing');
$wing_result=$this->wing->find('all');
$this->set('wing_result',$wing_result);

foreach($result5 as $data)
{
$visible=$data['notice']['visible'];
$sub_visible=$data['notice']['sub_visible'];
$attachment=$data['notice']['n_attachment'];
$date=$data['notice']['n_date'];

}
if(isset($this->request->data['publish_d'])) 
{
	
$ip=$this->hms_email_ip();
	
$category_id=(int)$this->request->data['notice_category'];
$text=htmlentities($this->request->data['notice_subject']);
$sub = wordwrap($text, 25, " ", true);
$expire_date = new MongoDate(strtotime(date("Y-m-d", strtotime($this->request->data['notice_expire_date']))));
$message=$this->request->data['Editor3'];
$notice_att=$this->request->form['file']['name'];

if(empty($notice_att))
{
$notice_att=$attachment;
}
$target = "notice_file/";
$target=@$target.basename( @$this->request->form['file']['name']);
$ok=1;
move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target); 
$this->notice->updateAll(array('n_draft_id'=>0,'n_category_id' => $category_id ,'n_subject' => $sub , 'n_expire_date' => $expire_date,'n_attachment'=>$notice_att),array('notice.notice_id'=>$notice_id));

if($visible==1)
{
/////////////////////////////////////////// All User mail functionality conditions //////////////////////////////////////////////////////


$result_user=$this->all_user_deactive();
foreach($result_user as $data)
{
$da_to[]=$data['user']['email'];
$da_user_name[]=$data['user']['user_name'];
$da_user_id[]=$data['user']['user_id'];
}
}
//////////////////////////////// end mail ////////////////////////////////////////////////////////		



if($visible==4)
{
/////////////////////////////////////////// All Owner mail functionality conditions //////////////////////////////////////////////////////

//$this->loadmodel('user');
//$conditions=array('tenant'=>1,'society_id'=>$s_society_id);
//$result_user=$this->user->find('all',array('conditions'=>$conditions));
$result_user=$this->all_owner_deactive();
foreach($result_user as $data)
{
$da_to[]=$data['user']['email'];
$da_user_name[]=$data['user']['user_name'];
$da_user_id[]=$data['user']['user_id'];
}
//////////////////////////////// end mail ////////////////////////////////////////////////////////		

}
if($visible==5)
{
/////////////////////////////////////////// All Tenant mail functionality conditions //////////////////////////////////////////////////////

//$this->loadmodel('user');
//$conditions=array('tenant'=>2,'society_id'=>$s_society_id);
//$result_user=$this->user->find('all',array('conditions'=>$conditions));
$result_user=$this->all_tenant_deactive();
foreach($result_user as $data)
{
$da_to[]=$data['user']['email'];
$da_user_name[]=$data['user']['user_name'];
$da_user_id[]=$data['user']['user_id'];
}
//////////////////////////////// end mail ////////////////////////////////////////////////////////		
}
if($visible==2)
{
foreach ($role_result as $collection) 
{
$role_id=$collection["role"]["role_id"];
if(in_array($role_id,$sub_visible))
{

/////////////////////////////////////////// All role  functionality  conditions //////////////////////////////////////////////////////
//$this->loadmodel('user');
//$conditions=array('role_id'=>$role_id,'society_id'=>$s_society_id);
//$result_user=$this->user->find('all',array('conditions'=>$conditions));
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
foreach ($wing_result as $collection) 
{
$wing_id=$collection["wing"]["wing_id"];
if(in_array($wing_id,$sub_visible))
{

/////////////////////////////////////////// All wing wise  functionality conditions //////////////////////////////////////////////////////
//$this->loadmodel('user');
//$conditions=array('wing'=>$wing_id,'society_id'=>$s_society_id);
//$result_user=$this->user->find('all',array('conditions'=>$conditions));
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

////////////////////////////////////////////// Email Code Start ////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$this->loadmodel('email');
$conditions=array('auto_id'=>2);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
}
$from_name="HousingMatters";
$reply="donotreply@housingmatters.in";
$category_name=$this->notice_category_name($category_id);
$society_result=$this->society_name($s_society_id);
foreach($society_result as $data)
{
$society_name=$data['society']['society_name'];
}

if($visible==1)
{
$send='All Users'; 
}
if($visible==2)
{
$send='Roll Wise'; 
}
if($visible==3)
{
$send='Wing Wise'; 
}

if($visible==4)
{
$send='All Owners'; 
}

if($visible==5)
{
$send='All Tenants'; 
}
for($k=0;$k<sizeof(@$da_to);$k++)
{
$to = @$da_to[$k];
$d_user_id = @$da_user_id[$k];	 
$user_name = @$da_user_name[$k];	
$message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Dear  $user_name,</p>
<p>A new notice has been posted on your society Notice Board.</p>
<table  cellpadding='10' width='100%;' border='1' bordercolor='#e1e1e1'  >
<tr class='tr_heading' style='background-color:#00A0E3;color:white;'>
<td>Date</td>
<td>Subject</td>
<td>Category</td>
<td>Sent to</td>
</tr>
<tr class='tr_content' style=background-color:#E9E9E9;'>
<td>$date</td>
<td>$sub</td>
<td>$category_name</td>
<td>$send</td>
</tr>
</table>
<div>
<p style='font-size:16px;'> <strong>Notice Description:</strong></p>
<p style='font-size:15px;'>$message</p><br/><br/>
<center><p>To view / respond
<a href='$ip".$this->webroot."hms' ><button style='width:100px; height:30px;  background-color:#00A0E3;color:white'> Click Here </button></a></p></center><br/>
<p>For any software related queries, please contact <span style='color:#00A0E3;'> support@housingmatters.in </span></p>
www.housingmatters.co.in
</div>
</div>"; 
$this->loadmodel('notification_email');
$conditions7=array("module_id" =>1,"user_id"=>$d_user_id,'chk_status'=>0);
$result5=$this->notification_email->find('all',array('conditions'=>$conditions7));
$n=sizeof($result5);
if($n>0)
{
@$subject.= '['. $society_name . ']  - '.' New Notice : '.'     '.''.$sub.'';
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$subject="";
}
}
?>
<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Your Notice has been Published.
</div> 
<div class="modal-footer">
<a href="<?php echo $this->webroot; ?>Notices/notice_publish" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php
}


}


function notice_visible_role_check($role_id,$notice_id) 
{
$s_society_id=$this->Session->read('society_id'); 


$this->loadmodel('notice_visible');
$conditions=array("notice_id" => $notice_id,"visible" => 2,"sub_visible" => $role_id);
return $this->notice_visible->find('count',array('conditions'=>$conditions));
}

function notice_visible_wing_check($wing_id,$notice_id) 
{
$s_society_id=$this->Session->read('society_id'); 


$this->loadmodel('notice_visible');
$conditions=array("notice_id" => $notice_id,"visible" => 3,"sub_visible" => $wing_id);
return $this->notice_visible->find('count',array('conditions'=>$conditions));
}


function notice_archive()
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
//$this->layout='session';
$this->check_user_privilages();
$this->ath();
	
$s_society_id=$this->Session->read('society_id');
$tenant=$this->Session->read('tenant');
$role_id=$this->Session->read('role_id');
$wing=$this->Session->read('wing');
$q=$this->request->query('con');
$cat=$this->decode($q,'housingmatters');
$this->set('blue_cat',$cat);
$current_date = new MongoDate(strtotime(date("Y-m-d")));
$this->loadmodel('master_notice_category');
$this->set('result1', $this->master_notice_category->find('all'));
$this->loadmodel('notice');
$conditions=array("n_draft_id" => 2, "n_delete_id" => 0,"society_id"=> $s_society_id);
$order=array('notice_id'=>'DESC');
$this->set('result_notice_publish',$this->notice->find('all',array('conditions'=>$conditions,'order'=>$order)));	
if(!empty($cat))
{
	$this->set('red_cat',$cat);	
	$conditions=array("n_draft_id" => 2, "n_delete_id" => 0,"society_id"=> $s_society_id,'n_category_id'=>(int)$cat);
	$order=array('notice.notice_id'=>'DESC');
	$this->set('result_notice_publish',$this->notice->find('all',array('conditions'=>$conditions,'order'=>$order)));
}
}


function notice_move_archive($id=null)
{
	$this->layout='blank';	
	$notice_id=(int)$id;
	$this->loadmodel('notice');
	$this->notice->updateAll(array('n_draft_id'=>2),array('notice_id'=>$notice_id));
	$this->redirect(array("controller"=>"Notices","action"=>"notice_archive"));
	//$this->response->header('location','notice_archive');
	
}


function notice_publish() 
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();
$q=$this->request->query('con');
$cat=$this->decode($q,'housingmatters');
$this->set('blue_cat',$cat);
$s_society_id=$this->Session->read('society_id');
$tenant=$this->Session->read('tenant');
$role_id=$this->Session->read('role_id');
$this->set('s_role_id',$role_id);
$wing=$this->Session->read('wing');
$current_date = new MongoDate(strtotime(date("Y-m-d")));
$this->loadmodel('master_notice_category');
$this->set('result1', $this->master_notice_category->find('all'));
if($role_id==3)
{
$this->loadmodel('notice');
$conditions=array("n_draft_id" => 0, "n_delete_id" => 0,"society_id"=> $s_society_id);
$order=array('notice_id'=>'DESC');
$res_notice=$this->notice->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('result_notice_publish',$res_notice);
$current_date=date("d-m-Y");

foreach($res_notice as $data)
{
$notice_id=$data['notice']['notice_id'];
$n_expire_date=$data['notice']['n_expire_date'];
$n_expire_date= date('d-m-Y', $n_expire_date->sec);
	if(strtotime($n_expire_date) < strtotime($current_date))
	{
		$this->loadmodel('notice');
		$this->notice->updateAll(array('n_draft_id'=>2),array('notice_id'=>$notice_id));
	}
	
}



if(!empty($cat))
{
$this->set('red_cat',$cat);	
$conditions=array("n_draft_id" => 0, "n_delete_id" => 0,"society_id"=> $s_society_id,'n_category_id'=>(int)$cat);
$order=array('notice.notice_id'=>'DESC');
$this->set('result_notice_publish',$this->notice->find('all',array('conditions'=>$conditions,'order'=>$order)));
}
}
else
{
$this->loadmodel('notice');
$conditions =array( '$or' => array( 
array('n_draft_id' => 0,'society_id' =>$s_society_id,'visible' =>1,'n_expire_date' => array('$gte'=>$current_date)),
array('n_draft_id' => 0,'society_id' =>$s_society_id,'visible' =>2,'sub_visible' =>array('$in' => array($role_id)),'n_expire_date' => array('$gte'=>$current_date)),
array('n_draft_id' => 0,'society_id' =>$s_society_id,'visible' =>3,'sub_visible' =>array('$in' => array($wing)),'n_expire_date' => array('$gte'=>$current_date)),
array('n_draft_id' => 0,'society_id' =>$s_society_id,'visible' =>4,'sub_visible' =>$tenant,'n_expire_date' => array('$gte'=>$current_date)),
array('n_draft_id' => 0,'society_id' =>$s_society_id,'visible' =>5,'sub_visible' =>$tenant,'n_expire_date' => array('$gte'=>$current_date))
));
$order=array('notice.notice_id'=>'DESC');
$this->set('result_notice_publish',$this->notice->find('all', array('conditions' => $conditions,'order' => $order)));
if(!empty($cat))
{
$this->set('red_cat',$cat);
$this->loadmodel('notice');
$conditions =array( '$or' => array( 
array('society_id' =>$s_society_id,'n_category_id'=>(int)$cat,'visible' =>1,'n_expire_date' => array('$gte'=>$current_date)),
array('society_id' =>$s_society_id,'n_category_id'=>(int)$cat,'visible' =>2,'sub_visible' =>array('$in' => array($role_id)),'n_expire_date' => array('$gte'=>$current_date)),
array('society_id' =>$s_society_id,'n_category_id'=>(int)$cat,'visible' =>3,'sub_visible' =>array('$in' => array($wing)),'n_expire_date' => array('$gte'=>$current_date)),
array('society_id' =>$s_society_id,'n_category_id'=>(int)$cat,'visible' =>4,'sub_visible' =>$tenant,'n_expire_date' => array('$gte'=>$current_date)),
array('society_id' =>$s_society_id,'n_category_id'=>(int)$cat,'visible' =>5,'sub_visible' =>$tenant,'n_expire_date' => array('$gte'=>$current_date))
));
$order=array('notice.notice_id'=>'DESC');
$this->set('result_notice_publish',$this->notice->find('all', array('conditions' => $conditions,'order' => $order)));
}

}

}
///////////////////////////////// End Notice board ////////////////////////////////

function new_notice(){
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	$this->ath();
	$this->check_user_privilages();
	$s_society_id=$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$s_role_id=$this->Session->read('role_id'); 
	$this->loadmodel('master_notice_category');
	$this->set('result1', $this->master_notice_category->find('all'));
	$this->loadmodel('master_notice_category');
	$this->set('result1', $this->master_notice_category->find('all'));
	$this->loadmodel('role');
	$conditions=array("society_id" => $s_society_id);
	$role_result=$this->role->find('all',array('conditions'=>$conditions));
	$this->set('role_result',$role_result);
	$this->loadmodel('wing');
	$conditions=array("society_id" => $s_society_id);
	$wing_result=$this->wing->find('all',array('conditions'=>$conditions));
	$this->set('wing_result',$wing_result);
	
}

function edit_notice($id=null){
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	$this->ath();
	//$this->check_user_privilages();
	$s_society_id=$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$s_role_id=$this->Session->read('role_id'); 
	$this->loadmodel('master_notice_category');
	$this->set('result1', $this->master_notice_category->find('all'));
	$this->loadmodel('master_notice_category');
	$this->set('result1', $this->master_notice_category->find('all'));
	$this->loadmodel('role');
	$conditions=array("society_id" => $s_society_id);
	$role_result=$this->role->find('all',array('conditions'=>$conditions));
	$this->set('role_result',$role_result);
	$this->loadmodel('wing');
	$conditions=array("society_id" => $s_society_id);
	$wing_result=$this->wing->find('all',array('conditions'=>$conditions));
	$this->set('wing_result',$wing_result);
	
	$notice_id=(int)$id;
	$this->set('notice_id',$notice_id);
	$this->loadmodel('notice');
	$conditions=array("notice_id" => $notice_id);
	$result5= $this->notice->find('all',array('conditions'=>$conditions));
	$this->set('result_notices',$result5); 
}

function submit_notice(){
	$this->layout=null;
	$post_data=$this->request->data;
	
	
	$this->ath();
	$s_society_id=$this->Session->read('society_id');
	$s_role_id=$this->Session->read('role_id'); 
	$s_user_id=$this->Session->read('user_id');
	$date=date('d-m-Y');
	$time = date(' h:i a', time());
	$result_society=$this->society_name($s_society_id);
	foreach($result_society as $child)	{
		@$notice=$child['society']['notice'];
		 @$s_duser_id[]=$child['society']['user_id'];
	}
	
	
	
	if(empty($post_data['notice_subject'])){
		$output = json_encode(array('type'=>'error', 'text' => 'Please fill subject.'));
		die($output);
	}
	if($post_data['notice_category']==0){
		$output = json_encode(array('type'=>'error', 'text' => 'Please select category for notice.'));
		die($output);
	}
	if(empty($post_data['notice_expire_date'])){
		$output = json_encode(array('type'=>'error', 'text' => 'Please select expire date for notice.'));
		die($output);
	}
	
	if(!empty($post_data['notice_expire_date'])){
		 if(strtotime($post_data['notice_expire_date'])<strtotime($date)){
				$output = json_encode(array('type'=>'error', 'text' => 'Notice expire date should be >current date'));
				die($output);
		
			}
	
		
	}

	
	if(empty($post_data['code'])){
		$output = json_encode(array('type'=>'error', 'text' => 'Please create notice.'));
		die($output);
	}
	if($post_data['visible']==0){
		$output = json_encode(array('type'=>'error', 'text' => 'Please select visible.'));
		die($output);
	}elseif($post_data['visible']==2 and $post_data['sub_visible']==0){
		$output = json_encode(array('type'=>'error', 'text' => 'Please select role.'));
		die($output);
	}elseif($post_data['visible']==3 and $post_data['sub_visible']==0){
		$output = json_encode(array('type'=>'error', 'text' => 'Please select wing.'));
		die($output);
	}
	
	$category_id=(int)$post_data['notice_category'];
	$notice_subject=htmlentities($post_data['notice_subject']);
	$notice_subject = wordwrap($notice_subject, 25, " ", true);
	$sub=html_entity_decode($notice_subject);
	
	$notice_expire_date = new MongoDate(strtotime(date("Y-m-d", strtotime($post_data['notice_expire_date']))));
	$code=$post_data['code'];
	$visible=(int)$post_data['visible'];
	$sub_visible=$post_data['sub_visible'];
	$sub_visible=explode(",",$sub_visible);
	$allowed=(int)$post_data['allowed'];


if($post_data['post_type']==1){
	if($notice==1 && $s_role_id!=3){
		
		if(isset($_FILES['file'])){
		$target = "notice_file/";
		$file_name=@$_FILES['file']['name'];
		$file_tmp_name =$_FILES['file']['tmp_name'];
		$target=@$target.basename($file_name);
		move_uploaded_file($file_tmp_name,@$target);
		}
		
		$notice_id=$this->autoincrement('notice','notice_id');
		$this->loadmodel('notice');
		$this->notice->save(array('notice_id' => $notice_id, 'user_id' => $s_user_id, 'society_id' => $s_society_id, 'n_category_id' => $category_id ,'n_subject' => $notice_subject , 'n_expire_date' => $notice_expire_date, 'n_attachment' => @$file_name , 'n_message' => $code,'n_date' => $date, 'n_time' => $time, 'n_delete_id' => 0,'n_draft_id' => 4,'visible' => $visible,'sub_visible' => $sub_visible,'allowed' => $allowed));
		
		$this->send_notification('<span class="label label-info" ><i class="icon-bullhorn"></i></span>','Approval request for notice published - <b>'.$notice_subject.'</b> by',2,$notice_id,$this->webroot.'Hms/notice_approval',$s_user_id,$s_duser_id);
						
		$output = json_encode(array('type'=>'approve', 'text' =>'Your notice has created and sent for approval to your society Admin/Committee.'));
		die($output);
	}else{
		
		 
		@$ip=$this->hms_email_ip();
		
		
		$recieve_info=$this->visible_subvisible($visible,$sub_visible);
		
		 
		if(isset($_FILES['file'])){
		$target = "notice_file/";
		$file_name=@$_FILES['file']['name'];
		$file_tmp_name =$_FILES['file']['tmp_name'];
		$target=@$target.basename($file_name);
		move_uploaded_file($file_tmp_name,@$target);
		}
		if(!empty($file_name))
				{
				//@$file_att='<br/><a href="'.$ip.'/'.$this->webroot.'notice_file/'.$file_name.'" download>Download attachment</a><br/><br/>';
				}

		
		
		
		$notice_id=$this->autoincrement('notice','notice_id');
		$this->loadmodel('notice');
		$this->notice->save(array('notice_id' => $notice_id, 'user_id' => $s_user_id, 'society_id' => $s_society_id, 'n_category_id' => $category_id ,'n_subject' => $notice_subject , 'n_expire_date' => $notice_expire_date, 'n_attachment' => @$file_name, 'n_message' => $code,'n_date' => $date, 'n_time' => $time, 'n_delete_id' => 0,'n_draft_id' => 0,'visible' => $visible,'sub_visible' => $sub_visible,'visible_user_id' => $recieve_info[2],'allowed' => $allowed));
		
		
		
		
		$this->loadmodel('email');
		$conditions=array('auto_id'=>2);
		$result_email=$this->email->find('all',array('conditions'=>$conditions));
		foreach ($result_email as $collection) 
		{
		$from=$collection['email']['from'];
		}
		$from_name="HousingMatters";
		$reply="donotreply@housingmatters.in";
		$category_name=$this->notice_category_name($category_id);
		$society_result=$this->society_name($s_society_id);
		foreach($society_result as $data)
		{
		$society_name=$data['society']['society_name'];
		}

		
		foreach($recieve_info[0] as $user_id=>$email)
		{
		$to = @$email;
		$d_user_id = @$user_id;	
		$da_user_id[]=$d_user_id;		
		$result_user=$this->profile_picture($user_id);
		$user_name=$result_user[0]['user']['user_name'];

		
		
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
										<span style="color:rgb(100,100,99)" align="justify"> Dear  '.$user_name.' </span> <br>
										</td>
								
								
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> A new notice has been posted on your society Notice Board. </span>
									</td>
																
								</tr>
								
								
								<tr>
									<td>
									
										<table  cellpadding="5" cellspacing="0" width="100%;"border="1" style="border:1px solid #e5e5e5;">
						
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Date</td>
										<td align="left" style="background-color:#f8f8f8;font-size:12px;" >'.$date.'</td>
										</tr>
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Subject</td>
										<td align="left" style="background-color:#f8f8f8;font-size:12px;" >'.$notice_subject.'</td>
										</tr>
										
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Category</td>
										<td align="left" style="background-color:#f8f8f8;font-size:12px;" >'.$category_name.'</td>
										</tr>
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Sent to</td>
										<td align="left" style="background-color:#f8f8f8;font-size:12px;" >'.$recieve_info[3].'</td>
										</tr>
									
										</table> 
									
									</td>
								
								
								
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<p style="font-size:16px;"> <strong>Notice Description:</strong></p>
										<p align="justify">'.$code.'</p>
										</td>
								</tr>
					
								<tr>
										<td style="padding:5px;" width="100%" align="center">
										<span style="color:rgb(100,100,99)">To view / respond <a href="'.$ip.$this->webroot.'" style="width:100px; height:30px;"><span style="background-color:#00A0E3;color:white;"><button style="width:100px; height:30px;  background-color:#00A0E3;color:white" id="bg_color_m"> Click Here </button> </span></a> </span>
										</td>
								</tr>
					

								<tr>
								<td style="font-size:12px;" width="100%" align="left">
								<P align="justify">For any software related queries, please contact <span style="color:#00A0E3;"> support@housingmatters.in </span></p>
								<p align="justify">	www.housingmatters.co.in </p>
								</td>
								</tr>

					
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';*/

		 $message_web='<div style="margin:0;padding:0" dir="ltr" bgcolor="#ffffff"><div class="adM">
	</div><table style="border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" width="100%;">
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
								<td style="height:32;line-height:0px" align="left" valign="middle" width="32"><a href="#150cd117ec15fdb9_" style="color:#3b5998;text-decoration:none"><img class="CToWUd" src="'.$ip.$this->webroot.'as/hm/HM-LOGO-small.jpg" style="border:0" height="50" width="50"></a></td>
								<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
								<td width="100%"><a href="#150cd117ec15fdb9_" style="color:#3b5998;text-decoration:none;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:19px;line-height:32px"><span style="color:#00a0e3">Housing</span><span style="color:#777776">Matters</span></a></td>
								<td align="right"><a href="https://www.facebook.com/HousingMatters.co.in" target="_blank"><img class="CToWUd" src="'.$ip.$this->webroot.'as/hm/SMLogoFB.png" style="max-height:30px;min-height:30px;width:30px;max-width:30px" height="30px" width="30px"></a>
									
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
								<td><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="line-height:28px" height="28">&nbsp;</td></tr><tr><td><span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:16px;line-height:21px;color:#141823">Hello  '.$user_name.'<br>A new notice has been posted on your society Notice Board.</span></td></tr><tr><td style="line-height:14px" height="14">&nbsp;</td></tr><tr><td><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;border:solid 1px #e5e5e5;border-radius:2px;display:block"><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="padding:5px 10px;background:#269abc;border-top:#cccccc 1px solid;border-bottom:#cccccc 1px solid"><span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:16px;line-height:19px;color:#fff">'.$notice_subject.'</span></td></tr><tr>
								<td style="padding:5px">
								
								<table style="border-collapse:collapse" cellpadding="0" cellspacing="0">
									<tr>
										<td>
										<span style="color:#adabab;font-size:12px">Category : '.$category_name.'  </span>
										</td>
										<td>&nbsp;&nbsp;|&nbsp;&nbsp;</td>
										<td>
										<span style="color:#adabab;font-size:12px">Sent to : '.$recieve_info[3].'  </span>
										</td>
										<td>&nbsp;&nbsp;|&nbsp;&nbsp;</td>
										<td>
										<span style="color:#adabab;font-size:12px">Date :'.$date.'</span>
										</td>
										<td></td>
									</tr>
								</table>
								</td>
							</tr>
							<tr>
								<td style="padding:5px" height="10">'.$code.'</td>
							</tr>
						</tbody>
					</table></td></tr></tbody></table></td></tr><tr><td style="line-height:14px" height="14">&nbsp;</td></tr></tbody></table></td>
								<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
</tr>						<tr>
								<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
								<td>
									<table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="line-height:2px" colspan="3" height="2">&nbsp;</td></tr><tr><td><a href="#150cd117ec15fdb9_" style="color:#3b5998;text-decoration:none"><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="border-collapse:collapse;border-radius:2px;text-align:center;display:block;border:1px solid #026a9e;background:#008ed5;padding:7px 16px 11px 16px"><a href="'.$ip.$this->webroot.'Notices/notice_publish_view/'.$notice_id.'" style="color:#3b5998;text-decoration:none;display:block" target="_blank"><center><font size="3"><span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;white-space:nowrap;font-weight:bold;vertical-align:middle;color:#ffffff;font-size:14px;line-height:14px">View on HousingMatters</span></font></center></a></td></tr></tbody></table></a></td><td style="display:block;width:10px" width="10">&nbsp;&nbsp;&nbsp;</td><td><a href="#150cd117ec15fdb9_" style="color:#3b5998;text-decoration:none"><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr></tr></tbody></table></a></td><td width="100%"></td></tr><tr><td style="line-height:32px" colspan="3" height="32">&nbsp;</td></tr></tbody></table>
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
	</table><div class="yj6qo"></div><div class="adL">
</div></div>';

		$this->loadmodel('notification_email');
		$conditions7=array("module_id" =>1,"user_id"=>$d_user_id,'chk_status'=>0);
		$result5=$this->notification_email->find('all',array('conditions'=>$conditions7));
		$n=sizeof($result5);
		if($n>0)
		{
			
		@$subject.= '['. $society_name . ']  - '.' New Notice : '.'     '.''.$sub.'';
		$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
		$subject="";
		}	
		}


		//$da_user_id[]=$d_user_id;
		$this->send_notification('<span class="label label-info" ><i class="icon-bullhorn"></i></span>','New Notice published - <b>'.$notice_subject.'</b> by',2,$notice_id,$this->webroot.'Notices/notice_publish_view/'.$notice_id,$s_user_id,$da_user_id);

		$output = json_encode(array('type'=>'created', 'text' =>'Your notice has been created and sent via email to all users selected by you.'));
		die($output);
	}
}
if($post_data['post_type']==2){
	$file_name="";
	if(isset($_FILES['file'])){
		$target = "notice_file/";
		$file_name=$_FILES['file']['name'];
		$file_tmp_name =$_FILES['file']['tmp_name'];
		$target=@$target.basename($file_name);
		move_uploaded_file($file_tmp_name,@$target);
		}
	
	$notice_id=$this->autoincrement('notice','notice_id');	
	$this->loadmodel('notice');
	$this->notice->save(array('notice_id' => $notice_id, 'user_id' => $s_user_id, 'society_id' => $s_society_id, 'n_category_id' => $category_id ,'n_subject' => $notice_subject , 'n_expire_date' => $notice_expire_date, 'n_attachment' => $file_name , 'n_message' => $code,'n_date' => $date, 'n_time' => $time, 'n_delete_id' => 0,'n_draft_id' => 1,'visible' => $visible,'sub_visible' => $sub_visible ,'allowed' => $allowed));
	$output = json_encode(array('type'=>'draft', 'text' =>'Your notice has been saved in Draft box. You can edit/post later.'));
	die($output);
}	
	
		
	
	
	
}




function submit_notice_edit($id=null){

	$this->layout=null;
	$post_data=$this->request->data;
	$this->ath();
	$s_society_id=$this->Session->read('society_id');
	$s_role_id=$this->Session->read('role_id'); 
	$s_user_id=$this->Session->read('user_id');
	$date=date('d-m-Y');
	$time = date(' h:i a', time());
	$result_society=$this->society_name($s_society_id);
	foreach($result_society as $child)	{
		@$notice=$child['society']['notice'];
	}
	
	if(empty($post_data['notice_subject'])){
		$output = json_encode(array('type'=>'error', 'text' => 'Please fill subject.'));
		die($output);
	}
	if($post_data['notice_category']==0){
		$output = json_encode(array('type'=>'error', 'text' => 'Please select category for notice.'));
		die($output);
	}
	if(empty($post_data['notice_expire_date'])){
		$output = json_encode(array('type'=>'error', 'text' => 'Please select expire date for notice.'));
		die($output);
	}
	if(empty($post_data['code'])){
		$output = json_encode(array('type'=>'error', 'text' => 'Please create notice.'));
		die($output);
	}
		
	$notice_id_q=(int)$this->request->query('q');
	
	$this->loadmodel('notice');
	$conditions=array("notice_id" => $notice_id_q);
	$result5= $this->notice->find('all',array('conditions'=>$conditions));
	
	
	
	$category_id=(int)$post_data['notice_category'];
	$notice_subject=htmlentities($post_data['notice_subject']);
	$notice_subject = wordwrap($notice_subject, 25, " ", true);
	$sub=$notice_subject;
	$notice_expire_date = new MongoDate(strtotime(date("Y-m-d", strtotime($post_data['notice_expire_date']))));
	$code=$post_data['code'];
	$visible=(int)$result5[0]['notice']['visible'];
	$sub_visible=$result5[0]['notice']['sub_visible'];
	



	if($notice==1 && $s_role_id!=3){
		$notice_id=$this->autoincrement('notice','notice_id');
		$this->loadmodel('notice');
		$this->notice->updateAll(array('notice_id' => $notice_id, 'user_id' => $s_user_id, 'society_id' => $s_society_id, 'n_category_id' => $category_id ,'n_subject' => $notice_subject , 'n_expire_date' => $notice_expire_date, 'n_attachment' => "" , 'n_message' => $code,'n_date' => $date, 'n_time' => $time, 'n_delete_id' => 0,'n_draft_id' => 4,'visible' => $visible,'sub_visible' => $sub_visible),array('notice_id'=>$notice_id_q));
		
		$output = json_encode(array('type'=>'approve', 'text' =>'Your notice has created and sent for approval to your society Admin/Committee.'));
		die($output);
	}else{
		
		 
		@$ip=$this->hms_email_ip();
		
		
		$recieve_info=$this->visible_subvisible($visible,$sub_visible);
		
		$notice_id=$this->autoincrement('notice','notice_id');
		$this->loadmodel('notice');
		$this->notice->updateAll(array('notice_id' => $notice_id, 'user_id' => $s_user_id, 'society_id' => $s_society_id, 'n_category_id' => $category_id ,'n_subject' => $notice_subject , 'n_expire_date' => $notice_expire_date, 'n_attachment' => "" , 'n_message' => $code,'n_date' => $date, 'n_time' => $time, 'n_delete_id' => 0,'n_draft_id' => 0,'visible' => $visible,'sub_visible' => $sub_visible,'visible_user_id' => $recieve_info[2] ),array('notice_id'=>$notice_id_q));
		
		
		
		
		$this->loadmodel('email');
		$conditions=array('auto_id'=>2);
		$result_email=$this->email->find('all',array('conditions'=>$conditions));
		foreach ($result_email as $collection) 
		{
		$from=$collection['email']['from'];
		}
		$from_name="HousingMatters";
		$reply="donotreply@housingmatters.in";
		$category_name=$this->notice_category_name($category_id);
		$society_result=$this->society_name($s_society_id);
		foreach($society_result as $data)
		{
		$society_name=$data['society']['society_name'];
		}

		
		foreach($recieve_info[0] as $user_id=>$email)
		{
		$to = @$email;
		$d_user_id = @$user_id;	 
		$result_user=$this->profile_picture($user_id);
		$user_name=$result_user[0]['user']['user_name'];

		
		/*  $message_web='<table  align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
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
										<span style="color:rgb(100,100,99)" align="justify"> Dear  '.$user_name.' </span> <br>
										</td>
								
								
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> A new notice has been posted on your society Notice Board. </span>
									</td>
																
								</tr>
								
								
								<tr>
									<td>
									
										<table  cellpadding="5" cellspacing="0" width="100%;"border="1" style="border:1px solid #e5e5e5;">
						
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Date</td>
										<td align="left" style="background-color:#f8f8f8;font-size:12px;" >'.$date.'</td>
										</tr>
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Subject</td>
										<td align="left" style="background-color:#f8f8f8;font-size:12px;" >'.$notice_subject.'</td>
										</tr>
										
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Category</td>
										<td align="left" style="background-color:#f8f8f8;font-size:12px;" >'.$category_name.'</td>
										</tr>
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Sent to</td>
										<td align="left" style="background-color:#f8f8f8;font-size:12px;" >'.$recieve_info[3].'</td>
										</tr>
									
										</table> 
									
									</td>
								
								
								
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<p style="font-size:16px;"> <strong>Notice Description:</strong></p>
										<p align="justify">'.$code.'</p>
										</td>
								</tr>
					
								<tr>
										<td style="padding:5px;" width="100%" align="center">
										<span style="color:rgb(100,100,99)">To view / respond <a href="'.$ip.$this->webroot.'" style="width:100px; height:30px;"><span style="background-color:#00A0E3;color:white;"><button style="width:100px; height:30px;  background-color:#00A0E3;color:white" id="bg_color_m"> Click Here </button> </span></a> </span>
										</td>
								</tr>
					

								<tr>
								<td style="font-size:12px;" width="100%" align="left">
								<P align="justify">For any software related queries, please contact <span style="color:#00A0E3;"> support@housingmatters.in </span></p>
								<p align="justify">	www.housingmatters.co.in </p>
								</td>
								</tr>

					
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';
*/




	 $message_web='<div style="margin:0;padding:0" dir="ltr" bgcolor="#ffffff"><div class="adM">
	</div><table style="border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" width="100%;">
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
								<td style="height:32;line-height:0px" align="left" valign="middle" width="32"><a href="#150cd117ec15fdb9_" style="color:#3b5998;text-decoration:none"><img class="CToWUd" src="'.$ip.$this->webroot.'as/hm/HM-LOGO-small.jpg" style="border:0" height="50" width="50"></a></td>
								<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
								<td width="100%"><a href="#150cd117ec15fdb9_" style="color:#3b5998;text-decoration:none;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:19px;line-height:32px"><span style="color:#00a0e3">Housing</span><span style="color:#777776">Matters</span></a></td>
								<td align="right"><a href="https://www.facebook.com/HousingMatters.co.in" target="_blank"><img class="CToWUd" src="'.$ip.$this->webroot.'as/hm/SMLogoFB.png" style="max-height:30px;min-height:30px;width:30px;max-width:30px" height="30px" width="30px"></a>
									
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
								<td><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="line-height:28px" height="28">&nbsp;</td></tr><tr><td><span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:16px;line-height:21px;color:#141823">Hello  '.$user_name.'<br>A new notice has been posted on your society Notice Board.</span></td></tr><tr><td style="line-height:14px" height="14">&nbsp;</td></tr><tr><td><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;border:solid 1px #e5e5e5;border-radius:2px;display:block"><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="padding:5px 10px;background:#269abc;border-top:#cccccc 1px solid;border-bottom:#cccccc 1px solid"><span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:16px;line-height:19px;color:#fff">'.$notice_subject.'</span></td></tr><tr>
								<td style="padding:5px">
								
								<table style="border-collapse:collapse" cellpadding="0" cellspacing="0">
									<tr>
										<td>
										<span style="color:#adabab;font-size:12px">Category : '.$category_name.'  </span>
										</td>
										<td>&nbsp;&nbsp;|&nbsp;&nbsp;</td>
										<td>
										<span style="color:#adabab;font-size:12px">Sent to : '.$recieve_info[3].'  </span>
										</td>
										<td>&nbsp;&nbsp;|&nbsp;&nbsp;</td>
										<td>
										<span style="color:#adabab;font-size:12px">Date :'.$date.'</span>
										</td>
										<td></td>
									</tr>
								</table>
								</td>
							</tr>
							<tr>
								<td style="padding:5px" height="10">'.$code.'</td>
							</tr>
						</tbody>
					</table></td></tr></tbody></table></td></tr><tr><td style="line-height:14px" height="14">&nbsp;</td></tr></tbody></table></td>
								<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
</tr>						<tr>
								<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
								<td>
									<table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="line-height:2px" colspan="3" height="2">&nbsp;</td></tr><tr><td><a href="#150cd117ec15fdb9_" style="color:#3b5998;text-decoration:none"><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="border-collapse:collapse;border-radius:2px;text-align:center;display:block;border:1px solid #026a9e;background:#008ed5;padding:7px 16px 11px 16px"><a href="'.$ip.$this->webroot.'Notices/notice_publish_view/'.$notice_id.'" style="color:#3b5998;text-decoration:none;display:block" target="_blank"><center><font size="3"><span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;white-space:nowrap;font-weight:bold;vertical-align:middle;color:#ffffff;font-size:14px;line-height:14px">View on HousingMatters</span></font></center></a></td></tr></tbody></table></a></td><td style="display:block;width:10px" width="10">&nbsp;&nbsp;&nbsp;</td><td><a href="#150cd117ec15fdb9_" style="color:#3b5998;text-decoration:none"><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr></tr></tbody></table></a></td><td width="100%"></td></tr><tr><td style="line-height:32px" colspan="3" height="32">&nbsp;</td></tr></tbody></table>
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
	</table><div class="yj6qo"></div><div class="adL">
</div></div>';
	
		$this->loadmodel('notification_email');
		$conditions7=array("module_id" =>1,"user_id"=>$d_user_id,'chk_status'=>0);
		$result5=$this->notification_email->find('all',array('conditions'=>$conditions7));
		$n=sizeof($result5);
		if($n>0)
		{
			@$subject.= '['. $society_name . ']  - '.' New Notice : '.'     '.''.$sub.'';
			$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
			$subject="";
		}	
		}


		$da_user_id[]=$d_user_id;
		$this->send_notification('<span class="label label-info" ><i class="icon-bullhorn"></i></span>','New Notice published - <b>'.$notice_subject.'</b> by',2,$notice_id,'notice_publish_view?con='.$notice_id,$s_user_id,$da_user_id);

		$output = json_encode(array('type'=>'created', 'text' =>'Your notice has been created and sent via email to all users selected by you.'));
		die($output);
	}

	
	
		
	
	
	
}

}
?>