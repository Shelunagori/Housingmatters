<?php
//ini_set('max_execution_time', 300); //300 seconds = 5 minutes
class HmsController extends AppController {
var $helpers = array('Html', 'Form','Js');
/*$this->helpers['SocialSignIn.Facebook'] = array(
	'app_id' => '1067899399889225',
	'redirect_uri' => 'hmslogin.com');
	*/
public $components = array(
'Paginator',
'Session','Cookie','RequestHandler'
);




var $name = 'Hms';

function check_charecter_name($name){
	
	$dd=explode(' ',$name);

	for($i=0;$i<sizeof($dd);$i++){
		$r=strtr($dd[$i], array('.' => '', ',' => ''));
		if(strlen($r)>2){
			return $dd[$i];
		}
		
	}
	
	
	/*$dd=explode(' ',$name);
	$first=$dd[0];
	$r=strtr($first, array('.' => '', ',' => ''));
	if(strlen($r)>2){
		return $first=$dd[0];
		
	}else{
		$z=strtr($dd[1], array('.' => '', ',' => ''));
		if(strlen($z)>2){
			return $first=$dd[1];
			
		}else{
			return $first=$dd[2];
		}
		
	}
	
	*/
	
	
}


function email_mobile_update(){
	
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$s_society_id=$this->Session->read('society_id');	
$this->ath();
	$this->loadmodel('user_info_import_record');
	$conditions=array("society_id" => $s_society_id);
	$result_import_record = $this->user_info_import_record->find('all',array('conditions'=>$conditions));
	$this->set('result_import_record',$result_import_record);
	foreach($result_import_record as $data_import){
		$step1=(int)@$data_import["user_info_import_record"]["step1"];
		$step2=(int)@$data_import["user_info_import_record"]["step2"];
		$step3=(int)@$data_import["user_info_import_record"]["step3"];
		$step4=(int)@$data_import["user_info_import_record"]["step4"];
		$date=@$data_import["user_info_import_record"]["date"];
		$this->set("date",$date);
	}
	$process_status= @$step1+@$step2+@$step3+@$step4;
	$this->set("process_status",$process_status);

}

function Upload_user_info_csv_file(){
	$s_society_id = $this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$this->ath();
	if(isset($_FILES['file'])){
		$file_name=$s_society_id.".csv";
		$file_tmp_name =$_FILES['file']['tmp_name'];
		$target = "user_email_mobile_csv/";
		$target=@$target.basename($file_name);
		move_uploaded_file($file_tmp_name,@$target);
		
		
		$today = date("d-M-Y");
		
		$this->loadmodel('user_info_import_record');
		$auto_id=$this->autoincrement('user_info_import_record','auto_id');
		$this->user_info_import_record->saveAll(Array( Array("auto_id" => $auto_id, "file_name" => $file_name,"society_id" => $s_society_id, "user_id" => $s_user_id, "step1" => 1,"date"=>$today))); 
		
		die(json_encode("UPLOADED"));
	}
}

function read_user_info_csv_file(){
	$this->layout=null;
	$s_society_id = $this->Session->read('society_id');
	
	$f = fopen('user_email_mobile_csv/'.$s_society_id.'.csv', 'r') or die("ERROR OPENING DATA");
	$batchcount=0;
	$records=0;
	while (($line = fgetcsv($f, 4096, ';')) !== false) {
	$numcols = count($line);
	$test[]=$line;
	++$records;
	}
	$i=0;
	foreach($test as $child){ $i++;
		if($i>1){
			$child_ar=explode(',',$child[0]);
			$name=$child_ar[0];
			$wing_name=$child_ar[1];
			$flat_name=$child_ar[2];
			$owner_tenant=$child_ar[3];
			$email=$child_ar[4];
			$mobile=$child_ar[5];
			
			
			$this->loadmodel('user_info_csv');
			$auto_id=$this->autoincrement('user_info_csv','auto_id');
			$this->user_info_csv->saveAll(Array(Array("auto_id" => $auto_id, "name" => $name,"wing_name" => $wing_name, "flat_name" => $flat_name, "owner_tenant" => $owner_tenant, "email" => $email, "mobile" => $mobile,"society_id"=>$s_society_id,"is_converted"=>"NO")));
		}
	}
	$this->loadmodel('user_info_import_record');
	$this->user_info_import_record->updateAll(array("step2" => 1),array("society_id" => $s_society_id));
	die(json_encode("READ"));
}

function convert_user_info_data(){
	$this->layout=null;
	$s_society_id = $this->Session->read('society_id');
	
	$this->loadmodel('user_info_csv');
	$conditions=array("society_id" => $s_society_id,"is_converted" => "NO");
	$result_import_record = $this->user_info_csv->find('all',array('conditions'=>$conditions,'limit'=>10));
	foreach($result_import_record as $import_record){
		$user_info_csv_id=$import_record["user_info_csv"]["auto_id"];
		$name=trim($import_record["user_info_csv"]["name"]);
		$wing_name=trim($import_record["user_info_csv"]["wing_name"]);
		$flat_name=trim($import_record["user_info_csv"]["flat_name"]);
		$owner_tenant=trim($import_record["user_info_csv"]["owner_tenant"]);
		$email=trim($import_record["user_info_csv"]["email"]);
		$mobile=trim($import_record["user_info_csv"]["mobile"]);
		
		$this->loadmodel('wing'); 
		$conditions=array("wing_name"=> new MongoRegex('/^' . $wing_name . '$/i'),"society_id"=>$s_society_id);
		$result_ac=$this->wing->find('all',array('conditions'=>$conditions));
		if(sizeof($result_ac)>0){
			foreach($result_ac as $collection){
				$wing_id = (int)$collection['wing']['wing_id'];
			}
		}else{
			$wing_id=0;
		}
		
		$this->loadmodel('flat'); 
		$conditions=array("flat_name"=> new MongoRegex('/^' . $flat_name . '$/i'),"society_id"=>$s_society_id);
		$result_ac=$this->flat->find('all',array('conditions'=>$conditions));
		if(sizeof($result_ac)>0){
			foreach($result_ac as $collection){
				$flat_id = (int)$collection['flat']['flat_id'];
			}
		}else{
			$flat_id=0;
		}
		
		if($owner_tenant=="owner"){ $tenant=1; }else{ $tenant=2; }
		
		$this->loadmodel('user'); 
		$conditions=array("wing"=>$wing_id,"flat"=>$flat_id,"tenant"=>$tenant);
		$result_user=$this->user->find('all',array('conditions'=>$conditions));
		$user_id =0;
		foreach($result_user as $collection){
				$user_id = (int)$collection['user']['user_id'];
			}
		
		 $emailErr = 1;
		 if(!empty($email)){
			 if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			   $emailErr = 0;
			 }else{
				$this->loadmodel('user'); 
				$conditions=array("email"=>$email);
				$result_user_count=$this->user->find('count',array('conditions'=>$conditions));
				
				$this->loadmodel('user_info_csv_converted'); 
				$conditions=array("email"=>$email);
				$result_user_info_csv_converted_count=$this->user_info_csv_converted->find('count',array('conditions'=>$conditions));
				
				if($result_user_count>1 or $result_user_info_csv_converted_count>1){
					 $emailErr = 0;
				}
			 }
		 }
		 
		 
		 $mobileErr = 1;
		 if(!empty($mobile)){
			 $mob="/([0-9]{10})/"; 
			 if(!preg_match($mob, $mobile) && strlen($mobile)!=10 ) {
				 $mobileErr = 0;
			}else{
				$this->loadmodel('user'); 
				$conditions=array("mobile"=>$mobile);
				$result_user_count=$this->user->find('count',array('conditions'=>$conditions));
				
				$this->loadmodel('user_info_csv_converted'); 
				$conditions=array("mobile"=>$mobile);
				$result_user_info_csv_converted_count=$this->user_info_csv_converted->find('count',array('conditions'=>$conditions));
				
				if($result_user_count>1 or $result_user_info_csv_converted_count>1){
					 $mobileErr = 0;
				}
			}
		 }
		 
			
		$this->loadmodel('user_info_csv_converted');
		$auto_id=$this->autoincrement('user_info_csv_converted','auto_id');
		$this->user_info_csv_converted->saveAll(Array(Array("auto_id" => $auto_id,"user_id" => $user_id, "email" => $email, "mobile" => $mobile,"emailErr" => $emailErr,"mobileErr" => $mobileErr,"user_id"=>$user_id,"society_id"=>$s_society_id,"is_imported"=>"NO")));
		
		$this->loadmodel('user_info_csv');
		$this->user_info_csv->updateAll(array("is_converted" => "YES"),array("auto_id" => $user_info_csv_id));
	}
	
	$this->loadmodel('user_info_csv');
	$conditions=array("society_id" => $s_society_id,"is_converted" => "YES");
	$total_converted_records = $this->user_info_csv->find('count',array('conditions'=>$conditions));
	
	$this->loadmodel('user_info_csv');
	$conditions=array("society_id" => $s_society_id);
	$total_records = $this->user_info_csv->find('count',array('conditions'=>$conditions));
	
	$converted_per=($total_converted_records*100)/$total_records;
	if($converted_per==100){ $again_call_ajax="NO"; 
		$this->loadmodel('user_info_import_record');
		$this->user_info_import_record->updateAll(array("step3" => 1),array("society_id" => $s_society_id));
	}else{
		$again_call_ajax="YES"; 
		}
		
	die(json_encode(array("again_call_ajax"=>$again_call_ajax,"converted_per"=>$converted_per)));
}

function check_user_info_before_submit(){
	$this->layout=null;
	$s_society_id = $this->Session->read('society_id');
	
	$this->loadmodel('user_info_csv_converted');
	$conditions =array( '$or' => array( 
	array('emailErr' =>0,'mobileErr' =>0),
	array('emailErr' =>1,'mobileErr' =>0),
	array('emailErr' =>0,'mobileErr' =>1)
	));
	$result_count = $this->user_info_csv_converted->find('count',array('conditions'=>$conditions));
	if($result_count==0){ 
		$this->loadmodel('user_info_import_record');
		$this->user_info_import_record->updateAll(array("step4" => 1),array("society_id" => $s_society_id));
		
		die(json_encode(true)); 
	}
}

function modify_user_info_csv_data($page=null){
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	$this->ath();
	$s_society_id = $this->Session->read('society_id');
	$page=(int)$page;
	$this->set('page',$page);
	
	$this->loadmodel('user_info_import_record');
	$conditions=array("society_id" => $s_society_id);
	$result_import_record = $this->user_info_import_record->find('all',array('conditions'=>$conditions));
	$this->set('result_import_record',$result_import_record);
	foreach($result_import_record as $data_import){
		$step1=(int)@$data_import["user_info_import_record"]["step1"];
		$step2=(int)@$data_import["user_info_import_record"]["step2"];
		$step3=(int)@$data_import["user_info_import_record"]["step3"];
	}
	$process_status= @$step1+@$step2+@$step3;
	if($process_status==3){
		$this->loadmodel('user_info_csv_converted'); 
		$conditions=array("society_id"=>(int)$s_society_id);
		$result_user_info_csv_converted=$this->user_info_csv_converted->find('all',array('conditions'=>$conditions,"limit"=>10,"page"=>$page));
		$this->set('result_user_info_csv_converted',$result_user_info_csv_converted);
		
		$this->loadmodel('user_info_csv_converted'); 
		$conditions=array("society_id"=>(int)$s_society_id);
		$count_user_info_csv_converted=$this->user_info_csv_converted->find('count',array('conditions'=>$conditions));
		$this->set('count_user_info_csv_converted',$count_user_info_csv_converted);
	}
	
			
}

function check_user_info_csv_validation($id=null,$field=null,$val=null){
	$this->layout=null;
	
	
		
	if($field=="email"){
		$emailErr = 1;
		$email=$val;
		
		$this->loadmodel('user_info_csv_converted');
		$this->user_info_csv_converted->updateAll(array("email" => $email),array("auto_id" => (int)$id));
		
		 if(!empty($email)){
			 if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			   $emailErr = 0;
			 }else{
				$this->loadmodel('user'); 
				$conditions=array("email"=>$email);
				$result_user_count=$this->user->find('count',array('conditions'=>$conditions));
				
				
				
				$this->loadmodel('user_info_csv_converted'); 
				$conditions=array("email"=>$email);
				$result_user_info_csv_converted_count=$this->user_info_csv_converted->find('count',array('conditions'=>$conditions));
				
				if($result_user_count>1 or $result_user_info_csv_converted_count>1){
					 $emailErr = 0;
				}
			 }
		 }
		 
		$this->loadmodel('user_info_csv_converted');
		$this->user_info_csv_converted->updateAll(array("emailErr" => $emailErr),array("auto_id" => (int)$id));
		
		if($emailErr==0){ die(json_encode(false)); }else{ die(json_encode(true)); }
	}
	
	if($field=="mobile"){
		$mobileErr = 1;
		$mobile=$val;
		
		$this->loadmodel('user_info_csv_converted');
		$this->user_info_csv_converted->updateAll(array("mobile" => $mobile),array("auto_id" => (int)$id));
		
		 if(!empty($mobile)){
			 $mob="/([0-9]{10})/"; 
			 if(!preg_match($mob, $mobile) ) {
				 $mobileErr = 0;
			}else{
				$this->loadmodel('user'); 
				$conditions=array("mobile"=>$mobile);
				$result_user_count=$this->user->find('count',array('conditions'=>$conditions));
				
				$this->loadmodel('user_info_csv_converted'); 
				$conditions=array("mobile"=>$mobile);
				$result_user_info_csv_converted_count=$this->user_info_csv_converted->find('count',array('conditions'=>$conditions));
				
				if($result_user_count>1 or $result_user_info_csv_converted_count>1){
					 $mobileErr = 0;
				}
			}
		 }
		 
		$this->loadmodel('user_info_csv_converted');
		$this->user_info_csv_converted->updateAll(array("mobileErr" => $mobileErr),array("auto_id" => (int)$id));
		
		if($mobileErr==0){ die(json_encode(false)); }else{ die(json_encode(true));}
	}

}

function final_import_user_info_ajax(){
	$this->layout=null;
	$s_society_id = $this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	
	$this->loadmodel('user_info_import_record');
	$conditions=array("society_id" => $s_society_id);
	$result_import_record = $this->user_info_import_record->find('all',array('conditions'=>$conditions));
	$this->set('result_import_record',$result_import_record);
	foreach($result_import_record as $data_import){
		$step1=(int)@$data_import["user_info_import_record"]["step1"];
		$step2=(int)@$data_import["user_info_import_record"]["step2"];
		$step3=(int)@$data_import["user_info_import_record"]["step3"];
		$step4=(int)@$data_import["user_info_import_record"]["step4"];
	}
	$process_status= @$step1+@$step2+@$step3+@$step4;
	if($process_status==4){
		
		$this->loadmodel('user_info_csv_converted');
		$conditions=array("society_id" => $s_society_id,"is_imported" => "NO");
		$result_import_converted = $this->user_info_csv_converted->find('all',array('conditions'=>$conditions,'limit'=>2));
		
		foreach($result_import_converted as $data){
			
			$auto_id=$data["user_info_csv_converted"]["auto_id"];
			$user_id=$data["user_info_csv_converted"]["user_id"];
			$email=$data["user_info_csv_converted"]["email"];
			$mobile=$data["user_info_csv_converted"]["mobile"];
			
			$this->loadmodel('user');
			$conditions=array("user_id" => $user_id);
			$result_user = $this->user->find('all',array('conditions'=>$conditions));
			foreach($result_user as $data2){
				$al_email=$data2["user"]["email"];
				$al_mobile=$data2["user"]["mobile"];
			}
			
			if($email!=$al_email){
				
				$this->loadmodel('user');
				$this->user->updateAll(array("email" => $email),array("user_id" => (int)$user_id));
			}
			if($mobile!=$al_mobile){
				$this->loadmodel('user');
				$this->user->updateAll(array("mobile" => $mobile),array("user_id" => (int)$user_id));
			}
			
			if(empty($al_email) && empty($al_mobile)){
				$this->loadmodel('login');
				$login_id=$this->autoincrement('login','login_id');
				$this->login->saveAll(array('login_id' => $login_id, 'user_name' => $email, 'mobile' => $mobile, 'signup_random' => ""));
				
				$this->loadmodel('user');
				$this->user->updateAll(array("login_id" => $login_id),array("user_id" => (int)$user_id));
			}
			
			$this->loadmodel('user_info_csv_converted');
			$this->user_info_csv_converted->updateAll(array("is_imported" => "YES"),array("auto_id" => (int)$auto_id));
			
		}
		
		
		
		$this->loadmodel('user_info_csv_converted');
		$conditions=array("society_id" => $s_society_id,"is_imported" => "YES");
		$total_converted_records = $this->user_info_csv_converted->find('count',array('conditions'=>$conditions));
		
		$this->loadmodel('user_info_csv_converted');
		$conditions=array("society_id" => $s_society_id);
		$total_records = $this->user_info_csv_converted->find('count',array('conditions'=>$conditions));
		
		$converted_per=($total_converted_records*100)/$total_records;
		
		
		if($converted_per==100){ $again_call_ajax="NO"; 
			
			$this->loadmodel('user_info_csv_converted');
			$conditions4=array('society_id'=>$s_society_id);
			$this->user_info_csv_converted->deleteAll($conditions4);
			
			$this->loadmodel('user_info_csv_converted');
			$conditions4=array('society_id'=>$s_society_id);
			$this->user_info_csv_converted->deleteAll($conditions4);
			
			$this->loadmodel('user_info_import_record');
			$conditions4=array("society_id" => $s_society_id);
			$this->user_info_import_record->deleteAll($conditions4);
		}else{
			$again_call_ajax="YES"; 
			}
		die(json_encode(array("again_call_ajax"=>$again_call_ajax,"converted_per_im"=>$converted_per)));
	}
}

function email_mobile_import_file(){
	$this->layout="";
	$filename="email_mobile_import_file";
	header ("Expires: 0");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/vnd.ms-excel");
	header ("Content-Disposition: attachment; filename=".$filename.".csv");
	header ("Content-Description: Generated Report" );

	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id = (int)$this->Session->read('user_id');
	
	$output= "Name,wing,unit,owner/tenant,email,mobile \n";
	
	
	$this->loadmodel('user');
	$conditions=array("society_id" => $s_society_id,"deactive"=>0);
	$order=array('user.user_name'=>'ASC');
	$result_users=$this->user->find('all',array('conditions'=>$conditions,'order'=>$order));
	
	foreach($result_users as $user_info){
		$user_name=$user_info["user"]["user_name"];
		$wing=$user_info["user"]["wing"];
		$flat=$user_info["user"]["flat"];
		$email=$user_info["user"]["email"];
		$mobile=$user_info["user"]["mobile"];
		$tenant=$user_info["user"]["tenant"];
		if($tenant==1){
			$ownership="owner";
		}else{
			$ownership="tenant";
		}
		
		$wing_name=$this->fetch_wingname_via_wingid($wing);
		$flat_name=$this->fetch_flatname_via_flatid($flat);
		
		$output.= $user_name.",".$wing_name.",".$flat_name.",".$ownership.",".$email.",".$mobile." \n";
	}
	echo $output;
}
		


function import_email_mobile_update(){
	
$this->layout=null;	
$s_society_id=$this->Session->read('society_id');	
$this->loadmodel('user');
	$conditions=array("society_id" => $s_society_id);
	$result_user = $this->user->find('all',array('conditions'=>$conditions));
	$this->set('result_user',$result_user);

	if(isset($_FILES['file1'])){
	
	   $file_name=$_FILES['file1']['name']; 
		$file_tmp_name =$_FILES['file1']['tmp_name'];
		$target = "csv_file/";
		$target=@$target.basename($file_name);
		move_uploaded_file($file_tmp_name,@$target);
		
		$f = fopen('csv_file/'.$file_name, 'r') or die("ERROR OPENING DATA");
		$batchcount=0;
		$records=0;
		while (($line = fgetcsv($f, 4096, ';')) !== false) {
		// skip first record and empty ones
		$numcols = count($line);

		$test[]=$line;

		//echo $col = $line[0];
		//echo $batchcount++.". ".$col."\n";


		++$records;
		}

		fclose($f);
		$records;
	}
	
	$i=0;
	
	foreach($test as $child){
		if($i>0){
			$child_ex=explode(',',$child[0]);
			 $name=trim($child_ex[0]);
			 $email=trim($child_ex[1]);
			 $mobile=trim($child_ex[2]);
			
			$this->loadmodel('user'); 
			$conditions=array("society_id"=>$s_society_id,"user_name"=> new MongoRegex('/^' .  $name . '$/i'));
			$result_user=$this->user->find('all',array('conditions'=>$conditions));
		
			$result_user_count=sizeof($result_user);
			if($result_user_count>0){
					 $user_id=@$result_user[0]['user']['user_id'];	
				}
			$table[]=array(@$user_id,$email,$mobile);
		}
			$i++;
	}
	
	$this->set('table',$table);
	
}

////// End 


////// End 


function griter_notification($id)
{	

//////////////// Destroy Session_code start ///////////////////////

////////////////// Start bill update /////////////////////////

	if($id=="bill_update")
	{
		$this->Session->delete('bill_update_status');
	}
	
//////////////////// end ///////////////////////////

////////////////// Start document /////////////////////////

	if($id==4)
	{
		$this->Session->delete('document_status');
		$this->Session->delete('document_status1');
	}
	
//////////////////// end ///////////////////////////

////////////////// Start Profile /////////////////////////

	if($id==101)
	{
		$this->Session->delete('profile_status');
	}
	
//////////////////// end ///////////////////////////

////////////////// Start Invitation /////////////////////////
	
	if($id==17)
	{
		$this->Session->delete('invite_status');
	}

//////////////////// end ///////////////////////////

////////////////// Start Poll /////////////////////////	

	if($id==7)
	{
		$this->Session->delete('poll_status');
		$this->Session->delete('poll_status1');
	}
	
//////////////////// end ///////////////////////////	


////////////////// Start Poll /////////////////////////	

	if($id==1)
	{
		$this->Session->delete('help_desk_status');
		$this->Session->delete('help_desk_draft_status');
		
	}
	
//////////////////// end ///////////////////////////


///////////////// Start discussion forum /////////////////

if($id==3)
	{
		$this->Session->delete('discussion_forum_status');
		$this->Session->delete('discussion_forum_status1');
		
	}
	



/////////////////////  End ///////////////////////////////


///////////////// Start Feedback /////////////////

if($id==102)
	{
		$this->Session->delete('feedback_status');
		
		
	}

/////////////////////  End ///////////////////////////////
//bill update//
if($id==1111){
	$this->Session->delete('bill_updated');
}
if($id==11){
	$this->Session->delete('bank_rrr');
}

if($id==111){
	$this->Session->delete('bank_rrr2');
}
if($id==1101){
 $this->Session->delete('bank_ppp');
}

if($id==1102){
 $this->Session->delete('bank_ppp2');
}


if($id==1301){
 $this->Session->delete('petty_cc_rr');
}

if($id==1401){
 $this->Session->delete('petty_cc_pp');
}

if($id==1501){
 $this->Session->delete('fix_ddd');
}

if($id==1601){
 $this->Session->delete('journll');
}

if($id==1701){
 $this->Session->delete('exp_ttt');
}

if($id==1801){
 $this->Session->delete('fix_assset');
}
if($id==1901){
 $this->Session->delete('incttt');
}
if($id==2101){
 $this->Session->delete('suppll');
}

if($id==3101){
 $this->Session->delete('ledd_accc');
}
if($id==3102){
 $this->Session->delete('ledgrr_sub_accc');
}
if($id==3103){
 $this->Session->delete('remindrrr');
}

if($id==3104){
 $this->Session->delete('ffyyyy');
}
if($id==5511){
 $this->Session->delete('bank_eddd');
}
if($id==5512){
 $this->Session->delete('new_bank_rrr');
}
if($id==5513){
 $this->Session->delete('opnn_bll');
}

if($id==5514){
 $this->Session->delete('fix_asst');
}

/////////////////////// End session_code //////////////////
	
}

function visible_subvisible($visible,$sub_visible) {
$s_user_id=$this->Session->read('user_id');
if($visible==1){	
$result_user=$this->all_user_deactive();

foreach($result_user as $data){
$da_to[$data['user']['user_id']]=$data['user']['email'];
$da_user_name[]=$data['user']['user_name'];
$da_user_id[]=$data['user']['user_id'];
}

}
if($visible==4){	
$result_user=$this->all_owner_deactive();
foreach($result_user as $data){
$da_to[$data['user']['user_id']]=$data['user']['email'];
$da_user_name[]=$data['user']['user_name'];
$da_user_id[]=$data['user']['user_id'];
}
}
	if($visible==5){
		$result_user=$this->all_tenant_deactive();
		foreach($result_user as $data){
			$da_to[$data['user']['user_id']]=$data['user']['email'];
			$da_user_name[]=$data['user']['user_name'];
			$da_user_id[]=$data['user']['user_id'];
		}
	}
	if($visible==2){	
		foreach ($sub_visible as $role_id){
			$role_id=(int)$role_id;
			$result_user=$this->all_role_wise_deactive($role_id);
			foreach($result_user as $data){
				$da_to[$data['user']['user_id']]=$data['user']['email'];
				$da_user_name[]=$data['user']['user_name'];
				$da_user_id[]=$data['user']['user_id'];
			}
		}
	}
	if($visible==3){	
		foreach ($sub_visible as $wing_id){
			$wing_id=(int)$wing_id;
			$result_user=$this->all_wing_wise_deactive($wing_id);
			foreach($result_user as $data){
				$da_to[$data['user']['user_id']]=$data['user']['email'];
				$da_user_name[]=$data['user']['user_name'];
				$da_user_id[]=$data['user']['user_id'];
			}
		}
	}

	///////// creator send email code //////////////////
	$result_user=$this->profile_picture($s_user_id);
	foreach($result_user as $data){
			 $da_to[]=$data['user']['email'];
			 $da_user_name[]=$data['user']['user_name'];
			 $da_user_id[]=$data['user']['user_id'];
		}
	////////////end code ///////////////////////////////
	$da_to=array_unique(array_filter($da_to));
	$da_user_name=array_unique(array_filter($da_user_name));
	$da_user_id=array_unique(array_filter($da_user_id));
	
	
	if($visible==1){ $send='All Users'; }
	if($visible==2){ $send='Roll Wise'; }
	if($visible==3){ $send='Wing Wise'; }
	if($visible==4){ $send='All Owners'; }
	if($visible==5){ $send='All Tenants'; }
		
		
	return $send_info=array($da_to,$da_user_name,$da_user_id,$send);
}


function encode($string,$key) {
$key = sha1($key);
$strLen = strlen($string);
$keyLen = strlen($key);
for ($i = 0; $i < $strLen; $i++) {
$ordStr = ord(substr($string,$i,1));
if (@$j == $keyLen) { $j = 0; }
$ordKey = ord(substr($key,@$j,1));
@$j++;
@$hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
}
return @$hash;
}

function decode($string,$key) {
$key = sha1($key);
$strLen = strlen($string);
$keyLen = strlen($key);
for ($i = 0; $i < $strLen; $i+=2) {
$ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
if (@$j == $keyLen) { @$j = 0; }
$ordKey = ord(substr($key,@$j,1));
@$j++;
@$hash .= chr($ordStr - $ordKey);
}
return @$hash;
}


function webroot_path() {
	$this->loadmodel('user');
	$conditions=array("email" => "housingmatters.in@gmail.com");
	$resultwebroot_path=$this->user->find('all',array('conditions'=>$conditions));
	return @$resultwebroot_path[0]['user']['webroot_path'];
}







function cronjob()
{

	 $this->layout=null;
	$this->loadmodel('email_requests');
	$conditions=array('flag'=>0);
	$result1_email=$this->email_requests->find('all',array('conditions'=>$conditions,'limit'=>2));
	foreach($result1_email as $data)
	{
		$e_id=$data['email_requests']['e_id'];
		$to=$data['email_requests']['to'];
		$from=$data['email_requests']['from'];
		$from_name=$data['email_requests']['from_name'];
		$subject=$data['email_requests']['subject'];
		$message_web=$data['email_requests']['message_web'];
		$reply=$data['email_requests']['reply'];
		
		$mail_result=$this->smtpmailer($to,$from,$from_name,$subject,$message_web,$reply);
		
		if($mail_result = true){
			$this->loadmodel('email_requests');
			$this->email_requests->updateAll(array('flag'=>1),array('e_id'=>$e_id));
		}
		
	} 
	
}

function content_moderation_society($content_check)
{
	$content_check=explode(' ',$content_check);
	$s_society_id=$this->Session->read('society_id');
	
	$this->loadmodel('society');
	$conditions=array('society_id'=>$s_society_id);
	$result1=$this->society->find('all',array('conditions'=>$conditions));
	foreach($result1 as $data)
	{
		  $content=@$data['society']['content_moderation'];

	}
	if(!empty($content)){
		 $content=array_map('trim',$content);
	
	   
		foreach($content_check as $c_moda)
		{	
		
				if(in_array($c_moda,$content))
				{
					
				 return 0;
					
				}
	
		}
		}
	
		return 1;
	
}

function content_check_des()
{
	$this->layout='blank';
	$description=$this->request->query['description'];
	$des=explode(' ',$description);
	$r=$this->content_moderation_society($des);
	
	if($r==0)
	{
	echo "false";
	}
	else
	{
	echo "true";
	}
	
}

function ath()
{
$user_id=$this->Session->read('user_id');
if(empty($user_id))
{
$this->Session->destroy();
 $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$actual_link = urlencode($actual_link); 
$this->response->header('Location', $this->webroot.'hms/index?next='.$actual_link);
}
date_default_timezone_set('Asia/Kolkata');	
$this->set('webroot_path',$this->webroot_path());

}

function send_email($to,$from,$from_name,$subject,$message_web,$reply)
{
//$this->layout='session';
$this->loadmodel('email_request');
$er=$this->autoincrement('email_request','e_id');
$this->email_request->saveAll(array('e_id' => $er, 'to' => $to, 'from' => $from, 'from_name' => $from_name, 'subject' => $subject,'message_web' => $message_web, 'reply' => $reply, 'flag' => 0));
}
function logout() 
{
$this->layout='blank';
$this->Session->destroy();
$this->redirect(array('action' => 'index'));
}

function beforeFilter()
{
 //Configure::write('debug', 0);
}


function menus_from_role_privileges()
{
$this->layout='blank';
$s_society_id=$this->Session->read('society_id');
$this->set('s_society_id',$s_society_id);
$s_role_id=$this->Session->read('role_id');
$this->set('s_role_id',$s_role_id);

$this->loadmodel('role_privileges');
$conditions=array("society_id" => $s_society_id,"role_id" => $s_role_id);
$this->set('result',$this->role_privileges->find('all',array('conditions'=>$conditions)));
return $this->role_privileges->find('all',array('conditions'=>$conditions));
}


function fetch_submoduleid_usermanagement($module_id) 
{
$s_society_id=$this->Session->read('society_id');
$s_role_id=$this->Session->read('role_id');

$this->loadmodel('role_privilege');
$conditions=array("module_id" => $module_id,"society_id" => $s_society_id,"role_id" => $s_role_id);
$order=array('role_privilege.sub_module_id'=> 'ASC');
return $result=$this->role_privilege->find('all',array('conditions'=>$conditions,'order'=>$order,'limit'=>1));
}

function count_receipt_against_bill($regular_bill_one_time_id,$flat_id) 
{
$s_society_id=$this->Session->read('society_id');
$s_role_id=$this->Session->read('role_id');


$this->loadmodel('new_cash_bank');
$conditions=array("bill_one_time_id" => $regular_bill_one_time_id,"flat_id" => $flat_id,"society_id" => $s_society_id);
return $this->new_cash_bank->find('count',array('conditions'=>$conditions));

}

function fetch_module_type_id($module_id) 
{
$this->loadmodel('main_module');
$conditions=array("auto_id" => $module_id);
$result_moduletype_id=$this->main_module->find('all',array('conditions'=>$conditions));
foreach ($result_moduletype_id as $ddq) 
{
return $mt_id=$ddq["main_module"]["mt_id"];
}
}

function fetch_module_type_name($result_moduletype_id) 
{
$this->loadmodel('module_type');
$conditions=array("module_type_id" => $result_moduletype_id);
return $this->module_type->find('all',array('conditions'=>$conditions));

}

function new_cash_bank_detail_via_transaction_id($value)
{
$s_society_id=$this->Session->read('society_id');

$this->loadmodel('new_cash_bank');
$conditions=array("society_id"=>$s_society_id,"transaction_id"=>$value);
return $this->new_cash_bank->find('all',array('conditions'=>$conditions));
}


function fetch_module_name($module_type)
{

	$this->loadmodel('main_module');
	$order=array('main_module.module_name'=>'ASC');
	$conditions=array("mt_id" => $module_type);
	return $result_moduletype_id=$this->main_module->find('all',array('conditions'=>$conditions,'order'=>$order));

	
}

function fetch_pagename_usermanagement($sub_module_id) 
{
$s_society_id=$this->Session->read('society_id');
$s_role_id=$this->Session->read('role_id');

$this->loadmodel('page');
$conditions=array("sub_module_id" => $sub_module_id);
return $result=$this->page->find('all',array('conditions'=>$conditions,'limit'=>1));
}

function fetch_pagename_main_module_usermanagement($module_id,$sub_module_id) 
{
$s_society_id=$this->Session->read('society_id');
$s_role_id=$this->Session->read('role_id');

$this->loadmodel('page');
$conditions=array("module_id" => $module_id,"sub_module_id" => $sub_module_id);
return $result=$this->page->find('all',array('conditions'=>$conditions,'limit'=>1));
}

function fetch_sub_module_id_from_role_prvg($module_id){
	$s_society_id=$this->Session->read('society_id');
	$s_role_id=$this->Session->read('role_id');

	$this->loadmodel('role_privilege');
	$conditions=array("module_id" => $module_id,"society_id"=>$s_society_id,"role_id" => $s_role_id);
	return $result=$this->role_privilege->find('all',array('conditions'=>$conditions,'limit'=>1));
}

function fetch_mainmodulename_usermanagement($module_id) 
{
$s_society_id=$this->Session->read('society_id');
$s_role_id=$this->Session->read('role_id');

$this->loadmodel('main_module');
$conditions=array("auto_id" => $module_id);
return $result=$this->main_module->find('all',array('conditions'=>$conditions));
}

function fetch_rolename_via_roleid($s_role_id) 
{
$s_society_id=$this->Session->read('society_id');
$this->loadmodel('role');
$conditions=array("society_id"=>$s_society_id,"role_id"=>$s_role_id);
$result=$this->role->find('all',array('conditions'=>$conditions));
foreach ($result as $dd) 
{
return $role_name=$dd["role"]["role_name"];
}
}

function fetch_wingname_via_wingid($wing_id) 
{
$s_society_id=$this->Session->read('society_id');

$this->loadmodel('wing');
$conditions=array("society_id"=>$s_society_id,"wing_id"=>$wing_id);
$result=$this->wing->find('all',array('conditions'=>$conditions));
foreach ($result as $dd) 
{
return $wing_name=$dd["wing"]["wing_name"];
}
}


function fetch_flatname_via_flatid($flat_id) 
{
$s_society_id=$this->Session->read('society_id');

$this->loadmodel('flat');
$conditions=array("society_id"=>$s_society_id,"flat_id"=>$flat_id);
$result=$this->flat->find('all',array('conditions'=>$conditions));
foreach ($result as $dd) 
{
return $flat_name=$dd["flat"]["flat_name"];
}
}

function fetch_users_role() 
{
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('user');
$conditions=array("user_id"=>$s_user_id);
$result=$this->user->find('all',array('conditions'=>$conditions));
foreach($result as $data)
{
return @$data['user']['role_id'];	 

}	
}

function fetch_all_flat_via_wing_id($wing){
	$this->loadmodel('flat');
	$conditions=array("wing_id" => $wing);
	$order=array('flat.flat_name'=> 'ASC');
	return $this->flat->find('all',array('conditions'=>$conditions,'order' =>$order));
} 


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
$close_date=date("d-m-y");
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
<p style='font-size:16px;'> <strong>Closure Comments:</strong></p>
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
@$subject.= ''. $society_name . '' . ' Closure of Helpdesk Ticket #'. '' .$ticket_id.'';
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$subject="";
}
$close_date;
$massage_close;
$this->loadmodel('help_desk');
$this->help_desk->updateAll(array("help_desk_close_comment" => $massage_close,"help_desk_close_date"=>$close_date,"help_desk_status" => 1),array("help_desk_id" => $hd_id));
$this->response->header('Location:help_desk_sm_close_ticket');

}
//////////////////////////////////////////////close ticket///////////////////////////////////////////////////
}

function assign_ticket()
{
$this->layout='blank';
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
	$ip=$this->hms_email_ip();
	
$hd_id=(int)$this->request->data['hd_id'];
$close_date=date("d-m-y");
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
<p style='font-size:16px;'> <strong>Closure Comments:</strong></p>
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
@$subject.= ''. $society_name . '' . ' Closure of Helpdesk Ticket #'. '' .$ticket_id.'';
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




function help_desk_r_view()
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();
$hd_id=(int)$this->request->query('id');
$this->set('hd_id',$hd_id);
$status=(int)$this->request->query('status');
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
$conditions=array("help_desk_category_id" => 5);
$cursor=$this->help_desk_category->find('all',array('conditions'=>$conditions));
foreach ($cursor as $collection2) 
{
$this->set('help_desk_category_name',$collection2['help_desk_category']['help_desk_category_name']);
}

$this->loadmodel('help_desk_reply');
$conditions=array("help_desk_id" => $hd_id);
$this->set('result_reply',$this->help_desk_reply->find('all',array('conditions'=>$conditions)));

}


function help_desk_sm_view()
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();

$hd_id=(int)$this->request->query('id');
$this->set('hd_id',$hd_id);
$status=(int)$this->request->query('status');
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
$close_date=date("d-m-y");
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
@$subject.= ''. $society_name . '' . ' Closure of Helpdesk Ticket #'. '' .$ticket_id.'';
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$subject="";
}
$close_date;
$massage_close;
$this->loadmodel('help_desk');
$this->help_desk->updateAll(array("help_desk_close_comment" => $massage_close,"help_desk_close_date"=>$close_date,"help_desk_status" => 1),array("help_desk_id" => $hd_id));

$da_user_id[]=$d_user_id;
$this->send_notification('<span class="label" style="background-color:#4cae4c;"><i class="icon-ok"></i></span>','Your help-desk ticket#<b>'.$ticket_id.'</b> closed by ',1,$hd_id,'help_desk_r_view?id='.$hd_id.'&status=1',$s_user_id,$da_user_id);


$this->response->header('Location:help_desk_sm_close_ticket');
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

$result_sp2=$this->fetch_service_provider_info_via_vendor_id($vendor_id);
foreach ($result_sp2 as $collection3)
{
$this->set('sp_name',$collection3['service_provider']['sp_name']);
}
}


function help_desk_reports()
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
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


function save_reply_resident()
{
$this->layout='blank';
$reply=htmlentities($this->request->query('reply'));
$reply=nl2br($reply);
$rep=explode(' ',$reply);

$r=$this->content_moderation_society($rep);



	
	
$hd_id=(int)$this->request->query('id');

$s_user_id=$this->Session->read('user_id');

$date=date("d-m-y");
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
$this->layout='session';
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
@$file_upload=$this->request['form']['file']['name'];
$text=htmlentities($this->request->data['name']);	
$name=wordwrap($text, 25, " ", true);
$text1=htmlentities($this->request->data['person']);
$person = wordwrap($text1, 25, " ", true);
$mobile=$this->request->data['mobile'];
$email=$this->request->data['email'];
@$cont_start=$this->request->data['cont_start'];
@$cont_end=$this->request->data['cont_end'];

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
$this->service_provider->saveAll(array("sp_id" => $i, "sp_attachment" => $file_upload , "sp_name" => $name,"sp_date"=>$date,"user_id"=>$s_user_id,"society_id"=>$s_society_id,"sp_time"=>$time,"sp_delete"=>0,"sp_cont_start"=>$cont_start,"sp_cont_end"=>$cont_end,"sp_person"=>$person,"sp_email"=>$email,"sp_mobile"=>$mobile,"sp_contract_type"=>$contract_type));

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
$this->layout='session';
$this->ath();
$this->check_user_privilages();

$s_society_id=$this->Session->read('society_id');
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
$this->response->header('Location', 'service_provider_view');
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
$subject=$society_name;
$text=htmlentities($this->request->query('con2'));
$message_web = wordwrap($text, 25, " ", true);
$to=$this->request->query('con3');
$this->loadmodel('user');
$conditions=array("user_id"=>$s_user_id);
$result=$this->user->find('all',array('conditions'=>$conditions));
foreach ($result as $collection) 
{ 

$email=$collection['user']["email"];
}


$from_name="HousingMatters";
$from="support@housingmatters.in";
$reply=$email;
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);

}

function service_provider_edit()
{
$this->layout='session';
$id=(int)$this->request->query('con');
$this->loadmodel('service_provider');
$conditions=array("sp_id"=> $id);
$res= $this->service_provider->find('all',array('conditions'=>$conditions));
foreach ($res as $collection) 
{
$attachment=$collection['service_provider']['sp_attachment'];
$Contract_start=$collection['service_provider']['sp_cont_start'];
$Contract_end=$collection['service_provider']['sp_cont_end'];
}
$this->set('result_sp',$this->service_provider->find('all',array('conditions'=>$conditions))); 
if($this->request->is('post'))
{
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
$this->loadmodel('service_provider');
$this->service_provider->updateAll(array("sp_name" => $name,"sp_mobile"=>$mobile,'sp_person'=> $person,"sp_email"=>$email,"sp_attachment"=>$file_upload,'sp_cont_start'=>$cont_start,'sp_cont_end'=> $cont_end,'sp_contract_type'=> $Contract_type),array("sp_id" => $id));
$this->response->header('location:service_provider_view');			

}

}
///////////////////////////////////////////////// Service Provider End ///////////////////////////////...............................////////////////////////
/////////////////////////////////////////////////////End Help Desk /////////////////////////




/////////////////// Help desk some function //////////////

function help_desk_category_name($complain_type_id)
{

$this->loadmodel('help_desk_category');
$conditions=array("help_desk_category_id" => $complain_type_id);
$result_category=$this->help_desk_category->find('all',array('conditions'=>$conditions));

foreach ($result_category as $collection) 
{
return $help_desk_category_name=$collection['help_desk_category']['help_desk_category_name'];
}
}
function regular_bill_check_due_date($d_user_id)
{
$date=date('d-m-Y');
$current_date_for = new MongoDate(strtotime(date("Y-m-d", strtotime($date))));
$this->loadmodel('regular_bill');
$conditions=array('bill_for_user'=>$d_user_id,'status'=>0,'remaining_amount'=>array('$gte'=>0),'due_date'=>array('$lte'=>$current_date_for));	
return $result_bill=$this->regular_bill->find('all',array('conditions'=>$conditions));	
}


function fetch_service_provider_info_via_vendor_id($vendor_id)
{
$s_society_id=$this->Session->read('society_id');
$this->loadmodel('service_provider');
$conditions=array("sp_id" => $vendor_id,"society_id" => $s_society_id);
return $this->service_provider->find('all',array('conditions'=>$conditions));
}

////////////////////// end help desk function /////////////////////////////////////////

//////////////////////////////// Parking Managment System start /////////////////////


function sm_parking_slot()
{
	$this->layout='session';
	$s_society_id=$this->Session->read('society_id'); 
	$this->ath();
	$this->check_user_privilages();
	
	
	/*
	
	$this->loadmodel('parking');
	$conditions=array('society_id'=>$s_society_id,'type'=>2);
	$result=$this->parking->find('all',array('conditions'=>$conditions));
	$c=sizeof($result);
	foreach($result as $data)
	{
		$first=$data['parking']['slot_no'];
		 break;
	}
	@$r=explode('-',$first);
	@$r1=$r[1];
	$this->set('num2',$c);
	$this->set('start2',$r1);
	$this->loadmodel('parking');
	$conditions1=array('society_id'=>$s_society_id,'type'=>4);
	$result1=$this->parking->find('all',array('conditions'=>$conditions1));
	$c1=sizeof($result1);
	foreach($result1 as $data)
	{
		 $first1=$data['parking']['slot_no'];
		break;
	}
	@$r3= explode('-',$first1);
	@$r4=$r3[1];
	$this->set('num4',$c1);
	$this->set('start4',$r4);
	
	*/
	
	if($this->request->is('post'))
	{
		$this->loadmodel('parking');
		//$conditions4=array('society_id'=>$s_society_id);
		//$this->parking->deleteAll($conditions4);
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
			 $this->parking->saveAll(array('parking_id'=>$j,'slot_no'=>$to_flot,'type'=>2,'society_id'=>$s_society_id,'status'=>0));
		}
		
		for($k=$four_start;$k<$four_r; $k++)
		{
			$j=$this->autoincrement('parking','parking_id');
			 $fo_flot= '4-'.$k ;
			 $this->loadmodel('parking');
			 $this->parking->saveAll(array('parking_id'=>$j,'slot_no'=>$fo_flot,'type'=>4,'society_id'=>$s_society_id,'status'=>0));
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








function sm_parking_slot123()
{
	$this->layout='session';
	$s_society_id=$this->Session->read('society_id'); 
	
	
	$this->loadmodel('parking');
	$conditions=array('society_id'=>$s_society_id,'type'=>2);
	$result=$this->parking->find('all',array('conditions'=>$conditions));
	$c=sizeof($result);
	foreach($result as $data)
	{
		$first=$data['parking']['slot_no'];
		 break;
	}
	@$r=explode('-',$first);
	@$r1=$r[1];
	$this->set('num2',$c);
	$this->set('start2',$r1);
	$this->loadmodel('parking');
	$conditions1=array('society_id'=>$s_society_id,'type'=>4);
	$result1=$this->parking->find('all',array('conditions'=>$conditions1));
	$c1=sizeof($result1);
	foreach($result1 as $data)
	{
		 $first1=$data['parking']['slot_no'];
		break;
	}
	@$r3= explode('-',$first1);
	@$r4=$r3[1];
	$this->set('num4',$c1);
	$this->set('start4',$r4);
	
	
	
	if($this->request->is('post'))
	{
		$this->loadmodel('parking');
		$conditions4=array('society_id'=>$s_society_id);
		$this->parking->deleteAll($conditions4);
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
			 $this->parking->saveAll(array('parking_id'=>$j,'slot_no'=>$to_flot,'type'=>2,'society_id'=>$s_society_id,'status'=>0));
		}
		
		for($k=$four_start;$k<$four_r; $k++)
		{
			$j=$this->autoincrement('parking','parking_id');
			 $fo_flot= '4-'.$k ;
			 $this->loadmodel('parking');
			 $this->parking->saveAll(array('parking_id'=>$j,'slot_no'=>$fo_flot,'type'=>4,'society_id'=>$s_society_id,'status'=>0));
		}
		 $this->response->header('location','sm_parking_slot');
		
		
		
	}
}


function parking_system_view()
{
	$this->layout="session";
	$this->ath();
	$this->check_user_privilages();
	$s_society_id=$this->Session->read('society_id');
	$this->loadmodel('parking');
	$conditions1=array('society_id'=>$s_society_id);
	$result1=$this->parking->find('all',array('conditions'=>$conditions1));
	$this->set('result_parking',$result1);
	$this->loadmodel('parking');
	$conditions2=array('society_id'=>$s_society_id,'type'=>2);
	$result2=$this->parking->find('all',array('conditions'=>$conditions2));
	$n=sizeof($result2);
	$this->set('two_n',$n);
	$this->loadmodel('parking');
	$conditions3=array('society_id'=>$s_society_id,'type'=>4);
	$result3=$this->parking->find('all',array('conditions'=>$conditions3));
	$n2=sizeof($result3);
	$this->set('four_n',$n2);
	
}


function sm_assign_parking_system()
{
	$this->layout="session";
	$this->ath();
	$this->check_user_privilages();
	$s_society_id=$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$this->loadmodel('user');
	$conditions=array('society_id'=>$s_society_id);
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

	$this->layout="session";
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

function change_role() 
{
$this->layout='blank';
$role=(int)$this->request->query('role');
$this->Session->write('role_id', $role);
$this->redirect(array('controller' => 'Hms','action' => 'dashboard'));
}


function change_society() 
{
$this->layout='blank';
$s_login_id=(int)$this->Session->read('login_id');
$society=(int)$this->request->query('society');
$this->loadmodel('user');
$conditions=array('login_id'=>$s_login_id,'society_id'=>$society);
$result_user=$this->user->find('all',array('conditions'=>$conditions));
	foreach($result_user as $data)
	{
	$user_id=$data['user']['user_id'];
	$user_name=$data['user']['user_name'];
	$wing=$data['user']['wing'];
	$tenant=$data['user']['tenant'];
	$role_id=$data['user']['default_role_id'];
	}

$this->Session->write('user_id', $user_id);
$this->Session->write('role_id', $role_id);
$this->Session->write('user_name', $user_name);
$this->Session->write('wing', $wing);
$this->Session->write('tenant', $tenant);
$this->Session->write('society_id', $society);
$this->redirect(array('action' => 'dashboard'));
}


function submenu()
{
	
$this->layout=null;
$s_society_id=$this->Session->read('society_id');
$s_role_id=$this->Session->read('role_id');

$page_namr_url=pathinfo($_SERVER[ 'REQUEST_URI'],PATHINFO_FILENAME);
$url = parse_url($page_namr_url) ;
$page_namr_url=  $url['path'];
$this->loadmodel('page');
$conditions=array("page_name" => $page_namr_url);
$cursor=$this->page->find('all',array('conditions'=>$conditions));
foreach ($cursor as $collection) 
{					
$module_id=$collection["page"]["module_id"];
$sub_module_id=$collection["page"]["sub_module_id"];
}

$this->loadmodel('role_privilege');
$conditions=array("module_id" => @$module_id,"society_id" => $s_society_id,"role_id" => $s_role_id);
$cursor=$this->role_privilege->find('all',array('conditions'=>$conditions));
sort($cursor);
if(sizeof($cursor)>1)
{ 
?>
<div align="center">
<?php
foreach ($cursor as $collection) 
{					
$sub_module_id=$collection["role_privilege"]["sub_module_id"];

$this->loadmodel('page');
$conditions=array("sub_module_id" => $sub_module_id);
$cursor_page=$this->page->find('all',array('conditions'=>$conditions,'limit'=>1));
foreach ($cursor_page as $collection) 
{					
$page_name=$collection["page"]["page_name"];
$controller=$collection['page']['controller'];
}

$this->loadmodel('sub_module');
$conditions=array("auto_id" => $sub_module_id);
$cursor_sub_module=$this->sub_module->find('all',array('conditions'=>$conditions,'limit'=>1));
foreach ($cursor_sub_module as $collection) 
{					
$sub_module_name=$collection["sub_module"]["sub_module_name"];
}
$sub_module_id_fix="fix".$sub_module_id;
echo '<a href='.$this->webroot.@$controller.'/'.$page_name.' id='.$sub_module_id_fix.' class="btn blue allsubmenu" style="margin-left: 2px;margin-bottom: 4px;" rel="tab">'.$sub_module_name.' </a>';
}
?>
</div>
<?php

}
}


function check_housingmatters_privilages()
{
$s_society_id=$this->Session->read('society_id');
if($s_society_id!=0)
{
$this->layout='resricted';
?>
<div style="min-height: 85%;margin-top: 60px; " align="center">
<h2>Sorry<br/>You are not allowed to access this page.</h2>
<img src="<?php echo $this->webroot ; ?>/as/hm/hm-logo.png" alt="logo" >
<br/><h4>Back to <a href="<?php echo $webroot_path; ?>Hms/dashboard">Dashboard</a></h4>
</div>
<?php
}

}


function check_user_privilages()
{

$s_society_id=$this->Session->read('society_id');
$s_role_id=$this->Session->read('role_id');

$page_namr_url=strtolower($this->request->params['action']); 
 
$this->loadmodel('page');
$conditions=array("page_name" => $page_namr_url);
$cursor=$this->page->find('all',array('conditions'=>$conditions));
foreach ($cursor as $collection) 
{					
$module_id=$collection["page"]["module_id"];
$sub_module_id=$collection["page"]["sub_module_id"];
$this->set('id_current_page',$sub_module_id);
}

$this->loadmodel('role_privilege');
$conditions=array("module_id" => @$module_id,"sub_module_id" => @$sub_module_id,"society_id" => $s_society_id,"role_id" => $s_role_id);
$num=$this->role_privilege->find('count',array('conditions'=>$conditions));
if($num==0)
{
$this->layout='resricted';
?>
<div style="min-height: 85%;margin-top: 60px; " align="center">
<h2>Sorry<br/>You are not allowed to access this page.</h2>
<img src="<?php echo $this->webroot ; ?>/as/hm/hm-logo.png" alt="logo" >
<br/><h4>Back to <a href="<?php echo $this->webroot_path(); ?>Hms/dashboard">Dashboard</a></h4>
</div>
<?php

}

}

function rendom_color($last_color) 
{
$allcolors=array('#285e8e','#398439','#269abc','#d58512','#ac2925','#45b6af','#3ea7a0','#9b59b6');
$key = array_search($last_color,$allcolors);
if($key!==false){
unset($allcolors[$key]);
}
return $allcolors[array_rand($allcolors)];
}

function random_color_part() {
return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}
function rendom_color_new() 
{
//$allcolors=array('#285e8e','#398439','#269abc','#d58512','#ac2925','#45b6af','#3ea7a0','#9b59b6');
//return $allcolors[array_rand($allcolors)];
return '#'.$this->random_color_part() . $this->random_color_part() . $this->random_color_part();
}



function autoincrement($table,$field) 
{

$this->loadmodel($table);
$order=array($table.'.'.$field=>'DESC');

$cursor=$this->$table->find('all',array('order'=>$order,'limit'=>1));

foreach ($cursor as $collection) 
{
$last=$collection[$table][$field];
}

if(empty($last))
{
$auto=0;
}
else
{
$auto=$last;	
}

return ++$auto;

}

function autoincrement_with_society($table,$field) 
{
$s_society_id=$this->Session->read('society_id');
$this->loadmodel($table);
$conditions=array("society_id" => $s_society_id);
$order=array($table.'.'.$field=>'DESC');
$cursor=$this->$table->find('all',array('conditions'=>$conditions,'order'=>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last=$collection[$table][$field];
}
if(empty($last))
{
$auto2=0;
}
else
{
$auto2=$last;	
}
return ++$auto2;

}

function autoincrement_with_society_ticket($table,$field) 
{
$s_society_id=$this->Session->read('society_id');
$this->loadmodel($table);
$conditions=array("society_id" => $s_society_id);
$order=array($table.'.'.$field=>'DESC');
$cursor=$this->$table->find('all',array('conditions'=>$conditions,'order'=>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last=$collection[$table][$field];
}
if(empty($last))
{
$auto2=1000;
}
else
{
$auto2=$last;	
}
return ++$auto2;
}


function autoincrement_with_receipt_source($table,$field,$source) 
{
$s_society_id=$this->Session->read('society_id');
$this->loadmodel($table);
$conditions=array("society_id" => $s_society_id,"receipt_source"=>$source,"auto_inc"=>"YES");
$order=array($table.'.'.$field=>'DESC');
$cursor=$this->$table->find('all',array('conditions'=>$conditions,'order'=>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last=$collection[$table][$field]; 
}
if(empty($last))
{
$auto2=1000;
}
else
{
$auto2=$last;	
}
return ++$auto2;
}


function autoincrement_with_fixed_deposit($table,$field) 
{
$s_society_id=$this->Session->read('society_id');
$this->loadmodel($table);
$conditions=array("society_id" => $s_society_id,"auto_inc"=>"YES");
$order=array($table.'.'.$field=>'DESC');
$cursor=$this->$table->find('all',array('conditions'=>$conditions,'order'=>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last=$collection[$table][$field]; 
}
if(empty($last))
{
$auto2=1000;
}
else
{
$auto2=$last;	
}
return ++$auto2;
}

///////////////////////////// Setting ///////////////////////////////

function society_settings()
{
	
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}
	$this->ath();
	$s_society_id=$this->Session->read('society_id');
	
	$this->set('s_user_id',$this->Session->read('user_id'));
	$this->set('role_id',$this->Session->read('role_id'));
	if(isset($this->request->data['sub']))
	{
	
	        @$reminder_status = $this->request->data['remndrr'];
			@$signup_auto=$this->request->data['signup'];
			@$help_desk=$this->request->data['help_desk'];
			@$family_member=(int)$this->request->data['family_member'];
			@$family_member_tenant=(int)$this->request->data['family_member_tenant']; 
			@$notice=$this->request->data['notice'];
			@$document=$this->request->data['document'];
			@$discussion_forum=$this->request->data['discussion_forum'];
			@$discussion_forum_email=$this->request->data['discussion_forum1'];
			@$poll=$this->request->data['poll'];
			@$account_email=$this->request->data['account1'];
			@$account_sms=$this->request->data['account2'];
			@$account_zero_ammount=$this->request->data['account3'];
			@$merge_receipt=(int)$this->request->data['merge_receipt'];
			@$access_tenant=(int)$this->request->data['access_tenant'];
			
			@$banned_word=$this->request->data['banned'];
			@$banned_word= explode(",",$banned_word);
			//$society_pan=$this->request->data['pan'];
			//$society_tax=$this->request->data['tax_num'];
			if(empty($signup_auto))
			{
				$signup_auto=0;
				
			}
	    	if(empty($help_desk))
			{
				$help_desk=0;
				
			}
			if(empty($notice))
			{
				$notice=0;
				
			}
			if(empty($document))
			{
				$document=0;
				
			}
			if(empty($discussion_forum))
			{
				$discussion_forum=0;
				
			}
			if(empty($discussion_forum_email))
			{
				$discussion_forum_email=0;
				
			}
			if(empty($poll))
			{
				$poll=0;
				
			}
			if(empty($account_email))
			{
				$account_email=0;
				
			}
			if(empty($account_sms))
			{
				$account_sms=0;
				
			}
			if(empty($family_member))
			{
				$family_member=0;
				
			}
			if(empty($account_zero_ammount))
			{
				$account_zero_ammount=0;
			}
			if(empty($reminder_status))
			{
			$reminder_status = 0;
			}
			$this->loadmodel('society');
			$this->society->updateAll(array('signup'=>$signup_auto,'help_desk'=>$help_desk,'notice'=>$notice,'document'=>$document,'discussion_forum'=>$discussion_forum,'discussion_forum_email'=>$discussion_forum_email,'poll'=>$poll,'account_email'=>$account_email,'account_sms'=>$account_sms,'account_zero_ammount'=>$account_zero_ammount,'content_moderation'=>$banned_word,'family_member'=>$family_member,'merge_receipt'=>$merge_receipt,"reminder_status"=>$reminder_status,'access_tenant'=>$access_tenant,'family_member_tenant'=>$family_member_tenant),array('society_id'=>$s_society_id));
					
	}
	
	$this->loadmodel('society');
	$result=$this->society->find('all',array('conditions'=>array('society_id'=>$s_society_id)));
	$this->set('result_society',$result);

}

///////////////////////// end Setting /////////////////////////////


///////////////////////   Deactive functionality start   //////////////////////////////////////



function add_field(){
		
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}
	$this->ath();
	
	
	/*this code to run production system 
		
	$s_society_id=$this->Session->read('society_id');	
	$this->loadmodel('user');
	$conditions=array('deactive'=>0,'society_id'=>$s_society_id);
	$result_user=$this->user->find('all');
	foreach($result_user as $data){
		
		 $user_id=$data['user']['user_id'];
		  $society_id=$data['user']['society_id'];
		 $tenant=$data['user']['tenant'];
		 $wing=$data['user']['wing'];
		 $flat=$data['user']['flat'];
		 $multiple_flat=@$data['user']['multiple_flat'];
		if(!empty($multiple_flat)){
			
			foreach($multiple_flat as $dd){
				
				 $wing_id=$dd[0];
				 $flat_id=$dd[1];
				 $this->loadmodel('user_flat');
				 $i=$this->autoincrement('user_flat','user_flat_id');
				 $this->user_flat->saveAll(array('user_flat_id'=>$i,'user_id'=>$user_id,'society_id'=>$society_id,'flat_id'=>$flat_id,'status'=>$tenant,'active'=>0,'exit_date'=>'','time'=>''));
			}	
			
			
		}else{
			
		
				 $this->loadmodel('user_flat');
				 $i=$this->autoincrement('user_flat','user_flat_id');
				 $this->user_flat->saveAll(array('user_flat_id'=>$i,'user_id'=>$user_id,'society_id'=>$society_id,'flat_id'=>$flat,'status'=>$tenant,'active'=>0,'exit_date'=>'','time'=>''));
			
		}
		
	} */
	
	/*
	$this->loadmodel('flat');
	
	$result_flat=$this->flat->find('all');
	//pr($result_flat);
	foreach($result_flat as $data){
		
		   $flat_id=(int)$data['flat']['flat_id'];
		   $flat_name=$data['flat']['flat_name'];
		   $this->loadmodel('flat');
		  $this->flat->updateAll(array('flat_name'=>(int)$flat_name),array('flat_id'=>$flat_id));
		  
		  //$this->flat->updateAll(array('flat_name'=>$flat_name),array('flat_id'=>$flat_id));
		
	}
	
	*/
	echo $bill_html='<div style="margin: 0px;">
        <table style="padding:24px;background-color:#34495e" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="main_table">
            <tbody><tr>
                <td>
                    <table style="padding:38px 30px 30px 30px;background-color:#fafafa" align="center" border="0" cellpadding="0" cellspacing="0" width="540">
                        <tbody>
						<tr>
							<td height="10">
							<table width="100%" class="hmlogobox">
								<tr>
									<td width="50%" style="padding: 10px 0px 0px 10px;"><img src="/Housingmatters//Housingmatters//as/hm/hm-logo.png" style="max-height: 60px; " height="60px" /></td>
									<td width="50%" align="right" valign="middle"  style="padding: 7px 10px 0px 0px;">
									<a href="https://www.facebook.com/HousingMatters.co.in"><img src="/Housingmatters//Housingmatters//as/hm/SMLogoFB.png"    style="max-height: 30px; height: 30px; width: 30px; max-width: 30px;" height="30px" width="30px" /></a>
									</td>
								</tr>
							</table>
							</td>
						</tr>
						<tr>
							<td height="10"></td>
						</tr>
                        <tr>
                            <td colspan="2" style="font-size:12px;line-height:1.4;font-family:Arial,Helvetica,sans-serif;color:#34495e;border: solid 1px #767575;">
							<table style="font-size:12px" width="100%" cellspacing="0">
								<tbody><tr>
									<td style="padding:2px;background-color:rgb(0,141,210);color:#fff" align="center" width="100%"><b>THARWANI HERITAGE CHS LTD</b></td>
								</tr>
							</tbody></table>
							<table style="font-size:12px" width="100%" cellspacing="0">
								<tbody>
								<tr>
									<td width="30%" style="border-bottom: solid 1px #767575;    border-top: solid 1px #767575;"></td>
									<td style="padding:5px;border-bottom: solid 1px #767575;    border-top: solid 1px #767575;"  width="70%" align="right">
									<span style="color: rgb(100, 100, 99); ">Regn# &nbsp; NBOM/CIDCO/HSG (OH)/2780/JTR/2008-09</span><br>
									<span style="color: rgb(100, 100, 99); ">Plot 24, Sector 7, Kharghar, Navi Mumbai 410 210</span><br><span>Email:</span><a href="mailto:tharwaniheritage@yahoo.in" target="_blank" style="color:#000 !important;text-decoration: none;">tharwaniheritage@yahoo.in</a> | <span>Phone : 022 27741211</span>
									</td>
								</tr>
								</tbody>
							</table>
							<table style="font-size:12px" width="100%" cellspacing="0">
								<tbody><tr>
									<td style="padding: 0px 0 0 5px;"><b>Name:</b></td>
									<td>Anmol Singh</td>
									<td><b>Flat/Shop No.:</b></td>
									<td></td>
								</tr>
								<tr>
									<td style="padding: 0px 0 0 5px;"><b>Bill No.:</b></td>
									<td>1203</td>
									<td><b>Area (sq.ft.):</b></td>
									<td>545</td>
								</tr>
								<tr>
									<td style="padding: 0px 0 0 5px;"><b>Bill Date:</b></td>
									<td>01-04-2015</td>
									<td><b>Billing Period:</b></td>
									<td>Apr - Jun  2015</td>
								</tr>
								<tr>
									<td style="padding: 0px 0 0 5px;"><b>Due Date:</b></td>
									<td>01-05-2015</td>
									<td><b>Description:</b></td>
									<td></td>
								</tr>
							</tbody></table>
							<table style="font-size:12px;border-bottom: solid 1px #767575;" width="100%" cellspacing="0">
								<tbody><tr>
									<td style="padding: 0 0 0 5px;background-color:rgb(0,141,210);color:#fff;border-top: solid 1px #767575;border-bottom: solid 1px #767575;border-right: solid 1px #FFFFFF;" align="left" width="60%"><b>Particulars of charges</b></td>
									<td style="padding: 0 5px 0 0;background-color:rgb(0,141,210);color:#fff;border-top: solid 1px #767575;border-bottom: solid 1px #767575;" align="right" width="40%"><b>Amount (Rs.)</b> </td>
								</tr><tr>
										<td align="left" style="border-right: solid 1px #767575;padding: 0 0 0 5px;" >CIDCO Service charges</td>
										<td align="right" style="padding: 0 5px 0 0;">572</td>
									</tr><tr>
										<td align="left" style="border-right: solid 1px #767575;padding: 0 0 0 5px;" >Maintenance charges</td>
										<td align="right" style="padding: 0 5px 0 0;">2520</td>
									</tr><tr>
										<td align="left" style="border-right: solid 1px #767575;padding: 0 0 0 5px;" >Repair Fund</td>
										<td align="right" style="padding: 0 5px 0 0;">621</td>
									</tr><tr>
										<td align="left" style="border-right: solid 1px #767575;padding: 0 0 0 5px;" >Sinking Fund</td>
										<td align="right" style="padding: 0 5px 0 0;">196</td>
									</tr><tr>
										<td align="left" style="border-right: solid 1px #767575;padding: 0 0 0 5px;" >Fire Equipt. Maint Charges</td>
										<td align="right" style="padding: 0 5px 0 0;">156</td>
									</tr></tbody></table>
							<table style="font-size:12px;border-bottom: solid 1px #767575;" width="100%" cellspacing="0">
								<tbody><tr>
									<td width="60%" valign="top" style="border-right: solid 1px #767575;">
										<table style="font-size:11px" width="100%">
											<tbody>
											<tr>
												<td colspan="2" style="padding: 0 0 0 5px;">Cheque/NEFT payment instructions:</td>
											</tr>
											<tr>
												<td width="40%" style="padding: 0 0 0 5px;"><b>Account Name:</b></td>
												<td width="60%"></td>
											</tr>
											<tr>
												<td width="40%" style="padding: 0 0 0 5px;"><b>Account No.:</b></td>
												<td width="60%"></td>
											</tr>
											<tr>
												<td width="40%" style="padding: 0 0 0 5px;"><b>Bank Name:</b></td>
												<td width="60%"></td>
											</tr>
											<tr>
												<td width="40%" style="padding: 0 0 0 5px;"><b>Branch Name:</b></td>
												<td width="60%"></td>
											</tr>
											<tr>
												<td width="40%" style="padding: 0 0 0 5px;"><b>IFSC no.:</b></td>
												<td width="60%"></td>
											</tr>
										</tbody></table>
									</td>
									<td width="40%" valign="top">
										<table style="font-size:12px" width="100%">
											<tbody><tr>
												<td align="right" width="70%">Total:</td>
												<td align="right" width="30%" style="padding: 0 5px 0 0;">4065</td>
											</tr>
											<tr>
												<td align="right">Interest on arrears:</td>
												<td align="right" style="padding: 0 5px 0 0;">0</td>
											</tr>
											<tr>
												<td align="right">Arrears-Principal:</td>
												<td align="right" style="padding: 0 5px 0 0;">0</td>
											</tr>
											<tr>
												<td align="right">Arrears-Interest:</td>
												<td align="right" style="padding: 0 5px 0 0;">0</td>
											</tr><tr>
												<td align="right" width="60%">Credit/Adjustment:</td>
												<td align="right" width="40%" style="padding: 0 5px 0 0;">0</td>
											</tr><tr>
												<td align="right" width="60%"><b>Due For Payment:</b></td>
												<td align="right" width="40%" style="padding: 0 5px 0 0;">4065</td>
											</tr>
										</tbody></table>
									</td>
								</tr>
							</tbody></table><table style="font-size:12px" width="100%" cellspacing="0">
								<tbody><tr>
									<td width="100%" style="font-size:12px;border-bottom: solid 1px #767575;padding: 0 0 0 5px;"><b>Due For Payment (in words) :</b> Rupees Four Thousand And Sixty-five Only</td>
								</tr>
							</tbody></table><table style="font-size:12px;border-bottom: dotted 1px;" width="100%" cellspacing="0">
								<tbody><tr>
									<td width="50%" style="padding:5px;" valign="top">
									<span>Remarks:</span><br><span>1. Please pay by due date to avoid penal interest.</span><br></td>
									<td align="center" width="50%" style="padding:5px;" valign="top">
									For  <b>Tharwani Heritage CHS Ltd</b><br><br><br>
									<div><span style="border-top:solid 1px #424141">Society Manager</span></div>
									</td>
								</tr>
							</tbody></table>
							<table style="font-size:12px" width="100%" cellspacing="0">
								<tbody><tr>
									<td align="center" width="100%">Note: This is a computer generated bill hence no signature required.</td>
								</tr>
							</tbody></table>
							
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2" >
                                <table style="background-color: #008DD2;font-size:11px;color:#FFF;border: solid 1px #767575;border-top:none;" width="100%" cellspacing="0">
                                 <tbody>
								 
									<tr>
                                        <td  align="center" colspan="7"><b>
										Your Society is empowered by HousingMatters - <b/> <i>"Making Life Simpler"</i>
										</td>
                                    </tr>
									<tr>
                                        <td width="50" align="right"><b>Email :</b></td>
                                        <td  width="120" style="color:#FFF !important;"> 
										<a href="mailto:support@housingmatters.in" target="_blank" style="color:#FFF !important;"><b>support@housingmatters.in</b></a>
                                        </td>
										<td align="center"></td>
                                        <td align="right" width="50"><b>Phone :</b></td>
                                        <td width="84" style="color:#FFF !important;text-decoration: none;"><b>022-41235568</b></td>
										<td align="center"></td>
                                        <td width="100" style="padding-right: 10px;text-decoration: none;"> <a href="http://www.housingmatters.in" target="_blank" style="color:#FFF !important;"><b>www.housingmatters.in</b></a></td>
                                    </tr>
                                    <tr>
                                        <td  align="center" colspan="7"><b>
										9887779123 </td>
                                    </tr>
                                    
                                </tbody>
							</table>
                            </td>
                        </tr>
                        <tr>
							<td align="center"><div class="hmlogobox" ><a href="mailto:Support@housingmatters.in">Do not miss important e-mails from HousingMatters,  add us to your address book</a></div></td>
						</tr>
                    </tbody></table>
                </td>
            </tr>
        </tbody></table>
                   
            </div>';
	
	exit; 
}



function user_deactive()
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();	

$s_society_id=$this->Session->read('society_id');	
$this->loadmodel('society');	
$conditions=array('society_id'=>$s_society_id);	
$this->set('result_society',$this->society->find('all',array('conditions'=>$conditions)));


$this->loadmodel('user');
$conditions=array('society_id'=>$s_society_id);
$result=$this->user->find('all',array('conditions'=>$conditions));
$this->set('result_user_deactive',$result);
}

function user_deactive_ajax()
{
		$this->layout="blank_signup";
		$s_society_id=$this->Session->read('society_id');
		$user_id=(int)$this->request->query['t']; 
		 $user_flat_id=(int)$this->request->query['user_flat_id'];
		 $status=(int)$this->request->query['d'];
		
		$this->loadmodel('user_flat');
		$conditions6=array('user_flat_id'=>$user_flat_id);
		$result_user_f=$this->user_flat->find('all',array('conditions'=>$conditions6));
		$flat_id=$result_user_f[0]['user_flat']['flat_id'];
		
	  $this->set('user_id',$user_id);
	 $this->set('det',$status);
	 if($status==0)
	 {
		
		date_default_timezone_set('Asia/kolkata');
		$date=date("d-m-Y");
		$time=date('h:i:a',time());
		$exit_date1 = date('Y-m-d',strtotime($date));
		//$exit_date1 = "2015-2-5";
		//$exit_date1 = date('Y-m-d',strtotime($exit_date1));
		$exit_date = strtotime($exit_date1); 
		$this->loadmodel('user_flat');
		$this->user_flat->updateAll(array('active'=>1,'exit_date'=>$exit_date,'time'=>$time),array('user_flat_id'=>$user_flat_id));
		
		
		$this->loadmodel('log');
		$i=$this->autoincrement('log','log_id');
		$this->log->save(array('log_id'=>$i,'user_id'=>$user_id,'society_id'=>$s_society_id,'deactive_date'=>$date,'deactive_time'=>$time,'status'=>1));
		
		$this->loadmodel('ledger_sub_account');
		$this->ledger_sub_account->updateAll(array('deactive'=>1,"exit_date"=>$exit_date),array('user_id'=>$user_id,'flat_id'=>$flat_id));
		
		
		$this->loadmodel('user_flat');
		$conditions=array('user_id'=>$user_id,'active'=>0);
		$result_user=$this->user_flat->find('count',array('conditions'=>$conditions));
		
			if($result_user==0){
			$this->loadmodel('user');
			$this->user->updateAll(array('deactive'=>1),array('user_id'=>$user_id));
			}
	 }
	 
	 
	 if($status==1)
	 {
		 
		
		date_default_timezone_set('Asia/kolkata');
		$date=date("d-m-Y");
		$time=date('h:i:a',time());
		$exit_date1 = date('Y-m-d',strtotime($date));
		$exit_date = strtotime($exit_date1); 
		
		$this->loadmodel('user_flat');
		$conditions=array('flat_id'=>$flat_id,'active'=>0);
		$result_user=$this->user_flat->find('count',array('conditions'=>$conditions));
		if($result_user==0){
		
		$this->loadmodel('user_flat');
		$this->user_flat->updateAll(array('active'=>0,'exit_date'=>$exit_date,'time'=>$time),array('user_flat_id'=>$user_flat_id));
		
		$this->loadmodel('user');
		$this->user->updateAll(array('deactive'=>0),array('user_id'=>$user_id));
		
		$this->loadmodel('log');
		$i=$this->autoincrement('log','log_id');
		$this->log->save(array('log_id'=>$i,'user_id'=>$user_id,'society_id'=>$s_society_id,'active_date'=>$date,'active_time'=>$time,'status'=>2));
		
		$this->loadmodel('ledger_sub_account');
		$this->ledger_sub_account->updateAll(array('deactive'=>0,"exit_date"=>$exit_date),array('user_id'=>$user_id,'flat_id'=>$flat_id)); 
		$output = json_encode(array('report_type'=>'done', 'text' => ''));
		die($output);
		
		}else{
			$output = json_encode(array('report_type'=>'exits', 'text' => ''));
			die($output);
			
		}
	 }
		
}

function all_user_deactive()
{
	$s_society_id=$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$this->loadmodel('user');
	$conditions=array('society_id'=>$s_society_id,'deactive'=>0);
	return $result_user=$this->user->find('all',array('conditions'=>$conditions));
}


function all_owner_deactive()
{
	$s_society_id=$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$this->loadmodel('user');
	$conditions=array('society_id'=>$s_society_id,'tenant'=>1,'deactive'=>0);
	return $result_user=$this->user->find('all',array('conditions'=>$conditions));
}


function all_tenant_deactive()
{
	$s_society_id=$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$this->loadmodel('user');
	$conditions=array('society_id'=>$s_society_id,'tenant'=>2,'deactive'=>0);
	return $result_user=$this->user->find('all',array('conditions'=>$conditions));
}



function all_role_wise_deactive($role_id)
{
	
	$s_society_id=$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$this->loadmodel('user');
	$conditions=array('society_id'=>$s_society_id,'role_id'=>(int)$role_id,'deactive'=>0);
	return $result_user=$this->user->find('all',array('conditions'=>$conditions));
}


function all_wing_wise_deactive($wing_id)
{
	$s_society_id=$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$this->loadmodel('user');
	$conditions=array('society_id'=>$s_society_id,'wing'=>(int)$wing_id,'deactive'=>0);
	return $result_user=$this->user->find('all',array('conditions'=>$conditions));
}


///////////////////////////// End  ///////////////////////////////////////


///////////////////////// Start  multiple_flat ///////////////////////////////
function multiple_flat()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}
			$this->ath();
			$this->check_user_privilages();	
			$s_society_id=(int)$this->Session->read('society_id');
			$s_user_id=$this->Session->read('user_id');
			
			$this->set('s_society_id',$s_society_id);
			
			
			$this->seen_alert(105,$s_user_id);
			$result=$this->all_user_deactive();
			$this->set('result_user',$result);
	
		if($this->request->is('post')){
		
		  $user_sel=(int)$this->request->data['resident_id'];
		  $wing=(int)$this->request->data['wing'];
		  $flat=(int)$this->request->data['fflt'];
		  $result_user=$this->profile_picture($user_sel);
			foreach($result_user as $data){
				$user_name=$data['user']['user_name'];
				$tenant=$data['user']['tenant'];
				
			}
				$this->loadmodel('user_flat');
				$conditions=array("flat_id" => $flat,'society_id'=>$s_society_id,'active'=>0);
				$result_count=$this->user_flat->find('all',array('conditions'=>$conditions));
				$n= sizeof($result_count);
		  	
			if($n==0){


				
						$this->loadmodel('user_flat');
						$i=$this->autoincrement('user_flat','user_flat_id');
						$this->user_flat->saveAll(array('user_flat_id'=>$i,'user_id'=>$user_sel,'society_id'=>$s_society_id,'flat_id'=>$flat,'status'=>$tenant,'active'=>0,'exit_date'=>'','time'=>''));

					///////////////  Insert code ledger Sub Accounts //////////////////////
					if($tenant==1){
					$this->loadmodel('ledger_sub_account');
					$j=$this->autoincrement('ledger_sub_account','auto_id');
					$this->ledger_sub_account->save(array('auto_id'=>$j,'ledger_id'=>34,'name'=>$user_name,'society_id' => $s_society_id,'user_id'=>$user_sel,'deactive'=>0,"flat_id"=>$flat));
					}
					
					/////////////  End code ledger sub accounts //////////////////////////
					?>
					<!----alert-------------->
					<div class="modal-backdrop fade in"></div>
					<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
					<div class="modal-body" style="font-size:16px;">
					Successfully add multiple flat
					</div> 
					<div class="modal-footer">
					<a href="multiple_flat" class="btn green">OK</a>
					</div>
					</div>
					<!----alert--------------><?php
			}	
			else{
				$this->set('wrong','<span style="color:red; font-size:14px;">Wing-Flat is already exits</span>');
			}	
		}


		$this->loadmodel('wing');
		$conditions=array("society_id"=>$s_society_id);
		$cursor1 = $this->wing->find('all',array('conditions'=>$conditions));
		$this->set('wing_data',$cursor1);

		}

///////////////////////// Start  multiple_flat ///////////////////////////////
function multiple_flat_ajax1()
{
    $this->layout="blank";
	 $flat_id=(int)$this->request->query('vb');	
	 $this->loadmodel('flat');
	 $this->set('result_flat',$this->flat->find('all',array('conditions'=>array('wing_id'=>$flat_id))));
	
}
function multiple_flat_ajax()
{
		$this->layout="blank";
		$s_society_id=$this->Session->read('society_id');
		
  		$wing_id = (int)$this->request->query('wngg');
	    $value = $this->request->query('vv');	
        $this->set('value',$value);
		
		
		if(!empty($value))
		{
		$this->loadmodel('user_flat');
		$conditions=array('user_id'=>$wing_id,"society_id"=>$s_society_id,'active'=>0);
		$result2=$this->user_flat->find('all',array('conditions'=>$conditions));
		$this->set('user_data',$result2);
		}
		
		$this->loadmodel('flat');
		$conditions=array('wing_id'=>$wing_id,"society_id"=>$s_society_id);
		$result=$this->flat->find('all',array('conditions'=>$conditions));
		$this->set('flat_data',$result);

}	

function flat_name_via_wing_id($wing_id)
{
$s_society_id=(int)$this->Session->read('society_id');

$this->loadmodel('flat');
$conditions=array("wing_id" =>(int)$wing_id,"society_id"=>$s_society_id);
$order=array('flat.flat_name'=>'ASC');
return $this->flat->find('all',array('conditions'=>$conditions,'order'=>$order));

}


function profile_picture($user_id)
{
$this->loadmodel('user');
$conditions=array("user_id" => $user_id);
return $this->user->find('all',array('conditions'=>$conditions));
}

function wing_flat($wing_id,$flat_id)
{
$this->loadmodel('wing');
$conditions=array("wing_id" => $wing_id);
$result=$this->wing->find('all',array('conditions'=>$conditions));
foreach($result as $data)
{
$wing_name=$data['wing']['wing_name'];
}
$this->loadmodel('flat');
$conditions=array("flat_id" => $flat_id);
$result2=$this->flat->find('all',array('conditions'=>$conditions));
foreach($result2 as $data)
{
$flat_name=$data['flat']['flat_name'];
}
if(!empty($wing_name) && !empty($flat_name))
{
return @$wing_name.'-'.@$flat_name;
}
}

///////////////////////// Start wing flat with bracket ///////////////////////////////////
function wing_flat_with_brackets($wing_id,$flat_id)
{
$this->loadmodel('wing');
$conditions=array("wing_id" => $wing_id);
$result=$this->wing->find('all',array('conditions'=>$conditions));
foreach($result as $data)
{
$wing_name=$data['wing']['wing_name'];
}

$this->loadmodel('flat');
$conditions=array("flat_id" => $flat_id);
$result2=$this->flat->find('all',array('conditions'=>$conditions));
foreach($result2 as $data)
{
$flat_name=$data['flat']['flat_name'];
}
if(!empty($wing_name) && !empty($flat_name))
{
$wing_flat = "( " .$wing_name." - ".$flat_name." )";
return $wing_flat;
}
}

function fetch_flat_detail_via_flat_type_id($flat_type_id){
	$s_society_id=$this->Session->read('society_id');
	$this->loadmodel('flat');
	$conditions=array("flat_type_id" => $flat_type_id,"society_id"=>$s_society_id);
	return $this->flat->find('all',array('conditions'=>$conditions));
}



///////////////////// End wing flat with bracket ////////////////////////////////// 

function fetch_subLedger_detail_via_flat_id($flat_id){
	$s_society_id=$this->Session->read('society_id');
	$this->loadmodel('ledger_sub_account');
	$conditions=array("flat_id" => $flat_id,"society_id"=>$s_society_id);
	return $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
}

function fetch_wing_id_via_flat_id($flat_id){
	$s_society_id = (int)$this->Session->read('society_id');
	$flat_id = (int)$flat_id;
	$this->loadmodel('flat');
	$conditions=array("flat_id" =>$flat_id,"society_id" => $s_society_id);
	return $this->flat->find('all',array('conditions'=>$conditions));
}

function fetch_user_info_via_flat_id($wing,$flat){
	$s_society_id=$this->Session->read('society_id');
	$this->loadmodel('user_flat');
	/*$conditions =array( '$or' => array( 
	array('wing' =>$wing,'flat' =>$flat),
	array('multiple_flat' => array('$in' => array(array((int)$wing,(int)$flat))))
	)); */
	
	$conditions=array('flat_id'=>$flat,'status'=>1,'active'=>0);
	$result_user_flat=$this->user_flat->find('all',array('conditions'=>$conditions));
	$user_id=@$result_user_flat[0]['user_flat']['user_id'];
	return $this->profile_picture((int)$user_id);
	
}

function fetch_user_info_via_flat_id2($flat){
	$s_society_id=$this->Session->read('society_id');
	$this->loadmodel('user_flat');
	$conditions=array('flat_id'=>$flat,'active'=>0);
	$result_user_flat=$this->user_flat->find('all',array('conditions'=>$conditions));
	$user_id=$result_user_flat[0]['user_flat']['user_id'];
	return $this->profile_picture((int)$user_id);
	
}


function wing_flat_new($wing_id,$flat_id)
{
$this->loadmodel('wing');
$conditions=array("wing_id" => $wing_id);
$result=$this->wing->find('all',array('conditions'=>$conditions));
foreach($result as $data)
{
$wing_name=$data['wing']['wing_name'];
}

$this->loadmodel('flat');
$conditions=array("flat_id" => $flat_id);
$result2=$this->flat->find('all',array('conditions'=>$conditions));
foreach($result2 as $data)
{
$flat_name=$data['flat']['flat_name'];
}

if(!empty($wing_name) && !empty($flat_name))
{
return @$wing_name.' '.@$flat_name;
}


}


function csv_import()
{
$this->layout='session';
if ($this->request->is('post')) 
{

$file=$this->request->form['file']['name'];

$dir='C:\xampp\htdocs\cakephp\app\webroot\csv_file';

$target = "csv_file/";
$target=@$target.basename( @$this->request->form['file']['name']);
$ok=1;
move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target);

$f = fopen('csv_file/'.$file, 'r') or die("ERROR OPENING DATA");
$batchcount=0;
$records=0;
while (($line = fgetcsv($f, 4096, ';')) !== false) {
// skip first record and empty ones
$numcols = count($line);

$test[]=$line;

//echo $col = $line[0];
//echo $batchcount++.". ".$col."\n";


++$records;
}

fclose($f);
$records;


for($i=1;$i<sizeof($test);$i++)
{
$r=explode(',',$test[$i][0]);

if(!empty($r[0])) {	$ok1=2; }
else { $ok1=1; $error_msg[]="UserName should not be empty";	}

if(!empty($r[1]))
{	
$ok2=2; 

if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $r[1])) {
$ok3=2;
}
else {
$ok3=1; $error_msg[]="Email Id is not valid.";
}

}
else { $ok2=1; $error_msg[]="Email should not be empty";	}

if(!empty($r[2])) {	$ok4=2; }
else { $ok4=1; $error_msg[]="Password should not be empty";	}


if($ok1==2 && $ok2==2 && $ok3==2 && $ok4==2)
{

}	

}

$this->set('error_msg',@$error_msg);

$this->set('ok1',$ok1);
$this->set('ok2',$ok2);
$this->set('ok3',$ok3);
$this->set('ok4',$ok4);

if($ok1==2 && $ok2==2 && $ok3==2 && $ok4==2)
{
//$cmd='cmd.exe /c C:\\mongodb\bin\mongoimport -d test -c test  -type csv -f name,age  '.$dir.'/'.$file;
//$cmd='cmd.exe /c C:\\mongodb\bin\mongoimport -d test -c test  -type csv  '.$dir.'/'.$file.' --headerline';
//exec($cmd,$output,$err);

for($i=1;$i<sizeof($test);$i++)
{
$r=explode(',',$test[$i][0]);
$u=$this->autoincrement('user','user_id');
$this->loadmodel('user');
$this->user->saveAll(array('user_id' => $u, 'user_name' => $r[0],'email' => $r[1], 'password' => $r[2], 'mobile' => "",  'society_id' => 0, 'role_id' => array(2), 'committee' => 2 , 'tenant' => 1, 'wing' => 0, 'flat' => 0,'residing' => 1,'default_role_id'=>2,'profile_pic'=>"blank.jpg"));
}

$this->set('sucess','Csv Imported successfully.');
}

}
}


function VerifyMailAddress($address) 
{
$Syntax='#^[w.-]+@[w.-]+.[a-zA-Z]{2,5}$#';
if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
return 0;
}
else
{ return 1; }
}


function VerifyMobileNo($number) 
{
if (preg_match('/^\d{10}$/', $number)) {
return 1;
} else {
return 0;
}
}






function csv_import_signup()
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
	$this->ath();
$this->check_user_privilages();
$s_society_id=$this->Session->read('society_id');
$soc_result=$this->society_name($s_society_id);
foreach($soc_result as $data)
{
	$society_name=$data['society']['society_name'];
	
}
if ($this->request->is('post')) 
{
@$ip=$this->hms_email_ip();
date_default_timezone_set('Asia/kolkata');
 $date=date("d-m-Y");
 $time=date('h:i:a',time());
$file=$this->request->form['file']['name'];
$extension = pathinfo($file, PATHINFO_EXTENSION);
if($extension!='csv') { echo '<script>alert("file extension should be csv." ); location="csv_import_signup"; </script>';	exit; }


$dir='C:\xampp\htdocs\cakephp\app\webroot\csv_file';

$target = "csv_file/";
$target=@$target.basename( @$this->request->form['file']['name']);
$ok=1;
move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target);

$f = fopen('csv_file/'.$file, 'r') or die("ERROR OPENING DATA");
$batchcount=0;
$records=0;
while (($line = fgetcsv($f, 4096, ';')) !== false) {
// skip first record and empty ones
$numcols = count($line);

$test[]=$line;

//echo $col = $line[0];
//echo $batchcount++.". ".$col."\n";


++$records;
}

fclose($f);
$records;


for($i=1;$i<sizeof($test);$i++)
{
$row_no=$i+1;
$r=explode(',',$test[$i][0]);
$username=trim($r[0]);
$wing=trim($r[1]); 
$flat=trim($r[2]);
$email=trim($r[3]);
if($i==1) { $email_current=array(); }
$mobile=trim($r[4]);
$owner=trim($r[5]);
$committee=trim($r[6]);
$residing =trim($r[7]);
$imported_data=$test;

if(!empty($username)) {	$ok=2; }
else { $ok=1; $error_msg[]="UserName should not be empty in row ".$row_no.".";	break;}

$this->loadmodel('wing'); 
$conditions=array("society_id"=>$s_society_id,"wing_name"=> new MongoRegex('/^' .  $wing . '$/i'));
$result_wing=$this->wing->find('all',array('conditions'=>$conditions));
$result_wing_count=sizeof($result_wing);

if($result_wing_count>0) 
{	
$ok=2; 
$wing_id=$result_wing[0]['wing']['wing_id'];
$wing_id_d[]=$wing_id;
}
else { $ok=1; $error_msg[]="Wing name is not right in row ".$row_no."."; break;}

$this->loadmodel('flat'); 
$conditions=array("wing_id"=>$wing_id,"flat_name"=> new MongoRegex('/^' .  $flat . '$/i'));
$result_flat=$this->flat->find('all',array('conditions'=>$conditions));
$result_flat_count=sizeof($result_flat);

if($result_flat_count>0) 
{ 
$ok=2; 		
$flat_id=$result_flat[0]['flat']['flat_id'];	
$flat_id_d[]=$flat_id;
}
else { $ok=1; $error_msg[]="Flat name is not right in row ".$row_no.".";  break;}


if(!empty($email))
{
$email_varify=$this->VerifyMailAddress($email);
if($email_varify==1) 
{
$this->loadmodel('user'); 
$conditions=array("email"=>$email);
$result_email=$this->user->find('all',array('conditions'=>$conditions));
$result_email_count=sizeof($result_email);


if (in_array($email, $email_current))
{
$ok=1; $error_msg[]="Email Id can't be same in row ".$row_no.".";  break;
}
$email_current[]=$email;   
if($result_email_count==0) 
{ 
$ok=2; 	
}

else { $ok=1; $error_msg[]="Email Id is already exist in row ".$row_no.".";  break;}
}
else { $ok=1; $error_msg[]="Email Id format is not valid in row ".$row_no.".";  break;}
}
else { $ok=1; $error_msg[]="Email Id should not be empty in row ".$row_no.".";  break;}




if(!empty($mobile))
{
	
$ok=2; 
$mobile_varify=$this->VerifyMobileNo($mobile);
if($mobile_varify==1)
{
$this->loadmodel('user'); 
$conditions=array("mobile"=>$mobile);
$result_mobile=$this->user->find('all',array('conditions'=>$conditions));
$result_mobile_count=sizeof($result_mobile);	
if($result_mobile_count==0)
{	
	
$ok=2; 
}
else{ $ok=1; $error_msg[]="Mobile Number is already exist in row ".$row_no.".";  break; }

}
else { $ok=1; $error_msg[]="Mobile format is not valid in row ".$row_no.".";  break;}

}
else { $ok=1; $error_msg[]="Mobile should not be empty in row ".$row_no.".";  break;}



if(!empty($owner))
{
$result_owner_yes = strcasecmp($owner, 'yes');
$result_owner_no = strcasecmp($owner, 'no');
if ($result_owner_yes == 0 || $result_owner_no == 0) 
{

$ok=2;
} 
else { $ok=1; $error_msg[]="Owner should be yes or no in row ".$row_no.".";  break;}
}
else { $ok=1; $error_msg[]="Owner should not be empty in row ".$row_no.".";  break;}



if(!empty($committee))
{
$result_committee_yes = strcasecmp($committee, 'yes');
$result_committee_no = strcasecmp($committee, 'no');
if ($result_committee_yes == 0 || $result_committee_no == 0) 
{
$ok=2;
} 
else { $ok=1; $error_msg[]="Committee should be yes or no in row ".$row_no.".";  break;}
}
else { $ok=1; $error_msg[]="Committee should not be empty in row ".$row_no.".";  break;}


if(!empty($residing))
{
$result_residing_yes = strcasecmp($residing, 'yes');
$result_residing_no = strcasecmp($residing, 'no');
if ($result_residing_yes == 0 || $result_residing_no == 0) 
{

$ok=2;
} 
else { $ok=1; $error_msg[]="Residing should be yes or no in row ".$row_no.".";  break;}
}
else { $ok=1; $error_msg[]="Residing should not be empty in row ".$row_no.".";  break;}


}

$this->set('error_msg',@$error_msg);

$this->set('ok',$ok);


if($ok==2)
{

//$cmd='cmd.exe /c C:\\mongodb\bin\mongoimport -d test -c test  -type csv -f name,age  '.$dir.'/'.$file;
//$cmd='cmd.exe /c C:\\mongodb\bin\mongoimport -d test -c test  -type csv  '.$dir.'/'.$file.' --headerline';
//exec($cmd,$output,$err);
$this->set('imported_data',$imported_data);
for($i=1;$i<sizeof($test);$i++)
{
$r=explode(',',$test[$i][0]);

$ii=$i-1;
$username=$r[0];
$email=trim($r[3]);
$mobile=trim($r[4]);

$owner=trim($r[5]);
$result_owner_yes = strcasecmp($owner, 'yes');
$result_owner_no = strcasecmp($owner, 'no');
if ($result_owner_yes == 0) { $result_owner=1; }
if ($result_owner_no == 0) { $result_owner=2; }

$committee=trim($r[6]);
$result_committee_yes = strcasecmp($committee, 'yes');
$result_committee_no = strcasecmp($committee, 'no');
if ($result_committee_yes == 0) { $result_committee=1; }
if ($result_committee_no == 0) { $result_committee=2; }
if ($result_owner==2) { $result_committee=2; }

$residing =trim($r[7]);
$result_residing_yes = strcasecmp($residing, 'yes');
$result_residing_no = strcasecmp($residing, 'no');
if ($result_residing_yes == 0) { $result_residing=1; }
if ($result_residing_no == 0) { $result_residing=2; }	

$u=$this->autoincrement('user','user_id');
$log_i=$this->autoincrement('login','login_id');
$random1=mt_rand(1000000000,9999999999);
$random2=mt_rand(1000000000,9999999999);
$random=$random1.$random2 ;	
$de_user_id=$this->encode($u,'housingmatters');
$random=$de_user_id.'/'.$random;
$role_id[]=2;
if($result_committee==1)
{
 $role_id[]=1;
}
///////////////// insert user table /////////////////////////////

$this->loadmodel('user');
$this->user->saveAll(array('user_id' => $u, 'user_name' => $username,'email' => $email, 'password' => @$random, 'mobile' => $mobile,  'society_id' => $s_society_id, 'role_id' => $role_id,'tenant' => $result_owner, 'wing' => $wing_id_d[$ii], 'flat' => $flat_id_d[$ii],'residing' => $result_residing,'default_role_id'=>2,'profile_pic'=>"blank.jpg",'date' => $date, 'time' => $time,'sex'=>'','signup_random'=>$random,'deactive'=>0,'login_id'=>$log_i,'s_default'=>1));

///////////////////////// end //////////////////////////////////////

////////////////////  insert login table  ///////////////////

$this->loadmodel('login');
$this->login->saveAll(array('login_id'=>$log_i,'user_name'=>$email,'password'=>$random,'signup_random'=>$random,'mobile'=>$mobile));

////////////////////////////////////////////////////////////////// 


$message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Dear $username,</p>
<p>'We at $society_name use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.</p>
<p>As you are an owner/resident/staff of $society_name, we have added your email address in HousingMatters portal.</p>
<p>Here are some of the important features related to our portal on HousingMatters:</p>
<p>You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.</p>
<p>You can receive important SMS & emails from your committee.</p>
<br/>				
<p><b>
<a href='$ip".$this->webroot."/hms/send_sms_for_verify_mobile?q=$random'>Click here</a> for one time verification of your mobile number and Login into HousingMatters  for making life simpler for all your housing matters!</b></p>
<br/>
<p>Pls add www.housingmatters.co.in in your favorite bookmarks for future use.</p>
<p>Regards,</p>	
<p>Administrator of $society_name</p><br/>
www.housingmatters.co.in
</div >
</div>";

$from_name="HousingMatters";
$reply="support@housingmatters.in";
$to=$email;
$this->loadmodel('email');
$conditions=array("auto_id" => 4);
$result_email = $this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
}
$subject="Welcome to ".$society_name." portal ";
$this->send_email($to,$from,$from_name,$subject,@$message_web,$reply);



///////////////  Insert code ledger Sub Accounts //////////////////////

 $this->loadmodel('ledger_sub_account');
 $j=$this->autoincrement('ledger_sub_account','auto_id');
 $this->ledger_sub_account->saveAll(array('auto_id'=>$j,'ledger_id'=>34,'name'=>$username,'society_id' => $s_society_id,'user_id'=>$u,'deactive'=>0));

/////////////  End code ledger sub accounts //////////////////////////




////////////////Notification email user all checked code  //////////////////////////
$this->loadmodel('email');	
$conditions=array('notification_id'=>1);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach($result_email as $data)
{
  $auto_id = (int)$data['email']['auto_id'];
  $this->loadmodel('notification_email');
  $lo=$this->autoincrement('notification_email','notification_id');
  $this->notification_email->saveAll(array("notification_id" => $lo, "module_id" => $auto_id , "user_id" => $u,'chk_status'=>0));
}

//////////////// End all checked code   //////////////////////////

unset($role_id);
}

$this->set('sucess','Csv Imported successfully.');
}

}
}



function society_name($d_society_id)
{
	
$this->loadmodel('society');
$conditions=array("society_id"=>$d_society_id);
return $this->society->find('all',array('conditions'=>$conditions));
} 

function cron_email() 
{

/*
$this->layout='blank';

$this->loadmodel('email_request');
$conditions=array("flag"=>0);
$result_cron=$this->email_request->find('all',array('conditions'=>$conditions,'limit'=>3));
foreach($result_cron as $data4)
{
echo $to=$data4['email_request']['to'];
echo $from=$data4['email_request']['from'];
echo $from_name=$data4['email_request']['from_name'];
echo $subject=$data4['email_request']['subject'];
$message_web=$data4['email_request']['message_web'];
echo $reply=$data4['email_request']['reply'];

$this->smtpmailer($to, $from, $from_name, $subject, $message_web,$reply);
}
//$this->smtpmailer('abhilashlohar01@gmail.com', 'alerts@housingmatters.in', 'housingmatters', 'testing','hello','alerts@housingmatters.in');
*/
}


function notifications_count() 
{
$this->layout=null;
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('notification');
$conditions=array('users' =>array('$in' => array($s_user_id)),'seen_users' =>array('$nin' => array($s_user_id)));
$order=array('notification.notification_id'=>'DESC');
$this->set('result_notifications_count',$this->notification->find('count',array('conditions'=>$conditions,'order'=>$order)));
}

function notifications() 
{
$this->layout='blank';
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('notification');
$conditions=array('users' =>array('$in' => array($s_user_id)),'seen_users' =>array('$nin' => array($s_user_id)));
$order=array('notification.notification_id'=>'DESC');
$this->set('result_notification',$this->notification->find('all',array('conditions'=>$conditions,'order'=>$order)));

$this->loadmodel('notification');
$this->notification->updateAll(array('seen_users'=>1),array('user_id'=>$s_user_id));
}


function see_all_notifications() 
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('notification');
$conditions=array('users' =>array('$in' => array($s_user_id)),'seen_users' =>array('$nin' => array($s_user_id)));
$order=array('notification.notification_id'=>'DESC');
$this->set('result_notification',$this->notification->find('all',array('conditions'=>$conditions,'order'=>$order)));

$this->loadmodel('notification');
$this->notification->updateAll(array('seen_users'=>1),array('user_id'=>$s_user_id));
}

function send_notification($icon,$text,$module_id,$element_id,$url,$by_user,$users) 
{


$s_society_id=$this->Session->read('society_id');

$now=date('Y-m-d');
$seen=array();
$notification_id=$this->autoincrement('notification','notification_id');
$this->loadmodel('notification');
$this->notification->saveAll(array('notification_id' => $notification_id,'icon' => $icon,'module_id' => $module_id,'element_id' => $element_id,'text' => $text, 'url' =>$url, 'by_user' =>$by_user, 'users' =>$users, 'society_id' =>$s_society_id, 'date' =>$now,'seen_users'=>$seen));
}


function seen_notification($module_id,$element_id) 
{
	$module_id=(int)$module_id;
	$element_id=(int)$element_id;
	$s_society_id=$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');

	$this->loadmodel('notification');
	$conditions=array("module_id" => $module_id,"element_id" => $element_id);
	$notification_result=$this->notification->find('all', array('conditions' => $conditions));
	
	
	foreach($notification_result as $notification_result_data)
	{
		 $seen_users=@$notification_result_data['notification']['seen_users'];
	
	if(is_array($seen_users))	{  
	if(sizeof($seen_users)==0)	{ $seen_users=array(); }
	
	if (!in_array($s_user_id, $seen_users))
	{
	  
		if(sizeof($seen_users)==0)
		{
		$seen_users[]=$s_user_id;
		
		}
		else
		{
		$t=$s_user_id;
		array_push($seen_users,$t);
		}
		
		
		$this->notification->updateAll(array('seen_users'=>$seen_users),array('notification.module_id'=>$module_id,'notification.element_id'=>$element_id));
	}
	
	}
	}
	
	
}



function seen_alert($module_id,$element_id) 
{
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

	$this->loadmodel('alert');
	$conditions=array("module_id" => $module_id,"element_id" => $element_id);
	$alert_result=$this->alert->find('all', array('conditions' => $conditions));
	
	foreach($alert_result as $alert_result_data)
	{
		$seen_users=@$alert_result_data['alert']['seen_users'];
		
	if(sizeof($seen_users)==0)	{ $seen_users=array(); }
	
	if (!in_array($s_user_id, $seen_users))
	{
	
		if(sizeof($seen_users)==0)
		{
		$seen_users[]=$s_user_id;
		
		}
		else
		{
		$t=$s_user_id;
		array_push($seen_users,$t);
		}
		
		
		$this->alert->updateAll(array('seen_users'=>$seen_users),array('alert.module_id'=>$module_id,'alert.element_id'=>$element_id));
	}
	
	}
	
	
}

function recent_activities($icon,$by_user,$text,$url,$users,$module_id) 
{


$s_society_id=$this->Session->read('society_id');

$now=date('Y-m-d');

$activity_id=$this->autoincrement('activity','activity_id');
$this->loadmodel('activity');
$this->activity->saveAll(array('activity_id' => $activity_id,'icon' => $icon,'by_user' =>$by_user,'text' => $text, 'url' =>$url,'users' =>$users,'module_id' =>$module_id ,'society_id' =>$s_society_id, 'date' =>$now));
}

function alerts_count() 
{
$this->layout=null;
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('alert');
$conditions=array('users' =>array('$in' => array($s_user_id)),'seen_users' =>array('$nin' => array($s_user_id)));
$order=array('alert.alert_id'=>'DESC');
$this->set('result_alerts_count',$this->alert->find('count',array('conditions'=>$conditions,'order'=>$order)));
}

function alerts()
{
$this->layout=null;
 $s_society_id=$this->Session->read('society_id');
  $s_user_id=$this->Session->read('user_id');

date_default_timezone_set('Asia/Kolkata');	
$now=date('d-m-Y');
$now_for_search=date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));


$current_date_for_search = new MongoDate(strtotime($now_for_search)); 

////////////////notice//////////////////////////////////////
$this->loadmodel('notice');
$conditions=array("n_draft_id" => 0, "n_delete_id" => 0,"society_id"=> $s_society_id,'n_expire_date' => array('$gte'=>$current_date_for_search));
$notice_result=$this->notice->find('all',array('conditions'=>$conditions));

foreach($notice_result as $data1)
{
$notice_id=$data1['notice']['notice_id'];
$n_subject=$data1['notice']['n_subject'];

$visible_user_id=$data1['notice']['visible_user_id'];



$n_expire_date=$data1['notice']['n_expire_date'];
$n_expire_date= date('d-m-Y',$n_expire_date->sec);

$datediff = strtotime($n_expire_date) - strtotime($now);

$remening_days=floor($datediff/(60*60*24));

	if($remening_days<=15)
	{
	
	$this->loadmodel('alert');
	$conditions=array("module_id" => 2, "element_id" => $notice_id);
	$alert_result_count=$this->alert->find('count',array('conditions'=>$conditions));
	
		if($alert_result_count==0)
		{
		$this->send_alert('<span class="label label-info" ><i class="icon-bullhorn"></i></span>','Notice - <b>'.$n_subject.'</b> will expire on <b>'.$n_expire_date.'</b>',2,$notice_id,$this->webroot.'Notices/notice_publish_view/'.$notice_id,$visible_user_id);
		}
	
	}
}

////////////////notice//////////////////////////////////////


////////////////Events//////////////////////////////////////
$this->loadmodel('event');
$conditions=array("society_id"=> $s_society_id);
$result_event=$this->event->find('all',array('conditions'=>$conditions));

foreach($result_event as $data1)
{
$event_id=$data1['event']['event_id'];
$e_name=$data1['event']['e_name'];

$visible_user_id=$data1['event']['visible_user_id'];


$date_to=$data1['event']['date_to'];
$date_to= date('d-m-Y',$date_to->sec);

$datediff = strtotime($date_to) - strtotime($now);

$remening_days=floor($datediff/(60*60*24));

	if($remening_days<=3 and $remening_days>=0)
	{
	$this->loadmodel('alert');
	$conditions=array("module_id" => 6, "element_id" => $event_id);
	$alert_result_count=$this->alert->find('count',array('conditions'=>$conditions));
	
		if($alert_result_count==0)
		{
		$this->send_alert('<span class="label" style="background-color:#44b6ae;" ><i class="icon-gift"></i></span>','Event - <b>'.$e_name.'</b> will expire on <b>'.$date_to.'</b>',6,$event_id,$this->webroot.'Events/event_info/'.$event_id,$visible_user_id);
		}
	
	}
	if($remening_days<0)
	{
	$this->loadmodel('alert');
	$conditions=array("module_id" => 6, "element_id" => $event_id);
	$alert_result_count=$this->alert->find('count',array('conditions'=>$conditions));
	
		if($alert_result_count==0)
		{
		$this->send_alert('<span class="label" style="background-color:#44b6ae;" ><i class="icon-gift"></i></span>','Event - <b>'.$e_name.'</b> have been expired on <b>'.$date_to.'</b>',6,$event_id,$this->webroot.'Events/event_info/'.$event_id,$visible_user_id);
		}
	
	}

}

////////////////Events//////////////////////////////////////

////////////////Polls//////////////////////////////////////
$this->loadmodel('poll');
$conditions=array("society_id"=> $s_society_id);
$result_poll=$this->poll->find('all',array('conditions'=>$conditions));
foreach($result_poll as $data1)
{
  $poll_id=$data1['poll']['poll_id'];
  $question=$data1['poll']['question'];

@$visible_user_id=$data1['poll']['visible_user_id'];


$close_date=$data1['poll']['close_date'];
$close_date= date('d-m-Y',$close_date->sec);

$datediff = strtotime($close_date) - strtotime($now);

$remening_days=floor($datediff/(60*60*24));

	if(($remening_days<=3 or $remening_days<=7) and ($remening_days>=0))
	{
	$this->loadmodel('alert');
	$conditions=array("module_id" => 7, "element_id" => $poll_id);
	$alert_result_count=$this->alert->find('count',array('conditions'=>$conditions));
	
		if($alert_result_count==0)
		{
		$this->send_alert('<span class="label" style="background-color:#6d1b81;" ><i class="icon-question-sign"></i></span>','Voting for Poll - <b>'.$question.'</b> will close on <b>'.$close_date.'</b>',7,$poll_id,$this->webroot.'Polls/polls',$visible_user_id);
		}
	
	}
	if($remening_days<0)
	{
	$this->loadmodel('alert');
	$conditions=array("module_id" => 7, "element_id" => $poll_id);
	$alert_result_count=$this->alert->find('count',array('conditions'=>$conditions));
	
		if($alert_result_count==0)
		{
		$this->send_alert('<span class="label" style="background-color:#6d1b81;" ><i class="icon-question-sign"></i></span>','Voting for Poll - <b>'.$question.'</b> have been closed on <b>'.$close_date.'</b>',7,$poll_id,$this->webroot.'Polls/closed_polls',$visible_user_id);
		}
	
	}

}

////////////////Polls//////////////////////////////////////

////////////////profile incompleteness//////////////////////////////////////
$this->loadmodel('user');
$conditions=array("user_id"=> $s_user_id);
$result_user=$this->user->find('all',array('conditions'=>$conditions));
foreach ($result_user as $collection)   
{
$c_email = $collection['user']['email'];
$c_mobile = $collection['user']['mobile'];
$c_name = $collection['user']['user_name'];
@$profile_pic = $collection['user']['profile_pic'];
$c_sex = (int)@$collection['user']['sex'];
$c_wing_id = (int)$collection['user']['wing'];
 $c_flat_id = (int)$collection['user']['flat'];
$da_dob=@$collection['user']['dob'];
$per_address=@$collection['user']['per_address'];
$com_address=@$collection['user']['comm_address'];
$hobbies=@$collection['user']['hobbies'];
$private_field=@$collection['user']['private'];

}

$flat = $this->wing_flat($c_wing_id,$c_flat_id);

$ccc=0;
	if(!empty($c_email))
	{
		$ccc++;
	}
	if(!empty($c_mobile))
	{
		$ccc++;
	}
	if(!empty($c_name))
	{
		$ccc++;
	}
	if(!empty($profile_pic))
	{
		$ccc++;
	}
	if(!empty($c_sex))
	{
		$ccc++;
	}
	if(!empty($c_wing_id))
	{
		$ccc++;
	}
	if(!empty($c_flat_id))
	{
		$ccc++;
	}
	if(!empty($da_dob))
	{
		$ccc++;
	}
	if(!empty($per_address))
	{
		$ccc++;
	}
	if(!empty($com_address))
	{
		$ccc++;
	}
	if(!empty($hobbies))
	{
		$ccc++;
	}
$progres=$ccc*100/11;
$progres=round($progres);
$incomplete=100-$progres;

	if($incomplete!=100)
	{
	$this->loadmodel('alert');
	$conditions=array("module_id" => 101, "element_id" => $s_user_id);
	$alert_result_count=$this->alert->find('count',array('conditions'=>$conditions));

		if($alert_result_count==0)
		{
		$this->send_alert('<span class="label label-success"><i class="icon-user"></i></span>','Your Profile is <b>'.$incomplete.'%</b> incomplete',101,$s_user_id,$this->webroot.Hms.'/profile',array($s_user_id));
		}

	}

////////////////profile incompleteness//////////////////////////////////////


$this->loadmodel('alert');
$conditions=array('users' =>array('$in' => array($s_user_id)),'seen_users' =>array('$nin' => array($s_user_id)));
$order=array('alert.alert_id'=>'DESC');
$this->set('result_alerts',$this->alert->find('all',array('conditions'=>$conditions,'order'=>$order)));
}

function send_alert($icon,$text,$module_id,$element_id,$url,$users)
{
$this->layout='blank';

$s_society_id=$this->Session->read('society_id');

$now=date('Y-m-d');

$alert_id=$this->autoincrement('alert','alert_id');
$this->loadmodel('alert');
$this->alert->saveAll(array('alert_id' => $alert_id,'icon' => $icon,'module_id' => $module_id,'element_id' => $element_id,'text' => $text, 'url' =>$url, 'users' =>$users, 'society_id' =>$s_society_id, 'date' =>$now));
}


function index()
{
$ua=$this->Cookie->read('username');
$pa=$this->Cookie->read('password');
$this->set('bgColor',$ua);
$this->set('txtColor',$pa);
$this->layout='without_session';
$this->set('webroot_path',$this->webroot_path());



		$fb_user_name=@$this->request->query['aqazp2yd'];
		$uid=@$this->request->query['uid'];
		
		$source=@$this->request->query['source'];
		if(!empty($fb_user_name)){
			$fb_user_name=$this->decode($fb_user_name,'Housingmatters_facebook');
			
			$this->loadmodel('login');
			$conditions =array( '$or' => array(array("user_name" => $fb_user_name)));
			$result_login=$this->login->find('all',array('conditions'=>$conditions));
			$count=sizeof($result_login);
			if($count>0){
				foreach($result_login as $data)
				{
					 $login_id=(int)$data['login']['login_id'];
				}
				 
					 $this->loadmodel('user');
					 $conditions1=array('s_default'=>1,'login_id'=>$login_id,'deactive'=>0);
					 $result_user=$this->user->find('all',array('conditions'=>$conditions1));
					 $n=sizeof($result_user);
					 if($n>0)
					 {
						foreach($result_user as $data)
						{
						$user_id=$data['user']['user_id'];
						$society_id=$data['user']['society_id'];
						$user_name=$data['user']['user_name'];
						$wing=$data['user']['wing'];
						$tenant=$data['user']['tenant'];
						$role_id=$data['user']['default_role_id'];
						$profile=@$data['user']['profile_status'];
						$slide_show=@$data['user']['slide_show'];
						if($slide_show==2){
							$this->loadmodel('user');
							$this->user->updateAll(array('slide_show'=>0),array('user_id'=>$user_id));
						}
						}
						
						if(!empty($uid) && $source=="f"){
							$this->loadmodel('user');
							$this->user->updateAll(array("f_profile_pic" => "https://graph.facebook.com/".$uid."/picture"),array("user_id" => (int)$user_id));
						}
						if(!empty($uid) && $source=="g"){
							$this->loadmodel('user');
							$this->user->updateAll(array("g_profile_pic" => $uid),array("user_id" => (int)$user_id));
						}
						 
							date_default_timezone_set('Asia/kolkata');
							$date=date("d-m-Y");
							$time=date('h:i:a',time());
							$this->loadmodel('log');
							$i=$this->autoincrement('log','log_id');
							$this->log->save(array('log_id'=>$i,'user_id'=>$user_id,'society_id'=>$society_id,'date'=>$date,'time'=>$time,'status'=>0));
							$this->Session->write('user_id', $user_id);
							$this->Session->write('login_id', $login_id);
							$this->Session->write('role_id', $role_id);
							$this->Session->write('society_id', $society_id);
							$this->Session->write('user_name', $user_name);
							$this->Session->write('wing', $wing);
							$this->Session->write('tenant', $tenant);
							$this->redirect(array('action' => 'dashboard'));
						 
						
					 }
					
			}
			 else
					 {
						 if($source=="f"){
							 $this->set('wrong_fb', 'It seems you have not sign up with HousingMatters or your Facebook email is not matching with our system.'); 
						 }
						else{
							 $this->set('wrong_fb', 'It seems you have not sign up with HousingMatters or your Google email is not matching with our system.'); 
						 }
					 }
		}
	
if ($this->request->is('post')) 
{
	
	 $username=htmlentities($this->request->data["username"]);
	 $password=htmlentities($this->request->data["password"]);
	 $rememberme=htmlentities(@$this->request->data["rememberme"]);
		$this->loadmodel('login');
		$conditions =array( '$or' => array( 
		array("user_name" => $username, "password" => $password),
		array("mobile" => $username, "password" => $password),
		));
	 $result_login=$this->login->find('all',array('conditions'=>$conditions));
	 $count=sizeof($result_login);
	 if($count>0)
	 {
		 
			if($rememberme==1)
			{
			$this->Cookie->write('username',$username,3600);
			$this->Cookie->write('password',$password,3600);
			}
			else
			{
			$this->Cookie->delete('username');
			$this->Cookie->delete('password');
			}
		 
		 
		foreach($result_login as $data)
		{
			
			 //$da_society_id=(int)$data['login']['society_id'];
			 $login_id=(int)$data['login']['login_id'];
		}
		 
			 $this->loadmodel('user');
			 $conditions1=array('s_default'=>1,'login_id'=>$login_id,'deactive'=>0);
			 $result_user=$this->user->find('all',array('conditions'=>$conditions1));
			 $n=sizeof($result_user);
			 if($n>0)
			 {
				foreach($result_user as $data)
				{
				
				$user_id=$data['user']['user_id'];
				$society_id=$data['user']['society_id'];
				$user_name=$data['user']['user_name'];
				$wing=$data['user']['wing'];
				$tenant=$data['user']['tenant'];
				$role_id=$data['user']['default_role_id'];
				$profile=@$data['user']['profile_status'];
				$slide_show=@$data['user']['slide_show'];
					if($slide_show==2){
						$this->loadmodel('user');
						$this->user->updateAll(array('slide_show'=>0),array('user_id'=>$user_id));
					}
				}
				 
					$this->loadmodel('user');
					$conditions5=array('signup_random'=>$password);
					$res_n=$this->user->find('all',array('conditions'=>$conditions5));
					$result_no=sizeof($res_n);
					if($result_no>0){
						$de_user_id=$this->encode($user_id,'housingmatters');
						$random=$de_user_id.'/'.$password;
						$this->response->header('Location', $this->webroot.'hms/set_new_password?q='.$random.' ');
					}
					else{
						
					date_default_timezone_set('Asia/kolkata');
					$date=date("d-m-Y");
					$time=date('h:i:a',time());
					$this->loadmodel('log');
					$i=$this->autoincrement('log','log_id');
					$this->log->save(array('log_id'=>$i,'user_id'=>$user_id,'society_id'=>$society_id,'date'=>$date,'time'=>$time,'status'=>0));
				    $this->Session->write('user_id', $user_id);
					$this->Session->write('login_id', $login_id);
					$this->Session->write('role_id', $role_id);
					$this->Session->write('society_id', $society_id);
					$this->Session->write('user_name', $user_name);
					$this->Session->write('wing', $wing);
					$this->Session->write('tenant', $tenant);
					
					 $next=@$this->request->query['next']; 
					if(!empty($next)){
						//$this->redirect(array('action' => $next));
						//$this->redirect(array('controller' => 'Hms','action' => 'dashboard'));
						$this->response->header('Location', $next);
					}else{
						$this->redirect(array('action' => 'dashboard'));
					}
					
				 
				 	}
				
				 
				 
			 }
			 else
			 {
				$this->set('wrong', 'Username and Password are Incorrect'); 
			 }
	 }
	 else
	 {
		$this->loadmodel('login');
		$condition3=array('user_name'=>$username);
		$result_login1=$this->login->find('all',array('conditions'=>$condition3));
		$res_n=sizeof($result_login1);
		if($res_n>0)
		{
			$this->set('wrong', 'Password is Incorrect');
		}
		else
		{
			$this->loadmodel('login');
		    $condition4=array('password'=>$password);
		    $result_login2=$this->login->find('all',array('conditions'=>$condition4));
		    $res_n1=sizeof($result_login2);
				if($res_n1>0)
				{
				$this->set('wrong', 'Username is Incorrect');
				
				}
				else
				{
					$this->set('wrong', 'Username and Password are Incorrect');
					
				}
			
		}
	 }
	 
	
}
	
}
function login_user_id($login_id)
{
	$this->loadmodel('user');
	$conditions=array('login_id'=>$login_id);
	return $this->user->find('all',array('conditions'=>$conditions));
	
}


function index23() 
{	
$ua=$this->Cookie->read('username');
$pa=$this->Cookie->read('password');
$this->set('bgColor',$ua);
$this->set('txtColor',$pa);
$this->layout='without_session';
if ($this->request->is('post')) 
{
 $username=htmlentities($this->request->data["username"]);
 $password=htmlentities($this->request->data["password"]);
$rememberme=htmlentities(@$this->request->data["rememberme"]);
$this->loadmodel('user');
$conditions =array( '$or' => array( 
array("email" => $username, "password" => $password,'deactive'=>0),
array("mobile" => $username, "password" => $password,'deactive'=>0),
));
$result = $this->user->find('all',array('conditions'=>$conditions));
$n = sizeof($result);

if($n>0)
{
if($rememberme==1)
{
$this->Cookie->write('username',$username,3600);
$this->Cookie->write('password',$password,3600);
}
else
{
$this->Cookie->delete('username');
$this->Cookie->delete('password');
}
foreach($result as $data)
{
	
$user_id=$data['user']['user_id'];
$society_id=$data['user']['society_id'];
$user_name=$data['user']['user_name'];
$wing=$data['user']['wing'];
$tenant=$data['user']['tenant'];
$role_id=$data['user']['default_role_id'];
$profile=@$data['user']['profile_status'];
}

$this->loadmodel('user');
$conditions5=array('signup_random'=>$password);
$res_n=$this->user->find('all',array('conditions'=>$conditions5));
$result_no=sizeof($res_n);
if($result_no>0)
{
	$de_user_id=$this->encode($user_id,'housingmatters');
	$random=$de_user_id.'/'.$password;
	$this->response->header('Location', $this->webroot.'hms/set_new_password?q='.$random.' ');
}
else
{
$this->loadmodel('user');
if($profile==2)
{
$conditions =array( '$or' => array( 
array("email" => $username, "password" => $password,"profile_status" =>2),
array("mobile" => $username, "password" => $password,"profile_status" =>2),
));
}
else
{
$conditions =array( '$or' => array( 
array("email" => $username, "password" => $password,"profile_status" =>1),
array("mobile" => $username, "password" => $password,"profile_status" =>1),
));	
}
$result = $this->user->find('all',array('conditions'=>$conditions));
$pro = sizeof($result);
if($pro==0)
{
$this->loadmodel('user');
$this->user->updateAll(array('profile_status'=>1),array('user_id'=>$user_id));
}
else
{
$this->loadmodel('user');
$this->user->updateAll(array('profile_status'=>2),array('user_id'=>$user_id));
}

date_default_timezone_set('Asia/kolkata');
$date=date("d-m-Y");
$time=date('h:i:a',time());
$this->loadmodel('log');
$i=$this->autoincrement('log','log_id');
$this->log->save(array('log_id'=>$i,'user_id'=>$user_id,'society_id'=>$society_id,'date'=>$date,'time'=>$time,'status'=>0));
$this->Session->write('user_id', $user_id);
$this->Session->write('role_id', $role_id);

$this->Session->write('society_id', $society_id);
$this->Session->write('user_name', $user_name);
$this->Session->write('wing', $wing);
$this->Session->write('tenant', $tenant);
$this->redirect(array('action' => 'dashboard'));
}
}
else
{
$this->loadmodel('user');
$conditions =array( '$or' => array( 
array("email" => $username, 'deactive'=>0),
array("mobile" => $username, 'deactive'=>0),
));
$result1 = $this->user->find('all',array('conditions'=>$conditions));
$n1 = sizeof($result1);
if($n1>0)
{ 
$this->set('wrong', 'Password is Incorrect');
}
else
{
$this->loadmodel('user');
$conditions=array("password" => $password,'deactive'=>0);
$result2 = $this->user->find('all',array('conditions'=>$conditions));
$n2 = sizeof($result2);
if($n2>0)
{ 
$this->set('wrong', 'Username is Incorrect');
}
else
{
$this->set('wrong', 'Username and Password are Incorrect');
}
}
}
}
}

function sign_up()
{
$this->layout='without_session';
App::import('', 'sendsms.php');
$this->set('webroot_path',$this->webroot_path());
if ($this->request->is('POST')) 
{


date_default_timezone_set('Asia/kolkata');
$date=date("d-m-Y");
$time=date('h:i:a',time());
$name=htmlentities($this->request->data['name']);
$email=htmlentities($this->request->data['email']);
$mobile=htmlentities($this->request->data['mobile']);
$i=$this->autoincrement('user_temp','user_temp_id');
$this->loadmodel('user_temp');
$this->user_temp->save(array('user_temp_id' => $i, 'user_name' => $name,'email' => $email, 'password' => '', 'mobile' => $mobile,  'society_id' => 0, 'role' => 0, 'committee' => 2 , 'tenant' => 1, 'wing' => 0, 'flat' => 0,'residing' => 1,'complete_signup' => 0 , 'reply_mail' => "", 'date' => $date, 'time' => $time,'reject' =>0 ));
$this->response->header('Location', 'sign_up_next?user='.$i.' ');


}
}




function sign_up_next()
{
$this->layout='without_session';
$this->set('webroot_path',$this->webroot_path());	
$user=$this->request->query['user'];
$this->set('user', $user);
}

/////////////////////////////////////////// Start Resident Signup //////////////////////////////////////////////////

function resident_signup()
{
$this->layout='without_session';
$this->set('webroot_path',$this->webroot_path());
$user=(int)$this->request->query['user'];
$this->set('user_id', $user);
$this->loadmodel('society');
$this->set('result', $this->society->find('all'));
		if($this->request->is('post')) 
		{
		@$ip=$this->hms_email_ip();
		$society_id=(int)$this->request->data['society'];
		$tenant=(int)$this->request->data['tenant'];
		if($tenant==1)
		{
		$committe=(int)$this->request->data['committe'];
		}
			else
			{
			$committe=2;
			}
	$wing=(int)$this->request->data['wing'];
	$flat=(int)$this->request->data['flat'];
	
	
//$residing=(int)$this->request->data['residing'];
$this->loadmodel('user_temp');
$this->user_temp->updateAll(array("society_id" => $society_id,"committee" => $committe, 
'tenant' => $tenant, 'wing' => $wing, 'flat' => $flat,"role"=>2,"complete_signup"=>1,'multiple_society'=>0),array("user_temp.user_temp_id" => $user));


$this->loadmodel('user_temp');
$conditions=array("user_temp_id" => $user);
$result_user=$this->user_temp->find('all',array('conditions'=>$conditions));

foreach($result_user as $data1)
{
$user_name_post=$data1['user_temp']['user_name'];
}
$wing_flat=$this->wing_flat($wing,$flat);

$this->loadmodel('user');
$conditions=array("society_id" => $society_id,'role_id' =>array('$in' => array(3)));
$result_user_admin=$this->user->find('all',array('conditions'=>$conditions));
foreach($result_user_admin as $data2)
{
$admin_user_id[]=$data2['user']['user_id'];
}

//$this->send_alert('<span class="label label-success"><i class="icon-user"></i></span>','New sign up by '.$user_name_post.' '.$wing_flat.' is pending for action in Resident Approve in Admin tab.','resident_approve',$admin_user_id);

//$this->send_notification('<span class="label label-success" ><i class="icon-user"></i></span>','New User <b>'.$user_name_post.' '.$wing_flat.'</b> awaiting your approval/action',100,$user,'resident_approve',0,$admin_user_id);
////////////////////////////////// mail functionality //////////////////////////////////////////////////////////////////////
$this->loadmodel('society');
$conditions=array("society_id" => $society_id);
$result_society = $this->society->find('all',array('conditions'=>$conditions));
foreach ($result_society as $collection) 
{
$user_id=$collection['society']['user_id'];
$society_name3=$collection['society']['society_name'];
}
$this->loadmodel('user');
$conditions=array("user_id" => $user_id);
$result_user = $this->user->find('all',array('conditions'=>$conditions));
foreach ($result_user as $collection) 
{
$email=$collection['user']['email'];
$mobile=$collection['user']['mobile'];
}
$this->loadmodel('user_temp');
$conditions=array("user_temp_id" => $user);
$result_user_temp = $this->user_temp->find('all',array('conditions'=>$conditions));
foreach ($result_user_temp as $collection) 
{
$mobile1=$collection['user_temp']['mobile'];
$user_name1=$collection['user_temp']['user_name'];
}
$this->loadmodel('wing');
$conditions=array("wing_id" => $wing);
$result_wing = $this->wing->find('all',array('conditions'=>$conditions));
foreach ($result_wing as $collection) 
{
$wing_name=$collection['wing']['wing_name'];
}
$this->loadmodel('wing');
$conditions=array("wing_id" => $wing);
$result_wing = $this->wing->find('all',array('conditions'=>$conditions));
foreach ($result_wing as $collection) 
{
$wing_name=$collection['wing']['wing_name'];
}
$this->loadmodel('flat');
$conditions=array("flat_id" => $flat);
$result_flat = $this->flat->find('all',array('conditions'=>$conditions));
foreach ($result_flat as $collection) 
{
$flat_name=$collection['flat']['flat_name'];
}
$wing_flat = $wing_name.'-'.$flat_name;

$r_sms=$this->hms_sms_ip();
$working_key=$r_sms->working_key;
$sms_sender=$r_sms->sms_sender; 
$sms_allow=(int)$r_sms->sms_allow;


$z=1;
if($z==1)
{
if($tenant==1)
{
$owner="Yes";
}
else
{
$owner="No";
}

if($tenant==1)
{
$tenant="Owner";
}
else
{
$tenant="Tenant";
}

if($sms_allow==1){
	
$user_name_short=$this->check_charecter_name($user_name1);
	
$sms='Hello!+New+User+request+:+'.$user_name_short.'+'.$wing_flat.'+'.$tenant.'+Please+log+into+HousingMatters+for+further+action.';
$sms1=str_replace(' ', '+', $sms);
$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms1.'');
}

$to=$email;

 /* $message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>

</br><p>Dear Administrator,</p>
One new user request in your society has been received for your approval.<br/><br/>
<table  cellpadding='10' width='100%;' border='1' bordercolor='#e1e1e1'  >
<tr class='tr_heading' style='background-color:#00A0E3;color:white;'>
<td>Flat</td>
<td>Name</td>
<td>Mobile</td>
<td>Owner</td>
</tr>
<tr class='tr_content' style=background-color:#E9E9E9;'>
<td>$wing_flat</td>
<td>$user_name1</td>
<td>$mobile1</td>
<td>$owner</td>
</tr>
</table>
<div>
<p>Kindly log into <a href='http://www.housingmatters.co.in'> HousingMatters portal </a> and review </p>
<p>the request under 'Admin -> Resident Approve' for further action at your end.</p><br/>
For any assistance, please email us on support@housingmatters.in<br/><br/>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.co.in
</div >
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
										<span style="color:rgb(100,100,99)" align="justify"> Dear Administrator, </span> <br>
										</td>
								
								
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)">One new user request in your society has been received for your approval. </span>
									</td>
																
								</tr>
								
								
								<tr>
									<td>
									
										<table  cellpadding="5" cellspacing="0" width="100%;"border="1" style="border:1px solid #e5e5e5;">
						
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" width="200" >Flat</td>
										<td align="left" style="background-color:#f8f8f8;" width="600" >'.$wing_flat.'</td>
										</tr>
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Name</td>
										<td align="left" style="background-color:#f8f8f8;" >'.$user_name1.'</td>
										</tr>
										
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Mobile</td>
										<td align="left" style="background-color:#f8f8f8;" >'.$mobile1.'</td>
										</tr>
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Owner</td>
										<td align="left" style="background-color:#f8f8f8;" >'.$owner.'</td>
										</tr>
									
										</table> 
									
									</td>
								
								
								
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> <p>Kindly log into <a href="http://www.housingmatters.co.in"> HousingMatters portal </a> and review </p>
											<p>the request under " Admin -> Resident Approve " for further action at your end.</p>
											<p>For any assistance, please email us on support@housingmatters.in</p>
											</span>
									</td>
																
								</tr>
					
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> 
												Thank you.<br/>
												HousingMatters (Support Team)<br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>

								

					
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';
		






$from_name="HousingMatters";
$reply="support@housingmatters.in";
$this->loadmodel('email');
$conditions=array("auto_id" => 4);
$result_email = $this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
}
$subject="[$society_name3]-New User Request for approval";
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$z++;			
}


if($z==2)
{

$this->loadmodel('user_temp');
$conditions=array("user_temp_id" => $user);
$result_user_temp = $this->user_temp->find('all',array('conditions'=>$conditions));
foreach ($result_user_temp as $collection) 
{
$email1=$collection['user_temp']['email'];
$user_name=$collection['user_temp']['user_name'];
$mobile1=$collection['user_temp']['mobile'];
}

$dd=explode(' ',$user_name);
$user_name1=$dd[0];
$user_name1=ucfirst($user_name1);
$to=$email1;
  /* $message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Hi $user_name1,</p>
<p>Thank for Signing up with Housing Matters. Your Application is under review. We will get back to you with further details within 24 Hrs.</p>
To know more about Housing Matters, <a href='http://www.housingmatters.co.in'>Click here</a>
<p>For any assistance, Email us on support@housingmatters.in</p><br/>
Thank you<br/>
HousingMatters (Support Team)<br/>
www.housingmatters.co.in
</div >
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
										<span style="color:rgb(100,100,99)" align="justify">Hi '.$user_name1.', </span> <br>
										</td>
								
								
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> <p align="justify">Thank for Signing up with Housing Matters. Your Application is under review. We will get back to you with further details within 24 Hrs.</p> </span>
									</td>
																
								</tr>
								
								

								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> <p align="justify">To know more about Housing Matters, <a href="http://www.housingmatters.co.in">Click here</a></p>
											<p>For any assistance, Email us on support@housingmatters.in</p>
											</span>
									</td>
																
								</tr>
					
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> 
												Thank you.<br/>
												HousingMatters (Support Team)<br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>

								

					
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';
	
	
$from_name="HousingMatters";
$reply="support@housingmatters.in";

$this->loadmodel('email');
$conditions=array("auto_id" => 4);
$result_email = $this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
}
$subject="Lets get going with setting up your society and Housing Matters";
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		


	
$this->response->header('Location', 'r_ack');



}
}





function r_ack()
{
$this->layout='without_session';	
}

function society_signup()
{
App::import('', 'sendsms.php');
App::import('phpmailer', 'mail.php');
$this->layout='without_session';
$this->set('webroot_path',$this->webroot_path());	
$user=(int)$this->request->query['user'];
$this->set('user_id', $user);
if($this->request->is('post')) 
{
	@$ip=$this->hms_email_ip();

$society_name=htmlentities($this->request->data['society_name']);
$pin_code=htmlentities($this->request->data['pin_code']);
$association=htmlentities($this->request->data['association']);
$no_flat=htmlentities($this->request->data['no_flat']);
$i=$this->autoincrement('society','society_id');

$this->loadmodel('society');
$this->society->save(array('society_id' => $i, 'society_name' => $society_name, 
'association_formed' => $association, 'user_id' => $user,"aprvl_status"=>0,"pin_code"=>$pin_code,"flats"=>$no_flat));
$this->loadmodel('user_temp');
$this->user_temp->updateAll(array("society_id" => $i,"role" => 3,"complete_signup"=>1),array("user_temp.user_temp_id" => $user));

//////////////////////mail functionality//////////////////////////////////////////////////////////////////////////////////////////


$z=1;
if($z==1)
{

$this->loadmodel('user');
$conditions=array("society_id" => 0);
$result2 = $this->user->find('all',array('conditions'=>$conditions));
foreach ($result2 as $collection) 
{
$mobile=$collection['user']['mobile'];
}
////////////////////////////// Sms functionality ////////////////////////////////////////////////////////////	

$r=$this->hms_sms_ip();
$working_key=$r->working_key;
$sms_sender=$r->sms_sender; 
$sms_allow=(int)$r->sms_allow;
if($sms_allow==1){
$sms='New Request for Society registration into HousingMatters. Kindly approve the request.';
$sms1=str_replace(' ', '+', $sms);
$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms1.'');
}
////////////////////////////////////////// ////////////////////////////////////////////////////// ///////////////////////////////////////////////////////////// ////		
$to="admin@housingmatters.in";
$reply="support@housingmatters.in";

/*
$message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
<br/>New Request for Society registration into HousingMatters. Kindly approve the request.<br/>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.co.in
</div >

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
										<span style="color:rgb(100,100,99)" align="justify"> <p align="justify"> New Request for Society registration into HousingMatters. Kindly approve the request. </p> </span> 
										</td>
								
								
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> 
												Thank you.<br/>
												HousingMatters (Support Team)<br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';



$from_name="HousingMatters";

$this->loadmodel('email');
$conditions=array("auto_id" => 4);
$result_email = $this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
$sub=$collection['email']['subject'];
}

$subject='New Society  Set up in HousingMatters:   [' . $society_name . ']';
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$z++;
}

if($z==2)
{
$this->loadmodel('user_temp');
$conditions=array("user_temp_id" => $user);
$result_user_temp = $this->user_temp->find('all',array('conditions'=>$conditions));
foreach ($result_user_temp as $collection) 
{
$email=$collection['user_temp']['email'];
$mobile1=$collection['user_temp']['mobile'];
}
$to=$email;


 /* $message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
<br/>We have received your application.<br/>
We will review and get back to you in 24 Hours. <br/>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.co.in
</div >

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
										<span style="color:rgb(100,100,99)" align="justify"> <p align="justify"> We have received your application. <br/> We will review and get back to you in 24 Hours. </p> </span> 
										</td>
								
								
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> 
												Thank you.<br/>
												HousingMatters (Support Team)<br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';
	
	
$from_name="HousingMatters";
$this->loadmodel('email');
$conditions=array("auto_id" => 4);
$result1_email = $this->email->find('all',array('conditions'=>$conditions));
foreach ($result1_email as $collection) 
{
$from=$collection['email']['from'];
$sub=$collection['email']['subject'];
}
$reply="support@housingmatters.in";
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
$this->response->header('Location', 'r_ack');

}
}


function resident_signup_ajax()
{
$this->layout='blank';	
$so_id=(int)$this->request->query['con1'];
$this->loadmodel('wing');
$conditions=array("society_id" => $so_id);
$result = $this->wing->find('all',array('conditions'=>$conditions));
$this->set('result3',$result);
}


function resident_signup_wing_flat_ajax()
{
$this->layout='blank';	
$wing_id=(int)$this->request->query['con2'];
$this->loadmodel('flat');
$conditions=array("wing_id" => $wing_id);
$result = $this->flat->find('all',array('conditions'=>$conditions));
$this->set('result3',$result);
}


function fix_deposit_count_via_maturity_date($from,$to)
{
$s_user_id=$this->Session->read('user_id');
$s_society_id= (int)$this->Session->read('society_id');
$this->ath();


$this->loadmodel('fix_deposit');
$conditions=array("society_id" =>$s_society_id,"matured_status"=>1,'fix_deposit.maturity_date'=>array('$gte'=>$from,'$lte'=>$to));
return $this->fix_deposit->find('all',array('conditions'=>$conditions));
}


function return_flat_via_wing_id()
{
$this->layout='blank';	
$wing_id=(int)$this->request->query['con2'];
$i=(int)$this->request->query['con1'];
$this->set('i',$i);
$this->loadmodel('flat');
$conditions=array("wing_id" => $wing_id);
$result = $this->flat->find('all',array('conditions'=>$conditions));
$this->set('result3',$result);
}

function return_flat_via_wing_id3()
{
$this->layout='blank';	
$wing_id=(int)$this->request->query['con2'];
$i=(int)$this->request->query['con1'];
$this->set('i',$i);
$this->loadmodel('flat');
$conditions=array("wing_id" => $wing_id);
$result = $this->flat->find('all',array('conditions'=>$conditions));
$this->set('result3',$result);
}

function flat_already_exits()
{
$this->layout='blank_signup';
//$flat=(int)$this->request->query['flat'];
$society=(int)$this->request->data['society'];
$flat=(int)$this->request->data['flat'];
$tenant_fetch=(int)$this->request->data['tenant'];
$this->loadmodel('user_flat');
$conditions=array("flat_id" => $flat,'society_id'=>$society,'active'=>0,'family_member'=>array('$ne'=>1));
$result4 = $this->user_flat->find('all',array('conditions'=>$conditions));
$n4 = sizeof($result4);

if($n4==0){
	
	echo'true';
	
}elseif($n4==1){
	
	foreach($result4 as $data){
		
		$database_tenat=$data['user_flat']['status'];
		if($database_tenat==1){
			
			if($tenant_fetch==$database_tenat){
				
				echo'false';
				
			}else{
				echo'true';
				
			}
			
			
		}else{
			
			if($tenant_fetch==$database_tenat){
				
				echo'false';
				
			}else{
				
				echo'true';
				
			}
			
			
		}
		
	}
		
}elseif($n4==2){
	
	echo'false';
	
}
	



/*$n4 = sizeof($result4);
$e=$n4;
if ($tenant_fetch==1) {
echo "true";
} else {
echo "false";
} */
}


function signup_emilexits()
{
$this->layout='blank_signup';
$email=$this->request->query['email'];
$this->loadmodel('user_temp');
$conditions=array("email" => $email,'reject'=>0);
$result3 = $this->user_temp->find('all',array('conditions'=>$conditions));
$n3 = sizeof($result3);
$this->loadmodel('user');
$conditions=array("email" => $email);
$result4 = $this->user->find('all',array('conditions'=>$conditions));
$n4 = sizeof($result4);
$e=$n3+$n4;
if ($e > 0) {
echo "false";
} else {
echo "true";
}
}

function signup_mobileexit()
{
$this->layout='blank_signup';
$mobile=$this->request->query['mobile'];
$this->loadmodel('user_temp');
$conditions=array("mobile" => $mobile,'reject'=>0);
$result3 = $this->user_temp->find('all',array('conditions'=>$conditions));
$n3 = sizeof($result3);
$this->loadmodel('user');
$conditions=array("mobile" => $mobile,"user_id"=>array('$ne'=>1));
$result4 = $this->user->find('all',array('conditions'=>$conditions));
$n4 = sizeof($result4);
$e=$n4;

if ($e > 0) {
echo "false";
} else {
echo "true";
}
}

function profile_mobile_check()
{
$this->layout='blank_signup';
$s_user_id=$this->Session->read('user_id');	
$mobile=$this->request->query['mobile1'];

$this->loadmodel('user');
$conditions=array("mobile" => $mobile,'user_id'=>$s_user_id);
$result4 = $this->user->find('all',array('conditions'=>$conditions));
$n4 = sizeof($result4);
$e=$n4;
if ($e > 0) {
echo "true";
} else {
		$this->loadmodel('user_temp');
		$conditions=array("mobile" => $mobile,'reject'=>0);
		$result3 = $this->user_temp->find('all',array('conditions'=>$conditions));
		$n3 = sizeof($result3);
		$this->loadmodel('user');
		$conditions=array("mobile" => $mobile);
		$result4 = $this->user->find('all',array('conditions'=>$conditions));
		$n4 = sizeof($result4);
		$e=$n3+$n4;

		if ($e > 0) {
		echo"false";
		} else {
		echo"true";
		}
	
}	



	
}



function profile_email_check()
{
$this->layout='blank_signup';
$s_user_id=$this->Session->read('user_id');
$email=$this->request->query['email'];
$this->loadmodel('user');
$conditions=array("email" => $email,'user_id'=>$s_user_id);
$result4 = $this->user->find('all',array('conditions'=>$conditions));
$n4 = sizeof($result4);
$e=$n4;
if ($e > 0) {
echo "true";
} else {

		$this->loadmodel('user_temp');
		$conditions=array("email" => $email,'reject'=>0);
		$result3 = $this->user_temp->find('all',array('conditions'=>$conditions));
		$n3 = sizeof($result3);
		$this->loadmodel('user');
		$conditions=array("email" => $email);
		$result4 = $this->user->find('all',array('conditions'=>$conditions));
		$n5 = sizeof($result4);	
		$e1=$n3+$n5;
		if ($e1 > 0) {
		echo "false";
		} else {
		echo "true";	
		}

		}
}




function forget() 
{
$this->layout='without_session';
$this->set('webroot_path',$this->webroot_path());
if ($this->request->is('POST')) 
{
$ip=$this->hms_email_ip();
$to=$this->request->data['email'];
$this->loadmodel('user');
$conditions=array("email" => $to);
$result3 = $this->user->find('all',array('conditions'=>$conditions));
foreach($result3 as $collection)
{
$username=$collection['user']['user_name'];

$wing_id=$collection['user']['wing'];
$flat_id=$collection['user']['flat'];

$society_id=$collection['user']['society_id'];
}
$result_society=$this->society_name($society_id);
$society_name=$result_society[0]['society']['society_name'];
$wing_flat=$this->wing_flat($wing_id,$flat_id);
$n = sizeof($result3);
if($n>0)
{ 
$random=mt_rand(10000,99999);
$this->loadmodel('user');
$this->user->updateAll(array('password'=>$random),array('user.email'=>$to));
$from_name="HousingMatters Support Team";
 $subject="[".$society_name."] OTP for password reset";

/* $message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
<br/>
<p>Hello $username,<br/>
It seems that you or someone requested a new password for you.
</p>
<p>We have generated a new password, as per requested:</p>
<br/><b> Username: </b> = $to<br/>
<b>Your new password:</b> = $random <br/><br/>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.co.in
</div >

</div>"; */




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
								<span style="color:rgb(100,100,99)" align="justify"> Hello '.$username.' '.$wing_flat.', </span> 
								</td>
																
								</tr>
								
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span style="color:rgb(100,100,99)" align="justify">It seems that you or someone requested to reset your login password. </span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span style="color:rgb(100,100,99)" align="justify">We have generated a One Time Password (OTP). </span> 
										</td>
																
								</tr>
								
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span style="color:rgb(100,100,99)" align="justify">
										<b> Username: </b> = '.$to.'<br/>
										<b>Your OTP to reset your password </b> = '.$random.'  </span> 
										</td>
																
								</tr>

								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> 
												Thank you.<br/>
												HousingMatters (Support Team)<br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';

$this->loadmodel('email');
$conditions=array('auto_id'=>4);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
}
$reply=$from;
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$this->response->header('Location', 'verification?con='.$to.' ');
}
else
{ 
$this->set('wrong','This Email is not exist');

}

}

}



function verification() 
{
$this->layout='without_session';
$this->set('webroot_path',$this->webroot_path());
$emil=$this->request->query['con'];
$this->set('webroot_path',$this->webroot_path());
if ($this->request->is('POST')) 
{
$verification=(int)$this->request->data['email'];
$this->loadmodel('user');
$conditions=array('email'=> $emil,"password"=>$verification);
$result_user=$this->user->find('all',array('conditions'=>$conditions));
$n= sizeof($result_user);
if($n>0)
{
$this->response->header('Location', $this->webroot.'hms/change_password?con='.$emil.' ');

}
else
{
$this->set('wrong','This verification is not exist');
}

}

}




function change_password() 
{
$this->layout='without_session';
$emil=$this->request->query['con'];
$this->set('webroot_path',$this->webroot_path());
if ($this->request->is('POST')) 
{
$pass=$this->request->data['pass'];
$this->loadmodel('user');
$conditions=array('email'=> $emil);
$result_user=$this->user->find('all',array('conditions'=>$conditions));
$n= sizeof($result_user);
if($n>0)
{ 
foreach ($result_user as $collection) 
{
$user_id=$collection['user']["user_id"];
$society_id=$collection['user']["society_id"];
$user_name=$collection['user']["user_name"];
$role_id=$collection['user']["default_role_id"];
}
$this->Session->write('user_id', $user_id);
$this->Session->write('role_id', $role_id);
$this->Session->write('society_id', $society_id);
$this->Session->write('user_name', $user_name);
$this->loadmodel('user');
$this->user->updateAll(array('password'=>$pass),array('user.email'=>$emil));
$this->redirect(array('action' => 'dashboard'));
}

}
}


function dashboard2() 
{
Configure::version();

if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
}

function role_security_dashboard($scoiety_id,$role_id,$module_id){
	
	$this->loadmodel('role_privilege');
	$conditions=array("society_id"=>$scoiety_id,"role_id"=>$role_id,"module_id"=>$module_id);
	return $this->role_privilege->find('all',array('conditions'=>$conditions));
	
}

function role_security_dashboard_sub($scoiety_id,$role_id,$module_id,$sub_module_id){
	
	$this->loadmodel('role_privilege');
	$conditions=array("society_id"=>$scoiety_id,"role_id"=>$role_id,"module_id"=>$module_id,'sub_module_id'=>$sub_module_id);
	return $this->role_privilege->find('all',array('conditions'=>$conditions));
	
}
	
function tenant_access(){ 
	
	$this->layout='without_session';	
	
}
function dashboard() 
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	
	$s_society_id = $this->Session->read('society_id');
	/*$this->loadmodel('flat');
	$conditions=array("society_id" => $s_society_id);
	$result_flat = $this->flat->find('all',array('conditions'=>$conditions));
	foreach($result_flat as $data){
		$flat_id=(int)$data["flat"]["flat_id"];
		$flat_name=$data["flat"]["flat_name"];
		
		$this->loadmodel('flat');
		$this->flat->updateAll(array("flat_name" => (int)$flat_name),array("flat_id" => $flat_id));
	}*/
	
	//echo "hello";
	//exit;
	//$sms='You one Product is liked by some one. Kindly login into the portal for more details.';
	//$sms1=str_replace(" ", '+', $sms);
	//echo file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey=Ac47f5663efae985cc42d0081ef8e95b7&sender=NMINVT&to=9636653883&message='.$sms1);
	//exit;
	

$this->ath();
$r=$this->request->query('try');
$s_user_id=$this->Session->read('user_id');
$s_society_id=$this->Session->read('society_id');
$this->response->disableCache();


	/*
	$result_society=$this->society_name($s_society_id);
	$access_tenant=@$result_society[0]['society']['access_tenant'];
	$result_user=$this->profile_picture($s_user_id);
    $tenant=@$result_user[0]['user']['tenant'];
	if($tenant==2 && $access_tenant==0){
		$this->redirect(array('action' => 'tenant_access'));

	 }
*/

$tenant=$this->Session->read('tenant');
$role_id=$this->Session->read('role_id');
$this->set('role_id',$role_id);
$this->set('s_society_id',$s_society_id);

$wing=$this->Session->read('wing');


$current_date = new MongoDate(strtotime(date("Y-m-d")));


if(!empty($r))
{
$this->loadmodel('user');
$this->user->updateAll(array('profile_status'=>2),array('user_id'=>$s_user_id));
$this->redirect(array('action' => 'dashboard'));
}
$this->loadmodel('user');
$conditions=array("user_id" => $s_user_id);
$this->set('result_user',$this->user->find('all',array('conditions'=>$conditions))); 

//////////////recent activity/////////////////
$this->loadmodel('activity');
$conditions=array("module_id" => 1,"society_id" => $s_society_id);
$this->set('result_activity',$this->activity->find('all',array('conditions'=>$conditions)));
//////////////recent activity///////////////// 


//////////////Help-desk  last 3 tickets///////////////// 
$this->loadmodel('help_desk');
if($role_id==3) { 
$conditions=array("society_id" => $s_society_id);
}

if($role_id!=3) { 
$conditions=array("society_id" => $s_society_id,"user_id" => $s_user_id);
}

$order=array('help_desk.ticket_id'=> 'DESC');
$result_help_desk=$this->help_desk->find('all',array('conditions'=>$conditions,'order' =>$order,'limit' =>3));
$this->set('result_help_desk',$result_help_desk);
//////////////Help-desk  last 3 tickets///////////////// 

//////////////discussion  last 3 topic///////////////// 
$this->loadmodel('discussion_post');
$conditions =array( '$or' => array( 
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>1),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>2,'sub_visible' =>array('$in' => array($role_id))),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>3,'sub_visible' =>array('$in' => array($wing))),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>4),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>5)
));
$order=array('discussion_post.discussion_post_id'=>'DESC');
$this->set('result_discussion_topics',$this->discussion_post->find('all',array('conditions'=>$conditions,'order'=>$order,'limit' =>3)));
//////////////discussion  last 3 topic///////////////// 


//////////////event  last 3///////////////// 
$this->loadmodel('event');
$conditions=array("society_id" => $s_society_id,"visible_user_id" =>array('$in' => array($s_user_id)));
$order=array('event.event_id'=>'DESC');
$this->set('result_event_last',$this->event->find('all', array('conditions' => $conditions,'order' => $order,'limit' =>3)));
//////////////event  last 3 topic///////////////// 


//////////////pie chart help_desk///////////////// 
$this->loadmodel('help_desk');
$conditions=array("society_id" => $s_society_id);
$result_help_desk_report1=$this->help_desk->find('all',array('conditions'=>$conditions));
$this->set('result_help_desk_report1',$result_help_desk_report1);
//////////////pie chart help_desk///////////////// 



//////////////notice///////////////// 
$this->loadmodel('notice');
$result_notice_visible_last=array();
if($role_id==3) { 
$conditions=array("n_draft_id" => 0, "n_delete_id" => 0,"society_id"=> $s_society_id);
$order=array('notice_id'=>'DESC');
}

if($role_id!=3) { 
$conditions =array( '$or' => array( 
array('society_id' =>$s_society_id,'visible' =>1,'n_expire_date' => array('$gte'=>$current_date)),
array('society_id' =>$s_society_id,'visible' =>2,'sub_visible' =>array('$in' => array($role_id)),'n_expire_date' => array('$gte'=>$current_date)),
array('society_id' =>$s_society_id,'visible' =>3,'sub_visible' =>array('$in' => array($wing)),'n_expire_date' => array('$gte'=>$current_date)),
array('society_id' =>$s_society_id,'visible' =>4,'sub_visible' =>$tenant,'n_expire_date' => array('$gte'=>$current_date)),
array('society_id' =>$s_society_id,'visible' =>5,'sub_visible' =>$tenant,'n_expire_date' => array('$gte'=>$current_date))
));
}


$order=array('notice.notice_id'=>'DESC');
$result_notice_visible_last_q=$this->notice->find('all', array('conditions' => $conditions,'order' => $order,'limit' =>3));
$current_date=date("d-m-Y");


$result_notice_visible_last=array();
foreach($result_notice_visible_last_q as $data)
{
$n_expire_date=$data['notice']['n_expire_date'];
$n_expire_date= date('d-m-Y', $n_expire_date->sec);


if(strtotime($n_expire_date) >= strtotime($current_date))
{
$result_notice_visible_last[]=$data;

}


}



$this->set('result_notice_visible_last',$result_notice_visible_last);


//////////////notice///////////////// 


//////////////polls  last 3///////////////// 
$current_date3=date("Y-m-d");
$current_date3 = new MongoDate(strtotime($current_date3));
$this->loadmodel('poll');
$conditions=array("society_id" => $s_society_id,"visible_user_id" =>array('$in' => array($s_user_id)),"deleted" => 0,'close_date' => array('$gt' => $current_date3));
$order=array('poll.poll_id'=>'DESC');
$this->set('result_poll_last',$this->poll->find('all', array('conditions' => $conditions,'order' => $order,'limit' =>3)));

//////////////polls  last 3///////////////// 

//////////////documents  last 3///////////////// 
$this->loadmodel('resource');

if($role_id==3) { 
$conditions=array('society_id'=>$s_society_id);
}

if($role_id!=3) { 
$conditions =array( '$or' => array( 
array('society_id' =>$s_society_id,'visible' =>1),
array('society_id' =>$s_society_id,'visible' =>2,'sub_visible' =>array('$in' => array($role_id))),
array('society_id' =>$s_society_id,'visible' =>3,'sub_visible' =>array('$in' => array($wing))),
array('society_id' =>$s_society_id,'visible' =>4,'sub_visible' =>$tenant),
array('society_id' =>$s_society_id,'visible' =>5,'sub_visible' =>$tenant)
));
}

$order=array('resource.resource_id'=>'DESC');
$result_resource_last=$this->resource->find('all',array('conditions'=>$conditions,'order' => $order,'limit' =>3));
$this->set('result_resource_last',$result_resource_last);
//////////////documents  last 3///////////////// 

/////////////// Discussion information reject //////////////////

$this->loadmodel('discussion_post');
$conditions=array('delete_id'=>5,'society_id'=>$s_society_id,'user_id'=>$s_user_id);
$res_dis=$this->discussion_post->find('all',array('conditions'=>$conditions));
$this->set('disc_res',$res_dis);

//////////////// end ///////////////////////////////////////


/////////////// Notice information reject //////////////////
$this->loadmodel('notice');
$conditions=array('n_draft_id'=>5,'society_id'=>$s_society_id,'user_id'=>$s_user_id);
$res_not=$this->notice->find('all',array('conditions'=>$conditions));

$this->set('not_res',$res_not);

//////////////// end ///////////////////////////////////////


/////////////// Poll information reject //////////////////
$this->loadmodel('poll');
$conditions=array('deleted'=>5,'society_id'=>$s_society_id,'user_id'=>$s_user_id);
$res_poll=$this->poll->find('all',array('conditions'=>$conditions));
$this->set('poll_res',$res_poll);

//////////////// end ///////////////////////////////////////



/////////////// Documents information reject //////////////////

$this->loadmodel('resource');
$conditions=array('resource_delete'=>5,'society_id'=>$s_society_id,'user_id'=>$s_user_id);
$res_resource=$this->resource->find('all',array('conditions'=>$conditions));
$this->set('resource_res',$res_resource);

//////////////// end ///////////////////////////////////////



}
function reject_notification($id,$change)
{
	if($change==1)
	{
	$this->loadmodel('notice');
	$this->notice->updateAll(array('n_draft_id'=>6),array('notice_id'=>$id));
	}
	if($change==2)
	{
	$this->loadmodel('discussion_post');
	$this->discussion_post->updateAll(array('delete_id'=>6),array('discussion_post_id'=>$id));
	}
	if($change==3)
	{
	$this->loadmodel('poll');
	$this->poll->updateAll(array('deleted'=>6),array('poll_id'=>$id));
	}
	if($change==4)
	{
		$this->loadmodel('resource');
		$this->resource->updateAll(array('resource_delete'=>6),array('resource_id'=>$id));

	}
	
}


function dashboard_old() 
{
if ($this->request->isAjax()){
        $this->layout = 'blank';
        $this->view = 'view_ajax'; //Other view that doesn't needs layout, only if necessary 
		}else{
		$this->layout='session';
		}
   
	

$this->ath();
$r=$this->request->query('try');
$s_user_id=$this->Session->read('user_id');
$s_society_id=$this->Session->read('society_id');

if(!empty($r))
{
$this->loadmodel('user');
$this->user->updateAll(array('profile_status'=>2),array('user_id'=>$s_user_id));
$this->redirect(array('action' => 'dashboard'));
}
$this->loadmodel('user');
$conditions=array("user_id" => $s_user_id);
$this->set('result_user',$this->user->find('all',array('conditions'=>$conditions))); 

//--------notice view------------//
$tenant=$this->Session->read('tenant');
$role_id=$this->Session->read('role_id');
$wing=$this->Session->read('wing');

$current_date = new MongoDate(strtotime(date("Y-m-d")));

$this->loadmodel('notice');
$conditions =array( '$or' => array( 
array('society_id' =>$s_society_id,'visible' =>1,'sub_visible' =>array('$in' => array($tenant)),'n_expire_date' => array('$gte'=>$current_date)),
array('society_id' =>$s_society_id,'visible' =>2,'sub_visible' =>array('$in' => array($role_id)),'n_expire_date' => array('$gte'=>$current_date)),
array('society_id' =>$s_society_id,'visible' =>3,'sub_visible' =>array('$in' => array($wing)),'n_expire_date' => array('$gte'=>$current_date))
));
$order=array('notice.notice_id'=>'DESC');
$this->set('result_notice_visible',$this->notice->find('all', array('conditions' => $conditions,'order' => $order,'limit'=>5)));
//--------notice view end------------//



//--------notice view------------//
$this->loadmodel('event');
$conditions=array("society_id" => $s_society_id,"visible_user_id" =>array('$in' => array($s_user_id)));
$order=array('event.event_id'=>'DESC');
$this->set('result_event',$this->event->find('all', array('conditions' => $conditions,'order' => $order)));
//--------notice view end------------//

//--------notice view------------//
$this->loadmodel('discussion_post');
$conditions =array( '$or' => array( 
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>1),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>2,'sub_visible' =>array('$in' => array($role_id))),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>3,'sub_visible' =>array('$in' => array($wing))),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>4),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>5)
));
$order=array('discussion_post.discussion_post_id'=>'DESC');
$this->set('result_discussion_last',$this->discussion_post->find('all',array('conditions'=>$conditions,'order'=>$order,'limit'=>5)));
//--------notice view end------------//


//help_desk//
$this->loadmodel('help_desk');
$conditions=array("society_id" => $s_society_id,"user_id" => $s_user_id);
$order=array('help_desk.ticket_id'=> 'DESC');
$result=$this->help_desk->find('all',array('conditions'=>$conditions,'order' =>$order,'limit' =>5));
$this->set('result_help_desk',$result);
//help_desk//

//polls//
$this->loadmodel('poll');
$conditions=array("society_id" => $s_society_id,"visible_user_id" =>array('$in' => array($s_user_id)));
$order=array('poll.poll_id'=>'DESC');
$this->set('result_poll',$this->poll->find('all', array('conditions' => $conditions,'order' => $order,'limit' =>5)));
//polls//

//resource//
$this->loadmodel('resource');
$conditions=array("resource_delete"=>0,"society_id"=>$s_society_id);
$result=$this->resource->find('all',array('conditions'=>$conditions,'limit' =>5));
$this->set('result_resource',$result);
//resource//

//event//
$this->loadmodel('event');
$conditions=array("society_id" => $s_society_id,"visible_user_id" =>array('$in' => array($s_user_id)));
$order=array('event.event_id'=>'DESC');
$this->set('result_event',$this->event->find('all', array('conditions' => $conditions,'order' => $order,'limit' =>5)));
//event//
}

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
	
	foreach($res_notice as $dda)
			{
				$id=(int)$dda['notice']['notice_id'];
				$this->seen_notification(2,$id);

			}

	$this->set('result_notice_publish',$res_notice);	

}

function notice_approval_ajax()
{
	$this->layout='blank';
	$id=(int)$this->request->query('con');
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
		$notice_subject=html_entity_decode($sub);
		$date=$data['notice']['n_date'];
		$visible=(int)$data['notice']['visible'];
		$sub_visible=$data['notice']['sub_visible'];
		$message=$data['notice']['n_message'];
		$file_name=$data['notice']['n_attachment'];
		if(!empty($file_name))
				{
				//@$file_att='<br/><a href="'.$ip.'/'.$this->webroot.'notice_file/'.$file_name.'" download>Download attachment</a><br/><br/>';
				}
		
		
		
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

			
		/* $message_web='<table  align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
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
										<td align="left" style="background-color:#f8f8f8;font-size:12px;" >'.$sub.'</td>
										</tr>
										
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Category</td>
										<td align="left" style="background-color:#f8f8f8;font-size:12px;" >'.$category_name.'</td>
										</tr>
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Sent to</td>
										<td align="left" style="background-color:#f8f8f8;font-size:12px;" >'.$send.'</td>
										</tr>
									
										</table> 
									
									</td>
								
								
								
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<p style="font-size:16px;"> <strong>Notice Description:</strong></p>
										<p align="justify">'.$message.'</p>
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
								<td><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="line-height:28px" height="28">&nbsp;</td></tr><tr><td><span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:16px;line-height:21px;color:#141823">Hello  '.$user_name.'<br>A new notice has been posted on your society Notice Board.</span></td></tr><tr><td style="line-height:14px" height="14">&nbsp;</td></tr><tr><td><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;border:solid 1px #e5e5e5;border-radius:2px;display:block"><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="padding:5px 10px;background:#269abc;border-top:#cccccc 1px solid;border-bottom:#cccccc 1px solid"><span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:16px;line-height:19px;color:#fff">'.$sub.'</span></td></tr><tr>
								<td style="padding:5px">
								
								<table style="border-collapse:collapse" cellpadding="0" cellspacing="0">
									<tr>
										<td>
										<span style="color:#adabab;font-size:12px">Category : '.$category_name.'  </span>
										</td>
										<td>&nbsp;&nbsp;|&nbsp;&nbsp;</td>
										<td>
										<span style="color:#adabab;font-size:12px">Sent to : '.$send.'  </span>
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
								<td style="padding:5px" height="10">'.$message.'</td>
							</tr>
						</tbody>
					</table></td></tr></tbody></table></td></tr><tr><td style="line-height:14px" height="14">&nbsp;</td></tr></tbody></table></td>
								<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
</tr>						<tr>
								<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
								<td>
									<table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="line-height:2px" colspan="3" height="2">&nbsp;</td></tr><tr><td><a href="#150cd117ec15fdb9_" style="color:#3b5998;text-decoration:none"><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="border-collapse:collapse;border-radius:2px;text-align:center;display:block;border:1px solid #026a9e;background:#008ed5;padding:7px 16px 11px 16px"><a href="'.$ip.$this->webroot.'Notices/notice_publish_view/'.$id.'" style="color:#3b5998;text-decoration:none;display:block" target="_blank"><center><font size="3"><span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;white-space:nowrap;font-weight:bold;vertical-align:middle;color:#ffffff;font-size:14px;line-height:14px">View on HousingMatters</span></font></center></a></td></tr></tbody></table></a></td><td style="display:block;width:10px" width="10">&nbsp;&nbsp;&nbsp;</td><td><a href="#150cd117ec15fdb9_" style="color:#3b5998;text-decoration:none"><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr></tr></tbody></table></a></td><td width="100%"></td></tr><tr><td style="line-height:32px" colspan="3" height="32">&nbsp;</td></tr></tbody></table>
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
				
					@$subject.= '['. $society_name . ']  - '.' New Notice : '.'     '.''.$notice_subject.'';
					$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
					$subject="";
				}	
	}
			
			
////////// Send Notification code start ///////////////////////////////////////


$this->send_notification('<span class="label label-info" ><i class="icon-bullhorn"></i></span>','New Notice published - <b>'.$sub.'</b> by',2,$id,$this->webroot.'Notices/notice_publish_view/'.$id,$user_id,$da_to11);





//////////// End code notification ////////////////////////////			
			
		$this->loadmodel('notice');
		$this->notice->updateAll(array('visible_user_id' => $da_to11,'n_draft_id'=>0),array('notice_id'=>$id));
		$this->response->header('location','notice_approval');
		
	}
	
	
}

function notice_approval_reject()
{
	$this->layout="blank";
	$n_id=(int)$this->request->query['con'];
	$this->loadmodel(notice);
	$this->notice->updateAll(array('n_draft_id'=>5),array('notice_id'=>$n_id));
	$this->response->header('location','notice_approval');
}



function notice_approval_view()
{
	
		if($this->RequestHandler->isAjax()){
		$this->layout='blank';
		}else{
		$this->layout='session';
		}
		$this->ath();
		 $n_id=(int)$this->request->query['con'];
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
$this->check_user_privilages();
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
@$subject.= ''. $society_name . '' .' New Notice '.'     '.''.$sub.'';
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$subject="";
}	
}


$da_user_id[]=$d_user_id;
$this->send_notification('<span class="label label-info" ><i class="icon-bullhorn"></i></span>','New Notice published - <b>'.$sub.'</b> by',2,$notice_id,'notice_publish_view?con='.$notice_id,$s_user_id,$da_user_id);

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

function notice_publish_view() 
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
		$reply=htmlentities($this->request->query('reply'));
		$rep=explode(' ',$reply);
		$r=$this->content_moderation_society($rep);
		
		

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
$this->layout='session';
$this->ath();
$this->check_user_privilages();
$q=$this->request->query('con');
$cat=$this->decode($q,'housingmatters');
$this->set('blue_cat',$cat);
$s_society_id=$this->Session->read('society_id');
$this->loadmodel('master_notice_category');
$this->set('result1', $this->master_notice_category->find('all'));
$this->loadmodel('notice');
$conditions=array("n_draft_id" => 1, "n_delete_id" => 0,"society_id"=> $s_society_id);
$this->set('result_notice_draft',$this->notice->find('all',array('conditions'=>$conditions)));
	if(!empty($cat))
	{
		$this->set('red_cat',$cat);	
		$this->loadmodel('notice');
		$conditions1=array('n_draft_id'=>1,'n_delete_id'=>0,'society_id'=>$s_society_id,'n_category_id'=>$cat);
		$result=$this->notice->find('all',array('conditions'=>$conditions1));
		$this->set('result_notice_draft',$result);
	}
	
}


function notice_edit() 
{
$this->layout='session';
$this->ath();
$s_society_id=$this->Session->read('society_id');
$notice_id=(int)$this->request->query['n'];
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

//$this->loadmodel('user');
//$conditions=array('tenant'=>1,'society_id'=>$s_society_id);
//$result_user=$this->user->find('all',array('conditions'=>$conditions));
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
@$subject.= ''. $society_name . '' .' New Notice '.'     '.''.$sub.'';
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
<a href="notice_publish" class="btn green">OK</a>
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


function notice_move_archive()
{
	$this->layout='blank';	
	$notice_id=(int)$this->request->query('con');
	$this->loadmodel('notice');
	$this->notice->updateAll(array('n_draft_id'=>2),array('notice_id'=>$notice_id));
	$this->response->header('location','notice_archive');
	
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
$this->set('role_id',$role_id);
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

/////////////////////////////Start of Event//////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
function event_add()
{
$this->layout='session';
$this->ath();
$this->check_user_privilages();

$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$s_result= $this->society_name($s_society_id);
foreach($s_result as $data)
{
	
	$society_name=$data['society']['society_name'];
	
}
$date = new MongoDate(strtotime(date('Y-m-d')));



$this->loadmodel('role');
$conditions=array("society_id" => $s_society_id);
$role_result=$this->role->find('all',array('conditions'=>$conditions));
$this->set('role_result',$role_result);

$this->loadmodel('wing');
$wing_result=$this->wing->find('all');
$this->set('wing_result',$wing_result);

$this->loadmodel('user');
$conditions=array("society_id"=>$s_society_id,'deactive'=>0);
$this->set('result_users',$this->user->find('all',array('conditions'=>$conditions))); 

if (isset($this->request->data['create_event'])) 
{
$e_name=htmlentities($this->request->data['e_name']);
$day_type=(int)$this->request->data['day_type'];
$ip=$this->hms_email_ip();
if($day_type==2)
{
$date_from1=$this->request->data['date_from'];
$date_from=date("Y-m-d",strtotime($date_from1));
$date_from = new MongoDate(strtotime($date_from));
$date_to1=$this->request->data['date_to'];
$date_to=date("Y-m-d",strtotime($date_to1));
$date_to = new MongoDate(strtotime($date_to));
$date_email="from $date_from1 to $date_to1";
}

if($day_type==1)
{
$date_from1=$this->request->data['date_single'];
$date_from=date("Y-m-d",strtotime($date_from1));
$date_from = new MongoDate(strtotime($date_from));

$date_to1=$this->request->data['date_single'];
$date_to=date("Y-m-d",strtotime($date_to1));
$date_to = new MongoDate(strtotime($date_to));
$date_email="on $date_to1";
}




$location=htmlentities($this->request->data['location']);
$description=htmlentities($this->request->data['description']);
$visible=(int)$this->request->data['visible'];

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
$visible_user_id[]=$data['user']['user_id'];
$da_to[]=$data['user']['email'];
$da_user_name[]=$data['user']['user_name'];
}
/////////////////////////////////////////// All user ////////////////////////////
}

if($visible==4)
{	
$visible=4;
$sub_visible[]=0;
/////////////////////////////////////////// All Owners ////////////////////////////
//$this->loadmodel('user');
//$conditions=array('tenant'=>1,'society_id'=>$s_society_id);
//$result_user=$this->user->find('all',array('conditions'=>$conditions));
$result_user=$this->all_owner_deactive();
foreach($result_user as $data)
{
$visible_user_id[]=$data['user']['user_id'];
$da_to[]=$data['user']['email'];
$da_user_name[]=$data['user']['user_name'];
}
/////////////////////////////////////////// All Owners ////////////////////////////
}

if($visible==5)
{
$visible=5;
$sub_visible[]=0;
/////////////////////////////////////////// All Tenant ////////////////////////////
//$this->loadmodel('user');
//$conditions=array('tenant'=>2,'society_id'=>$s_society_id);
//$result_user=$this->user->find('all',array('conditions'=>$conditions));
$result_user=$this->all_tenant_deactive();
foreach($result_user as $data)
{
$visible_user_id[]=$data['user']['user_id'];
$da_to[]=$data['user']['email'];
$da_user_name[]=$data['user']['user_name'];
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

/////////////////////////////////////////// Role Wise ////////////////////////////
//$this->loadmodel('user');
//$conditions=array('role_id'=>$role_id,'society_id'=>$s_society_id);
//$result_user=$this->user->find('all',array('conditions'=>$conditions));
$result_user=$this->all_role_wise_deactive($role_id);
foreach($result_user as $data)
{
$visible_user_id[]=$data['user']['user_id'];
$da_to[]=$data['user']['email'];
$da_user_name[]=$data['user']['user_name'];
}
/////////////////////////////////////////// Role Wise ////////////////////////////
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

/////////////////////////////////////////// Wing Wise ////////////////////////////
//$this->loadmodel('user');
//$conditions=array('wing'=>$wing,'society_id'=>$s_society_id);
//$result_user=$this->user->find('all',array('conditions'=>$conditions));
$result_user=$this->all_wing_wise_deactive($wing);
foreach($result_user as $data)
{
$visible_user_id[]=$data['user']['user_id'];
$da_to[]=$data['user']['email'];
$da_user_name[]=$data['user']['user_name'];
}
/////////////////////////////////////////// Wing Wise ////////////////////////////
}
}

}



if($visible==6)
{	
$visible=6;
$sub_visible[]=0;
/////////////////////////////////////////// Manually ////////////////////////////
$visible_user_id1=$this->request->data['multi'];
foreach($visible_user_id1 as $data_user)
{
	$d_u_id=(int)$data_user;
	$res_user=$this->profile_picture($d_u_id);
	foreach($res_user as $ddd)
	{
		$da_to[]=$ddd['user']['email'];
		$da_user_name[]=$ddd['user']['user_name'];
	}
	
  $visible_user_id[]=(int)$data_user;
}
/////////////////////////////////////////// Manually ////////////////////////////
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
$visible_user_id[]=$c_user_id;

$da_to=array_unique($da_to);
$da_user_name=array_unique($da_user_name);
$visible_user_id=array_unique($visible_user_id);

/////////////////////////  end code ////////////////////////////////

////////////////// Email Functionality code ////////////////////////

$from="Support@housingmatters.in";
$reply="Support@housingmatters.in";
$from_name="HousingMatters";
for($k=0;$k<sizeof($da_to);$k++)
{
$to = @$da_to[$k];
//$d_user_id = @$da_user_id[$k];	 
$user_name = @$da_user_name[$k];	

$message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Hello $user_name </p>
<p>A new event has been created.</p>
<p><span>$e_name</span></p>
<p><span>$date_email</span></p>
<p><span>$location</span></p>
<div>
<br/>
<br/>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.co.in
</div>
</div>";
 @$subject.= ''. $society_name . '  ' .'     '.' '.$e_name.'';
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$subject="";



}



////////////////// End Email code ////////////////////////////////////

$visible_user_id = array_unique($visible_user_id);

ksort($visible_user_id);
foreach($visible_user_id as $x=>$x_value)
{
$visible_user_id_new[]=$x_value;
}

$event_id=$this->autoincrement('event','event_id');
$this->loadmodel('event');
$this->event->saveAll(array('event_id' => $event_id,'e_name' => $e_name, 'user_id' => $s_user_id, 'society_id' => $s_society_id, 'date_from' => $date_from , 'date_to' => $date_to, 'day_type' => $day_type, 'location' => $location,'description' => $description,'visible' => $visible,'sub_visible' => $sub_visible,'visible_user_id' => $visible_user_id_new,'date' => $date));


$this->send_notification('<span class="label" style="background-color:#44b6ae;"><i class="icon-gift"></i></span>','New Event <b>'.$e_name.'</b> submitted by',6,$event_id,'event_info?e='.$event_id,$s_user_id,$visible_user_id_new);
?>
<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Your Event has been created.
</div> 
<div class="modal-footer">
<a href="events" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php


}

}

function calendar()
{
$this->layout='blank';

$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$m_y=@$this->request->query('m_y');
if(empty($m_y))
{ 
$m_y = date('m-Y');
}


$m_y_ex=explode('-',$m_y);
$m=$m_y_ex[0];
$y=$m_y_ex[1];

/////////////////
$start='1-'.$m_y;
$start = date("Y-m-d", strtotime($start));
$start = new MongoDate(strtotime($start));

$days_in_month = cal_days_in_month(CAL_GREGORIAN, $m, $y);

$end=$days_in_month.'-'.$m_y;
$end = date("Y-m-d", strtotime($end));
$end = new MongoDate(strtotime($end));

$event_info=array();
$this->loadmodel('event');
$conditions=array('date_from' => array('$gte'=>$start,'$lte'=>$end));
$result_event_info=$this->event->find('all',array('conditions'=>$conditions));
foreach($result_event_info as $data)
{
$date_from = date("Y-m-d", $data['event']['date_from']->sec);
$date_to = date("Y-m-d", $data['event']['date_to']->sec);
$event_info[]=array($data['event']['event_id'],$data['event']['e_name'],$date_from,$date_to);
}
if(sizeof($event_info)==0) { $event_info=array(); }
$this->set('event_info',$event_info);
/////////////////



$dateObj   = DateTime::createFromFormat('!m', $m);
$month_name = $dateObj->format('F'); // March

$this->set('month',$m);
$this->set('month_name',$month_name);
$this->set('year',$y);

}

function check_event($e_date)
{
$this->layout='blank';

$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('event');
$conditions=array("date_from" =>$e_date);
$result_event_info=$this->event->find('all');

return $result_event_info;
}

function events()
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


$this->loadmodel('event');
$conditions=array("society_id" => $s_society_id,"visible_user_id" =>array('$in' => array($s_user_id)));
$order=array('event.event_id'=>'DESC');
$this->set('result_event',$this->event->find('all', array('conditions' => $conditions,'order' => $order)));
}

function events_calendar()
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();

}

function event_info()
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	
$this->ath();

$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$this->set('s_user_id',$s_user_id);

$e_id=(int)$this->request->query('e');
$this->set('e_id',$e_id);

$this->seen_notification(6,$e_id);
$this->seen_alert(6,$e_id);

if (isset($this->request->data['sub_update'])) 
{
	

$title=htmlentities($this->request->data['title']);
$title=wordwrap($title, 25, " ", true);
$title_cat=$this->request->data['title_cat'];
$title_des=htmlentities($this->request->data['description']);


$this->loadmodel('event');
$conditions=array("event_id" => $e_id);
$event_result_update=$this->event->find('all', array('conditions' => $conditions));
$this->set('event_result_update',$event_result_update);
$update=@$event_result_update[0]['event']['updates'];
$e_name=@$event_result_update[0]['event']['e_name'];
$visible_user_id=@$event_result_update[0]['event']['visible_user_id'];

if(sizeof($update)==0)
{
$update[]=array("title"=>$title,"color"=>$title_cat,"des"=>$title_des);
}
else
{
$t=array("title"=>$title,"color"=>$title_cat,"des"=>$title_des);
array_push($update,$t);
}

//$updates=array("title"=>$title,"color"=>$title_cat,"des"=>$title_des);
$this->event->updateAll(array('updates'=>$update),array('event.event_id'=>$e_id));


$this->send_notification('<span class="label" style="background-color:#d43f3a;"><i class="icon-tags"></i></span>','Updates for Event <b>'.$e_name.'</b> submitted by',6,$e_id,'event_info?e='.$e_id,$s_user_id,$visible_user_id);

}

if (isset($this->request->data['up_photo'])) 
{
$file=$this->request->form['file']['name'];


$file=$this->request->form['file']['name'];
if (!file_exists('event_file/event'.$e_id)) 
{
mkdir('event_file/event'.$e_id);
}
move_uploaded_file(@$this->request->form['file']['tmp_name'], "event_file/event".$e_id."/".$file);

$this->loadmodel('event');
$conditions=array("event_id" => $e_id);
$event_result_update=$this->event->find('all', array('conditions' => $conditions));
$this->set('event_result_update',$event_result_update);
$photo=@$event_result_update[0]['event']['photos'];

if(sizeof($photo)==0)
{
$photo[]=$file;
}
else
{
array_push($photo,$file);
}

$updates=array(array("title"=>"dfdgdf","color"=>"dfdgdf","des"=>"dfdgdf"));
$this->event->updateAll(array('photos'=>$photo),array('event.event_id'=>$e_id));

}

$this->loadmodel('event');
$conditions=array("event_id" => $e_id,"visible_user_id" => array('$in' => array($s_user_id)));
$result_event_detail=$this->event->find('all', array('conditions' => $conditions));
$this->set('result_event_detail',$result_event_detail);



}



function save_rsvp()
{
$this->layout='blank';

$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$e=(int)$this->request->query('e');
$type=(int)$this->request->query('type');

	if($type==1)
	{
	$this->loadmodel('event');
	$conditions=array("event_id" => $e);
	$event_result=$this->event->find('all', array('conditions' => $conditions));
	$rsvp=@$event_result[0]['event']['rsvp'];
	if(sizeof($rsvp)==0)	{ $rsvp=array(); }
	
	if (!in_array($s_user_id, $rsvp))
	{
	
		if(sizeof($rsvp)==0)
		{
		$rsvp[]=$s_user_id;
		
		}
		else
		{
		$t=$s_user_id;
		array_push($rsvp,$t);
		}
		
		
		$this->event->updateAll(array('rsvp'=>$rsvp),array('event.event_id'=>$e));
	}
	echo "Thanks for voting.";
	}
	
	if($type==2)
	{
	$this->loadmodel('event');
	$conditions=array("event_id" => $e);
	$event_result=$this->event->find('all', array('conditions' => $conditions));
	@$not_in_rsvp=@$event_result[0]['event']['not_in_rsvp'];
	
	if(sizeof($not_in_rsvp)==0)	{ $not_in_rsvp=array(); }
	
	if (!in_array($s_user_id, $not_in_rsvp))
	{
	
		if(sizeof($not_in_rsvp)==0)
		{
		$not_in_rsvp[]=$s_user_id;
		
		}
		else
		{
		$t=$s_user_id;
		array_push($not_in_rsvp,$t);
		}
		
		
		$this->event->updateAll(array('not_in_rsvp'=>$not_in_rsvp),array('event.event_id'=>$e));
	}
	
	echo "Thanks for voting.";
	}
}


///////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////End of Event//////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////start of polls//////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
function poll_add()
{
$this->layout='session';
$this->ath();
$this->check_user_privilages();

$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
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

$this->loadmodel('user');
$conditions=array("society_id"=>$s_society_id);
$this->set('result_users',$this->user->find('all',array('conditions'=>$conditions))); 

$result_so=$this->society_name($s_society_id);
	foreach($result_so as $data)
	{
	  @$poll_society=$data['society']['poll'];
	}
	if($poll_society==1 && $s_role_id!=3 )
	{
		
		if (isset($this->request->data['create_poll'])) 
		{
			$question=htmlentities($this->request->data['question']);
			$question=wordwrap($question, 25, " ", true);
			$description=htmlentities($this->request->data['description']);
			$description=wordwrap($description, 25, " ", true);
			$poll_close_date=$this->request->data['poll_close_date'];
			$type=(int)$this->request->data['type'];
			$private=(int)@$this->request->data['private']; 
			if(empty($private)) { $private=0; }
			$choice_text_box=(int)$this->request->data['choice_text_box'];
			for($z=1;$z<=$choice_text_box;$z++)
			{
			$color=$this->rendom_color_new();
			$choice[]=array(htmlentities($this->request->data['choice'.$z]),$color);

			}
			$current_date = date('Y-m-d');
			$current_date = new MongoDate(strtotime($current_date));


			if(empty($poll_close_date)) 
			{ 
			$current_date_add=date('Y-m-d', strtotime(date('Y-m-d'). ' + 15 days'));
			$poll_close_date=$current_date_add;

			}
			$poll_close_date = date("Y-m-d", strtotime($poll_close_date));
			$close_date = new MongoDate(strtotime($poll_close_date));
			
			$file=$this->request->form['file']['name'];

			$target = "polls_file/";
			$target=@$target.basename( @$this->request->form['file']['name']);
			$ok=1;
			move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target); 


			$visible=(int)$this->request->data['visible'];
			
			if($visible==1)
			{	
			$visible=1;
			$sub_visible[]=0;
			}

			if($visible==4)
			{	
			$visible=4;
			$sub_visible=0;
			}

			if($visible==5)
			{
			$visible=5;
			$sub_visible=0;
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
					
					
					$poll_id=$this->autoincrement('poll','poll_id');
					$this->loadmodel('poll');
					$this->poll->saveAll(array('poll_id' => $poll_id,'question' => $question , 'des' => $description, 'type' => $type, 'choice' => $choice,'visible' => $visible,'sub_visible' => $sub_visible,'date' => $current_date,'close_date' => $close_date,'file' => $file,'society_id' => $s_society_id,'user_id' => $s_user_id,"deleted" => 4,"private" => $private));
				
				?>
		<!----alert-------------->
		<div class="modal-backdrop fade in"></div>
		<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-body" style="font-size:16px;">
		Polls are sent for approval.
		</div> 
		<div class="modal-footer">
		<a href="Polls" class="btn green">OK</a>
		</div>
		</div>
		<!----alert-------------->
		<?php

				
				
				
		}
	}
	else
	{
		
		if (isset($this->request->data['create_poll'])) 
		{
			$ip=$this->hms_email_ip();
		$question=htmlentities($this->request->data['question']);
		$question=wordwrap($question, 25, " ", true);
		$description=htmlentities($this->request->data['description']);
		$description=wordwrap($description, 25, " ", true);
		$poll_close_date=$this->request->data['poll_close_date'];
		$type=(int)$this->request->data['type'];
		$private=(int)@$this->request->data['private']; 
		if(empty($private)) { $private=0; }
		$choice_text_box=(int)$this->request->data['choice_text_box'];
		for($z=1;$z<=$choice_text_box;$z++)
		{
		$color=$this->rendom_color_new();
		$choice[]=array(htmlentities($this->request->data['choice'.$z]),$color);

		}
		$current_date = date('Y-m-d');
		$current_date = new MongoDate(strtotime($current_date));


		if(empty($poll_close_date)) 
		{ 
		$current_date_add=date('Y-m-d', strtotime(date('Y-m-d'). ' + 15 days'));
		$poll_close_date=$current_date_add;

		}
		$poll_close_date = date("Y-m-d", strtotime($poll_close_date));
		$close_date = new MongoDate(strtotime($poll_close_date));



		$s_message='Your Poll has been created.';

		$file=$this->request->form['file']['name'];

		$target = "polls_file/";
		$target=@$target.basename( @$this->request->form['file']['name']);
		$ok=1;
		move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target); 


		$visible=(int)$this->request->data['visible'];

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
		$visible_user_id[]=$data['user']['user_id'];
		$visible_mobile[]=$data['user']['mobile'];
		$visible_email[]=$data['user']['email'];
		}
		/////////////////////////////////////////// All user ////////////////////////////
		}

		if($visible==4)
		{	
		$visible=4;
		$sub_visible[]=0;
		/////////////////////////////////////////// All Owners ////////////////////////////
		//$this->loadmodel('user');
		//$conditions=array('tenant'=>1,'society_id'=>$s_society_id);
		//$result_user=$this->user->find('all',array('conditions'=>$conditions));
		$result_user=$this->all_owner_deactive();
		foreach($result_user as $data)
		{
		$visible_user_id[]=$data['user']['user_id'];
		$visible_mobile[]=$data['user']['mobile'];
		$visible_email[]=$data['user']['email'];
		}
		/////////////////////////////////////////// All Owners ////////////////////////////
		}

		if($visible==5)
		{
		$visible=5;
		$sub_visible[]=0;
		/////////////////////////////////////////// All Tenant ////////////////////////////
		//$this->loadmodel('user');
		//$conditions=array('tenant'=>2,'society_id'=>$s_society_id);
		//$result_user=$this->user->find('all',array('conditions'=>$conditions));
		$result_user=$this->all_tenant_deactive();
		foreach($result_user as $data)
		{
		$visible_user_id[]=$data['user']['user_id'];
		$visible_mobile[]=$data['user']['mobile'];
		$visible_email[]=$data['user']['email'];
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

		/////////////////////////////////////////// Role Wise ////////////////////////////
		//$this->loadmodel('user');
		//$conditions=array('role_id'=>$role_id,'society_id'=>$s_society_id);
		//$result_user=$this->user->find('all',array('conditions'=>$conditions));
		$result_user=$this->all_role_wise_deactive($role_id);
		foreach($result_user as $data)
		{
		$visible_user_id[]=$data['user']['user_id'];
		$visible_mobile[]=$data['user']['mobile'];
		$visible_email[]=$data['user']['email'];
		}
		/////////////////////////////////////////// Role Wise ////////////////////////////
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

		/////////////////////////////////////////// Wing Wise ////////////////////////////
		//$this->loadmodel('user');
		//$conditions=array('wing'=>$wing,'society_id'=>$s_society_id);
		//$result_user=$this->user->find('all',array('conditions'=>$conditions));
		$result_user=$this->all_wing_wise_deactive($wing);
		foreach($result_user as $data)
		{
		$visible_user_id[]=$data['user']['user_id'];
		$visible_mobile[]=$data['user']['mobile'];
		$visible_email[]=$data['user']['email'];
		}
		/////////////////////////////////////////// Wing Wise ////////////////////////////
		}
		}

		}


					///////// creator send email code //////////////////

					$result_user=$this->profile_picture($s_user_id);
					foreach($result_user as $data)
					{
					  $c_email=$data['user']['email'];
					
					}
					$visible_email[]=$c_email;
					
					/////////////////////////  end code ////////////////////////////////


		$visible_mobile = array_unique($visible_mobile);
		$visible_email = array_unique($visible_email);

		$visible_user_id = array_unique($visible_user_id);

		ksort($visible_user_id);
		foreach($visible_user_id as $x=>$x_value)
		{
		$visible_user_id_new[]=$x_value;
		}


		$poll_id=$this->autoincrement('poll','poll_id');
		$this->loadmodel('poll');
		$this->poll->saveAll(array('poll_id' => $poll_id,'question' => $question , 'des' => $description, 'type' => $type, 'choice' => $choice,'visible' => $visible,'sub_visible' => $sub_visible,'visible_user_id' => $visible_user_id_new,'date' => $current_date,'close_date' => $close_date,'file' => $file,'society_id' => $s_society_id,'user_id' => $s_user_id,"deleted" => 0,"private" => $private));

$this->send_notification('<span class="label" style="background-color:#46b8da;"><i class="icon-question-sign"></i></span>','New Poll <b>'.$question.'</b> started by',7,$poll_id,'Polls',$s_user_id,$visible_user_id_new);



		$this->loadmodel('society');
		$conditions12=array('society_id'=>$s_society_id);
		$result12=$this->society->find('all',array('conditions'=>$conditions12));
		foreach($result12 as $data)
		{
			$s_name=$data['society']['society_name'];
		}
		$message_web="<div>
		<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
		<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
		<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
		</br>
		<p>A new poll has been created on your society poll booth.</p>

		<div style='border:solid 1px #ccc;padding:10px;'>
		<span style='color:#00A0E3;'>$question<span><br/>
		<span style='color:#000;font-size:12px;'>$description<span>
		<hr>";
		$message_web.="<ol Type='A' >";
		foreach($choice as $data)
		{
		$message_web.="<li ><span style='font-size:14px;'>".$data[0]."</span></li>";
		}
		$message_web.="</ol>";
		$message_web.="<center><p>To view / vote
		<a href='$ip".$this->webroot."hms' target='_blank'><button style='width:100px;height:30px;background-color:#00A0E3;color:white;'> Click Here </button></a></p></center>";
		$message_web.="</div>
		<br/>
		<br/>
		www.housingmatters.co.in
		</div >
		</div>";

		$reply="support@housingmatters.in";
		$subject="[".$s_name."]-".$question;
		$from_name="HousingMatters";
		$this->loadmodel('email');
		$conditions=array("auto_id" => 4);
		$result_email = $this->email->find('all',array('conditions'=>$conditions));
		foreach ($result_email as $collection) 
		{
		$from=$collection['email']['from'];
		}

		foreach($visible_email as $to)
		{
		  $this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
		}
		?>
		<!----alert-------------->
		<div class="modal-backdrop fade in"></div>
		<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-body" style="font-size:16px;">
		<?php echo $s_message; ?>
		</div> 
		<div class="modal-footer">
		<a href="Polls" class="btn green">OK</a>
		</div>
		</div>
		<!----alert-------------->
		<?php


		}
		
	}
	
}



function poll_approve_ajax()
{
	$this->layout="blank";	
	$s_society_id=$this->Session->read('society_id');
	 $poll_id=(int)$this->request->query('p_id');
	
	 $ip=$this->hms_email_ip();
	 $this->loadmodel('poll');
	$conditions=array('poll_id'=>$poll_id);
	$result=$this->poll->find('all',array('conditions'=>$conditions));
	
	foreach($result as $data)
	{
		 $user_id=$data['poll']['user_id'];
		 $visible=$data['poll']['visible'];
		 $sub_visible=$data['poll']['sub_visible'];
		 $question=$data['poll']['question'];
		 $choice=$data['poll']['choice'];
		 $description=$data['poll']['des'];
	}
	
	
if($visible==1)
{	
$visible=1;
$sub_visible[]=0;
/////////////////////////////////////////// All user ////////////////////////////
$result_user= $this->all_user_deactive();
foreach($result_user as $data)
		{
		$visible_user_id[]=$data['user']['user_id'];
		$visible_mobile[]=$data['user']['mobile'];
		$visible_email[]=$data['user']['email'];
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
		$visible_user_id[]=$data['user']['user_id'];
		$visible_mobile[]=$data['user']['mobile'];
		$visible_email[]=$data['user']['email'];
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
		$visible_user_id[]=$data['user']['user_id'];
		$visible_mobile[]=$data['user']['mobile'];
		$visible_email[]=$data['user']['email'];
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
		$visible_user_id[]=$data['user']['user_id'];
		$visible_mobile[]=$data['user']['mobile'];
		$visible_email[]=$data['user']['email'];
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
		$visible_user_id[]=$data['user']['user_id'];
		$visible_mobile[]=$data['user']['mobile'];
		$visible_email[]=$data['user']['email'];
		
		}

//////////////////////////////// end mail ////////////////////////////////////////////////////////	

}

}
	
$visible_user_id_new = array_unique($visible_user_id);	

/* $message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br>
<p>A new poll has been created on your society poll booth.</p>

<div style='border:solid 1px #ccc;padding:10px;'>
<span style='color:#00A0E3;'>$question<span><br/>
<span style='color:#000;font-size:12px;'>$description<span>
<hr>";
$message_web.="<ol Type='A' >";
foreach($choice as $data)
{
$message_web.="<li ><span style='font-size:14px;'>".$data[0]."</span></li>";
}
$message_web.="</ol>";
$message_web.="<center><p>To view / vote
<a href='$ip".$this->webroot."hms' target='_blank'><button style='width:100px;height:30px;background-color:#00A0E3;color:white;'> Click Here </button></a></p></center>";
$message_web.="</div>
<br/>
<br/>
www.housingmatters.co.in
</div >
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
											<span style="color:rgb(100,100,99)"> A new poll has been created on your society poll booth. </span>
									</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px; border: solid 1px #ccc;" width="100%">
										
										<span style="color:#00A0E3;">'.$question.'</span><br/>
										<p style="color:#000;font-size:12px;" align="justify">'.$description.'</p>
																			
										</td>
								
								
								</tr>
								
								<tr>
										<td style="padding:5px;border: solid 1px #ccc;" width="100%">';
											
										$message_web.="<ol Type='A' >";
										foreach($choice as $data)
										{
										$message_web.="<li ><span style='font-size:14px;'>".$data[0]."</span></li>";
										}
										$message_web.="</ol>";

																		
										$message_web.='</td>
								
								
								</tr>
								
								
								<tr>
										<td style="padding:10px;" width="100%" align="center">
										<a href="'.$ip.$this->webroot.'/Polls/polls" style="width: 100px; min-height: 30px; background-color: rgb(0, 142, 213); padding: 10px; font-family: Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif; white-space: nowrap; font-weight: bold; vertical-align: middle; font-size: 14px; line-height: 14px; color: rgb(255, 255, 255); border: 1px solid rgb(2, 106, 158); text-decoration: none;" target="_blank">view / vote on HousingMtters</a>
										</td>
								</tr>
					

								<tr>
								<td style="" width="100%" align="left">
								<p align="justify">	www.housingmatters.in </p>
								</td>
								</tr>

					
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';

		$result1=$this->society_name($s_society_id);
		foreach($result1 as $data)
		{
			$s_name=$data['society']['society_name'];
			
		}
	  	$reply="donotreply@housingmatters.in";
		
		$subject="[".$s_name."]- New Poll: ".$question;
		$from_name="HousingMatters";
		$this->loadmodel('email');
		$conditions=array("auto_id" => 4);
		$result_email = $this->email->find('all',array('conditions'=>$conditions));
		foreach ($result_email as $collection) 
		{
		$from=$collection['email']['from'];
		}

		foreach($visible_email as $to)
		{
			if(!empty($to))
			{	
			  $this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
			}
		}
	
	////////////// notification code start ////////////////////
	
	
	
$this->send_notification('<span class="label" style="background-color:#46b8da;"><i class="icon-question-sign"></i></span>','New Poll <b>'.$question.'</b> started by',7,$poll_id,$this->webroot.'Polls/polls',$user_id,$visible_user_id_new);

	
	//////// end notification code //////////////////////////
	
	
	
		$this->loadmodel('poll');
		$this->poll->updateAll(array("deleted" => 0,'visible_user_id' => $visible_user_id_new),array('poll_id'=>$poll_id));
		
}

function poll_approve_reject()
{
		$this->layout="blank";
		$poll_id=(int)$this->request->query("con");
		$this->loadmodel('poll');
		$this->poll->updateAll(array("deleted" => 5),array('poll_id'=>$poll_id));
		$this->response->header('location','poll_approve');
}

function poll_approve()
{
	
	if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}

	$this->check_user_privilages();
	$s_society_id=$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$this->set('s_user_id',$s_user_id);
	$current_date=date("Y-m-d");
	$current_date = new MongoDate(strtotime($current_date));
	$this->loadmodel('poll');
	$conditions=array("society_id" => $s_society_id,"deleted" => 4,'close_date' => array('$gt' => $current_date));
	$order=array('poll.poll_id'=>'DESC');
	$result=$this->poll->find('all', array('conditions' => $conditions,'order' => $order));
			foreach($result as $dda)
			{
				$id=(int)$dda['poll']['poll_id'];
				$this->seen_notification(7,$id);

			}

	$this->set('result_poll',$result);
	
}



function polls()
{
$this->layout='session';
$this->ath();
$this->check_user_privilages();
//$this->seen_notification(1,$hd_id);
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$this->set('s_user_id',$s_user_id);

$current_date=date("Y-m-d");
$current_date = new MongoDate(strtotime($current_date));

$this->loadmodel('poll');
$conditions=array("society_id" => $s_society_id,"visible_user_id" =>array('$in' => array($s_user_id)),"deleted" => 0,'close_date' => array('$gt' => $current_date));
$order=array('poll.poll_id'=>'DESC');
$result_poll=$this->poll->find('all', array('conditions' => $conditions,'order' => $order));
$this->set('result_poll',$result_poll);

	foreach($result_poll as $poll)
	{
		$this->seen_alert(7,$poll["poll"]["poll_id"]);
	}
}

function my_polls()
{
$this->layout='session';
$this->ath();
$this->check_user_privilages();

$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$this->set('s_user_id',$s_user_id);

if (isset($this->request->data['edit_save'])) 
{
$p_id=(int)$this->request->data['poll_id'];
$poll_des=htmlentities($this->request->data['poll_des']);

$this->loadmodel('poll');
$this->poll->updateAll(array('des'=>$poll_des),array('poll.poll_id'=>$p_id));

}

if (isset($this->request->data['delete_save'])) 
{
$p_id=(int)$this->request->data['poll_id_d'];

$this->loadmodel('poll');
$this->poll->updateAll(array('deleted'=>1),array('poll.poll_id'=>$p_id));

}


$this->loadmodel('poll');
$conditions=array("user_id" => $s_user_id,"deleted" => 0);
$order=array('poll.poll_id'=>'DESC');
$this->set('result_poll',$this->poll->find('all', array('conditions' => $conditions,'order' => $order)));
}

function closed_polls()
{
$this->layout='session';
$this->ath();
$this->check_user_privilages();

$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$this->set('s_user_id',$s_user_id);

$current_date=date("Y-m-d");
$current_date = new MongoDate(strtotime($current_date));

$this->loadmodel('poll');
$conditions=array("society_id" => $s_society_id,"visible_user_id" =>array('$in' => array($s_user_id)),"deleted" => 0,'close_date' => array('$lt' => $current_date));
$order=array('poll.poll_id'=>'DESC');
$result_poll=$this->poll->find('all', array('conditions' => $conditions,'order' => $order));
$this->set('result_poll',$result_poll);


	foreach($result_poll as $poll)
	{
		$this->seen_alert(7,$poll["poll"]["poll_id"]);
	}
}

function polls_approve()
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$this->ath();

$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$this->set('s_user_id',$s_user_id);


$this->loadmodel('poll');
$conditions=array("society_id" => $s_society_id,"approved" => 0,"deleted" => 0);
$order=array('poll.poll_id'=>'DESC');
$this->set('result_poll',$this->poll->find('all', array('conditions' => $conditions,'order' => $order)));
}

function poll_approve_reject_submit()
{
$this->layout='blank';
$this->ath();

$p_id=(int)$this->request->query('p_id');
$a_r=(int)$this->request->query('a_r');

if($a_r==1)
{	
$this->loadmodel('poll');
$this->poll->updateAll(array('approved'=>1),array('poll.poll_id'=>$p_id));
}

if($a_r==2)
{	
$comm=$this->request->query('comm');

$this->loadmodel('poll');
$this->poll->updateAll(array('approved'=>2,'reject_comm'=>$comm),array('poll.poll_id'=>$p_id));
echo $comm;
}

}

function poll_view()
{
$this->layout='blank';
$this->ath();

$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$p_id=(int)$this->request->query('id');

$this->loadmodel('poll');
$conditions=array("poll_id" => $p_id);
$this->set('result_poll_detail',$this->poll->find('all', array('conditions' => $conditions)));
}

function poll_save_vote()
{
$this->layout='blank';

$type=(int)$this->request->query('type');
$poll_id=(int)$this->request->query('poll_id');
$c_id=$this->request->query('c_id');

$s_user_id=$this->Session->read('user_id');
$this->set('s_user_id',$s_user_id);

if($type==1)
{
$c_id=(int)$c_id;

$this->loadmodel('poll');
$conditions=array("poll_id" => $poll_id);
$poll_vote=$this->poll->find('all', array('conditions' => $conditions));
$this->set('poll_vote',$poll_vote);
$vote=@$poll_vote[0]['poll']['result'];
if(sizeof($vote)==0)
{
$vote[]=array($s_user_id,$c_id);
}
else
{
$t=array($s_user_id,$c_id);
array_push($vote,$t);
}
$this->poll->updateAll(array('result'=>$vote),array('poll.poll_id'=>$poll_id));
}

if($type==2)
{
$choices_id=explode(",",$c_id);

$this->loadmodel('poll');
$conditions=array("poll_id" => $poll_id);
$poll_vote=$this->poll->find('all', array('conditions' => $conditions));
$this->set('poll_vote',$poll_vote);
$vote=@$poll_vote[0]['poll']['result'];

foreach($choices_id as $ch_id)
{
$ch_id=(int)$ch_id;
if(sizeof($vote)==0)
{
$vote[]=array($s_user_id,$ch_id);
}
else
{
$t=array($s_user_id,$ch_id);
array_push($vote,$t);
}
}

$this->poll->updateAll(array('result'=>$vote),array('poll.poll_id'=>$poll_id));
}
}

function poll_result_after_vote()
{
$this->layout='blank';

$type=(int)$this->request->query('type');
$poll_id=(int)$this->request->query('poll_id');
$c_id=(int)$this->request->query('c_id');

$s_user_id=$this->Session->read('user_id');
$this->set('s_user_id',$s_user_id);

$this->loadmodel('poll');
$conditions=array("poll_id" => $poll_id);
$poll_vote=$this->poll->find('all', array('conditions' => $conditions));
$this->set('poll_vote',$poll_vote);
}



function poll_edit()
{
$this->layout='blank';
$p_id=(int)$this->request->query('p_id');
$edit=(int)$this->request->query('edit');
$this->set('edit',$edit);
if($edit==1)
{
$des=$this->request->query('des');
$c_date=$this->request->query('c_date');

$c_date = date("Y-m-d", strtotime($c_date));
$c_date = new MongoDate(strtotime($c_date));

$this->loadmodel('poll');
$this->poll->updateAll(array('des'=>$des,'close_date'=>$c_date),array('poll.poll_id'=>$p_id));
}

if($edit==0)
{
$this->loadmodel('poll');
$conditions=array("poll_id" => $p_id);
$poll_result=$this->poll->find('all', array('conditions' => $conditions));
$this->set('poll_result',$poll_result);
}

}

function poll_delete()
{
$this->layout='blank';
$p_id=(int)$this->request->query('p_id');
$delete=(int)$this->request->query('delete');
$this->set('delete',$delete);
if($delete==1)
{


$this->loadmodel('poll');
$this->poll->updateAll(array('deleted'=>1),array('poll.poll_id'=>$p_id));
}

if($delete==0)
{
$this->set('poll_id',$p_id);
}

}


function resident_approve() 
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();
$society_id=(int)$this->Session->read('society_id');
$user_id=(int)$this->Session->read('user_id');
$this->seen_notification(100,$user_id);

$this->loadmodel('user_temp');
$conditions=array("society_id"=>$society_id,"complete_signup"=>1,"reject"=>0,"role"=>2);
$result=$this->user_temp->find('all',array('conditions'=>$conditions));
$this->set('result_user_temp',$result);
}


function resident_approve_reply()
{
$this->layout='blank';
$subject=htmlentities($this->request->query('con1'));
$message=htmlentities($this->request->query('con2'));
$message=nl2br($message);
$to=htmlentities($this->request->query('con3'));
$user_id=(int)htmlentities($this->request->query('con4'));
$from_name="HousingMatters";
$from="Support@housingmatters.in";
$reply="Support@housingmatters.in";
$ip=$this->hms_email_ip();

/* $message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
<br/><br/>
<p>$message</p> 
<br/>
Thank you.<br/>
HousingMatters (Support Team)<br/>
www.housingmatters.co.in
</div >
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
										<span style="color:rgb(100,100,99)"> <p align="justify">'.$message.' </p> </span> 
										</td>
								
								
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> 
												Thank you.<br/>
												HousingMatters (Support Team)<br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';
	



$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$this->loadmodel('user_temp');
$this->user_temp->updateAll(array('reply_mail'=>$message),array('user_temp.user_temp_id'=>$user_id));

}

function resident_approve_reject()
{
$this->layout='blank';
$email=$this->request->query('con');
$user_id=(int)$this->request->query('con1');
$this->loadmodel('user_temp');
$this->user_temp->updateAll(array('reject'=>1),array('user_temp.user_temp_id'=>$user_id));
$this->response->header('Location', 'resident_approve');


}


function resident_approve_mail() 
{
	$this->layout='blank';
	$user_temp_id=(int)$this->request->query('con');


// //////////////fetch data user_temp table  ////////////////////
$this->loadmodel('user_temp');
$conditions=array('user_temp_id'=>$user_temp_id);
$result_user_temp=$this->user_temp->find('all',array('conditions'=>$conditions));
foreach ($result_user_temp as $collection) 
{ 
$society_id=(int)$collection['user_temp']['society_id'];
$user_name=$collection['user_temp']['user_name'];
$date=$collection['user_temp']['date'];
$time=$collection['user_temp']['time'];
$mobile=$collection['user_temp']['mobile'];
$email=$collection['user_temp']['email'];
$password=$collection['user_temp']['password'];
$wing=(int)$collection['user_temp']['wing'];
$flat=(int)$collection['user_temp']['flat'];
$committee=(int)$collection['user_temp']['committee'];
$tenant=(int)$collection['user_temp']['tenant'];
//$residing=(int)$collection['user_temp']['residing'];
  @$login_id=(int)$collection['user_temp']['login_id'];
  @$multiple_society=$collection['user_temp']['multiple_society'];
}
///////////end fetch data ////////////////////

///// flat already exit checked code start ////////////////

$this->loadmodel('user_flat');

$conditions=array('flat_id'=>$flat,'society_id'=>$society_id,'active'=>0,'family_member'=>array('$ne'=>1));
$result_user=$this->user_flat->find('all',array('conditions'=>$conditions));
$n5=sizeof($result_user);
if($n5==1){
	$tenant_database=$result_user[0]['user_flat']['status'];
	if($tenant_database==1){
		if($tenant_database==$tenant){
			
			echo'<tr><td colspan="9">This flat is already exist owner.</td></tr>';
			exit;
		}
		
		
	}else{
		
		if($tenant_database==$tenant){
			
			echo'<tr><td colspan="9">This flat is already exist tenant.</td></tr>';
			exit;
		}
		
		
		
	}
	
}
if($n5==2){
	echo'<tr><td colspan="9">This flat is already exist.</td></tr>';
			exit;
	
}

//////////////////////////////// end cod ///////////////////

$role_id[]=2;
$default_role_id=2;
if($committee==1)
{
$role_id[]=1;
}

$ip=$this->hms_email_ip();

$random1=mt_rand(1000000000,9999999999);
$random2=mt_rand(1000000000,9999999999);
$random=$random1.$random2 ;

//////////////// insert data user table //////////////////////////
$this->loadmodel('user');
$i=$this->autoincrement('user','user_id');
$de_user_id=$this->encode($i,'housingmatters');
$random=$de_user_id.'/'.$random;


if($multiple_society==0)
{
	$login_id=$this->autoincrement('login','login_id');
	$s_default=1;
	$this->loadmodel('login');
	$this->login->save(array('login_id'=>$login_id,'user_name'=>$email,'mobile'=>$mobile,'signup_random'=>$random,'password'=>$random));
	
}
if($multiple_society==1)
{
	$s_default=0;
}


$this->user->save(array('user_id' => $i, 'user_name' => $user_name,'email' => $email, 'password' => $password, 'mobile' => $mobile,  'society_id' => $society_id, 'tenant' => $tenant, 'wing' => $wing, 'flat' => $flat,'date' => $date, 'time' => $time,"profile_pic"=>'blank.jpg','sex'=>'','role_id'=>$role_id,'default_role_id'=>$default_role_id,'signup_random'=>$random,'deactive'=>0,'login_id'=>$login_id,'profile_status'=>1,'s_default'=>$s_default,'private'=>array('mobile','email')));

//$this->loadmodel('flat');
//$this->flat->updateAll(array("noc_ch_tp" =>$residing),array("flat_id" =>$flat));	

$user_flat_id=$this->autoincrement('user_flat','user_flat_id');
$this->user_flat->saveAll(array('user_flat_id'=>$user_flat_id,'user_id'=>$i,'society_id'=>$society_id,'flat_id'=>$flat,'status'=>$tenant,'active'=>0,'exit_date'=>'','time'=>''));


//////////////// end insert code  //////////////////////////

///////////////  Insert code ledger Sub Accounts //////////////////////
if($tenant==1){
$this->loadmodel('ledger_sub_account');
$j=$this->autoincrement('ledger_sub_account','auto_id');
$this->ledger_sub_account->save(array('auto_id'=>$j,'ledger_id'=>34,'name'=>$user_name,'society_id' => $society_id,'user_id'=>$i,'deactive'=>0,"flat_id"=>$flat));
}
/////////////  End code ledger sub accounts //////////////////////////

///////////////////////////////////////////// approve mail functionality ///////////////////////////////////////
if($multiple_society==0)
{
$to=$email;

/*
echo $message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Dear  $user_name,</p>
<p>Congratulations! Welcome to HousingMatters...making life simpler for</p>
<p>managing your housing society affairs.</p><br/>
<p>Your registration request has been successfully approved.</p><br/>
<p><a href='$ip".$this->webroot."/hms/send_sms_for_verify_mobile?q=$random'>Click here</a> for one time verification of your mobile number and Login into HousingMatters</p>
<p>For any assistance, please email us on support@housingmatters.in</p>
<p>alternatively, feel free to get in touch via our online chat support.</p><br/>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.co.in
</div >
</div>"; */



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
										
										  <p align=""> Dear '.$user_name.',</p>
										  <p align="">Congratulations! Welcome to HousingMatters...making life simpler for</p>
										  <p align="">managing your housing society affairs.</p>
										  <p align="">Your registration request has been successfully approved.</p>
										  <p align=""><a href="'.$ip.$this->webroot.'hms/send_sms_for_verify_mobile?q='.$random.'" style="width:100px; height:30px;">Click here</a> for one time verification of your mobile number and Login into HousingMatters </p>
										  <p align="">For any assistance, please email us on support@housingmatters.in</p>
										  <p align="">alternatively, feel free to get in touch via our online chat support.</p>
										 
										</td>
								
								
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> 
												Thank you.<br/>
												HousingMatters (Support Team)<br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';
	
$subject="Welcome to HousingMatters";
$from_name="HousingMatters";
$reply="support@housingmatters.in";
$this->loadmodel('email');
$conditions=array('auto_id'=>4);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
}
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);

}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////Notification email user all checked code  //////////////////////////

$this->loadmodel('email');	
$conditions=array('notification_id'=>1);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach($result_email as $data)
{
$auto_id = (int)$data['email']['auto_id'];
$this->loadmodel('notification_email');
$lo=$this->autoincrement('notification_email','notification_id');
$this->notification_email->saveAll(array("notification_id" => $lo, "module_id" => $auto_id , "user_id" => $i,'chk_status'=>0));
}

//////////////// End all checked code   //////////////////////////



//////////////// Remove entry user_temp table  //////////////////////////
$this->loadmodel('user_temp');
$conditions=array('user_temp_id'=>$user_temp_id);
$this->user_temp->deleteAll($conditions);
//$this->user_temp->deleteAll(array('user_temp.user_temp_id' => true), false);

//////////////// End Remove entry user_temp table  //////////////////////////

}


function resident_approve_resend_sms()
{
	
$this->layout='blank';
$user_temp_id=(int)$this->request->query('con');

$s_society_id=(int)$this->Session->read('society_id');
$result_society=$this->society_name($s_society_id);
foreach($result_society as $dd)
{
  $society_name=$dd['society']['society_name'];
}

$s_n='';
$sco_na=$society_name;
$dd=explode(' ',$sco_na);
$first=$dd[0];
$two=$dd[1];
$three=$dd[2];
$s_n.=" $first $two $three ";

$this->loadmodel('user');
$conditions=array('user_id'=>$user_temp_id);
$result_user=$this->user->find('all',array('conditions'=>$conditions));
foreach($result_user as $data)
{
	 $mobile=$data['user']['mobile'];
	 $user_name=$data['user']['user_name'];
	 $login_id=(int)$data['user']['login_id'];
}

 $r_sms=$this->hms_sms_ip();
  $working_key=$r_sms->working_key;
 $sms_sender=$r_sms->sms_sender; 
$sms_allow=(int)$r_sms->sms_allow;
if($sms_allow==1){
$random=(string)mt_rand(1000,9999);
$sms="".$user_name.", Your housing society ".$s_n." has enrolled you in HousingMatters portal. Pls log into www.housingmatters.co.in One Time Password ".$random."";
$sms1=str_replace(" ", '+', $sms);
$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms1.'');
 
 }
$this->loadmodel('user');
$this->user->updateAll(array('password'=>$random,'signup_random'=>$random),array('user_id'=>$user_temp_id));
$this->loadmodel('login');
$this->login->updateAll(array('password'=>$random,'signup_random'=>$random),array('login_id'=>$login_id));
}


function resident_approve_resend_mail() 
{
$this->layout='blank';
$user_temp_id=(int)$this->request->query('con');

$s_society_id=(int)$this->Session->read('society_id');
// //////////////fetch data user_temp table  ////////////////////
$this->loadmodel('user');
$conditions=array('user_id'=>$user_temp_id);
$result_user_temp=$this->user->find('all',array('conditions'=>$conditions));
foreach ($result_user_temp as $collection) 
{ 
$society_id=(int)$collection['user']['society_id'];
$user_name=$collection['user']['user_name'];
$mobile=$collection['user']['mobile'];
$email=$collection['user']['email'];
$password=$collection['user']['password'];
$wing=(int)$collection['user']['wing'];
$flat=(int)$collection['user']['flat'];
$tenant=(int)$collection['user']['tenant'];
//$residing=(int)$collection['user']['residing'];

}
///////////end fetch data ////////////////////

if(!empty($email) and !empty($mobile)){
		
	$page_name='send_sms_for_verify_mobile';		
	
}else{
	
	$page_name='set_new_password';
}




$random1=mt_rand(1000000000,9999999999);
$random2=mt_rand(1000000000,9999999999);
$random=$random1.$random2 ;

//////////////// insert data user table //////////////////////////
$ip=$this->hms_email_ip();
$de_user_id=$this->encode($user_temp_id,'housingmatters');
$random=$de_user_id.'/'.$random;


$this->loadmodel('user');
$this->user->updateAll(array('signup_random'=>$random,'one_time_sms'=>0),array('user.user_id'=>$user_temp_id));



//////////////// end insert code  //////////////////////////

$this->loadmodel('society');
$conditions12=array('society_id'=>$s_society_id);
$result12=$this->society->find('all',array('conditions'=>$conditions12));
foreach($result12 as $data)
{
$s_name=$data['society']['society_name'];
}
///////////////////////////////////////////// approve mail functionality ///////////////////////////////////////
$special="'";
$to=$email;
 /* $message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
<p style='color:green;'><strong>Reminder!</strong></p>
<p>Dear  $user_name,</p>
<p>'We at $s_name use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent &amp; smart management of housing society affairs.</p>
<p>As you are an owner/resident/staff of $s_name, we have added your email address in HousingMatters portal.</p>
<p>Here are some of the important features related to our portal on HousingMatters:</p>

<li>log &amp; track complaints</li>
<li>start new discussions</li>
<li>check your maintenance dues</li>
<li>post classifieds</li>
<li>receive important SMS &amp; emails from your committee</li>
<li>and much more in the portal.</li>



<p><b><a href='$ip".$this->webroot."/hms/$page_name?q=$random' target='_blank'><button style='width:100px; height:30px;  background-color:#00A0E3;color:white'>Click here</button></a> for one time verification of your mobile number and Login into HousingMatters  for making life simpler for all your housing matters!</b></p>


<p>Regards,</p>
<p>Administrator of $s_name</p>

<p>PS: add <a href='http://www.housingmatters.co.in' target='_blank'>www.housingmatters.co.in</a> in your favorite bookmarks for future use.</p>



</div >
</div>"; */


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
								</tr>
								
									
								
						</tbody>
					</table>
					
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						

									<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span style="color:rgb(100,100,99)" align="justify"> <p style="color:green;"><strong>Reminder!</strong></p> </span> 
										</td>
																
									</tr>
									<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span  align="justify"> Dear '.$user_name.', </span> 
										</td>
																
									</tr>

								<tr>
										<td style="padding:5px;" width="100%" align="left">
										 '.$special.'We at '.$s_name.' use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.
										
										
										
										
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										As you are an owner/resident/staff of '.$s_name.', we have added your email address in HousingMatters portal.
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
												Here are some of the important features related to our portal on HousingMatters:
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
											<ul>
													<li>log &amp; track complaints</li>
													<li>start new discussions</li>
													<li>check your maintenance dues</li>
													<li>post classifieds</li>
													<li>receive important SMS &amp; emails from your committee</li>
													<li>and much more in the portal.</li>
											</ul>		
										</td>
																
								</tr>

									
								<tr>
										<td style="padding:5px;" width="100%" align="left"><br/>
											<span  align="justify"> <b>
											<a href="'.$ip.$this->webroot.'hms/'.$page_name.'?q='.$random.'" style="text-decoration:none;" > Click here </a> for one time verification of your mobile number and Login into HousingMatters for making life simpler for all your housing matters!</b>
											</span> 
										</td>
																
								</tr>
								
								
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span > 
												Regards,<br/>
												Administrator of '.$s_name.'<br/>
												PS: add <a href="http://www.housingmatters.in" target="_blank" style="text-decoration:none;">www.housingmatters.in</a> in your favorite bookmarks for future use.
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';

$subject="[$s_name]";
$from_name="HousingMatters";
$reply="support@housingmatters.in";
$this->loadmodel('email');
$conditions=array('auto_id'=>4);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
}
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



}



function resend_email()
{
$this->layout='session';

$this->loadmodel('user');
$conditions=array('user.profile_status'=> array('$ne' => 2));
$this->set('result_not_login',$this->user->find('all',array('conditions'=>$conditions)));

}

function set_new_password()
{


$this->layout='without_session';
$this->set('webroot_path',$this->webroot_path());
 $q=$this->request->query['q'];

$q_new=explode('/',$q);
$q_new[0];

$user_id=(int)$this->decode($q_new[0],'housingmatters');
$randm=$q_new[1];


		$result_user=$this->profile_picture($user_id);
		$tenant=@$result_user[0]['user']['tenant'];
		$society_id=@$result_user[0]['user']['society_id'];
		$result_society=$this->society_name($society_id);
		$access_tenant=@$result_society[0]['society']['access_tenant'];

		if($tenant==2 && $access_tenant==0){
			$this->redirect(array('action' => 'tenant_access'));

		 }

$this->loadmodel('user');
$conditions =array( '$or' => array( 
array('user_id'=> $user_id,'signup_random'=>$q),
array('user_id'=> $user_id,'signup_random'=>$randm),
));
//$conditions=array('user_id'=> $user_id,'signup_random'=>$q);
$result_check=$this->user->find('all',array('conditions'=>$conditions));
$n= sizeof($result_check);

if($n>0)
{ 

}
else
{
echo "Sorry, you have used this link.This link is one time login link.";	
exit;
}

if ($this->request->is('POST')) 
{
$pass=$this->request->data['pass'];

$this->loadmodel('user');
$conditions=array('user_id'=> $user_id); 
$result_user=$this->user->find('all',array('conditions'=>$conditions));
$n= sizeof($result_user);
if($n>0)
{ 
foreach ($result_user as $collection) 
{
$user_id=$collection['user']["user_id"];
$login_id=$collection['user']["login_id"];
$society_id=$collection['user']["society_id"];
$user_name=$collection['user']["user_name"];
$role_id=$collection['user']["default_role_id"];
$profile_status=@$collection['user']["profile_status"];
}

$this->loadmodel('user');
$this->user->updateAll(array('profile_status'=>1),array('user.user_id'=>$user_id));
$this->Session->write('user_id', $user_id);
$this->Session->write('login_id', $login_id);
$this->Session->write('role_id', $role_id);
$this->Session->write('society_id', $society_id);
$this->Session->write('user_name', $user_name);
$this->loadmodel('user');
$this->user->updateAll(array('password'=>$pass,'signup_random'=>'','deactive'=>0),array('user.user_id'=>$user_id));
$this->loadmodel('login');
$this->login->updateAll(array('password'=>$pass,'signup_random'=>''),array('login.login_id'=>$login_id));
$this->redirect(array('action' => 'dashboard'));
}

}

}





function verify_email()
{
$var=1;	
$this->layout='without_session';
@$q=$this->request->query['q'];
$q_new=explode('/',$q);
$q_new[0];
$user_id=(int)$this->decode($q_new[0],'housingmatters');
$randm=$q_new[1];
$this->loadmodel('user');
$conditions=array('user_id'=> $user_id); 
$result_user=$this->user->find('all',array('conditions'=>$conditions));
foreach ($result_user as $collection) 
{
$email=$collection['user']["email"];
}
$this->set('email',$email);


if (isset($this->request->data['login'])) 
{
	$ip=$this->hms_email_ip();
$var=2;
$captch=htmlentities($this->request->data['name']);
$this->loadmodel('user');
$conditions=array("user_id" => $user_id,"password" => $captch);
$result2 = $this->user->find('all',array('conditions'=>$conditions));
$n2 = sizeof($result2);
if($n2>0)
{
	$this->response->header('Location', 'set_new_password?q='.$q.' ');
}
else
{
$this->set('error', '<label style="color:red;">you have entered incorrect code</label>');
}
}

$this->loadmodel('user');
$conditions=array('user_id'=> $user_id,'signup_random'=>$q);
$result_check=$this->user->find('all',array('conditions'=>$conditions));
$n= sizeof($result_check);
if($n>0)
{ 
$random_otp=(string)mt_rand(1000,9999);

if($var==1)
{
$this->loadmodel('user');
$this->user->updateAll(array('password'=>$random_otp),array('user.user_id'=>$user_id));
$from_name="HousingMatters";
$reply="support@housingmatters.in";
$to=$email;
$this->loadmodel('email');
$conditions=array("auto_id" => 4);
$result_email = $this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
}
$subject="Verification your email";
$message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
<p>Hello! Please enter your code $random_otp  on the signup
screen to continue your HousingMatters
registration process.</p>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.co.in
</div >
</div>";
$this->smtpmailer($to,$from,$from_name,$subject,$message_web,$reply);
}
}
else
{
echo "Sorry, you have used this link.This link is one time login link.";	
exit;
}

}

function send_sms_for_verify_mobile(){
	$this->layout=null;
	$q=$this->request->query['q'];

	$q_new=explode('/',$q);
	$q_new[0];

	$user_id=(int)$this->decode($q_new[0],'housingmatters');
	$randm=$q_new[1];
	
	$this->loadmodel('user');
	$conditions=array('user_id'=> $user_id); 
	$result_user=$this->user->find('all',array('conditions'=>$conditions));
	foreach ($result_user as $collection) 
	{
	$mobile=$collection['user']["mobile"];
	}
	
	$this->loadmodel('user');
	$conditions=array('user_id'=> $user_id,'signup_random'=>$q);
	$result_check=$this->user->find('all',array('conditions'=>$conditions));
	foreach($result_check as $data9)
	{
		$user_name=$data9['user']['user_name'];
		$deactive=$data9['user']['deactive'];
		$one_time_sms=(int)@$data9['user']["one_time_sms"];
	}
	$n= sizeof($result_check);
	if($n>0){ 
	$random_otp=(string)mt_rand(1000,9999);


	$user_name=$this->check_charecter_name($user_name);
	//$dd=explode(' ',$user_name);
	//$user_name=$dd[0];
	$user_name=ucfirst($user_name);
	$r_sms=$this->hms_sms_ip();
	$working_key=$r_sms->working_key;
	$sms_sender=$r_sms->sms_sender; 	
	$sms_allow=(int)$r_sms->sms_allow;
	if($sms_allow==1){	

	$sms='Hi ! '.$user_name.', your one time activation code is '.$random_otp.' to continue your enrollment. If irrelevant contact info@housingmatters.in . ';

	$sms1=str_replace(' ', '+', $sms);

	$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms1.'');
	}
	$this->user->updateAll(array('password'=>$random_otp,'one_time_sms'=>1),array('user.user_id'=>$user_id));


	$this->response->header('Location', 'verify_mobile?q='.$q.' ');
	}
	else
	{
	echo "Sorry, you have used this link.This link is one time login link.";	
	exit;
	}

}
function verify_mobile()
{

$var=1;
$this->set('webroot_path',$this->webroot_path());
$this->layout='without_session';
$q=$this->request->query['q'];

$q_new=explode('/',$q);
$q_new[0];

$user_id=(int)$this->decode($q_new[0],'housingmatters');

$randm=$q_new[1];
$this->set('user_id',$user_id);
$this->loadmodel('user');
$conditions=array('user_id'=> $user_id); 
$result_user=$this->user->find('all',array('conditions'=>$conditions));
foreach ($result_user as $collection) 
{
$mobile=$collection['user']["mobile"];
}
$this->set('mobb',@$mobile);

if (isset($this->request->data['login'])) 
{
$var=2;
$captch=htmlentities($this->request->data['name']);
$this->loadmodel('user');
$conditions=array("user_id" => $user_id,"password" => $captch);
$result2 = $this->user->find('all',array('conditions'=>$conditions));

$n2 = sizeof($result2);
if($n2>0)
{
	$this->response->header('Location', 'set_new_password?q='.$q.' ');

}
else
{
$this->set('error', '<label style="color:red;">you have entered incorrect code</label>');
}


}


/*$this->loadmodel('user');
$conditions=array('user_id'=> $user_id,'signup_random'=>$q);
$result_check=$this->user->find('all',array('conditions'=>$conditions));
foreach($result_check as $data9)
{
	$user_name=$data9['user']['user_name'];
	$deactive=$data9['user']['deactive'];
	$one_time_sms=(int)@$data9['user']["one_time_sms"];
}
$n= sizeof($result_check);
if($n>0)
{ 
$random_otp=(string)mt_rand(1000,9999);

if($one_time_sms==0)
{

$dd=explode(' ',$user_name);
  $user_name=$dd[0];
  $user_name=ucfirst($user_name);
$r_sms=$this->hms_sms_ip();
  $working_key=$r_sms->working_key;
 $sms_sender=$r_sms->sms_sender; 	
	
//$sms='Dear '.$user_name.' Please enter your code '.$random_otp.' on the signup screen to continue your HousingMatters registration process. Thank you';
// $sms=''.$random_otp.' is your One Time Passcode, please enter on the signup screen to continue your HousingMatters registration process.';
  $sms='Hi ! '.$user_name.', Use '.$random_otp.' as one time passcode and continue your Housing Matters registration process. ';

$sms1=str_replace(' ', '+', $sms);

@// //sms-closed// $payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms1.'');
//$this->user->updateAll(array('password'=>$random_otp,'one_time_sms'=>1),array('user.user_id'=>$user_id));

}

}
else
{
echo "Sorry, you have used this link.This link is one time login link.";	
exit;
}*/

}


function verify_mobile_ajax()
{
	
	$this->layout='blank';
	$id=(int)$this->request->query['con'];
	$this->loadmodel('user');
	$result=$this->user->find('all',array('conditions'=>array('user_id'=>$id)));
	foreach($result as $data)
	{
		 $mobile= $data['user']['mobile'];
		 $user= $data['user']['user_name'];
	}
	$user_name=$this->check_charecter_name($user);
	//$dd=explode(' ',$user);
	//$user_name=$dd[0];
	$user_name=ucfirst($user_name);
	
$r_sms=$this->hms_sms_ip();
$working_key=$r_sms->working_key;
$sms_sender=$r_sms->sms_sender; 
$random_otp=(string)mt_rand(1000,9999);
$sms_allow=(int)$r_sms->sms_allow;
if($sms_allow==1){

$sms='Hi ! '.$user_name.', Use '.$random_otp.' as one time passcode and continue your Housing Matters registration process. ';
$sms1=str_replace(' ', '+', $sms);
$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms1.'');
}

$this->user->updateAll(array('password'=>$random_otp),array('user.user_id'=>$id));

}
///////////////////////////////// Start Society Approve ///////////////////////////////////////////
function society_approve()
{

$this->layout='session';
$this->ath();
$this->check_housingmatters_privilages();
$society_id=(int)$this->Session->read('society_id');
$user_id=(int)$this->Session->read('user_id');
$this->loadmodel('user_temp');
$conditions=array("complete_signup"=>1,"reject"=>0,"role"=>3);
$result=$this->user_temp->find('all',array('conditions'=>$conditions));
$this->set('result_user_temp',$result);
}


function new_society_enrollment()
{
$this->layout='session';
$this->ath();
if ($this->request->is('POST')) 
{
	$ip=$this->hms_email_ip();
 $society_name=htmlentities($this->request->data['society_name']);
 $user_name=htmlentities($this->request->data['user_name']);
 $email=htmlentities($this->request->data['email']);
 $mobile=htmlentities($this->request->data['mobile']);
 $pin_code=htmlentities($this->request->data['pin_code']);
 $association=htmlentities($this->request->data['association']);
 $no_flat=htmlentities($this->request->data['no_flat']);
 $i=$this->autoincrement('user','user_id');
 $society_id=$this->autoincrement('society','society_id');  
 $random1=mt_rand(1000000000,9999999999);
$random2=mt_rand(1000000000,9999999999);
$random=$random1.$random2 ;	
$de_user_id=$this->encode($i,'housingmatters');
$random=$de_user_id.'/'.$random;
$log_i=$this->autoincrement('login','login_id');

//////////////////////////////////////// Insert society table ////////////////////////////////////////

$this->loadmodel('society');
$this->society->save(array('society_id' => $society_id, 'society_name' => $society_name, 
'association_formed' => $association, 'user_id' => $i,"aprvl_status"=>1,"pin_code"=>$pin_code,"flats"=>$no_flat));
 
/////////////////////////////////////// End code /////////////////////////////////////////////////
 
 
//////////////////////////////////////// Insert data user table ///////////////////// ///////////////////////////////////
date_default_timezone_set('Asia/kolkata');
$date=date("d-m-Y");
$time=date('h:i:a',time());
$role_id[]=3;
$default_role_id=3;
$this->loadmodel('user');
$this->user->save(array('user_id' => $i, 'user_name' => $user_name,'email' => $email, 'password' =>'', 'mobile' => $mobile,  'society_id' => $society_id, 'tenant' => 1, 'wing' =>0, 'flat' =>0,'date' => $date, 'time' => $time,"profile_pic"=>'blank.jpg','sex'=>'','role_id'=>$role_id,'default_role_id'=>$default_role_id,'signup_random'=>$random,'deactive'=>0,'login_id'=>$log_i,'s_default'=>1,'profile_status'=>1,'private'=>array('mobile','email')));

$user_flat_id=$this->autoincrement('user_flat','user_flat_id');
$this->user_flat->saveAll(array('user_flat_id'=>$user_flat_id,'user_id'=>$i,'society_id'=>$society_id,'flat_id'=>0,'status'=>1,'active'=>0,'exit_date'=>'','time'=>''));

//////////////////////////////////// End Code ////////////////////////////////////////////////////////////////////////

////////////////////////////// Mail functionality /////////////////////////////////////////////////////////////////


/////////////////////////////////////// Mail functinality //////////////////////////////////////

/* $message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
<br/><br/>Login-Id: $email<br/>
<p> Password: <b>
<a href='$ip".$this->webroot."/hms/send_sms_for_verify_mobile?q=$random'>Click here</a> for one time verification of your mobile number and Login into HousingMatters  for making life simpler for all your housing matters!</b></p> <br/>
Congratulations your registration request has been successfully approved  <br/>
<br/>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.co.in
</div >
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
										<span style="color:rgb(100,100,99)" align="justify"> Login-Id: '.$email.' </span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)" align="justify"> <p> Password: <b>
											<a href="'.$ip.$this->webroot.'hms/send_sms_for_verify_mobile?q='.$random.'"> Click here </a> for one time verification of your mobile number and Login into HousingMatters for making life simpler for all your housing matters!</b></p>
											<p>Congratulations your registration request has been successfully approved  
											</p></span> 
										</td>
																
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> 
												Thank you.<br/>
												HousingMatters (Support Team)<br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';

		
$from_name="HousingMatters";
$this->loadmodel('email');
$conditions=array('auto_id'=>4);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
$subject=$collection['email']['subject'];
}
$reply=$from;
$to=$email;
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);

///////////////////////////////// End Mail functionality //////////////////////////////////////////////////////////

////////////////////////////// Notification email checked code start////////////////////////////////////////////////////////
$this->loadmodel('email');	
$conditions=array('notification_id'=>1);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach($result_email as $data)
{
$auto_id = (int)$data['email']['auto_id'];
$this->loadmodel('notification_email');
$lo=$this->autoincrement('notification_email','notification_id');
$this->notification_email->saveAll(array("notification_id" => $lo, "module_id" => $auto_id , "user_id" => $i,'chk_status'=>0));
}

//////////////////////// /////////////////// End code notification  ////////////////////////////////////////////////////////

///////////////////// login table insert //////////////////////////////////


$this->loadmodel('login');
$this->login->save(array('login_id'=>$log_i,'user_name'=>$email,'password'=>$random,'signup_random'=>$random,'mobile'=>$mobile));

//////////////////// end code login table ///////////////////////////////

//////////////// Role to assign code for Society  //////////////////////////
for($p=1;$p<=4;$p++)
{
if($p==1) { $d="Committee Member"; }
if($p==2) { $d="Resident"; }
if($p==3) { $d="Admin"; }
if($p==4) { $d="Family Member"; }
$this->loadmodel('role');
$k=$this->autoincrement('role','auto_id');
$this->role->saveAll(array("auto_id" => $k, "role_name" => $d, 'role_id'=>$p, "society_id" => $society_id));

}	
//////////////// Role to assign end   //////////////////////////


?>
<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
New society registered successfully.
</div> 
<div class="modal-footer">
<a href="new_society_enrollment" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php

}
}


function society_approve_mail()
{
$this->layout='blank';
$user_temp_id=(int)htmlentities($this->request->query('con1'));
$this->loadmodel('user_temp');
$conditions=array('user_temp_id'=>$user_temp_id); 
$result_user_temp=$this->user_temp->find('all',array('conditions'=>$conditions));
foreach ($result_user_temp as $collection) 
{ 
$society_id=(int)$collection['user_temp']['society_id'];
$user_name=$collection['user_temp']['user_name'];
$date=$collection['user_temp']['date'];
$time=$collection['user_temp']['time'];
$mobile=$collection['user_temp']['mobile'];
$email=$collection['user_temp']['email'];
$password=$collection['user_temp']['password'];
$wing=(int)$collection['user_temp']['wing'];
$flat=(int)$collection['user_temp']['flat'];
$committee=(int)$collection['user_temp']['committee'];
$tenant=(int)$collection['user_temp']['tenant']; 
//$residing=(int)$collection['user_temp']['residing'];
} 
$ip=$this->hms_email_ip();

$i=$this->autoincrement('user','user_id'); 
$random1=mt_rand(1000000000,9999999999);
$random2=mt_rand(1000000000,9999999999);
$random=$random1.$random2 ;	
$de_user_id=$this->encode($i,'housingmatters');
$random=$de_user_id.'/'.$random;
 

/////////////////////////////////////// Mail functinality //////////////////////////////////////

/*$message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
<br/><br/>Login-Id: $email<br/>
<p> Password: <b>
<a href='$ip".$this->webroot."/hms/send_sms_for_verify_mobile?q=$random'>Click here</a> for one time verification of your mobile number and Login into HousingMatters  for making life simpler for all your housing matters!</b></p><br>
Congratulations your registration request has been successfully approved  <br/>
<br/>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.co.in
</div >
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
										<span style="color:rgb(100,100,99)" align="justify"> Login-Id: '.$email.' </span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)" align="justify"> <p> Password: <b>
											<a href="'.$ip.$this->webroot.'hms/send_sms_for_verify_mobile?q='.$random.'"> Click here </a> for one time verification of your mobile number and Login into HousingMatters for making life simpler for all your housing matters!</b></p>
											<p>Congratulations your registration request has been successfully approved  
											</p></span> 
										</td>
																
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> 
												Thank you.<br/>
												HousingMatters (Support Team)<br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';

	
$from_name="HousingMatters";
$this->loadmodel('email');
$conditions=array('auto_id'=>4);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
$subject=$collection['email']['subject'];
}
$reply=$from;
$to=$email;
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);

//////////////////////////////////////// Insert data user table ///////////////////// ///////////////////////////////////

$login_id=$this->autoincrement('login','login_id');

$role_id[]=3;
$default_role_id=3;
$this->loadmodel('user');
$this->user->save(array('user_id' => $i, 'user_name' => $user_name,'email' => $email, 'password' => $password, 'mobile' => $mobile,  'society_id' => $society_id, 'tenant' => $tenant, 'wing' => $wing, 'flat' => $flat,'date' => $date, 'time' => $time,"profile_pic"=>'blank.jpg','sex'=>'','role_id'=>$role_id,'default_role_id'=>$default_role_id,'signup_random'=>$random,'deactive'=>0,'login_id'=>$login_id,'s_default'=>1,'profile_status'=>1,'private'=>array('mobile','email')));

$user_flat_id=$this->autoincrement('user_flat','user_flat_id');
$this->user_flat->saveAll(array('user_flat_id'=>$user_flat_id,'user_id'=>$i,'society_id'=>$society_id,'flat_id'=>$flat,'status'=>$tenant,'active'=>0,'exit_date'=>'','time'=>''));

//////////////////////// insert login table //////////////////////////////////////


$this->loadmodel('login');
$this->login->save(array('login_id'=>$login_id,'user_name'=>$email,'password'=>$random,'signup_random'=>$random,'mobile'=>$mobile));

////////////////////////// End login code ////////////////////////////////////

//////////////////////////////////////////////////// End insert code  /////////////////////////////////////////////////////////////////////////////////

////////////////////////// update approval status in society //////////////////////////////////////////
$this->loadmodel('society');
$this->society->updateAll(array('aprvl_status'=>1,'user_id'=>$i),array('society.user_id'=>$user_temp_id));

/////////////////////////////////////////////////////end code /////////////////////////////////////////////


////////////////////////////// Notification email checked code start////////////////////////////////////////////////////////
$this->loadmodel('email');	
$conditions=array('notification_id'=>1);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach($result_email as $data)
{
$auto_id = (int)$data['email']['auto_id'];
$this->loadmodel('notification_email');
$lo=$this->autoincrement('notification_email','notification_id');
$this->notification_email->saveAll(array("notification_id" => $lo, "module_id" => $auto_id , "user_id" => $i,'chk_status'=>0));
}

//////////////////////// /////////////////// End code notification  ////////////////////////////////////////////////////////


//////////////// Remove entry user_temp table  //////////////////////////
$this->loadmodel('user_temp');
$conditions=array("user_temp_id" => $user_temp_id);
$this->user_temp->deleteAll($conditions);

//////////////// End Remove entry user_temp table  //////////////////////////


//////////////// Role to assign code for Society  //////////////////////////
for($p=1;$p<=4;$p++)
{
if($p==1) { $d="Committee Member"; }
if($p==2) { $d="Resident"; }
if($p==3) { $d="Admin"; }
if($p==4) { $d="Family Member"; }

$this->loadmodel('role');
$k=$this->autoincrement('role','auto_id');
$this->role->saveAll(array("auto_id" => $k, "role_name" => $d, 'role_id'=>$p, "society_id" => $society_id));

}	
//////////////// Role to assign end   //////////////////////////



//////////////////  Ledger account table entry //////////////////////////
/*
$this->loadmodel('ledger_account');
$conditions=array('edit_user_id'=>1);
$result=$this->ledger_account->find('all',array('conditions'=>$conditions));
foreach($result as $data)
{
$group_id=$data['ledger_account']['group_id'];
$ledger_name=$data['ledger_account']['ledger_name'];
$h=$this->autoincrement('ledger_account','auto_id');
	
$this->loadmodel('ledger_account');
$this->ledger_account->saveAll(array('auto_id'=>$h,'ledger_name'=>$ledger_name,'group_id'=>$group_id,'edit_user_id'=>1,'society_id'=>$society_id,'delete_id'=>0));
	
}
*/
//////////////////////////  End account ledger table entry  ///////////////////////////////////////////

}

function society_approve_reject()
{
$this->layout='blank';	
$email=htmlentities($this->request->query('con'));
$user_id=(int)htmlentities($this->request->query('con1'));
$this->loadmodel('user_temp');
$this->user_temp->updateAll(array('reject'=>1),array('user_temp.user_temp_id'=>$user_id));
$this->response->header('Location','society_approve');

}


function role_add()
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();
$s_society_id=$this->Session->read('society_id');

if (isset($this->request->data['add_role'])) 
{
$role_name=$this->request->data['role_name'];
$auto_id=$this->autoincrement('role','auto_id');
$role_id=$this->autoincrement_with_society('role','role_id');



$this->loadmodel('role');
$multipleRowData = Array( Array('auto_id'=>$auto_id,'role_id' => $role_id, 'role_name' => $role_name,'society_id' => $s_society_id));
$this->role->saveAll($multipleRowData); 
}

$this->loadmodel('role');
$conditions=array("society_id" => $s_society_id);
$this->set('result_role',$this->role->find('all',array('conditions'=>$conditions)));


}



function asisgn_module_to_role()
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();
$s_society_id=$this->Session->read('society_id');

//$role_id=$this->request->query('con');

if (isset($this->request->data['add_role'])) 
{
 $role_id=(int)$this->request->data['r_name'];

$this->loadmodel('hm_modules_assign');
$conditions=array("society_id" => $s_society_id);
$result_hm_modules_assign=$this->hm_modules_assign->find('all',array('conditions'=>$conditions));
foreach($result_hm_modules_assign as $data)
{
 $module_id=$data['hm_modules_assign']['module_id'];

$this->loadmodel('sub_modules');
$conditions=array("module_id" => $module_id);
$result_sub_modules=$this->sub_modules->find('all',array('conditions'=>$conditions));
foreach($result_sub_modules as $data)
{
$sub_module_id=(int)$data["sub_modules"]["auto_id"];
$sub_module_name=$data["sub_modules"]["sub_module_name"];

$check_box=@$this->request->data['ch'.$sub_module_id];

if($check_box>0)
{
	
$this->loadmodel('role_privilege');
$conditions=array("society_id" => $s_society_id ,"role_id" => $role_id,"sub_module_id" => $sub_module_id,"module_id" => $module_id,"sub_module_id" => $sub_module_id);
$n=$this->role_privilege->find('count',array('conditions'=>$conditions));

if($n==0)
{

$this->loadmodel('role_privilege');
$data_row = Array( Array("society_id" => $s_society_id, "role_id" => $role_id , "module_id" => $module_id,"sub_module_id" => $sub_module_id));
$this->role_privilege->saveAll($data_row); 

}

}
else
{
$this->loadmodel('role_privilege');
$conditions=array("society_id" => $s_society_id ,"role_id" => $role_id,"sub_module_id" => $sub_module_id);
$n=$this->role_privilege->deleteall($conditions);
}



}


}
$this->redirect('asisgn_module_to_role');
}


$this->loadmodel('role');
$conditions=array("society_id" => $s_society_id);
$result_r=$this->role->find('all',array('conditions'=>$conditions));

$this->set('result_role',$result_r);


}

function assign_modules_to_role_ajax()
{
$this->layout='blank';
$this->ath();

$s_society_id=$this->Session->read('society_id');
$s_role_id=$this->Session->read('role_id');

/*
$this->loadmodel('hm_modules_assign');
$conditions=array("society_id" => $s_society_id);
$this->set('result_hm_modules_assign',$this->hm_modules_assign->find('all',array('conditions'=>$conditions)));

*/
$this->loadmodel('module_type');
$order=array('module_type.module_type_name'=>'ASC');		
$this->set('result_module_type',$this->module_type->find('all',array('order'=>$order)));

}

function fetch_main_module_name($module_id)
{
$this->layout='blank';
$this->ath();

$this->loadmodel('main_module');
$conditions=array("auto_id" => $module_id);
return $result_main_module=$this->main_module->find('all',array('conditions'=>$conditions));
}

function fetch_sub_module($main_module_id)
{
$this->layout='blank';
$this->ath();

$this->loadmodel('sub_modules');
$conditions=array("module_id" => $main_module_id);
return $result_sub_modules=$this->sub_modules->find('all',array('conditions'=>$conditions));
}



function fetch_hm_assign_module($mt_id)
{
	$this->layout='blank';
	$this->ath();

	$role_id=(int)$this->request->query('con');

	$s_society_id=$this->Session->read('society_id');
$this->loadmodel('hm_modules_assign');
$conditions=array("society_id" => $s_society_id,'mt_id'=>$mt_id);
return $this->hm_modules_assign->find('all',array('conditions'=>$conditions));

	
}
function fetch_role_privileges($sub_module_id)
{
$this->layout='blank';
$this->ath();

$role_id=(int)$this->request->query('con');

$s_society_id=$this->Session->read('society_id');

$this->loadmodel('role_privilege');
$conditions=array("sub_module_id" => $sub_module_id,"society_id" => $s_society_id,"role_id" => $role_id);
return $result_role_privileges=$this->role_privilege->find('count',array('conditions'=>$conditions));
}

function hm_assign_module()
{
$this->layout='session';
$da_society_id=(int)$this->request->query('q');
if(!empty($da_society_id))
{	
	
	$result2=$this->society_name($da_society_id);
	foreach($result2 as $data)
	{
		$society_name=$data['society']['society_name'];
		$user_id=(int)$data['society']['user_id'];
		
	}
	$message= 'Society <b>'.$society_name.'</b> approved.<br/> Assign modules to the society';
	$this->set('mess',$message);
}
$this->loadmodel('society');
$result=$this->society->find('all');
$this->set('result_society',$result);
if ($this->request->is('post')) 
{

  $society_id=(int)$this->request->data['r_name'];
 
	$this->loadmodel('role_privilege');
	$conditions=array("society_id" => $society_id, "role_id" => 3 , "module_id" => 18,"sub_module_id" =>49);
	$result5=$this->role_privilege->find('all',array('conditions'=>$conditions));
	$num_count=sizeof($result5);
	if($num_count==0)
	{
	$this->loadmodel('role_privilege');
	$data_row =Array( Array("society_id" => $society_id, "role_id" => 3 , "module_id" => 18,"sub_module_id" =>49));
	$this->role_privilege->saveAll($data_row);
	}

$society_id=(int)$this->request->data['r_name'];

$this->loadmodel('main_module');
$result_main_module=$this->main_module->find('all');

foreach ($result_main_module as $collection) 
{		  
$module_id =(int)$collection['main_module']['auto_id'];
$mt_id =(int)$collection['main_module']['mt_id'];
$value =@$this->request->data[$module_id];
if($value==1)
{

$this->loadmodel('hm_modules_assign');
$conditions=array("society_id" => $society_id, "module_id" => $module_id);
$result1=$this->hm_modules_assign->find('all',array('conditions'=>$conditions));

$n = sizeof($result1);
if($n==0)
{
$this->loadmodel('hm_modules_assign');
$this->hm_modules_assign->saveAll(array("society_id" => $society_id, "module_id" => $module_id,'mt_id'=>$mt_id));
}   
}
else
{
$this->loadmodel('hm_modules_assign');
$conditions= array("society_id" => $society_id, "module_id" => $module_id);
$this->hm_modules_assign->deleteAll($conditions);
$this->loadmodel('role_privilege');
$conditions= array("society_id" => $society_id, "module_id" => $module_id);
$this->role_privilege->deleteAll($conditions);
}

}
$this->response->header('location','hm_assign_module');
}
}

function hm_society_view()
{
$this->layout='session';
$this->ath();
$this->check_housingmatters_privilages();
$this->loadmodel('society');
$result=$this->society->find('all');
$this->set('n',sizeof($result));
$this->set('result_society',$result);
}


function hm_resident_approve_resend_mail()
{
	$this->layout='blank';
	$user_temp_id=(int)$this->request->query('con');	
	$s_society_id=(int)$this->request->query('con2');		
$this->loadmodel('user');
$conditions=array('user_id'=>$user_temp_id);
$result_user_temp=$this->user->find('all',array('conditions'=>$conditions));
foreach ($result_user_temp as $collection) 
{ 
$society_id=(int)$collection['user']['society_id'];
$user_name=$collection['user']['user_name'];
$mobile=$collection['user']['mobile'];
$email=$collection['user']['email'];
$password=$collection['user']['password'];
$wing=(int)$collection['user']['wing'];
$flat=(int)$collection['user']['flat'];
$tenant=(int)$collection['user']['tenant'];
$residing=(int)$collection['user']['residing'];

}
///////////end fetch data ////////////////////

$random1=mt_rand(1000000000,9999999999);
$random2=mt_rand(1000000000,9999999999);
$random=$random1.$random2 ;

//////////////// insert data user table //////////////////////////
$ip=$this->hms_email_ip();
$de_user_id=$this->encode($user_temp_id,'housingmatters');
$random=$de_user_id.'/'.$random;


$this->loadmodel('user');
$this->user->updateAll(array('signup_random'=>$random,'one_time_sms'=>0),array('user.user_id'=>$user_temp_id));



//////////////// end insert code  //////////////////////////

$this->loadmodel('society');
$conditions12=array('society_id'=>$s_society_id);
$result12=$this->society->find('all',array('conditions'=>$conditions12));
foreach($result12 as $data)
{
$s_name=$data['society']['society_name'];
}
///////////////////////////////////////////// approve mail functionality ///////////////////////////////////////

$to=$email;
$message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
<p style='color:green;'><strong>Reminder!</strong></p>
<p>Dear  $user_name,</p>
<p>'We at $s_name use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent &amp; smart management of housing society affairs.</p>
<p>As you are an owner/resident/staff of $s_name, we have added your email address in HousingMatters portal.</p>
<p>Here are some of the important features related to our portal on HousingMatters:</p>

<li>log &amp; track complaints</li>
<li>start new discussions</li>
<li>check your maintenance dues</li>
<li>post classifieds</li>
<li>receive important SMS &amp; emails from your committee</li>
<li>and much more in the portal.</li>



<p><b><a href='$ip".$this->webroot."/hms/send_sms_for_verify_mobile?q=$random' target='_blank'><button style='width:100px; height:30px;  background-color:#00A0E3;color:white'>Click here</button></a> for one time verification of your mobile number and Login into HousingMatters  for making life simpler for all your housing matters!</b></p>


<p>Regards,</p>
<p>Administrator of $s_name</p>

<p>PS: add <a href='http://www.housingmatters.co.in' target='_blank'>www.housingmatters.co.in</a> in your favorite bookmarks for future use.</p>



</div >
</div>";

$subject="[$s_name]";
$from_name="HousingMatters";
$reply="support@housingmatters.in";
$this->loadmodel('email');
$conditions=array('auto_id'=>4);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
}
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	
	
}


function hm_resident_approve_resend_sms()
{
	
		$this->layout='blank';
		$user_temp_id=(int)$this->request->query('con');	
		$s_society_id=(int)$this->request->query('con2');	
		$result_society=$this->society_name($s_society_id);
		foreach($result_society as $dd)
		{
		$society_name=$dd['society']['society_name'];
		}
		
		$s_n='';
		$sco_na=$society_name;
		$dd=explode(' ',$sco_na);
		$first=$dd[0];
		$two=$dd[1];
		$three=$dd[2];
		$s_n.=" $first $two $three ";
		
		$this->loadmodel('user');
		$conditions=array('user_id'=>$user_temp_id);
		$result_user=$this->user->find('all',array('conditions'=>$conditions));
		foreach($result_user as $data)
		{
		$mobile=$data['user']['mobile'];
		$user_name=$data['user']['user_name'];
		$login_id=(int)$data['user']['login_id'];
		}
			$r_sms=$this->hms_sms_ip();
			$working_key=$r_sms->working_key;
			$sms_sender=$r_sms->sms_sender; 
			$sms_allow=(int)$r_sms->sms_allow;
		$random=(string)mt_rand(1000,9999);
		if($sms_allow==1){
		$sms="".$user_name.", Your housing society ".$s_n." has enrolled you in HousingMatters portal. Pls log into www.housingmatters.co.in One Time Password ".$random."";
		$sms1=str_replace(" ", '+', $sms);
		$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms1.'');
		}
		$this->loadmodel('user');
		$this->user->updateAll(array('password'=>$random,'signup_random'=>$random),array('user_id'=>$user_temp_id));
		$this->loadmodel('login');
		$this->login->updateAll(array('password'=>$random,'signup_random'=>$random),array('login_id'=>$login_id));


}


function hm_society_member_view()
{

$this->layout='session';
$this->ath();	
$this->loadmodel('society');	
$this->set('result_society',$this->society->find('all'));
$this->loadmodel('user');
$order=array('user.user_name'=>'ASC');		
$result1=$this->user->find('all',array('conditions'=>array('deactive'=>0),'order'=>$order));	
$this->set('result_user',$result1);
$this->set('n',sizeof($result1));	

}


function society_count_user($society_id)
{
$this->loadmodel('user');
$conditions=array('society_id'=>$society_id);
$result=$this->user->find('all',array('conditions'=>$conditions));
return sizeof($result);

}


function hm_assign_module_ajax()
{
$this->layout='blank';
$society_id=(int)$this->request->query('con');
/*$this->loadmodel('main_module');
$result=$this->main_module->find('all');
$this->set('result_main_module',$result);
$this->set('society_id',$society_id);
*/

$this->loadmodel('module_type');
$result=$this->module_type->find('all',array('order'=>array('module_type.module_type_name'=>'ASC')));
$this->set('result_main_module',$result);
$this->set('society_id',$society_id);


}
function count($module_id,$society_id)
{
$this->loadmodel('hm_modules_assign');
$conditions=array("society_id" => $society_id, "module_id" => $module_id); 
$result=$this->hm_modules_assign->find('all',array('conditions'=>$conditions)); 
return $n=sizeof($result);         
}	



function user_assign_role()
{
$s_society_id=$this->Session->read('society_id');
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();
$this->loadmodel('user');
$conditions1=array('society_id'=>$s_society_id,'deactive'=>0);
$result=$this->user->find('all',array('conditions'=>$conditions1));
$this->set('result_user',$result);
if ($this->request->is('post')) 
{

$user_id=(int)$this->request->data['user'];
$this->loadmodel('role');
$conditions2=array("society_id" => $s_society_id);
$result_role=$this->role->find('all',array('conditions'=>$conditions2));	
foreach ($result_role as $collection) 
{					
$role_id=(int)$collection['role']["role_id"];
$r=@$this->request->data['role'.$role_id];
if($r==1)
{
$j[]=$role_id;
}
}			

$this->loadmodel('user');
$this->user->updateAll(array('role_id'=>$j),array('user_id'=>$user_id));


}

}


function user_assign_role_ajax()
{
$this->layout='blank';
$user_id=(int)$this->request->query('con');
$s_society_id=$this->Session->read('society_id');
$this->loadmodel('role');
$conditions=array('society_id'=>$s_society_id);	
$result=$this->role->find('all',array('conditions'=>$conditions));
$this->set('result_role',$result);
$this->set('user_id',$user_id);
}

function user_role($role_id,$user_id)
{
$this->loadmodel('user');
$conditions=array("user_id" => $user_id, "role_id" => $role_id); 
$result=$this->user->find('all',array('conditions'=>$conditions)); 
return $n=sizeof($result);        
}



////////////////////////////////////// Notification email and Sms Start ///////////////////////////////////////

function notification_email()
{

if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$user_id=$this->Session->read('user_id');	
$this->set('s_user_id',$user_id);
$s_society_id=$this->Session->read('society_id'); 
$this->loadmodel('email');	
$conditions=array('notification_id'=>1);
$result=$this->email->find('all',array('conditions'=>$conditions));
$this->set('result_email',$result);
if($this->request->is('post'))
{
foreach($result as $data)
{

$notification_id=(int)$data['email']['notification_id'];
$auto_id = (int)$data['email']['auto_id'];
$module_name = $data['email']['module_name']; 
$chk_email=@$this->request->data['check_email'.$auto_id];
$chk_sms=@$this->request->data['check_sms'.$auto_id];

if($chk_email==1)
{
$this->loadmodel('notification_email');
$conditions5=array('module_id'=>$auto_id,'user_id'=>$user_id,'chk_status'=>0);
$result5=$this->notification_email->find('all',array('conditions'=>$conditions5));
$n= sizeof($result5);
if($n==0)
{
$this->loadmodel('notification_email');
$i=$this->autoincrement('notification_email','notification_id');
$this->notification_email->saveAll(array("notification_id" => $i, "module_id" => $auto_id , "user_id" => $user_id,'chk_status'=>0));
}

}
else
{
$this->loadmodel('notification_email');
$conditions6=array('module_id'=>$auto_id,'user_id'=>$user_id,'chk_status'=>0);
$this->notification_email->deleteAll($conditions6);
}

if($chk_sms==1)
{
$this->loadmodel('notification_email');
$conditions5=array('module_id'=>$auto_id,'user_id'=>$user_id,'chk_status'=>1);
$result5=$this->notification_email->find('all',array('conditions'=>$conditions5));
$n= sizeof($result5);
if($n==0)
{
$this->loadmodel('notification_email');
$i=$this->autoincrement('notification_email','notification_id');
$this->notification_email->saveAll(array("notification_id" => $i, "module_id" => $auto_id , "user_id" => $user_id,'chk_status'=>1));
}
}
else
{
$this->loadmodel('notification_email');
$conditions6=array('module_id'=>$auto_id,'user_id'=>$user_id,'chk_status'=>1);
$this->notification_email->deleteAll($conditions6);
}

}


}



}


function notification_count_email($auto_id,$user_id)
{
$this->loadmodel('notification_email');
$conditions=array('module_id'=>$auto_id,'user_id'=>$user_id,'chk_status'=>0);
$result=$this->notification_email->find('all',array('conditions'=>$conditions));
return  $n= sizeof($result);
}


function notification_count_sms($auto_id,$user_id)
{
$this->loadmodel('notification_email');
$conditions=array('module_id'=>$auto_id,'user_id'=>$user_id,'chk_status'=>1);
$result=$this->notification_email->find('all',array('conditions'=>$conditions));
return  $n= sizeof($result);
}

/////////////////////////////////// End notification  //////////////////






////////////////////////////////// Start Yellow Page /////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////



function yellow_registration()
{
$this->layout='session';	
$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id'); 	
$this->set('role_id',$s_role_id=$this->Session->read('role_id'));
$this->loadmodel('yellow_category');
$result_yellow=$this->yellow_category->find('all');	
$this->set('result_yellow_category',$result_yellow);	

if($this->request->is('post'))
{

$ip=$this->hms_email_ip();
$file=$this->request->form['file']['name'];
if(empty($file))
{
$file='blank.jpg';
}
$name=htmlentities($this->request->data['name']);
$address=htmlentities($this->request->data['address']);
$mobile=htmlentities($this->request->data['mobile']);
$to=htmlentities($this->request->data['email']);
$website=htmlentities($this->request->data['website']);
$message_web="Thank you. You have been enroll in HousingMatters";
$this->loadmodel('email');
$condition=array('auto_id'=>7);
$result4=$this->email->find('all',array('conditions'=>$condition));
foreach($result4 as $data)
{
$from=$data['email']['from'];

}
$from_name="HousingMatters";
$subject="HousingMatters";
$reply=$from;

$message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
<br/><p>Thank you. You have been enroll in HousingMatters</p><br/>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.co.in
</div >
</div>";


$target = "yellow_page_file/";
$target=@$target.basename( @$this->request->form['file']['name']);
$ok=1;
move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target); 
foreach($result_yellow as $data)
{
$id=(int)$data['yellow_category']['yellow_cat_id'];
$servies=$data['yellow_category']['yellow_cat_name'];
$check_id=(int)@$this->request->data[$id];
if(!empty($check_id))
{
$category[]=$check_id;
}
}
date_default_timezone_set('Asia/kolkata');
$date=date("d-m-Y");
$time=date('h:i:a',time());
$i=$this->autoincrement('yellow_registration','yellowpage_id');
$this->loadmodel('yellow_registration');
$this->yellow_registration->saveAll(array("yellowpage_id" => $i, "yellowpage_attachment" => $file , "yellowpage_name" => $name,"yellowpage_date"=>$date,"yellowpage_category"=>$category,"user_id"=>$s_user_id,"society_id"=>$s_society_id,"yellowpage_time"=>$time,"yellowpage_delete"=>0,"yellowpage_website"=>$website,"yellowpage_address"=>$address,"yellowpage_email"=>$to,"yellowpage_mobile"=>$mobile));
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
//$this->smtpmailer($to,$from,$from_name,$subject,$message_web,$reply);


?>	

<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
<?php echo $name; ?> successfully registered in HousingMatters.
</div> 
<div class="modal-footer">
<a href="yellow_page" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->

<?php 		 

}

}

function yellow_page()
{
$this->layout='session';	
$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id'); 
$this->loadmodel('yellow_category');
$result_yellow=$this->yellow_category->find('all');	
$this->set('result_yellow_category',$result_yellow);
$this->loadmodel('yellow_registration');
$conditions=array('yellowpage_delete'=>0);
$result=$this->yellow_registration->find('all',array('conditions'=>$conditions));
$this->set('result_ye_registration',$result);

}


function yellow_category_name($category)
{
$this->loadmodel('yellow_category');
$conditions=array('yellow_cat_id'=>$category);
return $this->yellow_category->find('all',array('conditions'=>$conditions));

}

function yellow_page_view()
{
$this->layout='blank';

$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id'); 	
$yellow_id=(int)$this->request->query('id');
$this->loadmodel('yellow_registration');
$conditions1=array('yellowpage_id'=>$yellow_id);
$this->set('result_yellow',$this->yellow_registration->find('all',array('conditions'=>$conditions1)));

}

function yellow_page_view_ajax()
{
$this->layout='blank';
$search_cat=(int)$this->request->query('con');
$this->set('search_value',$search_cat);
$this->loadmodel('yellow_registration');
$conditions=array('yellowpage_category'=>$search_cat);
$result= $this->yellow_registration->find('all',array('conditions'=>$conditions));
$this->set('count_yellow',sizeof($result));
$this->set('result_yellow',$result);

$this->loadmodel('yellow_registration');
$conditions1=array('yellowpage_delete'=>0);
$result1=$this->yellow_registration->find('all',array('conditions'=>$conditions1));
$this->set('result_ye_registration',$result1);


}


////////////////////////////  End Yellow Page //////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////////////	
/////////////////////////////////////////////////////start Message//////////////////////
////////////////////////////////////////////////////////////////////////////////////////	
function message()
{
$this->layout='session';
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
}



$r_sms=$this->hms_sms_ip();
  $working_key=$r_sms->working_key;
 $sms_sender=$r_sms->sms_sender; 
$sms_allow=(int)$r_sms->sms_allow;
if($radio==1)
{
$multi=$this->request->data['multi'];
$multi[]=$sender_email;
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
	$conditions=array('society_id'=>$s_society_id);
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
	$conditions=array('tenant'=>1,'society_id'=>$s_society_id);
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
	$conditions=array('tenant'=>2,'society_id'=>$s_society_id);
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
	$conditions=array('role_id'=>$role_id,'society_id'=>$s_society_id);
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
	$conditions=array('wing'=>$wing_id,'society_id'=>$s_society_id);
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
$this->layout='session';
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
$this->layout='session';
$this->ath();
$this->check_user_privilages();

$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id'); 


$this->loadmodel('user');
$conditions=array("society_id"=>$s_society_id,'user.email'=> array('$ne' => ""));
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

$message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
<br/>
<div>$message_db</div>
<br/>
<div style='color: #7B7B7B;'>Regards,</div>
<div style='color: #7B7B7B;'>$name&nbsp;&nbsp;$wing_flat</div>
<div style='color: #7B7B7B;'>$society_name</div>
</div >
</div>";


if(!empty($file))
{
$message_web.='<br/><a href="'.$ip.'/'.$this->webroot.'email_file/'.$file.'" download>Download attachment</a>';
}


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
$multi[]=$sender_email;

foreach($multi as $data)
{

$ex = explode(",", $data);
$user[]=$ex[0];
$to=$ex[1];
//echo $email[$i];
$this->send_email($to,'support@housingmatters.in','HousingMatters',$subject,$message_web,'support@housingmatters.in');
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
$this->send_email($to,'support@housingmatters.in','HousingMatters',$subject,$message_web,'support@housingmatters.in');
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
	$conditions=array('society_id'=>$s_society_id);
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
	$conditions=array('tenant'=>1,'society_id'=>$s_society_id);
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
	$conditions=array('tenant'=>2,'society_id'=>$s_society_id);
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
	$conditions=array('role_id'=>$role_id,'society_id'=>$s_society_id);
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
	$conditions=array('wing'=>$wing_id,'society_id'=>$s_society_id);
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
$this->send_email($to,'support@housingmatters.in','HousingMatters',$subject,$message_web,'support@housingmatters.in');
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
$this->layout='session';
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
	$multipleRowData = Array( Array("group_id" => $group_id,"group_name"=>$group_name,"society_id"=>$s_society_id,"users"=>array()));
	$this->group->saveAll($multipleRowData); 
	$this->response->header('Location', 'groupview?gid='.$group_id);
	}
	else{
		$this->set('error_addgroup','Group name should not be duplicate.');
	}
}

$this->loadmodel('group');
$conditions=array("society_id"=>$s_society_id);
$order=array('group.group_id'=>'DESC');
$this->set('result_group',$this->group->find('all',array('conditions'=>$conditions,'order'=>$order))); 
}

function groupview() 
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
	$gid=(int)$this->request->query('gid');
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

//////////////////////////// Discussion fourm Approval /////////////////////////////

function discussion_forum_approval()
{
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	
	$this->check_user_privilages();	
	$s_society_id=$this->Session->read('society_id');
	
	$this->loadmodel('discussion_post');
	$conditions=array('delete_id'=>4,'society_id'=>$s_society_id);
	$order=array('discussion_post.discussion_post_id'=>'DESC');
	$result=$this->discussion_post->find('all',array('conditions'=>$conditions,'order'=>$order));
	foreach($result as $dda)
	{
		 $id=(int)$dda['discussion_post']['discussion_post_id'];
		$this->seen_notification(3,$id);
		
	}
	
	$this->set('result_discussion',$result);
}

function discussion_forum_app_view()
{
	if($this->RequestHandler->isAjax()){
		$this->layout='blank';
		}else{
		$this->layout='session';
		}
			
		 $discu_id=(int)$this->request->query['con'];
		 $this->loadmodel('discussion_post');
		 $conditions=array('discussion_post_id'=>$discu_id);
		 $result_discussion=$this->discussion_post->find('all',array('conditions'=>$conditions));
	    $this->set('result_discussion',$result_discussion);
}


function discussion_forum_app_ajax()
{
	
		$this->layout='session';
		$ip=$this->hms_email_ip();
		$s_society_id=$this->Session->read('society_id');
		$discu_id=(int)$this->request->query('con');
		$this->loadmodel('discussion_post');
		$conditions=array('discussion_post_id'=>$discu_id);
		$result_discussion=$this->discussion_post->find('all',array('conditions'=>$conditions));
		foreach($result_discussion as $data)
		{
			$topic=$data['discussion_post']['topic'];
			$user_id=$data['discussion_post']['user_id'];
			$description=$data['discussion_post']['description'];
			$date=$data['discussion_post']['date'];
			   $newDate = date("d-m-y", strtotime($date));
			   $newDate1 = date("d-m-Y", strtotime($newDate));
			
			$time=$data['discussion_post']['time'];
			$visible=(int)$data['discussion_post']['visible'];
			$sub_visible=$data['discussion_post']['sub_visible'];
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
				$da_user_id=array_unique($da_user_id);
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
				
				$result_user=$this->profile_picture($user_id);
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
		for($k=0;$k<sizeof($da_to);$k++)
		{				
			$to = @$da_to[$k];
			$d_user_id = @$da_user_id[$k];	 
			$user_name = @$da_user_name[$k];	
			
/* $message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Hello  $user_name </p>
<p>A new topic is posted in your society Discussion Forum.</p>
<table  cellpadding='10' width='100%;' border='1' bordercolor='#e1e1e1'  >
<tr class='tr_heading' style='background-color:#00A0E3;color:white;'>
<td>New Discussion Topic</td>
<td>Posted by</td>
<td>Flat #</td>
</tr>
<tr class='tr_content' style=background-color:#E9E9E9;'>
<td>$topic</td>
<td>$user_name_post</td>
<td>$wing_flat</td>
</tr>
</table>
<div>
<br/>
<center><p>To view or post response
<a href='$ip".$this->webroot."hms' ><button style='width:100px; height:30px;  background-color:#00A0E3;color:white'> Click Here </button></a></p></center><br/>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.co.in
</div>
</div>"; 

	
	 $message_web='<table  align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
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
</table>';

*/

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
									<table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="line-height:2px" colspan="3" height="2">&nbsp;</td></tr><tr><td><a href="#" style="color:#3b5998;text-decoration:none" target="_blank"><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="border-collapse:collapse;border-radius:2px;text-align:center;display:block;border:1px solid #026A9E;background:#008ED5;padding:7px 16px 11px 16px"><a href="'.$ip.$this->webroot.'Discussions/index/'.$discu_id.'/0" style="color:#3b5998;text-decoration:none;display:block" target="_blank"><center><font size="3"><span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;white-space:nowrap;font-weight:bold;vertical-align:middle;color:#ffffff;font-size:14px;line-height:14px">View on HousingMatters</span></font></center></a></td></tr></tbody></table></a></td><td style="display:block;width:10px" width="10">&nbsp;&nbsp;&nbsp;</td><td><a href="#" style="color:#3b5998;text-decoration:none" target="_blank"><table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="border-collapse:collapse;border-radius:2px;text-align:center;display:block;border:solid 1px #c9ccd1;background:#f6f7f8;padding:7px 16px 11px 16px"><a href="'.$ip.$this->webroot.'Discussions/index/'.$discu_id.'/0" style="color:#3b5998;text-decoration:none;display:block" target="_blank"><center><font size="3"><span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;white-space:nowrap;font-weight:bold;vertical-align:middle;color:#525252;font-size:14px;line-height:14px">Comment</span></font></center></a></td></tr></tbody></table></a></td><td width="100%"></td></tr><tr><td style="line-height:32px" colspan="3" height="32">&nbsp;</td></tr></tbody></table>
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

////////// start code notification ///////////////////////////////


$this->send_notification('<span class="label" style="background-color:#269abc;"><i class="icon-comment"></i></span>','New Discussion <b>'.$topic.'</b> created by',3,$discu_id,'discussion_forum?t='.$discu_id.'&list=0',$user_id,$da_user_id);



////////// end code notification ///////////////////////////////

$this->loadmodel('discussion_post');
$this->discussion_post->updateAll(array('delete_id'=>0,'users'=>$da_user_id),array('discussion_post_id'=>$discu_id));
$this->response->header('location','discussion_forum_approval');

	
}



function discussion_forum_app_reject()
{
	
	$this->layout="blank";
	$descussion_p_id=(int)$this->request->query('con');
	$this->loadmodel('discussion_post');
	$this->discussion_post->updateAll(array('delete_id'=>5),array('discussion_post_id'=>$descussion_p_id));
	$this->response->header('location','discussion_forum_approval');
}
//////////////////////// End Discussion fourm approval ///////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////	
/////////////////////////////////////////////////////start discussion//////////////////////
////////////////////////////////////////////////////////////////////////////////////////	
function discussion_forum()
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	
$t=(int)$this->request->query('t');
$this->set('t',$t);
$list=(int)$this->request->query('list');
$this->set('list',$list);
$new=(int)$this->request->query('new');
$this->set('new',$new);

$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id');
$s_role_id=$this->Session->read('role_id');
$this->set('s_user_id',$s_user_id);
$tenant=$this->Session->read('tenant');
$role_id=$this->Session->read('role_id');
$wing=$this->Session->read('wing');

$this->seen_notification(3,$t);

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
		//@$s_duser_id=$data['society']['user_id'];
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
					
	?>
                

				<!----alert-------------->
				<div class="modal-backdrop fade in"></div>
				<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
				<div class="modal-body" style="font-size:16px;">
				Discussion Forum are sent for approval.
				</div> 
				<div class="modal-footer">
				<a href="discussion_forum" class="btn green">OK</a>
				</div>
				</div>
				<!----alert-------------->
								
                
                
                
   <?php						
		
		
		
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
$sub_visible[]=0;
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
$sub_visible[]=0;
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
$wing_id=$collection["wing"]["wing_id"];

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

///////////////////// send email creator code start ///////////////////////

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

//////////////////  End Code //////////////////////////////////////////




$discussion_post_id=$this->autoincrement('discussion_post','discussion_post_id');
$this->loadmodel('discussion_post');
$multipleRowData = Array( Array("discussion_post_id" => $discussion_post_id, "user_id" => $s_user_id , "society_id" => $s_society_id, "topic" => $topic,"description" => $description, "file" =>$file,"delete_id" =>0, "date" =>$date, "time" => $time, "visible" => $visible, "sub_visible" => $sub_visible,"users"=>$da_user_id));
$this->discussion_post->saveAll($multipleRowData); 
$this->response->header('Location', 'discussion_delete_topic');

$this->send_notification('<span class="label" style="background-color:#269abc;"><i class="icon-comment"></i></span>','New Discussion <b>'.$topic.'</b> created by',3,$discussion_post_id,'discussion_forum?t='.$discussion_post_id.'&list=0',$s_user_id,$da_user_id);


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
$sub="New Topic";
$result= $this->society_name($s_society_id);
foreach($result as $data)
{
	$society_name=$data['society']['society_name'];
	$dis_email_setting=$data['society']['discussion_forum_email'];

}

$result_user=$this->profile_picture($s_user_id);
foreach($result_user as $data1)
{
$user_name_post=$data1['user']['user_name'];
$wing=$data1['user']['wing'];
$flat=$data1['user']['flat'];

}
$wing_flat=$this->wing_flat($wing,$flat);
if($dis_email_setting==1)
{
for($k=0;$k<sizeof($da_to);$k++)
{
$to = @$da_to[$k];
$d_user_id = @$da_user_id[$k];	 
$user_name = @$da_user_name[$k];	

$message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Hello  $user_name </p>
<p>A new topic is posted in your society Discussion Forum.</p>
<table  cellpadding='10' width='100%;' border='1' bordercolor='#e1e1e1'  >
<tr class='tr_heading' style='background-color:#00A0E3;color:white;'>
<td>New Discussion Topic</td>
<td>Posted by</td>
<td>Flat #</td>
</tr>
<tr class='tr_content' style=background-color:#E9E9E9;'>
<td>$topic</td>
<td>$user_name_post</td>
<td>$wing_flat</td>
</tr>
</table>
<div>
<br/>
<center><p>To view or post response
<a href='$ip".$this->webroot."hms' ><button style='width:100px; height:30px;  background-color:#00A0E3;color:white'> Click Here </button></a></p></center><br/>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.co.in
</div>
</div>";
$this->loadmodel('notification_email');
$conditions7=array("module_id" =>10,"user_id"=>$d_user_id,'chk_status'=>0);
$result5=$this->notification_email->find('all',array('conditions'=>$conditions7));
$n=sizeof($result5);
if($n>0)
{
@$subject.= ''. $society_name . '  ' .'     '.' '.$sub.'';
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$subject="";
}	
}
}


////////////////////////////////////////////End Mail Functionality //////////////////////////////////////
///////////////////////////////////////////////////////////////////////////


}
	
	
	
}



///////////////////////End start new topic//////////////////////////////////


$this->loadmodel('discussion_post');

if($list==0 or empty($list))
{
	$conditions =array( '$or' => array( 
	array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>1),
	array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>2,'sub_visible' =>array('$in' => array($role_id))),
	array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>3,'sub_visible' =>array('$in' => array($wing))),
	array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>4),
	array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>5)
	));
}
if($list==1)
{
	$conditions =array( '$or' => array( 
	array('user_id' =>$s_user_id,'delete_id' =>0,'visible' =>1),
	array('user_id' =>$s_user_id,'delete_id' =>0,'visible' =>2,'sub_visible' =>array('$in' => array($role_id))),
	array('user_id' =>$s_user_id,'delete_id' =>0,'visible' =>3,'sub_visible' =>array('$in' => array($wing))),
	array('user_id' =>$s_user_id,'delete_id' =>0,'visible' =>4),
	array('user_id' =>$s_user_id,'delete_id' =>0,'visible' =>5)
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
if(empty($t)){
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
	$conditions=array('discussion_post_id' =>$t,'users' =>array('$in' => array($s_user_id)));
	$count=$this->discussion_post->find('count',array('conditions'=>$conditions));
	if($count>0){	$conditions=array('discussion_post_id' =>$t);	}
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
//$conditions=array("discussion_post_id"=>@$discussion_post_id,"delete_id"=>0);
$this->set('result_comment_last',$this->discussion_comment->find('all',array('conditions'=>$conditions))); 
}

function discussion()
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	 clearCache();
$this->ath(); 
$this->check_user_privilages();

$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id');
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
if ($this->request->is('post')) 
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
$sub_visible[]=0;
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
$sub_visible[]=0;
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
$wing_id=$collection["wing"]["wing_id"];

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

$discussion_post_id=$this->autoincrement('discussion_post','discussion_post_id');
$this->loadmodel('discussion_post');
$multipleRowData = Array( Array("discussion_post_id" => $discussion_post_id, "user_id" => $s_user_id , "society_id" => $s_society_id, "topic" => $topic,"description" => $description, "file" =>$file,"delete_id" =>0, "date" =>$date, "time" => $time, "visible" => $visible, "sub_visible" => $sub_visible));
$this->discussion_post->saveAll($multipleRowData); 
$this->response->header('Location', 'discussion_delete_topic');

$this->send_notification('<span class="label" style="background-color:#269abc;"><i class="icon-comment"></i></span>','New Discussion <b>'.$topic.'</b> created by',3,$discussion_post_id,'discussion',$s_user_id,$da_user_id);


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
$sub="New Topic";
$result= $this->society_name($s_society_id);
foreach($result as $data)
{
	$society_name=$data['society']['society_name'];
	$dis_email_setting=$data['society']['discussion_forum_email'];

}

$result_user=$this->profile_picture($s_user_id);
foreach($result_user as $data1)
{
$user_name_post=$data1['user']['user_name'];
$wing=$data1['user']['wing'];
$flat=$data1['user']['flat'];

}
$wing_flat=$this->wing_flat($wing,$flat);
if($dis_email_setting==1)
{
for($k=0;$k<sizeof($da_to);$k++)
{
$to = @$da_to[$k];
$d_user_id = @$da_user_id[$k];	 
$user_name = @$da_user_name[$k];	

$message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Hello  $user_name </p>
<p>A new topic is posted in your society Discussion Forum.</p>
<table  cellpadding='10' width='100%;' border='1' bordercolor='#e1e1e1'  >
<tr class='tr_heading' style='background-color:#00A0E3;color:white;'>
<td>New Discussion Topic</td>
<td>Posted by</td>
<td>Flat #</td>
</tr>
<tr class='tr_content' style=background-color:#E9E9E9;'>
<td>$topic</td>
<td>$user_name_post</td>
<td>$wing_flat</td>
</tr>
</table>
<div>
<br/>
<center><p>To view or post response
<a href='$ip".$this->webroot."hms' ><button style='width:100px; height:30px;  background-color:#00A0E3;color:white'> Click Here </button></a></p></center><br/>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.co.in
</div>
</div>";
$this->loadmodel('notification_email');
$conditions7=array("module_id" =>10,"user_id"=>$d_user_id,'chk_status'=>0);
$result5=$this->notification_email->find('all',array('conditions'=>$conditions7));
$n=sizeof($result5);
if($n>0)
{
@$subject.= ''. $society_name . '  ' .'     '.' '.$sub.'';
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$subject="";
}	
}
}


////////////////////////////////////////////End Mail Functionality //////////////////////////////////////
///////////////////////////////////////////////////////////////////////////


}
///////////////////////End start new topic//////////////////////////////////


$this->loadmodel('discussion_post');
$conditions =array( '$or' => array( 
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>1),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>2,'sub_visible' =>array('$in' => array($role_id))),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>3,'sub_visible' =>array('$in' => array($wing))),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>4),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>5)
));
$order=array('discussion_post.discussion_post_id'=>'DESC');
$this->set('result_discussion',$this->discussion_post->find('all',array('conditions'=>$conditions,'order'=>$order)));   


$this->loadmodel('discussion_post');
$conditions =array( '$or' => array( 
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>1),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>2,'sub_visible' =>array('$in' => array($role_id))),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>3,'sub_visible' =>array('$in' => array($wing))),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>4),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>5)
));
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
//$conditions=array("discussion_post_id"=>@$discussion_post_id,"delete_id"=>0);
$this->set('result_comment_last',$this->discussion_comment->find('all',array('conditions'=>$conditions))); 
}


function discussion_pdf()
{
$this->layout = 'pdf'; //this will use the pdf.ctp layout 
$this->ath(); 

$con=(int)$this->request->query('con');
$this->set('con',$con);

$s_user_id=$this->Session->read('user_id'); 
$this->set('s_user_id',$s_user_id);
$s_society_id=$this->Session->read('society_id'); 


$this->loadmodel('discussion_post');
$conditions=array("discussion_post_id"=>$con);
$this->set('result_topic_view',$this->discussion_post->find('all',array('conditions'=>$conditions))); 

$this->loadmodel('discussion_comment');
$conditions=array("discussion_post_id"=>$con,"delete_id"=>0);
$order=array('discussion_comment.discussion_comment_id'=>'ASC');
$this->set('result_comment',$this->discussion_comment->find('all',array('conditions'=>$conditions,'order'=>$order))); 

}



function discussion_delete_topic()
{
$this->layout='blank';
$s_society_id=$this->Session->read('society_id'); 

$con=(int)$this->request->query('con');
if($con==0) { $this->response->header('Location', 'discussion_forum'); }

$this->loadmodel('discussion_post');
$this->discussion_post->updateAll(array("delete_id" =>1),array("discussion_post_id" => $con));
$this->response->header('Location', 'discussion_forum');
}

function discussion_comment_delete_ajax()
{
$this->layout='blank';

$s_society_id=$this->Session->read('society_id'); 

$c_id=(int)$this->request->query('c_id');

$this->loadmodel('discussion_comment');
$this->discussion_comment->updateAll(array("delete_id" =>1),array("discussion_comment_id" => $c_id));
//$this->response->header('Location', 'discussion');
}



function discussion_delete_topic_archive()
{
	$this->layout='blank';
	$s_society_id=$this->Session->read('society_id'); 
	$con=(int)$this->request->query('con');
	if($con==0) { $this->response->header('Location', 'discussion'); }
	$this->loadmodel('discussion_post');
	$this->discussion_post->updateAll(array("delete_id" =>2),array("discussion_post_id" => $con));
	$this->response->header('Location', 'discussion');
	
}


function discussion_my_topic()
{
$this->layout='blank';
$s_user_id=$this->Session->read('user_id');
$this->set('s_user_id',$s_user_id);
$s_society_id=$this->Session->read('society_id'); 

$tenant=$this->Session->read('tenant');
$role_id=$this->Session->read('role_id');
$wing=$this->Session->read('wing');

$q=(int)$this->request->query('q');
$this->set('q',$q);

if($q==1)
{
$this->loadmodel('discussion_post');
$conditions =array( '$or' => array( 
array('user_id' =>$s_user_id,'delete_id' =>0,'visible' =>1),
array('user_id' =>$s_user_id,'delete_id' =>0,'visible' =>2,'sub_visible' =>array('$in' => array($role_id))),
array('user_id' =>$s_user_id,'delete_id' =>0,'visible' =>3,'sub_visible' =>array('$in' => array($wing))),
array('user_id' =>$s_user_id,'delete_id' =>0,'visible' =>4),
array('user_id' =>$s_user_id,'delete_id' =>0,'visible' =>5)
));
$order=array('discussion_post.discussion_post_id'=>'DESC');
$this->set('result_my_topic',$this->discussion_post->find('all',array('conditions'=>$conditions,'order'=>$order)));   
}

if($q==2)
{
$this->loadmodel('discussion_post');
$conditions =array( '$or' => array( 
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>1),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>2,'sub_visible' =>array('$in' => array($role_id))),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>3,'sub_visible' =>array('$in' => array($wing))),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>4),
array('society_id' =>$s_society_id,'delete_id' =>0,'visible' =>5)
));
$order=array('discussion_post.discussion_post_id'=>'DESC');
$this->set('result_all_topic',$this->discussion_post->find('all',array('conditions'=>$conditions,'order'=>$order)));   
}

if($q==3)
{
$this->loadmodel('discussion_post');
$conditions =array( '$or' => array( 
array('society_id' =>$s_society_id,'delete_id' =>1,'visible' =>1),
array('society_id' =>$s_society_id,'delete_id' =>1,'visible' =>2,'sub_visible' =>array('$in' => array($role_id))),
array('society_id' =>$s_society_id,'delete_id' =>1,'visible' =>3,'sub_visible' =>array('$in' => array($wing))),
array('society_id' =>$s_society_id,'delete_id' =>1,'visible' =>4),
array('society_id' =>$s_society_id,'delete_id' =>1,'visible' =>5)
));
$order=array('discussion_post.discussion_post_id'=>'DESC');
$this->set('result_deleted_topic',$this->discussion_post->find('all',array('conditions'=>$conditions,'order'=>$order)));   
}
}

function discussion_search_topic()
{
$this->layout='blank';
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

function topic_view()
{
$this->layout='blank';
$s_user_id=$this->Session->read('user_id'); 
$this->set('s_user_id',$s_user_id);
$s_society_id=$this->Session->read('society_id'); 
$t=(int)$this->request->query('t');
$this->set('t',$t);

$this->loadmodel('discussion_post');
$conditions=array("discussion_post_id"=>$t);
$this->set('result_topic_view',$this->discussion_post->find('all',array('conditions'=>$conditions))); 

$this->loadmodel('discussion_comment');
//$conditions=array("discussion_post_id"=>$t,"delete_id"=>0);
$conditions =array( '$or' => array( 
array('discussion_post_id' =>$t,'delete_id' =>0),array('discussion_post_id' =>$t,'delete_id' =>2)));

$order=array('discussion_comment.discussion_comment_id'=>'ASC');
$this->set('result_comment',$this->discussion_comment->find('all',array('conditions'=>$conditions,'order'=>$order))); 
}

function discussion_comment_refresh()
{
$this->layout='blank';
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


function discussion_offensive_delete_ajax()
{
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

function discussion_offensive_view()
{
$this->layout="session";
$s_society_id=$this->Session->read('society_id'); 
$this->loadmodel('discussion_comment');
$conditions=array('society_id'=>$s_society_id,'delete_id'=>2);
$result=$this->discussion_comment->find('all',array('conditions'=>$conditions));
$this->set('result_discussion_comment',$result);	
}


function discussion_offensive_delete_ajax1()
{
$this->layout="blank";
$co_id=(int)$this->request->query('con');
$this->loadmodel('discussion_comment');
$this->discussion_comment->updateAll(array("delete_id" =>3),array("discussion_comment_id" => $co_id));
$this->response->header('Location', 'discussion_offensive_view');

}


function topic_view_deleted()
{
$this->layout='blank';
$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id'); 
$t=(int)$this->request->query('t');
$this->set('t',$t);

$this->loadmodel('discussion_post');
$conditions=array("discussion_post_id"=>$t);
$this->set('result_topic_view',$this->discussion_post->find('all',array('conditions'=>$conditions))); 

$this->loadmodel('discussion_comment');
$conditions=array("discussion_post_id"=>$t,"delete_id"=>0);
$this->set('result_comment',$this->discussion_comment->find('all',array('conditions'=>$conditions))); 
}


function discussion_save_comment()
{
$this->layout='blank';
$this->ath(); 
$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id'); 
$tid=(int)$this->request->query('tid');
$g=$this->request->query('c');
$c=htmlentities(wordwrap($g, 25, " ", true));
$c_mod=explode(' ',$g);
$c=nl2br($c);
$date=date("d-m-y");
$time=date('h:i:a',time());
$r=$this->content_moderation_society($c_mod);

if($r==0)
{
echo $word='You have enter wrong word  <br/> ';
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

function count_comment_of_topic($id)
{
	$this->layout='blank';
	$id=(int)$this->decode($id,'housingmatters');
	$this->loadmodel('discussion_comment');
	$conditions =array( '$or' => array( 
	array('discussion_post_id' =>$id,'delete_id' =>0),array('discussion_post_id' =>$id,'delete_id' =>2)));
	return $this->discussion_comment->find('count',array('conditions'=>$conditions)); 

}

///////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////end of discussion forum//////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////  ALL  Repotr start /////////////////////////////////////


function all_report()
{

$this->layout='session';	




}

function contact_report()
{
$this->layout='session';
$s_society_id=$this->Session->read('society_id');
$this->loadmodel('user');
$conditions=array('society_id'=>$s_society_id);
$result=$this->user->find('all',array('conditions'=>$conditions));
$this->set('result_user',$result);


}

function log_user($da_user_id)
{
	
$this->loadmodel('log');
$conditions=array('user_id'=>$da_user_id);
return $result=$this->log->find('all',array('conditions'=>$conditions));	

}


function log_all_report()
{
	$this->layout='session';
	$id=(int)$this->request->query('con');
	$this->loadmodel('log');
	$conditions=array('user_id'=>$id,'status'=>0);
	$order=array('log.log_id'=> 'DESC');
	$result=$this->log->find('all',array('conditions'=>$conditions,'order'=>$order));
	$this->set('result_log',$result);
}


function login_report_user()
{

$this->layout='session';
$s_society_id=$this->Session->read('society_id');
$this->loadmodel('user');
$conditions=array('society_id'=>$s_society_id);
$result=$this->user->find('all',array('conditions'=>$conditions));
$this->set('result_user',$result);

}


function profile_report()
{

$this->layout='session';
$s_society_id=$this->Session->read('society_id');
$this->loadmodel('user');
$conditions=array('society_id'=>$s_society_id);
$result=$this->user->find('all',array('conditions'=>$conditions));
$this->set('result_user',$result);


}

function profile_log($id)
{
	
$this->loadmodel('profile_log');
$conditions=array('user_id'=>$id);
return $result=$this->profile_log->find('all',array('conditions'=>$conditions));

}

function profile_all_report()
{
	$this->layout='session';
	$id=(int)$this->request->query('con');
	$this->loadmodel('profile_log');
	$conditions=array('user_id'=>$id);
	$order=array('profile_log.profile_log_id'=> 'DESC');
	$result=$this->profile_log->find('all',array('conditions'=>$conditions,'order'=>$order));
	$this->set('result_profile_log',$result);
	
}
function login_report_unit()
{

$this->layout='session';
$s_society_id=$this->Session->read('society_id');
$this->loadmodel('user');
$conditions=array('society_id'=>$s_society_id);
$result=$this->user->find('all',array('conditions'=>$conditions));
$this->set('result_user',$result);
}


function complaint_closed_report()
{

$this->layout="session";	
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$this->loadmodel('help_desk');
$conditions=array("help_desk_status" =>1,"society_id" => $s_society_id);
$order=array('help_desk.ticket_id'=> 'DESC');
$result=$this->help_desk->find('all',array('conditions'=>$conditions,'order' =>$order));
$this->set('result_help_desk',$result);



}


function complaint_open_report()
{
$this->layout="session";
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$this->loadmodel('help_desk');
$conditions=array("help_desk_status" => 0,"society_id" => $s_society_id);
$order=array('help_desk.ticket_id'=> 'DESC');
$result_help_desk=$this->help_desk->find('all',array('conditions'=>$conditions,'order' =>$order));
$this->set('result_help_desk',$result_help_desk);

}



function sp_performance_report()
{
	

$this->layout="session";
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');


if($this->request->is('post')) 
{
 $this->set('date1',$this->request->data['from']);
 $this->set('date2',$this->request->data['to']);
 
 $this->loadmodel('help_desk');
$conditions=array('society_id'=>$s_society_id,'help_desk.help_desk_service_provider_id'=> array('$ne' => 0));
$result12=$this->help_desk->find('all',array('conditions'=>$conditions));
$this->set('result_help_desk',$result12);
	
}

}


function sp_performance_report_pdf()
{

$this->layout="pdf";
$this->layout="session";
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
 $date1=$this->request->query('con');
 $date2=$this->request->query('con2');

$this->loadmodel('help_desk');
$conditions=array('society_id'=>$s_society_id,'help_desk.help_desk_service_provider_id'=> array('$ne' => 0));
$result12=$this->help_desk->find('all',array('conditions'=>$conditions));
$this->set('result_help_desk',$result12);
App::import('Vendor','xtcpdf');  
$tcpdf = new XTCPDF(); 
$textfont = 'freesans'; // looks better, finer, and more condensed than 'dejavusans' 
$tcpdf->SetAuthor("KBS Homes & Properties at http://kbs-properties.com"); 
$tcpdf->SetAutoPageBreak( true ); 
//$tcpdf->setHeaderFont(array($textfont,'',40)); 
$tcpdf->xheadercolor = array(255,255,255); 
$tcpdf->xheadertext = ''; 
$tcpdf->xfootertext = 'HousingMatters'; 
$tcpdf->AddPage(); 
$tcpdf->SetTextColor(0, 0, 0); 
$tcpdf->SetFont($textfont,'N',12);
$html='
<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
Service Provider Performance Report
</div>
<br>
<table><tr><th><b>Sr No.</b></th>
<th><b>Ticket</b></th>
<th><b>Service Provider</b></th>
<th><b>Assigned Date</b></th>
<th><b>Closure Date</b></th>
<th><b>Average</b></th></tr>';
$i=0;
foreach($result12 as $data)
{
 $avg='';
$assign_date=$data['help_desk']['help_desk_assign_date'];
$close_date=@$data['help_desk']['help_desk_close_date'];
$help_desk_date=$data['help_desk']['help_desk_date'];
$sp_id=$data['help_desk']['help_desk_service_provider_id'];
$ticket_id=$data['help_desk']['ticket_id'];
 $help_desk_date1=date("d-m-y", strtotime($help_desk_date));
 $help_desk_date2 = date("Y-m-d", strtotime($help_desk_date1));
 $help_desk_date3 = date("d-m-Y", strtotime($help_desk_date2));

if(!empty($assign_date) && !empty($close_date))
{
$newDate = date("d-m-y", strtotime($assign_date));
$newDate1 = date("Y-m-d", strtotime($newDate));
$newDate2 = date("d-m-y", strtotime($close_date));
$newDate3 = date("Y-m-d", strtotime($newDate2));
$datetime1 = date_create($newDate1);
$datetime2 = date_create($newDate3);
$interval = date_diff($datetime1, $datetime2);
$avg= $interval->format('%R%a days');
}
$sp=$this->fetch_service_provider_info_via_vendor_id($sp_id);
foreach($sp as $data)
{
	$sp_name=$data['service_provider']['sp_name'];
	
}
if(strtotime($date1)<=strtotime($help_desk_date3) && strtotime($date2)>=strtotime($help_desk_date3))
{
$i++;
$html.='
<tr>
<td>'.$i .'</td>
<td>'.$ticket_id.'</td>
<td>'.$sp_name.'</td>
<td>'.$assign_date.'</td>
<td>'.$close_date.'</td>
<td>'.$avg.'</td></tr>
';
} }
$html.="</table>";
$tcpdf->writeHTML($html);
echo $tcpdf->Output('sp_report.pdf', 'D'); 
}

////////////////////////////////////////////  End Report  ////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////// Resource Start ////////////////////////////////////////////////////////////	

function resource_add()
{

	$this->layout='session';
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
				?>
                

				<!----alert-------------->
				<div class="modal-backdrop fade in"></div>
				<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
				<div class="modal-body" style="font-size:16px;">
				Documents are sent for approval
				</div> 
				<div class="modal-footer">
				<a href="resource_view" class="btn green">OK</a>
				</div>
				</div>
				<!----alert-------------->
								
                
                
                
                <?php		
			
			
			
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
<td>$resource_title</td>
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
@$subject.= ''. $society_name . ''.'-' . 'New Document upload'.  '    ' .$resource_title;
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$subject="";
}	
}



$this->send_notification('<span class="label label-warning" ><i class="icon-folder-open"></i></span>','New document <b>'.$resource_title.'</b> submitted by',4,$i,'resource_view',$s_user_id,$da_user_id);
?>
<!----alert-------------->
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
foreach($result as $dda)
	{
		 $id=(int)$dda['resource']['resource_id'];
		$this->seen_notification(4,$id);
		
	}
	
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
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
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


/* $message_web="<div>
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
</div>";*/

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
										<td align="left" style="background-color:#00A0E3;color:white;" >Date</td>
										<td align="left" style="background-color:#f8f8f8;" >'.$date.'</td>
										</tr>
										

										
										
										<tr>
										<td align="left" style="background-color:#00A0E3;color:white;" >Category</td>
										<td align="left" style="background-color:#f8f8f8;" >'.$category_name.'</td>
										</tr>
										
										<tr>
										<td align="left" style="background-color:#00A0E3;color:white;" >Title	</td>
										<td align="left" style="background-color:#f8f8f8;" >'.$title.'</td>
										</tr>
										
										
										<tr>
										<td align="left" style="background-color:#00A0E3;color:white;" >Attention</td>
										<td align="left" style="background-color:#f8f8f8;" >'.$send.'</td>
										</tr>
									
										</table> 
									
									</td>
								
								
								
								</tr>
								

					
								<tr>
										<td style="padding:5px;" width="100%" align="center">
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
@$subject.= '['. $society_name . ']'.'-' . 'New Document :'.  '    ' .$title;
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$subject="";
}	
}

$this->send_notification('<span class="label label-warning" ><i class="icon-folder-open"></i></span>','New document <b>'.$title.'</b> submitted by',4,$id,$this->webroot.'Documents/resource_view',$user_id,$da_user_id);


$this->loadmodel('resource');
$this->resource->updateAll(array('resource_delete'=>0),array('resource_id'=>$id));	

}

function resource_view()
{
$this->layout='session';
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

function resource_edit()
{
$this->layout='session';
$s_society_id=$this->Session->read('society_id');
$res_id=(int)$this->request->query('con');
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
/*
if($visible==1)
{
if(in_array(1,$sub_visible))
{
/////////////////////////////////////////// All Owner mail functionality conditions //////////////////////////////////////////////////////

$this->loadmodel('user');
$conditions=array('tenant'=>1,'society_id'=>$s_society_id);
$result_user=$this->user->find('all',array('conditions'=>$conditions));
foreach($result_user as $data)
{
$da_to[]=$data['user']['email'];
$da_user_name[]=$data['user']['user_name'];
$da_user_id[]=$data['user']['user_id'];
}
//////////////////////////////// end mail ////////////////////////////////////////////////////////		

}
if(in_array(2,$sub_visible))
{

/////////////////////////////////////////// All Tenant mail functionality conditions //////////////////////////////////////////////////////

$this->loadmodel('user');
$conditions=array('tenant'=>2,'society_id'=>$s_society_id);
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

if($visible==2)
{
foreach ($role_result as $collection) 
{
$role_id=$collection["role"]["role_id"];
if(in_array($role_id,$sub_visible))
{

/////////////////////////////////////////// All role  functionality  conditions //////////////////////////////////////////////////////
$this->loadmodel('user');
$conditions=array('role_id'=>$role_id,'society_id'=>$s_society_id);
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
$da_to=array_unique($da_to);
}

if($visible==3)
{

foreach($wing_result as $collection)
{

$wing_id=$collection['wing']['wing_id'];

if(in_array($wing_id,$sub_visible))
{

/////////////////////////////////////////// All wing wise  functionality conditions //////////////////////////////////////////////////////
$this->loadmodel('user');
$conditions=array('wing'=>$wing_id,'society_id'=>$s_society_id);
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

}




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

for($k=0;$k<sizeof(@$da_to);$k++)
{
$to = @$da_to[$k];
$d_user_id = @$da_user_id[$k];	 
$user_name = @$da_user_name[$k];
$message_web="<div>
<img src='http://123.63.2.150:8080".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='http://123.63.2.150:8080".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='http://123.63.2.150:8080".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='http://123.63.2.150:8080".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
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
<td>$resource_date</td>
<td>$category_name</td>
<td>$resource_title</td>
<td>$send</td>
</tr>
</table>
<div>
<center><p>To view document 
<a href='http://123.63.2.150:8080".$this->webroot."hms' ><button style='width:100px; height:30px;  background-color:#00A0E3;color:white'> Click Here </button></a></p></center><br/>
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
@$subject.= ''. $society_name . ''.'-' . 'New Document upload'.  '    ' .$resource_title;
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$subject="";
}	
}
*/


$this->loadmodel('resource');
$this->resource->updateAll( array("resource_attachment" => $resource_att,"resource_title"=>$resource_title,'resource_category'=> $resource_cat),array("resource_id" => $res_id));
$this->response->header('Location', 'resource_view');
}

}


////////////////////////////////////////////////////Resource End /////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////Classified Start //////////////////////////////////////////////////////////////////

function classified_select_category()
{	
$this->layout='session';
$this->loadmodel('master_classified_category');
$this->set('result_select_category',$this->master_classified_category->find('all'));


}


function classified_category_name($main_category)
{	
$this->loadmodel('master_classified_category');
$conditions=array("category_id" => $main_category);
$resut_category=$this->master_classified_category->find('all',array('conditions'=>$conditions));
	foreach ($resut_category as $collection)
	{
	return $collection['master_classified_category']['category_name'];
	}	
}

function classified_subcategory_name($subcategory)
{	
$this->loadmodel('master_classified_subcategories');
$conditions=array("subcategory_id" => $subcategory);
$resut_category=$this->master_classified_subcategories->find('all',array('conditions'=>$conditions));
	foreach ($resut_category as $collection)
	{
	return $collection['master_classified_subcategories']['subcategory_name'];
	}	
}





function master_classified_subcategory($classified_category_id)
{
$this->loadmodel('master_classified_subcategory');
$conditions=array('category_id' => $classified_category_id);
return $this->master_classified_subcategory->find('all',array('conditions'=>$conditions));
}



function classified_post_ad()
{
$this->ath();
$this->layout='session';
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$post_category_id = (int)$this->request->query('a');
$post_sub_category_id = (int)$this->request->query('b');
if(isset($this->request->data['pub'])) 
{

date_default_timezone_set('Asia/Kolkata');
$date=date("d-m-Y");
$time = date(' h:i a', time());
$title=htmlentities($this->request->data['title']);
$description=htmlentities($this->request->data['description']);
$price=$this->request->data['price'];
$offer_up_to_date=$this->request->data['offer'];
if(empty($offer_up_to_date))
{
$offer_up_to_date_s=date('Y-m-d', strtotime($date. ' +30 days'));
$offer_up_to_date=date('d-m-Y', strtotime($offer_up_to_date_s));
}
$price_type=(int)$this->request->data['optionsRadios1'];
$condition=(int)$this->request->data['condition'];
$sell=(int)$this->request->data['sell'];
$photo_name =$this->request->form['photo_upload']['name'];
$target = "classified_photos/";
$target=@$target.basename( @$this->request->form['photo_upload']['name']);
$ok=1;
move_uploaded_file(@$this->request->form['photo_upload']['tmp_name'],@$target); 
$this->loadmodel('classified');
$i=$this->autoincrement('classified','classified_id');
$this->classified->saveAll(array('classified_id' => $i, 'user_id' => $s_user_id, 'society_id' => $s_society_id, 'classified_title' => $title ,
'classified_attachment' => $photo_name , 'classified_price' => $price, 'classified_price_type' => $price_type , 'classified_type_ad' => $sell ,'classified_condition' => $condition ,'classified_description' => $description, 'classified_offer_up_to_date' => $offer_up_to_date, 'classified_post_category_id' => $post_category_id, 'classified_post_sub_category_id' => $post_sub_category_id, 'classified_date' => $date , 'classified_time' => $time , 'classified_delete_id' => 0,'c_status'=>1));
?>
<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Your Post Classified Ads is Publish
</div> 
<div class="modal-footer">
<a href="classified" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php

}


if(isset($this->request->data['draft'])) 
{


date_default_timezone_set('Asia/Kolkata');
$date=date("d-m-Y");
$time = date(' h:i a', time());
$title=htmlentities($this->request->data['title']);
$description=htmlentities($this->request->data['description']);
$price=$this->request->data['price'];
$offer_up_to_date=$this->request->data['offer'];
$price_type=(int)$this->request->data['optionsRadios1'];
$condition=(int)$this->request->data['condition'];
$sell=(int)$this->request->data['sell'];
$photo_name =$this->request->form['photo_upload']['name'];
$target = "classified_photos/";
$target=@$target.basename( @$this->request->form['photo_upload']['name']);
$ok=1;
move_uploaded_file(@$this->request->form['photo_upload']['tmp_name'],@$target); 
$this->loadmodel('classified');
$i=$this->autoincrement('classified','classified_id');
$this->classified->saveAll(array('classified_id' => $i, 'user_id' => $s_user_id, 'society_id' => $s_society_id, 'classified_title' => $title ,
'classified_attachment' => $photo_name , 'classified_price' => $price, 'classified_price_type' => $price_type , 'classified_type_ad' => $sell ,'classified_condition' => $condition ,'classified_description' => $description, 'classified_offer_up_to_date' => $offer_up_to_date, 'classified_post_category_id' => $post_category_id, 'classified_post_sub_category_id' => $post_sub_category_id, 'classified_date' => $date , 'classified_time' => $time , 'classified_delete_id' => 0,'c_status'=>0 ));

?>
<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Your Post Classified Ads is Draft
</div> 
<div class="modal-footer">
<a href="classified_draft" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php

}
}


function classified()
{	
$this->layout='session';
$this->ath();

$cat1=(int)@$this->request->query('cat');
$this->set('cat',$cat1);

$this->loadmodel('master_classified_category');
$order=array('master_classified_category.category_name'=>'ASC');
$this->set('result_classified',$this->master_classified_category->find('all',array('order'=>$order)));
$this->loadmodel('classified');
if(empty($cat1)) 
{
$condition1=array("classified_delete_id" => 0,"c_status" =>1);
$this->set('resut_cat',$this->classified->find('all',array('conditions'=>$condition1)));
}

if(!empty($cat1)) 
{
$condition1=array("classified_delete_id" => 0,"classified_post_category_id" => $cat1,"c_status" =>1);
$this->set('resut_cat',$this->classified->find('all',array('conditions'=>$condition1)));
}

}

function classified_detail()
{
$this->ath();
$this->layout='session';
$id=(int)@$this->request->query('con');
$this->loadmodel('classified');
$conditions=array("classified_id" => $id);
$this->set('result_cate',$this->classified->find('all',array('conditions'=>$conditions)));

}

function mail_post_ad()
{
$this->layout='session';
$to=@$this->request->query('r');
$this->set('title',@$this->request->query('con'));

if($this->request->is('post'))
{
$subject=htmlentities($this->request->data['subject']);
$message_web=htmlentities($this->request->data['message']);
$from_name="HousingMatters";
$this->loadmodel('email');
$conditions=array("auto_id" => 3);
$res=$this->email->find('all',array('conditions'=>$conditions));
foreach ($res as $collection)
{ 
$from = $collection['email']['from'];
}
$reply=$from;
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
}

}


function classified_draft()
{

$this->ath();
$this->layout='session';
$s_user_id=$this->Session->read('user_id');
$cat1=(int)@$this->request->query('cat');
$this->set('cat',$cat1);
$this->loadmodel('master_classified_category');
$order=array('master_classified_category.category_name'=>'ASC');
$this->set('result_classified_draft',$this->master_classified_category->find('all',array('order'=>$order)));
$this->loadmodel('classified');
$condition1=array("classified_delete_id" => 0,"c_status" =>0,"user_id" =>$s_user_id);
$this->set('resut_cat',$this->classified->find('all',array('conditions'=>$condition1)));



}

function classified_my_post()
{
$this->ath();
$this->layout='session';
$s_user_id=$this->Session->read('user_id');
$cat1=(int)@$this->request->query('cat');
$this->set('cat',$cat1);
$this->loadmodel('master_classified_category');
$order=array('master_classified_category.category_name'=>'ASC');
$this->set('result_classified_my_post',$this->master_classified_category->find('all',array('order'=>$order)));
$this->loadmodel('classified');
$condition1=array("classified_delete_id" => 0,"c_status" =>1,"user_id" =>$s_user_id);
$this->set('resut_cat',$this->classified->find('all',array('conditions'=>$condition1)));

}


function classified_detail_mypost()
{
$this->ath();
$this->layout='session';
$id=(int)@$this->request->query('con');
$this->loadmodel('classified');
$conditions=array("classified_id" => $id);
$this->set('result_cate',$this->classified->find('all',array('conditions'=>$conditions)));

}

function classified_post_draft_edit()
{
$this->ath();
$this->layout='session';
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$get_id = (int)$this->request->query('e');
$this->loadmodel('master_classified_category');
$this->set('result1',$this->master_classified_category->find('all'));
$this->loadmodel('master_classified_subcategory');
$this->set('result1',$this->master_classified_category->find('all'));
$this->loadmodel('classified');
$conditions=array("classified_id" => $get_id);
$result= $this->classified->find('all',array('conditions'=>$conditions));
foreach($result as $collection)
{
$view_attachment = $collection['classified']['classified_attachment'];
}

$this->set('result_classified',$result); 


if(isset($this->request->data['sub'])) 
{
date_default_timezone_set('Asia/Kolkata');
$date=date("d-m-Y");
$time = date(' h:i a', time());
$title=htmlentities($this->request->data['title']);
$description=htmlentities($this->request->data['description']);
$price=$this->request->data['price'];
$offer_up_to_date=$this->request->data['offer'];
$price_type=(int)$this->request->data['optionsRadios1'];
$condition_ad=(int)$this->request->data['condition'];
$sell_ad=(int)$this->request->data['sell'];
$photo_name =$this->request->form['photo_upload']['name'];
$cat_main=(int)$this->request->data['class_main'];
$cat_sub=(int)$this->request->data['class_sub'];
if(empty($photo_name))
{
$photo_name = $view_attachment;
}
$target = "classified_photos/";
$target=@$target.basename( @$this->request->form['photo_upload']['name']);
$ok=1;
move_uploaded_file(@$this->request->form['photo_upload']['tmp_name'],@$target); 
$this->loadmodel('classified');
$this->classified->updateAll(array('user_id' => $s_user_id, 'society_id' => $s_society_id, 'classified_title' => $title ,
'classified_attachment' => $photo_name , 'classified_price' => $price, 'classified_price_type' => $price_type ,  'classified_type_ad' => $sell_ad ,'classified_condition' => $condition_ad ,'classified_description' => $description, 'classified_offer_up_to_date' => $offer_up_to_date, 'classified_date' => $date , 'classified_time' => $time , 'classified_delete_id' => 0,'classified_post_category_id'=>$cat_main,'classified_post_sub_category_id'=>$cat_sub,'c_status' =>0),array('classified_id'=> $get_id));

?>

<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Your Post Classified Ads is Draft
</div> 
<div class="modal-footer">
<a href="classified_draft" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php




}

if(isset($this->request->data['pub'])) 
{

date_default_timezone_set('Asia/Kolkata');
$date=date("d-m-Y");
$time = date(' h:i a', time());
$title=htmlentities($this->request->data['title']);
$description=htmlentities($this->request->data['description']);
$price=$this->request->data['price'];
$offer_up_to_date=$this->request->data['offer'];
$price_type=(int)$this->request->data['optionsRadios1'];
$condition_ad=(int)$this->request->data['condition'];
$sell_ad=(int)$this->request->data['sell'];
$photo_name =$this->request->form['photo_upload']['name'];
$cat_main=(int)$this->request->data['class_main'];
$cat_sub=(int)$this->request->data['class_sub'];

if(empty($photo_name))
{
$photo_name = $view_attachment;
}
$target = "classified_photos/";
$target=@$target.basename( @$this->request->form['photo_upload']['name']);
$ok=1;
move_uploaded_file(@$this->request->form['photo_upload']['tmp_name'],@$target); 
$this->loadmodel('classified');
$this->classified->updateAll(array('user_id' => $s_user_id, 'society_id' => $s_society_id, 'classified_title' => $title ,
'classified_attachment' => $photo_name , 'classified_price' => $price, 'classified_price_type' => $price_type ,  'classified_type_ad' => $sell_ad ,'classified_condition' => $condition_ad ,'classified_description' => $description,'classified_offer_up_to_date' => $offer_up_to_date,'classified_date' => $date , 'classified_time' => $time ,'classified_delete_id' => 0,'classified_post_category_id'=>$cat_main,'classified_post_sub_category_id'=>$cat_sub,'c_status' =>1),array('classified_id'=> $get_id));

?>
<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Your Post Classified Ads is Publish
</div> 
<div class="modal-footer">
<a href="classified" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php

}






}

function classified_cat_subcategory_ajax()
{

$this->layout='blank';
$this->set('category_id',(int)$this->request->query('con1'));

}

///////////////////////////////////////////////// Classified End /////////////////////////////////////////////////////////////////////




////////////////////////////////// /////////////////////////// Profile  Start //////////////////////////////////////////////////

function flat($c_wing_id)
{
$this->loadmodel('flat');
$conditions=array("wing_id" => $c_wing_id);
return $this->flat->find('all',array('conditions'=>$conditions));

}

function hms_email_ip()
{
	
	$this->loadmodel('user');
	$conditions=array('society_id'=>0);
	$result=$this->user->find('all',array('conditions'=>$conditions));
	foreach($result as $data)
	{
		return @$data['user']['email_ip'];
	}

}


function hms_sms_ip()
{
	
	$this->loadmodel('user');
	$conditions=array('society_id'=>0);
	$result=$this->user->find('all',array('conditions'=>$conditions));
	
	foreach($result as $data)
	{
		$w= $data['user']['sms_working_key'];
		$s= $data['user']['sms_sender'];
		$alow= @$data['user']['sms_allow'];
		
		return $sms=(object)array("working_key"=>$w,"sms_sender"=>$s,"sms_allow"=>$alow);
		
	}
	
/*
$ip=$this->hms_email_ip();
$r=$this->hms_sms_ip();
  $working_key=$r->working_key;
 $sms_sender=$r->sms_sender; */
	
}


function hobbies_category_fetch($id){
	
$this->loadmodel('hobbies_category');
$conditions=array('hobbies_id'=>$id);	
$result_hobbies_cat=$this->hobbies_category->find('all',array('conditions'=>$conditions));
	foreach($result_hobbies_cat as $data){
		
		return $data['hobbies_category']['hobbies_name'];
	}
}
		

function profile() 
{

$this->ath();
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$s_society_id=$this->Session->read('society_id');
$s_role_id=$this->Session->read('role_id'); 
$s_user_id=$this->Session->read('user_id');
$r=$this->request->query('try');
$this->set('s_role_id',$s_role_id);
$this->seen_alert(101,$s_user_id);
@$ip=$this->hms_email_ip();
 
if(!empty($r))
{
$this->loadmodel('user');
$this->user->updateAll(array('profile_status'=>2),array('user_id'=>$s_user_id));
$this->redirect(array('action' => 'profile'));
}

$this->loadmodel('user');
$conditions2=array('user_id'=>$s_user_id);
$result_user=$this->user->find('all',array('conditions'=>$conditions2));
foreach($result_user as $data)
{
	   $profile=$data['user']['profile_pic'];
	   $tenant=$data['user']['tenant'];
	   
}
$this->set('tenant',$tenant);
$result_society=$this->society_name($s_society_id);
foreach($result_society as $data)
{
	 $society_name2=$data['society']['society_name'];
	 @$family_member=$data['society']['family_member'];
	 @$family_member_tenant=$data['society']['family_member_tenant'];
	 
}
$this->set('family_member',$family_member);
$this->set('family_member_tenant',$family_member_tenant);
$this->loadmodel('hobbies_category');
$this->set('hobbies_category',$this->hobbies_category->find('all'));


if($this->request->is('post')) 
{
	
 @$name=htmlentities($this->request->data['name']);	
 @$medical=htmlentities($this->request->data['medical']);	
 @$mobile=htmlentities($this->request->data['mobile1']); 
 @$email=htmlentities($this->request->data['email']);
 @$sex=(int)htmlentities($this->request->data['sex']);
 @$age=htmlentities($this->request->data['age']);
 @$per_address=htmlentities($this->request->data['per_address']);
 @$com_address=htmlentities($this->request->data['com_address']);
 @$hob=$this->request->data['hob'];
 @$photo_name =$this->request->form['profile_photo']['name'];
 @$blood_group=htmlentities($this->request->data['blood_group']);
 @$contact_emergency=htmlentities($this->request->data['contact_emergency1']);	
  

if($blood_group==1)
{
$b_group="A+";
}
if($blood_group==2)
{
$b_group="B+";
}
if($blood_group==3)
{
$b_group="AB+";
}
if($blood_group==4)
{
$b_group="O+";
}
 if($blood_group==5)
{
$b_group="A-";
}
if($blood_group==6)
{
$b_group="B-";
}
if($blood_group==7)
{
$b_group="AB-";
}
if($blood_group==8)
{
$b_group="O-";
}
 if($medical==1)
 {
	 
	 $med_pro="Yes";
 }
 
 if($medical==2)
 {
	 
	 $med_pro="No";
 }
 
if($age==1)
{
$age_group="18-24";
}

if($age==2)
{
$age_group="25-34";
}


if($age==3)
{
$age_group="35-44";
}

if($age==4)
{
$age_group="45-54";
}
if($age==5)
{
$age_group="55-64";
}
 
if($age==6)
{
$age_group="65+";
}

 $result_user=$this->profile_picture($s_user_id);
 foreach($result_user as $data)
 {
	  $email1=$data['user']['email'];
	  $mobile1=$data['user']['mobile'];
	 
 }
 
 if($email==$email && $mobile==$mobile1)
 {
	
	 
 }
 else{
	 
		date_default_timezone_set('Asia/Kolkata');
		$date=date("d-m-Y");
		$time = date(' h:i a', time());
		$op=$this->autoincrement('profile_log','profile_log_id');
		$this->loadmodel('profile_log');
		$this->profile_log->saveAll(array('profile_log_id'=>$op,'user_id'=>$s_user_id,'society_id'=>$s_society_id,'email'=>$email1,'mobile'=>$mobile1,'new_email'=>$email,'new_mobile'=>$mobile,'date'=>$date,'time'=>$time));
 }
 
 
if(empty($photo_name))
{
	$photo_name=$profile;
	
}

	$target = "profile/";
	$target=@$target.basename( @$this->request->form['profile_photo']['name']);
	$ok=1;
	move_uploaded_file(@$this->request->form['profile_photo']['tmp_name'],@$target); 
	$this->loadmodel('user');
	$this->user->updateAll(array("user_name" => $name,"email" => $email,'mobile'=>$mobile,'sex'=>$sex,'dob'=>$age,'per_address'=>$per_address,'comm_address'=>$com_address,'hobbies'=>$hob,'profile_pic'=>$photo_name,'blood_group'=>$blood_group,'medical_pro'=>$medical,'contact_emergency'=>$contact_emergency),array("user_id" => $s_user_id));
	$this->loadmodel('ledger_sub_accounts');
	$this->ledger_sub_accounts->updateAll(array("name" => $name),array("user_id" => $s_user_id));
	
$to=$email;
$from_name="HousingMatters";
 $subject='['.$society_name2.']-Profile Update';
$this->loadmodel('email');
$conditions=array('auto_id'=>4);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
}
$reply=$from;

  /* @$message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
<p> Your profile is successfully update. </p>
<p> Name : $name </p>
<p> Mobile : $mobile </p>
<p> Email : $email </p>
<p> Age group : $age_group </p>
<p> Contact number emergency : $contact_emergency </p>
<p> Permanent address : $per_address </p>
<p> Communication address : $com_address </p>
<p> Hobbies : $hob </p>
<p> Blood group : $b_group </p>
<p> Medical professional : $med_pro </p>
<br/>
Thank you.<br/>
HousingMatters (Support Team)<br/>
www.housingmatters.co.in
</div >
</div>";

*/

  @$message_web='<table  align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
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
								</tr>
								
									
								
						</tbody>
					</table>
					
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span  align="justify"> Your profile is successfully update. </span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span  align="justify">  Name : '.$name.'  </span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span  align="justify"> Mobile : '.$mobile.'  </span> 
										</td>
																
								</tr>
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span  align="justify">  Email : '.$email.' </span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span  align="justify"> Age group : '.$age_group.'</span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span  align="justify"> Contact number emergency : '.$contact_emergency .'</span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span  align="justify"> Permanent address : '.$per_address.'</span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span  align="justify"> Communication address : '.$com_address.' </span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span  align="justify"> Hobbies : '.$hob.' </span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span  align="justify"> Blood group : '.$b_group.' </span> 
										</td>
																
								</tr>
								
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span  align="justify"> Medical professional : '.@$med_pro.' </span> 
										</td>
																
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left"><br/>
											<span style="color:rgb(100,100,99)"> 
												Thank you.<br/>
												HousingMatters (Support Team)<br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';



$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
$this->Session->write('profile_status', 1);
$this->response->header('Location', $this->webroot.'Hms/dashboard');
	
}



$this->loadmodel('user');
$conditions=array("user_id" => $s_user_id);
$this->set('result_user',$this->user->find('all',array('conditions'=>$conditions)));            
$this->loadmodel('wing'); 
$this->set('result1',$this->wing->find('all'));   
}

function profile_flat_ajax()
{
$this->layout='blank';	
$wing_id=(int)$this->request->query['con'];
$this->loadmodel('flat');
$conditions=array("wing_id" => $wing_id);
$result = $this->flat->find('all',array('conditions'=>$conditions));
$this->set('result3',$result);
}


function profile_check_private()
{
$this->layout='blank';
$s_user_id=$this->Session->read('user_id');
$pub=$this->request->query('con');
$t= explode(',',$pub);

$field=$t[0];
$private_pubice=$t[1];
if($private_pubice==1)
{
$this->loadmodel('user');
$conditions=array('user_id'=>$s_user_id);
$res= $this->user->find('all',array('conditions'=>$conditions));
foreach($res as $data)
{
$row =@$data['user']['private'];
}

if(@!in_array($field,$row))
{
$row[]=$field;
$this->loadmodel('user');
$this->user->updateAll(array('private'=>$row),array('user_id'=>$s_user_id));
}

}
elseif($private_pubice==0)
{
$this->loadmodel('user');
$conditions=array('user_id'=>$s_user_id);
$res= $this->user->find('all',array('conditions'=>$conditions));
foreach($res as $data)
{
$row =$data['user']['private'];
}


if(($key=array_search($field,$row))!== false)
{
unset($row[$key]);

$this->loadmodel('user');
$this->user->updateAll(array('private'=>$row),array('user_id'=>$s_user_id));

}

}


}
/////////////////////////// ////////////////////////////// /End Profile ///////////////////////////////////////////////////////


/////////////////////////// start Content modaration  //////////////////////////////

function society_details()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}
$this->ath();

//$webroot_path=$this->requestAction(array('controller' => 'Hms', 'action' => 'webroot_path'));
//$this->set('webroot_path',$webroot_path);


	$s_society_id=$this->Session->read('society_id'); 
	$sco_n=$this->society_name($s_society_id);
	foreach($sco_n as $data)
	{
	$sco= $data['society']['society_name'];
	}
	$this->set('society_name',$sco);
	if($this->request->is('post'))
	{
	$pan=$this->request->data['pan'];
	$s_tax=$this->request->data['s_tax'];
	$s_number=$this->request->data['s_number'];
	$address=$this->request->data['address'];
	$society_phone = @$this->request->data['society_phone'];
    $society_email = @$this->request->data['society_email'];	
    $sig_title = @$this->request->data['title'];
	
	$logo=$_FILES['logo']['name'];
    $sig=$_FILES['sig']['name'];	
	


$target = "logo/";
$target = $target . basename( $_FILES['logo']['name']) ;
move_uploaded_file($_FILES['logo']['tmp_name'], $target);


$target = "sig/";
$target = $target . basename($_FILES['sig']['name']) ;
move_uploaded_file($_FILES['sig']['tmp_name'], $target);	

$this->loadmodel('society');
$this->society->updateAll(array('pan'=>$pan,'tex_number'=>$s_tax,'society_address'=>$address,'society_reg_num'=>$s_number,"society_phone"=>$society_phone,"society_email"=>$society_email,"signature"=>@$sig,"logo"=>@$logo,"sig_title"=>$sig_title),array('society_id'=>$s_society_id));

?>

<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Society details updated successfully.
</div> 
<div class="modal-footer">
<a href="society_details" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php		
}
$this->loadmodel('society');
$conditions=array('society_id'=>$s_society_id);
$result=$this->society->find('all',array('conditions'=>$conditions));
$this->set('result_society',$result);
}

function content_moderation()
{
	$this->layout='session';
	$s_society_id=$this->Session->read('society_id'); 
	$this->loadmodel('society');
	$conditions=array('society_id'=>$s_society_id);
	$result=$this->society->find('all',array('conditions'=>$conditions));
	$this->set('result_society',$result);
	if($this->request->is('post'))
	{
		
	     $id=$this->request->data['text_name'];
		 
		if(!empty($id))
		{
			$content=$this->request->data['name'];
			echo $content ;
			$r=explode(',',$content);
			
			if(!empty($r))
			{
				
				$this->loadmodel('society');
				$this->society->updateAll(array('content_moderation'=>$r),array('society_id'=>$s_society_id));
			}
		}
		else
		{
			
		 $content[]=$this->request->data['name'];
		foreach($result as $data)
		{
			 $con=@$data['society']['content_moderation'];
		}
		if(!empty($con))
		{
		 $content=$this->request->data['name'];
		array_push($con,$content);	
		$this->loadmodel('society');
		$this->society->updateAll(array('content_moderation'=>$con),array('society_id'=>$s_society_id));
		
		}
		else
		{
			$this->loadmodel('society');
		   $this->society->updateAll(array('content_moderation'=>$content),array('society_id'=>$s_society_id));
		   
		}
		}
		$this->response->header('location','content_moderation');
		
	}
}


function content_moderation_delete()
{
	
	 $id=(int)$this->request->query('con');
	 $this->loadmodel('moderation');
	 $this->moderation->updateAll(array('c_m_delete'=>1),array('auto_id'=>$id));
	 $this->response->header('location','content_moderation');
	
}

///////////////////////// End Contant Modaration  /////////////////////////////////

/////////////////// Start Contact Handbook ////////////////////////////


function contact_handbook_export()
{
	
$this->layout="";
$s_society_id=$this->Session->read('society_id');
$result_society=$this->society_name($s_society_id);
$society_name=$result_society[0]['society']['society_name'];
$filename=$society_name.'_contact_handbook_';
$filename = str_replace(' ', '_', $filename);


$filename='Contact Handbook';
header ("Expires: 0");
header ("border: 1");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls");
header ("Content-Description: Generated Report" );
$export="<div align='center'> 
<span style='font-size:16px;'>".$society_name." <span>
<br/>
<span>contact handbook<span>
</div>";
$export.="<table border='1'>
<tr>
<th>Sr no.</th>
<th>Service Provider/ Vendor</th>
<th>Services offered</th>
<th>Mobile</th>
<th>Email</th>
<th>Website</th>

</tr>
";	
$i=0;
$this->loadmodel('contact_handbook');
$conditions=array('society_id'=>$s_society_id,'c_h_delete'=>0);
$result=$this->contact_handbook->find('all',array('conditions'=>$conditions));
	foreach($result as $collection)
	{
		$i++;
		$c_h_id=$collection['contact_handbook']["c_h_id"];
		$mobile=$collection['contact_handbook']["c_h_mobile"];
		$user_id=(int)$collection['contact_handbook']['user_id'];
		$name=$collection['contact_handbook']["c_h_name"];
		$email=$collection['contact_handbook']["c_h_email"];
		$web=$collection['contact_handbook']["c_h_web"];
		$service=$collection['contact_handbook']["c_h_service"];
		$result_user=$this->profile_picture($user_id);
		foreach($result_user as $data)
		{
			 $user_name=$data['user']['user_name'];

		}	
		
				$service_name="";
				if(!empty($service)){
				foreach($service as $data){
				$result_contact_handbook_service=$this->requestAction(array('controller' => 'hms', 'action' => 'contact_handbook_service'),array('pass'=>array($data)));	
				$service_name.=$result_contact_handbook_service.',';
				}
				}
		
		$export.="<tr>
		<td>".$i."</td>
		<td>".$name."</td>
		<td>".$service_name."</td>
		<td>".$mobile."</td>
		<td>".$email."</td>
		<td>".$web."</td>
		 </tr>";
		
	}
	 $export.="</table>" ;
	 echo $export ;
}

function contact_handbook_service($ser_id){
	
 	
$this->loadmodel('contact_handbook_service');
$conditions=array('contact_handbook_service_id'=>(int)$ser_id);
$result_contact_handbook=$this->contact_handbook_service->find('all',array('conditions'=>$conditions));	

	foreach($result_contact_handbook as $data){
		return $data['contact_handbook_service']['contact_handbook_service_name'];
		
	}
}

function contact_handbook_edit(){
	
	$this->layout="blank";	
	$id=(int)$this->request->query('id');
	
$this->loadmodel('contact_handbook');
$conditions=array('c_h_id'=>$id);
$result_contact_handbook=$this->contact_handbook->find('all',array('conditions'=>$conditions));
$this->set('result_contact_handbook',$result_contact_handbook);

$this->loadmodel('contact_handbook_service');
$result_contact_handbook_service=$this->contact_handbook_service->find('all');	
$this->set('contact_handbook_service',$result_contact_handbook_service);	

}

function contact_handbook()
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id'); 	
$this->set('role_id',$s_role_id=$this->Session->read('role_id'));
$this->set('s_user_id',$s_user_id);
$this->loadmodel('contact_handbook');
$conditions=array('society_id'=>$s_society_id,'c_h_delete'=>0);
$result=$this->contact_handbook->find('all',array('conditions'=>$conditions));
foreach($result as $data){
	$c_h_id=$data["contact_handbook"]["c_h_id"];
	$this->seen_notification(21,$c_h_id);
}

$this->loadmodel('contact_handbook_service');
$result_contact_handbook_service=$this->contact_handbook_service->find('all');	
$this->set('contact_handbook_service',$result_contact_handbook_service);	

$this->set('result_contact_handbook',$result);	
if($this->request->is('post'))
{
 $id=(int)$this->request->data['text_id'];
 $name=htmlentities($this->request->data['name']);
 $mobile=htmlentities($this->request->data['mobile']);
 $email=htmlentities($this->request->data['email']);
 $web=htmlentities($this->request->data['web']);
 $service=@$this->request->data['service'];
 
 if(!empty($web)){
 if (!preg_match("~^(?:f|ht)tps?://~i", $web)) {
        $web = "http://" . $web;
    }
 }	
	


if(!empty($id))
{
	$this->loadmodel('contact_handbook');
	$this->contact_handbook->updateAll(array('c_h_name'=>$name,'c_h_mobile'=>$mobile,'c_h_email'=>$email,'c_h_web'=>$web,'c_h_service'=>$service),array('c_h_id'=>$id));
	$this->response->header('location','contact_handbook');
}
else
{
	
date_default_timezone_set('Asia/kolkata');
$date=date("d-m-Y");
$time=date('h:i:a',time());
$i=$this->autoincrement('contact_handbook','c_h_id');
$this->loadmodel('contact_handbook');
$this->contact_handbook->saveAll(array("c_h_id" => $i, "c_h_name" => $name,"c_h_date"=>$date,"user_id"=>$s_user_id,"society_id"=>$s_society_id,"c_h_time"=>$time,"c_h_mobile"=>$mobile,'c_h_email'=>$email,'c_h_web'=>$web,'c_h_service'=>$service,'c_h_delete'=>0));


$result_user=$this->all_user_deactive();
foreach($result_user as $data)
{
$visible_user_id[]=$data['user']['user_id'];
}

$this->send_notification('<span class="label label-warning" ><i class="icon-phone"></i></span>','Addition to contact handbook  <b>'.$name.'</b> added by',21,$i,$this->webroot.'Hms/contact_handbook',$s_user_id,$visible_user_id);

$this->response->header('location','contact_handbook');

}



}

}

function contact_handbook_delete()
{
	$this->layout='blank';
	$id=(int)$this->request->query('con');
	$this->loadmodel('contact_handbook');
	$this->contact_handbook->updateAll(array('c_h_delete'=>1),array('c_h_id'=>$id));
	$this->response->header('location','contact_handbook');
}

function contact_handbook_view()
{
$this->layout='session';	
$s_society_id=$this->Session->read('society_id'); 
$this->loadmodel('contact_handbook');
$conditions=array('society_id'=>$s_society_id);
$result=$this->contact_handbook->find('all',array('conditions'=>$conditions));
$this->set('result_contact_handbook',$result);
}


function contact_handbook_view_page()
{
$this->layout='blank';
$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id'); 	
$this->set('role_id',$s_role_id=$this->Session->read('role_id'));
$this->set('s_user_id',$s_user_id);
$c_h_id=$this->request->query('con');

$this->set('search_value',$c_h_id);
$regex = new MongoRegex("/.*$c_h_id.*/i"); 

$this->loadmodel('contact_handbook_service');
$condition1=array('contact_handbook_service_name'=>$regex);

$result_contact_handbook_service=$this->contact_handbook_service->find('all',array('conditions'=>$condition1));
$service=@$result_contact_handbook_service[0]['contact_handbook_service']['contact_handbook_service_id'];

$this->loadmodel('contact_handbook');
$conditions =array( '$or' => array( 
array('c_h_name' =>$regex,'society_id'=>$s_society_id,'c_h_delete'=>0),
array('c_h_mobile' =>$regex,'society_id'=>$s_society_id,'c_h_delete'=>0),
array('c_h_email' =>$regex,'society_id'=>$s_society_id,'c_h_delete'=>0),
array('c_h_web' =>$regex,'society_id'=>$s_society_id,'c_h_delete'=>0),
array('c_h_service' =>''.$service.'','society_id'=>$s_society_id,'c_h_delete'=>0)));

$result=$this->contact_handbook->find('all',array('conditions'=>$conditions));

$this->set('result_contact_handbook',$result);
$this->set('count_yellow',sizeof($result));	

}

/////////////////// End Contact handbook ////////////////////////////




////////////////////////////////////////////////////   Resident Directory Start ////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function resident_directory() 
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$s_role_id=$this->Session->read('role_id');	

 $s_society_id=$this->Session->read('society_id');
$this->ath();
$this->loadmodel('wing');
$conditions1=array('society_id'=>$s_society_id);
$result1=$this->wing->find('all',array('conditions'=>$conditions1));
$this->set('result_wing',$result1);
$this->loadmodel('user');
$conditions=array("society_id" => $s_society_id,'deactive'=>0);
$order=array('user.user_name'=> 'ASC');
$result_user=$this->user->find('all',array('conditions'=> $conditions,'order'=>$order));
$this->set('result_user',$result_user);


$this->loadmodel('user_flat');
$conditions=array("society_id" => $s_society_id,'active'=>0);
$result_user_count=$this->user_flat->find('count',array('conditions'=> $conditions));
$this->set('result_user_count',$result_user_count);

}


function resident_directory_view()
{
$this->layout="blank";
$this->ath();
$s_role_id=$this->Session->read('role_id');	
$s_society_id=$this->Session->read('society_id');	
$this->set('role_id',$s_role_id);
$this->set('s_society_id',$s_society_id);
$this->set('user_id',$this->Session->read('user_id'));
$user_id=(int)$this->request->query('id');
$this->set('user_flat',$this->request->query('user_flat_id')); 
$this->loadmodel('user');
$conditions=array("user_id" => $user_id);
$result=$this->user->find('all',array('conditions'=> $conditions));
$this->set('result_user1',$result);



}
function resident_directory_count_wing(){
	
$this->layout=null;
$this->ath();
$search_wing=(int)$this->request->query('id'); 
if($search_wing!=0){
$s_society_id=$this->Session->read('society_id');
$this->loadmodel('user');
$conditions=array("society_id" => $s_society_id,'wing'=>$search_wing,'deactive'=>0);
echo $result_user=$this->user->find('count',array('conditions'=> $conditions));
}else{
$s_society_id=$this->Session->read('society_id');
$this->loadmodel('user_flat');
$conditions=array("society_id" => $s_society_id,'active'=>0);
echo $result_user=$this->user_flat->find('count',array('conditions'=> $conditions));
	
}
}


function resident_directory_search_wing_ajax()
{
$this->layout="blank";
$this->ath();
$search_wing=(int)$this->request->query('con');
$this->set('search_value',$search_wing);
$s_society_id=$this->Session->read('society_id');
$this->loadmodel('user');
$order=array('user.user_name'=> 'ASC');
$conditions=array("society_id" => $s_society_id,'wing'=>$search_wing,'deactive'=>0);
$result1=$this->user->find('all',array('conditions'=> $conditions,'order'=>$order));
$n=sizeof($result1);
$this->set('result_user2',$result1);
$this->set('count_user2',$n);

$this->loadmodel('user');
$conditions=array("society_id" => $s_society_id,'deactive'=>0);
$order1=array('user.user_name'=> 'ASC');
$result2=$this->user->find('all',array('conditions'=> $conditions,'order'=>$order1));
$this->set('result_user3',$result2);

}


function resident_directory_search_name()
{
	
$this->layout="blank";
$this->ath();
$s_society_id=$this->Session->read('society_id');
$search=$this->request->query('con');
$flat=$search;
$this->loadmodel('flat'); 
$conditions=array("society_id"=>$s_society_id,"flat_name"=> (int)$flat);
$result_flat=$this->flat->find('all',array('conditions'=>$conditions));
foreach($result_flat as $data)
{
	$flat_id=$data['flat']['flat_id'];
	$this->set('flat_search',@$flat_id);
	$this->loadmodel('user_flat');	
	$conditions=array('flat_id'=>$flat_id,'active'=>0);
	$result_user=$this->user_flat->find('all',array('conditions'=>$conditions));
	
	foreach($result_user as $dda)
	{
		@$da_user_id[]=@$dda['user_flat']['user_id'];
	}
}

if(!empty($da_user_id))
{
$this->set('result_usser_flat',@$da_user_id);
}
$this->set('search_value',$search);
$regex_hob = new MongoRegex("/.*$search.*/i"); 
$this->loadmodel('hobbies_category');
$conditions=array('hobbies_name'=>$regex_hob);
$result_hobbies_category=$this->hobbies_category->find('all',array('conditions'=>$conditions));
 $hob_id=(string)$result_hobbies_category[0]['hobbies_category']['hobbies_id'];

$regex = new MongoRegex("/.*$search.*/i");  
$this->loadmodel('user');
$conditions =array( '$or' => array( 
		array('user_name'=>$regex,'society_id'=>$s_society_id,'deactive'=>0),
		array("hobbies" => $hob_id),
		));
		
$result=$this->user->find('all',array('conditions'=>$conditions));
$this->set('result_user',$result); 
$n=sizeof($result);
$this->set('count_user2',$n);
$this->loadmodel('user');
$conditions=array("society_id" => $s_society_id,'deactive'=>0);
$order1=array('user.user_name'=> 'ASC');
$result2=$this->user->find('all',array('conditions'=> $conditions,'order'=>$order1));
$this->set('result_user3',$result2);
}


////////////////////////////////////////////////////   Resident Directory End ////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	
///////////////////  Start Family member functionality //////////////////////



function dob_check()
{
	
	$this->layout='blank';
	$dob=$this->request->query['dob'];
	date_default_timezone_set('Asia/kolkata');
	$date=date("d-m-Y");
	$newDate = date("d-m-Y", strtotime($date));
	$newDate1 = date("Y-m-d", strtotime($newDate));
	$newDate2 = date("d-m-Y", strtotime($dob));
	$newDate3 = date("Y-m-d", strtotime($newDate2));
	$datetime1 = date_create($newDate1);
	$datetime2 = date_create($newDate3);
	$interval = date_diff($datetime2, $datetime1);
	 $years = $interval->y;
	 if($years>=13)
	 {
		echo'true';
	 }
	 else
	 {
		echo'false'; 
	 }
}

function family_member_add_ajax()
{
	
	$this->layout="session";
	$id=(int)$this->request->query('con');
	$result_user=$this->profile_picture($id);
	$this->set('result_user',$result_user);
	
	if($this->request->is("post"))
	{
		    $name=$this->request->data['name1'];
		    //$email=$this->request->data['email1'];
		    //$mobile=$this->request->data['mobile1'];
		    $dob=$this->request->data['dob1'];
		    $blood_group=$this->request->data['blood_group1'];
		    $relation=$this->request->data['relation1'];
			$this->loadmodel('user');
			$this->user->updateAll(array("user_name"=>$name,"dob"=>$dob,"relation"=>$relation,"blood_group"=>$blood_group),array("user_id"=>$id));
			?>
			
			
<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Your family details have been updated successfully.
</div> 
<div class="modal-footer">
<a href="family_member_view" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->

			
			
			
			<?php
			
	}
	
}

function family_member_deactive()
{
	$this->layout="blank";
	$id=(int)$this->request->query('con');
	$this->loadmodel("user");
	$this->user->updateAll(array('deactive'=>1),array('user_id'=>$id));
	$this->loadmodel("user_flat");
	$this->user_flat->updateAll(array('active'=>1),array('user_id'=>$id));
	$this->response->header("location","family_member_view");
	
}

function family_member_view()
{
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	 $s_user_id=$this->Session->read('user_id'); 
	 $s_society_id=$this->Session->read('society_id'); 
	 $s_role_id=$this->Session->read('role_id');
	 $this->set('s_role_id',$s_role_id);
	$this->loadmodel('user');
	$conditions=array('user_id'=>$s_user_id);
	$result=$this->user->find('all',array('conditions'=>$conditions));
	foreach($result as $data)
	{
	$tenant=(int)$data['user']['tenant'];
	$wing=(int)$data['user']['wing'];
	$flat=(int)$data['user']['flat'];
	//$residing=(int)$data['user']['noc_type'];

	}
	$this->set('tenant',$tenant);
	$result_society=$this->society_name($s_society_id);	
	foreach($result_society as $data)
	{
	 $society_name=$data['society']['society_name'];
	 @$family_member=$data['society']['family_member'];
	  @$family_member_tenant=$data['society']['family_member_tenant'];
	  @$s_duser_id=$data['society']['user_id'];
	}
	$this->set('family_member',$family_member);
	$this->set('family_member_tenant',$family_member_tenant);	
	
	
	
    $this->loadmodel('user');
	$conditions=array('family_member'=>$s_user_id,'deactive'=>0);
	$result_family_member=$this->user->find('all',array('conditions'=>$conditions));
	$this->set('result_user',$result_family_member);	
	
	
}

function family_member()
{
	
$this->layout="session";	
$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id'); 
$this->loadmodel('user');
$conditions=array('user_id'=>$s_user_id);
$result=$this->user->find('all',array('conditions'=>$conditions));
foreach($result as $data)
{
	$tenant=(int)$data['user']['tenant'];
	$wing=(int)$data['user']['wing'];
	$flat=(int)$data['user']['flat'];
	$residing=(int)$data['user']['residing'];
	
}
$result_society=$this->society_name($s_society_id);	
foreach($result_society as $data)
{
	 $society_name=$data['society']['society_name'];
	 @$family_member=$data['society']['family_member'];
}

if($this->request->is('post'))
	$ip=$this->hms_email_ip();
		{
		if($family_member==1)
		{			
			date_default_timezone_set('Asia/kolkata');
			$date=date("d-m-Y");
			$time=date('h:i:a',time());
			$name=$this->request->data['name'];
			$email=$this->request->data['email'];
			$mobile=$this->request->data['mobile'];
			$this->loadmodel('user');	
			$i=$this->autoincrement('user','user_id');	
			$random1=mt_rand(1000000000,9999999999);
			$random2=mt_rand(1000000000,9999999999);
			$random=$random1.$random2 ;	
			$de_user_id=$this->encode($i,'housingmatters');
			$random=$de_user_id.'/'.$random;
			$dob=$this->request->data['dob'];
			$relation=$this->request->data['relation'];
			$blood_group=$this->request->data['blood_group'];
			$log_i=$this->autoincrement('login','login_id');
			
////////////////////////// insert user table //////////////////////////
		
$this->user->save(array('user_id' => $i, 'user_name' => $name,'email' => $email, 'password' =>'', 'mobile' => $mobile,  'society_id' => $s_society_id, 'tenant' => $tenant, 'wing' => $wing, 'flat' => $flat,'residing' => $residing, 'date' => $date, 'time' => $time,"profile_pic"=>'blank.jpg','sex'=>'','role_id'=>2,'default_role_id'=>2,'signup_random'=>$random,'family_member'=>$s_user_id,'dob'=>$dob,'relation'=>$relation,'login_id'=>$log_i,'s_default'=>1,'blood_group'=>$blood_group));

////////////////////// End user table ///////////////////////////////////////////////////

////////////////////////////////// insert login table /////////////////////////////////////

$this->loadmodel('login');
$this->login->save(array('login_id'=>$log_i,'user_name'=>$email,'password'=>$random,'signup_random'=>$random,'mobile'=>$mobile));

/////////////////////////  End login table /////////////////////////////////////////

 $message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Dear $name,</p>
<p>'We at $society_name use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.</p>
<p>As you are an owner/resident/staff of $society_name, we have added your email address in HousingMatters portal.</p>
<p>Here are some of the important features related to our portal on HousingMatters:</p>
<p>You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.</p>
<p>You can receive important SMS & emails from your committee.</p>
<br/>				
<p><b><a href='$ip".$this->webroot."/hms/send_sms_for_verify_mobile?q=$random'>Click here</a> for one time verification of your mobile number and Login into HousingMatters  for making life simpler for all your housing matters!</b></p>
<br/>
<p>Pls add www.housingmatters.co.in in your favorite bookmarks for future use.</p>
<p>Regards,</p>	
<p>Administrator of $society_name</p><br/><br/>
www.housingmatters.co.in
</div >
</div>";
$from_name="HousingMatters";
$reply="support@housingmatters.in";
$to=$email;
$this->loadmodel('email');
$conditions=array("auto_id" => 4);
$result_email = $this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
}
$subject="Welcome to ".$society_name." portal ";
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);

?>

<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Your family details have been updated.
</div> 
<div class="modal-footer">
<a href="" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->

<?php
		}
		else
		{
			?>

<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Administrator has not allowed family member login into the portal.
</div> 
<div class="modal-footer">
<a href="" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->

<?php
			
		}
	}
	
}



//////////////////////////// End  family member //////////////////////////////

function committee_metters_view()
{

$this->layout='session';
$this->ath();	
$s_user_id=$this->Session->read('user_id'); 
$s_society_id=$this->Session->read('society_id');	
$this->loadmodel('committee_metter');
$conditions=array('society_id'=>$s_society_id);
$result=$this->committee_metter->find('all',array('conditions'=>$conditions));
$this->set('result_com',$result);
}


//////////////////////////////////// Committee_metters end  //////////////////////////////////	



////////////////////////////////////////////// Society Report view start //////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

function fetch_user_flat_active($id){
$s_society_id=$this->Session->read('society_id');
$this->loadmodel('user_flat');	
$conditions=array('user_id'=>$id,'active'=>0);	
return $this->user_flat->find('all',array('conditions'=>$conditions));
	
}

function fetch_user_flat_deactive($id){
$s_society_id=$this->Session->read('society_id');
$this->loadmodel('user_flat');	
$conditions=array('user_id'=>$id,'active'=>1);	
return $this->user_flat->find('all',array('conditions'=>$conditions));
	
}

function fetch_user_flat($id){
$s_society_id=$this->Session->read('society_id');
$this->loadmodel('user_flat');	
$conditions=array('user_id'=>$id);	
return $this->user_flat->find('all',array('conditions'=>$conditions));

}
function check_due_payment(){
	
$s_society_id=$this->Session->read('society_id');	
$user_flat_id=(int)$this->request->query('user_flat');
$this->loadmodel('user_flat');	
$conditions=array('user_flat_id'=>$user_flat_id,'status'=>1);	
$result_user_flat= $this->user_flat->find('all',array('conditions'=>$conditions));
  $n=sizeof($result_user_flat);
		if($n>0){
				$flat_id=$result_user_flat[0]['user_flat']['flat_id'];
				$user_id=$result_user_flat[0]['user_flat']['user_id'];
				
			   
			   
			   
				$result_new_regular_bill = $this->requestAction(array('controller' => 'Incometrackers', 
				'action' => 'fetch_last_bill_info_via_flat_id'),array('pass'=>array($flat_id)));
				if(sizeof($result_new_regular_bill)>0){
					foreach($result_new_regular_bill as $data){
					//$bill_no=$data["bill_no"];
					$bill_start_date=$data["bill_start_date"];
					$due_date=$data["due_date"];
					$due_for_payment=$data["due_for_payment"];
					
					 $last_bill_one_time_id=$data["one_time_id"];
					//$flat_id22 = (int)$data["flat_id"];
					$result_new_cash_bank = $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_last_receipt_info_via_flat_id'),array('pass'=>array($flat_id,$last_bill_one_time_id)));
					
					$total_amount=0;
							foreach($result_new_cash_bank as $data2){
							$amount=$data2["new_cash_bank"]["amount"];
							 $total_amount+=$amount;
							}
					} 
				
					$total=$due_for_payment-$total_amount;
					
					if($total>0){
					
							$result_user=$this->profile_picture($user_id);
							$user_name=$result_user[0]['user']['user_name'];
							$result_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
							foreach($result_flat as $data2){

							$wing_id=$data2['flat']['wing_id'];
							}
							$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));
						    
						 $msg="Payment of &#8377; ".$total." is due from ".$user_name." (".$wing_flat.")" ;
						$output = json_encode(array('report_type'=>'due', 'text' => $msg));
						die($output);
						
					}else{
						
						$output = json_encode(array('report_type'=>'done', 'text' => ''));
						die($output);
					}
				}else{
					$output = json_encode(array('report_type'=>'done', 'text' => ''));
						die($output);
				}
			
		}else{
						$output = json_encode(array('report_type'=>'done', 'text' => ''));
						die($output);
			
		}
}

function society_member_view()
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();	
$s_society_id=$this->Session->read('society_id');
$this->loadmodel('society');	
$conditions=array('society_id'=>$s_society_id);	
$this->set('result_society',$this->society->find('all',array('conditions'=>$conditions)));
$this->loadmodel('user');	
$conditions1=array('society_id'=>$s_society_id);
$order=array('user.user_name'=>'ASC');
$result1=$this->user->find('all',array('conditions'=>$conditions1,'order'=>$order));	
$this->set('result_user',$result1);
$this->set('n',sizeof($result1));
$this->loadmodel('role');	
$conditions2=array('society_id'=>$s_society_id);
$this->set('result_role',$this->role->find('all',array('conditions'=>$conditions2)));

$this->loadmodel('user_flat');	
$conditions1=array('society_id'=>$s_society_id,'active'=>0,'status'=>1);
$result_user_owner=$this->user_flat->find('count',array('conditions'=>$conditions1,'order'=>$order));	
$this->set('result_user_owner',$result_user_owner);

$this->loadmodel('user_flat');	
$conditions1=array('society_id'=>$s_society_id,'active'=>0,'status'=>2);
$result_user_tenant=$this->user_flat->find('count',array('conditions'=>$conditions1,'order'=>$order));	
$this->set('result_user_tenant',$result_user_tenant);
}

function society_member_excel()
{
$this->layout="";
$s_society_id=$this->Session->read('society_id');

$filename='user_list';
@header("Expires: 0");
@header("border: 1");
@header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
@header("Cache-Control: no-cache, must-revalidate");
@header("Pragma: no-cache");
@header("Content-type: application/vnd.ms-excel");
@header("Content-Disposition: attachment; filename=".$filename.".xls");
@header("Content-Description: Generated Report");

$this->ath();
	
$s_society_id=$this->Session->read('society_id');
$this->loadmodel('society');	
$conditions=array('society_id'=>$s_society_id);	
$this->set('result_society',$this->society->find('all',array('conditions'=>$conditions)));
$this->loadmodel('user');	
$conditions1=array('society_id'=>$s_society_id,'deactive'=>0);
$order=array('user.user_name'=>'ASC');
$result1=$this->user->find('all',array('conditions'=>$conditions1,'order'=>$order));	
$this->set('result_user',$result1);
$this->set('n',sizeof($result1));
$this->loadmodel('role');	
$conditions2=array('society_id'=>$s_society_id);
$this->set('result_role',$this->role->find('all',array('conditions'=>$conditions2)));

}



////////////////////////////////////////////End Society member view /////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////// multiple society ///////////////////

function multi_society_enrollment()
{
	
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$this->ath();	
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
	
$this->loadmodel('society');
$result=$this->society->find('all');	
$this->set('result_society',$result);	
	if($this->request->is('post')) 
	{
		date_default_timezone_set('Asia/kolkata');
		$date=date("d-m-Y");
		$time=date('h:i:a',time());
		$society_id=(int)$this->request->data['society'];
		$wing=(int)$this->request->data['wing'];
		$flat=(int)$this->request->data['flat'];
		//$residing=(int)$this->request->data['residing'];
		$tenant=(int)$this->request->data['tenant'];
		if($tenant==1)
		{
		 $committee=(int)$this->request->data['committe'];
		}
		else
		{
		 $committee=2;
		}
		
		$this->loadmodel('user');
		$conditions=array('user_id'=>$s_user_id);
		$result_user=$this->user->find('all',array('conditions'=>$conditions));
		
		foreach($result_user as $data)
		{
			$user_name=$data['user']['user_name'];
			$login_id=(int)$data['user']['login_id'];
			$email=$data['user']['email'];
			$mobile=$data['user']['mobile'];
		}
		 $wing_flat=$this->wing_flat($wing,$flat);
	
$i=$this->autoincrement('user_temp','user_temp_id');
$this->loadmodel('user_temp');
$this->user_temp->save(array('user_temp_id'=>$i,'user_name'=>$user_name,'email'=>$email,'mobile'=>$mobile,'password'=>'',"society_id" => $society_id,"committee" => $committee,'tenant' => $tenant, 'wing' => $wing, 'flat' => $flat,"role"=>2,"complete_signup"=>1,'reject'=>0,'login_id'=>$login_id,'date'=>$date,'time'=>$time,'multiple_society'=>1));
if($tenant==1)
{
$owner="Yes";
}
else
{
$owner="No";
}	

$result_society=$this->society_name($society_id);
foreach($result_society as $data)
{
	 $da_user_id=$data['society']['user_id'];
	  $society_name3=$data['society']['society_name'];
	
}
$result_user=$this->profile_picture($da_user_id);
foreach($result_user as $data1)
{
	 $to=$data1['user']['email'];
	
}


@$ip=$this->hms_email_ip();	
$message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>

</br><p>Dear Administrator,</p>
One new user request in your society has been received for your approval.<br/><br/>
<table  cellpadding='10' width='100%;' border='1' bordercolor='#e1e1e1'  >
<tr class='tr_heading' style='background-color:#00A0E3;color:white;'>
<td>Flat</td>
<td>Name</td>
<td>Mobile</td>
<td>Owner</td>
</tr>
<tr class='tr_content' style=background-color:#E9E9E9;'>
<td>$wing_flat</td>
<td>$user_name</td>
<td>$mobile</td>
<td>$owner</td>
</tr>
</table>
<div>
<p>Kindly log into <a href='http://www.housingmatters.co.in'> HousingMatters portal </a> and review </p>
<p>the request under 'Admin -> Resident Approve' for further action at your end.</p><br/>
For any assistance, please email us on support@housingmatters.in<br/><br/>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.co.in
</div >
</div>";

$from_name="HousingMatters";
$reply="support@housingmatters.in";
$this->loadmodel('email');
$conditions=array("auto_id" => 4);
$result_email = $this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
}
$subject="[$society_name3]- New User Request for approval";
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);	
$this->send_notification('<span class="label label-success" ><i class="icon-user"></i></span>','New User <b>'.$user_name.' '.$wing_flat.'</b> awaiting your approval/action',100,$da_user_id,'resident_approve',0,$da_user_id);
	
?>
<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
 Your request is sent for approval to Society Administrator.<br/>
</div> 
<div class="modal-footer">
<a href="dashboard" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php	
	
	}
	
}


////////////////////////////////////////////////////////


///////////////////////////////////////// New User Enrollment ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function hm_new_user_enrollment()
{
$this->layout="session";
$this->ath();	
$this->loadmodel('society');
$result=$this->society->find('all');	
$this->set('result_society',$result);
if($this->request->is('post')) 
{

$ip=$this->hms_email_ip();	
date_default_timezone_set('Asia/kolkata');
$date=date("d-m-Y");
$time=date('h:i:a',time());
$society_id=(int)$this->request->data['society'];
$result_society=$this->society_name($society_id);
foreach($result_society as $data)
{
	 $society_name=$data['society']['society_name'];
	
}

$s_n='';
$sco_na=$society_name;
$dd=explode(' ',$sco_na);
$first=$dd[0];
@$two=$dd[1];
@$three=$dd[2];
$s_n.=" $first $two $three ";

$name=$this->request->data['name'];
$email=$this->request->data['email'];
$mobile=$this->request->data['mobile'];
$wing=(int)$this->request->data['wing'];
$flat=(int)$this->request->data['flat'];
//$residing=(int)$this->request->data['residing'];
$tenant=(int)$this->request->data['tenant'];


$this->loadmodel('user_flat');
$conditions2=array('flat_id'=>$flat,'society_id'=>$society_id,'active'=>0,'family_member'=>array('$ne'=>1));
$result_user=$this->user_flat->find('all',array('conditions'=>$conditions2));
$n5=sizeof($result_user);
if($n5==1){
	$tenant_database=$result_user[0]['user_flat']['status'];
	if($tenant_database==1){
		if($tenant_database==$tenant){
			
			$this->set('tenant_allow','Flat is Already Exist owner.');
			goto a;
			
		}
		
		
	}else{
		
		if($tenant_database==$tenant){
			
			$this->set('tenant_allow','Flat is Already Exist tenant.');
			goto a;
			
		}
		
		
		
	}
	
}
if($n5==2){
	$this->set('tenant_allow','Flat is Already Exist.');
	goto a;
	
}

if($tenant==1)
{
$committee=(int)$this->request->data['committe'];
}
else
{
$committee=2;
}
$role_id[]=2;
$default_role_id=2;
if($committee==1)
{
$role_id[]=1;
}
$this->loadmodel('user');
$i=$this->autoincrement('user','user_id');
$random1=mt_rand(1000000000,9999999999);
$random2=mt_rand(1000000000,9999999999);
$random=$random1.$random2 ;	
$de_user_id=$this->encode($i,'housingmatters');
$random=$de_user_id.'/'.$random;
$log_i=$this->autoincrement('login','login_id');

if(!empty($mobile))
{
if(empty($email))
{
$login_user=$mobile;
$random=(string)mt_rand(1000,9999);
	
$r_sms=$this->hms_sms_ip();
$working_key=$r_sms->working_key;
$sms_sender=$r_sms->sms_sender; 	
$sms_allow=(int)$r_sms->sms_allow;
if($sms_allow==1){
	
$user_name_short=$this->check_charecter_name($name);

$sms="".$user_name_short.", Your housing society  ".$s_n." has enrolled  you in HousingMatters portal. Pls log into www.housingmatters.co.in One Time Password ".$random."";
 $sms1=str_replace(" ", '+', $sms);
$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms1.'');
}
}
}

$this->user->save(array('user_id' => $i, 'user_name' => $name,'email' => $email, 'password' => @$random, 'mobile' => $mobile,  'society_id' => $society_id, 'tenant' => $tenant, 'wing' => $wing, 'flat' => $flat, 'date' => $date, 'time' => $time,"profile_pic"=>'blank.jpg','sex'=>'','role_id'=>$role_id,'default_role_id'=>$default_role_id,'signup_random'=>$random,'deactive'=>0,'login_id'=>$log_i,'s_default'=>1,'profile_status'=>1,'private'=>array('mobile','email')));


 
$user_flat_id=$this->autoincrement('user_flat','user_flat_id');
$this->user_flat->saveAll(array('user_flat_id'=>$user_flat_id,'user_id'=>$i,'society_id'=>$society_id,'flat_id'=>$flat,'status'=>$tenant,'active'=>0,'exit_date'=>'','time'=>''));


		  //$this->loadmodel('flat');
          //$this->flat->updateAll(array("noc_ch_tp" =>$residing),array("flat_id" =>$flat));
///////////////  Insert code ledger Sub Accounts //////////////////////
if($tenant==1){
$this->loadmodel('ledger_sub_account');
$j=$this->autoincrement('ledger_sub_account','auto_id');
$this->ledger_sub_account->save(array('auto_id'=>$j,'ledger_id'=>34,'name'=>$name,'society_id' => $society_id,'user_id'=>$i,'deactive'=>0,"flat_id"=>$flat));

}

/////////////  End code ledger sub accounts //////////////////////////
$special="'";	

	
if(!empty($email) && !empty($mobile))
{
$login_user=$email;
  /* $message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Dear $name,</p>
<p>'We at $society_name use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.</p>
<p>As you are an owner/resident/staff of $society_name, we have added your email address in HousingMatters portal.</p>
<p>Here are some of the important features related to our portal on HousingMatters:</p>
<p>You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.</p>
<p>You can receive important SMS & emails from your committee.</p>
<br/>				
<p><b>
<a href='$ip".$this->webroot."/hms/send_sms_for_verify_mobile?q=$random'>Click here</a> for one time verification of your mobile number and Login into HousingMatters  for making life simpler for all your housing matters!</b></p>
<br/>
<p>Pls add www.housingmatters.co.in in your favorite bookmarks for future use.</p>
<p>Regards,</p>	
<p>Administrator of $society_name</p><br/>
www.housingmatters.co.in
</div >
</div>"; */


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
										<span style="color:rgb(100,100,99)" align="justify"> Dear '.$name.', </span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										 '.$special.'We at '.$society_name.' use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.
										
										
										
										
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										As you are an owner/resident/staff of '.$society_name.', we have added your email address in HousingMatters portal.
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
												Here are some of the important features related to our portal on HousingMatters:
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
												You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.
										</td>
																
								</tr>

									<tr>
									<td style="padding:5px;" width="100%" align="left">
									You can receive important SMS & emails from your committee.
									</td>

									</tr>
								<tr>
										<td style="padding:5px;" width="100%" align="left"><br/>
											<span  align="justify"> <b>
											<a href="'.$ip.$this->webroot.'hms/send_sms_for_verify_mobile?q='.$random.'"> Click here </a> for one time verification of your mobile number and Login into HousingMatters for making life simpler for all your housing matters!</b>
											</span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span align="justify"> Pls add www.housingmatters.in in your favorite bookmarks for future use. </span> 
										</td>
																
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span > 
												Regards,<br/>
												Administrator of '.$society_name.'<br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';

	

}
		
if(!empty($email) && empty($mobile))
{
$login_user=$email;	
 /* $message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Dear $name,</p>
<p>'We at $society_name use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.</p>
<p>As you are an owner/resident/staff of $society_name, we have added your email address in HousingMatters portal.</p>
<p>Here are some of the important features related to our portal on HousingMatters:</p>
<p>You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.</p>
<p>You can receive important SMS & emails from your committee.</p>
<br/>				
<p><b><a href='$ip".$this->webroot."/hms/set_new_password?q=$random'>Click here</a> for one time verification of your email and Login into HousingMatters  for making life simpler for all your housing matters!</b></p>
<br/>
<p>Pls add www.housingmatters.co.in in your favorite bookmarks for future use.</p>
<p>Regards,</p>	
<p>Administrator of $society_name</p><br/>
www.housingmatters.co.in
</div >
</div>"; */



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
										<span style="color:rgb(100,100,99)" align="justify"> Dear '.$name.', </span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										 '.$special.'We at '.$society_name.' use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.
										
										
										
										
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										As you are an owner/resident/staff of '.$society_name.', we have added your email address in HousingMatters portal.
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
												Here are some of the important features related to our portal on HousingMatters:
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
												You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.
										</td>
																
								</tr>

									<tr>
									<td style="padding:5px;" width="100%" align="left">
									You can receive important SMS & emails from your committee.
									</td>

									</tr>
								<tr>
										<td style="padding:5px;" width="100%" align="left"><br/>
											<span  align="justify"> <b>
											<a href="'.$ip.$this->webroot.'hms/set_new_password?q='.$random.'"> Click here </a> for one time verification of your email and Login into HousingMatters for making life simpler for all your housing matters!</b>
											</span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span align="justify"> Pls add www.housingmatters.in in your favorite bookmarks for future use. </span> 
										</td>
																
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span > 
												Regards,<br/>
												Administrator of '.$society_name.'<br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';

}
$from_name="HousingMatters";
$reply="support@housingmatters.in";
$to=$email;
$this->loadmodel('email');
$conditions=array("auto_id" => 4);
$result_email = $this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
}
$subject="Welcome to ".$society_name." portal ";
if(!empty($email))
{
$this->send_email($to,$from,$from_name,$subject,@$message_web,$reply);
}

////////////////Notification email user all checked code  //////////////////////////
$this->loadmodel('email');	
$conditions=array('notification_id'=>1);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach($result_email as $data)
{
$auto_id = (int)$data['email']['auto_id'];
$this->loadmodel('notification_email');
$lo=$this->autoincrement('notification_email','notification_id');
$this->notification_email->saveAll(array("notification_id" => $lo, "module_id" => $auto_id , "user_id" => $i,'chk_status'=>0));
}

//////////////// End all checked code   //////////////////////////


$this->loadmodel('login');
$this->login->save(array('login_id'=>$log_i,'user_name'=>@$login_user,'password'=>$random,'signup_random'=>$random,'mobile'=>$mobile));

?>
<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
New member registered into your society successfully.
</div> 
<div class="modal-footer">
<a href="hm_new_user_enrollment" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php
a:
} 
}


function new_user_enrollment()
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();
$s_society_id=$this->Session->read('society_id');

$this->loadmodel('wing');
$conditions=array("society_id" => $s_society_id);
$result_wing = $this->wing->find('all',array('conditions'=>$conditions));
$this->set('result_wing',$result_wing);
}

function new_user_enrollment2()
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$this->check_user_privilages();
$this->ath();
$s_society_id=$this->Session->read('society_id');

$this->loadmodel('wing');
$conditions=array("society_id" => $s_society_id);
$result_wing = $this->wing->find('all',array('conditions'=>$conditions));
$this->set('result_wing',$result_wing);
}

function import_flat_configuration()
{
	$this->layout="blank";
	$this->ath();
	$s_society_id=$this->Session->read('society_id');
	
	$this->loadmodel('wing');
	$conditions=array("society_id" => $s_society_id);
	$result_wing = $this->wing->find('all',array('conditions'=>$conditions));
	$this->set('result_wing',$result_wing);
	
	$this->loadmodel('flat_type_name');
	$result_flat_type = $this->flat_type_name->find('all');
	$this->set('result_flat_type',$result_flat_type);
	
	if(isset($_FILES['file'])){
		 $file_name=$_FILES['file']['name'];
		
		$file_tmp_name =$_FILES['file']['tmp_name'];
		$target = "csv_file/";
		$target=@$target.basename($file_name);
		move_uploaded_file($file_tmp_name,@$target);
		
		$f = fopen('csv_file/'.$file_name, 'r') or die("ERROR OPENING DATA");
		
		$batchcount=0;
		$records=0;
		while (($line = fgetcsv($f, 4096, ';')) !== false) {
		// skip first record and empty ones
		 $numcols = count($line);

		$test[]=$line;

		//echo $col = $line[0];
		//echo $batchcount++.". ".$col."\n";


		++$records;
		}

		fclose($f);
		$records;
	}
	
	$i=0;
	foreach($test as $child){ 
		if($i>0){
			
					 $child_ex=explode(',',$child[0]);
					 $wing_name=$child_ex[0];
					 $flat_name=$child_ex[1];
					 $flat_type=$child_ex[2];
					 @$flat_area=$child_ex[3];
			if(!empty($flat_type))
            {			
			$this->loadmodel('wing'); 
			$conditions=array("society_id"=>$s_society_id,"wing_name"=> new MongoRegex('/^' .  $wing_name . '$/i'));
			$result_wing=$this->wing->find('all',array('conditions'=>$conditions));
			 $result_wing_count=sizeof($result_wing);

			$wing_id=0;
			$flat_id=0;
			if($result_wing_count>0){
			  $wing_id=$result_wing[0]['wing']['wing_id'];
				
				//$this->loadmodel('flat'); 
				//$conditions=array("wing_id"=>$wing_id,"flat_name"=> new MongoRegex('/^' .  $flat_name . '$/i'));
				//$result_flat=$this->flat->find('all',array('conditions'=>$conditions));
				//$result_flat_count=sizeof($result_flat);

				//if($result_flat_count>0){
					//$flat_id=$result_flat[0]['flat']['flat_id'];	
				//}
			
			}
			
			$this->loadmodel('flat_type_name'); 
			$conditions=array("flat_name"=> new MongoRegex('/^' .  $flat_type . '$/i'));
			$result_flat_type_name=$this->flat_type_name->find('all',array('conditions'=>$conditions));
			 $result_f_t_count=sizeof($result_flat_type_name);
				if($result_f_t_count>0){
					$flat_type_id=@$result_flat_type_name[0]['flat_type_name']['auto_id'];	
				}else{
					$flat_type_id=0;
				}	 
					
					 $table[]=array($wing_id,$flat_name,$flat_type_id,@$flat_area);
			}
		} $i++;
	}
	
	$this->set('table',$table);
	
}

function import_user_ajax()
{
	$this->layout="blank";
	$this->ath();
	 
	$s_society_id=$this->Session->read('society_id');
	$this->loadmodel('wing');
	$conditions=array("society_id" => $s_society_id);
	$result_wing = $this->wing->find('all',array('conditions'=>$conditions));
	$this->set('result_wing',$result_wing);
	

	if(isset($_FILES['file'])){
		$file_name=$_FILES['file']['name'];
		$file_tmp_name =$_FILES['file']['tmp_name'];
		$target = "csv_file/";
		$target=@$target.basename($file_name);
		move_uploaded_file($file_tmp_name,@$target);
		
		$f = fopen('csv_file/'.$file_name, 'r') or die("ERROR OPENING DATA");
		$batchcount=0;
		$records=0;
		while (($line = fgetcsv($f, 4096, ';')) !== false) {
		// skip first record and empty ones
		$numcols = count($line);

		$test[]=$line;

		//echo $col = $line[0];
		//echo $batchcount++.". ".$col."\n";


		++$records;
		}

		fclose($f);
		$records;
	}
	
	
	$i=0;
	
	foreach($test as $child){
		if($i>0){
			$child_ex=explode(',',$child[0]);
			$name=trim($child_ex[0]);
			$wing_name=trim($child_ex[1]);
			$flat_name=trim($child_ex[2]);
			$email=trim($child_ex[3]);
			$mobile=trim($child_ex[4]);
			$owner=trim($child_ex[5]);
			$committee=trim($child_ex[6]);
			//$noc=$child_ex[7];
			
			$this->loadmodel('wing'); 
			$conditions=array("society_id"=>$s_society_id,"wing_name"=> new MongoRegex('/^' .  $wing_name . '$/i'));
			$result_wing=$this->wing->find('all',array('conditions'=>$conditions));
			$result_wing_count=sizeof($result_wing);

			$wing_id=0;
			$flat_id=0;
			if($result_wing_count>0){
				$wing_id=$result_wing[0]['wing']['wing_id'];
				
				$this->loadmodel('flat'); 
				$conditions=array("wing_id"=>$wing_id,"flat_name"=> new MongoRegex('/^' .  $flat_name . '$/i'));
				$result_flat=$this->flat->find('all',array('conditions'=>$conditions));
				$result_flat_count=sizeof($result_flat);

				if($result_flat_count>0){
					$flat_id=$result_flat[0]['flat']['flat_id'];	
				}
			}
			
			$owner_id=0;
			$committee_id=0;
			$noc_id=0;
			if(!empty($owner)){
				$result_owner_yes = strcasecmp($owner, 'yes');
				$result_owner_no = strcasecmp($owner, 'no');
				if ($result_owner_yes == 0){
				$owner_id=1;
				}
				if ($result_owner_no == 0){
				$owner_id=2;
				}
			}
			
			if(!empty($committee)){
				$result_committee_yes = strcasecmp($committee, 'yes');
				$result_committee_no = strcasecmp($committee, 'no');
				if ($result_committee_yes == 0){
				$committee_id=1;
				}
				if ($result_committee_no == 0){
				$committee_id=2;
				}
			}
			
			/*if(!empty($noc)){
				$result_noc_yes = strcasecmp($noc, 'yes');
				$result_noc_no = strcasecmp($noc, 'no');
				if ($result_noc_yes == 0){
				$noc_id=1;
				}
				if ($result_noc_no == 0){
				$noc_id=2;
				}
			} */
			
			
			
			$table[]=array($name,$wing_id,$flat_id,$email,$mobile,$owner_id,$committee_id);
		}
		$i++;
	}
	$this->set('table',$table);
	
	
	
}

function user_enrollment_ajax_add_row()
{
$this->layout="blank";
$h=(int)$this->request->query('q');
$this->set('h',$h);
$s_society_id=$this->Session->read('society_id');

$this->loadmodel('wing');
$conditions=array("society_id" => $s_society_id);
$result_wing = $this->wing->find('all',array('conditions'=>$conditions));
$this->set('result_wing',$result_wing);
}



function new_user_enrollment12345()
{
$this->layout="session";
$this->ath();
$this->check_user_privilages();
App::import('', 'sendsms.php');
$s_society_id=$this->Session->read('society_id');
$this->loadmodel('wing');
$conditions=array('society_id'=>$s_society_id);
$result=$this->wing->find('all',array('conditions'=>$conditions));
$this->set('result_wing',$result);
$res_society=$this->society_name($s_society_id);
foreach($res_society as $data)
{
 $society_name=$data['society']['society_name'];

}
$s_n='';
$sco_na=$society_name;
$dd=explode(' ',$sco_na);
 $first=$dd[0];
 $two=$dd[1];
 $three=$dd[2];
$s_n.=" $first $two $three ";



if($this->request->is('post')) 
{
date_default_timezone_set('Asia/kolkata');
$date=date("d-m-Y");
$time=date('h:i:a',time());
$name=$this->request->data['name'];
$email=$this->request->data['email'];
$mobile=$this->request->data['mobile'];
$wing=(int)$this->request->data['wing'];
$flat=(int)$this->request->data['flat'];
$residing=(int)$this->request->data['residing'];
$tenant=(int)$this->request->data['tenant'];
if($tenant==1)
{
$committee=(int)$this->request->data['committe'];
}
else
{
$committee=2;
}
$role_id[]=2;
$default_role_id=2;
if($committee==1)
{
$role_id[]=1;
}

$this->loadmodel('user');
$i=$this->autoincrement('user','user_id');
$log_i=$this->autoincrement('login','login_id');
$random1=mt_rand(1000000000,9999999999);
$random2=mt_rand(1000000000,9999999999);
$random=$random1.$random2 ;	
$de_user_id=$this->encode($i,'housingmatters');
$random=$de_user_id.'/'.$random;
if(!empty($mobile))
{
if(empty($email))
{
$r_sms=$this->hms_sms_ip();
$working_key=$r_sms->working_key;
$sms_sender=$r_sms->sms_sender; 
$sms_allow=(int)$r_sms->sms_allow;

$login_user=$mobile;
$random=(string)mt_rand(1000,9999);
if($sms_allow==1){
$sms="".$name.", Your housing society ".$s_n." has enrolled you in HousingMatters portal. Pls log into www.housingmatters.co.in One Time Password ".$random."";
$sms1=str_replace(" ", '+', $sms);
$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms1.'');
}
}
}

$this->user->save(array('user_id' => $i, 'user_name' => $name,'email' => $email, 'password' => @$random, 'mobile' => $mobile,  'society_id' => $s_society_id, 'tenant' => $tenant, 'wing' => $wing, 'flat' => $flat,'residing' => $residing, 'date' => $date, 'time' => $time,"profile_pic"=>'blank.jpg','sex'=>'','role_id'=>$role_id,'default_role_id'=>$default_role_id,'signup_random'=>$random,'deactive'=>0,'login_id'=>$log_i,'s_default'=>1));




///////////////  Insert code ledger Sub Accounts //////////////////////

$this->loadmodel('ledger_sub_account');
$j=$this->autoincrement('ledger_sub_account','auto_id');
$this->ledger_sub_account->save(array('auto_id'=>$j,'ledger_id'=>34,'name'=>$name,'society_id' => $s_society_id,'user_id'=>$i,'deactive'=>0));

/////////////  End code ledger sub accounts //////////////////////////

	
	
if(!empty($email) && !empty($mobile))
{
$login_user=$email;	
	
$message_web="<div>
<img src='http://123.63.2.150:8080".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='http://123.63.2.150:8080".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='http://123.63.2.150:8080".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='http://123.63.2.150:8080".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Dear $name,</p>
<p>'We at $society_name use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.</p>
<p>As you are an owner/resident/staff of $society_name, we have added your email address in HousingMatters portal.</p>
<p>Here are some of the important features related to our portal on HousingMatters:</p>
<p>You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.</p>
<p>You can receive important SMS & emails from your committee.</p>
<br/>				
<p><b>
<a href='http://123.63.2.150:8080".$this->webroot."/hms/send_sms_for_verify_mobile?q=$random'>Click here</a> for one time verification of your mobile number and Login into HousingMatters  for making life simpler for all your housing matters!</b></p>
<br/>
<p>Pls add www.housingmatters.co.in in your favorite bookmarks for future use.</p>
<p>Regards,</p>	
<p>Administrator of $society_name</p><br/>
www.housingmatters.co.in
</div >
</div>";
}
		
if(!empty($email) && empty($mobile))
{
	$login_user=$email;	
$message_web="<div>
<img src='http://123.63.2.150:8080".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='http://123.63.2.150:8080".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='http://123.63.2.150:8080".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='http://123.63.2.150:8080".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Dear $name,</p>
<p>'We at $society_name use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.</p>
<p>As you are an owner/resident/staff of $society_name, we have added your email address in HousingMatters portal.</p>
<p>Here are some of the important features related to our portal on HousingMatters:</p>
<p>You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.</p>
<p>You can receive important SMS & emails from your committee.</p>
<br/>				
<p><b><a href='http://123.63.2.150:8080".$this->webroot."/hms/set_new_password?q=$random'>Click here</a> for one time verification of your email and Login into HousingMatters  for making life simpler for all your housing matters!</b></p>
<br/>
<p>Pls add www.housingmatters.co.in in your favorite bookmarks for future use.</p>
<p>Regards,</p>	
<p>Administrator of $society_name</p><br>
www.housingmatters.co.in
</div >
</div>";
}
$from_name="HousingMatters";
$reply="support@housingmatters.in";
$to=$email;
$this->loadmodel('email');
$conditions=array("auto_id" => 4);
$result_email = $this->email->find('all',array('conditions'=>$conditions));
foreach ($result_email as $collection) 
{
$from=$collection['email']['from'];
}
$subject="Welcome to ".$society_name." portal ";
if(!empty($email))
{
$this->send_email($to,$from,$from_name,$subject,@$message_web,$reply);
}
////////////////Notification email user all checked code  //////////////////////////
$this->loadmodel('email');	
$conditions=array('notification_id'=>1);
$result_email=$this->email->find('all',array('conditions'=>$conditions));
foreach($result_email as $data)
{
$auto_id = (int)$data['email']['auto_id'];
$this->loadmodel('notification_email');
$lo=$this->autoincrement('notification_email','notification_id');
$this->notification_email->saveAll(array("notification_id" => $lo, "module_id" => $auto_id , "user_id" => $i,'chk_status'=>0));
}

//////////////// End all checked code   //////////////////////////

////////////////////  insert login table  ///////////////////

$this->loadmodel('login');
$this->login->save(array('login_id'=>$log_i,'user_name'=>$login_user,'password'=>$random,'signup_random'=>$random,'mobile'=>$mobile));

//////////////////////////////////////////////////////////////////


?>
<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
New member registered into your society successfully.
</div> 
<div class="modal-footer">
<a href="society_member_view" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php
}
}




/////////////////////////////////// End  new User Enrolment ////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////// New Tenant Enrollment Start //////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



function new_tenant_edit($id=null)
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}
$id=(int)$id;
$s_society_id=$this->Session->read('society_id');
$this->ath();
$this->loadmodel('tenant');	
	
$conditions1=array('user_id'=>$id);
$result1=$this->tenant->find('all',array('conditions'=>$conditions1));	

$this->set('result_tenant',$result1);
if($this->request->is('post'))
{
date_default_timezone_set('Asia/kolkata');
$date=date("d-m-Y");
$time=date('h:i:a',time());
$name_tenant=$this->request->data['name_tenant'];
$address=$this->request->data['address'];
$start_date=$this->request->data['start_date'];
$end_date=$this->request->data['end_date'];
$verification=$this->request->data['verification'];
$ten_age=(int)@$this->request->data['ten_agr'];
$pol_ver=(int)@$this->request->data['pol_ver'];

$this->loadmodel('tenant');
$this->tenant->updateAll(array("t_start_date"=>$start_date,"t_end_date"=>$end_date,"t_address"=>$address,"verification"=>$verification,'t_agreement'=>$ten_age,'t_police'=>$pol_ver),array("user_id" => $id));
?>


<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Successfully Update .
</div> 
<div class="modal-footer">
<a href="<?php  echo $this->webroot_path();?>hms/new_tenant_enrollment_view" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php

//$this->response->header('Location', 'new_tenant_enrollment_view');	
	
}
	
}


function new_tenant_enrollment()
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();
$s_society_id=$this->Session->read('society_id');
$this->loadmodel('user');	
$conditions1=array('society_id'=>$s_society_id,'tenant'=>2);
$result1=$this->user->find('all',array('conditions'=>$conditions1));	
$this->set('result_user',$result1);
$this->loadmodel('wing');
$conditions=array('society_id'=>$s_society_id);
$result=$this->wing->find('all',array('conditions'=>$conditions));
$this->set('result_wing',$result);
if($this->request->is('post')) 
{
date_default_timezone_set('Asia/kolkata');
$date=date("d-m-Y");
$time=date('h:i:a',time());
$tenant_user_id=(int)$this->request->data['sel'];
$this->loadmodel('user');	
$conditions1=array('user_id'=>$tenant_user_id);
$result1=$this->user->find('all',array('conditions'=>$conditions1));
foreach($result1 as $data)
{
$user_name=$data['user']['user_name'];
$mobile=@$data['user']['mobile'];
}
$ten_age=(int)@$this->request->data['ten_agr'];
// $user_name=@$this->request->data['name_tenant'];
// $wing=(int)@$this->request->data['wing'];
// $flat=(int)@$this->request->data['flat'];
$pol_ver=(int)@$this->request->data['pol_ver'];
$address=$this->request->data['address'];
$start_date=$this->request->data['start_date'];
$end_date=$this->request->data['end_date'];
$verification=$this->request->data['verification'];
//$this->loadmodel('user');
//$this->user->updateAll(array( "user_name" => $user_name,'wing'=>$wing,'flat'=>$flat),array('user_id'=>$tenant_user_id));
$this->loadmodel('tenant');	
$conditions2=array('user_id'=>$tenant_user_id);
$result2=$this->tenant->find('all',array('conditions'=>$conditions2));
$n=sizeof($result2);
if($n==0)
{

$i=$this->autoincrement('tenant','tenant_id');
$this->loadmodel('tenant');
$this->tenant->saveAll((array("tenant_id" => $i, "name" => $user_name , "user_id" => $tenant_user_id,"t_start_date"=>$start_date,"t_end_date"=>$end_date,"society_id"=>$s_society_id,"t_time"=>$time,"t_mobile"=>$mobile,"t_address"=>$address,"verification"=>$verification,'t_agreement'=>$ten_age,'t_police'=>$pol_ver)));

$this->response->header('Location', 'new_tenant_enrollment_view');


}
else
{

$this->loadmodel('tenant');
$this->tenant->updateAll(array( "name" => $user_name ,"t_start_date"=>$start_date,"t_end_date"=>$end_date,"society_id"=>$s_society_id,"t_time"=>$time,"t_mobile"=>$mobile,"t_address"=>$address,"verification"=>$verification,'t_agreement'=>$ten_age,'t_police'=>$pol_ver),array("user_id" => $tenant_user_id));
$this->response->header('Location', 'new_tenant_enrollment_view');		
}

}

}

function new_tenant_enrollment_ajax()
{
$this->layout='blank';
$s_society_id=$this->Session->read('society_id');
$t=(int)$this->request->query('con');
$this->loadmodel('tenant');	
$conditions1=array('user_id'=>$t);
$result1=$this->tenant->find('all',array('conditions'=>$conditions1));	
$this->set('result_tenant',$result1);
$this->loadmodel('user');	
$conditions2=array('user_id'=>$t);
$result2=$this->user->find('all',array('conditions'=>$conditions2));	
$this->set('result_user',$result2);
$this->loadmodel('wing');
$conditions=array('society_id'=>$s_society_id);
$result3=$this->wing->find('all',array('conditions'=>$conditions));
$this->set('result_wing',$result3);

}

function new_tenant_data_fetch($id){
	
	$s_society_id=(int)$this->Session->read('society_id');
	$this->loadmodel('tenant');
	$conditions=array('user_id'=>$id,'society_id'=>$s_society_id);
	return $this->tenant->find('all',array('conditions'=>$conditions));
}
function new_tenant_file_upload(){
	
	$this->layout=null;
	$this->ath();
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$post_data=$this->request->data;
	$tenant_id=(int)$post_data['tenant_id'];
	$file_name=@$_FILES["file"]["name"];
				if(!empty($file_name)){
					$file_name=$_FILES["file"]["name"];
					$file_tmp_name =$_FILES['file']['tmp_name'];
					$target = "tenant_upload/";
					$target=@$target.basename($file_name);
					move_uploaded_file($file_tmp_name,@$target);
				}
			$this->loadmodel('tenant');
			$this->tenant->updateAll(array("t_file"=>$file_name),array("user_id" => $tenant_id));
}

function new_tenant_enrollment_ajax1(){
	$this->layout=null;
	$this->ath();
	 $s_society_id=(int)$this->Session->read('society_id');
	  $t_id=(int)$this->request->query('con');
	  $update_field=$this->request->query('con2');
	  $whichplace=$this->request->query('con3');
	  $file_name=@$_FILES[$update_field]["name"];
	
	$this->loadmodel('tenant');
	$conditions=array('user_id'=>$t_id,'society_id'=>$s_society_id);
	$result_tenant=$this->tenant->find('all',array('conditions'=>$conditions));
	$n=sizeof($result_tenant);
	if($n==0){
		$date=date("d-m-Y");
		$time=date('h:i:a',time());
		$result_user=$this->profile_picture($t_id);
		$user_name=$result_user[0]['user']['user_name'];
		$mobile=$result_user[0]['user']['mobile'];
		
			if($whichplace=='permanet_address'){
				
				$i=$this->autoincrement('tenant','tenant_id');
				$this->loadmodel('tenant');
				$this->tenant->saveAll((array("tenant_id" => $i, "name" => $user_name , "user_id" => $t_id,"society_id"=>$s_society_id,"t_time"=>$time,"t_mobile"=>$mobile,"t_address"=>$update_field)));

				
			}
			if($whichplace=='tenancy_start'){
				
				$i=$this->autoincrement('tenant','tenant_id');
				$this->loadmodel('tenant');
				$this->tenant->saveAll((array("tenant_id" => $i, "name" => $user_name , "user_id" => $t_id,"society_id"=>$s_society_id,"t_time"=>$time,"t_mobile"=>$mobile,"t_start_date"=>$update_field)));

				
			}
			
			if($whichplace=='tenancy_end'){
				
				$i=$this->autoincrement('tenant','tenant_id');
				$this->loadmodel('tenant');
				$this->tenant->saveAll((array("tenant_id" => $i, "name" => $user_name , "user_id" => $t_id,"society_id"=>$s_society_id,"t_time"=>$time,"t_mobile"=>$mobile,"t_end_date"=>$update_field)));

				
			}
			
			if($whichplace=='verification'){
				
				$i=$this->autoincrement('tenant','tenant_id');
				$this->loadmodel('tenant');
				$this->tenant->saveAll((array("tenant_id" => $i, "name" => $user_name , "user_id" => $t_id,"society_id"=>$s_society_id,"t_time"=>$time,"t_mobile"=>$mobile,"verification"=>$update_field)));

				
			}
			
			if($whichplace=='tenancy_agreement'){
				
				$i=$this->autoincrement('tenant','tenant_id');
				$this->loadmodel('tenant');
				$this->tenant->saveAll((array("tenant_id" => $i, "name" => $user_name , "user_id" => $t_id,"society_id"=>$s_society_id,"t_time"=>$time,"t_mobile"=>$mobile,"t_agreement"=>$update_field)));

				
			}
			
			if($whichplace=='police_verification'){
				
				$i=$this->autoincrement('tenant','tenant_id');
				$this->loadmodel('tenant');
				$this->tenant->saveAll((array("tenant_id" => $i, "name" => $user_name , "user_id" => $t_id,"society_id"=>$s_society_id,"t_time"=>$time,"t_mobile"=>$mobile,"t_police"=>$update_field)));

				
			}
			
			
		
	}else{
			if($whichplace=='permanet_address'){
			$this->loadmodel('tenant');
			$this->tenant->updateAll(array("t_address"=>$update_field),array("user_id" => $t_id));
			}
			if($whichplace=='tenancy_start'){
			$this->loadmodel('tenant');
			$this->tenant->updateAll(array("t_start_date"=>$update_field),array("user_id" => $t_id));
			}
			if($whichplace=='tenancy_end'){
			$this->loadmodel('tenant');
			$this->tenant->updateAll(array("t_end_date"=>$update_field),array("user_id" => $t_id));
			}
			
			if($whichplace=='verification'){
			$this->loadmodel('tenant');
			$this->tenant->updateAll(array("verification"=>$update_field),array("user_id" => $t_id));
			}
			
			if($whichplace=='tenancy_agreement'){
			$this->loadmodel('tenant');
			$this->tenant->updateAll(array("t_agreement"=>$update_field),array("user_id" => $t_id));
			}
			
			if($whichplace=='police_verification'){
			$this->loadmodel('tenant');
			$this->tenant->updateAll(array("t_police"=>$update_field),array("user_id" => $t_id));
			}
				
						
		}

}



function new_tenant_enrollment_view()
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$this->ath();
$this->check_user_privilages();
$s_society_id=(int)$this->Session->read('society_id');
$this->loadmodel('tenant');
$condition=array('society_id'=>$s_society_id);
$result=$this->tenant->find('all',array('conditions'=>$condition)); 
$this->set('user_tenant',$result);
}

function tenant_excel()
{
$this->layout="";
$s_society_id=$this->Session->read('society_id');
$result_society=$this->society_name($s_society_id);
$society_name=$result_society[0]['society']['society_name'];
$filename=$society_name.'_Tenant_List';
$filename = str_replace(' ', '_', $filename);
$filename = str_replace(' ', '-', $filename);

@header("Expires: 0");
@header("border: 1");
@header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
@header("Cache-Control: no-cache, must-revalidate");
@header("Pragma: no-cache");
@header("Content-type: application/vnd.ms-excel");
@header("Content-Disposition: attachment; filename=".$filename.".xls");
@header("Content-Description: Generated Report");

$excel="<div align='center'> 
<span style='font-size:16px;'> $society_name<span>
<br/>
<span> Tenant List Report <span>
</div>
<table border='1'>
<tr>
<td><strong>Name</strong></td>
<td><strong>Flat</strong></td>
<td><strong>Mobile</strong></td>
<td><strong>Email</strong></td>
<td><strong>Start date</strong></td>
<td><strong>End date</strong></td>
<td><strong>Agreement Copy</strong></td>
<td><strong>Police NOC</strong></td>
<td><strong>Remarks</strong></td>
<td><strong>Permanent Address</strong></td>
</tr>";

$s_society_id=(int)$this->Session->read('society_id');
$this->loadmodel('tenant');
$condition=array('society_id'=>$s_society_id);
$user_tenant=$this->tenant->find('all',array('conditions'=>$condition)); 

 foreach($user_tenant as $collection) 
            {
			$name=@$collection['tenant']['name'];
			$d_user_id=(int)@$collection['tenant']['user_id'];
            $mobile=@$collection['tenant']['t_mobile'];
            $t_address=@$collection['tenant']['t_address'];
            $t_agreement=@$collection['tenant']['t_agreement'];
			$t_police=@$collection['tenant']['t_police'];
            $verification=@$collection['tenant']['verification'];
            $t_start_date=@$collection['tenant']['t_start_date'];
            $t_end_date=@$collection['tenant']['t_end_date'];
			if($t_agreement==1)
			{
				$t_agreement='Yes';
			}
			else
			{
			$t_agreement='No';
			
			}
			if($t_police==1)
			{
				$t_police='Yes';
			}
			else
			{
			$t_police='No';
			
			}
$result_user = $this->profile_picture($d_user_id);
foreach($result_user as $data)
{
$wing=$data['user']['wing'];
$flat=$data['user']['flat'];
$email=$data['user']['email'];
}

@$wing_flat = $this->wing_flat($wing,$flat);
@$excel.="<tr>
<td>$name</td>
<td>$wing_flat</td>
<td>$mobile</td>
<td>$email</td>
<td>$t_start_date</td>
<td>$t_end_date</td>
<td>$t_agreement</td>
<td>$t_police</td>
<td>$verification</td>
<td>$t_address</td>
</tr>";
}
@$excel.="</table>";
echo @$excel ;
}


////////////////////////////////////////////////////////////////End new Tenant enrollment //////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////// Start  Feedback functionality ///////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function feedback_category_name($category)
{
$this->loadmodel('feedback_category');
$conditions=array('feedback_cat_id'=>$category);
$result=$this->feedback_category->find('all',array('conditions'=>$conditions));
foreach($result as $data)
{
return $category_name=$data['feedback_category']['feedback_cat_name'];

}

}

function feedback()
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$this->loadmodel('user');
$conditions=array('user_id'=>$s_user_id);
$result=$this->user->find('all',array('conditions'=>$conditions));
foreach($result as $data)
{
$user=$data['user']['user_name'];
$mobile=$data['user']['mobile'];
$email=$data['user']['email'];	
}
$this->set('user_name',$user);

$this->loadmodel('feedback_category');
$this->set('result_fed_cat',$this->feedback_category->find('all'));

if($this->request->is('post')) 
{

$ip=$this->hms_email_ip();
$feedback_cat_id=(int)$this->request->data['sel'];
$subject= htmlentities($this->request->data['subject']);
$message= htmlentities($this->request->data['mess']);
$feedback_cat_name=$this->feedback_category_name($feedback_cat_id);
$result_society=$this->society_name($s_society_id);
foreach ($result_society as $collection) 
{ 
$society_name=$collection['society']["society_name"];
}
$to = "Support@housingmatters.in";
$from="Support@housingmatters.in";
$reply="Support@housingmatters.in";
$from_name="HousingMatters"; 
 /* $message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>

</br><p>Dear Administrator,</p>
<br/>
<table  cellpadding='10' width='100%;' border='1' bordercolor='#e1e1e1'  >
<tr class='tr_heading' style='background-color:#00A0E3;color:white;'>
<td>Name</td>
<td>Category</td>
<td>Society Name</td>
<td>Details</td>
</tr>
<tr class='tr_content' style=background-color:#E9E9E9;'>
<td>$user</td>
<td>$feedback_cat_name</td>
<td>$society_name</td>
<td><p>User Email-Id: &nbsp; $email </p>
<p>Mobile No: &nbsp; $mobile </p></td>
</tr>
</table>
<div>
<p style='font-size:16px;'> <strong>Message Description:</strong></p>
<p style='font-size:15px;'>$message</p>
<center><p>To view the feedback response <a href='$ip".$this->webroot."hms' ><button style='width:100px; height:30px;  background-color:#00A0E3;color:white'> Click Here </button></a></p></center><br/>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.co.in
</div>
</div>"; */


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
								</tr>
								
									
								
						</tbody>
					</table>
					
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span align="justify"> Dear Administrator, </span> 
										</td>
								
								
								</tr>
								
								
								
								
								<tr>
									<td>
									
										<table  cellpadding="5" cellspacing="0" width="100%;"border="1" style="border:1px solid #e5e5e5;">
						
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" width="200" >Name</td>
										<td align="left" style="background-color:#f8f8f8;" width="600" >'.$user.'</td>
										</tr>
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Category</td>
										<td align="left" style="background-color:#f8f8f8;" >'.$feedback_cat_name.'</td>
										</tr>
										
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Society Name</td>
										<td align="left" style="background-color:#f8f8f8;" >'.$society_name.'</td>
										</tr>
										
										<tr>
										<td align="center" style="background-color:#00A0E3;color:white;" >Details</td>
										<td align="left" style="background-color:#f8f8f8;" >
										<p>User Email-Id: &nbsp; '.$email.'</p>
										<p>Mobile No: &nbsp; '.$mobile.' </p></td>
										</tr>
									
										</table> 
									
									</td>
								
								
								
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span> 
												<p style="font-size:16px;"> <strong>Message Description:</strong></p>
												<p>'.$message.'</p>
											</span>
									</td>
																
								</tr>
								
								<tr>
									<td style="padding:10px;" width="100%" align="center">
	<span> 
	 <a href="'.$ip.$this->webroot.'" style="width:100px;min-height:30px;background-color:rgb(0,142,213);padding:7px;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;white-space:nowrap;font-weight:bold;vertical-align:middle;font-size:14px;line-height:14px;color:rgb(255,255,255);border:1px solid rgb(2,106,158);text-decoration:none" target="_blank">View / response on HousingMatters</a>							
	</span>
									</td>
																
								</tr>
								
								
					
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span > 
												Thank you.<br/>
												HousingMatters (Support Team)<br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>

								

					
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';



date_default_timezone_set('Asia/kolkata');
$date=date("d-m-Y");
$time=date('h:i:a',time());
$i=$this->autoincrement('feedback','feedback_id');
$this->loadmodel('feedback');
$this->feedback->saveAll(array("feedback_id" => $i,"feedback_subject" => $subject,"feedback_date"=>$date,"feedback_category"=>$feedback_cat_id,"user_id"=>$s_user_id,"feedback_time"=>$time,"feedback_message"=>$message_web,"society_id"=>$s_society_id,"feedback_des"=>$message,'delete_id'=>0));
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);

$this->Session->write('feedback_status',1);
$this->response->header('Location', $this->webroot.'Hms/dashboard');		
	
?>     



<!----alert--------------
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Thank you for getting in touch with us. <br> We shall Respond to you within 24 hours. 
</div> 
<div class="modal-footer">
<a href="dashboard" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php


}

}


function feedback_view()
{

$this->layout='session';	
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$this->loadmodel('feedback');
$order=array('feedback.feedback_id'=>'DESC');
$conditions=array('delete_id'=>0);
$result=$this->feedback->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('result_feedback',$result);	
}

function feedback_view1()
{

$this->layout='session';	
$feedback_id=(int)$this->request->query('con');
$this->loadmodel('feedback');	
$conditions=array('feedback_id'=>$feedback_id);	
$result=$this->feedback->find('all',array('conditions'=>$conditions));	
$this->set('result_feedback',$result);
if($this->request->is('post'))
{
	$ip=$this->hms_email_ip();
	 $feedback_reply=$this->request->data['feedback_reply'];
	
	foreach($result as $collection)
	{
		$da_user_id=(int)$collection['feedback']['user_id'];
		$reply_fed=@$collection['feedback']['reply'];
	}
	if(sizeof($reply_fed)==0)	{ $reply_fed=array(); }
	
	if(sizeof($reply_fed)==0)
		{
		$reply_fed[]=$feedback_reply;
		
		}
		else
		{
		$t=$feedback_reply;
		array_push($reply_fed,$t);
		}
	
	
	$result_user=$this->profile_picture($da_user_id);
	foreach($result_user as $data)
	{
		 $user_name=$data['user']['user_name'];
		 $to=$data['user']['email'];
	} 
	
	$from="Support@housingmatters.in";
	$reply="Support@housingmatters.in";
	$from_name="HousingMatters"; 
	$subject='HousingMatters';


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
								</tr>
								
									
								
						</tbody>
					</table>
					
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						
								
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span>
											<p style="font-size:16px;"> <strong>Message:</strong></p>';
											foreach($reply_fed as $data){
												$message_web.=$data;
											}
											
										$message_web.='</span> 
										</td>
																
								</tr>
								
								
								

								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span style="color:rgb(100,100,99)"> 
												Thank you.<br/>
												HousingMatters (Support Team)<br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';

$this->loadmodel('feedback');
$this->feedback->updateAll(array('reply'=>$reply_fed),array('feedback_id'=>$feedback_id));
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);		
?>

<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Successfully reply.
</div> 
<div class="modal-footer">
<a href="feedback_view" class="btn green">OK</a>
</div>
</div>
<!----alert-------------->



<?php	
}

	
}

function feedback_delete()
{
	$this->layout="blank";
	$fed_id=(int)$this->request->query('con');
	$this->loadmodel('feedback');
	$this->feedback->updateAll(array('delete_id'=>1),array('feedback_id'=>$fed_id));
	$this->response->header('Location','feedback_view');
	
}

/////////////////////////////////////// End Feedback functionality /////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


///////////////////////////// Start Invitation Member ////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////

function invite_member()
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
	$this->ath();
	$this->check_user_privilages();
$s_society_id=(int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
if(isset($this->request->data['sub'])) 
{
	$ip=$this->hms_email_ip();
date_default_timezone_set('Asia/Kolkata');
$date=date("d-m-Y");
$time = date(' h:i a', time());
$from_name="HousingMatters";
$reply="Support@housingmatters.in";
$from="alerts@housingmatters.in";
$this->loadmodel('society');
$condition=array('society_id'=>$s_society_id);
$result_society=$this->society->find('all',array('conditions'=>$condition));
foreach($result_society as $data)
{
$society_name=$data['society']['society_name'];
}
$result_user=$this->profile_picture($s_user_id);
foreach($result_user as $dd)
{
	$user_name=$dd['user']['user_name'];
	$role_id=$dd['user']['role_id'];
	$wing=$dd['user']['wing'];
	$flat=$dd['user']['flat'];
}
if(in_array(3,$role_id))
{
	 $role='Admin';
}

if(!in_array(3,$role_id))
{
	 $role=$this->wing_flat($wing,$flat);
	
}
 @$radio=$this->request->data['committe'];
if($radio==1)
{
  $subject="".$society_name." - Invitation to HousingMatters"; 
}
if($radio==0)
{

 $subject="".$user_name." - Invites you to HousingMatters "; 
}

$r=$this->request->data['hid_name'];
for($i=2;$i<=$r;$i++)
{
$to=$this->request->data['email'.$i];
$name_user=$this->request->data['name_user'.$i];
if($radio==1)
{
/* $message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Dear $name_user,</p>
<p>We at $society_name use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.</p>
<p>As you are an owner/resident/staff of $society_name, I have added your email address in HousingMatters portal.</p>
<p>Here are some of the important features related to our portal on HousingMatters:</p>
<ul type='disc'>
<li>You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.</li>
<li>You can receive important SMS & emails from your committee.</li>
</ul>
<p>Signup today to <a href='$ip".$this->webroot."/hms/sign_up''>HousingMatters </a> for making life simpler for all your housing matters!</p>
<p>Regards,<br/>
$user_name $role  <br/>
www.housingmatters.co.in
</div >
</div>"; */

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
								</tr>
								
									
								
						</tbody>
					</table>
					
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						

									
									<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span  align="justify"> Dear '.$name_user.', </span> 
										</td>
																
									</tr>

								<tr>
										<td style="padding:5px;" width="100%" align="left">
										 We at '.$society_name.' use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.
										
										
										
										
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										As you are an owner/resident/staff of '.$society_name.', we have added your email address in HousingMatters portal.
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
												Here are some of the important features related to our portal on HousingMatters:
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
											<ul type="disc">
											<li>You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.</li>
											<li>You can receive important SMS & emails from your committee.</li>
											</ul>		
										</td>
																
								</tr>

									
								<tr>
										<td style="padding:5px;" width="100%" align="left"><br/>
											<span  align="justify"> 
											Signup today to <a href="'.$ip.$this->webroot.'hms/sign_up" style="text-decoration:none;" > HousingMatters </a> for making life simpler for all your housing matters!
																					
											</span> 
										</td>
																
								</tr>
								
								
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span > 
												Regards,<br/>
												'.$user_name.' '. $role .' <br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';



}

if($radio==0)
{
 /* $message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Dear $name_user,</p>
<p>We at $society_name use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.</p>
<p>Here are some of the important features related to our portal on HousingMatters:</p>
<ul type='disc'>
<li>You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.</li>
<li>You can receive important SMS & emails from your committee.</li>
</ul>
<p>Signup today to <a href='$ip".$this->webroot."/hms/sign_up''>HousingMatters </a> for making life simpler for all your housing matters!</p>
<p>Regards,<br/>
$user_name <br/>
www.housingmatters.co.in
</div >
</div>"; */

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
								</tr>
								
									
								
						</tbody>
					</table>
					
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						

									
									<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span  align="justify"> Dear '.$name_user.', </span> 
										</td>
																
									</tr>

								<tr>
										<td style="padding:5px;" width="100%" align="left">
										 We at '.$society_name.' use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.
										
										
										
										
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										As you are an owner/resident/staff of '.$society_name.', we have added your email address in HousingMatters portal.
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
												Here are some of the important features related to our portal on HousingMatters:
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
											<ul type="disc">
											<li>You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.</li>
											<li>You can receive important SMS & emails from your committee.</li>
											</ul>		
										</td>
																
								</tr>

									
								<tr>
										<td style="padding:5px;" width="100%" align="left"><br/>
											<span  align="justify"> 
											Signup today to <a href="'.$ip.$this->webroot.'hms/sign_up" style="text-decoration:none;" > HousingMatters </a> for making life simpler for all your housing matters!
																					
											</span> 
										</td>
																
								</tr>
								
								
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span > 
												Regards,<br/>
												'.$user_name.'  <br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';



}

$this->loadmodel('invitation');
$j= $this->autoincrement('invitation','invite_id');
$this->invitation->saveAll(array('invite_id'=>$j,'name'=>$name_user,'email'=>$to,'user_id'=>$s_user_id,'society_id'=>$s_society_id,'date'=>$date,'time'=>$time,'subject'=>$subject));
$this->send_email($to,$from,$from_name,$subject,$message_web,$reply); 
}
$this->Session->write('invite_status', 1);
}
}


function invite_member_view()
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
	$this->ath();
	$this->check_user_privilages();
$s_society_id=(int)$this->Session->read('society_id');
$this->loadmodel('invitation');
$condition=array('society_id'=>$s_society_id);
$order=array('invitation.date'=>'DESC');
$result=$this->invitation->find('all',array('conditions'=>$condition,'order'=>$order));
$this->set('result_invitation',$result);
}
function invitation_remainder()
{
$this->layout='session';
$ip=$this->hms_email_ip();
$s_society_id=(int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$this->loadmodel('invitation');
$result= $this->invitation->find('all');
foreach($result as $data)
{
$check_email=$data['invitation']['email'];
 $check_date=$data['invitation']['date'];
$name_user=$data['invitation']['name'];
$subject=$data['invitation']['subject'];
$society_id=(int)$data['invitation']['society_id'];
$this->loadmodel('user');
$condition1=array('email'=>$check_email);
$result1=$this->user->find('all',array('conditions'=>$condition1));
$n=sizeof($result1);

if($n==0)
{
date_default_timezone_set('Asia/Kolkata');
$current_date=date("d-m-Y");

$r_date= date('d-m-Y', strtotime($check_date. ' + 7 days'));

if(strtotime($r_date)<strtotime($current_date))
{
  $to=$check_email;
	
$from_name="HousingMatters";
$reply="donotreply@housingmatters.in";
$from="alerts@housingmatters.in";
$this->loadmodel('society');
$condition=array('society_id'=>$society_id);
$result_society=$this->society->find('all',array('conditions'=>$condition));
foreach($result_society as $data)
{
$society_name=$data['society']['society_name'];
}
/*$message_web="<div>
<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
</br><p>Dear $name_user,</p>
<p>We at $society_name use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.</p>
<p>As you are an owner/resident/staff of $society_name, I have added your email address in HousingMatters portal.</p>
<p>Here are some of the important features related to our portal on HousingMatters:</p>
<ul type='disc'>
<li>You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.</li>
<li>You can receive important SMS & emails from your committee.</li>
</ul>
<p>Signup today to <a href='$ip".$this->webroot."/hms/sign_up''>HousingMatters </a> for making life simpler for all your housing matters!</p>
<p>Regards,<br/>
Administrator of $society_name <br/>
<a href='http://www.housingmatters.co.in''>www.housingmatters.co.in </a>
</p><br/>
Thank you.<br/>
HousingMatters (Support Team)<br/><br/>
www.housingmatters.co.in
</div >
</div>"; */


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
								</tr>
								
									
								
						</tbody>
					</table>
					
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						

									
									<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span  align="justify"> Dear '.$name_user.', </span> 
										</td>
																
									</tr>

								<tr>
										<td style="padding:5px;" width="100%" align="left">
										 We at '.$society_name.' use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.
										
										
										
										
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										As you are an owner/resident/staff of '.$society_name.', we have added your email address in HousingMatters portal.
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
												Here are some of the important features related to our portal on HousingMatters:
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
											<ul type="disc">
											<li>You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.</li>
											<li>You can receive important SMS & emails from your committee.</li>
											</ul>		
										</td>
																
								</tr>

									
								<tr>
										<td style="padding:5px;" width="100%" align="left"><br/>
											<span  align="justify"> 
											Signup today to <a href="'.$ip.$this->webroot.'hms/sign_up" style="text-decoration:none;" > HousingMatters </a> for making life simpler for all your housing matters!
																					
											</span> 
										</td>
																
								</tr>
								
								
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span > 
												Regards,<br/>
												Administrator of '.$society_name.' <br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';

$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
}
}
}

}
////////////////////////////End Invitation Member ///////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////// Governance_designation ////////////////////////////////////////
/*

function governance_designation()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}
$this->ath();
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$this->loadmodel('governance_designation');
$condition=array('society_id'=>$s_society_id);
$result=$this->governance_designation->find('all',array('conditions'=>$condition)); 
$this->set('result_governance_designation',$result);

}
function designation_edit()
{
	$this->layout='blank';
	$designation_id=(int)$this->request->query('d_id');
	 $edit=(int)$this->request->query('edit');
	 $this->set('edit',$edit);
	if($edit==0)
	{
	$this->loadmodel('governance_designation');
	$conditions=array("governance_designation_id" => $designation_id);
	$des_result=$this->governance_designation->find('all', array('conditions' => $conditions));
	$this->set('des_result',$des_result);
	}
	if($edit==1)
	{
	$des=$this->request->query('des');	
		
	}
	
}
function governance_designation_ajax()
{
	$this->layout=null;	
	$post_data=$this->request->data;
	$s_society_id=$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$date=date('d-m-Y');
	$time = date(' h:i a', time());	
	$designation = htmlentities($post_data['designation']);
	$report = array();
	if(empty($designation)){
	$report[]=array('label'=>'win', 'text' => 'Please Fill designation Name');
	}
				
	if(sizeof($report)>0)
	{
	$output=json_encode(array('report_type'=>'error','report'=>$report));
	die($output);
	}
	
	
	$this->loadmodel('governance_designation');
	$governance_designation_id=$this->autoincrement('governance_designation','governance_designation_id');
	$this->governance_designation->saveAll(array('governance_designation_id'=>$governance_designation_id,'society_id'=>$s_society_id,'user_id'=>$s_user_id,'date'=>$date,'time'=>$time,'designation_name'=>$designation));

$output=json_encode(array('report_type'=>'publish','report'=>'Designation Inserted Successfully'));
die($output);
	
}
*/
//////////////////////////  end deginations ////////////////////////////////////////////



///////////////////////////////////////////////// Society Setup //////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function master_sm_wing_ajax()
{
$this->layout='blank';

$s_society_id=(int)$this->Session->read('society_id');
$wing=$this->request->query['wing_name'];
$this->loadmodel('wing');
$conditions=array("wing_name" => $wing,'society_id'=>$s_society_id);
$result3 = $this->wing->find('all',array('conditions'=>$conditions));
$n3 = sizeof($result3);
if ($n3 > 0) {
echo "false";
} else {
echo "true";
}
}
 /////////////////////////////////////////// Start Master Sm wing ////////////////////////////////////////////////// 

 function master_sm_wing()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}
$this->ath();
	
	
	
$s_society_id=$this->Session->read('society_id');
if(isset($this->request->data['sub'])) 
{
echo $wing_name=htmlentities($this->request->data['wing_name']);
exit;
//$no_of_flat = (int)$this->request->data['nu'];
$this->loadmodel('wing');
$i=$this->autoincrement('wing','wing_id');
$this->wing->saveAll(array("wing_id" => $i,"society_id"=> $s_society_id,"wing_name"=>$wing_name));


}
$this->loadmodel('wing');
$condition=array('society_id'=>$s_society_id);
$result=$this->wing->find('all',array('conditions'=>$condition)); 
$this->set('user_wing',$result);


}
 /////////////////////////////////////////// End Master Sm wing ////////////////////////////////////////////////// 


/////////////////////////////// Start Master Sm Flat//////////////////////////////////////
function master_sm_flat()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}
$this->ath();
$s_society_id= (int)$this->Session->read('society_id');
$nnn = 0;

if(isset($this->request->data['sssbbb']))
{
$valll = $this->request->data['arra_typpp'];

$this->loadmodel('society');
$this->society->updateAll(array("area_scale" => $valll),array('society_id'=> $s_society_id));	
}


if(isset($this->request->data['flat_add']))
{
$count = $this->request->data['xyz'];

for($j=1; $j<=$count; $j++)
{
$wing_id = (int)$this->request->data['wing_name'.$j];
$flat_id = (int)$this->request->data['flat_no'.$j];
$flat_type_id = (int)$this->request->data['flat_type'.$j];
$area = (int)$this->request->data['area'.$j];
$noc_type = (int)$this->request->data['noctp'.$j];

$mmm = 5;
$this->loadmodel('flat_type');
$condition=array('society_id'=>$s_society_id,"flat_type_id"=>$flat_type_id);
$cursor = $this->flat_type->find('all',array('conditions'=>$condition)); 
foreach($cursor as $collection)
{
$auto_id = (int)@$collection['flat_type']['auto_id'];
$no_of_flat = (int)@$collection['flat_type']['number_of_flat'];
$mmm = 55;
}
if($mmm == 5)
{
$no_of_flat = 1;
$this->loadmodel('flat_type');
$p=$this->autoincrement('flat_type','auto_id');
$this->flat_type->saveAll(array("auto_id" => $p,"flat_type_id"=> $flat_type_id,"number_of_flat"=>$no_of_flat,"status"=>0,"society_id"=>$s_society_id));


$this->loadmodel('flat');
$this->flat->updateAll(array("flat_area"=>$area,"noc_ch_type"=>$noc_type,"flat_type_id"=>$p),array("flat_id"=>$flat_id));



}
else if($mmm == 55)
{
$no_of_flat++;
$this->loadmodel('flat_type');
$this->flat_type->updateAll(array("number_of_flat"=>$no_of_flat),array("auto_id"=>$auto_id));

$this->loadmodel('flat');
$this->flat->updateAll(array("flat_area"=>$area,"noc_ch_type"=>$noc_type,"flat_type_id"=>$auto_id),array("flat_id"=>$flat_id));

}



}
?>
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-header">
<center>
<h3 id="myModalLabel3" style="color:#999;"><b>Flat Number</b></h3>
</center>
</div>
<div class="modal-body">
<center>
<h3><b>Record Inserted Successfully</b></h3>
</center>
</div>
<div class="modal-footer">
<a href="master_sm_flat" class="btn blue">OK</a>
</div>
</div>
<?php

}
//$this->loadmodel('flat');
//$i=$this->autoincrement('flat','flat_id');
//$this->flat->saveAll(array("flat_id" => $i,"wing_id"=> $wing_id,"flat_name"=>$flat_name));



$this->loadmodel('wing');
$condition=array('society_id'=>$s_society_id);
$result_wing=$this->wing->find('all',array('conditions'=>$condition)); 
$this->set('user_wing',$result_wing);

$this->loadmodel('flat_type');
$condition=array('society_id'=>$s_society_id);
$result2=$this->flat_type->find('all',array('conditions'=>$condition)); 
$this->set('cursor2',$result2);

$this->loadmodel('flat');
$condition=array('society_id'=>$s_society_id);
$cursor1 = $this->flat->find('all',array('conditions'=>$condition)); 
$this->set('cursor1',$cursor1);

$this->loadmodel('society');
$condition=array('society_id'=>$s_society_id);
$cursor11 = $this->society->find('all',array('conditions'=>$condition)); 
$this->set('cursor11',$cursor11);


$this->loadmodel('flat_type_name');
$cursor4 = $this->flat_type_name->find('all'); 
$this->set("cursor4",$cursor4);

$this->loadmodel('noc_type');
$cursor3 = $this->noc_type->find('all'); 
$this->set('cursor3',$cursor3);

}

/////////////////////////////// End Master Sm Flat////////////////////////////////////////

function master_sm_flat_ajax()
{
$this->layout='blank';
$flat=$this->request->query['con1'];
$res=(int)$this->request->query['con2'];
$this->set('r',$res);
$this->loadmodel('flat');
$conditions=array("flat_name" => $flat,'wing_id'=>$res);
$result3 = $this->flat->find('all',array('conditions'=>$conditions));
$n = sizeof($result3);
$this->set('n3',$n);
}

function society_setting()
{
$this->layout='session';

}

////////////////////////////////////////// End Society Setup //////////////////////

////////////////////////////// Start ledger_sub_account by Flat id ///////////////////////////////////

function ledger_SubAccount_dattta_by_flat_id($flat_id)
{
$s_society_id = (int)$this->Session->read('society_id');

$this->loadmodel('ledger_sub_account');
$conditions=array("flat_id" => $flat_id,"society_id"=>$s_society_id);
return $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
}

////////////////////////////// Start ledger_sub_account by Flat id ///////////////////////////////////

//////////////////////////////// Start Rgular Bill Fetch (Accounts)///////////////////////////////
function new_regular_bill_detail_via_flat_id($flat_id)
{
$this->loadmodel('new_regular_bill');
$conditions=array("flat_id" => $flat_id,"approval_status"=>1);
return $this->new_regular_bill->find('all',array('conditions'=>$conditions));
}
///////////////////// End Rgular Bill Fetch (Accounts)///////////////////////////////////////


///////////////////////////////////////////////////////////Start Function Fetch Amount Income heads(Accounts)///////////////////////////////////////////
function fetch_amount($data_d) 
{
$this->loadmodel('ledger_account');
$conditions=array("auto_id" => $data_d);
return $this->ledger_account->find('all',array('conditions'=>$conditions));

}

///////////////////////////////////////////////////////////End Function Fetch Amount Income heads (Accounts)//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////// Start Petty Cash Payment Ajax(amount_cal_p)(Accounts) //////////////////////////////////////////////////////
function amount_cal_p()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->set('s_role_id',$s_role_id);	

$tds = (int)$this->request->query('data');
$amount = $this->request->query('amount');

$this->set('tds',$tds);
$this->set('amount',$amount);



}

//////////////////////////////////////////// End Petty Cash Payment Ajax(amount_cal_p)(Accounts) ////////////////////////////////////////////////////////

///////////////////////////////////////// Start Fetch tds (Accounts) ////////////////////////////////////////////////////////////////////////////////////
function fetch_tds($auto_id)
{
$this->loadmodel('master_tds');
$conditions=array("auto_id" => $auto_id);
return $this->master_tds->find('all',array('conditions'=>$conditions));	

}
///////////////////////////////////////// End Fetch tds (Accounts) ////////////////////////////////////////////////////////////////////////////////////





//////////////////////////////////Start Fix Deposit Add (Accounts) ////////////////////////////////////////////////////
function fix_deposit_add()
{
$this->layout='session';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->set('s_role_id',$s_role_id);


}

/////////////////////////////////////End Fix Deposit Add (Accounts) //////////////////////////////////////////////////////
















////////////////// Start Expense Tracker View History (Accounts)//////////////////////

function expense_tracker_view_history()
{
$this->layout='session';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->set('s_role_id',$s_role_id);
$vendor_id = (int)$this->request->query['b'];

$this->set('vendor_id',$vendor_id);


$this->loadmodel('ledger_sub_account');
$conditions=array("auto_id" => $vendor_id);
$cursor1=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
foreach($cursor1 as $collection)
{
$vendor_name = $collection['ledger_sub_account']['name'];
}
$this->set('vendor_name',$vendor_name);


$this->loadmodel('expense_tracker');
$conditions=array("party_head" => $vendor_id);
$cursor2=$this->expense_tracker->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);




}

/////////////////////////////////////////////// End Expense Tracker View History (Accounts)//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////Start Expense Tracker View History Approver Fetch (Accounts) ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function approver($user_id)
{
$this->loadmodel('user');
$conditions=array("user_id" => $user_id);
return $this->user->find('all',array('conditions'=>$conditions));
}
/////////////////////////////////////// End Expense Tracker View History Approver Fetch (Accounts)////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////// Start Expense Tracker View History Expense Head (Accounts) /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function fetch_expense_tracker($element_id){
	
$this->loadmodel('expense_tracker');	
$conditions=array('expense_tracker_id'=>$element_id);	
return $this->expense_tracker->find('all',array('conditions'=>$conditions));	
	
}

function fetch_fix_asset_table($id){

$this->loadmodel('fix_asset');	
$conditions=array('fix_asset_id'=>$id);	
return $this->fix_asset->find('all',array('conditions'=>$conditions));	
	
}


function fetch_adhoc_bill_table($id){

$this->loadmodel('adhoc_bill');	
$conditions=array('adhoc_bill_id'=>$id);	
return $this->adhoc_bill->find('all',array('conditions'=>$conditions));	
	
}


function fetch_journal_table($element_id){
	
$this->loadmodel('journal');	
$conditions=array('journal_id'=>$element_id);	
return $this->journal->find('all',array('conditions'=>$conditions));	
	
}

function expense_head($expense_head)
{
$this->loadmodel('ledger_account');
$conditions=array("auto_id" => $expense_head);
return $this->ledger_account->find('all',array('conditions'=>$conditions));
}
///////////////////////////////////////// End Expense Tracker View History Expense Head Fetch (Accounts) /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////// Start report_excel_expense_tracker (Accounts)////////////////////////////////////////////////////////////////////
function report_excel_expense_tracker()
{
$this->layout='session';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->set('s_role_id',$s_role_id);

$vendor_id = (int)$this->request->query['c'];
$this->set('vendor_id',$vendor_id);



$this->loadmodel('ledger_sub_account');
$conditions=array("auto_id" => $vendor_id);
$cursor1=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);



$this->loadmodel('expense_tracker');
$conditions=array("party_head" => $vendor_id);
$cursor2=$this->expense_tracker->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);


}


/////////////////////////////////////// End report_excel_expense_tracker (Accounts)////////////////////////////////////////////////////////////////////

////////////////////////////////////// Start Fix Asset View (Accounts)///////////////////////////////////////////////////////////////////////////////////
function fix_asset_view(){
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}

$this->ath();
$this->check_user_privilages();	

$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$result_society=$this->society_name($s_society_id);
$society_name = $result_society[0]['society']['society_name'];
$this->set('society_name',$society_name);

$this->loadmodel('fix_asset');
$order=array('fix_asset.purchase_date'=> 'ASC');
$conditions=array("society_id" => $s_society_id);
$result_fix_asset=$this->fix_asset->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('result_fix_asset',$result_fix_asset);



}
////////////////////////////// End Fix Asset View (Accounts)///////////////////////////////////////////////////////

/////////////////////////////Start Fix Asset Add (Accounts)////////////////////////////////////////////////////////
function fix_asset_add()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->ath();
$this->check_user_privilages();	
$this->set('s_role_id',$s_role_id);
$this->loadmodel('ledger_account');
$conditions=array("group_id" => 4);
$result_ledger_account=$this->ledger_account->find('all',array('conditions'=>$conditions));
$this->set('result_ledger_account',$result_ledger_account);


$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 15);
$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('result_ledger_sub_account',$result_ledger_sub_account);

}

////////////////////////////////////End Fix Asset Add (Accounts)////////////////////////////////////////// ////////////////////////////////////////////

////////////////////////////////////////// Start Fix Asset Show Ajax (Accounts) /////////////////////////////////////////////////////////////////////////

function fix_asset_show_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->set('s_role_id',$s_role_id);

$from = $this->request->query('date1');
$to = $this->request->query('date2');
$this->set('from',$from);
$this->set('to',$to);


$this->loadmodel('fix_asset');
$conditions=array("society_id" => $s_society_id);
$cursor1=$this->fix_asset->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);


$this->loadmodel('fix_asset');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->fix_asset->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

}


////////////////////////////////// Start Create Purchase Order//////////////////////////////////////////////////////
function create_purchase_order()
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


}
////////////////////////////////// End Create Purchase Order//////////////////////////////////////////////////////

/////////////////////////////////// Start Fix asset Json //////////////////////////////////////////////////////
function fix_asset_json(){
$this->layout='blank';
	
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id = (int)$this->Session->read('user_id');
	$post_data=$this->request->data;

     $this->ath();

$q=$post_data['myJsonString'];
$myArray = json_decode($q, true);

$c=0;
foreach($myArray as $child)
{
$c++;


	if(empty($child[0])){
		$output = json_encode(array('type'=>'error', 'text' => 'Asset Category is Required in row '.$c));
		die($output);
		}	
		
		
			if(empty($child[1])){
		$output = json_encode(array('type'=>'error', 'text' => 'Date of Purchase is Required in row '.$c));
		die($output);
		}	
		
		
		$TransactionDate = $child[1];
		$this->loadmodel('financial_year');
		$conditions=array("society_id" => $s_society_id,"status"=>1);
		$cursor = $this->financial_year->find('all',array('conditions'=>$conditions));
		$abc = 555;
		foreach($cursor as $collection){
				$from = $collection['financial_year']['from'];
				$to = $collection['financial_year']['to'];
				$from1 = date('Y-m-d',$from->sec);
				$to1 = date('Y-m-d',$to->sec);
				$from2 = strtotime($from1);
				$to2 = strtotime($to1);
				$transaction1 = date('Y-m-d',strtotime($TransactionDate));
				$transaction2 = strtotime($transaction1);
					if($transaction2 <= $to2 && $transaction2 >= $from2){
					$abc = 5;
					break;
					}	
		}
	if($abc == 555){
		$output=json_encode(array('type'=>'error','text'=>'Date of Purchase Should be in Open Financial Year in row '.$c));
		die($output);
	}
		
		
		
		
		
		
		
		
			if(empty($child[2])){
		$output = json_encode(array('type'=>'error', 'text' => 'Name of Supplier is Required in row '.$c));
		die($output);
		}	
		
		
			if(empty($child[3])){
		$output = json_encode(array('type'=>'error', 'text' => 'Rupees is Required in row '.$c));
		die($output);
		}	
		
		
		if(empty($child[4])){
		$output = json_encode(array('type'=>'error', 'text' => 'Asset Name is Required in row '.$c));
		die($output);
		}	
		
		
		if(!empty($child[5]) && !empty($child[6]))
		{
		$frmm = date('Y-m-d',strtotime($child[5]));
		$tttm = date('Y-m-d',strtotime($child[6]));
		$frmm2 = strtotime($frmm);
		$tttm2 = strtotime($tttm);
		if($tttm2 < $frmm2)
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Warranty Period To can not be Small Than Warranty Period From  in row '.$c));
		die($output);	
			
		}
		}	
		
		
}

$rrrr = array();
$z=0;
foreach($myArray as $child)
{
 $z++;
 $asset_category_id = (int)$child[0];
 $purchase_date = $child[1];
 $assert_supplier_id = (int)$child[2];
 $cost_of_purchase = $child[3];
 $asset_name = $child[4];
 $warranty_from = $child[5];
 $warranty_to = $child[6];
 $description = $child[7];
 $maintanance_schedule = $child[8]; 
 $current_date = date('d-m-Y');
 
 $file_name=@$_FILES["file".$z]["name"];
		if(!empty($file_name)){
		$file_name=$_FILES["file".$z]["name"];
		$file_tmp_name =$_FILES['file'.$z]['tmp_name'];
		$target = "fix_assets/";
		$target=@$target.basename($file_name);
		move_uploaded_file($file_tmp_name,@$target);
		}

 
 
 
 
 
 
$purchase_date2 = date('Y-m-d',strtotime($purchase_date));
 
 
	$fix_asset_id=$this->autoincrement('fix_asset','fix_asset_id');
	$fix_receipt_id=$this->autoincrement_with_society_ticket('fix_asset','fix_receipt_id');
	$this->loadmodel('fix_asset');
	$multipleRowData = Array( Array("fix_asset_id" => $fix_asset_id, "fix_receipt_id" => $fix_receipt_id,
	"asset_category_id" => $asset_category_id,"asset_name" => $asset_name, "description" => $description, 
	"purchase_date" => strtotime($purchase_date2), "cost_of_purchase" => $cost_of_purchase, 
	"asset_supplier_id" => $assert_supplier_id,"warranty_period_from" => $warranty_from,
	"warranty_period_to" => $warranty_to, "maintanance_schedule" => $maintanance_schedule, 
	"society_id" => $s_society_id,'user_id'=>$s_user_id,"file_name"=>$file_name,"current_date"=>$current_date));
	$this->fix_asset->saveAll($multipleRowData);   
    $rrrr[] = $fix_receipt_id;


$auto_id=$this->autoincrement('ledger','auto_id');
$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => $asset_category_id,
"ledger_sub_account_id" => null,"debit"=>$cost_of_purchase,"credit"=>null,
"table_name"=>"fix_asset","element_id"=>$fix_asset_id,"society_id"=>$s_society_id,
"transaction_date"=>strtotime($purchase_date2)));

$auto_id=$this->autoincrement('ledger','auto_id');
$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 15,
"ledger_sub_account_id" => $assert_supplier_id,"debit"=>null,"credit"=>$cost_of_purchase,
"table_name"=>"fix_asset","element_id"=>$fix_asset_id,"society_id"=>$s_society_id,
"transaction_date"=>strtotime($purchase_date2)));

$this->Session->write('fix_asst',1);
}
$fix_receipt_id = implode(',',$rrrr);

$output=json_encode(array('type'=>'success','text'=>'Fixed Asset Voucher No. #'.$fix_receipt_id.' is generated successfully'));
die($output);   

}
/////////////////////////////////// End Fix asset Json //////////////////////////////////
////////////////////////// Start Fix Asset Excel ////////////////////////////////////////
function fix_asset_excel()
{
	$this->layout=null;
	$this->ath();
	//$this->check_user_privilages();	

	$s_role_id=$this->Session->read('role_id');
	$s_society_id = $this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');

	$result_society=$this->society_name($s_society_id);
	$society_name = $result_society[0]['society']['society_name'];
	$this->set('society_name',$society_name);

	$this->loadmodel('fix_asset');
	$conditions=array("society_id" => $s_society_id);
	$result_fix_asset=$this->fix_asset->find('all',array('conditions'=>$conditions));
	$this->set('result_fix_asset',$result_fix_asset);



}
//////////////////////////////// End Fix Asset Excel ///////////////////////////////////////////////////////



////////////////////////// Start Ledger Sub Account Fetch (Accounts)//////////////////////////////////////////////////
function ledger_sub_account_fetch($value) 
{
$s_society_id = $this->Session->read('society_id');

$this->loadmodel('ledger_sub_account');
$conditions=array("auto_id" => $value,"society_id" => $s_society_id);
return $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
}

/////////////////////////////// End Ledger Sub Account Fetch (Accounts)/////////////////////////////////////////////

//////////////////////////////////////// Start Ledger Sub Account Fetch (Accounts)///////////////////////////////////////////////////////////////////////
function ledger_sub_account_fetch3($flat_id) 
{
$this->loadmodel('ledger_sub_account');
$conditions=array("flat_id" => (int)$flat_id);
return $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
}

//////////////////////////////////////// End Ledger Sub Account Fetch (Accounts)///////////////////////////////////////////////////////////////////////







/////////////////////////////////////////////// Start Module Fetch (Accounts)////////////////////////////////////////////////////////////////////////////
function module_fetch($module_id) 
{

$this->loadmodel('account_category');
$conditions=array("ac_id" => $module_id);
return $this->account_category->find('all',array('conditions'=>$conditions));
}

/////////////////////////////// End Module Fetch (Accounts)//////////////////////////////////////////

////////////////////// Start Module Name Fetch Date (Accounts)////////////////////////////////////
function module_main_fetch($module_name,$receipt_id) 
{
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel($module_name);
$order = array('$or' => array( array($module_name.'posting_date'=> 'ASC'),array($module_name.'transaction_date'=> 'ASC')));
$conditions=array("receipt_id" => $receipt_id, "society_id" => $s_society_id);
return $this->$module_name->find('all',array('conditions'=>$conditions,'order' =>$order));
}

function module_main_fetch5($module_name,$receipt_id,$module_id)
{
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel($module_name);
$order=array($module_name.'transaction_date'=> 'ASC');
$conditions=array("receipt_id" => $receipt_id,"society_id" => $s_society_id,"module_id"=>$module_id);
return $this->$module_name->find('all',array('conditions'=>$conditions,'order' =>$order));
}

function module_main_fetch10($module_name,$receipt_id) 
{
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel($module_name);
$order=array($module_name.'date'=> 'ASC');
$conditions=array("receipt_id" => $receipt_id, "society_id" => $s_society_id, "approve_status" => 2);
return $this->$module_name->find('all',array('conditions'=>$conditions,'order' =>$order));
}

////////////////////// End Module Name Fetch Date (Accounts)///////////////////////////////////////


/////////////////////////////////// Start Module Fetch (Accounts) //////////////////////////////////

function module_main_fetch2($module_name) 
{
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');


$this->loadmodel($module_name);
$conditions=array("society_id" => $s_society_id);
return $this->$module_name->find('all',array('conditions'=>$conditions));
}

//////////////////////////// End Module Fetch (Accounts) ///////////////////////////////////////////

//////////////////////////////////////////Start Trial Balance Module Fetch(Accounts)///////////////////////////////////////////////////////////////////

function module_main_fetch3($module_name,$receipt_id) 
{
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');


$this->loadmodel($module_name);
$conditions=array("society_id" => $s_society_id, "receipt_id" => $receipt_id);
return $this->$module_name->find('all',array('conditions'=>$conditions));
}





//////////////////////////////////////////End Trial Balance Module Fetch(Accounts)///////////////////////////////////////////////////////////////////

//////////////////////////////////////////////// Start Amount Category Fetch (Accounts)/////////////////////////////////////////////////////////////////
function amount_category($amount_category_id) 
{
$this->loadmodel('amount_category');
$conditions=array("amount_category_id" => $amount_category_id);
return $this->amount_category->find('all',array('conditions'=>$conditions));
}

//////////////////////////////////////////////// End Amount Category Fetch (Accounts)/////////////////////////////////////////////////////////////////

///////////////////////////////////////////////// Start Accounts Group Fetch (Accounts) ///////////////////////////////////////////////////////////////
function accounts_group($group_id) 
{
$this->loadmodel('accounts_group');
$conditions=array("auto_id" => $group_id);
return $this->accounts_group->find('all',array('conditions'=>$conditions));
}


///////////////////////////////////////////////// End Accounts Group Fetch (Accounts) ///////////////////////////////////////////////////////////////////













/////////////////// Start Income Head Fetch Regular Bill (Accounts)//////////////////
function it_income_head_fetch($user_id,$date1,$date2)
{

$this->loadmodel('regular_bill');
$conditions=array("bill_daterange_from" => array('$gt' => $date1),"bill_daterange_to" => array('$lte' => $date2),"bill_for_user"=>$user_id);
return $this->regular_bill->find('all',array('conditions'=>$conditions));
}
////////////////////// End Income Head Fetch Regular Bill (Accounts)///////////////


////////////////// Start Income Head Amount Fetch (Accounts)/////////////////////////////

function income_head_amount($inhe)
{

$this->loadmodel('ledger_account');
$conditions=array("auto_id" =>$inhe);
return $this->ledger_account->find('all',array('conditions'=>$conditions));


}

/////////////////////// End Income Head Amount Fetch (Accounts)///////////////////////



/////////////////// Start Supplimentry Bill View(Accounts)////////////////////////////
function supplimentry_bill_view()
{
$this->layout='session';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$auto_id = (int)$this->request->query('bill');


$this->loadmodel('adhoc_bill');
$conditions=array("adhoc_bill_id"=>$auto_id,"society_id" => $s_society_id);
$cursor=$this->adhoc_bill->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$bill_html = $collection['adhoc_bill']['bill_html'];	
}

$this->set('bill_html',$bill_html);

}
///////////////////////////////////////////////////////// End Supplimentry Bill View(Accounts)///////////////////////////////////////////////////////////

//////////////////////////////////////////////////////// Start Regular Bill View (Accounts)//////////////////////////////////////////////////////////////
function regular_bill_view()
{
$this->layout='session';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$auto_id = (int)$this->request->query('bill');

$this->loadmodel('regular_bill');
$conditions=array("regular_bill_id"=>$auto_id,"society_id" => $s_society_id);
$cursor=$this->regular_bill->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$bill_html = $collection['regular_bill']['bill_html'];	
}

$this->set('bill_html',$bill_html);

}
////////////////////////////////// End Regular Bill View (Accounts)//////////////////////////////////////////


////////////////////////////////////Start It Due date /////////////////////////////////////////////////

function it_due_date()
{
$this->layout='session';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$this->loadmodel('regular_bill');
$conditions=array("society_id" => $s_society_id);
$order = array('regular_bill.one_time_id'=> 'ASC');
$cursor1=$this->regular_bill->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('cursor1',$cursor1);


if(isset($this->request->data['sub']))
{
$day = (int)$this->request->data['due_day'];


$this->loadmodel('regular_bill');
$this->regular_bill->updateAll(array("due_days" => $day),array("update_id" => 5));	
?>

<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Due Days updated successfully
</div> 
<div class="modal-footer">
<a href="it_due_date"   class="btn green">OK</a>
</div>
</div>
<!----alert-------------->

<?php

}
}

/////////////////End It Due date /////////////////////////////////////////////////////////










////////////////////////// Start Master Opening Balance (Accounts)///////////////////
function master_opening_balance()
{
$this->layout = 'session';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	


$this->loadmodel('ledger_account');
$cursor1=$this->ledger_account->find('all');
$this->set('cursor1',$cursor1);



if(isset($this->request->data['sub']))
{
$year = $this->request->data['year'];
$la_id = (int)$this->request->data['le_ac'];
$opening_bal = $this->request->data['balance'];

if($la_id == 15 || $la_id == 33 || $la_id == 34 || $la_id == 35)
{
$lsa_id = (int)$this->request->data['su_le_ac'];

$opening_balance_id=$this->autoincrement('opening_balance','opening_balance_id');
$this->loadmodel('opening_balance');
$this->opening_balance->saveAll(array('opening_balance_id' => $opening_balance_id,'year' => $year,'account_type'=> 1, 'account_id' => $lsa_id,'opening_balance_amount' => $opening_bal,
"society_id" => $s_society_id));

}
else
{

$opening_balance_id=$this->autoincrement('opening_balance','opening_balance_id');
$this->loadmodel('opening_balance');
$this->opening_balance->saveAll(array('opening_balance_id' => $opening_balance_id,'year' => $year,'account_type'=> 2, 'account_id' => $la_id,'opening_balance_amount' => $opening_bal,"society_id" => $s_society_id));


}

?>
<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Record Inserted successfully
</div> 
<div class="modal-footer">
<a href="master_opening_balance"   class="btn green">OK</a>
</div>
</div>
<!----alert-------------->
<?php
}


}
////////////////////////// End Master Opening Balance (Accounts)/////////////////////////////



/////////////////////// Start Opening Balance Ajax (Accounts)/////////////////////////////////
function opening_balance_ajax()
{
$this->layout = 'blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$value1 = (int)$this->request->query('value1');
$this->set('value1',$value1);

}


/////////////////////// End Opening Balance Ajax (Accounts)////////////////////////////////////



////////////////////////// Start Opening Balance Report (Account)//////////////////////////////
function opening_balance_report()
{
$this->layout = 'session';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('ledger_account');
$cursor1=$this->ledger_account->find('all');
$this->set('cursor1',$cursor1);

}
////////////////////////// Start Opening Balance Report (Account)//////////////////////////////



////////////////////////// Start Opening Balance Report Ajax (Accounts)///////////////////////
function opening_balance_report_ajax()
{
$this->layout = 'blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$value1 = (int)$this->request->query('ff');

$this->loadmodel('ledger_sub_account');
$conditions=array("society_id" => $s_society_id, "ledger_id" => $value1);
$cursor1=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);



}
////////////////////////// End Opening Balance Report Ajax (Accounts)/////////////////////////


//////////////////////////// Start Opening Balance Show Ajax (Accounts)////////////////////////
function opening_balance_show_ajax()
{
$this->layout = 'blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$year = $this->request->query('year');
$le_ac = (int)$this->request->query('le_ac');

$this->set('le_ac',$le_ac);
$this->set('year',$year);

if($le_ac == 15 || $le_ac == 33 || $le_ac == 34 || $le_ac == 35)
{
$ls_ac = (int)$this->request->query('ls_ac');

$this->loadmodel('opening_balance');
$conditions=array("society_id" => $s_society_id, "year" => $year, "account_type" => 1,"account_id" => $ls_ac);
$cursor =$this->opening_balance->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$op_ba = $collection['opening_balance']['opening_balance_amount'];
}

$this->loadmodel('ledger_sub_account');
$conditions=array("auto_id" => $ls_ac, "society_id" => $s_society_id);
$cursor =$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$subl_name = $collection['ledger_sub_account']['name'];
}

$this->set('subl_name',$subl_name);
$this->set('op_ba',$op_ba);
}
else
{
$this->loadmodel('opening_balance');
$conditions=array("society_id" => $s_society_id, "year" => $year, "account_type" => 2,"account_id" => $le_ac);
$cursor =$this->opening_balance->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$op_ba = $collection['opening_balance']['opening_balance_amount'];
}
$this->loadmodel('ledger_account');
$conditions=array("auto_id" => $le_ac);
$cursor =$this->ledger_account->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$ledger_ac_name = $collection['ledger_account']['ledger_name'];
}
$this->set('le_ac_name',$ledger_ac_name);
$this->set('op_ba',$op_ba);

}
}
//////////////////////////// End Opening Balance Show Ajax (Accounts)//////////////










//////////////////////////////////////////////// Start Master Flat Rent (Accounts) //////////////////////////////////////////////////////////////////////
function master_flat_rent()
{
$this->layout='session';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	



if(isset($this->request->data['sub']))
{
$user_id = (int)$this->request->data['user_id'];
$type = $this->request->data['flat_type'];

if($type == 1)
{
$size = $this->request->data['flat_size_s'];

$this->loadmodel('user');
$this->user->updateAll(array("flat_type" => $type, "flat_size" => $size),array("user_id" => $user_id));	
}

if($type == 2)
{
$size_id = (int)$this->request->data['flat_size'];

$this->loadmodel('user');
$this->user->updateAll(array("flat_type" => $type, "flat_size" => $size_id),array("user_id" => $user_id));	
}
?>

<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">
Record Updated
</div> 
<div class="modal-footer">
<a href="master_flat_rent"   class="btn green">OK</a>
</div>
</div>
<!----alert-------------->

<?php

}

$this->loadmodel('user');
$conditions=array("society_id"=>$s_society_id);
$cursor1=$this->user->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);	

$this->loadmodel('flat_rent');
$conditions=array("flat_type" => 2);
$cursor2=$this->flat_rent->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);	






}

//////////////////////////////////////////////// End Master Flat Rent (Accounts) //////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////// Start Flat Assign Ajax (Accounts) ////////////////////////////////////////////////////////////////////
function flat_assign_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$user_id = (int)$this->request->query('user_id');
$this->set('user_id',$user_id);











}
////////////////////////////////////////////////// End Flat Assign Ajax (Accounts) ////////////////////////////////////////////////////////////////////






////////////////////////////////////// Start Accounts Group Fetch (Accounts)////////////////////////////////////////////////////////////////////////////
function accounts_group_fetch($auto_id) 
{
$this->loadmodel('accounts_group');
$conditions=array("accounts_id" => $auto_id);
return $this->accounts_group->find('all',array('conditions'=>$conditions));
}

////////////////////////////////////// End Accounts Group Fetch (Accounts)//////////////////////////////////////////////////////////////////////////////
/////////////////// Start accounts_group_fetch2 //////////////////////////////////

function accounts_group_fetch2($auto_id) 
{
$this->loadmodel('accounts_group');
$conditions=array("auto_id" => $auto_id);
return $this->accounts_group->find('all',array('conditions'=>$conditions));
}

/////////////////// End accounts_group_fetch2 //////////////////////////////////



/////////////////////// Start Ledger Account Fetch (Accounts)////////////////////////////////////////////////////////////////////////
function service_provider_detail($auto_id) 
{
$this->loadmodel('service_provider');
$conditions=array("sp_id" => $auto_id);
return $this->service_provider->find('all',array('conditions'=>$conditions));
}

/////////////////////// Start Ledger Account Fetch (Accounts)////////////////////////////////////////////////////////////////////////
function ledger_account_fetch($auto_id) 
{
$this->loadmodel('ledger_account');
$conditions=array("group_id" => $auto_id);
$order=array("ledger_account.ledger_name"=>"ASC");
return $this->ledger_account->find('all',array('conditions'=>$conditions,'order'=>$order));
}




//////////////////////////////////////// End Ledger Account Fetch (Accounts)////////////////////////////////////////////////////////////////////////

function ledger_fetch_new($sub_id)
{
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');		

$this->loadmodel('ledger');
$conditions=array("society_id" => $s_society_id,"account_id" => $sub_id);
return $this->ledger->find('all',array('conditions'=>$conditions));

}



//////////////////////////////////////////////Start Ledger Fetch1 (Accounts)/ ///////////////////////////////////////////////////////////////////////////
function ledger_fetch1($sub_id)
{
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');		

$this->loadmodel('ledger');
$conditions=array("society_id" => $s_society_id, "account_type" => 1, "account_id" => $sub_id);
return $this->ledger->find('all',array('conditions'=>$conditions));

}
//////////////////////////////////////////////End Ledger Fetch1 (Accounts)///////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////// Start Ledger Fetch2 (Accounts)//////////////////////////////////////////////////////////////////////////////

function ledger_fetch2($sub_id)
{
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');		


$this->loadmodel('ledger');
$conditions=array("society_id" => $s_society_id, "account_type" => 2, "account_id" => $sub_id);
return $this->ledger->find('all',array('conditions'=>$conditions));

}


//////////////////////////////////////////// End Ledger Fetch2 (Accounts)//////////////////////////////////////////////////////////////////////////////


/////////////////////////////////// Start Ledger Sub Account Fetch (Accounts)///////////////////////
function ledger_sub_account_fetch2($auto_id) 
{

$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => $auto_id);
return $this->ledger_sub_account->find('all',array('conditions'=>$conditions));

}

///////////////// End Ledger Sub Account Fetch (Accounts)///////////////////////////////////////////////////////////

function subledger_fetch_by_auto_id($auto_id) 
{
$this->loadmodel('ledger_sub_account');
$conditions=array("auto_id" => $auto_id);
return $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
}
////////////////////////////// Start Master Ledger Account Hm (Accounts)///////////////
function master_ledger_account_hm()
{
	$this->layout='session';
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id= (int)$this->Session->read('user_id');	
	$this->set('s_user_id',$s_user_id);

	$del_id = (int)$this->request->query('con');
	$this->set('del_id',$del_id);

	if(isset($this->request->data['delc']))
	{
	$del = (int)$this->request->data['del_id'];

	$this->loadmodel('ledger_account');
	$this->ledger_account->updateAll(array("delete_id" => 1),array("auto_id" => $del));	
	?>
	<script>
	window.location.href="master_ledger_account_hm";
	</script>
	<?php
	}
	$this->loadmodel('ledger_account');
	$cursor=$this->ledger_account->find('all');
	foreach ($cursor as $collection) 
	{
		$auto_id = (int)$collection['ledger_account']['auto_id']; 
		//submit code edit//
			if(isset($this->request->data['sub'.$auto_id]))
			{
			$ledger_name = $this->request->data['cat'.$auto_id];
			$gr_id = (int)$this->request->data['gr_id'.$auto_id];



			$this->loadmodel('ledger_account');
			$this->ledger_account->updateAll(array("ledger_name" => $ledger_name,"group_id"=>$gr_id),array("auto_id" => $auto_id));	

			}
	} 

	if(isset($this->request->data['sub']))
	{
		$main_id = (int)$this->request->data['main_id'];
		$name = $this->request->data['cat_name'];

		$this->loadmodel('ledger_account');
		$order=array('ledger_account.auto_id'=> 'ASC');
		$cursor=$this->ledger_account->find('all',array('order' =>$order));
		foreach ($cursor as $collection) 
		{
		$last=$collection['ledger_account']["auto_id"];
		}
		if(empty($last))
		{
		$i=0;
		}	
		else
		{	
		$i=$last;
		}
		$i++;
		$this->loadmodel('ledger_account');
		$multipleRowData = Array( Array("auto_id" => $i, "group_id" => $main_id, "ledger_name" => $name,"delete_id"=>0, "edit_user_id"=>$s_user_id,"society_id"=>0));
		$this->ledger_account->saveAll($multipleRowData);	

	}

	$this->loadmodel('accounts_group');
	$cursor1=$this->accounts_group->find('all');
	$this->set('cursor1',$cursor1);	

	$this->loadmodel('ledger_account');
	$conditions=array("delete_id" => 0);
	$cursor2=$this->ledger_account->find('all',array('conditions'=>$conditions));
	$this->set('cursor2',$cursor2);	


	$this->loadmodel('accounts_group');
	$conditions=array("delete_id" => 0);
	$cursor3=$this->accounts_group->find('all',array('conditions'=>$conditions));
	$this->set('cursor3',$cursor3);

}
//////////////////////// End Master Ledger Account Hm (Accounts)/////////////////////

//////////////////////////// Start Accounts Category Fetch (Accounts) /////////////////////////////////////
function accounts_category($accounts_id) 
{
$this->loadmodel('accounts_category');
$conditions=array("auto_id" => $accounts_id);
return $this->accounts_category->find('all',array('conditions'=>$conditions));

}
//////////////////////////////End Accounts Category Fetch (Accounts) //////////////////////////////////



/////////////////////////////////////////Start Master Ledger Sub Account Ajax  (Accounts)////////////////////////////////////////////////////////////////
function master_ledger_sub_account_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$value = (int)$this->request->query('value');
$this->set('value',$value);

}
///////////////////////////////////////End Master Ledger Sub Account Ajax (Accounts)/////////////////////////////////////////////////////////////////////

////////////////////////////////////////// Start Ledger Account Fetch (Accounts)/////////////////////////////////////////////////////////////////////////
function ledger_account($ledger_id) 
{

$this->loadmodel('ledger_account');
$conditions=array("auto_id" => $ledger_id);
return $this->ledger_account->find('all',array('conditions'=>$conditions));

}
////////////////////////////////////////// End Ledger Account Fetch (Accounts)///////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////Start Ledger Account Fetch2 (Accounts)////////////////////////////////////////////////////////////////////////
function ledger_account2($group_id) 
{

$this->loadmodel('ledger_account');
$conditions=array("group_id" => $group_id);
return $this->ledger_account->find('all',array('conditions'=>$conditions));

}

///////////////////////////////////////////End Ledger Account Fetch2 (Accounts)////////////////////////////////////////////////////////////////////////

//////////////////////Start Master Accounts Category Hm (Accounts)///////////////////////
function master_accounts_category_hm()
{
$this->layout='session';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	
$del_id = (int)$this->request->query('con');
$this->set('del_id',$del_id);

if(isset($this->requet->data['delc']))
{
$del = (int)$this->request->data['del_id'];
$this->loadmodel('accounts_category');
$this->accounts_category->updateAll(array("delete_id" => 1),array("auto_id" => $del));	
?>
<script>
window.location.href="master_accounts_category_hm";
</script>
<?php
}
$this->loadmodel('accounts_category');
$order=array('accounts_category.auto_id'=> 'ASC');
$cursor=$this->accounts_category->find('all',array('order' =>$order));
foreach ($cursor as $collection) 
{
$auto_id = (int)$collection['accounts_category']['auto_id'];
if(isset($this->request->data['sub'.$auto_id]))
{
$cata22 = $this->request->data['cat'.$auto_id];
$this->loadmodel('accounts_category');
$this->accounts_category->updateAll(array("category_name" => $cata22),array("auto_id" => $auto_id));	
}
}
if(isset($this->request->data['sub']))
{
$name = $this->request->data['cat_name'];

$this->loadmodel('accounts_category');
$iii=$this->autoincrement('accounts_category','auto_id');
$this->accounts_category->saveAll(array("auto_id" => $iii, "category_name"=>$name,"delete_id" => 0));
		
}

$this->loadmodel('accounts_category');
$conditions=array("delete_id" => 0);
$cursor1=$this->accounts_category->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);
}

//////////////////// End Master Accounts Category Hm (Accounts)//////////////////////

/////////////// Start Master Accounts Group Hm (Accounts) ////////////////////////////

function master_accounts_group_hm()
{
$this->layout='session';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$del_id = (int)@$this->request->query['con'];
$this->set('del_id',$del_id);

if(isset($this->request->data['delc']))
{
$del = (int)$this->request->data['del_id'];

$this->loadmodel('accounts_group');
$this->accounts_group->updateAll(array("delete_id" => 1),array("auto_id" => $del));
?>
<script>
window.location.href="master_accounts_group_hm";
</script>
<?php
}
$this->loadmodel('accounts_group');
$order=array('accounts_group.auto_id'=> 'ASC');
$cursor=$this->accounts_group->find('all',array('order' =>$order));
foreach ($cursor as $collection) 
{
$auto_id = (int)$collection['accounts_group']['auto_id'];
if(isset($this->request->data['sub'.$auto_id]))
{
$group_name = $this->request->data['cat'.$auto_id];
$this->loadmodel('accounts_group');
$this->accounts_group->updateAll(array("group_name" => $group_name),array("auto_id" => $auto_id));	
}
}

if(isset($this->request->data['sub']))
{
$main_id = $this->request->data['main_id'];
$name = $this->request->data['cat_name'];

$this->loadmodel('accounts_group');
$order=array('accounts_group.auto_id'=> 'ASC');
$cursor=$this->accounts_group->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last=$collection['accounts_group']["auto_id"];
}
if(empty($last))
{
$i=0;
}	
else
{	
$i=$last;
}
$i++;
$this->loadmodel('accounts_group');
$multipleRowData = Array( Array("auto_id" => $i, "accounts_id" => $main_id, "group_name" => $name,"delete_id" => 0));
$this->accounts_group->saveAll($multipleRowData);	
}

$this->loadmodel('accounts_group');
$conditions=array("delete_id" => 0);
$cursor1=$this->accounts_group->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('accounts_category');
$conditions=array("delete_id" => 0);
$cursor2=$this->accounts_category->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);
}

//////////////// End Master Accounts Group Hm (Accounts) //////////////////////////////


/////////////////////////////////////////// Start Master Flat Type (Accounts) ///////////////////////////////////////////////////////////////////////////
function master_flat_type()
{
$this->layout='session';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	


if(isset($this->request->data['sub']))
{
$flat_type = (int)$this->request->data['flat_type'];

if($flat_type == 1)
{
$square_rs = $this->request->data['rs_feet'];	

$this->loadmodel('flat_rent');
$this->flat_rent->updateAll(array("rs" => $square_rs),array("flat_type" => 1));	
}

if($flat_type == 2)
{
$flat_cat = (int)$this->request->data['flat_cat'];
$rs = $this->request->data['rs'];
if($flat_cat == 1)
{
$name = "1 BHK";	
}
else if($flat_cat == 2)
{
$name ="2 BHK";	
}
else if($flat_cat == 3)
{
$name ="3 BHK";	
}
else if($flat_cat == 4)
{
$name ="4 BHK";	
}
else if($flat_cat == 5)
{
$name ="5 BHK";	
}
else if($flat_cat == 6)
{
$name ="6 BHK";	
}
$this->loadmodel('flat_rent');
$this->flat_rent->updateAll(array("rs" => $rs),array("name" => $name));	

}
}
}
/////////////////////////////////////////// End Master Flat Type (Accounts) ///////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////Start Master Flat Assign ///////////////////////////////////////////////////////////////////////////////////
function master_flat_assign()
{
$this->layout='session';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

if(isset($this->request->data['sub']))
{
$this->loadmodel('flat');
$cursor=$this->flat->find('all');
foreach($cursor as $collection)
{	
$flat_id = (int)$collection['flat']['flat_id'];	

$type = (int)$this->request->data['flat_type'.$flat_id];

$this->loadmodel('flat');
$this->flat->updateAll(array("flat_type_id" => $type, "sqr_feet" => null),array("flat_id" => $flat_id));

}
}

$this->loadmodel('flat');
$cursor1=$this->flat->find('all');
$this->set('cursor1',$cursor1);	
}
/////////////////////////////////////////////End Master Flat Assign /////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////Start Master Flat Assign Second ///////////////////////////////////////////////////////////////////////////
function master_flat_assign2()
{
$this->layout='session';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

if(isset($this->request->data['sub']))
{
$type = (int)$this->request->data['type'];
if($type == 1)
{
$this->loadmodel('flat');
$conditions=array("flat_type_id" => 0);
$cursor = $this->flat->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$flat_id = (int)$collection['flat']['flat_id'];	

$sq_feet = (int)$this->request->data['sq_feet'.$flat_id];

$this->loadmodel('flat');
$this->flat->updateAll(array("sqr_feet" => $sq_feet),array("flat_id" => $flat_id));
}
}
if($type == 2)
{
$this->loadmodel('flat');
$conditions=array("flat_type_id" => 2);
$cursor = $this->flat->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$flat_id = (int)$collection['flat']['flat_id']; 

$bhk_id = (int)$this->request->data['bhk'.$flat_id];

$this->loadmodel('flat');
$this->flat->updateAll(array("flat_type_id" => $bhk_id),array("flat_id" => $flat_id));




}
}
}







}
//////////////////////////////////////////////End Master Flat Assign Second /////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////// Start Master Flat Assign2 Ajax /////////////////////////////////////////////////////////////////////////////
function master_flat_assign2_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$value = (int)$this->request->query('value1');
$this->set('value',$value);

$this->loadmodel('flat');
$conditions=array("flat_type_id" => 0);
$cursor1=$this->flat->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('flat');
$conditions=array("flat_type_id" => 2);
$cursor2=$this->flat->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);


$this->loadmodel('flat_rent');
$cursor3=$this->flat_rent->find('all');
$this->set('cursor3',$cursor3);

}
/////////////////////////////////// End Master Flat Assign2 Ajax /////////////////////////////////////////

////////////////////////////////// Start Expense History Pdf (Accounts)//////////////////////////////////////////
function expense_history_pdf()
{
$this->layout = 'pdf'; //this will use the pdf.ctp layout 
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$auto_id = (int)$this->request->query('a');
$this->set('auto_id',$auto_id);

$this->loadmodel('expense_tracker');
$conditions=array("auto_id" => $auto_id);
$cursor1=$this->expense_tracker->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);



}
/////////////////////////////////// End Expense History Pdf (Accounts)/////////////////////////////////////

///////////////////////////////// Start Regular Bill Pdf(Accounts)///////////////////////////////////////
function regular_bill_pdf()
{
$this->layout = 'pdf'; //this will use the pdf.ctp layout 
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$bill_id = (int)$this->request->query('p');
$this->set('bill_id',$bill_id);

$this->loadmodel('regular_bill');
$conditions=array("regular_bill_id" => $bill_id);
$cursor1=$this->regular_bill->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name=$collection['society']["society_name"];
$so_reg_no = $collection['society']['society_reg_num'];
$so_address = $collection['society']['society_address'];	
}
$this->set("society_name",$society_name);
$this->set("so_reg_no",$so_reg_no);
$this->set("so_address",$so_address);

}
//////////////////////////////////////////// End Regular Bill Pdf(Accounts)/////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////// Start Supplimentry Bill Pdf (Accounts)////////////////////////////////////////////////////////////////////
function supplimentry_bill_pdf()
{
$this->layout = 'pdf'; //this will use the pdf.ctp layout 
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$bill_id = (int)$this->request->query('p');
$this->set('bill_id',$bill_id);

$this->loadmodel('adhoc_bill');
$conditions=array("adhoc_bill_id" => $bill_id);
$cursor1=$this->adhoc_bill->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);



}
//////////////////////////////////////////// End Supplimentry Bill Pdf (Accounts)///////////////////////////////////////////////////////////////////////



/////////////////////////////////////////// Start Function Convert Rupee ///////////////////////////////////////////////////////////////////////////////
function n2www($num){
$numbers10 = array('ten','twenty','thirty','fourty','fifty','sixty','seventy','eighty','ninety');
$numbers01 = array('one','two','three','four','fife','six','seven','eight','nine','ten',
    'eleven','twelve','thirteen','fourteen','fifteen','sixteen','seventeen','eighteen','nineteen');
$string="";

if($num == 0) {
    $string.="zero ";
}

echo $thousands = floor($num/1000);

if($thousands != 0) {
	echo $thousands-1;
    $string.= $numbers01[$thousands-1] . " thousand "; 
    $num -= $thousands*1000;
	echo  $string; exit;
}

$hundreds = floor($num/100);
if($hundreds != 0) {
    $string.= $numbers01[$hundreds-1] . " hundred ";
    $num -= $hundreds*100;
}

if($num < 20) {
    if($num != 0) {
        $string.= $numbers01[$num-1];
    }
} else {
	
    $tens = floor($num/10);
    $string.= $numbers10[$tens-1] . " ";
    $num -= $tens*10;

    if($num != 0) {
		
        $string.= $numbers01[$num-1];
		
    }
	
}
return $string; 
}


function serial_no($number)
{

$str_lenth=strlen($number);
if($str_lenth==1)
{
$number='000'.$number;
}
else if($str_lenth==2)
{
$number='00'.$number;
}

else if($str_lenth==3)
{
$number='0'.$number;
}
$string.= $number;

echo $string;
}







/////////////////////////////////////////// End Function Convert Rupee ///////////////////////////////////////////////////////////////////////////////





/////////////////////// Start Flat Fetch(Accounts)//////////////////////////////////////////

function flat_fetch($flat_id) 
{
$s_society_id = (int)$this->Session->read('society_id');

$this->loadmodel('flat');
$conditions=array("flat_id" => $flat_id,"society_id"=>$s_society_id);
return $this->flat->find('all',array('conditions'=>$conditions));
}

/////////////////////// End Flat Fetch(Accounts)//////////////////////////////////////////////



//////////////////// Start Flat Rent Fetch(Accounts)//////////////////////////////////////////

function flat_rent_fetch($auto_id) 
{
$this->loadmodel('flat_rent');
$conditions=array("auto_id" => $auto_id);
return $this->flat_rent->find('all',array('conditions'=>$conditions));
}

///////////////////////End Flat Rent Fetch (Accounts)//////////////////////////////////////////


/////////////// Start Terms Conditions Fetch (Accounts)///////////////////////////////////////

function terms_fetch($auto_id) 
{
$this->loadmodel('terms_condition');
$conditions=array("terms_conditions_id" => $auto_id);
return $this->terms_condition->find('all',array('conditions'=>$conditions));
}
/////////////// End Terms Conditions Fetch (Accounts)//////////////////////////////////////////

/////////////// Start Bank receipt Fetch (Accounts)///////////////////////////////////////

function bank_receipt_fetch2($receipt_id) 
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
	
$this->loadmodel('cash_bank');
$conditions=array("receipt_id"=>$receipt_id,"society_id"=>$s_society_id,"module_id"=>1);
return $this->cash_bank->find('all',array('conditions'=>$conditions));
}
/////////////// End Terms Conditions Fetch (Accounts)//////////////////////////////////////////



/////////////// Start Bank receipt Fetch (Accounts)///////////////////////////////////////

function bank_receipt_fetch($user_id,$receipt_id) 
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
	
$this->loadmodel('cash_bank');
$conditions=array("bill_reference"=>$receipt_id,"user_id"=>$user_id,"society_id"=>$s_society_id,"module_id"=>1);
return $this->cash_bank->find('all',array('conditions'=>$conditions));
}
/////////////// End Terms Conditions Fetch (Accounts)//////////////////////////////////////////

/////////////// Start Petty Cash receipt Fetch (Accounts)///////////////////////////////////////

function petty_cash_receipt_fetch($user_id,$receipt_id) 
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
	
$this->loadmodel('cash_bank');
$conditions=array("bill_reference"=>$receipt_id,"user_id"=>$user_id,"society_id"=>$s_society_id,"module_id"=>3);
return $this->cash_bank->find('all',array('conditions'=>$conditions));
}
/////////////// End Terms Conditions Fetch (Accounts)//////////////////////////////////////////

////////////////// Start Regular Bill Fetch(Accounts)/////////////////////////////////////////
function regular_bill_fetch7($receipt_id) 
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('regular_bill');
$conditions=array("receipt_id" => $receipt_id,"society_id"=>$s_society_id);
return $this->regular_bill->find('all',array('conditions'=>$conditions));
}

////////////////// End Regular Bill Fetch(Accounts)/////////////////////////////////////////


////////////////// Start Regular Bill Fetch10(Accounts)/////////////////////////////////////////
function regular_bill_fetch10($user_id,$flat_id) 
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('regular_bill');
$conditions=array("bill_for_user" => $user_id, "status" => 0, "society_id"=>$s_society_id,"flat_id"=>$flat_id);
return $this->regular_bill->find('all',array('conditions'=>$conditions));
}

////////////////// End Regular Bill Fetch10(Accounts)/////////////////////////////////////////





////////////////// Start Regular Bill Fetch(Accounts)/////////////////////////////////////////
function regular_bill_fetch($user_id) 
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('regular_bill');
$conditions=array("bill_for_user" => $user_id, "status" => 0, "society_id"=>$s_society_id);
return $this->regular_bill->find('all',array('conditions'=>$conditions));
}

////////////////// End Regular Bill Fetch(Accounts)/////////////////////////////////////////




///////////////////// Start Ledger Account Fetch(Accounts)/////////////////////////////////////
function ledger_account_fetch2($auto_id) 
{
$this->loadmodel('ledger_account');
$conditions=array("auto_id" => $auto_id);
return $this->ledger_account->find('all',array('conditions'=>$conditions));
}
/////////////////////End Ledger Account Fetch(Accounts)/////////////////////////////////////

/////////////////////////// Start Nikhil Test (Accounts)///////////////////////////////////////
function nikhil_test()
{
$this->layout = 'session';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');		
}
/////////////////////////// Start Nikhil Test (Accounts)///////////////////////////////////////

////////////////////////// Start Profit And Loss Report////////////////////////////////////////
function profit_loss_report()
{
$this->layout = 'session';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');


}
////////////////////////// End Profit And Loss Report//////////////////////////////////////////

//////////////////////////Start Profit Loss Report Show Ajax(Accounts)/////////////////////////
function profit_loss_report_show_ajax()
{
$this->layout = 'blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');


$date1 = $this->request->query('date1');
$date2 = $this->request->query('date2');
$this->set('date1',$date1);
$this->set('date2',$date2);

$this->loadmodel('accounts_category');
$cursor1=$this->accounts_category->find('all');
$this->set('cursor1',$cursor1);


}
//////////////////////////End Profit Loss Report Show Ajax(Accounts)//////////////////////////

/////////////////////// Start ledger  Fetch1 (Accounts)///////////////////////////////////////
function ledger_fetch($auto_id)
{
$this->loadmodel('ledger');
$conditions=array("auto_id" => $auto_id, "account_type" => 1);
return $this->ledger->find('all',array('conditions'=>$conditions));
}

/////////////////////// End ledger  Fetch1 (Accounts)///////////////////////////////////////

/////////////////////// Start ledger  Fetch2 (Accounts)///////////////////////////////////////
function ledger_fetch3($auto_id)
{
$this->loadmodel('ledger');
$conditions=array("auto_id" => $auto_id, "account_type" => 2);
return $this->ledger->find('all',array('conditions'=>$conditions));
}

/////////////////////// End ledger  Fetch2 (Accounts)///////////////////////////////////////

/////////////////////////////// Start My Flat (Accounts)//////////////////////////////////////
function my_flat()
{
$this->layout = 'session';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

}
/////////////////////////////// End My Flat (Accounts)//////////////////////////////////////

///////////////////////////// Start My Flat Ajax(Accounts)///////////////////////////

function my_flat_ajax()
{
$this->layout = 'blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');

$this->loadmodel('user');
$conditions=array("society_id" => $s_society_id, "user_id"=>$s_user_id);
$cursor = $this->user->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$flat_id = (int)$collection['user']['flat'];
$wing_id = (int)$collection['user']['wing'];
}

$this->loadmodel('wing');
$conditions=array("society_id" => $s_society_id, "wing_id"=>$wing_id);
$cursor = $this->wing->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$wing_name = $collection['wing']['wing_name'];
}
$this->loadmodel('flat');
$conditions=array("society_id" => $s_society_id, "flat_id"=>$flat_id);
$cursor = $this->flat->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$flat_name = $collection['flat']['flat_name'];
$flat_mas_id = (int)$collection['flat']['flat_master_id'];
$flat_tp_id = (int)$collection['flat']['flat_type_id'];
}

$this->loadmodel('flat_master');
$conditions=array("society_id" => $s_society_id, "auto_id"=>$flat_mas_id);
$cursor = $this->flat_master->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$flat_area = $collection['flat_master']['flat_area'];
}

$this->loadmodel('flat_type');
$conditions=array("society_id" => $s_society_id, "auto_id"=>$flat_tp_id);
$cursor = $this->flat_type->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$flat_type = $collection['flat_type']['flat_name'];
}
$this->set('wing_name',$wing_name);
$this->set('flat_name',$flat_name);
$this->set('flat_area',$flat_area);
$this->set('flat_type',$flat_type);




$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
}
$this->set('society_name',$society_name);













$this->loadmodel('ledger_sub_account');
$conditions=array("society_id" => $s_society_id, "user_id"=>$s_user_id);
$cursor = $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$account_id = (int)$collection['ledger_sub_account']['auto_id'];
$name = $collection['ledger_sub_account']['name'];
$ledger_id = (int)$collection['ledger_sub_account']['ledger_id'];
}
$this->set('account_id',@$account_id);
$this->set('name',@$name);
$this->set('ledger_id',@$ledger_id);










$date1 = $this->request->query('date1');
$date2 = $this->request->query('date2');

$this->set('from',$date1);
$this->set('to',$date2);


$this->loadmodel('financial_year');
$conditions=array("society_id" => $s_society_id);
$cursor = $this->financial_year->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$from = $collection['financial_year']['from'];
$to = $collection['financial_year']['to'];
}
$cm = date('m');
$fm = date('m',strtotime($to));

if($cm <= $fm)
{
$year = date('Y');
$year = $year-1;
}
else
{
$year = date('Y');
}
$from1 = $from.'-'.$year; 

$year = $year-1;
$from2 = $from.''.$year;


$nv = 1;
$op_deb = 0;
$op_cred = 0;
while($nv < 3)
{
if($nv == 1)
{
$datefrom = date('Y-m-d',strtotime($from1));
$datefrom = new MongoDate(strtotime($datefrom));
}
else
{
$datefrom = date('Y-m-d',strtotime($from2));
$datefrom = new MongoDate(strtotime($datefrom));
}
$this->loadmodel('ledger'); 
$conditions=array("op_date"=>$datefrom,"account_type"=> 1,"account_id"=>
@$account_id,"receipt_id"=>"O_B","society_id"=>$s_society_id);
$cursor=$this->ledger->find('all',array('conditions'=>$conditions));

foreach($cursor as $collection)
{
$amount_type2 = (int)$collection['ledger']['amount_category_id'];
$amount2 = $collection['ledger']['amount'];
}
if(@$amount_type2 == 1)
{
$op_deb = $op_deb + $amount2;
}
else if(@$amount_type2 == 2)
{
$op_cred = $op_cred + $amount2;
}
$nv ++;
}
$this->set('op_deb',$op_deb);
$this->set('op_cred',$op_cred);




$this->loadmodel('ledger');
$conditions=array("society_id" => $s_society_id, "account_id"=>@$account_id,"account_type"=>1);
$cursor1 = $this->ledger->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

}

///////////////////////////// End My Flat Ajax(Accounts)////////////////////////////





////////////////////////// start master sm flat add row /////////////////////////////////////
function master_sm_flat_add_row()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$t = $this->request->query('con');
$this->set('t',$t);

$this->loadmodel('wing');
$condition=array('society_id'=>$s_society_id);
$result=$this->wing->find('all',array('conditions'=>$condition)); 
$this->set('user_wing',$result);

$this->loadmodel('flat_type');
$condition=array('society_id'=>$s_society_id);
$result2=$this->flat_type->find('all',array('conditions'=>$condition)); 
$this->set('cursor2',$result2);

$this->loadmodel('flat_type_name');
$result4=$this->flat_type_name->find('all'); 
$this->set('cursor4',$result4);


$this->loadmodel('noc_type');
$cursor3 = $this->noc_type->find('all'); 
$this->set('cursor3',$cursor3);


}
////////////////////////// End master sm flat add row /////////////////////////////////////



////////////////////// Start Flat Fetch (Accounts)///////////////////////////////////
function flat_fetch2($flat,$wing)
{
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');


$this->loadmodel('flat');
$conditions=array("society_id" => $s_society_id, "flat_id" => $flat, "wing_id" => $wing);
return $this->flat->find('all',array('conditions'=>$conditions));

}
////////////////////// End Flat Fetch (Accounts)///////////////////////////////////////////

//////////////////////// Start Flat Master Fetch(Accounts)//////////////////////////////////
function flat_master_fetch($auto_id)
{
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('flat_master');
$conditions=array("auto_id" => $auto_id);
return $this->flat_master->find('all',array('conditions'=>$conditions));

}
/////////////////////////// End Flat master fetch (accounts)///////////////////////////////

///////////////////////// Start Flat Type fetch(Accounts)/////////////////////////////////
function flat_type_fetch($auto_id)
{
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('flat_type');
$conditions=array("society_id" => $s_society_id, "flat_type_id" => $auto_id);
return $this->flat_type->find('all',array('conditions'=>$conditions));
}

/////////////////////////End Flat Type Fetch (Accounts)/////////////////////////////////////

//////////////////// Start regular Bill Fetch(Accounts)/////////////////////////////////////
function regular_bill_fetch3($date1,$date2)
{
$s_role_id = (int)$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');

$this->loadmodel('regular_bill');
$order=array('regular_bill.regular_bill_id'=>'ASC');
$conditions=array("date" => array('$gt' => $date1),"bill_daterange_to" => array('$lte' => $date2),"society_id"=>$s_society_id);
return $this->regular_bill->find('all',array('conditions'=>$conditions,'order'=>$order));
}
//////////////////// End regular Bill Fetch(Accounts)/////////////////////////////

////////////////// Start user Fetch(Accounts)////////////////////////////////////////////
function user_fetch($user_id)
{
$s_role_id = (int)$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');

$this->loadmodel('user');
$conditions=array("user_id" => $user_id,"society_id"=>$s_society_id);
return $this->user->find('all',array('conditions'=>$conditions));
}
////////////////////////////////////// End user Fetch(Accounts)///////////////////////

////////////////// Start user Fetch(Accounts)////////////////////////////////////////////
function user_fetch5($wing,$flat)
{
$s_role_id = (int)$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');

$this->loadmodel('user');
$conditions=array("wing" => $wing,"flat"=>$flat,"society_id"=>$s_society_id);
return $this->user->find('all',array('conditions'=>$conditions));
}
////////////////////////////////////// End user Fetch(Accounts)///////////////////////












//////////////////////Start User fetch2///////////////////////////////////////////////
function user_fetch4()
{
$s_role_id = (int)$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');

$this->loadmodel('user');
$order=array('user.user_id'=> 'ASC');
$conditions=array("society_id" => $s_society_id, "tenant" => 1,"deactive"=>0);
return $this->user->find('all',array('conditions'=>$conditions));
}
/////////////////////End User fetch2////////////////////////////////////////////////////

///////////////////////// Start User fetch 3/////////////////////////////////////////////
function user_fetch3($wing)
{
$s_role_id = (int)$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');

$this->loadmodel('user');
$order=array('user.user_id'=> 'ASC');
$conditions=array("society_id" => $s_society_id, "tenant" => 1,"deactive"=>0,"wing"=>$wing);
return $this->user->find('all',array('conditions'=>$conditions));
}
///////////////////////// End User fetch 3/////////////////////////////////////////////



//////////////////////// Start terms Condition fetch(Accounts)//////////////////////
function terms_condition_fetch($auto_id) 
{

$this->loadmodel('terms_condition');
$conditions=array("terms_conditions_id" => $auto_id);
return $this->terms_condition->find('all',array('conditions'=>$conditions));

}

////////////////// End terms Condition fetch(Accounts) (Accounts)//////////////////////

///////////////////// Start Flat Type //////////////////////////////////////////////
function flat_type()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}
$this->ath();
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$this->loadmodel('flat');
$conditions=array("society_id" => $s_society_id);
$cursor1 = $this->flat->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('wing');
$conditions=array("society_id" => $s_society_id);
$cursor2 = $this->wing->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

}

/////////////////////////// Start Flat Import ////////////////////////////////////////////// 
function save_import_flat(){
	$this->layout='blank';
	$s_society_id = (int)$this->Session->read('society_id');
	
	$q=$this->request->query('q'); 
	$myArray = json_decode($q, true);
	
	$c=0;
	$report=array();
	$array1 = array();
	foreach($myArray as $child){
		$c++;
		if(empty($child[0])){
			$report[]=array('tr'=>$c,'td'=>1, 'text' => 'Required');
		}
		if(empty($child[1])){
		$report[]=array('tr'=>$c,'td'=>2, 'text' => 'Required');
		}
		
if(sizeof($report) == 0)
{		
$wing = (int)$child[0];
$flat_name = $child[1];	   
//////////////////////////////////////////
$nnn = 555;
$this->loadmodel('flat');
$conditions=array("society_id"=>$s_society_id);
$cursor3 = $this->flat->find('all',array('conditions'=>$conditions));
foreach($cursor3 as $collection)
{	
$wing_id2 = (int)$collection['flat']['wing_id'];
$flat_nu2 = $collection['flat']['flat_name'];	
if($wing_id2 == $wing && $flat_nu2 == $flat_name)
{
$nnn = 55;	
}	
}	
if($nnn == 55)
{	
$output=json_encode(array('report_type'=>'already','text'=>'Same Wing and Flat Already Exist in row '.$c));
die($output);
}	

foreach($array1 as $cmp)
{
$w = (int)$cmp[0];
$f = $cmp[1];
if($w == $wing && $f == $flat_name)
{
$output = json_encode(array('report_type'=>'repeat', 'text' => 'Repeatation of Flat Number in row '.$c.''));
die($output);
}
}
$array1[] = array($wing,$flat_name);

///////////////////////////////////////////////
}
}
if(sizeof($report)>0){
$output=json_encode(array('report_type'=>'error','report'=>$report));
die($output);
	
}
	
	
	
	
	
if($child[2]=="yes")
{
foreach($myArray as $child)
{

$wing = (int)$child[0];
$flat_name = $child[1];	
$this->loadmodel('flat');
$order=array('flat.flat_id'=> 'DESC');
$cursor=$this->flat->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last=$collection['flat']["flat_id"];
}
if(empty($last))
{
$k=0;
}	
else
{	
$k=$last;
}
$k++;
$this->loadmodel('flat');
$multipleRowData = Array( Array("flat_id"=>$k, "wing_id"=>$wing, "flat_name"=>(int)$flat_name, "society_id"=>$s_society_id));
$this->flat->saveAll($multipleRowData);	

}

$output=json_encode(array('report_type'=>'done','text'=>'Record Inserted Successfully'));
die($output);

}

	
}
/////////////////////////// End Flat Import ////////////////////////////////////////////// 
function import_flat_ajax(){
	
	$this->layout="blank";
	$this->ath();
	 
	$s_society_id=$this->Session->read('society_id');
	$this->loadmodel('wing');
	$conditions=array("society_id" => $s_society_id);
	$result_wing = $this->wing->find('all',array('conditions'=>$conditions));
	$this->set('result_wing',$result_wing);

	if(isset($_FILES['file'])){
		$file_name=$_FILES['file']['name'];
		$file_tmp_name =$_FILES['file']['tmp_name'];
		$target = "csv_file/unit/";
		$target=@$target.basename($file_name);
		move_uploaded_file($file_tmp_name,@$target);
		
		$f = fopen('csv_file/unit/'.$file_name, 'r') or die("ERROR OPENING DATA");
		$batchcount=0;
		$records=0;
		while (($line = fgetcsv($f, 4096, ';')) !== false) {
		// skip first record and empty ones
		$numcols = count($line);
		$test[]=$line;
		++$records;
		}

		fclose($f);
		$records;
	}
	
	$i=0;
	foreach($test as $child){
		if($i>0){
			$child_ex=explode(',',$child[0]);
			$wing_name=$child_ex[0];
			$flat_name=$child_ex[1];
			
			
			$this->loadmodel('wing'); 
			$conditions=array("society_id"=>$s_society_id,"wing_name"=> new MongoRegex('/^' .  $wing_name . '$/i'));
			$result_wing=$this->wing->find('all',array('conditions'=>$conditions));
			$result_wing_count=sizeof($result_wing);
			
			$wing_id=0;
			if($result_wing_count>0){
				$wing_id=$result_wing[0]['wing']['wing_id'];
			}
			
			$table[]=array($wing_id,$flat_name);
		}
		$i++;
	}
	$this->set('table',$table);
}
///////// Flat Import ///////////////////////////
/*
if($this->request->is('post')) 
{
$file=$this->request->form['file']['name'];
$dir='C:\xampp\htdocs\cakephp\app\webroot\csv_file';
$target = "csv_file/";
$target=@$target.basename(@$this->request->form['file']['name']);
$ok=1;
move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target);

$f = fopen('csv_file/'.$file, 'r') or die("ERROR OPENING DATA");
$batchcount=0;
$records=0;

while (($line = fgetcsv($f, 4096, ';')) !== false) {
// skip first record and empty ones
$numcols = count($line);

$test[]=$line;

//echo $col = $line[0];
//echo $batchcount++.". ".$col."\n";


++$records;
}

fclose($f);
$records;
$total_debit = 0;
$total_credit = 0;
for($i=1;$i<sizeof($test);$i++)
{
$row_no=$i+1;
$r=explode(',',$test[$i][0]);
$wing = trim($r[0]);
$flat_number=trim($r[1]);
$flat_type=trim($r[2]);
$flat_area=trim($r[3]);

if(!empty($date)) 
{	
$ok=2;
} 
else
{
$ok=1; $error_msg[]="wing should not be empty in row".$row_no.".";	
break;
}
if(!empty($flat_number)) 
{
$ok=2;
if(is_numeric($flat_area))
{

}
else
{
$ok = 1;
$error_msg[]="flat number should be numeric in row".$row_no.".";	break;
}
}
else
{
$ok=1; $error_msg[]="flat number should not be empty in row".$row_no.".";
}
if(!empty($flat_type))
{
$ok=2;
}
else
{
$ok=1; $error_msg[]="flat type should not be empty in row".$row_no.".";	
}
if(!empty($flat_area))
{
$ok=2;
if(is_numeric($flat_area))
{

}
else
{
$ok = 1;
$error_msg[]="flat area should be numeric in row".$row_no.".";	break;
}
}
else
{
$ok=1; $error_msg[]="flat area should not be empty in row".$row_no.".";	
}






if(!empty($account_name)) 
{	$ok=2;

$this->loadmodel('ledger_account'); 
$conditions=array("ledger_name"=> new MongoRegex('/^' .  $account_name . '$/i'));
$result_ac=$this->ledger_account->find('all',array('conditions'=>$conditions));
$result_ac_count=sizeof($result_ac);


$this->loadmodel('ledger_sub_account'); 
$conditions=array("name"=> new MongoRegex('/^' .  $account_name . '$/i'));
$result_sac=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$result_sac_count=sizeof($result_sac);
if($result_ac_count>0)
{
$account_type_id = 2;
foreach($result_ac as $collection)
{
$account_id = (int)$collection['ledger_account']['auto_id'];
}
}
else if($result_sac_count>0)
{
$account_type_id = 1;
foreach($result_sac as $collection)
{
$account_id = (int)$collection['ledger_sub_account']['auto_id'];
}
}
else
{
$ok=1; $error_msg[]="No Account Name Match ".$row_no.".";	break;
}
}
else 
{ 
$ok=1; $error_msg[]="account name should not be empty in row ".$row_no.".";	break;
}
}
if($ok == 2)
{
if($total_debit == $total_credit)
{
$ok = 2; 
}
else
{
$ok = 1; $error_msg[]="Total Credit is not equal to Total debit";
}
}



$this->set('error_msg',@$error_msg);
$this->set('ok',$ok);


if($ok == 2)
{
$this->Session->write('test2', $test);
$nnn = 55;
$this->set('nnn',$nnn);
$this->set('test',$test);


for($i=1;$i<sizeof($test);$i++)
{
$row_no=$i+1;
$r=explode(',',$test[$i][0]);
$date2=trim($r[0]);

$account_name=trim($r[1]);
$amount_type=trim($r[2]);
$opening_balance=trim($r[3]);

$date1 = date("Y-m-d", strtotime($date2));
$date1 = new MongoDate(strtotime($date1));




$this->loadmodel('ledger_account'); 
$conditions=array("ledger_name"=> new MongoRegex('/^' .  $account_name . '$/i'));
$result_ac=$this->ledger_account->find('all',array('conditions'=>$conditions));
$result_ac_count=sizeof($result_ac);


$this->loadmodel('ledger_sub_account'); 
$conditions=array("name"=> new MongoRegex('/^' .  $account_name . '$/i'));
$result_sac=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$result_sac_count=sizeof($result_sac);


$cr_date = date("Y-m-d");
$cr_date = new MongoDate(strtotime($cr_date));

$u=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$this->ledger->saveAll(array("auto_id" => $u, "op_date" => $date1, 
"receipt_id" => "O_B","amount" => $opening_balance, "amount_category_id" => $amount_type_id, "module_id" => "O_B", "account_type" => $account_type_id,"account_id" => $account_id,"current_date" => $cr_date,"society_id" => $s_society_id));
$this->set('sucess','Csv Imported successfully.'); 
}
}
}
}
*/










////////// End Flat Import/////////////

///////////////////// End Flat Type ////////////////////////////////////////////////

///////////////////////// Start Flat No. Ajax (Accounts)////////////////////////////
function flat_no_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$flat_type_id = (int)$this->request->query('con');
$t = (int)$this->request->query('t2');
$this->set('t',$t);



$this->loadmodel('flat_type');
$conditions=array("society_id" => $s_society_id, "auto_id"=>$flat_type_id);
$cursor1 = $this->flat_type->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

}
///////////////////////// End Flat No. Ajax (Accounts)/////////////////////////////////////

/////////////// Start Flat Show Ajax ///////////////////////////////////////////////////////////
function flat_show_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$wing_id = (int)$this->request->query('con');
$t = (int)$this->request->query('t2');
$this->set('t',$t);
$this->set("wing_id",$wing_id);
$this->loadmodel('flat');
$conditions=array("society_id" => $s_society_id, "wing_id"=>$wing_id);
$cursor1 = $this->flat->find('all',array('conditions'=>$conditions));

$this->set('cursor1',$cursor1);

}
/////////////// End Flat Show Ajax ///////////////////////////////////////////////////////////

////////////////// Start Regular Bill Fetch2(Accounts)///////////////////////////
function regular_bill_fetch33($user_id) 
{
$s_society_id = (int)$this->Session->read('society_id');
$flat_id = (int)$user_id;
$this->loadmodel('new_regular_bill');
$order=array('new_regular_bill.bill_start_date'=> 'ASC');
$conditions=array("flat_id" => $user_id,"approval_status"=>1,"society_id"=>$s_society_id);
return $this->new_regular_bill->find('all',array('conditions'=>$conditions,'order'=>$order));
}
////////////////// End Regular Bill Fetch2(Accounts)//////////////////////////////



////////////////// Start Regular Bill Fetch2(Accounts)///////////////////////////
function regular_bill_fetch2($user_id) 
{
$this->loadmodel('regular_bill');
$conditions=array("bill_for_user" => $user_id);
return $this->regular_bill->find('all',array('conditions'=>$conditions));
}
////////////////// End Regular Bill Fetch2(Accounts)//////////////////////////////

////////////////// Start Flat type name fetch(Accounts)///////////////////////////
function flat_type_name_fetch($auto_id) 
{
$this->loadmodel('flat_type_name');
$conditions=array("auto_id" => $auto_id);
return $this->flat_type_name->find('all',array('conditions'=>$conditions));
}
////////////////// End Flat type name fetch(Accounts)//////////////////////////////

///////////////////////// Start user fetch2(Accounts)/////////////////////////////
function user_fetch2($flat_id) 
{
$s_society_id=(int)$this->Session->read('society_id');


$this->loadmodel('user');
$conditions=array("flat" => $flat_id,"society_id" => $s_society_id);
return $this->user->find('all',array('conditions'=>$conditions));
}
///////////////////////// End user fetch2(Accounts)/////////////////////////////////////

/////////////////////Start Financial Vali Ajax(Accounts)//////////////////////////////
function regular_vali()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$cc = (int)$this->request->query('ss');
$this->set('cc',$cc);

}
/////////////////////End Financial Vali Ajax(Accounts)//////////////////////////////

////////////////////// Start Supplimentry Vali (Accounts)////////////////////////////////
function supplimentry_vali()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$cc = (int)$this->request->query('ss');
$this->set('cc',$cc);
}
////////////////////// End Supplimentry Vali (Accounts)////////////////////////////////

/////////////////// Start Cash Bank Vali (Accounts) ////////////////////////////////////
function cash_bank_vali()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$cc = (int)$this->request->query('ss');
$this->set('cc',$cc);
}
/////////////////// End Cash Bank Vali (Accounts) ////////////////////////////////////////

////////////////////// Start it due tax (Accounts) //////////////////////////////////////

function it_due_tax()
{
$this->layout='session';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$this->loadmodel('bill_period');
$conditions=array("society_id" => $s_society_id,"status"=>1);
$cursor1 = $this->bill_period->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);


if(isset($this->request->data['taxp']))
{
$type = (int)$this->request->data['type'];
$per = (int)$this->request->data['tax_p'];

$cur_date = date('Y-m-d');
$cur_date = new MongoDate(strtotime($cur_date));

$this->loadmodel('bill_period');
$this->bill_period->updateAll(array('tax' => $per),array('auto_id' => $type,"society_id" => $s_society_id,"status"=>1));

}
}


////////////////////// End it due tax (Accounts) //////////////////////////////////////

////////////////// Start Due Tax (Accounts)///////////////////////////////////////////////
function due_tax_fetch() 
{
$s_society_id=(int)$this->Session->read('society_id');

$this->loadmodel('due_tax');
$conditions=array("society_id" => $s_society_id, "status" => 1);
return $this->due_tax->find('all',array('conditions'=>$conditions));
}
////////////////// End Due Tax Fetch2(Accounts)///////////////////////////////////////////

/////////////////////// Start Wing Fetch(Accounts) //////////////////////////////////
function wing_fetch($wing) 
{
$s_society_id = $this->Session->read('society_id');

$this->loadmodel('wing');
$conditions=array("wing_id" => $wing,"society_id"=>$s_society_id);
return $this->wing->find('all',array('conditions'=>$conditions));
}
/////////////////////// End Wing Fetch(Accounts)/////////////////////////////////////

/////////////////////// Start Flat Type Fetch(Accounts) ////////////////////////////
function flat_type_fetch2($tp) 
{
$s_society_id = $this->Session->read('society_id');

$this->loadmodel('flat_type');
$conditions=array("auto_id" => $tp,"society_id"=>$s_society_id);
return $this->flat_type->find('all',array('conditions'=>$conditions));
}
/////////////////////// End  Flat Type Fetch(Accounts)//////////////////////////////

/////////////////////// Start Flat Master Fetch (Accounts) ////////////////////////////
function flat_master_fetch2($flm) 
{
$s_society_id = $this->Session->read('society_id');

$this->loadmodel('flat_master');
$conditions=array("auto_id" => $flm,"society_id"=>$s_society_id);
return $this->flat_master->find('all',array('conditions'=>$conditions));
}
/////////////////////// End Flat Master Fetch (Accounts)//////////////////////////////

/////////////////////// Start bill Period Fetch Fetch (Accounts)/////////////////
function bill_period_fetch($auto_id) 
{
$s_society_id = $this->Session->read('society_id');

$this->loadmodel('bill_period');
$conditions=array("auto_id" => $auto_id,"society_id" => $s_society_id,"status"=>1);
return $this->bill_period->find('all',array('conditions'=>$conditions));
}
/////////////////////// End bill Period Fetch Fetch (Accounts)//////////////////////



//////////////// Start Income Head Fetch2(Accounts)/////////////////////////
function income_heads_fetch2() 
{
$s_society_id = $this->Session->read('society_id');

$this->loadmodel('income_head');
$conditions=array("society_id" => $s_society_id);
$order=array('income_head.auto_id'=> 'ASC');
return $this->income_head->find('all',array('conditions'=>$conditions,'order' =>$order));
}
/////////////////// End Income Head Fetch2(Accounts)////////////////////

///////////////////// Start Income Heads Fetch(Accounts)/////////////////////////
function income_head_fetch($auto_id) 
{
$this->loadmodel('income_head');
$conditions=array("auto_id" => $auto_id);
return $this->income_head->find('all',array('conditions'=>$conditions));
}

/////////////////////End Income Heads Fetch(Accounts)//////////////////////////

////////////////////// Start Flat master Fetch2 (Accounts)/////////////////////////
function flat_master_fetch3($flat_type_id)
{
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('flat_master');
$conditions=array("society_id" => $s_society_id, "flat_type_id" => $flat_type_id);
return $this->flat_master->find('all',array('conditions'=>$conditions));
}
////////////////////// End Flat Master Fetch2 (Accounts)///////////////////////////





///////////////////////////// Start add_ac_field //////////////////////////////////

function add_ac_field()
{
 $this->layout="session";
 $this->loadmodel('ledger_sub_account');	
 $result=$this->ledger_sub_account->find('all');
	
	foreach($result as $data)
	{
		 $user_id=(int)@$data['ledger_sub_account']['user_id'];
		if(!empty($user_id))
		{
			$this->loadmodel('ledger_sub_account');
			$this->ledger_sub_account->updateAll(array('deactive'=>0),array('user_id'=>$user_id));
		}
		
	}
	
}

////////////////////////////// End add_ac_field //////////////////////////////////





























//////////////////////////// Start Flat type edit ///////////////////////////////////////////////
function flat_type_edit()
{
$this->layout="session";
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');	

if(isset($this->request->data['update']))
{
$tp_id2 = (int)$this->request->data['tp'];

$area = array();
$this->loadmodel('flat');
$condition=array('society_id'=>$s_society_id,"status"=>0,"flat_type_id"=>$tp_id2);
$cursor = $this->flat->find('all',array('conditions'=>$condition)); 
foreach($cursor as $collection)
{
$flat_id = (int)$collection['flat']['flat_id'];
$area2 = (int)$this->request->data['area'.$flat_id];
//if(in_array($area2, $area))
//{
//$vali = "Flat Area Should not be Same";
//$nnn = 55;
//break;
//}
//else
//{
//$vali = "";
$nnn = 5;
$area[] = $area2;

}
if($nnn == 55)
{
$this->set('vali',$vali);
}
else
{
$x=0;
$this->loadmodel('flat');
$condition=array('society_id'=>$s_society_id,"status"=>0,"flat_type_id"=>$tp_id2);
$cursor = $this->flat->find('all',array('conditions'=>$condition)); 
foreach($cursor as $collection)
{
$auto_id2 = (int)$collection['flat']['flat_id'];
$area3 = $area[$x];
$this->loadmodel('flat');
$this->flat->updateAll(array('flat_area'=>$area3),array('flat_id'=>$auto_id2,"society_id"=>$s_society_id));
$x++;
}
?>


<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-header">
<center>
<h3 id="myModalLabel3" style="color:#999;"><b>Flat Type Update</b></h3>
</center>
</div>
<div class="modal-body">
<center>
<h3><b>Record Updated Successfully</b></h3>
</center>
</div>
<div class="modal-footer">
<a href="flat_type"   class="btn blue">OK</a>
</div>
</div>

<?php
}
}


$fl_tp_id = (int)$this->request->query('e');
$this->set('fl_tp_id',$fl_tp_id);

$this->loadmodel('flat_type_name');
$cursor1 = $this->flat_type_name->find('all'); 
$this->set('cursor1',$cursor1);

$this->loadmodel('flat');
$condition=array('society_id'=>$s_society_id,"status"=>0,"flat_type_id"=>$fl_tp_id);
$cursor2 = $this->flat->find('all',array('conditions'=>$condition)); 
$this->set('cursor2',$cursor2);

}
//////////////////////////// End Flat type edit ///////////////////////////////////////////////

////////////////////////////// Start Flat Excel ///////////////////////////////////////////////
function flat_excel()
{
$this->layout="";
$filename="Flat";
header ("Expires: 0");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls");
header ("Content-Description: Generated Report" );

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');	

$this->loadmodel('society');
$condition=array('society_id'=>$s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$condition)); 
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
$valllll = (int)@$collection['society']['area_scale'];
}

$excel="<table border='1'>
<tr>
<th colspan='6' style='text-align:center;'>$society_name</th></tr>
<tr>
<th>Sr No.</th>
<th>Wing</th>
<th>Unit Number</th>
<th>Unit Type</th>
<th>Unit Area"; if(@$vallll == 0) { $excel.="(Sq. Ft.)"; } else {  $excel.="(Sq. Mtr.)";  } $excel.="</th>
<th>Status</th>
</tr>";

$q = 0;
$this->loadmodel('flat');
$condition=array('society_id'=>$s_society_id);
$cursor = $this->flat->find('all',array('conditions'=>$condition)); 
foreach($cursor as $collection)
{
$q++;						
$wing_id = (int)$collection['flat']['wing_id'];
$flat_name = $collection['flat']['flat_name'];
$flat_type_id = (int)@$collection['flat']['flat_type_id'];
$sqfeet = (int)@$collection['flat']['flat_area'];
$noc_type = (int)@$collection['flat']['noc_ch_tp'];


$wing_fetch = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_fetch'),array('pass'=>array($wing_id)));	
foreach($wing_fetch as $collection)
{							
$wing_name = $collection['wing']['wing_name'];							
}

$fl_tp = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_type_name_fetch'),array('pass'=>array($flat_type_id)));		
foreach($fl_tp as $collection)
{
$flat_type = @$collection['flat_type_name']['flat_name'];
}

if($noc_type == 1)
{
$noc_type_name="Self Occupied";
}
else if($noc_type == 2)
{
$noc_type_name="Leased";
}

$excel.="<tr>
<td>$q</td>
<td>$wing_name</td>
<td>$flat_name</td>
<td>";
if($sqfeet == 0) { $excel.="null"; } else { $excel.="$flat_type"; } $excel.="</td>
<td>";
if($sqfeet == 0) { $excel.="null"; } else { $excel.="$sqfeet"; } $excel.="</td><td>";
if($noc_type == 0) { $excel.="not defined"; } else { $excel.="$noc_type_name"; } $excel.="</td>";
$excel.="</tr>";
}
$excel.="</table>";


echo $excel;
}
/////////////////////////// End Flat Excel/////////////////////////////////////////////////////////

//////////////////////// Start Flat Nu Import ///////////////////////////////////////////////////////
function flat_nu_import()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}
$this->ath();
$s_society_id=(int)$this->Session->read('society_id');


if($this->request->is('post')) 
{
$array1 = array();
$array2 = array();

$file=$this->request->form['file']['name'];
$dir='C:\xampp\htdocs\cakephp\app\webroot\csv_file';
$target = "csv_file/";
$target=@$target.basename( @$this->request->form['file']['name']);
$ok=1;
move_uploaded_file(@$this->request->form['file']['tmp_name'],@$target);

$f = fopen('csv_file/'.$file, 'r') or die("ERROR OPENING DATA");
$batchcount=0;
$records=0;
while (($line = fgetcsv($f, 4096, ';')) !== false) {
$numcols = count($line);
$test[]=$line;
++$records;
}

fclose($f);
$records;
$total_debit = 0;
$total_credit = 0;
$arr[] = array('0','0');
for($i=1;$i<sizeof($test);$i++)
{
$row_no=$i+1;
$r=explode(',',$test[$i][0]);
$wing_name = trim($r[0]);
$flat_number = trim($r[1]);
$flat_type = trim($r[2]);
$flat_area = trim($r[3]);

$count2 = 0;
$count1 = 0;

if(!empty($wing_name)) 
{	
$ok=2; 
}
else 
{ 
$ok=1; $error_msg[]="Wing should not be empty in row ".$row_no.".";	break;
}
if(!empty($flat_number))
{
$ok=2; 
if(is_numeric($flat_number))
{

}
else
{
$ok = 1;
$error_msg[]="flat number should be numeric in row".$row_no.".";	break;
}
}
else 
{ 
$ok=1; $error_msg[]="Flat Number should not be empty in row ".$row_no.".";	
break;
}

if(!empty($flat_type))
{
$ok=2; 
}
else{ $ok=1; $error_msg[]="Flat Type should not be empty in row ".$row_no.".";	break;}
if(!empty($flat_area))
{
$ok=2; 
if(is_numeric($flat_area))
{

}
else
{
$ok = 1;
$error_msg[]="flat area should be numeric".$row_no.".";	break;
}
}
else 
{ 
$ok=1; $error_msg[]="Flat Area should not be empty in row ".$row_no.".";	break;
}

$this->loadmodel('wing');
$condition=array('society_id'=>$s_society_id);
$cursor = $this->wing->find('all',array('conditions'=>$condition)); 
foreach($cursor as $collection)
{
$wing_name_flat = $collection['wing']['wing_name'];
if(strcasecmp($wing_name_flat,$wing_name) == 0);
{
$count1=5;
break;
}
}
$this->loadmodel('flat');
$condition=array('society_id'=>$s_society_id,"flat_name"=>$flat_number);
$cursor = $this->flat->find('all',array('conditions'=>$condition)); 
foreach($cursor as $collection)
{
$count2 = 5;
}
if($count2 == 5 and $count1 == 5)
{
$ok=1; $error_msg[]="same wing and flat exist please select another wing or flat".$row_no.".";	break;
}

for($s=0; $s<sizeof(@$array2); $s++)
{
$arr_wing = $array2[$s];
$arr_flat_num = $array1[$s];
if($arr_wing == $wing_name and $flat_number == $arr_flat_num)
{
$ok=1; $error_msg[]="repeatation of same wing and flat".$row_no.".";	break;
}
}
$array2[]= $wing_name;
$array1[]= $flat_number;
}


$this->set('error_msg',@$error_msg);
$this->set('ok',$ok);

if($ok == 2)
{
for($i=1;$i<sizeof($test);$i++)
{
$nnn = 5;
$row_no=$i+1;
$r=explode(',',$test[$i][0]);
$wing_name = trim($r[0]);
$flat_number = trim($r[1]);
$flat_type = trim($r[2]);
$flat_area = trim($r[3]);

$this->loadmodel('wing');
$condition=array('society_id'=>$s_society_id);
$cursor = $this->wing->find('all',array('conditions'=>$condition)); 
foreach($cursor as $collection)
{
$wing_id = (int)$collection['wing']['wing_id'];
$str1 = $collection['wing']['wing_name'];
if (strcasecmp($str1, $wing_name) == 0) 
{
$wing = (int)$wing_id;
}
}

$this->loadmodel('flat_type_name');
$cursor = $this->flat_type_name->find('all'); 
foreach($cursor as $collection)
{
$fl_tp_id = (int)$collection['flat_type_name']['auto_id'];
$fl_name = $collection['flat_type_name']['flat_name'];
if (strcasecmp($fl_name, $flat_type) == 0) 
{
$flat_type_id = (int)$fl_tp_id;
}
}

$this->loadmodel('flat_type');
$condition=array('society_id'=>$s_society_id);
$cursor = $this->flat_type->find('all',array('conditions'=>$condition)); 
foreach($cursor as $collection)
{
$flat_type_id2 = (int)$collection['flat_type']['flat_type_id'];
$no_of_flat = $collection['flat_type']['number_of_flat'];
if($flat_type_id2 == $flat_type_id)
{
$nnn = 55;
$no_of_flat++;
$this->loadmodel('flat_type');
$this->flat_type->updateAll(array('number_of_flat' => $no_of_flat),array('flat_type_id' => $flat_type_id2,"society_id"=>$s_society_id));
}
}
if($nnn == 5)
{
$x=$this->autoincrement('flat_type','auto_id');
$this->loadmodel('flat_type');
$this->flat_type->saveAll(array("auto_id" => $x,"flat_type_id"=>$flat_type_id,"society_id"=>$s_society_id,"number_of_flat"=>1,"status"=>1));
}

$z = $this->autoincrement('flat','flat_id');
$this->loadmodel('flat');
$this->flat->saveAll(array("flat_id" => $z,"wing_id"=>$wing,"flat_name"=>$flat_number,"society_id"=>$s_society_id,"flat_type_id"=>$flat_type_id,"flat_area"=>$flat_area));
$this->set('sucess','Csv Imported successfully.'); 
}
}
}
}
//////////////////////// End Flat Nu Import ///////////////////////////////////////////////////////

////////////////////// Start Accounts Category Excel HM/////////////////////////////////////////////////
function accounts_category_excel_hm()
{
$this->layout="";
$filename="Accounts Category";
header ("Expires: 0");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls");
header ("Content-Description: Generated Report" );

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');	


$excel="<table border='1'>
<tr>
<th style='text-align:center;' colspan='2'>Accounts Category</th>
</tr>
<tr>
<th style='text-align:left;'>Sr. No.</th>
<th style='text-align:left;'>Accounts Category</th>
</tr>";
$n = 1;
$this->loadmodel('accounts_category');
$conditions=array("delete_id" => 0);
$cursor = $this->accounts_category->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$name = $collection['accounts_category']['category_name'];
$auto_id = (int)$collection['accounts_category']['auto_id'];
$excel.="<tr>
<td style='text-align:left;'>$n</td>
<td style='text-align:left;'>$name</td>";
$n++;
}
$excel.="</table>";


echo $excel;
}
////////////////////// End Accounts Category Excel HM/////////////////////////////////////////////////

///////////////////////// Start accounts gruo excel hm ////////////////////////////////////////////////
function accounts_group_excel_hm()
{
$this->layout="";
$filename="Accounts Group";
header ("Expires: 0");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls");
header ("Content-Description: Generated Report" );

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');	

$excel="<table border='1'>
<tr>
<th colspan='2' style='text-align:center;'>Accounts Group</th>
</tr>
<tr>
<th style='text-align:left;'>Sr. No.</th>
<th style='text-align:left;'>Accounts Group</th>
</tr>";
$n = 1;
$this->loadmodel('accounts_group');
$conditions=array("delete_id" => 0);
$cursor = $this->accounts_group->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$name = $collection['accounts_group']['group_name'];
$auto_id = (int)$collection['accounts_group']['auto_id'];

$excel.="
<tr>
<td style='text-align:left;'>$n</td>
<td style='text-align:left;'>$name</td>
</tr>
";
}
$excel.="</table>";

echo $excel;
}
///////////////////////// End accounts gruo excel hm //////////////////////////////////////////////////

/////////////////////// Start Ledger Account Excel Hm ///////////////////////////////////////////////////
function ledger_account_excel_hm()
{
$this->layout="";
$filename="Ledger Accounts";
header ("Expires: 0");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls");
header ("Content-Description: Generated Report" );

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');	

$excel="<table border='1'>
<tr>
<th colspan='4'>Ledger Accounts</th>
</tr>
<tr>
<th style='text-align:left;'>Sr. No.</th>
<th style='text-align:left;'>Accounts Category</th>
<th style='text-align:left;'>Accounts Group</th>
<th style='text-align:left;'>Ledger Accounts</th>
</tr>";
$n = 1;
$this->loadmodel('ledger_account');
$conditions=array("delete_id" => 0);
$cursor = $this->ledger_account->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$auto_id5 = (int)$collection['ledger_account']['auto_id'];
$sub_id = (int)$collection['ledger_account']['group_id'];
$name = $collection['ledger_account']['ledger_name'];
$edit_id = (int)$collection['ledger_account']['edit_user_id'];

$result_ag = $this->requestAction(array('controller' => 'hms', 'action' => 'accounts_group'),array('pass'=>array($sub_id)));
foreach ($result_ag as $collection) 
{
$accounts_id = (int)$collection['accounts_group']['accounts_id'];	
$group_name = $collection['accounts_group']['group_name'];	
}

$result_ac = $this->requestAction(array('controller' => 'hms', 'action' => 'accounts_category'),array('pass'=>array($accounts_id)));		   
foreach ($result_ac as $collection) 
{
$main_name = $collection['accounts_category']['category_name'];	
}
$excel.="<tr>
<td style='text-align:left;'>$n</td>
<td style='text-align:left;'>$main_name</td>
<td style='text-align:left;'>$group_name</td>
<td style='text-align:left;'>$name</td>
</tr>";
$n++;
}	
$excel.="</table>";

echo $excel;

}
/////////////////////// End Ledger Account Excel Hm ///////////////////////////////////////////////////

/////////////////////////// Start Nov View2 ///////////////////////////////////////////////////////////
function noc_view2()
{
$this->layout="session";
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');

$show_arr2 = $this->request->query('arr');
$this->set("show_arr2",$show_arr2);

if(isset($this->request->data['sub']))
{
$this->loadmodel('flat_type');
$order=array('flat_type.auto_id'=>'ASC');
$condition=array('society_id'=>$s_society_id);
$cursor1 = $this->flat_type->find('all',array('conditions'=>$condition,'order' => $order)); 
foreach($cursor1 as $collection)
{
$auto_id1 = (int)$collection['flat_type']['auto_id'];
$type_id = (int)$this->request->data['tp'.$auto_id1];
if($type_id == 4)
{
$arr = array($type_id);
}
else
{
$amt = $this->request->data['amt'.$auto_id1];
$arr = array($type_id,$amt);
}

$this->loadmodel('flat_type');
$this->flat_type->updateAll(array('noc_charge' => $arr),array('auto_id' => $auto_id1));
}
$this->response->header('Location', 'master_noc_view');
}

$this->loadmodel('flat_type');
$order=array('flat_type.auto_id'=>'ASC');
$condition=array('society_id'=>$s_society_id);
$cursor1 = $this->flat_type->find('all',array('conditions'=>$condition,'order' => $order)); 
$this->set('cursor1',$cursor1);
}
/////////////////////////// End Nov View2 ///////////////////////////////////////////////////////////


function update_wing_flat()
{
	$this->layout="session";
	$s_society_id = (int)$this->Session->read('society_id');
	
	/*$this->loadmodel('user');
	$result_user_acc=$this->user->find('all',array('conditions'=>array('society_id'=>$s_society_id),'role_id' =>array('$in' => array(2))));
	foreach($result_user_acc as $data_acc)
	{
		$user_name=$data_acc["user"]["user_name"];
		$user_id=$data_acc["user"]["user_id"];
		$deactive=$data_acc["user"]["deactive"];
		
		$this->loadmodel('ledger_sub_account');
		$k=$this->autoincrement('ledger_sub_account','auto_id');
		$this->ledger_sub_account->saveAll(array("auto_id" => $k, "ledger_id" =>34, 'name'=>$user_name,"society_id" => $s_society_id,"deactive" => $deactive,"user_id" => $user_id));
	}*/
	
	
	if(isset($this->request->data['update']))
	{
		$user=(int)$this->request->data['user'];
		$wing=(int)$this->request->data['wing'];
		$flat=(int)$this->request->data['flat'];
		
		$this->loadmodel('user');
		$this->user->updateAll(array('wing'=>$wing,'flat'=>$flat),array('user_id'=>$user));
		
	}
	
	$this->loadmodel('user');
	$this->set('result_user',$this->user->find('all',array('conditions'=>array('society_id'=>$s_society_id))));
	
	$this->loadmodel('wing');
	$this->set('result_wing',$this->wing->find('all',array('conditions'=>array('society_id'=>$s_society_id))));
}

function update_wing_flat_ajax()
{
	$this->layout="blank";
	$w=(int)$this->request->query('w');
	$s_society_id = (int)$this->Session->read('society_id');
	$this->loadmodel('flat');
	$this->set('result_flat',$this->flat->find('all',array('conditions'=>array('wing_id'=>$w))));
}

function family_member_valid()
{

$this->layout='blank';
$q=$this->request->query('q');
 $q = html_entity_decode($q);
 $myArray = json_decode($q, true);

$s_society_id=$this->Session->read('society_id'); 
$s_role_id=$this->Session->read('role_id');
$s_user_id=$this->Session->read('user_id');
	

			date_default_timezone_set('Asia/kolkata');
			$date=date("d-m-Y");
			$time=date('h:i:a',time());
    $this->loadmodel('user');
	$conditions=array('user_id'=>$s_user_id);
	$result=$this->user->find('all',array('conditions'=>$conditions));
	foreach($result as $data)
	{
	$tenant=(int)$data['user']['tenant'];
	$user_name_by=$data['user']['user_name'];
	$wing=(int)$data['user']['wing'];
	$flat=(int)$data['user']['flat'];
	

	}
	@$wing_flat=$this->wing_flat($wing,$flat);
	$result_society=$this->society_name($s_society_id);	
	foreach($result_society as $data)
	{
	  $society_name=$data['society']['society_name'];
	  @$family_member=$data['society']['family_member'];
	  @$family_member_tenant=$data['society']['family_member_tenant'];
	  
	}

	
	$s_n='';
	$sco_na=$society_name;
	$dd=explode(' ',$sco_na);
	$first=$dd[0];
	@$two=$dd[1];
	@$three=$dd[2];
	$s_n.=" $first $two $three ";

foreach($myArray as $child){
	
	
	if(empty($child[0])){
		$output = json_encode(array('type'=>'error', 'text' => 'Please enter a name'));
        die($output);
	}
	
	
	if (!filter_var($child[4], FILTER_VALIDATE_EMAIL) && !empty($child[4])) {
	  $output = json_encode(array('type'=>'error', 'text' => 'Invalid email format'));
        die($output);
	}elseif(!empty($child[4])){
		$this->loadmodel('user_temp');
		$conditions=array("email" => $child[4],'reject'=>0);
		$result3 = $this->user_temp->find('all',array('conditions'=>$conditions));
		$n3 = sizeof($result3);
		$this->loadmodel('user');
		$conditions=array("email" => $child[4]);
		$result4 = $this->user->find('all',array('conditions'=>$conditions));
		$n4 = sizeof($result4);
		$e=$n3+$n4;
		if ($e > 0) {
			$output = json_encode(array('type'=>'error', 'text' => 'Email already exist.'));
			die($output);
		}
	}
	
	if (!preg_match ( '/^\\d{10}$/',$child[5]) && !empty($child[5])) {
	  $output = json_encode(array('type'=>'error', 'text' => 'Invalid mobile format'));
        die($output);
	}elseif(!empty($child[5])){
		$this->loadmodel('user_temp');
		$conditions=array("mobile" => $child[5],'reject'=>0);
		$result3 = $this->user_temp->find('all',array('conditions'=>$conditions));
		$n3 = sizeof($result3);
		$this->loadmodel('user');
		$conditions=array("mobile" => $child[5]);
		$result4 = $this->user->find('all',array('conditions'=>$conditions));
		$n4 = sizeof($result4);
		$e=$n3+$n4;
		if ($e > 0) {
			$output = json_encode(array('type'=>'error', 'text' => 'Mobile already exist.'));
			die($output);
		}
	}
	
	
	
	
	if(empty($child[1])){
		$output = json_encode(array('type'=>'error', 'text' => 'Please select age group'));
        die($output);
	}
	
	/*if(!empty($child[1]) && $child[1]< 13){
		
		$output = json_encode(array('type'=>'error', 'text' => 'Your age should be above 13'));
        die($output);
		
	}*/
	if(empty($child[3])){
		$output = json_encode(array('type'=>'error', 'text' => 'Please enter a relation'));
        die($output);
	}
	
	
	
	if (!empty($child[4])) {
	  $email_addrs1[]=$child[4];
	  $email_addrs2[]=$child[4];
	}
	if (!empty($child[5])) {
	  $mobile_no1[]=$child[5];
	  $mobile_no2[]=$child[5];
	}
	
	
	
	
	
}

if((sizeof(@$email_addrs1)>0) && (sizeof(@$email_addrs2)>0)){
	$email_addrs1 = array_unique($email_addrs1);
	if(sizeof(@$email_addrs1)!=sizeof(@$email_addrs2)){
	$output = json_encode(array('type'=>'error', 'text' => 'Email should not be same in two or more rows.'));
        die($output);
}
}

if((sizeof(@$mobile_no1)>0) && (sizeof(@$mobile_no2)>0)){
	$mobile_no1 = array_unique($mobile_no1);
	if(sizeof(@$mobile_no1)!=sizeof(@$mobile_no2)){
	$output = json_encode(array('type'=>'error', 'text' => 'mobile should not be same in two or more rows.'));
        die($output);
}
}

if($tenant==1){
		$type="owner";
	}
	if($tenant==2){
		$type="tenant";
	}

 
if(($type=="owner" && $family_member==1) || ($type=="tenant" && $family_member_tenant==1))
{
	$ip=$this->hms_email_ip();


		foreach($myArray as $child)
		{
			$name=$child[0];
			$email=$child[4];
			$mobile=$child[5];
			$dob=$child[1];
			$relation=$child[3];
			$blood_group=$child[2];
			$gender=$child[6];
			
			$this->loadmodel('user');	
			$i=$this->autoincrement('user','user_id');	
			$random1=mt_rand(1000000000,9999999999);
			$random2=mt_rand(1000000000,9999999999);
			$random=$random1.$random2 ;	
			$de_user_id=$this->encode($i,'housingmatters');
			$random=$de_user_id.'/'.$random;
			$log_i=$this->autoincrement('login','login_id');

				if(!empty($mobile) && empty($email))
				{
					$r_sms=$this->hms_sms_ip();
					$working_key=$r_sms->working_key;
					$sms_sender=$r_sms->sms_sender; 
					$sms_allow=(int)$r_sms->sms_allow;
					
					$login_user=$mobile;
					$random=(string)mt_rand(1000,9999);
					if($sms_allow==1){
					$sms="".$name.", Your housing society ".$s_n." has enrolled you in HousingMatters portal. Pls log into www.housingmatters.co.in One Time Password ".$random."";
					$sms1=str_replace(" ", '+', $sms);
					$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms1.'');
					}
				}

			
			
		  			
			////////////////////////// insert user table //////////////////////////
$role_id[]=4;
$this->user->saveAll(array('user_id' => $i, 'user_name' => $name,'email' => $email, 'password' =>$random, 'mobile' => $mobile,  'society_id' => $s_society_id, 'tenant' => $tenant, 'wing' => $wing, 'flat' => $flat,'date' => $date, 'time' => $time,"profile_pic"=>'blank.jpg','sex'=>$gender,'role_id'=>$role_id,'default_role_id'=>4,'signup_random'=>$random,'family_member'=>$s_user_id,'dob'=>$dob,'relation'=>$relation,'login_id'=>$log_i,'s_default'=>1,'blood_group'=>$blood_group,'deactive'=>0,'profile_status'=>1));

			////////////////////// End user table ///////////////////////////////////////////////////

$user_flat_id=$this->autoincrement('user_flat','user_flat_id');
$this->user_flat->saveAll(array('user_flat_id'=>$user_flat_id,'user_id'=>$i,'society_id'=>$s_society_id,'flat_id'=>$flat,'status'=>$tenant,'active'=>0,'exit_date'=>'','time'=>'','family_member'=>1));
unset($role_id); 
if(!empty($email) && !empty($mobile))
		{
			$login_user=$email;	

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
										<span style="color:rgb(100,100,99)" align="justify"> Dear '.$name.', </span> 
										</td>
																
								</tr>
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span style="color:rgb(100,100,99)" align="justify">As a family member, you have been added to '.$society_name.' online portal by '.$user_name_by.' '.@$wing_flat.' </span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										 We at '.$society_name.' use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.
										
										
										
										
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										As you are an owner/resident/staff of '.$society_name.', we have added your email address in HousingMatters portal.
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
												Here are some of the important features related to our portal on HousingMatters:
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
												You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.
										</td>
																
								</tr>

									<tr>
									<td style="padding:5px;" width="100%" align="left">
									You can receive important SMS & emails from your committee.
									</td>

									</tr>
								<tr>
										<td style="padding:5px;" width="100%" align="left"><br/>
											<span  align="justify"> <b>
											<a href="'.$ip.$this->webroot.'hms/send_sms_for_verify_mobile?q='.$random.'"> Click here </a> for one time verification of your mobile number and Login into HousingMatters for making life simpler for all your housing matters!</b>
											</span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span align="justify"> Pls add www.housingmatters.in in your favorite bookmarks for future use. </span> 
										</td>
																
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span > 
												Regards,<br/>
												Administrator of '.$society_name.'<br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';
			
		}
			
			
		if(!empty($email) && empty($mobile))
		{
			$login_user=$email;	
			
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
										<span style="color:rgb(100,100,99)" align="justify"> Dear '.$name.', </span> 
										</td>
																
								</tr>
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span style="color:rgb(100,100,99)" align="justify">As a family member, you have been added to '.$society_name.' online portal by '.$user_name_by.' '.@$wing_flat.' </span> 
										</td>
																
								</tr>
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										 We at '.$society_name.' use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.
										
										
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										As you are an owner/resident/staff of '.$society_name.', we have added your email address in HousingMatters portal.
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
												Here are some of the important features related to our portal on HousingMatters:
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
												You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.
										</td>
																
								</tr>

									<tr>
									<td style="padding:5px;" width="100%" align="left">
									You can receive important SMS & emails from your committee.
									</td>

									</tr>
								<tr>
										<td style="padding:5px;" width="100%" align="left"><br/>
											<span  align="justify"> <b>
											<a href="'.$ip.$this->webroot.'hms/set_new_password?q='.$random.'"> Click here </a> for one time verification of your email and Login into HousingMatters for making life simpler for all your housing matters!</b>
											</span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span align="justify"> Pls add www.housingmatters.in in your favorite bookmarks for future use. </span> 
										</td>
																
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span > 
												Regards,<br/>
												Administrator of '.$society_name.'<br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';
			
			
		}
			
			
		
			
			$from_name="HousingMatters";
			$reply="support@housingmatters.in";
			$to=$email;
			$this->loadmodel('email');
			$conditions=array("auto_id" => 4);
			$result_email = $this->email->find('all',array('conditions'=>$conditions));
			foreach ($result_email as $collection) 
			{
			$from=$collection['email']['from'];
			}
			$subject="Welcome to ".$society_name." portal ";
			if(!empty($email))
			{
			$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
			}

			
			////////////////////////////////// insert login table /////////////////////////////////////

$this->loadmodel('login');
$this->login->saveAll(array('login_id'=>$log_i,'user_name'=>$login_user,'password'=>$random,'signup_random'=>$random,'mobile'=>$mobile));

			/////////////////////////  End login table /////////////////////////////////////////

			
			////////////////Notification email user all checked code  //////////////////////////
				$this->loadmodel('email');	
				$conditions=array('notification_id'=>1);
				$result_email=$this->email->find('all',array('conditions'=>$conditions));
				foreach($result_email as $data)
				{
				$auto_id = (int)$data['email']['auto_id'];
				$this->loadmodel('notification_email');
				$lo=$this->autoincrement('notification_email','notification_id');
				$this->notification_email->saveAll(array("notification_id" => $lo, "module_id" => $auto_id , "user_id" => $i,'chk_status'=>0));
				}

				//////////////// End all checked code   //////////////////////////
			
			
			

		}
				
		$output = json_encode(array('type'=>'add_tr', 'text' => 'Your family member will get further communication to complete their enrollment process.'));
		die($output);



}
else
{
	
	
	$output = json_encode(array('type'=>'sucess', 'text' => 'Administrator has not allowed family member login into the portal.'));
    die($output);
	
}



}
///////////////////////////////// Start Check Email Already Exist /////////////////////////////////////////////
function check_email_already_exist()
{
$this->layout='blank';
$q=$this->request->query('q'); 

$s_society_id=$this->Session->read('society_id');

$res_society=$this->society_name($s_society_id);
foreach($res_society as $data)
{
 $society_name=$data['society']['society_name'];

}
$s_n='';
$sco_na=$society_name;
$dd=explode(' ',$sco_na);
 $first=$dd[0];
 @$two=$dd[1];
 @$three=$dd[2];
 $s_n.=" $first $two $three ";

 date_default_timezone_set('Asia/kolkata');
 $date=date("d-m-Y");
 $time=date('h:i:a',time());





$myArray = json_decode($q, true);
$c=0;
$report=array();

foreach($myArray as $child){
	$c++;
	
	
	if(empty($child[0])){
		$report[]=array('tr'=>$c,'td'=>1, 'text' => 'Required');
	}
	if(empty($child[1])){
        $report[]=array('tr'=>$c,'td'=>2, 'text' => 'Required');
	}
	if(empty($child[2])){
        $report[]=array('tr'=>$c,'td'=>3, 'text' => 'Required');
	}
	if (!filter_var($child[3], FILTER_VALIDATE_EMAIL) && !empty($child[3])) {
		$report[]=array('tr'=>$c,'td'=>4, 'text' => 'Invalid');
	}elseif(!empty($child[3])){
		$this->loadmodel('user_temp');
		$conditions=array("email" => $child[3],'reject'=>0);
		$result3 = $this->user_temp->find('all',array('conditions'=>$conditions));
		$n3 = sizeof($result3);
		$this->loadmodel('user');
		$conditions=array("email" => $child[3]);
		$result4 = $this->user->find('all',array('conditions'=>$conditions));
		$n4 = sizeof($result4);
		$e=$n3+$n4;
		if ($e > 0) {
			$report[]=array('tr'=>$c,'td'=>4, 'text' => 'already exist');
		}
	}
	if (!preg_match ( '/^\\d{10}$/',$child[4]) && !empty($child[4])) {
		$report[]=array('tr'=>$c,'td'=>5, 'text' => 'Invalid');
	}elseif(!empty($child[4])){
		$this->loadmodel('user_temp');
		$conditions=array("mobile" => $child[4],'reject'=>0);
		$result3 = $this->user_temp->find('all',array('conditions'=>$conditions));
		$n3 = sizeof($result3);
		$this->loadmodel('user');
		$conditions=array("mobile" => $child[4],'user_id'=>array('$ne'=>1));
		$result4 = $this->user->find('all',array('conditions'=>$conditions));
		$n4 = sizeof($result4);
		$e=$n3+$n4;
		if ($e > 0) {
			$report[]=array('tr'=>$c,'td'=>5, 'text' => 'already exist');
		}
	}
	if (empty($child[5])) {
		$report[]=array('tr'=>$c,'td'=>6, 'text' => 'Required');
	}else{
			if ($child[5]==1){
					if (empty($child[6])){
						$report[]=array('tr'=>$c,'td'=>7, 'text' => 'Required');
					}
					
					/*if (empty($child[7])) {
						$report[]=array('tr'=>$c,'td'=>8, 'text' => 'Required');
					}*/
			}
	}
	
	if(!empty($child[2])) {
		
		$this->loadmodel('user_flat');
		$conditions=array("flat_id" => (int)$child[2],'active'=>0,'family_member'=>array('$ne'=>1));
		$result4 = $this->user_flat->find('all',array('conditions'=>$conditions));
		
		
		 $n4 = sizeof($result4); 
		if($n4==1){
			
			$tenant=$result4[0]['user_flat']['status'];
			if($tenant==1){
				if($tenant==(int)$child[5]){
					
				 $report[]=array('tr'=>$c,'td'=>3, 'text' => 'already exist owner');	
					
				}
				
				
			}else{
				
				if($tenant==(int)$child[5]){
					
				 $report[]=array('tr'=>$c,'td'=>3, 'text' => 'already exist tenant');	
					
				}
				
				
				
			}
			
			
		}
			if($n4==2){	
			$report[]=array('tr'=>$c,'td'=>3, 'text' => 'already exist');
			
			}
		
		}
	
	
	if(!empty($child[2])) {
		
		
			$flat_id1[]=$child[2];
			 $flat_id2[]=$child[2];
	}
	
		
	
/*	if((sizeof(@$flat_id1)>1) && (sizeof(@$flat_id2)>1)){
	$flat_id1 = array_unique($flat_id1);
	if(sizeof(@$flat_id1)!=sizeof(@$flat_id2)){
	$output = json_encode(array('report_type'=>'already_error', 'text' => 'Flat should not be same in two or more rows.'));
        die($output);
		}
	  } */
	
	if (!empty($child[3])) {
	  $email_addrs1[]=$child[3];
	  $email_addrs2[]=$child[3];
	}
	if (!empty($child[4])) {
	  $mobile_no1[]=$child[4];
	  $mobile_no2[]=$child[4];
	}
	
	
	if((sizeof(@$email_addrs1)>0) && (sizeof(@$email_addrs2)>0)){
	$email_addrs1 = array_unique($email_addrs1);
	if(sizeof(@$email_addrs1)!=sizeof(@$email_addrs2)){
	$output = json_encode(array('report_type'=>'already_error', 'text' => 'Email should not be same in two or more rows.'));
        die($output);
		}
	  }
if((sizeof(@$mobile_no1)>0) && (sizeof(@$mobile_no2)>0)){
	$mobile_no1 = array_unique($mobile_no1);
	if(sizeof(@$mobile_no1)!=sizeof(@$mobile_no2)){
	$output = json_encode(array('report_type'=>'already_error', 'text' => 'mobile should not be same in two or more rows.'));
        die($output);
		}
	 }
$owner_tenant_set[]=$child[2].'-'.$child[5];
}

if(sizeof($report)>0){
	$output=json_encode(array('report_type'=>'error','report'=>$report));
	die($output);
}

$owner_tenant_set=array_count_values($owner_tenant_set);
foreach($owner_tenant_set as $data){
		if($data>=2){
			
			$output = json_encode(array('report_type'=>'already_error', 'text' => 'Flat should not be same owner and tenant in two or more rows.'));
			die($output);
		}
	}


/*------code here insert start -------*/

$ip=$this->hms_email_ip();
foreach($myArray as $child)
{
	$name=$child[0];
	$email=$child[3];
	$mobile=$child[4];
	$wing=(int)$child[1];
	$flat=(int)$child[2];
	$residing=(int)$child[7];
	$tenant=(int)$child[5];

	if($tenant==1)
	{
	 $committee=(int)$child[6];
	}
	else
	{
	 $committee=2;
	}

	$role_id[]=2;
	$default_role_id=2;
	if($committee==1)
	{
	$role_id[]=1;
	}



	$this->loadmodel('user');
	$i=$this->autoincrement('user','user_id');
	$log_i=$this->autoincrement('login','login_id');

	$random1=mt_rand(1000000000,9999999999);
	$random2=mt_rand(1000000000,9999999999);
	$random=$random1.$random2 ;	
	$de_user_id=$this->encode($i,'housingmatters');
	$random=$de_user_id.'/'.$random;
	

		if(!empty($mobile) && empty($email))
		{
			$r_sms=$this->hms_sms_ip();
			$working_key=$r_sms->working_key;
			$sms_sender=$r_sms->sms_sender;
			$sms_allow=(int)$r_sms->sms_allow;

		$login_user=$mobile;
		$random=(string)mt_rand(1000,9999);
		if($sms_allow==1){
			
			$user_name_short=$this->check_charecter_name($name);
			$sms="".$user_name_short.", Your housing society ".$s_n." has enrolled you in HousingMatters portal. Pls log into www.housingmatters.co.in One Time Password ".$random."";
			$sms1=str_replace(" ", '+', $sms);
			$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms1.'');
			}
		}

		/////////// insert code user table ///////////////////////
		
		$this->user->saveAll(array('user_id' => $i, 'user_name' => $name,'email' => $email, 'password' => @$random, 'mobile' => $mobile,  'society_id' => $s_society_id, 'tenant' => $tenant, 'wing' => $wing, 'flat' => $flat, 'date' => $date, 'time' => $time,"profile_pic"=>'blank.jpg','sex'=>'','role_id'=>$role_id,'default_role_id'=>$default_role_id,'signup_random'=>$random,'deactive'=>0,'login_id'=>$log_i,'s_default'=>1,'profile_status'=>1,'private'=>array('mobile','email')));
	      ///////////  code end insert //////////////////////////////////
         // $this->loadmodel('flat');
         // $this->flat->updateAll(array("noc_ch_tp" =>$residing),array("flat_id" =>$flat));

			$user_flat_id=$this->autoincrement('user_flat','user_flat_id');
			$this->user_flat->saveAll(array('user_flat_id'=>$user_flat_id,'user_id'=>$i,'society_id'=>$s_society_id,'flat_id'=>$flat,'status'=>$tenant,'active'=>0,'exit_date'=>'','time'=>''));
		 
	      ///////////////  Insert code ledger Sub Accounts //////////////////////
			if($tenant==1){
			$this->loadmodel('ledger_sub_account');
			$j=$this->autoincrement('ledger_sub_account','auto_id');
			$this->ledger_sub_account->saveAll(array('auto_id'=>$j,'ledger_id'=>34,'name'=>$name,'society_id' => $s_society_id,'user_id'=>$i,'deactive'=>0,'flat_id'=>$flat));
			}
		/////////////  End code ledger sub accounts //////////////////////////
		$special="'";
		if(!empty($email) && !empty($mobile))
		{
		$login_user=$email;	

		/* $message_web="<div>
		<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
		<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
		<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
		</br><p>Dear $name,</p>
		<p>'We at $society_name use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.</p>
		<p>As you are an owner/resident/staff of $society_name, we have added your email address in HousingMatters portal.</p>
		<p>Here are some of the important features related to our portal on HousingMatters:</p>
		<p>You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.</p>
		<p>You can receive important SMS & emails from your committee.</p>
		<br/>				
		<p><b>
		<a href='$ip".$this->webroot."/hms/send_sms_for_verify_mobile?q=$random'>Click here</a> for one time verification of your mobile number and Login into HousingMatters  for making life simpler for all your housing matters!</b></p>
		<br/>
		<p>Pls add www.housingmatters.co.in in your favorite bookmarks for future use.</p>
		<p>Regards,</p>	
		<p>Administrator of $society_name</p><br/>
		www.housingmatters.co.in
		</div >
		</div>"; */
		
		
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
										<span style="color:rgb(100,100,99)" align="justify"> Dear '.$name.', </span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										 '.$special.'We at '.$society_name.' use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.
										
										
										
										
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										As you are an owner/resident/staff of '.$society_name.', we have added your email address in HousingMatters portal.
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
												Here are some of the important features related to our portal on HousingMatters:
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
												You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.
										</td>
																
								</tr>

									<tr>
									<td style="padding:5px;" width="100%" align="left">
									You can receive important SMS & emails from your committee.
									</td>

									</tr>
								<tr>
										<td style="padding:5px;" width="100%" align="left"><br/>
											<span  align="justify"> <b>
											<a href="'.$ip.$this->webroot.'hms/send_sms_for_verify_mobile?q='.$random.'"> Click here </a> for one time verification of your mobile number and Login into HousingMatters for making life simpler for all your housing matters!</b>
											</span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span align="justify"> Pls add www.housingmatters.in in your favorite bookmarks for future use. </span> 
										</td>
																
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span > 
												Regards,<br/>
												Administrator of '.$society_name.'<br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';
		
		}
		
		if(!empty($email) && empty($mobile))
		{
			
			$login_user=$email;	
			/* $message_web="<div>
			<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
			<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
			<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
			</br><p>Dear $name,</p>
			<p>'We at $society_name use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.</p>
			<p>As you are an owner/resident/staff of $society_name, we have added your email address in HousingMatters portal.</p>
			<p>Here are some of the important features related to our portal on HousingMatters:</p>
			<p>You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.</p>
			<p>You can receive important SMS & emails from your committee.</p>
			<br/>				
			<p><b><a href='$ip".$this->webroot."/hms/set_new_password?q=$random'>Click here</a> for one time verification of your email and Login into HousingMatters  for making life simpler for all your housing matters!</b></p>
			<br/>
			<p>Pls add www.housingmatters.co.in in your favorite bookmarks for future use.</p>
			<p>Regards,</p>	
			<p>Administrator of $society_name</p><br>
			www.housingmatters.co.in
			</div >
			</div>"; */
			
			
			
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
										<span style="color:rgb(100,100,99)" align="justify"> Dear '.$name.', </span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										 '.$special.'We at '.$society_name.' use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.
										
										
										
										
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										As you are an owner/resident/staff of '.$society_name.', we have added your email address in HousingMatters portal.
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
												Here are some of the important features related to our portal on HousingMatters:
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
												You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.
										</td>
																
								</tr>

									<tr>
									<td style="padding:5px;" width="100%" align="left">
									You can receive important SMS & emails from your committee.
									</td>

									</tr>
								<tr>
										<td style="padding:5px;" width="100%" align="left"><br/>
											<span  align="justify"> <b>
											<a href="'.$ip.$this->webroot.'hms/set_new_password?q='.$random.'"> Click here </a> for one time verification of your email and Login into HousingMatters for making life simpler for all your housing matters!</b>
											</span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span align="justify"> Pls add www.housingmatters.in in your favorite bookmarks for future use. </span> 
										</td>
																
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span > 
												Regards,<br/>
												Administrator of '.$society_name.'<br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';
			
		}

			$from_name="HousingMatters";
			$reply="support@housingmatters.in";
			$to=$email;
			$this->loadmodel('email');
			$conditions=array("auto_id" => 4);
			$result_email = $this->email->find('all',array('conditions'=>$conditions));
			foreach ($result_email as $collection) 
			{
			 $from=$collection['email']['from'];
			}
			 $subject="Welcome to ".$society_name." portal ";
			if(!empty($email))
			{
			$this->send_email($to,$from,$from_name,$subject,@$message_web,$reply);
			}
			

				////////////////Notification email user all checked code  //////////////////////////
				$this->loadmodel('email');	
				$conditions=array('notification_id'=>1);
				$result_email=$this->email->find('all',array('conditions'=>$conditions));
				foreach($result_email as $data)
				{
				$auto_id = (int)$data['email']['auto_id'];
				$this->loadmodel('notification_email');
				$lo=$this->autoincrement('notification_email','notification_id');
				$this->notification_email->saveAll(array("notification_id" => $lo, "module_id" => $auto_id , "user_id" => $i,'chk_status'=>0));
				}

				//////////////// End all checked code   //////////////////////////

			if(empty($email) && empty($mobile))
			{
			}else{
				////////////////////  insert login table  ///////////////////
				$this->loadmodel('login');
				$this->login->saveAll(array('login_id'=>$log_i,'user_name'=>$login_user,'password'=>$random,'signup_random'=>$random,'mobile'=>$mobile));
			}
			//////////////////////////////////////////////////////////////////
		
unset($role_id);
}
$output = json_encode(array('report_type'=>'success', 'text' => 'New members registered into your society successfully.'));
die($output);



}
///////////////////////////////// End Check Email Already Exist ////////////////////////////////////////////// 

/////////////////////Start Function expense Tracker Add Fetch2 (Accounts)//////////////
function expense_tracker_fetch2($auto_id) 
{
$this->loadmodel('ledger_account');
$conditions=array("group_id" => $auto_id);
return $this->ledger_account->find('all',array('conditions'=>$conditions));
}
////////////////End Function Fetch expense Tracker Add Fetch2 (Accounts)//////////////

///////////////////////////////////////// Start Expense Tracker View History Expense Head (Accounts) /////////
function expense_tracker_fetch($auto_id)
{
$this->loadmodel('expense_tracker');
$conditions=array("auto_id" => $auto_id);
return $this->expense_tracker->find('all',array('conditions'=>$conditions));
}
///////////////////////// End Expense Tracker View History Expense Head Fetch (Accounts) //////////////////////////////

////////////////////////////// Start Flat type Validation //////////////////////////////////////////////////////////
function flat_type_validation()
{
$this->layout='blank';
$q=$this->request->query('q');
$q = html_entity_decode($q);
$wing = $this->request->query('b');
$wing = html_entity_decode($wing);

$s_society_id = (int)$this->Session->read('society_id');
$s_user_id  = (int)$this->Session->read('user_id');

$wing = json_decode($wing, true);
$myArray = json_decode($q, true);

if(empty($wing))
{
$output = json_encode(array('type'=>'error', 'text' => 'Select Wing'));
die($output);
}
$c=0;
$array1 = array();
foreach($myArray as $data)
{
$c++;
if(empty($data[0]))
{
$output = json_encode(array('type'=>'error', 'text' => 'Insert Flat Number in textbox'.$c.''));
die($output);
}


$nnn = 555;
$this->loadmodel('flat');
$conditions=array("society_id"=>$s_society_id);
$cursor3 = $this->flat->find('all',array('conditions'=>$conditions));
foreach($cursor3 as $collection)
{	
$wing_id2 = (int)$collection['flat']['wing_id'];
$flat_nu2 = $collection['flat']['flat_name'];	
if($wing_id2 == $wing && $flat_nu2 == $data[0])
{
$nnn = 55;	
}	
}	
if($nnn == 55)
{	
$output = json_encode(array('type'=>'error', 'text' => 'The Flat Number is Already Exist in textbox'.$c.''));
die($output);
}	

foreach($array1 as $child)
{
if($child == $data[0])
{
$output = json_encode(array('type'=>'error', 'text' => 'Repeatation of Flat Number in textbox'.$c.''));
die($output);
}
}
$array1[] = $data[0];
}

foreach($myArray as $data)
{
$flat_number = $data[0];
$wing = (int)$wing;
$this->loadmodel('flat');
$order=array('flat.flat_id'=> 'DESC');
$cursor=$this->flat->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last=$collection['flat']["flat_id"];
}
if(empty($last))
{
$k=0;
}	
else
{	
$k=$last;
}
$k++;
$this->loadmodel('flat');
$multipleRowData = Array( Array("flat_id"=>$k, "wing_id"=>$wing, "flat_name"=>(int)$flat_number, "society_id"=>$s_society_id));
$this->flat->saveAll($multipleRowData);

}
$output = json_encode(array('type'=>'succ', 'text' => 'Record Inserted Successfully'));
die($output);

}
////////////////////////////// End Flat type Validation //////////////////////////////////////////////////////////

//////////////////////////////////////// Start Insert query /////////////////////////////////////////////////////////
function query_insert()
{
$this->layout='blank';
$s_society_id=$this->Session->read('society_id'); 
$s_role_id=$this->Session->read('role_id');
$s_user_id=$this->Session->read('user_id');


$this->loadmodel('user');
$cursor = $this->user->find('all');
foreach($cursor as $collection)
{
$user_id = (int)$collection['user']['user_id'];
$deactive = (int)$collection['user']['deactive'];
$society_id = (int)$collection['user']['society_id'];
$name = $collection['user']['user_name'];
$role = $collection['user']['role_id'];

for($r=0; $r<sizeof($role); $r++)
{
$role_id = (int)$role[$r];
if($role_id == 2)
{
$k = (int)$this->autoincrement('ledger_sub_account','auto_id');
$this->loadmodel('ledger_sub_account');
$multipleRowData = Array( Array("auto_id"=>$k,"ledger_id"=>34,"delete_id"=>0,"society_id"=>$society_id,"name"=>$name,"user_id"=>$user_id,"deactive"=>$deactive));
$this->ledger_sub_account->saveAll($multipleRowData);
}
}


}
}
///////////////////////////////// End Insert Query /////////////////////////////////////////////////////////////////

//////////////////////////////// Start Master Sm Flat Vali //////////////////////////////////////////////////
function master_sm_flat_vali()
{
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id  = (int)$this->Session->read('user_id');
$s_role_id = (int)$this->Session->read('role_id');

$res_society=$this->society_name($s_society_id);
foreach($res_society as $data)
{
$society_name=$data['society']['society_name'];
}

$q=$this->request->query('q');
$q = html_entity_decode($q);

$s_n='';
$sco_na=$society_name;
$dd=explode(' ',$sco_na);
$first=$dd[0];
@$two=$dd[1];
@$three=$dd[2];
$s_n.=" $first $two $three ";

date_default_timezone_set('Asia/kolkata');
$date=date("d-m-Y");
$time=date('h:i:a',time());

$myArray = json_decode($q, true);

$c=0;

foreach($myArray as $child)
{
$c++;

if(empty($child[0])){
$output = json_encode(array('type'=>'error', 'text' => 'Please Select Wing in row'.$c));
die($output);
}	

if(empty($child[1])){
$output = json_encode(array('type'=>'error', 'text' => 'Please Select Flat Number in row'.$c));
die($output);
}	

$this->loadmodel('flat');
$conditions=array("society_id"=>$s_society_id);
$cursor3 = $this->flat->find('all',array('conditions'=>$conditions));
foreach($cursor3 as $collection)
{
$wing_id = $collection['flat']['wing_id'];
$flat_nu = $collection['flat']['flat_id'];
$flat_area = @$collection['flat']['flat_area'];

if($wing_id == $child[0] and $flat_nu == $child[1] and !empty($flat_area))
{
$nnn = 55;
break;
}
else
{
$nnn = 555;
}
}
if($nnn == 55)
{
$output = json_encode(array('type'=>'error', 'text' => 'The Flat Number is Already Exist, Please Select Another Flat Number in row'.$c));
die($output);
}


$wing_id1 = (int)$child[0];
$flat_id = (int)$child[1];

for($j=0; $j<sizeof(@$fl_arr); $j++)
{
$sub_arr2 = $fl_arr[$j];
$wing_id2 = (int)$sub_arr2[0];
$flat_id2 = (int)$sub_arr2[1];

if($wing_id2 == $wing_id1 and $flat_id2 == $flat_id)
{
$mmm = 55;
break;
}
else
{
$mmm = 555;
}
}

if(@$mmm == 55)
{
$output = json_encode(array('type'=>'error', 'text' => 'Repeatation of Same Wing and Flat Number, Please Select Another Wing or Flat in row'.$c));
die($output);
}
$sub_arr = array($wing_id1,$flat_id);
$fl_arr[] = $sub_arr;

if(empty($child[2])){
$output = json_encode(array('type'=>'error', 'text' => 'Please Select Flat Type in row'.$c));
die($output);
}	

if(!empty($child[3]))
{
if(is_numeric($child[3]))
{
}
else
{
$output = json_encode(array('type'=>'error', 'text' => 'Please Fill Numeric Area of the Flat in row'.$c));
die($output);
}
}

}

foreach($myArray as $child)
{
$wing_id5 = (int)$child[0];
$flat_id5 = (int)$child[1];
$flat_type5 = (int)$child[2];
$flat_area5 = (float)$child[3];

///////////////////////////
$qqq = 5;
$this->loadmodel('flat_type');
$condition=array('society_id'=>$s_society_id,"flat_type_id"=>$flat_type5);
$cursor = $this->flat_type->find('all',array('conditions'=>$condition)); 
foreach($cursor as $collection)
{
$auto_id = (int)@$collection['flat_type']['auto_id'];
$no_of_flat = (int)@$collection['flat_type']['number_of_flat'];
$qqq = 55;
}
if($qqq == 5)
{

$no_of_flat = 1;
$this->loadmodel('flat_type');
$p=$this->autoincrement('flat_type','auto_id');
$this->flat_type->saveAll(array("auto_id" => $p,"flat_type_id"=> $flat_type5,"number_of_flat"=>$no_of_flat,"status"=>0,"society_id"=>$s_society_id));

$this->loadmodel('flat');
$this->flat->updateAll(array("flat_area"=>$flat_area5,"flat_type_id"=>$flat_type5),array("flat_id"=>$flat_id5));
}
else if($qqq == 55)
{
$no_of_flat++;
$this->loadmodel('flat_type');
$this->flat_type->updateAll(array("number_of_flat"=>$no_of_flat),array("auto_id"=>$auto_id));

$this->loadmodel('flat');
$this->flat->updateAll(array("flat_area"=>$flat_area5,"flat_type_id"=>$flat_type5),array("flat_id"=>$flat_id5));
}

}

$output = json_encode(array('type'=>'succ', 'text' => 'Record Inserted Successfully.'));
die($output);

}
//////////////////////////////// End Master Sm Flat Vali //////////////////////////////////////////////////







//////////////////////////// Start purchase order json ////////////////////////////////////////////////////////////
function purchase_order_json()
{
$this->layout=null;
$post_data=$this->request->data;
$this->ath();
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$date=date('d-m-Y');
$time = date(' h:i a', time());


$date = $post_data['date'];
$date2 = $post_data['date2'];
$quat = $post_data['quta'];
$item = $post_data['itm'];
$unit = $post_data['unt'];
$qty = $post_data['qty'];
$desc = $post_data['desc'];
$po_issue = $post_data['poiss'];
$po_desc = $post_data['pdesc'];
$sent = $post_data['sent'];

$report = array();

if(empty($date)){
$report[]=array('label'=>'dat', 'text' => 'Please select R&Q Date');
}	

if(empty($date2)){
$report[]=array('label'=>'dat2', 'text' => 'Please select Required Date');
}	

if(empty($quat)){
$report[]=array('label'=>'qut', 'text' => 'Please Select Quatation');
}	

if(empty($item)){
$report[]=array('label'=>'itm', 'text' => 'Please Select Item');
}	

if(empty($unit)){
$report[]=array('label'=>'unt', 'text' => 'Please Select Unit of Measurement');
}	

if(empty($qty)){
$report[]=array('label'=>'qty', 'text' => 'Please Fill Price');
}	


if(empty($desc)){
$report[]=array('label'=>'des', 'text' => 'Please Fill Description');
}

if($po_issue == "undefined"){
$report[]=array('label'=>'poiss', 'text' => 'Please Select PO Issue');
}	
if($po_issue == 1)
{
if(empty($po_desc)){
$report[]=array('label'=>'pdes', 'text' => 'Please select Expense Head');
}	
}

if(empty($sent))
{
$report[]=array('label'=>'sen', 'text' => 'Please Fill Sent To');
}

$date4 = date("Y-m-d", strtotime($date));
$date4 = new MongoDate(strtotime($date4));

$this->loadmodel('financial_year');
$conditions=array("society_id" => $s_society_id);
$cursor=$this->financial_year->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$from = $collection['financial_year']['from'];
$to = $collection['financial_year']['to'];
if($from <= $date4 && $to >= $date4)
{
$abc = 55;
break;
}
else
{
$abc = 555; 
}
}

if(!empty($date))
{
if($abc == 555)
{
$report[]=array('label'=>'dat', 'text' => 'The Date is not in Open Financial Year, Please Select another Date');
}
}

if(!empty($qty))
{
if(is_numeric($qty))
{
}
else
{
$report[]=array('label'=>'qty', 'text' => 'Pleaes Fill Numeric Value');
}
}

if(sizeof($report)>0)
{
$output=json_encode(array('report_type'=>'error','report'=>$report));
die($output);
}

$date11 = date("Y-m-d", strtotime($date));
$date11 = new MongoDate(strtotime($date11));

$date12 = date("Y-m-d", strtotime($date2));
$date12 = new MongoDate(strtotime($date12));

$current_date = date('Y-m-d');
$current_date = new MongoDate(strtotime($current_date));


$this->loadmodel('purchase_order');
$order=array('purchase_order.auto_id'=> 'DESC');
$cursor=$this->purchase_order->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last=$collection['purchase_order']["auto_id"]; 
}
if(empty($last))
{
$k=1000;
}	
else
{	
$k=$last;
}
$k++;
$this->loadmodel('purchase_order');
$multipleRowData = Array( Array("auto_id" => $k,"purchase_order_date" => $date11, "required_date" => $date12, "quatation_id" => $quat, "item_id" => $item, "unit_of_measurement" => $unit,"price" => $qty, "description" => $desc,"po_issue"=>$po_issue,"po_description"=>$po_desc,"society_id"=>$s_society_id,"prepaired_by"=>$s_user_id,"sent_to"=>$sent));
$this->purchase_order->saveAll($multipleRowData);   


$output=json_encode(array('report_type'=>'publish','report'=>'Purchase Order Created Successfully'));
die($output);

}
//////////////////////////// End purchase order json ////////////////////////////////////////////////////////////

///////////////////////////// Start purchase order view ///////////////////////////////////////////////////////////
function purchase_order_view()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}

$this->ath();
$this->check_user_privilages();	




}
///////////////////////////// End purchase order view ///////////////////////////////////////////////////////////

/////////////////////////////// Start Purchase Order Show Ajax //////////////////////////////////////////////////////
function purchase_order_show_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$from = $this->request->query('date1');
$to = $this->request->query('date2');
$this->set('from',$from);
$this->set('to',$to);

$this->loadmodel('purchase_order');
$conditions=array("society_id" => $s_society_id);
$cursor1 = $this->purchase_order->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);




}



/////////////////////////////// End Purchase Order Show Ajax //////////////////////////////////////////////////////
/////////////////////////////////// Start Wing Json//////////////////////////////////////////////////////////////
function wing_json()
{
$this->layout=null;
$post_data=$this->request->data;
$this->ath();
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$date=date('d-m-Y');
$time = date(' h:i a', time());

$wing = htmlentities($post_data['wing']);

$report = array();
if(empty($wing)){
$report[]=array('label'=>'win', 'text' => 'Please Fill Wing Name');
}

			$this->loadmodel('wing'); 
			$conditions=array("society_id"=>$s_society_id,"wing_name"=> new MongoRegex('/^' .  $wing . '$/i'));
			$result_wing=$this->wing->find('all',array('conditions'=>$conditions));
			
if(sizeof($result_wing)>0)
{

$output = json_encode(array('report_type'=>'already_error', 'text' => 'Wing Name is already exist .'));
        die($output);
}

			
			
if(sizeof($report)>0)
{
$output=json_encode(array('report_type'=>'error','report'=>$report));
die($output);
}


$this->loadmodel('wing');
$i=$this->autoincrement('wing','wing_id');
$this->wing->saveAll(array("wing_id" => $i,"society_id"=> $s_society_id,"wing_name"=>$wing));

$output=json_encode(array('report_type'=>'publish','report'=>'Wing Inserted Successfully'));
die($output);

}
/////////////////////////////////// End Wing Json//////////////////////////////////////////////////////////////

/////////////////////////////////// Start Save Flat Imp /////////////////////////////////////////////////////
function save_flat_imp()
{
$this->layout='blank';
$s_society_id = (int)$this->Session->read('society_id');
	
$q=$this->request->query('q'); 
$myArray = json_decode($q, true);

$c=1;
$report=array();
//$array1 = array();
foreach($myArray as $child){

$c++;
if(empty($child[0])){
$report[]=array('tr'=>$c,'td'=>1, 'text' => 'Required');
}
if(empty($child[1])){
$report[]=array('tr'=>$c,'td'=>2, 'text' => 'Required');
}

if(empty($child[2])){
$report[]=array('tr'=>$c,'td'=>3, 'text' => 'Required');
}


}
if(sizeof($report)>0){
$output=json_encode(array('report_type'=>'error','report'=>$report));
die($output);
}

$t=0;
foreach($myArray as $child)
{
$t++;
$wing_id = (int)$child[0];
$flat_num = $child[1];
$area = $child[3];


$this->loadmodel('flat');
$conditions=array("society_id" => $s_society_id);
$cursor1 = $this->flat->find('all',array('conditions'=>$conditions));
foreach($cursor1 as $collection)
{
$wing_id2 = (int)$collection['flat']['wing_id'];
$flat_name2 = $collection['flat']['flat_name'];
if($wing_id2 == $wing_id && $flat_name2 == $flat_num)
{ 
$nnn = 55;
break;
}
else
{
$nnn = 555;
}
}
if($nnn == 55)
{
$output=json_encode(array('report_type'=>'vali','text'=>'Wing and Flat Already Exist in row '.$t));
die($output);
}

if(!empty($area))
{
if(is_numeric($area))
{
}
else
{
$output=json_encode(array('report_type'=>'vali','text'=>'Flat Area Should be Numeric in row '.$t));
die($output);
}
}

}
$bbbb = "pp";
 
foreach($myArray as $child)
{
$wing_id5 = $child[0];
$flat_name = trim($child[1]);
$flat_type = (int)$child[2];
$area = (float)$child[3];
$insert = (int)$child[4];


$this->loadmodel('wing');
$conditions=array("wing_name" => $wing_id5,"society_id" => $s_society_id);
$cursor1wing = $this->wing->find('all',array('conditions'=>$conditions));
$q_wing_id=$cursor1wing[0]["wing"]["wing_id"];

$ww = 5;
$this->loadmodel('flat');
$conditions=array("society_id" => $s_society_id);
$cursor1 = $this->flat->find('all',array('conditions'=>$conditions));

foreach($cursor1 as $collection)
{
$wing_id2 = (int)$collection['flat']['wing_id'];
$flat_name2 = $collection['flat']['flat_name'];
$flat_id = (int)$collection['flat']['flat_id'];
$flat_area = (int)@$collection['flat']['flat_area'];
$flat_ttt_ppp = (int)@$collection['flat']['flat_type_id'];

if($flat_name2 == $flat_name && $q_wing_id==$wing_id2)
{ 
$wing_id5 = (int)$wing_id2;
$flat_id5 = (int)$flat_id;
$flat_tttdd = (int)$flat_ttt_ppp;
if($flat_area == 0)
{
$ww = 555;
}
}
}
if($insert == 2)
{
$mmm = 5;
$this->loadmodel('flat_type');
$condition=array('society_id'=>$s_society_id,"flat_type_id"=>$flat_type);
$cursor = $this->flat_type->find('all',array('conditions'=>$condition)); 

foreach($cursor as $collection)
{
$auto_id = (int)@$collection['flat_type']['auto_id'];
$no_of_flat = (int)@$collection['flat_type']['number_of_flat'];
$mmm = 55;
}

if($ww == 555)
{
if($mmm == 5)
{
$no_of_flat = 1;
$this->loadmodel('flat_type');
$p=$this->autoincrement('flat_type','auto_id');
$this->flat_type->saveAll(array("auto_id" => $p,"flat_type_id"=> $flat_type,"number_of_flat"=>$no_of_flat,"status"=>0,"society_id"=>$s_society_id));

$this->loadmodel('flat');
$this->flat->updateAll(array("flat_area"=>$area,"flat_type_id"=>$flat_type),array("flat_id" => $flat_id5,"society_id"=>$s_society_id));		
}
else if($mmm == 55)
{
$no_of_flat++;
$this->loadmodel('flat_type');
$this->flat_type->updateAll(array("number_of_flat"=>$no_of_flat),array("auto_id"=>$auto_id));

$this->loadmodel('flat');
$this->flat->updateAll(array("flat_area"=>$area,"flat_type_id"=>$flat_type),array("flat_id" => $flat_id5,"society_id"=>$s_society_id));	
}
}
else if($ww == 5)
{
if($flat_tttdd != $flat_type)
{
$ggg = 5;
$this->loadmodel('flat_type');
$condition=array('society_id'=>$s_society_id,"flat_type_id"=>$flat_tttdd);
$cursor = $this->flat_type->find('all',array('conditions'=>$condition)); 
foreach($cursor as $collection)
{
$auto_id22 = (int)@$collection['flat_type']['auto_id'];
$no_of_flat22 = (int)@$collection['flat_type']['number_of_flat'];
}
if($bbbb != $auto_id22)
{
$bbbb = (int)$auto_id22;
$auto_id2 = (int)$auto_id22;
$no_of_flat2 = (int)$no_of_flat22;
}
}
else
{
$ggg = 555;
}

$no_of_flat2 = @$no_of_flat2 - 1;
if($no_of_flat2 == 0)
{
$this->loadmodel('flat_type');
$conditions=array('flat_type.auto_id'=>$auto_id2);
$this->flat_type->deleteAll($conditions);
}
else
{
$this->loadmodel('flat_type');
$this->flat_type->updateAll(array("number_of_flat"=>@$no_of_flat2),array("auto_id"=>@$auto_id2));
}


if($mmm == 5)
{
$no_of_flat = 1;
$this->loadmodel('flat_type');
$p=$this->autoincrement('flat_type','auto_id');
$this->flat_type->saveAll(array("auto_id" => $p,"flat_type_id"=> $flat_type,"number_of_flat"=>$no_of_flat,"status"=>0,"society_id"=>$s_society_id));

$this->loadmodel('flat');
$this->flat->updateAll(array("flat_area"=>$area,"flat_type_id"=>$flat_type),array("flat_id" => $flat_id5,"society_id"=>$s_society_id));		
}
else if($mmm == 55)
{
if($ggg == 5)
{
$no_of_flat++;
$this->loadmodel('flat_type');
$this->flat_type->updateAll(array("number_of_flat"=>$no_of_flat),array("auto_id"=>$auto_id));
}
$this->loadmodel('flat');
$this->flat->updateAll(array("flat_area"=>$area,"flat_type_id"=>$flat_type),array("flat_id" => $flat_id5,"society_id"=>$s_society_id));	
}
}

}
}

$output=json_encode(array('report_type'=>'done','text'=>'Flat Area Should be Numeric in row '));
die($output);
}
/////////////////////////////////// End Save Flat Imp /////////////////////////////////////////////////////






///////////////start flash message////////////////////

function flash_message(){
	if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
	$this->ath();
	$this->loadmodel('flash');
	$conditions=array("flash_id" => 1);
	$result_cursor1=$this->flash->find('all',array('conditions'=>$conditions));
	$this->set('result_cursor1',$result_cursor1);
}

function submit_flash_message(){
	$this->layout=null;
	$title=$_POST["title"];
	$description=$_POST["description"];
	$theme=$_POST["theme"];
	$active=(int)$_POST["active"];
	 
	$this->loadmodel('flash');
	$this->flash->updateAll(array("title"=> $title,"description"=>$description,"theme"=>$theme,"active"=>$active),array("flash_id"=>1));
	echo "success";
}

function flash_output(){
	$this->layout=null;
	$this->loadmodel('flash');
	$conditions=array("flash_id" => 1);
	$result_cursor1=$this->flash->find('all',array('conditions'=>$conditions));
	$this->set('result_cursor1',$result_cursor1);
}



function set_ledger_sub_acc_users(){
			$this->layout=null;
	
	$this->loadmodel('user');
	$conditions=array("society_id" => 2);
	$result_cursor1=$this->user->find('all',array('conditions'=>$conditions));
		foreach($result_cursor1 as $data){
			$user_id = (int)$data['user']['user_id'];
			$user_name = $data['user']['user_name'];
			
			
			
			
			
		$auto_id = (int)$this->autoincrement('ledger_sub_accounts','auto_id');
		$this->loadmodel('ledger_sub_accounts');
		$this->ledger_sub_accounts->saveAll(array("auto_id" => $auto_id,"ledger_id"=> 34,"name"=>$user_name,"society_id"=>2,"user_id"=>$user_id,"deactive"=>0));
		}
		
		
		
	}

//////////////end flash mesage////////////////////////
function convert_number_to_words($number) {
            $hyphen      = '-';
            $conjunction = ' and ';
            $separator   = '  ';
            $negative    = 'negative ';
            $decimal     = ' point ';
            $dictionary  = array(
                0                   => 'zero',
                1                   => 'one',
                2                   => 'two',
                3                   => 'three',
                4                   => 'four',
                5                   => 'five',
                6                   => 'six',
                7                   => 'seven',
                8                   => 'eight',
                9                   => 'nine',
                10                  => 'ten',
                11                  => 'eleven',
                12                  => 'twelve',
                13                  => 'thirteen',
                14                  => 'fourteen',
                15                  => 'fifteen',
                16                  => 'sixteen',
                17                  => 'seventeen',
                18                  => 'eighteen',
                19                  => 'nineteen',
                20                  => 'twenty',
                30                  => 'thirty',
                40                  => 'fourty',
                50                  => 'fifty',
                60                  => 'sixty',
                70                  => 'seventy',
                80                  => 'eighty',
                90                  => 'ninety',
                100                 => 'hundred',
                1000                => 'thousand',
                1000000             => 'million',
                1000000000          => 'billion',
                1000000000000       => 'trillion',
                1000000000000000    => 'quadrillion',
                1000000000000000000 => 'quintillion'
            );
            
            if (!is_numeric($number)) {
                return false;
            }
            
            if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
                // overflow
                trigger_error(
                    'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                    E_USER_WARNING
                );
                return false;
            }

            if ($number < 0) {
			
			$rupee= abs($number); 
                return $this->convert_number_to_words($rupee);
            }
            
            $string = $fraction = null;
            
            if (strpos($number, '.') !== false) {
                list($number, $fraction) = explode('.', $number);
            }
            
            switch (true) {
                case $number < 21:
                    $string = $dictionary[$number];
                    break;
                case $number < 100:
                    $tens   = ((int) ($number / 10)) * 10;
                    $units  = $number % 10;
                    $string = $dictionary[$tens];
                    if ($units) {
                        $string .= $hyphen . $dictionary[$units];
                    }
                    break;
                case $number < 1000:
                    $hundreds  = $number / 100;
                    $remainder = $number % 100;
                    $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                    if ($remainder) {
                        $string .= $conjunction . $this->convert_number_to_words($remainder);
                    }
                    break;
                default:
                    $baseUnit = pow(1000, floor(log($number, 1000)));
                    $numBaseUnits = (int) ($number / $baseUnit);
                    $remainder = $number % $baseUnit;
                    $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                    if ($remainder) {
                        $string .= $remainder < 100 ? $conjunction : $separator;
                        $string .= $this->convert_number_to_words($remainder);
                    }
                    break;
					}
					if (null !== $fraction && is_numeric($fraction)) {
					$string .= $decimal;
					$words = array();
					foreach (str_split((string) $fraction) as $number) {
					$words[] = $dictionary[$number];
					}
					$string .= implode(' ', $words);
					}
					return $string;
					}
////////////////////// Start Unit Config  Excel Export ///////////////////////////////////////////////////////////
function unit_config()
{
$this->layout="";
$filename="Unit_Configuration_Import";
header ("Expires: 0");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".csv");
header ("Content-Description: Generated Report" );

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');


$excel = "Wing,Flat Number,Flat Type,Flat Area (Sq. Ft.) \n";


$this->loadmodel('wing');
$conditions=array("society_id" => $s_society_id);
$result_wing = $this->wing->find('all',array('conditions'=>$conditions));
foreach($result_wing as $wing){
	$wing_id = $wing['wing']['wing_id'];
	$wing_name = $wing['wing']['wing_name'];
	
	$this->loadmodel('flat');
	$conditions=array("wing_id" => $wing_id);
	$order=array("flat.flat_name" => "ASC");
	$result_flat = $this->flat->find('all',array('conditions'=>$conditions,'order'=>$order));
	foreach($result_flat as $flat){
		$flat_name = $flat['flat']['flat_name'];
		$excel.= "$wing_name,$flat_name  \n";
	}

}
echo $excel;


}
////////////////////// End Unit Config Excel Export ///////////////////////////////////////////////////////////		
	function callback_url_google(){
		$this->layout=null;
		echo $facebook = $this->Session->read('FacebookAuthenticate');
	
	}
	
	function login_user_to_app($user_email){
		$this->layout=null;
		$this->loadmodel('login');
		$conditions=array("user_name" => $user_email);
		$result_login = $this->login->find('all',array('conditions'=>$conditions));	
		if(sizeof($result_login)==0){
			echo 0;
		}else{
			$login_id=$result_login[0]["login"]["login_id"];
			
			$this->loadmodel('user');
			 $conditions1=array('s_default'=>1,'login_id'=>$login_id,'deactive'=>0);
			 $result_user=$this->user->find('all',array('conditions'=>$conditions1));
			 $n=sizeof($result_user);
			 if($n>0)
			 {
				foreach($result_user as $data)
				{
				
				$user_id=$data['user']['user_id'];
				$society_id=$data['user']['society_id'];
				$user_name=$data['user']['user_name'];
				$wing=$data['user']['wing'];
				$tenant=$data['user']['tenant'];
				$role_id=$data['user']['default_role_id'];
				$profile=@$data['user']['profile_status'];
				}
				 
					date_default_timezone_set('Asia/kolkata');
					$date=date("d-m-Y");
					$time=date('h:i:a',time());
					$this->loadmodel('log');
					$i=$this->autoincrement('log','log_id');
					$this->log->save(array('log_id'=>$i,'user_id'=>$user_id,'society_id'=>$society_id,'date'=>$date,'time'=>$time,'status'=>0));
				    $this->Session->write('user_id', $user_id);
					$this->Session->write('login_id', $login_id);
					$this->Session->write('role_id', $role_id);
					$this->Session->write('society_id', $society_id);
					$this->Session->write('user_name', $user_name);
					$this->Session->write('wing', $wing);
					$this->Session->write('tenant', $tenant);
					echo 1;
				 
			 }
		}
	}
	
	
	
	function smtpmailer($to,$from, $from_name, $subject, $message_web,$reply, $is_gmail=true)
	{
	App::import('Vendor', 'PhpMailer', array('file' => 'phpmailer' . DS . 'class.phpmailer.php')); 

		global $error;
		
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl'; 
		$mail->Host = 'email-smtp.us-west-2.amazonaws.com';
		$mail->Port = 465;  
		$mail->Username = 'AKIAI7T4AF3TM3UDL2HA';  
		$mail->Password = 'AhrW2AEFouYGi1f1M3rB7tGhnsoJfr+2iU2eUuWT/hKz';
		$mail->SMTPDebug = 1; 
		$mail->From = $from;
		$HTML = true;	 
		$mail->WordWrap = 50; // set word wrap
		$mail->IsHTML($HTML);

		
		$mail->FromName= $from_name;

	$mail->Subject = $subject;
	$mail->Body = $message_web;
	if(!empty($reply))
	{
		$mail->AddReplyTo($reply ,"HousingMatters");
	}
	$mail->addAddress($to);

		if(!$mail->Send()) {
			$error = 'Mail error: '.$mail->ErrorInfo;
			return false;
		} else {
			$error = 'Message sent!';
			return true;
		}
		
	}
	
	function check_slide_show_displayed_or_not(){
		$this->layout=null;
		$s_user_id = (int)$this->Session->read('user_id');
		$this->loadmodel('user');
		$conditions=array("user_id" => $s_user_id);
		$result_user = $this->user->find('all',array('conditions'=>$conditions));
		$slide_show=(int)@$result_user[0]["user"]["slide_show"];
		if($slide_show==0){
			echo 0;
		}
		elseif($slide_show==1){
			echo 1;
		}
		elseif($slide_show==2){
			echo 2;
		}
	}
	
	function have_seen_slide_show(){
		$this->layout=null;
		$s_user_id = (int)$this->Session->read('user_id');
		$this->loadmodel('user');
		$this->user->updateAll(array('slide_show'=>1),array('user_id'=>$s_user_id));
	}
	
	function update_slide_show_me_later(){
		$this->layout=null;
		$s_user_id = (int)$this->Session->read('user_id');
		$this->loadmodel('user');
		$this->user->updateAll(array('slide_show'=>2),array('user_id'=>$s_user_id));
	}
	
	function fetch_slide_1(){
		$this->layout=null;
		$this->set("ip",$this->hms_email_ip());
		$s_user_id = (int)$this->Session->read('user_id');
		$this->loadmodel('user');
		$conditions=array("user_id" => $s_user_id);
		$result_user = $this->user->find('all',array('conditions'=>$conditions));
	}
	
	function fetch_slide_2(){
		$this->layout=null;
		$this->set("ip",$this->hms_email_ip());
		$s_user_id = (int)$this->Session->read('user_id');
		$this->loadmodel('user');
		$conditions=array("user_id" => $s_user_id);
		$result_user = $this->user->find('all',array('conditions'=>$conditions));
	}
	
	function fetch_slide_3(){
		$this->layout=null;
		$this->set("ip",$this->hms_email_ip());
		$s_user_id = (int)$this->Session->read('user_id');
		$this->loadmodel('user');
		$conditions=array("user_id" => $s_user_id);
		$result_user = $this->user->find('all',array('conditions'=>$conditions));
	}
	
	function fetch_slide_4(){
		$this->layout=null;
		$this->set("ip",$this->hms_email_ip());
		$s_user_id = (int)$this->Session->read('user_id');
		$this->loadmodel('user');
		$conditions=array("user_id" => $s_user_id);
		$result_user = $this->user->find('all',array('conditions'=>$conditions));
	}
	
	function fetch_slide_5(){
		$this->layout=null;
		$this->set("ip",$this->hms_email_ip());
		$s_user_id = (int)$this->Session->read('user_id');
		$this->loadmodel('user');
		$conditions=array("user_id" => $s_user_id);
		$result_user = $this->user->find('all',array('conditions'=>$conditions));
	}
	
	function check_session_destroy_or_not(){
		$this->layout=null;
		$s_user_id = (int)$this->Session->read('user_id');
		if(empty($s_user_id)){
			echo 0;
		}else{
			echo 1;
		}
	}

//////////////////////// Start fix_assets_add_row ///////////////////////////////////////
function fix_assets_add_row()
{
$this->layout='blank';
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');

$this->ath();

$count = (int)$this->request->query('con');
$this->set('count',$count);	
	
$this->loadmodel('ledger_account');
$conditions=array("group_id" => 4);
$result_ledger_account=$this->ledger_account->find('all',array('conditions'=>$conditions));
$this->set('result_ledger_account',$result_ledger_account);


$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 15);
$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('result_ledger_sub_account',$result_ledger_sub_account);
	
}
//////////////////////// End fix_assets_add_row ///////////////////////////////////////

////////////////////////// Start Resident drop down ////////////////////////////////////
function resident_drop_down()
{
$s_society_id=(int)$this->Session->read('society_id');

$current_date = date('Y-m-d');
$current_date2 = strtotime($current_date);
$this->loadmodel('financial_year');
$conditions=array("society_id"=>$s_society_id);
$financial_data = $this->financial_year->find('all',array('conditions'=>$conditions));
foreach($financial_data as $financial_dataaa)
{
$from = $financial_dataaa['financial_year']['from'];	
$to = $financial_dataaa['financial_year']['to'];

$from2 = date('Y-m-d',$from->sec);
$to2 = date('Y-m-d',$to->sec);	
$from3 = strtotime($from2);
$to3 = strtotime($to2);
if($current_date2 >= $from3 && $current_date2 <= $to3)
{
$financial_year_from = $from3;
$financial_year_to = $to3;
}
}




?>
<select class="m-wrap medium chosen resident_drop_down" id="resident" name="resident">
<option value="" style="display:none;">Select Sub Ledger A/c</option>
	<?php
	$this->loadmodel('ledger_sub_account');
	$conditions=array("ledger_id" => 34,"society_id"=>$s_society_id);
	$cursor = $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
    foreach($cursor as $data)
	{
	$flat_id = $data['ledger_sub_account']['flat_id'];
	$name = $data['ledger_sub_account']['name'];
    $exit_date = $data['ledger_sub_account']['exit_date']; 
	$deactive = $data['ledger_sub_account']['deactive']; 
	$wing_detailll = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
	foreach($wing_detailll as $wing_dataaa)
	{
	$wing_idddd = (int)$wing_dataaa['flat']['wing_id'];	
	}

$wing_flat= $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'),array('pass'=>array($wing_idddd,$flat_id)));
   if(($financial_year_from <= $exit_date && $financial_year_to >= $exit_date && $deactive == 1) || ($deactive == 0))
   {
   ?>		
    <option value="<?php echo $flat_id; ?>"><?php echo $name; ?> <?php echo $wing_flat; ?></option>
	<?php 
	} }
	?>
</select>
<?php	
}
////////////////////////// End Resident drop down ////////////////////////////////////	
////////////////////// Start fix_asset_update ////////////////////////////////////////
function fix_asset_update($fix_asset_id = null)
{
		if($this->RequestHandler->isAjax()){
		$this->layout='blank';
		}else{
		$this->layout='session';
		}
	$this->ath();
	$s_society_id = $this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');

$fix_asset_id=(int)$fix_asset_id;
$this->set('fix_asset_id',$fix_asset_id);


$this->loadmodel('fix_asset');
$conditions=array("society_id"=>$s_society_id,"fix_asset_id"=>$fix_asset_id);
$result_fix_assets=$this->fix_asset->find('all',array('conditions'=>$conditions));
$this->set('result_fix_assets',$result_fix_assets);


$this->loadmodel('ledger_account');
$conditions=array("group_id" => 4);
$result_ledger_account=$this->ledger_account->find('all',array('conditions'=>$conditions));
$this->set('result_ledger_account',$result_ledger_account);


$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 15);
$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('result_ledger_sub_account',$result_ledger_sub_account);
	
}
////////////////////////End fix_asset_update ///////////////////////////////////////////
////////////////////// Start fix_asset_update_json ///////////////////////////////////
function fix_asset_update_json()
{
$this->layout='blank';
	
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');
$post_data=$this->request->data;

     $this->ath();

$q=$post_data['myJsonString'];
$myArray = json_decode($q, true);

$c=0;
foreach($myArray as $child)
{
$c++;


	if(empty($child[0])){
		$output = json_encode(array('type'=>'error', 'text' => 'Asset Category is Required in row '.$c));
		die($output);
		}	
		
		
			if(empty($child[1])){
		$output = json_encode(array('type'=>'error', 'text' => 'Date of Purchase is Required in row '.$c));
		die($output);
		}	
		
		
		$TransactionDate = $child[1];
		$this->loadmodel('financial_year');
		$conditions=array("society_id" => $s_society_id,"status"=>1);
		$cursor = $this->financial_year->find('all',array('conditions'=>$conditions));
		$abc = 555;
		foreach($cursor as $collection){
				$from = $collection['financial_year']['from'];
				$to = $collection['financial_year']['to'];
				$from1 = date('Y-m-d',$from->sec);
				$to1 = date('Y-m-d',$to->sec);
				$from2 = strtotime($from1);
				$to2 = strtotime($to1);
				$transaction1 = date('Y-m-d',strtotime($TransactionDate));
				$transaction2 = strtotime($transaction1);
					if($transaction2 <= $to2 && $transaction2 >= $from2){
					$abc = 5;
					break;
					}	
		}
	if($abc == 555){
		$output=json_encode(array('type'=>'error','text'=>'Date of Purchase Should be in Open Financial Year in row '.$c));
		die($output);
	}
		
		
		
		
		
		
		
		
			if(empty($child[2])){
		$output = json_encode(array('type'=>'error', 'text' => 'Name of Supplier is Required in row '.$c));
		die($output);
		}	
		
		
			if(empty($child[3])){
		$output = json_encode(array('type'=>'error', 'text' => 'Rupees is Required in row '.$c));
		die($output);
		}	
		
		
		if(empty($child[4])){
		$output = json_encode(array('type'=>'error', 'text' => 'Asset Name is Required in row '.$c));
		die($output);
		}	
		
		
		if(!empty($child[5]) && !empty($child[6]))
		{
		$frmm = date('Y-m-d',strtotime($child[5]));
		$tttm = date('Y-m-d',strtotime($child[6]));
		$frmm2 = strtotime($frmm);
		$tttm2 = strtotime($tttm);
		if($tttm2 < $frmm2)
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Warranty Period To can not be Small Than Warranty Period From  in row '.$c));
		die($output);	
			
		}
		}	
		
		
}

$rrrr = array();
$z=0;
foreach($myArray as $child)
{
 $z++;
 $asset_category_id = (int)$child[0];
 $purchase_date = $child[1];
 $assert_supplier_id = (int)$child[2];
 $cost_of_purchase = $child[3];
 $asset_name = $child[4];
 $warranty_from = $child[5];
 $warranty_to = $child[6];
 $description = $child[7];
 $maintanance_schedule = $child[8]; 
 $current_date = date('d-m-Y');
 $asset_id = (int)$child[9];
 
 
$purchase_date2 = date('Y-m-d',strtotime($purchase_date));
 

$this->loadmodel('fix_asset');
$this->fix_asset->updateAll(array("asset_category_id" => $asset_category_id,"asset_name" => $asset_name, "description" => $description, 
"purchase_date" => strtotime($purchase_date2), "cost_of_purchase" => $cost_of_purchase, 
"asset_supplier_id" => $assert_supplier_id,"warranty_period_from" => $warranty_from,
"warranty_period_to" => $warranty_to, "maintanance_schedule" => $maintanance_schedule),array("society_id" => (int)$s_society_id,"fix_asset_id" =>$asset_id));


$this->loadmodel('ledger');
$this->ledger->updateAll(array("ledger_account_id" => $asset_category_id,"debit"=>$cost_of_purchase,"transaction_date"=>strtotime($purchase_date2)),array("society_id" => (int)$s_society_id, "element_id" =>$asset_id,"table_name"=>"fix_asset","ledger_sub_account_id" => null));

$this->loadmodel('ledger');
$this->ledger->updateAll(array("ledger_sub_account_id" => $assert_supplier_id,"credit"=>$cost_of_purchase,"transaction_date"=>strtotime($purchase_date2)),array("society_id" => (int)$s_society_id, "element_id" => $asset_id,"table_name"=>"fix_asset","ledger_account_id" => 15));

}


$output=json_encode(array('type'=>'success','text'=>'Fixed Asset  is generated successfully'));
die($output); 


}
/////////////////////////End fix_asset_update_json /////////////////////////////////////	
}
?>