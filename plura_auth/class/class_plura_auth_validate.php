<?php 
class Plura_auth_validate
{
	public $Auth;							//auth cookie
	
	function __construct()
	{	
	}
	
	//plura auth cookie check
	function getAuthCookieValue()
	{
		$this->Auth	= $_COOKIE[PLURA_AUTH_COOKIE];
		return $this->Auth;
	}
	
	//auth value validation
	function getAuthCookieValidation()
	{
		if (empty($this->Auth))	return false;
		
		$oCurl			= curl_init();
		/*
		 * must be changed by your auth api spec
		 */
		$sPostVal		= '##cookieparametername##='.$this->Auth;	//parameter
		$aReturnData	= $this->setCurl_post($oCurl, PLURA_AUTH_DECRYPT_URL, $sPostVal);
		
		return $aReturnData;
	}
	
	//curl method
	function setCurl_post($curl, $url, $val='')
	{
		@curl_setopt($curl, CURLOPT_URL, $url);
		@curl_setopt($curl, CURLOPT_POST, count($val));
		@curl_setopt($curl, CURLOPT_POSTFIELDS, $val);
		@curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
		@curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		@curl_setopt($curl, CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1" );
// 		@curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		@curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
		@curl_setopt($curl, CURLOPT_TIMEOUT, 3);
	
		$data = @curl_exec($curl);
		@curl_close ($curl);
	
		return $data;
	}
}
?>