<?php
/**
 * Sample code for cPanel PHP API
 *
 *
 * @author Gerardo Ortiz V.
 * @copyright (c) 2010 MB Works, Inc. 
 * @package cPanelAPI
 */
require_once ('class.cpanel.php');

// Initialize the class
$cPanel = new cPanel('domain.com', 'username', 'password', 2082, 'x3', false);

// Lets use this email account for test purposes
$email = 'sample';
$domain = 'domain.com';
?>
<h1>General Methods</h1>
<b>Contact email:</b> <?php echo $cPanel->getContactEmail(); ?>
<hr />
<h1>Email Methods</h1>
<b>Email:</b> <?php echo $email . '@' . $domain; ?><br />
<b>Quota (Used/Aviable):</b> <?php echo $cPanel->email()->getUsedSpace($email, $domain); ?>/<?php echo $cPanel->email()->getQuota($email, $domain); ?><br />
<b>Forwarders:</b><br />
<ul>
<?php
$forwarders = $cPanel->email()->getForwarders($email, $domain);
if (empty($forwarders)) {?>	

  <li>No forwarders</li>

<?php 
// We detected forwarders, list em
} else {
	foreach ($forwarders as $forwarder) {
	?>
    
    <li><?php echo $forwarder; ?></li>
    
    <?php
	}
}
?>
</ul>