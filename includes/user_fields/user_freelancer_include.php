<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2014	 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: user_freelancer_include.php
| Author: KasteR
| Web: http://www.kaster.us
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }
    
// Display user field input
if ($profile_method == "input") {
	$user_freelancer = isset($user_data['user_freelancer']) ? $user_data['user_freelancer'] : "";
	if ($this->isError()) { $user_freelancer = isset($_POST['user_freelancer']) ? stripinput($_POST['user_freelancer']) : $user_freelancer; }

	echo "<tr>\n";
	echo "<td class='tbl".$this->getErrorClass("user_freelancer")."'><label for='user_freelancer'>".$locale['uf_freelancer'].$required."</label></td>\n";
	echo "<td class='tbl".$this->getErrorClass("user_freelancer")."'>";
	echo "<input type='text' id='user_freelancer' name='user_freelancer' value='".$user_freelancer."' maxlength='16' class='textbox' style='width:200px;' />";
	echo "</td>\n</tr>\n";

	if ($required) { $this->setRequiredJavaScript("user_freelancer", $locale['uf_freelancer_error']); }
	
// Display in profile
} elseif ($profile_method == "display") {
	if ($user_data['user_freelancer']) {

// JSON data from FREELANCER
$user = $user_data['user_freelancer'];
$json = file_get_contents('http://api.freelancer.com/User/Properties.json?id='.$user.'');
$data = json_decode($json,true);
    $url = $data['profile']['url'];
    $hourlyrate = $data['profile']['hourlyrate'];
    $username = $data['profile']['username'];
	$country =  strtolower($data['profile']['address']['country']);
	$currency = $locale['uf_freelancer_c_'.$country];

		echo "<tr>\n";
		echo "<td class='tbl1'>".$locale['uf_freelancer']."</td>\n";
		echo "<td align='right' class='tbl1'>(".$currency.")<a href='".$url."' target='_blank'>".$hourlyrate."/".$locale['uf_freelancer_hour']."</a></td>\n";
		echo "</tr>\n";
	}
	
// Insert or update
} elseif ($profile_method == "validate_insert"  || $profile_method == "validate_update") {
	// Get input data
	if (isset($_POST['user_freelancer']) && ($_POST['user_freelancer'] != "" || $this->_isNotRequired("user_freelancer"))) {
		// Set update or insert user data
		$this->_setDBValue("user_freelancer", stripinput(trim($_POST['user_freelancer'])));
	} else {
		$this->_setError("user_freelancer", $locale['uf_freelancer_error'], true);	
	}
}
?>