<?php 
App::import('Controller','Hms');
class ExpensetrackersController extends HmsController {
var $helpers = array('Html', 'Form','Js');
public $components = array(
'Paginator',
'Session','Cookie','RequestHandler'
);
var $name = 'Expensetrackers';

///////////////////// Start Expense Tracker Pie Chart (Accounts)///////////////////////////////
function expense_tracker_pie_chart()
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
///////////////////// End Expense Tracker Pie Chart (Accounts)/////////////////////////////////

///////////////Start Expense Tracker Pie Chart Ajax(Accounts)//////////////////////////////////

function expense_tracker_pie_chart_ajax()
{
$this->layout = 'blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$date1 = $this->request->query('date1');
$date2 = $this->request->query('date2');
$this->set('date1',$date1);
$this->set('date2',$date2);

$this->loadmodel('expense_tracker');
$conditions=array("society_id" => $s_society_id);
$cursor1=$this->expense_tracker->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

}
///////////////End Expense Tracker Pie Chart Ajax(Accounts)//////////////////////////////////
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
	
	/*if(empty($child[2])){
					
						$output=json_encode(array('report_type'=>'error','text'=>'Due Date is Required in row '.$c));
						die($output);
				} */
	
	if(!empty($child[2]))
	{
	$invoice_date = $child[1];
	$due_date = $child[2];
	$invoice_date = date('Y-m-d',strtotime($invoice_date));
	$due_date = date('Y-m-d',strtotime($due_date));
	$invoice_date = strtotime($invoice_date);
	$due_date = strtotime($due_date);
	
	if($due_date < $invoice_date)
	{
	$output=json_encode(array('report_type'=>'error','text'=>'Due Date should be Greater Than Invoice date in row '.$c));
	die($output);	
	}
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
		//$file_name = $child[8];
		
		
		
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
///////////////////////////// Start expense_tracker_update //////////////////////////////
function expense_tracker_update($auto_id=null)
{
		if($this->RequestHandler->isAjax()){
		$this->layout='blank';
		}else{
		$this->layout='session';
		}	

$this->ath();
$s_society_id=(int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	
	
$auto_idddddd = (int)$auto_id;
$this->set('auto_iddddd',$auto_idddddd);	
	
$this->loadmodel('expense_tracker');
$conditions=array("expense_tracker_id"=>$auto_idddddd,"society_id"=>$s_society_id);
$result_expense_tracker=$this->expense_tracker->find('all',array('conditions'=>$conditions));
$this->set('result_expense_tracker',$result_expense_tracker);	

$this->loadmodel('accounts_group');
		$conditions=array("accounts_id" => 4);
		$result_account_group=$this->accounts_group->find('all',array('conditions'=>$conditions));
		$this->set('result_account_group',$result_account_group);
			$this->loadmodel('ledger_sub_account');
			$conditions=array("ledger_id" => 15,"society_id"=>$s_society_id);
			$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
			$this->set('result_ledger_sub_account',$result_ledger_sub_account);
	
	
}
////////////////////////////End expense_tracker_update /////////////////////////////////////
//////////////////////////// Start expense_tracker_update_json ///////////////////////////
function expense_tracker_update_json()
{
$this->layout='blank';
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
		$output=json_encode(array('report_type'=>'error','text'=>'Posting Date is Required'));
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
		$output=json_encode(array('report_type'=>'error','text'=>'Posting date Should be in Open Financial Year'));
		die($output);
	}					
				
				
				
				
				
				
				
				
				
				
				
				
				
				/*if(empty($child[1])){
					
						$output=json_encode(array('report_type'=>'error','text'=>'Please Select Due Date in row'.$c));
						die($output);
				} */
				if(empty($child[1])){
					
						$output=json_encode(array('report_type'=>'error','text'=>'Invoice Date is Required'));
						die($output);
				}
	
	if(empty($child[2])){
					
						$output=json_encode(array('report_type'=>'error','text'=>'Due Date is Required'));
						die($output);
				}
	
	
	
	$invoice_date = $child[1];
	$due_date = $child[2];
	$invoice_date = date('Y-m-d',strtotime($invoice_date));
	$due_date = date('Y-m-d',strtotime($due_date));
	$invoice_date = strtotime($invoice_date);
	$due_date = strtotime($due_date);
	
	if($due_date < $invoice_date)
	{
	$output=json_encode(array('report_type'=>'error','text'=>'Due Date should be Greater Than Invoice date'));
	die($output);	
	}
	
	
	
	
	
	
	
	
	
	
		if(empty($part_ac)){
		$output=json_encode(array('report_type'=>'error','text'=>'Party Account Head is Required'));
		die($output);
		}
		
		
		if(empty($invoice_ref)){
		$output=json_encode(array('report_type'=>'error','text'=>'Invoice Reference is Required'));
		die($output);
		}
		
		
		if(empty($expense_head)){
		$output=json_encode(array('report_type'=>'error','text'=>'Expense Head is Required'));
		die($output);
		}
		
		if(empty($amt_inv)){
		$output=json_encode(array('report_type'=>'error','text'=>'Amount of Invoice is Required '));
		die($output);
		}
		
		if(is_numeric($amt_inv))
		{
		}
		else
		{
		$output=json_encode(array('report_type'=>'error','text'=>'Amount of Invoice Should be Numeric Value'));
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
	   $auto_id = (int)$child[8];
			
		///////////// add Expense tracker code /////////////////////
		

			
///////////////////////////// End ///////////////////////////////////
$this->loadmodel('expense_tracker');
$this->expense_tracker->updateAll(array('posting_date'=>$posting_date,'due_date'=>$payment_due_date,'date_of_invoice'=>$date_of_invoice,'expense_head'=>$expense_head,'invoice_reference'=>$invoice_ref,'party_ac_head'=>$part_ac,'ammount_of_invoice'=>$amt_inv,'description'=>$description),array("society_id" => (int)$s_society_id, "expense_tracker_id" => (int)$auto_id));	
			
///////////// Start Ledger Code ////////////////////////////////////////////////
			
			
$this->loadmodel('ledger');
$this->ledger->updateAll(array("ledger_account_id" => $expense_head,"debit"=>$amt_inv,"credit"=>null,"transaction_date"=>$posting_date),array("society_id" => (int)$s_society_id, "element_id" => (int)$auto_id,"table_name"=>"expense_tracker","ledger_sub_account_id" => null));
			
			
$this->loadmodel('ledger');
$this->ledger->updateAll(array("ledger_sub_account_id" => $part_ac,"debit"=>null,"credit"=>$amt_inv,"transaction_date"=>$posting_date),array("society_id" => (int)$s_society_id, "element_id" => (int)$auto_id,"table_name"=>"expense_tracker","ledger_account_id" => 15));		
			
			
		}
	
$output=json_encode(array('report_type'=>'submit','text'=>'Expense vouche generated successfully.'));
die($output);	
	
	
}
//////////////////////End expense_tracker_update_json /////////////////////////////////////
//////////////////// Start expense_upload /////////////////////
function expense_upload()
{
$this->layout=null;
	$this->ath();
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$post_data=$this->request->data;
	
$file_name=@$_FILES["file"]["name"];
if(!empty($file_name)){
$file_name=$_FILES["file"]["name"];
$file_tmp_name =$_FILES['file']['tmp_name'];
$target = "expense_temp/";
$target=@$target.basename($file_name);
move_uploaded_file($file_tmp_name,@$target);
}
}
///////////////// End expense_upload ////////////////////////////

/////////////////// Start expense_tracker_import ////////////////////////////////////
function expense_tracker_import()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}
$this->ath();
$this->check_user_privilages();
$s_society_id=(int)$this->Session->read('society_id');	

$value="";
$value = $this->request->query('fff');
if(!empty($value))
{
$this->loadmodel('expense_tracker_csv_converted');
$conditions4=array('society_id'=>$s_society_id);
$this->expense_tracker_csv_converted->deleteAll($conditions4);

$this->loadmodel('expense_tracker_csv');
$conditions4=array('society_id'=>$s_society_id);
$this->expense_tracker_csv->deleteAll($conditions4);

$this->loadmodel('import_expense_tracker_record');
$conditions4=array("society_id" => $s_society_id, "module_name" => "ET");
$this->import_expense_tracker_record->deleteAll($conditions4);
}

$this->loadmodel('import_expense_tracker_record');
	$conditions=array("society_id" => $s_society_id,"module_name" => "ET");
	$result_import_record = $this->import_expense_tracker_record->find('all',array('conditions'=>$conditions));
	$this->set('result_import_record',$result_import_record);
	foreach($result_import_record as $data_import){
		$step1=(int)@$data_import["import_expense_tracker_record"]["step1"];
		$step2=(int)@$data_import["import_expense_tracker_record"]["step2"];
		$step3=(int)@$data_import["import_expense_tracker_record"]["step3"];
		$step4=(int)@$data_import["import_expense_tracker_record"]["step4"];
	}

}
////////////////// End expense_tracker_import ///////////////////////////////////////
////////////////// Start upload_expense_tracker_csv_file //////////////////////
function upload_expense_tracker_csv_file()
{
$s_society_id = $this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$this->ath();
	if(isset($_FILES['file'])){
		$file_name=$s_society_id.".csv";
		$file_tmp_name =$_FILES['file']['tmp_name'];
		$target = "expense_tracker_csv_file/";
		$target=@$target.basename($file_name);
		move_uploaded_file($file_tmp_name,@$target);
		
		
		$today = date("d-M-Y");
		
		$this->loadmodel('import_expense_tracker_record');
		$auto_id=$this->autoincrement('import_expense_tracker_record','auto_id');
		$this->import_expense_tracker_record->saveAll(Array( Array("auto_id" => $auto_id, "file_name" => $file_name,"society_id" => $s_society_id, "user_id" => $s_user_id, "module_name" => "ET","step1" => 1,"date"=>$today))); 
		
		die(json_encode("UPLOADED"));
	}	
}
//////////////////////// End upload_expense_tracker_csv_file //////////////////
//////////////////////// Start read_csv_file_expense //////////////////////////
function read_csv_file_expense()
{
$this->layout=null;
	$s_society_id = $this->Session->read('society_id');
	
	$f = fopen('expense_tracker_csv_file/'.$s_society_id.'.csv', 'r') or die("ERROR OPENING DATA");
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
			$posting_date=@$child_ar[0];
			$invoice_date=@$child_ar[1];
			$due_date=@$child_ar[2];
			$party_ac=@$child_ar[3];
			$invoice_ref=@$child_ar[4];
			$expense_head=@$child_ar[5];
			$amount=@$child_ar[6];
			$description = $child[7];
			
			$this->loadmodel('expense_tracker_csv');
			$auto_id=$this->autoincrement('expense_tracker_csv','auto_id');
			$this->expense_tracker_csv->saveAll(Array(Array("auto_id" => $auto_id, "posting_date" => $posting_date,"invoice_date"=>$invoice_date,"due_date"=>$due_date, "party_ac" => $party_ac, "invoice_ref" => $invoice_ref,"expense_head"=>$expense_head,"amount"=>$amount,"description"=>$description,"society_id"=>$s_society_id,"is_converted"=>"NO")));
		
	}
	}
	$this->loadmodel('import_expense_tracker_record');
	$this->import_expense_tracker_record->updateAll(array("step2" => 1),array("society_id" => $s_society_id, "module_name" => "ET"));
	die(json_encode("READ"));	
	
	
}
/////////////////////// End read_csv_file_expense /////////////////////////////
////////////////////// Start convert_imported_data_et //////////////////////////////
function convert_imported_data_et()
{
$this->layout=null;
	$s_society_id = $this->Session->read('society_id');
	
	$this->loadmodel('expense_tracker_csv');
	$conditions=array("society_id" => $s_society_id,"is_converted" => "NO");
	$result_import_record = $this->expense_tracker_csv->find('all',array('conditions'=>$conditions,'limit'=>20));
	foreach($result_import_record as $import_record){

$ep_id=(int)@$import_record["expense_tracker_csv"]["auto_id"];
$posting_date=trim(@$import_record["expense_tracker_csv"]["posting_date"]);
$invoice_date=trim(@$import_record["expense_tracker_csv"]["invoice_date"]);
$due_date=@$import_record["expense_tracker_csv"]["due_date"];
$party_ac=@$import_record["expense_tracker_csv"]["party_ac"];
$invoice_ref=@$import_record["expense_tracker_csv"]["invoice_ref"];
$expense_head=@$import_record["expense_tracker_csv"]["expense_head"];
$amount=@$import_record["expense_tracker_csv"]["amount"];
$description=@$import_record["expense_tracker_csv"]["description"];

$this->loadmodel('ledger_sub_account');
$conditions=array("name"=> new MongoRegex('/^' . trim($party_ac) . '$/i'),'society_id'=>$s_society_id);
$result_ledger_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
foreach($result_ledger_account as $data1){
$party_ac_id=(int)@$data1['ledger_sub_account']['auto_id'];
}
			
$this->loadmodel('ledger_account');
$conditions=array("ledger_name"=> new MongoRegex('/^' . trim($expense_head) . '$/i'));
$result_ledger_account=$this->ledger_account->find('all',array('conditions'=>$conditions));
foreach($result_ledger_account as $data){
$expense_head_id=(int)$data['ledger_account']['auto_id'];
}

	

		$this->loadmodel('expense_tracker_csv_converted');
		$auto_iddd=$this->autoincrement('expense_tracker_csv_converted','auto_id');
		$this->expense_tracker_csv_converted->saveAll(Array(Array("auto_id" => $auto_iddd, "posting_date"=>$posting_date,"invoice_date" => $invoice_date,"due_date" => $due_date, "party_ac_id" => $party_ac_id, "invoice_ref" => $invoice_ref,"expense_head_id"=>$expense_head_id,"amount"=>$amount,"description"=>$description,"society_id"=>$s_society_id,"is_imported"=>"NO")));
		
		$this->loadmodel('expense_tracker_csv');
		$this->expense_tracker_csv->updateAll(array("is_converted" => "YES"),array("auto_id" => $ep_id));
	}
	
	$this->loadmodel('expense_tracker_csv');
	$conditions=array("society_id" => $s_society_id,"is_converted" => "YES");
	$total_converted_records = $this->expense_tracker_csv->find('count',array('conditions'=>$conditions));
	
	$this->loadmodel('expense_tracker_csv');
	$conditions=array("society_id" => $s_society_id);
	$total_records = $this->expense_tracker_csv->find('count',array('conditions'=>$conditions));
	
	$converted_per=($total_converted_records*100)/$total_records;
	if($converted_per==100){ $again_call_ajax="NO"; 
		$this->loadmodel('import_expense_tracker_record');
		$this->import_expense_tracker_record->updateAll(array("step3" => 1),array("society_id" => $s_society_id, "module_name" => "ET"));
	}else{
		$again_call_ajax="YES"; 
			
		}
	die(json_encode(array("again_call_ajax"=>$again_call_ajax,"converted_per"=>$converted_per)));	
		
	
}
///////////////// End convert_imported_data_et /////////////////////////////////////
//////////////// Start modify_expense_tracker ////////////////////////////////////
function modify_expense_tracker($page=null)
{
if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	$this->ath();
	
	
	$s_society_id = $this->Session->read('society_id');
	$page=(int)$page;
	$this->set('page',$page);		
	
	$this->loadmodel('import_expense_tracker_record');
	$conditions=array("society_id" => $s_society_id,"module_name" => "ET");
	$result_import_record = $this->import_expense_tracker_record->find('all',array('conditions'=>$conditions));
	$this->set('result_import_record',$result_import_record);
	foreach($result_import_record as $data_import){
	$step1=(int)@$data_import["import_expense_tracker_record"]["step1"];
	$step2=(int)@$data_import["import_expense_tracker_record"]["step2"];
	$step3=(int)@$data_import["import_expense_tracker_record"]["step3"];
	}
	$process_status= @$step1+@$step2+@$step3;
	if($process_status==3){
		$this->loadmodel('expense_tracker_csv_converted'); 
		$order=array('expense_tracker_csv_converted.auto_id'=>'ASC');
		$conditions=array("society_id"=>(int)$s_society_id);
		$result_bank_receipt_converted=$this->expense_tracker_csv_converted->find('all',array('conditions'=>$conditions,"limit"=>20,"page"=>$page,'order'=>$order));
		$this->set('result_bank_receipt_converted',$result_bank_receipt_converted);
		
		$this->loadmodel('expense_tracker_csv_converted'); 
		$conditions=array("society_id"=>(int)$s_society_id);
		$count_bank_receipt_converted=$this->expense_tracker_csv_converted->find('count',array('conditions'=>$conditions));
		$this->set('count_bank_receipt_converted',$count_bank_receipt_converted);
	}
	
	
$this->loadmodel('accounts_group');
$conditions=array("accounts_id" => 4);
$result_account_group=$this->accounts_group->find('all',array('conditions'=>$conditions));
$this->set('result_account_group',$result_account_group);
			
$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 15,"society_id"=>$s_society_id);
$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('result_ledger_sub_account',$result_ledger_sub_account);

}
///////////////// End modify_expense_tracker ////////////////////////////////////
///////////////// Start auto_save_expense_tracker //////////////////////////////
function auto_save_expense_tracker($record_id=null,$field=null,$value=null)
{
$this->layout=null;
	
	$this->ath();
	$s_society_id = $this->Session->read('society_id');
	$record_id=(int)$record_id; 	
		
	if($field=="posting")
	{
	$this->loadmodel('expense_tracker_csv_converted');
	$this->expense_tracker_csv_converted->updateAll(array("posting_date"=>$value),array("auto_id" =>$record_id));
	echo "T";	
	}
	
	
	if($field=="invoice")
	{
	$this->loadmodel('expense_tracker_csv_converted');
	$this->expense_tracker_csv_converted->updateAll(array("invoice_date"=>$value),array("auto_id" =>$record_id));
	echo "T";	
	}
	
	
	if($field=="due")
	{
	$this->loadmodel('expense_tracker_csv_converted');
	$this->expense_tracker_csv_converted->updateAll(array("due_date"=>$value),array("auto_id" =>$record_id));
	echo "T";	
	}
	if($field=="party")
	{
	$this->loadmodel('expense_tracker_csv_converted');
	$this->expense_tracker_csv_converted->updateAll(array("party_ac_id"=>$value),array("auto_id" =>$record_id));
	echo "T";	
	}
	
	if($field=="reference")
	{
	$this->loadmodel('expense_tracker_csv_converted');
	$this->expense_tracker_csv_converted->updateAll(array("invoice_ref"=>$value),array("auto_id" =>$record_id));
	echo "T";	
	}
	
	if($field=="expense")
	{
	$this->loadmodel('expense_tracker_csv_converted');
	$this->expense_tracker_csv_converted->updateAll(array("expense_head_id"=>$value),array("auto_id" =>$record_id));
	echo "T";	
	}
	
	if($field=="amt")
	{
	$this->loadmodel('expense_tracker_csv_converted');
	$this->expense_tracker_csv_converted->updateAll(array("amount"=>$value),array("auto_id" =>$record_id));
	echo "T";	
	}
	
	if($field=="desc")
	{
	$this->loadmodel('expense_tracker_csv_converted');
	$this->expense_tracker_csv_converted->updateAll(array("description"=>$value),array("auto_id" =>$record_id));
	echo "T";	
	}
}
///////////////// End auto_save_expense_tracker //////////////////////////////////
////////////////// Start allow_import_expense_tracker /////////////////////////////
function allow_import_expense_tracker()
{
$this->layout=null;
	
$this->ath();
$s_society_id = (int)$this->Session->read('society_id');	


$this->loadmodel('expense_tracker_csv_converted'); 
$conditions=array("society_id"=>(int)$s_society_id);
$order=array('expense_tracker_csv_converted.auto_id'=>'ASC');
$result_bank_receipt_converted=$this->expense_tracker_csv_converted->find('all',array('conditions'=>$conditions,'order'=>$order));
foreach($result_bank_receipt_converted as $receipt_converted){
$ledger="";
$et_id=(int)$receipt_converted["expense_tracker_csv_converted"]["auto_id"];
$posting_date2=$receipt_converted["expense_tracker_csv_converted"]["posting_date"];
$invoice_date = $receipt_converted["expense_tracker_csv_converted"]["invoice_date"];
$due_date = $receipt_converted["expense_tracker_csv_converted"]["due_date"];
$party_ac_id = $receipt_converted["expense_tracker_csv_converted"]["party_ac_id"];
$invoice_ref=@$receipt_converted["expense_tracker_csv_converted"]["invoice_ref"];
$expense_head_id = $receipt_converted["expense_tracker_csv_converted"]["expense_head_id"];
$amount = $receipt_converted["expense_tracker_csv_converted"]["amount"];
$description = $receipt_converted["expense_tracker_csv_converted"]["description"];


//////////////////////
        $posting_date1 = $posting_date2;
		$posting_date1 = date('Y-m-d',strtotime($posting_date1));
		$posting_date = strtotime($posting_date1); 
		
		$date_of_invoice1 = $invoice_date;
		$date_of_invoice1 = date('Y-m-d',strtotime($date_of_invoice1));
		$date_of_invoice = strtotime($date_of_invoice1);
				
		$payment_due_date1 = $due_date;
		$payment_due_date1 = date('Y-m-d',strtotime($payment_due_date1));
		$payment_due_date = strtotime($payment_due_date1);

if(empty($posting_date2)){ $posting_v = 1; }else {  $posting_v = 0;  }
				
				
		$TransactionDate = $posting_date2;
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
if($abc == 555){ $financial_v = 1;  }else{ $financial_v = 0; }					
		
if(empty($invoice_date)){ $invoice_date_v = 1; }else{  $invoice_date_v = 0; }
	
if(empty($due_date)){ $due_v = 1; }else{ $due_v = 0;  }
	
if($payment_due_date < $date_of_invoice){ $date_v = 1;  }else{ $date_v = 0;  }
	
if(empty($party_ac_id)){ $party_v = 1; }else{ $party_v = 0;  }
		
if(empty($invoice_ref)){  $invoice_v = 1; }else{ $invoice_v = 0; }
		
if(empty($expense_head_id)){ $expense_v = 1; }else{  $expense_v = 0; }
		
if(empty($amount)){ $amount_v = 1;  }else{ $amount_v = 0;  }
		
if(is_numeric($amount)){ $amount_vv = 0;  }else{ $amount_vv = 1; }
		

$v_result[]=array($posting_v,$financial_v,$invoice_date_v,$due_v,$date_v,$party_v,$invoice_v,$expense_v,$amount_v,$amount_vv);
}

foreach($v_result as $data){
if(array_sum($data)==0) { $tt ="T"; }else{ $tt="F"; break;  }
}

if($tt == "T")
{
	
$this->loadmodel('import_expense_tracker_record');
$this->import_expense_tracker_record->updateAll(array("step4" => 1),array("society_id" => $s_society_id, "module_name" => "ET"));	
		    
}else{ echo "F"; die; }
}
////////////////// End allow_import_expense_tracker ////////////////////////////
//////////////////// Start final_import_expense_tracker ///////////////////////
function final_import_expense_tracker()
{
$this->layout=null;
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$this->loadmodel('import_expense_tracker_record');
$conditions=array("society_id" => $s_society_id,"module_name" => "ET");
$result_import_record = $this->import_expense_tracker_record->find('all',array('conditions'=>$conditions));
$this->set('result_import_record',$result_import_record);
foreach($result_import_record as $data_import){
$step1=(int)@$data_import["import_expense_tracker_record"]["step1"];
$step2=(int)@$data_import["import_expense_tracker_record"]["step2"];
$step3=(int)@$data_import["import_expense_tracker_record"]["step3"];
$step4=(int)@$data_import["import_expense_tracker_record"]["step4"];
}
$process_status= @$step1+@$step2+@$step3+@$step4;
		if($process_status==4)
		{
	$this->loadmodel('expense_tracker_csv_converted'); 
	$conditions=array("society_id"=>(int)$s_society_id);
	$order=array('expense_tracker_csv_converted.auto_id'=>'ASC');
	$result_bank_receipt_converted=$this->expense_tracker_csv_converted->find('all',array('conditions'=>$conditions,'order'=>$order));
	foreach($result_bank_receipt_converted as $receipt_converted){
	$ledger="";
	$et_id=(int)$receipt_converted["expense_tracker_csv_converted"]["auto_id"];
	$posting_date2=$receipt_converted["expense_tracker_csv_converted"]["posting_date"];
	$invoice_date = $receipt_converted["expense_tracker_csv_converted"]["invoice_date"];
	$due_date = $receipt_converted["expense_tracker_csv_converted"]["due_date"];
	$party_ac_id = $receipt_converted["expense_tracker_csv_converted"]["party_ac_id"];
	$invoice_ref=@$receipt_converted["expense_tracker_csv_converted"]["invoice_ref"];
	$expense_head_id = $receipt_converted["expense_tracker_csv_converted"]["expense_head_id"];
	$amount = $receipt_converted["expense_tracker_csv_converted"]["amount"];
	$description = $receipt_converted["expense_tracker_csv_converted"]["description"];

	$posting_date = date('Y-m-d',strtotime($posting_date2));
	$posting_date = strtotime($posting_date);
	
	$invoice_date = date('Y-m-d',strtotime($invoice_date));
	$invoice_date = strtotime($invoice_date);
	
	$due_date = date('Y-m-d',strtotime($due_date));
	$due_date = strtotime($due_date);
	
	$current_date = date('Y-m-d');
	
	
	$this->loadmodel('expense_tracker');
	$expense_tracker_id=@$this->autoincrement('expense_tracker','expense_tracker_id');
	$expense_id = (int)$this->autoincrement_with_society_ticket('expense_tracker','expense_id');
	$this->expense_tracker->saveAll(array('expense_tracker_id'=>$expense_tracker_id,'posting_date'=>$posting_date,'due_date'=>$due_date,'date_of_invoice'=>$invoice_date,'expense_head'=>$expense_head_id,'invoice_reference'=>$invoice_ref,'party_ac_head'=>$party_ac_id,'ammount_of_invoice'=>$amount,'user_id'=>$s_user_id,'society_id'=>$s_society_id,'description'=>$description,'expense_id'=>$expense_id,'current_date'=>$current_date));
			
								
$auto_id=$this->autoincrement('ledger','auto_id');
$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => $expense_head_id,"ledger_sub_account_id" => null,"debit"=>$amount,"credit"=>null,"table_name"=>"expense_tracker","element_id"=>$expense_tracker_id,"society_id"=>$s_society_id,"transaction_date"=>$posting_date));
			
$auto_id=$this->autoincrement('ledger','auto_id');
$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => 15,"ledger_sub_account_id" => $party_ac_id,"debit"=>null,"credit"=>$amount,"table_name"=>"expense_tracker","element_id"=>$expense_tracker_id,"society_id"=>$s_society_id,"transaction_date"=>$posting_date));

$this->loadmodel('expense_tracker_csv_converted');
$this->expense_tracker_csv_converted->updateAll(array("is_imported" => "YES"),array("auto_id" => $et_id));

}

	$this->loadmodel('expense_tracker_csv_converted');
	$conditions=array("society_id" => $s_society_id,"is_imported" => "YES");
	$total_converted_records = $this->expense_tracker_csv_converted->find('count',array('conditions'=>$conditions));
		
		$this->loadmodel('expense_tracker_csv_converted');
		$conditions=array("society_id" => $s_society_id);
		$total_records = $this->expense_tracker_csv_converted->find('count',array('conditions'=>$conditions));
		
		$converted_per=($total_converted_records*100)/$total_records;


if($converted_per==100){ $again_call_ajax="NO"; 
			
			$this->loadmodel('expense_tracker_csv_converted');
			$conditions4=array('society_id'=>$s_society_id);
			$this->expense_tracker_csv_converted->deleteAll($conditions4);
			
			$this->loadmodel('expense_tracker_csv');
			$conditions4=array('society_id'=>$s_society_id);
			$this->expense_tracker_csv->deleteAll($conditions4);
			
			$this->loadmodel('import_expense_tracker_record');
			$conditions4=array("society_id" => $s_society_id, "module_name" => "ET");
			$this->import_expense_tracker_record->deleteAll($conditions4);
		}else{
			$again_call_ajax="YES"; 
			}
		die(json_encode(array("again_call_ajax"=>$again_call_ajax,"converted_per_im"=>$converted_per)));



}

	
}
/////////////////// End final_import_expense_tracker ////////////////////////////////

}
?>
