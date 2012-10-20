<?php

function __autoload($class_name) {
	$class_name = strtolower($class_name);
  $path = "LIB_PATH.DS.{$class_name}.php";
  if(file_exists($path)) {
    require_once($path);
  } else {
		die("The file {$class_name}.php could not be found.");
	}
}


function redirect_to( $location = NULL ) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

function output_message($message="") {
  if (!empty($message)) { 
    return "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}

function include_layout_template($template=""){
	include(SITE_ROOT.DS.'public'.DS.'layouts'.DS. $template);
}

function time2string($timeline) {
    $periods = array('day' => 86400, 'hour' => 3600, 'minute' => 60, 'second' => 1);
    foreach($periods AS $name => $seconds){
        $num = floor($timeline / $seconds);
        $timeline -= ($num * $seconds);
        $ret .= $num.' '.$name.(($num > 1) ? 's' : '').' ';
    }

    return trim($ret);
}

function getElapsedTime($eventTime)
{
    $totaldelay = time() - strtotime($eventTime);
    if($totaldelay <= 0)
    {
        return 'just created';
    }
    else
    {
        if($days=floor($totaldelay/45792000))
        {
            $totaldelay = $totaldelay % 86400;
            return $days.' years ago';
        }
        if($days=floor($totaldelay/5184000))
        {
            $totaldelay = $totaldelay % 86400;
            return $days.' months ago';
        }
    		if($days=floor($totaldelay/1209600))
        {
            $totaldelay = $totaldelay % 86400;
            return $days.' weeks ago';
        }
        if($days=floor($totaldelay/86400))
        {
            $totaldelay = $totaldelay % 86400;
            return $days.' days ago';
        }
        if($hours=floor($totaldelay/3600))
        {
            $totaldelay = $totaldelay % 3600;
            return $hours.' hours ago';
        }
        if($minutes=floor($totaldelay/60))
        {
            $totaldelay = $totaldelay % 60;
            return $minutes.' minutes ago';
        }
        if($seconds=floor($totaldelay/1))
        {
            $totaldelay = $totaldelay % 1;
            return $seconds.' seconds ago';
        }
    }
}

function timeNow(){
	$dt = new DateTime("now");
	$date = $dt->format('Y-m-d H:i:sP');
	return $date;
}

function checkEmail($email) {
  // First, we check that there's one @ symbol, 
  // and that the lengths are right.
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters 
    // in one section or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
    if(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&↪'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
      return false;
    }
  }
  // Check if domain is IP. If not, 
  // it should be valid domain name
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|↪([A-Za-z0-9]+))$", $domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}

function sendMail($to, $from, $subject, $message) {
	$headers  = 'From: ' . $from . "\r\n";
	$headers .= 'Reply-To: '. $from . "\r\n";
	$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	mail($to, $subject, $message, $headers);
}

function MailTemplate($template){
	$settings = Setting::load();
	$template_link = 'themes/' . $settings->theme . '/emails/' . $template;
	ob_start();
	include_once($template_link);
	$message = ob_get_contents();
	ob_end_clean();
	return $message;
}

function find_file_extension($filename) { 
	 $filename = strtolower($filename) ; 
	 $exts = split("[/\\.]", $filename) ; 
	 $n = count($exts)-1; 
	 $exts = $exts[$n]; 
	 return $exts; 
 } 

function back_path($level){
	if($level == 0){
		return '';
	} else {
		$counter = 1;
		while($counter <= $level){
			$path .= '../';
			$counter = $counter + 1;
		}
		return $path;
	}
}

function build_link($page_id) {
	$page = Page::find_by_id($page_id);
	if($page->parent_id != 0){
		$parent_page = Page::find_by_id($page->parent_id);
		if($parent_page->parent_id != 0){
			$grand_parent_page = Page::find_by_id($parent_page->parent_id);
			if($grand_parent_page->parent_id != 0){
				$great_grand_parent_page = Page::find_by_id($grand_parent_page->parent_id);
			}
		}
	}
	if($great_grand_parent_page){
		$link = $great_grand_parent_page->name . '/';
	}
	if($grand_parent_page){
		$link .= $grand_parent_page->name . '/';
	}
	if($parent_page){
		$link .= $parent_page->name . '/';
	}
	if($page){
		$link .= $page->name . '/';
	}
	return $link;
}

function build_nav_menu($level, $page_slug){
    $links = NavLink::find_all();
  	foreach($links as $link){
  		$link_page = Page::find_by_id($link->page_id);
      	echo '<li class="'; 
      	if($link_page->name == $page_slug) { echo 'active'; }
      	echo '"><a href="' . back_path($level) . build_link($link->page_id) . '">' . $link->name . '</a></li>';
  	}
}

?>