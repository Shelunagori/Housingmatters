<?php
$account_name = "";	
$bank_name = "";	
$account_number = "";	
$branch = "";	
$ifsc_code = "";	

foreach($cursor1 as $data)
{
$type = @$data['society']['neft_type'];	
$neft_detail = @$data['society']['neft_detail'];
}
if($type == "WW")
{
$account_name = "";	
$bank_name = "";	
$account_number = "";	
$branch = "";	
$ifsc_code = "";		
	
@$neft_detail2 = @$neft_detail[@$wing_id];	

$account_name = @$neft_detail2['account_name'];	
$bank_name = @$neft_detail2['bank_name'];
$account_number = @$neft_detail2['account_number'];
$branch = @$neft_detail2['branch'];
$ifsc_code = @$neft_detail2['ifsc_code'];	
}





?>

<div class="span6">
<label style="font-size:14px;">Account Name<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="m-wrap span9" name="acno" id="acno" value="<?php echo $account_name; ?>">
<label id="acno"></label>
</div>
<br />

<label style="font-size:14px;">Bank Name<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="m-wrap span9" name="bank_name" id="bnk" value="<?php echo $bank_name; ?>"/>
<label id="bnk"></label>
</div>
<br />
</div>


<div class="span6">

<label style="font-size:14px;">Account Number<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" name="acnu" class="m-wrap span9" id="acn" value="<?php echo $account_number; ?>"/>
<label id="acn"></label>
</div>
<br />


<label style="font-size:14px;">Branch<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" name="branch" class="m-wrap span9" id="bnch" value="<?php echo $branch; ?>"/>
<label id="bnch"></label>
</div>
<br />


<label style="font-size:14px;">IFSC Code<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="m-wrap span9" name="ifsc" id="cdd" value="<?php echo $ifsc_code; ?>"/>
<label id="cdd"></label>
</div>
<br />
</div>


