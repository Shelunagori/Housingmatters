<?php
if($cc == 1)
{
echo "<p style='color:red; font-size:15px;'>Date Invalid (To Date is small than From Date)</p>";
}
else if($cc == 2)
{
echo "<p style='color:red; font-size:15px;'>Billing Date Should be in Open Financial Year</p>";	
}
else if($cc == 3)
{
echo "<p style='color:red; font-size:15px;'>Billing Date can not be Small than Due Date</p>";	
}
else if($cc == 5)
{
echo "<p style='color:red; font-size:15px;'>Bill Already Generated for the Mentioned Period, Kindly Select Another Period</p>";		
}
else if($cc == 505)
{
echo "<p style='color:red; font-size:15px;'>Due Date could not be greater then billing end date, Kindely select anouther date</p>";		
}
else
{
	
}

?>