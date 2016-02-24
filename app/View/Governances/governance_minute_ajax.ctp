<?php 
foreach($result_governance_invite as $data){
$gov_invite_id=$data['governance_invite']['governance_invite_id'];
$date=$data['governance_invite']['date'];
$time=$data['governance_invite']['time'];
$location=$data['governance_invite']['location'];
$message=$data['governance_invite']['message'];
$user=$data['governance_invite']['user'];
}

?>

<div class="control-group" id="" >
  <div class="controls">
   
<select data-placeholder="Select attendees user"  name="multi" id="multi" class="chosen span9" multiple="multiple" tabindex="6">
<?php
foreach ($user as $collection){
$result_user=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($collection)));
$user_id=$result_user[0]["user"]["user_id"];
$user_name=$result_user[0]["user"]["user_name"];
$email=$result_user[0]["user"]["email"];
$wing=$result_user[0]["user"]["wing"];
$flat=$result_user[0]["user"]["flat"];


$flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));

?>
<option value="<?php echo $user_id; ?>" selected><?php echo $user_name; ?>&nbsp;&nbsp;<?php echo $flat; ?></option>
<?php } ?>           
		  
	 </select>
	 
  </div>
  <label report="multi" class="remove_report"></label>
</div>

<div class="row-fluid">
<label style="font-size:14px; font-weight:bold;"><span>Date </span> <span style="margin-left:50px;"> Time </span> <span style="margin-left:50px;"> Location </span></label> 
<span> <?php echo @$date ; ?> </span> <span style="margin-left:15px;"> <?php echo @$time ; ?> </span> <span style="margin-left:30px;"> <?php echo @$location ; ?> </span>
</div>
<br/>


<div class="row-fluid">
<table  width="100%" id="count_table" border="0">
<thead>
<tr>
<td width="60%"><b> Agenda </b></td><td> <b> Minutes </b></td></tr>

</thead>
<tbody>
 <?php
 $z=0;
		

		  foreach($message as $data){
			  $z++;
			  
			  $data[1];
			  ?>
			  <tr>
			  <td>
			 <b> <?php echo $z; ?> <?php echo urldecode($data[0]); ?> </b><br/> <?php echo urldecode($data[1]); ?>
			  </td>
			  <td>
			  <textarea name="min_<?php echo $z; ?>" class="span12 " rows="4" id=""></textarea>
			  </td>
			 </tr> 
			 <?php 
		  }
			   
 ?>
 </tbody>
 </table>
 
		  
 


</div>