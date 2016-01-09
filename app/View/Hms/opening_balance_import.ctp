<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>

<?php
if($nnn == 5)
{

if(@$ok==2)
{
echo '<div class="alert alert-success">'.$sucess.'</div>';
}
if(@$ok==1)
{

echo '<div class="alert alert-error">';
echo "<h4>Error :</h4></br>";
foreach($error_msg as $er_msg)
{
echo '<p>'.$er_msg.'</p>';
}
echo '</div>';
}
?>


<div class="portlet box green">
<div class="portlet-title">
<h4><i class="icon-cogs"></i> Csv Import</h4>
</div>
<div class="portlet-body">
<form  id="contact-form" name="myform" enctype="multipart/form-data" class="form-horizontal" method="post" >	
<div class="control-group">
<label class="control-label">Attach csv file</label>
<div class="controls">
<input type="file" name="file" class="default">
<input type="submit" name="sub" class="btn blue" value="Import" >
</div>
</div>
</form>	

<strong><a href="<?php echo $webroot_path; ?>/csv_file/demo/demo2.csv" download="">Click here for sample format</a></strong>
<br>
<h4>Instruction set to import users</h4>
<?php
echo 'hello';
?>	
<ol>
<li>All the field are compulsory.</li>
<li>Opening Balance Amount should be Numeric</li>
<li>Amount Type should be 'Debit' or 'Credit'</li>
<li>Total Debit should be same to total Credit</li>
</ol>
	
</div>
</div>
<?php }

else if($nnn == 55)
{

//$datee = explode(',',$datei);
//$ac_namee = explode(',',$ac_namei);
//$amt_typee = explode(',',$amt_typei);
//$op_bale = explode(',',$op_bali);

?>
<form method="post">
<table class="table table-bordered" style="background-color:white;">
<tr>
<th>Sr #</th>
<th>Date</th>
<th>A/c Name</th>
<th>Amount Type</th>
<th>Amount(Opening Balance)</th>    
</tr>
<?php
$n=0;
$total = 0;
for($i=1;$i<sizeof($test);$i++)
{
$n++;
$row_no=$i+1;
$r=explode(',',$test[$i][0]);
$date2=trim($r[0]);
//$acccount_type=trim($r[1]); 
$account_name=trim($r[1]);
$amount_type=trim($r[2]);
$opening_balance=trim($r[3]);
$total = $total + $opening_balance;

?>    
 <tr>
 <td><?php echo $n; ?></td>
 <td><?php echo $date2; ?></td>
 <td><?php echo $account_name; ?></td>
 <td><?php echo $amount_type; ?></td>
 <td><?php echo $opening_balance; ?></td>
 </tr>   
<?php
}
?>  
<tr>
<th colspan="4">Total</th>
<th><?php echo $total; ?></th>
</tr> 
</table>   
  
<div style="width:100%;">
<a href="opening_balance_import" class="btn green">Ok</a>
</div>   
</form>   

<?php
}
?>