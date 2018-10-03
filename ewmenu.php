<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(1, "mi_membership", $Language->MenuPhrase("1", "MenuText"), "membershiplist.php", -1, "", IsLoggedIn() || AllowListMenu('{C94A36D7-4F8C-407F-9ED7-192C6149F989}membership'), FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
