<?php
$app_id = get_option('xyz_smap_application_id');
$app_secret = get_option('xyz_smap_application_secret');
$redirecturl=admin_url('admin.php?page=social-media-auto-publish-settings&auth=1');
$lnredirecturl=admin_url('admin.php?page=social-media-auto-publish-settings&auth=3');
$my_url=urlencode($redirecturl);

session_start();
$code="";
if(isset($_REQUEST['code']))
$code = $_REQUEST["code"];

if(isset($_POST['fb_auth']))
{
		$xyz_smap_session_state = md5(uniqid(rand(), TRUE));
		setcookie("xyz_smap_session_state",$xyz_smap_session_state,"0","/");
		
		$dialog_url = "https://www.facebook.com/".XYZ_SMAP_FB_API_VERSION."/dialog/oauth?client_id="
		. $app_id . "&redirect_uri=" . $my_url . "&state="
		. $xyz_smap_session_state . "&scope=email,user_about_me,offline_access,publish_stream,publish_actions,manage_pages";
		
		header("Location: " . $dialog_url);
}


if(isset($_COOKIE['xyz_smap_session_state']) && isset($_REQUEST['state']) && ($_COOKIE['xyz_smap_session_state'] === $_REQUEST['state'])) {
	
	$token_url = "https://graph.facebook.com/".XYZ_SMAP_FB_API_VERSION."/oauth/access_token?"
	. "client_id=" . $app_id . "&redirect_uri=" . $my_url
	. "&client_secret=" . $app_secret . "&code=" . $code;
	
	$params = null;$access_token="";
	$response = wp_remote_get($token_url);
	
	if(is_array($response))
	{
		if(isset($response['body']))
		{
			parse_str($response['body'], $params);
			if(isset($params['access_token']))
			$access_token = $params['access_token'];
		}
	}
	
	if($access_token!="")
	{
		update_option('xyz_smap_fb_token',$access_token);
		update_option('xyz_smap_af',0);
		
		
		$offset=0;$limit=100;$data=array();
		$fbid=get_option('xyz_smap_fb_id');
		do
		{
			$result1="";$pagearray1="";
			$pp=wp_remote_get("https://graph.facebook.com/".XYZ_SMAP_FB_API_VERSION."/me/accounts?access_token=$access_token&limit=$limit&offset=$offset");
			if(is_array($pp))
			{
				$result1=$pp['body'];
				$pagearray1 = json_decode($result1);
				if(is_array($pagearray1->data))
					$data = array_merge($data, $pagearray1->data);
			}
			else
				break;
			$offset += $limit;
			if(!is_array($pagearray1->paging))
				break;
		}while(array_key_exists("next", $pagearray1->paging));
		
		
		
		
		$count=count($data);
			
		$smap_pages_ids1=get_option('xyz_smap_pages_ids');
		$smap_pages_ids0=array();$newpgs="";
		if($smap_pages_ids1!="")
			$smap_pages_ids0=explode(",",$smap_pages_ids1);
		
		$smap_pages_ids=array();$profile_flg=0;
		for($i=0;$i<count($smap_pages_ids0);$i++)
		{
		if($smap_pages_ids0[$i]!="-1")
			$smap_pages_ids[$i]=trim(substr($smap_pages_ids0[$i],0,strpos($smap_pages_ids0[$i],"-")));
			else{
			$smap_pages_ids[$i]=$smap_pages_ids0[$i];$profile_flg=1;
			}
		}
		
		for($i=0;$i<$count;$i++)
		{
		if(in_array($data[$i]->id, $smap_pages_ids))
			$newpgs.=$data[$i]->id."-".$data[$i]->access_token.",";
		}
					$newpgs=rtrim($newpgs,",");
					if($profile_flg==1)
						$newpgs=$newpgs.",-1";
					update_option('xyz_smap_pages_ids',$newpgs);
	}
	else {
		
		$xyz_smap_af=get_option('xyz_smap_af');
		
		if($xyz_smap_af==1){
			header("Location:".admin_url('admin.php?page=social-media-auto-publish-settings&msg=3'));
			exit();
		}
	}
}
else {
	
	//header("Location:".admin_url('admin.php?page=social-media-auto-publish-settings&msg=2'));
	//exit();
}


if(isset($_POST['lnauth']))
{
	
	$redirecturl=admin_url('admin.php?page=social-media-auto-publish-settings&auth=3');
	$lnappikey=get_option('xyz_smap_lnapikey');
	$lnapisecret=get_option('xyz_smap_lnapisecret');
	
	# First step is to initialize with your consumer key and secret. We'll use an out-of-band oauth_callback
	$API_CONFIG = array(
	'appKey'       => $lnappikey,
	'appSecret'    => $lnapisecret,
	'callbackUrl'  => $redirecturl
	);

	$OBJ_linkedin = new SMAPLinkedIn($API_CONFIG);
	$response = $OBJ_linkedin->retrieveTokenRequest();
	
	if(isset($response['error']))
	{
		header("Location:".admin_url('admin.php?page=social-media-auto-publish-settings&msg=1'));
		exit();
	}

	$lnoathtoken=$response['linkedin']['oauth_token'];
	$lnoathseret=$response['linkedin']['oauth_token_secret'];
	

	# Now we retrieve a request token. It will be set as $linkedin->request_token

	update_option('xyz_smap_lnoauth_token', $lnoathtoken);
	update_option('xyz_smap_lnoauth_secret',$lnoathseret);
	header('Location: ' . SMAPLinkedIn::_URL_AUTH . $response['linkedin']['oauth_token']);
	die;
}

if(isset($_GET['auth']) && $_GET['auth']==3)
{
	if(isset($_GET['auth_problem']))
		break;
	$lnoathtoken=get_option('xyz_smap_lnoauth_token');
	$lnoathseret=get_option('xyz_smap_lnoauth_secret');
	 
	$lnappikey=get_option('xyz_smap_lnapikey');
	$lnapisecret=get_option('xyz_smap_lnapisecret');

	$lnoauth_verifier=$_GET['oauth_verifier'];


	update_option('xyz_smap_lnoauth_verifier',$lnoauth_verifier);

	$API_CONFIG = array(
			'appKey'       => $lnappikey,
			'appSecret'    => $lnapisecret,
			'callbackUrl'  => $lnredirecturl
	);

	$OBJ_linkedin = new SMAPLinkedIn($API_CONFIG);
	$response = $OBJ_linkedin->retrieveTokenAccess($lnoathtoken, $lnoathseret, $lnoauth_verifier);

	# Now we retrieve a request token. It will be set as $linkedin->request_token
	update_option('xyz_smap_application_lnarray', $response['linkedin']);	
	update_option('xyz_smap_lnaf',0);

}

?>