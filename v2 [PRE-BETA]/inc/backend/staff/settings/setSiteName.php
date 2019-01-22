<?php
session_name('hydrid');
session_start();
require '../../../connect.php';

require '../../../config.php';

require '../../../backend/user/auth/userIsLoggedIn.php';

$error = array();

if (staff_access && staff_siteSettings) {
  $site_name = strip_tags($_POST['site_name']);

  $stmt              = $pdo->prepare("UPDATE `settings` SET `site_name`=:q");
  $stmt->bindValue(':q', $site_name);
  $result = $stmt->execute();
  logAction('Changed Website Setting: Name', $user['username']);

  if ($settings['discord_alerts'] === 'true') {
  discordAlert('**Panel Settings Changed**
	  Name has been updated by '. $user['username'] .'
      - **Hydrid CAD System**');
  }
  $error['msg'] = "";
  echo json_encode($error);
  exit();
} else {
  logAction('Attempted To Change Website Setting: Name', $user['username']);
  $error['msg'] = "You don't have permission.";
  echo json_encode($error);
  exit();
}
