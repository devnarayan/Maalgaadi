<?php
class common
{
	function sanitize($input) {
		return mysql_real_escape_string(trim($input));
	}

	function getLoadJs($array)
	{
	}
	
	function getLoadCss($array)
	{
	}

	function checkEmail($emailid)
	{
		if(!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$emailid)) {
			return "no";
		} else {
			return "yes";
		}
	}
	
	function getEncryptPassword($password)
	{
		return base64_encode($password);
	}
	
	function getDecryptPassword($passowrd)
	{
		echo base64_decode($passowrd);
	}
	
	function currentDate()
	{
		return date('Y-m-d');
	}

	function currentTime()
	{
		return date("G:i:s");
	}

    function currentTimestamp() 
	{
        return $this->currentDate() . " " . $this->currentTime();
    }

    function randomkeys($length=8) 
	{
        $pattern = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        for ($i = 0; $i < $length; $i++) 
		{
            $key.= $pattern{rand(0, 62)};
        }
        return $key;
    }

    function curPageURL() 
	{
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

    function subString($str, $strlen, $strpos=0) {
        if (strlen($str) > $strlen)
            return substr(strip_tags(html_entity_decode($str)), $strpos, $strlen) . "...";
        else
            return strip_tags(html_entity_decode($str));
    }

    function getJavaScripRedirect($url) {
        echo "<script>window.location.href='".$url."'</script>";
    }


    public function debugArray($array,$die=0){
        print("<pre>");
        print_r($array);
        print("</pre>");
        if($die==1) {
            die();
		}
    }

	function getShowDateFormat($date)
	{
		$exp=explode("-",$date);
		$year=$exp[0];
		$month=$exp[1];
		$day=$exp[2];
	
		if($year>0 && $month>0)
		{	
			$date=date("d M Y",mktime(0,0,0,$month,$day,$year));
			$return=$date;
		}
		else
		{
			$return='';
		}
		return $return;
	}
	
	function getShowDateFormatByTime($time)
	{
		$date=date("Y-m-d",$time);
		return $this->getShowDateFormat($date);
	}

	function getMonthList($month='')
	{
		$montharray=array("January","February","March","April","May","June","July","August","September","Octomber","November","December");
		$return='';
		$return.='<select name="month_list" id="bmonth">';
		$return.='<option value="">Month:</option>';
		foreach($montharray as $key=>$value)
		{
			$key=$key+1;
			if($key<9) { $key="0".$key; }
			if($month==$key) {
				$return.='<option value="'.$key.'" selected="true">'.$value.'</option>';
			} else {
				$return.='<option value="'.$key.'">'.$value.'</option>';
			}
		}
		$return.='</select>';
		return $return;
	}

	function getDayList($day='')
	{
		$noday=31;
		$string='<select name="day_list" id="bday">';
		$string.='<option value="">Day:</option>';
		for($i=1;$i<=$noday;$i++)
		{
			if($i<10) {
				$i="0".$i;
			}

			if($day==$i) {
				$string.='<option value="'.$i.'" selected="true">'.$i.'</option>';
			} else {
				$string.='<option value="'.$i.'">'.$i.'</option>';
			}
		}
		$string.='</select>';
		return $string;
	}

	function getOption($key)
	{
		$return='';
		$fetch=mysql_query("select option_value from tbl_setting where option_name='".$key."' ");
		if(is_resource($fetch) && mysql_num_rows($fetch)>0)
		{
			$result=mysql_fetch_array($fetch);
			$return=$result['option_value'];
		}
		return $return;
	}
	
	function getAllOption()
	{
		$settingdata=array();
		$setting=mysql_query("select * from tbl_setting ");
		if(is_resource($setting) && mysql_num_rows($setting)>0)
		{
			$settingdata=array();
			while($data=mysql_fetch_array($setting))
			{
				$settingdata[$data['option_name']]=$data['option_value'];
			}
		}
		return $settingdata;
	}
	
	function getYearList($year='')
	{
		$startyear=$this->getOption('dob_start_year');
		$stopyear=$this->getOption('dob_end_year');
		$string='<select name="year_list" id="byear">';
		$string.='<option value="">Year:</option>';
		for($i=$stopyear;$i>=$startyear;$i--)
		{
			if($year==$i) {
				$string.='<option value="'.$i.'" selected="true">'.$i.'</option>';
			} else {
				$string.='<option value="'.$i.'">'.$i.'</option>';
			}
		}
		$string.='</select>';
		return $string;
	}
	
	function getBirthDay($date='')
	{
		if($date!='')
		{
			$exp=explode("-",$date);
		}
	
		$return='';
		$return.=$this->getMonthList($exp[1]);
		$return.=$this->getDayList($exp[2]);
		$return.=$this->getYearList($exp[0]);
		
		return $return;
	}

	function getExt($filename)
	{
		$end='';
		if($filename!='')
		{
			$exp=explode(".",$filename);
			if(is_array($exp) && !empty($exp))
			{
				$end=end($exp);
			}
		}
		return $end;
	}

	function audiotype($end)
	{
		$end=strtolower(trim($end));
		if($end=="mp3" || $end=="ogg" || $end=="3gp" || $end=="wma" || $end=="wav") {
			$return1 = true;
		} else {
			$return1 = false;
		}
		return $return1;
	}
	
	function videotype($end)
	{
		//mpeg , avi , 3gp add this format also.
		$end=strtolower(trim($end));
		if($end=="flv" || $end=="webm" || $end=="mp4" || $end=="mov" || $end=="f4v" || $end=="m4v")
		{
			$return2 = true;	
		} else {
			$return2 = false;	
		}
		return $return2;
	}

	function getSupprtedImage($end)
	{
		$end=strtolower(trim($end));
		if($end=="jpeg" || $end=="png" || $end=="jpg" || $end=="gif") {
			$return = true;	
		} else {
			$return = false;
		}
		return $return;
	}
	
	function getEmailTemplate($message)
	{
	//$str='<table width="650" align="center" cellspacing="0" cellpadding="0" border="0" style="border:10px solid #c8e5f6; margin-top:50px;margin-bottom:20px;"><tr><td width="275" valign="middle" align="left" style="padding:15px 30px; background:#effaff; border-bottom:2px solid #c8e5f6;"><img width="177" height="72" alt="priceperlink" src="http://www.priceperlink.com/link-building-submission-service/images/email-template/email-logo.png"></td><td valign="middle" align="right" style="font-family:Arial;font-size:14px;color:#555555;padding:15px 30px;  background:#effaff; border-bottom:2px solid #c8e5f6; border-bottom:2px solid #c8e5f6;">&nbsp;</td></tr><tr><td colspan="2"><table width="95%" cellpadding="0" cellspacing="0" border="0" align="center" style="font:14px Georgia, \'Times New Roman\', Times, serif; color:#000000; line-height:18px; margin-bottom:0;margin-top:0.5em"><tr><td colspan="2"><p>'.$message.'</p></td></tr><tr><td colspan="2">&nbsp;</td></tr><tr><td colspan="2"><table width="100%" cellpadding="10" cellspacing="0" border="0" align="center" bgcolor="#FFF" style="border:1px solid #c4e4f2"><tr><td valign="top" align="left"><p style="font:16px Georgia, \'Times New Roman\', Times, serif; font-style:italic; margin-left:10px; padding:0;">Call Now : +1- 828-393-9397</p></td><td valign="top" align="right"><p style="font:16px Georgia, \'Times New Roman\', Times, serif; font-style:italic; margin-left:10px; padding:0;"><a target="_blank" style="color:#0093d0;text-decoration:none" href="http://www.priceperlink.com">Learn how</a></p></td></tr></table></td></tr></table></td></tr><tr><td colspan="2">&nbsp;</td></tr></table>';
	return $message;
	}
	
	function sendmail($toemail,$subject,$msgbody,$from='')
	{
		$adminemail=$this->getAdminDetails();
		$emailfrom='<Management FunAfrique> info@funafrique.com';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:'.$emailfrom."\r\n";
		$msgbody=$this->getEmailTemplate($msgbody);
		@mail($toemail, $subject, $msgbody, $headers);
	}
	
	function getAdminDetails()
	{
		$fetch=mysql_query("select * from admin_info where admin_id=1 limit 0,1 ");
		$result=mysql_fetch_array($fetch);
		return $result;
	}	

	function mail_attachment($to,$subject,$message,$attachment,$from='')
	{
		$adminemail=$this->getAdminDetails();
		$email_from=$adminemail['email'];
		$email_message = 0;
		$fileatt = $attachment; // Path to the file
		$fileatt_type = "application/octet-stream"; // File Type
		$start=	strrpos($attachment, '/') == -1 ? strrpos($attachment, '//') : strrpos($attachment, '/')+1;
		$fileatt_name = substr($attachment, $start, strlen($attachment)); // Filename that will be used for the file as the 	attachment
	
		$email_subject =  $subject; // The Subject of the email
	
		//$email_txt=$message; // Message that the email has in it
		$email_txt=$this->getEmailTemplate($message);
	
	
		$email_to = $to; // Who the email is to
		$headers = "From: ".$email_from;
	
		$file = fopen($fileatt,'rb');
		$data = fread($file,filesize($fileatt));
		fclose($file);
		$msg_txt="";
		
		$semi_rand = md5(time());
		$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
		
		$headers .= "\nMIME-Version: 1.0\n" .
		"Content-Type: multipart/mixed;\n" .
		" boundary=\"{$mime_boundary}\"";
		
		$email_txt .= $msg_txt;
		
		$email_message .= "This is a multi-part message in MIME format.\n\n" .
		"--{$mime_boundary}\n" .
		"Content-Type:text/html; charset=\"iso-8859-1\"\n" .
		"Content-Transfer-Encoding: 7bit\n\n" .
		$email_txt . "\n\n";
	
		$data = chunk_split(base64_encode($data));
	
		$email_message .= "--{$mime_boundary}\n" .
		"Content-Type: {$fileatt_type};\n" .
		" name=\"{$fileatt_name}\"\n" .
		"Content-Disposition: attachment;\n" .
		" filename=\"{$fileatt_name}\"\n" .
		"Content-Transfer-Encoding: base64\n\n" .
		$data . "\n\n" .
		"--{$mime_boundary}--\n";
		
		$ok = @mail($email_to, $email_subject, $email_message, $headers);
	}
	
	/*  shivkumar yadav 14 march start here */
	function getCountryList($country='')
	{
		$return='';
		$query=mysql_query('Select *from tbl_countries order by country_name asc');
		while($data=mysql_fetch_array($query))
		{
			if($data['country_id']==$country) {
				$return.='<option value="'.$data['country_id'].'" selected="true">'.$data["country_name"].'</option>';
			} else {
				$return.='<option value="'.$data['country_id'].'">'.$data["country_name"].'</option>';
			}
		}
		return $return;
	}
	
	function checkProfileImage($imagename)
	{
		if($imagename!='' && is_file(PROFILE_IMAGE_LOC."thumbs/".$imagename) && file_exists(PROFILE_IMAGE_LOC."thumbs/".$imagename)) {
			$return=PROFILE_IMAGE_URL."thumbs/".$imagename;
		} else {
			$return='';
		}
		return $return;
	}

	function getCurrentUserRatingById($userid)
	{
		$average=0;
		$sql=mysql_query("select * from tbl_rating where rated_userid='".$userid."' ");
		$count=mysql_num_rows($sql);
		if($sql && $count>0 && is_resource($sql))
		{
			$total=0; 
			while($result=mysql_fetch_object($sql))
			{
				$rating=$result->rating;
				$total=$total+$rating;
			}
			$average=($total/$count);
		}
		
		if($average>5) {
			$average=5;
		}
		
		if($average<0) {
			$average=0;
		}
		
		if($average<1) {
			$average=2;
		}
		return number_format($average,2);
	}
	
	function getRatingPercentage($rating)
	{
		$per=0;
		if($rating>0)
		{
			$per=(($rating/5)*100);
		}
		return $per;
	}	
	/*  shivkumar yadav 14 march end here */
	
	function getAlbumName($albumid)
	{
		$albumname='';
		if($albumid!='')
		{
			$sql=mysql_query("select album_title from tbl_album where album_id='".$albumid."' ");
			if(is_resource($sql) && mysql_num_rows($sql)>0)
			{
				$result=mysql_fetch_array($sql);
				$albumname=$result['album_title'];
			}
		}
		return $albumname;
	}
	
	function getAlbumCount($userid)
	{
			$count=0;
			$fetch=mysql_query("select count(album_id) as count_album from tbl_album where user_id='".$userid."' and album_status='".$status."' ");
		if(is_resource($fetch) && mysql_num_rows($fetch))
		{
			$result=mysql_fetch_array($fetch);
			$count=$result['count_album'];
		}
		return $count;

	}
	function getPhotoCount($albumid)
	{
			$count=0;
			$result_set = mysql_query("select count(upload_id) as count_photo from user_uploads where album_id='".$albumid."' and upload_type='image'");
			if(is_resource($result_set) && mysql_num_rows($result_set))
			{
					$result=mysql_fetch_array($result_set);
					$count= $result['count_photo'];
			}
		return $count;
	}
	
	function getRemoveDir($dir)
	{
		foreach(glob($dir . '/*') as $file) 
		{ 
			if(is_dir($file)) { 
				$this->getRemoveDir($file); 
			} else { 
				unlink($file); 
			}	
		} 	@rmdir($dir); 		
	}

	function getFriendRequestStatus($sentby,$sentto,$caption='')
	{
		$fetch=mysql_query("select * from tbl_friend_request where ( request_sent_by_userid='".$sentby."' and request_sent_to_userid='".$sentto."' )
		or ( request_sent_to_userid='".$sentby."' and request_sent_by_userid='".$sentto."' ) ");
		if(mysql_num_rows($fetch)>0)
		{
			$result=mysql_fetch_array($fetch);
			if($result['reply']==1) {
				$caption='Already friend';
			} elseif($result['reply']==2) {
				$caption='Blocked';
			} elseif($result['reply']==3) {
				$caption='<a href="javascript:void(0);" class="send_friend_request" id="user_'.$sentto.'" name="'.$sentto.'" title="'.$sentby.'">Decline</a>';
			} else {
				$caption='Friend request sent';
			}
		}
		else
		{
			$caption='<a href="javascript:void(0);" class="send_friend_request add-friend-link" id="user_'.$sentto.'" name="'.$sentto.'" title="add-friend">
			Add friend</a>';
		}
		return $caption;
	}
	
	function getFriendRrequestCount($userid,$type='')
	{
		$count=0;
		if($type=='sent') {
			$sql=mysql_query("select count(frid) as count_results from tbl_friend_request where request_sent_by_userid='".$userid."' and reply=0 ");
		} elseif($type=='get') {
			$query = "select count(frid) as count_results from tbl_friend_request where request_sent_to_userid='".$userid."' and reply=0 ";
			$sql=mysql_query($query);
		} else {
			$sql='';
		}
		if(is_resource($sql) && mysql_num_rows($sql))
		{
			$result=mysql_fetch_array($sql);
			$count=$result['count_results'];
		}
		return $count;
	}
	
	function getFriendsIdsByUserId($userid)
	{
		$implode='';
		$useridlist=array();
		if($userid!='') 
		{
			$fetch=mysql_query("select * from tbl_friend_request where ( request_sent_by_userid='".$userid."' or request_sent_to_userid='".$userid."' ) 
			and reply='1' ");
			if($fetch && mysql_num_rows($fetch))
			{
				while($result=mysql_fetch_array($fetch))
				{
					$useridlist[]=$result['request_sent_by_userid'];
					$useridlist[]=$result['request_sent_to_userid'];
				}
			}
			$useridlist=array_unique($useridlist);
			$ok=array_search($userid,$useridlist);
			unset($useridlist[$ok]);
			$implode=implode(",",$useridlist);
		}
		return $implode;
	}
	
	function getFriendCount($userid,$status=1)
	{
		$count=0;
		if($status!='') {
			$fetch=mysql_query("select count(frid) as count_friend from tbl_friend_request where ( request_sent_by_userid='".$userid."' or request_sent_to_userid='".$userid."' ) 			and reply='".$status."' ");
		}
		if(is_resource($fetch) && mysql_num_rows($fetch))
		{
			$result=mysql_fetch_array($fetch);
			$count=$result['count_friend'];
		}
		return $count;
	}

	function getUserDetailsByUserId($userid,$type='array')
	{
		$userdetails='';
		if($userid!='')
		{
			$fetch=mysql_query("select * from tbl_users where userid='".$userid."' ");
			if(is_resource($fetch) && mysql_num_rows($fetch)>0)
			{
				if($type=='object') {
					$userdetails=mysql_fetch_object($fetch);
				} else {
					$userdetails=mysql_fetch_array($fetch);
				}
			}
		}
		return $userdetails;
	}

	function getMessageCount($userid,$type='inbox')
	{
		$count=0;
		if($type=='inbox') {
			$fetch=mysql_query("select * from tbl_message where message_sent_to_userid='".$userid."' and message_status='unread' and message_sent_to_status!=2 ");
		} elseif($type=='outbox') {
			$fetch=mysql_query("select * from tbl_message where message_sent_by_userid='".$userid."' and message_sent_by_status!=2 ");
		} else {
			$fetch=mysql_query("select * from tbl_message where message_sent_by_userid='".$userid."'");
		}
		if(is_resource($fetch) && mysql_num_rows($fetch)>0)
		{
			$count=mysql_num_rows($fetch);
		}
		return $count;
	}

	function getThemeCss($themid='')
	{
		if($themid==1 || $themid=='')
		{
			$cssfile=BASE_URL.'css/style.css';
		}
		else
		{
			$fetch=mysql_query("select * from tbl_themes where theme_id='".$themid."' limit 0,1 ");
			if(is_resource($fetch) && mysql_num_rows($fetch)>0)
			{
				$result=mysql_fetch_array($fetch);
				$cssfile=USER_THEME_URL.$result['theme_name']."/css/style.css";
			}
			else
			{
				$cssfile=BASE_URL.'css/style.css';
			}
		}
		return $cssfile;
	}

	function getPages($position='')
	{
		$return='';
		$fetch=mysql_query("select * from tbl_pages where page_status=1 and page_position like '%".$position."%' ");
		if($fetch && is_resource($fetch) && mysql_num_rows($fetch))
		{
			while($result=mysql_fetch_array($fetch))
			{
				if($position=='footer') {
					$return.='<a href="'.BASE_URL."cms/".$result['sef_url'].'">'.$result['page_title'].'</a> - ';
				} else {
					$return.='<li><a href="'.BASE_URL."cms/".$result['sef_url'].'">'.$result['page_title'].'</a></li>';
				}
			}
			$return=rtrim($return," - ");
		}
		return $return;
	}

	function getPageById($id)
	{
		$return='';
		$fetch=mysql_query("select * from tbl_pages where page_status=1 and page_id='".$id."' limit 0,1 ");
		if($fetch && is_resource($fetch) && mysql_num_rows($fetch))
		{
			$result=mysql_fetch_array($fetch);
			$return='<a href="'.BASE_URL."cms/".$result['sef_url'].'">'.$result['page_title'].'</a>';
		}
		return $return;
	}

	function removeSpecialChars($string)
	{
		$string=preg_replace('/[^\sa-zA-Z0-9\']/','',$string);
		return $string;
	}
	
	function getSlug($string)
	{
		$string=$this->removeSpecialChars($string);
		$string=str_replace(" ","-",$string);
		return strtolower($string);
	}

	function getCommentCount($qid)
	{
		$query=mysql_query("select * from tbl_comments where question_id='".$qid."'  ");
		if($query && mysql_num_rows($query)>0) {
			$count=mysql_num_rows($query);
		} else {
			$count=0;
		}
		return $count;
	}

/* manish  14-march friend suggestion  ***/
function getEventCount($userid)
{
	$count=0;
	$result_set=mysql_query("select count(eid) as count_event from tbl_events where user_id='".$userid."' and (curdate()<=event_start_date or curdate()<=event_end_date) ");
	if(is_resource($result_set) && mysql_num_rows($result_set))
	{
		$result=mysql_fetch_array($result_set);
		$count= $result['count_event'];
	}
	return $count;
}

function getGroupCount($userid)
{
	$count=0;
	$result_set= mysql_query('select count(a.grp_id) as group_count1,b.* from tbl_group a  join (select count(grp_id) as group_count from tbl_group_members where group_member_id="'.$userid.'") b on a.user_id="'.$userid.'"');
	if(is_resource($result_set) && mysql_num_rows($result_set))
	{
		$result=mysql_fetch_array($result_set);
		$count1= $result['group_count'];
		$count2= $result['group_count1'];
		$count= $count1+$count2;
	}
	return $count;
}
function getGroupCountother($userid)
{
	$count=0;
	$result_set= mysql_query('select count(grp_id) as count_group from tbl_group where user_id="'.$userid.'"');
//	$result_set= mysql_query('select count(a.grp_id) as group_count1,b.* from tbl_group a  join (select count(grp_id) as group_count from tbl_group_members where group_member_id="'.$userid.'") b on a.user_id="'.$userid.'"');
	if(is_resource($result_set) && mysql_num_rows($result_set))
	{
		$result=mysql_fetch_array($result_set);
		$count= $result['count_group'];
		
	}
	return $count;
}

	function getFriendSuggestion($userid,$count='')
	{
		$return='';
$query = "select * from tbl_users where userid in (select request_sent_by_userid from tbl_friend_request where `request_sent_to_userid` in (
(select `request_sent_to_userid` from tbl_friend_request where `request_sent_by_userid` = '".$userid."' and reply=1
union 
select `request_sent_by_userid` from tbl_friend_request where `request_sent_to_userid` = '".$userid."'and reply=1) 
) and reply = 1  union 
select request_sent_to_userid from tbl_friend_request where `request_sent_by_userid` in (

(select `request_sent_to_userid` from tbl_friend_request where `request_sent_by_userid` = '".$userid."' and reply=1
union 
select `request_sent_by_userid` from tbl_friend_request where `request_sent_to_userid` = '".$userid."' and reply=1) 
)  
)
and userid not in (select `request_sent_to_userid` from tbl_friend_request where `request_sent_by_userid` ='".$userid."'
union 
select `request_sent_by_userid` from tbl_friend_request where `request_sent_to_userid` = '".$userid."') and userid != '".$userid."' ";

		if(isset($count) && $count>0) {
			$query=$query." limit 0,".$count;
		}
		
		$sql=mysql_query($query);
		if($sql && is_resource($sql) && mysql_num_rows($sql)>0)
		{
			$return.='<div id="friend-suggestion-wrap">';
			$return.='<h3 class="sggs-frd-heading dft-fnt">Friend suggestions</h3>';
			while($result=mysql_fetch_array($sql))
			{
				$userid=$result['userid'];
				
				$userdetails=$this->getUserDetailsByUserId($userid,$type='array');
				$userfullname=$userdetails['last_name'].' '.$userdetails['last_name'];
				
				$return.='<div class="suggs-frd-container">';
				$return.='<div class="suggs-lft-pic-col">';
				$return.='<a href="'.BASE_URL.'view-profile/'.$userid."/".$userfullname.'">';

				if($userdetails['profile_picture']!='' && file_exists(PROFILE_IMAGE_LOC."thumbs/".$userdetails['profile_picture'])) {
				$return.='<img src="'.PROFILE_IMAGE_URL."thumbs/".$userdetails['profile_picture'].'" height="50" width="50"/>';
				} else {
					$return.='<img src="'.BASE_URL.'images/priends-no-available.jpg" height="50" width="50" />';
				}

				$return.='</a>';
				$return.='</div>';
				$return.='<div class="suggs-frd-detail-col">';
				$return.='<a class="frd-title" href="'.BASE_URL.'view-profile/'.$userid."/".$userfullname.'">'.$userfullname.'</a>';
				$return.='<div>'.$this->getFriendRequestStatus($_SESSION['ses_userid'],$userid).'</div>';
				$return.='</div>';
				$return.='</div>';
			}
			$return.='<a class="view-all-nav" href="'.BASE_URL.'all-suggested-friend/1">View All Friends &raquo;</a>';
			$return.='</div>';
		}
		return $return;
	}
	
	function getStatusType($type='',$selected='')
	{
		$return='';
		if($type!='')
		{
			$sql=mysql_query("select * from tbl_status where type='".$type."' and enable=1 order by status_id asc ");
			if(is_resource($sql) && mysql_num_rows($sql)>0)
			{
				while($result=mysql_fetch_assoc($sql))
				{
					if($selected==$result['status_id']) {
						$return.='<option value="'.$result['status_id'].'" selected="true">'.$result['status'].'</option>';
					} else {
						$return.='<option value="'.$result['status_id'].'">'.$result['status'].'</option>';
					}
				}
			}
		}
		return $return;
	}
	
	function getStatusName($id)
	{
		$return='';
		if($id!='')
		{
			$sql=mysql_query("select status from tbl_status where status_id='".$id."' ");
			if(mysql_num_rows($sql)>0)
			{
				$result=mysql_fetch_assoc($sql);
				$return=$result['status'];
			}
		}
		return $return;
	}
	
	function getAdImg($pos,$h,$w,$limit=1)
	{
		$params='';
		if(isset($w) && $w>0 && $w!='') {
			$params.=' width="'.$w.'" ';
		}
		
		if(isset($h) && $h>0 && $h!='') {
			$params.=' height="'.$h.'" ';
		}
		 
		$return='';$container='';
		$addvertise=mysql_query("SELECT * FROM tbl_advertisement where ad_position='".$pos."' and ad_status=1  order by rand() limit 0,".$limit);
		if(mysql_num_rows($addvertise)>0) 
		{
			while($resultad=mysql_fetch_array($addvertise))
			{
				if(is_file(ADVERTISEMENT_THUMB_LOC.$resultad['ad_image']) && $resultad['ad_image']!='') 
				{
					if($pos==13) { $return.='<div class="adveRGT-row">'; }
					if($resultad['ad_link']!='') {
$return.='<a href="'.$resultad['ad_link'].'" style="margin-bottom:10px; display:block;" target="_blank"><img src="'.ADVERTISEMENT_THUMB_URL.$resultad['ad_image'].'" alt="'.$resultad['ad_title'].'" '.$params.'></a>';
					} else {
						$return.='<img src="'.ADVERTISEMENT_THUMB_URL.$resultad['ad_image'].'" alt="'.$resultad['ad_title'].'" '.$params.'>';
					}
					if($pos==13) { $return.='</div>'; }
				}
			}
		}
		return $return;
	}
	
	function getCoverBackgroundImage($coverid,$userid)
	{
		if($coverid<=1) {
			$return='<img src="'.BASE_URL.'images/timeline-cover-img-old.png" />';
		} 
		else 
		{
			 $fetch=mysql_query("select * from cover_upload where cover_id='".$coverid."' ");
			 if($fetch && mysql_num_rows($fetch)>0)
			 {
			 	$result=mysql_fetch_array($fetch);
				$imgname=$result['cover_file_name'];
				$imgloc=USER_GALLERY_LOC.$userid."/cover-page/".$imgname;
				$imgurl=USER_GALLERY_URL.$userid."/cover-page/".$imgname;
				
				$imgthumbloc=USER_GALLERY_LOC.$userid."/cover-page/thumbs/".$imgname;
				$imgthumburl=USER_GALLERY_URL.$userid."/cover-page/thumbs/".$imgname;

				if($imgthumbloc!='' && file_exists($imgthumbloc) && is_file($imgthumbloc)) {
					$return='<img src="'.$imgthumburl.'" width="690" height="260" />';
				} else {
					$return='<img src="'.BASE_URL.'images/timeline-cover-img-old.png" />';
				}
			 } 
			 else 
			 {
				$return='<img src="'.BASE_URL.'images/timeline-cover-img-old.png" />';
			 }
		}
		return $return;
	}
	
	function getPrivacy($type='radio',$selected='16')
	{
		$fetch=mysql_query("select * from tbl_status where type='privacy' and enable=1 ");
		if($fetch && mysql_num_rows($fetch)>0)
		{
			while($result=mysql_fetch_array($fetch))
			{
				if($type=='radio') 
				{
					if($selected==$result['status_id']) {
						$return.='<input type="radio" name="event_privacy" value="'.$result['status_id'].'" checked="true" />'.$result['status'];
					} else {
						$return.='<input type="radio" name="event_privacy" value="'.$result['status_id'].'" />'.$result['status'];
					}
				}
				else
				{
					if($selected==$result['status_id']) {
						$return.='<option value="'.$result['status_id'].'" selected="true">'.$result['status'].'</option>';
					} else {
						$return.='<option value="'.$result['status_id'].'">'.$result['status'].'</option>';
					}	
				}
			}
		}
		return $return;
	}
	
	function getAllUpdateComments($updateid)
	{
		$return='';
		$fetchcomments=mysql_query("select * from ( select * from tbl_users_updates_comments where update_id='".$updateid."' order by com_id ) 
		tbl_users_updates_comments order by com_id asc ") ;
		$count=mysql_num_rows($fetchcomments);
		if($fetchcomments && $count>0)
		{
			$return.='<ul id="all_comments_of_update_'.$updateid.'" class="user-give-cmmt">';
			while($resultfetchcomments=mysql_fetch_array($fetchcomments))
			{
				$userprofiledata=$this->getUserDetailsByUserId($resultfetchcomments['comment_by_userid']);
				$profilethumb=$this->checkProfileImage($userprofiledata['profile_picture']);
				if($profilethumb!='') {
					$profileimg='<img src="'.$profilethumb.'" width="56" alt="" title="" />';
				} else {
					$profileimg='<img src="'.BASE_URL.'images/priends-no-available.jpg" alt="" title="" width="56" />';
				}
				
				$return.='<li id="comment_container_'.$resultfetchcomments['com_id'].'">';
				$return.='<div class="cmmt-pic-lft lfloat">'.$profileimg.'</div>';
				$return.='<div class="cmmt-summery-rgt"><span class="cmmt-title"><a href="javascript:void(0);">'.$userprofiledata['first_name']." ".$userprofiledata['last_name'].'&nbsp;</a>';
				$return.='</span>'.$resultfetchcomments['comment_text'];
				$return.='<span class="cmmt-time-meta">';
				$return.= $this->nicetime($resultfetchupdates['time_added']);
				$return.= '</span>';
				$return.='</div>';
				$return.='</li>';
			}
			$return.='</ul>';
		}
		return $return;
	}
	
	function getUpdateComments($updateid)
	{
		$return='';
		$fetchcommentscount=mysql_query("select * from tbl_users_updates_comments where update_id='".$updateid."' ");
		$getcountcomments=mysql_num_rows($fetchcommentscount);
		
		$fetchcomments=mysql_query("select * from ( select * from tbl_users_updates_comments where update_id='".$updateid."' order by com_id desc limit 0,5 ) 
		tbl_users_updates_comments order by com_id asc ") ;
		$count=mysql_num_rows($fetchcomments);
		if($fetchcomments && $count>0)
		{
			if($getcountcomments>5) {
				$return.='<div class="view-all-cmmt-col"><span><a href="javascript:void(0);" class="view_all_comments" name="'.$updateid.'">
				View all '.$getcountcomments.' comments</a></span></div>';
			}
			
			$return.='<ul id="all_comments_of_update_'.$updateid.'" class="user-give-cmmt">';
			while($resultfetchcomments=mysql_fetch_array($fetchcomments))
			{
				$userprofiledata=$this->getUserDetailsByUserId($resultfetchcomments['comment_by_userid']);
				$profilethumb=$this->checkProfileImage($userprofiledata['profile_picture']);
				if($profilethumb!='') {
					$profileimg='<img src="'.$profilethumb.'" width="56" alt="" title="" />';
				} else {
					$profileimg='<img src="'.BASE_URL.'images/priends-no-available.jpg" alt="" title="" width="56" />';
				}
				
				$return.='<li id="comment_container_'.$resultfetchcomments['com_id'].'">';
				if($resultfetchcomments['comment_by_userid'] == $_SESSION['ses_userid'])
				{
				$return.='<span class="dlt-comment"><a href="javascript:void(0);" title="Delete" rel="'.$resultfetchcomments['com_id'].'" class="delete_updates1"><img src="'.BASE_URL.'images/cross-icon.png" /></a></span>';
				}
				$return.='<div class="cmmt-pic-lft lfloat">'.$profileimg.'</div>';
				$return.='<div class="cmmt-summery-rgt"><span class="cmmt-title"><a href="javascript:void(0);">'.$userprofiledata['first_name']." ".$userprofiledata['last_name'].'&nbsp;</a>';
				$return.='</span>'.$resultfetchcomments['comment_text'];
				$return.='<span class="cmmt-time-meta">';
				$return.= $this->nicetime($resultfetchcomments['time_added']);
				$return.='</span>';
				$return.='</div>';
				$return.='</li>';
			}
			$return.='</ul>';
		}
		return $return;
	}
	
	function getUpdateComments1($updateid)
	{
		$return='';
		$fetchcommentscount=mysql_query("select * from tbl_users_updates_comments where update_id='".$updateid."' ");
		$getcountcomments=mysql_num_rows($fetchcommentscount);
		
		$fetchcomments=mysql_query("select * from ( select * from tbl_users_updates_comments where update_id='".$updateid."' order by com_id desc limit 0,5 ) 
		tbl_users_updates_comments order by com_id asc ") ;
		$count=mysql_num_rows($fetchcomments);
		if($fetchcomments && $count>0)
		{
			if($getcountcomments>5) {
				$return.='<div class="view-all-cmmt-col"><span><a href="javascript:void(0);" class="view_all_comments" name="'.$updateid.'">
				View all '.$getcountcomments.' comments</a></span></div>';
			}
			
			$return.='<ul id="all_comments_of_update_'.$updateid.'" class="user-give-cmmt">';
			while($resultfetchcomments=mysql_fetch_array($fetchcomments))
			{
				$userprofiledata=$this->getUserDetailsByUserId($resultfetchcomments['comment_by_userid']);
				$profilethumb=$this->checkProfileImage($userprofiledata['profile_picture']);
				if($profilethumb!='') {
					$profileimg='<img src="'.$profilethumb.'" width="56" alt="" title="" />';
				} else {
					$profileimg='<img src="'.BASE_URL.'images/priends-no-available.jpg" alt="" title="" width="56" />';
				}
				
				$return.='<li id="comment_container_'.$resultfetchcomments['com_id'].'">';
				$return.='<span class="dlt-comment"><a href="javascript:void(0);" title="Delete" class="delete_updates1" rel="'.$resultfetchcomments['com_id'].'"><img src="'.BASE_URL.'images/cross-icon.png" /></a></span>';	
				$return.='<div class="cmmt-pic-lft lfloat">'.$profileimg.'</div>';
				$return.='<div class="cmmt-summery-rgt"><span class="cmmt-title"><a href="javascript:void(0);">'.$userprofiledata['first_name']." ".$userprofiledata['last_name'].'&nbsp;</a>';
				$return.='</span>'.$resultfetchcomments['comment_text'];
				$return.='<span class="cmmt-time-meta">';
				$return.= $this->nicetime($resultfetchcomments['time_added']);
				$return.='</span>';
				$return.='</div>';
				$return.='</li>';
			}
			$return.='</ul>';
		}
		return $return;
	}
	function getCommentForm($updateid)
	{
		$return='';
		if(isset($updateid) && $updateid>0 && $updateid!='')
		{
			$return.='<div class="snd-cmmt-field">';
			$return.='<div class="snd-cmmt-pic"><img src="'.BASE_URL.'images/sggs-pic4.jpg" /></div>';
			$return.='<div class="snd-cmmt-filed-col">';
			$return.='<form lang="'.$updateid.'" class="add_comment_for_updates" onsubmit="return false;" id="update_form_id_'.$updateid.'">';
			$return.='<input id="comment_box_'.$updateid.'" name="comment_box" type="text" placeHolder="Write Comment Here..." />';
			$return.='</form>';
			$return.='</div>';
			$return.='</div>';
		}
		return $return;
	}
	
	function getAllUpdatesByUserId($userid)
	{
		$return='';
		$fetchupdates=mysql_query("select * from tbl_users_updates where userid='".$userid."' order by update_id desc ");
		if($fetchupdates && mysql_num_rows($fetchupdates)>0)
		{
			$userprofiledata=$this->getUserDetailsByUserId($userid);
			$profilethumb=$this->checkProfileImage($userprofiledata['profile_picture']);
			if($profilethumb!='') {
				$profileimg='<img src="'.$profilethumb.'" width="56" alt="" title="" />';
			} else {
				$profileimg='<img src="'.BASE_URL.'images/priends-no-available.jpg" alt="" title="" width="56" />';
			}
			
			while($resultfetchupdates=mysql_fetch_array($fetchupdates))
			{
				$return.='<div id="story-wrapper">';
				$return.='<div class="storty-pic">'.$profileimg.'</div>';
				$return.='<div class="story-summery-col">';
				$return.='<h2 class="user-title">'.$userprofiledata['first_name']." ".$userprofiledata['last_name'].'</h2>';
				$return.='<span class="userContent">'.nl2br($resultfetchupdates['update_text']).'</span>';
				$return.='<div class="story-meta-footer"><span class="stry-cmmt-meta">';
				$return.='<a href="javascript:void(0);" class="getfocus" id="'.$resultfetchupdates['update_id'].'">Comments</a>';
				$return.='</span><span class="stry-time-meta">';
				$return.= $this->nicetime($resultfetchupdates['time_added']);
				$rerurn.= '</span></div>';
				$return.='<div id="all_comment_container_'.$resultfetchupdates['update_id'].'" class="cmmt-post-wrapper">';
				$return.=$this->getUpdateComments($resultfetchupdates['update_id']);
				$return.='</div>';
				$return.=$this->getCommentForm($resultfetchupdates['update_id']);
				$return.='</div>';
				$return.='</div>';
			}
		}	
		return $return;
	}
	
	function getOffset($pagenumber,$rowperpage)
	{
		$offset=($pagenumber-1)*$rowperpage;
		return($offset);
	}
	
	function getPagingSql($sql,$pagenumber,$total,$rowperpage=RECORD_PER_PAGE)
	{
		$offset=($pagenumber-1)*$rowperpage;
		$query=$sql." limit $offset , $rowperpage";
		return($query);
	}

	function checkIsLast($pagenumber,$total_rows)
	{
		if($pagenumber==$this->getMaxPage(RECORD_PER_PAGE,$total_rows)) {
			return true;
		} else {
			return false;
		}
	}
	
	function getMaxPage($rowperpage,$total)
	{
		$maxpage=ceil($total/$rowperpage);
		return $maxpage;
	}

	function getPageNav($pagenumber,$total_rows)
	{
		$offset=($pagenumber-1)*RECORD_PER_PAGE;
		if($pagenumber==1) {
			$from=1;
		} else {
			$from=$offset+1;
		}
	
		$mexpage=$this->getMaxPage(RECORD_PER_PAGE,$total_rows);
		if($pagenumber==$mexpage) {
			$to=$total_rows;
		} else {
			$to=$from+RECORD_PER_PAGE-1;
		}
	
		$pagenave='';
		$pagenave.='<span>Record : '.$from."-".$to.' of '.$total_rows.'</span> ';
		
		if($pagenumber==1) {
			$pagenave.='<span class="prev"><a href="javascript:void(0);">Prev</a></span>';
		} else {
			$pagenave.='<span class="prev"><a href="javascript:void(0);" class="prev_records">Prev</a></span>';
		}
	
		if($pagenumber==$mexpage) {
			$pagenave.='<span class="next"><a href="javascript:void(0);">Next</a></span>';
		} else {
			$pagenave.='<span class="next"><a href="javascript:void(0);" class="next_records">Next</a></span>';
		}
		return $pagenave;
	}
	
	function getSubStr($string,$limit=50)
	{
		$return='';
		if($string!='') 
		{
			if(strlen($string)>$limit) 
			{
				$string=substr($string,0,$limit);
				$exp=explode(" ",$string);
				$narray=array_pop($exp);
				$return=implode(" ",$exp);
			}
			else
			{
				$return=$string;
			}
		}
		return $return;
	}
	
	function getShowDateFormatWithWeekDay($date)
	{
		$exp=explode("-",$date);
		$year=$exp[0];
		$month=$exp[1];
		$day=$exp[2];
	
		if($year>0 && $month>0)
		{
			$date=date("l, F d, Y",mktime(0,0,0,$month,$day,$year));
		}
		else
		{
			$date='';
		}
		return $date;
	}

	function getInvitationCount($userid)
	{
		$count=0;
		$result_set= mysql_query('select count(id) as count_invitation from event_join where user_id="'.$userid.'" ');
		if(is_resource($result_set) && mysql_num_rows($result_set))
		{
		$result= mysql_fetch_array($result_set);
		$count= $result['count_invitation'];
		}
		return $count;
	}

	function getfavoriteajaxcall($userid)
	{
		$userlist='';
		$fetch=mysql_query("select * from tbl_users where userid in ( select request_sent_to_userid from tbl_friend_request where request_sent_by_userid='".$userid."' and 
		add_to_favourite=1)  order by rand() limit 0,8 ");
		if($fetch && mysql_num_rows($fetch)>0)
		{
			$userlist.='<h3>Favorites you?</h3><ul class="favorite-user-image-margin-sidebar">';
			while($result=mysql_fetch_assoc($fetch))
			{
				$url=BASE_URL.'view-profile/'.$result['userid']."/".$userfullname;
		
				$userlist.='<li>';
				if($result['profile_picture']!='' && file_exists(PROFILE_IMAGE_LOC."thumbs/".$result['profile_picture'])) {
					$userlist.= '<a href="'.$url.'"><img src="'.PROFILE_IMAGE_URL."thumbs/".$result['profile_picture'].'" width="50"/></a>';
				} else {
					$userlist.= '<a href="'.BASE_URL.'view-profile/'.$result['userid']."/".$userfullname.'"><img src="'.BASE_URL.'images/priends-no-available.jpg" 
					width="50" /></a>';
				}
				$userlist.= '<span class="adveRGT-row-title-wrap">'.substr($result['first_name'],0,10).'</span>';
				$userlist.='</li>';
			}
			$userlist.='</ul>';
		}
		return $userlist;
	}

function nicetime($date)
{
    if(empty($date)) {
        return "No date provided";
    }
   
    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths         = array("60","60","24","7","5.30","12","10");
   
   
    $now             =  time();
    $unix_date       = $date;
   
    if(empty($unix_date)) {   
        return "Bad date";
    }

    if($now > $unix_date) {   
        $difference     = $now - $unix_date;
        $tense         = "ago";
       
    } else {
        $difference     = $unix_date - $now;
        $tense         = "from now";
    }
   
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
   
    $difference = round($difference);
   
    if($difference != 1) {
        $periods[$j].= "s";
    }
   
    return "$difference $periods[$j] {$tense}";
}
function time_elapsed_B($psecs){
$secs= time()-$psecs;
    $time_added = array(
        ' year'        => $secs / 31556926 % 12,
        ' week'        => $secs / 604800 % 52,
        ' day'        => $secs / 86400 % 7,
        ' hour'        => $secs / 3600 % 24,
        ' minute'    => $secs / 60 % 60,
        );
       
    foreach($time_added as $k => $var){
        if($var > 1)$ret[] = $var . $k . 's';
        if($var == 1)$ret[] = $var . $k;
        }
    array_splice($ret,count($ret)-1, 0, ' ');
    $ret[] = 'ago.';
   
    return join(' ', $ret);
    }
	
function create_square_image($original_file, $destination_file=NULL, $square_size = 200)
{
// get width and height of original image
$imagedata = getimagesize($original_file);
$original_width = $imagedata[0];
$original_height = $imagedata[1];

if($original_width > $original_height){
$new_height = $square_size;
$new_width = $new_height*($original_width/$original_height);
}
if($original_height > $original_width){
$new_width = $square_size;
$new_height = $new_width*($original_height/$original_width);
}
if($original_height == $original_width){
$new_width = $square_size;
$new_height = $square_size;
}

$new_width = round($new_width);
$new_height = round($new_height);

// load the image
if(substr_count(strtolower($original_file), ".jpg") or substr_count(strtolower($original_file), ".jpeg")){
$original_image = imagecreatefromjpeg($original_file);
}
if(substr_count(strtolower($original_file), ".gif")){
$original_image = imagecreatefromgif($original_file);
}
if(substr_count(strtolower($original_file), ".png")){
$original_image = imagecreatefrompng($original_file);
}

$smaller_image = imagecreatetruecolor($new_width, $new_height);
$square_image = imagecreatetruecolor($square_size, $square_size);

imagecopyresampled($smaller_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

if($new_width>$new_height){
$difference = $new_width-$new_height;
$half_difference = round($difference/2);
imagecopyresampled($square_image, $smaller_image, 0-$half_difference+1, 0, 0, 0, $square_size+$difference, $square_size, $new_width, $new_height);
}
if($new_height>$new_width){
$difference = $new_height-$new_width;
$half_difference = round($difference/2);
imagecopyresampled($square_image, $smaller_image, 0, 0-$half_difference+1, 0, 0, $square_size, $square_size+$difference, $new_width, $new_height);
}
if($new_height == $new_width){
imagecopyresampled($square_image, $smaller_image, 0, 0, 0, 0, $square_size, $square_size, $new_width, $new_height);
}


// if no destination file was given then display a png
if(!$destination_file){
imagepng($square_image,NULL,9);
}

// save the smaller image FILE if destination file given
if(substr_count(strtolower($destination_file), ".jpg")){
imagejpeg($square_image,$destination_file,100);
}
if(substr_count(strtolower($destination_file), ".gif")){
imagegif($square_image,$destination_file);
}
if(substr_count(strtolower($destination_file), ".png")){
imagepng($square_image,$destination_file,9);
}

imagedestroy($original_image);
imagedestroy($smaller_image);
imagedestroy($square_image);
}


function getAdImg1($pos,$h,$w,$limit=1)
{
	$params='';
	if(isset($w) && $w>0 && $w!='') {
		$params.=' width="'.$w.'" ';
	}

	if(isset($h) && $h>0 && $h!='') {
		$params.=' height="'.$h.'" ';
	}

	$return='';$container='';
	$addvertise=mysql_query("SELECT * FROM tbl_advertisement where ad_position='".$pos."' and ad_status=1  order by rand() limit 0,".$limit);
	if(mysql_num_rows($addvertise)>0) 
	{
		$return.='<div class="adveRGT-wrap">';
		while($resultad=mysql_fetch_array($addvertise))
		{
			if(is_file(ADVERTISEMENT_THUMB_LOC.$resultad['ad_image']) && $resultad['ad_image']!='') 
			{
				$return.='<div class="adv-txt-reapet-box">';
				$return.= '<h2>';
				if($resultad['ad_link']!='') {
					$return.= '<a href="'.$resultad['ad_link'].'" style="margin-bottom:10px; display:block;" target="_blank">'.$resultad['ad_title'].'</a>';
				} else {
					$return.=$resultad['ad_title'];
				}
				$return.= '</h2>';
				$return.='<div class="adv-txt-detail-cnt">';
				//$return.='<a href="'.$resultad['ad_link'].'" style="margin-bottom:10px; display:block;" target="_blank">';
				$return.='<img src="'.ADVERTISEMENT_THUMB_URL.$resultad['ad_image'].'" alt="'.$resultad['ad_title'].'" '.$params.'>';
				//$return.='</a>';
				$return.=substr($resultad['ad_description'],0,150).'</div>';
				$return.='</div>';
			}
		}
		$return.='</div>';
	}
	return $return;
}

function getEmailTamplate($tid)
{
	$return='';
	$emaildata= array();
	$query='SELECT * FROM  tbl_email_template where template_id="'.$tid.'" ';
	$query_fetch= mysql_query($query);	
	if(is_resource($query_fetch) && mysql_num_rows($query_fetch)>0)
	{
		$return=mysql_fetch_array($query_fetch);
	}
	return $return;
}		

}
?>