<?php
App::import('Controller', 'Hms');
class ParkingsController extends HmsController {
var $helpers = array('Html', 'Form','Js');
public $components = array(
'Paginator',
'Session','Cookie','RequestHandler'
);


var $name = 'Parkings';

//////////////////////////////// Parking Managment System start /////////////////////
function parking_area_cat($parking_id)
{
	
	$this->layout=Null;	
	$this->loadmodel("parking_area");
	$conditions=array('parking_area_id'=>$parking_id);
	$result_parking=$this->parking_area->find('all',array('conditions'=>$conditions));
	foreach($result_parking as $data)
	{
		return $data['parking_area']['parking_area_cat'];

	}
}
function master_parking()
{

		if($this->RequestHandler->isAjax()){
		$this->layout='blank';
		}else{
		$this->layout='session';
		}	
		 $s_society_id=(int)$this->Session->read('society_id'); 
		$this->ath();
		$this->check_user_privilages();
			if($this->request->is('post'))
			{
				 $parking_area1=$this->request->data['parking_area'];
				
				$this->loadmodel('parking_area');
				 $parking_area_id=$this->autoincrement('parking_area','parking_area_id'); 
				$this->parking_area->saveAll(array('society_id'=>$s_society_id,'parking_area_cat'=>$parking_area1,'parking_area_id'=>$parking_area_id));
					
				?>
				
				<!----alert-------------->
				<div class="modal-backdrop fade in"></div>
				<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
				<div class="modal-body" style="font-size:16px;">
				Successfully add parking Area.
				</div> 
				<div class="modal-footer">
				<a href="master_parking" class="btn green">OK</a>
				</div>
				</div>
				<!----alert-------------->
				
				
				<?php
			}
				$this->loadmodel('parking_area');
				$conditions=array('society_id'=>$s_society_id);
				$result_parking=$this->parking_area->find('all',array('conditions'=>$conditions));
				$this->set('result_parking',$result_parking);
	
	
}
function sm_parking_slot()
{
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	$s_society_id=$this->Session->read('society_id'); 
	$this->ath();
	$this->check_user_privilages();
		$this->loadmodel('parking_area');
		$conditions=array('society_id'=>$s_society_id);
		$result_parking=$this->parking_area->find('all',array('conditions'=>$conditions));
		$this->set('result_parking',$result_parking);

	
	if($this->request->is('post'))
	{
		$this->loadmodel('parking');
		 $parking_area=(int)$this->request->data['sel_parking'];
		
		 $two_slot=$this->request->data['two_slot'];
		 $two_start=$this->request->data['two_start'];
		 $to_r=$two_slot+$two_start;
		 $four_slot=$this->request->data['four_slot'];
		 $four_start=$this->request->data['four_start'];
		 $four_r=$four_slot+$four_start;
		for($i=$two_start;$i<$to_r; $i++)
		{
			$j=$this->autoincrement('parking','parking_id');
			 $to_flot= '2-'.$i ;
			 $this->loadmodel('parking');
			 $this->parking->saveAll(array('parking_id'=>$j,'slot_no'=>$to_flot,'type'=>2,'society_id'=>$s_society_id,'status'=>0,'stiker_number'=>$j,'parking_area'=>$parking_area));
		}
		
		for($k=$four_start;$k<$four_r; $k++)
		{
			$j=$this->autoincrement('parking','parking_id');
			 $fo_flot= '4-'.$k ;
			 $this->loadmodel('parking');
			 $this->parking->saveAll(array('parking_id'=>$j,'slot_no'=>$fo_flot,'type'=>4,'society_id'=>$s_society_id,'status'=>0,'stiker_number'=>$j,'parking_area'=>$parking_area));
		}
		
		 //$this->response->header('location','parking_system_view');
		 
		 ?>
		 
		 
				<!----alert-------------->
				<div class="modal-backdrop fade in"></div>
				<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
				<div class="modal-body" style="font-size:16px;">
				Successfully add parking slot.
				</div> 
				<div class="modal-footer">
				<a href="parking_system_view" class="btn green">OK</a>
				</div>
				</div>
				<!----alert-------------->
								
                
		 
		 
		 
		 
		 
		 <?php
		
		
		
	}
}



function parking_system_view()
{
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	$this->ath();
	$this->check_user_privilages();
	$s_society_id=$this->Session->read('society_id');
	$this->loadmodel('parking');
	$conditions1=array('society_id'=>$s_society_id);
	$result1=$this->parking->find('all',array('conditions'=>$conditions1));
	$this->set('result_parking',$result1);
	
	$this->loadmodel('parking_area');
	$conditions6=array('society_id'=>$s_society_id);
	$result6=$this->parking_area->find('all',array('conditions'=>$conditions6));
	$this->set('result_parking_area',$result6);
	
	
	$this->loadmodel('parking');
	$conditions2=array('society_id'=>$s_society_id,'type'=>2,'status'=>0);
	$result2=$this->parking->find('all',array('conditions'=>$conditions2));
	$n=sizeof($result2);
	$this->set('two_n',$n);
	$this->loadmodel('parking');
	$conditions3=array('society_id'=>$s_society_id,'type'=>4,'status'=>0);
	$result3=$this->parking->find('all',array('conditions'=>$conditions3));
	$n2=sizeof($result3);
	$this->set('four_n',$n2);
	
}


function sm_assign_parking_system()
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
	$this->loadmodel('user');
	$conditions=array('society_id'=>$s_society_id,'deactive'=>0);
	$result=$this->user->find('all',array('conditions'=>$conditions));
	$this->set('result_user',$result);
	$this->loadmodel('parking');
	$conditions2=array('society_id'=>$s_society_id,'type'=>2,'status'=>0);
	$result2=$this->parking->find('all',array('conditions'=>$conditions2));
	$this->set('result_parking2',$result2);
	$this->loadmodel('parking');
	$conditions4=array('society_id'=>$s_society_id,'type'=>4,'status'=>0);
	$result4=$this->parking->find('all',array('conditions'=>$conditions4));
	$this->set('result_parking4',$result4);
	if($this->request->is('post'))
	{
		$user=(int)$this->request->data['sel_user'];
		$type=$this->request->data['wheeler'];
		$vehicle=$this->request->data['vehicle'];
		if($type==2)
		{
			$slot=$this->request->data['sel_slot2'];
		}
		if($type==4)
		{
			$slot=$this->request->data['sel_slot4'];
		}
		
			$this->loadmodel('user');
			$conditions=array('user_id'=>$user);
			$result7=$this->user->find('all',array('conditions'=>$conditions));
			
		foreach($result7 as $data)
		{
		@$parking=$data['user']['parking'];	
		}
		
		

if(sizeof($parking)==0)
{
$parking[]=array($slot,$vehicle);
}
else
{
$t=array($slot,$vehicle);
array_push($parking,$t);
}
$this->loadmodel('parking');
$this->parking->updateAll(array('status'=>1),array('parking_id'=>(int)$slot));
$this->loadmodel('user');
$this->user->updateAll(array('parking'=>$parking),array('user_id'=>$user));
//$this->response->header('location','parking_assign_user_view');



?>


	<!----alert-------------->
	<div class="modal-backdrop fade in"></div>
	<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
	<div class="modal-body" style="font-size:16px;">
	Successfully assign parking slot user.
	</div> 
	<div class="modal-footer">
	<a href="parking_assign_user_view" class="btn green">OK</a>
	</div>
	</div>
	<!----alert-------------->





<?php

	}
}

function parking_assign_user_view()
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
	$this->loadmodel('user');
	$conditions=array('society_id'=>$s_society_id,'user.parking'=>array('$ne'=>null));
	$result=$this->user->find('all',array('conditions'=>$conditions));
	$this->set('result_user',$result);
	
}


function parking_slot($park)
{
	
	$this->loadmodel('parking');
	$conditions=array('parking_id'=>$park);
	return $result=$this->parking->find('all',array('conditions'=>$conditions));
	
	
}

//////////////////////////////// End Parking system ////////////////////////////////




}

?>