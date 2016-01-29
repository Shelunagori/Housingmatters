<?php
App::import('Controller','Hms');
class AccountsController extends HmsController {
var $helpers = array('Html', 'Form','Js');
public $components = array(
'Paginator',
'Session','Cookie','RequestHandler'
);
var $name = 'Accounts';
////////////////// Start Master Ledger Sub Account Ajax ///////////////////////
function master_ledger_sub_account_ajax()
{
		$this->layout='blank';
		$s_role_id=$this->Session->read('role_id');
		$s_society_id = (int)$this->Session->read('society_id');
		$s_user_id=$this->Session->read('user_id');	

			$value = (int)$this->request->query('value');
			$this->set('value',$value);
}
/////////////////////////////End Master Ledger Sub Account Ajax///////////////////////////////

//////////////////////////// Start Opening Balance Import (Accounts)//////////////////////////
function opening_balance_import()
{
			if($this->RequestHandler->isAjax()){
			$this->layout='blank';
			}else{
			$this->layout='session';
			}
			
				$this->ath();
				$this->check_user_privilages();
				$s_society_id=(int)$this->Session->read('society_id');
}
//////////////////// End Opening Balance Import (Accounts)/////////////////////////////////////

/////////////////////////////////// Start Master Period Status (Accounts)//////////////////////
function master_financial_period_status()
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

		if(isset($this->request->data['status']))
		{
			$this->loadmodel('financial_year');
			$conditions=array("society_id" => $s_society_id);
			$order=array('financial_year.auto_id'=> 'ASC');
			$cursor = $this->financial_year->find('all',array('conditions'=>$conditions,'order' =>$order));
			foreach($cursor as $collection)
			{
			$auto_id = (int)$collection['financial_year']['auto_id'];
			$xyz = @$this->request->data['abc'.$auto_id];
				if($xyz == 2)
				{
				$this->loadmodel('financial_year');
				$this->financial_year->updateAll(array("status" => 1),array('auto_id'=> $auto_id));	
				}
				else
				{
				$this->loadmodel('financial_year');
				$this->financial_year->updateAll(array("status" => 2),array('auto_id'=> $auto_id));	
				}
		    }
?>

<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
The Financial Year Updated Successfully
</div>
<div class="modal-footer">
<a href="master_financial_period_status" class="btn red">OK</a>
</div>
</div>
		
<?php
	}
		$this->loadmodel('financial_year');
		$conditions=array("society_id" => $s_society_id);
		$order=array('financial_year.auto_id'=> 'ASC');
		$cursor1 = $this->financial_year->find('all',array('conditions'=>$conditions,'order' =>$order));
		$this->set('cursor1',$cursor1);
}
///////////////////////////// End Master Period Status (Accounts)//////////////////////////////

/////////////////// Start master Financial Year (Accounts)//////////////////////////////////////
function master_financial_year()
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

		if(isset($this->request->data['sub1']))
		{
			$from = $this->request->data['from'];	
			$to = $this->request->data['to'];	

			$m_from = date("Y-m-d", strtotime($from));
			$m_from = new MongoDate(strtotime($m_from));

			$m_to = date("Y-m-d", strtotime($to));
			$m_to = new MongoDate(strtotime($m_to));

			$from1 = date('d-M-Y',strtotime($from));
			$to1 = date('d-M-Y',strtotime($to));

	$a=$this->autoincrement('financial_year','auto_id');
	$this->loadmodel('financial_year');
	$multipleRowData = Array( Array("auto_id" => $a, "from" => $m_from, "to" => $m_to,"user_id"=>$s_user_id, "status"=> 1, "society_id" => $s_society_id));
	$this->financial_year->saveAll($multipleRowData); 

    $this->Session->write('ffyyyy', 1);
	
?>
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
The Financial Year Created Successfully
</div>
<div class="modal-footer">
<a href="master_financial_period_status" class="btn red">OK</a>
</div>
</div>
			
<?php
	 }
		$this->loadmodel('financial_year');
		$conditions=array("society_id" => $s_society_id);
		$order=array('financial_year.auto_id'=> 'ASC');
		$cursor = $this->financial_year->find('all',array('conditions'=>$conditions,'order' =>$order));
		foreach($cursor as $collection)
		{
			$f_date = $collection['financial_year']['from'];
			$t_date = $collection['financial_year']['to'];

			$f_d1 = date('Y-m-d',$f_date->sec);
			$t_d1 = date('Y-m-d',$t_date->sec);

			$this->set('fd1',$f_d1);
			$this->set('td1',$t_d1);
		}
}
////////////////// End Master Financial Year(Accounts)////////////////////////////////////////

/////////////////////Start Financial Vali Ajax(Accounts)//////////////////////////////////////
function financial_vali_ajax()
{
	$this->layout='blank';
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');	

	$cc = (int)$this->request->query('ss');
	$this->set('cc',$cc);
}
/////////////////////End Financial Vali Ajax(Accounts)/////////////////////////////////////////

////////////////////////Start Master Ledger Accounts COA(Accounts)/////////////////////////////
function master_ledger_account_coa()
{
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}

	$this->ath();
	$this->check_user_privilages();

		$ledger = array();
		$y=0;
		$this->loadmodel('ledger_account');
		$order=array('ledger_account.auto_id'=> 'ASC');
		$cursor=$this->ledger_account->find('all',array('order' =>$order));
		foreach ($cursor as $collection) 
		{
		$y++;
		$ledger_name = $collection['ledger_account']['ledger_name'];
		$ledger[] = $ledger_name;
		}
		
		$ledger2 = implode(",",$ledger);
		$this->set('ledger2',$ledger2);
		$this->set('y',$y);

		$s_role_id=$this->Session->read('role_id');
		$s_society_id = (int)$this->Session->read('society_id');
		$s_user_id=$this->Session->read('user_id');	
		$this->set('s_user_id',$s_user_id);

	$this->loadmodel('ledger_account');
	$conditions =array( '$or' => array(array('society_id' =>$s_society_id),array("society_id" => 0)));
	$cursor=$this->ledger_account->find('all',array('conditions'=>$conditions));
	foreach($cursor as $collection) 
	{
		$auto_id = (int)$collection['ledger_account']['auto_id']; 
			if(isset($this->request->data['sub'.$auto_id]))
			{
			$group_id = (int)$this->request->data['gr_id'];
			$ledger_name = $this->request->data['cat'];

			$this->loadmodel('ledger_account');
			$this->ledger_account->updateAll(array("ledger_name" => $ledger_name,"group_id"=>$group_id),array("auto_id" => $auto_id));	
			}
			
			if(isset($this->request->data['sub2'.$auto_id]))
			{
			$this->loadmodel('ledger_account');
			$this->ledger_account->updateAll(array("delete_id" => 1),array("auto_id" => $auto_id));	
			}
	}

	if(isset($this->request->data['sub']))
	{
		$main_id = (int)$this->request->data['main_id'];
		$name = $this->request->data['cat_name'];

		if($main_id == 4)
		{
			$rate = (int)$this->request->data['rate'];
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
				$multipleRowData = Array( Array("auto_id" => $i, "group_id" => $main_id, "ledger_name" => $name, "rate" => $rate,"society_id"=> $s_society_id,"edit_user_id"=>$s_user_id,"delete_id" => 0));
				$this->ledger_account->saveAll($multipleRowData);
		}
		else if($main_id == 7 || $main_id == 8)
		{
			$this->loadmodel('ledger_account');
			$order=array('ledger_account.auto_id'=> 'DESC');
			$cursor=$this->ledger_account->find('all',array('order' =>$order,'limit'=>1));
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
			$multipleRowData = Array( Array("auto_id" => $i, "group_id" => $main_id, "ledger_name" => $name, "society_id"=> $s_society_id,"edit_user_id"=>$s_user_id,"delete_id" => 0));
			$this->ledger_account->saveAll($multipleRowData);	
		}
		else
		{
			$this->loadmodel('ledger_account');
			$order=array('ledger_account.auto_id'=> 'DESC');
			$cursor=$this->ledger_account->find('all',array('order' =>$order,'limit'=>1));
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
			$multipleRowData = Array( Array("auto_id" => $i, "group_id" => $main_id, "ledger_name" => $name,"society_id"=> $s_society_id,"edit_user_id"=>$s_user_id,"delete_id" => 0));
			$this->ledger_account->saveAll($multipleRowData);	
		}

?>
<!--<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
The Ledger Account Created Successfully
</div>
<div class="modal-footer">
<a href="master_ledger_account_coa" class="btn red">OK</a>
</div>
</div>-->
<?php
$this->Session->write('ledd_accc', 1);
	}
			$this->loadmodel('accounts_groups');
			$cursor1=$this->accounts_groups->find('all');
			$this->set('cursor1',$cursor1);	

			$this->loadmodel('ledger_account');
			$conditions =array( '$or' => array(array("society_id"=>$s_society_id),array("society_id"=>0)));
			$cursor2=$this->ledger_account->find('all',array('conditions'=>$conditions));
			$this->set('cursor2',$cursor2);	

			$this->loadmodel('accounts_group');
			$conditions=array("delete_id" => 0);
			$cursor3=$this->accounts_group->find('all',array('conditions'=>$conditions));
			$this->set('cursor3',$cursor3);
}
///////////////////////////End Master Ledger Accounts COA (Accounts)///////////////////////////

///////////////////////// Start Master Ledger Accounts Ajax COA (Accounts)///////////////////////
function master_ledger_account_ajax()
{
		$this->layout='blank';
		$s_role_id=$this->Session->read('role_id');
		$s_society_id = (int)$this->Session->read('society_id');
		$s_user_id=$this->Session->read('user_id');	

		$value = $this->request->query('value');
		$this->set('value',$value);
}
/////////////////////// End Master Ledger Accounts Ajax COA (Accounts)////////////////////////////

//////////////////// Start Master Ledger Sub Accounts COA (Accounts) /////////////////////////////
function master_ledger_sub_accounts_coa()
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

		$this->loadmodel('ledger_account');
		$cursor1=$this->ledger_account->find('all');
		$this->set('cursor1',$cursor1);	

		$ledger = array();
		$t=0;
		$this->loadmodel('ledger_sub_account');
		$conditions=array("society_id" => $s_society_id);
		$cursor = $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
		foreach($cursor as $collection)
		{
		$t++;
		$sub_ledger_name = $collection['ledger_sub_account']['name'];
		$ledger[] = $sub_ledger_name;
		}
		
			$ledger2 = implode(",",$ledger);
			$this->set('ledger2',$ledger2);
			$this->set('t',$t);

		$this->loadmodel('ledger_sub_account');
		$conditions=array("society_id" => $s_society_id);
		$cursor = $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
		foreach($cursor as $collection)
		{
		$auto_id = (int)$collection['ledger_sub_account']['auto_id'];
				if(isset($this->request->data['sub'.$auto_id]))
				{
				$ledger_id = (int)$this->request->data['gr'];
				$name = $this->request->data['name'];

				$this->loadmodel('ledger_sub_account');
				$this->ledger_sub_account->updateAll(array("name" => $name,"ledger_id" => $ledger_id),array("auto_id" => $auto_id));	
				}
		}
		
			if(isset($this->request->data['sub']))
			{
			$main_id = (int)$this->request->data['main_id'];
			$name = $this->request->data['cat_name'];

	if($main_id == 34)
	{
		$user_id = (int)$this->request->data['user_id'];

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
		$multipleRowData = Array( Array("auto_id" => $i, "ledger_id" => $main_id, "name" => $name, "society_id" => $s_society_id, "user_id" => $user_id,"delete_id"=>0,"deactive"=>0));
		$this->ledger_sub_account->saveAll($multipleRowData);	
	}
	else if($main_id == 15)
	{
		
			
		
			$sp_date=date("d-m-y");
			$sp_time=date('h:i:a',time());
			$this->loadmodel('service_provider');
			$sp_id2=$this->autoincrement('service_provider','sp_id');
			$multipleRowData = Array( Array("sp_id" => $sp_id2, "sp_name" => $name, "society_id" => $s_society_id,"sp_delete"=>0,'sp_date'=>$sp_date,'sp_time'=>$sp_time));
			$this->service_provider->saveAll($multipleRowData);
		
		
		
		$this->loadmodel('ledger_sub_account');
		$i=$this->autoincrement('ledger_sub_account','auto_id');
		$multipleRowData = Array( Array("auto_id" => $i, "ledger_id" => $main_id, "name" => $name, 
		"society_id" => $s_society_id,"delete_id"=>0,"sp_id"=>$sp_id2));
		$this->ledger_sub_account->saveAll($multipleRowData);	
		
		
	}
	else if($main_id == 33)
	{
		$bank_ac = $this->request->data['bank_account'];

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
				$multipleRowData = Array( Array("auto_id" => $i, "ledger_id" => $main_id, "name" => $name, "society_id" => $s_society_id, "bank_account" => $bank_ac,"delete_id"=>0));
				$this->ledger_sub_account->saveAll($multipleRowData);	
	}
	else if($main_id == 35)
	{
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
				$multipleRowData = Array( Array("auto_id" => $i, "ledger_id" => $main_id, "name" => $name, "society_id" => $s_society_id,"delete_id"=>0));
				$this->ledger_sub_account->saveAll($multipleRowData);
	}
	else
	{
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
				$multipleRowData = Array( Array("auto_id" => $i, "ledger_id" => $main_id, "name" => $name, "society_id" => $s_society_id,"delete_id"=>0));
				$this->ledger_sub_account->saveAll($multipleRowData);	
	}
?>
<!--<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
The Ledger Sub Account Created Successfully
</div>
<div class="modal-footer">
<a href="master_ledger_sub_accounts_coa" class="btn red">OK</a>
</div>
</div>-->

<?php	
$this->Session->write('ledgrr_sub_accc', 1);
}
				$this->loadmodel('ledger_sub_account');
				$conditions=array("society_id" => $s_society_id,"delete_id"=>0);
				$cursor2=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
				$this->set('cursor2',$cursor2);	
}
///////////////////////// End Master Ledger Sub Accounts COA (Accounts) //////////////////////////////

////////////////////////////////// Start Over Due Report (Accounts) ///////////////////////////////////
function over_due_report()
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

					$this->loadmodel('user');
					$conditions=array("society_id" => $s_society_id, "tenant"=>1,"deactive"=>0);
					$cursor1 = $this->user->find('all',array('conditions'=>$conditions));
					$this->set('cursor1',$cursor1);

					$this->loadmodel('wing');
					$conditions=array("society_id"=> $s_society_id);
					$cursor2=$this->wing->find('all',array('conditions'=>$conditions));
					$this->set('cursor2',$cursor2);	

					$this->loadmodel('ledger_sub_account');
					$conditions=array("society_id" => $s_society_id, "ledger_id" => 34);
					$cursor3=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
					$this->set('cursor3',$cursor3);
}
///////////////////////////////////// End Over Due Report (Accounts)///////////////////////////////////

/////////////////////// Start over due report show ajax(Accounts)/////////////////////////////////////
function over_due_report_show_ajax()
{
		$this->layout = 'blank';
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

				$from = $this->request->query('date1');
				$to = $this->request->query('date2');
				$wise = (int)$this->request->query('w');
				$this->set('wise',$wise);
				if($wise == 1)
				{
					$wing = (int)$this->request->query('wi');
					$this->set("wing",$wing);
				}
				else if($wise == 2)
				{
					$user_id = (int)$this->request->query('u');
					$this->set("user_id",$user_id);
				}
					$this->set('from',$from);
					$this->set('to',$to);

				$this->loadmodel('new_regular_bill');
				$conditions=array("society_id"=> $s_society_id,"approval_status"=>1);
				$cursor1=$this->new_regular_bill->find('all',array('conditions'=>$conditions));
				$this->set('cursor1',$cursor1);	
}
/////////////////////// End over due report show ajax(Accounts)/////////////////////////////

//////////////////////////// Start OverDue Excel////////////////////////////////////////////
function overdue_excel()
{
$this->layout = 'blank';	
	
	            $s_role_id=$this->Session->read('role_id');
				$s_society_id = (int)$this->Session->read('society_id');
				$s_user_id=$this->Session->read('user_id');	
	
		
		$this->loadmodel('society');
		$conditions=array("society_id" => $s_society_id);
		$cursor=$this->society->find('all',array('conditions'=>$conditions));
		foreach ($cursor as $collection)  
		{
		$society_name = $collection['society']['society_name'];
		}
	$this->set('society_name',$society_name);
	$socc_namm = str_replace(' ', '_', $society_name);
	$this->set('socc_namm',$socc_namm);

	
     	$from = $this->request->query('f');
		$to = $this->request->query('t');
		$wise = (int)$this->request->query('w');
		$this->set('wise',$wise);
			if($wise == 1)
			{
			$wing = (int)$this->request->query('wi');
			$this->set("wing",$wing);
			}
			else if($wise == 2)
			{
			$user_id = (int)$this->request->query('u');
			$this->set("user_id",$user_id);
			}
				
                    $this->set('from',$from);
					$this->set('to',$to);
					
						
			$this->loadmodel('new_regular_bill');
			$conditions=array("society_id"=> $s_society_id,"approval_status"=>1);
			$cursor1=$this->new_regular_bill->find('all',array('conditions'=>$conditions));
			$this->set('cursor1',$cursor1);	

	
}
//////////////////////////////////////////// End OverDue Excel///////////////////////////////////////////

/////////////////////////////// Start Account Statement (Accounts)////////////////////////////////////////
function account_statement()
{
		if($this->RequestHandler->isAjax()){
		$this->layout='blank';
		}else{
		$this->layout='session';
		}
			$s_role_id=$this->Session->read('role_id');
			$s_society_id = (int)$this->Session->read('society_id');
			$s_user_id=$this->Session->read('user_id');	

				$this->loadmodel('regular_bill');
				$conditions=array("society_id" => $s_society_id,"status"=>0);
				$cursor1 = $this->regular_bill->find('all',array('conditions'=>$conditions));
				$this->set('cursor1',$cursor1);

				$this->loadmodel('user');
				$conditions=array("society_id" => $s_society_id,"tenant"=>1,"deactive"=>0);
				$cursor2 = $this->user->find('all',array('conditions'=>$conditions));
				$this->set('cursor2',$cursor2);
}
/////////////////////////// End Account Statement (Accounts)/////////////////////////////////////

////////////////////////// Start account statement show ajax(Accounts)///////////////////////////
function account_statement_show_ajax()
{
		$this->layout='blank';
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
}
/////////////////////////////////// End account statement show ajax(Accounts)////////////////////////////

//////////////////////////////// Start Account Statement Excel//////////////////////////////////////////
function account_statement_excel()
{
		$this->layout="";
		$filename=strtotime("now");
		header ("Expires: 0");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/vnd.ms-excel");
		header ("Content-Disposition: attachment; filename=".$filename.".xls");
		header ("Content-Description: Generated Report" );

		$s_society_id = (int)$this->Session->read('society_id');
		$s_role_id=$this->Session->read('role_id');

			$this->loadmodel('society');
			$conditions=array("society_id" => $s_society_id);
			$cursor = $this->society->find('all',array('conditions'=>$conditions));
			foreach ($cursor as $collection) 
			{
			$society_name = $collection['society']['society_name'];
			}

			$from = $this->request->query('f');
			$to = $this->request->query('t');
			$user_id = (int)$this->request->query('u');

				$m_from = date("Y-m-d", strtotime($from));
				$m_from = new MongoDate(strtotime($m_from));
				$m_to = date("Y-m-d", strtotime($to));
				$m_to = new MongoDate(strtotime($m_to));

					$excel="<table border='1'>
					<tr>
					<th colspan='7' style='text-align:center;'>
					Account Statement ($society_name)
					</th>
					</tr>
					<tr>
					<th style='text-align:center;'>Sr. No.</th>
					<th style='text-align:center;'>User Name</th>
					<th style='text-align:center;'>Bill No.</th>
					<th style='text-align:center;'>Bill for Date</th>
					<th style='text-align:center;'>Last Date</th>
					<th style='text-align:center;'>Total Amount</th>
					<th style='text-align:center;'>Due Amount</th>
					</tr>";
				$nn = 0;
				$grand_total_amount=0;
				$total_due_amount=0;
				$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'regular_bill_fetch2'),array('pass'=>array($user_id)));	
				foreach($result2 as $collection)
				{
					$nn++;
					$bill_no = (int)$collection['regular_bill']['receipt_id'];
					$date_from = $collection['regular_bill']['bill_daterange_from'];
					$date_to = $collection['regular_bill']['bill_daterange_to'];
					$last_date = $collection['regular_bill']['due_date'];
					$total_amount = (int)$collection['regular_bill']['g_total'];
					$due_amount = (int)$collection['regular_bill']['remaining_amount'];
					$date = $collection['regular_bill']['date'];
					$user_id = (int)$collection['regular_bill']['bill_for_user'];
					//$bill_no = (int)$collection[''][''];
					//$bill_no = (int)$collection[''][''];
					$date_from1 = date('d-M-Y',$date_from->sec);
					$date_to1 = date('d-M-Y',$date_to->sec);
					$due_date = date('d-M-Y',$last_date->sec); 

	$bill_html = $collection['regular_bill']['bill_html'];
	$receipt_id = (int)$collection['regular_bill']['receipt_id']; 
	$result3 = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($user_id)));	
	foreach($result3 as $collection)
	{
	$user_name = $collection['user']['user_name'];
	$wing = (int)$collection['user']['wing'];
	$flat =(int)$collection['user']['flat'];
	}
	$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array(@$wing,@$flat)));

		if($m_from <= $date && $m_to >= $date)
		{
		$grand_total_amount = $grand_total_amount + $total_amount;
		$total_due_amount = $total_due_amount + $due_amount;	

		$excel.="<tr>
		<td style='text-align:center;'>$nn</td>
		<td style='text-align:center;'>$user_name&nbsp;&nbsp;$wing_flat</td>
		<td style='text-align:center;'>$bill_no</td>
		<td style='text-align:center;'>$date_from1&nbsp;&nbsp;To&nbsp;&nbsp;$date_to1</td>
		<td style='text-align:center;'>$due_date</td>
		<td style='text-align:center;'>$total_amount</td>
		<td style='text-align:center;'>$due_amount</td>
		</tr>";
		}}
			$excel.="<tr>
			<th colspan='5' style='text-align:center;'>Total</th>
			<th style='text-align:center;'>$grand_total_amount</th>
			<th style='text-align:center;'>$total_due_amount</th>
			</tr>";
			$excel.="</table>";

			echo $excel;
}
/////////////////////// End Account Statement Excel/////////////////////////////////////////////////

/////////////////////////// Start ac statement Bill View/////////////////////////////////////////////
function ac_statement_bill_view($receipt_id=null)
{
	$this->layout='blank';
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');

		$receipt_id = (int)$receipt_id; 
		$this->loadmodel('regular_bill');
		$conditions=array("receipt_id"=>$receipt_id,"society_id" => $s_society_id);
		$cursor=$this->regular_bill->find('all',array('conditions'=>$conditions));
		foreach($cursor as $collection)
		{
		$bill_html = $collection['regular_bill']['bill_html'];	
		}
			$this->set('bill_html',$bill_html);
}
///////////////////////////////////// End ac statement Bill View////////////////////////////////////////

//////////////////////// Start My Flat Bill (Accounts) //////////////////////////////
function my_flat_bill()
{
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}
	
	$last_date=date('t'); 
	$current_month=date('m');
	$current_year=date('Y');
	$from=$current_year."-".$current_month."-01";
	$to=$current_year."-".$current_month."-".$last_date;
	$this->set("from",$from);
	$this->set("to",$to);
	
	
	$this->ath();
	$this->check_user_privilages();
	$s_society_id = (int)$this->Session->read('society_id');
	
	$s_user_id=$this->Session->read('user_id');
	$this->set("s_user_id",$s_user_id);
	
	$result_user_info=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($s_user_id)));
	foreach ($result_user_info as $collection2){
		$user_id=$collection2["user"]["user_id"];
		$user_name=$collection2["user"]["user_name"];
		$this->set('user_name',$user_name);
		//$multiple_flat=@$collection2["user"]["multiple_flat"];
		//$this->set('multiple_flat',$multiple_flat);
		$flat_id=$collection2["user"]["flat"];
	}
	
	$this->loadmodel('society');
	$conditions=array("society_id" => $s_society_id);
	$result_society=$this->society->find('all',array('conditions'=>$conditions));
	$this->set('result_society',$result_society);
	
	$this->loadmodel('ledger_sub_account');
	$conditions=array("society_id" => $s_society_id,"user_id" => (int)$user_id);
	$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
	$ledger_sub_account_id=@$result_ledger_sub_account[0]["ledger_sub_account"]["auto_id"];
	
	$this->loadmodel('ledger');
	$conditions=array("society_id" => $s_society_id,"ledger_account_id" => 34,"ledger_sub_account_id" => $ledger_sub_account_id,'transaction_date'=> array('$gte' => strtotime($from),'$lte' => strtotime($to)));
	$order=array('new_regular_bill.one_time_id'=>'ASC');
	$result_ledger=$this->ledger->find('all',array('conditions'=>$conditions,'order'=>$order));
	$this->set('result_ledger',$result_ledger);

}
////////////////////////////////// End My Flat Bill /////////////////////////////////////////////////////

/////////////////////////////////// Start my_flat_bill_ajax ////////////////////////////////////////////
function my_flat_bill_ajax($from=null,$to=null,$flat_id=null)
{
		if($this->RequestHandler->isAjax()){
		$this->layout='blank';
		}else{
		$this->layout='session';
		} 
			 $from=date("Y-m-d",strtotime($from));
			 $this->set("from",$from);
			 $to=date("Y-m-d",strtotime($to));
			 $this->set("to",$to);
			 
			 $this->set("flat_id",$flat_id);
		
		$this->ath();
		$s_society_id = (int)$this->Session->read('society_id');
	
		$s_user_id=(int)$this->Session->read('user_id');
		$this->set("s_user_id",$s_user_id);
	
	
	$this->loadmodel('society');
	$conditions=array("society_id" => $s_society_id);
	$result_societydattt=$this->society->find('all',array('conditions'=>$conditions));
	foreach($result_societydattt as $dataaaaa)
	{
	$society_name = $dataaaaa['society']['society_name'];
	}
	

	
	$flat_id=(int)$flat_id; 
	if($flat_id==0)
	{
		$result_user_info=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($s_user_id)));
		foreach($result_user_info as $collection2)
		{
		$user_name=$collection2["user"]["user_name"];
		$this->set('user_name',$user_name);
		$wing_id=$collection2["user"]["wing"];
		$flat_id=$collection2["user"]["flat"];
		}

		$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing_id,$flat_id)));
		$this->set('wing_flat',$wing_flat);
	}else{
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
	$conditions=array("society_id" => $s_society_id,"ledger_account_id" => 34,"ledger_sub_account_id" => $ledger_sub_account_id,'transaction_date'=> array('$gte' => strtotime($from),'$lte' => strtotime($to)));
	$order=array('ledger.transaction_date'=>'ASC');
	$result_ledger=$this->ledger->find('all',array('conditions'=>$conditions,'order'=>$order));
	$this->set('result_ledger',$result_ledger);
	
//$this->loadmodel('ledger_sub_account');
//$conditions=array("society_id"=>$s_society_id,"user_id" =>$s_user_id);
//$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
//$this->set('result_ledger_sub_account',$result_ledger_sub_account);

	
}
////////////////////////////End My Flat Bill Ajax/////////////////////////////////////////////////
function my_flat_bill_excel_export($from=null,$to=null,$flat_id=null)
{
$this->layout=null;
	$this->ath();
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');
	$this->set("s_user_id",$s_user_id);		

	$fdddd = date('d-M-Y',strtotime($from));
	$tdddd = date('d-M-Y',strtotime($to));	
	
$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$result_societydattt=$this->society->find('all',array('conditions'=>$conditions));
foreach($result_societydattt as $dataaaaa)
{
$society_name = $dataaaaa['society']['society_name'];
}
$sss_namm = str_replace(' ','-',$society_name);	
	
	
	
	$filename="".$sss_namm."_My_Flat_Register_".$fdddd."_".$tdddd."";
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
	
	
	$flat_id=(int)$flat_id; 
	if($flat_id==0)
	{
		$result_user_info=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($s_user_id)));
		foreach($result_user_info as $collection2)
		{
		$user_name=$collection2["user"]["user_name"];
		$this->set('user_name',$user_name);
		$wing_id=$collection2["user"]["wing"];
		$flat_id=$collection2["user"]["flat"];
		}

		$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing_id,$flat_id)));
		$this->set('wing_flat',$wing_flat);
	}else{
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
	}
	
	$this->loadmodel('society');
	$conditions=array("society_id" => $s_society_id);
	$result_society=$this->society->find('all',array('conditions'=>$conditions));
	$this->set('result_society',$result_society);
	
	$this->loadmodel('ledger_sub_account');
	$conditions=array("society_id" => $s_society_id,"flat_id" => (int)$flat_id);
	$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
	$ledger_sub_account_id=$result_ledger_sub_account[0]["ledger_sub_account"]["auto_id"];
	
	$this->loadmodel('ledger');
	$conditions=array("society_id" => $s_society_id,"ledger_account_id" => 34,"ledger_sub_account_id" => $ledger_sub_account_id,'transaction_date'=> array('$gte' => strtotime($from),'$lte' => strtotime($to)));
	$order=array('ledger.transaction_date'=>'ASC');
	$result_ledger=$this->ledger->find('all',array('conditions'=>$conditions,'order'=>$order));
	$this->set('result_ledger',$result_ledger);
}
/////////////////////////// End my_flat_bill_ajax (Accounts) /////////////////////////////////////

/////////////////////////// Start Bank Receipt Pdf (Accounts)//////////////////////////////////////
function bank_receipt_pdf()
{
	$this->layout = 'pdf'; //this will use the pdf.ctp layout 
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');	

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
/////////////////////////////////// End Bank Receipt Pdf (Accounts)////////////////////////////////////

/////////////////////////////// Start my flat Bill Excel ////////////////////////////////////////////
function my_flat_bill_excel()
{
	$this->layout="";
	$filename="My Flat";
	header ("Expires: 0");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/vnd.ms-excel");
	header ("Content-Disposition: attachment; filename=".$filename.".xls");
	header ("Content-Description: Generated Report" );

		$s_role_id=(int)$this->Session->read('role_id');
		$s_society_id = (int)$this->Session->read('society_id');
		$s_user_id=(int)$this->Session->read('user_id');	

			$this->loadmodel('ledger_sub_account');
			$conditions=array("user_id"=>$s_user_id,"society_id"=>$s_society_id);
			$cursor = $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
			foreach($cursor as $collection)
			{
			$auto_id = (int)$collection['ledger_sub_account']['auto_id'];
			$user_name = $collection['ledger_sub_account']['name'];
			}

				$this->loadmodel('society');
				$conditions=array("society_id"=>$s_society_id);
				$cursor = $this->society->find('all',array('conditions'=>$conditions));
				foreach($cursor as $collection)
				{
				$society_name = $collection['society']['society_name'];
				}

				$from = $this->request->query('f');
				$to = $this->request->query('t');

		$m_from = date("Y-m-d", strtotime($from));
		$m_to = date("Y-m-d", strtotime($to));

			$excel="<table border='1'>
			<tr>
			<th colspan='9' style='text-align:center;'>
			<p style='font-size:16px;'>
			Bill Detail($society_name)
			</p>
			</th>
			</tr>
			<tr>
			<th style='text-align:center;'>Bill No.</th>
			<th colspan='2'>Bill Date</th>
			<th style='text-align:center;' colspan='2'>Bill Period</th>
			<th style='text-align:center;'>Due Date</th>
			<th style='text-align:center;'>Total Amount</th>
			<th style='text-align:center;'>Paid Amount</th>
			<th style='text-align:center;'>Due Amount</th>
			</tr>";
	$nn=0;
	$gt_amt = 0;
	$gt_pay_amt = 0;
	$due_amt = 0;
	
	$this->loadmodel('regular_bill');
		$conditions=array("bill_for_user" => $s_user_id,"society_id"=>$s_society_id);
		$cursor1 = $this->regular_bill->find('all',array('conditions'=>$conditions));
		foreach($cursor1 as $collection)
		{
			$bill_no = (int)$collection['regular_bill']['receipt_id'];	
			$from2 = $collection['regular_bill']['bill_daterange_from'];
			$to2 = $collection['regular_bill']['bill_daterange_to'];
			$due_date = $collection['regular_bill']['due_date'];
			$total_amount = (int)$collection['regular_bill']['g_total'];
			$remaining_amt = (int)$collection['regular_bill']['remaining_amount'];
			$date = $collection['regular_bill']['date'];
			$fromm = date('d-M-Y',strtotime($from2));
			$tom = date('d-M-Y',strtotime($to2));
			$due = date('d-M-Y',strtotime($due_date));
			$pay_amt = $total_amount - $remaining_amt; 
			
				if($m_from <= $date && $m_to >= $date)
				{
					$nn++;
					$gt_amt = $gt_amt + $total_amount;
					$gt_pay_amt = $gt_pay_amt + $pay_amt;
					$due_amt = $due_amt + $remaining_amt;
					$date1 = date('d-m-Y',strtotime($date));

						$excel.="<tr>
						<td style='text-align:center;'>$bill_no</td>
						<td colspan='2'>$date1</td>
						<td style='text-align:center;' colspan='2'>$fromm - $tom</td>
						<td style='text-align:center;'>$due</td>
						<td style='text-align:center;'>$total_amount</td>
						<td style='text-align:center;'>$pay_amt</td>
						<td style='text-align:center;'>$remaining_amt</td>
						</tr>";
				}
			}
				$excel.="<tr>
				<th colspan='6' style='text-align:right;'>Grand Total</th>
				<th style='text-align:center;'>$gt_amt</th>
				<th style='text-align:center;'>$gt_pay_amt</th>
				<th style='text-align:center;'>$due_amt</th>
				</tr>
				<tr>
				<th style='text-align:center;' colspan='9'>
				<p style='font-size:16px;'>Bank Receipt Detail($society_name)</p>
				</th>
				</tr>
				<tr>
				<th>Receipt#</th>
				<th>Transaction Date </th>
				<th>Party Name</th>
				<th>Bill Reference</th>
				<th>Payment Mode</th>
				<th>Instrument/UTR</th>
				<th>Deposit Bank</th>
				<th>Narration</th>
				<th>Amount</th>
				</tr>";

	$total_credit = 0;
	$total_debit = 0;
	$this->loadmodel('cash_bank');
	$conditions=array("user_id"=>@$auto_id,"society_id"=>$s_society_id,"module_id"=>1);
	$cursor4 = $this->cash_bank->find('all',array('conditions'=>$conditions));
	foreach ($cursor4 as $collection) 
	{
		$receipt_no = $collection['cash_bank']['receipt_id'];
		$transaction_id = (int)$collection['cash_bank']['transaction_id'];	
		$date = $collection['cash_bank']['transaction_date'];
		$prepaired_by_id = (int)$collection['cash_bank']['prepaired_by'];
		$member = (int)$collection['cash_bank']['member'];
		$narration = $collection['cash_bank']['narration'];
		$receipt_mode = $collection['cash_bank']['receipt_mode'];
		$receipt_instruction = $collection['cash_bank']['receipt_instruction'];
		$account_id = (int)$collection['cash_bank']['account_head'];
		$amount = $collection['cash_bank']['amount'];
		$amount_category_id = (int)$collection['cash_bank']['amount_category_id'];
		$current_date = $collection['cash_bank']['current_date'];  
		if($member == 1)
		{
		$received_from_id = (int)$collection['cash_bank']['user_id'];
		$ref = $collection['cash_bank']['bill_reference'];
		$ref = "Bill No:".$ref;
		}        
			$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($received_from_id)));	
			foreach($result1 as $collection)
			{	
			$user_id = (int)$collection['ledger_sub_account']['user_id'];
			}			  
				$creation_date = date('d-m-Y',$current_date->sec);	         
				$result_prb = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($prepaired_by_id)));
				foreach ($result_prb as $collection) 
				{
				$prepaired_by_name = $collection['user']['user_name'];
				}	         
		$result = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user_id)));
		foreach ($result as $collection) 
		{
		$wing_id = (int)$collection['user']['wing'];  
		$flat_id = (int)$collection['user']['flat'];
		$tenant = (int)$collection['user']['tenant'];
		}	
			$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));	                  
			$result_lsa2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($account_id)));									
			foreach ($result_lsa2 as $collection) 
			{
			$account_no = $collection['ledger_sub_account']['name'];  
			}		
				if($date >= $m_from && $date <= $m_to)
				{
				$tr_date = date('d-M-Y',strtotime($date));
				$total_debit = $total_debit + $amount;		
				$excel.="<tr>
				<td>$receipt_no</td>
				<td>$tr_date</td>
				<td>$user_name &nbsp&nbsp&nbsp&nbsp $wing_flat</td> 
				<td>$ref</td>
				<td>$receipt_mode</td>
				<td>$receipt_instruction</td>
				<td>$account_no</td>
				<td>$narration</td>
				<td>$amount</td>
				</tr>";					
				}
			}
				$excel.="<tr>
				<th colspan='8' style='text-align:right;'>Grand Total</th>
				<th>$total_debit</th>
				</tr>
				<tr>
				<th colspan='9' style='text-align:center;'>
				<p style='font-size:16px;'>Petty Cash Receipt Detail($society_name)</p></th>
				</tr>
				<tr>
				<th colspan='2'>PC Receipt #</th>
				<th colspan='2'>Transaction Date</th>
				<th colspan='2'>Narration</th>
				<th colspan='2'>Received From</th>
				<th>Amount</th>
				</tr>";
	$n=1;
	$total_credit = 0;
	$total_debit = 0;
		$this->loadmodel('cash_bank');
		$conditions=array("society_id" => $s_society_id,"module_id"=>3);
		$cursor11=$this->cash_bank->find('all',array('conditions'=>$conditions));
		foreach($cursor11 as $collection)
		{
			$receipt_no = @$collection['cash_bank']['receipt_id'];
			$transaction_id = (int)$collection['cash_bank']['transaction_id'];	
			$account_type = (int)$collection['cash_bank']['account_type'];    									  
			$d_user_id = (int)$collection['cash_bank']['user_id'];
			$date = $collection['cash_bank']['transaction_date'];
			$prepaired_by = (int)$collection['cash_bank']['prepaired_by'];   
			$narration = $collection['cash_bank']['narration'];
			$account_head = $collection['cash_bank']['account_head'];
			$amount = $collection['cash_bank']['amount'];
			$prepaired_by = (int)$collection['cash_bank']['prepaired_by'];   
			$current_date = $collection['cash_bank']['current_date'];
			$creation_date = date('d-m-Y',$current_date->sec);

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
		$user_id = (int)$collection['ledger_sub_account']['user_id'];
		}
		$resultttt = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user_id)));
			foreach ($resultttt as $collection) 
			{
			$user_name = $collection['user']['user_name'];
			$wing_id = $collection['user']['wing'];  
			$flat_id = (int)$collection['user']['flat'];
			$tenant = (int)$collection['user']['tenant'];
			}	
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));
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

	if($account_type == 1)
	{
		if($date >= $m_from && $date <= $m_to)
		{
			if($s_user_id == $user_id)  
			{
				$date = date('d-m-Y',strtotime($date));
				$total_debit = $total_debit + $amount;
				$amount = number_format($amount);

					$excel.="<tr>
					<td colspan='2'>$receipt_no</td>
					<td colspan='2'>$date</td>
					<td colspan='2'>$narration</td>
					<td colspan='2'>$user_name &nbsp&nbsp&nbsp&nbsp $wing_flat</td>
					<td>$amount</td>
					</tr>";
			}
		}
	}
}
	$total_debit = number_format($total_debit);
		$excel.="<tr>
		<th colspan='8' style='text-align:right;'>Grand Total</th>
		<th>$total_debit</th>
		</tr></table>";

	echo $excel;
}
//////////////////////// End my flat Bill Excel///////////////////////////////////////

///////////////////////Start my flat receipt(Accounts)/////////////////////////////////
function my_flat_receipt()
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
///////////////////////End my flat receipt(Accounts)/////////////////////////////////////

////////////////// Start My Flat receipt Excel//////////////////////////////////////////
function my_flat_receipt_excel()
{
	$this->layout="";
	$filename=strtotime("now");
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

		$from = $this->request->query('f');
		$to = $this->request->query('t');

		$m_from = date("Y-m-d", strtotime($from));
		$m_from = new MongoDate(strtotime($m_from));

		$m_to = date("Y-m-d", strtotime($to));
		$m_to = new MongoDate(strtotime($m_to));

			$this->loadmodel('ledger_sub_account');
			$conditions=array("user_id"=>$s_user_id,"society_id"=>$s_society_id);
			$cursor = $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
			foreach($cursor as $collection)
			{
			$auto_id = (int)$collection['ledger_sub_account']['auto_id'];
			$user_name = $collection['ledger_sub_account']['name'];
			}

		$excel="<table border='1'>
		<tr>
		<th colspan='9' style='text-align:center;'>
		Bank Receipt Report</th>
		</tr>
			<tr>
			<th>From : $from</th>
			<th>To : $to</th>
			<th colspan='7'></th>
			</tr>
				<tr>
				<th>Receipt#</th>
				<th>Transaction Date </th>
				<th>Party Name</th>
				<th>Bill Reference</th>
				<th>Payment Mode</th>
				<th>Instrument/UTR</th>
				<th>Deposit Bank</th>
				<th>Narration</th>
				<th>Amount</th>
				</tr>";

	$total_credit = 0;
	$total_debit = 0;
		$this->loadmodel('cash_bank');
		$conditions=array("user_id"=>$auto_id,"society_id"=>$s_society_id,"module_id"=>1);
		$cursor1 = $this->cash_bank->find('all',array('conditions'=>$conditions));
		foreach ($cursor1 as $collection) 
		{
			$receipt_no = $collection['cash_bank']['receipt_id'];
			$transaction_id = (int)$collection['cash_bank']['transaction_id'];	
			$date = $collection['cash_bank']['transaction_date'];
			$prepaired_by_id = (int)$collection['cash_bank']['prepaired_by'];
			$member = (int)$collection['cash_bank']['member'];
			$narration = $collection['cash_bank']['narration'];
			$receipt_mode = $collection['cash_bank']['receipt_mode'];
			$receipt_instruction = $collection['cash_bank']['receipt_instruction'];
			$account_id = (int)$collection['cash_bank']['account_head'];
			$amount = $collection['cash_bank']['amount'];
			$amount_category_id = (int)$collection['cash_bank']['amount_category_id'];
			$current_date = $collection['cash_bank']['current_date'];  
                     
				if($member == 1)
				{
				$received_from_id = (int)$collection['cash_bank']['user_id'];
				$ref = $collection['cash_bank']['bill_reference'];
				$ref = "Bill No:".$ref;
				}     

	$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($received_from_id)));	
	foreach($result1 as $collection)
	{	
	$user_id = (int)$collection['ledger_sub_account']['user_id'];
	}		

		$creation_date = date('d-m-Y',$current_date->sec);	         
		$result_prb = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($prepaired_by_id)));
		foreach ($result_prb as $collection) 
		{
		$prepaired_by_name = $collection['user']['user_name'];
		}	

$result = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user_id)));
foreach ($result as $collection) 
{
$wing_id = (int)$collection['user']['wing'];  
$flat_id = (int)$collection['user']['flat'];
$tenant = (int)$collection['user']['tenant'];
}	

$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));	                  

	$result_lsa2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($account_id)));						
	foreach ($result_lsa2 as $collection) 
	{
	$account_no = $collection['ledger_sub_account']['name'];  
	}
	
	if($date >= $m_from && $date <= $m_to)
	{
		$tr_date = date('d-M-Y',$date->sec);
		$total_debit = $total_debit + $amount;		

		$excel.="<tr>
		<td style='text-align:center;'>$receipt_no</td>
		<td style='text-align:center;'>$tr_date</td>
		<td width='15%' style='text-align:center;'>$narration</td>
		<td style='text-align:center;'>$user_name&nbsp;&nbsp;&nbsp;&nbsp;$wing_flat</td>
		<td style='text-align:center;'>$ref</td>
		<td style='text-align:center;'>$receipt_mode</td>
		<td style='text-align:center;'>$receipt_instruction</td>
		<td style='text-align:center;'>$account_no</td>
		<td style='text-align:center;'>$amount</td>
		</tr>";			
}}
	$excel.="<tr>
	<th colspan='8'> Total</th>
	<th style='text-align:center;'>$total_debit</th>
	</tr>										 
	</table>"; 		

echo $excel;
}
////////////////// End My Flat receipt Excel/////////////////////////////////////////

//////////////////////Start my flat receipt show (Accounts)////////////////////////
function my_flat_receipt_show()
{
	$this->layout='blank';
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id = (int)$this->Session->read('user_id');	

			$this->loadmodel('society');
			$conditions=array("society_id"=>$s_society_id);
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

					$this->set('user_id',$s_user_id);

		$this->loadmodel('ledger_sub_account');
		$conditions=array("user_id"=>$s_user_id,"society_id"=>$s_society_id);
		$cursor = $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
		foreach($cursor as $collection)
		{
		$auto_id = (int)$collection['ledger_sub_account']['auto_id'];
		$user_name = $collection['ledger_sub_account']['name'];
		}
		$this->set('user_name',$user_name);

			$this->loadmodel('cash_bank');
			$conditions=array("user_id"=>$auto_id,"society_id"=>$s_society_id,"module_id"=>1);
			$cursor1 = $this->cash_bank->find('all',array('conditions'=>$conditions));
			$this->set('cursor1',$cursor1);
}
//////////////////////End my flat receipt show (Accounts)/////////////////////////////////////

//////////////////// Start Trial Balance Excel/////////////////////////////////////////////////
function trial_balance_excel()
{
		$this->layout="";
		$filename="Trial balance";
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

				$this->loadmodel('society');
				$conditions=array("society_id" => $s_society_id);
				$cursor=$this->society->find('all',array('conditions'=>$conditions));
				foreach ($cursor as $collection)  
				{
				$society_name = $collection['society']['society_name'];
				}

					$from = $this->request->query('f');
					$to = $this->request->query('t');
					$tp = (int)$this->request->query('tp');

						$m_from = date("Y-m-d", strtotime($from));
						$m_to = date("Y-m-d", strtotime($to));

			if($tp == 1)
			{
				$excel="<table border='1'>
				<tr>
				<th colspan='5' style='text-align:center;'>
				$society_name</th>
				</tr>
				<tr>
				<th colspan='5' style='text-align:center;'>
				Trial balance For The Period $from to $to
				</th>
				</tr>
				<tr>
				<th style='text-align:center;'>Account Name</th>
				<th style='text-align:center;'>Opening Balance</th>
				<th style='text-align:center;'>Debit</th>
				<th style='text-align:center;'>Credit</th>
				<th style='text-align:center;'>Closing balance</th>
				</tr>";
				
	$grand_total_debit = 0;
	$grand_total_credit = 0;
	$grand_total_opening_balance = 0;
	$grand_total_closing_balance = 0;
			$this->loadmodel('ledger_sub_account');
			$conditions=array("ledger_id"=>15);
			$cursor3 = $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
			foreach($cursor3 as $collection)
			{
				$auto_id11 = (int)$collection['ledger_sub_account']['auto_id'];
				$account_name = $collection['ledger_sub_account']['name'];
				$total_debit1 = 0;
				$total_credit1 = 0;
				$total_opening_balance = 0;
				$total_closing_balance = 0;

	$ledger1 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_fetch1'),array('pass'=>array($auto_id11)));		
		foreach ($ledger1 as $collection) 
		{
		$op_date = "";
		$amount1 = $collection['ledger']['amount'];
		$ammount_type_id1 = (int)$collection['ledger']['amount_category_id'];
		$receipt_id = $collection['ledger']['receipt_id'];
			if($receipt_id == 'O_B')
			{
			$op_date = @$collection['ledger']['op_date'];
			}
				$table_name = $collection['ledger']['table_name'];
					if($table_name == "cash_bank")
					{
					$module_id = (int)$collection['ledger']['module_id'];
					}

	if($receipt_id != 'O_B')
		{
		if($table_name == "cash_bank")
			{
				$date_fetch=$this->requestAction(array('controller'=>'hms','action'=>'module_main_fetch5'),array('pass'=>array($table_name,$receipt_id,$module_id)));				
			}
			else
			{
			$date_fetch=$this->requestAction(array('controller'=>'hms','action'=>'module_main_fetch3'),array('pass'=>array($table_name,$receipt_id)));	
			}
			foreach ($date_fetch as $collection) 
				{
				$date1 = @$collection[$table_name]['transaction_date'];
				if(empty($date1))
				{
				$date1 = @$collection[$table_name]['posting_date'];	
				}
				if(empty($date1))
				{
				$date1 = @$collection[$table_name]['purchase_date'];	
				}
					if(empty($date1))
					{
					$date1 = @$collection[$table_name]['date'];	
					}
				}	
			}
			else 
			{
				if($receipt_id == 'O_B')
					{
					if($op_date < $from)
						{
						if($ammount_type_id1 == 1)
							{
							$total_opening_balance = $total_opening_balance - $amount1;
							}
						else if($ammount_type_id1 == 2)
							{
							$total_opening_balance = $total_opening_balance + $amount1;	
							}
						}
					}
					else
						{
							if($ammount_type_id1 == 1)
							{
							$total_closing_balance = $total_closing_balance - $amount1;	
							}
							else if($ammount_type_id1 == 2)
							{
							$total_closing_balance = $total_closing_balance + $amount1;	
							}
						}
					}

			if($receipt_id != 'O_B')
			{
				if($date1 >= $m_from && $date1 <= $m_to)
					{
					if($ammount_type_id1 == 1)
					{
					$total_debit1 = $total_debit1 + $amount1;	
					$grand_total_debit = $grand_total_debit + $amount1;
					}
					else if($ammount_type_id1 == 2)
					{
					$total_credit1 = $total_credit1 + $amount1;	
					$grand_total_credit = $grand_total_credit + $amount1;
					}
				}	
			}
		}
		
if($total_debit1 != 0 || $total_credit1 != 0)
{
$total_closing_balance = $total_closing_balance + $total_opening_balance + $total_credit1 - $total_debit1;
$grand_total_closing_balance = $grand_total_closing_balance + $total_closing_balance;
$grand_total_opening_balance = $grand_total_opening_balance + $total_opening_balance;

	$excel.="<tr><td style='text-align:center;'>          
	$account_name
	</td>
	<td style='text-align:center;'>";
			if($total_opening_balance > 0)
			{
			$total_opening_balance = $total_opening_balance.'Cr';
			}
			else if($total_opening_balance < 0)
			{
			$total_opening_balance = abs($total_opening_balance);
			$total_opening_balance = $total_opening_balance.'Dr';
			}
	$excel.="$total_opening_balance</td>
			<td style='text-align:center;'>$total_debit1</td>
			<td style='text-align:center;'>$total_credit1</td>
			<td>";
				if($total_closing_balance > 0)
				{
				$total_closing_balance = $total_closing_balance.'Cr';
				}
				else if($total_closing_balance < 0)
				{
				$total_closing_balance = abs($total_closing_balance);
				$total_closing_balance = $total_closing_balance.'Dr';
				}
				$excel.="$total_closing_balance</td>
				</tr>";
				}}	
					$excel.="<tr>
					<th style='text-align:center;'>Total</th>
					<th style='text-align:center;'>"; 
					if($grand_total_opening_balance > 0)
					{
					$grand_total_opening_balance = $grand_total_opening_balance.'Cr';
					}
						else if($grand_total_opening_balance < 0)
						{
						$grand_total_opening_balance = abs($grand_total_opening_balance);
						$grand_total_opening_balance = $grand_total_opening_balance.'Dr';
						}
				$excel.="$grand_total_opening_balance</th>
				<th style='text-align:center;'>$grand_total_debit</th>
				<th style='text-align:center;'>$grand_total_credit</th>
				<th style='text-align:center;'>";
					if($grand_total_closing_balance > 0)
					{
					$grand_total_closing_balance = $grand_total_closing_balance.'Cr';
					}
					else if($grand_total_closing_balance < 0)
					{
					$grand_total_closing_balance = abs($grand_total_closing_balance);
					$grand_total_closing_balance = $grand_total_closing_balance.'Dr';
					}
						$excel.="$grand_total_closing_balance</th>
						</tr>
						</table>";
					}
			if($tp == 2)
			{
$excel="<table border='1'>
<tr>
<th colspan='5' style='text-align:center;'>
$society_name
</th>
</tr>
<tr>
<th colspan='5' style='text-align:center;'>
Trial balance for the Period $from to $to
</th>
</tr>
<tr>
<th style='text-align:center;'>Account Name</th>
<th style='text-align:center;'>Opening Balance</th>
<th style='text-align:center;'>Debit</th>
<th style='text-align:center;'>Credit</th>
<th style='text-align:center;'>Closing balance</th>
</tr>";
		$grand_total_debit = 0;
		$grand_total_credit = 0;
		$grand_total_opening_balance = 0;
		$grand_total_closing_balance = 0;
			$this->loadmodel('ledger_sub_account');
			$conditions=array("ledger_id"=>34);
			$cursor4 = $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
			foreach($cursor4 as $collection)
			{
				$auto_id11 = (int)$collection['ledger_sub_account']['auto_id'];
				$account_name = $collection['ledger_sub_account']['name'];
				$total_debit1 = 0;
				$total_credit1 = 0;
				$total_opening_balance = 0;
				$total_closing_balance = 0;
		$ledger1 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_fetch1'),array('pass'=>array($auto_id11)));		
			foreach ($ledger1 as $collection) 
			{
			$amount1 = $collection['ledger']['amount'];
			$ammount_type_id1 = (int)$collection['ledger']['amount_category_id'];
			//$module_id = (int)@$collection['ledger']['module_id'];
			$receipt_id = (int)$collection['ledger']['receipt_id'];
			$op_date = @$collection['ledger']['op_date']; 
			$table_name = $collection['ledger']['table_name']; 
			if($table_name == "cash_bank")
			{ 
			$module_id = (int)$collection['ledger']['module_id']; 
			}
				if($receipt_id != 'O_B')
				{
					if($table_name == "cash_bank")
					{
					$date_fetch=$this->requestAction(array('controller'=>'hms','action'=>'module_main_fetch5'),array('pass'=>array($table_name,$receipt_id,$module_id)));	
					}
					else
					{
					$date_fetch=$this->requestAction(array('controller'=>'hms','action'=>'module_main_fetch3'),array('pass'=>array($table_name,$receipt_id)));	
					}			
		foreach ($date_fetch as $collection) 
		{
		$date1 = @$collection[$table_name]['transaction_date'];
			if(empty($date1))
			{
			$date1 = @$collection[$table_name]['posting_date'];	
			}
			if(empty($date1))
			{
			$date1 = @$collection[$table_name]['purchase_date'];	
			}
			if(empty($date1))
			{
			$date1 = @$collection[$table_name]['date'];	
			}
		}		
	}
	else
	{
		if($op_date < $from)
		{
			if($ammount_type_id1 == 1)
			{
			$total_opening_balance = $total_opening_balance - $amount1;
			}
			else if($ammount_type_id1 == 2)
			{
			$total_opening_balance = $total_opening_balance + $amount1;	
			}
		}
		else
		{
			if($ammount_type_id1 == 1)
			{
			$total_closing_balance = $total_closing_balance - $amount1;	
			}
			else if($ammount_type_id1 == 2)
			{
			$total_closing_balance = $total_closing_balance + $amount1;	
			}
		}
	}

	if($receipt_id != 'O_B')
	{		
		if($date1 < $m_from)
		{
			if($ammount_type_id1 == 1)
			{
			$total_opening_balance = $total_opening_balance - $amount1;
			}
			else if($ammount_type_id1 == 2)
			{
			$total_opening_balance = $total_opening_balance + $amount1;	
			}
		}

	if($date1 >= $m_from && $date1 <= $m_to)
	{
		if($ammount_type_id1 == 1)
		{
		$total_debit1 = $total_debit1 + $amount1;	
		$grand_total_debit = $grand_total_debit + $amount1;
		}
		else if($ammount_type_id1 == 2)
		{
		$total_credit1 = $total_credit1 + $amount1;	
		$grand_total_credit = $grand_total_credit + $amount1;
		}
		}	
	}
	}
	if($total_debit1 != 0 || $total_credit1 != 0)
	{
	$total_closing_balance = $total_closing_balance + $total_opening_balance + $total_credit1 - $total_debit1;
	$grand_total_closing_balance = $grand_total_closing_balance + $total_closing_balance;
	$grand_total_opening_balance = $grand_total_opening_balance + $total_opening_balance;
	
$excel.="<tr>
<td style='text-align:center;'>          
$account_name
</td><td style='text-align:center;'>"; 
		if($total_opening_balance > 0)
		{
		$total_opening_balance = $total_opening_balance.'Cr';
		}
		else if($total_opening_balance < 0)
		{
		$total_opening_balance = abs($total_opening_balance);
		$total_opening_balance = $total_opening_balance.'Dr';
		}
			$excel.="$total_opening_balance</td>
			<td style='text-align:center;'>$total_debit1</td>
			<td style='text-align:center;'>$total_credit1</td>
			<td style='text-align:center;'>";
				if($total_closing_balance > 0)
				{
				$total_closing_balance = $total_closing_balance.'Cr';
				}
				else if($total_closing_balance < 0)
				{
				$total_closing_balance = abs($total_closing_balance);
				$total_closing_balance = $total_closing_balance.'Dr';
				}
	$excel.="$total_closing_balance</td>
	</tr>";
	}}
		$excel.="
		<tr>
		<th style='text-align:center;'>Total</th>
		<th style='text-align:center;'>"; 
			if($grand_total_opening_balance > 0)
			{
			$grand_total_opening_balance = $grand_total_opening_balance.'Cr';
			}
			else if($grand_total_opening_balance < 0)
			{
			$grand_total_opening_balance = abs($grand_total_opening_balance);
			$grand_total_opening_balance = $grand_total_opening_balance.'Dr';
			}
				$excel.="$grand_total_opening_balance</th>
				<th style='text-align:center;'>$grand_total_debit</th>
				<th style='text-align:center;'>$grand_total_credit</th>
				<th style='text-align:center;'>";
					if($grand_total_closing_balance > 0)
					{		
					$grand_total_closing_balance = $grand_total_closing_balance.'Cr';
					}
					else if($grand_total_closing_balance < 0)
					{
					$grand_total_closing_balance = abs($grand_total_closing_balance);
					$grand_total_closing_balance = $grand_total_closing_balance.'Dr';
					}
						$excel.="$grand_total_closing_balance</th>
						</tr>
						</table>";
						}
			if($tp == 4)
			{
				$excel="<table border='1'>
				<tr>
				<th colspan='5' style='text-align:center;'>
				$society_name</th>
				</tr>

				<tr>
				<th colspan='5' style='text-align:center;'>
				Trial balance for the Period $from to $to
				</th>
				</tr>
				<tr>
				<th style='text-align:center;'>Account Name</th>
				<th style='text-align:center;'>Opening Balance</th>
				<th style='text-align:center;'>Debit</th>
				<th style='text-align:center;'>Credit</th>
				<th style='text-align:center;'>Closing balance</th>
				</tr>";

		$grand_total_debit = 0;
		$grand_total_credit = 0;
		$grand_total_opening_balance = 0;
		$grand_total_closing_balance = 0;

			$this->loadmodel('ledger_sub_account');
			$conditions=array("ledger_id"=>33);
			$cursor5 = $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
			foreach($cursor5 as $collection)
			{
				$auto_id11 = (int)$collection['ledger_sub_account']['auto_id'];
				$account_name = $collection['ledger_sub_account']['name'];
				$total_debit1 = 0;
				$total_credit1 = 0;
				$total_opening_balance = 0;
				$total_closing_balance = 0;

		$ledger1 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_fetch1'),array('pass'=>array($auto_id11)));
		
		foreach ($ledger1 as $collection) 
		{
		$amount1 = $collection['ledger']['amount'];
		$ammount_type_id1 = (int)$collection['ledger']['amount_category_id'];
		$receipt_id = (int)$collection['ledger']['receipt_id'];
		$op_date = @$collection['ledger']['op_date'];
		$table_name = $collection['ledger']['table_name']; 
			if($table_name == "cash_bank")
			{
			$module_id = (int)$collection['ledger']['module_id'];
			} 
 
	if($receipt_id != 'O_B')
	{
		if($table_name == "cash_bank")
		{
		$date_fetch=$this->requestAction(array('controller'=>'hms','action'=>'module_main_fetch5'),array('pass'=>array($table_name,$receipt_id,$module_id)));
		}
		else
		{
		$date_fetch=$this->requestAction(array('controller'=>'hms','action'=>'module_main_fetch3'),array('pass'=>array($table_name,$receipt_id)));
		}
			
			foreach ($date_fetch as $collection) 
			{
				$date1 = @$collection[$table_name]['transaction_date'];
				if(empty($date1))
				{
				$date1 = @$collection[$table_name]['posting_date'];	
				}
				if(empty($date1))
				{
				$date1 = @$collection[$table_name]['purchase_date'];	
				}
				if(empty($date1))
				{
				$date1 = @$collection[$table_name]['date'];	
				}
			}		
		}
		else
		{
			if($op_date < $from)
			{
				if($ammount_type_id1 == 1)
				{
				$total_opening_balance = $total_opening_balance - $amount1;
				}
				else if($ammount_type_id1 == 2)
				{
				$total_opening_balance = $total_opening_balance + $amount1;	
				}
			}
			else
			{
				if($ammount_type_id1 == 1)
				{
				$total_closing_balance = $total_closing_balance - $amount1;	
				}
				else if($ammount_type_id1 == 2)
				{
				$total_closing_balance = $total_closing_balance + $amount1;	
				}
			}
		}

		if($receipt_id != 'O_B')
		{
			if($date1 < $m_from)
			{
				if($ammount_type_id1 == 1)
				{
				$total_opening_balance = $total_opening_balance - $amount1;
				}
					else if($ammount_type_id1 == 2)
					{
					$total_opening_balance = $total_opening_balance + $amount1;	
					}
			}

			if($date1 >= $m_from && $date1 <= $m_to)
			{
				if($ammount_type_id1 == 1)
				{
				$total_debit1 = $total_debit1 + $amount1;	
				$grand_total_debit = $grand_total_debit + $amount1;
				}
				else if($ammount_type_id1 == 2)
				{
				$total_credit1 = $total_credit1 + $amount1;	
				$grand_total_credit = $grand_total_credit + $amount1;
				}
			}	
		}
	}
	
	if($total_debit1 != 0 || $total_credit1 != 0)
	{
	$total_closing_balance = $total_closing_balance + $total_opening_balance + $total_credit1 - $total_debit1;
	$grand_total_closing_balance = $grand_total_closing_balance + $total_closing_balance;
	$grand_total_opening_balance = $grand_total_opening_balance + $total_opening_balance;

	$excel.="<tr>
	<td style='text-align:center;'>$account_name</td>
	<td style='text-align:center;'>";
		if($total_opening_balance > 0)
		{
		$total_opening_balance = $total_opening_balance.'Cr';
		}
		else if($total_opening_balance < 0)
		{
		$total_opening_balance = abs($total_opening_balance);
		$total_opening_balance = $total_opening_balance.'Dr';
		}
			$excel.="$total_opening_balance</td>
			<td style='text-align:center;'>$total_debit1</td>
			<td style='text-align:center;'>$total_credit1</td>
			<td style='text-align:center;'>";
				if($total_closing_balance > 0)
				{
				$total_closing_balance = $total_closing_balance.'Cr';
				}
				else if($total_closing_balance < 0)
				{
				$total_closing_balance = abs($total_closing_balance);
				$total_closing_balance = $total_closing_balance.'Dr';
				}
				$excel.="$total_closing_balance</td>
				</tr>";
				}}
			$excel.="<tr>
			<th style='text-align:center;'>Total</th>
			<th style='text-align:center;'>"; 
			
			if($grand_total_opening_balance > 0)
			{
			$grand_total_opening_balance = $grand_total_opening_balance.'Cr';
			}
			else if($grand_total_opening_balance < 0)
			{
			$grand_total_opening_balance = abs($grand_total_opening_balance);
			$grand_total_opening_balance = $grand_total_opening_balance.'Dr';
			}
			
		$excel.="$grand_total_opening_balance</th>
		<th style='text-align:center;'>$grand_total_debit</th>
		<th style='text-align:center;'>$grand_total_credit</th>
		<th style='text-align:center;'>";
		if($grand_total_closing_balance > 0)
		{
		$grand_total_closing_balance = $grand_total_closing_balance.'Cr';
		}
		else if($grand_total_closing_balance < 0)
		{
		$grand_total_closing_balance = abs($grand_total_closing_balance);
		$grand_total_closing_balance = $grand_total_closing_balance.'Dr';
		}
			$excel.="$grand_total_closing_balance</th>
			</tr>
			</table>";
		}

		if($tp == 3)
		{
$excel="
<table border='1'>
<tr>
<th colspan='6' style='text-align:center;'>
$society_name
</th>
</tr>
<tr>
<th colspan='6' style='text-align:center;'>
Trial balance for the Period $from to $to
</th>
</tr>

<tr>
<th style='text-align:center;'>Account Name</th>
<th style='text-align:center;'>Sub Account Name</th>
<th style='text-align:center;'>Opening Balance</th>
<th style='text-align:center;'>Debit</th>
<th style='text-align:center;'>Credit</th>
<th style='text-align:center;'>Closing balance</th>
</tr>";

	$grand_total_debit = 0;
	$grand_total_credit = 0;
	$grand_total_opening_balance = 0;
	$grand_total_closing_balance = 0;
		$this->loadmodel('accounts_category');
		$order=array('accounts_category.auto_id'=> 'ASC');
		$cursor2 = $this->accounts_category->find('all',array('order' =>$order));
		foreach($cursor2 as $collection)
		{
		$auto_id11 = (int)$collection['accounts_category']['auto_id'];
		$result11 = $this->requestAction(array('controller' => 'hms', 'action' => 'accounts_group_fetch'),array('pass'=>array($auto_id11)));
			foreach($result11 as $collection)
			{
				$auto_id22 = (int)$collection['accounts_group']['auto_id'];
				$result22 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch'),array('pass'=>array($auto_id22)));
				foreach($result22 as $collection)
				{
				$auto_id3 = (int)$collection['ledger_account']['auto_id'];
				$account_name = $collection['ledger_account']['ledger_name'];

	if($auto_id3 == 34 || $auto_id3 == 15 || $auto_id3 == 33 || $auto_id3 == 35)
	{	
		$total_debit1 = 0;
		$total_credit1 = 0;
		$total_opening_balance = 0;
		$total_closing_balance = 0;
		$n=1;
			$result_lsa1 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch2'),array('pass'=>array($auto_id3)));
			
	foreach ($result_lsa1 as $collection) 
	{
	$sub_id1 = (int)$collection['ledger_sub_account']['auto_id'];
	$sub_account_name1 = $collection['ledger_sub_account']['name'];

		$ledger1 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_fetch1'),array('pass'=>array($sub_id1)));	
		
	foreach ($ledger1 as $collection) 
	{
	$amount1 = $collection['ledger']['amount'];
	$ammount_type_id1 = (int)$collection['ledger']['amount_category_id'];
	$receipt_id = (int)$collection['ledger']['receipt_id'];
	$op_date = @$collection['ledger']['op_date'];
	$table_name = $collection['ledger']['table_name'];
		if($table_name == "cash_bank")
		{
		$module_id = (int)$collection['ledger']['module_id'];
		}
			if($receipt_id != 'O_B')
			{
				if($table_name == "cash_bank")
				{
				$date_fetch=$this->requestAction(array('controller'=>'hms','action'=>'module_main_fetch5'),array('pass'=>array($table_name,$receipt_id,$module_id)));	
				}
				else
				{
				$date_fetch=$this->requestAction(array('controller'=>'hms','action'=>'module_main_fetch3'),array('pass'=>array($table_name,$receipt_id)));				
				}

			foreach ($date_fetch as $collection) 
			{
				$date1 = @$collection[$table_name]['transaction_date'];
				if(empty($date1))
				{
				$date1 = @$collection[$table_name]['posting_date'];	
				}
				if(empty($date1))
				{
				$date1 = @$collection[$table_name]['purchase_date'];	
				}
				if(empty($date1))
				{
				$date1 = @$collection[$table_name]['date'];	
				}
			}	
		}
		else
		{
			if($op_date < $from)
			{
				if($ammount_type_id1 == 1)
				{
				$total_opening_balance = $total_opening_balance - $amount1;
				}
				else if($ammount_type_id1 == 2)
				{
				$total_opening_balance = $total_opening_balance + $amount1;	
				}
			}
			else
			{
				if($ammount_type_id1 == 1)
				{
				$total_closing_balance = $total_closing_balance - $amount1;	
				}
				else if($ammount_type_id1 == 2)
				{
				$total_closing_balance = $total_closing_balance + $amount1;	
				}
			}
			}

	if($receipt_id != 'O_B')
	{	
		if($date1 < $m_from)
		{
			if($ammount_type_id1 == 1)
			{
			$total_opening_balance = $total_opening_balance - $amount1;
			}
			else if($ammount_type_id1 == 2)
			{
			$total_opening_balance = $total_opening_balance + $amount1;	
			}
		}

			if($date1 >= $m_from && $date1 <= $m_to)
			{
				if($ammount_type_id1 == 1)
				{
				$total_debit1 = $total_debit1 + $amount1;	
				}
				else if($ammount_type_id1 == 2)
				{
				$total_credit1 = $total_credit1 + $amount1;	
				}
			}	
		}
	}
}

	if($total_debit1 != 0 || $total_credit1 != 0)
	{
	$total_closing_balance = $total_closing_balance + $total_opening_balance + $total_credit1 - $total_debit1; 
	$grand_total_closing_balance = $grand_total_closing_balance + $total_closing_balance;
	$grand_total_opening_balance = $grand_total_opening_balance + $total_opening_balance;  

		$excel.="<tr>
		<td>$account_name</td>
		<td></td>
		<td>"; 
			if($total_opening_balance > 0)
			{
			$total_opening_balance = $total_opening_balance.'Cr';
			}
			else if($total_opening_balance < 0) 
			{ 
			$total_opening_balance = abs($total_opening_balance);
			$total_opening_balance = $total_opening_balance.'Dr';
			}
				$excel.="</td>
				<td></td>
				<td></td>
				<td>";
					if($total_closing_balance > 0)
					{
					$total_closing_balance = $total_closing_balance.'Cr';
					}
					else if($total_closing_balance < 0)
					{
					$total_closing_balance = abs($total_closing_balance);
					$total_closing_balance = $total_closing_balance.'Dr';
					}
						$excel.="</td>
						</tr>
						<tr>
						<td colspan='6'>";
						$excel.="
						<table border='1'>";

	$n++;
		$total_sub_credit = 0;
		$total_sub_debit = 0;
		$total_sub_opening_balance = 0;
		$total_sub_closing_balance = 0;
	$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch2'),array('pass'=>array($auto_id3)));			
		foreach ($result_lsa as $collection) 
		{
		$sub_id = (int)$collection['ledger_sub_account']['auto_id'];
		$sub_account_name = $collection['ledger_sub_account']['name'];

	$debit_sub = 0;
	$credit_sub = 0;
	$opening_balance_sub = 0;
	$closing_balance_sub = 0;
		$ledger2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_fetch1'),array('pass'=>array($sub_id)));	
		
	foreach ($ledger2 as $collection) 
	{
	$amount = $collection['ledger']['amount'];
	$ammount_type_id = (int)$collection['ledger']['amount_category_id'];
	$receipt_id_s = (int)$collection['ledger']['receipt_id'];
	$op_date2 = @$collection['ledger']['op_date'];
	$table_name = $collection['ledger']['table_name'];
		if($table_name == "cash_bank")
		{
		$module_id = (int)$collection['ledger']['module_id'];
		}
	if($receipt_id_s != 'O_B')
	{	
		if($table_name == "cash_bank")
		{
		$date_fetch2 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch5'),array('pass'=>array($table_name,$receipt_id_s,$module_id)));
		}
		else
		{
		$date_fetch2 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch3'),array('pass'=>array($table_name,$receipt_id_s)));
		}	
			foreach ($date_fetch2 as $collection) 
			{
			$date2 = @$collection[$table_name]['transaction_date'];
				if(empty($date2))
				{
				$date2 = @$collection[$table_name]['posting_date'];	
				}
				if(empty($date2))
				{
				$date2 = @$collection[$table_name]['purchase_date'];	
				}
				if(empty($date2))
				{
				$date2 = @$collection[$table_name]['date'];	
				}
			}	
		}
		else
		{
			if($op_date2 < $from)
			{
				if($ammount_type_id == 1)
				{
				$opening_balance_sub = $opening_balance_sub - $amount;
				}
				else if($ammount_type_id == 2)
				{
				$opening_balance_sub = $opening_balance_sub + $amount;	
				}
			}
			else
			{
				if($ammount_type_id == 1)
				{
				$closing_balance_sub = $closing_balance_sub - $amount;	
				}
				else if($ammount_type_id == 2)
				{
				$closing_balance_sub = $closing_balance_sub + $amount;	
				}
			}	
		}

		if($receipt_id_s != 'O_B')
		{
			if($date2 < $m_from)
			{
				if($ammount_type_id == 1)
				{
				$opening_balance_sub = $opening_balance_sub - $amount;
				}
				else if($ammount_type_id == 2)
				{
				$opening_balance_sub = $opening_balance_sub + $amount;
				}
			}

		if($date2 >= $m_from && $date2 <= $m_to)
		{
			if($ammount_type_id == 1)
			{
			$debit_sub = $debit_sub + $amount;
			$total_sub_debit = $total_sub_debit + $amount;
			$grand_total_debit = $grand_total_debit + $amount;
			}
			else if($ammount_type_id == 2)
			{
			$credit_sub = $credit_sub + $amount;
			$total_sub_credit = $total_sub_credit + $amount;
			$grand_total_credit =$grand_total_credit + $amount;
			}
		}
		}
		}
		
	if($credit_sub != 0 || $debit_sub != 0)
	{
	$closing_balance_sub = $closing_balance_sub + $opening_balance_sub - $debit_sub + $credit_sub;
	$total_sub_closing_balance = $total_sub_closing_balance + $closing_balance_sub;
	$total_sub_opening_balance = $total_sub_opening_balance + $opening_balance_sub;
	
$excel.="<tr>
<td></td>
<td>$sub_account_name</td>
<td>";
		if($opening_balance_sub > 0)
		{
		$opening_balance_sub = $opening_balance_sub.'Cr';
		}
		else if($opening_balance_sub < 0)
		{
		$opening_balance_sub = abs($opening_balance_sub);
		$opening_balance_sub = $opening_balance_sub.'Dr';
		}
		
		$excel.="$opening_balance_sub</td>
		<td>$debit_sub</td>
		<td>$credit_sub</td>
		<td>";
			if($closing_balance_sub > 0)
			{
			$closing_balance_sub = $closing_balance_sub.'Cr';
			}
			else if($closing_balance_sub < 0)
			{
			$closing_balance_sub = abs($closing_balance_sub);
			$closing_balance_sub = $closing_balance_sub.'Dr';
			}
		$excel.="$closing_balance_sub</td>
		</tr>";
		}}

	$excel.="</table>
	</td>
	</tr>";
		}}
		else
		{
	$total_debit = 0;
	$total_credit = 0;
	$total_opening_balance2 = 0;
	$total_closing_balance2 = 0;
		$ledger_fetch2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_fetch2'),array('pass'=>array($auto_id3)));	
	foreach ($ledger_fetch2 as $collection) 
	{
	$amount = $collection['ledger']['amount'];
	$amount_type_id = (int)$collection['ledger']['amount_category_id'];
	$receipt_id2 = (int)$collection['ledger']['receipt_id'];
	$op_date3 = @$collection['ledger']['op_date'];
	$table_name = $collection['ledger']['table_name'];
		if($table_name == "cash_bank")
		{
		$module_id = (int)$collection['ledger']['module_id'];
		}
	if($receipt_id2 != 'O_B')
	{
		if($table_name == "cash_bank")
		{
		$module_fetch3 = $this->requestAction(array('controller' => 'hms', 'action' =>'module_main_fetch5'),array('pass'=>array($table_name,$receipt_id2,$module_id)));
		}
		else
		{
		$module_fetch3 = $this->requestAction(array('controller' => 'hms', 'action' =>'module_main_fetch3'),array('pass'=>array($table_name,$receipt_id2)));
		}
			foreach ($module_fetch3 as $collection) 
			{
				$date3 = @$collection[$table_name]['transaction_date'];
				if(empty($date3))
				{
				$date3 = @$collection[$table_name]['posting_date'];	
				}
				if(empty($date3))
				{
				$date3 = @$collection[$table_name]['purchase_date'];	
				}
				if(empty($date3))
				{
				$date3 = @$collection[$table_name]['date'];	
				}
			}		
		}
		else
		{
			if($op_date3 < $from)
			{
				if($amount_type_id == 1)
				{
				$total_opening_balance2 = $total_opening_balance2 - $amount;
				}
				else if($amount_type_id == 2)
				{
				$total_opening_balance2 = $total_opening_balance2 + $amount;	
				}
			}
			else
			{
				if($amount_type_id == 1)
				{
				$total_closing_balance2 = $total_closing_balance2 - $amount;	
				}
				else if($amount_type_id == 2)
				{
				$total_closing_balance2 = $total_closing_balance2 + $amount;	
				}
			}		
		}

		if($receipt_id2 != 'O_B')
		{
			if($date3 < $m_from)
			{
				if($amount_type_id == 1)
				{
				$total_opening_balance2 = $total_opening_balance2 - $amount;
				}
				else if($amount_type_id == 2)
				{
				$total_opening_balance2 = $total_opening_balance2 + $amount;
				}
			}

		if(@$date3 >= $m_from && @$date3 <= $m_to)
		{
			if($amount_type_id == 1)
			{
			$total_debit = $total_debit + $amount;
			$grand_total_debit = $grand_total_debit + $amount;
			}
			else if($amount_type_id == 2)
			{
			$total_credit = $total_credit + $amount;
			$grand_total_credit = $grand_total_credit + $amount;
			}
		}
	}
	}
	
	if($total_debit !=0 || $total_credit != 0)
	{ 
	$total_closing_balance2 = $total_closing_balance2 + $total_opening_balance2 + $total_credit - $total_debit;
	$grand_total_closing_balance = $grand_total_closing_balance + $total_closing_balance2;
	$grand_total_opening_balance = $grand_total_opening_balance + $total_opening_balance2;

	$excel.="<tr>
	<td>$account_name</td>
	<td></td>
	<td>"; 
		if($total_opening_balance2 > 0)
		{
		$total_opening_balance2 = $total_opening_balance2.'Cr';
		}
		else if($total_opening_balance2 < 0)
		{
		$total_opening_balance2 = abs($total_opening_balance2);
		$total_opening_balance2 = $total_opening_balance2.'Dr';
		}
$excel.="$total_opening_balance2</th>
<td>$total_debit</td>
<td>$total_credit</td>
<td>";
		if($total_closing_balance2 > 0)
		{
		$total_closing_balance2 = $total_closing_balance2.'Cr';
		}
		else if($total_closing_balance2 < 0)
		{
		$total_closing_balance2 = abs($total_closing_balance2);
		$total_closing_balance2 = $total_closing_balance2.'Dr';
		}
		$excel.="$total_closing_balance2</td>
		</tr>";  
	}}}}}
		$excel.="<tr>
			<th colspan=''>Grand Total</th>
			<th></th>
			<th>";
				if($grand_total_opening_balance > 0)
				{
				$grand_total_opening_balance = $grand_total_opening_balance.'Cr';
				}
				else if($grand_total_opening_balance < 0)
				{
				$grand_total_opening_balance = abs($grand_total_opening_balance);
				$grand_total_opening_balance = $grand_total_opening_balance.'Dr';
				}
			$excel.="$grand_total_opening_balance</th>   
			<th>$grand_total_debit</th>
			<th>$grand_total_credit</th>
			<th>"; 
				if($grand_total_closing_balance > 0)
				{
				$grand_total_closing_balance = $grand_total_closing_balance.'Cr';
				}
				else if($grand_total_closing_balance < 0)
				{
				$grand_total_closing_balance = abs($grand_total_closing_balance);
				$grand_total_closing_balance = $grand_total_closing_balance.'Dr';
				}
					$excel.="$grand_total_closing_balance</th>
					</tr>
					</table>";
			}
echo $excel;
}
//////////////////////////// End Trial Balance Excel/////////////////////////////////////////////


//////////////////////// Start Balance Shit //////////////////////////////

function balance_sheet(){
				if($this->RequestHandler->isAjax()){
				$this->layout='blank';
				}else{
				$this->layout='session';
				}	
				$this->ath();
				$this->check_user_privilages();
		}

		function income_expenditure(){
				if($this->RequestHandler->isAjax()){
				$this->layout='blank';
				}else{
				$this->layout='session';
				}	
				$this->ath();
				$this->check_user_privilages();
		}


function balance_sheet_ajax($from=null){
	
		
	$this->layout='blank';
	$this->ath();
	
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$this->set('s_society_id',$s_society_id);
	$s_user_id=$this->Session->read('user_id');	
	
	if(empty($from)){
		echo "<center style='color:red;'>Fill above fields.</center>"; exit;
	}
		$this->set('from',$from);
		$this->loadmodel('accounts_group');
		$conditions2=array("accounts_id" => 1);
		$result_accounts_group=$this->accounts_group->find('all',array('conditions'=>$conditions2));
		$this->set('result_accounts_group',$result_accounts_group);
		
		
		$this->loadmodel('accounts_group');
		$conditions3=array("accounts_id" => 2);
		$result_accounts_group1=$this->accounts_group->find('all',array('conditions'=>$conditions3));
		$this->set('result_accounts_group1',$result_accounts_group1);	
	
		
	
	
}



function income_expenditure_ajax($from=null,$to=null){
			
	$this->layout='blank';
	$this->ath();
	
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$this->set('s_society_id',$s_society_id);
	$s_user_id=$this->Session->read('user_id');	
	
	if(empty($from) or empty($to)){
		echo "<center style='color:red;'>Fill above fields.</center>"; exit;
	}
		$this->set('from',$from);
		$this->set('to',$to);
		
		$this->loadmodel('accounts_group');
		$conditions4=array("accounts_id" => 3);
		$result_accounts_group2=$this->accounts_group->find('all',array('conditions'=>$conditions4));
		$this->set('result_accounts_group2',$result_accounts_group2);	
	
		$this->loadmodel('accounts_group');
		$conditions5=array("accounts_id" => 4);
		$result_accounts_group3=$this->accounts_group->find('all',array('conditions'=>$conditions5));
		$this->set('result_accounts_group3',$result_accounts_group3);	
	
	
}

function balance_sheet_excel(){
		$this->layout='blank';
		$this->ath();
		$s_society_id = (int)$this->Session->read('society_id');	
		$result_society=$this->society_name($s_society_id);
		$this->set('society_name',$result_society[0]['society']['society_name']);
		$from=$this->request->query('from');	
		$this->set('from',$from);
		$this->loadmodel('accounts_group');
		$conditions2=array("accounts_id" => 1);
		$result_accounts_group=$this->accounts_group->find('all',array('conditions'=>$conditions2));
		$this->set('result_accounts_group',$result_accounts_group);
				
		$this->loadmodel('accounts_group');
		$conditions3=array("accounts_id" => 2);
		$result_accounts_group1=$this->accounts_group->find('all',array('conditions'=>$conditions3));
		$this->set('result_accounts_group1',$result_accounts_group1);	
	
		
	
}


function income_expenditure_excel(){
		$this->layout='blank';
		$this->ath();
		$s_society_id = (int)$this->Session->read('society_id');	
		$from=$this->request->query('from');
		$to=$this->request->query('to');
		$result_society=$this->society_name($s_society_id);
		$this->set('society_name',$result_society[0]['society']['society_name']);
		$this->set('from',$from);
		$this->set('to',$to);

		$this->loadmodel('accounts_group');
		$conditions4=array("accounts_id" => 3);
		$result_accounts_group2=$this->accounts_group->find('all',array('conditions'=>$conditions4));
		$this->set('result_accounts_group2',$result_accounts_group2);	
	
		$this->loadmodel('accounts_group');
		$conditions5=array("accounts_id" => 4);
		$result_accounts_group3=$this->accounts_group->find('all',array('conditions'=>$conditions5));
		$this->set('result_accounts_group3',$result_accounts_group3);	
	
	 
}
function balance_sheet_income_expenditure($from){
	$this->layout='blank';
	$this->ath();
	$s_society_id = (int)$this->Session->read('society_id');
		$total_balace=0; 
		$this->loadmodel('accounts_group');
		$conditions4=array("accounts_id" => 3);
		$result_accounts_group2=$this->accounts_group->find('all',array('conditions'=>$conditions4));
			foreach($result_accounts_group2 as $data){
				$auto_id=$data['accounts_group']['auto_id'];
				$result_ledger_account=$this->requestAction(array('controller' => 'Accounts', 'action' => 'ledger_account_fetch'),array('pass'=>array($auto_id)));
				$total_ledger_account=0;
				foreach($result_ledger_account as $data1){
					$ledger_account_id=$data1['ledger_account']['auto_id'];
					$balance_sheet_income=$this->requestAction(array('controller' => 'Accounts', 'action' => 'calculate_balance_sheet_credit_new'),array('pass'=>array($from,$ledger_account_id)));
					$total_balace+=$balance_sheet_income; 
					$total_ledger_account+=$balance_sheet_income;
					
				}
				
			}
	
		$this->loadmodel('accounts_group');
		$conditions5=array("accounts_id" => 4);
		$result_accounts_group3=$this->accounts_group->find('all',array('conditions'=>$conditions5));
		$total_balace_expenditure=0; 
			foreach($result_accounts_group3 as $data){
				$auto_id=$data['accounts_group']['auto_id'];
				$result_ledger_account=$this->requestAction(array('controller' => 'Accounts', 'action' => 'ledger_account_fetch'),array('pass'=>array($auto_id)));
				 $total_ledger_account_expen=0;
				 foreach($result_ledger_account as $data1){
					$ledger_account_id=$data1['ledger_account']['auto_id'];
					$balance_sheet_expenditure=$this->requestAction(array('controller' => 'Accounts', 'action' => 'calculate_balance_sheet_debit_new'),array('pass'=>array($from,$ledger_account_id)));
					$total_balace_expenditure+=$balance_sheet_expenditure; 
					$total_ledger_account_expen+=$balance_sheet_expenditure ;
				 }
				
				
			}
			
			if($total_balace>$total_balace_expenditure){
				return $total_surplus=$total_balace-$total_balace_expenditure;
				}else{ return $total_surplus=$total_balace_expenditure-$total_balace; }
			
}


function calculate_balance_sheet_credit($from,$ledger_account_id,$to){
	
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$to=date('Y-m-d',strtotime($to));
	$from=date('Y-m-d',strtotime($from));
	$this->loadmodel('ledger');
	//$conditions=array('society_id'=>$s_society_id,'ledger_account_id'=>$ledger_account_id,'transaction_date'=>array('$lt'=>strtotime($from)));
	
	$conditions=array('society_id'=>$s_society_id,'ledger_account_id'=>$ledger_account_id,'transaction_date'=>array('$gte'=>strtotime($from),'$lte'=>strtotime($to)));
	
	$ledger_result_b=$this->ledger->find('all',array('conditions'=>$conditions));
	$credit_b=0; $debit_b=0;
	foreach($ledger_result_b as $data_b){
		$debit_b+=$data_b["ledger"]["debit"];
		$credit_b+=$data_b["ledger"]["credit"];
	}
	return $difference_b=$credit_b-$debit_b;
}

function calculate_balance_sheet_credit_new($from,$ledger_account_id){
	
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	
	$from=date('Y-m-d',strtotime($from));
	$this->loadmodel('ledger');
	$conditions=array('society_id'=>$s_society_id,'ledger_account_id'=>$ledger_account_id,'transaction_date'=>array('$lt'=>strtotime($from)));
	
	
	$ledger_result_b=$this->ledger->find('all',array('conditions'=>$conditions));
	$credit_b=0; $debit_b=0;
	foreach($ledger_result_b as $data_b){
		$debit_b+=$data_b["ledger"]["debit"];
		$credit_b+=$data_b["ledger"]["credit"];
	}
	return $difference_b=$credit_b-$debit_b;
}

function calculate_balance_sheet_debit($from,$ledger_account_id,$to){
	
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');

	$from=date('Y-m-d',strtotime($from));
	$to=date('Y-m-d',strtotime($to));
	$this->loadmodel('ledger');
	
	$conditions=array('society_id'=>$s_society_id,'ledger_account_id'=>$ledger_account_id,'transaction_date'=>array('$gte'=>strtotime($from),'$lte'=>strtotime($to)));
	$ledger_result_b=$this->ledger->find('all',array('conditions'=>$conditions));
	$credit_b=0; $debit_b=0;
	foreach($ledger_result_b as $data_b){
		$debit_b+=$data_b["ledger"]["debit"];
		$credit_b+=$data_b["ledger"]["credit"];
	}
	return $difference_b=$debit_b-$credit_b;
}

function calculate_balance_sheet_debit_new($from,$ledger_account_id){
	
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');

	$from=date('Y-m-d',strtotime($from));
	
	$this->loadmodel('ledger');
	
	$conditions=array('society_id'=>$s_society_id,'ledger_account_id'=>$ledger_account_id,'transaction_date'=>array('$lt'=>strtotime($from)));
	
	$ledger_result_b=$this->ledger->find('all',array('conditions'=>$conditions));
	$credit_b=0; $debit_b=0;
	foreach($ledger_result_b as $data_b){
		$debit_b+=$data_b["ledger"]["debit"];
		$credit_b+=$data_b["ledger"]["credit"];
	}
	return $difference_b=$debit_b-$credit_b;
}




////////////////////// End Balance Shit //////////////////////////////////////

/////////////////////////////// Start Trial Balance (Accounts) //////////////////////////////////
function trial_balance()
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
////////////////////////// End Trial Balance (Accounts) /////////////////////////////////////////////////

//////////////////////////////// Start Trial Balance Ajax Show (Accounts) //////////////////////////////
function trial_balance_ajax_show($from=null,$to=null,$wise=null)
{
	
	$this->layout='blank';
	$this->ath();
	
	



	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$this->set('s_society_id',$s_society_id);
	$s_user_id=$this->Session->read('user_id');	
	
	
	if(empty($from) || empty($to) || empty($wise)){
		echo '<div align="center" style="font-weight: 600; color: RED;">Fill above fields.</div>'; exit;
	}elseif(strtotime($from)>strtotime($to)){
		echo '<div align="center" style="font-weight: 600; color: RED;">Date Range is not Valid.</div>'; exit;
	}
	$this->set('from',$from);
	$this->set('to',$to);
	$this->set('wise',$wise);
	
	
	$result_ledger_account=array();	
	$this->loadmodel('accounts_category');
	$result_accounts_category=$this->accounts_category->find('all');
	foreach($result_accounts_category as $data){
		$accounts_category_id=(int)$data["accounts_category"]["auto_id"];
		
		$this->loadmodel('accounts_group');
		$conditions2=array("accounts_id" => $accounts_category_id);
		$result_accounts_group=$this->accounts_group->find('all',array('conditions'=>$conditions2));
		foreach($result_accounts_group as $data2){
			$accounts_group_ids[]=(int)$data2["accounts_group"]["auto_id"];
		}
		
		foreach($accounts_group_ids as $accounts_group_id){
			$condition_array[]=array("group_id" => $accounts_group_id);
		}
		
		
		$this->loadmodel('ledger_account');
		$conditions =array( '$or' =>$condition_array);
		
		$order=array('ledger_account.ledger_name'=> 'ASC');
		$result_ledger_account_1=$this->ledger_account->find('all',array('conditions'=>$conditions,'order'=>$order));
		
		
		$result_ledger_account=array_merge($result_ledger_account,$result_ledger_account_1);
		
		unset($accounts_group_ids); unset($condition_array);
	} 
	
	$this->set('result_ledger_account',$result_ledger_account);	
}



function trial_balance_ajax_show_excel($from=null,$to=null,$wise=null)
{
	
	$this->layout='blank';
	$this->ath();
	
	$s_society_id = (int)$this->Session->read('society_id');
	$this->set('s_society_id',$s_society_id);
	$society_result=$this->requestAction(array('controller' => 'Hms', 'action' => 'society_name'),array('pass'=>array($s_society_id)));
	$society_name=$society_result[0]["society"]["society_name"];

	$filename=$society_name.'_Trial_Bal_'.$from.'_'.$to;
	$filename = str_replace(' ', '_', $filename);
	$filename = str_replace(' ', '-', $filename);

header ("Expires: 0");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls");
header ("Content-Description: Generated Report" );
	
	$s_role_id=$this->Session->read('role_id');
	
	$s_user_id=$this->Session->read('user_id');	
	
	if(empty($from) || empty($to) || empty($wise)){
		echo "Fill above fields."; exit;
	}
	$this->set('from',$from);
	$this->set('to',$to);
	$this->set('wise',$wise);
	
	
		
	
	$result_ledger_account=array();	
	$this->loadmodel('accounts_category');
	$result_accounts_category=$this->accounts_category->find('all');
	foreach($result_accounts_category as $data){
		$accounts_category_id=(int)$data["accounts_category"]["auto_id"];
		
		$this->loadmodel('accounts_group');
		$conditions2=array("accounts_id" => $accounts_category_id);
		$result_accounts_group=$this->accounts_group->find('all',array('conditions'=>$conditions2));
		foreach($result_accounts_group as $data2){
			$accounts_group_ids[]=(int)$data2["accounts_group"]["auto_id"];
		}
		
		foreach($accounts_group_ids as $accounts_group_id){
			$condition_array[]=array("group_id" => $accounts_group_id);
		}
		
		
		$this->loadmodel('ledger_account');
		$conditions =array( '$or' =>$condition_array);
		$order=array('ledger_account.ledger_name'=> 'ASC');
		$result_ledger_account_1=$this->ledger_account->find('all',array('conditions'=>$conditions,'order'=>$order));
		
		
		$result_ledger_account=array_merge($result_ledger_account,$result_ledger_account_1);
		
		unset($accounts_group_ids); unset($condition_array);
	} 

	$this->set('result_ledger_account',$result_ledger_account);	
}


function trial_balance_ajax_show_sub_ledger($from=null,$to=null,$wise=null)
{
	
	$this->layout='blank';
	$this->ath();
	
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$this->set('s_society_id',$s_society_id);
	$s_user_id=$this->Session->read('user_id');	
	
	
	if(empty($from) || empty($to) || empty($wise)){
		echo "Fill above fields."; exit;
	}
	$this->set('from',$from);
	$this->set('to',$to);
	$this->set('wise',$wise);
	
	
	
	if($wise==1){
		$conditions=array("ledger_id" => 15);
		$this->set('ledger_account_id',15);
	}
	if($wise==2){
		$conditions=array("ledger_id" =>34);
		$this->set('ledger_account_id',34);
	}
	if($wise==3){
		$conditions=array("ledger_id" => 33);
		$this->set('ledger_account_id',33);
	}
	if($wise==6)
	{
	$conditions=array("ledger_id" => 112);
	$this->set('ledger_account_id',112);	
	}

	
	
	
	$this->loadmodel('ledger_sub_account');
	$order=array('ledger_sub_account.name'=> 'ASC');
	$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions,'order' =>$order));
	$this->set('result_ledger_sub_account',$result_ledger_sub_account);	
}


function trial_balance_ajax_show_sub_ledger_excel($from=null,$to=null,$wise=null)
{
	
	$this->layout='blank';
	$this->ath();
	$s_society_id = (int)$this->Session->read('society_id');
	$society_result=$this->requestAction(array('controller' => 'Hms', 'action' => 'society_name'),array('pass'=>array($s_society_id)));
	$society_name=$society_result[0]["society"]["society_name"];
	
	$filename=$society_name.'_Trial_Bal_'.$from.'_'.$to;
	$filename = str_replace(' ', '_', $filename);
	$filename = str_replace(' ', '-', $filename);
header ("Expires: 0");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls");
header ("Content-Description: Generated Report" );
	
	$s_role_id=$this->Session->read('role_id');
	
	$this->set('s_society_id',$s_society_id);
	$s_user_id=$this->Session->read('user_id');	
	
	
	if(empty($from) || empty($to) || empty($wise)){
		echo '<div align="center" style="font-weight: 600; color: RED;">Fill above fields.</div>'; exit;
	}elseif(strtotime($from)>strtotime($to)){
		echo '<div align="center"  style="font-weight: 600; color: RED;">Date Range is not Valid.</div>'; exit;
	}
	$this->set('from',$from);
	$this->set('to',$to);
	$this->set('wise',$wise);
	
	
	
	if($wise==1){
		$conditions=array("ledger_id" => 15);
		$this->set('ledger_account_id',15);
	}
	if($wise==2){
		$conditions=array("ledger_id" =>34);
		$this->set('ledger_account_id',34);
	}
	if($wise==3){
		$conditions=array("ledger_id" => 33);
		$this->set('ledger_account_id',33);
	}
    if($wise==6)
	{
	$conditions=array("ledger_id" => 112);
	$this->set('ledger_account_id',112);	
	}
	$this->loadmodel('ledger_sub_account');
	$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
	$this->set('result_ledger_sub_account',$result_ledger_sub_account);	
}
/////////////////////////////// Start trial_balance_ajax_show_with_sub_ledger //////////////////////////////////
function trial_balance_ajax_show_with_sub_ledger($from=null,$to=null,$wise=null)
{
$this->layout='blank';
	$this->ath();
	
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');		

$this->set('s_society_id',$s_society_id);

if(empty($from) || empty($to) || empty($wise)){
		echo '<div align="center" style="font-weight: 600; color: RED;">Fill above fields.</div>'; exit;
	}elseif(strtotime($from)>strtotime($to)){
		echo '<div align="center" style="font-weight: 600; color: RED;">Date Range is not Valid.</div>'; exit;
	}
	$this->set('from',$from);
	$this->set('to',$to);
	$this->set('wise',$wise);
	
	
	$result_ledger_account=array();	
	$this->loadmodel('accounts_category');
	$result_accounts_category=$this->accounts_category->find('all');
	foreach($result_accounts_category as $data){
		$accounts_category_id=(int)$data["accounts_category"]["auto_id"];
		
		$this->loadmodel('accounts_group');
		$conditions2=array("accounts_id" => $accounts_category_id);
		$result_accounts_group=$this->accounts_group->find('all',array('conditions'=>$conditions2));
		foreach($result_accounts_group as $data2){
			$accounts_group_ids[]=(int)$data2["accounts_group"]["auto_id"];
		}
		
		foreach($accounts_group_ids as $accounts_group_id){
			$condition_array[]=array("group_id" => $accounts_group_id);
		}
		
		
		$this->loadmodel('ledger_account');
		$conditions =array( '$or' =>$condition_array);
		$order=array('ledger_account.ledger_name'=> 'ASC');
		$result_ledger_account_1=$this->ledger_account->find('all',array('conditions'=>$conditions,'order'=>$order));
		
		
		
		
		$result_ledger_account=array_merge($result_ledger_account,$result_ledger_account_1);

		unset($accounts_group_ids); unset($condition_array);
	
	
	} 
	$this->loadmodel('ledger_sub_account');
	$order=array('ledger_sub_account.name'=> 'ASC');
	$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('order' =>$order));
	$this->set('result_ledger_sub_account',$result_ledger_sub_account);	
	
	$this->set('result_ledger_account',$result_ledger_account);
	
}
/////////////////////////////// End trial_balance_ajax_show_with_sub_ledger //////////////////////////////////

function calculate_opening_balance_for_trail_balance($from=null,$to=null,$ledger_account_id=null){
	$this->ath();
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');	
	$from=date('Y-m-d',strtotime($from));
	
	$this->loadmodel('ledger');
	$conditions=array('society_id'=>$s_society_id,'ledger_account_id'=>$ledger_account_id,'transaction_date'=>array('$lt'=>strtotime($from)));
	$ledger_result_ob=$this->ledger->find('all',array('conditions'=>$conditions));
	
	$credit_ob=0; $debit_ob=0;
	foreach($ledger_result_ob as $data_ob){
		$debit_ob+=$data_ob["ledger"]["debit"];
		$credit_ob+=$data_ob["ledger"]["credit"];
	}
	$difference_ob=$debit_ob-$credit_ob;
	if($difference_ob>0){
		$type_ob="Dr";
	}
	if($difference_ob<0){
		$type_ob="Cr";
	}
	if($difference_ob==0){
		$type_ob=null;
	}
	
	$this->loadmodel('ledger');
	$conditions2=array('society_id'=>$s_society_id,'ledger_account_id'=>$ledger_account_id,'transaction_date'=>array('$gte'=>strtotime($from),'$lte'=>strtotime($to)));	
	$ledger_result_dc=$this->ledger->find('all',array('conditions'=>$conditions2));
	$credit_dc=0; $debit_dc=0;
	foreach($ledger_result_dc as $data_dc){
		$debit_dc+=$data_dc["ledger"]["debit"];
		$credit_dc+=$data_dc["ledger"]["credit"];
	}
	
	
	$difference_cb=$debit_dc-$credit_dc;
	
	
	
	$close_bal=$difference_ob+$difference_cb;
	
	if($close_bal>0){
		$type_cb="Dr";
	}
	if($close_bal<0){
		$type_cb="Cr";
	}
	if($close_bal==0){
		$type_cb=null;
	}
	
	$trail_balance=array(
		"opening_balance"=>array(abs($difference_ob),$type_ob),
		"debit"=>$debit_dc,
		"credit"=>$credit_dc,
		"closing_balance"=>array(abs($close_bal),$type_cb)
		);
	return $trail_balance; 
	
}



function calculate_opening_balance_for_trail_balance_for_sub_account($from=null,$to=null,$ledger_account_id=null,$ledger_sub_account_id=null){
	$this->ath();
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');	
	$from=date('Y-m-d',strtotime($from));
	
	$this->loadmodel('ledger');
	$conditions=array('society_id'=>$s_society_id,'ledger_account_id'=>$ledger_account_id,'ledger_sub_account_id'=>$ledger_sub_account_id,'transaction_date'=>array('$lt'=>strtotime($from)));
	$ledger_result_ob=$this->ledger->find('all',array('conditions'=>$conditions));
	
	$credit_ob=0; $debit_ob=0;
	foreach($ledger_result_ob as $data_ob){
		$debit_ob+=$data_ob["ledger"]["debit"];
		$credit_ob+=$data_ob["ledger"]["credit"];
	}
	$difference_ob=$debit_ob-$credit_ob;
	if($difference_ob>0){
		$type_ob="Dr";
	}
	if($difference_ob<0){
		$type_ob="Cr";
	}
	if($difference_ob==0){
		$type_ob=null;
	}
	
	$this->loadmodel('ledger');
	$conditions2=array('society_id'=>$s_society_id,'ledger_account_id'=>$ledger_account_id,'ledger_sub_account_id'=>$ledger_sub_account_id,'transaction_date'=>array('$gte'=>strtotime($from),'$lte'=>strtotime($to)));	
		
	
	$ledger_result_dc=$this->ledger->find('all',array('conditions'=>$conditions2));
	$credit_dc=0; $debit_dc=0;
	foreach($ledger_result_dc as $data_dc){
		$debit_dc+=$data_dc["ledger"]["debit"];
		$credit_dc+=$data_dc["ledger"]["credit"];
	}
	
	
	$difference_cb=$debit_dc-$credit_dc;
	
	
	
	$close_bal=$difference_ob+$difference_cb;
	
	if($close_bal>0){
		$type_cb="Dr";
	}
	if($close_bal<0){
		$type_cb="Cr";
	}
	if($close_bal==0){
		$type_cb=null;
	}
	
	$trail_balance=array(
		"opening_balance"=>array(abs($difference_ob),$type_ob),
		"debit"=>$debit_dc,
		"credit"=>$credit_dc,
		"closing_balance"=>array(abs($close_bal),$type_cb)
		);
		
	
	return $trail_balance; 
	
}


function fetch_sub_accounts_from_ledger_account_id($ledger_account_id){
	$s_society_id=$this->Session->read('society_id');
	$this->loadmodel('ledger_sub_account');
	$conditions=array("ledger_id" => (int)$ledger_account_id);
	return $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
}
////////////////////// End Trial Balance Ajax Show (Accounts) //////////////////////////////////////////

///////////////////// Start Regular Bill View (Accounts)//////////////////////////////////////////////////////////////
	function regular_bill_view($auto_id=null)
	{
		$this->layout='session';
		$s_role_id=$this->Session->read('role_id');
		$s_society_id = (int)$this->Session->read('society_id');
		$s_user_id=$this->Session->read('user_id');

			$auto_id = (int)$auto_id;

				$this->loadmodel('new_regular_bill');
				$conditions=array("auto_id"=>$auto_id,"society_id" => $s_society_id);
				$cursor=$this->new_regular_bill->find('all',array('conditions'=>$conditions));
				foreach($cursor as $collection)
				{
				$bill_html = $collection['new_regular_bill']['bill_html'];	
				}
		$this->set('bill_html',@$bill_html);
	}
////////////////////////////////// End Regular Bill View (Accounts)//////////////////////////////////////////

///////////////////////////////////// Start Master Ledger Sub Account View/////////////////////////////////////////////
	function master_ledger_sub_account_view()
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

				$this->loadmodel('ledger_account');
				$cursor1=$this->ledger_account->find('all');
				$this->set('cursor1',$cursor1);	

		$this->loadmodel('ledger_sub_account');
			$conditions=array("society_id" => $s_society_id);
		$cursor2=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
		$this->set('cursor2',$cursor2);	
}
///////////////////////////////////// End Master Ledger Sub Account View/////////////////////////////////////////////

//////////////////////// Start Master Ledger Accounts View ////////////////////////////////////////////////////////////
function master_ledger_accounts_view()
{
	if($this->RequestHandler->isAjax()){
	$this->layout='blank';
	}else{
	$this->layout='session';
	}

		$s_role_id=$this->Session->read('role_id');
		$s_society_id = (int)$this->Session->read('society_id');
		$s_user_id=$this->Session->read('user_id');	
		$this->set('s_user_id',$s_user_id);

	$this->ath();
	$this->check_user_privilages();

	$this->loadmodel('ledger_account');
	$conditions = array( '$or' => array(array('society_id' =>$s_society_id),array('society_id' =>0)));
	$cursor2=$this->ledger_account->find('all',array('conditions'=>$conditions));
	$this->set('cursor2',$cursor2);	

		$this->loadmodel('accounts_group');
		$conditions=array("delete_id" => 0);
		$cursor3=$this->accounts_group->find('all',array('conditions'=>$conditions));
		$this->set('cursor3',$cursor3);
}
/////////////////////// End Master Ledger Accounts View ////////////////////////////////////////////////

////////////////////////////// Start ledger Edit //////////////////////////////////////////////////////
function ledger_edit()
{
$this->layout='blank';

	$s_society_id = (int)$this->Session->read('society_id');
	$auto_id = (int)$this->request->query('t_id');
	$edit = (int)$this->request->query('edit');
	$this->set('edit',$edit);

if($edit == 0)
{
$this->set('ledger_id',$auto_id);

$this->loadmodel('ledger_account');
$conditions=array('$or' => array( 
array("society_id" => 0, "auto_id" => $auto_id),
array("society_id" => $s_society_id, "auto_id" => $auto_id),));
$cursor1=$this->ledger_account->find('all', array('conditions' => $conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('accounts_group');
$cursor2=$this->accounts_group->find('all');
$this->set('cursor2',$cursor2);
}
	if($edit == 1)
	{
		$ledger_name = $this->request->query('led');
		//$group_id = (int)$this->request->query('g');

		$this->loadmodel('ledger_account');
		$this->ledger_account->updateAll(array('ledger_name'=>$ledger_name),array('auto_id'=>$auto_id));
	}
}
////////////////////////////// End ledger Edit ///////////////////////////////////////////////////////////////////

/////////////////////////////// Start SubLedgerEdit ////////////////////////////////////////////////////
function subledger_edit()
{
	$this->layout='blank';
	$s_society_id = (int)$this->Session->read('society_id');
}
/////////////////////////////// End SubLedgerEdit ////////////////////////////////////////////////////

///////////////////////////////////// Start Opening Balance Import Ajax //////////////////////////////////////////
function opening_balance_import_ajax()
{
	$this->layout="blank";
	$this->ath();

	$s_society_id= (int)$this->Session->read('society_id');

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
foreach($test as $child)
{
if($i>0)
{

$child_ex=explode(',',$child[0]);
		
		$flat_id = "";
		$wing_id = "";
		@$group_name = $child_ex[0];
		@$account_name = $child_ex[1];
		@$wingg_nammm = $child_ex[2];
		@$flatt_nammm = $child_ex[3];
		@$debit_or_credit = $child_ex[4];
		@$priciple_amount = $child_ex[5];
		@$penalty_amount = $child_ex[6];
		@$wing_flat = "";
		@$group_id = "";


			$this->loadmodel('ledger_account'); 
			$conditions=array("ledger_name"=> new MongoRegex('/^' . $group_name . '$/i'));
			$group_detail=$this->ledger_account->find('all',array('conditions'=>$conditions));
			foreach($group_detail as $group_data)
			{
			$group_id = (int)$group_data['ledger_account']['auto_id'];
			}

			$this->loadmodel('accounts_group'); 
			$conditions=array("group_name"=> new MongoRegex('/^' .  $group_name . '$/i'));
			$group_detail2=$this->accounts_group->find('all',array('conditions'=>$conditions));
			foreach($group_detail2 as $group_data2)
			{
			$group_id = (int)$group_data2['accounts_group']['auto_id'];
			}



			$auto_id = "";
			$validdddnnn=5;
        
			$account_nameee = trim($account_name);
			$account_nameee = htmlentities($account_nameee);
		
		
		$this->loadmodel('ledger_account'); 
			$conditions=array("ledger_name"=> new MongoRegex('/^' .  trim($account_name) . '$/i'),"group_id"=>$group_id);
			$conditions =array( '$or' => array( 
			array("ledger_name"=> new MongoRegex('/^' .  trim($account_name) . '$/i'),"group_id"=>$group_id),
			array("ledger_name"=> $account_name ,"group_id"=>$group_id),
			array("ledger_name"=> $account_nameee,"group_id"=>$group_id)));
	$ledg_ddtaill=$this->ledger_account->find('all',array('conditions'=>$conditions));
		foreach($ledg_ddtaill as $ledgr_dattt)
		{
		$auto_id = (int)$ledgr_dattt['ledger_account']['auto_id'];
		$ledger_type = 2;
		$validdddnnn=555;
		}
		
	
	  
	

		if($group_id == 34)
		{
			
		$this->loadmodel('wing'); 
		$conditions=array("wing_name"=> new MongoRegex('/^' . trim($wingg_nammm) . '$/i'),"society_id"=>$s_society_id);
		$wing_dataaa=$this->wing->find('all',array('conditions'=>$conditions));
		foreach($wing_dataaa as $wing_detaill)
		{
		$wing_id_new = (int)$wing_detaill['wing']['wing_id'];
		//$wingg_idddd = (int)$wing_detaill['flat']['wing_id'];
		}	
			
			
			
			
		$this->loadmodel('flat'); 
		$conditions=array("flat_name"=> new MongoRegex('/^' .  trim($flatt_nammm) . '$/i'),"society_id"=>$s_society_id,"wing_id"=>$wing_id_new);
		$flat_data=$this->flat->find('all',array('conditions'=>$conditions));
		foreach($flat_data as $flltdddt)
		{
		$flt_idddd = (int)$flltdddt['flat']['flat_id'];
		$wingg_idddd = (int)$flltdddt['flat']['wing_id'];
		}	
		
       
	    		
		$this->loadmodel('ledger_sub_account'); 
		$conditions=array("flat_id"=>$flt_idddd, "ledger_id"=>$group_id);
		$subledger_data=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
		foreach($subledger_data as $sub_lddrr_dddttt)
		{
		$auto_id = (int)$sub_lddrr_dddttt['ledger_sub_account']['auto_id'];
		$ledger_type = 1;
		$validdddnnn=555;
		$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_with_brackets'),array('pass'=>array($wingg_idddd,$flt_idddd)));	
		}
		}
		else
		{
		$this->loadmodel('ledger_sub_account'); 
		$conditions=array("name"=> new MongoRegex('/^' .  $account_name . '$/i'),"ledger_id"=>$group_id);
		$subledger_data=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
		foreach($subledger_data as $sub_lddrr_dddttt)
		{
		$auto_id = (int)$sub_lddrr_dddttt['ledger_sub_account']['auto_id'];
		$ledger_type = 1;
		$validdddnnn=555;
		}
		}
		
		
$table[] = array(@$account_name,@$debit_or_credit,@$priciple_amount,@$auto_id,@$ledger_type,@$group_id,@$group_name,@$penalty_amount,@$flat_id,@$wing_flat,@$validdddnnn,@$flt_idddd);
	  }
      $i++;
	  }

$this->set('table',$table);

	$this->loadmodel('ledger_sub_account');
	$conditions=array("society_id" => $s_society_id);
	$cursor1 = $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
	$this->set('cursor1',$cursor1);

		$this->loadmodel('ledger_account');
		$cursor2 = $this->ledger_account->find('all');
		$this->set('cursor2',$cursor2);

	$this->loadmodel('accounts_group');
	$cursor3 = $this->accounts_group->find('all');
	$this->set('cursor3',$cursor3);
}
///////////////////////////////////// End Opening Balance Import Ajax //////////////////////////////////////////

//////////////////////////// Start Save Open Bal //////////////////////////////////////////////////////////
function save_open_bal()
{
	$this->layout='blank';
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id = (int)$this->Session->read('user_id');
	
		$q=$this->request->query('q'); 
		$myArray = json_decode($q, true);
	
		$c=1;
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

				if(empty($child[2]) && empty($child[3])){
				$report[]=array('tr'=>$c,'td'=>3, 'text' => 'Required');
			}
		}
		
		if(sizeof($report)>0){
		$output=json_encode(array('report_type'=>'error','report'=>$report));
		die($output);
		}

		$t=1;
		$total_debit = 0;
		$total_credit = 0;
			foreach($myArray as $child)
			{
			$t++;

			$date2 = $child[5];
			$date1 = date("Y-m-d", strtotime($date2));
			$date1 = new MongoDate(strtotime($date1));

				if(empty($child[5]))
				{
				$output=json_encode(array('report_type'=>'fina','text'=>'Please Select Date'));
				die($output);
				}

	$this->loadmodel('financial_year');
	$conditions=array("society_id" => $s_society_id,"status"=>1);
	$cursor = $this->financial_year->find('all',array('conditions'=>$conditions));
	$abc = 555;
	foreach($cursor as $collection)
	{
		$from = $collection['financial_year']['from'];
		$to = $collection['financial_year']['to'];
			if($date1 <= $to && $date1 >= $from)
			{
			$abc = 5;
			break;
			}
	}
		if($abc == 555)
		{
		$output=json_encode(array('report_type'=>'fina','text'=>'Date is not in Financial Year'));
		die($output);
		}

		$opening_bal = $child[3];
			if($opening_bal == "")
			{
			$opening_bal = $child[2];
			}

				if(is_numeric($opening_bal))
				{
				}
				else
				{
				$output=json_encode(array('report_type'=>'fina','text'=>'Amount (Opening Balance Should be Numeric in row '.$t));
				die($output);
				}
					$penalty_amt = (int)$child[6];
					$ch2 = (int)$child[2];
					$ch3 = (int)$child[3];
			if($ch2 != 0)
			{
			$total_debit = $total_debit + $child[2] + $penalty_amt;
			}
			if($ch3 != 0)
			{
			$total_credit = $total_credit + $child[3];
			}
		}

		if($total_credit != $total_debit)
		{
		$output=json_encode(array('report_type'=>'fina','text'=>'Total Debit must be Equal to Total Credit','deb'=>$total_debit,'cre'=>$total_credit));
		die($output);
		}

		foreach($myArray as $child){
			$excel_ledger_id = (int)$child[0];
			$excel_account_name = trim($child[1]);
			$debit = (int)$child[2];
			$credit =(int)$child[3];
			$insert = (int)$child[4];
			$transaction_date =date("Y-m-d",strtotime($child[5]));
			$intrest_arrear = (int)$child[6];
			$flll_id = (int)$child[7];

	if($insert == 2){
	if($excel_ledger_id==34){
	
		$this->loadmodel('ledger_sub_account'); 
		$conditions=array("ledger_id"=>34,"name"=> new MongoRegex('/^' .  $excel_account_name . '$/i'),"flat_id"=>$flll_id,"society_id"=>$s_society_id);
		$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
		$ledger_sub_account_id=$result_ledger_sub_account[0]["ledger_sub_account"]["auto_id"];

		$this->loadmodel('ledger');
		$ledger_auto_id=$this->autoincrement('ledger','auto_id');
		$this->ledger->saveAll(array("auto_id" => $ledger_auto_id,"ledger_account_id" => 34,"ledger_sub_account_id" => $ledger_sub_account_id,"debit"=>$debit,"credit"=>$credit,"table_name"=>"opening_balance","element_id"=>null,"society_id"=>$s_society_id,"transaction_date"=>strtotime($transaction_date)));

		
		if($intrest_arrear>0){
		$this->loadmodel('ledger');
		$ledger_auto_id=$this->autoincrement('ledger','auto_id');
		$this->ledger->saveAll(array("auto_id" => $ledger_auto_id,"ledger_account_id" => 34,"ledger_sub_account_id" => $ledger_sub_account_id,"debit"=>$intrest_arrear,"credit"=>null,"table_name"=>"opening_balance","element_id"=>null,"society_id"=>$s_society_id,"transaction_date"=>strtotime($transaction_date),"arrear_int_type"=>"YES"));
		}
		}
		else if($excel_ledger_id==33 || $excel_ledger_id==35 || $excel_ledger_id==15 || $excel_ledger_id==112){
		
		$this->loadmodel('ledger_sub_account'); 
		$conditions=array("ledger_id"=>$excel_ledger_id,"name"=> new MongoRegex('/^' .  $excel_account_name . '$/i'),"society_id"=>$s_society_id);
		$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
		$ledger_sub_account_id= (int)$result_ledger_sub_account[0]["ledger_sub_account"]["auto_id"];
			
		$this->loadmodel('ledger');
		$ledger_auto_id=$this->autoincrement('ledger','auto_id');
		$this->ledger->saveAll(array("auto_id" => $ledger_auto_id,"ledger_account_id" =>$excel_ledger_id,
		"ledger_sub_account_id" => $ledger_sub_account_id,"debit"=>$debit,"credit"=>$credit,
		"table_name"=>"opening_balance","element_id"=>null,"society_id"=>$s_society_id,
		"transaction_date"=>strtotime($transaction_date)));	
		}
		else
		{
		$this->loadmodel('ledger_account'); 
		$conditions = array( '$or' => array(array("group_id"=>$excel_ledger_id,"ledger_name"=> new MongoRegex('/^' .  $excel_account_name . '$/i'),'society_id' =>$s_society_id),
		array("group_id"=>$excel_ledger_id,"ledger_name"=> new MongoRegex('/^' .  $excel_account_name . '$/i'),'society_id' =>0)));
		$result_ledger_account=$this->ledger_account->find('all',array('conditions'=>$conditions));
		$ledger_account_id=$result_ledger_account[0]["ledger_account"]["auto_id"];

		$this->loadmodel('ledger');
		$ledger_auto_id=$this->autoincrement('ledger','auto_id');
		$this->ledger->saveAll(array("auto_id" => $ledger_auto_id,"ledger_account_id" => $ledger_account_id,"ledger_sub_account_id" => null,"debit"=>$debit,"credit"=>$credit,"table_name"=>"opening_balance","element_id"=>null,"society_id"=>$s_society_id,"transaction_date"=>strtotime($transaction_date)));

		}
		}
		} 
		
$this->Session->write('opnn_bll',1);		
		
			$output=json_encode(array('report_type'=>'done','text'=>'Total Debit must be Equal to Total Credit'));
			die($output);
	}
//////////////////////////// End Save Open Bal //////////////////////////////////////////////////////////

///////////////////////////////// Start pay Bill ////////////////////////////////////////////////////////
function pay_bill()
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

				$receipt_no = (int)$this->request->query('b');
				$this->set('receipt_no',$receipt_no);

	if(isset($this->request->data['sub']))
	{
		$transaction_date = $this->request->data['date'];
		$bank_name = $this->request->data['bank_name'];
		$mobile = $this->request->data['mobile'];
		$bill_receipt = (int)$this->request->data['bill_no'];
		$branch = $this->request->data['branch'];
		$account_number = $this->request->data['acno'];
		$pay_amt = $this->request->data['amt'];
		$paying_mode = (int)$this->request->data['mode'];
			
			if($paying_mode == 1)
			{
			$cheque_number = $this->request->data['chq_no'];
			$mode="Cheque";
			}
			else
			{
			$cheque_number = "";
			$mode="Cash";
			}
			
		$transaction_date = date('Y-m-d',strtotime($transaction_date));
		$this->loadmodel('regular_bill');
		$this->regular_bill->updateAll(array("payment_date" => $transaction_date,"bank_name"=>$bank_name,"mobile"=>$mobile,"branch"=>$branch,"account_number"=>$account_number,"pay_amount"=>$pay_amt,"pay_mode"=>$mode,"cheque_no"=>$cheque_number),array("society_id" => $s_society_id,"receipt_id"=>$bill_receipt));
		
		?>
		<div class="modal-backdrop fade in"></div>
		<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
		<center>
		<h3 id="myModalLabel3" style="color:#999;"><b>Pay Bill Detail</b></h3>
		</center>
		</div>
		<div class="modal-body">
		<center>
		<h5><b>Record Inserted Successfully</b></h5>
		</center>
		</div>
		<div class="modal-footer">
		<a href="my_flat_bill" class="btn blue">OK</a>
		</div>
		</div>
		<?php
	}
}
///////////////////////////////// End pay Bill //////////////////////////////////////////////////////////////////

////////////////////// Start Opening Balance  Excel Export ///////////////////////////////////////////////////
function open_excel()
{
		$this->layout="";
		$filename="Opening_Balance_Import";
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


$excel = "Group Name,A/c name,wing,unit,Amount Type(Debit or Credit),Amount(Opening Balance),Penalty \n";

		$this->loadmodel('ledger_accounts');
		$conditions = array('$or'=>array(array('society_id' =>$s_society_id),array('society_id' =>0)));
		$cursor = $this->ledger_accounts->find('all',array('conditions'=>$conditions));
		foreach($cursor as $collection)
			{
			$group_id = (int)$collection['ledger_accounts']['group_id'];
			$ledger_name = $collection['ledger_accounts']['ledger_name'];
		    $ledger_idddd = (int)$collection['ledger_accounts']['auto_id'];
				if($ledger_idddd != 34 && $ledger_idddd != 33 && $ledger_idddd != 35 && $ledger_idddd != 15)
				{	
				$result_ag = $this->requestAction(array('controller' => 'hms', 'action' => 'accounts_group'),array('pass'=>array($group_id)));
				foreach ($result_ag as $collection) 
				{
				$accounts_id = (int)$collection['accounts_group']['accounts_id'];	
				$group_name = $collection['accounts_group']['group_name'];	
				}
				$excel.= "$group_name,$ledger_name\n";
				}
			}

			$this->loadmodel('ledger_sub_account');
			$conditions=array("society_id" => $s_society_id);
			$result1 = $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
			foreach($result1 as $datadd)
			{
			$user_id = "";
			$flat_id = "";
				$ledger_id = (int)$datadd['ledger_sub_account']['ledger_id'];
				$name = $datadd['ledger_sub_account']['name'];
				$user_id = (int)@$datadd['ledger_sub_account']['user_id'];
				$flat_id = (int)@$datadd['ledger_sub_account']['flat_id'];
	
			if($ledger_id == 34)
			{
				$flat_dtttl = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_fetch'),array('pass'=>array($flat_id)));
				foreach($flat_dtttl as $flltdetll)
				{
				$wing_id = (int)$flltdetll['flat']['wing_id'];
				$flat_name = $flltdetll['flat']['flat_name'];
				}

			$wing_data = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_fetch'),array('pass'=>array($wing_id)));
			foreach($wing_data as $wnngdddtt){
			$wing_name = $wnngdddtt['wing']['wing_name'];
			}
			}	

		$result_la = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account'),array('pass'=>array($ledger_id)));
		foreach ($result_la as $collection) 
		{
		$ledger_name = $collection['ledger_account']['ledger_name'];	
		}


		if($ledger_id==34){
		$excel.= "$ledger_name,$name,$wing_name,$flat_name\n";
		}
		else {
		$excel.= "$ledger_name,$name\n";
		}
			}
echo $excel;
}
////////////////////// End Opening Balance  Excel Export /////////////////////////////////////
/////////////////////////// Start fixed_deposit_reminder /////////////////////////////////////
function reminder_settings()
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
 $reminder_for = $this->request->data['ffrr'];
 $days = $this->request->data['days'];
//$onnnofff = (int)@$this->request->data['remindrrr'];

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor111=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor111 as $data)
{
$arrr = @$data['society']['reminder'];
}
if(empty($arrr))
{
$arrr = array();
}


if($reminder_for == 1)
{
             $nnn = 55;
			 for($h=0; $h<sizeof($arrr); $h++)
				{
						$sub_arrr = $arrr[$h];
						$idddd = (int)$sub_arrr[0];
						if($idddd == 1)
						{
						$arrr[$h] = array(1,$days);
						$nnn = 555;
						}
				}
			if($nnn == 55)
			{
			$arrr[] = array(1,$days);
			}
$this->loadmodel('society');
$this->society->updateAll(array('reminder'=>$arrr),array('society_id'=>$s_society_id));
}
if($reminder_for == 2)
{
		$nnn = 55;
		for($h=0; $h<sizeof($arrr); $h++)
		{
				$sub_arrr = $arrr[$h];
				$idddd = (int)$sub_arrr[0];
				if($idddd == 2)
				{
				$arrr[$h] = array(2,$days);
				$nnn = 555;
				}
		}
			if($nnn == 55)
			{
			$arrr[] = array(2,$days);
			}
$this->loadmodel('society');
$this->society->updateAll(array('reminder'=>$arrr),array('society_id'=>$s_society_id));
}

if($reminder_for == 3){
	$nnn = 55;
		for($h=0; $h<sizeof($arrr); $h++)
		{
				$sub_arrr = $arrr[$h];
				$idddd = (int)$sub_arrr[0];
				if($idddd == 3)
				{
				$arrr[$h] = array(3,$days);
				$nnn = 555;
				}
		}
			if($nnn == 55)
			{
			$arrr[] = array(3,$days);
			}
			
$this->loadmodel('society');
$this->society->updateAll(array('reminder'=>$arrr),array('society_id'=>$s_society_id));
}

?>
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
<p>The Record Updated Successfully</p>

</div>
<div class="modal-footer">
<a href="reminder_settings" class="btn red">OK</a>
</div>
</div>
<?php
$this->Session->write('remindrrr', 1);
}

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor2=$this->society->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);

}
/////////////////////////// End fixed_deposit_reminder //////////////////////////////////////
///////////////////////////////// Start auto_reminder ////////////////////////////////////// 
function auto_reminder()
{
		if($this->RequestHandler->isAjax()){
		$this->layout='blank';
		}else{
		$this->layout='session';
		}
		
	$this->ath();
	$s_society_id=(int)$this->Session->read('society_id');
	$s_user_id= (int)$this->Session->read('user_id');

	$this->loadmodel('user');
	$conditions=array("society_id" => $s_society_id,"user_id"=>$s_user_id);
	$cursrrr2=$this->user->find('all',array('conditions'=>$conditions));
	foreach($cursrrr2 as $ddddd2)
	{
	$mobile = $ddddd2['user']['mobile'];
	}

$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursrrr=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursrrr as $ddddd)
{
$society_name = $ddddd['society']['society_name'];
$arrrr = $ddddd['society']['reminder'];
$reminder_status = (int)$ddddd['society']['reminder_status'];
$society_user_id = (int)$ddddd['society']['user_id'];
}

for($a=0; $a<sizeof($arrrr); $a++)
{
$sub_arr = $arrrr[$a];
$iddd = (int)$sub_arr[0];
     if($iddd == 1)
     {
     $income_tracker_days = (int)$sub_arr[1];  
     }
     else if($iddd == 2)
     {
     $fixed_dep_days = (int)$sub_arr[1];  
     }
     else if($iddd == 3)
     {
     $help_desk_days = (int)$sub_arr[1];  
     }
}

if($reminder_status == 1)
{
	$this->loadmodel('fix_deposit');
	$conditions=array("society_id" => $s_society_id,'matured_status'=>1);
	$fixdeposittt=$this->fix_deposit->find('all',array('conditions'=>$conditions));
	foreach($fixdeposittt as $dataaa)
	{
	$bank_name = $dataaa['fix_deposit']['bank_name'];
	$reference = $dataaa['fix_deposit']['account_reference'];

	$receipt_number = $dataaa['fix_deposit']['receipt_id'];
	$matured_date = $dataaa['fix_deposit']['maturity_date'];
	$mat_datt = date('Y-m-d',$matured_date);
	$current_date = date('Y-m-d');

	$datetime1 = new DateTime($current_date);
	$datetime2 = new DateTime($mat_datt);
	$interval = $datetime1->diff($datetime2);
	$days =  $interval->format('%R%a days');

$days = (int)$days;
if($fixed_dep_days == $days)
{
$r_sms=$this->hms_sms_ip();
$working_key=$r_sms->working_key;
$sms_sender=$r_sms->sms_sender; 
$sms_allow=(int)$r_sms->sms_allow;

$sms="Reminder: Fixed Deposit with ".$bank_name." ".$reference." will mature on ".$mat_datt." ".$society_name;
$sms1=str_replace(' ', '+', $sms);

$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms1.''); 

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

//$subject="[".$society_name."]- Receipt of Rs ".$amount." on ".date('d-M-Y',$d_date)." against Unit ".$wing_flat."";
//$subject = "[".$society_name."]- Receipt,"date('d-M-Y',$d_date).""; 

//$this->send_email($to_email,'accounts@housingmatters.in','HousingMatters',$subject,$html_receipt,'donotreply@housingmatters.in');
}

}

}

//EMAIL message for income tracker reminder :- "Dear (User_Name , your maintenance bill of Rs for the period (date range) is due on (date). Please pay by due date. Kindly ignore this message if you have already made the payment.   society_name"
//Fixed Deposit SMS reminder to SM:-"Reminder: Fixed Deposit with Bank Name (reference Number) will mature on 31-10-2015. society_name

	$this->loadmodel('new_regular_bill');
	$conditions=array("society_id" => $s_society_id,"approval_status" => 1,'new_regular_bill.edit_status'=>array('$ne'=>"YES"));
	$order=array('new_regular_bill.one_time_id'=> 'DESC');
	$result_new_regular_bill = $this->new_regular_bill->find('all',array('conditions'=>$conditions,'order'=>$order));
	foreach($result_new_regular_bill as $regular_bill)
	{
	$due_date = $regular_bill['new_regular_bill']['due_date'];
    $bill_start_date = $regular_bill['new_regular_bill']['bill_start_date'];
	$bill_end_date = $regular_bill['new_regular_bill']['bill_end_date'];
	$flat_id = (int)$regular_bill['new_regular_bill']['flat_id']; 
	
	
	$ledgerr_sub_accc = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_subLedger_detail_via_flat_id'),array('pass'=>array($flat_id)));
	foreach ($ledgerr_sub_accc as $leddsubb_dataaaa) 
	{
	$user_name = (int)$leddsubb_dataaaa['ledger_sub_account']['name'];
	$user_id = (int)$leddsubb_dataaaa['ledger_sub_account']['user_id'];
	}	
	
	$user_detaillll = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($user_id)));
	foreach($user_detaillll as $usrrr_dataaa)
	{
	$user_email_id = $usrrr_dataaa['user']['email'];
	}
	
	$bill_stt_dat = date('d-M-Y',($bill_start_date));
	$bill_end_dat = date('d-M-Y',($bill_end_date));
	$due_date = date('d-M-Y',$due_date);
	$current_date = date('Y-m-d');

		$datetime1 = new DateTime($current_date);
		$datetime2 = new DateTime($due_date);
		$interval = $datetime1->diff($datetime2);
		$days =  $interval->format('%R%a days');
		$days = (int)$days;
	
		if($income_tracker_days == $days)
		{
			$r_sms=$this->hms_sms_ip();
			$working_key=$r_sms->working_key;
			$sms_sender=$r_sms->sms_sender; 
			$sms_allow=(int)$r_sms->sms_allow;

			$sms="Dear ".$user_name." , your maintenance bill of Rs for the period ".$bill_stt_dat."-".$bill_end_dat." is due on ".$due_date." Please pay by due date. Kindly ignore this message if you have already made the payment. ".$society_name;
			//$sms1=str_replace(' ', '+', $sms);

			$subject="Reminder for Payment";
			//$subject = "[".$society_name."]- Receipt,"date('d-M-Y',$d_date).""; 

			$this->send_email($user_email_id,'accounts@housingmatters.in','HousingMatters',$subject,$sms,'donotreply@housingmatters.in');	

		}
    	}
		
  ///////  help desk reminder functionality /////////
		
		$ip=$this->hms_email_ip();
		$result_user=$this->profile_picture($society_user_id);
		$email=$result_user[0]['user']['email'];
		$user_name=$result_user[0]['user']['user_name'];
		$this->loadmodel('service_provider');
		$conditions=array("society_id" => $s_society_id);
		$result_service_provider=$this->service_provider->find('all',array('conditions'=>$conditions));
		$subject="Reminder for Annual Contracts";
		foreach($result_service_provider as $data){
			
			  $sp_name=$data['service_provider']['sp_name'];
			  $sp_cont_end=@$data['service_provider']['sp_cont_end'];
				if(!empty($sp_cont_end)){
					
					$r_date= date('d-m-Y', strtotime($sp_cont_end. ' - '.$help_desk_days.' days')); 
					$current_date = date('d-m-Y');
					$r_date="11-12-2015";
					if(strtotime($current_date)<=strtotime($r_date)){
										
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
														Please note that contract of service provider '.$sp_name.' will get over on '.$sp_cont_end.'.
													
													</td>
																				
												</tr>
											
									</table>
									
								</td>
							</tr>

						</tbody>
					</table>';
					
				$subject="Reminder for Renewal of Annual Contract: ".$sp_name."";
				$this->send_email($email,'accounts@housingmatters.in','HousingMatters',$subject,$message_web,'donotreply@housingmatters.in');	
				$subject="";		
			}
					
		}

	}	
	
////// end code help desk reminder ///////////
}
}
///////////////////////////////// End auto_reminder ////////////////////////////////////////////// 
//////////////////////////////////// Start  tds_payment_report //////////////////////////////////
function tds_payment_report()
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
	
	

	
	
	
	
	
	
	
	
	
	
}
//////////////////////////////////// Start  tds_payment_report /////////////////////////////////////
////////////////////////////////// Start tds_payment_report_view_ajax /////////////////////////////// 
function tds_payment_report_view_ajax()
{
        $this->layout='blank';

		$this->ath();
		$s_role_id=$this->Session->read('role_id');
		$s_society_id = (int)$this->Session->read('society_id');
		$s_user_id=$this->Session->read('user_id');	
	

$this->loadmodel('society');
$conditions=array('society_id'=>$s_society_id);
$cursor = $this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $dataa)
{
$society_name = $dataa['society']['society_name'];	
}
$this->set('society_name',$society_name);


	
$from = $this->request->query('date1');
$to = $this->request->query('date2');	

$this->set('from',$from);
$this->set('to',$to);

$fromm = date('Y-m-d',strtotime($from));
$tomm = date('Y-m-d',strtotime($to));

$from_strtotime = strtotime($fromm);
$to_strtotime = strtotime($tomm);

	
$this->loadmodel('new_cash_bank');
$order=array('new_cash_bank.receipt_date'=> 'ASC');
$conditions=array('society_id'=>$s_society_id,"receipt_source"=>2,
'new_cash_bank.transaction_date'=>array('$gte'=>$from_strtotime,'$lte'=>$to_strtotime));
$cursor1=$this->new_cash_bank->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('cursor1',$cursor1);	
	
	
$this->loadmodel('reference');
$conditions=array("auto_id"=>3);
$cursor = $this->reference->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$tds_arr = $collection['reference']['reference'];
}
$this->set("tds_arr",$tds_arr);		

}
////////////////////////////////// Start tds_payment_report_view_ajax /////////////////////////////// 
//////////////////////////////// Start tds_report_excel /////////////////////////////////////////////
function tds_report_excel()
{
$this->layout=null;

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
$this->set('from',$from);
$this->set('to',$to);
$fdddd = date('d-M-Y',strtotime($from));
$tdddd = date('d-M-Y',strtotime($to));
$this->set('fdddd',$fdddd);
$this->set('tdddd',$tdddd);
$socc_namm = str_replace(' ', '_', $society_name);
$this->set('socc_namm',$socc_namm);
	
$fromm = date('Y-m-d',strtotime($from));
$tomm = date('Y-m-d',strtotime($to));

$from_strtotime = strtotime($fromm);
$to_strtotime = strtotime($tomm);
	
$this->loadmodel('new_cash_bank');
$order=array('new_cash_bank.receipt_date'=> 'ASC');
$conditions=array('society_id'=>$s_society_id,"receipt_source"=>2,
'new_cash_bank.transaction_date'=>array('$gte'=>$from_strtotime,'$lte'=>$to_strtotime));
$cursor1=$this->new_cash_bank->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('cursor1',$cursor1);	
	
	
$this->loadmodel('reference');
$conditions=array("auto_id"=>3);
$cursor = $this->reference->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$tds_arr = $collection['reference']['reference'];
}
$this->set("tds_arr",$tds_arr);	
}
//////////////////////////////// End tds_report_excel /////////////////////////////////////////////
////////////////////////////// Start Cash Book Report /////////////////////////////////////////////
function cash_book_report()
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


	
}
////////////////////////////// End Cash Book Report /////////////////////////////////////////////
////////////////////////////// Start cash_book_report_show_ajax ///////////////////////////////////// 
function cash_book_report_show_ajax()
{
  		
$this->layout='blank';
$this->ath();
		
      $bank_id = (int)$this->request->query('bank');
      $from = $this->request->query('date1');
      $to = $this->request->query('date2');

	  $this->set('from',$from);
	  $this->set('to',$to);
	  
      $from2 = date('Y-m-d',strtotime($from)); 
      $to2 = date('Y-m-d',strtotime($to)); 

	  $from_strtotime = strtotime($from2);
	  $to_strtotime = strtotime($to2);
	  
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	
	
	
$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
}	
$this->set('society_name',$society_name);	
	
	
$this->loadmodel('new_cash_bank');
$order=array('new_cash_bank.transaction_date'=> 'ASC');
$conditions =array('$or' => array(array('society_id'=>$s_society_id,"receipt_source"=>3,
'new_cash_bank.transaction_date'=>array('$gte'=>$from_strtotime,'$lte'=>$to_strtotime)),
array('society_id'=>$s_society_id,"receipt_source"=>4,
'new_cash_bank.transaction_date'=>array('$gte'=>$from_strtotime,'$lte'=>$to_strtotime))));
$cursor2=$this->new_cash_bank->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('cursor2',$cursor2);	
}
////////////////////////////// End cash_book_report_show_ajax /////////////////////////////////////
///////////////////////////// Start bank_book_report /////////////////////////////////////////////////
function bank_book_report()
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
	
	$this->loadmodel('ledger_sub_account');
	$conditions=array("society_id" => $s_society_id,"ledger_id"=>33);
	$cursor1=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
	$this->set('cursor1',$cursor1);		
	
}
///////////////////////////// End bank_book_report /////////////////////////////////////////////////
//////////////////////////// Start bank_book_report_view_ajax ////////////////////////////////////////
function bank_book_report_view_ajax()
{
    $this->layout='blank';
	$this->ath();

	
$bank_id = (int)$this->request->query('bank');
$this->set('bank_id',$bank_id);	

$from = $this->request->query('date1');
$to = $this->request->query('date2');

$this->set('from',$from);
$this->set('to',$to);


$from2 = date('Y-m-d',strtotime($from)); 
$to2 = date('Y-m-d',strtotime($to)); 

$from_strtotime = strtotime($from2);
$to_strtotime = strtotime($to2);
	  
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');	
	
$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
}	
$this->set('society_name',$society_name);	
	
	
$this->loadmodel('ledger_sub_account');
$conditions=array("auto_id"=>$bank_id,"society_id"=>$s_society_id);
$cursor1=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);
	
	
	
$this->loadmodel('new_cash_bank');
//$order=array('$or' => array(array('new_cash_bank.transaction_date'=> 'ASC'),
//array('new_cash_bank.transaction_date'=> 'ASC')));
$conditions=array('$or' => array(array('society_id'=>$s_society_id,"receipt_source"=>1,"deposited_bank_id"=>$bank_id,
'new_cash_bank.receipt_date'=>array('$gte'=>$from_strtotime,'$lte'=>$to_strtotime)),
array('society_id'=>$s_society_id,"receipt_source"=>2,"account_head"=>$bank_id,
'new_cash_bank.transaction_date'=>array('$gte'=>$from_strtotime,'$lte'=>$to_strtotime))));
$cursor2=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);
}
//////////////////////////// End bank_book_report_view_ajax ////////////////////////////////////////
//////////////////////////// Start bank_book_report_view_ajax ////////////////////////////////////////
function bank_book_report_excel()
{
$this->layout="";
$this->ath();	
	
$s_society_id = (int)$this->Session->read('society_id');
$s_role_id= (int)$this->Session->read('role_id');
$s_user_id= (int)$this->Session->read('user_id');

$bank_id = (int)$this->request->query('bank');
$from = $this->request->query('f');	
$to = $this->request->query('t');	
		
$from2 = date('Y-m-d',strtotime($from)); 
$to2 = date('Y-m-d',strtotime($to)); 

$from_strtotime = strtotime($from2);
$to_strtotime = strtotime($to2);		
		
$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
}
$socc_namm = str_replace(' ', '_', $society_name);	
$this->set('socc_namm',$socc_namm);

	
$this->set('society_name',$society_name);	
$this->set('from',$from);
$this->set('to',$to);	

$this->loadmodel('ledger_sub_account');
$conditions=array("auto_id"=>$bank_id,"society_id"=>$s_society_id);
$cursor1=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('cursor1',$cursor1);

$this->loadmodel('new_cash_bank');
//$order=array('$or' => array(array('new_cash_bank.transaction_date'=> 'ASC'),
//array('new_cash_bank.transaction_date'=> 'ASC')));
$conditions=array('$or' => array(array('society_id'=>$s_society_id,"receipt_source"=>1,"deposited_bank_id"=>$bank_id,
'new_cash_bank.receipt_date'=>array('$gte'=>$from_strtotime,'$lte'=>$to_strtotime)),
array('society_id'=>$s_society_id,"receipt_source"=>2,"account_head"=>$bank_id,
'new_cash_bank.transaction_date'=>array('$gte'=>$from_strtotime,'$lte'=>$to_strtotime))));
$cursor2=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
$this->set('cursor2',$cursor2);	
}
//////////////////////////// End bank_book_report_view_ajax ////////////////////////////////////////
///////////////////////////// Start cash_book_report_excel //////////////////////////////////////////
function cash_book_report_excel()
{
$this->layout="";
$this->ath();	
	
$s_society_id = (int)$this->Session->read('society_id');
$s_role_id= (int)$this->Session->read('role_id');
$s_user_id= (int)$this->Session->read('user_id');




$from = $this->request->query('f');	
$to = $this->request->query('t');	
		
$from2 = date('Y-m-d',strtotime($from)); 
$to2 = date('Y-m-d',strtotime($to)); 

$from_strtotime = strtotime($from2);
$to_strtotime = strtotime($to2);		
		
$this->loadmodel('society');
$conditions=array("society_id" => $s_society_id);
$cursor=$this->society->find('all',array('conditions'=>$conditions));
foreach($cursor as $collection)
{
$society_name = $collection['society']['society_name'];
}
$socc_namm = str_replace(' ', '_', $society_name);	
$this->set('socc_namm',$socc_namm);	
	
$this->set('society_name',$society_name);	
$this->set('from',$from);
$this->set('to',$to);


$this->loadmodel('new_cash_bank');
$order=array('new_cash_bank.transaction_date'=> 'ASC');
$conditions =array('$or' => array(array('society_id'=>$s_society_id,"receipt_source"=>3,
'new_cash_bank.transaction_date'=>array('$gte'=>$from_strtotime,'$lte'=>$to_strtotime)),
array('society_id'=>$s_society_id,"receipt_source"=>4,
'new_cash_bank.transaction_date'=>array('$gte'=>$from_strtotime,'$lte'=>$to_strtotime))));
$cursor2=$this->new_cash_bank->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('cursor2',$cursor2);	

}
///////////////////////////// End cash_book_report_excel //////////////////////////////////////////
//////////////////////////// Start trial_balance_ajax_show_excel_with_sub_ledger /////////////////
function trial_balance_ajax_show_excel_with_sub_ledger($from=null,$to=null,$wise=null)
{
$this->layout='blank';
	$this->ath();
	
	$s_role_id=$this->Session->read('role_id');
	$s_society_id = (int)$this->Session->read('society_id');
	$s_user_id=$this->Session->read('user_id');		

	
$s_society_id = (int)$this->Session->read('society_id');
	$this->set('s_society_id',$s_society_id);
	$society_result=$this->requestAction(array('controller' => 'Hms', 'action' => 'society_name'),array('pass'=>array($s_society_id)));
	$society_name=$society_result[0]["society"]["society_name"];

	$filename=$society_name.'_Trial_Bal_'.$from.'_'.$to;
	$filename = str_replace(' ', '_', $filename);
	$filename = str_replace(' ', '-', $filename);

header ("Expires: 0");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls");
header ("Content-Description: Generated Report" );	
	
	
$this->set('s_society_id',$s_society_id);

if(empty($from) || empty($to) || empty($wise)){
		echo '<div align="center" style="font-weight: 600; color: RED;">Fill above fields.</div>'; exit;
	}elseif(strtotime($from)>strtotime($to)){
		echo '<div align="center" style="font-weight: 600; color: RED;">Date Range is not Valid.</div>'; exit;
	}
	$this->set('from',$from);
	$this->set('to',$to);
	$this->set('wise',$wise);
	
	
	$result_ledger_account=array();	
	$this->loadmodel('accounts_category');
	$result_accounts_category=$this->accounts_category->find('all');
	foreach($result_accounts_category as $data){
		$accounts_category_id=(int)$data["accounts_category"]["auto_id"];
		
		$this->loadmodel('accounts_group');
		$conditions2=array("accounts_id" => $accounts_category_id);
		$result_accounts_group=$this->accounts_group->find('all',array('conditions'=>$conditions2));
		foreach($result_accounts_group as $data2){
			$accounts_group_ids[]=(int)$data2["accounts_group"]["auto_id"];
		}
		
		foreach($accounts_group_ids as $accounts_group_id){
			$condition_array[]=array("group_id" => $accounts_group_id);
		}
		
		
		$this->loadmodel('ledger_account');
		$conditions =array( '$or' =>$condition_array);
		$order=array('ledger_account.ledger_name'=> 'ASC');
		$result_ledger_account_1=$this->ledger_account->find('all',array('conditions'=>$conditions,'order'=>$order));
		
		
		
		
		$result_ledger_account=array_merge($result_ledger_account,$result_ledger_account_1);

		unset($accounts_group_ids); unset($condition_array);
	
	
	} 
	$this->loadmodel('ledger_sub_account');
	$order=array('ledger_sub_account.name'=> 'ASC');
	$result_ledger_sub_account=$this->ledger_sub_account->find('all',array('order' =>$order));
	$this->set('result_ledger_sub_account',$result_ledger_sub_account);	
	
	$this->set('result_ledger_account',$result_ledger_account);
	
}	
/////////////////End trial_balance_ajax_show_excel_with_sub_ledger/////////////////////////////////
///////////////// Start my_flat_receipt_update //////////////////////////////////////////////
function my_flat_receipt_update()
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
$s_user_id=(int)$this->Session->read('user_id');	

$this->set('s_user_id',$s_user_id);


$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 34,"society_id"=>$s_society_id,"deactive"=>0,'user_id'=>$s_user_id);
$ledger_sub_account_data = $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('ledger_sub_account_data',$ledger_sub_account_data);	


$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 33,"society_id"=>$s_society_id);
$bank_detail=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('bank_detail',$bank_detail);
	
}

//////////////////////End my_flat_receipt_update /////////////////////////////////////////////////
/////////////////////// Start my_flat_receipt_update_ajax ///////////////////////////////////
function my_flat_receipt_update_ajax($from=null,$to=null)
{
$this->layout='blank';
	$this->ath();
	
$s_role_id=$this->Session->read('role_id');
$s_society_id = (int)$this->Session->read('society_id');
$s_user_id=$this->Session->read('user_id');		
$this->set('s_user_id',$s_user_id);

$from = date('Y-m-d',strtotime($from));
$to = date('Y-m-d',strtotime($to));
$from_strtotime = strtotime($from);
$to_strtotime = strtotime($to);

$this->loadmodel('new_cash_bank');
$order=array('new_cash_bank.receipt_date'=> 'ASC');
$conditions=array('society_id'=>$s_society_id,"receipt_source"=>1,"edit_status"=>"NO",
'new_cash_bank.receipt_date'=>array('$gte'=>$from_strtotime,'$lte'=>$to_strtotime));
$bank_receipt_detail=$this->new_cash_bank->find('all',array('conditions'=>$conditions,'order'=>$order));
$this->set('bank_receipt_detail',$bank_receipt_detail);
	
}
////////////////////End my_flat_receipt_update_ajax //////////////////////////////////////////////
/////////////////////// Start my_flat_receipt_update_form //////////////////////////////////////
function my_flat_receipt_update_form($auto_id = null)
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

$auto_id = (int)$auto_id;

$this->loadmodel('new_cash_bank');
$conditions=array('society_id'=>$s_society_id,"receipt_source"=>1,"edit_status"=>"NO","transaction_id"=>$auto_id);
$bank_receipt_detail=$this->new_cash_bank->find('all',array('conditions'=>$conditions));
$this->set('bank_receipt_detail',$bank_receipt_detail);


$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 34,"society_id"=>$s_society_id,"deactive"=>0);
$ledger_sub_account_data = $this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('ledger_sub_account_data',$ledger_sub_account_data);	


$this->loadmodel('ledger_sub_account');
$conditions=array("ledger_id" => 33,"society_id"=>$s_society_id);
$bank_detail=$this->ledger_sub_account->find('all',array('conditions'=>$conditions));
$this->set('bank_detail',$bank_detail);



}

/////////////////End my_flat_receipt_update_form ////////////////////////////////////////////////
////////////////////Start my_flat_receipt_update_json ////////////////////////////////////////////
function my_flat_receipt_update_json()
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


$flatt_datta = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
foreach ($flatt_datta as $fltt_datttaa) 
{
$wnngg_idddd = (int)$fltt_datttaa['flat']['wing_id'];
}	

$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'),array('pass'=>array($wnngg_idddd,$flat_id)));




$ledger_sub_accdetailll = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_subLedger_detail_via_flat_id'),array('pass'=>array($flat_id)));
foreach($ledger_sub_accdetailll as $subledger_dataaa) 
{
$user_id=(int)$subledger_dataaa['ledger_sub_account']['user_id'];
$user_name = $subledger_dataaa['ledger_sub_account']['name'];
}	

$user_detailll = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($user_id)));
foreach($user_detailll as $user_dataaa) 
{
$user_email=$user_dataaa['user']['email'];
}	
////////////Email ////////////////////////

$this->loadmodel('society');
$condition=array('society_id'=>$s_society_id);
$result_society=$this->society->find('all',array('conditions'=>$condition)); 
$this->set('result_society',$result_society);
foreach($result_society as $data_society){
	$society_name=$data_society["society"]["society_name"];
	$email_is_on_off=(int)@$data_society["society"]["account_email"];
	$sms_is_on_off=(int)@$data_society["society"]["account_sms"];
    $admin_user_id = (int)$data_society["society"]["user_id"]; 
  }

if($email_is_on_off==1){
////email code//
$r_sms=$this->hms_sms_ip();
$working_key=$r_sms->working_key;
$sms_sender=$r_sms->sms_sender; 
$sms_allow=(int)$r_sms->sms_allow;

$subject="[".$society_name."]- ".$wing_flat." payment update";
//$subject = "[".$society_name."]- Receipt,"date('d-M-Y',$d_date).""; 
$email_content = "Dear ".$user_name.", Thanks for updating your payment details. (Receipt of ".$amount." via-".$mode." on ".$transaction_date.") This info has been sent to society for further verification & confirmation before issuing a formal receipt to you.";
$this->send_email($user_email,'accounts@housingmatters.in','HousingMatters',$subject,$email_content,'donotreply@housingmatters.in');
}

$user_detailll2 = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($admin_user_id)));
foreach($user_detailll2 as $user_dataaa2) 
{
$admin_email=$user_dataaa2['user']['email'];
}

if($email_is_on_off==1){
////email code//
$r_sms=$this->hms_sms_ip();
$working_key=$r_sms->working_key;
$sms_sender=$r_sms->sms_sender; 
$sms_allow=(int)$r_sms->sms_allow;

$subject="[".$society_name."]- ".$wing_flat." payment update";
//$subject = "[".$society_name."]- Receipt,"date('d-M-Y',$d_date).""; 
$email_content2 = "".$user_name."-".$wing_flat." has updated his/her payment details (Receipt of ".$amount." via-".$mode." on ".$transaction_date."). Please verify with bank statement & confirm for issuing formal receipt to resident.";

$this->send_email($admin_email,'accounts@housingmatters.in','HousingMatters',$subject,$email_content2,'donotreply@housingmatters.in');
}





	
//////////////////////////////////////////
$current_date = date('d-m-Y');

$l=$this->autoincrement('my_flat_receipt_update','auto_id');
	   
$this->loadmodel('my_flat_receipt_update');
$multipleRowData = Array( Array("auto_id"=> $l,
"receipt_date" => $transaction_date, "receipt_mode" => $mode, 
"cheque_number" =>@$cheque_number,"cheque_date" =>@$cheque_date,
"drawn_on_which_bank" =>@$drawn_bank_name,"reference_utr" => @$utr_ref,
"deposited_bank_id" => $bank_id,"member_type" => 1,
"party_name_id"=>$flat_id,"receipt_type" => 1,"amount" => $amount,
"current_date" => $current_date,"society_id"=>$s_society_id,"flat_id"=>$flat_id,
"narration"=>$narration,"prepaired_by"=>$s_user_id,"bank_branch"=>@$branch,"approval_id"=>1));
$this->my_flat_receipt_update->saveAll($multipleRowData);

$transaction_date_format = date('d-M-Y',strtotime($transaction_date)); 
$this->send_notification('<span class="label label-warning" ><i class="icon-money"></i></span>','Payment update waiting for verification ('.$wing_flat.') '.$transaction_date_format.'',28,$l,$this->webroot.'Cashbanks/bank_receipt_approve/'.$l,0,$admin_user_id);


}

$output = json_encode(array('type'=>'success', 'text' => 'Please Fill Numeric Amount '));
		die($output);	
}
////////////////////End my_flat_receipt_update_json /////////////////////////////////////////////
}
?>