<?php if($session->getAlertMessage() != "") { ?>
<div id="alert_message" class="<?php echo $session->getAlertColor(); ?>"><?php echo $session->getAlertMessage(); ?></div>
<?php $session->setAlertMessage(""); } ?>