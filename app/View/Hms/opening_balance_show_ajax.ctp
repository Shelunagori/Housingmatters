<?php 
if($le_ac == 15 || $le_ac == 33 || $le_ac == 35 || $le_ac == 34) 
{
?>
<table class="table table-bordered">
<tr>
<td style="text-align:center; font-size:16px;">
The Opening Balance For <?php echo $subl_name; ?>  Account For Year <?php echo $year; ?>  is:
</td>
<th style="text-align:center; font-size:16px;">
<?php echo $op_ba; ?> 
</th>
</tr>
</table>

<?php

}
else
{
?>
<table  class="table table-bordered">
<tr>
<td style="text-align:center; font-size:16px;">
The Opening Balance For <?php echo $le_ac_name; ?>  Account For Year <?php echo $year; ?>  is:
</td>
<th style="text-align:center; font-size:16px;">
<?php echo $op_ba; ?> 
</th>
</tr>
</table>

<?php } ?>