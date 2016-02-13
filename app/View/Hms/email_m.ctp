	if(($email!=$al_email) or ($mobile!=$al_mobile)){
				echo'ddgg';
			/////// Start email code 	
				$res_society=$this->society_name($s_society_id);
				foreach($res_society as $data){
				echo $society_name=$data['society']['society_name'];
				}
				$s_n='';
				$sco_na=$society_name;
				$dd=explode(' ',$sco_na);
				$first=$dd[0];
				@$two=$dd[1];
				@$three=$dd[2];
				$s_n.=" $first $two $three ";
				$ip=$this->hms_email_ip();
			
			
				$random1=mt_rand(1000000000,9999999999);
				$random2=mt_rand(1000000000,9999999999);
				$random=$random1.$random2 ;	
				$de_user_id=$this->encode($user_id,'housingmatters');
				$random=$de_user_id.'/'.$random;
			
				if(!empty($mobile) && empty($email)){
					$r_sms=$this->hms_sms_ip();
					$working_key=$r_sms->working_key;
					$sms_sender=$r_sms->sms_sender;
					$sms_allow=(int)$r_sms->sms_allow;

						$login_user=$mobile;
						$random=(string)mt_rand(1000,9999);
						if($sms_allow==1){
							
							$user_name_short=$this->check_charecter_name($name);
							$sms="".$user_name_short.", Your housing society ".$s_n." has enrolled you in HousingMatters portal. Pls log into www.housingmatters.in One Time Password ".$random."";
							$sms1=str_replace(" ", '+', $sms);
							$payload = file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms1.'');
							}
						}
			
	if(!empty($email) && !empty($mobile)){
		$login_user=$email;	
		   $message_web='<table  align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
			<tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						
								<tr>
									<td colspan="2">
										<table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%">
										<tbody>
										<tr><td style="line-height:16px" colspan="4" height="16">&nbsp;</td></tr>
										<tr>
										<td style="height:32;line-height:0px" align="left" valign="middle" width="32"><a href="#150d7894359a47c6_" style="color:#3b5998;text-decoration:none"><img class="CToWUd" src="'.$ip.$this->webroot.'as/hm/HM-LOGO-small.jpg" style="border:0" height="50" width="50"></a></td>
										<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
										<td width="100%"><a href="#150d7894359a47c6_" style="color:#3b5998;text-decoration:none;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:19px;line-height:32px"><span style="color:#00a0e3">Housing</span><span style="color:#777776">Matters</span></a></td>
										<td align="right"><a href="https://www.facebook.com/HousingMatters.co.in" target="_blank"><img class="CToWUd" src="'.$ip.$this->webroot.'as/hm/SMLogoFB.png" style="max-height:30px;min-height:30px;width:30px;max-width:30px" height="30px" width="30px"></a>
											
										</td>
										</tr>
										<tr style="border-bottom:solid 1px #e5e5e5"><td style="line-height:16px" colspan="4" height="16">&nbsp;</td></tr>
										</tbody>
										</table>
									</td>
								</tr>
								
									
								
						</tbody>
					</table>
					
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span style="color:rgb(100,100,99)" align="justify"> Dear '.$name.', </span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										 We at '.$society_name.' use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.
										
										
										
										
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										As you are an owner/resident/staff of '.$society_name.', we have added your email address in HousingMatters portal.
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
												Here are some of the important features related to our portal on HousingMatters:
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
												You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.
										</td>
																
								</tr>

									<tr>
									<td style="padding:5px;" width="100%" align="left">
									You can receive important SMS & emails from your committee.
									</td>

									</tr>
								<tr>
										<td style="padding:5px;" width="100%" align="left"><br/>
											<span  align="justify"> <b>
											<a href="'.$ip.$this->webroot.'hms/send_sms_for_verify_mobile?q='.$random.'"> Click here </a> for one time verification of your mobile number and Login into HousingMatters for making life simpler for all your housing matters!</b>
											</span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span align="justify"> Pls add www.housingmatters.in in your favorite bookmarks for future use. </span> 
										</td>
																
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span > 
												Regards,<br/>
												Administrator of '.$society_name.'<br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';
		
		}
			
if(!empty($email) && empty($mobile)){
		
  $message_web='<table  align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
			<tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						
								<tr>
									<td colspan="2">
										<table style="border-collapse:collapse" cellpadding="0" cellspacing="0" width="100%">
										<tbody>
										<tr><td style="line-height:16px" colspan="4" height="16">&nbsp;</td></tr>
										<tr>
										<td style="height:32;line-height:0px" align="left" valign="middle" width="32"><a href="#150d7894359a47c6_" style="color:#3b5998;text-decoration:none"><img class="CToWUd" src="'.$ip.$this->webroot.'as/hm/HM-LOGO-small.jpg" style="border:0" height="50" width="50"></a></td>
										<td style="display:block;width:15px" width="15">&nbsp;&nbsp;&nbsp;</td>
										<td width="100%"><a href="#150d7894359a47c6_" style="color:#3b5998;text-decoration:none;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:19px;line-height:32px"><span style="color:#00a0e3">Housing</span><span style="color:#777776">Matters</span></a></td>
										<td align="right"><a href="https://www.facebook.com/HousingMatters.co.in" target="_blank"><img class="CToWUd" src="'.$ip.$this->webroot.'as/hm/SMLogoFB.png" style="max-height:30px;min-height:30px;width:30px;max-width:30px" height="30px" width="30px"></a>
											
										</td>
										</tr>
										<tr style="border-bottom:solid 1px #e5e5e5"><td style="line-height:16px" colspan="4" height="16">&nbsp;</td></tr>
										</tbody>
										</table>
									</td>
								</tr>
								
									
								
						</tbody>
					</table>
					
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
						
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span style="color:rgb(100,100,99)" align="justify"> Dear '.$name.', </span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										We at '.$society_name.' use HousingMatters - a dynamic web portal to interact with all owners/residents/staff for transparent & smart management of housing society affairs.
										
										
										
										
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										As you are an owner/resident/staff of '.$society_name.', we have added your email address in HousingMatters portal.
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
												Here are some of the important features related to our portal on HousingMatters:
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
												You can log & track complaints, start new discussions, check your dues, post classifieds and many more in the portal.
										</td>
																
								</tr>

									<tr>
									<td style="padding:5px;" width="100%" align="left">
									You can receive important SMS & emails from your committee.
									</td>

									</tr>
								<tr>
										<td style="padding:5px;" width="100%" align="left"><br/>
											<span  align="justify"> <b>
											<a href="'.$ip.$this->webroot.'hms/set_new_password?q='.$random.'"> Click here </a> for one time verification of your email and Login into HousingMatters for making life simpler for all your housing matters!</b>
											</span> 
										</td>
																
								</tr>
								
								<tr>
										<td style="padding:5px;" width="100%" align="left">
										<span align="justify"> Pls add www.housingmatters.in in your favorite bookmarks for future use. </span> 
										</td>
																
								</tr>
								
								<tr>
									<td style="padding:5px;" width="100%" align="left">
											<span > 
												Regards,<br/>
												Administrator of '.$society_name.'<br/>
												www.housingmatters.in
											</span>
									</td>
																
								</tr>
					
					</table>
					
				</td>
			</tr>

        </tbody>
</table>';
			
}	

			$from_name="HousingMatters";
			$reply="support@housingmatters.in";
			$to=$email;
			$this->loadmodel('email');
			$conditions=array("auto_id" => 4);
			$result_email = $this->email->find('all',array('conditions'=>$conditions));
			foreach ($result_email as $collection) 
			{
			 $from=$collection['email']['from'];
			}
			 $subject="Welcome to ".$society_name." portal ";
			if(!empty($email))
			{
			$this->send_email($to,$from,$from_name,$subject,@$message_web,$reply);
			}
			
	/////// End code ///////		
   }	