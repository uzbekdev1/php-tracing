<?php  
  
  $logs='-------------'.date('Y-m-d H:i:s').'------------------';    
  $logs.="\r\n";

  $logs.='Remote IP:'. (isset($_GET['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP']: $_SERVER['REMOTE_ADDR']);
  $logs.="\r\n";
  
  $logs.='Request Method:'. $_SERVER['REQUEST_METHOD'];
  $logs.="\r\n";
  
  $logs.='Request URL:'. $_SERVER['REQUEST_URI'];
  $logs.="\r\n";
  
  $logs.='User agent:';
  $logs.="\r\n";
  $logs.= '  '.$_SERVER['HTTP_USER_AGENT'];
  $logs.="\r\n";

  $logs.='Headers:';
  $logs.="\r\n";
  
  // php 5.2
	if (!function_exists('getallheaders'))
	{
		function getallheaders()
		{
		   $headers = Array();
		   foreach ($_SERVER as $name => $value)
		   {
			   if (substr($name, 0, 5) == 'HTTP_')
			   {
				   $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
			   }
		   }
		   return $headers;
		}
	}

  // php 5.4
  foreach (getallheaders() as $name => $value) {
    $logs.='  '.$name.':'. $value;
    $logs.="\r\n";
  }
  $logs.="\r\n";

  $logs.='Post data:'; 
  $logs.="\r\n";
  $logs.=json_encode(file_get_contents('php://input'));   
  $logs.="\r\n";
    
  $logs.='---------------------------------------------------';    
  $logs.="\r\n";  
  
  $path='./logs/'.date('Y').'/'.date('m').'/'.date('d');
  if (!file_exists($path)) {
    mkdir($path,0755, true);
  }
  file_put_contents($path.'/access.log',$logs,FILE_APPEND); 
?>
