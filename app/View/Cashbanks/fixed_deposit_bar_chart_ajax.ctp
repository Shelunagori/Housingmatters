<?php
$from = date('Y-m-d',strtotime($from));
$to = date('Y-m-d',strtotime($to));
$to_datttt = $to;
$month_array = array();

$start    = new DateTime($from);
$start->modify('first day of this month');
$end      = new DateTime($to);
$end->modify('first day of next month');
$interval = DateInterval::createFromDateString('1 month');
$period   = new DatePeriod($start, $interval, $end);

foreach ($period as $dt) {
$month_array[] = $dt->format("Y-m-01"); 
}

$chart_array = array();
for($r=0; $r<sizeof($month_array); $r++)
{
$mmmm = $month_array[$r]; 
$first_date = date('Y-m-d',strtotime($mmmm));
$last_date = date('Y-m-t',strtotime($mmmm));
$month = date('M-Y',strtotime($mmmm));
$frmm = strtotime($first_date);
$to = strtotime($last_date);
$amtttt = 0;
$fix_deposit_dataaaa = $this->requestAction(array('controller' => 'hms', 'action' => 'fix_deposit_count_via_maturity_date'),array('pass'=>array($frmm,$to)));
foreach($fix_deposit_dataaaa as $ffxxdepp_detailll)
{
$amt = $ffxxdepp_detailll['fix_deposit']['principal_amount'];
$amtttt = $amtttt+$amt;	
}
$chart_array[] = array($month,$amtttt);	
}

$total_amt=0;
for($k=0; $k<sizeof($chart_array); $k++)
{
$sub_arr = $chart_array[$k];	
$cc = (int)$sub_arr[1]; 
$total_amt = $total_amt+$cc;
}
$subtotal = ($total_amt/5);

for($l=0; $l<sizeof($chart_array); $l++)
{ 
$cccount = 0;
$arrr_sub = $chart_array[$l];
$cccount = (int)@$chart_array[1];
}
?>
<div class="hide_at_print">
<a href="bar_chart_pdf?date1=<?php echo $from; ?>&date2=<?php echo $to_datttt; ?>" target="_blank"  class="btn blue mini">PDF</a>
<a type="button" class=" printt btn green mini" onclick="window.print()"><i class="icon-print"></i> Print</a>
</div>
<div style="background-color:#FFF; overflow:auto; border:1px solid #CCC;" class="row-fluid">
<h4 style="color: #03F;font-weight: 500;border-bottom: solid 1px #DAD9D9;padding-bottom:18px;">&nbsp;&nbsp;&nbsp;<i class="icon-money"></i> Fixed Deposit Maturity Profile</h4>
<h5 style="margin-left:3%;"><b>Rupees</b></h5>

<div style="width:6.3%; height:350px; float:left;">


 <div style="width:100%; height:20%;">
    <p style="text-align:right;"><b><?php echo $total_amt2 = round($total_amt); ?></b></p>
    </div>  
    
     <div style="width:100%; height:20%;">
     <p style="text-align:right;"><b><?php echo $sub4 = round($subtotal*4); ?></b></p>
    </div>  
    
     <div style="width:100%; height:20%;">
     <p style="text-align:right;"><b><?php echo $sub3 = round($subtotal*3); ?></b></p>
     
    </div>  
    
     <div style="width:100%; height:20%;">
     <p style="text-align:right;"><b><?php echo $sub2 = round($subtotal*2); ?></b></p>
    </div>  
    
     <div style="width:100%; height:20%;">
   <p style="text-align:right;"><b><?php echo $sub1 = round($subtotal*1); ?></b></p>
     </div>  

</div>
<div style="width:90%; border-bottom:solid thin silver; border-left:solid thin silver; height:350px; float:right;" class="chart">
		
		<?php
		for($l=0; $l<sizeof($chart_array); $l++)
        {
		$sub_arrrr = $chart_array[$l];
		$month = $sub_arrrr[0];
		$ccount = $sub_arrrr[1];
		if($total_amt != 0)
		{
		$perr = (($ccount/$total_amt)*100);
		}
		else
		{
		$perr = 0;	
		}
		
		if($perr != 0) {
			
			$perr = number_format($perr,2);
		?>
		
        <div class="column">
        <div class="fill" style="text-align:center;"><p><?php echo $ccount; ?><br /><b><?php echo $perr;  ?>%</b></p></div>
     
        
        </div>
         
	<?php } } ?>	
    <div style="width:100%; border-top:solid thin silver; height:20%;">
    </div>  
		
  <div style="width:100%; border-top:solid thin silver; height:20%;">
  </div>   
    <div style="width:100%; border-top:solid thin silver; height:20%;">
  </div>   
    <div style="width:100%; border-top:solid thin silver; height:20%;">
  </div>   
    <div style="width:100%; border-top:solid thin silver; height:20%;">
  </div>   
     

</div>

<div style="width:90%;float:right;" class="chart">
<?php for($l=0; $l<sizeof($chart_array); $l++)
        {
		$sub_arrrrr = $chart_array[$l];
		$monthh = $sub_arrrrr[0];
		$ccount = $sub_arrrrr[1];
		if($total_amt != 0)
		{
		$perr = (($ccount/$total_amt)*100);
		}
		else
		{
		$perr = 0;	
		}
		
		if($perr != 0) {
		?>
 <div class="column">
  <p class="rotulo" style="text-align:center;"><b><?php echo $monthh; ?></b></p>
 </div>
<?php } } ?>

</div>


</div>




<style>

.chart{
	/*border: solid thin silver;*/
	width: 450px;
	height: 300px;
	padding: 10px;
}
.column{
	width: 80px;
	height: 100%;
	margin: 2px 5px;
	float: left;
	position: relative;
	
}

.column .fill{
	width: 100%;
	position: absolute;
	bottom: 0px;
	
}


.label{
	text-align: center;
}
.column2{
	width: 80px;
	height: 100%;
	margin: 2px 5px;
	float: left;
	position: relative;
}

</style>

<style>
<?php 
$nn = 0;
for($l=0; $l<sizeof($chart_array); $l++)
{ 
$perr = 0;
$cccount = 0;
$arrr_sub = $chart_array[$l];
$cccount = $arrr_sub[1];

if($total_amt != 0)
{
$perr = (($cccount/$total_amt)*100);
}
else
{
$perr = 0;	
}

if($nn%2 == 0)
{
$color = "grey";  
}
else
{
$color = "pink";    
}
if($perr != 0) { 
$nn++;
?>
.column:nth-child(<?php echo $nn; ?>) .fill{
		background: <?php echo $color; ?>;
		height: <?php echo $perr; ?>%;
	}

<?php } } ?>

</style>


<!--
<style>

	.column:nth-child(1) .fill{
		background: yellow;
		height: 50%;
	}
	.column:nth-child(2) .fill{
		background: yellow;
		height: 50%;
	}
	.column:nth-child(3) .fill{
		background: green;
		height: 60%;
	}
	.column:nth-child(4) .fill{
		background: red;
		height: 80%;
	}
	.column:nth-child(5) .fill{
		background: gray;
		height: 20%;
	}
</style>-->










<!--
<div class="chart">
	<div class="column-container">
		<div class="column">
			<div class="fill"></div>
			<p class="rotulo">NY</p>
		</div>
		<div class="column">
			<div class="fill"></div>
			<p class="rotulo">Boston</p>
		</div>
		<div class="column">
			<div class="fill"></div>
			<p class="rotulo">LA</p>
		</div>
		<div class="column">
			<div class="fill"></div>
			<p class="rotulo">Houston</p>
		</div>
		<div class="column">
			<div class="fill"></div>
			<p class="rotulo">Washington</p>
		</div>
	</div>
</div> 
-->
