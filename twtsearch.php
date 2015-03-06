<?php
//require(dirname(__FILE__).'/includes/app.config.php');
require(dirname(__FILE__).'/includes/conexion.php');
require(dirname(__FILE__).'/twitteroauth/twitteroauth.php');

//require(dirname(__FILE__).'/includes/twitteroauth.php');
//require(dirname(__FILE__).'/includes/OAuth.php');
?>

<?php

//require_once 'twitteroauth/twitteroauth.php';
 
define('CONSUMER_KEY', '');
define('CONSUMER_SECRET', '');
define('ACCESS_TOKEN', '');
define('ACCESS_TOKEN_SECRET', '');
 
function search(array $query)
{
  $toa = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
  return $toa->get('search/tweets', $query);
}

//foreach ($results->statuses as $result) {
//  echo $result->user->screen_name . ": " . $result->text . "\n";
//}

$query="SELECT max_twt_id FROM max_id WHERE id = 1";
$reply=mysql_query($query,$conn);
$filter_maxid=mysql_fetch_assoc($reply);
$params = "include_entities=false&result_type=mixed";
$params .= "&rpp=".RPP."&since_id=".$filter_maxid['max_twt_id'];
$sql_key = "SELECT twt_keyword FROM `twt_keywords`";
$keywords = mysql_query($sql_key,$conn);
if (mysql_num_rows($keywords)==0) die("[ ".date('Y-m-d h:i:s')." ] Nothing to do\r\n");

while ($kw = mysql_fetch_assoc($keywords)) {
	$query1 = array(
	  "q" => $kw['twt_keyword'] . 'palabra a buscar'
	);

	$results = search($query1);
	//var_dump($results);
		
		if (!empty($results)) {
			$max_id = $data->max_id;
			$query1="UPDATE max_id SET max_twt_id = '$max_id'";
			$reply1=mysql_query($query1,$conn);
			foreach ($results as $key => $value) {
			if (is_object($value)) continue;
			else 
				foreach ($value as $row) {
				//$row = $value[0];
				//echo PHP_EOL . "===========" . PHP_EOL;
						
				$id_str = $row->id_str;
				$from_user = $row->user->screen_name;
				$from_user_id = $row->user->id;
				$from_img = $row->user->profile_image_url;
				$text = $row->text;
				$fecha = $row->created_at;
				$query2="INSERT IGNORE INTO 
				  twts (
				      from_name,
				      from_id,
				      twt_id,
				      twt_text,
				      twt_user_img,
				      twt_keyword,
				      twt_date)
				  VALUES (
				      '$from_user',
				      '$from_user_id',
				      '$id_str',
				      '".mysql_real_escape_string($text)."',
				      '".$from_img."',
				      '".mysql_real_escape_string($kw['twt_keyword'])."',
				      '$fecha'
				  )";
				 $reply2 = mysql_query($query2) or die("[ ".date('Y-m-d h:i:s')." ] Error MySQL ".mysql_error()." \n");
				}
			}  
		} else {
			echo "[ ".date('Y-m-d h:i:s')." ] No hay resultados para ".$kw['twt_keyword']." \n";
		}
		
}
?>
