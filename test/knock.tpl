<?php $test_var = "Local val!" . $this->answer; ?>
<html>
  <head></head>
  <body>
    <h1>Knock! Knock!</h1>
    <h2>Who's there?</h2>
    <h2><?php echo $this->answer; ?></h2>
    <h2><?php echo $this->answer; ?> who?</h2>
    <h2><?php echo $this->punchline; ?></h2>
	<?php echo $test_var?>
  </body>
</html>