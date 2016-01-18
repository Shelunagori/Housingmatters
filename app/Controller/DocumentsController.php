<?php
App::import("Controller","Hms");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
class DocumentsController extends HmsController{
var $helpers = array('Html', 'Form','Js');
public $components = array(
'Paginator',
'Session','Cookie','RequestHandler'
);


var $name = 'Documents';



/////////////////////////////////////////////////////////// Resource Start ////////////////////////////////////////////////////////////	

function resource_add()
{

	if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
	$this->ath();
	$this->check_user_privilages();
	$s_society_id=$this->Session->read('society_id');
	$s_role_id=$this->Session->read('role_id');
	$s_user_id=$this->Session->read('user_id');
	$this->set('role_id',$s_role_id=$this->Session->read('role_id')); 
	$this->loadmodel('resource_category');
	$this->set('result_resource_category',$this->resource_category->find('all'));  
	$this->loadmodel('role');
	$conditions=array("society_id" => $s_society_id);
	$role_result=$this->role->find('all',array('conditions'=>$conditions));
	$this->set('role_result',$role_result);
	$this->loadmodel('wing');
	$wing_result=$this->wing->find('all');
	$this->set('wing_result',$wing_result);


	$result=$this->society_name($s_society_id);
	foreach($result as $data)
	{
	@$document=$data['society']['document'];
	@$s_duser_id[]=$data['society']['user_id'];
	}
	if($document==1 && $s_role_id!=3 )
	{		

				
			if($this->request->is('post'))
			{
				$resource_title= $this->request->data['title'];
				$resource_cat= (int)$this->request->data['sel'];
				$resource_att=$this->request->form['file']['name'];
				$i=$this->autoincrement('resource','resource_id');
				$visible=(int)$this->request->data['visible'];
				
				
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
					
							
				$date=date("d-m-Y");
				$time=date('h:i:a',time());
				$target = "resource_file/";
				$target=@$target.basename( @$this->request->form['file']['name']);
				$ok=1;
				move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target); 
					
				$this->loadmodel('resource');
				$this->resource->saveAll(array("resource_id" => $i, "resource_attachment" => $resource_att , "resource_title" => $resource_title,"resource_date"=>$date,"resource_category"=>$resource_cat,"user_id"=>$s_user_id,"society_id"=>$s_society_id,"resource_time"=>$time,"resource_delete"=>4,"visible"=>$visible,"sub_visible"=>$sub_visible));	
				
				
$this->send_notification('<span class="label label-warning" ><i class="icon-folder-open"></i></span>','Approval request for  document <b>'.$resource_title.'</b> created by',4,$i,$this->webroot.'Hms/resource_approval',$s_user_id,$s_duser_id);
			$this->Session->write('document_status1', 2);
			$this->response->header('Location', $this->webroot.'Documents/resource_view');	
			}
	}
	else
	{
	
	
if($this->request->is('post'))
{
	
	$ip=$this->hms_email_ip();
$resource_title= $this->request->data['title'];
$resource_cat= (int)$this->request->data['sel'];
$resource_att=$this->request->form['file']['name'];
$i=$this->autoincrement('resource','resource_id');
$visible=(int)$this->request->data['visible'];	
$date=date("d-m-Y");
$time=date('h:i:a',time());
$target = "resource_file/";
$target=@$target.basename( @$this->request->form['file']['name']);
$ok=1;
move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target); 

if($visible==1)
{	
$visible=1;
$sub_visible[]=0;
/////////////////////////////////////////// All user ////////////////////////////
//$this->loadmodel('user');
//$conditions=array('society_id'=>$s_society_id);
//$result_user=$this->user->find('all',array('conditions'=>$conditions));
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
$wing_id=(int)$collection["wing"]["wing_id"];

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

$this->loadmodel('resource');
$this->resource->saveAll(array("resource_id" => $i, "resource_attachment" => $resource_att , "resource_title" => $resource_title,"resource_date"=>$date,"resource_category"=>$resource_cat,"user_id"=>$s_user_id,"society_id"=>$s_society_id,"resource_time"=>$time,"resource_delete"=>0,"visible"=>$visible,"sub_visible"=>$sub_visible));	
////////////////////////////////////////////// Email Code Start ////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$this->loadmodel('email');
$conditions=array('auto_id'=>6);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
}
$from_name="HousingMatters";
$reply="donotreply@housingmatters.in";
$category_name=$this->resource_category_name($resource_cat);
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
if(sizeof(@$da_to)==0) { $da_to=array(); }
for($k=0;$k<sizeof($da_to);$k++)
{
	
$to = @$da_to[$k];
$d_user_id = @$da_user_id[$k];	 
$user_name = @$da_user_name[$k];



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
										<span style="color:rgb(100,100,99)" align="justify"> Dear '.$user_name.' </span> <br>
										</td>
								
								
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> A new document has been uploaded in your society Resource section. </span>
									</td>
																
								</tr>
								
								
								<tr>
									<td>
									
										<table  cellpadding="5" cellspacing="0" width="100%;"border="1" style="border:1px solid #e5e5e5;">
						
										<tr>
										<td align="left" style="background-color:#00A0E3;color:white;" width="200">Date</td>
										<td align="left" style="background-color:#f8f8f8;" width="600" >'.$date.'</td>
										</tr>
										

										
										
										<tr>
										<td align="left" style="background-color:#00A0E3;color:white;" >Category</td>
										<td align="left" style="background-color:#f8f8f8;" >'.$category_name.'</td>
										</tr>
										
										<tr>
										<td align="left" style="background-color:#00A0E3;color:white;" >Title	</td>
										<td align="left" style="background-color:#f8f8f8;" >'.$resource_title.'</td>
										</tr>
										
										
										<tr>
										<td align="left" style="background-color:#00A0E3;color:white;" >Attention</td>
										<td align="left" style="background-color:#f8f8f8;" >'.$send.'</td>
										</tr>
									
										</table> 
									
									</td>
								
								
								
								</tr>
								

					
								<tr>
										<td style="padding:10px;" width="100%" align="center">
										<a href="'.$ip.$this->webroot.'Documents/resource_view" style="width: 100px; min-height: 30px; background-color: rgb(0, 142, 213); padding: 10px; font-family: Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif; white-space: nowrap; font-weight: bold; vertical-align: middle; font-size: 14px; line-height: 14px; color: rgb(255, 255, 255); border: 1px solid rgb(2, 106, 158); text-decoration: none;" target="_blank">view / on HousingMatters</a>
										</td>
								</tr>
					

								<tr>
								<td style="" width="100%" align="left">
									Thank you.<br/>
									HousingMatters (Support Team)<br/>
									www.housingmatters.in 
								</td>
								</tr>

					
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';

$this->loadmodel('notification_email');
$conditions7=array("module_id" =>6,"user_id"=>$d_user_id,'chk_status'=>0);
$result5=$this->notification_email->find('all',array('conditions'=>$conditions7));
$n=sizeof($result5);
if($n>0)
{
@$subject.= '['. $society_name . ']'.'-' . 'New Document :'.  '    ' .$resource_title;
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$subject="";
}	
}



$this->send_notification('<span class="label label-warning" ><i class="icon-folder-open"></i></span>','New document <b>'.$resource_title.'</b> submitted by',4,$i,$this->webroot.'Documents/resource_view',$s_user_id,$da_user_id);

$this->Session->write('document_status', 1);
$this->response->header('Location', $this->webroot.'Documents/resource_view');
	
?>
<!----alert--------------
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Resources are published
</div> 
<div class="modal-footer">
<a href="resource_view" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php

}

}

}




function resource_category_name($category_id)
{
$this->loadmodel('resource_category');
$conditions=array("resource_cat_id" => $category_id);
$result_category=$this->resource_category->find('all',array('conditions'=>$conditions));
foreach ($result_category as $collection) 
{
return $resource_cat_name=$collection['resource_category']['resource_cat_name'];
}
}

function resource_approval()
{

	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->check_user_privilages();	
$this->ath();	
$s_society_id=$this->Session->read('society_id');
$this->loadmodel('resource');
$conditions=array('society_id'=>$s_society_id,'resource_delete'=>4);	
$order=array('resource.resource_id'=>'DESC');
$result=$this->resource->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('result_resource',$result);	
	
}
function resource_reject()
{
	$this->layout="blank";	
	$id=(int)$this->request->query('con');
	$this->loadmodel('resource');
	$this->resource->updateAll(array('resource_delete'=>5),array('resource_id'=>$id));
	$this->response->header('location','resource_approval');	
}	
function resource_approve_ajax()
{
	$this->layout='blank';
	$s_society_id=$this->Session->read('society_id');
	$id=(int)$this->request->query('t');
	$ip=$this->hms_email_ip();
	$this->loadmodel('resource');
	$conditions=array('resource_id'=>$id);
	$result_resource=$this->resource->find('all',array('conditions'=>$conditions));
	foreach($result_resource as $data)
	{
		$title=$data['resource']['resource_title'];
		$user_id=$data['resource']['user_id'];
		$date=$data['resource']['resource_date'];
		$resource_category=$data['resource']['resource_category'];
		$visible=(int)$data['resource']['visible'];
		$sub_visible=$data['resource']['sub_visible'];
	}
	
if($visible==1)
{	
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

$this->loadmodel('email');
$conditions=array('auto_id'=>6);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
}
$from_name="HousingMatters";
$reply="donotreply@housingmatters.in";
$category_name=$this->resource_category_name($resource_category);

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
if(sizeof(@$da_to)==0) { $da_to=array(); }
for($k=0;$k<sizeof($da_to);$k++)
{
$to = @$da_to[$k];
$d_user_id = @$da_user_id[$k];	 
$user_name = @$da_user_name[$k];


$message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Dear  $user_name,</p>
<p>A new document has been uploaded in your society Resource section.</p>
<table  cellpadding='10' width='100%;' border='1' bordercolor='#e1e1e1'  >
<tr class='tr_heading' style='background-color:#00A0E3;color:white;'>
<td>Date</td>
<td>Category</td>
<td>Title</td>
<td>Attention</td>
</tr>
<tr class='tr_content' style=background-color:#E9E9E9;'>
<td>$date</td>
<td>$category_name</td>
<td>$title</td>
<td>$send</td>
</tr>
</table>
<div>
<center><p>To view document 
<a href='$ip".$this->webroot."hms' ><button style='width:100px; height:30px;  background-color:#00A0E3;color:white'> Click Here </button></a></p></center><br/>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.co.in
</div >
</div>";

$this->loadmodel('notification_email');
$conditions7=array("module_id" =>6,"user_id"=>$d_user_id,'chk_status'=>0);
$result5=$this->notification_email->find('all',array('conditions'=>$conditions7));
$n=sizeof($result5);
if($n>0)
{
@$subject.= '['. $society_name . ']'.'-' . 'New Document: '.  '    ' .$title;
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$subject="";
}	
}

$this->send_notification('<span class="label label-warning" ><i class="icon-folder-open"></i></span>','New document <b>'.$title.'</b> submitted by',4,$id,$this->webroot.'Documents/resource_view',$user_id,$da_user_id);


$this->loadmodel('resource');
$this->resource->updateAll(array('resource_delete'=>0),array('resource_id'=>$id));	
echo"<td colspan='8'>Documents have published</td>";	
}

function resource_view()
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
$s_user_id=$this->Session->read('user_id');
$this->set('role_id',$role_id); 
$this->loadmodel('resource');
//$conditions=array('society_id'=>$s_society_id);
$conditions =array( '$or' => array( 
array('society_id' =>$s_society_id,'visible' =>1,'resource_delete'=>0),
array('society_id' =>$s_society_id,'resource_delete'=>0,'visible' =>2,'sub_visible' =>array('$in' => array($role_id))),
array('society_id' =>$s_society_id,'resource_delete'=>0,'visible' =>3,'sub_visible' =>array('$in' => array($wing))),
array('society_id' =>$s_society_id,'resource_delete'=>0,'visible' =>4,'sub_visible' =>$tenant),
array('society_id' =>$s_society_id,'visible' =>5,'sub_visible' =>$tenant,'resource_delete'=>0)
));
$order=array('resource.resource_id'=>'DESC');
$result=$this->resource->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('result_resource',$result);

	foreach($result as $resource)
	{
		$this->seen_notification(4,$resource["resource"]["resource_id"]);
	}
}


function index()
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
$s_user_id=$this->Session->read('user_id');
$this->set('role_id',$role_id); 
$this->loadmodel('resource');
//$conditions=array('society_id'=>$s_society_id);
$conditions =array( '$or' => array( 
array('society_id' =>$s_society_id,'visible' =>1,'resource_delete'=>0),
array('society_id' =>$s_society_id,'resource_delete'=>0,'visible' =>2,'sub_visible' =>array('$in' => array($role_id))),
array('society_id' =>$s_society_id,'resource_delete'=>0,'visible' =>3,'sub_visible' =>array('$in' => array($wing))),
array('society_id' =>$s_society_id,'resource_delete'=>0,'visible' =>4,'sub_visible' =>$tenant),
array('society_id' =>$s_society_id,'visible' =>5,'sub_visible' =>$tenant,'resource_delete'=>0)
));
$order=array('resource.resource_id'=>'DESC');
$result=$this->resource->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('result_resource',$result);

	foreach($result as $resource)
	{
		$this->seen_notification(4,$resource["resource"]["resource_id"]);
	}
}

function resource_sm_delete()
{
$this->layout='blank';
$a=(int)$this->request->query('con');
$this->loadmodel('resource');
$this->resource->updateAll(array("resource_delete" =>1),array("resource_id" => $a));
$this->response->header('Location', 'resource_view');
}
function resource_category_name_edit($category_id)
{
$this->loadmodel('resource_category');
$conditions=array("resource_cat_id" => $category_id);
return $result=$this->resource_category->find('all',array('conditions'=>$conditions));

}

function resource_edit($res_id=null)
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$s_society_id=$this->Session->read('society_id');
$res_id=(int)$res_id;
$this->loadmodel('resource');
$conditions=array("resource_id"=> $res_id);
$result=$this->resource->find('all',array('conditions'=>$conditions));

foreach($result as $data)
{
$attachment=$data['resource']['resource_attachment'];
//$visible=$data['resource']['r_visible_id'];
//$sub_visible=$data['resource']['r_sub_visible_id'];
$resource_date=$data['resource']['resource_date'];
}

$this->set('result_resource',$this->resource->find('all',array('conditions'=>$conditions))); 
$this->loadmodel('resource_category');
$this->set('result_cat',$this->resource_category->find('all'));
$this->loadmodel('role');
$conditions=array("society_id" => $s_society_id);
$role_result=$this->role->find('all',array('conditions'=>$conditions));
$this->loadmodel('wing');
$wing_result=$this->wing->find('all');
if($this->request->is('post'))
{

$resource_title= $this->request->data['title'];
$resource_cat= (int)$this->request->data['sel'];
$resource_att=$this->request->form['file']['name'];
if(empty($resource_att))
{
$resource_att=$attachment;
}
$target = "resource_file/";
$target=@$target.basename( @$this->request->form['file']['name']);
$ok=1;
move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target); 
$this->loadmodel('resource');
$this->resource->updateAll( array("resource_attachment" => $resource_att,"resource_title"=>$resource_title,'resource_category'=> $resource_cat),array("resource_id" => $res_id));

$this->redirect(array("controller"=>"Documents","action"=>"resource_view"));
}

}


////////////////////////////////////////////////////Resource End /////////////////////////////////////////////////////////////////////








}
?>