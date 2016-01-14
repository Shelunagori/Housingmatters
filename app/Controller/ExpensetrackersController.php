<?php 
App::import('Controller','Hms');
class ExpensetrackersController extends HmsController {
var $helpers = array('Html', 'Form','Js');
public $components = array(
'Paginator',
'Session','Cookie','RequestHandler'
);
var $name = 'Expensetrackers';




function add_new_party_account_head($party_name=null){
	$this->layout=null;
	$s_society_id = (int)$this->Session->read('society_id');
	if(!empty($party_name)){
		
			$sp_date=date("d-m-y");
			$sp_time=date('h:i:a',time());
			$this->loadmodel('service_provider');
			$sp_id2=$this->autoincrement('service_provider','sp_id');
			$multipleRowData = Array( Array("sp_id" => $sp_id2, "sp_name" => $party_name, "society_id" => $s_society_id,"sp_delete"=>0,'sp_date'=>$sp_date,'sp_time'=>$sp_time));
			$this->service_provider->saveAll($multipleRowData);
				
		$this->loadmodel('ledger_sub_account');
		$auto_id=@$this->autoincrement('ledger_sub_account','auto_id');
		$this->ledger_sub_account->saveAll(array('auto_id'=>$auto_id,'ledger_id'=>15,'name'=>$party_name,'society_id'=>$s_society_id,'sp_id'=>$sp_id2));
						
		echo "OK"; exit;
	}
}

function expense_tracker_export(){
$this->layout="";
$this->ath();
$filename="expense_tracker_import";
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
$date=date("d-m-Y");
$excel = "Posting Date,Date of invoice,Due Date,Party account head,Invoice Reference,Expense Head,Amount of invoice, Description \n";


	$this->loadmodel('accounts_group');
	$conditions=array("accounts_id" => 4);
	$result_account_group=$this->accounts_group->find('all',array('conditions'=>$conditions));
	
	$auto_id=$result_account_group[0]['accounts_group']['auto_id'];
	$result_ledger_account= $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($auto_id)));
	
	$expense_head=$result_ledger_account[0]['ledger_account']['ledger_name'];
	$this->loadmodel('ledger_sub_account');
	
	$conditions=array("ledger_id" => 15,"society_id"=>$s_society_id);
	$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
	$party_ac_head=$result_ledger_sub_account[0]['ledger_sub_account']['name'];


$excel.="".$date.",".$date.",".$date.",".$party_ac_head.",test,".$expense_head.",100,description";

echo $excel;

	
}



function expense_tracker_add(){
	
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
		$this->loadmodel('accounts_group');
		$conditions=array("accounts_id" => 4);
		$result_account_group=$this->accounts_group->find('all',array('conditions'=>$conditions));
		$this->set('result_account_group',$result_account_group);
			$this->loadmodel('ledger_sub_account');
			$conditions=array("ledger_id" => 15,"society_id"=>$s_society_id);
			$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
			$this->set('result_ledger_sub_account',$result_ledger_sub_account);

		
}

function expense_tracker_add_row(){
	
	$this->layout='blank';
		$this->ath();
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$this->set('count',$this->request->query('con'));
	$this->loadmodel('accounts_group');
	$conditions=array("accounts_id" => 4);
	$result_account_group=$this->accounts_group->find('all',array('conditions'=>$conditions));
	$this->set('result_account_group',$result_account_group);
	
			$this->loadmodel('ledger_sub_account');
			$conditions=array("ledger_id" => 15,"society_id"=>$s_society_id);
			$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
			$this->set('result_ledger_sub_account',$result_ledger_sub_account);
	
}


function expense_tracker_json(){
	$this->layout=null;
	$this->ath();
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$post_data=$this->request->data;
	
	$q=$post_data['myJsonString'];
	 
	$myArray = json_decode($q, true);

	$c=0;
	foreach($myArray as $child){
		$c++;
		
		$posting_date1 = $child[0];
		$posting_date1 = date('Y-m-d',strtotime($posting_date1));
		$posting_date = strtotime($posting_date1); 
		
		$date_of_invoice1 = $child[1];
		$date_of_invoice1 = date('Y-m-d',strtotime($date_of_invoice1));
		$date_of_invoice = strtotime($date_of_invoice1);
				
		$payment_due_date1 = $child[2];
		$payment_due_date1 = date('Y-m-d',strtotime($payment_due_date1));
		$payment_due_date = strtotime($payment_due_date1);
		
		$part_ac = (int)$child[3];
		$invoice_ref = $child[4];
		$expense_head = (int)$child[5];
		$amt_inv = $child[6];
		$description = $child[7];
		
////////////////   Validation code ///////////////////////////////		
		if(empty($child[0])){
		$output=json_encode(array('report_type'=>'error','text'=>'Posting Date is Required in row '.$c));
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
		$output=json_encode(array('report_type'=>'error','text'=>'Posting date Should be in Open Financial Year in row '.$c));
		die($output);
	}					
				
				
				
				
				
				
				
				
				
				
				
				
				
				/*if(empty($child[1])){
					
						$output=json_encode(array('report_type'=>'error','text'=>'Please Select Due Date in row'.$c));
						die($output);
				} */
				if(empty($child[1])){
					
						$output=json_encode(array('report_type'=>'error','text'=>'Invoice Date is Required in row '.$c));
						die($output);
				}
	
	if(empty($child[2])){
					
						$output=json_encode(array('report_type'=>'error','text'=>'Due Date is Required in row '.$c));
						die($output);
				}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		if(empty($part_ac)){
		$output=json_encode(array('report_type'=>'error','text'=>'Party Account Head is Required in row '.$c));
		die($output);
		}
		
		
		if(empty($invoice_ref)){
		$output=json_encode(array('report_type'=>'error','text'=>'Invoice Reference is Required in row '.$c));
		die($output);
		}
		
		
		if(empty($expense_head)){
		$output=json_encode(array('report_type'=>'error','text'=>'Expense Head is Required in row '.$c));
		die($output);
		}
		
		if(empty($amt_inv)){
		$output=json_encode(array('report_type'=>'error','text'=>'Amount of Invoice is Required in row '.$c));
		die($output);
		}
		
		if(is_numeric($amt_inv))
		{
		}
		else
		{
		$output=json_encode(array('report_type'=>'error','text'=>'Amount of Invoice Should be Numeric Value in row '.$c));
		die($output);
		}
		
		
		///////////////////////////////// End code ///////////////////////
	}
	
	$current_date=date("d-m-Y");
	
$z=0;
foreach($myArray as $child){
		$z++;
		
		$posting_date1 = $child[0];
		$posting_date1 = date('Y-m-d',strtotime($posting_date1));
		$posting_date = strtotime($posting_date1); 
				
		$date_of_invoice1 = $child[1];
		$date_of_invoice1 = date('Y-m-d',strtotime($date_of_invoice1));
		$date_of_invoice = strtotime($date_of_invoice1);
		
		$payment_due_date1 = $child[2];
		if(!empty($payment_due_date1)){
		$payment_due_date1 = date('Y-m-d',strtotime($payment_due_date1));
		$payment_due_date = strtotime($payment_due_date1);
		}else{
			$payment_due_date=null;
		}
		$part_ac = (int)$child[3];
		$invoice_ref = $child[4];
			
		$expense_head = (int)$child[5];
		$amt_inv = $child[6];
		$description = $child[7];
		
				$file_name=@$_FILES["file".$z]["name"];
				if(!empty($file_name)){
					$file_name=$_FILES["file".$z]["name"];
					$file_tmp_name =$_FILES['file'.$z]['tmp_name'];
					$target = "expenset/";
					$target=@$target.basename($file_name);
					move_uploaded_file($file_tmp_name,@$target);
				}
		///////////// add Expense tracker code /////////////////////
		
			$this->loadmodel('expense_tracker');
			$expense_tracker_id=@$this->autoincrement('expense_tracker','expense_tracker_id');
			$expense_id = (int)$this->autoincrement_with_society_ticket('expense_tracker','expense_id');
			$voucher_num[]=$expense_id;
			$this->expense_tracker->saveAll(array('expense_tracker_id'=>$expense_tracker_id,'posting_date'=>$posting_date,'due_date'=>$payment_due_date,'date_of_invoice'=>$date_of_invoice,'expense_head'=>$expense_head,'invoice_reference'=>$invoice_ref,'party_ac_head'=>$part_ac,'ammount_of_invoice'=>$amt_inv,'user_id'=>$s_user_id,'society_id'=>$s_society_id,'description'=>$description,'file'=>@$file_name,'expense_id'=>$expense_id,'current_date'=>$current_date));
			
			///////////////////////////// End ///////////////////////////////////
			
			
			///////////// Start Ledger Code ////////////////////////////////////////////////
					
					$auto_id=$this->autoincrement('ledger','auto_id');
					$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => $expense_head,"ledger_sub_account_id" => null,"debit"=>$amt_inv,"credit"=>null,"table_name"=>"expense_tracker","element_id"=>$expense_tracker_id,"society_id"=>$s_society_id,"transaction_date"=>$posting_date));
			
					$auto_id=$this->autoincrement('ledger','auto_id');
					$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 15,"ledger_sub_account_id" => $part_ac,"debit"=>null,"credit"=>$amt_inv,"table_name"=>"expense_tracker","element_id"=>$expense_tracker_id,"society_id"=>$s_society_id,"transaction_date"=>$posting_date));
			
			
			////////////////// End code ledger ////////////////////////////////
		}
		
		$voc=sizeof($voucher_num);
		if($voc>1){
		 $first = reset($voucher_num);
		 $last = end($voucher_num);
		 $voucher=$first.' to '.$last;
		}else{
		$voucher= $first = reset($voucher_num);	
		}
		
$this->Session->write('exp_ttt',1);		
		
$output=json_encode(array('report_type'=>'submit','text'=>'Expense voucher '.$voucher.' is generated successfully.'));
die($output);
}

function expense_tracker_view(){
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
		$this->loadmodel('expense_tracker');
		$conditions=array('society_id'=>$s_society_id);
		$result_expense_tracker=$this->expense_tracker->find('all',array('conditions'=>$conditions));
		$this->set('result_expense_tracker',$result_expense_tracker);
}
function expense_tracker_view_ajax(){
		if($this->RequestHandler->isAjax()){
		$this->layout='blank';
		}else{
		$this->layout='session';
		}
		$this->ath();
		$s_society_id = (int)$this->Session->read('society_id');
		$result_society=$this->society_name($s_society_id);
		foreach($result_society as $data){
			$this->set('society_name',$data['society']['society_name']);
			
		}
		$from1=$this->request->query('date1');
		$from = date('Y-m-d',strtotime($from1));
		$from = strtotime($from);
		
		$to1=$this->request->query('date2');
		$to = date('Y-m-d',strtotime($to1));
		$to = strtotime($to);
		$this->set('to',$to1);
		$this->set('from',$from1);
		$this->loadmodel('expense_tracker');
		$conditions=array('society_id'=>$s_society_id,'expense_tracker.posting_date'=>array('$gte'=>$from,'$lte'=>$to));
		$order=array('expense_tracker.posting_date'=> 'ASC');
		$result_expense_tracker=$this->expense_tracker->find('all',array('conditions'=>$conditions,'order'=>$order));
		$this->set('result_expense_tracker',$result_expense_tracker);
}

function expense_tracker_excel(){
	
	$this->layout=null;
	$this->ath();
	$to=$this->request->query('to');
	$this->set('to1',$to);
	$to = date('Y-m-d',strtotime($to));
	$to = strtotime($to);
	$from1=$this->request->query('from');
	$this->set('from1',$from1);
	$from1 = date('Y-m-d',strtotime($from1));
	$from = strtotime($from1);
	$s_society_id = (int)$this->Session->read('society_id');
	$result_society=$this->society_name($s_society_id);
	$this->set('society_name',$result_society[0]['society']['society_name']);
	$this->loadmodel('expense_tracker');
	$conditions=array('society_id'=>$s_society_id,'expense_tracker.posting_date'=>array('$gte'=>$from,'$lte'=>$to));
	$order=array('expense_tracker.posting_date'=> 'ASC');
	$result_expense_tracker=$this->expense_tracker->find('all',array('conditions'=>$conditions,'order'=>$order));
	$this->set('result_expense_tracker',$result_expense_tracker);
}

function import_expense_tracker_ajax(){
	
	if($this->RequestHandler->isAjax()){
		$this->layout='blank';
		}else{
		$this->layout='session';
		}
	$this->ath();
	$s_society_id=$this->Session->read('society_id');
	
	$this->loadmodel('accounts_group');
	$conditions=array("accounts_id" => 4);
	$result_account_group=$this->accounts_group->find('all',array('conditions'=>$conditions));
	$this->set('result_account_group',$result_account_group);
	$this->loadmodel('ledger_sub_account');
	$conditions=array("ledger_id" => 15,"society_id"=>$s_society_id);
	$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
	$this->set('result_ledger_sub_account',$result_ledger_sub_account);
		
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
			$posting_date=$child_ex[0];
			$invoice_date=$child_ex[1];
			$due_date=$child_ex[2];
			$party_ac_head=$child_ex[3];
			$invoice_reference=$child_ex[4];
			$expense_head=$child_ex[5];
			$ammount_of_invoice=$child_ex[6];
			$description=$child_ex[7];
			
			
			
			$this->loadmodel('ledger_sub_account');
			$conditions=array("name"=> new MongoRegex('/^' . $party_ac_head . '$/i'),'society_id'=>$s_society_id);
			$result_ledger_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
			foreach($result_ledger_account as $data1){
				
				$ledger_sub_id2=(int)@$data1['ledger_sub_account']['auto_id'];
				
			}
			
			$this->loadmodel('ledger_account');
			$conditions=array("ledger_name"=> new MongoRegex('/^' . $expense_head . '$/i'));
			$result_ledger_account=$this->ledger_account->find('all',array('conditions'=>$conditions));
			foreach($result_ledger_account as $data){
				
				$ledger_id=(int)$data['ledger_account']['auto_id'];
				
			}
			
		$table[]=array($posting_date,$invoice_date,$due_date,@$ledger_sub_id2,$invoice_reference,$ledger_id,$ammount_of_invoice,$description);	
		}
		$i++;
	}
	
	$this->set('table',$table);
	
}

function expense_tracker_pdf(){
	
	$this->layout=null;
	$this->ath();
	$to=$this->request->query('to');
	$to = date('Y-m-d',strtotime($to));
	$to = strtotime($to);
	$from1=$this->request->query('from');
	$from1 = date('Y-m-d',strtotime($from1));
	$from = strtotime($from1);
	$s_society_id = (int)$this->Session->read('society_id');
	$this->loadmodel('expense_tracker');
	$conditions=array('society_id'=>$s_society_id,'expense_tracker.posting_date'=>array('$gte'=>$from,'$lte'=>$to));
	$result_expense_tracker=$this->expense_tracker->find('all',array('conditions'=>$conditions));
	$this->set('result_expense_tracker',$result_expense_tracker);
	
}

}
?>
