<?php
if($cc == 1)
{
echo "<p style='color:red; font-size:15px;'>Date Invalid (To Date is small than From Date)</p>";
}
else if($cc == 2)
{
echo "<p style='color:red; font-size:15px;'>Date Invalid(Dates is not in open year Please Check)</p>";	
}
else if($cc == 3)
{
echo "<p style='color:red; font-size:15px;'>Invalid Date (Due Date should be after Bill start date)</p>";	
}
else if($cc == 5)
{
echo "<p style='color:red; font-size:15px;'>Bill already generated for the mentioned period, Kindly select another period</p>";		
}
else if($cc == 505)
{
echo "<p style='color:red; font-size:15px;'>Due Date could not be greater then billing end date, Kindely select anouther date</p>";		
}
else
{
	
}

?>