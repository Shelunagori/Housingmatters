
<?php
$nn = 0;
foreach($cursor1 as $dataaaa)
{
	$nn++;
$maturity_date = $dataaaa['fix_deposit']['maturity_date'];	
if($nn == 1)
{
$tooo_dattt = $maturity_date; 	
}
if($maturity_date > $tooo_dattt)
{
$tooo_dattt = $maturity_date;	
}
	
}


$dat_toooo = date('d-m-Y',($tooo_dattt))

?>


<div class="hide_at_print">
<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>    
<center>
<a href="<?php echo $webroot_path; ?>Cashbanks/fix_deposit_add" class="btn" rel='tab'>Add</a>
<a href="<?php echo $webroot_path; ?>Cashbanks/fix_deposit_view" class="btn yellow" rel='tab'>Active Deposits</a>
<a href="<?php echo $webroot_path; ?>Cashbanks/matured_deposit_view" class="btn" rel='tab'>Matured Deposits</a>
<!--<a href="<?php echo $webroot_path; ?>Cashbanks/fixed_deposit_bar_chart" class="btn" rel='tab'>Maturity Profile</a>-->
<!--<a href="<?php //echo $webroot_path; ?>Cashbanks/matured_deposit_add" class="btn" rel='tab'>Approve matured Deposit</a>-->
</center>
<?php
$b_date = date('1-m-Y');
?>
        
<center>
<div class="hide_at_print">
<table>
<tr>
<td><input type="text" id="date1" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="from" placeholder="From" style="background-color:white !important;" value="<?php echo $b_date; ?>"></td>
<td><input type="text" id="date2" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="to" placeholder="To" style="background-color:white !important;" value="<?php echo $dat_toooo; ?>"></td>
<td valign="top"><button type="button" name="sub" class="btn yellow" id="go">Go</button></td>
</tr>
</table>
</div>
</center>
</div>
<span style="float:right;"><a href="<?php echo $webroot_path; ?>Cashbanks/fixed_deposit_bar_chart" class="btn blue mini" rel='tab'>Maturity Profile</a></span>
<div id="result"></div>


		<script>
        $(document).ready(function() {
        $("#go").bind('click',function(){
        var date1=document.getElementById('date1').value;
        var date2=document.getElementById('date2').value;
        
        if((date1=='')) { alert('Please Input Date-from'); }
        if((date2=='')) { alert('Please Input Date-to'); }
        else
        {
        $("#result").html('<div align="center" style="padding:10px;"><img src="<?php echo $webroot_path;?>as/loding.gif" />Loading....</div>').load("fixed_deposit_bar_chart_ajax?date1=" +date1+ "&date2=" +date2+ "");
        }
        });
        });
        </script>	