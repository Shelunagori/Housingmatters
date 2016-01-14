<?php
App::import('Controller', 'Hms');
class ClassifiedsController extends HmsController {
var $helpers = array('Html', 'Form','Js');
public $components = array(
'Paginator',
'Session','Cookie','RequestHandler'
);


var $name = 'Classifieds';

function post_ad(){
	if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
	$this->check_user_privilages();
	$this->ath();
	
	$this->loadmodel('master_classified_category');
	$this->set('result_select_category',$this->master_classified_category->find('all'));

}


function classified_buy($id=null)
{
	
		if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
	$this->check_user_privilages();
	$this->ath();
	$this->set('id',$id);
	
	$this->loadmodel('classified');
	$conditions=array('delete'=>0,'draft'=>0,'ad_type'=>'2');
	$order=array('classified.classified_id'=>'DESC');
	$result_classifieds=$this->classified->find('all',array('conditions'=>$conditions,'order'=>$order));
	$this->set('result_classifieds',$result_classifieds);
	foreach($result_classifieds as $data){
		$this->seen_notification(21,$data["classified"]["classified_id"]);
	}
	
	
}


function classified_sel($id=null)
{
	
		if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
	$this->check_user_privilages();
	$this->ath();
	$this->set('id',$id);
	
	$this->loadmodel('classified');
	$conditions=array('delete'=>0,'draft'=>0,'ad_type'=>'1');
	$order=array('classified.classified_id'=>'DESC');
	$result_classifieds=$this->classified->find('all',array('conditions'=>$conditions,'order'=>$order));
	$this->set('result_classifieds',$result_classifieds);
	foreach($result_classifieds as $data){
		$this->seen_notification(21,$data["classified"]["classified_id"]);
	}
	
	
}




function classified_ads($id=null){
	if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
	$this->check_user_privilages();
	$this->ath();
	$this->set('id',$id);
	
	$this->loadmodel('classified');
	$conditions=array('delete'=>0,'draft'=>0);
	$order=array('classified.classified_id'=>'DESC');
	$result_classifieds=$this->classified->find('all',array('conditions'=>$conditions,'order'=>$order));
	$this->set('result_classifieds',$result_classifieds);
	foreach($result_classifieds as $data){
		$this->seen_notification(21,$data["classified"]["classified_id"]);
	}
}


function view_ad_buy($id=null)
{
	$this->layout=null;
	$this->ath();
	$id=(int)$id;
	$this->loadmodel('classified');
	$conditions=array('classified_id'=>$id);
	$result_classified=$this->classified->find('all',array('conditions'=>$conditions));
	$this->set('result_classified',$result_classified);
	
	$this->loadmodel('classified');
	$conditions=array('classified_id' => array('$gt'=>$id),'delete'=>0,'draft'=>0,'ad_type'=>'2');
	$result_next=$this->classified->find('all',array('conditions'=>$conditions,'limit'=>1));
	if(sizeof($result_next)==0){
		$conditions=array('classified_id' => array('$gte'=>1),'delete'=>0,'draft'=>0,'ad_type'=>'2');
		$result_next=$this->classified->find('all',array('conditions'=>$conditions,'limit'=>1));
	}
	$this->set('result_next',$result_next[0]["classified"]["classified_id"]);
	
	$this->loadmodel('classified');
	$conditions=array('classified_id' => array('$lt'=>$id),'delete'=>0,'draft'=>0,'ad_type'=>'2');
	$result_prv=$this->classified->find('all',array('conditions'=>$conditions,'limit'=>1));
	if(sizeof($result_prv)==0){
		$count_all=$this->classified->find('count');
		
		$conditions=array('classified_id' => array('$lte'=>$count_all),'delete'=>0,'draft'=>0,'ad_type'=>'2');
		$result_prv=$this->classified->find('all',array('conditions'=>$conditions,'limit'=>1));
	}
	$this->set('result_prv',$result_next[0]["classified"]["classified_id"]);
	
}


function view_ad_sel($id=null)
{
	$this->layout=null;
	$this->ath();
	$id=(int)$id;
	$this->loadmodel('classified');
	$conditions=array('classified_id'=>$id);
	$result_classified=$this->classified->find('all',array('conditions'=>$conditions));
	$this->set('result_classified',$result_classified);
	
	$this->loadmodel('classified');
	$conditions=array('classified_id' => array('$gt'=>$id),'delete'=>0,'draft'=>0,'ad_type'=>'1');
	$result_next=$this->classified->find('all',array('conditions'=>$conditions,'limit'=>1));
	if(sizeof($result_next)==0){
		$conditions=array('classified_id' => array('$gte'=>1),'delete'=>0,'draft'=>0,'ad_type'=>'1');
		$result_next=$this->classified->find('all',array('conditions'=>$conditions,'limit'=>1));
	}
	$this->set('result_next',$result_next[0]["classified"]["classified_id"]);
	
	$this->loadmodel('classified');
	$conditions=array('classified_id' => array('$lt'=>$id),'delete'=>0,'draft'=>0,'ad_type'=>'1');
	$result_prv=$this->classified->find('all',array('conditions'=>$conditions,'limit'=>1));
	if(sizeof($result_prv)==0){
		$count_all=$this->classified->find('count');
		
		$conditions=array('classified_id' => array('$lte'=>$count_all),'delete'=>0,'draft'=>0,'ad_type'=>'1');
		$result_prv=$this->classified->find('all',array('conditions'=>$conditions,'limit'=>1));
	}
	$this->set('result_prv',$result_next[0]["classified"]["classified_id"]);
	
}


function view_ad_ajax($id=null){
	$this->layout=null;
	$this->ath();
	$id=(int)$id;
	$this->loadmodel('classified');
	$conditions=array('classified_id'=>$id);
	$result_classified=$this->classified->find('all',array('conditions'=>$conditions));
	$this->set('result_classified',$result_classified);
	
	$this->loadmodel('classified');
	$conditions=array('classified_id' => array('$gt'=>$id),'delete'=>0,'draft'=>0);
	$result_next=$this->classified->find('all',array('conditions'=>$conditions,'limit'=>1));
	if(sizeof($result_next)==0){
		$conditions=array('classified_id' => array('$gte'=>1),'delete'=>0,'draft'=>0);
		$result_next=$this->classified->find('all',array('conditions'=>$conditions,'limit'=>1));
	}
	$this->set('result_next',$result_next[0]["classified"]["classified_id"]);
	
	$this->loadmodel('classified');
	$conditions=array('classified_id' => array('$lt'=>$id),'delete'=>0,'draft'=>0);
	$result_prv=$this->classified->find('all',array('conditions'=>$conditions,'limit'=>1));
	if(sizeof($result_prv)==0){
		$count_all=$this->classified->find('count');
		
		$conditions=array('classified_id' => array('$lte'=>$count_all),'delete'=>0,'draft'=>0);
		$result_prv=$this->classified->find('all',array('conditions'=>$conditions,'limit'=>1));
	}
	$this->set('result_prv',$result_next[0]["classified"]["classified_id"]);
}

function intrested_in_classified_ajax($id=null){
	$this->layout=null;
	$this->ath();
	$id=(int)$id;
	$this->loadmodel('classified');
	$conditions=array('classified_id'=>$id);
	$result_classified=$this->classified->find('all',array('conditions'=>$conditions));
	$this->set('result_classified',$result_classified);
	
	$user_id=$result_classified[0]["classified"]["user_id"];
	$result_user=$this->profile_picture($user_id);
	$this->set('result_user',$result_user);
}

function send_message_ajax(){
	$this->layout=null;
	$this->ath();
	$id=(int)$this->request->query('con');
	$m=$this->request->query('con1');
	$m=nl2br($m);
	$this->loadmodel('classified');
	$conditions=array('classified_id'=>$id);
	$result_classified=$this->classified->find('all',array('conditions'=>$conditions));
	$user_id=$result_classified[0]["classified"]["user_id"];
	$result_user=$this->profile_picture($user_id);
	$mobile=$result_user[0]["user"]["mobile"];
	$email=$result_user[0]["user"]["email"];
	@$ip=$this->hms_email_ip();
	if(!empty($email)){
		$to=$email;
		$this->loadmodel('email');
		$conditions=array('auto_id'=>3);
		$result_email=$this->email->find('all',array('conditions'=>$conditions));
		foreach ($result_email as $collection) 
		{
		$from=$collection['email']['from'];
		}
		$from_name="HousingMatters";
		$subject="Interested";
		$reply="donotreply@housingmatters.in";
		 $message_web="<div>
			<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
			<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
			<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>
	
			<p><b>Message:-</b>$m</p>
			<br/>
			<p> www.housingmatters.co.in </p>
			</div>";
		$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
		
	}else{
		

		// sms code 
	}
}

function submit_ad(){
	$this->layout=null;
	$post_data=$this->request->data;
	
	$this->ath();
	$s_society_id=$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$date=date('d-m-Y');
	$time = date(' h:i a', time());
	$cat_id=$post_data["cat_id"];
	if(!empty($cat_id)){
		$cat_id_ar=explode(',',$cat_id);
		$category=(int)$cat_id_ar[0];
		$sub_category=(int)$cat_id_ar[1];
	}
	$title=$post_data["title"]; 
	$description=$post_data["description"];
	$price=$post_data["price"];
	$price_type=$post_data["price_type"];
	$ad_type=$post_data["ad_type"];
	$condition=$post_data["condition"];
	$offer=$post_data["offer"];
	$report=array();
	if(empty($cat_id)){
		$report[]=array('label'=>'cat_id', 'text' => 'Please select category');
	}
	if(empty($title)){
		$report[]=array('label'=>'title', 'text' => 'Please fill title');
	}
	if(empty($price)){
		$report[]=array('label'=>'price', 'text' => 'Please fill price');
	}
	if(empty($price_type)){
		$report[]=array('label'=>'price_type', 'text' => 'Please select price_type');
	}
	if(empty($ad_type)){
		$report[]=array('label'=>'ad_type', 'text' => 'Please fill ad_type');
	}
	if(empty($condition)){
		$report[]=array('label'=>'condition', 'text' => 'Please fill condition');
	}
	if(empty($description)){
		$report[]=array('label'=>'description', 'text' => 'Please fill description');
	}
	if(sizeof($report)>0){
		$output=json_encode(array('report_type'=>'error','report'=>$report));
		die($output);
	}
	
	if($post_data['post_type']==1){
		
		
		if(isset($_FILES['file'])){
		$file_name=@$_FILES['file']['name'];
		$file_tmp_name =@$_FILES['file']['tmp_name'];
		$target = "Classifieds/";
		$target=@$target.basename($file_name);
		move_uploaded_file($file_tmp_name,@$target);
		}

		$classified_id=$this->autoincrement('classified','classified_id');
		$this->loadmodel('classified');
		$this->classified->save(array('classified_id' => $classified_id, 'category' => $category, 'sub_category' => $sub_category, 'title' => $title ,'price' => $price , 'price_type' => $price_type, 'ad_type' => $ad_type, 'condition' => $condition,'offer' => $offer, 'description' => $description, 'delete' => 0,'draft' => 0,'user_id' => $s_user_id,'society_id' => $s_society_id,'file' => @$file_name));
				
		@$ip=$this->hms_email_ip();
		
		$this->loadmodel('notification_email');
		$conditions=array('module_id'=>3,'chk_status'=>0);
		$result_users=$this->notification_email->find('all',array('conditions'=>$conditions));
		
		$this->loadmodel('email');
		$conditions=array('auto_id'=>3);
		$result_email=$this->email->find('all',array('conditions'=>$conditions));
		foreach ($result_email as $collection) 
		{
		$from=$collection['email']['from'];
		}
		$from_name="HousingMatters";
		$reply="donotreply@housingmatters.in";
		$society_result=$this->society_name($s_society_id);
		foreach($society_result as $data)
		{
		$society_name=$data['society']['society_name'];
		}
		
		foreach($result_users as $data){
			$user_id=$data["notification_email"]["user_id"];
			$result_user=$this->profile_picture($user_id);
			@$user_name=@$result_user[0]['user']['user_name'];
			@$to=@$result_user[0]['user']['email'];
			@$deactive=@$result_user[0]['user']['deactive'];
			if($deactive==0)
			{
			 $message_web="<div>
			<img src='$ip".$this->webroot."/as/hm/hm-logo.png'/><span  style='float:right; margin:2.2%;'>
			<span class='test' style='margin-left:5px;'><a href='https://www.facebook.com/HousingMatters.co.in' target='_blank' ><img src='$ip".$this->webroot."/as/hm/fb.png'/></a></span>
			<a href='#' target='_blank'><img src='$ip".$this->webroot."/as/hm/tw.png'/></a><a href'#'><img src='$ip".$this->webroot."/as/hm/ln.png'/ class='test' style='margin-left:5px;'></a></span>

			</br><p>Dear  $user_name,</p>
			<p>A new Classified ad has been posted.</p>
			
			<div>
			
			<center><p>To view / respond
			<a href='$ip".$this->webroot."hms'><button style='width:100px; height:30px;  background-color:#00A0E3;color:white'> Click Here </button></a></p></center><br/>
			<br/>
			<p>For any software related queries, please contact <span style='color:#00A0E3;'> support@housingmatters.in </span></p>
			www.housingmatters.co.in
			</div>
			</div>";
			
		@$subject.= '['. $society_name . ']' .' New Classified ad created';
		if(!empty($to))
		{
		$this->send_email($to,$from,$from_name,$subject,$message_web,$reply);
		$subject="";
		}
		}
		}
			
		
		$this->loadmodel('user');
		$conditions=array('deactive'=>0);
		$result_users=$this->user->find('all',array('conditions'=>$conditions));
		foreach($result_users as $data){
			$users[]=$data["user"]["user_id"];
		}
		
		$this->send_notification('<span class="label" style="background-color:#1BBC9B;"><i class="icon-shopping-cart"></i></span>','New Classified Ad <b>'.$title.'</b> posted ',21,$classified_id,$this->webroot.'Classifieds/classified_ads/',0,$users);
		
		$output=json_encode(array('report_type'=>'publish','report'=>'Your Classified ad has been published successfully.'));
		die($output);
	}
	if($post_data['post_type']==2){
		
		if(isset($_FILES['file'])){
			$file_name=@$_FILES['file']['name'];
		$file_tmp_name =@$_FILES['file']['tmp_name'];
		$target = "Classifieds/";
		$target=@$target.basename($file_name);
		move_uploaded_file($file_tmp_name,@$target);
		}
		
		$classified_id=$this->autoincrement('classified','classified_id');
		$this->loadmodel('classified');
		$this->classified->save(array('classified_id' => $classified_id, 'category' => $category, 'sub_category' => $sub_category, 'title' => $title ,'price' => $price , 'price_type' => $price_type, 'ad_type' => $ad_type, 'condition' => $condition,'offer' => $offer, 'description' => $description, 'delete' => 0,'draft' => 1,'user_id' => $s_user_id,'society_id' => $s_society_id,'file' => @$file_name));
		
		$output=json_encode(array('report_type'=>'publish','report'=>'Your Classified ad has been saved as draft successfully.'));
		die($output);
	}
	
}


}
?>