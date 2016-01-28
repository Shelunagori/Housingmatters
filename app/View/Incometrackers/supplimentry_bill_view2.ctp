<style>
@media screen {
    .bill_on_screen {
       width:70%;
    }
}

@media print {
    .bill_on_screen {
       width:90% !important;
    }
}
.main_table{
	background-color: #F1F3FA !important;
}
.hmlogobox{
	display:none;
}
</style>

<?php


$html='<div style="margin: 0px;">

<table style="padding:24px;background-color:#34495e" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="main_table">
           <tbody>
           <tr>
           <td>
               <table style="padding:38px 30px 30px 30px;background-color:#fafafa" align="center" border="0" cellpadding="0" cellspacing="0" width="540">
               <tbody>
               <tr>
			   <td height="10">
								<table width="100%" class="hmlogobox">
								<tr>
								<td width="50%" style="padding: 10px 0px 0px 10px;"><img src="'.$ip.$this->webroot.'/as/hm/hm-logo.png" style="max-height: 60px; " height="60px" />
								</td>
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
					<td colspan="2" style="font-size:12px;line-height:1.4;font-family:Arial,Helvetica,sans-serif;color:#34495e;border: solid 1px #767575;">
									<table style="font-size:12px" width="100%" cellspacing="0">
									<tbody><tr>
									<td style="padding:2px;background-color:rgb(0,141,210);color:#fff" align="center" width="100%"><b>
			'.strtoupper($society_name).'</b>
									</td>
									</tr>
									</tbody>
									</table>
									
								<table style="font-size:12px" width="100%" cellspacing="0">
								<tbody>
								<tr>
								<td width="30%" style="border-bottom: solid 1px #767575; border-top: solid 1px #767575;">';
								 if(!empty($society_logo)){ 
                                 
$html.='<img src="'.$webroot_path.'/logo/'.$society_logo.'"  height="45px" width="45px">';	
								 } 
$html.='</td>
<td style="padding:5px;border-bottom: solid 1px #767575; border-top: solid 1px #767575;"  width="70%" align="right">
<span style="color: rgb(100, 100, 99);">Regn# &nbsp; '.$society_reg_num.'</span><br>
								<span style="color: rgb(100, 100, 99); ">'.$society_address.'</span><br><span>Email:</span><a href="mailto:'.$society_email.'" target="_blank" style="color:#000 !important;text-decoration: none;">'.$society_email.'</a> | <span>Phone : '.$society_phone.'</span>
								</td>
								</tr>
								</tbody>
								</table>';
							
$flat_id = (int)@$user;
$due_date2 = date('d-m-Y',strtotime($due_date));
$from2 = date('d-m-Y',strtotime($from));
if($type == 2)
{
$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_subLedger_detail_via_flat_id'),
array('pass'=>array($flat_id)));	
		foreach($result1 as $collection)
		{	
		$auto_id = (int)$collection['ledger_sub_account']['auto_id'];
		//$user_id = (int)$collection['ledger_sub_account']['user_id'];
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

if($area_scale == 0)
{
$area_scale_text = "sq.ft.";	
}
else
{
$area_scale_text = "sq.mtr.";		
}
}
else
{
	$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),
	array('pass'=>array($flat_id)));	
	foreach($result1 as $collection)
	{	
	$auto_id = (int)$collection['ledger_sub_account']['auto_id'];
	//$flat_id = (int)$collection['ledger_sub_account']['flat_id'];
	$user_name = $collection['ledger_sub_account']['name'];
	}
	
$wing_flat = "";	
}
?>	
<?php if($type == 2) { 					
$html.='<table style="font-size:12px" width="100%" cellspacing="0">
<tbody><tr>
<td style="padding: 0px 0 0 5px;"><b>Name:</b></td>
<td>'.$user_name.'</td>
<td><b>Flat/Shop No.:</b></td>
<td>'.$wing_flat.'</td>
</tr>
<tr>
<td style="padding: 0px 0 0 5px;"><b>Bill No.:</b></td>
<td>'.$bill_no.'</td>
<td><b>Area ('.@$area_scale_text.'):</b></td>
<td>'.$sq_feet.'</td>
</tr>
<tr>
<td style="padding: 0px 0 0 5px;"><b>Bill Date:</b></td>
<td>'.$from2.'</td>
<td></td>
<td></td>
</tr>
<tr>
<td style="padding: 0px 0 0 5px;"><b>Due Date:</b></td>
<td>'.$due_date2.'</td>
<td></td>
<td></td>
</tr>
</tbody>
</table>';
} else { 
$html.='<table style="font-size:12px" width="100%" cellspacing="0">
<tbody><tr>
<td style="padding: 0px 0 0 5px;"><b>Name:</b></td>
<td>'.$user_name.'</td>
<td><b>Flat/Shop No.:</b></td>
<td>'.$wing_flat.'</td>
</tr>
<tr>
<td style="padding: 0px 0 0 5px;"><b>Bill No.:</b></td>
<td>'.$bill_no.'</td>
<td></td>
<td></td>
</tr>
<tr>
<td style="padding: 0px 0 0 5px;"><b>Bill Date:</b></td>
<td>'.$from2.'</td>
</tr>
<tr>
<td style="padding: 0px 0 0 5px;"><b>Due Date:</b></td>
<td>'.$due_date2.'</td>
<td></td>
<td></td>
</tr>
</tbody>
</table>';	
}
$html.='<table style="font-size:12px;border-bottom: solid 1px #767575;" width="100%" cellspacing="0">
<tbody><tr>
<td style="padding: 0 0 0 5px;background-color:rgb(0,141,210);color:#fff;border-top: solid 1px #767575;border-bottom: solid 1px #767575;border-right: solid 1px #FFFFFF;" align="left" width="60%"><b>Particulars of charges</b></td>
<td style="padding: 0 5px 0 0;background-color:rgb(0,141,210);color:#fff;border-top: solid 1px #767575;border-bottom: solid 1px #767575;" align="right" width="40%"><b>Amount (Rs.)</b></td>
</tr>';
$income_head_id = (int)$inhead_id;
$result3 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($income_head_id)));		
foreach($result3 as $collection)
{
$income_head_name = $collection['ledger_account']['ledger_name'];
}
$html.='<tr>
<td align="left" style="border-right: solid 1px #767575;padding: 0 0 0 5px;" >
'.$income_head_name.'</td>
<td align="right" style="padding: 0 5px 0 0;">';$value2 = number_format($amount);  
$html.=''.$value2.'</td>
</tr>';

$html.='
</tbody>
</table>';


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



$html.='<table style="font-size:12px;border-bottom: solid 1px #767575;" width="100%" cellspacing="0">
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
						</tbody>
						</table>
										
	</td>
	<td width="40%" valign="top">
										<table style="font-size:12px" width="100%">
										<tbody>';
										 if($type == 2) { 
										$html.='<tr>
										<td align="right" width="70%">Total:</td>
										<td align="right" width="30%" style="padding: 0 5px 0 0;">';
										$total2 = number_format($amount);
								
										$html.=''.$total2.'</td>
					</tr>
					<tr>
					<td align="right" width="70%"><b>Due for Payment:</b></td>
					<td align="right" width="30%" style="padding: 0 5px 0 0;"><b>'.$total2.'</b></td>
										</tr>';
                                       } else { 
								$html.='<tr>
										<td align="right" width="70%">Total:</td>
										<td align="right" width="30%" style="padding: 0 5px 0 0;">';
										$total2 = number_format($amount);
								
										$html.=''.$total2.'</td>
					</tr>
					<tr>
					<td align="right" width="70%"><b>Due for Payment:</b></td>
					<td align="right" width="30%" style="padding: 0 5px 0 0;"><b>'.$total2.'</b></td>
										</tr>';           
										 } 
										$html.='</tbody>
										</table>
	</td>
	</tr>
	</tbody>
	</table>';								
									
	
								
	
if($type == 2)
{
$due_for_payment = $amount;	
}
else
{
$due_for_payment = $amount;			
}
								
if($due_for_payment<0){
$write_am_word="Nil";
}else{
$am_in_words=ucwords(strtolower($this->requestAction(array('controller' => 'hms', 'action' => 'convert_number_to_words'),
array('pass'=>array($due_for_payment)))));
$write_am_word="Rupees ".$am_in_words." Only";
}								
					
$html.='<table style="font-size:12px" width="100%" cellspacing="0">
<tbody>
<tr>
<td width="100%" style="font-size:12px;border-bottom: solid 1px #767575;padding: 0 0 0 5px;">
<b>Due For Payment (in words) :</b>'.$write_am_word.'</td>
</tr>
</tbody>
</table>';									
				
$html.='<table style="font-size:12px;border-bottom: dotted 1px;" width="100%" cellspacing="0">
<tbody>
<tr>
<td width="50%" style="padding:5px;" valign="top">
<span>Remarks:</span><br>';
 
$html.='<span>'.@$des.'</span><br>';

$html.='</td>
<td align="center" width="50%" style="padding:5px;" valign="top">
For  <b>'.$society_name.'</b><br><br><br>
<div><span style="border-top:solid 1px #424141">'.$sig_title.'</span></div>
</td>
</tr>
</tbody>
</table>									
							

		<table style="font-size:12px" width="100%" cellspacing="0">
		<tbody><tr>
		<td align="center" width="100%">Note: This is a computer generated bill hence no signature required.</td>
		</tr>
		</tbody>
		</table>


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
		</table>
             
            </div>';

echo $html;
?>
<form method="post">


<input type="hidden" name="htmllll" value='<?php echo $html; ?>' />

<input type="hidden" name="amt" value="<?php echo $amount; ?>" />
<input type="hidden" name="from" value="<?php echo $from; ?>" />
<input type="hidden" name="due_date" value="<?php echo $due_date; ?>" />
<input type="hidden" name="desc" value="<?php echo $des; ?>" />
<input type="hidden" name="type" value="<?php echo $type; ?>" />
<?php
if($type == 1)
{
?>
<input type="hidden" name="com" value="<?php echo $company_name; ?>" />
<input type="hidden" name="ih" value="<?php echo $inhead_id; ?>" />
<input type="hidden" name="res_id" value="<?php echo $user; ?>" />
<?php
}
else
{
?>
<input type="hidden" name="ih" value="<?php echo $inhead_id; ?>" />
<input type="hidden" name="res_id" value="<?php echo $user; ?>" />
<?php
}
?>
<br />
<div style="width:100%;">
<a href="it_supplimentry_bill" class="btn green" style="margin-left:68%;"><i class="icon-arrow-left"></i>Back</a>
<button type="submit" name="sub_sup" class="btn red"  value="ssss">Submit</button>
</div>
</form>








	
