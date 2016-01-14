<?php
//Check if we have received a connection_token
		if ( ! empty ($_POST['connection_token']))
		{
		  //Get connection_token
		  $token = $_POST['connection_token'];
		 
		  //Your Site Settings
		  $site_subdomain = 'housingmattersapp';
		  $site_public_key = '2b2ee522-c2a2-42a8-8e80-a608bc75524c';
		  $site_private_key = 'f2c95a8d-76a4-4337-9c6d-e73365695e1c';
		 
		  //API Access domain
		  $site_domain = $site_subdomain.'.api.oneall.com';
		 
		  //Connection Resource
		  //http://docs.oneall.com/api/resources/connections/read-connection-details/
		  $resource_uri = 'https://'.$site_domain.'/connections/'.$token .'.json';
		 
		  //Setup connection
		  $curl = curl_init();
		  curl_setopt($curl, CURLOPT_URL, $resource_uri);
		  curl_setopt($curl, CURLOPT_HEADER, 0);
		  curl_setopt($curl, CURLOPT_USERPWD, $site_public_key . ":" . $site_private_key);
		  curl_setopt($curl, CURLOPT_TIMEOUT, 15);
		  curl_setopt($curl, CURLOPT_VERBOSE, 0);
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
		  curl_setopt($curl, CURLOPT_FAILONERROR, 0);
		 
		  //Send request
		  $result_json = curl_exec($curl);

		  //Error
		  if ($result_json === false)
		  {
			//You may want to implement your custom error handling here
			echo 'Curl error: ' . curl_error($curl). '<br />';
			echo 'Curl info: ' . curl_getinfo($curl). '<br />';
			curl_close($curl);
		  }
		  //Success
		  else
		  {
			//Close connection
			curl_close($curl);
		 
			//Decode
			$json = json_decode ($result_json);
		 
			//Extract data
			$data = $json->response->result->data;
			 
			//Check for service
			switch ($data->plugin->key)
			{
			  //Social Login
			  case 'social_login':
			   
			  //Single Sign On
			  case 'single_sign_on':
					 
				//Operation successfull
				if ($data->plugin->data->status == 'success')
				{
				  //The user_token uniquely identifies the user 
				  //that has connected with his social network account
				  $user_token = $data->user->user_token;
				   
				  //The identity_token uniquely identifies the social network account 
				  //that the user has used to connect with
				  $identity_token = $data->user->identity->identity_token;       
					
				 
					$emails = $data->user->identity->emails;
					foreach($emails as $email){
						 $user_email=$email->value;
					}
					
					$this->requestAction(array('controller' => 'Hms', 'action' => 'login_user_to_app'), array('pass' => array($user_email)));
					
					
					
				  // 2) You have either created a new user or read the details of an existing
				  // user from your database. In both cases you should now have a $user_id 
				   
				  // 2a) Create a Single Sign On session
				  // $sso_session_token = GenerateSSOSessionToken ($user_token, $identity_token); 
				  // If you would like to use Single Sign on then you should now call our API
				  // to generate a new SSO Session: http://docs.oneall.com/api/resources/sso/
							 
				  // 2b) Login this user
				  // You now need to login this user, exactly like you would login a user
				  // after a traditional (username/password) login (i.e. set cookies, setup 
				  // the session) and forward him to another page (i.e. his account dashboard)    
				}
			  break;
			}
		  }
		}
?>