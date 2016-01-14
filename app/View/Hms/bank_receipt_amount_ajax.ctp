<?php
$total_amount = 0;
if(!empty($i_head))
{
$new=explode(',',$i_head);
for($i=0; $i<sizeof($new); $i++)
{
$value = $new[$i];
$abc = explode('/',$value);
$amount = @$abc[1];	
$total_amount = $total_amount + $amount;
}
?>
<br>

<input type="text" readonly name="amount" value="<?php echo $total_amount; ?>" class="m-wrap medium">

<?php
}
else
{
	?>
<input type="text" readonly name="amount" class="m-wrap medium">	

<?php } ?>