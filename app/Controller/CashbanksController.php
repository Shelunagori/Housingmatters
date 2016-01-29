<?php
App::import('Controller','Hms');
class CashbanksController extends HmsController {
var $helpers = array('Html', 'Form','Js');
public $components = array(
'Paginator',
'Session','Cookie','RequestHandler'
);
var $name = 'Cashbanks';

function import_bank_receipts_csv(){
	if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
	$this->ath();
	$s_society_id = $this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	
	$this->loadmodel('import_record');
	$conditions=array("society_id" => $s_society_id,"module_name" => "BR");
	$result_import_record = $this->import_record->find('all',array('conditions'=>$conditions));
	$this->set('result_import_record',$result_import_record);
	foreach($result_import_record as $data_import){
		$step1=(int)@$data_import["import_record"]["step1"];
		$step2=(int)@$data_import["import_record"]["step2"];
		$step3=(int)@$data_import["import_record"]["step3"];
		$step4=(int)@$data_import["import_record"]["step4"];
	}
	$process_status= @$step1+@$step2+@$step3+@$step4;
	if(@$process_status==2){
		$this->loadmodel('bank_receipt_csv');
		$conditions=array("society_id" => $s_society_id,"is_converted" => "YES");
		$total_converted_records = $this->bank_receipt_csv->find('count',array('conditions'=>$conditions));
		
		$this->loadmodel('bank_receipt_csv');
		$conditions=array("society_id" => $s_society_id);
		$total_records = $this->bank_receipt_csv->find('count',array('conditions'=>$conditions));
		
		$this->set("converted_per",($total_converted_records*100)/$total_records);
	}
	if(@$process_status==4){
		$this->loadmodel('bank_receipt_csv_converted');
		$conditions=array("society_id" => $s_society_id,"is_imported" => "YES");
		$total_converted_records = $this->bank_receipt_csv_converted->find('count',array('conditions'=>$conditions));
		
		$this->loadmodel('bank_receipt_csv_converted');
		$conditions=array("society_id" => $s_society_id);
		$total_records = $this->bank_receipt_csv_converted->find('count',array('conditions'=>$conditions));
		
		$this->set("converted_per_im",($total_converted_records*100)/$total_records);
	}
}

function Upload_Bank_receipt_csv_file(){
	$s_society_id = $this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$this->ath();
	if(isset($_FILES['file'])){
		$file_name=$s_society_id.".csv";
		$file_tmp_name =$_FILES['file']['tmp_name'];
		$target = "Bank_Receipt_csv_files/";
		$target=@$target.basename($file_name);
		move_uploaded_file($file_tmp_name,@$target);
		
		
		$today = date("d-M-Y");
		
		$this->loadmodel('import_record');
		$auto_id=$this->autoincrement('import_record','auto_id');
		$this->import_record->saveAll(Array( Array("auto_id" => $auto_id, "file_name" => $file_name,"society_id" => $s_society_id, "user_id" => $s_user_id, "module_name" => "BR", "step1" => 1,"date"=>$today))); 
		
		die(json_encode("UPLOADED"));
	}
}

function read_csv_file(){
	$this->layout=null;
	$s_society_id = $this->Session->read('society_id');
	
	$f = fopen('Bank_Receipt_csv_files/'.$s_society_id.'.csv', 'r') or die("ERROR OPENING DATA");
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
			$trajection_date=$child_ar[0];
			$deposited_in=$child_ar[1];
			$receipt_mode=$child_ar[2];
			$cheque_or_reference_no=$child_ar[3];
			$date=$child_ar[4];
			$drown_in_which_bank=$child_ar[5];
			$branch_of_bank=$child_ar[6];
			$member_name=$child_ar[7];
			$wing=$child_ar[8];
			$flat=$child_ar[9];
			$receipt_type=$child_ar[10];
			$amount=$child_ar[11];
			$narration=$child_ar[12];
			
			$this->loadmodel('bank_receipt_csv');
			$auto_id=$this->autoincrement('bank_receipt_csv','auto_id');
			$this->bank_receipt_csv->saveAll(Array(Array("auto_id" => $auto_id, "trajection_date" => $trajection_date,"deposited_in" => $deposited_in, "receipt_mode" => $receipt_mode, "cheque_or_reference_no" => $cheque_or_reference_no, "date" => $date,"drown_in_which_bank"=>$drown_in_which_bank,"branch_of_bank"=>$branch_of_bank,"member_name"=>$member_name,"wing"=>$wing,"flat"=>$flat,"receipt_type"=>$receipt_type,"amount"=>$amount,"narration"=>$narration,"society_id"=>$s_society_id,"is_converted"=>"NO")));
		}
	}
	$this->loadmodel('import_record');
	$this->import_record->updateAll(array("step2" => 1),array("society_id" => $s_society_id, "module_name" => "BR"));
	die(json_encode("READ"));
}

function convert_imported_data(){
	$this->layout=null;
	$s_society_id = $this->Session->read('society_id');
	
	$this->loadmodel('bank_receipt_csv');
	$conditions=array("society_id" => $s_society_id,"is_converted" => "NO");
	$result_import_record = $this->bank_receipt_csv->find('all',array('conditions'=>$conditions,'limit'=>20));
	foreach($result_import_record as $import_record){
		$bank_receipt_csv_id=$import_record["bank_receipt_csv"]["auto_id"];
		$trajection_date=trim($import_record["bank_receipt_csv"]["trajection_date"]);
		$deposited_in=trim($import_record["bank_receipt_csv"]["deposited_in"]);
		$receipt_mode=trim(strtolower($import_record["bank_receipt_csv"]["receipt_mode"]));
		$cheque_or_reference_no=trim($import_record["bank_receipt_csv"]["cheque_or_reference_no"]);
		$date=trim($import_record["bank_receipt_csv"]["date"]);
		$drown_in_which_bank=trim($import_record["bank_receipt_csv"]["drown_in_which_bank"]);
		$branch_of_bank=trim($import_record["bank_receipt_csv"]["branch_of_bank"]);
		$member_name=$import_record["bank_receipt_csv"]["member_name"];
		 $wing=trim($import_record["bank_receipt_csv"]["wing"]);
		 $flat=(int)trim($import_record["bank_receipt_csv"]["flat"]);
		$receipt_type=trim(strtolower($import_record["bank_receipt_csv"]["receipt_type"]));
		$amount=trim($import_record["bank_receipt_csv"]["amount"]);
		$narration=trim($import_record["bank_receipt_csv"]["narration"]);
		
		$this->loadmodel('ledger_sub_account'); 
		$conditions=array("name"=> new MongoRegex('/^' . $deposited_in . '$/i'),"society_id"=>$s_society_id);
		$result_ac=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
		if(sizeof($result_ac)>0){
			foreach($result_ac as $collection){
				$bank_id = (int)$collection['ledger_sub_account']['auto_id'];
			}
		}else{
			$bank_id=0;
		}
		
		
		$this->loadmodel('wing'); 
		$conditions=array("wing_name"=> new MongoRegex('/^' . $wing . '$/i'),"society_id"=>$s_society_id);
		$result_ac=$this->wing->find('all',array('conditions'=>$conditions));
		if(sizeof($result_ac)>0){
			foreach($result_ac as $collection){
				$wing_id = (int)$collection['wing']['wing_id'];
			}
		}else{
			$wing_id=0;
		}
		

		$this->loadmodel('flat'); 
		$conditions=array("flat_name"=>$flat, "society_id"=>$s_society_id, "wing_id"=>$wing_id);
		$result_ac=$this->flat->find('all',array('conditions'=>$conditions));
		if(sizeof($result_ac)>0){
			foreach($result_ac as $collection){
				$flat_id = (int)$collection['flat']['flat_id'];
				$true_wing_id = (int)$collection['flat']['wing_id'];
			}
		}else{
			$flat_id=0; $true_wing_id=0;
		}
		
		
		if($true_wing_id==$wing_id && ($true_wing_id!=0)){
			$this->loadmodel('ledger_sub_account'); 
			$conditions=array("flat_id"=> (int)$flat_id, "society_id"=>$s_society_id);
			$result_ac=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
			foreach($result_ac as $collection){
				$ledger_sub_account_id = (int)$collection['ledger_sub_account']['auto_id'];
			}
		}else{
			$ledger_sub_account_id = 0;
		}
		
		
		
		if($receipt_type=="m"){
			$receipt_type=1;
		}
		elseif($receipt_type=="o"){
			$receipt_type=2;
		}else{
			$receipt_type=0;
		}

		$this->loadmodel('bank_receipt_csv_converted');
		$auto_id=$this->autoincrement('bank_receipt_csv_converted','auto_id');
		$this->bank_receipt_csv_converted->saveAll(Array(Array("auto_id" => $auto_id, "trajection_date" => $trajection_date,"deposited_in" => $bank_id, "receipt_mode" => $receipt_mode, "cheque_or_reference_no" => $cheque_or_reference_no, "date" => $date,"drown_in_which_bank"=>$drown_in_which_bank,"branch_of_bank"=>$branch_of_bank,"ledger_sub_account_id"=>$ledger_sub_account_id,"receipt_type"=>$receipt_type,"amount"=>$amount,"narration"=>$narration,"society_id"=>$s_society_id,"is_imported"=>"NO")));
		
		$this->loadmodel('bank_receipt_csv');
		$this->bank_receipt_csv->updateAll(array("is_converted" => "YES"),array("auto_id" => $bank_receipt_csv_id));
	}
	
	$this->loadmodel('bank_receipt_csv');
	$conditions=array("society_id" => $s_society_id,"is_converted" => "YES");
	$total_converted_records = $this->bank_receipt_csv->find('count',array('conditions'=>$conditions));
	
	$this->loadmodel('bank_receipt_csv');
	$conditions=array("society_id" => $s_society_id);
	$total_records = $this->bank_receipt_csv->find('count',array('conditions'=>$conditions));
	
	$converted_per=($total_converted_records*100)/$total_records;
	if($converted_per==100){ $again_call_ajax="NO"; 
		$this->loadmodel('import_record');
		$this->import_record->updateAll(array("step3" => 1),array("society_id" => $s_society_id, "module_name" => "BR"));
	}else{
		$again_call_ajax="YES"; 
			
		}
	die(json_encode(array("again_call_ajax"=>$again_call_ajax,"converted_per"=>$converted_per)));
}

function modify_bank_receipt_csv_data($page=null){
	
	
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	$this->ath();
	
	
	$s_society_id = $this->Session->read('society_id');
	$page=(int)$page;
	$this->set('page',$page);
	
	$this->loadmodel('import_record');
	$conditions=array("society_id" => $s_society_id,"module_name" => "BR");
	$result_import_record = $this->import_record->find('all',array('conditions'=>$conditions));
	$this->set('result_import_record',$result_import_record);
	foreach($result_import_record as $data_import){
		$step1=(int)@$data_import["import_record"]["step1"];
		$step2=(int)@$data_import["import_record"]["step2"];
		$step3=(int)@$data_import["import_record"]["step3"];
	}
	$process_status= @$step1+@$step2+@$step3;
	if($process_status==3){
		$this->loadmodel('bank_receipt_csv_converted'); 
		$conditions=array("society_id"=>(int)$s_society_id);
		$result_bank_receipt_converted=$this->bank_receipt_csv_converted->find('all',array('conditions'=>$conditions,"limit"=>20,"page"=>$page));
		$this->set('result_bank_receipt_converted',$result_bank_receipt_converted);
		
		$this->loadmodel('bank_receipt_csv_converted'); 
		$conditions=array("society_id"=>(int)$s_society_id);
		$count_bank_receipt_converted=$this->bank_receipt_csv_converted->find('count',array('conditions'=>$conditions));
		$this->set('count_bank_receipt_converted',$count_bank_receipt_converted);
	}
	
	$this->loadmodel('ledger_sub_account');
	$conditions=array("ledger_id" => 33,"society_id"=>$s_society_id);
	$result_banks=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
	$this->set('result_banks',$result_banks);
	
	$this->loadmodel('ledger_sub_account');
	$conditions=array("ledger_id" => 34,"society_id"=>$s_society_id);
	$result_members=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
	$this->set('result_members',$result_members);
			
}

function check_bank_receipt_csv_validation($page=null){
	$this->layout=null;
	
	$this->ath();
	$s_society_id = $this->Session->read('society_id');
	$page=(int)$page;
	
	$this->loadmodel('bank_receipt_csv_converted'); 
	$conditions=array("society_id"=>(int)$s_society_id);
	$order=array('bank_receipt_csv_converted.auto_id'=>'ASC');
	$result_bank_receipt_converted=$this->bank_receipt_csv_converted->find('all',array('conditions'=>$conditions,'order'=>$order,"limit"=>20,"page"=>$page));
	foreach($result_bank_receipt_converted as $receipt_converted){
		$auto_id=$receipt_converted["bank_receipt_csv_converted"]["auto_id"];
		$trajection_date=$receipt_converted["bank_receipt_csv_converted"]["trajection_date"];
		$deposited_in=(int)$receipt_converted["bank_receipt_csv_converted"]["deposited_in"];
		$receipt_mode=$receipt_converted["bank_receipt_csv_converted"]["receipt_mode"];
		$cheque_or_reference_no=$receipt_converted["bank_receipt_csv_converted"]["cheque_or_reference_no"];
		$date=$receipt_converted["bank_receipt_csv_converted"]["date"];
		$drown_in_which_bank=$receipt_converted["bank_receipt_csv_converted"]["drown_in_which_bank"];
		$branch_of_bank=$receipt_converted["bank_receipt_csv_converted"]["branch_of_bank"];
		$ledger_sub_account_id=$receipt_converted["bank_receipt_csv_converted"]["ledger_sub_account_id"];
		$amount=(int)$receipt_converted["bank_receipt_csv_converted"]["amount"];
		$receipt_type=(int)$receipt_converted["bank_receipt_csv_converted"]["receipt_type"];
		$narration=$receipt_converted["bank_receipt_csv_converted"]["narration"];
		
		
		if(empty($trajection_date)){ $trajection_date_v=1; }else{ $trajection_date_v=0; }
		if(empty($deposited_in)){ $deposited_in_v=1; }else{ $deposited_in_v=0; }
		$receipt_mode_v=0;
		if($receipt_mode=="cheque"){
			if(empty($cheque_or_reference_no)){	$cheque_or_reference_no_v=1; }else{ $cheque_or_reference_no_v=0; }
			if(empty($date)){	$date_v=1; }else{ $date_v=0; }
			if(empty($drown_in_which_bank)){ $drown_in_which_bank_v=1; }else{ $drown_in_which_bank_v=0; }
			if(empty($branch_of_bank)){ $branch_of_bank_v=1; }else{ $branch_of_bank_v=0; }
		}elseif($receipt_mode=="neft" || $receipt_mode=="pg"){
			if(empty($cheque_or_reference_no)){	$cheque_or_reference_no_v=1; }else{ $cheque_or_reference_no_v=0; }
			if(empty($date)){	$date_v=1; }else{ $date_v=0; }
			$drown_in_which_bank_v=0;
			$branch_of_bank_v=0;
		}
		
		if(empty($ledger_sub_account_id)){ $ledger_sub_account_id_v=1; }else{ $ledger_sub_account_id_v=0; }
		if(empty($amount)){ $amount_v=1; }else{ $amount_v=0; }
		if(empty($receipt_type)){ $receipt_type_v=1; }else{ $receipt_type_v=0; }
		
		$v_result[]=array($trajection_date_v,$deposited_in_v,$receipt_mode_v,$cheque_or_reference_no_v,$date_v,$drown_in_which_bank_v,$branch_of_bank_v,$ledger_sub_account_id_v,$amount_v,$receipt_type_v,$auto_id);
	}
		
	die(json_encode($v_result));
}

function auto_save_bank_receipt($record_id=null,$field=null,$value=null){
	$this->layout=null;
	
	$this->ath();
	$s_society_id = $this->Session->read('society_id');
	$record_id=(int)$record_id; 
	
	if($field=="trajection_date"){
		if(empty($value)){ echo "F";}
		else{
			$this->loadmodel('bank_receipt_csv_converted');
			$this->bank_receipt_csv_converted->updateAll(array("trajection_date" => $value),array("auto_id" => $record_id));
			echo "T";
		}
	}
	
	if($field=="deposited_in"){
		if(empty($value)){ echo "F";}
		else{
			$this->loadmodel('bank_receipt_csv_converted');
			$this->bank_receipt_csv_converted->updateAll(array("deposited_in" => (int)$value),array("auto_id" => $record_id));
			echo "T";
		}
	}
	
	if($field=="receipt_mode"){
		if(empty($value)){ echo "F";}
		else{
			$this->loadmodel('bank_receipt_csv_converted');
			$this->bank_receipt_csv_converted->updateAll(array("receipt_mode" => strtolower($value)),array("auto_id" => $record_id));
			echo "T";
		}
	}
	
	if($field=="cheque_or_reference_no"){
		if(empty($value)){ echo "F";}
		else{
			$this->loadmodel('bank_receipt_csv_converted');
			$this->bank_receipt_csv_converted->updateAll(array("cheque_or_reference_no" => $value),array("auto_id" => $record_id));
			echo "T";
		}
	}
	
	if($field=="date"){
		if(empty($value)){ echo "F";}
		else{
			$this->loadmodel('bank_receipt_csv_converted');
			$this->bank_receipt_csv_converted->updateAll(array("date" => $value),array("auto_id" => $record_id));
			echo "T";
		}
	}
	
	if($field=="drown_in_which_bank"){
		if(empty($value)){ echo "F";}
		else{
			$this->loadmodel('bank_receipt_csv_converted');
			$this->bank_receipt_csv_converted->updateAll(array("drown_in_which_bank" => $value),array("auto_id" => $record_id));
			echo "T";
		}
	}
	
	if($field=="branch_of_bank"){
		if(empty($value)){ echo "F";}
		else{
			$this->loadmodel('bank_receipt_csv_converted');
			$this->bank_receipt_csv_converted->updateAll(array("branch_of_bank" => $value),array("auto_id" => $record_id));
			echo "T";
		}
	}
	
	if($field=="ledger_sub_account_id"){
		if(empty($value)){ echo "F";}
		else{
			$this->loadmodel('bank_receipt_csv_converted');
			$this->bank_receipt_csv_converted->updateAll(array("ledger_sub_account_id" => (int)$value),array("auto_id" => $record_id));
			echo "T";
		}
	}
	
	
	if($field=="amount"){
		$value=(int)$value;
		if(empty($value)){ echo "F"; 
			$this->loadmodel('bank_receipt_csv_converted');
			$this->bank_receipt_csv_converted->updateAll(array("amount" => (int)$value),array("auto_id" => $record_id));
		}
		else{
			$this->loadmodel('bank_receipt_csv_converted');
			$this->bank_receipt_csv_converted->updateAll(array("amount" => (int)$value),array("auto_id" => $record_id));
			echo "T";
		}
	}
	
	if($field=="receipt_type"){
		$this->loadmodel('bank_receipt_csv_converted');
		$this->bank_receipt_csv_converted->updateAll(array("receipt_type" => (int)$value),array("auto_id" => $record_id));
		echo "T";
	}
	
	if($field=="narration"){
		$this->loadmodel('bank_receipt_csv_converted');
		$this->bank_receipt_csv_converted->updateAll(array("narration" => $value),array("auto_id" => $record_id));
		echo "T";
	}
	
}

function allow_import_bank_receipt(){
	$this->layout=null;
	
	$this->ath();
	$s_society_id = $this->Session->read('society_id');
	
	$this->loadmodel('bank_receipt_csv_converted'); 
	$conditions=array("society_id"=>(int)$s_society_id);
	$order=array('bank_receipt_csv_converted.auto_id'=>'ASC');
	$result_bank_receipt_converted=$this->bank_receipt_csv_converted->find('all',array('conditions'=>$conditions));
	foreach($result_bank_receipt_converted as $receipt_converted){
		$auto_id=$receipt_converted["bank_receipt_csv_converted"]["auto_id"];
		$trajection_date=$receipt_converted["bank_receipt_csv_converted"]["trajection_date"];
		$deposited_in=(int)$receipt_converted["bank_receipt_csv_converted"]["deposited_in"];
		$receipt_mode=$receipt_converted["bank_receipt_csv_converted"]["receipt_mode"];
		$cheque_or_reference_no=$receipt_converted["bank_receipt_csv_converted"]["cheque_or_reference_no"];
		$date=$receipt_converted["bank_receipt_csv_converted"]["date"];
		$drown_in_which_bank=$receipt_converted["bank_receipt_csv_converted"]["drown_in_which_bank"];
		$branch_of_bank=$receipt_converted["bank_receipt_csv_converted"]["branch_of_bank"];
		$ledger_sub_account_id=$receipt_converted["bank_receipt_csv_converted"]["ledger_sub_account_id"];
		$amount=(int)$receipt_converted["bank_receipt_csv_converted"]["amount"];
		$narration=$receipt_converted["bank_receipt_csv_converted"]["narration"];
		
		
		if(empty($trajection_date)){ $trajection_date_v=1; }else{ $trajection_date_v=0; }
		
			$ddatttt = $trajection_date;
			$dattttt = date('Y-m-d',strtotime($ddatttt));
			$dddatttt = strtotime($dattttt);
			
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
			$trajection_date_v=1;
			}
	   	    else{
			$trajection_date_v=0;	
			}
		
		
		if(empty($deposited_in)){ $deposited_in_v=1; }else{ $deposited_in_v=0; }
		$receipt_mode_v=0;
		if($receipt_mode=="cheque"){
			if(empty($cheque_or_reference_no)){	$cheque_or_reference_no_v=1; }else{ $cheque_or_reference_no_v=0; }
			if(empty($date)){	$date_v=1; }else{ $date_v=0; }
			if(empty($drown_in_which_bank)){ $drown_in_which_bank_v=1; }else{ $drown_in_which_bank_v=0; }
			if(empty($branch_of_bank)){ $branch_of_bank_v=1; }else{ $branch_of_bank_v=0; }
		}elseif($receipt_mode=="neft" || $receipt_mode=="pg"){
			if(empty($cheque_or_reference_no)){	$cheque_or_reference_no_v=1; }else{ $cheque_or_reference_no_v=0; }
			if(empty($date)){	$date_v=1; }else{ $date_v=0; }
			$drown_in_which_bank_v=0;
			$branch_of_bank_v=0;
		}
		
		if(empty($ledger_sub_account_id)){ $ledger_sub_account_id_v=1; }else{ $ledger_sub_account_id_v=0; }
		if(empty($amount)){ $amount_v=1; }else{ $amount_v=0; }
		
		$v_result[]=array($trajection_date_v,$deposited_in_v,$receipt_mode_v,$cheque_or_reference_no_v,$date_v,$drown_in_which_bank_v,$branch_of_bank_v,$ledger_sub_account_id_v,$amount_v);
		
	} 
	foreach($v_result as $data){
		if(array_sum($data)==0){ echo "T";
			$this->loadmodel('import_record');
			$this->import_record->updateAll(array("step4" => 1),array("society_id" => $s_society_id, "module_name" => "BR"));	
		}else{ echo "F"; die; }
	}
}

function final_import_bank_receipt_ajax(){
	$this->layout=null;
	$s_society_id = $this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	
	$this->loadmodel('import_record');
	$conditions=array("society_id" => $s_society_id,"module_name" => "BR");
	$result_import_record = $this->import_record->find('all',array('conditions'=>$conditions));
	$this->set('result_import_record',$result_import_record);
	foreach($result_import_record as $data_import){
		$step1=(int)@$data_import["import_record"]["step1"];
		$step2=(int)@$data_import["import_record"]["step2"];
		$step3=(int)@$data_import["import_record"]["step3"];
		$step4=(int)@$data_import["import_record"]["step4"];
	}
	$process_status= @$step1+@$step2+@$step3+@$step4;
	
	if($process_status==4){
		$this->loadmodel('bank_receipt_csv_converted');
		$conditions=array("society_id" => $s_society_id,"is_imported" => "NO");
		$result_import_converted = $this->bank_receipt_csv_converted->find('all',array('conditions'=>$conditions,'limit'=>2));
		
		foreach($result_import_converted as $import_converted){
			$bank_receipt_csv_id=$import_converted["bank_receipt_csv_converted"]["auto_id"];
			$trajection_date=$import_converted["bank_receipt_csv_converted"]["trajection_date"];
			$trajection_date = date('Y-m-d',strtotime($trajection_date));
			$trajection_date = strtotime($trajection_date); 
			$deposited_in=$import_converted["bank_receipt_csv_converted"]["deposited_in"];
			$receipt_mode=$import_converted["bank_receipt_csv_converted"]["receipt_mode"];
			$cheque_or_reference_no=$import_converted["bank_receipt_csv_converted"]["cheque_or_reference_no"];
			$date=$import_converted["bank_receipt_csv_converted"]["date"];
			$drown_in_which_bank=$import_converted["bank_receipt_csv_converted"]["drown_in_which_bank"];
			$branch_of_bank=$import_converted["bank_receipt_csv_converted"]["branch_of_bank"];
			$ledger_sub_account_id=$import_converted["bank_receipt_csv_converted"]["ledger_sub_account_id"];
			$amount=$import_converted["bank_receipt_csv_converted"]["amount"];
			$narration=$import_converted["bank_receipt_csv_converted"]["narration"];
			$receipt_type=$import_converted["bank_receipt_csv_converted"]["receipt_type"];
			
			$this->loadmodel('ledger_sub_account'); 
			$conditions=array("auto_id"=> $ledger_sub_account_id);
			$result_ac=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
			foreach($result_ac as $collection){
				$flat_id = (int)$collection['ledger_sub_account']['flat_id'];
			}
			
			if($receipt_type == 1){
				//apply receipt in regular_bill//
				$result_new_regular_bill = $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_last_bill_info_via_flat_id'),array('pass'=>array($flat_id)));
				
				$auto_id=null; $regular_bill_one_time_id=null;
				
				if(sizeof($result_new_regular_bill)>0){
					foreach($result_new_regular_bill as $data){
						$auto_id=$data["auto_id"];  
						$edit_status=$data["edit_status"]; 
						$latest_bill=@$data["latest_bill"]; 
						$receipt_applied=@$data["receipt_applied"]; 
						$regular_bill_one_time_id = (int)$data["one_time_id"];
						$flat_id = (int)$data["flat_id"];
						if($edit_status=="NO" && $latest_bill=="YES"){
							if(empty($receipt_applied)){
								$arrear_intrest=$data["arrear_intrest"];
								$intrest_on_arrears=$data["intrest_on_arrears"];
								$total=$data["total"];
								$arrear_maintenance=$data["arrear_maintenance"];
							}else{
								$arrear_intrest=$data["new_arrear_intrest"];
								$intrest_on_arrears=$data["new_intrest_on_arrears"];
								$total=$data["new_total"];
								$arrear_maintenance=$data["new_arrear_maintenance"];
							}
						}else{
							$number_of_receipt=$this->count_receipt_against_bill($regular_bill_one_time_id,$flat_id);
							if($number_of_receipt==0){
								$arrear_intrest=$data["arrear_intrest"];
								$intrest_on_arrears=$data["intrest_on_arrears"];
								$total=$data["total"];
								$arrear_maintenance=$data["arrear_maintenance"]; 
							}else{
								$arrear_intrest=$data["new_arrear_intrest"];
								$intrest_on_arrears=$data["new_intrest_on_arrears"];
								$total=$data["new_total"];
								$arrear_maintenance=$data["new_arrear_maintenance"];
							}
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
					$this->new_regular_bill->updateAll(array('new_arrear_intrest'=>$new_arrear_intrest,"new_intrest_on_arrears"=>$new_intrest_on_arrears,"new_arrear_maintenance"=>$new_arrear_maintenance,"new_total"=>$new_total),array('auto_id'=>$auto_id));
				}
			
			
			$current_date = date('Y-m-d');
			
			$t1=$this->autoincrement('new_cash_bank','transaction_id');
			$k = (int)$this->autoincrement_with_receipt_source('new_cash_bank','receipt_id',1); 
			$this->loadmodel('new_cash_bank');
			$multipleRowData = Array( Array("transaction_id"=> $t1,"receipt_id" => $k, "receipt_date" => $trajection_date, "receipt_mode" => $receipt_mode, "cheque_number" =>@$cheque_or_reference_no,"cheque_date" =>$date,"drawn_on_which_bank" =>@$drown_in_which_bank,"reference_utr" => @$cheque_or_reference_no,"deposited_bank_id" => $deposited_in,"bank_branch" => $branch_of_bank,"member_type" => 1,"party_name_id"=>$flat_id,"receipt_type" => $receipt_type,"amount" => $amount,"current_date" => $current_date,"society_id"=>$s_society_id,"flat_id"=>$flat_id,"bill_auto_id"=>$auto_id,"bill_one_time_id"=>$regular_bill_one_time_id,"narration"=>$narration,"receipt_source"=>1,"edit_status"=>"NO","auto_inc"=>"YES","prepaired_by" => $s_user_id,"is_cancel"=>"NO"));  
			$this->new_cash_bank->saveAll($multipleRowData);
			
			$l=$this->autoincrement('ledger','auto_id');
			$this->loadmodel('ledger');
			$multipleRowData = Array( Array("auto_id" => $l, "transaction_date"=> $trajection_date, "debit" => $amount, "credit" =>null,"ledger_account_id" => 33, "ledger_sub_account_id" => $deposited_in, "table_name" => "new_cash_bank","element_id" => $t1, "society_id" => $s_society_id));
			$this->ledger->saveAll($multipleRowData); 

			$l=$this->autoincrement('ledger','auto_id');
			$this->loadmodel('ledger');
			$multipleRowData = Array( Array("auto_id" => $l, "transaction_date"=> $trajection_date, "credit" => $amount, "debit" =>null,"ledger_account_id" => 34, "ledger_sub_account_id" => $ledger_sub_account_id,"table_name" => "new_cash_bank","element_id" => $t1, "society_id" => $s_society_id));
			$this->ledger->saveAll($multipleRowData);
			
			$this->loadmodel('bank_receipt_csv_converted');
			$this->bank_receipt_csv_converted->updateAll(array("is_imported" => "YES"),array("auto_id" => $bank_receipt_csv_id));
					
					
			//////email///
			
			$receipt_no = $k;
			$d_date = $trajection_date;
			$today = date("d-M-Y");
			$bill_reference = $cheque_or_reference_no;
			$member = 1;
			$cheque_number = $cheque_or_reference_no;
			$which_bank = $drown_in_which_bank;
			$reference_number = $cheque_or_reference_no;
			$cheque_date = $date;
			$sub_account = $deposited_in;
			$sms_date=date("d-m-Y",($d_date));

			$amount = str_replace( ',', '', $amount );
			$am_in_words=ucwords($this->requestAction(array('controller' => 'hms', 'action' => 'convert_number_to_words'), array('pass' => array($amount))));

			$this->loadmodel('society');
			$conditions=array("society_id" => $s_society_id);
			$cursor2=$this->society->find('all',array('conditions'=>$conditions));
			foreach ($cursor2 as $collection) 
			{
			$society_name = $collection['society']['society_name'];
			$society_reg_no = $collection['society']['society_reg_num'];
			$society_address = $collection['society']['society_address'];
			$sig_title = $collection['society']['sig_title'];
			}
			
			
			$flatt_datta = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
			foreach ($flatt_datta as $fltt_datttaa) 
			{
			$wnngg_idddd = (int)$fltt_datttaa['flat']['wing_id'];
			}

			$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wnngg_idddd,$flat_id)));
			foreach ($result_lsa as $collection) 
			{
			$wing_id = $collection['user']['wing'];  
			$flat_id = (int)$collection['user']['flat'];
			$tenant = (int)$collection['user']['tenant'];
			$user_name = $collection['user']['user_name'];
			$to_mobile = $collection['user']['mobile'];
			$to_email = $collection['user']['email'];
			}
			$wing_flat = $this->requestAction(array('controller' => 'hms', 'action'=>'wing_flat'),array('pass'=>array($wing_id,$flat_id)));									
			
			$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($sub_account))); 
			foreach($result2 as $collection)
			{
			$bank_name = $collection['ledger_sub_account']['name'];
			}
												
			$ip=$this->hms_email_ip();
			$date=date("d-m-Y",($d_date));
				
			$ip=$this->hms_email_ip();
			$html_receipt='<table style="padding:24px;background-color:#34495e" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
						<tbody><tr>
							
							<td>
						
								
							
								<table style="padding:38px 30px 30px 30px;background-color:#fafafa" align="center" border="0" cellpadding="0" cellspacing="0" width="540">
									<tbody>
									<tr>
										<td colspan="2" style="font-size:12px;line-height:1.4;font-family:Arial,Helvetica,sans-serif;color:#34495e;">
										
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
										
										<table style="font-size:12px" width="100%" cellspacing="0">
											<tbody><tr>
												<td style="padding:2px;background-color:rgb(0,141,210);color:#fff" align="center" width="100%"><b>'.strtoupper($society_name).'</b></td>
											</tr>
										</tbody></table>
										<table style="font-size:12px" width="100%" cellspacing="0">
											<tbody>
											<tr>
												<td style="padding:5px;border-bottom:solid 1px #767575;border-top:solid 1px #767575" width="100%" align="center">
												<span style="color:rgb(100,100,99)">Regn# &nbsp; '.$society_reg_no.'</span><br>
												<span style="color:rgb(100,100,99)">'.$society_address.'</span><br
												</td>
											</tr>
											</tbody>
										</table>
										<table style="font-size:12px;border-bottom:solid 1px #767575;" width="100%" cellspacing="0">
											<tbody><tr>
												<td style="padding:0px 0 2px 5px" colspan="2">Receipt No: '.$receipt_no.'</td>
												
												<td colspan="2" align="right" style="padding:0px 5px 0 0px"><b>Date:</b> '.$date.' </td>
												
											</tr>
											<tr>
												<td style="padding:0px 0 2px 5px" colspan="2"> Received with thanks from: <b>'.$user_name.' '.$wing_flat.'</b></td>
																					
											</tr>
											<tr>
												<td style="padding:0px 0 2px 5px"  colspan="4">Rupees '.$am_in_words.' Only </td>
												
											</tr>';
											
										if($receipt_mode=="Cheque"){
										$receipt_mode_type='Via '.$receipt_mode.'-'.$cheque_number.' drawn on '.$which_bank.' dated '.$cheque_date;
										}
										else{
										$receipt_mode_type='Via '.$receipt_mode.'-'.$reference_number.' dated '.$cheque_date;
										}


											
											$html_receipt.='<tr>
												<td style="padding:0px 0 2px 5px"  colspan="4">'.$receipt_mode_type.'</td>
												
											</tr>
											
											<tr>
												<td style="padding:0px 0 2px 5px" colspan="4">Payment of previous bill</td>
												
											</tr>
											
										</tbody></table>
										
										
										
										<table style="font-size:12px;" width="100%" cellspacing="0">
											<tbody><tr>
												<td width="50%" style="padding:5px" valign="top">
												<span style="font-size:16px;"> <b>Rs '.$amount.'</b></span><br>';
												if($receipt_mode=="Cheque"){
												$receipt_title_cheq='Subject to realization of Cheque(s)';
												}
																					
												$html_receipt.='<span>'.@$receipt_title_cheq.'</span></td>
												<td align="center" width="50%" style="padding:5px" valign="top">
												For  <b>'.$society_name.'</b><br><br><br>
												<div><span style="border-top:solid 1px #424141">'.$sig_title.'</span></div>
												</td>
											</tr>
										</tbody></table>
															
										
										</td>
									</tr>
									
									<tr>
										<td colspan="2">
											<table style="background-color:#008dd2;font-size:11px;color:#fff;border:solid 1px #767575;border-top:none" width="100%" cellspacing="0">
											 <tbody>
											 
												<tr>
													<td align="center" colspan="7"><b>
													Your Society is empowered by HousingMatters - <b> <i>"Making Life Simpler"</i>
													</b></b></td>
												</tr>
												<tr>
													<td width="50" align="right" style="font-size: 10px;"><b>Email :</b></td>
													<td width="120" style="color:#fff!important;font-size: 10px;"> 
													<a href="mailto:support@housingmatters.in" style="color:#fff!important" target="_blank"><b>support@housingmatters.in</b></a>
													</td>
													<td align="center" style="font-size: 10px;"></td>
													<td align="right" style="font-size: 10px;"><b>Phone :</b></td>
													<td width="84" style="color:#fff!important;text-decoration:none;font-size:10px;"><b>022-41235568</b></td>
													<td align="center" style="font-size: 10px;"></td>
													<td width="100" style="padding-right:10px;text-decoration:none"> <a href="http://www.housingmatters.in" style="color:#fff!important" target="_blank"><b>www.housingmatters.in</b></a></td>
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
					</tbody>
			</table>';
			
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
			////email code//

			$r_sms=$this->hms_sms_ip();
			$working_key=$r_sms->working_key;
			$sms_sender=$r_sms->sms_sender; 
			$sms_allow=(int)$r_sms->sms_allow;

			$subject="[".$society_name."]- e-Receipt of Rs ".$amount." on ".date('d-M-Y',$d_date)." against Unit ".$wing_flat."";

			if(!empty($to_email)){
				$this->send_email($to_email,'accounts@housingmatters.in','HousingMatters',$subject,$html_receipt,'donotreply@housingmatters.in');
			}
			}

			if($sms_is_on_off==1){
				if($sms_allow==1){
					$r_sms=$this->hms_sms_ip();
					$working_key=$r_sms->working_key;
					$sms_sender=$r_sms->sms_sender; 
					$sms_allow=(int)$r_sms->sms_allow;
					$user_name_short=$this->check_charecter_name($user_name);
					$sms="Dear ".$user_name_short." ,we have received Rs ".$amount." on ".$sms_date." towards Society Maint. dues. Cheques are subject to realization,".$society_name;
					$sms1=str_replace(' ', '+', $sms);

					$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$to_mobile.'&message='.$sms1.''); 
				}
			}	
			//////email/////		
		} 
		if($receipt_type == 2){
			$current_date = date('Y-m-d');
			$t2=$this->autoincrement('new_cash_bank','transaction_id');
			$k = (int)$this->autoincrement_with_receipt_source('new_cash_bank','receipt_id',1);
			$this->loadmodel('new_cash_bank');
			$multipleRowData = Array( Array("transaction_id"=>$t2, "receipt_id" => $k, "receipt_date" => $trajection_date, "receipt_mode" => $receipt_mode, "cheque_number" =>@$cheque_or_reference_no,"cheque_date" =>$date,"drawn_on_which_bank" =>@$drown_in_which_bank,"bank_branch" => $branch_of_bank,"reference_utr" => @$cheque_or_reference_no,"deposited_bank_id" => $deposited_in,"member_type" => 1,"party_name_id"=>$flat_id,"receipt_type" => $receipt_type,"amount" => $amount,"current_date" => $current_date,"society_id"=>$s_society_id,"flat_id"=>$flat_id,"narration"=>$narration,"receipt_source"=>1,"prepaired_by" => $s_user_id,"edit_status"=>"NO","auto_inc"=>"YES"));
			$this->new_cash_bank->saveAll($multipleRowData);

			
			
			$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'ledger_SubAccount_dattta_by_flat_id'),array('pass'=>array($flat_id)));
			foreach($result_flat_info as $flat_info){
				$account_id = (int)$flat_info["ledger_sub_account"]["auto_id"];
			}

			$l=$this->autoincrement('ledger','auto_id');
			$this->loadmodel('ledger');
			$multipleRowData = Array( Array("auto_id" => $l, "transaction_date"=> $trajection_date, "debit" => $amount, "credit" =>null, "ledger_account_id" => 33, "ledger_sub_account_id" => $deposited_in,"table_name" => "new_cash_bank","element_id" => $t2, "society_id" => $s_society_id,));
			$this->ledger->saveAll($multipleRowData); 

			$l=$this->autoincrement('ledger','auto_id');
			$this->loadmodel('ledger');
			$multipleRowData = Array( Array("auto_id" => $l, "transaction_date"=> $trajection_date, "credit" => $amount, "debit" =>null, "ledger_account_id" => 34, "ledger_sub_account_id" => $account_id,"table_name" => "new_cash_bank","element_id" => $t2, "society_id" => $s_society_id,));
			$this->ledger->saveAll($multipleRowData);
			
			$this->loadmodel('bank_receipt_csv_converted');
			$this->bank_receipt_csv_converted->updateAll(array("is_imported" => "YES"),array("auto_id" => $bank_receipt_csv_id));
		}
	}
		
		
		$this->loadmodel('bank_receipt_csv_converted');
		$conditions=array("society_id" => $s_society_id,"is_imported" => "YES");
		$total_converted_records = $this->bank_receipt_csv_converted->find('count',array('conditions'=>$conditions));
		
		$this->loadmodel('bank_receipt_csv_converted');
		$conditions=array("society_id" => $s_society_id);
		$total_records = $this->bank_receipt_csv_converted->find('count',array('conditions'=>$conditions));
		
		$converted_per=($total_converted_records*100)/$total_records;
		if($converted_per==100){ $again_call_ajax="NO"; 
			
			$this->loadmodel('bank_receipt_csv_converted');
			$conditions4=array('society_id'=>$s_society_id);
			$this->bank_receipt_csv_converted->deleteAll($conditions4);
			
			$this->loadmodel('bank_receipt_csv');
			$conditions4=array('society_id'=>$s_society_id);
			$this->bank_receipt_csv->deleteAll($conditions4);
			
			$this->loadmodel('import_record');
			$conditions4=array("society_id" => $s_society_id, "module_name" => "BR");
			$this->import_record->deleteAll($conditions4);
		}else{
			$again_call_ajax="YES"; 
			}
		die(json_encode(array("again_call_ajax"=>$again_call_ajax,"converted_per_im"=>$converted_per)));
	}
}

function delete_bank_receipt_row($record_id=null){
	$this->layout=null;
	$s_society_id = $this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$this->loadmodel('bank_receipt_csv_converted');
	$conditions4=array("auto_id" => (int)$record_id);
	$this->bank_receipt_csv_converted->deleteAll($conditions4);
	echo "1";
}
///////////////////// Start bank receipt View/////////////////////////////////////////////////////////
function bank_receipt_view()
{
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

		$this->set('s_role_id',$s_role_id);
}
////////////////////End Bank receipt View////////////////////////////////////////////////////////////

/////////////////////// Start bank receipt show ajax //////////////////////////////////////////////
function bank_receipt_show_ajax()
{
	$this->layout='blank';

		$this->ath();
		$s_role_id=$this->Session->read('role_id');
		$s_society_id = $this->Session->read('society_id');
		$s_user_id=$this->Session->read('user_id');

	$this->set('s_user_id',$s_user_id);
	$this->set('s_role_id',$s_role_id);

		$from = $this->request->query('date1');
		$to = $this->request->query('date2');

	$date_from = date('Y-m-d',strtotime($from));
	$date_to = date('Y-m-d',strtotime($to));

		$from_strtotime = strtotime($date_from);
		$to_strtotime = strtotime($date_to);

	$this->set('from',$from);
	$this->set('to',$to);

		$this->loadmodel('new_cash_bank');
		$order=array('new_cash_bank.receipt_date'=> 'ASC');
		$conditions=array('society_id'=>$s_society_id,"receipt_source"=>1,"edit_status"=>"NO",
		'new_cash_bank.receipt_date'=>array('$gte'=>$from_strtotime,'$lte'=>$to_strtotime));
		$cursor2=$this->new_cash_bank->find('all',array('conditions'=>$conditions,'order'=>$order));
		$this->set('cursor2',$cursor2);

			$this->loadmodel('society');
			$conditions=array("society_id" => $s_society_id);
			$cursor = $this->society->find('all',array('conditions'=>$conditions));
			foreach($cursor as $collection)
			{
			$society_name = $collection['society']['society_name'];
			}
			$this->set('society_name',$society_name);
		
	$this->loadmodel('new_regular_bill');
	$conditions2=array("society_id" => $s_society_id,"approval_status" => 1);
	$result_new_regular_bill_max = $this->new_regular_bill->find('all',array('conditions'=>$conditions2));
	foreach($result_new_regular_bill_max as $data_max){
	$one_time_ids[]=$data_max["new_regular_bill"]["one_time_id"];
	}
	@$maximum_one_time_id=max(@$one_time_ids);
	$this->set("maximum_one_time_id",$maximum_one_time_id);
}
///////////////////////////////////End bank receipt show ajax//////////////////////////////////////////////////

function cancel_receipt_due_to_check_bounce($record_id=null){
	$this->ath();
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = $this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
		
	$this->loadmodel('new_cash_bank');
	$conditions=array("transaction_id"=>(int)$record_id);
	$result_new_cash_bank = $this->new_cash_bank->find('all',array('conditions'=>$conditions));
	foreach($result_new_cash_bank as $data){
		$amount=$data["new_cash_bank"]["amount"];
		$deposited_bank_id=$data["new_cash_bank"]["deposited_bank_id"];
		$flat_id=(int)$data["new_cash_bank"]["flat_id"];
		$bill_one_time_id=$data["new_cash_bank"]["bill_one_time_id"];
	}
	
	$this->loadmodel('ledger_sub_account');
	$conditions=array("ledger_id"=>34,"flat_id"=>$flat_id);
	$result_ledger_sub_account= $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
	foreach($result_ledger_sub_account as $data){
		$ledger_sub_account_id=$data["ledger_sub_account"]["auto_id"];
	}
	
	$current_date = date('Y-m-d');
	$current_date = strtotime($current_date); 
	
	$voucher_id=$this->autoincrement_with_society_ticket('journal','voucher_id');
	$journal_id=$this->autoincrement('journal','journal_id');
	$this->loadmodel('journal');
	$multipleRowData = Array( Array("journal_id" => $journal_id,"ledger_account_id" => 34,"ledger_sub_account_id"=>$ledger_sub_account_id,"user_id" => $s_user_id, "transaction_date" => $current_date,"current_date" => $current_date, "credit" => null,'debit'=>$amount, "remark" => "Receipt canceled due to cheque bounce" ,"society_id" => $s_society_id,'voucher_id'=>$voucher_id));
	$this->journal->saveAll($multipleRowData);
	
	$this->loadmodel('ledger');
	$auto_id=$this->autoincrement('ledger','auto_id');
	$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 34,"ledger_sub_account_id" =>$ledger_sub_account_id,"debit"=>$amount,"credit"=>null,"table_name"=>"journal","element_id"=>$journal_id,"society_id"=>$s_society_id,"transaction_date"=>$current_date));
	
	$journal_id=$this->autoincrement('journal','journal_id');
	$this->loadmodel('journal');
	$multipleRowData = Array( Array("journal_id" => $journal_id,"ledger_account_id" => 33,"ledger_sub_account_id"=>$deposited_bank_id,"user_id" => $s_user_id, "transaction_date" => $current_date,"current_date" => $current_date, "credit" => $amount,'debit'=>null, "remark" => "Receipt canceled due to cheque bounce" ,"society_id" => $s_society_id,'voucher_id'=>$voucher_id));
	$this->journal->saveAll($multipleRowData);
	
	$this->loadmodel('ledger');
	$auto_id=$this->autoincrement('ledger','auto_id');
	$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 33,"ledger_sub_account_id" =>$deposited_bank_id,"debit"=>null,"credit"=>$amount,"table_name"=>"journal","element_id"=>$journal_id,"society_id"=>$s_society_id,"transaction_date"=>$current_date));
	
	$this->loadmodel('new_cash_bank');
	$this->new_cash_bank->updateAll(array('narration'=>'Receipt canceled due to cheque bounce','is_cancel'=>'YES'),array("transaction_id"=>(int)$record_id));	
	
	
	
	
	
	//APPLY RECEIPT
	$this->loadmodel('new_cash_bank');
	$condition=array('society_id'=>$s_society_id,"flat_id"=>$flat_id,"bill_one_time_id"=>$bill_one_time_id,"edit_status"=>"NO","is_cancel"=>"NO");
	$result_new_cash_bank=$this->new_cash_bank->find('all',array('conditions'=>$condition));
	
	
	$q=0; foreach($result_new_cash_bank as $cash_bank){ $q++;
		$amount=$cash_bank["new_cash_bank"]["amount"];
		
		
		$this->loadmodel('new_regular_bill');
		$condition=array("flat_id"=>$flat_id,"edit_status"=>"NO","one_time_id"=>$bill_one_time_id);
		$result_new_regular_bill=$this->new_regular_bill->find('all',array('conditions'=>$condition)); 
		
		 foreach($result_new_regular_bill as $bill_data){ 
			$bill_auto_id=$bill_data["new_regular_bill"]["auto_id"];
			
			if($q==1){
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
		$this->new_regular_bill->updateAll(array('new_arrear_intrest'=>$new_arrear_intrest,"new_intrest_on_arrears"=>$new_intrest_on_arrears,"new_arrear_maintenance"=>$new_arrear_maintenance,"new_total"=>$new_total),array('auto_id'=>(int)$bill_auto_id));
	}
	
	if(sizeof($result_new_cash_bank)==0){
		$this->loadmodel('new_regular_bill');
		$this->new_regular_bill->updateAll(array('new_arrear_intrest'=>null,"new_intrest_on_arrears"=>null,"new_arrear_maintenance"=>null,"new_total"=>null),array('auto_id'=>(int)$record_id));
	}
	
	
	
	?>
	<button type="button" class="close" id="close_model" ></button>
	<div style="font-size: 14px;">
		<strong>Success!</strong> <span>Receipt canceled successfully.</span>
	</div>
	<?php
}
//////////////////////// Start bank receipt ///////////////////////////////////////////////////////////
function bank_receipt()
{
		if($this->RequestHandler->isAjax())
		{
		$this->layout='blank';
		}else{
		$this->layout='session';
		}
$s_society_id=(int)$this->Session->read('society_id');
		$this->ath();

    $credit_dc=0; $debit_dc=0;
	//$this->loadmodel('ledger_sub_account');
	//$conditions=array('society_id'=>$s_society_id,'ledger_id'=>34);	
	//$aaaa=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
	//foreach($aaaa as $dataa)
	//{
	//$bank_id = (int)$dataa['ledger_sub_account']['auto_id'];	
	
    $this->loadmodel('ledger');
	$conditions2=array('society_id'=>$s_society_id,'ledger_account_id'=>34);	
	$ledger_result_dc=$this->ledger->find('all',array('conditions'=>$conditions2));
	
	foreach($ledger_result_dc as $data_dc){
		$debit_dc+=$data_dc["ledger"]["debit"];
		$credit_dc+=$data_dc["ledger"]["credit"];
}
	echo $credit_dc;
	exit;


/*
$this->loadmodel('new_cash_bank');
$conditions=array('society_id'=>$s_society_id,"receipt_source"=>1);	
$aaaa=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
foreach($aaaa as $dataa)
{
$element = (int)$dataa['new_cash_bank']['transaction_id'];
$n=0;
$this->loadmodel('ledger');
$conditions=array('society_id'=>$s_society_id,"element_id"=>$element,"table_name"=>"new_cash_bank");	
$aaaaa=$this->ledger->find('all',array('conditions'=>$conditions));
foreach($aaaaa as $dataaa)
{
$n++;	
}
if($n == 3)
{
echo "three";
break;	
}	
}
echo"sdgdsg";
exit;

*/






}
//////////////////////// End bank receipt email code ////////////////////////////////////////////

////////////////// Start Bank receipt Excel (Accounts)/////////////////////////////
function bank_receipt_excel()
{
$this->layout="";
$this->ath();

$s_society_id = (int)$this->Session->read('society_id');
$s_role_id= (int)$this->Session->read('role_id');
$s_user_id= (int)$this->Session->read('user_id');

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
}

$from = $this->request->query('f');
$to = $this->request->query('t');

$fdddd = date('d-M-Y',strtotime($from));
$tdddd = date('d-M-Y',strtotime($to));

$socc_namm = str_replace(' ', '_', $society_name);

$filename="".$socc_namm."_Bank_Receipt_Register_".$fdddd."_".$tdddd."";

header ("Expires: 0");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls");
header ("Content-Description: Generated Report" );



$m_from = date("Y-m-d", strtotime($from));
$m_from = strtotime($m_from);
$m_to = date("Y-m-d", strtotime($to));
$m_to = strtotime($m_to);

$s_society_id = (int)$this->Session->read('society_id');
$s_role_id= (int)$this->Session->read('role_id');
$s_user_id= (int)$this->Session->read('user_id');

$excel="<table border='1'>
</tr>
<tr>
<th colspan='10'>$society_name Bank Receipt Register From : $from &nbsp;&nbsp; To : $to </th>
</tr>
<tr>
<th>Receipt#</th>
<th>Receipt Date </th>
<th>Receipt Type</th>
<th>Party Name</th>
<th>Unit Detail</th>
<th>Payment Mode</th>
<th>Instrument/UTR</th>
<th>Deposit Bank</th>
<th>Narration</th>
<th>Amount</th>
</tr>";
  
		$total_credit = 0;
		$total_debit = 0;
		$n=0;
	$this->loadmodel('new_cash_bank');
	$order=array('new_cash_bank.receipt_date'=> 'ASC');
	$conditions=array('society_id'=>$s_society_id,"receipt_source"=>1,"edit_status"=>"NO",'new_cash_bank.receipt_date'=>array('$gte'=>$m_from,'$lte'=>$m_to));
	$cursor2=$this->new_cash_bank->find('all',array('conditions'=>$conditions,'order'=>$order));	
	foreach ($cursor2 as $collection) 
	{
	$n++;
	$receipt_no = $collection['new_cash_bank']['receipt_id'];
	$receipt_mode = $collection['new_cash_bank']['receipt_mode'];
	$TransactionDate = $collection['new_cash_bank']['receipt_date'];
						
		if($receipt_mode == "Cheque")
		{
		$reference_utr = $collection['new_cash_bank']['cheque_number'];
		$cheque_date = $collection['new_cash_bank']['cheque_date'];
		$drawn_on_which_bank = $collection['new_cash_bank']['drawn_on_which_bank'];
		}
		else
		{
		$reference_utr = $collection['new_cash_bank']['reference_utr'];
		$cheque_date = $collection['new_cash_bank']['cheque_date'];
		$drawn_on_which_bank = "";
		}
	
	$member_type = $collection['new_cash_bank']['member_type'];
	$narration = @$collection['new_cash_bank']['narration'];
		if($member_type == 1)
		{
		$party_name_id = (int)$collection['new_cash_bank']['party_name_id'];
		$receipt_type = $collection['new_cash_bank']['receipt_type'];
			
			if($receipt_type == 1)
			{
			 $receipt_tppp = "Maintenance";	
			}
			else
			{
			 $receipt_tppp = "Other";	
			}
			
			
			
			
	$flatt_datta = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($party_name_id)));
	foreach ($flatt_datta as $fltt_datttaa) 
	{
	$wnngg_idddd = (int)$fltt_datttaa['flat']['wing_id'];
	}			
		
		$user_fetch = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_info_via_flat_id'),array(				'pass'=>array($wnngg_idddd,$party_name_id)));	
		foreach($user_fetch as $rrr)
		{
		$party_name = $rrr['user']['user_name'];	
		$wing_id = $rrr['user']['wing'];
		}
			
		$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'),array('pass'=>array($wing_id,$party_name_id)));
		}
		else
		{
		$receipt_tppp = "Non-Residential";
		$wing_flat = "";
		$party_name_id = (int)$collection['new_cash_bank']['party_name_id'];
		
		$ledger_subaccc = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($party_name_id)));
foreach ($ledger_subaccc as $dataaa) 
{
$party_name = $dataaa['ledger_sub_account']['name'];
}	
		$bill_reference = @$collection['new_cash_bank']['bill_reference'];	
		}
		

		$amount=$collection['new_cash_bank']['amount'];
		$flat_id = $collection['new_cash_bank']['flat_id'];
		$deposited_bank_id = (int)$collection['new_cash_bank']['deposited_bank_id'];
		$current_date = $collection['new_cash_bank']['current_date'];
		if($receipt_mode == "Cheque")
		{
		$receipt_mode = $receipt_mode;
		}
			
	$ledger_sub_account_fetch_result = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($deposited_bank_id)));			
	foreach($ledger_sub_account_fetch_result as $rrrr)
	{
	$deposited_bank_name = $rrrr['ledger_sub_account']['name'];	
	}			
	
		if($s_role_id == 3)
		{
		$TransactionDate = date('d-m-Y',$TransactionDate);
		$total_debit =  $total_debit + $amount; 
		if(empty($reference_utr))
		{
		$reference_utr = $reference_utr;
		} 
 
$excel.=" <tr>
<td>$receipt_no</td>
<td>$TransactionDate</td>
<td>$receipt_tppp</td>
<td>$party_name</td>
<td>$wing_flat</td>
<td>$receipt_mode - $drawn_on_which_bank</td>
<td>$reference_utr</td>
<td>$deposited_bank_name</td>
<td>$narration</td>
<td align='right'>";
$amount = number_format($amount);
$excel.="$amount</td>
</tr>";	

}
}
	
$excel.="<tr>
<td colspan='9' style='text-align:right;'><b>Total</b></td>
<td align='right'><b>";
$total_debit = number_format($total_debit);
$excel.="$total_debit</b></td>
</tr></table>";   
 
echo $excel; 
  
  


}
////////////////// End Bank receipt Excel (Accounts)/////////////////////////////

////////////////////////////////Start Bank Payment (Accounts)//////////////////////////
function bank_payment()
{
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

$this->set('s_role_id',$s_role_id);

$this->loadmodel('user');
$conditions=array("society_id" => $s_society_id,"user_id" => $s_user_id);
$cursor=$this->user->find('all',array('conditions'=>$conditions));
foreach ($cursor as $collection) 
{
$tenant_c = (int)$collection['user']['tenant'];
}
$this->set('tenant_c',$tenant_c);



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

$this->loadmodel('ledger_sub_account');
$conditions=array("society_id" => $s_society_id, "ledger_id" => 33);
$cursor2=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

$this->loadmodel('master_tds');
$cursor3=$this->master_tds->find('all');
$this->set('cursor3',$cursor3);

$this->loadmodel('reference');
$conditions=array("auto_id"=>3);
$cursor = $this->reference->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$tds_arr = $collection['reference']['reference'];
}
$this->set("tds_arr",$tds_arr);

if(isset($this->request->data['bank_payment_add']))
{
$date = $this->request->data['date'];
$date = date("Y-m-d", strtotime($date));
$paid_to = (int)$this->request->data['expense_ac'];
$invoice_reference = $this->request->data['invoice_reference'];
$description = $this->request->data['description']; 
$receipt_mode = $this->request->data['mode'];
$receipt_instruction = $this->request->data['instruction'];
$sub_account_id = (int)$this->request->data['bank_account'];
$amount = $this->request->data['ammount'];				
$tds_id = (int)$this->request->data['tds_p'];
$current_date = date("d-m-Y");		
$ac_type = (int)$this->request->data['ac_type'];

if($ac_type == 1)
{
$account_type = 1;
}
else if($ac_type == 2 || $ac_type == 3)
{
$account_type = 2;
}

$current_date = date("Y-m-d", strtotime($current_date));
$current_date = new MongoDate(strtotime($current_date)); 

///////////////////Start Insert //////////////////////////////////////

$this->loadmodel('cash_bank');
$conditions=array("society_id" => $s_society_id,"module_id"=>2);
$order=array('cash_bank.transaction_id'=> 'DESC');
$cursor=$this->cash_bank->find('all',array('conditions'=>$conditions,'order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last11 = $collection['cash_bank']['transaction_id'];
$last12 = $collection['cash_bank']['receipt_id'];
}
if(empty($last11))
{
$i=0;
$bbb = 1000;
}	
else
{	
$i=$last11;
$bbb = $last12;
}
$i++; 
$bbb++;
$this->loadmodel('cash_bank');
$multipleRowData = Array( Array("transaction_id" => $i, "receipt_id" => $bbb,  "current_date" => $current_date, 
"transaction_date" => strtotime($date), "prepaired_by" => $s_user_id, 
"user_id" => $paid_to, "invoice_reference" => $invoice_reference,"narration" => $description, "receipt_mode" => $receipt_mode,
"receipt_instruction" => $receipt_instruction, "account_head" => $sub_account_id,  
"amount" => $amount, "amount_category_id" => 1, "society_id" => $s_society_id, "tds_id" => $tds_id,"account_type" => $account_type,"module_id"=>2));
$this->cash_bank->saveAll($multipleRowData);  

//////////////////// End Insert///////////////////////////////
///////////// TDS CALCULATION /////////////////////
$this->loadmodel('master_tds');
$conditions=array("auto_id" => $tds_id);
$cursor4=$this->master_tds->find('all',array('conditions'=>$conditions));
foreach($cursor4 as $collection)
{
$tds_rate = (int)$collection['master_tds']['charge'];	
}

$tds_amount = (int)(round(($tds_rate/100)*$amount));
$total_tds_amount = (int)($amount - $tds_amount);
////////////END TDS CALCULATION //////////////////// 
////////////////START LEDGER ENTRY///////////////////////

$this->loadmodel('ledger');
$order=array('ledger.auto_id'=> 'DESC');
$cursor=$this->ledger->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last21 =$collection['ledger']['auto_id'];
}
if(empty($last21))
{
$k=0;
}	
else
{	
$k=$last21;
}
$k++; 
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $bbb, 
"amount" => $amount, "amount_category_id" => 1, "module_id" => 2, "account_type" => $account_type, "account_id" => $paid_to,
"current_date" => $current_date, "society_id" => $s_society_id,"table_name"=>"cash_bank","module_name"=>"Bank Payment"));
$this->ledger->saveAll($multipleRowData); 



$sub_account_id_a = (int)$sub_account_id;
$this->loadmodel('ledger');
$order=array('ledger.auto_id'=> 'DESC');
$cursor=$this->ledger->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last22=$collection['ledger']['auto_id'];
}
if(empty($last22))
{
$k=0;
}	
else
{	
$k=$last22;
}
$k++; 
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $bbb, 
"amount" => $total_tds_amount, "amount_category_id" => 2, "module_id" => 2, "account_type" => 1, "account_id" => $sub_account_id_a, "current_date" => $current_date, "society_id" => $s_society_id,"table_name"=>"cash_bank","module_name"=>"Bank Payment"));
$this->ledger->saveAll($multipleRowData); 

if($tds_amount > 0)
{
$sub_account_id_t = 16;
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
$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $bbb, 
"amount" => $tds_amount, "amount_category_id" => 2, "module_id" => 2, "account_type" => 2, "account_id" => $sub_account_id_t, "current_date" => $current_date, "society_id" => $s_society_id,"table_name"=>"cash_bank","module_name"=>"Bank Payment"));
$this->ledger->saveAll($multipleRowData);
}
//////////////////END LEDGER ENTRY/////////////////////
$this->loadmodel('cash_bank');
$conditions=array("society_id" => $s_society_id,"module_id"=>2);
$order=array('cash_bank.receipt_id'=> 'ASC');
$cursor1=$this->cash_bank->find('all',array('conditions'=>$conditions));
foreach ($cursor1 as $collection) 
{
$d_receipt_id = (int)$collection['cash_bank']['receipt_id'];	
}
?>

<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-header">
<center>
<h3 id="myModalLabel3" style="color:#999;"><b>Bank Payment</b></h3>
</center>
</div>
<div class="modal-body">
<center>
<h5><b>Payment Voucher No. <?php echo $d_receipt_id; ?> is  generated successfully</b></h5>
</center>
</div>
<div class="modal-footer">
<a href="bank_payment_view" class="btn blue">OK</a>
</div>
</div>
<?php
}

$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 15,"society_id"=>$s_society_id);
$cursor11=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor11',$cursor11);


$this->loadmodel('accounts_group');
$conditions=array("accounts_id" => 1);
$cursor12=$this->accounts_group->find('all',array('conditions'=>$conditions));
$this->set('cursor12',$cursor12);

$this->loadmodel('accounts_group');
$conditions=array("accounts_id" => 4);
$cursor13=$this->accounts_group->find('all',array('conditions'=>$conditions));
$this->set('cursor13',$cursor13);

}

/////////////////////////End Bank Payment(Accounts)///////////////////////////////////

//////////////////////// Start Bank Payment View (Accounts) ////////////////////////
function bank_payment_view()
{
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

$this->set('s_role_id',$s_role_id);
}
//////////////////////// End Bank Payment View (Accounts) ///////////////////////////

//////////////////////Start Bank Payment Show Ajax (Accounts)////////////////////////
function bank_payment_show_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->ath();

$this->set('s_role_id',$s_role_id);
$this->set('s_user_id',$s_user_id);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
}
$this->set('society_name',$society_name);

$from = $this->request->query('date1');
$to = $this->request->query('date2');
$this->set('from',$from);
$this->set('to',$to);

$this->loadmodel('bank_payment');
$conditions=array("society_id" => $s_society_id);
$cursor1=$this->bank_payment->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('new_cash_bank');
$conditions=array("society_id" => $s_society_id,"receipt_source"=>2);
$order=array('new_cash_bank.transaction_date'=> 'ASC');
$cursor2=$this->new_cash_bank->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('cursor2',$cursor2);

$this->loadmodel('reference');
$conditions=array("auto_id"=>3);
$cursor = $this->reference->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$tds_arr = $collection['reference']['reference'];
}
$this->set("tds_arr",$tds_arr);	


}
/////////////////////////////////////End Bank Payment Show Ajax (Accounts)////////////////////////////////////////

////////////////////////////// Start Bank Payment Excel //////////////////////////////
function bank_payment_excel()
{
$this->layout="";

$this->ath();

$s_society_id = (int)$this->Session->read('society_id');
$s_role_id=$this->Session->read('role_id');

$from = $this->request->query('f');
$to = $this->request->query('t');

$fdddd = date('d-M-Y',strtotime($from));
$tdddd = date('d-M-Y',strtotime($to));

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
}

$sss_namm = str_replace(' ','-',$society_name);

$filename="".$sss_namm."_Bank_Payment_Register_".$fdddd."_".$tdddd."";
header ("Expires: 0");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls");
header ("Content-Description: Generated Report" );

$from = $this->request->query('f');
$to = $this->request->query('t');

$m_from = date("Y-m-d", strtotime($from));
$m_from = strtotime($m_from);
$m_to = date("Y-m-d", strtotime($to));
$m_to = strtotime($m_to);

$s_society_id = (int)$this->Session->read('society_id');
$s_role_id=$this->Session->read('role_id');

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
}

$this->loadmodel('reference');
$conditions=array("auto_id"=>3);
$cursor = $this->reference->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$tds_arr = $collection['reference']['reference'];
}


$excel="<table border='1'>
<tr>
<th colspan='8'>$society_name Bank Payment Register From : $from &nbsp;&nbsp; To : $to</th>
</tr>
<tr>
<th>Transaction Date</th>
<th>Payment Voucher</th>
<th>Paid To</th>
<th>Invoice Ref</th>
<th>Paid By</th>
<th>Cheque/UTR</th>
<th>Bank Account </th>
<th>Amount(Rs.)</th>
</tr>";
		
	$total_credit = 0;
	$total_debit = 0;
		$this->loadmodel('new_cash_bank');
		$order=array('new_cash_bank.transaction_date'=> 'ASC');
		$conditions=array("society_id" => $s_society_id,"receipt_source"=>2);
		$cursor2=$this->new_cash_bank->find('all',array('conditions'=>$conditions,'order'=>$order));
		foreach ($cursor2 as $collection) 
		{
			$receipt_no = $collection['new_cash_bank']['receipt_id'];
			$transaction_id = (int)$collection['new_cash_bank']['transaction_id'];	
			$date = $collection['new_cash_bank']['transaction_date'];
			$prepaired_by_id = (int)$collection['new_cash_bank']['prepaired_by'];
			$user_id = (int)$collection['new_cash_bank']['user_id'];   
			$invoice_reference = $collection['new_cash_bank']['invoice_reference'];
			$description = $collection['new_cash_bank']['narration'];
			$receipt_mode = $collection['new_cash_bank']['receipt_mode'];
			$receipt_instruction = $collection['new_cash_bank']['receipt_instruction'];
			$account_id = (int)$collection['new_cash_bank']['account_head'];
			$amount = $collection['new_cash_bank']['amount'];
			$current_date = $collection['new_cash_bank']['current_date'];		
			$ac_type = $collection['new_cash_bank']['account_type'];
		    $tds_id = (int)$collection['new_cash_bank']['tds_id']; 

	foreach($tds_arr as $tds_ddd)
	{
	$tdsss_taxxx = (int)$tds_ddd[0];  
	$tds_iddd = (int)$tds_ddd[1];  
	if($tds_iddd == $tds_id) 
	{
	$tds_tax = $tdsss_taxxx;   
	}
	}
	
	$tds_amount = (round(($tds_tax/100)*$amount));
	$total_tds_amount = ($amount - $tds_amount);	






		
	//$creation_date = date('d-m-Y',strtotime($current_date));											
	if($ac_type == 1)
	{						
	$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($user_id)));  
	foreach ($result_lsa as $collection) 
	{
	$user_name = $collection['ledger_sub_account']['name'];  
	}	
	}											
		else if($ac_type == 2)
		{
		$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_head'),array('pass'=>array($user_id)));  
		foreach ($result_lsa as $collection) 
		{
		$user_name = $collection['ledger_account']['ledger_name'];  
		}	
		}											
			$result55 = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($prepaired_by_id)));
			foreach ($result55 as $collection) 										
			{
			$prepaired_by_name = $collection['user']['user_name'];
			}									 
				
		$result_lsa2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($account_id))); 					   
		foreach ($result_lsa2 as $collection) 
		{
		$account_no = $collection['ledger_sub_account']['bank_account'];  
		}    		
if($date >= $m_from && $date <= $m_to)
{
if($s_role_id == 3)
{
$date = date('d-m-Y',($date));
$total_debit =  $total_debit + $total_tds_amount; 
$total_tds_amount = number_format($total_tds_amount);

$excel.="<tr>
<td>$date</td>
<td>$receipt_no</td>
<td>$user_name</td>
<td>$invoice_reference</td>
<td>$receipt_mode</td>
<td>$receipt_instruction</td>
<td>$account_no</td>
<td>$total_tds_amount</td>
</tr>";
}
}
}	
$excel.="<tr>
<td colspan='7' style='text-align:right;'><b>Total</b></td>
<td><b>";
$total_debit = number_format($total_debit);
$excel.="$total_debit</b></td>
</tr>
</table>";		
		
echo $excel;

}

/////////////////////////// End Bank Payment Excel ///////////////////////////////

///////////////////// Start Petty cash Receipt (Accounts)///////////////////////////
function petty_cash_receipt()
{
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

$this->set('s_role_id',$s_role_id);


$this->loadmodel('user');
$conditions=array("society_id" => $s_society_id,"user_id" => $s_user_id);
$cursor=$this->user->find('all',array('conditions'=>$conditions));
foreach ($cursor as $collection) 
{
$tenant_c = (int)$collection['user']['tenant'];
}
$this->set('tenant_c',$tenant_c);


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







$this->loadmodel('cash_bank');
$conditions=array("society_id" => $s_society_id,"module_id"=>3);
$order=array('cash_bank.receipt_id'=> 'DESC');
$cursor=$this->cash_bank->find('all',array('conditions'=>$conditions,'order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last=$collection['cash_bank']['receipt_id'];
}
if(empty($last))
{
$zz=0;
}	
else
{	
$zz=$last;
}
$this->set('zz',$zz);


///////////////////////////////////////////
//////////////////////////////////////////
if(isset($this->request->data['ptr_sasdadd']))
{
$date = $this->request->data['date'];
$date = date("Y-m-d", strtotime($date));
$date = new MongoDate(strtotime($date));

$user_id = (int)$this->request->data['user_id'];
$narration = $this->request->data['narration']; 
$account_head = (int)$this->request->data['account_head'];
$ammount = $this->request->data['ammount'];
$current_date = date("d-m-Y");
$account_type = (int)$this->request->data['type'];

$current_date = date("Y-m-d", strtotime($current_date));
$current_date = new MongoDate(strtotime($current_date));


$this->loadmodel('cash_bank');
$conditions=array("society_id" => $s_society_id,"module_id"=>3);
$order=array('cash_bank.transaction_id'=> 'DESC');
$cursor=$this->cash_bank->find('all',array('conditions'=>$conditions,'order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last11 = $collection['cash_bank']['transaction_id'];
$last22 = $collection['cash_bank']['receipt_id'];
}
if(empty($last11))
{
$auto=0;
$i = 1000;
}	
else
{	
$auto = $last11;
$i = $last22;
}
$auto++;
$i++; 
$this->loadmodel('cash_bank');
$multipleRowData = Array( Array("transaction_id" => $auto, "receipt_id" => $i, "prepaired_by" => $s_user_id,
"current_date" => $current_date, "account_type" => $account_type,"transaction_date" => $date, "user_id" => $user_id, 
"narration" => $narration, "account_head" => $account_head,  "amount" => $ammount, "amount_category_id" => 1, 
"society_id" => $s_society_id,"module_id"=>3));
$this->cash_bank->saveAll($multipleRowData);  


$this->loadmodel('ledger');
$order=array('ledger.auto_id'=> 'DESC');
$cursor=$this->ledger->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last21=$collection['ledger']['auto_id'];
}
if(empty($last21))
{
$k=0;
}	
else
{	
$k=$last21;
}
$k++; 
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $i, 
"amount" => $ammount, "amount_category_id" => 2, "module_id" => 3, "account_type" => $account_type, "account_id" => $user_id, "current_date" => $current_date, "society_id" => $s_society_id,"table_name"=>"cash_bank","module_name"=>"Petty Cash Receipt"));
$this->ledger->saveAll($multipleRowData); 




$sub_account_id_a = (int)$account_head;


$this->loadmodel('ledger');
$order=array('ledger.auto_id'=> 'DESC');
$cursor=$this->ledger->find('all',array('order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last22=$collection['ledger']['auto_id'];
}
if(empty($last22))
{
$k=0;
}	
else
{	
$k=$last22;
}
$k++; 
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $i, 
"amount" => $ammount, "amount_category_id" => 1, "module_id" => 3, "account_type" => 2, "account_id" => $sub_account_id_a, "current_date" => $current_date, "society_id" => $s_society_id,"table_name"=>"cash_bank","module_name"=>"Petty Cash Receipt"));
$this->ledger->saveAll($multipleRowData); 


$this->loadmodel('cash_bank');
$conditions=array("society_id" => $s_society_id,"module_id"=>3);
$order=array('cash_bank.receipt_id'=> 'ASC');
$cursor1=$this->cash_bank->find('all',array('conditions'=>$conditions));
foreach ($cursor1 as $collection) 
{
$d_receipt_id = (int)$collection['cash_bank']['receipt_id'];	 
}
?>
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-header">
<center>
<h3 id="myModalLabel3" style="color:#999;"><b>Petty Cash Receipt</b></h3>
</center>
</div>
<div class="modal-body">
<center>
<h5><b>Receipt No. <?php echo $d_receipt_id; ?> is  Generated Successfully</b></h5>
</center>
</div>
<div class="modal-footer">
<a href="petty_cash_receipt_view" class="btn blue">OK</a>
</div>
</div>

<?php
}
}
////////////////////// End Petty Cash Receipt (Accounts) //////////////////////////////

///////////////// Start Petty Cash Receipt Show Ajax (Accounts)////////////////////////

function petty_cash_receipt_show_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->ath();

$this->set('s_society_id',$s_society_id);
$this->set('s_role_id',$s_role_id);
$this->set('s_user_id',$s_user_id);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
}
$this->set('society_name',$society_name);


$from = $this->request->query('date1');
$to = $this->request->query('date2');

$this->set('from',$from);
$this->set('to',$to);



$this->loadmodel('new_cash_bank');
$order=array('new_cash_bank.transaction_date'=> 'ASC');
$conditions=array("society_id" => $s_society_id,"receipt_source"=>3);
$cursor1=$this->new_cash_bank->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('cursor1',$cursor1);
}

//////////////////////////////////// End Petty Cash Receipt Show Ajax (Accounts)///////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////// Start Petty Cash Receipt View (Accounts)//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function petty_cash_receipt_view()
{
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

$this->set('s_role_id',$s_role_id);




}

//////////////////////////////////////////////////////////End Petty Cash Receipt View (Accounts) ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////// Start Petty cash receipt excel /////////////////////////////
function petty_cash_receipt_excel()
{
	$this->layout="";
	$this->ath();

	$s_society_id = (int)$this->Session->read('society_id');
	$s_role_id = (int)$this->Session->read('role_id');

		$this->loadmodel('society');
		$conditions=array("society_id" => $s_society_id);
		$cursor = $this->society->find('all',array('conditions'=>$conditions));
		foreach ($cursor as $collection) 
		{
		$society_name = $collection['society']['society_name'];
		}	
	
		$from = $this->request->query('f');
		$to = $this->request->query('t');
	
	$fdddd = date('d-M-Y',strtotime($from));
	$tdddd = date('d-M-Y',strtotime($to));
$socitty_nammm = str_replace(' ','-',$society_name);
	
	$filename="".$socitty_nammm."_Petty_Cash_Receipt_Register_".$fdddd."_".$tdddd."";
	header ("Expires: 0");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/vnd.ms-excel");
	header ("Content-Disposition: attachment; filename=".$filename.".xls");
	header ("Content-Description: Generated Report" );

	$s_society_id = (int)$this->Session->read('society_id');
	$s_role_id = (int)$this->Session->read('role_id');

		$this->loadmodel('society');
		$conditions=array("society_id" => $s_society_id);
		$cursor = $this->society->find('all',array('conditions'=>$conditions));
		foreach ($cursor as $collection) 
		{
		$society_name = $collection['society']['society_name'];
		}
			$from = $this->request->query('f');
			$to = $this->request->query('t');

	$m_from = 	date('Y-m-d',strtotime($from));
	$m_to = date('Y-m-d',strtotime($to));
		
		$from_strto = strtotime($m_from);
		$to_strto = strtotime($m_to);

$excel = "<table border='1'>  
<tr>
<th colspan='5'>$society_name Petty Cash Receipt Register From :$from &nbsp;&nbsp; To : $to</th>
</tr>
<tr>
<th>PC Receipt#</th>
<th>Transaction Date</th>
<th>Received From</th>
<th>Amount</th>
<th>Narration</th>
</tr>";
		$total_debit = 0;
	$this->loadmodel('new_cash_bank');
	$order=array('new_cash_bank.transaction_date'=> 'ASC');
	$conditions=array("society_id" => $s_society_id,"receipt_source"=>3);
	$bank_rrr_data=$this->new_cash_bank->find('all',array('conditions'=>$conditions,'order'=>$order));
	foreach($bank_rrr_data as $bank_dataaaa)
	{
		$receipt_no = @$bank_dataaaa['new_cash_bank']['receipt_id'];
		$transaction_id = (int)$bank_dataaaa['new_cash_bank']['transaction_id'];	
		$account_type = (int)$bank_dataaaa['new_cash_bank']['account_type'];    									  
		$d_user_id = (int)$bank_dataaaa['new_cash_bank']['user_id'];
		$receipt_date = $bank_dataaaa['new_cash_bank']['transaction_date'];
		$prepaired_by = (int)$bank_dataaaa['new_cash_bank']['prepaired_by'];   
		$narration = @$bank_dataaaa['new_cash_bank']['narration'];
		$account_head = $bank_dataaaa['new_cash_bank']['account_head'];
		$amount = $bank_dataaaa['new_cash_bank']['amount'];
		$prepaired_by = (int)$bank_dataaaa['new_cash_bank']['prepaired_by'];   
		$current_date = $bank_dataaaa['new_cash_bank']['current_date'];
		//$creation_date = date('d-m-Y',$current_date->sec);


		
	$result_gh = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($prepaired_by)));
	foreach ($result_gh as $collection) 
	{
	$prepaired_by_name = (int)$collection['user']['user_name'];
	}			

	if($account_type == 1)
	{
		$user_id1 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($d_user_id)));
		foreach ($user_id1 as $collection)
		{
		$user_id = $collection['ledger_sub_account']['user_id'];
		$flat_id = (int)$collection['ledger_sub_account']['flat_id'];
		}
			
$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
foreach($result_flat_info as $flat_info){
$wing=$flat_info["flat"]["wing_id"];
} 				
			
			$result = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user_id)));
			foreach ($result as $collection) 
			{
			$user_name = $collection['user']['user_name'];
			$tenant = (int)$collection['user']['tenant'];
			}	
			$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing,$flat_id)));
	}

	if($account_type == 2)
	{
	$user_name1 = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_amount'),array('pass'=>array($d_user_id)));
	foreach ($user_name1 as $collection)
	{
	$user_name = $collection['ledger_account']['ledger_name'];
	$wing_flat = "";
	}
	}
		
	$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($prepaired_by)));
	foreach ($result2 as $collection) 
	{
	$prepaired_by_name = $collection['user']['user_name'];   
	$society_id = $collection['user']['society_id'];  	
	}	
	
		if($receipt_date >= $from_strto && $receipt_date <= $to_strto)
		{
		if($s_role_id == 3)
		{
			$date2 = date('d-m-Y',($receipt_date));  
			$total_debit = $total_debit + $amount;
			$amount = number_format($amount);
			$excel.="<tr>
			<td>$receipt_no</td>
			<td>$date2</td>
			<td>$user_name &nbsp;&nbsp;&nbsp;&nbsp; $wing_flat</td>
			<td>$amount</td>
			<td>$narration</td>
			</tr>";	
		}
		}
	}
	
$excel.="<tr>
<td colspan='3' style='text-align:right;'><b>Total</b></td>
<td><b>";
$total_debit = number_format($total_debit);
$excel.="$total_debit</b></td> 
<td></td> 
</tr>
</table>"; 

echo $excel;
}
/////////////////////// End Petty cash receipt excel /////////////////////////////

////////////////////////////////Start Petty Cash Receipt Ajax (Accounts)///////////////////////////////////
function petty_cash_receipt_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->set('s_role_id',$s_role_id);

$value = (int)$this->request->query('value');
$ussidd = (int)@$this->request->query('ussidd');
$this->set('value',$value);
$this->set('ussidd',$ussidd);

$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 34, "society_id" => $s_society_id,"deactive"=>0);
$cursor1=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('ledger_account');
$conditions=array("group_id" => 8);
$cursor2=$this->ledger_account->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

}

////////////////////////////End Petty Cash Receipt Ajax (Accounts)///////////////////////////////////////////////

///////////////////////////// Start Petty cash Receipt Pdf (Accounts)///////////////////////////////////////////
function petty_cash_receipt_pdf()
{
$this->layout = 'pdf'; //this will use the pdf.ctp layout 
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$tns_id = (int)$this->request->query('c');
$this->set('tns_id',$tns_id);


$this->loadmodel('new_cash_bank');
$conditions=array("transaction_id" => $tns_id,"receipt_source"=>3,"society_id"=>$s_society_id);
$cursor1=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

}
/////////////////////////// End Petty cash Receipt Pdf (Accounts)//////////////////////////////////////////////////

/////////////////////// Start Petty Cash Payment (Accounts) /////////////////////////// 
function petty_cash_payment()
{
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

$this->set('s_role_id',$s_role_id);

$this->loadmodel('user');
$conditions=array("society_id" => $s_society_id,"user_id" => $s_user_id);
$cursor=$this->user->find('all',array('conditions'=>$conditions));
foreach ($cursor as $collection) 
{
$tenant_c = (int)$collection['user']['tenant'];
}
$this->set('tenant_c',$tenant_c);

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


$this->loadmodel('cash_bank');
$conditions=array("society_id" => $s_society_id,"module_id"=>4);
$order=array('cash_bank.receipt_id'=> 'DESC');
$cursor=$this->cash_bank->find('all',array('conditions'=>$conditions,'order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last=$collection['cash_bank']['receipt_id'];
}
if(empty($last))
{
$zz=0;
}	
else
{	
$zz=$last;
}
$this->set('zz',$zz);



$this->loadmodel('master_tds');
$cursor1=$this->master_tds->find('all');
$this->set('cursor1',$cursor1);

//////////////////////////////////////////////////
//////////////////////////////////////////////////
if(isset($this->request->data['ptp_add']))
{

$date = $this->request->data['date'];
$date = date("Y-m-d", strtotime($date));
//$date = new MongoDate(strtotime($date));
$user_id = (int)$this->request->data['user_id'];
$narration = $this->request->data['narration']; 
$account_head = (int)$this->request->data['account_head'];
$amount = $this->request->data['ammount'];
$current_date = date("d-m-Y");
//$tds_id = (int)$this->request->data['tds_pp'];
$account_type = (int)$this->request->data['type'];

$current_date = date("Y-m-d", strtotime($current_date));
$current_date = new MongoDate(strtotime($current_date));



$this->loadmodel('new_cash_bank');
$conditions=array("society_id" => $s_society_id,"receipt_source"=>4);
$order=array('new_cash_bank.transaction_id'=> 'DESC');
$cursor=$this->new_cash_bank->find('all',array('conditions'=>$conditions,'order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last11 = $collection['new_cash_bank']['transaction_id'];
$last12 = $collection['new_cash_bank']['receipt_id'];
}
if(empty($last11))
{
$auto=0;
$i = 1000;
}	
else
{	
$auto=$last11;
$i = $last12;
}
$auto++; 
$i++;
$this->loadmodel('new_cash_bank');
$multipleRowData = Array( Array("transaction_id" => $auto, "receipt_id" => $i,  "user_id" => $user_id, 
"current_date" => $current_date, "account_type" => $account_type,"transaction_date" => strtotime($date), "prepaired_by" => $s_user_id,"narration" => $narration, "account_head" => $account_head,  "amount" => $amount,"society_id" => $s_society_id,"receipt_source"=>4));
$this->new_cash_bank->saveAll($multipleRowData);  

/* $this->loadmodel('master_tds');
$conditions=array("auto_id" => $tds_id);
$cursor2=$this->master_tds->find('all',array('conditions'=>$conditions));
foreach($cursor2 as $collection)
{
$tds_rate = (int)$collection['master_tds']['charge'];
}
$tds_amount = (int)(round(($tds_rate/100)*$amount));
$total_tds_amount = (int)($amount - $tds_amount);
*/
if($account_type == 1)
{
$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l,"transaction_date"=>strtotime($date), "debit" => $amount, "credit" =>null,"ledger_account_id" => 15, "ledger_sub_account_id" =>$user_id, "table_name" =>"new_cash_bank","element_id" => $auto, "society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData);
}
else
{
$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l,"transaction_date"=>strtotime($date), "debit" => $amount, "credit" =>null,"ledger_account_id" =>$user_id, "ledger_sub_account_id" =>null,"table_name" =>"new_cash_bank","element_id" => $auto, "society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData);
}

$sub_account_id_a =  (int)$account_head;

$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l,"transaction_date"=>strtotime($date), "debit" => null, "credit" =>$amount,"ledger_account_id" =>$sub_account_id_a,"ledger_sub_account_id" =>null,"table_name" =>"new_cash_bank","element_id" => $auto, "society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData);


$this->loadmodel('new_cash_bank');
$conditions=array("society_id" => $s_society_id,"receipt_source"=>4);
$order=array('new_cash_bank.receipt_id'=> 'ASC');
$cursor3=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
foreach($cursor3 as $collection)
{
$d_receipt_id = (int)$collection['new_cash_bank']['receipt_id'];		
}
?>

<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">

<p style="font-size:15px; font-weight:600;">Petty Cash Voucher <?php echo $d_receipt_id; ?> is  generated successfully</p>
</div>
<div class="modal-footer">
<a href="petty_cash_payment_view" class="btn green">OK</a>
</div>
</div>

<?php
}
///////////////////////////////////////////
//////////////////////////////////////////
}

//////////////////////// End Petty cash Payment (Accounts) ////////////////////////////

////////////////////////////////////////////////////////// Start Petty cash Payment View (Accounts)/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function petty_cash_payment_view()
{
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

$this->set('s_role_id',$s_role_id);

}

/////////////////////////////////// End Petty cash Payment View (Accounts) ///////////////////////////////////

///////////////////////Start Petty Cash Payment Show Ajax (Accounts)/////////////////////
function petty_cash_payment_show_ajax()
{
$this->layout='blank';

$this->ath();
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
}
$this->set('society_name',$society_name);

$this->set('s_user_id',$s_user_id);
$this->set('s_role_id',$s_role_id);

$from = $this->request->query('date1');
$to = $this->request->query('date2');

$this->set('from',$from);
$this->set('to',$to);

$this->loadmodel('new_cash_bank');
$conditions=array("society_id" => $s_society_id,"receipt_source"=>4);
$order=array('new_cash_bank.transaction_date'=>'ASC');
$cursor1=$this->new_cash_bank->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('cursor1',$cursor1);

}
////////////////////////End Petty Cash Payment Show Ajax (Accounts)//////////////////////

//////////////////////////////////////////// Start Petty Cash Payment Pdf (Accounts)////////////////////////////////////////////////////////////////////
function petty_cash_payment_pdf()
{
$this->layout = 'pdf'; //this will use the pdf.ctp layout 
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$module_id = (int)$this->request->query('m');
$tns_id = (int)$this->request->query('c');
$this->set('tns_id',$tns_id);
$this->set('module_id',$module_id);


$this->loadmodel('cash_bank');
$conditions=array("transaction_id" => $tns_id,"module_id"=>4);
$cursor1=$this->cash_bank->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);


$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

}
///////////////////////////////// End Petty Cash Payment Pdf (Accounts)//////////////////////

//////////////////////Start Petty Cash Payment Ajax (Accounts) ////////////////////////////////
function petty_cash_payment_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->set('s_role_id',$s_role_id);

$value1 = (int)$this->request->query('value1');
$ussidd = (int)@$this->request->query('usdd');
$this->set('value1',$value1);
$this->set('ussidd',$ussidd);

$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 15,"society_id"=>$s_society_id);
$cursor1=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('accounts_group');
$conditions=array("accounts_id" => 4);
$cursor2=$this->accounts_group->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);
}
///////////////////////////////////////End Petty Cash Payment Ajax (Accounts) ////////////////////////////////

/////////////////////// Start Petty Cash Payment Excel//////////////////////////////
function petty_cash_payment_excel()
{
$this->layout="";

$this->ath();
$s_society_id = (int)$this->Session->read('society_id');
$s_role_id=$this->Session->read('role_id');
$s_user_id = (int)$this->Session->read('user_id');

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach ($cursor as $collection) 
{
$society_name = $collection['society']['society_name'];
}

$from = $this->request->query('f');
$to = $this->request->query('t');

$fdddd = date('d-M-Y',strtotime($from));
$tdddd = date('d-M-Y',strtotime($to));

$socitty_nammm = str_replace(' ','-',$society_name);

$filename="".$socitty_nammm."_Petty_Cash_Payment_Register_".$fdddd."_".$tdddd."";

header ("Expires: 0");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls");
header ("Content-Description: Generated Report" );



$m_from = date("Y-m-d", strtotime($from));
$m_from = strtotime($m_from);
$m_to = date("Y-m-d", strtotime($to));
$m_to = strtotime($m_to);

$excel="<table border='1'>
<tr>
<th colspan='5' style='text-align:center;'>
$society_name Petty Cash Payment Register From : $from To : $to
</th>
</tr>
<tr>
<th>PC Payment Vochure</th>
<th>Transaction Date</th>
<th>Paid To</th>
<th>Narration</th>
<th>Amount</th>
</tr>";
									
$total_debit = 0;
$total_credit = 0;
$this->loadmodel('new_cash_bank');
$order=array('new_cash_bank.transaction_date'=> 'ASC');
$conditions=array("society_id" => $s_society_id,"receipt_source"=>4);
$cursor = $this->new_cash_bank->find('all',array('conditions'=>$conditions,'order'=>$order));
foreach ($cursor as $collection) 
{
$receipt_no = (int)@$collection['new_cash_bank']['receipt_id'];
$transaction_id = (int)$collection['new_cash_bank']['transaction_id'];	
$account_type = (int)$collection['new_cash_bank']['account_type'];
$user_id = (int)$collection['new_cash_bank']['user_id'];
$date = $collection['new_cash_bank']['transaction_date'];
$prepaired_by = (int)$collection['new_cash_bank']['prepaired_by'];   
$narration = $collection['new_cash_bank']['narration'];
$account_head = $collection['new_cash_bank']['account_head'];
$amount = $collection['new_cash_bank']['amount'];
//$amount_category_id = (int)$collection['cash_bank']['amount_category_id'];
$current_date = $collection['new_cash_bank']['current_date'];
$creation_date = date('d-m-Y',strtotime($current_date));										
										
$result_gh = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($prepaired_by)));
foreach ($result_gh as $collection) 
{
$prepaired_by_name = $collection['user']['user_name'];
}			
if($account_type == 1)
{
$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($user_id)));
foreach ($result_lsa as $collection) 
{
$user_name = $collection['ledger_sub_account']['name'];	  
}
}										
else if($account_type == 2)
{
$result_la = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_amount'),array('pass'=>array($user_id)));
foreach ($result_la as $collection) 
{
$user_name = $collection['ledger_account']['ledger_name'];	  
}
}   										

if($date >= $m_from && $date <= $m_to)
{
if($s_role_id == 3)
{
$date = date('d-m-Y',($date));     
$total_debit = $total_debit + $amount;

$excel.="<tr>
<td>$receipt_no</td>
<td>$date</td>
<td>$user_name</td>
<td>$narration</td>
<td>$amount</td>
</tr>";
}}}

$excel.="<tr>
<th colspan='4' style='text-align:right;'>Total</th>
<th>$total_debit</th>
</tr>
</table>";

echo $excel;
}
/////////////////////// End Petty Cash Payment Excel////////////////////////////////

///////////////////////////// Start Bank receipt Reference Ajax (Accounts)/////////////////////////////////////////
function bank_receipt_reference_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->ath();

$flat_id = (int)$this->request->query('flat');
$type = (int)$this->request->query('rf');
$this->set('type',$type);
$this->set('flat_id',$flat_id);
}

/////////////////////End Bank Receipt Reference Ajax (Accounts)///////////////////////////////////////////

/////////////////////////////// Start Bank Receipt Amount Ajax(Accounts)///////////////////////////////////
function bank_receipt_amount_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$i_head = $this->request->query('ss');
$this->set('i_head',$i_head);

}

////////////////////////////// End Bank Receipt Amount Ajax(Accounts)/////////////////////////////////////

/////////////////////////// Start Bank Receipt Pdf (Accounts)//////////////////////////////////////
function bank_receipt_pdf($auto_id=null)
{
$this->layout = 'pdf'; //this will use the pdf.ctp layout 

$this->ath();

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$auto_id = (int)$auto_id;

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');	


$this->loadmodel('new_cash_bank');
$conditions=array("transaction_id" => $auto_id,"receipt_source"=>1,"society_id"=>$s_society_id);
$cursor1=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

}

function b_receipt_view()
{
$this->layout = 'session'; //this will use the pdf.ctp layout 
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$this->ath();

$module_id = (int)$this->request->query('m');
$trns_id = (int)$this->request->query('c');
$this->set('trns_id',$trns_id);
$this->set('module_id',$module_id);

$this->loadmodel('cash_bank');
$conditions=array("transaction_id" => $trns_id,"module_id"=>$module_id);
$cursor1=$this->cash_bank->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);



$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);



}

function b_receipt_edit($transaction_id=null){
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	$s_role_id = (int)$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id = (int)$this->Session->read('user_id');	

	
	$this->ath();
	
	$this->loadmodel('ledger_sub_account');
	$conditions=array("ledger_id" => 33,"society_id"=>$s_society_id);
	$cursor3=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
	$this->set('cursor3',$cursor3);

	$this->loadmodel('new_cash_bank');
	$conditions=array("transaction_id"=>(int)$transaction_id,"society_id"=>$s_society_id);
	$cursor1=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
	$this->set('cursor1',$cursor1);
	foreach($cursor1 as $receipt_data){
		$receipt_id=$receipt_data["new_cash_bank"]["receipt_id"];
		$receipt_id=$receipt_id.'-R';
		$bill_one_time_id=$receipt_data["new_cash_bank"]["bill_one_time_id"];
	}
	
	if(isset($this->request->data['bank_receipt_update'])){
		$tranjection_date = $this->request->data['transaction_date']; 
		$tranjection_date=date('Y-m-d',strtotime($tranjection_date));
		$deposited_bank_id = (int)$this->request->data['deposited_bank_id'];
		$receipt_mode = $this->request->data['receipt_mode'];
		
		$cheque_number = null;
		$cheque_date = null;
		$drawn_on_which_bank = null;
		$reference_utr = null;
		if($receipt_mode=="Cheque"){
			$cheque_number = @$this->request->data['cheque_number'];
			$cheque_date = @$this->request->data['cheque_date1'];
			$drawn_on_which_bank = @$this->request->data['drawn_on_which_bank'];
		}
		if($receipt_mode=="NEFT" or $receipt_mode=="PG"){
			$reference_utr = @$this->request->data['reference_number'];
			$cheque_date = @$this->request->data['neft_date'];
		}
		$member_type = @$this->request->data['member_type'];
		
		$party_name = null;
		$bill_reference = null;
		$receipt_type = null;
		$resident_flat_id = null;
		if($member_type==1){
			$receipt_type = @$this->request->data['receipt_type'];
			if($receipt_type==1){
				
			}
			$resident_flat_id = (int)@$this->request->data['resident_flat_id'];
		}
		if($member_type==2){
			$party_name = @$this->request->data['party_name'];
			$bill_reference = @$this->request->data['bill_reference'];
		}
		$amount = @$this->request->data['amount'];
		$narration = @$this->request->data['description'];
	
		$current_date = date('Y-m-d');
		
		$this->loadmodel('new_cash_bank');
		$this->new_cash_bank->updateAll(array('edit_status'=>'YES'),array("transaction_id"=>(int)$transaction_id));	
		
		$this->loadmodel('new_cash_bank');
		$new_new_cash_bank_auto_id=$this->autoincrement('new_cash_bank','transaction_id');
		$this->new_cash_bank->saveAll(array('transaction_id'=>$new_new_cash_bank_auto_id,'receipt_date'=>strtotime($tranjection_date),"deposited_bank_id"=>$deposited_bank_id,"receipt_mode"=>$receipt_mode,"cheque_number"=>$cheque_number,"cheque_date"=>$cheque_date,"drawn_on_which_bank"=>$drawn_on_which_bank,"member_type"=>$member_type,"receipt_type"=>$receipt_type,"flat_id"=>$resident_flat_id,"amount"=>$amount,"narration"=>$narration,"reference_utr"=>$reference_utr,"party_name_id"=>$party_name,"bill_reference"=>$bill_reference,"current_date"=>$current_date,"society_id"=>$s_society_id,"receipt_id"=>$receipt_id,"receipt_source"=>1,"bill_one_time_id"=>$bill_one_time_id,"edit_status"=>"NO","prepaired_by"=>$s_user_id));
		
		
		$result_ledger_sub_account = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch3'),array('pass'=>array($resident_flat_id)));
		foreach($result_ledger_sub_account as $ledger_sub_account){
			$ledger_sub_account_id = (int)$ledger_sub_account['ledger_sub_account']['auto_id'];
		}
		
		
		//LEDGER POSTING
		$this->loadmodel('ledger');
		$conditions4=array('society_id'=>$s_society_id,"table_name"=>"new_cash_bank","element_id"=>(int)$transaction_id);
		$this->ledger->deleteAll($conditions4);
		
		$this->loadmodel('ledger');
		$auto_id=$this->autoincrement('ledger','auto_id');
		$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 33,"ledger_sub_account_id" => $deposited_bank_id,"debit"=>$amount,"credit"=>null,"table_name"=>"new_cash_bank","element_id"=>$new_new_cash_bank_auto_id,"society_id"=>$s_society_id,"transaction_date"=>strtotime($tranjection_date)));
		
		$this->loadmodel('ledger');
		$auto_id=$this->autoincrement('ledger','auto_id');
		$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 34,"ledger_sub_account_id" => $ledger_sub_account_id,"debit"=>null,"credit"=>$amount,"table_name"=>"new_cash_bank","element_id"=>$new_new_cash_bank_auto_id,"society_id"=>$s_society_id,"transaction_date"=>strtotime($tranjection_date)));
		
		
		if($member_type==1 && $receipt_type==1){
			
		//APPLY RECEIPT
		$this->loadmodel('new_cash_bank');
		$condition=array('society_id'=>$s_society_id,"flat_id"=>$resident_flat_id,"bill_one_time_id"=>$bill_one_time_id,"edit_status"=>"NO");
		$result_new_cash_bank=$this->new_cash_bank->find('all',array('conditions'=>$condition));
		
		$q=0; foreach($result_new_cash_bank as $cash_bank){ $q++;
			$amount=$cash_bank["new_cash_bank"]["amount"];
			
			
			$this->loadmodel('new_regular_bill');
			$condition=array("flat_id"=>$resident_flat_id,"edit_status"=>"NO","one_time_id"=>$bill_one_time_id);
			$result_new_regular_bill=$this->new_regular_bill->find('all',array('conditions'=>$condition)); 
			
			 foreach($result_new_regular_bill as $bill_data){ 
				$bill_auto_id=$bill_data["new_regular_bill"]["auto_id"];
				
				if($q==1){
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
			$this->new_regular_bill->updateAll(array('new_arrear_intrest'=>$new_arrear_intrest,"new_intrest_on_arrears"=>$new_intrest_on_arrears,"new_arrear_maintenance"=>$new_arrear_maintenance,"new_total"=>$new_total),array('auto_id'=>$bill_auto_id));
		}
		
////////////////////////////////////////	
$this->loadmodel('new_cash_bank');
$conditions=array("transaction_id"=>$new_new_cash_bank_auto_id,"receipt_source"=>1);
$cursor=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$receipt_no = (int)$collection['new_cash_bank']['receipt_id'];
$d_date = $collection['new_cash_bank']['receipt_date'];
$today = date("d-M-Y");
$flat_id = (int)$collection['new_cash_bank']['flat_id'];
$amount = $collection['new_cash_bank']['amount'];
$society_id = (int)$collection['new_cash_bank']['society_id'];
$bill_reference = $collection['new_cash_bank']['reference_utr'];
$narration = $collection['new_cash_bank']['narration'];
$member = (int)$collection['new_cash_bank']['member_type'];
$receiver_name = @$collection['new_cash_bank']['receiver_name'];
$receipt_mode = $collection['new_cash_bank']['receipt_mode'];
$cheque_number = @$collection['new_cash_bank']['cheque_number'];
$which_bank = @$collection['new_cash_bank']['drawn_on_which_bank'];
$reference_number = @$collection['new_cash_bank']['reference_number'];
$cheque_date = @$collection['new_cash_bank']['cheque_date'];
$sub_account = (int)$collection['new_cash_bank']['deposited_bank_id'];
$sms_date=date("d-m-Y",($d_date));
$amount = str_replace( ',', '', $amount );
$am_in_words=ucwords($this->requestAction(array('controller' => 'hms', 'action' => 'convert_number_to_words'), array('pass' => array($amount))));

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
foreach ($cursor2 as $collection) 
{
$society_name = $collection['society']['society_name'];
$society_reg_no = $collection['society']['society_reg_num'];
$society_address = $collection['society']['society_address'];
$sig_title = $collection['society']['sig_title'];
}
if($member == 2)
{
$user_name = $receiver_name;
$wing_flat = "";
}
else
{
$flatt_datta = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
foreach ($flatt_datta as $fltt_datttaa) 
{
$wnngg_idddd = (int)$fltt_datttaa['flat']['wing_id'];
}

$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wnngg_idddd,$flat_id)));
foreach ($result_lsa as $collection) 
{
$wing_id = $collection['user']['wing'];  
$flat_id = (int)$collection['user']['flat'];
$tenant = (int)$collection['user']['tenant'];
$user_name = $collection['user']['user_name'];
$to_mobile = $collection['user']['mobile'];
$to_email = $collection['user']['email'];
}
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action'=>'wing_flat'),array('pass'=>array($wing_id,$flat_id)));									
}  
$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($sub_account))); 
foreach($result2 as $collection)
{
$bank_name = $collection['ledger_sub_account']['name'];
}
                                    
$ip=$this->hms_email_ip();
$date=date("d-m-Y",($d_date));

$html_receipt='<table style="padding:24px;background-color:#34495e" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
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
<a href="https://www.facebook.com/HousingMatters.co.in"><img src="'.$ip.$this->webroot.'/as/hm/SMLogoFB.png" style="max-height: 30px; height: 30px; width: 30px; max-width: 30px;" height="30px" width="30px" /></a>
</td>
</tr>
							</table>
							</td>
						</tr>
						<tr>
							<td height="10"></td>
						</tr>
                        <tr>
                            <td colspan="2" style="font-size:12px;line-height:1.4;font-family:Arial,Helvetica,sans-serif;color:#34495e;border:solid 1px #767575">
							<table style="font-size:12px" width="100%" cellspacing="0">
								<tbody><tr>
									<td style="padding:2px;background-color:rgb(0,141,210);color:#fff" align="center" width="100%"><b>'.strtoupper($society_name).'</b></td>
								</tr>
							</tbody></table>
							<table style="font-size:12px" width="100%" cellspacing="0">
								<tbody>
								<tr>
									<td style="padding:5px;border-bottom:solid 1px #767575;border-top:solid 1px #767575" width="100%" align="center">
									<span style="color:rgb(100,100,99)">Regn# &nbsp; '.$society_reg_no.'</span><br>
									<span style="color:rgb(100,100,99)">'.$society_address.'</span><br
									</td>
								</tr>
								</tbody>
							</table>
							<table style="font-size:12px;border-bottom:solid 1px #767575;" width="100%" cellspacing="0">
								<tbody><tr>
									<td style="padding:0px 0 2px 5px" colspan="2">Receipt No: '.$receipt_no.'-R</td>
									
									<td colspan="2" align="right" style="padding:0px 5px 0 0px"><b>Date:</b> '.$date.' </td>
									
								</tr>
								<tr>
									<td style="padding:0px 0 2px 5px" colspan="2"> Received with thanks from: <b>'.$user_name.' '.$wing_flat.'</b></td>
																		
								</tr>
								<tr>
									<td style="padding:0px 0 2px 5px"  colspan="4">Rupees '.$am_in_words.' Only </td>
									
								</tr>';
								
							if($receipt_mode=="Cheque"){
							$receipt_mode_type='Via '.$receipt_mode.'-'.$cheque_number.' drawn on '.$which_bank.' dated '.$cheque_date;
							}
							else{
							$receipt_mode_type='Via '.$receipt_mode.'-'.$reference_number.' dated '.$cheque_date;
							}

								
								$html_receipt.='<tr>
									<td style="padding:0px 0 2px 5px"  colspan="4">'.$receipt_mode_type.'</td>
									
								</tr>
								
								<tr>
									<td style="padding:0px 0 2px 5px" colspan="4">Payment of previous bill</td>
									
								</tr>
								
							</tbody></table>
							
							
							
							<table style="font-size:12px;" width="100%" cellspacing="0">
								<tbody><tr>
									<td width="50%" style="padding:5px" valign="top">
									<span style="font-size:16px;"> <b>Rs '.$amount.'</b></span><br>';
									if($receipt_mode=="Cheque"){
									$receipt_title_cheq='Subject to realization of Cheque(s)';
									}
																		
									$html_receipt.='<span>'.@$receipt_title_cheq.'</span></td>
									<td align="center" width="50%" style="padding:5px" valign="top">
									For  <b>'.$society_name.'</b><br><br><br>
									<div><span style="border-top:solid 1px #424141">'.$sig_title.'</span></div>
									</td>
								</tr>
							</tbody></table>
												
							
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2">
                                <table style="background-color:#008dd2;font-size:11px;color:#fff;border:solid 1px #767575;border-top:none" width="100%" cellspacing="0">
                                 <tbody>
								 
									<tr>
                                        <td align="center" colspan="7"><b>
										Your Society is empowered by HousingMatters - <b> <i>"Making Life Simpler"</i>
										</b></b></td>
                                    </tr>
									<tr>
                                        <td width="50" align="right" style="font-size: 10px;"><b>Email :</b></td>
                                        <td width="120" style="color:#fff!important;font-size: 10px;"> 
										<a href="mailto:support@housingmatters.in" style="color:#fff!important" target="_blank"><b>support@housingmatters.in</b></a>
                                        </td>
										<td align="center" style="font-size: 10px;"></td>
                                        <td align="right" style="font-size: 10px;"><b>Phone :</b></td>
                                        <td width="84" style="color:#fff!important;text-decoration:none;font-size:10px;"><b>022-41235568</b></td>
										<td align="center" style="font-size: 10px;"></td>
                                        <td width="100" style="padding-right:10px;text-decoration:none"> <a href="http://www.housingmatters.in" style="color:#fff!important" target="_blank"><b>www.housingmatters.in</b></a></td>
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
        </tbody>
</table>';
////////////////my Email//////////////
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
//////////////////////////////////////////////////////////////////////////


if($email_is_on_off==1){
////email code//

$r_sms=$this->hms_sms_ip();
$working_key=$r_sms->working_key;
$sms_sender=$r_sms->sms_sender; 
$sms_allow=(int)$r_sms->sms_allow;

$subject="[".$society_name."]- Revised Receipt of Rs ".$amount." on ".date('d-M-Y',$d_date)." against Unit ".$wing_flat."";
//$subject = "[".$society_name."]- Receipt,"date('d-M-Y',$d_date).""; 

$this->send_email($to_email,'accounts@housingmatters.in','HousingMatters',$subject,$html_receipt,'donotreply@housingmatters.in');

}		

/////////////////////////////////////////		
		}
	    $this->Session->write('bank_eddd', 1);
		$this->response->header('Location', $this->webroot.'Cashbanks/bank_receipt_view');
	}
}
////////////////////////////////////////// End Bank Receipt Pdf (Accounts)////////////////////////////////////

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

//////////////////////////// Start Bank Receipt ajax (Accounts)///////////////////////
function bank_receipt_ajax()
{
$this->layout = 'blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$ff = $this->request->query('ff');
$this->set('ff',$ff);

$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 33);
$cursor3=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor3',$cursor3);

$this->loadmodel('ledger_sub_account');
$conditions=array("society_id" => $s_society_id, "ledger_id" => 34,"deactive"=>0);
$cursor1=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

}
//////////////////////// End bank receipt Ajax (Accounts)/////////////////////////////////

//////////////////////////////////////////////////////////// Start tds Bank Payment Ajax (Accounts)//////////////////////////////////////////////////////
function bank_payment_tds_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$tds = (int)$this->request->query('tds');
$amount = (int)$this->request->query('amount');


$this->loadmodel('reference');
$conditions=array("auto_id" => 3);
$cursor1=$this->reference->find('all',array('conditions'=>$conditions));
foreach ($cursor1 as $collection) 
{
$tds_arr = $collection['reference']['reference'];
}
for($t=0; $t<sizeof($tds_arr); $t++)
{
$tds_arr2 = $tds_arr[$t];
$tds_id = (int)$tds_arr2[1];
if($tds_id == $tds)
{
$charge = $tds_arr2[0];
break;
}
}
$tds_charge = (float)((@$charge/100)*$amount);
$total_amount = round($amount - $tds_charge); 
$this->set('total_amount',$total_amount);
}
/////////////////////// End tds bank Payment Ajax (Accounts)///////////////////////

/////////////////////// Start bank_payment_type_json_ajax ////////////////////////////////
function bank_payment_type_json_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$type= (int)$this->request->query('type');
//$ussidd= (int)@$this->request->query('ussidd');
$this->set('type',$type);
//$this->set('ussidd',$ussidd);

$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 15);
$cursor1=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);


$this->loadmodel('accounts_group');
$conditions=array("accounts_id" => 1);
$cursor2=$this->accounts_group->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

$this->loadmodel('accounts_group');
$conditions=array("accounts_id" => 4);
$cursor3=$this->accounts_group->find('all',array('conditions'=>$conditions));
$this->set('cursor3',$cursor3);
}
/////////////////////// End bank_payment_type_json_ajax ////////////////////////////////
////////////////////////// Start Bank Payment Type Ajax////////////////////////////////////
function bank_payment_type_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$type= (int)$this->request->query('type');
$ussidd= (int)@$this->request->query('ussidd');
$this->set('type',$type);
$this->set('ussidd',$ussidd);




$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 15);
$cursor1=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);


$this->loadmodel('accounts_group');
$conditions=array("accounts_id" => 1);
$cursor2=$this->accounts_group->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

$this->loadmodel('accounts_group');
$conditions=array("accounts_id" => 4);
$cursor3=$this->accounts_group->find('all',array('conditions'=>$conditions));
$this->set('cursor3',$cursor3);
}
////////////////////////End Bank Payment Type Ajax /////////////////////////////////////

//////////////////////////////////////// Start bank payment Pdf (Accounts)///////////////////////////////////////
function bank_payment_pdf($trans_id=null)
{
$this->layout = 'pdf'; //this will use the pdf.ctp layout 
$s_role_id = (int)$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id = (int)$this->Session->read('user_id');	

	$this->ath();

$trans_id = (int)$trans_id;

$this->loadmodel('new_cash_bank');
$conditions=array("transaction_id" => $trans_id,"receipt_source"=>2,"society_id"=>$s_society_id);
$cursor1=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

$this->loadmodel('reference');
$conditions=array("auto_id"=>3);
$cursor = $this->reference->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$tds_arr = $collection['reference']['reference'];
}
$this->set("tds_arr",$tds_arr);	

}
//////////////////////////////////////// End bank payment Pdf (Accounts)////////////////////////////////////////////

//////////////////////////////////Start Fix Deposit Add (Accounts) ////////////////////////////////////////////////////
function fix_deposit_add()
{
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

$this->set('s_role_id',$s_role_id);

if(isset($this->request->data['sub']))
{
$bank_name = $this->request->data['bank_name'];
$branch = $this->request->data['branch'];
$account_reference = $this->request->data['account_reference'];
$principal_amount = $this->request->data['principal_amount'];
$start_date = $this->request->data['start_date'];
$maturity_date = $this->request->data['maturity_date'];
$interest_rate = $this->request->data['interest_rate'];
$remark = $this->request->data['remark'];
$reminder = $this->request->data['reminder'];
//$tds = $this->request->data['tds'];
$name = $this->request->data['name'];
$email = $this->request->data['email'];
$mobile = $this->request->data['mobile'];

$current_date = date('d-m-Y');
$current_date = date("Y-m-d", strtotime($current_date));
$current_date = new MongoDate(strtotime($current_date));

$start_date = date("Y-m-d", strtotime($start_date));
$start_date = new MongoDate(strtotime($start_date));

$maturity_date = date("Y-m-d", strtotime($maturity_date));
$maturity_date = new MongoDate(strtotime($maturity_date));

$this->loadmodel('fix_deposit');
$conditions=array("society_id" => $s_society_id);
$order=array('fix_deposit.auto_id'=> 'DESC');
$cursor=$this->fix_deposit->find('all',array('conditions'=>$conditions,'order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last11 = $collection['fix_deposit']['auto_id'];
}
if(empty($last11))
{
$i=0;
}	
else
{	
$i=$last11;
}
$i++; 
$this->loadmodel('fix_deposit');
$multipleRowData = Array( Array("auto_id" => $i, "bank_name" => $bank_name,  "branch" => $branch, "account_reference" => $account_reference, "prepaired_by" => $s_user_id, 
"principal_amount" => $principal_amount, "start_date" => $start_date,"maturity_date" => $maturity_date, "interest_rate" => $interest_rate,"remark" => $remark, "reminder" => $reminder,"name" => $name, "society_id" => $s_society_id, "email" => $email,"mobile" => $mobile, "current_date"=>$current_date));
$this->fix_deposit->saveAll($multipleRowData);
?>

<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-header">
<center>
<h3 id="myModalLabel3" style="color:#999;"><b>Fix Deposit</b></h3>
</center>
</div>
<div class="modal-body">
<center>
<h5><b>Record Inserted Successfully</b></h5>
</center>
</div>
<div class="modal-footer">
<a href="fix_deposit_view" class="btn blue">OK</a>
</div>
</div>


<?php
}

$this->loadmodel('reference');
$conditions=array("auto_id"=>6);
$rfff=$this->reference->find('all',array('conditions'=>$conditions));
foreach($rfff as $dddtttt)
{
$kendo_array = @$dddtttt['reference']['reference'];			
}
if(!empty($kendo_array))
{
@$kendo_implode = implode(",",$kendo_array);
}
$this->set('kendo_implode',@$kendo_implode);



$this->loadmodel('reference');
$conditions=array("auto_id"=>7);
$rfff2=$this->reference->find('all',array('conditions'=>$conditions));
foreach($rfff2 as $dddtttt2)
{
$kendo_array2 = @$dddtttt2['reference']['reference'];			
}
if(!empty($kendo_array2))
{
@$kendo_implode2 = implode(",",$kendo_array2);
}
$this->set('kendo_implode2',@$kendo_implode2);

}
/////////////////////////////////////End Fix Deposit Add (Accounts) //////////////////////////////////////////////////////

///////////////////// Start Fix Deposit View (Accounts) ////////////////////////////////////////////////////////
function fix_deposit_view()
{
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
	}else{
		$this->layout='session';
	}
	
$this->ath();
$this->check_user_privilages();		

$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=(int)$this->Session->read('user_id');


$rrrr = (int)$this->request->query('aa');
if(!empty($rrrr))
{
$move_on_date = date('Y-m-d');	
$this->loadmodel('fix_deposit');
$this->fix_deposit->updateAll(array('matured_status'=>2,"move_by"=>$s_user_id,"move_on"=>$move_on_date),array('transaction_id'=>$rrrr,"society_id"=>$s_society_id));
?>
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
The Record Updated Successfully
</div>
<div class="modal-footer">
<a class="btn red" href="fix_deposit_view">OK</a>
</div>
</div>
<?php
}

$readinggg = (int)$this->request->query('rr');
if(!empty($readinggg))
{
$this->loadmodel('fix_deposit');
$this->fix_deposit->updateAll(array('matured_status'=>2),array('transaction_id'=>$readinggg,"society_id"=>$s_society_id));
}

$this->set('s_role_id',$s_role_id);
$this->loadmodel('fix_deposit');
$conditions=array('society_id'=>$s_society_id,"matured_status"=>1);
$order=array('fix_deposit.start_date'=>'ASC');
$cursor1=$this->fix_deposit->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('cursor1',$cursor1);


$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor2 as $dataa)
{
$society_name = $dataa['society']['society_name'];
}
$this->set('society_name',$society_name);

}

//////////////////////////////////////////////////////////// End Fix Deposit View (Accounts) /////////////////////////////

//////////////////////////////////// Start Fix Deposit Show Ajax ///////////////////////////////////////////////////////

function fixed_diposit_show_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->ath();

$from = $this->request->query('date1');
$to = $this->request->query('date2');

$this->set('from',$from);
$this->set('to',$to);


$from = date('Y-m-d',strtotime($from));
$to = date('Y-m-d',strtotime($to));

$from = strtotime($from);
$to = strtotime($to);

$this->loadmodel('fix_deposit');
$conditions=array('society_id'=>$s_society_id,"matured_status"=>1,'fix_deposit.start_date'=>array('$gte'=>$from,'$lte'=>$to));
$cursor1=$this->fix_deposit->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);


$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor2 as $dataa)
{
$society_name = $dataa['society']['society_name'];
}
$this->set('society_name',$society_name);
}
//////////////////////////////////// End Fix Deposit Show Ajax ///////////////////////////////////////////////////////

///////////////////////////////////////// Start Bank Payment Json //////////////////////////////////////////////////
function bank_payment_json()
{
$this->layout="";
$this->ath();
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$date=date('d-m-Y');
$time = date(' h:i a', time());


$q=$this->request->query('q');
$q = html_entity_decode($q);
$myArray = json_decode($q, true);



$c = 0;
foreach($myArray as $child)
{
$c++;
if(empty($child[0])){
$output = json_encode(array('type'=>'error', 'text' => 'Transaction Date is Required in row '.$c));
die($output);
}	


 $TransactionDate = $child[0];
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
		$output=json_encode(array('type'=>'error','text'=>'Transaction date Should be in Open Financial Year in row '.$c));
		die($output);
	}

if(empty($child[1])){
$output = json_encode(array('type'=>'error', 'text' => 'Ledger Account is Required in row '.$c));
die($output);
}	

if(empty($child[2])){
$output = json_encode(array('type'=>'error', 'text' => 'Amount is Required in row '.$c));
die($output);
}	

if(is_numeric($child[2]))
{
}
else
{
$output = json_encode(array('type'=>'error', 'text' => 'Amount Should be Numeric Value in row '.$c));
die($output);
}


if(empty($child[5])){
$output = json_encode(array('type'=>'error', 'text' => 'Mode of Payment is Required in row '.$c));
die($output);
}	

if(empty($child[6])){
$output = json_encode(array('type'=>'error', 'text' => 'Instrument/Utr is Required in row '.$c));
die($output);
}	

if(empty($child[7])){
$output = json_encode(array('type'=>'error', 'text' => 'Bank Account is Required in row '.$c));
die($output);
}	
	
}
$rr_arr = array();
$current_date = date('Y-m-d');
foreach($myArray as $child)
{
$transaction_date = $child[0];
$ledgr_acc = $child[1];
$amount = $child[2];
$tds_id = $child[3];
$net_amt = $child[4];
$mode = $child[5];
$instrument = $child[6];
$bank_ac = (int)$child[7];
$invoice = @$child[8];
$narration = $child[9];

$accctyypp = explode(',',$ledgr_acc);
$ledger_acc = (int)$accctyypp[0];
$acc_type = (int)$accctyypp[1];

$i=$this->autoincrement('new_cash_bank','transaction_id');
$bbb=$this->autoincrement_with_receipt_source('new_cash_bank','receipt_id',2);
$rr_arr[] = $bbb;
$this->loadmodel('new_cash_bank');
$multipleRowData = Array( Array("transaction_id" => $i, "receipt_id" => $bbb,  "current_date" => $current_date, 
"transaction_date" => strtotime($transaction_date), "prepaired_by" => $s_user_id, 
"user_id" => $ledger_acc, "invoice_reference" => @$invoice,"narration" => $narration, "receipt_mode" => $mode,
"receipt_instruction" => $instrument, "account_head" => $bank_ac,  
"amount" => $amount,"society_id" => $s_society_id, "tds_id" =>$tds_id,"account_type"=>$acc_type,"receipt_source"=>2,"auto_inc"=>"YES"));
$this->new_cash_bank->saveAll($multipleRowData);  

//////////////////// End Insert///////////////////////////////
///////////// TDS CALCULATION /////////////////////
$this->loadmodel('reference');
$conditions=array("auto_id" => 3);
$cursor4=$this->reference->find('all',array('conditions'=>$conditions));
foreach($cursor4 as $collection)
{
$tds_arr = $collection['reference']['reference'];	
}
if(!empty($tds_id))
{
for($r=0; $r<sizeof($tds_arr); $r++)
{
$tds_sub_arr = $tds_arr[$r];
$tds_id2 = (int)$tds_sub_arr[1];
if($tds_id2 == $tds_id)
{
$tds_rate = $tds_sub_arr[0];
break;
}
}
$tds_amount = (round(($tds_rate/100)*$amount));
$total_tds_amount = ($amount - $tds_amount);
}
else
{
$total_tds_amount = $amount;
$tds_amount = 0;
}

////////////END TDS CALCULATION //////////////////// 
////////////////START LEDGER ENTRY///////////////////////
if($acc_type == 1)
{
$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l,"transaction_date"=>strtotime($transaction_date), "debit" => $amount, "credit" =>null,"ledger_account_id" => 15, "ledger_sub_account_id" =>$ledger_acc, "table_name" =>"new_cash_bank","element_id" => $i, "society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData); 
}
else
{
$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l,"transaction_date"=>strtotime($transaction_date), "debit" => $amount,"credit" =>null,"ledger_account_id" =>$ledger_acc, "ledger_sub_account_id" =>null, "table_name" =>"new_cash_bank","element_id" =>$i, "society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData); 
}




$sub_account_id_a = (int)$bank_ac;
$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l,"transaction_date"=>strtotime($transaction_date), 
"debit" =>null,"credit" =>$total_tds_amount,"ledger_account_id" =>33, 
"ledger_sub_account_id" =>$sub_account_id_a, "table_name" =>"new_cash_bank","element_id" =>$i, 
"society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData); 


if($tds_amount > 0)
{
$sub_account_id_t = 16;
$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l,"transaction_date"=>strtotime($transaction_date),
"debit" =>null,"credit" =>$tds_amount,"ledger_account_id" =>$sub_account_id_t, 
"ledger_sub_account_id" =>null, "table_name" =>"new_cash_bank","element_id" =>$i, 
"society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData); 
}
}

$this->Session->write('bank_ppp',1);

$rr_arr2 = implode(",",$rr_arr);
$output = json_encode(array('type'=>'success', 'text' => 'Bank Payment Voucher '.$rr_arr2.' Generated Successfully'));
die($output);

}
///////////////////////////////////////// End Bank Payment Json /////////////////////////////////////////////////////

////////////////////////////////////////// Start Petty Cash Receipt Json/////////////////////////////////////////////
function petty_cash_receipt_json()
{
$this->layout="";
$this->ath();
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$date=date('d-m-Y');
$time = date(' h:i a', time());


$q=$this->request->query('q');
$q = html_entity_decode($q);
$myArray = json_decode($q, true);

$c = 0;
foreach($myArray as $child)
{
$c++;
if(empty($child[0])){
$output = json_encode(array('type'=>'error', 'text' => 'Transaction Date is Required in row '.$c));
die($output);
}	

    $TransactionDate = $child[0];
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
		$output=json_encode(array('type'=>'error','text'=>'Transaction date Should be in Open Financial Year in row '.$c));
		die($output);
	}



if(empty($child[1])){
$output = json_encode(array('type'=>'error', 'text' => 'A/c Group is Required in row '.$c));
die($output);
}	

if(empty($child[2])){
$output = json_encode(array('type'=>'error', 'text' => 'Income/Party A/c is Required in row '.$c));
die($output);
}	

if(empty($child[3])){
$output = json_encode(array('type'=>'error', 'text' => 'Account Head is Required in row '.$c));
die($output);
}	

if(empty($child[4])){
$output = json_encode(array('type'=>'error', 'text' => 'Amount is Required in row '.$c));
die($output);
}	

if(is_numeric($child[4]))
{
}
else
{
$output = json_encode(array('type'=>'error', 'text' => 'Amount Should be Numeric Value in row '.$c));
die($output);
}
}

$rr_arr = array();
foreach($myArray as $child)
{
$transaction_date = $child[0];
$ac_group = (int)$child[1];
$party_ac = (int)$child[2];
$ac_head = (int)$child[3];
$amount = $child[4];
$narration = $child[5];
$current_date = date('Y-m-d');

$auto=$this->autoincrement('new_cash_bank','transaction_id');
$i=$this->autoincrement_with_receipt_source('new_cash_bank','receipt_id',3);
$rr_arr[] = $i;
$this->loadmodel('new_cash_bank');
$multipleRowData = Array( Array("transaction_id" => $auto, "receipt_id" => $i,  "user_id" => $party_ac, 
"current_date" => $current_date, "account_type" => $ac_group,"transaction_date" => strtotime($transaction_date), "prepaired_by" => $s_user_id,"narration" => $narration, "account_head" => $ac_head,  "amount"=>$amount,"society_id" => $s_society_id,"receipt_source"=>3,"auto_inc"=>"YES"));
$this->new_cash_bank->saveAll($multipleRowData);  


$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'ledger_SubAccount_dattta_by_flat_id'),array('pass'=>array($party_ac)));
foreach($result_flat_info as $flat_info){
$account_id = (int)$flat_info["ledger_sub_account"]["auto_id"];
}



if($ac_group == 1)
{
$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l,"transaction_date"=>strtotime($transaction_date),"debit"=>null, "credit" =>$amount,"ledger_account_id" => 34, "ledger_sub_account_id" =>$account_id,"table_name" =>"new_cash_bank","element_id"=>$auto, "society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData);
}
else
{
$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l,"transaction_date"=>strtotime($transaction_date), "debit" => null, "credit" =>$amount,"ledger_account_id" =>$party_ac, "ledger_sub_account_id" =>null,"table_name" =>"new_cash_bank","element_id" => $auto, "society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData);
}


$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l,"transaction_date"=>strtotime($transaction_date),"debit" =>$amount, "credit" =>null,"ledger_account_id" =>$ac_head,"ledger_sub_account_id"=>null,"table_name" =>"new_cash_bank","element_id"=>$auto, "society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData);
}

$this->Session->write('petty_cc_rr',1);


$rr_arr2 = implode(",",$rr_arr);
$output = json_encode(array('type'=>'success', 'text' => 'Petty Cash Receipt '.$rr_arr2.' generated successfully '));
die($output);

}
////////////////////////////////////////// End Petty Cash Receipt Json/////////////////////////////////////////////

////////////////////////////////////////// Start Fix Deposit Jason ////////////////////////////////////////////////
function fix_deposit_json()
{
$this->layout='blank';
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id = (int)$this->Session->read('user_id');
	$post_data=$this->request->data;

     $this->ath();

	  $q=$post_data['myJsonString'];
		//$q=$this->request->query('q'); 
		$myArray = json_decode($q, true);
		$c=0;
foreach($myArray as $child){
$c++;

		if(empty($child[0])){
		$output = json_encode(array('type'=>'error', 'text' => 'Bank Name is Required in row '.$c));
		die($output);
		}	

if(empty($child[1])){
		$output = json_encode(array('type'=>'error', 'text' => 'Branch is Required in row '.$c));
		die($output);
		}	
  if(empty($child[2])){
		$output = json_encode(array('type'=>'error', 'text' => 'Account Reference is Reqired in row '.$c));
		die($output);
		}	
if(empty($child[3])){
		$output = json_encode(array('type'=>'error', 'text' => 'Principal Amount is Required in row '.$c));
		die($output);
		}

if(is_numeric($child[3]))
{
}
else
{
$output = json_encode(array('type'=>'error', 'text' => 'Principal Amount Should be Numeric Value in row '.$c));
die($output);
}


		
if(empty($child[4])){
		$output = json_encode(array('type'=>'error', 'text' => 'Start Date is Required in row '.$c));
		die($output);
		}

$TransactionDate = $child[4];
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
		$output=json_encode(array('type'=>'error','text'=>'Start Date Should be in Open Financial Year in row '.$c));
		die($output);
	}

		
if(empty($child[5])){
		$output = json_encode(array('type'=>'error', 'text' => 'Maturity Date is Required in row '.$c));
		die($output);
		}

$stattt_date = $child[4];
$mat_dateee = $child[5];
$stt_dat = date('Y-m-d',strtotime($stattt_date));
$matt_date = date('Y-m-d',strtotime($mat_dateee));
$start_com_date = strtotime($stt_dat);
$mat_com_date = strtotime($matt_date);

if($mat_com_date < $start_com_date)
{
$output = json_encode(array('type'=>'error', 'text' => 'Maturity Date Should be Greater than Start Date in row '.$c));
		die($output);	
	
}

		
if(empty($child[6])){
		$output = json_encode(array('type'=>'error', 'text' => 'Interest Rate is Required in row '.$c));
		die($output);
		}			
if(is_numeric($child[6]))
{
}
else
{
$output = json_encode(array('type'=>'error', 'text' => 'Interest Rate Should be Numeric Value in row '.$c));
die($output);
}


if(empty($child[7])){
		$output = json_encode(array('type'=>'error', 'text' => 'Purpose is Required in row '.$c));
		die($output);
		}





		
}
$rr = array();
$z=1;
foreach($myArray as $child)
{
$z++;
$bank_name = $child[0];
$branch = $child[1];
$ac_reference = $child[2];
$principal_amt = $child[3];
$start_date = $child[4];
$maturity_date = $child[5];
$rate = $child[6];
$purpose = @$child[7];

 $knddd = "&quot;".$bank_name."&quot;";
			$this->loadmodel('reference');
			$conditions=array("auto_id"=>6);
			$rfff=$this->reference->find('all',array('conditions'=>$conditions));
			foreach($rfff as $dddttt)
			{
			$knnddd = @$dddttt['reference']['reference'];			
			}
				$nnnn = 555;
				for($n=0; $n<sizeof($knnddd); $n++)
				{
				$kendo_name = $knnddd[$n];
				if($kendo_name == $knddd)
				{
				$nnnn = 5;
				break;
				}
				else
				{
				$nnnn = 555;
				}
				}
					
						if($nnnn == 555){
						$knnddd[] = $knddd;
						$this->loadmodel('reference');
						$this->reference->updateAll(array("reference" => $knnddd),array("auto_id" =>6));
						}	










$knddd = "&quot;".$branch."&quot;";
			$this->loadmodel('reference');
			$conditions=array("auto_id"=>7);
			$rfff=$this->reference->find('all',array('conditions'=>$conditions));
			foreach($rfff as $dddttt)
			{
			$knnddd = @$dddttt['reference']['reference'];			
			}
				$nnn = 555;
				for($n=0; $n<sizeof($knnddd); $n++)
				{
				$kendo_name = $knnddd[$n];
				if($kendo_name == $knddd)
				{
				$nnn = 5;
				break;
				}
				else
				{
				$nnn = 555;
				}
				}
					
						if($nnn == 555){
						$knnddd[] = $knddd;
						$this->loadmodel('reference');
						$this->reference->updateAll(array("reference" => $knnddd),array("auto_id" =>7));
						}













$start_date = date('Y-m-d',strtotime($start_date));
$maturity_date = date('Y-m-d',strtotime($maturity_date));
$current_date = date('Y-m-d');

		$file_name=@$_FILES["file".$z]["name"];
		if(!empty($file_name)){
		$file_name=$_FILES["file".$z]["name"];
		$file_tmp_name =$_FILES['file'.$z]['tmp_name'];
		$target = "fix_deposit/";
		$target=@$target.basename($file_name);
		move_uploaded_file($file_tmp_name,@$target);
		}



$l=$this->autoincrement('fix_deposit','transaction_id');
$re_id = $this->autoincrement_with_fixed_deposit('fix_deposit','receipt_id');
$rr[] = $re_id; 
$this->loadmodel('fix_deposit');
$multipleRowData = Array( Array("transaction_id" => $l,"receipt_id"=>$re_id,"bank_name"=>$bank_name,
"bank_branch"=>$branch,"account_reference"=>$ac_reference,"principal_amount"=>$principal_amt,
"start_date"=>strtotime($start_date),"maturity_date"=>strtotime($maturity_date),"interest_rate"=>$rate,
"purpose"=>$purpose,"file_name"=>$file_name,"society_id" => $s_society_id,"matured_status"=>1,
"auto_inc"=>"YES","current_date"=>$current_date,"prepaired_by"=>$s_user_id));
$this->fix_deposit->saveAll($multipleRowData);
}


$this->Session->write('fix_ddd',1);

$rrr = implode(',',$rr);

$output = json_encode(array('type'=>'success', 'text' => 'fixed deposit #'.$rrr.' generated successfully'));
die($output);


}
////////////////////////////////////////// End Fix Deposit Jason ////////////////////////////////////////////////
///////////////////////// Start Matured Deposit View ////////////////////////////////////////////////
function matured_deposit_view()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}

$this->ath();
$this->check_user_privilages();

$s_society_id=(int)$this->Session->read('society_id');


$rrrr = (int)$this->request->query('aa');
if(!empty($rrrr))
{
$move_on_date = date('Y-m-d');	
$this->loadmodel('fix_deposit');
$this->fix_deposit->updateAll(array('matured_status'=>1),array('transaction_id'=>$rrrr,"society_id"=>$s_society_id));
?>
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
The Record Reversed Successfully
</div>
<div class="modal-footer">
<a class="btn red" href="matured_deposit_view">OK</a>
</div>
</div>
<?php
}









$this->loadmodel('fix_deposit');
$conditions=array('society_id'=>$s_society_id,"matured_status"=>2);
$order=array('fix_deposit.start_date'=>'ASC');
$cursor1=$this->fix_deposit->find('all',array('conditions'=>$conditions,'order' => $order));
$this->set('cursor1',$cursor1);


$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor2 as $dataa)
{
$society_name = $dataa['society']['society_name'];
}
$this->set('society_name',$society_name);

}
///////////////////////////////// End Matured Deposit View /////////////////////////////////////////////////

////////////////////////////////// Start Fix Deposit view (Active) Excel///////////////////////////////////////////
function fix_deposit_excel()
{
$this->layout="";
$this->ath();

$s_society_id = (int)$this->Session->read('society_id');
$s_role_id= (int)$this->Session->read('role_id');
$s_user_id= (int)$this->Session->read('user_id');

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
}

$socc_namm = str_replace(' ', '_', $society_name);

$filename="".$socc_namm."_Fixed_Deposits";

//$filename="Fix Deposit Excel";
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

$currr_datee = date('d-M-Y');

$excel="<table border='1'>
<tr>
<th colspan='9' style='text-align:center;'>$society_name: Fixed Deposit Register on $currr_datee</th>
</tr>
<tr>
<th>Deposit ID</th>
<th>Bank name</th>
<th>Bank Branch</th>
<th>Account Reference</th>
<th>Start Date</th>
<th>Maturity Date</th>
<th>Interest Rate</th>
<th>Principal Amount</th>
<th>Purpose</th>
</tr>";

$tt_amt = 0;
$this->loadmodel('fix_deposit');
$order=array('fix_deposit.start_date'=>'ASC');
$conditions=array('society_id'=>$s_society_id,"matured_status"=>1);
$cursor1=$this->fix_deposit->find('all',array('conditions'=>$conditions,'order'=>$order));
foreach($cursor1 as $data)
{
$receipt_id = $data['fix_deposit']['receipt_id'];
$start_date = $data['fix_deposit']['start_date'];	
$bank_name = $data['fix_deposit']['bank_name'];	
$branch = $data['fix_deposit']['bank_branch'];	
$rate = $data['fix_deposit']['interest_rate'];	
$mat_date = $data['fix_deposit']['maturity_date'];	
$remarks = $data['fix_deposit']['purpose'];		
$reference = $data['fix_deposit']['account_reference'];		
$amt = $data['fix_deposit']['principal_amount'];
$file_name = $data['fix_deposit']['file_name'];
$tt_amt = $tt_amt + $amt;
$start_date	= date('d-m-Y',($start_date));	
$mat_date	= date('d-m-Y',($mat_date));

$excel.="<tr>
<td>$receipt_id</td>
<td>$bank_name</td>
<td>$branch</td>
<td>$reference</td>
<td>$start_date</td>
<td>$mat_date</td>
<td>$rate</td>
<td>$amt</td>
<td>$remarks</td>
</tr>";
}
$excel.="<tr><td colspan='7' style='text-align:right;'><b>Total</b></td>
            <td><b>$tt_amt</b></td>
            <td></td></tr>
</table>";	

echo $excel;
}
////////////////////////////////// Start Fix Deposit view (Active) Excel///////////////////////////////////////////
/////////////////////////////////// Start Edit PCP //////////////////////////////////////////////////////////////
function edit_pcp($rr_id)
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');	




$this->loadmodel('cash_bank');
$conditions=array("society_id" => $s_society_id,"module_id"=>4,"receipt_id"=>$rr_id);
$cursor1 = $this->cash_bank->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

}
/////////////////////////////////// End Edit PCP //////////////////////////////////////////////////////////////
/////////////////////////////////// Start bank_receipt_import ////////////////////////////////////////////////////////
function bank_receipt_import()
{
$this->layout="";
$filename="Bank_Receipt_Import";
header ("Expires: 0");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . "GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".csv");
header ("Content-Description: Generated Report" );

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');

$excel = "Transaction Date,Receipt Mode,Cheque No.,branch,Reference/UTR,Drawn Bank name,Deposited In,Date,Member Name,Wing,Unit #,Amount,Narration \n";

$excel.="12-5-2015,Cheque,55434,Hiran Magri,445566H,SBBJ,SBBJ,25-5-2015,Abhilash,Wing A,101,5000,Receipt for bill";

echo $excel;
}
/////////////////////////////// End bank_receipt_import ////////////////////////////////////////////////////////////

////////////////////////////// Start bank_receipt_import_ajax //////////////////////////////////////////////////////////
function bank_receipt_import_ajax()
{
$this->layout="blank";
$this->ath();

$s_society_id= (int)$this->Session->read('society_id');


if(isset($_FILES['file'])){
$file_name=$_FILES['file']['name'];
$file_tmp_name =$_FILES['file']['tmp_name'];
$target = "csv_file/bank/";
$target=@$target.basename($file_name);
move_uploaded_file($file_tmp_name,@$target);

$f = fopen('csv_file/bank/'.$file_name, 'r') or die("ERROR OPENING DATA");
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
foreach($test as $child)
{
if($i>0)
{
$child_ex=explode(',',$child[0]);
/////////////////////////////////////////////////////
$TransactionDate = $child_ex[0];
$ReceiptMod = $child_ex[1];
$ChequeNo = $child_ex[2];
$branch = $child_ex[3];
$Reference = $child_ex[4];
$DrawnBankname = $child_ex[5];
$Deposited = $child_ex[6];
$Date1 = $child_ex[7];
$MemberName = $child_ex[8];
$Wing = $child_ex[9];
$Flat = $child_ex[10];
$Amount = $child_ex[11];
$narration = $child_ex[12];
	  
////////////////////////////////////////////////////////////

$this->loadmodel('wing'); 
$conditions=array("wing_name"=> new MongoRegex('/^' . $Wing . '$/i'),"society_id"=>$s_society_id);
$result_ac=$this->wing->find('all',array('conditions'=>$conditions));
foreach($result_ac as $collection)
{
$wing_id = (int)$collection['wing']['wing_id'];
}

$this->loadmodel('flat'); 
$conditions=array("flat_name"=> new MongoRegex('/^' . trim($Flat) . '$/i'), "society_id"=>$s_society_id);
$result_ac=$this->flat->find('all',array('conditions'=>$conditions));
foreach($result_ac as $collection)
{
$flat_id = (int)$collection['flat']['flat_id'];
}

 
$this->loadmodel('ledger_sub_account'); 
$conditions=array("name"=> new MongoRegex('/^' . $MemberName . '$/i'),"society_id"=>$s_society_id,"ledger_id"=>34,"flat_id"=>$flat_id);
$result_ac=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
foreach($result_ac as $collection)
{
$user_id = (int)$collection['ledger_sub_account']['user_id'];
$auto_id = (int)$collection['ledger_sub_account']['auto_id'];


		$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
		foreach($result_flat_info as $flat_info){
		$wing_id= (int)$flat_info["flat"]["wing_id"];
		}
}		
			
@$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_with_brackets'),array('pass'=>array($wing_id,$flat_id)));


$this->loadmodel('ledger_sub_account'); 
$conditions=array("name"=> new MongoRegex('/^' . $Deposited . '$/i'),"society_id"=>$s_society_id);
$result_ac=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
foreach($result_ac as $collection)
{
$bank_id = (int)$collection['ledger_sub_account']['auto_id'];
}


$table[] = array(@$TransactionDate,@$ReceiptMod,@$ChequeNo,@$Reference,@$DrawnBankname,@$bank_id,@$Date1,@$auto_id,@$Amount,@$narration,@$flat_id,@$wing_id,@$branch);
} 
$i++;
}
$this->set('aaa',$table);

$this->loadmodel('ledger_sub_account');
$conditions=array("society_id" => $s_society_id,"ledger_id"=>33);
$cursor1 = $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('ledger_sub_account');
$conditions=array("society_id" => $s_society_id,"ledger_id"=>34);
$cursor2 = $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

}
////////////////////////////// End bank_receipt_import_ajax //////////////////////////////////////////////////////////
///////////////////////////////// Start Save bank Imp ///////////////////////////////////////////////////////////////
function save_bank_imp()
{
$this->layout='blank';
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');
$this->ath();
$q=$this->request->query('q'); 
$myArray = json_decode($q, true);

$r=1;
foreach($myArray as $child){
	$r++;
	$TransactionDate = $child[0];
	$ReceiptMod = $child[1];
	$bank_id = $child[6];
	$auto_id = $child[7];
	$Amount = $child[8];
  
		if(empty($TransactionDate)){
		$output=json_encode(array('report_type'=>'validation','text'=>'Please Fill Transaction Date in row'.$r));
		die($output);
		}

	if(empty($ReceiptMod)){
		$output=json_encode(array('report_type'=>'validation','text'=>'Please Fill Receipt Mode in row'.$r));
		die($output);
	}
	$c = (int)strcasecmp("Cheque",$ReceiptMod);
	$n = (int)strcasecmp("NEFT",$ReceiptMod);
	$p = (int)strcasecmp("PG",$ReceiptMod);
	if($c == 0){
		$ChequeNo = $child[2];
		$DrawnBankname = $child[4];
		$Date1 = $child[5];	
        $branch = $child[11];
	
	
			if(empty($ChequeNo)){
			$output=json_encode(array('report_type'=>'validation','text'=>'Please Fill Cheque Number in row'.$r));
			die($output);
			}
				if(is_numeric($ChequeNo))
				{
				}
				else
				{
				$output=json_encode(array('report_type'=>'validation','text'=>'Please Fill Numeric Cheque Number in row'.$r));
				die($output);
				}
			
			
		
		if(empty($Date1)){
			$output=json_encode(array('report_type'=>'validation','text'=>'Please Fill Date in row'.'30'));
			die($output);
			}
		
			if(empty($branch)){
			$output=json_encode(array('report_type'=>'validation','text'=>'Please Fill Branch in row'.$r));
			die($output);
			}	
	}
	else if($n == 0){
		
		
		$Date1 = $child[5];
		if(empty($Date1)){
			$output=json_encode(array('report_type'=>'validation','text'=>'Please Fill Date in row'.$r));
			die($output);
		}
	}
	else if($p == 0){
		$Date1 = $child[5];	
		
		if(empty($Date1)){
			$output=json_encode(array('report_type'=>'validation','text'=>'Please Fill Date in row'.$r));
			die($output);
		}
	}
	else{
		$output=json_encode(array('report_type'=>'validation','text'=>'Please Fill "Cheque", "NEFT" or PG in Receipt Mode in row'.$r));
		die($output);
	}

		
	
	
	  $abc = 555;
	$this->loadmodel('financial_year');
	$conditions=array("society_id" => $s_society_id,"status"=>1);
	$cursor = $this->financial_year->find('all',array('conditions'=>$conditions));
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
		$output=json_encode(array('report_type'=>'validation','text'=>'Transaction date is not in open Financial Year in row'.$r));
		die($output);
	}

	if(empty($Amount)){
		$output=json_encode(array('report_type'=>'validation','text'=>'Please Fill Amount in row'.$r));
		die($output);
	
	}
	
	if(is_numeric($Amount)){
	}
	else{
		$output=json_encode(array('report_type'=>'validation','text'=>'Please Fill Numeric Amount in row'.$r));
		die($output);
	}
	}

	$r=0;

foreach($myArray as $child){
		
			$r++;
			$Reference="";
			$type = (int)$child[9];
			$current_date = date('Y-m-d');
			$TransactionDate = $child[0];
			$TransactionDate = date('Y-m-d',strtotime($TransactionDate));
			$ReceiptMod = $child[1];
			$bank_id = (int)$child[6];
			$auto_id77 = (int)$child[7];
			$amount = $child[8];
			$narration = $child[10];
		    $branch = $child[11];
		
		
	$ledger_sub_account = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($auto_id77)));
	foreach($ledger_sub_account as $data){
	$flat_id = (int)$data['ledger_sub_account']['flat_id'];
	}

	
	
			$current_date = date('Y-m-d');
			$c = (int)strcasecmp("Cheque",$ReceiptMod);
			$n = (int)strcasecmp("NEFT",$ReceiptMod);
			$p = (int)strcasecmp("PG",$ReceiptMod);
		
		if($c == 0){
		$ChequeNo = $child[2];
		$DrawnBankname = $child[4];
		$cheque_date = $child[5];
		}
		else if($n == 0){
			$Reference = $child[3];
			$cheque_date = $child[5];
		}
		else if($p == 0){
			$Reference = $child[3];
			$cheque_date = $child[5];	
		}


		$flat_dttt = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array(@$flat_id)));
		foreach($flat_dttt as $flat_datttt){
		$wing_iddd = (int)$flat_datttt['flat']['wing_id'];
		}

		$result_rb1 = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wing_iddd,@$flat_id)));
		foreach($result_rb1 as $data2){
		$user_id = (int)$data2['user']['user_id'];
		}
		
		$result_rb = $this->requestAction(array('controller' => 'hms', 'action' => 'new_regular_bill_detail_via_flat_id'),array('pass'=>array(@$flat_id)));
		foreach ($result_rb as $collection){
			$bill_no = (int)$collection['new_regular_bill']['bill_no'];
		}



	if($type == 2){

	$sub_leddr_dattt=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_subLedger_detail_via_flat_id'),array('pass'=>array(@$flat_id)));
	foreach($sub_leddr_dattt as $sub_leddr_dattttt){
	$account_id = (int)$sub_leddr_dattttt["ledger_sub_account"]["auto_id"];
	}

	
			
	$this->loadmodel('new_regular_bill');
	$condition=array('society_id'=>$s_society_id,"flat_id"=>$flat_id);
	$order=array('new_regular_bill.one_time_id'=>'DESC');
	$result_new_regular_bill=$this->new_regular_bill->find('first',array('conditions'=>$condition,'order'=>$order)); 
	$this->set('result_new_regular_bill',$result_new_regular_bill);
	foreach($result_new_regular_bill as $data){
	$auto_id=$data["auto_id"]; 
	$regular_bill_one_time_id = (int)$data["one_time_id"];
	$flat_id = (int)$data["flat_id"];
	$number_of_receipt=$this->count_receipt_against_bill($regular_bill_one_time_id,$flat_id);
	if($number_of_receipt==0){
		$arrear_intrest=$data["arrear_intrest"];
		$intrest_on_arrears=$data["intrest_on_arrears"];
		$total=$data["total"];
		$arrear_maintenance=$data["arrear_maintenance"];
	}else{
		$arrear_intrest=$data["new_arrear_intrest"];
		$intrest_on_arrears=$data["new_intrest_on_arrears"];
		$total=$data["new_total"];
		$arrear_maintenance=$data["new_arrear_maintenance"];
	}
	
	
	}
    	$amount_after_arrear_intrest=$amount-@$arrear_intrest;
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
		$amount_after_intrest_on_arrears=$amount_after_arrear_intrest-@$intrest_on_arrears;
			if($amount_after_intrest_on_arrears<0)
			{
			$new_intrest_on_arrears=abs($amount_after_intrest_on_arrears);
			$new_arrear_maintenance=$arrear_maintenance;
			$new_total=$total;
			}
			else
			{
			$new_intrest_on_arrears=0;
			$amount_after_arrear_maintenance=$amount_after_intrest_on_arrears-@$arrear_maintenance;
				if($amount_after_arrear_maintenance<0){
				$new_arrear_maintenance=abs($amount_after_arrear_maintenance);
				$new_total=$total;
				}else{
				$new_arrear_maintenance=0;
				$amount_after_total=$amount_after_arrear_maintenance-@$total; 
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
		
			
			
			
			$t1=$this->autoincrement('new_cash_bank','transaction_id');	
			$k = (int)$this->autoincrement_with_receipt_source('new_cash_bank','receipt_id',1);
			$this->loadmodel('new_cash_bank');
			$multipleRowData = Array( Array("transaction_id"=> $t1, "receipt_id" => $k,"receipt_date" => strtotime($TransactionDate), "receipt_mode" => $ReceiptMod, "cheque_number" =>@$ChequeNo,"cheque_date" =>$cheque_date,"drawn_on_which_bank" =>@$DrawnBankname,"reference_utr" => @$Reference,"deposited_bank_id" => $bank_id,"member_type" => 1,"party_name_id"=>$flat_id,"receipt_type" => 1,"amount"=>$amount,"current_date" => $current_date,"society_id"=>$s_society_id,"flat_id"=>$flat_id,"bill_auto_id"=>$auto_id,"bill_one_time_id"=>@$regular_bill_one_time_id,"narration"=>$narration,"receipt_source"=>1,"prepaired_by" => $s_user_id,"edit_status"=>"NO","auto_inc"=>"YES","bank_branch"=>$branch));
			$this->new_cash_bank->saveAll($multipleRowData);

			
			
		$l=$this->autoincrement('ledger','auto_id');
		$this->loadmodel('ledger');
		$multipleRowData = Array( Array("auto_id" => $l, "transaction_date"=> strtotime($TransactionDate), "debit" => $amount, "credit" =>null, "ledger_account_id" => 33, "ledger_sub_account_id" => $bank_id,"table_name" => "new_cash_bank","element_id" => $t1, "society_id" => $s_society_id,));
		$this->ledger->saveAll($multipleRowData); 


$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l, "transaction_date"=> strtotime($TransactionDate), "credit" => $amount,"debit" =>null,"ledger_account_id" => 34, "ledger_sub_account_id" => $account_id,"table_name" => "new_cash_bank","element_id" => $t1, "society_id" => $s_society_id,));
$this->ledger->saveAll($multipleRowData);
			
//////////////////////////
		$this->loadmodel('new_cash_bank');
		$conditions=array("receipt_id" => $k,"society_id"=>$s_society_id,"receipt_source"=>1);
		$cursor=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
		foreach($cursor as $collection)
		{
			$receipt_no = (int)$collection['new_cash_bank']['receipt_id'];
			$d_date = @$collection['new_cash_bank']['receipt_date'];
			$today = date("d-M-Y");
			$flat_id = $collection['new_cash_bank']['party_name_id'];
			$amount = $collection['new_cash_bank']['amount'];
			$society_id = (int)$collection['new_cash_bank']['society_id'];
			$bill_reference = $collection['new_cash_bank']['reference_utr'];
			$narration = $collection['new_cash_bank']['narration'];
			$member = (int)$collection['new_cash_bank']['member_type'];
			$receiver_name = @$collection['new_cash_bank']['receiver_name'];
			$receipt_mode = $collection['new_cash_bank']['receipt_mode'];
			$cheque_number = @$collection['new_cash_bank']['cheque_number'];
			$which_bank = @$collection['new_cash_bank']['drawn_on_which_bank'];
			$reference_number = @$collection['new_cash_bank']['reference_number'];
			$cheque_date = @$collection['new_cash_bank']['cheque_date'];
			$sub_account = (int)$collection['new_cash_bank']['deposited_bank_id'];
			$sms_date=date("d-m-Y",($d_date));

	$amount = str_replace( ',', '', $amount );
	$am_in_words=ucwords($this->requestAction(array('controller' => 'hms', 'action' => 'convert_number_to_words'), array('pass' => array($amount))));

			$this->loadmodel('society');
			$conditions=array("society_id" => $s_society_id);
			$cursor2=$this->society->find('all',array('conditions'=>$conditions));
			foreach ($cursor2 as $collection) 
			{
			$society_name = $collection['society']['society_name'];
			$society_reg_no = $collection['society']['society_reg_num'];
			$society_address = $collection['society']['society_address'];
			$sig_title = $collection['society']['sig_title'];
			}
				if($member == 2)
				{
				$user_name = $receiver_name;
				$wing_flat = "";
				}
				else
				{
				$flatt_datta = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
					foreach ($flatt_datta as $fltt_datttaa) 
					{
					$wnngg_idddd = (int)$fltt_datttaa['flat']['wing_id'];
					}

					$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wnngg_idddd,$flat_id)));
					foreach ($result_lsa as $collection) 
					{
					$wing_id = $collection['user']['wing'];  
					$flat_id = (int)$collection['user']['flat'];
					$tenant = (int)$collection['user']['tenant'];
					$user_name = $collection['user']['user_name'];
					$to_mobile = $collection['user']['mobile'];
					$to_email = $collection['user']['email'];
					}
			        $wing_flat = $this->requestAction(array('controller' => 'hms', 'action'=>'wing_flat'),array('pass'=>array($wing_id,$flat_id)));									
				    }  
			$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($sub_account))); 
			foreach($result2 as $collection)
			{
			$bank_name = $collection['ledger_sub_account']['name'];
			}
											

		$date=date("d-m-Y",($d_date));
$ip=$this->hms_email_ip();

				$html_receipt='<table style="padding:24px;background-color:#34495e" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
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
<a href="https://www.facebook.com/HousingMatters.co.in"><img src="'.$ip.$this->webroot.'/as/hm/SMLogoFB.png" style="max-height: 30px; height: 30px; width: 30px; max-width: 30px;" height="30px" width="30px" /></a>
</td>
</tr>
							</table>
							</td>
						</tr>
						<tr>
							<td height="10"></td>
						</tr>
                        <tr>
                            <td colspan="2" style="font-size:12px;line-height:1.4;font-family:Arial,Helvetica,sans-serif;color:#34495e;border:solid 1px #767575">
							<table style="font-size:12px" width="100%" cellspacing="0">
								<tbody><tr>
									<td style="padding:2px;background-color:rgb(0,141,210);color:#fff" align="center" width="100%"><b>'.strtoupper($society_name).'</b></td>
								</tr>
							</tbody></table>
							<table style="font-size:12px" width="100%" cellspacing="0">
								<tbody>
								<tr>
									<td style="padding:5px;border-bottom:solid 1px #767575;border-top:solid 1px #767575" width="100%" align="center">
									<span style="color:rgb(100,100,99)">Regn# &nbsp; '.$society_reg_no.'</span><br>
									<span style="color:rgb(100,100,99)">'.$society_address.'</span><br
									</td>
								</tr>
								</tbody>
							</table>
							<table style="font-size:12px;border-bottom:solid 1px #767575;" width="100%" cellspacing="0">
								<tbody><tr>
									<td style="padding:0px 0 2px 5px" colspan="2">Receipt No: '.$receipt_no.'</td>
									
									<td colspan="2" align="right" style="padding:0px 5px 0 0px"><b>Date:</b> '.$date.' </td>
									
								</tr>
								<tr>
									<td style="padding:0px 0 2px 5px" colspan="2"> Received with thanks from: <b>'.$user_name.' '.$wing_flat.'</b></td>
																		
								</tr>
								<tr>
									<td style="padding:0px 0 2px 5px"  colspan="4">Rupees '.$am_in_words.' Only </td>
									
								</tr>';
								
							if($receipt_mode=="Cheque"){
							$receipt_mode_type='Via '.$receipt_mode.'-'.$cheque_number.' drawn on '.$which_bank.' dated '.$cheque_date;
							}
							else{
							$receipt_mode_type='Via '.$receipt_mode.'-'.$reference_number.' dated '.$cheque_date;
							}

								
								$html_receipt.='<tr>
									<td style="padding:0px 0 2px 5px"  colspan="4">'.$receipt_mode_type.'</td>
									
								</tr>
								
								<tr>
									<td style="padding:0px 0 2px 5px" colspan="4">Payment of previous bill</td>
									
								</tr>
								
							</tbody></table>
							
							
							
							<table style="font-size:12px;" width="100%" cellspacing="0">
								<tbody><tr>
									<td width="50%" style="padding:5px" valign="top">
									<span style="font-size:16px;"> <b>Rs '.$amount.'</b></span><br>';
									if($receipt_mode=="Cheque"){
									$receipt_title_cheq='Subject to realization of Cheque(s)';
									}
																		
									$html_receipt.='<span>'.@$receipt_title_cheq.'</span></td>
									<td align="center" width="50%" style="padding:5px" valign="top">
									For  <b>'.$society_name.'</b><br><br><br>
									<div><span style="border-top:solid 1px #424141">'.$sig_title.'</span></div>
									</td>
								</tr>
							</tbody></table>
												
							
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2">
                                <table style="background-color:#008dd2;font-size:11px;color:#fff;border:solid 1px #767575;border-top:none" width="100%" cellspacing="0">
                                 <tbody>
								 
									<tr>
                                        <td align="center" colspan="7"><b>
										Your Society is empowered by HousingMatters - <b> <i>"Making Life Simpler"</i>
										</b></b></td>
                                    </tr>
									<tr>
                                        <td width="50" align="right" style="font-size: 10px;"><b>Email :</b></td>
                                        <td width="120" style="color:#fff!important;font-size: 10px;"> 
										<a href="mailto:support@housingmatters.in" style="color:#fff!important" target="_blank"><b>support@housingmatters.in</b></a>
                                        </td>
										<td align="center" style="font-size: 10px;"></td>
                                        <td align="right" style="font-size: 10px;"><b>Phone :</b></td>
                                        <td width="84" style="color:#fff!important;text-decoration:none;font-size:10px;"><b>022-41235568</b></td>
										<td align="center" style="font-size: 10px;"></td>
                                        <td width="100" style="padding-right:10px;text-decoration:none"> <a href="http://www.housingmatters.in" style="color:#fff!important" target="_blank"><b>www.housingmatters.in</b></a></td>
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
        </tbody>
</table>';


////////////////my Email//////////////
}

/////////////////////////////////////////////////////////////////////////////
$this->loadmodel('society');
$condition=array('society_id'=>$s_society_id);
$result_society=$this->society->find('all',array('conditions'=>$condition)); 
$this->set('result_society',$result_society);
foreach($result_society as $data_society){
	$society_name=$data_society["society"]["society_name"];
	$email_is_on_off=(int)@$data_society["society"]["account_email"];
	$sms_is_on_off=(int)@$data_society["society"]["account_sms"];
   }
//////////////////////////////////////////////////////////////////////////


if($email_is_on_off==1){
	$r_sms=$this->hms_sms_ip();
	$working_key=$r_sms->working_key;
	$sms_sender=$r_sms->sms_sender; 
	$sms_allow=(int)$r_sms->sms_allow;

$subject="[".$society_name."]- e-Receipt of Rs ".$amount." on ".date('d-M-Y',$d_date)." against Unit ".$wing_flat."";
   //$subject="[".$society_name."]- Receipt, ".date('d-M-Y',$d_date)."";
	
	
	$this->send_email($to_email,'accounts@housingmatters.in','HousingMatters',$subject,$html_receipt,'donotreply@housingmatters.in');
}

if($sms_is_on_off==1){
if($sms_allow==1){
	
$user_name_short=$this->check_charecter_name($user_name);

$sms="Dear ".$user_name_short." ,we have received Rs ".$amount." on ".$sms_date." towards Society Maint. dues. Cheques are subject to realization,".$society_name;
$sms1=str_replace(' ', '+', $sms);

$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$to_mobile.'&message='.$sms1.''); 
}
}	
			
}
}

$this->Session->write('bank_rrr2',1);
	
$output=json_encode(array('report_type'=>'done','text'=>'Please Fill Date in row'));
die($output);
}
///////////////////////////////// End Save bank Imp ///////////////////////////////////////////////////////////////
///////////////////////////// Start bank receipt html view //////////////////////////////////////////////////////////////
function bank_receipt_html_view($auto_id=null)
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}
 
$this->ath();
  
$auto_id = (int)$auto_id;

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');	


$this->loadmodel('new_cash_bank');
$conditions=array("transaction_id" => $auto_id,"receipt_source"=>1,"society_id"=>$s_society_id);
$cursor1=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

}
///////////////////////////// End bank receipt html view //////////////////////////////////////////////////////////////
////////////////////////Start Bank Receipt Deposit Slip /////////////////////////////////////////////////////////////
function bank_receipt_deposit_slip()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');
$this->set('s_role_id',$s_role_id);

$this->ath();
$this->check_user_privilages();

if(isset($this->request->data['dep_slip']))
{
$arr = array();
$this->loadmodel('new_cash_bank');
$conditions=array('society_id'=>$s_society_id,"receipt_source"=>1,"edit_status"=>"NO");
$cursor2=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
foreach($cursor2 as $data)
{
$trns_id = (int)$data['new_cash_bank']['transaction_id'];
$receipt_mode = $data['new_cash_bank']['receipt_mode'];
$value = @$this->request->data['dd'.$trns_id];
if(!empty($value))
{
$arr[] = $value;

$this->loadmodel('new_cash_bank');
$this->new_cash_bank->updateAll(array("deposit_status" => 1)
,array("transaction_id" => $trns_id));	

}
}
$arrr =implode(",",$arr);
$this->response->header('Location', 'show_deposit_slip?ar='.$arrr.'');
}


$this->loadmodel('new_cash_bank');
$conditions=array('society_id'=>$s_society_id,"receipt_source"=>1,"edit_status"=>"NO");
$cursor1=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('new_cash_bank');
$conditions=array('society_id'=>$s_society_id,"receipt_source"=>1,"edit_status"=>"NO","deposit_status"=>1);
$cursor2=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

}
////////////////////////End Bank Receipt Deposit Slip /////////////////////////////////////////////////////////////

/////////////////////////////Start print_deposit_slip /////////////////////////////////////////////////////////
function print_deposit_slip()
{
$this->layout='blank';
}
/////////////////////////////End print_deposit_slip /////////////////////////////////////////////////////////

///////////////////////////// Start petty_cash_payment_html_view /////////////////////////////////////////////
function petty_cash_payment_html_view($auto_id=null)
{
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');

$this->ath();
$auto_id = (int)$auto_id;


$this->loadmodel('new_cash_bank');
$conditions=array("transaction_id" => $auto_id,"receipt_source"=>4,"society_id"=>$s_society_id);
$cursor1=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

}
///////////////////////////// End petty_cash_payment_html_view /////////////////////////////////////////////

///////////////////////////// Start petty_cash_receipt_html_view /////////////////////////////////////////////
function petty_cash_receipt_html_view($auto_id=null)
{
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');

$this->ath();
$auto_id = (int)$auto_id;


$this->loadmodel('new_cash_bank');
$conditions=array("transaction_id" => $auto_id,"receipt_source"=>3,"society_id"=>$s_society_id);
$cursor1=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

}
///////////////////////////// End petty_cash_Receipt_html_view /////////////////////////////////////////////

///////////////////////////// Start petty_cash_receipt_Update /////////////////////////////////////////////
function petty_cash_receipt_update($auto_id=null)
{
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	$s_role_id = (int)$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id = (int)$this->Session->read('user_id');	

	$auto_id=(int)$auto_id;
	$this->ath();
	//$this->check_user_privilages();
	
	$this->loadmodel('ledger_sub_account');
	$conditions=array("ledger_id" => 33,"society_id"=>$s_society_id);
	$cursor3=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
	$this->set('cursor3',$cursor3);

	$this->loadmodel('new_cash_bank');
	$conditions=array("transaction_id"=>$auto_id,"receipt_source"=>3,"society_id"=>$s_society_id);
	$cursor1=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
	$this->set('cursor1',$cursor1);

}
///////////////////////////// End petty_cash_Receipt_Update /////////////////////////////////////////////

///////////////////////////// Start petty_cash_Payment_Update /////////////////////////////////////////////
function petty_cash_payment_update($auto_id=null)
{
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	$s_role_id = (int)$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id = (int)$this->Session->read('user_id');	

	$auto_id=(int)$auto_id;
	$this->ath();
	//$this->check_user_privilages();
	
	$this->loadmodel('ledger_sub_account');
	$conditions=array("ledger_id" => 33,"society_id"=>$s_society_id);
	$cursor3=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
	$this->set('cursor3',$cursor3);

	$this->loadmodel('new_cash_bank');
	$conditions=array("transaction_id"=>$auto_id,"receipt_source"=>4,"society_id"=>$s_society_id);
	$cursor1=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
	$this->set('cursor1',$cursor1);

}
///////////////////////////// End petty_cash_Payment_Update /////////////////////////////////////////////

///////////////////////////// Start petty_cash_Payment_Update /////////////////////////////////////////////
function bank_payment_html_view($auto_id=null)
{
		if($this->RequestHandler->isAjax()){
		$this->layout='blank';
		}else{
		$this->layout='session';
		}
	
	$s_role_id = (int)$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id = (int)$this->Session->read('user_id');	

	$auto_id=(int)$auto_id;
	$this->ath();
	//$this->check_user_privilages();

		$this->loadmodel('new_cash_bank');
		$conditions=array("transaction_id" => $auto_id,"receipt_source"=>2,"society_id"=>$s_society_id);
		$cursor1=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
		$this->set('cursor1',$cursor1);

		$this->loadmodel('society');
		$conditions=array("society_id" => $s_society_id);
		$cursor2=$this->society->find('all',array('conditions'=>$conditions));
		$this->set('cursor2',$cursor2);

$this->loadmodel('reference');
$conditions=array("auto_id"=>3);
$cursor = $this->reference->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$tds_arr = $collection['reference']['reference'];
}
$this->set("tds_arr",$tds_arr);		
		
}
///////////////////////////// End petty_cash_Payment_Update /////////////////////////////////////////////

///////////////////////////// Start petty_cash_Payment_Update /////////////////////////////////////////////
function bank_pyment_update($auto_id=null)
{
		if($this->RequestHandler->isAjax()){
		$this->layout='blank';
		}else{
		$this->layout='session';
		}
	
	$s_role_id = (int)$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id = (int)$this->Session->read('user_id');	
	
	
	$this->loadmodel('reference');
	$conditions=array("auto_id"=>3);
	$cursor = $this->reference->find('all',array('conditions'=>$conditions));
	foreach($cursor as $collection)
	{
	$tds_arr = $collection['reference']['reference'];
	}
	$this->set("tds_arr",$tds_arr);

	$auto_id=(int)$auto_id;
	$this->ath();
	//$this->check_user_privilages();

		$this->loadmodel('new_cash_bank');
		$conditions=array("transaction_id" => $auto_id,"receipt_source"=>2,"society_id"=>$s_society_id);
		$cursor1=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
		$this->set('cursor1',$cursor1);

		$this->loadmodel('ledger_sub_account');
		$conditions=array("ledger_id" => 33,"society_id"=>$s_society_id);
		$cursor3=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
		$this->set('cursor3',$cursor3);

}
///////////////////////////// End Bank_Payment_Update /////////////////////////////////////////////

//////////////////////////////Start Petty Cash Payment Json //////////////////////////////////////////
function petty_cash_payment_json()
{
$this->layout="";
$this->ath();
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$date=date('d-m-Y');
$time = date(' h:i a', time());


$q=$this->request->query('q');
$q = html_entity_decode($q);
$myArray = json_decode($q, true);
$c = 0;
foreach($myArray as $child)
{
$c++;

if(empty($child[0])){
$output = json_encode(array('type'=>'error', 'text' => 'Transaction Date is Required in row '.$c));
die($output);
}	


  $TransactionDate = $child[0];
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
		$output=json_encode(array('type'=>'error','text'=>'Transaction Date Should be in Open Financial Year in row '.$c));
		die($output);
	}


if(empty($child[1])){
$output = json_encode(array('type'=>'error', 'text' => 'Account Group is Required in row '.$c));
die($output);
}	

if(empty($child[2])){
$output = json_encode(array('type'=>'error', 'text' => 'Expense Party Account is Required in row '.$c));
die($output);
}	

if(empty($child[3])){
$output = json_encode(array('type'=>'error', 'text' => 'Paid From is Required in row '.$c));
die($output);
}	

if(empty($child[4])){
$output = json_encode(array('type'=>'error', 'text' => 'Amount is Required in row '.$c));
die($output);
}	

if(is_numeric($child[4]))
{

}
else
{
$output = json_encode(array('type'=>'error', 'text' => 'Amount Should be Numeric Value in row '.$c));
die($output);
}
}
$rrr_arr = array();
foreach($myArray as $child)
{
$transaction_date = $child[0];
$ac_group = (int)$child[1];
$expense_party = (int)$child[2];
$paid_from = (int)$child[3];
$amount = $child[4];
$narration = $child[5];

$current_date = date('Y-m-d');

$auto=$this->autoincrement('new_cash_bank','transaction_id');
$i=$this->autoincrement_with_receipt_source('new_cash_bank','receipt_id',4);
$rrr_arr[] = $i;
$this->loadmodel('new_cash_bank');
$multipleRowData = Array( Array("transaction_id" => $auto, "receipt_id" => $i,  "user_id" => $expense_party, 
"current_date" => $current_date, "account_type" => $ac_group,"transaction_date" => strtotime($transaction_date), "prepaired_by" => $s_user_id,"narration" => $narration, "account_head" => $paid_from,  "amount" => $amount,"society_id" => $s_society_id,"receipt_source"=>4,"auto_inc"=>"YES"));
$this->new_cash_bank->saveAll($multipleRowData);  

if($ac_group == 1)
{
$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l,"transaction_date"=>strtotime($transaction_date), "debit" => $amount, "credit" =>null,"ledger_account_id" => 15, "ledger_sub_account_id" =>$expense_party, "table_name" =>"new_cash_bank","element_id" => $auto, "society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData);
}
else
{
$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l,"transaction_date"=>strtotime($transaction_date), "debit" => $amount, "credit" =>null,"ledger_account_id" =>$expense_party, "ledger_sub_account_id" =>null,"table_name" =>"new_cash_bank","element_id" => $auto, "society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData);
}

$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l,"transaction_date"=>strtotime($transaction_date), "debit" => null, "credit" =>$amount,"ledger_account_id" =>$paid_from,"ledger_sub_account_id" =>null,"table_name" =>"new_cash_bank","element_id" => $auto, "society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData);
}

$this->Session->write('petty_cc_pp',1);

$rr_shww = implode(",",$rrr_arr);
$output = json_encode(array('type'=>'success', 'text' => 'Petty Cash Payment voucher '.$rr_shww.' generated successfully'));
die($output);
}
//////////////////////////////End Petty Cash Payment Json //////////////////////////////////////////

////////////////////////////// Start Petty Cash receipt update Json //////////////////////////////////////////
function petty_cash_receipt_update_json()
{
$this->layout=null;
$post_data=$this->request->data;
$this->ath();
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$transaction_date = $post_data['dddd'];
$acgroup = (int)$post_data['actpp'];
$party_acc = (int)$post_data['usssr'];
$achddd = (int)$post_data['acheadd'];
$amttt = $post_data['amttt'];
$narration = $post_data['nrrr'];
$element_id = (int)$post_data['elidd'];

$report = array();
if(empty($transaction_date)){
$report[]=array('label'=>'dddd', 'text' => 'Please select transaction date');
}	
	
if(empty($acgroup)){
$report[]=array('label'=>'acggg', 'text' => 'Please select account group');
}	

if(empty($party_acc)){
$report[]=array('label'=>'ussrr', 'text' => 'Please select Income/Party A/c');
}	

if(empty($achddd)){
$report[]=array('label'=>'achdd', 'text' => 'Please select account head');
}	

if(empty($amttt)){
$report[]=array('label'=>'amttt', 'text' => 'Please Fill Amount');
}

if(is_numeric($amttt))
{
}
else
{
$report[]=array('label'=>'amttt', 'text' => 'Please Fill Numeric Amount');
}
	
if(sizeof($report)>0)
{
$output=json_encode(array('report_type'=>'error','report'=>$report));
die($output);
}


$transaction_date = date('Y-m-d',strtotime($transaction_date));

$output=json_encode(array('report_type'=>'publish','text'=>$element_id));
die($output);

$this->new_cash_bank->updateAll(array("user_id" => $party_acc,"account_type" => $acgroup,"transaction_date" => strtotime($transaction_date),"narration" => $narration, "account_head" => $achddd,  "amount"=>$amttt),array('society_id'=>$s_society_id,"transaction_id"=>$element_id));





if($acgroup == 1)
{
$this->ledger->updateAll(array("transaction_date"=>strtotime($transaction_date),"debit"=>null, "credit" =>$amttt,"ledger_account_id" => 34, "ledger_sub_account_id" =>$party_acc),array('society_id'=>$s_society_id,"element_id"=>$element_id,"table_name" =>"new_cash_bank"));
}
else
{
$this->ledger->updateAll(array("transaction_date"=>strtotime($transaction_date), "debit" => null, "credit" =>$amttt,"ledger_account_id" =>$party_acc, "ledger_sub_account_id" =>null),array('society_id'=>$s_society_id,"element_id"=>$element_id,"table_name" =>"new_cash_bank"));
}


$this->ledger->updateAll(array("transaction_date"=>strtotime($transaction_date),"debit" =>$amttt, "credit" =>null,"ledger_account_id" =>$achddd,"ledger_sub_account_id"=>null),array('society_id'=>$s_society_id,"element_id"=>$element_id,"table_name" =>"new_cash_bank"));


$output=json_encode(array('report_type'=>'publish','text'=>'sdgdgdssdgds'));
die($output);

}
////////////////////////////// End Petty Cash receipt update Json //////////////////////////////////////////

///////////////////////////////// Start bank_payment_import_excel ///////////////////////////////////////////
function bank_payment_import_excel()
{
$this->layout="";


$filename="Bank_Payment_Import";
header ("Expires: 0");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . "GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".csv");
header ("Content-Description: Generated Report" );


$this->ath();

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');


$excel = "Transaction Date,Ledger A/c,Amount,TDS in Percentage,Mode of Payment,Instrument/UTR,Bank Account,Invoice Reference,Narration \n";
$excel.="12-10-2015,Sinking Fund,10000,2,NEFT,HHHG4455,SBI,for marketing,narration \n";
echo $excel;

}
///////////////////////////////// End bank_payment_import_excel ///////////////////////////////////////////

/////////////////////////////////// Start bank_payment_import_view //////////////////////////////////////////////
function bank_payment_import_view()
{
$this->layout="blank";
$this->ath();

$s_society_id= (int)$this->Session->read('society_id');

if(isset($_FILES['file'])){
$file_name=$_FILES['file']['name'];
$file_tmp_name =$_FILES['file']['tmp_name'];
$target = "csv_file/bank/";
$target=@$target.basename($file_name);
move_uploaded_file($file_tmp_name,@$target);

$f = fopen('csv_file/bank/'.$file_name, 'r') or die("ERROR OPENING DATA");
$batchcount=0;
$records=0;
while (($line = fgetcsv($f, 4096, ';')) !== false) {
$numcols = count($line);
$test[]=$line;
++$records;
}
fclose($f);
$records;
}
$i=0;
foreach($test as $child)
{
if($i>0)
{
$child_ex=explode(',',$child[0]);
$TransactionDate = $child_ex[0];
$ledger_account = $child_ex[1];
$amount = $child_ex[2];
$tds_persent = $child_ex[3];
$mode = $child_ex[4];
$instrument = $child_ex[5];
$bank_account = $child_ex[6];
$invoice = $child_ex[7];
$narration = $child_ex[8];

  
$this->loadmodel('ledger_account'); 
$conditions=array("ledger_name"=> new MongoRegex('/^' . trim($ledger_account) . '$/i'));
$ledggrr_acc_datt=$this->ledger_account->find('all',array('conditions'=>$conditions));
foreach($ledggrr_acc_datt as $ledggrr_acc_datttaa)
{
$auto_id = (int)$ledggrr_acc_datttaa['ledger_account']['auto_id'];
$typppp = 2;
}

$this->loadmodel('ledger_sub_account'); 
$conditions=array("name"=> new MongoRegex('/^' . trim($ledger_account) . '$/i'),"society_id"=>$s_society_id);
$ledggr_sub_acc_resulltt = $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
foreach($ledggr_sub_acc_resulltt as $ledd_detaill)
{
$auto_id = (int)$ledd_detaill['ledger_sub_account']['auto_id'];
$typppp = 1;
}			

$this->loadmodel('ledger_sub_account'); 
$conditions=array("name"=> new MongoRegex('/^' . trim($bank_account) . '$/i'),"society_id"=>$s_society_id);
$result_ac=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
foreach($result_ac as $collection)
{
$bank_id = (int)$collection['ledger_sub_account']['auto_id'];
}

$table[] = array(@$TransactionDate,@$typppp,@$auto_id,@$amount,@$tds_persent,@$mode,@$instrument,@$bank_id,@$invoice,@$narration);
} 
$i++;
}
$this->set('aaa',$table);

$this->loadmodel('reference');
$conditions=array("auto_id"=>3);
$cursor = $this->reference->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$tds_arr = $collection['reference']['reference'];
}
$this->set("tds_arr",$tds_arr);


$this->loadmodel('ledger_sub_account');
$conditions=array("society_id"=>$s_society_id,"ledger_id"=>15);
$cursor1=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 33,"society_id"=>$s_society_id);
$cursor2=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

$this->loadmodel('accounts_group');
$conditions=array("accounts_id" => 1);
$cursor12=$this->accounts_group->find('all',array('conditions'=>$conditions));
$this->set('cursor12',$cursor12);

$this->loadmodel('accounts_group');
$conditions=array("accounts_id" => 4);
$cursor13=$this->accounts_group->find('all',array('conditions'=>$conditions));
$this->set('cursor13',$cursor13);

}
/////////////////////////////////// End bank_payment_import_view //////////////////////////////////////////////

/////////////////////////////////// Start save_bank_payment_imp //////////////////////////////////////////////
function save_bank_payment_imp()
{
	$this->layout='blank';
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id = (int)$this->Session->read('user_id');
	
	$this->ath();
	
	$q=$this->request->query('q'); 
	$myArray = json_decode($q, true);
		$r=1;
			foreach($myArray as $child){
				$r++;
				$TransactionDate = $child[0];
				$ledger_acount = $child[1];
				$amount = $child[2];
				$tds_amount = $child[3];
				$total_amt = $child[4];
				$mode = $child[5];
				$instrument = $child[6];
				$bank_id = $child[7];
				$invoice_ref = @$child[8];
		        $narration = $child[9];
		
		
		
		if(empty($TransactionDate)){
		$output=json_encode(array('report_type'=>'validation','text'=>'Please fill Transaction Date in row'.$r));
		die($output);
		}

		
		
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
			$output=json_encode(array('report_type'=>'validation','text'=>'Transaction date is not in open Financial Year in row'.$r));
			die($output);
			}
				

		if(empty($ledger_acount)){
		$output=json_encode(array('report_type'=>'validation','text'=>'Please Fill Ledger Account in row'.$r));
		die($output);
		}
	
	
		if(empty($amount)){
		$output=json_encode(array('report_type'=>'validation','text'=>'Please Fill Amount in row'.$r));
		die($output);
		}
	
			if(is_numeric($amount))
			{
			}
			else
			{
			$output=json_encode(array('report_type'=>'validation','text'=>'Please Fill Numeric Amount in row'.$r));
			die($output);
			}

	
		
	

			
		if(empty($mode)){
		$output=json_encode(array('report_type'=>'validation','text'=>'Please Fill Mode in row'.$r));
		die($output);
		}
	
	
		if(empty($instrument)){
		$output=json_encode(array('report_type'=>'validation','text'=>'Please Fill Instrument in row'.$r));
		die($output);
		}

		
	
		if(empty($bank_id)){
		$output=json_encode(array('report_type'=>'validation','text'=>'Please Select bank in row'.$r));
		die($output);
		}
		
}
$current_date = date('Y-m-d');
foreach($myArray as $child){
		$r++;
		$TransactionDate = $child[0];
		$transaction_date = date('Y-m-d',strtotime($TransactionDate));
		$ledger_acount = $child[1];
		$amount = $child[2];
		$tds_id = $child[3];
		$total_amt = $child[4];
		$mode = $child[5];
		$instrument = $child[6];
		$bank_id = $child[7];
		$invoice_ref = @$child[8];
		$narration = $child[9];
        $ins_type = (int)$child[10];
		
$accctyypp = explode(',',$ledger_acount);
$ledger_acc = (int)$accctyypp[0];
$acc_type = (int)$accctyypp[1];

$i=$this->autoincrement('new_cash_bank','transaction_id');
$bbb=$this->autoincrement_with_receipt_source('new_cash_bank','receipt_id',2);
$rr_arr[] = $bbb;
$this->loadmodel('new_cash_bank');
$multipleRowData = Array( Array("transaction_id" => $i, "receipt_id" => $bbb,  "current_date" => $current_date, 
"transaction_date" => strtotime($transaction_date), "prepaired_by" => $s_user_id, 
"user_id" => $ledger_acc, "invoice_reference" => @$invoice_ref,"narration" => $narration, "receipt_mode" => $mode,
"receipt_instruction" => $instrument, "account_head" => $bank_id,  
"amount" => $amount,"society_id" => $s_society_id, "tds_id" =>$tds_id,"account_type"=>$acc_type,"receipt_source"=>2,"auto_inc"=>"YES"));
$this->new_cash_bank->saveAll($multipleRowData);  

//////////////////// End Insert///////////////////////////////
///////////// TDS CALCULATION /////////////////////
$this->loadmodel('reference');
$conditions=array("auto_id" => 3);
$cursor4=$this->reference->find('all',array('conditions'=>$conditions));
foreach($cursor4 as $collection)
{
$tds_arr = $collection['reference']['reference'];	
}
if(!empty($tds_id))
{
for($r=0; $r<sizeof($tds_arr); $r++)
{
$tds_sub_arr = $tds_arr[$r];
$tds_id2 = (int)$tds_sub_arr[1];
if($tds_id2 == $tds_id)
{
$tds_rate = $tds_sub_arr[0];
break;
}
}
$tds_amount = (round(($tds_rate/100)*$amount));
$total_tds_amount = ($amount - $tds_amount);
}
else
{
$total_tds_amount = $amount;
$tds_amount = 0;
}

////////////END TDS CALCULATION //////////////////// 
////////////////START LEDGER ENTRY///////////////////////
if($acc_type == 1)
{
$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l,"transaction_date"=>strtotime($transaction_date), "debit" => $amount, "credit" =>null,"ledger_account_id" => 15, "ledger_sub_account_id" =>$ledger_acc, "table_name" =>"new_cash_bank","element_id" => $i, "society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData); 
}
else
{
$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l,"transaction_date"=>strtotime($transaction_date), "debit" => $amount,"credit" =>null,"ledger_account_id" =>$ledger_acc, "ledger_sub_account_id" =>null, "table_name" =>"new_cash_bank","element_id" =>$i, "society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData); 
}

$sub_account_id_a = (int)$bank_id;
$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l,"transaction_date"=>strtotime($transaction_date), "debit" =>null,"credit" =>$total_tds_amount,"ledger_account_id" =>33, "ledger_sub_account_id" =>$sub_account_id_a, "table_name" =>"new_cash_bank","element_id" =>$i, "society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData); 


if($tds_amount > 0)
{
$sub_account_id_t = 16;
$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l,"transaction_date"=>strtotime($transaction_date), "debit" =>null,"credit" =>$tds_amount,"ledger_account_id" =>$sub_account_id_t, "ledger_sub_account_id" =>null, "table_name" =>"new_cash_bank","element_id" =>$i, "society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData); 
}	

////////////END TDS CALCULATION //////////////////// 

}

$this->Session->write('bank_ppp2',1);

$output=json_encode(array('report_type'=>'done','text'=>'Please Fill Date in row'));
die($output);
}
/////////////////////////////////// End save_bank_payment_imp //////////////////////////////////////////////
////////////////////////////// Start bank_payment_add_row //////////////////////////////////////// 
function bank_payment_add_row()
{
$this->layout='blank';
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');

$this->ath();

$count = (int)$this->request->query('con');
$this->set('count',$count);
//////////////////////////////////////

$this->loadmodel('ledger_sub_account');
$conditions=array("society_id" => $s_society_id, "ledger_id" => 33);
$cursor2=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

$this->loadmodel('master_tds');
$cursor3=$this->master_tds->find('all');
$this->set('cursor3',$cursor3);

$this->loadmodel('reference');
$conditions=array("auto_id"=>3);
$cursor = $this->reference->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$tds_arr = $collection['reference']['reference'];
}
$this->set("tds_arr",$tds_arr);



$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 15,"society_id"=>$s_society_id);
$cursor11=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor11',$cursor11);


$this->loadmodel('accounts_group');
$conditions=array("accounts_id" => 1);
$cursor12=$this->accounts_group->find('all',array('conditions'=>$conditions));
$this->set('cursor12',$cursor12);

$this->loadmodel('accounts_group');
$conditions=array("accounts_id" => 4);
$cursor13=$this->accounts_group->find('all',array('conditions'=>$conditions));
$this->set('cursor13',$cursor13);

}
////////////////////////////// End bank_payment_add_row //////////////////////////////////////// 
////////////////////////// Start show_deposit_slip ///////////////////////////////////////////////////// 
function show_deposit_slip()
{
$this->layout='session';
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = (int)$this->Session->read('user_id');

$this->ath();


$this->loadmodel('society');
$conditions=array("society_id" =>$s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
}

$this->set('society_name',$society_name);

$arrr = $this->request->query('ar');
$this->set('arrr',$arrr);


$this->loadmodel('ledger_sub_account');
$conditions=array('society_id'=>$s_society_id,"ledger_id"=>33);
$cursor=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
foreach($cursor as $data)
{
$bank_account = $data['ledger_sub_account']['bank_account'];
}
$this->set('bank_account',$bank_account);
}
////////////////////////// End show_deposit_slip ///////////////////////////////////////////////////// 

/////////////////////////////// start new bank receipt //////////////////////////////////////////////////
function new_bank_receipt()
{
		if($this->RequestHandler->isAjax())
		{
		$this->layout='blank';
		}else{
		$this->layout='session';
		}

		$this->ath();
		$this->check_user_privilages();

			App::import('', 'sendsms.php');
			$s_role_id=$this->Session->read('role_id');
			$s_society_id = (int)$this->Session->read('society_id');
			$s_user_id = (int)$this->Session->read('user_id');

		$this->set('s_user_id',$s_user_id);
		$this->set('s_role_id',$s_role_id);
		$first_day_this_month = date('01-m-Y'); 
		$this->set('default_date',$first_day_this_month);
		
			$this->loadmodel('user');
			$conditions=array("society_id" => $s_society_id,"user_id" => $s_user_id);
			$cursor=$this->user->find('all',array('conditions'=>$conditions));
			foreach ($cursor as $collection) 
			{
			$tenant_c = (int)$collection['user']['tenant'];
			}
			
		$this->set('tenant_c',$tenant_c);

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


		$this->loadmodel('cash_bank');
		$conditions=array("society_id" => $s_society_id,"module_id"=>1);
		$order=array('cash_bank.receipt_id'=> 'DESC');
		$cursor=$this->cash_bank->find('all',array('conditions'=>$conditions,'order' =>$order,'limit'=>1));
		foreach ($cursor as $collection) 
		{
		$last=$collection['cash_bank']['receipt_id'];
		}
		if(empty($last))
		{
		$zz=0;
		}	
		else
		{	
		$zz=$last;
		}
		$this->set('zz',$zz);



		$this->loadmodel('ledger_sub_account');
		$conditions=array("society_id" => $s_society_id, "ledger_id" => 34,"deactive"=>0);
		$cursor1=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
		$this->set('cursor1',$cursor1);
		foreach($cursor1 as $collection)
		{
		$user_id = (int)@$collection['ledger_sub_account']['user_id'];
		$this->loadmodel('user');
		$conditions=array("user_id" => $user_id);
		$cursor2=$this->user->find('all',array('conditions'=>$conditions));
		$this->set('cursor',$cursor2);
		}
		
			$this->loadmodel('ledger_sub_account');
			$conditions=array("ledger_id" => 33,"society_id"=>$s_society_id);
			$cursor3=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
			$this->set('cursor3',$cursor3);


			
$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 112,"society_id"=>$s_society_id);
$cursor4=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor4',$cursor4);
			
$this->loadmodel('reference');
$conditions=array("auto_id"=>6);
$rfff=$this->reference->find('all',array('conditions'=>$conditions));
foreach($rfff as $dddtttt)
{
$kendo_array = @$dddtttt['reference']['reference'];			
}
if(!empty($kendo_array))
{
@$kendo_implode = implode(",",$kendo_array);
}
$this->set('kendo_implode',@$kendo_implode);


$this->loadmodel('reference');
$conditions=array("auto_id"=>7);
$rfff2=$this->reference->find('all',array('conditions'=>$conditions));
foreach($rfff2 as $dddtttt2)
{
$kendo_array2 = @$dddtttt2['reference']['reference'];			
}
if(!empty($kendo_array2))
{
@$kendo_implode2 = implode(",",$kendo_array2);
}
$this->set('kendo_implode2',@$kendo_implode2);
}
/////////////////////////////// End new bank receipt //////////////////////////////////////////////////

///////////////////////////////////// Start bank_receipt_mode_ajax //////////////////////////////////////
function bank_receipt_amt_ajax()
{
$this->layout="blank";
$s_society_id=$this->Session->read('society_id');
 
 $this->ath();
 
$flat_id = (int)$this->request->query('flat');
$type = (int)$this->request->query('type');
$ccc = (int)$this->request->query('cc');
 
$this->set('flat_id',$flat_id);
$this->set('type',$type);
$this->set('ccc',$ccc);
}
///////////////////////////////////// End bank_receipt_mode_ajax //////////////////////////////////////

////////////////////////// Start bank_receipt_json /////////////////////////////////////////////////////
function bank_receipt_json()
{
		$this->layout='blank';
		$s_society_id = (int)$this->Session->read('society_id');
		$s_user_id = (int)$this->Session->read('user_id');

          $this->ath();	
		
		$q=$this->request->query('q'); 
		$q = html_entity_decode($q);
		$myArray = json_decode($q, true);
		
		$r=0;
		foreach($myArray as $child)
		{
		$r++;

			if(empty($child[0]))
			{
			$output = json_encode(array('type'=>'error', 'text' => 'Transaction Date is Required in row '.$r));
			die($output);
			}
			
			$ddatttt = $child[0];
			$dattttt = date('Y-m-d',strtotime($ddatttt));
			$dddatttt = strtotime($dattttt);
			
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
			$output = json_encode(array('type'=>'error', 'text' => 'Transaction Date Should be in Open Financial Year in row '.$r));
			die($output);
			}

			
			
			
			if(empty($child[1]))
			{
			$output = json_encode(array('type'=>'error', 'text' => 'Deposited In is Required in row '.$r));
			die($output);
			}
		
		if(empty($child[2]))
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Receipt Mode is Required in row '.$r));
		die($output);
		}

if($child[2] == "Cheque")
{		
	if(empty($child[3]))
	{
	$output = json_encode(array('type'=>'error', 'text' => 'Cheque Number is Required in row '.$r));
	die($output);
	}
	
	if(is_numeric($child[3]))
	{
	}	
	else
	{
	$output = json_encode(array('type'=>'error', 'text' => 'Cheque Number Should be Numeric Value in row '.$r));
	die($output);
	}
	
	if(empty($child[4]))
	{
	$output = json_encode(array('type'=>'error', 'text' => 'Cheque Date is Required in row '.$r));
	die($output);
	}
		
		if(empty($child[5]))
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Drawn in which Bank is Required in row '.$r));
		die($output);
		}
		
	if(empty($child[15]))
	{
	$output = json_encode(array('type'=>'error', 'text' => 'Branch of Bank is Required in row '.$r));
	die($output);
	}
		
		
}	
else
{
        if(empty($child[7]))
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Reference/Utr is Required in row '.$r));
		die($output);
		}		
		
		if(empty($child[6]))
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Date is Required in row '.$r));
		die($output);
		}

}		
		if(empty($child[8]))
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Received From is Required in row '.$r));
		die($output);
		}
		
 if($child[8] == 1)
 {
 
		if(empty($child[9]))
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Select Resident is Required in row '.$r));
		die($output);
		}
 
		if(empty($child[10]))
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Receipt Type is Required in row '.$r));
		die($output);
		}
}
else
{
		if(empty($child[11]))
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Party Name is Required in row '.$r));
		die($output);
		}

		if(empty($child[12]))
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Bill Reference is Required in row '.$r));
		die($output);
		}
        }		
		
		if(empty($child[13]))
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Amount is Required in row '.$r));
		die($output);
		}

		if(is_numeric($child[13]))
		{
		}
		else
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Amount Should be Numeric Value in row '.$r));
		die($output);
		}
}
$receipt_arr = array();
foreach($myArray as $child)
{
		$current_date = date('Y-m-d');
		$receipt_date = $child[0];
			$TransactionDate = date('Y-m-d',strtotime($receipt_date));
			$TransactionDate = strtotime($TransactionDate); 

		$deposited_bank_id = (int)$child[1];
		$receipt_mode = $child[2];
			if($receipt_mode == "Cheque")
			{
				$cheque_number = $child[3];
				$cheque_date = $child[4];
				$drawn_on_which_bank = $child[5];

			 $branch = $child[15]; 
				
				
				
		    $knddd = "&quot;".$branch."&quot;";
			$this->loadmodel('reference');
			$conditions=array("auto_id"=>7);
			$rfff=$this->reference->find('all',array('conditions'=>$conditions));
			foreach($rfff as $dddttt)
			{
			$knnddd = @$dddttt['reference']['reference'];			
			}
				$nnnn = 555;
				for($n=0; $n<sizeof($knnddd); $n++)
				{
				$kendo_name = $knnddd[$n];
				if($kendo_name == $knddd)
				{
				$nnnn = 5;
				break;
				}
				else
				{
				$nnnn = 555;
				}
				}
					
						if($nnnn == 555){
						$knnddd[] = $knddd;
						$this->loadmodel('reference');
						$this->reference->updateAll(array("reference" => $knnddd),array("auto_id" =>7));
						}		
				
				
				
				
				
			$knddd = "&quot;".$drawn_on_which_bank."&quot;";
			$this->loadmodel('reference');
			$conditions=array("auto_id"=>6);
			$rfff=$this->reference->find('all',array('conditions'=>$conditions));
			foreach($rfff as $dddttt)
			{
			$knnddd = @$dddttt['reference']['reference'];			
			}
				$nnn = 555;
				for($n=0; $n<sizeof($knnddd); $n++)
				{
				$kendo_name = $knnddd[$n];
				if($kendo_name == $knddd)
				{
				$nnn = 5;
				break;
				}
				else
				{
				$nnn = 555;
				}
				}
					
						if($nnn == 555){
						$knnddd[] = $knddd;
						$this->loadmodel('reference');
						$this->reference->updateAll(array("reference" => $knnddd),array("auto_id" =>6));
						}			
				}
					else
					{
					$reference_utr = $child[7];
					$cheque_date = $child[6];
					}		
		$member_type = (int)$child[8];
				if($member_type == 1)
				{
					$party_name = (int)$child[9];
					$receipt_type = (int)$child[10];
					$flat_id = $party_name;
					}
				else
				{
				$party_name = $child[11];
				$bill_reference = $child[12];
				}
		$amount = $child[13];
		$narration = $child[14];
       
		
///////////////////////////
if($member_type == 1)
{
	if($receipt_type == 1)
	{
     //apply receipt in regular_bill//
	 
	 $result_new_regular_bill = $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_last_bill_info_via_flat_id'),array('pass'=>array($flat_id)));
	
	 $auto_id=null; $regular_bill_one_time_id=null;
	if(sizeof($result_new_regular_bill)>0){
		foreach($result_new_regular_bill as $data){
	$auto_id=$data["auto_id"];  
	$edit_status=$data["edit_status"]; 
	$latest_bill=@$data["latest_bill"]; 
	$receipt_applied=@$data["receipt_applied"]; 
	$regular_bill_one_time_id = (int)$data["one_time_id"];
	$flat_id = (int)$data["flat_id"];
	if($edit_status=="NO" && $latest_bill=="YES"){
			if(empty($receipt_applied)){
				$arrear_intrest=$data["arrear_intrest"];
				$intrest_on_arrears=$data["intrest_on_arrears"];
				$total=$data["total"];
				$arrear_maintenance=$data["arrear_maintenance"];
			}else{
				$arrear_intrest=$data["new_arrear_intrest"];
				$intrest_on_arrears=$data["new_intrest_on_arrears"];
				$total=$data["new_total"];
				$arrear_maintenance=$data["new_arrear_maintenance"];
			}
	}else{
		$number_of_receipt=$this->count_receipt_against_bill($regular_bill_one_time_id,$flat_id);
		if($number_of_receipt==0){
			$arrear_intrest=$data["arrear_intrest"];
			$intrest_on_arrears=$data["intrest_on_arrears"];
			$total=$data["total"];
			$arrear_maintenance=$data["arrear_maintenance"]; 
		}else{
			$arrear_intrest=$data["new_arrear_intrest"];
			$intrest_on_arrears=$data["new_intrest_on_arrears"];
			$total=$data["new_total"];
			$arrear_maintenance=$data["new_arrear_maintenance"];
		}
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
		$this->new_regular_bill->updateAll(array('new_arrear_intrest'=>$new_arrear_intrest,"new_intrest_on_arrears"=>$new_intrest_on_arrears,"new_arrear_maintenance"=>$new_arrear_maintenance,"new_total"=>$new_total),array('auto_id'=>$auto_id));
	}
	
			
		$t1=$this->autoincrement('new_cash_bank','transaction_id');
		$k = (int)$this->autoincrement_with_receipt_source('new_cash_bank','receipt_id',1); 
		$this->loadmodel('new_cash_bank');
		$multipleRowData = Array( Array("transaction_id"=> $t1,"receipt_id" => $k, 
		"receipt_date" => $TransactionDate, "receipt_mode" => $receipt_mode, 
		"cheque_number" =>@$cheque_number,"cheque_date" =>$cheque_date,
		"drawn_on_which_bank" =>@$drawn_on_which_bank,"reference_utr" => @$reference_utr,
		"deposited_bank_id" => $deposited_bank_id,"member_type" => $member_type,
		"party_name_id"=>$party_name,"receipt_type" => $receipt_type,"amount" => $amount,
		"current_date" => $current_date,"society_id"=>$s_society_id,"flat_id"=>$party_name,
		"bill_auto_id"=>$auto_id,"bill_one_time_id"=>$regular_bill_one_time_id,"narration"=>$narration,
		"receipt_source"=>1,"edit_status"=>"NO","auto_inc"=>"YES","prepaired_by" => $s_user_id,"bank_branch"=>@$branch,"is_cancel"=>"NO"));
		$this->new_cash_bank->saveAll($multipleRowData);
	    $receipt_arr[] = $k;
	
	
		$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'ledger_SubAccount_dattta_by_flat_id'),array('pass'=>array($party_name)));
		foreach($result_flat_info as $flat_info){
		$account_id = (int)$flat_info["ledger_sub_account"]["auto_id"];
		}


$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l, "transaction_date"=> $TransactionDate, "debit" => $amount, "credit" =>null,"ledger_account_id" => 33, "ledger_sub_account_id" => $deposited_bank_id, "table_name" => "new_cash_bank","element_id" => $t1, "society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData); 

$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l, "transaction_date"=> $TransactionDate, "credit" => $amount, "debit" =>null,"ledger_account_id" => 34, "ledger_sub_account_id" => $account_id,"table_name" => "new_cash_bank","element_id" => $t1, "society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData);
//////////////////////////////////////////////////


$this->loadmodel('new_cash_bank');
$conditions=array("receipt_id" => $k,"receipt_source"=>1,"society_id"=>$s_society_id);
$cursor=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$receipt_no = (int)$collection['new_cash_bank']['receipt_id'];
$d_date = $collection['new_cash_bank']['receipt_date'];
$today = date("d-M-Y");
$flat_id = $collection['new_cash_bank']['party_name_id'];
$amount = $collection['new_cash_bank']['amount'];
$society_id = (int)$collection['new_cash_bank']['society_id'];
$bill_reference = $collection['new_cash_bank']['reference_utr'];
$narration = $collection['new_cash_bank']['narration'];
$member = (int)$collection['new_cash_bank']['member_type'];
$receiver_name = @$collection['new_cash_bank']['receiver_name'];
$receipt_mode = $collection['new_cash_bank']['receipt_mode'];
$cheque_number = @$collection['new_cash_bank']['cheque_number'];
$which_bank = @$collection['new_cash_bank']['drawn_on_which_bank'];
$reference_number = @$collection['new_cash_bank']['reference_number'];
$cheque_date = @$collection['new_cash_bank']['cheque_date'];
$sub_account = (int)$collection['new_cash_bank']['deposited_bank_id'];
$sms_date=date("d-m-Y",($d_date));

$amount = str_replace( ',', '', $amount );
$am_in_words=ucwords($this->requestAction(array('controller' => 'hms', 'action' => 'convert_number_to_words'), array('pass' => array($amount))));

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
foreach ($cursor2 as $collection) 
{
$society_name = $collection['society']['society_name'];
$society_reg_no = $collection['society']['society_reg_num'];
$society_address = $collection['society']['society_address'];
$sig_title = $collection['society']['sig_title'];
}
if($member == 2)
{
$user_name = $receiver_name;
$wing_flat = "";
}
else
{
$flatt_datta = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
foreach ($flatt_datta as $fltt_datttaa) 
{
$wnngg_idddd = (int)$fltt_datttaa['flat']['wing_id'];
}

$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wnngg_idddd,$flat_id)));
foreach ($result_lsa as $collection) 
{
$wing_id = $collection['user']['wing'];  
$flat_id = (int)$collection['user']['flat'];
$tenant = (int)$collection['user']['tenant'];
$user_name = $collection['user']['user_name'];
$to_mobile = $collection['user']['mobile'];
$to_email = $collection['user']['email'];
}
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action'=>'wing_flat'),array('pass'=>array($wing_id,$flat_id)));									
}  
$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($sub_account))); 
foreach($result2 as $collection)
{
$bank_name = $collection['ledger_sub_account']['name'];
}
                                    
$ip=$this->hms_email_ip();
$date=date("d-m-Y",($d_date));

$html_receipt='<table style="padding:24px;background-color:#34495e" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
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
<a href="https://www.facebook.com/HousingMatters.co.in"><img src="'.$ip.$this->webroot.'/as/hm/SMLogoFB.png" style="max-height: 30px; height: 30px; width: 30px; max-width: 30px;" height="30px" width="30px" /></a>
</td>
</tr>
							</table>
							</td>
						</tr>
						<tr>
							<td height="10"></td>
						</tr>
                        <tr>
                            <td colspan="2" style="font-size:12px;line-height:1.4;font-family:Arial,Helvetica,sans-serif;color:#34495e;border:solid 1px #767575">
							<table style="font-size:12px" width="100%" cellspacing="0">
								<tbody><tr>
									<td style="padding:2px;background-color:rgb(0,141,210);color:#fff" align="center" width="100%"><b>'.strtoupper($society_name).'</b></td>
								</tr>
							</tbody></table>
							<table style="font-size:12px" width="100%" cellspacing="0">
								<tbody>
								<tr>
									<td style="padding:5px;border-bottom:solid 1px #767575;border-top:solid 1px #767575" width="100%" align="center">
									<span style="color:rgb(100,100,99)">Regn# &nbsp; '.$society_reg_no.'</span><br>
									<span style="color:rgb(100,100,99)">'.$society_address.'</span><br
									</td>
								</tr>
								</tbody>
							</table>
							<table style="font-size:12px;border-bottom:solid 1px #767575;" width="100%" cellspacing="0">
								<tbody><tr>
									<td style="padding:0px 0 2px 5px" colspan="2">Receipt No: '.$receipt_no.'</td>
									
									<td colspan="2" align="right" style="padding:0px 5px 0 0px"><b>Date:</b> '.$date.' </td>
									
								</tr>
								<tr>
									<td style="padding:0px 0 2px 5px" colspan="2"> Received with thanks from: <b>'.$user_name.' '.$wing_flat.'</b></td>
																		
								</tr>
								<tr>
									<td style="padding:0px 0 2px 5px"  colspan="4">Rupees '.$am_in_words.' Only </td>
									
								</tr>';
								
							if($receipt_mode=="Cheque"){
							$receipt_mode_type='Via '.$receipt_mode.'-'.$cheque_number.' drawn on '.$which_bank.' dated '.$cheque_date;
							}
							else{
							$receipt_mode_type='Via '.$receipt_mode.'-'.$reference_number.' dated '.$cheque_date;
							}

								
								$html_receipt.='<tr>
									<td style="padding:0px 0 2px 5px"  colspan="4">'.$receipt_mode_type.'</td>
									
								</tr>
								
								<tr>
									<td style="padding:0px 0 2px 5px" colspan="4">Payment of previous bill</td>
									
								</tr>
								
							</tbody></table>
							
							
							
							<table style="font-size:12px;" width="100%" cellspacing="0">
								<tbody><tr>
									<td width="50%" style="padding:5px" valign="top">
									<span style="font-size:16px;"> <b>Rs '.$amount.'</b></span><br>';
									if($receipt_mode=="Cheque"){
									$receipt_title_cheq='Subject to realization of Cheque(s)';
									}
																		
									$html_receipt.='<span>'.@$receipt_title_cheq.'</span></td>
									<td align="center" width="50%" style="padding:5px" valign="top">
									For  <b>'.$society_name.'</b><br><br><br>
									<div><span style="border-top:solid 1px #424141">'.$sig_title.'</span></div>
									</td>
								</tr>
							</tbody></table>
												
							
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2">
                                <table style="background-color:#008dd2;font-size:11px;color:#fff;border:solid 1px #767575;border-top:none" width="100%" cellspacing="0">
                                 <tbody>
								 
									<tr>
                                        <td align="center" colspan="7"><b>
										Your Society is empowered by HousingMatters - <b> <i>"Making Life Simpler"</i>
										</b></b></td>
                                    </tr>
									<tr>
                                        <td width="50" align="right" style="font-size: 10px;"><b>Email :</b></td>
                                        <td width="120" style="color:#fff!important;font-size: 10px;"> 
										<a href="mailto:support@housingmatters.in" style="color:#fff!important" target="_blank"><b>support@housingmatters.in</b></a>
                                        </td>
										<td align="center" style="font-size: 10px;"></td>
                                        <td align="right" style="font-size: 10px;"><b>Phone :</b></td>
                                        <td width="84" style="color:#fff!important;text-decoration:none;font-size:10px;"><b>022-41235568</b></td>
										<td align="center" style="font-size: 10px;"></td>
                                        <td width="100" style="padding-right:10px;text-decoration:none"> <a href="http://www.housingmatters.in" style="color:#fff!important" target="_blank"><b>www.housingmatters.in</b></a></td>
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
        </tbody>
</table>';
////////////////my Email//////////////
}


/////////////////////////////////////////////////////////////////////////////
$this->loadmodel('society');
$condition=array('society_id'=>$s_society_id);
$result_society=$this->society->find('all',array('conditions'=>$condition)); 
$this->set('result_society',$result_society);
foreach($result_society as $data_society){
	$society_name=$data_society["society"]["society_name"];
	$email_is_on_off=(int)@$data_society["society"]["account_email"];
	$sms_is_on_off=(int)@$data_society["society"]["account_sms"];
   }
//////////////////////////////////////////////////////////////////////////


if($email_is_on_off==1){
////email code//
$r_sms=$this->hms_sms_ip();
$working_key=$r_sms->working_key;
$sms_sender=$r_sms->sms_sender; 
$sms_allow=(int)$r_sms->sms_allow;

$subject="[".$society_name."]- e-Receipt of Rs ".$amount." on ".date('d-M-Y',$d_date)." against Unit ".$wing_flat."";
//$subject = "[".$society_name."]- Receipt,"date('d-M-Y',$d_date).""; 

$this->send_email($to_email,'accounts@housingmatters.in','HousingMatters',$subject,$html_receipt,'donotreply@housingmatters.in');

}

if($sms_is_on_off==1){
	if($sms_allow==1){

	
$r_sms=$this->hms_sms_ip();
$working_key=$r_sms->working_key;
$sms_sender=$r_sms->sms_sender; 
$sms_allow=(int)$r_sms->sms_allow;
$user_name_short=$this->check_charecter_name($user_name);
$sms="Dear ".$user_name_short." ,we have received Rs ".$amount." on ".$sms_date." towards Society Maint. dues. Cheques are subject to realization,".$society_name;
$sms1=str_replace(' ', '+', $sms);

$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$to_mobile.'&message='.$sms1.''); 
}
}	
//////////////////////////////////////////////////////////////////////////////
		
}
if($receipt_type == 2)
	{
	$t2=$this->autoincrement('new_cash_bank','transaction_id');
	$k = (int)$this->autoincrement_with_receipt_source('new_cash_bank','receipt_id',1);
	$this->loadmodel('new_cash_bank');
	$multipleRowData = Array( Array("transaction_id"=>$t2, "receipt_id" => $k, 
	"receipt_date" => $TransactionDate, "receipt_mode" => $receipt_mode, "cheque_number" =>@$cheque_number,
	"cheque_date" =>$cheque_date,"drawn_on_which_bank" =>@$drawn_on_which_bank,
	"reference_utr" => @$reference_utr,"deposited_bank_id" => $deposited_bank_id,"member_type" => $member_type,
	"party_name_id"=>$party_name,"receipt_type" => $receipt_type,"amount" => $amount,
	"current_date" => $current_date,"society_id"=>$s_society_id,"flat_id"=>$party_name,
	"narration"=>$narration,"receipt_source"=>1,"prepaired_by" => $s_user_id,
	"edit_status"=>"NO","auto_inc"=>"YES","bank_branch"=>@$branch));
	$this->new_cash_bank->saveAll($multipleRowData);
     $receipt_arr[] = $k;
	
	
$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'ledger_SubAccount_dattta_by_flat_id'),array('pass'=>array($party_name)));
foreach($result_flat_info as $flat_info){
$account_id = (int)$flat_info["ledger_sub_account"]["auto_id"];
}

$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l, "transaction_date"=> $TransactionDate, "debit" => $amount, "credit" =>null, "ledger_account_id" => 33, "ledger_sub_account_id" => $deposited_bank_id,"table_name" => "new_cash_bank","element_id" => $t2, "society_id" => $s_society_id,));
$this->ledger->saveAll($multipleRowData); 

$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l, "transaction_date"=> $TransactionDate, "credit" => $amount, "debit" =>null, "ledger_account_id" => 34, "ledger_sub_account_id" => $account_id,"table_name" => "new_cash_bank","element_id" => $t2, "society_id" => $s_society_id,));
$this->ledger->saveAll($multipleRowData);
	
}
}
else if($member_type == 2)
{
$t3=$this->autoincrement('new_cash_bank','transaction_id');
$k = (int)$this->autoincrement_with_receipt_source('new_cash_bank','receipt_id',1);
$this->loadmodel('new_cash_bank');
$multipleRowData = Array( Array("transaction_id"=>$t3,"receipt_id" => $k,"receipt_date" => $TransactionDate,
"receipt_mode" => $receipt_mode, "cheque_number" =>@$cheque_number,"cheque_date" =>$cheque_date,
"drawn_on_which_bank" =>@$drawn_on_which_bank,"reference_utr" => @$reference_utr,
"deposited_bank_id" => $deposited_bank_id,"member_type" => $member_type,"party_name_id"=>$party_name,
"receipt_type" => @$receipt_type,"amount" => $amount,
"current_date" => $current_date,"society_id"=>$s_society_id,"flat_id"=>$party_name,
"narration"=>$narration,"bill_reference"=>$bill_reference,"receipt_source"=>1,
"prepaired_by" => $s_user_id,"edit_status"=>"NO","auto_inc"=>"YES","bank_branch"=>@$branch));
$this->new_cash_bank->saveAll($multipleRowData);
$receipt_arr[] = $k;

$party_name = (int)$party_name;
$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l, "transaction_date"=> $TransactionDate, "debit" => $amount, "credit" =>null, "ledger_account_id" => 33, "ledger_sub_account_id" => $deposited_bank_id,"table_name" => "new_cash_bank","element_id" => $t3, "society_id" => $s_society_id,));
$this->ledger->saveAll($multipleRowData); 

$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l, "transaction_date"=> $TransactionDate, "credit" => $amount, "debit" =>null, "ledger_account_id" => 112, "ledger_sub_account_id" => $party_name,"table_name" => "new_cash_bank","element_id" => $t3,"society_id" => $s_society_id,));
$this->ledger->saveAll($multipleRowData);







}
	
$result_new_regular_bill = $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_last_bill_info_via_flat_id'),array('pass'=>array($party_name)));
if(sizeof($result_new_regular_bill)==1){
foreach($result_new_regular_bill as $last_bill){
$bill_auto_id=$last_bill["auto_id"];
$bill_one_time_id=$last_bill["one_time_id"];
}
}		
		
}
$arr_rrr = implode(',',$receipt_arr);
$this->Session->write('new_bank_rrr', 1);
$output = json_encode(array('type'=>'success', 'text' => 'The Bank Receipt #'.$arr_rrr.' Generated Sucessfully'));
die($output);
}
////////////////////////// End bank_receipt_json ////////////////////////////////////////////////////////
////////////////////////////// Start new_bank_receipt_reference_ajax ///////////////////////////////////////
function new_bank_receipt_reference_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->ath();

//$flat_id = (int)$this->request->query('value1'); 
$flat_id = (int)$this->request->query('flat');
$type = (int)$this->request->query('rf');
$this->set('type',$type);
$this->set('flat_id',$flat_id);
//$this->set('flat_id',$flat_id);
}
///////////////////////////// End new_bank_receipt_reference_ajax ///////////////////////////////////////

/////////////////////////////////// Start petty_cash_payment_add_row ////////////////////////////////////////////
function petty_cash_payment_add_row()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->ath();

$count = (int)$this->request->query('con');
$this->set('count',$count);

}
/////////////////////////////////// End petty_cash_payment_add_row ////////////////////////////////////////////
///////////////////////////////////// Start Fixed Deposit Bar chart /////////////////////////////////////////////
function fixed_deposit_bar_chart()
{
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
		$this->ath();
		$this->check_user_privilages();
		
		$s_society_id=(int)$this->Session->read('society_id');
		$s_user_id= (int)$this->Session->read('user_id');



$this->loadmodel('fix_deposit');
$conditions=array('society_id'=>$s_society_id,"matured_status"=>1);
$cursor1=$this->fix_deposit->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);



}
///////////////////////////////////// End Fixed Deposit Bar chart /////////////////////////////////////////////
//////////////////////////////////// Start fixed_deposit_bar_chart_ajax ////////////////////////////////////////// 
function fixed_deposit_bar_chart_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->ath();

$from = $this->request->query('date1');
$to = $this->request->query('date2');

$this->set('from',$from);
$this->set('to',$to);


$this->loadmodel('fix_deposit');
$conditions=array('society_id'=>$s_society_id,"matured_status"=>1);
$cursor1=$this->fix_deposit->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

}
//////////////////////////////////// End fixed_deposit_bar_chart_ajax //////////////////////////////////////////

/////////////////////////////////// Start matured_deposit_add //////////////////////////////////////////
function matured_deposit_add()
{
		if($this->RequestHandler->isAjax()){
		$this->layout='blank';
		}else{
		$this->layout='session';
		}
		
		$this->ath();
		$this->check_user_privilages();
		
		$s_society_id=(int)$this->Session->read('society_id');
		$s_user_id= (int)$this->Session->read('user_id');

		
if(isset($this->request->data['sub']))
{		
$arr = array();	
$this->loadmodel('fix_deposit');
$conditions=array('society_id'=>$s_society_id,"matured_status"=>1);
$cursor=$this->fix_deposit->find('all',array('conditions'=>$conditions));
foreach($cursor as $dataaa)	
{
$receipt_id = (int)$dataaa['fix_deposit']['receipt_id'];
$auto_id = (int)$dataaa['fix_deposit']['transaction_id'];
$value = (int)@$this->request->data['app'.$auto_id];
if($value == 1)
{
$arr[] = $receipt_id;
$this->loadmodel('fix_deposit');
$this->fix_deposit->updateAll(array('matured_status'=>2),array('transaction_id'=>$auto_id,"society_id"=>$s_society_id));
}
}
$arrrr = implode(',',$arr);

?>

<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<p style="font-size:15px; font-weight:600;">Fixed Deposit Receipt <?php echo $arrrr; ?> is updated suceesfully</p>
</div>
<div class="modal-footer">
<a href="matured_deposit_add" class="btn green">OK</a>
</div>
</div>
<?php
}		

}
/////////////////////////////////// End matured_deposit_add //////////////////////////////////////////
/////////////////////////////////// Start matured_deposit_approve //////////////////////////////////////////
function matured_deposit_approve_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->ath();

$from = $this->request->query('date1');
$to = $this->request->query('date2');

$this->set('from',$from);
$this->set('to',$to);


$from = date('Y-m-d',strtotime($from));
$to = date('Y-m-d',strtotime($to));

$from = strtotime($from);
$to = strtotime($to);

$this->loadmodel('fix_deposit');
$conditions=array('society_id'=>$s_society_id,"matured_status"=>1,'fix_deposit.maturity_date'=>array('$gte'=>$from,'$lte'=>$to));
$cursor1=$this->fix_deposit->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);


$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor2 as $dataa)
{
$society_name = $dataa['society']['society_name'];
}
$this->set('society_name',$society_name);
}
/////////////////////////////////// End matured_deposit_approve //////////////////////////////////////////
//////////////////////////// Start matured_deposit_excel /////////////////////////////////////////////////// 
function matured_deposit_excel()
{
$this->layout="";
$this->ath();

$s_society_id = (int)$this->Session->read('society_id');
$s_role_id= (int)$this->Session->read('role_id');
$s_user_id= (int)$this->Session->read('user_id');

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
}

$currr_dateee = date('d-M-Y');

$socc_namm = str_replace(' ', '_', $society_name);

$filename="".$socc_namm."Matured_Fixed_Deposits";

//$filename="Fix Deposit Excel";
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
<th colspan='9' style='text-align:center;'>$society_name Fixed Deposit Register $currr_dateee</th>
</tr>
<tr>
<th>Deposit ID</th>
<th>Bank name</th>
<th>Bank Branch</th>
<th>Account Reference</th>
<th>Start Date</th>
<th>Maturity Date</th>
<th>Interest Rate</th>
<th>Principal Amount</th>
<th>Purpose</th>
</tr>";

$tt_amt = 0;
$this->loadmodel('fix_deposit');
$order=array('fix_deposit.start_date'=>'ASC');
$conditions=array('society_id'=>$s_society_id,"matured_status"=>2);
$cursor1=$this->fix_deposit->find('all',array('conditions'=>$conditions,'order'=>$order));
foreach($cursor1 as $data)
{
$receipt_id = $data['fix_deposit']['receipt_id'];
$start_date = $data['fix_deposit']['start_date'];	
$bank_name = $data['fix_deposit']['bank_name'];	
$branch = $data['fix_deposit']['bank_branch'];	
$rate = $data['fix_deposit']['interest_rate'];	
$mat_date = $data['fix_deposit']['maturity_date'];	
$remarks = $data['fix_deposit']['purpose'];		
$reference = $data['fix_deposit']['account_reference'];		
$amt = $data['fix_deposit']['principal_amount'];
$file_name = $data['fix_deposit']['file_name'];
@$renewal = @$data['fix_deposit']['renewal'];

$start_date	= date('d-m-Y',($start_date));	
$mat_date	= date('d-m-Y',($mat_date));
if($renewal != 'y')
{
	$tt_amt = $tt_amt + $amt;
$excel.="<tr>
<td>$receipt_id</td>
<td>$bank_name</td>
<td>$branch</td>
<td>$reference</td>
<td>$start_date</td>
<td>$mat_date</td>
<td>$rate</td>
<td>$amt</td>
<td>$remarks</td>
</tr>";
}}
$excel.="<tr><td colspan='7' style='text-align:right;'><b>Total</b></td>
            <td><b>$tt_amt</b></td>
            <td></td></tr>
</table>";	

echo $excel;
}
//////////////////////////// End matured_deposit_excel /////////////////////////////////////////////////// 
/////////////////////////////// Start bar_chart_pdf ///////////////////////////////////////////////////////// 
function bar_chart_pdf()
{
$this->layout = 'pdf'; //this will use the pdf.ctp layout 
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$this->ath();

$from = $this->request->query('date1');
$to = $this->request->query('date2');

$this->set('from',$from);
$this->set('to',$to);


$this->loadmodel('fix_deposit');
$conditions=array('society_id'=>$s_society_id,"matured_status"=>1);
$cursor1=$this->fix_deposit->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);
}
/////////////////////////////// End bar_chart_pdf ///////////////////////////////////////////////////////// 
////////////////////////////// Start active_deposit_edit //////////////////////////////////////////////////
function active_deposit_edit()
{
$this->layout = 'session'; 
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$this->ath();

$receipt_id = (int)$this->request->query('rccidd');

$this->loadmodel('fix_deposit');
$conditions=array('society_id'=>$s_society_id,"matured_status"=>1,"transaction_id"=>$receipt_id);
$cursor1=$this->fix_deposit->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('reference');
$conditions=array("auto_id"=>6);
$rfff=$this->reference->find('all',array('conditions'=>$conditions));
foreach($rfff as $dddtttt)
{
$kendo_array = @$dddtttt['reference']['reference'];			
}
if(!empty($kendo_array))
{
$kendo_implode = implode(",",$kendo_array);
}
$this->set('kendo_implode',@$kendo_implode);

$this->loadmodel('reference');
$conditions=array("auto_id"=>7);
$rfff2=$this->reference->find('all',array('conditions'=>$conditions));
foreach($rfff2 as $dddtttt2)
{
$kendo_array2 = @$dddtttt2['reference']['reference'];			
}
if(!empty($kendo_array2))
{
$kendo_implode2 = implode(",",$kendo_array2);
}
$this->set('kendo_implode2',@$kendo_implode2);








if(isset($this->request->data['subbb']))
{
$bank_name = $this->request->data['bank_name'];
$branch = $this->request->data['branch'];
$reference = $this->request->data['reference'];
$amount = $this->request->data['amount'];
$start_date = $this->request->data['start_date'];
$maturity_date = $this->request->data['maturity_date'];
$rate = $this->request->data['rate'];
$remarks = $this->request->data['purpose'];
$receipt_iddd = (int)$this->request->data['rriddd'];
$current_date = date('Y-m-d');
$file_name=@$_FILES["file2"]["name"];
$transaction_id = (int)$this->request->data['ttrcidd'];

$start_date = date('Y-m-d',strtotime($start_date));
$maturity_date = date('Y-m-d',strtotime($maturity_date));

$target = "fix_deposit/";
$target = $target . basename($_FILES['file2']['name']);
move_uploaded_file($_FILES['file2']['tmp_name'], $target);

$this->loadmodel('fix_deposit');
$this->fix_deposit->updateAll(array("bank_name" =>$bank_name,"bank_branch"=>$branch,
"account_reference"=>$reference, "principal_amount"=>$amount,"start_date"=>strtotime($start_date),
"maturity_date"=>strtotime($maturity_date),"interest_rate"=>$rate,"purpose"=>$remarks,
"society_id"=>$s_society_id,"file_name"=>$file_name),array("transaction_id" => $transaction_id));

?>
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
Fixed Deposit #<?php echo $receipt_iddd; ?> is updated successfully
</div>
<div class="modal-footer">
<a href="fix_deposit_view" class="btn red">OK</a>
</div>
</div>
<?php
}
}
////////////////////////////// End active_deposit_edit ////////////////////////////////////
///////////////////////////////// Start renewal_fixed_deposit /////////////////////////////////////////////////
function renewal_fixed_deposit()
{
$this->layout = 'session'; 
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=(int)$this->Session->read('user_id');	

$this->ath();

$receipt_id = (int)$this->request->query('nn');

$this->loadmodel('fix_deposit');
$conditions=array('society_id'=>$s_society_id,"matured_status"=>1,"transaction_id"=>$receipt_id);
$cursor1=$this->fix_deposit->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

if(isset($this->request->data['subbb']))
{
$amount = $this->request->data['amount'];
$start_date = $this->request->data['start_date'];
$maturity_date = $this->request->data['maturity_date'];
$rate = $this->request->data['rate'];
$remarks = @$this->request->data['purpose'];
$receipt_iddddd = (int)$this->request->data['rriddd'];

$file_name=@$_FILES["file2"]["name"];

$target = "fix_deposit/";
$target = $target . basename($_FILES['file2']['name']);
move_uploaded_file($_FILES['file2']['tmp_name'], $target);

$current_date = date('Y-m-d');

$this->loadmodel('fix_deposit');
$conditions=array('society_id'=>$s_society_id,"matured_status"=>1,"transaction_id"=>$receipt_iddddd);
$cursor=$this->fix_deposit->find('all',array('conditions'=>$conditions));
foreach($cursor as $dataaa)
{
$bank_name = $dataaa['fix_deposit']['bank_name'];
$branch = $dataaa['fix_deposit']['bank_branch'];
$reference = $dataaa['fix_deposit']['account_reference'];
$receipt_idddd = $dataaa['fix_deposit']['receipt_id'];
@$renewal_id = (int)@$dataaa['fix_deposit']['renewal_id'];
}
$renewal_id++;
if($renewal_id == 2)
{
$rrrcccidd = explode('/',$receipt_idddd);
$rrrrddd = $rrrcccidd[0];
}
else
{
$rrrrddd = $receipt_idddd; 
}
$rrrrr_idddd = $rrrrddd."/".$renewal_id;

$this->loadmodel('fix_deposit');
$this->fix_deposit->updateAll(array('matured_status'=>2,"renewal"=>"y"),array('transaction_id'=>$receipt_iddddd,"society_id"=>$s_society_id));

$l=$this->autoincrement('fix_deposit','transaction_id');
$this->loadmodel('fix_deposit');
$multipleRowData = Array( Array("transaction_id" => $l,"receipt_id"=>$rrrrr_idddd,"bank_name"=>$bank_name,
"bank_branch"=>$branch,"account_reference"=>$reference,"principal_amount"=>$amount,
"start_date"=>strtotime($start_date),"maturity_date"=>strtotime($maturity_date),"interest_rate"=>$rate,
"purpose"=>$remarks,"file_name"=>$file_name,"society_id" => $s_society_id,"matured_status"=>1,
"auto_inc"=>"NO","renewal_id"=>$renewal_id,"prepaired_by"=>$s_user_id,"current_date"=>$current_date));
$this->fix_deposit->saveAll($multipleRowData);

?>
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
Fixed Deposit #<?php echo $receipt_idddd; ?> is renewed successfully
</div>
<div class="modal-footer">
<a href="fix_deposit_view" class="btn red">OK</a>
</div>
</div>

<?php
}
}
///////////////////////////////// End renewal_fixed_deposit /////////////////////////////////////////////////
//////////////////////////////// Start petty_cash_receipt_add_row ////////////////////////////////////////////////////
function petty_cash_receipt_add_row()
{
$this->layout = 'blank'; 
$s_role_id = $this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = $this->Session->read('user_id');	

$this->ath();

$count = (int)$this->request->query('con');
$this->set('count',$count);

}
//////////////////////////////// End petty_cash_receipt_add_row ////////////////////////////////////////////////////
/////////////////////////////////// Start fixed_deposit_add_row ///////////////////////////////////////////////////////
function fixed_deposit_add_row()
{
$this->layout = 'blank'; 
$s_role_id = $this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = $this->Session->read('user_id');	
$this->ath();

$count = (int)$this->request->query('con');
$this->set('count',$count);


$this->loadmodel('reference');
$conditions=array("auto_id"=>6);
$rfff=$this->reference->find('all',array('conditions'=>$conditions));
foreach($rfff as $dddtttt)
{
$kendo_array = @$dddtttt['reference']['reference'];			
}
if(!empty($kendo_array))
{
@$kendo_implode = implode(",",$kendo_array);
}
$this->set('kendo_implode',@$kendo_implode);


$this->loadmodel('reference');
$conditions=array("auto_id"=>7);
$rfff2=$this->reference->find('all',array('conditions'=>$conditions));
foreach($rfff2 as $dddtttt2)
{
$kendo_array2 = @$dddtttt2['reference']['reference'];			
}
if(!empty($kendo_array2))
{
@$kendo_implode2 = implode(",",$kendo_array2);
}
$this->set('kendo_implode2',@$kendo_implode2);

}
/////////////////////////////////// End fixed_deposit_add_row ///////////////////////////////////////////////////////
/////////////////////////////////// Start new_bank_receipt_add_row ///////////////////////////////////////////////////////
function new_bank_receipt_add_row()
{
$this->layout = 'blank'; 
$s_role_id = $this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = $this->Session->read('user_id');	

$this->ath();

$count = (int)$this->request->query('con');
$this->set('count',$count);

$this->loadmodel('ledger_sub_account');
$conditions=array("society_id" => $s_society_id, "ledger_id" => 34,"deactive"=>0);
$cursor1=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);
foreach($cursor1 as $collection)
{
$user_id = (int)@$collection['ledger_sub_account']['user_id'];
$this->loadmodel('user');
$conditions=array("user_id" => $user_id);
$cursor2=$this->user->find('all',array('conditions'=>$conditions));
$this->set('cursor',$cursor2);
}
		
$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 33,"society_id"=>$s_society_id);
$cursor3=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor3',$cursor3);

$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 112,"society_id"=>$s_society_id);
$cursor4=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor4',$cursor4);

$this->loadmodel('reference');
$conditions=array("auto_id"=>6);
$rfff=$this->reference->find('all',array('conditions'=>$conditions));
foreach($rfff as $dddtttt)
{
$kendo_array = @$dddtttt['reference']['reference'];			
}
if(!empty($kendo_array))
{
@$kendo_implode = implode(",",$kendo_array);
}
$this->set('kendo_implode',@$kendo_implode);


$this->loadmodel('reference');
$conditions=array("auto_id"=>7);
$rfff2=$this->reference->find('all',array('conditions'=>$conditions));
foreach($rfff2 as $dddtttt2)
{
$kendo_array2 = @$dddtttt2['reference']['reference'];			
}
if(!empty($kendo_array2))
{
@$kendo_implode2 = implode(",",$kendo_array2);
}
$this->set('kendo_implode2',@$kendo_implode2);

}
/////////////////////////////////// End new_bank_receipt_add_row //////////////////////////////////////////
/////////////////////// Start bill_show_ajax /////////////////////////////////////////////////////////////
function bill_show_ajax()
{
$this->layout = 'blank'; 
$s_role_id = $this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id = $this->Session->read('user_id');	

$this->ath();	
	
$flat_id = (int)$this->request->query('ff');	
$this->set('flat_id',$flat_id);	

}
/////////////////////// End bill_show_ajax /////////////////////////////////////////////////////////////
////////////////////////////// Start non_member_add_ajax ////////////////////////////////////////////////
function non_member_add_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	
	
$this->ath();	
$kkk = (int)$this->request->query('kk');
$type = (int)$this->request->query('typ');
$this->set('type',$type);
$this->set('kkk',$kkk);

$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 112,"society_id"=>$s_society_id);
$cursor1=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 34,"society_id"=>$s_society_id);
$cursor2=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);


}

////////////////////////////// End non_member_add_ajax ////////////////////////////////////////////////
/////////////////////////// Start bank_receipt_member_add_ajax /////////////////////////////////////////
function bank_receipt_member_add_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	
	
$this->ath();
$kkk = (int)$this->request->query('kk');
$this->set('kkk',$kkk);
$member_name = $this->request->query('nammm');
$hhh = (int)$this->request->query('hh');

if($hhh == 1)
{
$auto_id=(int)$this->autoincrement('ledger_sub_account','auto_id');
$this->loadmodel('ledger_sub_account');
$multipleRowData = Array( Array("auto_id"=>$auto_id,"ledger_id"=>112,"name"=>$member_name,"delete_id"=>0,
"society_id"=>$s_society_id));
$this->ledger_sub_account->saveAll($multipleRowData);
}
	
	
$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 112,"society_id"=>$s_society_id);
$cursor1=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

}
/////////////////////////// End bank_receipt_member_add_ajax /////////////////////////////////////////
/////////////////////////// Start bank_receipt_type_ajax /////////////////////////////////////////////
function bank_receipt_type_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	
	
$this->ath();	

$kkk = (int)$this->request->query('kk');
$type = (int)$this->request->query('typ');
$this->set('type',$type);
$this->set('kkk',$kkk);	
}
/////////////////////////// End bank_receipt_type_ajax /////////////////////////////////////////////
///////////////////////////// Start fixed_deposit_renewal_show ///////////////////////////////////////////
function fixed_deposit_renewal_show()
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
$conditions=array('society_id'=>$s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $data)
{
$society_name = $data['society']['society_name'];	
}
$this->set('society_name',$society_name);






	
$this->loadmodel('fix_deposit');
$conditions=array('society_id'=>$s_society_id,"matured_status"=>2,"renewal"=>"y");
$cursor1=$this->fix_deposit->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);
	
}
///////////////////////////// End fixed_deposit_renewal_show ///////////////////////////////////////////
/////////////////////////// Start bank_receipt_approve //////////////////////////////////////////////
function bank_receipt_approve($rrr=null)
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$approved_date = date('d-m-Y');

$this->set('s_role_id',$s_role_id);
$this->ath();		
$this->check_user_privilages();	
$this->seen_notification(28,$rrr);
$auto_id22 = (int)$this->request->query('aa');

if(!empty($auto_id22))
{

$this->loadmodel('my_flat_receipt_update');
$conditions=array('society_id'=>$s_society_id,"approval_id"=>1,"auto_id"=>$auto_id22);
$cursor=$this->my_flat_receipt_update->find('all',array('conditions'=>$conditions));
foreach($cursor as $data)
{
$transaction_date = $data['my_flat_receipt_update']['receipt_date'];
$transaction_date = date('Y-m-d',strtotime($transaction_date));
$transaction_date = strtotime($transaction_date);
$mode = $data['my_flat_receipt_update']['receipt_mode'];
if($mode == "Cheque" || $mode == "cheque")
{
  $cheque_number = @$data['my_flat_receipt_update']['cheque_number'];
  $cheque_date = @$data['my_flat_receipt_update']['cheque_date'];
  $drawn_bank_name = @$data['my_flat_receipt_update']['drawn_on_which_bank'];
  $branch = @$data['my_flat_receipt_update']['bank_branch'];
}
else
{
 $utr_ref = @$data['my_flat_receipt_update']['reference_utr'];
 $cheque_date = @$data['my_flat_receipt_update']['date'];
}
$amount = $data['my_flat_receipt_update']['amount'];
$narration = $data['my_flat_receipt_update']['narration'];	
$deposited_bank_id = (int)$data['my_flat_receipt_update']['deposited_bank_id'];
$party_name_id = (int)$data['my_flat_receipt_update']['party_name_id'];
$current_date = $data['my_flat_receipt_update']['current_date'];
$prepaired_by = $data['my_flat_receipt_update']['prepaired_by'];
}

/////////////////// Bill Code//////
 
	 $result_new_regular_bill = $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_last_bill_info_via_flat_id'),array('pass'=>array($party_name_id)));
	
	 $auto_id=null; $regular_bill_one_time_id=null;
	if(sizeof($result_new_regular_bill)>0){
		foreach($result_new_regular_bill as $data){
	$auto_id=$data["auto_id"];  
	$edit_status=$data["edit_status"]; 
	$latest_bill=@$data["latest_bill"]; 
	$receipt_applied=@$data["receipt_applied"]; 
	$regular_bill_one_time_id = (int)$data["one_time_id"];
	$flat_id = (int)$data["flat_id"];
	if($edit_status=="NO" && $latest_bill=="YES"){
			if(empty($receipt_applied)){
				$arrear_intrest=$data["arrear_intrest"];
				$intrest_on_arrears=$data["intrest_on_arrears"];
				$total=$data["total"];
				$arrear_maintenance=$data["arrear_maintenance"];
			}else{
				$arrear_intrest=$data["new_arrear_intrest"];
				$intrest_on_arrears=$data["new_intrest_on_arrears"];
				$total=$data["new_total"];
				$arrear_maintenance=$data["new_arrear_maintenance"];
			}
	}else{
		$number_of_receipt=$this->count_receipt_against_bill($regular_bill_one_time_id,$flat_id);
		if($number_of_receipt==0){
			$arrear_intrest=$data["arrear_intrest"];
			$intrest_on_arrears=$data["intrest_on_arrears"];
			$total=$data["total"];
			$arrear_maintenance=$data["arrear_maintenance"]; 
		}else{
			$arrear_intrest=$data["new_arrear_intrest"];
			$intrest_on_arrears=$data["new_intrest_on_arrears"];
			$total=$data["new_total"];
			$arrear_maintenance=$data["new_arrear_maintenance"];
		}
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
		$this->new_regular_bill->updateAll(array('new_arrear_intrest'=>$new_arrear_intrest,"new_intrest_on_arrears"=>$new_intrest_on_arrears,"new_arrear_maintenance"=>$new_arrear_maintenance,"new_total"=>$new_total),array('auto_id'=>$auto_id));
	}
/////////////////////////////










	
$t1=$this->autoincrement('new_cash_bank','transaction_id');
$k = (int)$this->autoincrement_with_receipt_source('new_cash_bank','receipt_id',1); 
$this->loadmodel('new_cash_bank');
$multipleRowData = Array( Array("transaction_id"=> $t1,"receipt_id" => $k, 
"receipt_date" => $transaction_date, "receipt_mode" => $mode, 
"cheque_number" =>@$cheque_number,"cheque_date" =>@$cheque_date,
"drawn_on_which_bank" =>@$drawn_bank_name,"reference_utr" => @$utr_ref,
"deposited_bank_id" => $deposited_bank_id,"member_type" => 1,
"party_name_id"=>$party_name_id,"receipt_type" => 1,"amount" => $amount,
"current_date" => $current_date,"society_id"=>$s_society_id,"flat_id"=>$party_name_id,
"bill_auto_id"=>$auto_id,"bill_one_time_id"=>@$regular_bill_one_time_id,"narration"=>$narration,
"receipt_source"=>1,"edit_status"=>"NO","auto_inc"=>"YES","prepaired_by" => $prepaired_by,"bank_branch"=>@$branch,"approved_by"=>$s_user_id,"approved_date"=>$approved_date,"is_cancel"=>"NO"));
$this->new_cash_bank->saveAll($multipleRowData);

	
	
$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'ledger_SubAccount_dattta_by_flat_id'),array('pass'=>array($party_name_id)));
foreach($result_flat_info as $flat_info){
$account_id = (int)$flat_info["ledger_sub_account"]["auto_id"];
}


$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l, "transaction_date"=> $transaction_date, "debit" => $amount, "credit" =>null,"ledger_account_id" => 33, "ledger_sub_account_id" => $deposited_bank_id, "table_name" => "new_cash_bank","element_id" => $t1, "society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData); 

$l=$this->autoincrement('ledger','auto_id');
$this->loadmodel('ledger');
$multipleRowData = Array( Array("auto_id" => $l, "transaction_date"=> $transaction_date, "credit" => $amount, "debit" =>null,"ledger_account_id" => 34, "ledger_sub_account_id" => $account_id,"table_name" => "new_cash_bank","element_id" => $t1, "society_id" => $s_society_id));
$this->ledger->saveAll($multipleRowData);

//////////////Email Sms///////////////////

$this->loadmodel('new_cash_bank');
$conditions=array("receipt_id" => $k,"receipt_source"=>1,"society_id"=>$s_society_id);
$cursor=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$receipt_no = (int)$collection['new_cash_bank']['receipt_id'];
$d_date = $collection['new_cash_bank']['receipt_date'];
$today = date("d-M-Y");
$flat_id = $collection['new_cash_bank']['party_name_id'];
$amount = $collection['new_cash_bank']['amount'];
$society_id = (int)$collection['new_cash_bank']['society_id'];
$bill_reference = $collection['new_cash_bank']['reference_utr'];
$narration = $collection['new_cash_bank']['narration'];
$member = (int)$collection['new_cash_bank']['member_type'];
$receiver_name = @$collection['new_cash_bank']['receiver_name'];
$receipt_mode = $collection['new_cash_bank']['receipt_mode'];
$cheque_number = @$collection['new_cash_bank']['cheque_number'];
$which_bank = @$collection['new_cash_bank']['drawn_on_which_bank'];
$reference_number = @$collection['new_cash_bank']['reference_number'];
$cheque_date = @$collection['new_cash_bank']['cheque_date'];
$sub_account = (int)$collection['new_cash_bank']['deposited_bank_id'];
$sms_date=date("d-m-Y",($d_date));

$amount = str_replace( ',', '', $amount );
$am_in_words=ucwords($this->requestAction(array('controller' => 'hms', 'action' => 'convert_number_to_words'), array('pass' => array($amount))));

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
foreach ($cursor2 as $collection) 
{
$society_name = $collection['society']['society_name'];
$society_reg_no = $collection['society']['society_reg_num'];
$society_address = $collection['society']['society_address'];
$sig_title = $collection['society']['sig_title'];
}
if($member == 2)
{
$user_name = $receiver_name;
$wing_flat = "";
}
else
{
$flatt_datta = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
foreach ($flatt_datta as $fltt_datttaa) 
{
$wnngg_idddd = (int)$fltt_datttaa['flat']['wing_id'];
}

$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wnngg_idddd,$flat_id)));
foreach ($result_lsa as $collection) 
{
$wing_id = $collection['user']['wing'];  
$flat_id = (int)$collection['user']['flat'];
$tenant = (int)$collection['user']['tenant'];
$user_name = $collection['user']['user_name'];
$to_mobile = $collection['user']['mobile'];
$to_email = $collection['user']['email'];
}
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action'=>'wing_flat'),array('pass'=>array($wing_id,$flat_id)));									
}  
$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($sub_account))); 
foreach($result2 as $collection)
{
$bank_name = $collection['ledger_sub_account']['name'];
}
                                    
$ip=$this->hms_email_ip();
$date=date("d-m-Y",($d_date));

$html_receipt='<table style="padding:24px;background-color:#34495e" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
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
<a href="https://www.facebook.com/HousingMatters.co.in"><img src="'.$ip.$this->webroot.'/as/hm/SMLogoFB.png" style="max-height: 30px; height: 30px; width: 30px; max-width: 30px;" height="30px" width="30px" /></a>
</td>
</tr>
							</table>
							</td>
						</tr>
						<tr>
							<td height="10"></td>
						</tr>
                        <tr>
                            <td colspan="2" style="font-size:12px;line-height:1.4;font-family:Arial,Helvetica,sans-serif;color:#34495e;border:solid 1px #767575">
							<table style="font-size:12px" width="100%" cellspacing="0">
								<tbody><tr>
									<td style="padding:2px;background-color:rgb(0,141,210);color:#fff" align="center" width="100%"><b>'.strtoupper($society_name).'</b></td>
								</tr>
							</tbody></table>
							<table style="font-size:12px" width="100%" cellspacing="0">
								<tbody>
								<tr>
									<td style="padding:5px;border-bottom:solid 1px #767575;border-top:solid 1px #767575" width="100%" align="center">
									<span style="color:rgb(100,100,99)">Regn# &nbsp; '.$society_reg_no.'</span><br>
									<span style="color:rgb(100,100,99)">'.$society_address.'</span><br
									</td>
								</tr>
								</tbody>
							</table>
							<table style="font-size:12px;border-bottom:solid 1px #767575;" width="100%" cellspacing="0">
								<tbody><tr>
									<td style="padding:0px 0 2px 5px" colspan="2">Receipt No: '.$receipt_no.'</td>
									
									<td colspan="2" align="right" style="padding:0px 5px 0 0px"><b>Date:</b> '.$date.' </td>
									
								</tr>
								<tr>
									<td style="padding:0px 0 2px 5px" colspan="2"> Received with thanks from: <b>'.$user_name.' '.$wing_flat.'</b></td>
																		
								</tr>
								<tr>
									<td style="padding:0px 0 2px 5px"  colspan="4">Rupees '.$am_in_words.' Only </td>
									
								</tr>';
								
							if($receipt_mode=="Cheque"){
							$receipt_mode_type='Via '.$receipt_mode.'-'.$cheque_number.' drawn on '.$which_bank.' dated '.$cheque_date;
							}
							else{
							$receipt_mode_type='Via '.$receipt_mode.'-'.$reference_number.' dated '.$cheque_date;
							}

								
								$html_receipt.='<tr>
									<td style="padding:0px 0 2px 5px"  colspan="4">'.$receipt_mode_type.'</td>
									
								</tr>
								
								<tr>
									<td style="padding:0px 0 2px 5px" colspan="4">Payment of previous bill</td>
									
								</tr>
								
							</tbody></table>
							
							
							
							<table style="font-size:12px;" width="100%" cellspacing="0">
								<tbody><tr>
									<td width="50%" style="padding:5px" valign="top">
									<span style="font-size:16px;"> <b>Rs '.$amount.'</b></span><br>';
									if($receipt_mode=="Cheque"){
									$receipt_title_cheq='Subject to realization of Cheque(s)';
									}
																		
									$html_receipt.='<span>'.@$receipt_title_cheq.'</span></td>
									<td align="center" width="50%" style="padding:5px" valign="top">
									For  <b>'.$society_name.'</b><br><br><br>
									<div><span style="border-top:solid 1px #424141">'.$sig_title.'</span></div>
									</td>
								</tr>
							</tbody></table>
												
							
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2">
                                <table style="background-color:#008dd2;font-size:11px;color:#fff;border:solid 1px #767575;border-top:none" width="100%" cellspacing="0">
                                 <tbody>
								 
									<tr>
                                        <td align="center" colspan="7"><b>
										Your Society is empowered by HousingMatters - <b> <i>"Making Life Simpler"</i>
										</b></b></td>
                                    </tr>
									<tr>
                                        <td width="50" align="right" style="font-size: 10px;"><b>Email :</b></td>
                                        <td width="120" style="color:#fff!important;font-size: 10px;"> 
										<a href="mailto:support@housingmatters.in" style="color:#fff!important" target="_blank"><b>support@housingmatters.in</b></a>
                                        </td>
										<td align="center" style="font-size: 10px;"></td>
                                        <td align="right" style="font-size: 10px;"><b>Phone :</b></td>
                                        <td width="84" style="color:#fff!important;text-decoration:none;font-size:10px;"><b>022-41235568</b></td>
										<td align="center" style="font-size: 10px;"></td>
                                        <td width="100" style="padding-right:10px;text-decoration:none"> <a href="http://www.housingmatters.in" style="color:#fff!important" target="_blank"><b>www.housingmatters.in</b></a></td>
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
        </tbody>
</table>';
////////////////my Email//////////////
}


/////////////////////////////////////////////////////////////////////////////
$this->loadmodel('society');
$condition=array('society_id'=>$s_society_id);
$result_society=$this->society->find('all',array('conditions'=>$condition)); 
$this->set('result_society',$result_society);
foreach($result_society as $data_society){
	$society_name=$data_society["society"]["society_name"];
	$email_is_on_off=(int)@$data_society["society"]["account_email"];
	$sms_is_on_off=(int)@$data_society["society"]["account_sms"];
   }
//////////////////////////////////////////////////////////////////////////


if($email_is_on_off==1){
////email code//
$r_sms=$this->hms_sms_ip();
$working_key=$r_sms->working_key;
$sms_sender=$r_sms->sms_sender; 
$sms_allow=(int)$r_sms->sms_allow;

$subject="[".$society_name."]- e-Receipt of Rs ".$amount." on ".date('d-M-Y',$d_date)." against Unit ".$wing_flat."";
//$subject = "[".$society_name."]- Receipt,"date('d-M-Y',$d_date).""; 

$this->send_email($to_email,'accounts@housingmatters.in','HousingMatters',$subject,$html_receipt,'donotreply@housingmatters.in');

}

if($sms_is_on_off==1){
	if($sms_allow==1){

	
$r_sms=$this->hms_sms_ip();
$working_key=$r_sms->working_key;
$sms_sender=$r_sms->sms_sender; 
$sms_allow=(int)$r_sms->sms_allow;
$user_name_short=$this->check_charecter_name($user_name);
$sms="Dear ".$user_name_short." ,we have received Rs ".$amount." on ".$sms_date." towards Society Maint. dues. Cheques are subject to realization,".$society_name;
$sms1=str_replace(' ', '+', $sms);

$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$to_mobile.'&message='.$sms1.''); 
}
}



$this->loadmodel('my_flat_receipt_update');
$this->my_flat_receipt_update->updateAll(array("approval_id"=>2),array('society_id'=>$s_society_id,"approval_id"=>1,"auto_id"=>$auto_id22));

?>	

<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
<p>The Receipt Approved Successfully</p>
</div>
<div class="modal-footer">
<a href="bank_receipt_approve" class="btn red">OK</a>
</div>
</div>


<?php	
}

$this->loadmodel('my_flat_receipt_update');
$conditions=array('society_id'=>$s_society_id,"approval_id"=>1);
$cursor1=$this->my_flat_receipt_update->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

}

/////////////////////////////End bank_receipt_approve //////////////////////////////////////////////
/////////////////////////////Start aprrove_bank_receipt_update ////////////////////////////////////
function aprrove_bank_receipt_update()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');		
	
$transaction_id = (int)$this->request->query('bb');	

$this->loadmodel('my_flat_receipt_update');
$conditions=array('society_id'=>$s_society_id,"approval_id"=>1,"auto_id"=>$transaction_id);
$cursor1=$this->my_flat_receipt_update->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);	

$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 34,"society_id"=>$s_society_id,"deactive"=>0);
$ledger_sub_account_data = $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('ledger_sub_account_data',$ledger_sub_account_data);	


$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 33,"society_id"=>$s_society_id);
$bank_detail=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('bank_detail',$bank_detail);

	
}
/////////////////////////////End aprrove_bank_receipt_update ////////////////////////////////////
//////////////////////////// Start approve_receipt_update_json ///////////////////////////////////
function approve_receipt_update_json()
{
$this->layout=null;
$this->ath();
$s_society_id=$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');
$date=date('d-m-Y');
$time = date(' h:i a', time());

$q=$this->request->query('q');
$q = html_entity_decode($q);
$myArray = json_decode($q, true);

$c = 0;
foreach($myArray as $child)
{	

	if(empty($child[0])){
	$output = json_encode(array('type'=>'error', 'text' => 'Please Select transaction date'));
	die($output);
	}	
	
	
 $TransactionDate = $child[0];
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
		$output=json_encode(array('type'=>'error','text'=>'Transaction date is not in open Financial Year '));
		die($output);
	}	

if(empty($child[10]))
{
$output = json_encode(array('type'=>'error', 'text' => 'Please Select Deposited In '));
die($output);
}





	
if(empty($child[1]))
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Please Select Receipt Mode '));
		die($output);
		}

if($child[1] == "Cheque")
{		
	if(empty($child[2]))
	{
	$output = json_encode(array('type'=>'error', 'text' => 'Please Fill Cheque Number '));
	die($output);
	}
	
	if(is_numeric($child[2]))
	{
	}	
	else
	{
	$output = json_encode(array('type'=>'error', 'text' => 'Please Fill Numeric Cheque Number '));
	die($output);
	}
	
	if(empty($child[3]))
	{
	$output = json_encode(array('type'=>'error', 'text' => 'Please Select Cheque Date '));
	die($output);
	}
		
		if(empty($child[4]))
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Please Fill Drawn in which Bank '));
		die($output);
		}
		
	if(empty($child[5]))
	{
	$output = json_encode(array('type'=>'error', 'text' => 'Please Fill Baranch of Bank '));
	die($output);
	}
	
}	
else
{
        if(empty($child[7]))
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Please Fill Reference/Utr '));
		die($output);
		}		
		
		if(empty($child[6]))
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Please Select Date '));
		die($output);
		}

}	
        if(empty($child[11]))
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Please Select Resident'));
		die($output);
		}
		
        if(empty($child[8]))
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Please Fill Amount '));
		die($output);
		}

		if(is_numeric($child[8]))
		{
		}
		else
		{
		$output = json_encode(array('type'=>'error', 'text' => 'Please Fill Numeric Amount '));
		die($output);
		}	
	
	
	
}

foreach($myArray as $child)
{	
$transaction_date = $child[0];
$mode = $child[1];

if($mode == "Cheque" || $mode == "cheque")
{
$cheque_number = $child[2];
$cheque_date = $child[3];
$drawn_bank_name = $child[4];
$branch = $child[5];
}
else
{
$utr_ref = $child[7];
$cheque_date = $child[6];
}
$amount = $child[8];
$narration = $child[9];
$bank_id = (int)$child[10];
$flat_id = (int)$child[11];
$transaction_id = (int)$child[12];
$current_date = date('d-m-Y');

$this->loadmodel('my_flat_receipt_update');
$this->my_flat_receipt_update->updateAll(array("receipt_date" => $transaction_date, "receipt_mode" => $mode, 
"cheque_number" =>@$cheque_number,"cheque_date" =>@$cheque_date,
"drawn_on_which_bank" =>@$drawn_bank_name,"reference_utr" => @$utr_ref,
"deposited_bank_id" => $bank_id,"member_type" => 1,
"party_name_id"=>$flat_id,"receipt_type" => 1,"amount" => $amount,
"flat_id"=>$flat_id,
"narration"=>$narration,"bank_branch"=>@$branch),array('society_id'=>$s_society_id,"auto_id"=>$transaction_id));   

}
$output = json_encode(array('type'=>'success', 'text' => 'Please Fill Numeric Amount '));
die($output);	
}
////////////////////////// End approve_receipt_update_json ////////////////////////////////////////
}
?>