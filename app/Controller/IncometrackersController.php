<?php
App::import('Controller','Hms');
class IncometrackersController extends HmsController {
var $helpers = array('Html', 'Form','Js');

public $components = array(
'Paginator',
'Session','Cookie','RequestHandler'
);
var $name = 'Incometrackers';

function fetch_last_receipts_info_via_flat_id_for_no_bill($flat_id){
	$this->loadmodel('new_cash_bank');
	$condition=array( '$or' => array( 
		array('flat_id'=>(int)$flat_id,'receipt_type'=>"1",'edit_status'=>"NO"),
		array('flat_id'=>(int)$flat_id,'receipt_type'=>1,'edit_status'=>"NO"),
		));
	return $this->new_cash_bank->find('all',array('conditions'=>$condition));
}

function add_new_party_account_head($party_name=null){
	$this->layout=null;
	$s_society_id = (int)$this->Session->read('society_id');
	if(!empty($party_name)){
		
			$sp_date=date("d-m-y");
			$sp_time=date('h:i:a',time());
							
		$this->loadmodel('ledger_sub_account');
		$auto_id=@$this->autoincrement('ledger_sub_account','auto_id');
		$this->ledger_sub_account->saveAll(array('auto_id'=>$auto_id,'ledger_id'=>97,'name'=>$party_name,'society_id'=>$s_society_id));
						
		echo "OK"; exit;
	}
}
/////////////////////////Start It Regular Bill (Accounts) //////////////////////////////////////
function it_regular_bill()
{
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}

		$this->ath();
		$this->check_user_privilages();

			$s_role_id=$this->Session->read('role_id');
			$s_society_id = (int)$this->Session->read('society_id');
			$s_user_id=$this->Session->read('user_id');	

				$this->loadmodel('society');
				$conditions=array("society_id" => $s_society_id);
				$socct1=$this->society->find('all',array('conditions'=>$conditions));
				$this->set('socct1',$socct1);

	$this->loadmodel('flat_type');
	$conditions=array("society_id" => $s_society_id);
	$flat_tpp=$this->flat_type->find('all',array('conditions'=>$conditions));
	$this->set('flat_tpp',$flat_tpp);

		$this->loadmodel('regular_bill');
		$conditions=array("society_id" => $s_society_id,"status"=>0,"bill_for_user"=>$s_user_id);
		$cursor=$this->regular_bill->find('all',array('conditions'=>$conditions));
		foreach($cursor as $collection)
		{
		$ele_id=(int)@$collection['regular_bill']['receipt_id'];
		}

		$this->loadmodel('financial_year');
		$conditions=array("society_id" => $s_society_id, "status"=>1);
		$cursor=$this->financial_year->find('all',array('conditions'=>$conditions));
		foreach($cursor as $collection)
		{
		$date_from = @$collection['financial_year']['from'];
		$date_to = @$collection['financial_year']['to'];

			$date_from1 = date('Y-m-d',$date_from->sec);
			$date_to1 = date('Y-m-d',$date_to->sec);

		$datef[] = $date_from1;
		$datet[] = $date_to1;
		}
		
			if(!empty($datef))
			{
			$datef1 = implode(',',$datef);
			$datet1 = implode(',',$datet);
			}
			
				$count = sizeof(@$datef);
				$this->set('datef1',@$datef1);
				$this->set('datet1',@$datet1);
				$this->set('count',$count);

		$this->loadmodel('new_regular_bill');
		$order=array('new_regular_bill.auto_id'=> 'ASC');
		$conditions=array("society_id" => $s_society_id);
		$cursor=$this->new_regular_bill->find('all',array('conditions'=>$conditions,'order' =>$order));
		foreach ($cursor as $collection) 
		{
		$d_from = $collection['new_regular_bill']['bill_start_date'];
		$d_to = $collection['new_regular_bill']['bill_end_date'];
		}

			if(!empty($d_from))
			{
			$datefb = date('Y-m-d',($d_from));
			$datetb = date('Y-m-d',$d_to);

			$this->set('datefb',$datefb);
			$this->set('datetb',$datetb);
			}

				if(isset($this->request->data['sub1']))
				{
					$from = $this->request->data['from'];//billing start date
					@$penalty = $this->request->data['pen'];//panalty yes/no
					$due_date = $this->request->data['due_date'];
					$description = $this->request->data['description'];
					$period_id = (int)$this->request->data['bill_p']; 
					$fromm = date("Y-m-d", strtotime($from));
					$fromm = new MongoDate(strtotime($fromm));
					$bill_for = (int)$this->request->data['bill_for'];
	
						if($bill_for == 1){
						$this->loadmodel('wing');
						$conditions=array("society_id" => $s_society_id);
						$cursor = $this->wing->find('all',array('conditions'=>$conditions));
						foreach($cursor as $collection)
						{
						$wing_id = (int)$collection['wing']['wing_id'];
						$wing_for_bill = @$this->request->data['wing'.$wing_id];
						$wing_arr[] = $wing_for_bill;
						}
				}
			@$wing_imp = implode(",",@$wing_arr);
	
				if($period_id == 1)
				{
				$to = date('Y-m-d', strtotime("+1 months", strtotime($from)));
				$to = date('Y-m-d', strtotime("-1 days", strtotime($to)));
				}
				else if($period_id == 3)
				{
				$to = date('Y-m-d', strtotime("+3 months", strtotime($from)));
				$to = date('Y-m-d', strtotime("-1 days", strtotime($to)));
				}
				else if($period_id == 4)
				{
				$to = date('Y-m-d', strtotime("+6 months", strtotime($from)));
				$to = date('Y-m-d', strtotime("-1 days", strtotime($to)));
				}
				else if($period_id == 2)
				{
				$to = date('Y-m-d', strtotime("+2 months", strtotime($from)));
				$to = date('Y-m-d', strtotime("-1 days", strtotime($to)));
				}
				else if($period_id == 5)
				{
				$to = date('Y-m-d', strtotime("+12 months", strtotime($from)));
				$to = date('Y-m-d', strtotime("-1 days", strtotime($to)));
				}

		$tom = date("Y-m-d", strtotime($to));
		$tom = new MongoDate(strtotime($tom));

			$due_date55 = date("Y-m-d", strtotime($due_date));
			$due_date55 = new MongoDate(strtotime($due_date55));

				$f1=$this->encode($from,'housingmatters');
				$t1=$this->encode($to,'housingmatters');
				$due1=$this->encode($due_date,'housingmatters');
				$desc1=$this->encode($description,'housingmatters');
				$p_id = $this->encode($period_id,'housingmatters');
				$pen = $this->encode($penalty,'housingmatters');
				$wing_imp_en = $this->encode($wing_imp,'housingmatters');
				$bill_for_en = $this->encode($bill_for,'housingmatters');

	$this->response->header('Location','regular_bill_preview_screen_new?f='.$f1.'&t='.$t1.'&due='.$due1.'&d='.$desc1.'&p='.$p_id.'&pen='.$pen.'&wi='.$wing_imp_en.'&bi='.$bill_for_en.' ');
	
}

	$this->loadmodel('income_head');
	$conditions=array("society_id" => $s_society_id,"delete_id"=>0);
	$cursor1=$this->income_head->find('all',array('conditions'=>$conditions));
	$this->set('cursor1',$cursor1);		
		
		$this->loadmodel('ledger_sub_account');
		$conditions=array("society_id"=>$s_society_id, "ledger_id" => 35);
		$cursor2=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
		$this->set('cursor2',$cursor2);			
		
			$this->loadmodel('terms_condition');
			$conditions=array("society_id"=>$s_society_id,"status" => 1);
			$cursor3=$this->terms_condition->find('all',array('conditions'=>$conditions));
			$this->set('cursor3',$cursor3);				

				$this->loadmodel('bill_period');
				$conditions=array("society_id" => $s_society_id,"status"=>1);
				$cursor4 = $this->bill_period->find('all',array('conditions'=>$conditions));
				$this->set('cursor4',$cursor4);

		$this->loadmodel('wing');
		$conditions=array("society_id" => $s_society_id);
		$cursor5 = $this->wing->find('all',array('conditions'=>$conditions));
		$this->set('cursor5',$cursor5);

			$this->loadmodel('reference');
			$conditions=array("auto_id"=>2);
			$cursor = $this->reference->find('all',array('conditions'=>$conditions));
			foreach($cursor as $collection)
			{
			$bill_period_arr = $collection['reference']['reference'];
			}
	$this->set('bill_period_arr',$bill_period_arr);
}
/////////////////////// End It Regular Bill (Accounts) ////////////////////////////////////////////////////////////

////////////////////////// Start fetch_last_bill_info_via_flat_id ///////////////////////////////////////////////
function fetch_last_bill_info_via_flat_id($flat_id){
	$s_society_id =(int)$this->Session->read('society_id');
	$this->loadmodel('new_regular_bill');
	$condition=array('society_id'=>$s_society_id,"flat_id"=>$flat_id,'edit_status'=>"NO");
	$order=array('new_regular_bill.one_time_id'=>'DESC');
	$result_new_regular_bill=$this->new_regular_bill->find('first',array('conditions'=>$condition,'order'=>$order)); 
	if(sizeof($result_new_regular_bill)>0){
		return $result_new_regular_bill;
	}else{
		$this->loadmodel('new_regular_bill');
		$condition=array('society_id'=>$s_society_id,"flat_id"=>$flat_id);
		$order=array('new_regular_bill.one_time_id'=>'DESC');
		return $result_new_regular_bill=$this->new_regular_bill->find('first',array('conditions'=>$condition,'order'=>$order)); 
	}
}
////////////////////////// End fetch_last_bill_info_via_flat_id ///////////////////////////////////////////////


function fetch_last_receipt_info_via_flat_id($flat_id,$bill_one_time_id){
	$s_society_id =(int)$this->Session->read('society_id');
	$this->loadmodel('new_cash_bank');
	$condition=array('society_id'=>$s_society_id,"flat_id"=>(int)$flat_id,"bill_one_time_id"=>(int)$bill_one_time_id,"edit_status"=> "NO","is_cancel"=> "NO");
	$order=array('new_cash_bank.bill_one_time_id'=>'DESC');
	return $this->new_cash_bank->find('all',array('conditions'=>$condition,'order'=>$order)); 
}

////////////////////////// Start fetch_last_receipt_info_via_flat_id ////////////////////////////////////////////

////////////////////////// End fetch_last_receipt_info_via_flat_id ////////////////////////////////////////////

////////////////////////// Start fetch_opening_balance_via_user_id ////////////////////////////////////////////
function fetch_opening_balance_via_user_id($flat_id){
	$s_society_id =(int)$this->Session->read('society_id');
	$this->loadmodel('ledger_sub_account');
	$condition=array('flat_id'=>$flat_id);
	$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$condition)); 
	foreach($result_ledger_sub_account as $data){
		$auto_id=(int)$data["ledger_sub_account"]["auto_id"];
	}
	$this->loadmodel('ledger');
	$condition=array('ledger_sub_account_id'=>@$auto_id,"table_name"=>"opening_balance");
	return $result_ledger=$this->ledger->find('all',array('conditions'=>$condition));
}
////////////////////////// End fetch_opening_balance_via_user_id ////////////////////////////////////////////

////////////////////////// Start receipt ////////////////////////////////////////////
function receipt(){

		if($this->RequestHandler->isAjax()){
		$this->layout='blank';
		}else{
		$this->layout='session';
		}
			$this->ath();
	
		$s_society_id =(int)$this->Session->read('society_id');
		$s_role_id=$this->Session->read('role_id');
		$s_user_id=$this->Session->read('user_id');
	
			$amount=100; $flat_id=1; $receipt_date="2015-6-10";
			$this->loadmodel('new_regular_bill');
			$condition=array('society_id'=>$s_society_id,"flat_id"=>$flat_id);
			$order=array('new_regular_bill.one_time_id'=>'DESC');
			$result_new_regular_bill=$this->new_regular_bill->find('first',array('conditions'=>$condition,'order'=>$order)); 
			$this->set('result_new_regular_bill',$result_new_regular_bill);
			foreach($result_new_regular_bill as $data){
				$auto_id=$data["auto_id"]; 
				$arrear_intrest=$data["arrear_intrest"];
				$intrest_on_arrears=$data["intrest_on_arrears"];
				$total=$data["total"];
				$arrear_maintenance=$data["arrear_maintenance"];
			}
	
		$amount_after_arrear_intrest=$amount-$arrear_intrest;
			if($amount_after_arrear_intrest<0){
				$new_arrear_intrest=abs($amount_after_arrear_intrest);
				$new_intrest_on_arrears=$intrest_on_arrears;
				$new_arrear_maintenance=$arrear_maintenance;
				$new_total=$total;
			}else{
		$new_arrear_intrest=0;
		$amount_after_intrest_on_arrears=$amount_after_arrear_intrest-$intrest_on_arrears;
		if($amount_after_intrest_on_arrears<0){
			$new_intrest_on_arrears=abs($amount_after_intrest_on_arrears);
			$new_arrear_maintenance=$arrear_maintenance;
			$new_total=$total;
		}else{
			$new_intrest_on_arrears=0;
			
			$amount_after_arrear_maintenance=$amount_after_intrest_on_arrears-$arrear_maintenance;
			if($amount_after_arrear_maintenance<0){
				$new_arrear_maintenance=abs($amount_after_arrear_maintenance);
				$new_total=$total;
			}else{
				$new_arrear_maintenance=0;
				$amount_after_total=$amount_after_arrear_maintenance-$total; 
				if($amount_after_total>0){
					$new_total=0;
					$new_arrear_maintenance=-$amount_after_total;
				}else{
					$new_total=abs($amount_after_total);
					
				}
				
			}
		}
	}

	
	$this->loadmodel('new_regular_bill');
	$this->new_regular_bill->updateAll(array('new_arrear_intrest'=>$new_arrear_intrest,"new_intrest_on_arrears"=>$new_intrest_on_arrears,"new_arrear_maintenance"=>$new_arrear_maintenance,"new_total"=>$new_total),array('auto_id'=>$auto_id));
	
	
	
	$result_new_regular_bill = $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_last_bill_info_via_flat_id'),array('pass'=>array($flat_id)));
	if(sizeof($result_new_regular_bill)==1){
		foreach($result_new_regular_bill as $last_bill){
			$bill_auto_id=$last_bill["auto_id"];
			$bill_one_time_id=$last_bill["one_time_id"];
		}
	}
			
			
	$this->loadmodel('new_cash_bank');
	$auto_id=$this->autoincrement('new_cash_bank','auto_id');
	$this->new_cash_bank->saveAll(array("auto_id" => $auto_id, "flat_id" => $flat_id, "amount" => $amount,"receipt_date"=>$receipt_date,"bill_auto_id"=>$bill_auto_id,"bill_one_time_id"=>$bill_one_time_id,"society_id"=>$s_society_id));

	
}
function regular_bill_preview_screen_new(){
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout=null;
	}
	$this->ath();
	
	$s_society_id =(int)$this->Session->read('society_id');
	$s_role_id=$this->Session->read('role_id');
	$s_user_id=$this->Session->read('user_id');	
	
	$webroot_path=$this->requestAction(array('controller' => 'Hms', 'action' => 'webroot_path'));
	
	$from3 = $this->request->query('f');
	$to3 = $this->request->query('t');
	$due_date3 = $this->request->query('due');
	$desc3 = $this->request->query('d');
	$p_id = $this->request->query('p');
	$pen = $this->request->query('pen'); 
	$wing_arr_en = $this->request->query('wi');
	$bill_for_en = $this->request->query('bi');

	$bill_start_date = date("Y-m-d",strtotime($this->decode($from3,'housingmatters'))); 
	$bill_end_date = date("Y-m-d",strtotime($this->decode($to3,'housingmatters'))); 
	$due_date = date("Y-m-d",strtotime($this->decode($due_date3,'housingmatters'))); 
	$description = $this->decode($desc3,'housingmatters');
	$period_id = (int)$this->decode($p_id,'housingmatters');
	$penalty = (int)$this->decode($pen,'housingmatters');
	$wing_arr_im = $this->decode($wing_arr_en,'housingmatters');
	$bill_for = (int)$this->decode($bill_for_en,'housingmatters');
	
	if($bill_for==1){
		$wing_array=array_filter(explode(',',$wing_arr_im));
		$this->set("wing_array",$wing_array);
	}else{
		$wing_array=array();
		$this->set("wing_array",$wing_array);
	}
	

	$this->set('bill_for',$bill_for);
	$this->set('wing_arr_im',$wing_arr_im);
	$this->set('period_id',$period_id);
	$this->set('bill_start_date',$bill_start_date);
	$this->set('bill_end_date',$bill_end_date);
	$this->set('due_date',$due_date);
	$this->set('description',$description);
	$this->set('is_penalty',$penalty);
	
	
	$this->loadmodel('society');
	$condition=array('society_id'=>$s_society_id);
	$result_society=$this->society->find('all',array('conditions'=>$condition)); 
	$this->set('result_society',$result_society);
	foreach($result_society as $data){
		$society_name=$data["society"]["society_name"];
		$society_reg_num=$data["society"]["society_reg_num"];
		$society_address=$data["society"]["society_address"];
		$society_email=$data["society"]["society_email"];
		$society_phone=$data["society"]["society_phone"];
		$terms_conditions=$data["society"]["terms_conditions"];
		$signature=$data["society"]["signature"];
		$sig_title=$data["society"]["sig_title"];
	    $neft_type = @$data["society"]["neft_type"];
	    $neft_detail = @$data["society"]["neft_detail"];
	    $society_logo = @$data["society"]["logo"];
		$area_scale = (int)@$data["society"]["area_scale"];
		}
		
		
		$this->loadmodel('ledger_sub_account');
		$condition=array('society_id'=>$s_society_id,'ledger_id'=>34,'deactive'=>0);
		$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$condition));
		$this->set('result_ledger_sub_account',$result_ledger_sub_account);
		foreach($result_ledger_sub_account as $ledger_sub_account){
			$ledger_sub_account_user_id=$ledger_sub_account["ledger_sub_account"]["user_id"];
			$ledger_sub_account_flat_id=$ledger_sub_account["ledger_sub_account"]["flat_id"];
				$flats_for_bill[]=$ledger_sub_account_flat_id;
		}
		///order asc wing and flat/////
		$this->loadmodel('wing');
		$condition=array('society_id'=>$s_society_id);
		$order=array('wing.wing_name'=>'ASC');
		$result_wing=$this->wing->find('all',array('conditions'=>$condition,'order'=>$order));
		foreach($result_wing as $wing_info){
			$wing_id=$wing_info["wing"]["wing_id"];
			$this->loadmodel('flat');
			$condition=array('wing_id'=>(int)$wing_id);
			$order=array('flat.flat_name'=>'ASC');
			$result_flat=$this->flat->find('all',array('conditions'=>$condition,'order'=>$order));
			foreach($result_flat as $flat_info){
				$flat_id=$flat_info["flat"]["flat_id"];
				if (in_array($flat_id, $flats_for_bill)) {
					$new_flats_for_bill[]=$flat_id;
				}
			}
		}
		$this->set('new_flats_for_bill',$new_flats_for_bill);
		
	
		$this->loadmodel('user');
		$condition=array('society_id'=>$s_society_id,'tenant'=>1,'deactive'=>0);
		$result_user=$this->user->find('all',array('conditions'=>$condition));
		$this->set('result_user',$result_user);
		
		foreach($flats_for_bill as $flat_id){
			$this->loadmodel('flat');
			$condition=array('flat_id'=>$flat_id);
			$result_flat=$this->flat->find('all',array('conditions'=>$condition));
			$other_charges=@$result_flat[0]["flat"]["other_charges"];
			
			if(sizeof($other_charges)>0){
				$other_charges_array[$flat_id]=$other_charges;
			}
		}
		
		if(sizeof(@$other_charges_array)>0){
			foreach($other_charges_array as $other_charges_data){
				foreach($other_charges_data as $key=>$vlaue){
					$other_charges_ids[]=$key;
				}
			} 
			$other_charges_ids=array_unique($other_charges_ids);
			
			$this->set('other_charges_ids',$other_charges_ids);
		}
		
		$this->set('other_charges_array',@$other_charges_array);

			
			//submit code//
	if(isset($this->request->data['generate_bill'])){
		$inc=0;
		$this->loadmodel('new_regular_bill');
		$condition=array('society_id'=>$s_society_id,"bill_start_date"=>strtotime($bill_start_date));
		$result_bill_start_date=$this->new_regular_bill->find('all',array('conditions'=>$condition));
		
		if($bill_for==1 && (sizeof($result_bill_start_date)>0)){
			$one_time_id=$result_bill_start_date[0]["new_regular_bill"]["one_time_id"];
		}else{
			$one_time_id=$this->autoincrement_with_society('new_regular_bill','one_time_id');
		}
		
	
			
		
		foreach($new_flats_for_bill as $flat_data_id){ $inc++;
		    
			$flat_id = $flat_data_id;
			//$flat_id = (int)$this->request->data['flat_id'.$inc];
			//wing_id via flat_id//
			$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
			foreach($result_flat_info as $flat_info){
				  $wing_id=$flat_info["flat"]["wing_id"];
			}
			
			
			if(($bill_for==1 && in_array($wing_id,$wing_array)) || $bill_for==2){
			
			
			$bill_number = $this->request->data['bill_number'.$inc];
			
		
			
			$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing_id,$flat_id))); 
			
			$result_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_fetch2'),array('pass'=>array(@$flat_id,$wing_id))); 
			foreach($result_flat as $data2){
				 $sq_feet = @$data2['flat']['flat_area'];
			} 
			
			
			//user info via flat_id//
			$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wing_id,$flat_id)));
			foreach($result_user_info as $user_info){
				$user_id=$user_info["user"]["user_id"];
				$user_name=$user_info["user"]["user_name"];
			}
			
			$result_ledger_sub_account = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch3'),array('pass'=>array($flat_id)));
			foreach($result_ledger_sub_account as $ledger_sub_account)
			{
			$ledger_sub_account_id = (int)$ledger_sub_account['ledger_sub_account']['auto_id'];
			}
			
			foreach($result_society as $data){
				$income_heads=$data["society"]["income_head"];
			}
			foreach($income_heads as $income_head){
				$income_head_amount = (int)$this->request->data['income_head'.$income_head.$inc];
				$income_head_array[$income_head]=$income_head_amount;
			}
			
			$noc_charges = (int)@$this->request->data['noc_charges'.$inc];
			
		
			if(sizeof(@$other_charges_ids)>0){
				foreach($other_charges_ids as $other_charges_id){
					$flat_other_charges=@$other_charges_array[$flat_id];
					
					if(sizeof($flat_other_charges)>0){
						$other_charges_amount=(int)@$this->request->data['other_charges'.$other_charges_id.'_'.$inc];
						if(!empty($other_charges_amount)){
							$other_charges_insert[$other_charges_id]=$other_charges_amount;
						}
					}
				}
			}
			
			if(@$other_charges_insert==null){
				$other_charges_insert=array();
			}
			
			
						
			$total = (int)@$this->request->data['total'.$inc];
			$arrear_maintenance = (int)@$this->request->data['arrear_maintenance'.$inc];
			$arrear_intrest = (int)@$this->request->data['arrear_intrest'.$inc];
			$intrest_on_arrears = (int)@$this->request->data['intrest_on_arrears'.$inc];
			$credit_stock = @$this->request->data['credit_stock'.$inc];
			$due_for_payment = (int)@$this->request->data['due_for_payment'.$inc];

			
			$account_name = "";	
			$bank_name = "";
			$account_number = "";
			$branch = "";
			$ifsc_code = "";
				
			if($neft_type ==  "ALL"){
				$account_name = @$neft_detail['account_name'];	
				$bank_name = @$neft_detail['bank_name'];
				$account_number = @$neft_detail['account_number'];
				$branch = @$neft_detail['branch'];
				$ifsc_code = @$neft_detail['ifsc_code'];	
			}
			if($neft_type ==  "WW"){			
				$neft_detail2 = @$neft_detail[$wing_id];
				$account_name = @$neft_detail2['account_name'];	
				$bank_name = @$neft_detail2['bank_name'];
				$account_number = @$neft_detail2['account_number'];
				$branch = @$neft_detail2['branch'];
				$ifsc_code = @$neft_detail2['ifsc_code'];		
			}
	
			
			if($period_id!=1){
				$billing_period_text=date("M",strtotime($bill_start_date)).' - '.date("M",strtotime($bill_end_date)).'  '.date("Y",strtotime($bill_end_date));
			}else{
				$billing_period_text=date("M-Y",strtotime($bill_start_date));
			}
			
			if($area_scale==0 or $area_scale==null){
				$area_scale_text="sq.ft.";
			}
			if($area_scale==1){
				$area_scale_text="sq.mtr.";
			}
			@$ip=$this->hms_email_ip();

$bill_html='<div style="margin: 0px;">
        <table style="padding:24px;background-color:#34495e" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="main_table">
            <tbody><tr>
                <td>
                    <table style="padding:38px 30px 30px 30px;background-color:#fafafa" align="center" border="0" cellpadding="0" cellspacing="0" width="540">
                        <tbody>
						<tr>
							<td height="10">
							<table width="100%" class="hmlogobox">
								<tr>
									<td width="50%" style="padding: 10px 0px 0px 10px;"><img src="'.$ip.$this->webroot.'/as/hm/hm-logo.png" style="max-height: 60px; " height="60px" /></td>
									<td width="50%" align="right" valign="middle"  style="padding: 7px 10px 0px 0px;">
									<a href="https://www.facebook.com/HousingMatters.co.in"><img src="'.$ip.$this->webroot.'/as/hm/SMLogoFB.png"    style="max-height: 30px; height: 30px; width: 30px; max-width: 30px;" height="30px" width="30px" /></a>
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
									<td style="padding:2px;background-color:rgb(0,141,210);color:#fff" align="center" width="100%"><b>'.strtoupper($society_name).'</b></td>
								</tr>
							</tbody></table>
							<table style="font-size:12px" width="100%" cellspacing="0">
								<tbody>
								<tr>
									<td width="30%" style="border-bottom: solid 1px #767575;    border-top: solid 1px #767575;">';
									if(!empty($society_logo)){
									$bill_html.='<img src="'.$webroot_path.'/logo/'.$society_logo.'"  height="45px" width="45px">';	
									}
						$bill_html.='</td>
									<td style="padding:5px;border-bottom: solid 1px #767575;    border-top: solid 1px #767575;"  width="70%" align="right">
									<span style="color: rgb(100, 100, 99); ">Regn# &nbsp; '.$society_reg_num.'</span><br>
									<span style="color: rgb(100, 100, 99); ">'.$society_address.'</span><br><span>Email:</span><a href="mailto:'.$society_email.'" target="_blank" style="color:#000 !important;text-decoration: none;">'.$society_email.'</a> | <span>Phone : '.$society_phone.'</span>
									</td>
								</tr>
								</tbody>
							</table>
							<table style="font-size:12px" width="100%" cellspacing="0">
								<tbody><tr>
									<td style="padding: 0px 0 0 5px;"><b>Name:</b></td>
									<td>'.$user_name.'</td>
									<td><b>Flat/Shop No.:</b></td>
									<td>'.$wing_flat.'</td>
								</tr>
								<tr>
									<td style="padding: 0px 0 0 5px;"><b>Bill No.:</b></td>
									<td>'.$bill_number.'</td>
									<td><b>Area ('.$area_scale_text.'):</b></td>
									<td>'.$sq_feet.'</td>
								</tr>
								<tr>
									<td style="padding: 0px 0 0 5px;"><b>Bill Date:</b></td>
									<td>'.date("d-m-Y",strtotime($bill_start_date)).'</td>
									<td><b>Billing Period:</b></td>
									<td>'.$billing_period_text.'</td>
								</tr>
								<tr>
									<td style="padding: 0px 0 0 5px;"><b>Due Date:</b></td>
									<td>'.date("d-m-Y",strtotime($due_date)).'</td>
									<td><b>Description:</b></td>
									<td>'.$description.'</td>
								</tr>
							</tbody></table>
							<table style="font-size:12px;border-bottom: solid 1px #767575;" width="100%" cellspacing="0">
								<tbody><tr>
									<td style="padding: 0 0 0 5px;background-color:rgb(0,141,210);color:#fff;border-top: solid 1px #767575;border-bottom: solid 1px #767575;border-right: solid 1px #FFFFFF;" align="left" width="60%"><b>Particulars of charges</b></td>
									<td style="padding: 0 5px 0 0;background-color:rgb(0,141,210);color:#fff;border-top: solid 1px #767575;border-bottom: solid 1px #767575;" align="right" width="40%"><b>Amount (Rs.)</b> </td>
								</tr>';
								
								
							foreach($income_head_array as $key=>$value){
							$result_income_head = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($key)));	
								foreach($result_income_head as $data2){
									$income_head_name = $data2['ledger_account']['ledger_name'];
								}
								if(!empty($value)){
									$bill_html.='<tr>
										<td align="left" style="border-right: solid 1px #767575;padding: 0 0 0 5px;" >'.$income_head_name.'</td>
										<td align="right" style="padding: 0 5px 0 0;">'.$value.'</td>
									</tr>';
								}
							}
							
							
							if(!empty($noc_charges)){
							$bill_html.='<tr>
										<td align="left" style="border-right: solid 1px #767575;padding: 0 0 0 5px;" >Non Occupancy charges</td>
										<td align="right" style="padding: 0 5px 0 0;">'.$noc_charges.'</td>
									</tr>';
							}
							
							foreach($other_charges_insert as $key=>$vlaue){
								$result_income_head = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($key)));	
								foreach($result_income_head as $data2){
									$income_head_name = $data2['ledger_account']['ledger_name'];
								}
								
								$bill_html.='<tr>
										<td align="left" style="border-right: solid 1px #767575;padding: 0 0 0 5px;" >'.$income_head_name.'</td>
										<td align="right" style="padding: 0 5px 0 0;">'.$vlaue.'</td>
									</tr>';
							} 
							
							
							$bill_html.='</tbody></table>
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
												<td width="60%">'.$account_name.'</td>
											</tr>
											<tr>
												<td width="40%" style="padding: 0 0 0 5px;"><b>Account No.:</b></td>
												<td width="60%">'.$account_number.'</td>
											</tr>
											<tr>
												<td width="40%" style="padding: 0 0 0 5px;"><b>Bank Name:</b></td>
												<td width="60%">'.$bank_name.'</td>
											</tr>
											<tr>
												<td width="40%" style="padding: 0 0 0 5px;"><b>Branch Name:</b></td>
												<td width="60%">'.$branch.'</td>
											</tr>
											<tr>
												<td width="40%" style="padding: 0 0 0 5px;"><b>IFSC no.:</b></td>
												<td width="60%">'.$ifsc_code.'</td>
											</tr>
										</tbody></table>
									</td>
									<td width="40%" valign="top">
										<table style="font-size:12px" width="100%">
											<tbody><tr>
												<td align="right" width="70%">Total:</td>
												<td align="right" width="30%" style="padding: 0 5px 0 0;">'.$total.'</td>
											</tr>
											<tr>
												<td align="right">Interest on arrears:</td>
												<td align="right" style="padding: 0 5px 0 0;">'.$intrest_on_arrears.'</td>
											</tr>
											<tr>
												<td align="right">Arrears-Principal:</td>
												<td align="right" style="padding: 0 5px 0 0;">'.$arrear_maintenance.'</td>
											</tr>
											<tr>
												<td align="right">Arrears-Interest:</td>
												<td align="right" style="padding: 0 5px 0 0;">'.$arrear_intrest.'</td>
											</tr>';
								
								$credit_stock_text=$credit_stock;
								$bill_html.='<tr>
												<td align="right" width="60%">Credit/Adjustment:</td>
												<td align="right" width="40%" style="padding: 0 5px 0 0;">'.$credit_stock_text.'</td>
											</tr>';
								$bill_html.='<tr>
												<td align="right" width="60%"><b>Due For Payment:</b></td>
												<td align="right" width="40%" style="padding: 0 5px 0 0;">'.$due_for_payment.'</td>
											</tr>
										</tbody></table>
									</td>
								</tr>
							</tbody></table>';
							$due_for_payment = str_replace( ',', '', $due_for_payment );
							if($due_for_payment<0){
							$write_am_word="Nil";
							}else{
							$am_in_words=ucwords(strtolower($this->convert_number_to_words($due_for_payment)));
							$write_am_word="Rupees ".$am_in_words." Only";
							}
							$bill_html.='<table style="font-size:12px" width="100%" cellspacing="0">
								<tbody><tr>
									<td width="100%" style="font-size:12px;border-bottom: solid 1px #767575;padding: 0 0 0 5px;"><b>Due For Payment (in words) :</b> '.$write_am_word.'</td>
								</tr>
							</tbody></table>';
							$bill_html.='<table style="font-size:12px;border-bottom: dotted 1px;" width="100%" cellspacing="0">
								<tbody><tr>
									<td width="50%" style="padding:5px;" valign="top">
									<span>Remarks:</span><br>';
									$inc_t_c=0;
									foreach($terms_conditions as $t_c){ $inc_t_c++;
										$bill_html.='<span>'.$inc_t_c.'. '.$t_c.'</span><br>';
									}
									
									$bill_html.='</td>
									<td align="center" width="50%" style="padding:5px;" valign="top">
									For  <b>'.$society_name.'</b><br><br><br>
									<div><span style="border-top:solid 1px #424141">'.$sig_title.'</span></div>
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
                                        <td width="20" align="right"><b></b></td>
                                        <td  width="120" style="color:#FFF !important;"> 
										<a href="mailto:support@housingmatters.in" target="_blank" style="color:#FFF !important;"><b>support@housingmatters.in</b></a>
                                        </td>
										<td align="center"></td>
                                        <td align="right" width="50"><b><img src="'.$ip.$this->webroot.'/as/hm/whatsup.png"  width="18px" /></b></td>
                                        <td width="104" style="color:#FFF !important;text-decoration: none;"><b>+91-9869157561</b></td>
										<td align="center"></td>
                                        <td width="100" style="padding-right: 10px;text-decoration: none;"> <a href="http://www.housingmatters.in" target="_blank" style="color:#FFF !important;"><b>www.housingmatters.in</b></a></td>
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
////END BILL HTML////
	
	        $current_date = date('Y-m-d');
			
			if(@$other_charges_insert==null){
				$other_charges_insert=array();
			}
			
			$this->loadmodel('new_regular_bill');
			$new_regular_bill_auto_id=$this->autoincrement('new_regular_bill','auto_id');
			$this->new_regular_bill->saveAll(array("auto_id" => $new_regular_bill_auto_id, "flat_id" => $flat_id, "bill_no" => $bill_number, "income_head_array" => $income_head_array, "noc_charges" => $noc_charges,"total" => $total, "arrear_maintenance"=> $arrear_maintenance, "arrear_intrest" => $arrear_intrest, "intrest_on_arrears" => $intrest_on_arrears,"due_for_payment" => $due_for_payment,"one_time_id"=>$one_time_id,"society_id"=>$s_society_id,"due_date"=>strtotime($due_date),"bill_start_date"=>strtotime($bill_start_date),"bill_end_date"=>strtotime($bill_end_date),"approval_status"=>0,"bill_html"=>$bill_html,"credit_stock"=>$credit_stock,"current_date"=>strtotime($current_date),"description"=>$description,"other_charges_array"=>$other_charges_insert,"edit_status"=>"NO","period_id"=>$period_id,"created_by"=>$s_user_id));
			
			
			
			
			
			//LEDGER CODE START//
			foreach($income_head_array as $income_head_id=>$income_head_amount){
				if(!empty($income_head_amount)){
					$this->loadmodel('ledger');
					$auto_id=$this->autoincrement('ledger','auto_id');
					$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => $income_head_id,"ledger_sub_account_id" => null,"debit"=>null,"credit"=>$income_head_amount,"table_name"=>"new_regular_bill","element_id"=>$new_regular_bill_auto_id,"society_id"=>$s_society_id,"transaction_date"=>strtotime($bill_start_date)));
				}
			}
			
			if(!empty($noc_charges)){
				$this->loadmodel('ledger');
				$auto_id=$this->autoincrement('ledger','auto_id');
				$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 43,"ledger_sub_account_id" => null,"debit"=>null,"credit"=>$noc_charges,"table_name"=>"new_regular_bill","element_id"=>$new_regular_bill_auto_id,"society_id"=>$s_society_id,"transaction_date"=>strtotime($bill_start_date)));
			}
			
			
			foreach($other_charges_insert as $key=>$vlaue){
				if(!empty($value)){
					$this->loadmodel('ledger');
					$auto_id=$this->autoincrement('ledger','auto_id');
					$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => $key,"ledger_sub_account_id" => null,"debit"=>null,"credit"=>$vlaue,"table_name"=>"new_regular_bill","element_id"=>$new_regular_bill_auto_id,"society_id"=>$s_society_id,"transaction_date"=>strtotime($bill_start_date)));
				}
			} 
						
						
			if(!empty($total)){
				$this->loadmodel('ledger');
				$auto_id=$this->autoincrement('ledger','auto_id');
				$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 34,"ledger_sub_account_id" => $ledger_sub_account_id,"debit"=>$total,"credit"=>null,"table_name"=>"new_regular_bill","element_id"=>$new_regular_bill_auto_id,"society_id"=>$s_society_id,"transaction_date"=>strtotime($bill_start_date)));
			}
			
			if(!empty($intrest_on_arrears)){
				$this->loadmodel('ledger');
				$auto_id=$this->autoincrement('ledger','auto_id');
				$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 41,"ledger_sub_account_id" => null,"debit"=>null,"credit"=>$intrest_on_arrears,"table_name"=>"new_regular_bill","element_id"=>$new_regular_bill_auto_id,"society_id"=>$s_society_id,"transaction_date"=>strtotime($bill_start_date)));
				
				$this->loadmodel('ledger');
				$auto_id=$this->autoincrement('ledger','auto_id');
				$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 34,"ledger_sub_account_id" => $ledger_sub_account_id,"debit"=>$intrest_on_arrears,"credit"=>null,"table_name"=>"new_regular_bill","element_id"=>$new_regular_bill_auto_id,"society_id"=>$s_society_id,"transaction_date"=>strtotime($bill_start_date),"intrest_on_arrears"=>"YES"));
			}
			
			if(!empty($credit_stock)){
				if($credit_stock>0){
					$this->loadmodel('ledger');
					$auto_id=$this->autoincrement('ledger','auto_id');
					$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 88,"ledger_sub_account_id" => null,"debit"=>null,"credit"=>abs($credit_stock),"table_name"=>"new_regular_bill","element_id"=>$new_regular_bill_auto_id,"society_id"=>$s_society_id,"transaction_date"=>strtotime($bill_start_date)));
					
					$this->loadmodel('ledger');
					$auto_id=$this->autoincrement('ledger','auto_id');
					$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 34,"ledger_sub_account_id" => $ledger_sub_account_id,"debit"=>abs($credit_stock),"credit"=>null,"table_name"=>"new_regular_bill","element_id"=>$new_regular_bill_auto_id,"society_id"=>$s_society_id,"transaction_date"=>strtotime($bill_start_date)));
				}
				if($credit_stock<0){
					$this->loadmodel('ledger');
					$auto_id=$this->autoincrement('ledger','auto_id');
					$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 88,"ledger_sub_account_id" => null,"debit"=>abs($credit_stock),"credit"=>null,"table_name"=>"new_regular_bill","element_id"=>$new_regular_bill_auto_id,"society_id"=>$s_society_id,"transaction_date"=>strtotime($bill_start_date)));
					
					$this->loadmodel('ledger');
					$auto_id=$this->autoincrement('ledger','auto_id');
					$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 34,"ledger_sub_account_id" => $ledger_sub_account_id,"debit"=>null,"credit"=>abs($credit_stock),"table_name"=>"new_regular_bill","element_id"=>$new_regular_bill_auto_id,"society_id"=>$s_society_id,"transaction_date"=>strtotime($bill_start_date)));
				}
			}
				
			

		}  unset($other_charges_insert); }
		
		
$this->Session->write('incttt',1);		
		$role_security=$this->role_security_dashboard_sub($s_society_id,$s_role_id,10,93);
		if(sizeof($role_security)>0){
			$this->response->header('Location','aprrove_bill');
		}else{
			$this->response->header('Location','it_regular_bill');
		}
		
	}
	
}

////////////////////////// Start Regular Bill View2 ////////////////////////////////////

function regular_bill_view2()
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
$this->ath();
$webroot_path=$this->requestAction(array('controller' => 'Hms', 'action' => 'webroot_path'));

$this->loadmodel('penalty');
$condition=array('society_id'=>$s_society_id);
$result5=$this->penalty->find('all',array('conditions'=>$condition)); 
$this->set('cursor5',$result5);

$from3 = $this->request->query('f');
$to3 = $this->request->query('t');
$due_date3 = $this->request->query('due');
$desc3 = $this->request->query('d');
$p_id = $this->request->query('p');
$pen = $this->request->query('pen');
$wing_arr_en = $this->request->query('wi');
$bill_for_en = $this->request->query('bi');

$from = $this->decode($from3,'housingmatters');
$to = $this->decode($to3,'housingmatters');
$due_date = $this->decode($due_date3,'housingmatters');
$desc = $this->decode($desc3,'housingmatters');
$p_id = (int)$this->decode($p_id,'housingmatters');
$penalty = (int)$this->decode($pen,'housingmatters');
$wing_arr_im = $this->decode($wing_arr_en,'housingmatters');
$bill_for = (int)$this->decode($bill_for_en,'housingmatters');

$this->set('bill_for',$bill_for);
$this->set('wing_arr_im',$wing_arr_im);
$this->set('p_id',$p_id);
$this->set('from',$from);
$this->set('to',$to);
$this->set('due_date',$due_date);
$this->set('desc',$desc);
$this->set('penalty',$penalty);

$this->loadmodel('income_head');
$order=array('income_head.auto_id'=>'ASC');
$conditions=array("society_id" => $s_society_id,"delete_id"=>0);
$cursor11 = $this->income_head->find('all',array('conditions'=>$conditions,'order' => $order));
$this->set('cursor11',$cursor11);


$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor12 = $this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor12',$cursor12);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
$society_reg_no = $collection['society']['society_reg_num'];
$society_address = $collection['society']['society_address'];
$pen_per = (int)@$collection['society']['tax'];
$per_type = (int)@$collection['society']['tax_type'];
$sig_img = @$collection['society']['signature'];
$log_img = @$collection['society']['logo'];
$sig_title = @$collection['society']['sig_title'];
$bank_name = @$collection['society']['bank_name'];
$bank_branch = @$collection['society']['branch'];
$account_number = @$collection['society']['ac_name'];
$ifsc_code = @$collection['society']['ifsc_code'];
}
$this->set('pen_per',$pen_per);
$this->set('per_type',$per_type);
$this->set('society_name',$society_name);
$this->set('society_reg_no',$society_reg_no);
$this->set('society_address',$society_address);

$this->loadmodel('user');
$order=array('user.user_id'=> 'ASC');
$conditions=array("society_id" => $s_society_id, "tenant" => 1,"deactive"=>0);
$cursor1 = $this->user->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('cursor1',$cursor1);

$this->loadmodel('regular_bill');
$order=array('regular_bill.regular_bill_id'=> 'ASC');
$conditions=array("society_id" => $s_society_id);
$cursor2 = $this->regular_bill->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('cursor2',$cursor2);

if(isset($this->request->data['sub']))
{
$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$income_head_arr = @$collection['society']['income_head'];
$terms_arr = @$collection['society']['terms_conditions'];
$pen_per2 = (int)@$collection['society']['tax'];
$per_type2 = (int)@$collection['society']['tax_type'];
$society_address = $collection['society']['society_address'];
$society_sig = $collection['society']['signature'];
$society_email = $collection['society']['society_email'];
$society_phone = $collection['society']['society_phone'];
}
$bill_for = (int)$this->request->data['bill_for'];
$wing_arr_imp = $this->request->data['wing_ar'];
$from = $this->request->data['from'];
$to = $this->request->data['to'];
$due_date = $this->request->data['due'];
$description = $this->request->data['desc'];
$gtamt = @$this->request->data['gt'];
$penalty = (int)$this->request->data['penalty'];
$p_id = (int)$this->request->data['p_type'];

if($p_id == 1)
{
$multi = 1;
}
if($p_id == 2)
{
$multi = 2;
}
if($p_id == 3)
{
$multi = 3;
}
if($p_id == 4)
{
$multi = 6;
}
if($p_id == 5)
{
$multi = 12;
}

$sms_from = date('dM',strtotime($from));
$sms_to = date('dMy',strtotime($to));
$sms_due = date('dMy',strtotime($due_date));

$dueeed = $due_date;
$due_date_msg = $due_date;

$m_from = date("Y-m-d", strtotime($from));

$m_to = date("Y-m-d", strtotime($to));

$due_date = date("Y-m-d", strtotime($due_date));

$this->loadmodel('regular_bill');
$order=array('regular_bill.one_time_id'=> 'DESC');
$cursor=$this->regular_bill->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last10=$collection['regular_bill']["one_time_id"];
}
if(empty($last10))
{
$one=0;
}	
else
{	
$one=$last10;
}
$one++;
////////////////////////// BILL FOR 2///////////////////////////////////////////////
if($bill_for == 2)
{
$this->loadmodel('user');
$order=array('user.user_id'=> 'ASC');
$conditions=array("society_id" => $s_society_id,"tenant" => 1,"deactive"=>0);
$cursor = $this->user->find('all',array('conditions'=>$conditions,'order'=>$order));
foreach($cursor as $collection)
{
$multi_flat = array();
$user_id = (int)$collection['user']['user_id'];
$user_name = $collection['user']['user_name'];
$flat_id = (int)$collection['user']['flat'];
$wing_id = (int)$collection['user']['wing'];
$mobile = $collection['user']['mobile'];
$to_mail = $collection['user']['email'];
$wing_flat = $this->wing_flat($wing_id,$flat_id);
$multi_flat = @$collection['user']['multiple_flat'];

$rrr = (int)sizeof($multi_flat);
if($rrr == 0)
{
$multi_flat[] = array($wing_id,$flat_id);	
}

for($g=0; $g<sizeof($multi_flat); $g++)
{
$mul_flat2 = $multi_flat[$g];
$wing_id = (int)$mul_flat2[0];
$flat_id = (int)$mul_flat2[1];

$maint_ch = 0;

$this->loadmodel('flat');
$conditions=array("society_id" => $s_society_id, "flat_id" => $flat_id, "wing_id" => $wing_id);
$cursor = $this->flat->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$flat_type_id = (int)$collection['flat']['flat_type_id'];
$noc_ch_id = (int)@$collection['flat']['noc_ch_tp'];
$sq_feet = (int)$collection['flat']['flat_area'];
}

$this->loadmodel('flat_type');
$conditions=array("society_id" => $s_society_id, "auto_id" => $flat_type_id);
$cursor = $this->flat_type->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$charge = @$collection['flat_type']['charge'];
$noc_charge = @$collection['flat_type']['noc_charge'];
}

$this->loadmodel('regular_bill');
$order=array('regular_bill.receipt_id'=> 'DESC');
$cursor=$this->regular_bill->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last111=$collection['regular_bill']["receipt_id"];
}
if(empty($last111))
{
$regular_bill_id11=1000;
}	
else
{	
$regular_bill_id11=$last111;
}
$regular_bill_id11++;
$current_date11 = date('Y-m-d');
//$current_date11 = new MongoDate(strtotime($current_date11));
/////////////////////////////////////

$income_headd2 = array();
for($s=0; $s<sizeof($income_head_arr); $s++)
{
$auto_id_in = (int)$income_head_arr[$s];

$ih_amt = (int)$this->request->data['ih'.$auto_id_in.$user_id];
if($ih_amt != 0)
{
$income_headd = array($auto_id_in,$ih_amt);
$income_headd2[] = $income_headd;
$this->loadmodel('ledger');
$order=array('ledger.auto_id'=> 'ASC');
$cursor=$this->ledger->find('all',array('order' =>$order));
foreach ($cursor as $collection) 
{
$last=$collection['ledger']["auto_id"];
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
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $regular_bill_id11, "amount" => $ih_amt, "amount_category_id" => 2,
"table_name" => "regular_bill", "account_type" => 2, "account_id" => $auto_id_in, "current_date" => $current_date11,"society_id" => $s_society_id,"module_name"=>"Regular Bill"));
$this->ledger->saveAll($multipleRowData);
}
}
///////////////////////////////////////
if($noc_ch_id == 2)
{
$noc_amt = (int)$this->request->data['noc'.$user_id];
if($noc_amt != 0)
{
$this->loadmodel('ledger');
$order=array('ledger.auto_id'=> 'ASC');
$cursor=$this->ledger->find('all',array('order' =>$order));
foreach ($cursor as $collection) 
{
$last=$collection['ledger']["auto_id"];
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
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $regular_bill_id11, "amount" => $noc_amt, "amount_category_id" => 2,
"table_name" => "regular_bill", "account_type" => 2, "account_id" => 43, "current_date" => $current_date11,"society_id" => $s_society_id,"module_name"=>"Regular Bill"));
$this->ledger->saveAll($multipleRowData);
}
$income_headd = array(43,$noc_amt);
$income_headd2[] = $income_headd;

}
////////////////////////////////////
//$current_date = new MongoDate(strtotime(date("Y-m-d")));
$this->loadmodel('regular_bill');
$conditions=array("society_id" => $s_society_id,"bill_for_user"=>$user_id,"status"=>0,"flat_id"=>$flat_id);
$cursor = $this->regular_bill->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
//$due_amount11 = (int)$collection['regular_bill']['remaining_amount'];
$due_date11 = @$collection['regular_bill']['due_date'];
$from_due = @$collection['regular_bill']['bill_daterange_from'];
$tax_arrears = (int)@$collection['regular_bill']['accumulated_tax'];
$arrear_amt = (int)@$collection['regular_bill']['arrears_amt'];
$pr_amt = (int)@$collection['regular_bill']['current_bill_amt'];
$previous_penalty_amt = (int)@$collection['regular_bill']['current_tax'];

}
$cur_date = date('Y-m-d');
//$cur_datec = new MongoDate(strtotime($cur_date));

/////////////// Penalty ///////////////////
if($penalty == 1)
{
$due_date12 = date('Y-m-d',strtotime(@$due_date11));
$from_due_date = date('Y-m-d',strtotime(@$from_due));

$penalty_amt = (int)$this->request->data['penalty'.$user_id];
if($penalty_amt != 0)
{ 
$this->loadmodel('ledger');
$order=array('ledger.auto_id'=> 'DESC');
$cursor=$this->ledger->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last=$collection['ledger']["auto_id"];
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
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $regular_bill_id11, "amount" => @$penalty_amt, "amount_category_id" => 2, 
"table_name" => "regular_bill", "account_type"=> 2, "account_id" => 41, "current_date" => $current_date11,"society_id" => $s_society_id,"module_name"=>"Regular Bill"));
$this->ledger->saveAll($multipleRowData);
}
}

/////////////////////End Penalty //////////////////////////////


//$grand_total = $total_amt + $total_due_amount;

$over_due_amt = (int)$this->request->data['due'.$user_id];
/*
if(@$over_due_amt > 0)
{
$this->loadmodel('ledger');
$order=array('ledger.auto_id'=> 'DESC');
$cursor=$this->ledger->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last=$collection['ledger']["auto_id"];
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
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $regular_bill_id11, "amount" =>$over_due_amt, "amount_category_id" => 2,"table_name" => "regular_bill", "account_type" => 2, "account_id" => 13, "current_date" => $current_date11,"society_id" => $s_society_id,"module_name"=>"Regular Bill"));
$this->ledger->saveAll($multipleRowData);
}
*/
$total_due_amount = (int)@$penalty_amt + $over_due_amt;

$current_date13 = date('Y-m-d');
$regular_bill_id13 = (int)$this->autoincrement('regular_bill','regular_bill_id');

$this->loadmodel('ledger_sub_account');
$conditions=array("society_id" => $s_society_id, "user_id" => $user_id, "ledger_id" => 34);
$cursor=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$l_id =  (int)$collection['ledger_sub_account']['auto_id'];
}

$current_bill_amt2 = (int)$this->request->data['tt'.$user_id];

$grand_total = (int)$this->request->data['gtt'.$user_id];
if($current_bill_amt2 != 0)
{
$this->loadmodel('ledger');
$order=array('ledger.auto_id'=> 'DESC');
$cursor=$this->ledger->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last=$collection['ledger']["auto_id"];
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
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $regular_bill_id11, "amount" => $current_bill_amt2, "amount_category_id" => 1, 
"table_name" => "regular_bill", "account_type"=> 1, "account_id" => @$l_id, "current_date" => $current_date13,"society_id" => $s_society_id,"module_name"=>"Regular Bill","penalty"=>"NO"));
$this->ledger->saveAll($multipleRowData);
}

if($penalty == 1)
{
if($penalty_amt != 0)
{
$this->loadmodel('ledger');
$order=array('ledger.auto_id'=> 'DESC');
$cursor=$this->ledger->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last=$collection['ledger']["auto_id"];
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
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $regular_bill_id11, "amount" => @$penalty_amt, "amount_category_id" => 1, 
"table_name" => "regular_bill", "account_type"=> 1, "account_id" => @$l_id, "current_date" => $current_date13,"society_id" => $s_society_id,"module_name"=>"Regular Bill","penalty"=>"YES"));
$this->ledger->saveAll($multipleRowData);
}
}

$total_amt = (int)$this->request->data['tt'.$user_id];



$this->loadmodel('regular_bill');
$this->regular_bill->updateAll(array('status'=>1),array("society_id"=>$s_society_id,"bill_for_user"=>$user_id,"status"=>0,"flat_id"=>$flat_id));

///////////////////////////////////////////////
if($one > 1)
{
$from_due2 = date('Y-m-d',strtotime(@$from_due));
}
else
{
$from_due2 = "2000-01-01";
$from_due2 = date('Y-m-d',strtotime($from_due2));
$arrear_amt = 0;
$tax_arrears = 0;
}
$opn_principal_amt = 0;
$opn_penlty_amt = 0;
$this->loadmodel('ledger');
$conditions=array("society_id" => $s_society_id,"account_id" => $l_id);
$cursor=$this->ledger->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$receipt_id = "";
$op_date = "";
$op_date2 = "";
$op_amt = "";
$pen_type="";

$receipt_id = @$collection['ledger']['receipt_id'];

if($receipt_id == "O_B")
{
$op_date = $collection['ledger']['op_date'];
$op_date2 = date('Y-m-d',$op_date->sec);
$op_amt = $collection['ledger']['amount'];
@$pen_type = @$collection['ledger']['penalty'];
$amoun_cat_id = (int)@$collection['ledger']['amount_category_id'];

if($op_date2 <= $m_from && $one == 1)
{
if($amoun_cat_id == 1)
{
if($pen_type == "YES")
{
$opn_penlty_amt= $opn_penlty_amt + $op_amt;
}
else
{
$opn_principal_amt= $opn_principal_amt + $op_amt;
}
}
if($amoun_cat_id == 2)
{
$opn_principal_amt= $opn_principal_amt-$op_amt;

}
} 
}
}

/////////////////////////////////////////////////////







///////////////////////////////////
$admin_user_id = "";
$admin_user_id[] = $user_id;

$regular_bill_id = $this->autoincrement('regular_bill','regular_bill_id');

$wing_flat = $this->wing_flat($wing_id,$flat_id);

$current_date = date('Y-m-d');
$current_bill_amt = (int)$this->request->data['tt'.$user_id];
@$tax_arrears = (int)@$tax_arrears + @$penalty_amt + $opn_penlty_amt;
@$arrear_amt = @$arrear_amt + @$pr_amt + ($opn_principal_amt);
@$total_due_amount = $total_due_amount + ($opn_principal_amt)+$opn_penlty_amt;
@$grand_total = $grand_total+($opn_principal_amt)+$opn_penlty_amt;

//////////////////////////////////////////////////////////////
$this->loadmodel('regular_bill');
$order=array('regular_bill.receipt_id'=> 'DESC');
$cursor=$this->regular_bill->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$lastt=$collection['regular_bill']["receipt_id"];
}
if(empty($lastt))
{
$r=1000;
}	
else
{	
$r=$lastt;
}
$r++;
$this->loadmodel('regular_bill');
$multipleRowData = Array( Array("regular_bill_id" => $regular_bill_id,"receipt_id" => $r,
"description"=>$description,"date"=>$current_date, "society_id"=>$s_society_id,"bill_for_user"=>$user_id,
"g_total"=>$grand_total,"bill_daterange_from"=>$m_from,"bill_daterange_to"=>$m_to,
"bill_html"=>"","one_time_id"=>$one,"status" => 0,  
"due_date" => $due_date, "total_due_amount"=> $total_due_amount, "current_tax" => @$penalty_amt,"accumulated_tax"=>@$tax_arrears,"remaining_amount"=>$grand_total,"current_bill_amt" => $current_bill_amt,"arrears_amt"=>@$arrear_amt,"pay_amount"=>"", "due_amount" => @$over_due_amt,"period_id"=>$p_id,"ih_detail"=>$income_headd2,"noc_charge"=>@$noc_amt,"approve_status"=>1,"flat_id"=>$flat_id,"open_penlty"=>$opn_penlty_amt,"open_amt"=>$opn_principal_amt,"arrear_interest"=>@$tax_arrears,"arrears_amt2"=>@$arrear_amt));
$this->regular_bill->saveAll($multipleRowData);	

$ussrs[]=$user_id;

//$this->send_notification('<span class="label label-warning" ><i class="icon-money"></i></span>','New bill for your flat '.$wing_flat.' is generated ',10,$5,$this->webroot.'Incometrackers/ac_statement_bill_view/'.$r,0,$ussrs);
unset($ussrs);
///////////////////////////////////////

////////////////////////////////////////////
///////Start Bill Html Code/////////////////
$total_amount2 = 0;	
$this->loadmodel('regular_bill');
$conditions=array("one_time_id"=>$one,"bill_for_user"=>$user_id,"flat_id"=>$flat_id);
$cursor=$this->regular_bill->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$bill_no = (int)$collection['regular_bill']['regular_bill_id'];
$receipt_id = $collection['regular_bill']['receipt_id'];
$date_from = $collection['regular_bill']['bill_daterange_from'];
$date_to = $collection['regular_bill']['bill_daterange_to'];
$ih_detail2 = $collection['regular_bill']['ih_detail'];
$date_c=$collection['regular_bill']["date"];
$regular_bill_id=$collection['regular_bill']["regular_bill_id"];
$grand_total = (int)$collection['regular_bill']['g_total'];
$late_amt2 = (int)$collection['regular_bill']['current_tax'];
$due_amt2 = (int)$collection['regular_bill']['total_due_amount'];
$due_date2 = @$collection['regular_bill']['due_date'];
$narration = $collection['regular_bill']['description'];
$billing_cycle_id = (int)$collection['regular_bill']['period_id'];
$interest_arrears = (int)$collection['regular_bill']['accumulated_tax'];
$open_pen_amt2 = $collection['regular_bill']['open_penlty'];
$open_princi_amt2 = $collection['regular_bill']['open_amt'];
$amount_arrears = $collection['regular_bill']['arrears_amt'];
$remain_amount = $collection['regular_bill']['remaining_amount'];

}

$date_frm = date('M',strtotime($date_from));	
if($billing_cycle_id == 1)
{
$multi_ch = 1;
}
if($billing_cycle_id == 2)
{
$multi_ch = 2;
}
if($billing_cycle_id == 3)
{
$multi_ch = 3;
}
if($billing_cycle_id == 4)
{
$multi_ch = 6;
}
if($billing_cycle_id == 5)
{
$multi_ch = 12;
}	

$date_from = date("d-M-Y",strtotime($date_from));
$date_to = date("d-M-Y",strtotime($date_to));
$date_to2 = date('Y-m-d',strtotime($date_to));
$due_date21 = date('d-M-Y',strtotime($due_date2));
//$newDate = date("d-M-Y",strtotime($date));	

$this->loadmodel('user');
$conditions=array("user_id"=>$user_id,"society_id" => $s_society_id);
$cursor=$this->user->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$user_name=$collection['user']["user_name"];	
$wing = (int)$collection['user']['wing'];
$flat = (int)$collection['user']['flat'];
}

$this->loadmodel('flat');
$conditions=array("flat_id"=>$flat,"society_id" => $s_society_id);
$cursor=$this->flat->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$flat_area = $collection['flat']['flat_area'];
}

$wing_flat = $this->wing_flat($wing,$flat);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name=$collection['society']["society_name"];
$so_reg_no = $collection['society']['society_reg_num'];
$so_address = $collection['society']['society_address'];
$bank_name = @$collection['society']['bank_name'];	
$ac_num = @$collection['society']['ac_num'];
$branch = @$collection['society']['branch'];
$account_name = @$collection['society']['ac_name'];
$ifsc_code = @$collection['society']['ifsc_code'];		
}
$date_c = date('d-M-Y',strtotime($date_c));
$date = date('d-M-Y',strtotime($date_from));
$datett = date('M',strtotime($date_to));

$dd1 = date('M',strtotime($date_from));
$dd2 = date('M',strtotime($date_to));
$dd3 = array($dd1,$dd2);
$monthB = implode("-",$dd3);
//////////////////////////////////////////////
$dateA = date('m',strtotime($date));
$y = date('Y',strtotime($date));
$datt = array();
$multi_ch2 = $multi_ch+1;
$n=1;
while($n<$multi_ch2)
{
$n++;
$datt[] = date('d-'.$dateA.'-'.$y.'',strtotime($date));

if($dateA == 12)
{
$dateA=0;
$y++;
}
$dateA++;
}

$month2 = array();
for($r=0; $r<sizeof($datt); $r++)
{
$dat2 = $datt[$r];
$month2[] = date('M',strtotime($dat2));	
$year = date('Y',strtotime($dat2));
}


//////////////////////////////////////////////////
//echo $log_img;
$html='<div style="width:80%;margin:auto;" class="bill_on_screen">
<div style="background-color:white; overflow:auto;">
<div style="border:solid 1px; overflow:auto;">
<div align="center" style="background-color: rgb(0, 141, 210);padding: 5px;font-size: 16px;font-weight: bold;color: #fff;">'.strtoupper($society_name).'</div>
<div style="padding:5px;">
	<div style="float:left;">';
	if(!empty($log_img)){
		$html.='<img src='.$webroot_path.'logo/'.$log_img.'  height="45px" width="45px" class=""></img>';
	}
	
	$html.='</div>
	<div style="float:right;" align="right">
	<span style="color: rgb(100, 100, 99); ">Regn# &nbsp; '.$so_reg_no.'</span><br/>
	<span style="color: rgb(100, 100, 99); ">'.$so_address.'</span><br/>';
	
	if(!empty($society_email)){
		$html.='<span>Email: '.$society_email.'</span>';
	}
	if(!empty($society_email) && !empty($society_phone)){
		$html.=' | ';
	}
	if(!empty($society_phone)){
		$html.='<span>Phone : '.$society_phone.'</span>';
	}
	$html.='</div>
</div>
<table border="0" style="width:15%; float:left;">
<tr>
<td>

</td>
</tr>
</table>

</div>
<div style="border:solid 1px; overflow:auto; border-top:none; border-bottom:none;padding:5px;">
<div>
<table border="0" style="width:60%; float:left;">
<tr>
<td style="text-align:left; width:17%;font-weight: bold;">
Name :
</td>
<td>'.$user_name.'</td>
</tr>
<tr>
<td style="text-align:left;font-weight: bold;">Bill No.:</td>
<td style="text-align:left;">'.$receipt_id.' </td>
</tr>
<tr>
<td style="text-align:left;font-weight: bold;">Bill Date:</td>
<td style="text-align:left;">'.$date_c.'</td>
</tr>
<tr>
<td style="text-align:left;font-weight: bold;">Description:</td>
<td style="text-align:left;">'.$narration.'</td>
</tr>
<tr>
<td style="text-align:left;"></td>
<td style="text-align:left;"></td>
</tr>
</table>
<table border="0" style="width:39%; float:right;">
<tr>
<td></td>
<td></td>
</tr>
<tr>
<td style="text-align:left;font-weight: bold;">Flat/Shop No.:</td>
<td style="text-align:left;">'.$wing_flat.'</td>
</tr>
<tr>
<td style="text-align:left;font-weight: bold;">Area:</td>
<td style="text-align:left;">'.$flat_area.' Sq Feet</td>
</tr>
<tr>
<td style="text-align:left;font-weight: bold;">Billing Period:</td>
<td style="text-align:left;">'.$monthB.'&nbsp;'. $year.'</td>
</tr>
<tr>
<td style="text-align:left;font-weight: bold;"><b>Due Date:</b></td>
<td style="text-align:left;"><b>'.$due_date21.'</b></td>
</tr>
</table>
</div>
</div>
<div style="overflow:auto;">
<table border="1" style="width:100%; margine-left:2px; border-collapse:collapse;" cellspacing="0" cellpadding="5">
<tr>
<th style="width:85%; text-align:left;color: #fff;background-color: rgb(4, 126, 186);">Particulars of charges</th>
<th style="text-align:right;color: #fff;background-color: rgb(4, 126, 186);">Amount (Rs.)</th>
<tr>
<tr>
<td valign="top" >
<table border="0" style="width:100%;">';

for($x=0; $x<sizeof($ih_detail2); $x++)
{
$ih_det = $ih_detail2[$x];
$ih_id5 = (int)$ih_det[0];
$ammmt = $ih_det[1];
if($ih_id5 != 43)
{
$result7 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($ih_id5)));
foreach($result7 as $collection)
{
$ih_name = $collection['ledger_account']['ledger_name'];
}
}
else
{
$ih_name = "Non Occupancy charges";
}
if($ammmt != 0)
{
$html.='<tr>
<td style="text-align:left;">'.$ih_name.'</td>
</tr>';
}
}
$html.='<tr>
<td style="text-align:left;"><br/><br/></td>
</tr>';
$html.='</table>
</td>
<td valign="top">
<table border="0" style="width:100%;">';
for($y=0; $y<sizeof($ih_detail2); $y++)
{
$ih_det3 = $ih_detail2[$y];
$amount = $ih_det3[1];
if($amount != 0 )
{
//$amount2 = number_format($amount);
$html.='<tr>
<td style="text-align:right;padding-right: 8%;">'.$amount.'</td>
</tr>';
$total_amount2 = $total_amount2 + $amount;
}
}
//$due_amt3 = $due_amt2 - $late_amt2;
$html.='<tr>
<td style="text-align:left;"><br/><br/></td>
</tr>';
$html.='</table>
</td>
</tr>
<tr>
<td valign="top">
<table border="0" style="width:75%; float:left;font-size: 11px;">
<tr>
<td colspan="2" >Cheque/NEFT payment instructions:</td>
</tr>
<tr>
<td width="30%" valign="top"><b>Account Name:</b></td>
<td>'.$account_name.'</td>
</tr>
<tr>
<td><b>Account No.:</b></td>
<td>'.$ac_num.'</td>
</tr>
<tr>
<td><b>Bank Name:</b></td>
<td>'.$bank_name .'</td>
</tr>
<tr>
<td><b>Branch Name:</b></td>
<td>'.$branch .'</td>
</tr>
<tr>
<td><b>IFSC no.:</b></td>
<td>'.$ifsc_code.'</td>
</tr>
</table>
<table border="0" style="width:25%;">';
$html.='<tr>
<td rowspan="5"></td>
<td style="text-align:right; padding-right:2%;">Total:</td>
</tr>';
$html.='<tr>
<td style="text-align:right; padding-right:2%;">Interest on arrears:</td>
</tr>';
$html.='<tr>
<td style="text-align:right; padding-right:2%;">Arrears &nbsp; (Maint.):</td>
</tr>';
$html.='<tr>
<td style="text-align:right; padding-right:2%;">Arrears &nbsp; (Int.):</td>
</tr>';

$html.='<tr>
<th style="text-align:right; padding-right:2%;">Due For Payment:</th>
</tr>';
$html.='</table>
</td>
<td valign="top">';

$due_amt5 = $due_amt2-$interest_arrears;
$int_show_arrears = $interest_arrears - $late_amt2;



$total_amount3 = number_format($total_amount2);
if($amount_arrears<0)
{
$amount_arrears = abs($amount_arrears);
$due_amt4 = number_format($amount_arrears);
$due_amt4 = "-".$due_amt4;
}
else
{
$due_amt4 = number_format($amount_arrears);
}


$late_amt3 = number_format($late_amt2);
if($remain_amount<0)
{
$remain_amount = abs($remain_amount);
$grand_total2 = number_format($remain_amount);
$grand_total2 = "-".$grand_total2;
}
else
{
$grand_total2 = number_format($remain_amount);
}
$int_show_arrears2 = number_format($int_show_arrears);

$html.='<table border="0" style="width:100%;">
<tr>';
$html.='
<td style="text-align:right; padding-right:8%;">'.$total_amount3.'</td>
</tr>';
$html.='
<tr>
<td style="text-align:right; padding-right:8%;">'.@$late_amt3.'</td>
</tr>';
$html.='<tr>
<td style="text-align:right; padding-right:8%;">'.@$due_amt4.'</td>
</tr>';
$html.='<tr>
<td style="text-align:right; padding-right:8%;">'.@$int_show_arrears2.'</td>
</tr>';

$html.='<tr>
<th style="text-align:right; padding-right:8%;">'.$grand_total2.'</th>
</tr>';
$grand_total2;
$grand_total2 = str_replace( ',', '', $grand_total2 );
if($grand_total2<0){
$write_am_word="Nil";
}else{
$am_in_words=ucwords(strtolower($this->convert_number_to_words($grand_total2)));
$write_am_word="Rupees ".$am_in_words." Only";
}

$html.='</table>
</td>
</tr>
<tr><td colspan="2"><b>Due For Payment (in words) :</b> '.$write_am_word.'</td></tr>
</table>
</div>';

$html.='<div style="overflow:auto;border:solid 1px;border-bottom:none;padding:5px;border-top: none;">
<div style="width:70%;float:left;font-size: 11px;line-height: 15px;">
<span>Remarks:</span><br/>';
$count=0;
for($r=0; $r<sizeof($terms_arr); $r++)
{
$count++;
$tems_name = $terms_arr[$r];
$html.='<span>'.$count.'.  '.$tems_name.'</span><br/>';
}
$html.='</div>
<div style="width:30%;float:right;" align="center">For  <b>'.$society_name.' <br/><br/><br/><div align="center"><span style="border-top: solid 1px #424141;">'.$sig_title.'</span></div></div>
</div>
<div align="center" style="color: #6F6D6D;border: solid 1px black;border-top: dotted 1px;">Note: This is a computer generated bill hence no signature required.</div>
<div align="center" style="background-color: rgb(0, 141, 210);padding: 5px;font-size: 12px;font-weight: bold;color: #fff;vertical-align: middle;border: solid 1px #000;border-top: none;">
<span>Your Society is empowered by HousingMatters - 
<i>"Making Life Simpler"</i></span><br/>
<span style="color:#FFF;">Email: support@housingmatters.in</span> &nbsp;|&nbsp; <span>Phone : 022-41235568</span> &nbsp;|&nbsp; <span style="color:#FFF;">www.housingmatters.co.in</span></div>

</div>
</div>
';

$this->loadmodel('regular_bill');
$this->regular_bill->updateAll(array("bill_html" =>$html),array("regular_bill_id" =>$regular_bill_id));	
////////End Bill Html Code///////////////////
////////////////////////////////////////////



$this->loadmodel('society');
$condition=array('society_id'=>$s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$condition)); 
foreach($cursor as $collection)
{
$mail_id = $collection['society']['account_email'];
}
if($mail_id == 1)
{
/*
$from_mail_date = date('d M',strtotime($date_from));
$to_mail_date = date('d M Y',strtotime($date_to));

//$my_mail = "nikhileshvyas@yahoo.com";
$subject = ''.$society_name.' : Maintanance bill, '.$from_mail_date.' to '.$to_mail_date.'';
$from_name="HousingMatters";
//$message_web = "Receipt No. :".$d_receipt_id;
$from = "accounts@housingmatters.in";
$reply="accounts@housingmatters.in";
$this->send_email($to_mail,$from,$from_name,$subject,$html,$reply);
*/
}
}
}
}
else if($bill_for == 1)
{
$wing_arr = explode(",",$wing_arr_imp);
/////////////////////////////////////////////////
for($m=0; $m<sizeof($wing_arr); $m++)
{
$wing_id_a = (int)$wing_arr[$m];
$cursor = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch3'),array('pass'=>array($wing_id_a)));

foreach($cursor as $collection)
{
$multi_flat = array();
$user_id = (int)$collection['user']['user_id'];
$user_name = $collection['user']['user_name'];
$flat_id = (int)$collection['user']['flat'];
$wing_id = (int)$collection['user']['wing'];
$mobile = $collection['user']['mobile'];
$to_mail = $collection['user']['email'];
$multi_flat = @$collection['user']['multiple_flat'];

$rrr = (int)sizeof($multi_flat);
if($rrr == 0)
{
$multi_flat[] = array($wing_id,$flat_id);	
}
for($g=0; $g<sizeof($multi_flat); $g++)
{
$mul_flat2 = $multi_flat[$g];
$wing_id = (int)$mul_flat2[0];
$flat_id = (int)$mul_flat2[1];



$wing_flat = $this->wing_flat($wing_id,$flat_id);

$maint_ch = 0;


$this->loadmodel('flat');
$conditions=array("society_id" => $s_society_id, "flat_id" => $flat_id, "wing_id" => $wing_id);
$cursor = $this->flat->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$flat_type_id = (int)$collection['flat']['flat_type_id'];
$noc_ch_id = (int)@$collection['flat']['noc_ch_tp'];
$sq_feet = (int)$collection['flat']['flat_area'];
}

$this->loadmodel('flat_type');
$conditions=array("society_id" => $s_society_id, "auto_id" => $flat_type_id);
$cursor = $this->flat_type->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$charge = @$collection['flat_type']['charge'];
$noc_charge = @$collection['flat_type']['noc_charge'];
}

$this->loadmodel('regular_bill');
$order=array('regular_bill.receipt_id'=> 'ASC');
$cursor=$this->regular_bill->find('all',array('order' =>$order));
foreach ($cursor as $collection) 
{
$last111=$collection['regular_bill']["receipt_id"];
}
if(empty($last111))
{
$regular_bill_id11=1000;
}	
else
{	
$regular_bill_id11=$last111;
}
$regular_bill_id11++;

$current_date11 = date('Y-m-d');
//$current_date11 = new MongoDate(strtotime($current_date11));
/////////////////////////////////////
$total_amt = 0;
$income_headd2 = array();
for($s=0; $s<sizeof($income_head_arr); $s++)
{
$auto_id_in = (int)$income_head_arr[$s];

$ih_amt = (int)$this->request->data['ih'.$auto_id_in.$user_id];

$income_headd = array($auto_id_in,$ih_amt);
$income_headd2[] = $income_headd;

if($ih_amt != 0)
{
$this->loadmodel('ledger');
$order=array('ledger.auto_id'=> 'ASC');
$cursor=$this->ledger->find('all',array('order' =>$order));
foreach ($cursor as $collection) 
{
$last=$collection['ledger']["auto_id"];
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
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $regular_bill_id11, "amount" => $ih_amt, "amount_category_id" => 2,
"table_name" => "regular_bill", "account_type" => 2, "account_id" => $auto_id_in, "current_date" => $current_date11,"society_id" => $s_society_id,"module_name"=>"Regular Bill"));
$this->ledger->saveAll($multipleRowData);
}
}

///////////////////////////////////////
if($noc_ch_id == 2)
{
$noc_amt = (int)$this->request->data['noc'.$user_id];
if($noc_amt != 0)
{
$this->loadmodel('ledger');
$order=array('ledger.auto_id'=> 'ASC');
$cursor=$this->ledger->find('all',array('order' =>$order));
foreach ($cursor as $collection) 
{
$last=$collection['ledger']["auto_id"];
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
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $regular_bill_id11, "amount" => $noc_amt, "amount_category_id" => 2,
"table_name" => "regular_bill", "account_type" => 2, "account_id" => 43, "current_date" => $current_date11,"society_id" => $s_society_id,"module_name"=>"Regular Bill"));
$this->ledger->saveAll($multipleRowData);
}
$income_headd = array(43,$noc_amt);
$income_headd2[] = $income_headd;
}

////////////////////////////////////
//$tax_amount = round(($tax_per/100)*$total_amount);
$current_date = date('Y-m-d');
$this->loadmodel('regular_bill');
$conditions=array("society_id" => $s_society_id,"bill_for_user"=>$user_id,"status"=>0,"flat_id"=>$flat_id);
$cursor = $this->regular_bill->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
//$due_amount11 = (int)$collection['regular_bill']['remaining_amount'];
$due_date11 = $collection['regular_bill']['due_date'];
$from_due = $collection['regular_bill']['bill_daterange_from'];
$tax_arrears = (int)@$collection['regular_bill']['accumulated_tax'];
$arrear_amt = (int)@$collection['regular_bill']['arrears_amt'];
$pr_amt = (int)$collection['regular_bill']['current_bill_amt'];
$previous_penalty_amt = (int)@$collection['regular_bill']['current_tax'];
}
$cur_date = date('Y-m-d');
//$cur_datec = new MongoDate(strtotime($cur_date));

if($penalty == 1)
{
$due_date12 = date('Y-m-d',strtotime(@$due_date11));
$from_due_date = date('Y-m-d',strtotime(@$from_due));

$penalty_amt = (int)$this->request->data['penalty'.$user_id];
if($penalty_amt != 0)
{
$this->loadmodel('ledger');
$order=array('ledger.auto_id'=> 'DESC');
$cursor=$this->ledger->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last=$collection['ledger']["auto_id"];
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
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $regular_bill_id11, "amount" => @$penalty_amt, "amount_category_id" => 2, 
"table_name" => "regular_bill", "account_type"=> 2, "account_id" => 41, "current_date" => $current_date11,"society_id" => $s_society_id,"module_name"=>"Regular Bill"));
$this->ledger->saveAll($multipleRowData);
}
}

$over_due_amt = (int)$this->request->data['due'.$user_id];
/*
if(@$over_due_amt > 0)
{
$this->loadmodel('ledger');
$order=array('ledger.auto_id'=> 'DESC');
$cursor=$this->ledger->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last=$collection['ledger']["auto_id"];
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
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $regular_bill_id11, "amount" =>$over_due_amt, "amount_category_id" => 2,"table_name" => "regular_bill", "account_type" => 2, "account_id" => 13, "current_date" => $current_date11,"society_id" => $s_society_id,"module_name"=>"Regular Bill"));
$this->ledger->saveAll($multipleRowData);
}
*/
$total_due_amount = (int)@$penalty_amt + $over_due_amt;

$current_date13 = date('Y-m-d');
//$current_date13 = new MongoDate(strtotime($current_date13));

$regular_bill_id13 = (int)$this->autoincrement('regular_bill','regular_bill_id');

$this->loadmodel('ledger_sub_account');
$conditions=array("society_id" => $s_society_id, "user_id" => $user_id, "ledger_id" => 34);
$cursor=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$l_id =  (int)$collection['ledger_sub_account']['auto_id'];
}

$current_bill_amt2 = (int)$this->request->data['tt'.$user_id];
$grand_total = (int)$this->request->data['gtt'.$user_id];


if($current_bill_amt2 != 0)
{
$this->loadmodel('ledger');
$order=array('ledger.auto_id'=> 'DESC');
$cursor=$this->ledger->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last=$collection['ledger']["auto_id"];
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
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $regular_bill_id11, "amount" => $current_bill_amt2, "amount_category_id" => 1, 
"table_name" => "regular_bill", "account_type"=> 1, "account_id" => @$l_id, "current_date" => $current_date13,"society_id" => $s_society_id,"module_name"=>"Regular Bill","penalty"=>"NO"));
$this->ledger->saveAll($multipleRowData);
}
if($penalty == 1)
{
if($penalty_amt != 0)
{
$this->loadmodel('ledger');
$order=array('ledger.auto_id'=> 'DESC');
$cursor=$this->ledger->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last=$collection['ledger']["auto_id"];
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
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $regular_bill_id11, "amount" => $penalty_amt, "amount_category_id" => 1, 
"table_name" => "regular_bill", "account_type"=> 1, "account_id" => @$l_id, "current_date" => $current_date13,"society_id" => $s_society_id,"module_name"=>"Regular Bill","penalty"=>"YES"));
$this->ledger->saveAll($multipleRowData);
}
}


$total_amt = (int)$this->request->data['tt'.$user_id];

$this->loadmodel('regular_bill');
$this->regular_bill->updateAll(array('status'=>1),array("society_id"=>$s_society_id,"bill_for_user"=>$user_id,"status"=>0,"flat_id"=>$flat_id));

///////////////////////////////////////////////
if($one > 1)
{
$from_due2 = date('Y-m-d',strtotime(@$from_due));
}
else
{
$from_due2 = "2000-01-01";
$from_due2 = date('Y-m-d',strtotime($from_due2));
$arrear_amt = 0;
$tax_arrears = 0;
}


$opn_principal_amt = 0;
$opn_penlty_amt = 0;
$this->loadmodel('ledger');
$conditions=array("society_id" => $s_society_id,"account_id" => $l_id);
$cursor=$this->ledger->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$receipt_id = "";
$op_date = "";
$op_date2 = "";
$op_amt = "";
$pen_type = "";

$receipt_id = @$collection['ledger']['receipt_id'];

if($receipt_id == "O_B")
{
$op_date = $collection['ledger']['op_date'];
$op_date2 = date('Y-m-d',$op_date->sec);
$op_date2 = date('Y-m-d',strtotime($op_date2));
$op_amt = $collection['ledger']['amount'];
@$pen_type = @$collection['ledger']['penalty'];
$amoun_cat_id = (int)@$collection['ledger']['amount_category_id'];
if($op_date2 <= $m_from && $one == 1)
{
if($amoun_cat_id == 1)
{
if($pen_type == "YES")
{
$opn_penlty_amt= $opn_penlty_amt + $op_amt;
}
else
{
$opn_principal_amt= $opn_principal_amt + $op_amt;
}
}
if($amoun_cat_id == 2)
{
$opn_principal_amt= $opn_principal_amt - $op_amt;
}

}
}
}

/////////////////////////////////////////////////////







///////////////////////////////////
$admin_user_id = "";
$admin_user_id[] = $user_id;

$regular_bill_id = $this->autoincrement('regular_bill','regular_bill_id');

$wing_flat = $this->wing_flat($wing_id,$flat_id);

$current_bill_amt = (int)$this->request->data['tt'.$user_id];
@$tax_arrears = (int)$tax_arrears + @$penalty_amt+$opn_penlty_amt;
@$arrear_amt = @$arrear_amt + @$pr_amt+($opn_principal_amt);
@$total_due_amount = $total_due_amount+($opn_principal_amt)+$opn_penlty_amt;
@$grand_total = $grand_total+($opn_principal_amt)+$opn_penlty_amt;

$this->loadmodel('regular_bill');
$order=array('regular_bill.receipt_id'=> 'DESC');
$cursor=$this->regular_bill->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$lastt=$collection['regular_bill']["receipt_id"];
}
if(empty($lastt))
{
$r=1000;
}	
else
{	
$r=$lastt;
}
$r++;
$this->loadmodel('regular_bill');
$multipleRowData = Array( Array("regular_bill_id" => $regular_bill_id,"receipt_id" => $r,
"description"=>$description,"date"=>$current_date, "society_id"=>$s_society_id,"bill_for_user"=>$user_id,
"g_total"=>$grand_total,"bill_daterange_from"=>$m_from,"bill_daterange_to"=>$m_to,
"bill_html"=>"","one_time_id"=>$one,"status" => 0,  
"due_date" => $due_date, "total_due_amount"=> $total_due_amount, "current_tax" => @$penalty_amt,"accumulated_tax"=>@$tax_arrears,"remaining_amount"=>$grand_total,"current_bill_amt" => $current_bill_amt,"arrears_amt"=>@$arrear_amt,"pay_amount"=>"", "due_amount" => @$over_due_amt,"period_id"=>$p_id,"ih_detail"=>$income_headd2,"noc_charge"=>@$noc_amt,"approve_status"=>1,"flat_id"=>$flat_id,"open_penlty"=>$opn_penlty_amt,"open_amt"=>$opn_principal_amt,"arrear_interest"=>@$tax_arrears,"arrears_amt2"=>@$arrear_amt));
$this->regular_bill->saveAll($multipleRowData);	


////////////////////

///////////////////////////////////////
$ussrs[]=$user_id;

$this->send_notification('<span class="label label-warning" ><i class="icon-money"></i></span>','New bill for your flat '.$wing_flat.' is generated ',10,$r,$this->webroot.'Incometrackers/ac_statement_bill_view/'.$r,0,$ussrs);
unset($ussrs);
////////////////////////////////////////////
///////Start Bill Html Code/////////////////
	$total_amount2 = 0;	
	$this->loadmodel('regular_bill');
	$conditions=array("one_time_id"=>$one,"bill_for_user"=>$user_id,"flat_id"=>$flat_id);
	$cursor=$this->regular_bill->find('all',array('conditions'=>$conditions));
	foreach($cursor as $collection)
	{
	$bill_no = (int)$collection['regular_bill']['regular_bill_id'];
	$receipt_id = $collection['regular_bill']['receipt_id'];
	$date_from = $collection['regular_bill']['bill_daterange_from'];
	$date_to = $collection['regular_bill']['bill_daterange_to'];
	$ih_detail2 = $collection['regular_bill']['ih_detail'];
	$date_c=$collection['regular_bill']["date"];
	$regular_bill_id=$collection['regular_bill']["regular_bill_id"];
	$grand_total = (int)$collection['regular_bill']['g_total'];
	$late_amt2 = (int)$collection['regular_bill']['current_tax'];
	$due_amt2 = (int)$collection['regular_bill']['total_due_amount'];
	$due_date2 = @$collection['regular_bill']['due_date'];
	$narration = $collection['regular_bill']['description'];
	$billing_cycle_id = (int)$collection['regular_bill']['period_id'];
	$interest_arrears = (int)$collection['regular_bill']['accumulated_tax'];
	$open_pen_amt2 = $collection['regular_bill']['open_penlty'];
	$open_princi_amt2 = $collection['regular_bill']['open_amt'];
	$arrears_amt=$collection['regular_bill']['arrears_amt'];
	$remain_amount = $collection['regular_bill']['remaining_amount'];
	}
	
$date_frm = date('M',strtotime($date_from));	
if($billing_cycle_id == 1)
{
$multi_ch = 1;
}
if($billing_cycle_id == 2)
{
$multi_ch = 2;
}
if($billing_cycle_id == 3)
{
$multi_ch = 4;
}
if($billing_cycle_id == 4)
{
$multi_ch = 6;
}
if($billing_cycle_id == 5)
{
$multi_ch = 12;
}	

	
$date_from = date("d-M-Y",strtotime($date_from));
$date_to = date("d-M-Y",strtotime($date_to));
$date_to2 = date('Y-m-d',strtotime($date_to));

//$due_date = date('Y-m-d', strtotime($date_to2 .'+'. $due_days2.'day'));
$due_date21 = date('d-M-Y',strtotime(@$due_date2));
//$newDate = date("d-M-Y",strtotime(@$date));	


$this->loadmodel('user');
$conditions=array("user_id"=>$user_id,"society_id" => $s_society_id);
$cursor=$this->user->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$user_name=$collection['user']["user_name"];	
$wing = (int)$collection['user']['wing'];
$flat = (int)$collection['user']['flat'];
}

$this->loadmodel('flat');
$conditions=array("flat_id"=>$flat,"society_id" => $s_society_id);
$cursor=$this->flat->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$flat_area = $collection['flat']['flat_area'];
}

$wing_flat = $this->wing_flat($wing,$flat);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name=$collection['society']["society_name"];
$so_reg_no = $collection['society']['society_reg_num'];
$so_address = $collection['society']['society_address'];	
$bank_name = @$collection['society']['bank_name'];	
$ac_num = @$collection['society']['ac_num'];
$branch = @$collection['society']['branch'];
$account_name = @$collection['society']['ac_name'];
$ifsc_code = @$collection['society']['ifsc_code'];
}
$date_c = date('d-M-Y',strtotime($date_c));
$date = date('d-M-Y',strtotime($date_from));
$datett = date('M',strtotime($date_to));

$dd1 = date('M',strtotime($date_from));
$dd2 = date('M',strtotime($date_to));
$dd3 = array($dd1,$dd2);
$monthB = implode("-",$dd3);

/////////////////////////////////////
$dateA =date('m',strtotime($date));
$y = date('Y',strtotime($date));

$datt = array();
$multi_ch2 = $multi_ch+1;
$n=1;
while($n<$multi_ch2)
{
$n++;
$datt[] = date('d-'.$dateA.'-'.$y.'',strtotime($date));

if($dateA == 12)
{
$dateA=0;
$y++;
}
$dateA++;
}

$month2 = array();
for($r=0; $r<sizeof($datt); $r++)
{
$dat2 = $datt[$r];
$month2[] = date('M',strtotime($dat2));	
$year = date('Y',strtotime($dat2));
}
//$monthB = implode("-",$month2);

//////////////////////////////////////////
$html='<div style="width:80%;margin:auto;"  class="bill_on_screen">
<div style="background-color:white; overflow:auto;">
<div style="border:solid 1px; overflow:auto;">
<div align="center" style="background-color: rgb(0, 141, 210);padding: 5px;font-size: 16px;font-weight: bold;color: #fff;">'.strtoupper($society_name).' </div>
<div style="padding:5px;">
	<div style="float:left;">';
	if(!empty($log_img)){
		$html.='<img src='.$webroot_path.'logo/'.$log_img.' height="60px" width="60px" class=""></img>';
	}
	
	$html.='</div>
	<div style="float:right;" align="right">
	<span style="color: rgb(100, 100, 99); ">Regn# &nbsp; '.$so_reg_no.'</span><br/>
	<span style="color: rgb(100, 100, 99); ">'.$so_address.'</span><br/>';
	if(!empty($society_email)){
		$html.='<span>Email: '.$society_email.'</span>';
	}
	if(!empty($society_email) && !empty($society_phone)){
		$html.=' | ';
	}
	if(!empty($society_phone)){
		$html.='<span>Phone : '.$society_phone.'</span>';
	}
	$html.='</div>
</div>
<table border="0" style="width:15%; float:left;">
<tr>
<td>

</td>
</tr>
</table>

</div>
<div style="border:solid 1px; overflow:auto; border-top:none; border-bottom:none;padding:5px;">
<div>
<table border="0" style="width:60%; float:left;">
<tr>
<td style="text-align:left; width:17%;font-weight: bold;">
Name :
</td>
<td>'.$user_name.'</td>
</tr>
<tr>
<td style="text-align:left;font-weight: bold;">Bill No.:</td>
<td style="text-align:left;">'.$receipt_id.' </td>
</tr>
<tr>
<td style="text-align:left;font-weight: bold;">Bill Date:</td>
<td style="text-align:left;">'.$date_c.'</td>
</tr>
<tr>
<td style="text-align:left;font-weight: bold;">Description:</td>
<td style="text-align:left;">'.$narration.'</td>
</tr>
<tr>
<td style="text-align:left;"></td>
<td style="text-align:left;"></td>
</tr>
</table>
<table border="0" style="width:39%; float:right;">
<tr>
<td></td>
<td></td>
</tr>
<tr>
<td style="text-align:left;font-weight: bold;">Flat/Shop No.:</td>
<td style="text-align:left;">'.$wing_flat.'</td>
</tr>
<tr>
<td style="text-align:left;font-weight: bold;">Area:</td>
<td style="text-align:left;">'.$flat_area.' Sq Feet</td>
</tr>
<tr>
<td style="text-align:left;font-weight: bold;">Billing Period:</td>
<td style="text-align:left;">'.$monthB.'&nbsp;'. $year.'</td>
</tr>
<tr>
<td style="text-align:left;font-weight: bold;"><b>Due Date:</b></td>
<td style="text-align:left;"><b>'.$due_date21.'</b></td>
</tr>

</table>
</div>

</div>
<div style="overflow:auto;">
<table border="1" style="width:100%; margine-left:2px; border-collapse:collapse;" cellspacing="0" cellpadding="5">
<tr>
<th style="width:85%; text-align:left;color: #fff;background-color: rgb(4, 126, 186);">Particulars of charges</th>
<th style="text-align:right;color: #fff;background-color: rgb(4, 126, 186);">Amount (Rs.)</th>
<tr>
<tr>
<td valign="top">
<table border="0" style="width:100%;">';

for($x=0; $x<sizeof($ih_detail2); $x++)
{
$ih_det = $ih_detail2[$x];
$ih_id5 = (int)$ih_det[0];
$ammmt = $ih_det[1];
if($ih_id5 != 43)
{
$result7 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($ih_id5)));
foreach($result7 as $collection)
{
$ih_name = $collection['ledger_account']['ledger_name'];
}
}
else
{
$ih_name = "Non Occupancy charges";
}
if($ammmt != 0)
{
$html.='<tr>
<td style="text-align:left;">'.$ih_name.'</td>
</tr>';
}
}
$html.='<tr>
<td style="text-align:left;"><br/><br/></td>
</tr>';
$html.='</table>
</td>
<td valign="top">
<table border="0" style="width:100%;">';
for($y=0; $y<sizeof($ih_detail2); $y++)
{
$ih_det3 = $ih_detail2[$y];
$amount = $ih_det3[1];
//$amount2 = number_format($amount);
if($amount != 0)
{
$html.='<tr>
<td style="text-align:right;padding-right: 8%;">'.$amount.'</td>
</tr>';
$total_amount2 = $total_amount2 + $amount;
}
}
//$due_amt3 = $due_amt2 - $late_amt2;
$html.='<tr>
<td style="text-align:left;"><br/><br/></td>
</tr>';
$html.='</table>
</td>
</tr>
<tr>
<td valign="top">
<table border="0" style="width:75%; float:left;font-size:11px;">
<tr>
<td colspan="2" >Cheque/NEFT payment instructions:</td>
</tr>
<tr>
<td width="30%" valign="top"><b>Account Name:</b></td>
<td>'.$account_name.'</td>
</tr>
<tr>
<td><b>Account No.:</b></td>
<td>'.$ac_num.'</td>
</tr>
<tr>
<td><b>Bank Name:</b></td>
<td>'.$bank_name .'</td>
</tr>
<tr>
<td><b>Branch Name:</b></td>
<td>'.$branch .'</td>
</tr>
<tr>
<td><b>IFSC no.:</b></td>
<td>'.$ifsc_code.'</td>
</tr>
</table>
<table border="0" style="width:25%;">';
$html.='<tr>
<td rowspan="5"></td>
<td style="text-align:right; padding-right:2%;">Total:</td>
</tr>';
$html.='<tr>
<td style="text-align:right; padding-right:2%;">Interest on arrears:</td>
</tr>';
$html.='<tr>
<td style="text-align:right; padding-right:2%;">Arrears &nbsp; (Maint.):</td>
</tr>';
$html.='<tr>
<td style="text-align:right;">Arrears &nbsp; (Int.):</td>
</tr>';

$html.='<tr>
<th style="text-align:right; padding-right:2%;">Due For Payment:</th>
</tr>';
$html.='</table>
</td>
<td valign="top">';
//$due_amt5 = (int)$due_amt2 - $interest_arrears;
$int_show_arrears = (int)$interest_arrears-$late_amt2;

$total_amount3 = number_format($total_amount2);
if($arrears_amt < 0)
{
$arrears_amt = abs($arrears_amt);
$due_amt4 = number_format($arrears_amt);
$due_amt4 = "-".$due_amt4;
}
else
{
$due_amt4 = number_format($arrears_amt);
}

$late_amt3 = number_format($late_amt2);
if($remain_amount < 0)
{
$remain_amount = abs($remain_amount);
$grand_total2 = number_format($remain_amount);
$grand_total2 = "-".$grand_total2;
}
else
{
$grand_total2 = number_format($remain_amount);
}
$int_show_arrears2 = number_format($int_show_arrears);

$html.='<table border="0" style="width:100%;">
<tr>';
$html.='
<td style="text-align:right; padding-right:8%;">'.$total_amount3.'</td>
</tr>';
$html.='
<tr>
<td style="text-align:right; padding-right:8%;">'.@$late_amt3.'</td>
</tr>';

$html.='<tr>
<td style="text-align:right; padding-right:8%;">'.@$due_amt4.'</td>
</tr>';
$html.='<tr>
<td style="text-align:right; padding-right:8%;">'.@$int_show_arrears2.'</td>
</tr>';

$html.='<tr>
<th style="text-align:right; padding-right:8%;">'.$grand_total2.'</th>
</tr>';
$grand_total2 = str_replace( ',', '', $grand_total2 );
if($grand_total2<0){
$write_am_word="Nil";
}else{
$am_in_words=ucwords(strtolower($this->convert_number_to_words($grand_total2)));
$write_am_word="Rupees ".$am_in_words." Only";
}
$html.='</table>
</td>
</tr>
<tr><td colspan="2"><b>Due For Payment (in words) :</b> '.$write_am_word.'</td></tr>
</table>
</div>';

$html.='<div style="overflow:auto;border:solid 1px;border-bottom:none;padding:5px;border-top: none;">
<div style="width:70%;float:left;font-size: 11px;line-height: 15px;">
<span>Remarks:</span><br/>';
$count=0;
for($r=0; $r<sizeof($terms_arr); $r++)
{
$count++;
$tems_name = $terms_arr[$r];
$html.='<span>'.$count.'.  '.$tems_name.'</span><br/>';
}
$html.='</div>
<div style="width:30%;float:right;" align="center">For  <b>'.$society_name.' <br/><br/><br/><div align="center"><span style="border-top: solid 1px #424141;">'.$sig_title.'</span></div></div>
</div>
<div align="center" style="color: #6F6D6D;border: solid 1px black;border-top: dotted 1px;">Note: This is a computer generated bill hence no signature required.</div> 
<div align="center" style="background-color: rgb(0, 141, 210);padding: 5px;font-size: 12px;font-weight: bold;color: #fff;vertical-align: middle;border: solid 1px #000;border-top: none;">
<span>Your Society is empowered by HousingMatters - 
<i>"Making Life Simpler"</i></span><br/>
<span style="color:#FFF;">Email: support@housingmatters.in</span> &nbsp;|&nbsp; <span>Phone : 022-41235568</span> &nbsp;|&nbsp; <span style="color:#FFF;">www.housingmatters.co.in</span></div>

</div>
</div>
';

//////////////////////////////////

$this->loadmodel('regular_bill');
$this->regular_bill->updateAll(array("bill_html" =>$html),array("regular_bill_id" =>$regular_bill_id));	
////////End Bill Html Code///////////////////
////////////////////////////////////////////

///////////////Bill Html for mail////////////
/*
$html_mail='<center>
<div style="width:700px; background-color:white; overflow:auto;">
<br><Br><br>
<div style="width:96%; border:solid 1px; overflow:auto; border-bottom:none;">
<table border="0" style="width:100%;">
<tr>
<th style="text-align:center;">
<p style="font-size:22px;">'.$society_name.' Society</p>
</th>
</tr>
<tr>
<th style="text-align:center;">'.$so_reg_no.'</th>
</tr>
<tr>
<th style="text-align:center;">'.$so_address.'</th>
</tr>
</table>
</div>
<div style="width:96%; border:solid 1px; overflow:auto; border-bottom:none;">
<table border="0" style="width:65%; float:left;">
<tr>
<td style="text-align:left; width:20%;">
Name :
</td>
<td style="text-align:left;">'.$user_name.'</td>
</tr>
<tr>
<td style="text-align:left;">Bill No. :</td>
<td style="text-align:left;">'.$receipt_id.'</td>
</tr>
<tr>
<td style="text-align:left;">Bill Date :</td>
<td style="text-align:left;">'.$date.'</td>
</tr>
<tr>
<td style="text-align:left;">Due Date:</td>
<td style="text-align:left;">'.$due_date21.'</td>
</tr>
</table>
<table border="0" style="width:30%; float:right;">
<tr>
<td></td>
<td></td>
</tr>
<tr>
<td style="text-align:left;">Flat/Shop No. :</td>
<td style="text-align:left;">'.$wing_flat.'</td>
</tr>
<tr>
<td style="text-align:left;">Area:</td>
<td style="text-align:left;">'.$flat_area.' Sq Feet</td>
</tr>
<tr>
<td style="text-align:left;">Billing Period:</td>
<td style="text-align:left;">'.$monthB.''. $year.'</td>
</tr>
</table>
</div>
<div style="width:96.2%; overflow:auto;">
<table border="1" style="width:100%; border:black;  border-collapse:collapse; margine-left:2px;" cellpadding="0" cellspacing="0">
<tr>
<td style="width:80%; text-align:center;">Particulars</td>
<td style="text-align:center;">Amount (Rs.)</td>
</tr>
<tr>
<td valign="top" style="height:200px;">
<table border="0" style="width:100%;">';

for($x=0; $x<sizeof($ih_detail2); $x++)
{
$ih_det = $ih_detail2[$x];
$ih_id5 = (int)$ih_det[0];
if($ih_id5 != 43)
{
$result7 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($ih_id5)));
foreach($result7 as $collection)
{
$ih_name = $collection['ledger_account']['ledger_name'];
}
}
else
{
$ih_name = "Non Occupancy charges";
}
$html_mail.='<tr>
<td style="text-align:left;">'.$ih_name.'</td>
</tr>';
}
$html_mail.='</table>
</td>
<td valign="top">
<table border="0" style="width:100%;">';
for($y=0; $y<sizeof($ih_detail2); $y++)
{
$ih_det3 = $ih_detail2[$y];
$amount = $ih_det3[1];
$amount2 = number_format($amount);
$html_mail.='<tr>
<td style="text-align:center;">'.$amount2.'</td>
</tr>';
$total_amount2 = $total_amount2 + $amount;
}
$due_amt3 = $due_amt2 - $late_amt2;
$html_mail.='</table>
</td>
</tr>';
$total_amount3 = number_format($total_amount2);
$due_amt4 = number_format($due_amt3);
$late_amt3 = number_format($late_amt2);
$grand_total2 = number_format($grand_total);
$html.='
<tr>
<td valign="top">
<table border="0" style="width:100%;">
<tr>
<td rowspan="4"></td>
<td style="text-align:right;">Sub-Total:</td>
</tr>
<tr>
<td style="text-align:right;">Over Due Amount:</td>
</tr>
<tr>
<td style="text-align:right;">Over Due Interest:</td>
</tr>
<tr>
<th style="text-align:right;">Grand Total:</th>
</tr>
</table>
</td>
<td valign="top">
<table border="0" style="width:100%;">
<tr>
<td style="text-align:center;">'.$total_amount3.'</td>
</tr>
<tr>
<td style="text-align:center;">'.@$due_amt4.'</td>
</tr>
<tr>
<td style="text-align:center;">'.@$late_amt3.'</td>
</tr>
<tr>
<th style="text-align:center;">'.$grand_total2.'</th>
</tr>
</table>
</td>
</tr>
</table>
</div>
<div style="width:96%; overflow:auto; border:solid 1px; border-top:none;">
<table border="0" style="width:70%; float:left;">
<tr>
<th style="text-align:left;">Description:</th>
</tr>
<td style="text-align:left;">'.$narration.'</td>
</tr>
</table>
</div>
<div style="width:96%; overflow:auto; border:solid 1px; border-top:none;">
<table border="0" style="width:100%;">
<tr>
<th style="text-align:left;">
Terms And Conditions:
</th>
</tr>';
for($r=0; $r<sizeof($terms_arr); $r++)
{
$tems_name = $terms_arr[$r];
$html_mail.='
<tr>
<td style="text-align:left;">'.$tems_name.'</td>
</tr>';
}
$html_mail.='</table> 
</div>
<div style="width:96%; overflow:auto; border:solid 1px; border-top:none;">
<br><br><br>
<table border="0" style="width:100%;">
<tr>
<td style="text-align:right;">
<p style="font-size:18px;"><b>'.$society_name.' Society</b></p>
</td>
</tr>
</table>
</div>
<br><br><br><br>
</div>
';
*/
////////////End Html For mail/////////////////
}
}
}
///////////////////////////////////////////////
}
?>
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-header">
<center>
<h3 id="myModalLabel3" style="color:#999;"><b>Regular Bill</b></h3>
</center>
</div>
<div class="modal-body">
<center>
<h5><b>Bills generated successfully</b></h5>
</center>
</div>
<div class="modal-footer">
<a href="it_regular_bill" class="btn blue">OK</a>
</div>
</div>
<?php
}
}
////////////////////////// End Regular Bill View2 /////////////////////////////////////////////////////////////
///////////////// Start It Supplimentry Bill (Accounts)///////////////////////////////////////////////////////

function it_supplimentry_bill()
{
		if($this->RequestHandler->isAjax()){
		$this->layout='blank';
		}else{
		$this->layout='session';
		}

			$this->ath();
			$this->check_user_privilages();

		$s_role_id=$this->Session->read('role_id');
		$s_society_id = (int)$this->Session->read('society_id');
		$s_user_id=$this->Session->read('user_id');	

					$this->loadmodel('financial_year');
					$conditions=array("society_id" => $s_society_id, "status"=>1);
					$cursor=$this->financial_year->find('all',array('conditions'=>$conditions));
						foreach($cursor as $collection)
						{
						$date_from = @$collection['financial_year']['from'];
						$date_to = @$collection['financial_year']['to'];

						$date_from1 = date('Y-m-d',$date_from->sec);
						$date_to1 = date('Y-m-d',$date_to->sec);

						$datef[] = $date_from1;
						$datet[] = $date_to1;
						}
		if(!empty($datef))
		{
		$datef1 = implode(',',$datef);
		$datet1 = implode(',',$datet);
		}
				$count = sizeof(@$datef);
				$this->set('datef1',@$datef1);
				$this->set('datet1',@$datet1);
				$this->set('count',$count);

if(isset($this->request->data['sub1']))
{
					$this->loadmodel('society');
					$conditions=array("society_id" => $s_society_id);
					$cursor=$this->society->find('all',array('conditions'=>$conditions));
					foreach($cursor as $collection)
					{
					$society_name2 = $collection['society']['society_name'];
					}
						 $from2 = $this->request->data['from'];
						 $bill_type_id = $this->request->data['type'];
						 $due_date = $this->request->data['due_date'];
					
			   if($bill_type_id == 1)
			   {
			            //$com_name = $this->request->data['c_name'];
				        $resi_id = (int)$this->request->data['s_name'];
						$this->loadmodel('ledger_account');
						$conditions =array( '$or' => array( 
						array("society_id" => 0,"group_id"=>8),
						array("society_id" => $s_society_id,"group_id"=>8)
						));
						$cursor = $this->ledger_account->find('all',array('conditions'=>$conditions));
						foreach($cursor as $collection)	
						{
						$ih_id = (int)$collection['ledger_account']['auto_id'];
						$ih_idp = (int)@$this->request->data['ih'.$ih_id];
							if($ih_idp != 0)
							{
							$amt = $this->request->data['amt'.$ih_id];
							$ih_id2 = array($ih_idp,$amt);
							$ih_id3 = implode(",",$ih_id2);
							$ih_id4[] = $ih_id3;
							}
						}
								$ih_idn = (int)@$this->request->data['ih43'];
								if($ih_idn != 0)
								{
								$amt = $this->request->data['amt43'];
								$ih_id2 = array(43,$amt);
								$ih_id3 = implode(",",$ih_id2);
								$ih_id4[] = $ih_id3;
								}	  
                }
			
				else if($bill_type_id == 2)
                {
					$resi_id = (int)$this->request->data['r_name'];
					$this->loadmodel('ledger_account');
					$conditions =array( '$or' => array( 
					array("society_id" => 0,"group_id"=>8),
					array("society_id" => $s_society_id,"group_id"=>8)
					));
					$cursor = $this->ledger_account->find('all',array('conditions'=>$conditions));
						foreach($cursor as $collection)	
						{
						$ih_id = (int)$collection['ledger_account']['auto_id'];
						$ih_idp = (int)@$this->request->data['ih'.$ih_id];
								if($ih_idp != 0)
								{
								$amt = $this->request->data['amt'.$ih_id];
								$ih_id2 = array($ih_idp,$amt);
								$ih_id3 = implode(",",$ih_id2);
								$ih_id4[] = $ih_id3;
								}
						}
						$ih_idn = (int)@$this->request->data['ih43'];
							if($ih_idn != 0)
							{
							$amt = $this->request->data['amt43'];
							$ih_id2 = array(43,$amt);
							$ih_id3 = implode(",",$ih_id2);
							$ih_id4[] = $ih_id3;
							}

				}
	
$descp2 = $this->request->data['description'];


$fromm = date("Y-m-d", strtotime($from2));
$fromm = new MongoDate(strtotime($fromm));

$due_date55 = date("Y-m-d", strtotime($due_date));
$due_date55 = new MongoDate(strtotime($due_date55));

$ih2 = implode('/',$ih_id4);

		if($bill_type_id == 1)
		{
		$f2=$this->encode($from2,'housingmatters');
		$due3=$this->encode($due_date,'housingmatters');
		$ih3=$this->encode($ih2,'housingmatters');
		$desc3=$this->encode($descp2,'housingmatters');
		$bill_tp3=$this->encode($bill_type_id,'housingmatters');
		$resi3=$this->encode($resi_id,'housingmatters');

		$this->response->header('Location','supplimentry_bill_view2?f='.$f2.'&due='.$due3.'&ih='.$ih3.'&d='.$desc3.'&tp='.$bill_tp3.'&res='.$resi3.'');
		}
		else
		{
		$f2=$this->encode($from2,'housingmatters');
		$due3=$this->encode($due_date,'housingmatters');
		$ih3=$this->encode($ih2,'housingmatters');
		$desc3=$this->encode($descp2,'housingmatters');
		$bill_tp3=$this->encode($bill_type_id,'housingmatters');
		$resi3=$this->encode($resi_id,'housingmatters');

		$this->response->header('Location','supplimentry_bill_view2?f='.$f2.'&due='.$due3.'&ih='.$ih3.'&d='.$desc3.'&tp='.$bill_tp3.'&res='.$resi3.'');
		}
}

if(isset($this->request->data['add_non_member']))
{
$non_member_name = $this->request->data['mem_name'];	

$auto_id=(int)$this->autoincrement('ledger_sub_account','auto_id');
$this->loadmodel('ledger_sub_account');
$multipleRowData = Array( Array("auto_id"=>$auto_id,"ledger_id"=>112,"name"=>$non_member_name,"delete_id"=>0,
"society_id"=>$s_society_id));
$this->ledger_sub_account->saveAll($multipleRowData);
	
}




$this->loadmodel('ledger_sub_account');
$conditions=array("society_id"=>$s_society_id, "ledger_id" => 34,"deactive"=>0);
$cursor1=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);	

$this->loadmodel('ledger_sub_account');
$conditions=array("society_id"=>$s_society_id, "ledger_id" => 112);
$cursor11=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor11',$cursor11);	




$this->loadmodel('ledger_account');
$conditions =array( '$or' => array( 
array("society_id" => 0,"group_id"=>8),
array("society_id" => $s_society_id,"group_id"=>8)
));
$cursor2=$this->ledger_account->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);	

$this->loadmodel('ledger_sub_account');
$conditions=array("society_id"=>$s_society_id, "ledger_id" => 35);
$cursor3=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor3',$cursor3);	

$this->loadmodel('terms_conditions');
$conditions=array("society_id"=>$s_society_id);
$cursor4=$this->terms_conditions->find('all',array('conditions'=>$conditions));
$this->set('cursor4',$cursor4);	

$this->loadmodel('bill_period');
$conditions=array("society_id" => $s_society_id,"status"=>1);
$cursor5 = $this->bill_period->find('all',array('conditions'=>$conditions));
$this->set('cursor5',$cursor5);

}

///////////////////End It Supplimentry Bill (Accounts)//////////////////////////////////
///////////////////// Start supplimentry bill view2(Accounts)///////////////////////////
function supplimentry_bill_view2()
{
		$this->layout='session';
		$s_role_id=$this->Session->read('role_id');
		$s_society_id = (int)$this->Session->read('society_id');
		$s_user_id=$this->Session->read('user_id');	

		$this->ath();

			@$ip=$this->hms_email_ip();
			$this->set('ip',$ip);


				$this->loadmodel('society');
				$conditions=array("society_id" => $s_society_id);
				$cursor = $this->society->find('all',array('conditions'=>$conditions));
						foreach($cursor as $data)
						{
						$society_name=$data["society"]["society_name"];
						$society_reg_num=$data["society"]["society_reg_num"];
						$society_address=$data["society"]["society_address"];
						$society_email=$data["society"]["society_email"];
						$society_phone=$data["society"]["society_phone"];
						$terms_conditions=$data["society"]["terms_conditions"];
						$signature=$data["society"]["signature"];
						$sig_title=$data["society"]["sig_title"];
						$neft_type = @$data["society"]["neft_type"];
						$neft_detail = @$data["society"]["neft_detail"];
						$society_logo = @$data["society"]["logo"];
						$area_scale = (int)@$data["society"]["area_scale"];
						}
		$this->set('society_name',$society_name);
		$this->set('society_reg_num',$society_reg_num);
		$this->set('society_address',$society_address);
		$this->set('society_email',$society_email);
		$this->set('society_phone',$society_phone);
		$this->set('terms_conditions',$terms_conditions);
		$this->set('signature',$signature);
		$this->set('sig_title',$sig_title);
		$this->set('neft_type',$neft_type);
		$this->set('society_logo',$society_logo);
		$this->set('area_scale',$area_scale);
		$this->set('neft_detail',$neft_detail);

	$from = $this->request->query('from');
	$due_date = $this->request->query('due');
	$inhead_id = $this->request->query('ih');
	$amount = $this->request->query('amt');
    $des = $this->request->query('des');
	$type = $this->request->query('typ');
	$user = $this->request->query('user');
	
	
		$from=$this->decode($from,'housingmatters');
		$due_date=$this->decode($due_date,'housingmatters');
		$inhead_id=$this->decode($inhead_id,'housingmatters');
		$amount=$this->decode($amount,'housingmatters');
		$des=$this->decode($des,'housingmatters');
		$type=$this->decode($type,'housingmatters');
		$user=$this->decode($user,'housingmatters');

	    if($type == 1)
	    {
	    $company_name = $this->request->query('com');	
	    $company_name=$this->decode($company_name,'housingmatters');
	    $this->set('company_name',$company_name);
		}

			$this->set('from',$from);
			$this->set('due_date',$due_date);
			$this->set('inhead_id',$inhead_id);
			$this->set('amount',$amount);
			$this->set('des',$des);
			$this->set('type',$type);
			$this->set('user',$user);
			
			


		$this->loadmodel('adhoc_bill');
		$order=array('adhoc_bill.receipt_id'=> 'DESC');
		$cursor=$this->adhoc_bill->find('all',array('order' =>$order,'limit'=>1));
		foreach ($cursor as $collection) 
		{
		$last11=$collection['adhoc_bill']["receipt_id"];
		}
		if(empty($last11))
		{
		$z=1000;
		}	
		else
		{	
		$z=$last11;
		}
		$z++;
		$this->set('bill_no',$z);


if(isset($this->request->data['sub_sup']))
{
	$from = $this->request->data['from'];
	$due_date = $this->request->data['due_date'];
	$desc = @$this->request->data['desc'];
	$type = (int)$this->request->data['type'];
    $html_bill = $this->request->data['htmllll'];	
    $amount = $this->request->data['amt']; 
			if($type == 1)
			{
				$res_id = (int)$this->request->data['res_id'];
				$ih = (int)$this->request->data['ih'];
			    $company_name = $this->request_data['com'];
			}
			else
			{
				$res_id = (int)$this->request->data['res_id'];
				$ih = (int)$this->request->data['ih'];
			}

      $cur_date = date('Y-m-d');

	   if($type == 2)
	    {
	       	$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_subLedger_detail_via_flat_id'),
			array('pass'=>array($res_id)));	
			foreach($result1 as $collection)
			{	
			$auto_id = (int)$collection['ledger_sub_account']['auto_id'];
			$user_id = (int)$collection['ledger_sub_account']['user_id'];
			$flat_id = (int)$collection['ledger_sub_account']['flat_id'];
			$user_name = $collection['ledger_sub_account']['name'];
			}
			
	
		$flat_detaill = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),
		array('pass'=>array($flat_id)));				
		foreach($flat_detaill as $flat_dataaa)
		{
		$wing_id = (int)$flat_dataaa['flat']['wing_id'];
		$sq_feet = @$flat_dataaa['flat']['flat_area'];	
		}
		
	$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new')
	,array('pass'=>array($wing_id,$flat_id)));

			$l = (int)$this->autoincrement('adhoc_bill','adhoc_bill_id');
			
			$from2 = date('Y-m-d',strtotime($from));

			$k = (int)$this->autoincrement('ledger','auto_id');
			$this->loadmodel('ledger');
			$multipleRowData = Array( Array("auto_id"=>$k, "transaction_date"=> strtotime($from2), "debit" => null, 
			"credit" =>$amount,"ledger_account_id"=>$ih,"ledger_sub_account_id" => null, 
			"table_name"=>"adhoc_bill","element_id" => $l, "society_id" => $s_society_id));
			$this->ledger->saveAll($multipleRowData);
		
		
		$this->loadmodel('ledger_sub_account');
	$conditions=array("society_id" => $s_society_id,"flat_id" => (int)$res_id);
	$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
	$ledger_sub_account_idddd=@$result_ledger_sub_account[0]["ledger_sub_account"]["auto_id"];
		
		

			$k = (int)$this->autoincrement('ledger','auto_id');
			$this->loadmodel('ledger');
			$multipleRowData = Array( Array("auto_id"=>$k, "transaction_date"=> strtotime($from2),"debit"=>$amount, 
			"credit" =>null,"ledger_account_id"=>34,"ledger_sub_account_id"=>(int)$ledger_sub_account_idddd, 
			"table_name"=>"adhoc_bill","element_id" => $l, "society_id" => $s_society_id));
			$this->ledger->saveAll($multipleRowData);

//////////////////////////
$this->loadmodel('adhoc_bill');
$order=array('adhoc_bill.adhoc_bill_id'=> 'DESC');
$cursor=$this->adhoc_bill->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last22=$collection['adhoc_bill']["adhoc_bill_id"];
$last33=$collection['adhoc_bill']['receipt_id'];
}
if(empty($last22))
{
$adhoc_bill_id=0;
$receipt_id=1000;
}	
else
{	
$adhoc_bill_id=$last22;
$receipt_id=$last33;
}
$adhoc_bill_id++;
$receipt_id++;
////////////////////////
$receipt_id2 = 1000+$adhoc_bill_id;
$receipt_id3 = "S-".$receipt_id2;

$this->loadmodel('adhoc_bill');
$multipleRowData = Array( Array("adhoc_bill_id" => $adhoc_bill_id, "receipt_id" => $receipt_id3, "company_name"=> "",
"person_name"=>$res_id,"description"=>$desc,"date"=>$cur_date,"society_id"=>$s_society_id,"residential"=>"y" 
,"g_total"=> $amount,"bill_daterange_from"=>strtotime($from2),
"html_bill"=>$html_bill,"pay_status"=>0,"income_head"=>$ih,"created_by"=>$s_user_id,"due_date"=>$due_date));
$this->adhoc_bill->saveAll($multipleRowData);


////////////////////////////////////////////////////			
$user_detailll = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),
array('pass'=>array($user_id)));				
foreach($user_detailll as $ussr_dataa)	
{
$email = $ussr_dataa['user']['email'];	
}		

$this->loadmodel('society');
$condition=array('society_id'=>$s_society_id);
$result_society=$this->society->find('all',array('conditions'=>$condition)); 
$this->set('result_society',$result_society);
		foreach($result_society as $data_society){
		$society_name=$data_society["society"]["society_name"];
		$email_is_on_off=(int)@$data_society["society"]["account_email"];
		$sms_is_on_off=(int)@$data_society["society"]["account_sms"];
		}

if($email_is_on_off==1){
$r_sms=$this->hms_sms_ip();
$working_key=$r_sms->working_key;
$sms_sender=$r_sms->sms_sender; 
$sms_allow=(int)$r_sms->sms_allow;
$subject="[".$society_name."]- e-Supplimentry Bill of Rs ".$amount." on ".date('d-M-Y',$from)." against Unit ".@$wing_flat."";
$this->send_email($email,'accounts@housingmatters.in','HousingMatters',$subject,$html_bill,'donotreply@housingmatters.in');
}
			
////////////////////////////////////////////////////	

}
else
{
  

	$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),
	array('pass'=>array($res_id)));	
	foreach($result1 as $collection)
	{	
	$auto_id = (int)$collection['ledger_sub_account']['auto_id'];
	$user_name = $collection['ledger_sub_account']['name'];
	}	
	
		$l = (int)$this->autoincrement('adhoc_bill','adhoc_bill_id');
		$total = 0;
				
		 $from2 = date('Y-m-d',strtotime($from));

			$k = (int)$this->autoincrement('ledger','auto_id');
			$this->loadmodel('ledger');
			$multipleRowData = Array( Array("auto_id"=>$k, "transaction_date"=> strtotime($from2), "debit" => null, 
			"credit" =>$amount,"ledger_account_id"=>$ih,"ledger_sub_account_id" => null, 
			"table_name"=>"adhoc_bill","element_id" => $l, "society_id" => $s_society_id));
			$this->ledger->saveAll($multipleRowData);

	$k = (int)$this->autoincrement('ledger','auto_id');
	$this->loadmodel('ledger');
	$multipleRowData = Array( Array("auto_id"=>$k, "transaction_date"=> strtotime($from2),"debit"=>$amount, 
	"credit" =>null,"ledger_account_id"=>112,"ledger_sub_account_id"=>$res_id, 
	"table_name"=>"adhoc_bill","element_id" => $l, "society_id" => $s_society_id));
	$this->ledger->saveAll($multipleRowData);
//////////////////////////
		$this->loadmodel('adhoc_bill');
		$order=array('adhoc_bill.adhoc_bill_id'=> 'DESC');
		$cursor=$this->adhoc_bill->find('all',array('order' =>$order,'limit'=>1));
		foreach ($cursor as $collection) 
		{
		$last22=$collection['adhoc_bill']["adhoc_bill_id"];
		$last33=$collection['adhoc_bill']['receipt_id'];
		}
		if(empty($last22))
		{
		$adhoc_bill_id=0;
		$receipt_id=1000;
		}	
		else
		{	
		$adhoc_bill_id=$last22;
		$receipt_id=$last33;
		}
		$adhoc_bill_id++;
		$receipt_id++;

$receipt_id2 = 1000+$adhoc_bill_id;
$receipt_id3 = "S-".$receipt_id2;
	
$this->loadmodel('adhoc_bill');
$multipleRowData = Array( Array("adhoc_bill_id"=>$adhoc_bill_id,"receipt_id" => $receipt_id3,
"company_name"=>"",
"person_name"=>$res_id,"description"=>$desc,"date"=>$cur_date,"society_id"=>$s_society_id,
"residential"=>"n","g_total"=> $amount,"bill_daterange_from"=>strtotime($from2),
"html_bill"=>$html_bill,"pay_status"=>0,"ih_detail"=>$ih,"created_by"=>$s_user_id,"due_date"=>$due_date));
$this->adhoc_bill->saveAll($multipleRowData);
}

$this->Session->write('suppll',1);

?>
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
<p class="shwwtxtt">Bill #<?php echo $receipt_id3; ?> Genarated Successfully</p>
</div>
<div class="modal-footer">
<a href="it_supplimentry_bill" class="btn red">OK</a>
</div>
</div>
<?php
}
}

//////////////////////// End supplimentry bill view2(Accounts)/////////////////////////////

///////////////////// Start regular report show ajax///////////////////////////////
function regular_report_show_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	
$this->ath();

$this->loadmodel('society');
$conditions=array("society_id"=> $s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)	
{
$society_name = $collection['society']['society_name'];
$valllll = (int)@$collection['society']['area_scale'];
}
$this->set('society_name',$society_name);
$this->set('valllll',$valllll);


$wise = (int)$this->request->query('wise'); 
if($wise == 1)
{
$wing = (int)$this->request->query('wing');
$this->set('wing',$wing);
}
else if($wise == 2)
{
$user_id = (int)$this->request->query('user');
$this->set('user_id',$user_id);
}

else if($wise == 3)
{
$bill_number = $this->request->query('user');
$this->set('bill_number',$bill_number);
}
$this->set('wise',$wise);
/*
$this->loadmodel('new_regular_bill');
$order=array('new_regular_bill.bill_start_date'=> 'ASC');
$conditions=array('society_id'=>$s_society_id,"approval_status"=>1,'new_regular_bill.edit_status'=>array('$ne'=>"YES"));
$cursor1=$this->new_regular_bill->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('cursor1',$cursor1);	


if(!empty($bill_number))
{

$this->loadmodel('new_regular_bill');
$order=array('new_regular_bill.bill_start_date'=> 'ASC');
//$conditions=array('society_id'=>$s_society_id,"approval_status"=>1,"bill_no"=>$bill_number,'new_regular_bill.edit_status'=>array('$ne'=>"YES"));
$conditions=array('society_id'=>$s_society_id,"approval_status"=>1,"bill_no"=>$bill_number,"edit_status"=>"NO");
$cursor2=$this->new_regular_bill->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('cursor2',$cursor2);	
}
*/

$this->loadmodel('new_regular_bill');
$conditions=array("society_id" => $s_society_id,"approval_status" => 1,'new_regular_bill.edit_status'=>array('$ne'=>"YES"));
$order=array('new_regular_bill.one_time_id'=> 'DESC');
$result_new_regular_bill = $this->new_regular_bill->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set("result_new_regular_bill",$result_new_regular_bill);
foreach($result_new_regular_bill as $regular_bill){
$other_charges_array=@$regular_bill["new_regular_bill"]["other_charges_array"];
if(!empty($other_charges_array)){
foreach($other_charges_array as $key=>$value){
$other_charges_ids[]=$key;
}
}
}
	if(sizeof(@$other_charges_ids)>0){
	$other_charges_ids=array_unique($other_charges_ids);
	$this->set('other_charges_ids',$other_charges_ids);
	}
	
	$this->loadmodel('society');
	$condition=array('society_id'=>$s_society_id);
	$result_society=$this->society->find('all',array('conditions'=>$condition)); 
	$this->set('result_society',$result_society);
	

$this->loadmodel('wing');
$conditions=array("society_id"=> $s_society_id);
$cursor2=$this->wing->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);	

$this->loadmodel('ledger_sub_account');
$condition=array('society_id'=>$s_society_id,'ledger_id'=>34);
$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$condition));
$this->set('result_ledger_sub_account',$result_ledger_sub_account);
foreach($result_ledger_sub_account as $ledger_sub_account){
$ledger_sub_account_user_id=$ledger_sub_account["ledger_sub_account"]["user_id"];
$ledger_sub_account_flat_id=$ledger_sub_account["ledger_sub_account"]["flat_id"];
$flats_for_bill[]=$ledger_sub_account_flat_id;
}
$this->set('flats_for_bill',$flats_for_bill);

$this->loadmodel('wing');
$condition=array('society_id'=>$s_society_id,"wing_id"=>@$wing);
$order=array('wing.wing_name'=>'ASC');
$result_wing2=$this->wing->find('all',array('conditions'=>$condition,'order'=>$order));
$this->set('result_wing2',$result_wing2);


$this->loadmodel('wing');
$condition=array('society_id'=>$s_society_id);
$order=array('wing.wing_name'=>'ASC');
$result_wing=$this->wing->find('all',array('conditions'=>$condition,'order'=>$order));
$this->set('result_wing',$result_wing);



}
///////////////////////// End regular report show ajax///////////////////////////////

////////////////////////Start It Reports Regular (Accounts)////////////////////////////
function it_reports_regular()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}

$this->ath();
$this->check_user_privilages();

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$this->loadmodel('new_regular_bill');
$conditions=array("society_id"=> $s_society_id,"approval_status"=>1,"edit_status"=>"NO");
$cursor1=$this->new_regular_bill->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);	

$this->loadmodel('wing');
$conditions=array("society_id"=> $s_society_id);
$cursor2=$this->wing->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);	

$this->loadmodel('user');
$order=array('user.user_id'=> 'ASC');
$conditions=array("society_id" => $s_society_id,"tenant" => 1,"deactive"=>0);
$cursor3 = $this->user->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set("cursor3",$cursor3);



$this->loadmodel('ledger_sub_account');
$condition=array('society_id'=>$s_society_id,'ledger_id'=>34);
$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$condition));
$this->set('result_ledger_sub_account',$result_ledger_sub_account);
foreach($result_ledger_sub_account as $ledger_sub_account){
$ledger_sub_account_user_id=$ledger_sub_account["ledger_sub_account"]["user_id"];
$ledger_sub_account_flat_id=$ledger_sub_account["ledger_sub_account"]["flat_id"];
$flats_for_bill[]=$ledger_sub_account_flat_id;
}
$this->set('flats_for_bill',$flats_for_bill);


}
//////////////////////// End It Reports Regular (Accounts)//////////////////////

///////////////////////// Start In head report (Accounts)//////////////////////////
function in_head_report(){
		if($this->RequestHandler->isAjax()){
		$this->layout='blank';
		}else{
		$this->layout='session';
		}
	
		$this->ath();
		$this->check_user_privilages();

	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');	

	$this->loadmodel('new_regular_bill');
	$conditions=array("society_id" => $s_society_id,"approval_status" => 1,'new_regular_bill.edit_status'=>array('$ne'=>"YES"));
	$order=array('new_regular_bill.one_time_id'=> 'DESC');
	$result_new_regular_bill = $this->new_regular_bill->find('all',array('conditions'=>$conditions,'order'=>$order));
	$this->set("result_new_regular_bill",$result_new_regular_bill);
	foreach($result_new_regular_bill as $regular_bill){
		$other_charges_array=@$regular_bill["new_regular_bill"]["other_charges_array"];
		if(!empty($other_charges_array)){
			foreach($other_charges_array as $key=>$value){
				$other_charges_ids[]=$key;
			}
		}
		
	}
	if(sizeof(@$other_charges_ids)>0){
	$other_charges_ids=array_unique($other_charges_ids);
	$this->set('other_charges_ids',$other_charges_ids);
	}
	
	$this->loadmodel('society');
	$condition=array('society_id'=>$s_society_id);
	$result_society=$this->society->find('all',array('conditions'=>$condition)); 
	$this->set('result_society',$result_society);
	

$this->loadmodel('wing');
$conditions=array("society_id"=> $s_society_id);
$cursor2=$this->wing->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);	

$this->loadmodel('ledger_sub_account');
$condition=array('society_id'=>$s_society_id,'ledger_id'=>34);
$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$condition));
$this->set('result_ledger_sub_account',$result_ledger_sub_account);
foreach($result_ledger_sub_account as $ledger_sub_account){
$ledger_sub_account_user_id=$ledger_sub_account["ledger_sub_account"]["user_id"];
$ledger_sub_account_flat_id=$ledger_sub_account["ledger_sub_account"]["flat_id"];
$flats_for_bill[]=$ledger_sub_account_flat_id;
}
$this->set('flats_for_bill',$flats_for_bill);

$this->loadmodel('wing');
$condition=array('society_id'=>$s_society_id);
$order=array('wing.wing_name'=>'ASC');
$result_wing=$this->wing->find('all',array('conditions'=>$condition,'order'=>$order));
$this->set('result_wing',$result_wing);


		
}
///////////////////////// End In head report (Accounts)//////////////////////////

/////////////////////// Start It Reports Supplimentry Bill (Accounts)///////////////

function it_reports_supplimentry()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}

$this->ath();
$this->check_user_privilages();


$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$this->loadmodel('adhoc_bill');
$conditions=array("society_id"=> $s_society_id);
$cursor1=$this->adhoc_bill->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('wing');
$conditions=array("society_id"=> $s_society_id);
$cursor2=$this->wing->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);	

$this->loadmodel('user');
$order=array('user.user_id'=> 'ASC');
$conditions=array("society_id" => $s_society_id,"tenant" => 1,"deactive"=>0);
$cursor3 = $this->user->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set("cursor3",$cursor3);
	
}
/////////////////////////////////////////////////////// End It Reports Supplimentry Bill (Accounts)//////////////////////////////////////////////////////

///////////////////////////////////////////// Start It Reports Supplimentry Ajax (Accounts)/////////////////////////////////////////////////////////////
function it_reports_supplimentry_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');		

$this->ath();


$this->set('s_society_id',$s_society_id);

$c = (int)$this->request->query('c');
$this->set('c',$c);

$this->loadmodel('adhoc_bill');
$conditions=array("society_id"=> $s_society_id,"residential"=> "y");
$cursor1=$this->adhoc_bill->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);	

$this->loadmodel('adhoc_bill');
$conditions=array("society_id"=> $s_society_id,"residential"=> "n");
$cursor2=$this->adhoc_bill->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);	

$this->loadmodel('adhoc_bill');
$conditions=array("society_id"=> $s_society_id);
$cursor3=$this->adhoc_bill->find('all',array('conditions'=>$conditions));
$this->set('cursor3',$cursor3);	

}
//////////////////////////////// End It Reports Supplimentry Ajax (Accounts)/////////////////////////////////////////

//////////////////////// Start income Head report Excel///////////////////////////////
function income_head_report_excel()
{
$this->layout="";

$this->ath();

$filename="Income Head  Report";
header ("Expires: 0");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls");
header ("Content-Description: Generated Report" );



$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$from = $this->request->query('f');
$to = $this->request->query('t');

$m_from = date("Y-m-d", strtotime($from));
//$m_from = new MongoDate(strtotime($m_from));
$m_to = date("Y-m-d", strtotime($to));
//$m_to = new MongoDate(strtotime($m_to));

/////////////////////////////
$this->loadmodel('society');
$conditions=array("society_id"=>$s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
$society_reg_num = $collection['society']['society_reg_num'];
$society_address = $collection['society']['society_address'];
}

////////////////////////////////////////
$this->loadmodel('flat_type');
$conditions=array("society_id"=>$s_society_id);
$cursor9 = $this->flat_type->find('all',array('conditions'=>$conditions));
foreach($cursor9 as $collection) 
{
$charge = $collection['flat_type']['charge'];	
$income_heade_charge[] = $charge[0];
}
for($i=0; $i<sizeof($charge); $i++)
{
$inc_id = $charge[$i];
$income_head_charge[] = $inc_id[0];
}
$cnt=0;
for($y=0; $y<sizeof($income_head_charge); $y++)
{
$total[]="";	
$cnt++;	
}
$cnt = $cnt+6;
/////////////////////////////////////////
$excel="<table border='1'>
<thead>
<tr>
<th colspan='$cnt' style='text-align:center;'>$society_name Society</th>
</tr>
<tr>
<th style='text-align:left;'>Bill No.</th>
<th style='text-align:left;'>Flat No.</th>
<th style='text-align:left;'>Name of Resident</th>
<th style='text-align:left;'>Area (Sq.Ft.)</th>";
for($r=0; $r<sizeof($income_head_charge); $r++)
{
$abc = (int)$income_head_charge[$r];	
$ledgerac = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($abc)));			
foreach($ledgerac as $collection2)
{
$ac_name = $collection2['ledger_account']['ledger_name'];
}
$excel.="<th style='text-align:left;'>$ac_name</th>";
}
$excel.="
<th style='text-align:left;'>Non Occupancy Charges</th>
<th style='text-align:left;'>Total</th>
</tr>";
$total_noc_amt = 0;
$this->loadmodel('regular_bill');
$order=array('regular_bill.receipt_id'=> 'ASC');
$conditions=array("society_id"=>$s_society_id);
$cursor2=$this->regular_bill->find('all',array('conditions'=>$conditions,'order' =>$order));
foreach($cursor2 as $collection)
{
$bill_id = $collection['regular_bill']['receipt_id'];
$user_id = (int)$collection['regular_bill']['bill_for_user'];
$ih_detail2 = $collection['regular_bill']['ih_detail'];
$noc_amt = $collection['regular_bill']['noc_charge'];
$date = $collection['regular_bill']['date'];

$result = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user_id)));
foreach ($result as $collection) 
{
$wing_id = $collection['user']['wing'];  
$flat_id = (int)$collection['user']['flat'];
$user_name = $collection['user']['user_name'];
}
$result5 = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_fetch2'),array('pass'=>array($flat_id,$wing_id)));	
foreach($result5 as $collection)
{
$area = $collection['flat']['flat_area'];
$unit_number = $collection['flat']['flat_name'];
}	
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action'=>'wing_flat'),array('pass'=>array($wing_id,$flat_id)));
if($m_from<= $date && $m_to>= $date)
{
$excel.="<tr>
<td style='text-align:right;'>$bill_id</td>
<td style='text-align:left;'>$wing_flat</td>
<td style='text-align:left;'>$user_name</td>
<td style='text-align:left;'>$area &nbsp; sq.Ft.</td>";
$total_amt = 0;
for($y=0; $y<sizeof($income_head_charge); $y++)
{
$income_head_arr_id = $income_head_charge[$y];	
$nnn = 55;
for($r=0; $r<sizeof($ih_detail2); $r++)
{
$ih_detail1 = $ih_detail2[$r];	
$ih_id1 = $ih_detail1[0];
$amount = $ih_detail1[1];
if($income_head_arr_id == $ih_id1)
{
$total[$y] = $total[$y] + $amount;
$excel.="<td style='text-align:right;'>";
 
$amount2 = number_format($amount);
$excel.="$amount2</td>";
$total_amt=$total_amt+$amount;
$nnn = 555;
break;
}
}
if($nnn == 55)
{
$excel.="<td style='text-align:right;'> 0 </td>";
}
}
$total_noc_amt = $total_noc_amt + $noc_amt;
$total_amt=$total_amt+$noc_amt;

$excel.="<td style='text-align:right;'>";
$noc_amt2 = number_format($noc_amt);
$excel.="$noc_amt2</td>
<td style='text-align:right;'>";
$total_amt2 = number_format($total_amt);
$excel.="$total_amt2</td>
</tr>";
}
}
$excel.="<tr>
<th colspan='4' style='text-align:right;'>Grand Total</th>";
$grand_total = 0;
for($h=0; $h<sizeof($total); $h++)
{  
$excel.="<th style='text-align:right;'>";
@$totalh2 = number_format($total[$h]);
$excel.="$totalh2</th>";
$grand_total = $grand_total + $total[$h];
}
$grand_total = $grand_total + $total_noc_amt;
$excel.="<th style='text-align:right;'>";
$total_noc_amt2 = number_format($total_noc_amt);
$excel.="$total_noc_amt2</th>
<th style='text-align:right;'>";
$grand_total2 = number_format($grand_total);
$excel.="$grand_total2</th>
</tr>
</table>";

echo $excel;

}
//////////////////////// End income Head report Excel///////////////////////////////

/////////////////// Start Select Income Heads (Accounts)//////////////////////////////
function select_income_heads()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}

$this->ath();
$this->check_user_privilages();

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

if(isset($this->request->data['sub']))
{
$cur_date = date('Y-m-d');
$cur_date = new MongoDate(strtotime($cur_date));

$ih_arr = $this->request->data['i_head'];

$this->loadmodel('society');
$this->society->updateAll(array('income_head'=> $ih_arr),array('society_id'=>$s_society_id));


?>
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
The Income Heads Added Successfully
</div>
<div class="modal-footer">
<a class="btn red" href="<?php echo $webroot_path; ?>Incometrackers/select_income_heads" rel="tab">OK</a>
</div>
</div>
<?php
}

$this->loadmodel('accounts_group');
$conditions=array("delete_id"=>0,"accounts_id"=>3);
$cursor1 = $this->accounts_group->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('income_heads');
$conditions=array("delete_id"=>0,"society_id"=>$s_society_id);
$cursor2 = $this->income_heads->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

$this->loadmodel('society');
$conditions=array("society_id"=>$s_society_id);
$cursor3 = $this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor3',$cursor3);

}
/////////////////////End Select Income Heads (Accounts)//////////////////////////////

////START OTHER CHARGES//

function other_charges_all_remove(){
	$this->layout=null;
	
	$this->ath();
	
	 $status=(int)$this->request->query('con2');
	 if($status==0){
			$flat_id=(int)$this->request->query('con');	
			$this->loadmodel('flat');
			$this->flat->updateAll(array('other_charges'=>null),array('flat_id'=>$flat_id));
	 }
	 if($status==1){
		
			 $flat_id=(int)$this->request->query('con');
		     $inc_head_id=(int)$this->request->query('con3');
			 $this->loadmodel('flat');
			 $result_flat=$this->flat->find('all',array('conditions'=>array('flat_id'=>$flat_id)));
			 $charges=$result_flat[0]['flat']['other_charges'];
			
			foreach($charges as $key=>$value){
				if($key==$inc_head_id){
					unset($charges[$key]);
				}
			}
		
			 $this->flat->updateAll(array('other_charges'=>$charges),array('flat_id'=>$flat_id));
	 }
	
	$this->response->header('location:other_charges');
}

function other_charges(){
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	
	$this->ath();
	$this->check_user_privilages();
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');	
	
	$this->loadmodel('ledger_account');
	$conditions=array("group_id"=>7);
	$result_ledger_account=$this->ledger_account->find('all',array('conditions'=>$conditions));
	$this->set('result_ledger_account',$result_ledger_account);
		
	$this->loadmodel('society');
	$conditions=array("society_id"=>$s_society_id);
	$cursor3=$this->society->find('all',array('conditions'=>$conditions));
	$this->set('cursor3',$cursor3);
		
		
		$this->loadmodel('ledger_sub_account');
		$condition=array('society_id'=>$s_society_id,'ledger_id'=>34,"deactive"=>0);
		$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$condition));
		$this->set('result_ledger_sub_account',$result_ledger_sub_account);
		foreach($result_ledger_sub_account as $ledger_sub_account){
			$ledger_sub_account_user_id=$ledger_sub_account["ledger_sub_account"]["user_id"];
			$ledger_sub_account_flat_id=$ledger_sub_account["ledger_sub_account"]["flat_id"];
				$flats_for_bill[]=$ledger_sub_account_flat_id;
		}
		$this->set('flats_for_bill',$flats_for_bill);	
		
		
	$this->loadmodel('flat');	
	$conditions=array('society_id'=>$s_society_id);
	$flat_detail=$this->flat->find('all',array('conditions'=>$conditions));
	$this->set('flat_detail',$flat_detail);	
		
	
	if(isset($this->request->data['add_charges'])){ 
		$income_head_id=$this->request->data['income_head'];
		$amount=$this->request->data['amount'];
		$flats=$this->request->data['flats'];
		$charge_type = (int)$this->request->data['charge_type'];
		
		foreach($flats as $flat_id){
			
			$this->loadmodel('flat');
			$conditions=array("flat_id"=>(int)$flat_id);
			$result_flat=$this->flat->find('all',array('conditions'=>$conditions));
			$other_charges_database=@$result_flat[0]["flat"]["other_charges"];
			if(sizeof($other_charges_database)>0){
				$other_charges_database[$income_head_id]=array($amount,$charge_type);
				$this->loadmodel('flat');
				$this->flat->updateAll(array('other_charges'=> $other_charges_database),array('flat_id'=>(int)$flat_id));
			}else{
				$other_charges[$income_head_id]=array($amount,$charge_type);
				$this->loadmodel('flat');
				$this->flat->updateAll(array('other_charges'=> $other_charges),array('flat_id'=>(int)$flat_id));
			}
		}
	?>

<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
<p>Other Charges Updated Successfully</p>
</div>
<div class="modal-footer">
<a href="other_charges" class="btn red">OK</a>
</div>
</div>

<?php
	}

}

function fetch_other_charges_via_flat_id($flat_id){
	$this->loadmodel('flat');
	$conditions=array("flat_id"=>(int)$flat_id);
	$result_flat=$this->flat->find('all',array('conditions'=>$conditions));
	return @$result_flat[0]["flat"]["other_charges"];
}
//END OTHER CHARGES//
/////////////////////////////////// Start It Setup (Accounts) ///////////////////////////////////////////////
function it_setup()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}

$this->ath();
$this->check_user_privilages();


$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$tems_id = (int)$this->request->query('d');

if(!empty($tems_id))
{
$this->loadmodel('terms_condition');
$this->terms_condition->updateAll(array("status" => 2),array("terms_conditions_id" => $tems_id));
?>
<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
<p>Terms & Condition Deleted Successfully</p>
</div> 
<div class="modal-footer">
<a href="it_setup"   class="btn red">OK</a>
</div>
</div>
<!----alert-------------->

<?php	
}

if(isset($this->request->data['sub']))
{
$terms=$this->request->data['terms'];

$this->loadmodel('society');
$conditions=array("society_id"=>$s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)		
{
$terms_con = @$collection['society']['terms_conditions'];
}
$terms_con[] = $terms;

$this->loadmodel('society');
$this->society->updateAll(array("terms_conditions" => $terms_con),array("society_id" => $s_society_id));	
?>

<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
<p>Terms & Condition Added Successfully</p>
</div> 
<div class="modal-footer">
<a href="it_setup"   class="btn red">OK</a>
</div>
</div>
<!----alert-------------->

<?php	
}
if(isset($this->request->data['del']))
{
$del_id = (int)$this->request->data['arr_id'];

$this->loadmodel('society');
$conditions=array("society_id"=>$s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$terms_arr = $collection['society']['terms_conditions'];
}
for($k=0; $k<sizeof($terms_arr); $k++)
{
$terms_name = $terms_arr[$k];

if($k == $del_id)
continue;

$terms_new_arr[] = $terms_name;
}
$this->loadmodel('society');
$this->society->updateAll(array("terms_conditions" => $terms_new_arr),array("society_id" => $s_society_id));
}


if(isset($this->request->data['edit']))
{
$terms_name = $this->request->data['name'];
$edit_id = (int)$this->request->data['arr_id'];

$this->loadmodel('society');
$conditions=array("society_id"=>$s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$terms_arr = $collection['society']['terms_conditions'];
}
$terms_arr[$edit_id] = $terms_name;

$this->loadmodel('society');
$this->society->updateAll(array("terms_conditions" => $terms_arr),array("society_id" => $s_society_id));
}

$this->loadmodel('terms_conditions');
$conditions=array("society_id"=>$s_society_id,"status"=>1);
$cursor1=$this->terms_conditions->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);
	
$this->loadmodel('society');
$conditions=array("society_id"=>$s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);	

								
}

///////////////////////////////// End It Setup (Accounts) /////////////////////////////////////////////////

/////////////////////////Start Master rate Card(Accounts)//////////////////////////////
function master_rate_card()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}

$this->ath();
$this->check_user_privilages();

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	
$nnn = 5;
$this->set('nnn',$nnn);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor222 = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor222 as $collection)
{
$area_typppp = (int)@$collection['society']['area_scale'];
}
$this->set('area_typppp',$area_typppp);


if(isset($this->request->data['sub']))
{
$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2 = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor2 as $collection)
{
$income_head_arr = $collection['society']['income_head'];
}


$this->loadmodel('flat_type');
$conditions=array("society_id" => $s_society_id);
$cursor1 = $this->flat_type->find('all',array('conditions'=>$conditions));
foreach($cursor1 as $collection)
{
$auto_id1 = (int)$collection['flat_type']['auto_id'];
$rate_arr = array();
$rate_arri = array();
for($l=0; $l<sizeof($income_head_arr); $l++)
{
$auto_id2 = (int)$income_head_arr[$l];


$charge_type_id = (int)$this->request->data['charge_type'.$auto_id1.$auto_id2];
$charge = (int)$this->request->data['charge'.$auto_id1.$auto_id2];
$arr = array($auto_id1,$auto_id2,$charge_type_id,$charge);
$arri = implode('-',$arr);
$rate_arri[] = $arri;
$rate_arr[] = $arr;
}
$main_arri = implode("/",$rate_arri);
$show_arr[] = $main_arri;

//$this->loadmodel('flat_type');
//$this->flat_type->updateAll(array('charge' => $rate_arr),array('auto_id' => $auto_id));
}
$show_arri = implode(',',$show_arr);

$this->response->header('Location','rate_card_view2?arr='.$show_arri.' ');
}

$this->loadmodel('flat_type');
$conditions=array("society_id" => $s_society_id);
$cursor = $this->flat_type->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$auto_id = (int)$collection['flat_type']['auto_id'];
@$charge = $collection['flat_type']['charge'];



if(isset($this->request->data['sub'.$auto_id]))
{
$count = $this->request->data['count'.$auto_id];
$n=0;
for($k=0; $k<sizeof($charge); $k++)
{
$n++;
$charge2 = $charge[$k];
$ih_id = (int)$charge2[0];
$tp_id = (int)$this->request->data['tp'.$n];
$amt = $this->request->data['amt'.$n];
$arr = array($ih_id,$tp_id,$amt);
$rat_arr2[] = $arr;
}

$this->loadmodel('flat_type');
$this->flat_type->updateAll(array('charge' => $rat_arr2),array('auto_id' => $auto_id));


}
}


$this->loadmodel('flat_type');
$conditions=array("society_id" => $s_society_id);
$cursor1 = $this->flat_type->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('income_head');
$order=array('income_head.auto_id'=>'ASC');
$conditions=array("society_id" => $s_society_id,"delete_id"=>0);
$cursor2 = $this->income_head->find('all',array('conditions'=>$conditions,'order' => $order));
$this->set('cursor2',$cursor2);


$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor3 = $this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor3',$cursor3);

}
//////////////////////// End Master rate Card(Accounts)//////////////////////////////

/////////////////////////// Start master rate card view (Accounts)/////////////////////////////////
function master_rate_card_view()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}

$this->ath();
$this->check_user_privilages();

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');	


$this->loadmodel('flat_type');
$condition=array('society_id'=>$s_society_id,"status"=>0);
$result2=$this->flat_type->find('all',array('conditions'=>$condition)); 
$this->set('cursor2',$result2);


$this->loadmodel('income_head');
$order=array('income_head.auto_id'=>'ASC');
$conditions=array("society_id" => $s_society_id,"delete_id"=>0);
$cursor3 = $this->income_head->find('all',array('conditions'=>$conditions,'order' => $order));
$this->set('cursor3',$cursor3);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor4 = $this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor4',$cursor4);

}
/////////////////////////// End master rate card view (Accounts)/////////////////////////////////
////////////////////// Start Supplimentry Vali (Accounts)////////////////////////////////
function supplimentry_vali()
{
$this->layout='blank';

$this->ath();

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$cc = (int)$this->request->query('ss');
$this->set('cc',$cc);
}
////////////////////// End Supplimentry Vali (Accounts)////////////////////////////////
/////////////////////Start Financial Vali Ajax(Accounts)//////////////////////////////
function regular_vali()
{
$this->layout='blank';
$this->ath();

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$cc = (int)$this->request->query('ss');
$this->set('cc',$cc);

}
/////////////////////End Financial Vali Ajax(Accounts)//////////////////////////////


///////////////////// Start Master rate Card Edit ///////////////////////////////////
function master_rate_card_edit($auto_id5=null)
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
$nnn = 5;
$this->set("nnn",$nnn);
if(isset($this->request->data['sub']))
{
$tp_id = (int)$this->request->data['au'];

$this->loadmodel('society');
$condition=array('society_id'=>$s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$condition)); 
foreach($cursor as $collection)
{
$income_head_arr = $collection['society']['income_head'];
}
for($g=0; $g<sizeof($income_head_arr); $g++)
{
$auto_id = (int)$income_head_arr[$g];
$tp = (int)$this->request->data['tp'.$auto_id];
$amt = $this->request->data['amt'.$auto_id];
$ch = array($auto_id,$tp,$amt);
$ch2 = implode(",",$ch);
$ch3[] = $ch2;
$ch4 = implode("/",$ch3);
}
$nnn = 55;
$this->set("nnn",$nnn);
$this->set("ch4",$ch4);
$this->set("au",$tp_id);

//$this->loadmodel('flat_type');
//$this->flat_type->updateAll(array('charge'=>$ch2),array('auto_id'=>$tp_id));

}

if(isset($this->request->data['sub2']))
{
$au = (int)$this->request->data['auto_id'];
echo $ch4 = $this->request->data['val'];
$ch3 = explode("/",$ch4);
echo "<br>";
for($i=0; $i<sizeof($ch3); $i++)
{
$ch2 = $ch3[$i];
$ch1 = explode(",",$ch2);
$a1 = (int)$ch1[0];
$a2 = (int)$ch1[1];
$a3 = $ch1[2];
$ch = array($a1,$a2,$a3);
$ch_arr[] = $ch;
}
$this->loadmodel('flat_type');
$this->flat_type->updateAll(array('charge'=>$ch_arr),array('auto_id'=>$au));
//$this->response->header('Location','master_rate_card_view');
$this->redirect(array('controller' => 'Incometrackers','action' => 'master_rate_card_view'));
}

$auto_id5 = (int)$auto_id5;
$this->set('auto_id',$auto_id5);

$this->loadmodel('flat_type');
$condition=array('society_id'=>$s_society_id,"auto_id"=>$auto_id5,"status"=>0);
$result2=$this->flat_type->find('all',array('conditions'=>$condition)); 
$this->set('cursor1',$result2);

$this->loadmodel('income_head');
$condition=array('society_id'=>$s_society_id,"delete_id"=>0);
$cursor2 = $this->income_head->find('all',array('conditions'=>$condition)); 
$this->set('cursor2',$cursor2);

$this->loadmodel('society');
$condition=array('society_id'=>$s_society_id);
$cursor3 = $this->society->find('all',array('conditions'=>$condition)); 
$this->set('cursor3',$cursor3);

}
///////////////////// End Master rate Card Edit ///////////////////////////////////

/////////////////////////// Start Master Noc (Accounts)/////////////////////////////
function master_noc()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	


$this->ath();
$this->check_user_privilages();

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor222 = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor222 as $collection)
{
$area_typppp = (int)@$collection['society']['area_scale'];
}
$this->set('area_typppp',$area_typppp);

if(isset($this->request->data['sub']))
{

$this->loadmodel('flat_type');
$order=array('flat_type.auto_id'=>'ASC');
$condition=array('society_id'=>$s_society_id);
$cursor1 = $this->flat_type->find('all',array('conditions'=>$condition,'order' => $order)); 
foreach($cursor1 as $collection)
{
$auto_id1 = (int)$collection['flat_type']['auto_id'];
$fl_tp_id = (int)$collection['flat_type']['flat_type_id'];
$arr2 = array();

$tp = (int)$this->request->data['ctp'.$auto_id1];
if($tp == 4)
{
 $percent = (int)$this->request->data['amt'.$auto_id1];	
 $income_head = (int)$this->request->data['in_head'.$auto_id1];	

$arr1 = array($tp,$fl_tp_id,);
$arr2 = implode(",",$arr1);
}
else
{
$amt = $this->request->data['amt'.$auto_id1];
$arr1 = array($tp,$fl_tp_id,$amt);
$arr2 = implode(",",$arr1);
}
$show_arr[] = $arr2;

}
$show_arr2 = implode("/",$show_arr);
//$this->loadmodel('flat_type');
//$this->flat_type->updateAll(array('noc_charge' => $arr1),array('auto_id' => $auto_id1));
$this->response->header('Location','noc_view2?arr='.$show_arr2.' ');
}

$this->loadmodel('flat_type');
$order=array('flat_type.auto_id'=>'ASC');
$condition=array('society_id'=>$s_society_id);
$cursor1 = $this->flat_type->find('all',array('conditions'=>$condition,'order' => $order)); 
$this->set('cursor1',$cursor1);

$this->loadmodel('noc_charge');
$order=array('noc_charge.auto_id'=>'ASC');
$condition=array('society_id'=>$s_society_id);
$cursor2 = $this->noc_charge->find('all',array('conditions'=>$condition,'order' => $order)); 
$this->set('cursor2',$cursor2);

$this->loadmodel('society');
$conditions=array("society_id"=>$s_society_id);
$cursor3 = $this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor3',$cursor3);
}


function master_noc_status()
{
	if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}

$this->ath();
$this->check_user_privilages();
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	
	
	
	$this->loadmodel('ledger_sub_account');
		$condition=array('society_id'=>$s_society_id,'ledger_id'=>34,'deactive'=>0);
		$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$condition));
		$this->set('result_ledger_sub_account',$result_ledger_sub_account);
		foreach($result_ledger_sub_account as $ledger_sub_account){
			$ledger_sub_account_user_id=$ledger_sub_account["ledger_sub_account"]["user_id"];
			$ledger_sub_account_flat_id=$ledger_sub_account["ledger_sub_account"]["flat_id"];
				$flats_for_bill[]=$ledger_sub_account_flat_id;
		}
		///order asc wing and flat/////
		$this->loadmodel('wing');
		$condition=array('society_id'=>$s_society_id);
		$order=array('wing.wing_name'=>'ASC');
		$result_wing=$this->wing->find('all',array('conditions'=>$condition,'order'=>$order));
		foreach($result_wing as $wing_info){
			$wing_id=$wing_info["wing"]["wing_id"];
			$this->loadmodel('flat');
			$condition=array('wing_id'=>(int)$wing_id);
			$order=array('flat.flat_name'=>'ASC');
			$result_flat=$this->flat->find('all',array('conditions'=>$condition,'order'=>$order));
			foreach($result_flat as $flat_info){
				$flat_id=$flat_info["flat"]["flat_id"];
				if (in_array($flat_id, $flats_for_bill)) {
					$new_flats_for_bill[]=$flat_id;
				}
			}
		}
		$this->set('flats_for_bill',$new_flats_for_bill);
	
	
	if($this->request->is('post')){
	foreach($new_flats_for_bill as $flat_id1){
	  
			$value =@$this->request->data[$flat_id1]; 
			if($value==1){
				$this->loadmodel('flat');
				$this->flat->updateAll(array('noc_ch_tp'=>1),array('flat_id'=>$flat_id1));
				
			}
			if($value==2){
				$this->loadmodel('flat');
				$this->flat->updateAll(array('noc_ch_tp'=>2),array('flat_id'=>$flat_id1));
				
			}
				
	
		}

	}

}
///////////////////////// End master Noc (Accounts)/////////////////////////////////

////////////////////////// Start master noc view/////////////////////////////////////////////////
function master_noc_view()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}

$this->ath();
$this->check_user_privilages();


$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');	

$this->loadmodel('flat_type');
$conditions=array("society_id" => $s_society_id,"status"=>0);
$cursor1 = $this->flat_type->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);


}
////////////////////////// End master noc view/////////////////////////////////////////////////
///////////////////// Start IT Penalty (Accounts)///////////////////////////////////

function it_penalty()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}



$this->ath();
$this->check_user_privilages();


$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

if(isset($this->request->data['sub']))
{
//$base = (int)$this->request->data['base'];
$type = (int)$this->request->data['type'];
$tax = $this->request->data['tax'];

$this->loadmodel('society');
$this->society->updateAll(array('tax'=>$tax,"tax_type"=>$type),array('society_id'=>$s_society_id));


?>
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
<p>Penalty Updated Successfully</p>
</div>
<div class="modal-footer">
<a href="it_penalty" class="btn red">OK</a>
</div>
</div>

<?php
}

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$tax = @$collection['society']['tax'];
$tax_type = @$collection['society']['tax_type'];
}
$this->set("tax",$tax);
$this->set("tax_type",$tax_type);
}

///////////////////// End IT Penalty (Accounts)///////////////////////////////////

/////////////////////// Start NOC Edit ////////////////////////////////////////////////////////
function noc_edit()
{
$this->layout="session";
$this->ath();

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');
$nnn = 5;
$this->set("nnn",$nnn);
if(isset($this->request->data['sub']))
{
$aut = (int)$this->request->data['au'];

$type = (int)$this->request->data['tp'];
if($type == 4)
{
$ch = array($type);
$ch1 = implode(",",$ch);
}
else
{
$amt = $this->request->data['amt'];
$ch = array($type,$amt);
$ch1 = implode(",",$ch);
}
$nnn = 55;
$this->set("nnn",$nnn);
$this->set("au",$aut);
$this->set('ch1',$ch1);
//$this->loadmodel('flat_type');
//$this->flat_type->updateAll(array('noc_charge'=>$ch),array('auto_id'=>$aut));

//$this->response->header('Location', 'master_noc_view');
}

if(isset($this->request->data['sub2']))
{
$ch2 = $this->request->data['val'];
$aut2 = (int)$this->request->data['auto_id'];
$ch3 = explode(",",$ch2);

$this->loadmodel('flat_type');
$this->flat_type->updateAll(array('noc_charge'=>$ch3),array('auto_id'=>$aut2));

$this->response->header('Location', 'master_noc_view');

}
$auto_id = (int)$this->request->query('a');
$this->set('auto_id',$auto_id);

$this->loadmodel('flat_type');
$condition=array('society_id'=>$s_society_id,"auto_id"=>$auto_id,"status"=>0);
$result2=$this->flat_type->find('all',array('conditions'=>$condition)); 
$this->set('cursor1',$result2);
}
//////////////////////// End NOC Edit //////////////////////////////////////////////////////////////

/////////////////// /// Start in report ajax ////////////////////////////////////
function in_report_ajax(){
	
	$this->layout='blank';
	$this->ath();
	
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');	

	$one_time_id = (int)$this->request->query('un');
	$this->set('one_time_id',$one_time_id);
	
	$this->loadmodel('new_regular_bill');
	$conditions=array("society_id" => $s_society_id,"approval_status" => 1,"one_time_id" => $one_time_id,'new_regular_bill.edit_status'=>array('$ne'=>"YES"));
	$order=array('new_regular_bill.one_time_id'=> 'DESC');
	$result_new_regular_bill = $this->new_regular_bill->find('all',array('conditions'=>$conditions,'order'=>$order));
	$this->set("result_new_regular_bill",$result_new_regular_bill);
	foreach($result_new_regular_bill as $regular_bill){
		$other_charges_array=@$regular_bill["new_regular_bill"]["other_charges_array"];
		if(!empty($other_charges_array)){
			foreach($other_charges_array as $key=>$value){
				$other_charges_ids[]=$key;
			}
		}
	}
	if(sizeof(@$other_charges_ids)>0){
	$other_charges_ids=array_unique($other_charges_ids);
	$this->set('other_charges_ids',$other_charges_ids);
	}
	
	
	
	$this->loadmodel('new_regular_bill');
	$conditions2=array("society_id" => $s_society_id,"approval_status" => 1);
	$result_new_regular_bill_max = $this->new_regular_bill->find('all',array('conditions'=>$conditions2));
	foreach($result_new_regular_bill_max as $data_max){
		$one_time_ids[]=$data_max["new_regular_bill"]["one_time_id"];
	}
	
	if(!empty($one_time_ids))
	{
	$maximum_one_time_id=max(@$one_time_ids);
	$this->set("maximum_one_time_id",$maximum_one_time_id);
	}

	$this->loadmodel('society');
	$condition=array('society_id'=>$s_society_id);
	$result_society=$this->society->find('all',array('conditions'=>$condition)); 
	$this->set('result_society',$result_society);
	
	$this->loadmodel('wing');
	$condition=array('society_id'=>$s_society_id);
	$order=array('wing.wing_name'=>'ASC');
	$result_wing=$this->wing->find('all',array('conditions'=>$condition,'order'=>$order));
	$this->set('result_wing',$result_wing);

}
/////////////////// /// End in report ajax ////////////////////////////////////

///////////////////////// Start In Head Excel///////////////////////////////////////
function in_head_excel()
{

$this->layout="";
$this->ath();

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');	

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
}
$socc_namm = str_replace(' ', '_', $society_name);
$this->set('socc_namm',$socc_namm);
		
$one_time_id = (int)$this->request->query('one');
	$this->set('one_time_id',$one_time_id);
	
	$this->loadmodel('new_regular_bill');
	$conditions=array("society_id" => $s_society_id,"approval_status" => 1,"one_time_id" => $one_time_id,'new_regular_bill.edit_status'=>array('$ne'=>"YES"));
	$order=array('new_regular_bill.one_time_id'=> 'DESC');
	$result_new_regular_bill = $this->new_regular_bill->find('all',array('conditions'=>$conditions,'order'=>$order));
	$this->set("result_new_regular_bill",$result_new_regular_bill);
	foreach($result_new_regular_bill as $regular_bill){
		$other_charges_array=@$regular_bill["new_regular_bill"]["other_charges_array"];
		if(!empty($other_charges_array)){
			foreach($other_charges_array as $key=>$value){
				$other_charges_ids[]=$key;
			}
		}
	}
	if(sizeof(@$other_charges_ids)>0){
	$other_charges_ids=array_unique($other_charges_ids);
	$this->set('other_charges_ids',$other_charges_ids);
	}
	
	
	
	$this->loadmodel('new_regular_bill');
	$conditions2=array("society_id" => $s_society_id,"approval_status" => 1);
	$result_new_regular_bill_max = $this->new_regular_bill->find('all',array('conditions'=>$conditions2));
	foreach($result_new_regular_bill_max as $data_max){
		$one_time_ids[]=$data_max["new_regular_bill"]["one_time_id"];
	}
	$maximum_one_time_id=max($one_time_ids);
	$this->set("maximum_one_time_id",$maximum_one_time_id);
	

	$this->loadmodel('society');
	$condition=array('society_id'=>$s_society_id);
	$result_society=$this->society->find('all',array('conditions'=>$condition)); 
	$this->set('result_society',$result_society);

$this->loadmodel('wing');
$condition=array('society_id'=>$s_society_id);
$order=array('wing.wing_name'=>'ASC');
$result_wing=$this->wing->find('all',array('conditions'=>$condition,'order'=>$order));
$this->set('result_wing',$result_wing);


	
}
///////////////////////// End In Head Excel///////////////////////////////////////

////////////////// Start Regular Bill Excel (Accounts)//////////////////////////////
function regular_bill_excel()
{
	$this->layout="";
	$this->ath();

	$s_society_id=(int)$this->Session->read('society_id');
    $s_user_id = (int)$this->Session->read('user_id');


$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
$valllll = (int)$collection['society']['area_scale'];
}
$this->set('valllll',$valllll);

$socc_namm = str_replace(' ', '_', $society_name);
$this->set('socc_namm',$socc_namm);


$wise = (int)$this->request->query('w');
$this->set('wise',$wise);

if($wise == 1)
{
$wing = (int)$this->request->query('u');
$this->set('wing',$wing);
}
else if($wise == 2)
{
$user_id = (int)$this->request->query('u');
$this->set('user_id',$user_id);
}
else if($wise == 3)
{
$bill_id = $this->request->query('u');
$this->set('bill_id',$bill_id);
}

if(!empty($bill_id))
{
$this->loadmodel('new_regular_bill');
$order=array('new_regular_bill.bill_start_date'=> 'DESC');
$conditions=array('society_id'=>$s_society_id,"approval_status"=>1,"bill_no"=>$bill_id,"edit_status"=>"NO");
$curssrrrrrr=$this->new_regular_bill->find('all',array('conditions'=>$conditions,'order'=>$order));
}
$this->loadmodel('new_regular_bill');
$order=array('new_regular_bill.bill_start_date'=> 'DESC');
$conditions=array('society_id'=>$s_society_id,"approval_status"=>1,"edit_status"=>"NO");
$cursorrrr=$this->new_regular_bill->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('cursorrrr',$cursorrrr);

$cursor	= $cursorrrr;

foreach($cursor as $dataaaa)
{
$income_head_array=$dataaaa["new_regular_bill"]["income_head_array"];	
}
$this->set('income_head_array',$income_head_array);
	
	

						
}
////////////////// End Regular Bill Excel (Accounts)////////////////////////////////

////////////////////// Start Supplimentry reports show ajax//////////////////////////
function supplimentry_reports_show_ajax()
{
$this->layout='blank';

$this->ath();

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$this->loadmodel('society');
$conditions=array("society_id"=> $s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
}
$this->set('society_name',$society_name);

$from =  $this->request->query('date1');
$to = $this->request->query('date2');
$tp = $this->request->query('tp');

$this->set('from',$from);
$this->set('to',$to);
$this->set('tp',$tp);

$this->loadmodel('adhoc_bill');
$order=array('adhoc_bill.bill_daterange_from'=> 'ASC');
$conditions=array("society_id"=> $s_society_id);
$cursor1=$this->adhoc_bill->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('cursor1',$cursor1);

}
////////////////////// Start Supplimentry reports show ajax//////////////////////////

///////////////////// Start supplimentry Bill Excel/////////////////////////////////

function supplimentry_bill_excel()
{
$this->layout="";
$this->ath();

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$from = $this->request->query('f');
$to = $this->request->query('t');
$tp = $this->request->query('tp');

$fdddd = date('d-M-Y',strtotime($from));
$tdddd = date('d-M-Y',strtotime($to));


$this->loadmodel('society');
$conditions=array("society_id"=> $s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach ($cursor as $collection) 
{
$society_name = $collection['society']['society_name'];
}

$this->set('society_name',$society_name);


$socc_namm = str_replace(' ', '_', $society_name);

$this->set('fdddd',$fdddd);
$this->set('tdddd',$tdddd);
$this->set('socc_namm',$socc_namm);


$from = $this->request->query('f');
$to = $this->request->query('t');
$tp = $this->request->query('tp');
$this->set('from',$from);
$this->set('to',$to);
$this->set('tp',$tp);

$this->loadmodel('adhoc_bill');
$conditions=array("society_id"=> $s_society_id);
$cursor1=$this->adhoc_bill->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

}
///////////////////// End supplimentry Bill Excel/////////////////////////////////

////////////////////////////////////////////////// Start Income Heads Report (Accounts)//////////////////////////////////////////////////////////////////
function income_heads_report()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}

$this->ath();
$this->check_user_privilages();



$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	


}
/////////////////////////// End Income Heads Report (Accounts)///////////////////////

//////////////////////////// Start Income Heads Report Ajax(Accounts)///////////////
function income_heads_report_ajax()
{
$this->layout='blank';

$this->ath();

$s_role_id= (int)$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$this->loadmodel('society');
$conditions=array("society_id"=>$s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
$society_reg_num = $collection['society']['society_reg_num'];
$society_address = $collection['society']['society_address'];
}
$this->set('society_name',$society_name);
$this->set('society_reg_num',$society_reg_num);
$this->set('society_address',$society_address);

$from = $this->request->query('date1');
$to = $this->request->query('date2');

$this->set('from',$from);
$this->set('to',$to);

$this->loadmodel('income_head');
$order=array('income_head.auto_id'=> 'ASC');
$conditions=array("delete_id" => 0,"society_id"=>$s_society_id);
$cursor1=$this->income_head->find('all',array('conditions'=>$conditions,'order' =>$order));
$this->set('cursor1',$cursor1);	

$this->loadmodel('regular_bill');
$order=array('regular_bill.receipt_id'=> 'ASC');
$conditions=array("society_id"=>$s_society_id);
$cursor2=$this->regular_bill->find('all',array('conditions'=>$conditions,'order' =>$order));
$this->set('cursor2',$cursor2);	

$this->loadmodel('flat_type');
$conditions=array("society_id"=>$s_society_id);
$cursor9 = $this->flat_type->find('all',array('conditions'=>$conditions));
$this->set('cursor9',$cursor9);


}
////////////////////////////// End Income Heads Report Ajax(Accounts)////////////////
///////////////////////////////// Start Regular Bill Pdf(Accounts)///////////////////////////////////////
function regular_bill_pdf($auto_id=null)
{
$this->layout = 'pdf'; //this will use the pdf.ctp layout 
$this->ath();
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$auto_id = (int)$auto_id;

$this->loadmodel('new_regular_bill');
$conditions=array("auto_id" => $auto_id,"society_id"=>$s_society_id);
$cursor1=$this->new_regular_bill->find('all',array('conditions'=>$conditions));
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
/////////////////////////////////// End Regular Bill Pdf(Accounts)/////////////////////////////////////////////////////

///////////////////////////////////////////// Start Supplimentry Bill Pdf (Accounts)////////////////////////////////////////////////////////////////////
function supplimentry_bill_pdf()
{
$this->layout = 'pdf'; //this will use the pdf.ctp layout 
$this->ath();


$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$bill_id = (int)$this->request->query('p');
$this->set('bill_id',$bill_id);

$this->loadmodel('adhoc_bill');
$conditions=array("adhoc_bill_id" => $bill_id);
$cursor1=$this->adhoc_bill->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$tems_arr = $collection['society']['terms_conditions'];
}
$this->set('tems_arr',$tems_arr);






}
//////////////////////////////////////////// End Supplimentry Bill Pdf (Accounts)///////////////////////////////////////////////////////////////////////

//////////////////////////// Start Regular Bill View (Accounts)////////////////////////////////////////////////////////
function regular_bill_view($auto_id=null)
{
$this->layout='session';
$this->ath();

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

 $auto_id = (int)$auto_id;

$this->loadmodel('new_regular_bill');
$conditions=array("auto_id"=>$auto_id);
$result_new_regular_bill=$this->new_regular_bill->find('all',array('conditions'=>$conditions));
$this->set('result_new_regular_bill',$result_new_regular_bill);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$result_society=$this->society->find('all',array('conditions'=>$conditions));
$this->set('result_society',$result_society);

$this->loadmodel('new_regular_bill');
$conditions=array("auto_id"=>$auto_id);
$cursor=$this->new_regular_bill->find('all',array('conditions'=>$conditions));
foreach($cursor as $data)
{
$last_bill_one_time_id = (int)$data['new_regular_bill']['one_time_id'];
$flat = (int)$data['new_regular_bill']['flat_id'];
}
$last_bill_one_time_id--;





$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor3=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor3 as $data)
{
$receipt_show_id = (int)@$data['society']['merge_receipt'];
}
if($receipt_show_id == 1)
{
$result_new_cash_bank = $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_last_receipt_info_via_flat_id'),array('pass'=>array($flat,$last_bill_one_time_id)));
$this->set('result_new_cash_bank',$result_new_cash_bank);
$size = sizeof($result_new_cash_bank);
}
else
{
$size=0;
}
$this->set('size',$size);
}

function regular_bill_edit2($auto_id=null){
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	$this->ath();
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$auto_id=(int)$auto_id;
	$this->loadmodel('new_regular_bill');
	$conditions=array("auto_id"=>$auto_id);
	$result_new_regular_bill=$this->new_regular_bill->find('all',array('conditions'=>$conditions));
	$this->set('result_new_regular_bill',$result_new_regular_bill);
	$income_head_array=$result_new_regular_bill[0]["new_regular_bill"]["income_head_array"];
	$other_charges_array=$result_new_regular_bill[0]["new_regular_bill"]["other_charges_array"];
	$flat_id=$result_new_regular_bill[0]["new_regular_bill"]["flat_id"];
	$bill_number=$result_new_regular_bill[0]["new_regular_bill"]["bill_no"];
	$bill_number=$bill_number.'-R';
	$bill_start_date=$result_new_regular_bill[0]["new_regular_bill"]["bill_start_date"];
	$bill_end_date=$result_new_regular_bill[0]["new_regular_bill"]["bill_end_date"];
	$description=$result_new_regular_bill[0]["new_regular_bill"]["description"];
	$due_date=$result_new_regular_bill[0]["new_regular_bill"]["due_date"];
	$one_time_id=$result_new_regular_bill[0]["new_regular_bill"]["one_time_id"];
	$period_id=@$result_new_regular_bill[0]["new_regular_bill"]["period_id"];
	
	
	if($period_id!=1){
		$billing_period_text=date("M",$bill_start_date).' - '.date("M",$bill_end_date).'  '.date("Y",$bill_end_date);
	}else{
		$billing_period_text=date("M-Y",$bill_start_date);
	}
	
	$this->loadmodel('society');
	$conditions=array("society_id" => $s_society_id);
	$result_society=$this->society->find('all',array('conditions'=>$conditions));
	$this->set('result_society',$result_society);
	foreach($result_society as $data){
		$society_name=$data["society"]["society_name"];
		$society_reg_num=$data["society"]["society_reg_num"];
		$society_address=$data["society"]["society_address"];
		$society_phone=$data["society"]["society_phone"];
		$society_email=$data["society"]["society_email"];
		$terms_conditions=$data["society"]["terms_conditions"];
		$signature=$data["society"]["signature"];
		$sig_title=$data["society"]["sig_title"];
	    $neft_type = @$data["society"]["neft_type"];
	    $neft_detail = @$data["society"]["neft_detail"];
	    $society_logo = @$data["society"]["logo"];
		$area_scale = (int)@$data["society"]["area_scale"];
	}
	
	
	if($area_scale==0 or $area_scale==null){
		$area_scale_text="sq.ft.";
	}
	if($area_scale==1){
		$area_scale_text="sq.mtr.";
	}
	
	$result_ledger_sub_account = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch3'),array('pass'=>array($flat_id)));
	foreach($result_ledger_sub_account as $ledger_sub_account){
		$ledger_sub_account_id = (int)$ledger_sub_account['ledger_sub_account']['auto_id'];
	}
			
			
	//wing_id via flat_id//
	$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
	foreach($result_flat_info as $flat_info){
		$wing_id=$flat_info["flat"]["wing_id"];
	}
	
	$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing_id,$flat_id)));
	
	$result_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_fetch2'),array('pass'=>array(@$flat_id,$wing_id))); 
	foreach($result_flat as $data2){
		$sq_feet = $data2['flat']['flat_area'];
	}
	
	//user info via flat_id//
	$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wing_id,$flat_id)));
	foreach($result_user_info as $user_info){
		$user_id=$user_info["user"]["user_id"];
		$user_name=$user_info["user"]["user_name"];
	}
		
		
		$result_ledger_sub_account = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch3'),array('pass'=>array($flat_id)));
			foreach($result_ledger_sub_account as $ledger_sub_account)
			{
			$ledger_sub_account_id = (int)$ledger_sub_account['ledger_sub_account']['auto_id'];
			}
			
			foreach($result_society as $data){
				$income_heads=$data["society"]["income_head"];
			}
			

			
			
	/////submit code////
	if(isset($this->request->data['edit_bill'])){
		foreach($income_head_array as $income_head_id=>$income_head_amount){
			$income_head_array[$income_head_id] = (int)@$this->request->data['income_head'.$income_head_id];
		}
		$non_occupancy_charges = (int)@$this->request->data['non_occupancy_charges'];
		foreach($other_charges_array as $other_charge_id=>$other_charge_amount){
			$other_charges_array[$other_charge_id] = (int)@$this->request->data['other_charges'.$other_charge_id];
			
		}
		 
		$total = (int)@$this->request->data['total']; 
		$interest_on_arrears = (int)@$this->request->data['interest_on_arrears'];
		$arrear_maintenance = (int)@$this->request->data['arrear_maintenance'];
		$arrear_intrest = (int)@$this->request->data['arrear_intrest'];
		$credit_stock = (int)@$this->request->data['credit_stock'];
		$due_for_payment = (int)@$this->request->data['due_for_payment'];
		 
		 
		$account_name = "";	
		$bank_name = "";
		$account_number = "";
		$branch = "";
		$ifsc_code = "";
			
		if($neft_type ==  "ALL"){
			$account_name = @$neft_detail['account_name'];	
			$bank_name = @$neft_detail['bank_name'];
			$account_number = @$neft_detail['account_number'];
			$branch = @$neft_detail['branch'];
			$ifsc_code = @$neft_detail['ifsc_code'];	
		}
		if($neft_type ==  "WW"){			
			$neft_detail2 = $neft_detail[$wing_id];
			$account_name = @$neft_detail2['account_name'];	
			$bank_name = @$neft_detail2['bank_name'];
			$account_number = @$neft_detail2['account_number'];
			$branch = @$neft_detail2['branch'];
			$ifsc_code = @$neft_detail2['ifsc_code'];		
		}
		
		


@$ip=$this->hms_email_ip();

$bill_html='<div style="margin: 0px;">
        <table style="padding:24px;background-color:#34495e" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="main_table">
            <tbody><tr>
                <td>
                    <table style="padding:38px 30px 30px 30px;background-color:#fafafa" align="center" border="0" cellpadding="0" cellspacing="0" width="540">
                        <tbody>
						<tr>
							<td height="10">
							<table width="100%" class="hmlogobox">
								<tr>
									<td width="50%" style="padding: 10px 0px 0px 10px;"><img src="'.$ip.$this->webroot.'/as/hm/hm-logo.png" style="max-height: 60px; " height="60px" /></td>
									<td width="50%" align="right" valign="middle"  style="padding: 7px 10px 0px 0px;">
									<a href="https://www.facebook.com/HousingMatters.co.in"><img src="'.$ip.$this->webroot.'/as/hm/SMLogoFB.png"    style="max-height: 30px; height: 30px; width: 30px; max-width: 30px;" height="30px" width="30px" /></a>
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
									<td style="padding:2px;background-color:rgb(0,141,210);color:#fff" align="center" width="100%"><b>'.strtoupper($society_name).'</b></td>
								</tr>
							</tbody></table>
							<table style="font-size:12px" width="100%" cellspacing="0">
								<tbody>
								<tr>
									<td width="30%" style="border-bottom: solid 1px #767575;    border-top: solid 1px #767575;">';
									if(!empty($society_logo)){
									$bill_html.='<img src="'.$webroot_path.'/logo/'.$society_logo.'"  height="45px" width="45px">';	
									}
						$bill_html.='</td>
									<td style="padding:5px;border-bottom: solid 1px #767575;    border-top: solid 1px #767575;"  width="70%" align="right">
									<span style="color: rgb(100, 100, 99); ">Regn# &nbsp; '.$society_reg_num.'</span><br>
									<span style="color: rgb(100, 100, 99); ">'.$society_address.'</span><br><span>Email:</span><a href="mailto:'.$society_email.'" target="_blank" style="color:#000 !important;text-decoration: none;">'.$society_email.'</a> | <span>Phone : '.$society_phone.'</span>
									</td>
								</tr>
								</tbody>
							</table>
							<table style="font-size:12px" width="100%" cellspacing="0">
								<tbody><tr>
									<td style="padding: 0px 0 0 5px;"><b>Name:</b></td>
									<td>'.$user_name.'</td>
									<td><b>Flat/Shop No.:</b></td>
									<td>'.$wing_flat.'</td>
								</tr>
								<tr>
									<td style="padding: 0px 0 0 5px;"><b>Bill No.:</b></td>
									<td>'.$bill_number.'</td>
									<td><b>Area ('.$area_scale_text.'):</b></td>
									<td>'.$sq_feet.'</td>
								</tr>
								<tr>
									<td style="padding: 0px 0 0 5px;"><b>Bill Date:</b></td>
									<td>'.date("d-m-Y",$bill_start_date).'</td>
									<td><b>Billing Period:</b></td>
									<td>'.$billing_period_text.'</td>
								</tr>
								<tr>
									<td style="padding: 0px 0 0 5px;"><b>Due Date:</b></td>
									<td>'.date("d-m-Y",$due_date).'</td>
									<td><b>Description:</b></td>
									<td>'.$description.'</td>
								</tr>
							</tbody></table>
							<table style="font-size:12px;border-bottom: solid 1px #767575;" width="100%" cellspacing="0">
								<tbody><tr>
									<td style="padding: 0 0 0 5px;background-color:rgb(0,141,210);color:#fff;border-top: solid 1px #767575;border-bottom: solid 1px #767575;border-right: solid 1px #FFFFFF;" align="left" width="60%"><b>Particulars of charges</b></td>
									<td style="padding: 0 5px 0 0;background-color:rgb(0,141,210);color:#fff;border-top: solid 1px #767575;border-bottom: solid 1px #767575;" align="right" width="40%"><b>Amount (Rs.)</b> </td>
								</tr>';
								
								
							foreach($income_head_array as $key=>$value){
							$result_income_head = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($key)));	
								foreach($result_income_head as $data2){
									$income_head_name = $data2['ledger_account']['ledger_name'];
								}
								if(!empty($value)){
									$bill_html.='<tr>
										<td align="left" style="border-right: solid 1px #767575;padding: 0 0 0 5px;" >'.$income_head_name.'</td>
										<td align="right" style="padding: 0 5px 0 0;">'.$value.'</td>
									</tr>';
								}
							}
							
							
							if(!empty($non_occupancy_charges)){
							$bill_html.='<tr>
										<td align="left" style="border-right: solid 1px #767575;padding: 0 0 0 5px;" >Non Occupancy charges</td>
										<td align="right" style="padding: 0 5px 0 0;">'.$non_occupancy_charges.'</td>
									</tr>';
							}
							
							foreach($other_charges_array as $key=>$vlaue){
								$result_income_head = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($key)));	
								foreach($result_income_head as $data2){
									$income_head_name = $data2['ledger_account']['ledger_name'];
								}
								
								$bill_html.='<tr>
										<td align="left" style="border-right: solid 1px #767575;padding: 0 0 0 5px;" >'.$income_head_name.'</td>
										<td align="right" style="padding: 0 5px 0 0;">'.$vlaue.'</td>
									</tr>';
							} 
							
							
							$bill_html.='</tbody></table>
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
												<td width="60%">'.$account_name.'</td>
											</tr>
											<tr>
												<td width="40%" style="padding: 0 0 0 5px;"><b>Account No.:</b></td>
												<td width="60%">'.$account_number.'</td>
											</tr>
											<tr>
												<td width="40%" style="padding: 0 0 0 5px;"><b>Bank Name:</b></td>
												<td width="60%">'.$bank_name.'</td>
											</tr>
											<tr>
												<td width="40%" style="padding: 0 0 0 5px;"><b>Branch Name:</b></td>
												<td width="60%">'.$branch.'</td>
											</tr>
											<tr>
												<td width="40%" style="padding: 0 0 0 5px;"><b>IFSC no.:</b></td>
												<td width="60%">'.$ifsc_code.'</td>
											</tr>
										</tbody></table>
									</td>
									<td width="40%" valign="top">
										<table style="font-size:12px" width="100%">
											<tbody><tr>
												<td align="right" width="70%">Total:</td>
												<td align="right" width="30%" style="padding: 0 5px 0 0;">'.$total.'</td>
											</tr>
											<tr>
												<td align="right">Interest on arrears:</td>
												<td align="right" style="padding: 0 5px 0 0;">'.$interest_on_arrears.'</td>
											</tr>
											<tr>
												<td align="right">Arrears-Principal:</td>
												<td align="right" style="padding: 0 5px 0 0;">'.$arrear_maintenance.'</td>
											</tr>
											<tr>
												<td align="right">Arrears-Interest:</td>
												<td align="right" style="padding: 0 5px 0 0;">'.$arrear_intrest.'</td>
											</tr>';
								
								$credit_stock_text=$credit_stock;
								$bill_html.='<tr>
												<td align="right" width="60%">Credit/Adjustment:</td>
												<td align="right" width="40%" style="padding: 0 5px 0 0;">'.$credit_stock_text.'</td>
											</tr>';
								$bill_html.='<tr>
												<td align="right" width="60%"><b>Due For Payment:</b></td>
												<td align="right" width="40%" style="padding: 0 5px 0 0;">'.$due_for_payment.'</td>
											</tr>
										</tbody></table>
									</td>
								</tr>
							</tbody></table>';
							
							$due_for_payment = str_replace( ',', '', $due_for_payment );
							if($due_for_payment<0){
							$write_am_word="Nil";
							}else{
							$am_in_words=ucwords(strtolower($this->convert_number_to_words($due_for_payment)));
							$write_am_word="Rupees ".$am_in_words." Only";
							}
							$bill_html.='<table style="font-size:12px" width="100%" cellspacing="0">
								<tbody><tr>
									<td width="100%" style="font-size:12px;border-bottom: solid 1px #767575;padding: 0 0 0 5px;"><b>Due For Payment (in words) :</b> '.$write_am_word.'</td>
								</tr>
							</tbody></table>';
							$bill_html.='<table style="font-size:12px;border-bottom: dotted 1px;" width="100%" cellspacing="0">
								<tbody><tr>
									<td width="50%" style="padding:5px;" valign="top">
									<span>Remarks:</span><br>';
									$inc_t_c=0;
									foreach($terms_conditions as $t_c){ $inc_t_c++;
										$bill_html.='<span>'.$inc_t_c.'. '.$t_c.'</span><br>';
									}
									
									$bill_html.='</td>
									<td align="center" width="50%" style="padding:5px;" valign="top">
									For  <b>'.$society_name.'</b><br><br><br>
									<div><span style="border-top:solid 1px #424141">'.$sig_title.'</span></div>
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
                                        <td width="20" align="right"><b></b></td>
                                        <td  width="120" style="color:#FFF !important;"> 
										<a href="mailto:support@housingmatters.in" target="_blank" style="color:#FFF !important;"><b>support@housingmatters.in</b></a>
                                        </td>
										<td align="center"></td>
                                        <td align="right" width="50"><b><img src="'.$ip.$this->webroot.'/as/hm/whatsup.png"  width="18px" /></b></td>
                                        <td width="104" style="color:#FFF !important;text-decoration: none;"><b>+91-9869157561</b></td>
										<td align="center"></td>
                                        <td width="100" style="padding-right: 10px;text-decoration: none;"> <a href="http://www.housingmatters.in" target="_blank" style="color:#FFF !important;"><b>www.housingmatters.in</b></a></td>
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
////END BILL HTML////

$current_date = date('Y-m-d');
	$other_charges_insert=$other_charges_array;	
	if(@$other_charges_insert==null){
		$other_charges_insert=array();
	}
	
	
	$this->loadmodel('new_regular_bill');
	$this->new_regular_bill->updateAll(array('edit_status'=>'YES'),array("auto_id"=>$auto_id));	
	
	$this->loadmodel('new_regular_bill');
	$new_regular_bill_auto_id=$this->autoincrement('new_regular_bill','auto_id');
	$this->new_regular_bill->saveAll(array("auto_id" => $new_regular_bill_auto_id, "flat_id" => $flat_id, "bill_no" => $bill_number, "income_head_array" => $income_head_array, "noc_charges" => $non_occupancy_charges,"total" => $total, "arrear_maintenance"=> $arrear_maintenance, "arrear_intrest" => $arrear_intrest, "intrest_on_arrears" => $interest_on_arrears,"due_for_payment" => $due_for_payment,"one_time_id"=>$one_time_id,"society_id"=>$s_society_id,"due_date"=>$due_date,"bill_start_date"=>$bill_start_date,"bill_end_date"=>$bill_end_date,"approval_status"=>1,"bill_html"=>$bill_html,"credit_stock"=>$credit_stock,"current_date"=>strtotime($current_date),"description"=>$description,"other_charges_array"=>$other_charges_array,'edit_status'=>'NO','edit_by'=>$s_user_id));
	
	
$flatt_datta = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id')
,array('pass'=>array($flat_id)));
foreach ($flatt_datta as $fltt_datttaa) 
{
$wnngg_idddd = (int)$fltt_datttaa['flat']['wing_id'];
}	
	
$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wnngg_idddd,$flat_id)));
foreach($result_user_info as $user_info){
$user_id=$user_info["user"]["user_id"];
$user_name=$user_info["user"]["user_name"];
$email=$user_info["user"]["email"];
$mobile=$user_info["user"]["mobile"];
}

	
$this->loadmodel('society');
$condition=array('society_id'=>$s_society_id);
$result_society=$this->society->find('all',array('conditions'=>$condition)); 
$this->set('result_society',$result_society);
foreach($result_society as $data_society){
	$society_name=$data_society["society"]["society_name"];
	$email_is_on_off=(int)@$data_society["society"]["account_email"];
	$sms_is_on_off=(int)@$data_society["society"]["account_sms"];
}

if($email_is_on_off==1){
					////EMAIL CODE//
					if(!empty($email)){
							$r_sms=$this->hms_sms_ip();
							$working_key=$r_sms->working_key;
							$sms_sender=$r_sms->sms_sender; 
							$sms_allow=(int)$r_sms->sms_allow;

							$subject="[".$society_name."]- Revised Maintenance e-bill, ".date('d-M',$bill_start_date)." to ".date('d-M-Y',$bill_end_date)."";
							$this->send_email($email,'accounts@housingmatters.in','HousingMatters',$subject,$bill_html,'donotreply@housingmatters.in');
					}
				}	


		//LEDGER CODE START//
		
		$this->loadmodel('ledger');
		$conditions4=array('society_id'=>$s_society_id,"table_name"=>"new_regular_bill","element_id"=>$auto_id);
		$this->ledger->deleteAll($conditions4);
		
		
			foreach($income_head_array as $income_head_id=>$income_head_amount){
				if(!empty($income_head_amount)){
					$this->loadmodel('ledger');
					$auto_id=$this->autoincrement('ledger','auto_id');
					$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => $income_head_id,"ledger_sub_account_id" => null,"debit"=>null,"credit"=>$income_head_amount,"table_name"=>"new_regular_bill","element_id"=>$new_regular_bill_auto_id,"society_id"=>$s_society_id,"transaction_date"=>$bill_start_date));
				}
			}
			
			if(!empty($non_occupancy_charges)){
				$this->loadmodel('ledger');
				$auto_id=$this->autoincrement('ledger','auto_id');
				$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 43,"ledger_sub_account_id" => null,"debit"=>null,"credit"=>$non_occupancy_charges,"table_name"=>"new_regular_bill","element_id"=>$new_regular_bill_auto_id,"society_id"=>$s_society_id,"transaction_date"=>$bill_start_date));
			}
			
			
			foreach($other_charges_insert as $key=>$vlaue){
				if(!empty($value)){
					$this->loadmodel('ledger');
					$auto_id=$this->autoincrement('ledger','auto_id');
					$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => $key,"ledger_sub_account_id" => null,"debit"=>null,"credit"=>$vlaue,"table_name"=>"new_regular_bill","element_id"=>$new_regular_bill_auto_id,"society_id"=>$s_society_id,"transaction_date"=>$bill_start_date));
				}
			} 
						
						
			if(!empty($total)){
				$this->loadmodel('ledger');
				$auto_id=$this->autoincrement('ledger','auto_id');
				$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 34,"ledger_sub_account_id" => $ledger_sub_account_id,"debit"=>$total,"credit"=>null,"table_name"=>"new_regular_bill","element_id"=>$new_regular_bill_auto_id,"society_id"=>$s_society_id,"transaction_date"=>$bill_start_date));
			}
			
			if(!empty($interest_on_arrears)){
				$this->loadmodel('ledger');
				$auto_id=$this->autoincrement('ledger','auto_id');
				$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 41,"ledger_sub_account_id" => null,"debit"=>null,"credit"=>$interest_on_arrears,"table_name"=>"new_regular_bill","element_id"=>$new_regular_bill_auto_id,"society_id"=>$s_society_id,"transaction_date"=>$bill_start_date));
				
				$this->loadmodel('ledger');
				$auto_id=$this->autoincrement('ledger','auto_id');
				$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 34,"ledger_sub_account_id" => $ledger_sub_account_id,"debit"=>$interest_on_arrears,"credit"=>null,"table_name"=>"new_regular_bill","element_id"=>$new_regular_bill_auto_id,"society_id"=>$s_society_id,"transaction_date"=>$bill_start_date,"intrest_on_arrears"=>"YES"));
			}
			
			if(!empty($credit_stock)){
				$this->loadmodel('ledger');
				$auto_id=$this->autoincrement('ledger','auto_id');
				$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 88,"ledger_sub_account_id" => null,"debit"=>abs($credit_stock),"credit"=>null,"table_name"=>"new_regular_bill","element_id"=>$new_regular_bill_auto_id,"society_id"=>$s_society_id,"transaction_date"=>$bill_start_date));
				
				$this->loadmodel('ledger');
				$auto_id=$this->autoincrement('ledger','auto_id');
				$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 34,"ledger_sub_account_id" => $ledger_sub_account_id,"debit"=>null,"credit"=>abs($credit_stock),"table_name"=>"new_regular_bill","element_id"=>$new_regular_bill_auto_id,"society_id"=>$s_society_id,"transaction_date"=>$bill_start_date));
			}	
	
		//Receipt Apply
		$this->loadmodel('new_cash_bank');
		$condition=array('society_id'=>$s_society_id,"flat_id"=>$flat_id,"bill_one_time_id"=>$one_time_id,"edit_status"=>"NO");
		$result_new_cash_bank=$this->new_cash_bank->find('all',array('conditions'=>$condition));
		foreach($result_new_cash_bank as $cash_bank){
			$amount=$cash_bank["new_cash_bank"]["amount"];
			
			
			$this->loadmodel('new_regular_bill');
			$condition=array('auto_id'=>$new_regular_bill_auto_id);
			$result_new_regular_bill=$this->new_regular_bill->find('all',array('conditions'=>$condition)); 
			foreach($result_new_regular_bill as $bill_data){
				$receipt_applied=@$bill_data["new_regular_bill"]["receipt_applied"]; 
				
				if(empty($receipt_applied)){
					$arrear_intrest=$bill_data["new_regular_bill"]["arrear_intrest"];
					$intrest_on_arrears=$bill_data["new_regular_bill"]["intrest_on_arrears"];
					$total=$bill_data["new_regular_bill"]["total"];
					$arrear_maintenance=$bill_data["new_regular_bill"]["arrear_maintenance"];
				}else{
					$arrear_intrest=$bill_data["new_regular_bill"]["new_arrear_intrest"];
					$intrest_on_arrears=$bill_data["new_regular_bill"]["new_intrest_on_arrears"];
					$total=$bill_data["new_regular_bill"]["new_total"];
					$arrear_maintenance=$bill_data["new_regular_bill"]["new_arrear_maintenance"];
				}
				
			}
			
			$amount_after_arrear_intrest=$amount-$arrear_intrest;
			if($amount_after_arrear_intrest<0)
			{
			$new_arrear_intrest=abs($amount_after_arrear_intrest);
			$new_intrest_on_arrears=$intrest_on_arrears;
			$new_arrear_maintenance=$arrear_maintenance;
			$new_total=$total;
			}
			else
			{
			$new_arrear_intrest=0;
			$amount_after_intrest_on_arrears=$amount_after_arrear_intrest-$intrest_on_arrears;
				if($amount_after_intrest_on_arrears<0)
				{
				$new_intrest_on_arrears=abs($amount_after_intrest_on_arrears);
				$new_arrear_maintenance=$arrear_maintenance;
				$new_total=$total;
				}
				else
				{
				$new_intrest_on_arrears=0;
				$amount_after_arrear_maintenance=$amount_after_intrest_on_arrears-$arrear_maintenance;
					if($amount_after_arrear_maintenance<0){
					$new_arrear_maintenance=abs($amount_after_arrear_maintenance);
					$new_total=$total;
					}else{
					$new_arrear_maintenance=0;
					$amount_after_total=$amount_after_arrear_maintenance-$total; 
					if($amount_after_total>0){
					$new_total=0;
					$new_arrear_maintenance=-$amount_after_total;
					}else{
								$new_total=abs($amount_after_total);
								
						}
					}
				}
			}
			
			$this->loadmodel('new_regular_bill');
			$this->new_regular_bill->updateAll(array('new_arrear_intrest'=>$new_arrear_intrest,"new_intrest_on_arrears"=>$new_intrest_on_arrears,"new_arrear_maintenance"=>$new_arrear_maintenance,"new_total"=>$new_total,"edit_status"=>"NO","latest_bill"=>"YES","receipt_applied"=>"YES"),array('auto_id'=>$new_regular_bill_auto_id));
		}
	
	$this->Session->write('bill_update_status', 1);
	$this->response->header('Location', $this->webroot.'Incometrackers/in_head_report');
	}
}

function print_all_bill($last_one_time_id=null){
	$this->layout='session';
	
	$this->ath();
	
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');

	$last_one_time_id=(int)$last_one_time_id; 
	
	$this->loadmodel('new_regular_bill');
	$conditions=array("one_time_id"=>$last_one_time_id,'society_id'=>$s_society_id,'new_regular_bill.edit_status'=>array('$ne'=>"YES"));
	$result_new_regular_bill=$this->new_regular_bill->find('all',array('conditions'=>$conditions));
	$this->set('result_new_regular_bill',$result_new_regular_bill);
	
	$this->loadmodel('society');
	$conditions=array("society_id" => $s_society_id);
	$result_society=$this->society->find('all',array('conditions'=>$conditions));
	$this->set('result_society',$result_society);
	
	
$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);
	
	
}
////////////////////////////////// End Regular Bill View (Accounts)//////////////////////////////////////////

/////////////////////// Start Rate Card View2 (Accounts)/////////////////////////////

function rate_card_view2()
{
$this->layout='session';
$this->ath();


$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

//$ihe = $this->request->query('ii');
$show_arr = $this->request->query('arr');
$this->set('show_arr',$show_arr);
//$this->set('ihe',$ihe);


if(isset($this->request->data['sub']))
{
//$ih_head = explode(',',$ihe);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$income_head_arr = $collection['society']['income_head'];
}

$this->loadmodel('flat_type');
$conditions=array("society_id" => $s_society_id);
$cursor = $this->flat_type->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$auto_id1 = $collection['flat_type']['auto_id'];
$rate_arr = array();
for($r=0; $r<sizeof($income_head_arr); $r++)
{
$auto_id2 = (int)$income_head_arr[$r];

$charge_type_id = (int)$this->request->data['tp'.$auto_id1.$auto_id2];
$charge = (int)$this->request->data['chg'.$auto_id1.$auto_id2];

$arr = array($auto_id2,$charge_type_id,$charge);
$rate_arr[] = $arr;
}

$this->loadmodel('flat_type');
$this->flat_type->updateAll(array('charge' => $rate_arr),array('auto_id' => $auto_id1));
}
$this->response->header('Location','master_rate_card_view');
}

$this->loadmodel('society');
$conditions=array("society_id"=>$s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
}
$this->set('s_name',$society_name);

$this->loadmodel('flat_type');
$condition=array('society_id'=>$s_society_id);
$result2=$this->flat_type->find('all',array('conditions'=>$condition)); 
$this->set('cursor2',$result2);


$this->loadmodel('income_head');
$order=array('income_head.auto_id'=>'ASC');
$conditions=array("society_id" => $s_society_id,"delete_id"=>0);
$cursor3 = $this->income_head->find('all',array('conditions'=>$conditions,'order' => $order));
$this->set('cursor3',$cursor3);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor4 = $this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor4',$cursor4);



}

/////////////////////// End Rate Card View2 (Accounts)/////////////////////////////

/////////////////////////// Start Nov View2 ///////////////////////////////////////////////////////////
function noc_view2()
{
$this->layout="session";
$this->ath();

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
$this->response->header('Location', 'master_noc');
}

$this->loadmodel('flat_type');
$order=array('flat_type.auto_id'=>'ASC');
$condition=array('society_id'=>$s_society_id);
$cursor1 = $this->flat_type->find('all',array('conditions'=>$condition,'order' => $order)); 
$this->set('cursor1',$cursor1);
}
/////////////////////////// End Nov View2 ///////////////////////////////////////////////////////////

//////////////////////////////Start Supplimentry Bill show/////////////////////////////////////////
function supplimentry_view($auto_id=null)
{
$this->layout='session';
$this->ath();

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$auto_id = (int)$auto_id;

$this->loadmodel('adhoc_bill');
$conditions=array("adhoc_bill_id"=>$auto_id,"society_id" => $s_society_id);
$cursor=$this->adhoc_bill->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$bill_html = $collection['adhoc_bill']['html_bill'];	
}

$this->set('bill_html',$bill_html);
}
//////////////////////////////End Supplimentry Bill show/////////////////////////////////////////

//////////////////////////////// Start Noc Json ////////////////////////////////////////////////////////////////////
function noc_json()
{
$this->layout='blank';
$this->ath();

$q=$this->request->query('q');
$q = html_entity_decode($q);
$typ = $this->request->query('b');
$typ2 = json_decode($typ, true);

$s_society_id = (int)$this->Session->read('society_id');
$s_user_id  = (int)$this->Session->read('user_id');

$myArray = json_decode($q, true);

if($typ2 == 1)
{
foreach($myArray as $child)
{

if($child[0]!=5){
	if(empty($child[0])){
	$output = json_encode(array('type'=>'error', 'text' => 'Please Fill All Fields'));
	die($output);
	}
}	
$child1=(int)$child[1];
if($child[0] != 4)
{
	if($child[0]!=5){
		if(empty($child1) && $child1 != 0)
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Please Fill All Fields'));
		die($output);
		}
	}

if(is_numeric($child1))
{
}	
else
{
$output = json_encode(array('type'=>'error', 'text' => 'Please Fill Numeric value'));
die($output);
}
}

}

$output = json_encode(array('type'=>'succ', 'text' => 'Are You Sure'));
die($output);

}
if($typ2 == 2)
{
foreach($myArray as $child)
{
$ch_type = (int)$child[0];
if($ch_type != 4)
{
$amt = $child[1];
$fltp = (int)$child[2];
$arr = array($ch_type,$amt);
}
else
{
//$per = (int)$child[1];
$fltp = (int)$child[2];
$in_head = $child[3];
$arr = array($ch_type,10,$in_head);
}


$this->loadmodel('flat_type');
$this->flat_type->updateAll(array('noc_charge' => $arr),array('auto_id' => $fltp));
}
$output = json_encode(array('type'=>'okk', 'text' => 'Are You Sure'));
die($output);

}
}
//////////////////////////////// End Noc Json ////////////////////////////////////////////////////////////////////

////////////////////////////////////// Start Rate Card Json //////////////////////////////////////////////////////////
function rate_card_json()
{
$this->layout='blank';
$this->ath();

$q=$this->request->query('q');
$q = html_entity_decode($q);
$typ = $this->request->query('b');
$typ2 = json_decode($typ, true);

$s_society_id = (int)$this->Session->read('society_id');
$s_user_id  = (int)$this->Session->read('user_id');

$myArray = json_decode($q, true);

if($typ2 == 1)
{

$output = json_encode(array('type'=>'succ', 'text' => 'Are You Sure'));
die($output);
}
if($typ2 == 2)
{
$c=0;
foreach($myArray as $child)
{
$c++;
$type = (int)$child[0];
$amt = $child[1];
$flat_type_id = (int)$child[2];
$income_head = (int)$child[3];
$mm = (int)$child[4];
$arr = array($income_head,$type,$amt);
$arrr[] = $arr;
if($c == $mm)
{
$this->loadmodel('flat_type');
$this->flat_type->updateAll(array('charge' => $arrr),array('auto_id' => $flat_type_id));
$arrr = array();
$c=0;
}
}
$output = json_encode(array('type'=>'okk', 'text' => 'Are You Sure'));
die($output);
}
}
////////////////////////////////////// End Rate Card Json //////////////////////////////////////////////////////////

/////////////////////////////////////// Start Select Income Head Json //////////////////////////////////////////////////
function select_income_head_json()
{
$this->layout=null;

$post_data=$this->request->data;
$this->ath();
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$date=date('d-m-Y');
$time = date(' h:i a', time());

$arrr = $post_data['head'];
$type = (int)$post_data['type'];	
$ar = explode(",",$arrr);



if($type == 1)
{
$report = array();
if($arrr == 'null')
{
$report[]=array('label'=>'head', 'text' => 'Please select Income Heads');
}	

if(sizeof($report)>0)
{
$output=json_encode(array('report_type'=>'error','report'=>$report));
die($output);
}

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{

$arrr1 = $collection['society']['income_head'];
}
for($j=0; $j<sizeof($ar); $j++)
{
$head_id = (int)$ar[$j];
$arrr1[] = $head_id;
}

$this->loadmodel('society');
$this->society->updateAll(array('income_head'=> $arrr1),array('society_id'=>$s_society_id));

$output=json_encode(array('report_type'=>'publish','report'=>'Income Head Inserted Successfully'));
die($output);
}


}
/////////////////////////////////////// Start Select Income Head Json //////////////////////////////////////////////////
/////////////////////////////////// Start delete_select_income ////////////////////////////////////////////////////////
function delete_select_income()
{
$this->layout='blank';
$this->ath();

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$inid = (int)$this->request->query('con');

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$arr = $collection['society']['income_head'];
}
for($k=0; $k<sizeof($arr); $k++)
{
$incid = (int)$arr[$k];
if($incid != $inid)
{
$arrr[] = $incid;
}
}
$this->loadmodel('society');
$this->society->updateAll(array('income_head'=> @$arrr),array('society_id'=>$s_society_id));

$this->loadmodel('flat_type');
$conditions=array("society_id" => $s_society_id);
$cursor=$this->flat_type->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection2)
{
$auto_id = (int)$collection2['flat_type']['auto_id'];
$charge3 = array();
$charge = @$collection2['flat_type']['charge'];
foreach($charge as $charge2)
{
$in1 = $charge2[0];
if($in1 != $inid)
{
$charge3[] = $charge2;
}
}
$this->loadmodel('flat_type');
$this->flat_type->updateAll(array('charge'=> @$charge3),array('society_id'=>$s_society_id,"auto_id"=>$auto_id));
}


$this->redirect(array('controller' => 'Incometrackers','action' => 'select_income_heads'));
}
/////////////////////////////////// End delete_select_income ////////////////////////////////////////////////////////
//////////////////////// Start Account Statement (Accounts)//////////////////////////////
function account_statement(){
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}

	$this->ath();
	$this->check_user_privilages();

	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');	

	$this->loadmodel('ledger_sub_account');
	$conditions=array("society_id" => $s_society_id, "ledger_id" => 34);
	$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
	$this->set('result_ledger_sub_account',$result_ledger_sub_account);
}

function account_statement_for_flat_ajax($flat_id,$from,$to){
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	
	$this->ath();
	$this->set("flat_id",$flat_id);
	
	$from=date("Y-m-d",strtotime($from));
	$this->set("from",$from);
	$to=date("Y-m-d",strtotime($to));
	$this->set("to",$to);
	$flat_id = (int)$flat_id;
	/*$this->loadmodel('ledger_sub_account');
	$conditions=array("auto_id" => (int)$ledger_sub_account_id);
	$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
	foreach($result_ledger_sub_account as $ledger_sub_account_data){
		$name=$ledger_sub_account_data["ledger_sub_account"]["name"];
		$this->set("name",$name);
		$flat_id=$ledger_sub_account_data["ledger_sub_account"]["flat_id"];
		$this->set("flat_id",$flat_id); 
	}
	*/
	
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');	
	/*
	$this->loadmodel('ledger');
	$conditions=array("society_id" => $s_society_id, "ledger_sub_account_id" => (int)$ledger_sub_account_id,'transaction_date'=> array('$gte' => strtotime($from),'$lte' => strtotime($to)));
	$order=array('ledger.transaction_date'=>'ASC');
	$result_ledger_sub_account=$this->ledger->find('all',array('conditions'=>$conditions));
	$this->set('result_ledger_sub_account',$result_ledger_sub_account);
	
	$this->loadmodel('society');
	$conditions=array("society_id" => $s_society_id);
	$result_society=$this->society->find('all',array('conditions'=>$conditions));
	$this->set('result_society',$result_society);
	
$this->loadmodel('adhoc_bill');
$conditions=array("society_id" => $s_society_id, "residential"=>"y","person_name"=>$ledger_sub_account_id,
'bill_daterange_from'=> array('$gte' => strtotime($from),'$lte' => strtotime($to)));
$order=array('adhoc_bill.bill_daterange_from'=>'ASC');
$adhoc_detaill=$this->ledger->find('all',array('conditions'=>$conditions));
$this->set('adhoc_detaill',$adhoc_detaill);
*/


$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array((int)$flat_id)));
		foreach($result_flat_info as $flat_info){
		$wing_id=$flat_info["flat"]["wing_id"];
		} 
		
	$wing_flat=$this->requestAction(array('controller' => 'Bookkeepings', 'action' => 'wing_flat'), array('pass' => array($wing_id,(int)$flat_id)));
	$this->set('wing_flat',$wing_flat);
		
		//user info via flat_id//
		$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wing_id,$flat_id)));
		foreach($result_user_info as $user_info){
			$user_id=(int)$user_info["user"]["user_id"];
			$user_name=$user_info["user"]["user_name"];
			$this->set('user_name',$user_name);
		}



$this->loadmodel('society');
	$conditions=array("society_id" => $s_society_id);
	$result_society=$this->society->find('all',array('conditions'=>$conditions));
	$this->set('result_society',$result_society);
	
	$this->loadmodel('ledger_sub_account');
	$conditions=array("society_id" => $s_society_id,"flat_id" => (int)$flat_id);
	$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
	$ledger_sub_account_id=@$result_ledger_sub_account[0]["ledger_sub_account"]["auto_id"];
	
	
	
	$this->loadmodel('ledger');
	$conditions=array("society_id" => $s_society_id,"ledger_account_id" => 34,"ledger_sub_account_id" => (int)$ledger_sub_account_id,'transaction_date'=> array('$gte' => strtotime($from),'$lte' => strtotime($to)));
	$order=array('ledger.transaction_date'=>'ASC');
	$result_ledger=$this->ledger->find('all',array('conditions'=>$conditions,'order'=>$order));
	$this->set('result_ledger',$result_ledger);







	
}

function account_statement_for_flat_excel($flat_id,$from,$to){
	$this->layout=null;
	
	
	$filename="Account_statement";
	header ("Expires: 0");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/vnd.ms-excel");
	header ("Content-Disposition: attachment; filename=".$filename.".xls");
	header ("Content-Description: Generated Report" );
	
	
	
	
	$from=date("Y-m-d",strtotime($from));
	$this->set("from",$from);
	$to=date("Y-m-d",strtotime($to));
	$this->set("to",$to);
	
	
	$flat_id = (int)$flat_id;
	$this->ath();
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');	
	$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array((int)$flat_id)));
		foreach($result_flat_info as $flat_info){
		$wing_id=$flat_info["flat"]["wing_id"];
		} 
		
	$wing_flat=$this->requestAction(array('controller' => 'Bookkeepings', 'action' => 'wing_flat'), array('pass' => array($wing_id,(int)$flat_id)));
	$this->set('wing_flat',$wing_flat);
		
		//user info via flat_id//
		$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wing_id,$flat_id)));
		foreach($result_user_info as $user_info){
			$user_id=(int)$user_info["user"]["user_id"];
			$user_name=$user_info["user"]["user_name"];
			$this->set('user_name',$user_name);
		}



$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$result_society=$this->society->find('all',array('conditions'=>$conditions));
$this->set('result_society',$result_society);
	
$this->loadmodel('ledger_sub_account');
$conditions=array("society_id" => $s_society_id,"flat_id" => (int)$flat_id);
$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$ledger_sub_account_id=@$result_ledger_sub_account[0]["ledger_sub_account"]["auto_id"];

	
$this->loadmodel('ledger');
$conditions=array("society_id" => $s_society_id,"ledger_account_id" => 34,"ledger_sub_account_id" => (int)$ledger_sub_account_id,'transaction_date'=> array('$gte' => strtotime($from),'$lte' => strtotime($to)));
$order=array('ledger.transaction_date'=>'ASC');
$result_ledger=$this->ledger->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('result_ledger',$result_ledger);


}
////////////////End Account Statement (Accounts)/////////////////////////////////////

//////////////// Start ac statement Bill View////////////////////////////////////////
/////////// Done////////////////////////////
function ac_statement_bill_view($receipt_id=null)
{
$this->layout='blank';

$this->ath();

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->seen_notification(10,$receipt_id);

//$receipt_id = (int)$this->request->query('bill');
$receipt_id = (int)$receipt_id; 
$this->loadmodel('regular_bill');
$conditions=array("receipt_id"=>$receipt_id,"society_id" => $s_society_id);
$cursor=$this->regular_bill->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$bill_html = $collection['regular_bill']['bill_html'];	
}
$this->set('bill_html',@$bill_html);

}
//////////////// End ac statement Bill View////////////////////////////////////////

///////////////////// Start account statement show ajax(Accounts)////////////////////
///////Done////////////
function account_statement_show_ajax()
{
$this->layout='blank';

$this->ath();

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
}
$this->set('society_name',$society_name);


$from = $this->request->query('f');
$to = $this->request->query('t');
$value = (int)$this->request->query('ff');
$this->set('value',$value);
$this->set('from',$from);
$this->set('to',$to);

$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array((int)$value)));
		foreach($result_flat_info as $flat_info){
		$wing_id=$flat_info["flat"]["wing_id"];
		} 
		
	$wing_flat=$this->requestAction(array('controller' => 'Bookkeepings', 'action' => 'wing_flat'), array('pass' => array($wing_id,(int)$value)));
	$this->set('wing_flat',$wing_flat);
		
		//user info via flat_id//
		$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wing_id,$value)));
		foreach($result_user_info as $user_info){
			$user_id=(int)$user_info["user"]["user_id"];
			$user_name=$user_info["user"]["user_name"];
			$this->set('user_name',$user_name);
		} 

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$result_society=$this->society->find('all',array('conditions'=>$conditions));
$this->set('result_society',$result_society);

$this->loadmodel('ledger_sub_account');
$conditions=array("society_id" => $s_society_id,"flat_id" => (int)$value);
$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$ledger_sub_account_id=@$result_ledger_sub_account[0]["ledger_sub_account"]["auto_id"];

$this->loadmodel('ledger');
$conditions=array("society_id" => $s_society_id,"ledger_account_id" => 34,"ledger_sub_account_id" => $ledger_sub_account_id,'transaction_date'=> array('$gte' => strtotime($from),'$lte' => strtotime($to)));
$order=array('ledger.transaction_date'=>'ASC');
$result_ledger=$this->ledger->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('result_ledger',$result_ledger);














}
////////////////// End account statement show ajax(Accounts)////////////////////////

/////////////////////// Start Account Statement Excel////////////////////////////////
function account_statement_excel()
{
$this->layout="";
$this->ath();

$s_society_id = (int)$this->Session->read('society_id');
$s_role_id=$this->Session->read('role_id');

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach ($cursor as $collection) 
{
$society_name = $collection['society']['society_name'];
}
$this->set('society_name',$society_name);
$socc_namm = str_replace(' ', '_', $society_name);
$this->set('socc_namm',$socc_namm);

$from = $this->request->query('f');
$to = $this->request->query('t');
$user_id = (int)$this->request->query('u');
$fdddd = date('d-M-Y',strtotime($from));
$tdddd = date('d-M-Y',strtotime($to));

$this->set('fdddd',$fdddd);
$this->set('tdddd',$tdddd);

$this->set('from',$from);
$this->set('to',$to);
$this->set('value',$user_id);

}
/////////////////////// End Account Statement Excel/////////////////////////////////////////////////////////////

///////////////////////// Start Delete Terms ///////////////////////////////////////////////////////////////////
function delete_terms()
{
$this->layout='blank';
$this->ath();


$s_society_id = (int)$this->Session->read('society_id');

$delete = (int)$this->request->query('delete');
$t_id = (int)$this->request->query('t_id');
$this->set('delete',$delete);
if($delete == 0)
{
$this->set('t_id',$t_id);
}
if($delete == 1)
{
$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach ($cursor as $collection) 
{
$terms_arr = @$collection['society']['terms_conditions'];
}
$k=0;
$terms_arr2 = array();
for($h=0; $h<sizeof($terms_arr); $h++)
{
$k++;
$terms_name = $terms_arr[$h];
if($k != $t_id)
{
$terms_arr2[] = $terms_name;
} 
}
$this->loadmodel('society');
$this->society->updateAll(array('terms_conditions'=>$terms_arr2),array("society_id" => $s_society_id));
}
}
//////////////////////////// End Delete Terms ///////////////////////////////////////////////////////////////

//////////////////////// Start Edit Terms ////////////////////////////////////////////////////
function edit_terms()
{
$this->layout='blank';
$this->ath();

$s_society_id = (int)$this->Session->read('society_id');
$t_id = (int)$this->request->query('t_id');
$edit = (int)$this->request->query('edit');
$this->set('edit',$edit);

if($edit == 0)
{
$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor1 = $this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);
$this->set('t_id',$t_id);
}
if($edit == 1)
{
$tems_name = $this->request->query('tem');

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$terms_arr = $collection['society']['terms_conditions'];
}
$hh = $t_id-1;
$terms_arr[$hh] = $tems_name;

$this->loadmodel('society');
$this->society->updateAll(array('terms_conditions'=>$terms_arr),array("society_id" => $s_society_id));
}
}
//////////////////////// End Edit Terms ////////////////////////////////////////////////////////////////

///////////////////////////////// Start Approve Bill //////////////////////////////////////
function aprrove_bill(){
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}


$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$s_role_id=$this->Session->read('role_id');

$s_society_id = (int)$this->Session->read('society_id');
$this->ath();
$this->check_user_privilages();

$this->loadmodel('society');
$condition=array('society_id'=>$s_society_id);
$result_society=$this->society->find('all',array('conditions'=>$condition)); 
$this->set('result_society',$result_society);
foreach($result_society as $data_society){
	$society_name=$data_society["society"]["society_name"];
	$email_is_on_off=(int)@$data_society["society"]["account_email"];
	$sms_is_on_off=(int)@$data_society["society"]["account_sms"];
}

$this->loadmodel('new_regular_bill');
$condition=array('society_id'=>$s_society_id,"approval_status"=>0);
$order=array('new_regular_bill.one_time_id'=> 'DESC');
$result_new_regular_bill_period=$this->new_regular_bill->find('all',array('conditions'=>$condition,'order'=>$order,'limit'=>1)); 

//$this->set('result_new_regular_bill_period',$result_new_regular_bill_period);
if(sizeof($result_new_regular_bill_period)>0){
 $bill_start_d=$result_new_regular_bill_period[0]['new_regular_bill']['bill_start_date'];
 $bill_end_date=$result_new_regular_bill_period[0]['new_regular_bill']['bill_end_date'];
 $this->set('bill_start_d',$bill_start_d=date('d-m-Y',$bill_start_d));
 $this->set('bill_end_date',$bill_end_date=date('d-m-Y',$bill_end_date));
}


$this->loadmodel('new_regular_bill');
$condition=array('society_id'=>$s_society_id,"approval_status"=>0);
$order=array('new_regular_bill.one_time_id'=> 'ASC');
$result_new_regular_bill=$this->new_regular_bill->find('all',array('conditions'=>$condition)); 
$this->set('result_new_regular_bill',$result_new_regular_bill);
foreach($result_new_regular_bill as $regular_bill){
		$other_charges_array=@$regular_bill["new_regular_bill"]["other_charges_array"];
		if(!empty($other_charges_array)){
			foreach($other_charges_array as $key=>$value){
				$other_charges_ids[]=$key;
			}
		}
	}
	if(sizeof(@$other_charges_ids)>0){
	$other_charges_ids=array_unique($other_charges_ids);
	$this->set('other_charges_ids',$other_charges_ids);
	}

if(isset($this->request->data['approve'])){
	$date = date('d-m-Y');
	if(sizeof($result_new_regular_bill)>0){
		foreach($result_new_regular_bill as $data5){
			$auto_id=$data5["new_regular_bill"]["auto_id"];
			$chk_value = (int)@$this->request->data['check'.$auto_id];
			if($chk_value==1){
				$this->loadmodel('new_regular_bill');
				$this->new_regular_bill->updateAll(array('approval_status'=>1,"approved_by"=>$s_user_id,"approved_date"=>$date),array('auto_id'=>$auto_id));
				
				//fetch bill info via auto_id//
				$this->loadmodel('new_regular_bill');
				$condition=array('auto_id'=>$auto_id);
				$result_bill_info=$this->new_regular_bill->find('all',array('conditions'=>$condition));
				$new_regular_bill_auto_id=$result_bill_info[0]["new_regular_bill"]["auto_id"];
				$flat_id=$result_bill_info[0]["new_regular_bill"]["flat_id"];
				$bill_start_date=$result_bill_info[0]["new_regular_bill"]["bill_start_date"];
				$bill_end_date=$result_bill_info[0]["new_regular_bill"]["bill_end_date"];
				$bill_html=$result_bill_info[0]["new_regular_bill"]["bill_html"];
				$due_for_payment=$result_bill_info[0]["new_regular_bill"]["due_for_payment"];
				$due_date=$result_bill_info[0]["new_regular_bill"]["due_date"];
				
				
				//wing_id via flat_id//
				$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
				foreach($result_flat_info as $flat_info){
					$wing_id=$flat_info["flat"]["wing_id"];
				} 
				
				
				$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wing_id,$flat_id)));
				foreach($result_user_info as $user_info){
					 $user_id=$user_info["user"]["user_id"];
					$user_name=$user_info["user"]["user_name"];
					$email=$user_info["user"]["email"];
					$mobile=$user_info["user"]["mobile"];
				}
				//wing_id via flat_id//
				$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
				foreach($result_flat_info as $flat_info){
					$wing_id=$flat_info["flat"]["wing_id"];
				}
				
				$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing_id,$flat_id))); 
				
				
				//SEND NOTIFICATION//
				$users[]=$user_id;
				$this->send_notification('<span style="color:#E35B5A"><i class="fa fa-file-text fa-lg" ></i></span>','New Maintanance Bill',10,$new_regular_bill_auto_id,'regular_bill_view/'.$new_regular_bill_auto_id,$s_user_id,$users);
				unset($users);
				
			
				if($email_is_on_off==1){
					////EMAIL CODE//
					if(!empty($email)){
							$r_sms=$this->hms_sms_ip();
							$working_key=$r_sms->working_key;
							$sms_sender=$r_sms->sms_sender; 
							$sms_allow=(int)$r_sms->sms_allow;

							$subject="[".$society_name."]- Maintenance e-bill, ".date('d-M',$bill_start_date)." to ".date('d-M-Y',$bill_end_date)."";
							$this->send_email($email,'accounts@housingmatters.in','HousingMatters',$subject,$bill_html,'donotreply@housingmatters.in');
					}
				}
				
				if($sms_is_on_off==1){
					////SMS CODE//
					if(!empty($mobile)){
							//$sms="Dear ".$user_name." ".$wing_flat.",your maintenance bill for period ".date('d-M',$bill_start_date)." to ".date('d-M-Y',$bill_end_date)." is Rs ".$due_for_payment.".Kindly pay by ".date('d-M',$due_date).".".$society_name;
							//echo $user_name; echo'<br/>';
							
							 $user_name=$this->check_charecter_name($user_name);				
							
							 $sms="Dear ".$user_name." ".$wing_flat.",your maintenance bill of Rs ".$due_for_payment." for ".date('d-M',$bill_start_date)." to ".date('d-M-Y',$bill_end_date)." is sent via email,kindly check %26 pay by ".date('d-M',$due_date).".".$society_name;
							
							
							
							
							
							
							
							$sms1=str_replace(' ', '+', $sms);
							if($sms_allow==1){
							$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms1.''); 
							}
					}
				}
			}
			
		} 
	}
	$role_security=$this->role_security_dashboard_sub($s_society_id,$s_role_id,10,30);
		if(sizeof($role_security)>0){
			$this->response->header('Location','in_head_report');
		}else{
			$this->response->header('Location','aprrove_bill');
		}
		
}

}
//////////////////////////////////// End Approve Bill /////////////////////////////////////////////////////////////////
////////////////////////////////////////// Start NEFT Add //////////////////////////////////////////////////////////////
function neft_add()
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
		
		
$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor1 = $this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);


$this->loadmodel('new_regular_bill');
$order=array('new_regular_bill.auto_id'=> 'ASC');
$conditions=array("society_id" => $s_society_id);
$cursor=$this->new_regular_bill->find('all',array('conditions'=>$conditions,'order' =>$order));
foreach ($cursor as $collection) 
{
$d_from = $collection['new_regular_bill']['bill_start_date'];
$d_to = $collection['new_regular_bill']['bill_end_date'];
}

/*
$this->loadmodel('ledger');
$conditions=array('ledger.receipt_id'=> array('$ne' => 'O_B'));
$this->ledger->deleteAll($conditions);
*/
/*
$this->loadmodel('cash_bank');
$conditions=array("society_id" => $s_society_id,"module_id"=>1);
$cursor = $this->cash_bank->find('all',array('conditions'=>$conditions));
foreach($cursor as $data)
{
$amount = (int)$data['cash_bank']['amount'];
$received_from = $data['cash_bank']['user_id'];
$sub_account_id = $data['cash_bank']['account_head'];
$bill_no = (int)$data['cash_bank']['bill_reference'];
$current_date = $data['cash_bank']['current_date'];
$i = (int)$data['cash_bank']['receipt_id'];
//////////////////////////////////////////
$this->loadmodel('ledger');
$order=array('ledger.auto_id'=> 'DESC');
$cursor=$this->ledger->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last23=$collection['ledger']['auto_id'];
}
if(empty($last23))
{
$k=0;
}	
else
{	
$k=$last23;
}
$k++; 
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $i, 
"amount" => $amount, "amount_category_id" => 2, "module_id" => 1, "account_type" => 1,  "account_id" => $received_from, 
"current_date" => $current_date, "society_id" => $s_society_id,"table_name"=>"cash_bank","module_name"=>"Bank Receipt"));
$this->ledger->saveAll($multipleRowData); 


$sub_account_id_a = (int)$sub_account_id;
$this->loadmodel('ledger');
$order=array('ledger.auto_id'=> 'DESC');
$cursor=$this->ledger->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last24=$collection['ledger']['auto_id'];
}
if(empty($last24))
{
$k=0;
}	
else
{	
$k=$last24;
}
$k++; 
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $i, 
"amount" => $amount, "amount_category_id" => 1, "module_id" => 1, "account_type" => 1, "account_id" => $sub_account_id_a,
"current_date" => $current_date, "society_id" => $s_society_id,"table_name"=>"cash_bank","module_name"=>"Bank Receipt"));
$this->ledger->saveAll($multipleRowData);

//////////////////////////////////////

$this->loadmodel('regular_bill');
$conditions=array("receipt_id" => $bill_no,"society_id"=>$s_society_id);
$cursor=$this->regular_bill->find('all',array('conditions'=>$conditions));
foreach ($cursor as $collection) 
{
$remain_amt = $collection['regular_bill']['remaining_amount'];
$arrears_amt = (int)$collection['regular_bill']['arrears_amt'];
$arrears_int = $collection['regular_bill']['accumulated_tax'];
$total_due_amt = $collection['regular_bill']['total_due_amount'];
}
$due_amt = $remain_amt - $amount;
$total_due_amt = $total_due_amt - $amount;
if($arrears_int <= $amount)
{
$amount = $amount-$arrears_int;
$arrears_int = 0;
}
else
{
$arrears_int = $arrears_int -$amount;
$amount = 0;
}

if($amount >= $arrears_amt)
{
$arrears_amt = (int)$arrears_amt - $amount;
}
else
{
$arrears_amt = (int)$arrears_amt - $amount;
}

$this->loadmodel('regular_bill');
$this->regular_bill->updateAll(array("remaining_amount" => $due_amt,"arrears_amt"=>$arrears_amt,"accumulated_tax"=>$arrears_int,"total_due_amount"=>$total_due_amt),array("receipt_id" => $bill_no));
}
*/


if(isset($this->request->data['sub']))
{
$ac_name = $this->request->data['acno'];
$bank_name = $this->request->data['bank_name'];
$branch = $this->request->data['branch'];
$ifsc_code = $this->request->data['ifsc'];
$ac_number = $this->request->data['acnu'];
$neft_for = $this->request->data['neft_for'];
if($neft_for == "WW")
{
$wing_id = $this->request->data['select_wing'];
$this->loadmodel('society');
$conditions=array("society_id"=>$s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach ($cursor as $data) 
{
$neft = @$data['society']['neft_detail'];
$type = @$data['society']['neft_type'];
}
if($type == "ALL")
{
$neft ="";
$this->loadmodel('society');
$this->society->updateAll(array("neft_detail" => "","neft_type" => ""),array("society_id" => $s_society_id));
}

$sub_neft['account_name']=$ac_name;
$sub_neft['bank_name']=$bank_name;
$sub_neft['account_number']=$ac_number;
$sub_neft['branch']=$branch;
$sub_neft['ifsc_code']=$ifsc_code;

$neft[$wing_id] = $sub_neft;
}
else
{
$neft['account_name']=$ac_name;
$neft['bank_name']=$bank_name;
$neft['account_number']=$ac_number;
$neft['branch']=$branch;
$neft['ifsc_code']=$ifsc_code;
}


$this->loadmodel('society');
$this->society->updateAll(array("neft_detail" => $neft,"neft_type"=>$neft_for),array("society_id" => $s_society_id));
?>
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
<p>The NEFT Detail Updated Successfully</p>
</div>
<div class="modal-footer">
<a href="neft_add" class="btn red">OK</a>
</div>
</div>

<?php
}
$this->loadmodel('wing');
$conditions=array("society_id" => $s_society_id);
$cursor5 = $this->wing->find('all',array('conditions'=>$conditions));
$this->set('cursor5',$cursor5);

/*
$aaa = "Deposits (Asset)";
echo $aaa = htmlentities($aaa);
$ttt = 55;
$this->loadmodel('ledger_account'); 
$conditions=array("ledger_name"=> $aaa );
$group_detail=$this->ledger_account->find('all',array('conditions'=>$conditions));
foreach($group_detail as $group_data)
{
$ttt = 5555;
}
echo $ttt;
$this->set('ttt',$ttt);
*/
}
////////////////////////////////////////// End NEFT Add //////////////////////////////////////////////////////////////
/////////////////////////////// Start regular_bill_edit ////////////////////////////////////////////////////////////////
function regular_bill_edit()
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


$this->loadmodel('society');
$conditions=array("society_id"=>$s_society_id);
$cursor1 = $this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

}
///////////////////////////////// End regular_bill_edit ///////////////////////////////////////////////////////////////
/////////////////////////////////////// Start Bill bill_reminder ////////////////////////////////////////////////
function bill_reminder()
{
$this->layout='session';
$this->ath();

$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');

$this->loadmodel('user');
$order=array('user.user_id'=> 'ASC');
$conditions=array("society_id" => $s_society_id, "tenant" => 1,"deactive"=>0);
$cursor1 = $this->user->find('all',array('conditions'=>$conditions,'order'=>$order));
foreach($cursor1 as $data)
{
//$mobile = $data['user']['mobile'];	
//$email = $data['user']['email'];

//$mobile = "9799463210";

$r_sms=$this->hms_sms_ip();
$working_key=$r_sms->working_key;
$sms_sender=$r_sms->sms_sender; 
$sms_allow=(int)$r_sms->sms_allow;
if($sms_allow==1){
$sms='Dear '.$user_name.' '.$wing_flat.', your maintenance bill for period '.$sms_from.'-'.$sms_to.' is Rs '.$grand_total.'.Kindly pay by due '.$sms_due.'.'.$society_name.'';
$sms1=str_replace(' ', '+', $sms);
$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms1.''); 
}


$from_mail_date = date('d M',strtotime($from));
$to_mail_date = date('d M Y',strtotime($to));

//$email = "nikhileshvyas@yahoo.com";
$subject = ''.$society_name.' : Maintenance bill, '.$from_mail_date.' to '.$to_mail_date.'';
$from_name="HousingMatters";
//$message_web = "Receipt No. :".$d_receipt_id;
$from = "accounts@housingmatters.in";
$reply="accounts@housingmatters.in";
$this->send_email($email,$from,$from_name,$subject,$html,$reply);

}
}
/////////////////////////////////////// Start Bill bill_reminder ////////////////////////////////////////////////
function test_page(){
	$this->layout='session';
	$this->ath();
	
	
}
/////////////////////////////////////// Start NEFT Show Ajax ///////////////////////////////////////////////////
function neft_show_ajax()
{
$this->layout='blank';
$this->ath();

$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');

$wing_id =(int)$this->request->query('val');
$this->set('wing_id',$wing_id);

$this->loadmodel('society');
$conditions=array("society_id"=>$s_society_id);
$cursor1 = $this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);
}
/////////////////////////////////////// End NEFT Show Ajax ///////////////////////////////////////////////////
////////////////////////////////////Start Supplimentry Bill Json /////////////////////////////////////////////
function supplimentry_bill_json()
{
        $this->layout='blank';
		$s_society_id = (int)$this->Session->read('society_id');
		$s_user_id = (int)$this->Session->read('user_id');

          $this->ath();	
		
		$q=$this->request->query('q'); 
		$q = html_entity_decode($q);
		$myArray = json_decode($q, true);
		
		
		foreach($myArray as $child)
		{
		

			if(empty($child[0]))
			{
			$output = json_encode(array('type'=>'error', 'text' => 'Please Select Billing Date'));
			die($output);
			}	
	
	       $dattt = $child[0];
		   $dddatttt = date('Y-m-d',strtotime($dattt));
		   $dddatttt = strtotime($dddatttt);
		   
	        $this->loadmodel('financial_year');
			$conditions=array("society_id"=>$s_society_id,"status"=>1);
			$cursor=$this->financial_year->find('all',array('conditions'=>$conditions));
			if(sizeof($cursor) == 0)
			{
			$nnnnn = 555;	
			}
			foreach($cursor as $dataaa)
			{
				$fin_from_date = $dataaa['financial_year']['from'];
				$fin_to_date = $dataaa['financial_year']['to'];
				$from_date = date('Y-m-d',$fin_from_date->sec);
				$to_date = date('Y-m-d',$fin_to_date->sec);
				$from = strtotime($from_date);
				$to = strtotime($to_date);
					if($from <= $dddatttt && $to >= $dddatttt)
					{
					$nnnnn = 55;
					break;
					}
					else
					{
					$nnnnn = 555;
					}
			}
			
			if($nnnnn == 555)
			{
			$output = json_encode(array('type'=>'error', 'text' => 'Billing Date Should be in Financial Year'));
			die($output);
			}
	
	
			if(empty($child[1]))
			{
			$output = json_encode(array('type'=>'error', 'text' => 'Please Select Billing Due Date'));
			die($output);
			}	
	        $due_date = $child[1]; 
	        $due_date2 = date('Y-m-d',strtotime($due_date)); 
	        $dueee_datee = strtotime($due_date2);
	
	     if($dueee_datee < $dddatttt)
		 {
			$output = json_encode(array('type'=>'error', 'text' => 'Due Date Should be Greater Than or Equal to the Billing Date'));
			die($output);	 
			 
		 }
	     
		 if(empty($child[2]))
		 {
		 $output = json_encode(array('type'=>'error', 'text' => 'Please Select Bill Type'));
		 die($output);	 	 
		 }
	      $typp = $child[2];
				
		if(empty($child[3]))
		{			
		$output = json_encode(array('type'=>'error', 'text' => 'Please Select User'));
		die($output);
		}	
		
		if(empty($child[4]))
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Please Select Income Head'));
		die($output);	
		}			
	    
		if(empty($child[5])) 
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Please Fill Amount'));
		die($output);		
		}
	
		   if($typp == 1)
		   {
			 if(empty($child[6]))  
			 {
		$output = json_encode(array('type'=>'error', 'text' => 'Please Fill Company Name'));
		die($output);	 
				 
			 } 
		   }
	
		}	

foreach($myArray as $child)
		{		
		$billing_date = $child[0];
		$billing_due_date = $child[1];
		$bill_type = $child[2];
		$user_id = $child[3];
		$income_head_id = $child[4];
		$amount = $child[5];
		if($bill_type == 1)
		{
		$company_name = $child[6];	
		}
		@$desc = @$child[7];
		
		
	if($bill_type == 1)
		{
		$from=$this->encode($billing_date,'housingmatters');
		$due=$this->encode($billing_due_date,'housingmatters');
		$in_head=$this->encode($income_head_id,'housingmatters');
		$amountt=$this->encode($amount,'housingmatters');
		$user_idd=$this->encode($user_id,'housingmatters');
		$bill_typp=$this->encode($bill_type,'housingmatters');
        $company_name=$this->encode($company_name,'housingmatters');
		$descc=$this->encode($desc,'housingmatters');
		
/*$this->response->header('Location','supplimentry_bill_view2?from='.$from.'&due='.$due.'&ih='.$in_head.'
&amt='.$amountt.'&des='.$descc.'&typ='.$bill_typp.'&user='.$user_idd.'&com='.$company_name.'');*/

$output = json_encode(array('type'=>'success', 'text' => 'supplimentry_bill_view2?from='.$from.'&due='.$due.'&ih='.$in_head.'
&amt='.$amountt.'&des='.$descc.'&typ='.$bill_typp.'&user='.$user_idd.'&com='.$company_name.''));
		die($output);
		}
	    if($bill_type == 2)
		{
		$from=$this->encode($billing_date,'housingmatters');
		$due=$this->encode($billing_due_date,'housingmatters');
		$in_head=$this->encode($income_head_id,'housingmatters');
		$amountt=$this->encode($amount,'housingmatters');
		$user_idd=$this->encode($user_id,'housingmatters');
		$bill_typp=$this->encode($bill_type,'housingmatters');
        $descc=$this->encode($desc,'housingmatters');
		
	/*	$this->response->header('Location','supplimentry_bill_view2?from='.$from.'&due='.$due.'&ih='.$in_head.'
&amt='.$amountt.'&des='.$descc.'&typ='.$bill_typp.'&user='.$user_idd.'');*/
		
	$output = json_encode(array('type'=>'success', 'text' => 'supplimentry_bill_view2?from='.$from.'&due='.$due.'&ih='.$in_head.'
&amt='.$amountt.'&des='.$descc.'&typ='.$bill_typp.'&user='.$user_idd.''));
		die($output);	
		
		
		
		}	
		
		}
		
		}
		
////////////////////////////////////End Supplimentry Bill Json /////////////////////////////////////////////
}
?>