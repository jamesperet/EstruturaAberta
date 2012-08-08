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

?>