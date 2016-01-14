<?php
if($cc == 1)
{
echo "<p style='color:red; font-size:14px;'>Date Invalid (To Date is small than From Date)</p>";
}
else if($cc == 2)
{
echo "<p style='color:red; font-size:14px;'>Date Invalid(Dates is not in open year Plese Check)</p>";	
}
else if($cc == 3)
{
echo "<p style='color:red; font-size:14px;'>Date Invalid (Due Date is small Than From Date)</p>";	
}
else
{
	
}

?>