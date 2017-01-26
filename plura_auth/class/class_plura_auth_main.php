<?php 
//main
class Plura_auth_main
{
	
	function __construct() 
	{
		add_action( 'init', array($this, 'setSession_init') );
		add_action( 'init', array($this, 'getLoginCheck') );		//login check
		add_action( 'wp_logout', array($this, 'setLogOut') );	//logout
	}
	
	function setSession_init() 
	{
		if( !session_id() && !headers_sent() ) 
		{
			session_start();
		}
	}
	
	// If not wordpress user, create one.
	function getLoginCheck()
	{
		if (!is_user_logged_in())
		{
			$oPal	= new Plura_auth_validate();
			$sAuth	= $oPal->getAuthCookieValue();		//auth cookie
			
			$aAuthData		= $oPal->getAuthCookieValidation();	//auth cookie값 검증 
			$bAuthCheck	= (@$aAuthData->status == '1') ? true : false;

			if ($bAuthCheck)
			{
				$aUser	= get_user_by('login', $aAuthData->email);
				
				// if not wordpress user
				if (!$aUser)
				{
					// create user
					$this->setCreateUser($aAuthData);
					$aUser	= get_user_by('login', $aAuthData->email);
				}

				//forum login
				wp_clear_auth_cookie();
				wp_set_auth_cookie( $aUser->data->ID, true );
				wp_set_current_user( $aUser->data->ID );
				
				//session insert
				$_SESSION['name']		= $aAuthData->name;
				$_SESSION['cname']	= $aAuthData->cname;
				
				wp_redirect( home_url() );
			}
			else 
			{
				//invalid cookie 
				wp_clear_auth_cookie();
			}
		}
	}
	
	//reset cookie when logout
	function setLogOut()
	{
		if (isset($_COOKIE))
		{
			foreach($_COOKIE as $key => $val)
			{
				@setcookie($key, '', time()-3600, '/', PLURA_AUTH_DOMAIN);
			}
		}
		
		if (isset($_SESSION))
		{
			@session_destroy();
		}
	}
	
	//wordpress user creation
	function setCreateUser(&$aAuthData)
	{
		$sRandom_pw	= wp_generate_password( 12, false );
		$user_id 		= wp_create_user( $aAuthData->email, $sRandom_pw );
		$user_nicename	= $aAuthData->name;
		
		//in case of username with non numeric character
		if (preg_match("/[^0-9a-zA-Z]/", $user_nicename))
		{
			$aUser_nicename	= explode("@", $aAuthData->email);
			$user_nicename	= $aUser_nicename[0];
		}

		//wordpress update user
		wp_update_user( array('ID' => $user_id, 'display_name' => $aAuthData->name, 'user_nicename' => $user_nicename, 'user_email' => $aAuthData->email) );
		
	}	
}
?>