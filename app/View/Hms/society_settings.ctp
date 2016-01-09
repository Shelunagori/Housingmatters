<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
Society Settings
</div>
<div class="tabbable tabbable-custom">
<ul class="nav nav-tabs">
<li  ><a href="<?php echo $webroot_path; ?>Hms/master_sm_wing" rel='tab'> Wing</a></li>
<li><a href="<?php echo $webroot_path; ?>Hms/flat_type" rel='tab' >Unit Number</a></li>
<li ><a href="<?php echo $webroot_path; ?>Hms/master_sm_flat" rel='tab' >Unit Configuration</a></li>
<!--<li><a href="<?php echo $webroot_path; ?>Hms/flat_nu_import" rel='tab' >Flat Number Import</a></li>-->
<li><a href="<?php echo $webroot_path; ?>Hms/society_details" rel='tab' >Society Details</a></li>
<li class="active" ><a href="<?php echo $webroot_path; ?>Hms/society_settings" rel='tab' >Society Settings</a></li>
</ul>
<div class="tab-content" style="min-height:300px;">
<div class="tab-pane active" id="tab_1_1">

<?php

foreach($result_society as $data)
{

			@$signup_auto=$data['society']['signup'];
			@$help_desk=$data['society']['help_desk'];
			@$family_member=$data['society']['family_member'];
			@$notice=$data['society']['notice'];
			@$document=$data['society']['document'];
			@$discussion_forum=$data['society']['discussion_forum'];
			@$discussion_forum_email=$data['society']['discussion_forum_email'];
			@$poll=$data['society']['poll'];
			@$account_email=$data['society']['account_email'];
			@$account_sms=$data['society']['account_sms'];
			@$account_zero_ammount=$data['society']['account_zero_ammount'];
			@$banned_word=$data['society']['content_moderation'];
			@$banned_word=implode(',',$banned_word);
			@$user_id=$data['society']['user_id'];
			@$society_pan=$data['society']['pan'];
			@$society_tax=$data['society']['tex_number'];
			@$merge_receipt=$data['society']['merge_receipt'];
			@$access_tenant=$data['society']['access_tenant'];




}
if($role_id==3)
{

?>


<br>
<form method='post' >
<table class="table  " border='0' style='background-color:#fafafa !important;width: 75%;
align-content: center;
margin-left: 13%;' >
<tr style='background-color:#fafafa !important;'>
<td> <span style='color:#3B6B96;font-size: 16px;font-weight: bold;'>1. Shall auto create accounts for email addresses when adding members to your Society ? </span><br>
<span style='font-size:12px;'> &nbsp &nbsp <p> <input type='checkbox' name='signup' value='1' <?php if($signup_auto==1){?> checked <?php } ?> > Check this if you want HM accounts for email addresses uploaded/added by the administrator as members of this society to be auto created. When this is checked, member accounts will be auto-created in HM and a link to activate their account shall be sent to their email address.This instantly makes the users added part of the society member list. If this is unchecked, members will receive a mail to create their accounts in HM. When the member creates the account and activates the same, only then the member will be listed in the member database. Please note that as the Administrator of this society, you shall be responsible for all email addresses added into your society. Onus lies on you to ensure that email addresses being added are provided by the owners/residents of your society.
 </p></span>
</td>
</tr>

<tr>
<td>
<span style='color:#3B6B96;font-size: 16px;font-weight: bold;'>2. Should allow members to log community complaints ? </span><br>
<span style='font-size:12px;'> &nbsp &nbsp <p> <input type='checkbox' name='help_desk' value='1' <?php if($help_desk==1){?> checked <?php } ?> > Check this if you want to allow members to log community complaints in HousingMatters. 
 </p></span>
</td>
</tr>

<tr style='background-color:#fafafa !important;'>
<td>
<span style='color:#3B6B96;font-size: 16px;font-weight: bold;'>3. Should notices be approved before being shown to other members ? </span><br>
<span style='font-size:12px;'> &nbsp &nbsp <p> <input type='checkbox' name='notice' value='1' <?php if($notice==1){?> checked <?php } ?>> Check this if you want all notices submitted by members to be approved by the administrator before they are posted to other members.
 </p></span>
</td>
</tr>
<tr style='background-color:#fafafa !important;'>
<td>
<span style='color:#3B6B96;font-size: 16px;font-weight: bold;'>4. Should documents be approved before being shown to other members ? </span><br>
<span style='font-size:12px;'> &nbsp &nbsp <p> <input type='checkbox' name='document' value='1' <?php if($document==1){?> checked <?php } ?>> Check this if you want all documents submitted by members to be approved by the administrator before they are posted to other members.
 </p></span>

</td>
</tr>

<tr style='background-color:#fafafa !important;'>
<td>
<span style='color:#3B6B96;font-size: 16px;font-weight: bold;'>5. Should discussion forums be moderated ? </span><br>
<span style='font-size:12px;'> &nbsp &nbsp <p> <input type='checkbox' name='discussion_forum' value='1' <?php if($discussion_forum==1){?> checked <?php } ?>> Check this if you want all forum topics submitted by members to be approved by the administrator before they are posted on the forum.
 </p></span>

</td>
</tr>

<tr style='background-color:#fafafa !important;'>
<td>
<span style='color:#3B6B96;font-size: 16px;font-weight: bold;'>6. Should email notifications be sent for topics/replies on discussion forums ? </span><br>
<span style='font-size:12px;'> &nbsp &nbsp <p> <input type='checkbox' name='discussion_forum1' value='1' <?php if($discussion_forum_email==1){?> checked <?php } ?>> Check this if you want all topics and replies posted on the discussion forum to be sent via email to all members.
 </p></span>
</td>
</tr>

<tr style='background-color:#fafafa !important;'>
<td>
<span style='color:#3B6B96;font-size: 16px;font-weight: bold;'>7. Should polls be moderated ? </span><br>
<span style='font-size:12px;'> &nbsp &nbsp <p> <input type='checkbox' name='poll' value='1' <?php if($poll==1){?> checked <?php } ?> > Check this if you want all poll topics submitted by members to be approved by the administrator before they are posted.
 </p></span>
</td>
</tr>
<tr>
<td>
<span style='color:#3B6B96;font-size: 16px;font-weight: bold;'>8. Whether family members should allow to login into the portal ? </span><br>
<span style='font-size:12px;'> &nbsp &nbsp <p> <input type='checkbox' name='family_member' value='1' <?php if($family_member==1){?> checked <?php } ?>> Check this if you want to allow family members to login the portal.
 </p></span>
</td>
</tr>
<tr>
<td>
<span style='color:#3B6B96;font-size: 16px;font-weight: bold;'>9. Should send email notifications for invoices & receipts ? </span><br>
<span style='font-size:12px;'> &nbsp &nbsp <p> <input type='checkbox' name='account1' value='1' <?php if($account_email==1){?> checked <?php } ?>> Check this if you want email notifications to be sent to members when a new invoice is posted and a new receipt is generated.
 </p></span>
</td>
</tr>

<tr>
<td>
<span style='color:#3B6B96;font-size: 16px;font-weight: bold;'>10. Should send SMS notifications for invoices & receipts ? </span><br>
<span style='font-size:12px;'> &nbsp &nbsp <p> <input type='checkbox' name='account2' value='1' <?php if($account_sms==1){?> checked <?php } ?>> Check this if you want sms notifications to be sent to members when a new invoice is posted and a new receipt is generated.
 </p></span>
</td>
</tr>


<tr>
<td>
<span style='color:#3B6B96;font-size: 16px;font-weight: bold;'>11. Should invoice & last receipt be merge on bill ? </span><br>
<span style='font-size:12px;'> &nbsp &nbsp <p> <input type='checkbox' name='merge_receipt' value='1' <?php if($merge_receipt==1){?> checked <?php } ?>> Check this if you want to merge invoice & last receipt on bill .
 </p></span>
</td>
</tr>

<tr>
<td>
<span style='color:#3B6B96;font-size: 16px;font-weight: bold;'>12. Should Reminder Send ? </span><br>
<span style='font-size:12px;'> &nbsp &nbsp <p> <input type='checkbox' name='remndrr' value='1' <?php //if($account_zero_ammount==1){?>  <?php //} ?>>Reminder for Income Tracker and Fixed Deposit 
 </p></span>
</td>
</tr>

<tr>
<td>
<span style='color:#3B6B96;font-size: 16px;font-weight: bold;'>13. Should notify zero amount invoice ? </span><br>
<span style='font-size:12px;'> &nbsp &nbsp <p> <input type='checkbox' name='account3' value='1' <?php if($account_zero_ammount==1){?> checked <?php } ?>> Check this if you want notifications (SMS and/or Email) to be sent to members when an invoice with zero outstanding and zero charges is raised.

 </p></span>
</td>
</tr>


<tr style='background-color:#fafafa !important;'>
<td>
<span style='color:#3B6B96;font-size: 16px;font-weight: bold;'>14. Should Tenants be given access to society portal. ? </span><br>
<span style='font-size:12px;'> &nbsp &nbsp <p> <input type='checkbox' name='access_tenant' value='1' <?php if($access_tenant==1){?> checked <?php } ?>> Check this if you want to give access to society portal.
 </p></span>

</td>
</tr>



<tr>
<td>
<span style='color:#3B6B96;font-size: 16px;font-weight: bold;'>15. Banned Words  </span><br><br>
<span style='font-size:12px;'> &nbsp &nbsp  <textarea rows='5' cols='7' style='resize:none;' name='banned'><?php echo $banned_word ; ?></textarea>
<p>Please specify the list of banned words seperated by commas. These words will not be allowed in input fields such as subject,descriptions of notices,forums,complaints etc. for your society.

 </p></span>
</td>
</tr>


<!--<tr>
<td>
<span style='color:#3B6B96;font-size: 16px;font-weight: bold;'>13. Society PAN # </span><br><br>
<span> &nbsp &nbsp  <input type='text'name='pan' value='<?php echo $society_pan ; ?>'>
 </p></span>
</td>
</tr>

<tr>
<td>
<span style='color:#3B6B96;font-size: 16px;font-weight: bold;'>14. Society Service Tax Number </span><br><br>
<span> &nbsp &nbsp  <input type='text'name='tax_num' value="<?php echo $society_tax ; ?> ">
 </p></span>
</td>
</tr>-->

<tr>
<td>
<input type='submit' name='sub' class='btn blue' value='Update Settings' >
</td>

</tr>

</table


</form>

<?php }
else
{
?><div style="min-height: 85%;margin-top: 60px; " align="center">
<h2>Sorry<br/>You are not allowed to access this page.</h2>
<img src="<?php echo $this->webroot ; ?>/as/hm/hm-logo.png" alt="logo" >
<br/><h4>Back to <a href="dashboard">Dashboard</a></h4>
</div>
<?php

} ?>


</div>
</div>
</div>