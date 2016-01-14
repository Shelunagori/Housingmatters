<?php 
App::import('Controller','Hms');
class ExpensetrackersController extends HmsController {
var $helpers = array('Html', 'Form','Js');
public $components = array(
'Paginator',
'Session','Cookie','RequestHandler'
);
var $name = 'Expensetrackers';

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

/////////////////////////Start Expense Tracker Add (Accounts) ///////////////////////
function expense_tracker_add()
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

		$this->set('s_role_id',$s_role_id);

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

			$this->loadmodel('expense_tracker');
			$conditions=array("society_id" => $s_society_id);
			$order=array('expense_tracker.receipt_id'=> 'DESC');
			$cursor=$this->expense_tracker->find('all',array('conditions'=>$conditions,'order' =>$order,'limit'=>1));
			foreach ($cursor as $collection) 
			{
			$last=$collection['expense_tracker']['receipt_id'];
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

				$this->loadmodel('accounts_group');
				$conditions=array("accounts_id" => 4);
				$cursor1=$this->accounts_group->find('all',array('conditions'=>$conditions));
				$this->set('cursor1',$cursor1);

		if(isset($this->request->data['kkk']))
		{
			$name = $this->request->data['cat_name'];
			$this->loadmodel('ledger_sub_account');
			$order=array('ledger_sub_account.auto_id'=> 'DESC');
			$cursor=$this->ledger_sub_account->find('all',array('order' =>$order,'limit'=>1));
			foreach ($cursor as $collection) 
			{
			$last=$collection['ledger_sub_account']["auto_id"];
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
			$this->loadmodel('ledger_sub_account');
			$multipleRowData = Array( Array("auto_id" => $i, "ledger_id" => 15, "name" => $name, "society_id" => $s_society_id,"delete_id"=>0));
			$this->ledger_sub_account->saveAll($multipleRowData);
		}

			$this->loadmodel('ledger_sub_account');
			$conditions=array("ledger_id" => 15,"society_id"=>$s_society_id);
			$cursor2=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
			$this->set('cursor2',$cursor2);

		if(isset($this->request->data['ext_addxfdfg']))
		{
			$posting_date = $this->request->data['posting_date'];
			$posting_date = date("Y-m-d", strtotime($posting_date));
			$file_name = $_FILES['uploaded']['name'];
			$expense_head = (int)$this->request->data['ex_head'];
			$invoice_date = $this->request->data['invoice_date'];
			$invoice_amount = (int)$this->request->data['invoice_amount']; 
			$due_date = $this->request->data['due_date'];
			$party_head = (int)$this->request->data['party_head'];

				$description = $this->request->data['description'];
				$current_date = date("d-m-Y");
				$invoice_reference = $this->request->data['invoice_reference'];
				$invoice_date = date("Y-m-d", strtotime($invoice_date));
				$due_date = date("Y-m-d", strtotime($due_date));
				$current_date = date("Y-m-d", strtotime($current_date));

			$target = "expenset/";
			$target = $target . basename( $_FILES['uploaded']['name']) ;
			$ok=1;
			move_uploaded_file($_FILES['uploaded']['tmp_name'], $target);

				$p = 1;
				while($p < 3)
				{
				if($p == 1)
				{

					$this->loadmodel('expense_tracker');
					$conditions=array("society_id" => $s_society_id);
					$order=array('expense_tracker.auto_id'=> 'DESC','expense_tracker.receipt_id'=>'DESC');
					$cursor=$this->expense_tracker->find('all',array('conditions'=>$conditions,'order' =>$order,'limit'=>1));
					foreach ($cursor as $collection) 
					{
					$last=$collection['expense_tracker']["auto_id"];
					$r_last = $collection['expense_tracker']['receipt_id']; 
					}
		if(empty($last) && empty($r_last))
		{
		$i=0;
		$r = 1000;
		}	
		else
		{	
		$i=$last;
		$r = $r_last;
		}
			$i++;
			$r++;
			$this->loadmodel('expense_tracker');
			$multipleRowData = Array( Array("auto_id" => $i, "receipt_id" => $r, "society_id" => $s_society_id, "current_date" => $current_date, 
			"approver" => $s_user_id, "expense_head" => $expense_head, "invoice_date" => $invoice_date, 
			"due_date" => $due_date, "party_head" => $party_head, "description" => $description, "posting_date" => $posting_date,
			"amount" => $invoice_amount, "amount_category_id" => 1 , "invoice_reference" => $invoice_reference,"file_name"=>$file_name));
			$this->expense_tracker->saveAll($multipleRowData);   
		}

			if($p == 2)
			{
					/*$this->loadmodel('expense_tracker');
					$conditions=array("society_id" => $s_society_id);
					$order=array('expense_tracker.auto_id'=> 'DESC','expense_tracker.receipt_id'=>'DESC');
					$cursor=$this->expense_tracker->find('all',array('conditions'=>$conditions,'order' =>$order,'limit'=>1));
					foreach ($cursor as $collection) 
					{
					$last=$collection['expense_tracker']["auto_id"];
					$r_last = $collection['expense_tracker']['receipt_id']; 
					}
					if(empty($last) && empty($r_last))
					{
					$i=0;
					$r = 1000;
					}	
					else
					{	
					$i=$last;
					$r = $r_last;
					}
					$i++;
					$r++;
					$this->loadmodel('expense_tracker');
					$multipleRowData = Array( Array("auto_id" => $i, "receipt_id" => $r, "society_id" => $s_society_id, "current_date" => $current_date, 
					"approver" => $s_user_id, "expense_head" => $expense_head, "invoice_date" => $invoice_date, 
					"due_date" => $due_date, "party_head" => $party_head, "description" => $description, "posting_date" => $posting_date,
					"amount" => $invoice_amount, "amount_category_id" => 2, "invoice_reference" => $invoice_reference));
					$this->expense_tracker->saveAll($multipleRowData);   
					*/
			}
				$p++;
			}

		$sub_account_id_p = $party_head;
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
		$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $r, 
		"amount" => $invoice_amount, "amount_category_id" => 2, "table_name" => "expense_tracker", "account_type" =>  1, "account_id" => $sub_account_id_p, 
		"current_date" => $current_date, "society_id" => $s_society_id,"module_name"=>"Expense Tracker"));
		$this->ledger->saveAll($multipleRowData);   

				$sub_account_id_e = $expense_head;
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
				$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $r, 
				"amount" => $invoice_amount, "amount_category_id" => 1, "table_name" => "expense_tracker", "account_type" => 2,  
				"account_id" => $sub_account_id_e, "current_date" => $current_date, "society_id" => $s_society_id,"module_name"=>"Expense Tracker"));
				$this->ledger->saveAll($multipleRowData);   

					$this->loadmodel('expense_tracker');
					$conditions=array("society_id" => $s_society_id);
					$cursor3=$this->expense_tracker->find('all',array('conditions'=>$conditions));
					foreach($cursor3 as $collection)
					{
					$d_receipt_id = (int)$collection['expense_tracker']['receipt_id'];	
					}
?>
						<div class="modal-backdrop fade in"></div>
						<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
						<div class="modal-header">
						<center>
						<h3 id="myModalLabel3" style="color:#999;"><b>Expense Tracker</b></h3>
						</center>
						</div>
						<div class="modal-body">
						<center>
						<h5><b>Expense Voucher #<?php echo $d_receipt_id; ?> is  generated successfully</b></h5>
						</center>
						</div>
						<div class="modal-footer">
						<a href="expense_tracker_view" class="btn blue">OK</a>
						</div>
						</div>
				<?php		
				}
				}
///////////////////////End Expense Tracker Add (Accounts) /////////////////////////////////////////////////////

///////////////////////////////////////Start Expense Tracker View (Accounts)//////////////////////////////////
function expense_tracker_view()
{
		if($this->RequestHandler->isAjax())
		{
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

			$this->loadmodel('ledger_sub_account');
			$conditions=array("society_id" => $s_society_id,"ledger_id" => 15);
			$cursor1=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
			$this->set('cursor1',$cursor1);
}
//////////////////////// End Expense Tracker View (Accounts)/////////////////////////////////

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
///////////////////// End Expense Tracker Pie Chart (Accounts)///////////////////////////////////

///////////////Start Expense Tracker Pie Chart Ajax(Accounts)////////////////////////////////////
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
///////////////End Expense Tracker Pie Chart Ajax(Accounts)//////////////////////////////////////

////////////////////// Start Expense Tracker Show Ajax //////////////////////////////////////////
function expense_tracker_ajax_view2()
{
	$this->layout='blank';
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = $this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');	

		$this->ath();

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

					$this->loadmodel('expense_tracker');
					$cursor1=$this->expense_tracker->find('all');
					$this->set('cursor1',$cursor1);

				$this->loadmodel('accounts_group');
				$conditions=array("accounts_id"=>4);
				$cursor2 = $this->accounts_group->find('all',array('conditions'=>$conditions));
				$this->set('cursor2',$cursor2);

					$this->loadmodel('expense_tracker');
					$conditions=array("society_id"=>$s_society_id);
					$cursor3 = $this->expense_tracker->find('all',array('conditions'=>$conditions));
					$this->set('cursor3',$cursor3);
}
/////////////////////////////End Expense Tracker Show Ajax///////////////////////////

/////////////////////Start Function expense Tracker Add Fetch2 (Accounts)////////////////////
function expense_tracker_fetch2($auto_id) 
{
	$this->loadmodel('ledger_account');
	$conditions=array("group_id" => $auto_id);
	return $this->ledger_account->find('all',array('conditions'=>$conditions));
}
////////////////End Function Fetch expense Tracker Add Fetch2 (Accounts)/////////////////////////

///////////////////////////Start Function expense Tracker View Fetch1 (Accounts)///////////////////
function expense_tracker_fetch1($auto_id) 
{
$this->loadmodel('expense_tracker');
$conditions=array("party_head" => $auto_id,"amount_category_id" => 2);
return $this->expense_tracker->find('all',array('conditions'=>$conditions));
}
//////////End Function Fetch expense Tracker View Fetch1 (Accounts)////////////////////////////////////

//////////////////////// Start Expense Tracker Excel/////////////////////////////////////////////////
function expense_tracker_excel()
{
		$this->layout="";
		$filename="Expense Tracker";
		header ("Expires: 0");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/vnd.ms-excel");
		header ("Content-Disposition: attachment; filename=".$filename.".xls");
		header ("Content-Description: Generated Report" );

			$from = $this->request->query('f');
			$to = $this->request->query('t');

				$from = date("Y-m-d", strtotime($from));
				$to = date("Y-m-d", strtotime($to));

			$s_role_id = (int)$this->Session->read('role_id');
			$s_society_id = (int)$this->Session->read('society_id');
			$s_user_id = (int)$this->Session->read('user_id');	

		$this->loadmodel('society');
		$conditions=array("society_id" => $s_society_id);
		$cursor=$this->society->find('all',array('conditions'=>$conditions));
		foreach($cursor as $collection)
		{
		$society_name = $collection['society']['society_name'];
		}

$excel="<table border='1'>
<tr>
<th style='text-align:center;' colspan='8'>$society_name Society</th>
</tr>
<tr>
<th style='text-align:left;'>Voucher #</th>
<th style='text-align:left;'>Posting Date</th>
<th style='text-align:left;'>Due Date</th>
<th style='text-align:left;'>Date of Invoice</th>
<th style='text-align:left;'>Expense Head</th>
<th style='text-align:left;'>Invoice Reference</th>
<th style='text-align:left;'>Party Account Head</th>
<th style='text-align:left;'>Amount</th>
</tr>";
		$total = 0;
		$this->loadmodel('expense_tracker');
		$conditions=array("society_id"=>$s_society_id);
		$cursor3 = $this->expense_tracker->find('all',array('conditions'=>$conditions));
		foreach($cursor3 as $collection)
		{
			$receipt_id = $collection['expense_tracker']['receipt_id'];
			$posting_date = $collection['expense_tracker']['posting_date'];
			$due_date = $collection['expense_tracker']['due_date'];
			$invoice_date = $collection['expense_tracker']['invoice_date'];
			$expense_head = (int)$collection['expense_tracker']['expense_head'];
			$invoice_reference = $collection['expense_tracker']['invoice_reference'];
			$party_account_head = (int)$collection['expense_tracker']['party_head'];
			$amount = $collection['expense_tracker']['amount'];

				$result5 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($expense_head)));
				foreach($result5 as $collection3)
				{
				$ledger_name = $collection3['ledger_account']['ledger_name'];
				}

					$result6 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($party_account_head)));
					foreach($result6 as $collection4)
					{
					$party_name = $collection4['ledger_sub_account']['name'];
					}
					
		if($posting_date >= $from && $posting_date <= $to)
		{
			$total = $total+$amount;
$excel.="<tr>
<td style='text-align:right;'>$receipt_id</td>
<td style='text-align:left;'>$posting_date</td>
<td style='text-align:left;'>$due_date</td>
<td style='text-align:left;'>$invoice_date</td>
<td style='text-align:left;'>$ledger_name</td>
<td style='text-align:left;'>$invoice_reference</td>
<td style='text-align:left;'>$party_name</td>
<td style='text-align:right;'>$amount</td>
</tr>";
}}
$excel.="<tr>
<th colspan='7' style='text-align:right;'>Total</th>
<th>$total</th>
</tr>
</table>";
	
echo $excel;
}
////////////////////// End Expense Tracker Excel///////////////////////////////////////////////////////////////

////////////////////////// Start Expense Tracker Json ///////////////////////////////////////////////////////////
function expense_tracker_json()
{
		$this->layout='blank';
		$s_society_id = (int)$this->Session->read('society_id');
		$s_user_id  = (int)$this->Session->read('user_id');

			$posting_date = $_POST['post'];
			$due_date = $_POST['due'];
			$invoice_date = $_POST['inv_dat'];
			$desc = $_POST['desc'];

				if(empty($posting_date))
				{
				$output=json_encode(array('report_type'=>'error','text'=>'Please Select Posting Date'));
				die($output);
				}

					if(empty($due_date))
					{
					$output=json_encode(array('report_type'=>'error','text'=>'Please Select Due Date'));
					die($output);
					}

						if(empty($invoice_date))
						{
						$output=json_encode(array('report_type'=>'error','text'=>'Please Select Invoice Date'));
						die($output);
						}

							$q = $_POST["myJsonString"]; 
							$myArray = json_decode($q, true);
							$q = html_entity_decode($q);

					$myArray = json_decode($q, true);	
					$c=0;
					$report=array();
					$array1 = array();
						foreach($myArray as $child)
						{
						$c++;
						$expense_head = $child[0];
						$invoice_ref = $child[1];
						$part_ac = $child[2];
						$amt_inv = $child[3];

							if(empty($expense_head)){
							$output=json_encode(array('report_type'=>'error','text'=>'Please Select Expense Head in row'.$c));
							die($output);
							}

					if(empty($invoice_ref)){
					$output=json_encode(array('report_type'=>'error','text'=>'Please Fill Invoice Reference in row'.$c));
					die($output);
					}

				if(empty($part_ac)){
				$output=json_encode(array('report_type'=>'error','text'=>'Please Select Party Account Head in row'.$c));
				die($output);
				}

					if(empty($amt_inv)){
					$output=json_encode(array('report_type'=>'error','text'=>'Please Fill Amount of Invoice in row'.$c));
					die($output);
					}

			if(is_numeric($amt_inv))
			{
			}
			else
			{
			$output=json_encode(array('report_type'=>'error','text'=>'Please Fill Numeric Amount of Invoice in row'.$c));
			die($output);
			}
	
				$date4 = date("Y-m-d", strtotime($posting_date));
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
					if($abc == 555)
					{
					$output=json_encode(array('report_type'=>'error','text'=>'The Date is not in Open Financial Year, Please Select another Date'));
					die($output);
					}
				}
			$file_name=@$_FILES["file"]["name"];

		if(empty($file_name))
		{
		$output=json_encode(array('report_type'=>'error','text'=>'Please Select Attachment'));
		die($output);
		}
			foreach($myArray as $child)
			{
			$expense_head = $child[0];
			$invoice_ref = $child[1];
			$part_ac = $child[2];
			$amt_inv = $child[3];

				$file_name=$_FILES["file"]["name"];
				$file_tmp_name =$_FILES['file']['tmp_name'];
				$target = "expenset/";
				$target=@$target.basename($file_name);
				move_uploaded_file($file_tmp_name,@$target);

		$current_date = date('Y-m-d');

		$posting_date2 = date("Y-m-d", strtotime($posting_date));

		$due_date2 = date("Y-m-d", strtotime($due_date));

		$invoice_date2 = date("Y-m-d", strtotime($invoice_date));


		$this->loadmodel('expense_tracker');
		$conditions=array("society_id" => $s_society_id);
		$order=array('expense_tracker.auto_id'=> 'DESC','expense_tracker.receipt_id'=>'DESC');
		$cursor=$this->expense_tracker->find('all',array('conditions'=>$conditions,'order' =>$order,'limit'=>1));
		foreach ($cursor as $collection) 
		{
		$last=$collection['expense_tracker']["auto_id"];
		$r_last = $collection['expense_tracker']['receipt_id']; 
		}
			if(empty($last) && empty($r_last))
			{
			$i=0;
			$r = 1000;
			}	
				else
				{	
				$i=$last;
				$r = $r_last;
				}
					$i++;
					$r++;
					$this->loadmodel('expense_tracker');
					$multipleRowData = Array( Array("auto_id" => $i, "receipt_id" => $r, "society_id" => $s_society_id, "current_date" => $current_date, 
					"approver" => $s_user_id, "expense_head" => $expense_head, "invoice_date" => $invoice_date2, 
					"due_date" => $due_date2, "party_head" => $part_ac, "description" => $desc, "posting_date" => $posting_date2,
					"amount" => $amt_inv, "invoice_reference" => $invoice_ref,"attachment"=>$file_name));
					$this->expense_tracker->saveAll($multipleRowData); 
	
			$sub_account_id_p = $part_ac;
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
			$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $r, 
			"amount" => $amt_inv, "amount_category_id" => 2, "table_name" => "expense_tracker", "account_type" =>  1, "account_id" => $sub_account_id_p,"current_date" => $current_date, "society_id" => $s_society_id,"module_name"=>"Expense Tracker"));
			$this->ledger->saveAll($multipleRowData);   

				$sub_account_id_e = $expense_head;
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
				$multipleRowData = Array( Array("auto_id" => $k, "receipt_id" => $r, 
				"amount" => $amt_inv, "amount_category_id" => 1, "table_name" => "expense_tracker", "account_type" => 2,  
				"account_id" => $sub_account_id_e, "current_date" => $current_date, "society_id" => $s_society_id,"module_name"=>"Expense Tracker"));
				$this->ledger->saveAll($multipleRowData);  
			}

		$output=json_encode(array('report_type'=>'publish','report'=>'Expense Voucher #'.$r.' is generated successfully'));
		die($output);
}
////////////////////////// End Expense Tracker Json ///////////////////////////////////////////////////////////

////////////////////////////////// Start Expense Tracker Add Row ////////////////////////////////////////////////////////
function expense_tracker_add_row()
{
	$this->layout='blank';
	$s_society_id=(int)$this->Session->read('society_id');
	$s_user_id=(int)$this->Session->read('user_id');

		$count = (int)$this->request->query('con');
		$this->set('count',$count);

			$this->loadmodel('accounts_group');
			$conditions=array("accounts_id" => 4);
			$cursor1=$this->accounts_group->find('all',array('conditions'=>$conditions));
			$this->set('cursor1',$cursor1);

				$this->loadmodel('ledger_sub_account');
				$conditions=array("ledger_id" => 15);
				$cursor2=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
				$this->set('cursor2',$cursor2);
}
////////////////////////////////// End Expense Tracker Add Row ////////////////////////////////////////////////////////
}
?>
