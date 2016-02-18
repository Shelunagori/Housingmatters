<?php
App::import('Controller','Hms');
class BookkeepingsController extends HmsController {
var $helpers = array('Html', 'Form','Js');
public $components = array(
'Paginator',
'Session','Cookie','RequestHandler'
);
var $name = 'Bookkeepings';

////////////////////////// Start Detail fetch function//////////////////////////////////// 
	function regular_bill_info_via_auto_id($auto_id){
		$auto_id=(int)$auto_id;
		$this->loadmodel('new_regular_bill');
		$conditions=array('auto_id'=>$auto_id,'approval_status'=>1);
		return $this->new_regular_bill->find('all',array('conditions'=>$conditions)); 
	}
	
	function receipt_info_via_auto_id($auto_id){
		$auto_id=(int)$auto_id;
		$this->loadmodel('new_cash_bank');
		$conditions=array('transaction_id'=>$auto_id);
		return $this->new_cash_bank->find('all',array('conditions'=>$conditions)); 
	}
	
function adhoc_info_via_auto_id($auto_id){
	$s_society_id = (int)$this->Session->read('society_id');
		$auto_id=(int)$auto_id;
		$this->loadmodel('adhoc_bill');
		$conditions=array('adhoc_bill_id'=>$auto_id,'society_id'=>$s_society_id);
		return $this->adhoc_bill->find('all',array('conditions'=>$conditions)); 
	}
	
	function ledger_sub_account_detail_via_auto_id($auto_id){
	$s_society_id = (int)$this->Session->read('society_id');
	$auto_id=(int)$auto_id;
	$this->loadmodel('ledger_sub_account');
	$conditions=array('auto_id'=>$auto_id,"society_id"=>$s_society_id);
	return $this->ledger_sub_account->find('all',array('conditions'=>$conditions)); 
	}
	
	function ledger_account_detail_via_auto_id($auto_id){
	$s_society_id = (int)$this->Session->read('society_id');
	$auto_id=(int)$auto_id;
	$this->loadmodel('ledger_account');
	$conditions=array('$or'=>array( 
				array("society_id"=>0,"auto_id" => $auto_id),
				array("society_id"=>$s_society_id,"auto_id" => $auto_id)));
	return $this->ledger_account->find('all',array('conditions'=>$conditions)); 
	}



////////////////////////// End Detail fetch function//////////////////////////////////// 

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


/////////////////////////////// Start Journal Add (Accounts)///////////////////
function journal_add(){
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


$this->loadmodel('journal');
$conditions=array("society_id" => $s_society_id);
$order=array('journal.receipt_id'=> 'DESC');
$cursor=$this->journal->find('all',array('conditions'=>$conditions,'order' =>$order,'limit'=>1));
foreach ($cursor as $collection) 
{
$last=@$collection['journal']['receipt_id'];
}
if(empty($last))
{
$zz= 0;
}	
else
{	
$zz=$last;
}
$this->set('zz',$zz);   

$this->loadmodel('ledger_account');
$conditions = array( '$or' => array(array('society_id' =>$s_society_id),array('society_id' =>0)));
$cursor1=$this->ledger_account->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('ledger_sub_account');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);


}

///////////////////////////// End Journal Add (Accounts)////////////////////////////

////////////////////////////// Start Journal Excel /////////////////////////////////
function journal_excel(){

$this->layout=null;

$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

		   $result_society=$this->society_name($s_society_id);
			foreach($result_society as $data){
				$this->set('society_name',$data['society']['society_name']);
				
			}
		$from = $this->request->query('from');
		$to = $this->request->query('to');
		$search_vocher = $this->request->query('search_vocher');
		$this->set('from',$from);
		$this->set('to',$to);
		$from1 = date('Y-m-d',strtotime($from));
		$from1 = strtotime($from1);

		$to1 = date('Y-m-d',strtotime($to));
		$to1 = strtotime($to1);
		$this->loadmodel('journal');
		if(!empty($search_vocher)){
			
			$conditions=array("society_id" => $s_society_id,'voucher_id'=>(int)$search_vocher);
				
		}else{
		  $conditions=array("society_id" => $s_society_id,'journal.transaction_date'=>array('$gte'=>$from1,'$lte'=>$to1));
		
		}
		$order=array('journal.transaction_date'=> 'ASC');
		$result_journal=$this->journal->find('all',array('conditions'=>$conditions,'order'=>$order));
		$this->set('result_journal',$result_journal);






}
//////////////////////////// End Journal Excel ///////////////////////////////////

//////////////////////////////////////////////// Start Journal View (Accounts) //////////////////////////////////////////////////////////////////////////
function journal_view()
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

		$this->loadmodel('journal');
		$conditions=array("society_id" => $s_society_id);
		$order=array('journal.transaction_date'=> 'ASC');
		$result_journal=$this->journal->find('all',array('conditions'=>$conditions,'order'=>$order));
		$siz_journal=sizeof($result_journal);
		if($siz_journal>0){
		foreach($result_journal as $data){
			$voucher[]=@$data['journal']['voucher_id'];
		}
		
		$new_sort_voucher=array_unique($voucher);
		
		$this->set('result_journal',$new_sort_voucher);
		}
}

//////////////////////////////////////////////// End Journal View (Accounts) //////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////// Start Journal View Ajax(Accounts)///////////////////////////////////////////////////////////////////////

function journal_view_ajax($page=null,$from=null,$to=null){
if($this->RequestHandler->isAjax()){
		$this->layout='blank';
		}else{
		$this->layout='session';
		}
		$this->ath();
		$s_society_id = (int)$this->Session->read('society_id');
		$page=(int)$page;
	    $this->set('page',$page);
		
		$result_society=$this->society_name($s_society_id);
		foreach($result_society as $data){
			$this->set('society_name',$data['society']['society_name']);
			
		}
		//$from = $this->request->query('date1');
		//$to = $this->request->query('date2');
		//$search_voucher=$this->request->query('search');	
		$this->set('from',$from);
		$this->set('to',$to);
		//$this->set('search_vocher',$search_voucher);
		$from1 = date('Y-m-d',strtotime($from));
		$from1 = strtotime($from1);
		
		$to1 = date('Y-m-d',strtotime($to));
		$to1 = strtotime($to1);
		$this->loadmodel('journal');
		
		$conditions=array("society_id" => $s_society_id,'journal.transaction_date'=>array('$gte'=>$from1,'$lte'=>$to1));
		$order=array('journal.transaction_date'=> 'ASC');
		$result_journal=$this->journal->find('all',array('conditions'=>$conditions,'limit'=>10,"page"=>$page));
		$this->set('result_journal',$result_journal);

		
		$this->loadmodel('journal');
		
		$conditions=array("society_id" => $s_society_id,'journal.transaction_date'=>array('$gte'=>$from1,'$lte'=>$to1));
		$order=array('journal.transaction_date'=> 'ASC');
		$result_journal2=$this->journal->find('all',array('conditions'=>$conditions));
		$this->set('result_journal2',$result_journal2);
		$count_bank_receipt_converted=0;
		foreach($result_journal2 as $ddd)
		{
		$count_bank_receipt_converted++;	
		}
		
		$this->set('count_bank_receipt_converted',$count_bank_receipt_converted);
		

}




function journal_view_ajax_show_vocher(){
	if($this->RequestHandler->isAjax()){
		$this->layout='blank';
		}else{
		$this->layout='session';
		}
		$this->ath();
		$s_society_id = (int)$this->Session->read('society_id');
		$search_voucher=$this->request->query('search');
		if(!empty($search_voucher)){
			$conditions=array("society_id" => $s_society_id,'voucher_id'=>(int)$search_voucher);

		}else{
			$conditions=array("society_id" => $s_society_id,'journal.transaction_date'=>array('$gte'=>$from1,'$lte'=>$to1));
			}
		$order=array('journal.transaction_date'=> 'ASC');
		$result_journal=$this->journal->find('all',array('conditions'=>$conditions));
		$this->set('result_journal',$result_journal);
		
		
		
	
}
/////////////////////////////////////End Journal View Ajax(Accounts)/////////////////////////////

///////////////////////////////////////////// Start Journal Pdf (Accoints)//////////////////////////////////////////////////////////////////////////////
function journal_pdf()
{
$this->layout = 'pdf';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');		

$auto_id = (int)$this->request->query('c');	
$this->set('auto_id',$auto_id);	



$this->loadmodel('journal');
$conditions=array("auto_id" => $auto_id);
$cursor1=$this->journal->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

}


///////////////////////////////////////////// End Journal Pdf (Accoints)//////////////////////////////////////////////////////////////////////////////

//////////////////////////////// Start Journal Add Row (Accounts)///////////////////////////////
function journal_add_row()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$t = $this->request->query('con');
$this->set('t',$t);

$this->loadmodel('ledger_account');
$conditions = array( '$or' => array(array('society_id' =>$s_society_id),array('society_id' =>0)));
$cursor1=$this->ledger_account->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('ledger_sub_account');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

}
/////////////////////////////////// End Journal Add Row (Accounts)/////////////////

//////////////////////////////////////////////////////////// Start Show Ledger Type Journal(Accounts) ///////////////////////////////////////////////////
function show_ledger_type()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->set('s_society_id',$s_society_id);

$value =(int)$this->request->query('c1');
$t = $this->request->query('t');

$this->set('value',$value);
$this->set('t',$t);


$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => $value,"society_id" => $s_society_id);
$cursor1=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

}
//////////////////////// End Show Ledger Type Journal(Accounts) ////////////////////////

////////////////////////// Start Ledger (Accounts)/////////////////////////////////////
function ledger()
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

$m = new MongoClient();
$collection = $m->selectCollection('accounts', 'ledger_account');
$cursor = $collection->find();

$this->loadmodel('ledger_account');
$conditions = array( '$or' => array(array('society_id' =>$s_society_id),array('society_id' =>0)));
$cursor1=$this->ledger_account->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('ledger_sub_account');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

}
/////////////////////////////////////////// End Ledger (Accounts)//////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////// Start Ledger Ajax (Accounts) //////////////////////////////////////////////////////////////////////////////
function ledger_ajax()
{
$this->layout='blank';
$s_role_id=$this->Session->read('role_id');
$s_society_id = $this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');

$this->set('s_role_id',$s_role_id);

$ledger_account_id = (int)$this->request->query('ledger_account_id');
$this->set('ledger_account_id',$ledger_account_id);

$this->loadmodel('ledger_sub_account');
$conditions=array("society_id" => $s_society_id,'ledger_id' => $ledger_account_id);
$cursor1=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

}
////////////////////////////// End Ledger Ajax (Accounts) ////////////////////////////////////////////////////////

//////////////////////////// Start Ledger Excel (Accounts)//////////////////////////////////////////////////////
function ledger_excel()
{
$this->layout=null;
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
$from = $this->request->query('f');
$to = $this->request->query('t');
$this->set('from',$from);
$this->set('to',$to);
$fdddd = date('d-M-Y',strtotime($from));
$tdddd = date('d-M-Y',strtotime($to));
$this->set('fdddd',$fdddd);
$this->set('tdddd',$tdddd);
$socc_namm = str_replace(' ', '_', $society_name);
$this->set('socc_namm',$socc_namm);

$account_name = "";
$ledger_account_id=(int)$this->request->query('l');
$ledger_sub_account_id=(int)$this->request->query('sl');

$this->set('ledger_account_id',$ledger_account_id);
$this->set('ledger_sub_account_id',$ledger_sub_account_id);

		
	if($ledger_account_id == 15 || $ledger_account_id == 33 || $ledger_account_id == 34 || $ledger_account_id == 35 || $ledger_account_id == 112)
	{
		
		$this->loadmodel('ledger');
		$conditions=array('society_id'=>$s_society_id,"ledger_account_id"=>$ledger_account_id,"ledger_sub_account_id"=>$ledger_sub_account_id,'transaction_date'=>array('$gte'=>strtotime($from),'$lte'=>strtotime($to)));
		$order=array('ledger.transaction_date'=>'ASC');
		$result_ledger=$this->ledger->find('all',array('conditions'=>$conditions,'order'=>$order)); 
		$this->set('result_ledger',$result_ledger);
	
	
	$result_income_head2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($ledger_sub_account_id)));
	foreach($result_income_head2 as $data)
	{
	$account_name = $data['ledger_sub_account']['name'];	
	}
	
	$this->set('account_name',$account_name);
	}
	else{
		
		$this->loadmodel('ledger');
		$conditions=array('society_id'=>$s_society_id,"ledger_account_id"=>$ledger_account_id,'transaction_date'=>array('$gte'=>strtotime($from),'$lte'=>strtotime($to)));
		$order=array('ledger.transaction_date'=>'ASC');
		$result_ledger=$this->ledger->find('all',array('conditions'=>$conditions,'order'=>$order)); 
		$this->set('result_ledger',$result_ledger);
		
		$result_income_head2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($ledger_account_id)));
		foreach($result_income_head2 as $data)
		{
		$account_name = $data['ledger_account']['ledger_name'];	
		}
		$this->set('account_name',$account_name);
	}

///////////////////////////////////////
$this->loadmodel('reference');
$conditions=array("auto_id"=>3);
$cursor = $this->reference->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$tds_arr = $collection['reference']['reference'];
}
$this->set("tds_arr",$tds_arr);	
	
}
//////////////////////////// End Ledger Excel (Accounts)/////////////////////////////

////////////////////////////////////////////// Start Ledger Show Ajax (Accounts)////////////////////////////////////////////////////////////////////////
function ledger_show_ajax($page=null,$ledger_account_id=null,$from=null,$to=null){
	$this->layout='blank';
	$this->ath();
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$this->set('s_role_id',$s_role_id);

	
if(empty($ledger_account_id)){
			echo '<center><span style="color:red;"> Please select ledger accounts.</span></center>';
			exit;
		}
$id_arr = explode(',',$ledger_account_id);
 @$type = (int)$id_arr[1];	
if($type == 1)
{
 $ledger_sub_account_id = (int)$id_arr[0];
$ledger_sub_data = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($ledger_sub_account_id)));
foreach($ledger_sub_data as $sub_ledgerr)
{
$ledger_account_id = (int)$sub_ledgerr['ledger_sub_account']['ledger_id'];	
}
}	
else
{
$ledger_account_id = (int)$id_arr[0];	
}	
	
	
	//$ledger_account_id = (int)$ledger_account_id;
	//$ledger_sub_account_id = (int)$ledger_sub_account_id;
	$from = date("Y-m-d",strtotime($from));
	$to = date("Y-m-d",strtotime($to));
	$this->set('ledger_account_id',$ledger_account_id);
	$this->set('ledger_sub_account_id',@$ledger_sub_account_id);
	$this->set('from',$from);
	$this->set('to',$to);
	
		
		
		
	$this->loadmodel('ledger');
	$conditions=array('society_id'=>$s_society_id,"ledger_account_id"=>$ledger_account_id,'transaction_date'=>array('$gte'=>strtotime($from),'$lte'=>strtotime($to)));
	$order=array('ledger.transaction_date'=>'ASC');
	$result_ledger=$this->ledger->find('all',array('conditions'=>$conditions,'order'=>$order,"limit"=>10,"page"=>$page)); 
	$this->set('result_ledger',$result_ledger);
	
	
	$count_bank_receipt_converted=0;
	$this->loadmodel('ledger');
	$conditions=array('society_id'=>$s_society_id,"ledger_account_id"=>$ledger_account_id,'transaction_date'=>array('$gte'=>strtotime($from),'$lte'=>strtotime($to)));
	$order=array('ledger.transaction_date'=>'ASC');
	$result_ledger2=$this->ledger->find('all',array('conditions'=>$conditions,'order'=>$order)); 
	foreach($result_ledger2 as $rrr)
	{
	$count_bank_receipt_converted++;	
	}
	
	$this->set('count_bank_receipt_converted',$count_bank_receipt_converted);
	
	
	if($ledger_account_id == 15 || $ledger_account_id == 33 || $ledger_account_id == 34 || $ledger_account_id == 35 || $ledger_account_id == 112){


        $this->loadmodel('ledger');
		$conditions=array('society_id'=>$s_society_id,"ledger_account_id"=>$ledger_account_id,
		"ledger_sub_account_id"=>$ledger_sub_account_id,
		'transaction_date'=>array('$gte'=>strtotime($from),'$lte'=>strtotime($to)));
		$order=array('ledger.transaction_date'=>'ASC');
		$result_ledger=$this->ledger->find('all',array('conditions'=>$conditions,'order'=>$order,"limit"=>10,"page"=>$page)); 
		$this->set('result_ledger',$result_ledger);


		$this->loadmodel('ledger');
		$conditions=array('society_id'=>$s_society_id,"ledger_account_id"=>$ledger_account_id,
		"ledger_sub_account_id"=>$ledger_sub_account_id,
		'transaction_date'=>array('$gte'=>strtotime($from),'$lte'=>strtotime($to)));
		$order=array('ledger.transaction_date'=>'ASC');
		$result_ledger2=$this->ledger->find('all',array('conditions'=>$conditions,'order'=>$order)); 
		$count_bank_receipt_converted=0;
		foreach($result_ledger2 as $rrr)
		{
		$count_bank_receipt_converted++;	
		}
				
		
		
		
if($ledger_account_id == 15)
{
$this->loadmodel('ledger');
$conditions=array('society_id'=>$s_society_id,"ledger_account_id"=>$ledger_account_id,
"ledger_sub_account_id"=>$ledger_sub_account_id,
'transaction_date'=>array('$gte'=>strtotime($from),'$lte'=>strtotime($to)));
$order=array('ledger.transaction_date'=>'ASC');
$result_ledger=$this->ledger->find('all',array('conditions'=>$conditions,'order'=>$order,"limit"=>5,"page"=>$page)); 
$this->set('result_ledger',$result_ledger);	
$count_bank_receipt_converted = $count_bank_receipt_converted*2;
}
		
	$this->set('count_bank_receipt_converted',$count_bank_receipt_converted);	
		
		
		}
	
	
$this->loadmodel('reference');
$conditions=array("auto_id"=>3);
$cursor = $this->reference->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$tds_arr = $collection['reference']['reference'];
}
$this->set("tds_arr",$tds_arr);	
}

/////////////////////////////// End Ledger Show Ajax (Accounts)//////////////////////////

//////////////////////////// Start Jounal add new /////////////////////////////////////////
function journal_add_new()
{
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}


//$this->ath();
//$this->check_user_privilages();	

$this->loadmodel('ledger_account');
$cursor2=$this->ledger_account->find('all');
$this->set('cursor2',$cursor2);





}
//////////////////////////////// End Jounal add new /////////////////////////////////////////////////////////////

///////////////////////////////// Start journal validation///////////////////////////////////////////////////////////
function journal_validation(){
	$this->layout='blank';
	$this->ath();
	$q=$this->request->query('q');
	
	$q = html_entity_decode($q);
	$tra_date = $this->request->query('b');
	$tra_date = json_decode($tra_date, true);
	$tra_date = date('Y-m-d',strtotime($tra_date));
	$transaction_date = strtotime($tra_date); 
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id  = (int)$this->Session->read('user_id');
	$date=date("d-m-Y");
	$time=date('h:i:a',time());
				if(empty($tra_date)){
				$output = json_encode(array('type'=>'error', 'text' => 'Transaction Date is Required'));
				die($output);
			}
			
			
			
	   $TransactionDate = $tra_date;
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
		$output=json_encode(array('type'=>'error','text'=>'Transaction Date Should be in Open Financial Year'));
		die($output);
	}		
		
			
		$myArray = json_decode($q, true);
		
		$c=0;
		$total_debit = 0;
		$total_credit = 0;
		
foreach($myArray as $child){
	$c++;
	if(empty($child[0])){
	$output = json_encode(array('type'=>'error', 'text' => 'Ledger Account is Required in row '.$c));
	die($output);
	}
	
	if(empty($child[1]) and empty($child[2])){
	$output = json_encode(array('type'=>'error', 'text' => 'Debit or Credit is Required in row '.$c));
	die($output);
	}
	
	if(is_numeric($child[1]) || is_numeric($child[2])){
	}	
	else
	{
	$output = json_encode(array('type'=>'error', 'text' => 'Debit or Credit Should be Numeric Value in row '.$c));
	die($output);
	}
	$total_debit = $total_debit + $child[1];
	 $total_credit = $total_credit + $child[2];

		
	
  

}	
	if($total_debit != $total_credit){
			$output = json_encode(array('type'=>'error', 'text' => 'Total Debit Should be Match with Total Credit'));
			die($output);
		}
		
	$voucher_id=$this->autoincrement_with_society_ticket('journal','voucher_id');
	foreach($myArray as $child){
	
			$ledger = $child[0];
			$ledgerr_arrr = explode(',',$ledger);
			$type = (int)$ledgerr_arrr[1];
			$flat_id = null;
if($type == 1)
{
$ledger_sub_account = (int)$ledgerr_arrr[0];
$ledger_sub_account2 = (int)$ledger_sub_account;

$ledger_sub_data = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($ledger_sub_account)));
foreach($ledger_sub_data as $sub_ledgerr)
{
$ledger = (int)$sub_ledgerr['ledger_sub_account']['ledger_id'];	
if($ledger == 34)
{
$flat_id = (int)$sub_ledgerr['ledger_sub_account']['flat_id'];
$ledger_sub_account = (int)$flat_id;

}
}
}	
else
{
$ledger = (int)$ledgerr_arrr[0];
$ledger_sub_account2=null;	
}	
			
			
			$debit = $child[1];
			$credit = $child[2];
			$desc = $child[3];
			
			if(empty($debit)){
				$debit=null;
				
			}
			if(empty($credit)){
				$credit=null;
				
			}
			
			
				
				
				
		$journal_id=$this->autoincrement('journal','journal_id');
		$this->loadmodel('journal');
		$multipleRowData = Array( Array("journal_id" => $journal_id, 
		"ledger_account_id" => $ledger,"ledger_sub_account_id"=>(int)$ledger_sub_account,"user_id" => $s_user_id, "transaction_date" => $transaction_date,"current_date" => $date, "credit" => $credit,'debit'=>$debit, "remark" => $desc ,"society_id" => $s_society_id,'voucher_id'=>$voucher_id));
		$this->journal->saveAll($multipleRowData);
		
		$this->loadmodel('ledger');
		$auto_id=$this->autoincrement('ledger','auto_id');
		$this->ledger->saveAll(array("auto_id" => $auto_id,"ledger_account_id" => $ledger,"ledger_sub_account_id" =>$ledger_sub_account2,"debit"=>$debit,"credit"=>$credit,"table_name"=>"journal","element_id"=>$journal_id,"society_id"=>$s_society_id,"transaction_date"=>$transaction_date));

	
	}
		

////////////////////////////////////////////////////////////////

$this->Session->write('journll',1);

$output = json_encode(array('type'=>'succ', 'text' => 'Journal voucher '.$voucher_id.' is generated successfully.'));
    die($output);
}

///////////////////////////////// Start journal validation///////////////////////////////////////////////////////////

function journal_voucher_view($id=null){
	
if($this->RequestHandler->isAjax()){
$this->layout='blank';
}else{
$this->layout='session';
}
$this->ath();
$voucher_id=(int)$id;
$this->set('voc_id',$voucher_id);
//$this->check_user_privilages();
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	

$result_society=$this->society_name($s_society_id);
$this->set('society_name',$result_society[0]['society']['society_name']);

$this->loadmodel('journal');
$conditions=array('society_id'=>$s_society_id,'voucher_id'=>$voucher_id);	
$result_journal=$this->journal->find('all',array('conditions'=>$conditions));
$this->set('result_journal',$result_journal);	
}

}
?>