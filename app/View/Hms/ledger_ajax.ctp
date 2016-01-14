<?php
if($get_id == 34 || $get_id == 15 || $get_id == 33 || $get_id == 35)
{
?>
 
                <select class="medium m-wrap" tabindex="1" name="user_name2" id="sub_id">
                <option value="">Sub Ledger</option>
                <?php
				
                foreach ($cursor1 as $collection) 
				{
				$auto_id = (int)$collection['ledger_sub_account']['auto_id'];
                $name = $collection['ledger_sub_account']['name'];
				?>
                <option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option> 
                <?php } ?>
                </select>









 <script>
$(".chosen").chosen();
</script>






<?php 
}
else
{
?>

 <select class="medium m-wrap" tabindex="1" name="user_name2" id="sub_id">
                <option value="0">Sub Ledger</option>
  </select>




<?php	
}
?>
 



