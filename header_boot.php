<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>          </button>
          <a class="navbar-brand" href="index.php"><img src="images/small_logo.png" style="height:70px" /></a>

        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav" style="float:right">

		 	<li class="project_name">{<span id="project_name"></span>}</li>
					  	
			<li><a style="padding-top: 7px; padding-bottom: 6px;">
			Select Environment:
			<select name="selected_environment" id="selected_environment" onChange="updateEnvironment(this.value)">
				<option value="" selected="selected"><i>Select project first</i></option>
				</select>
            </a></li>

			<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer">Load Project<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="index.php?load_project=0"><img src="images/add.png" />&nbsp;&nbsp;Create New</a></li>				
                <li class="divider"></li>
				<?php
				$dir    = 'projects';
				$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

				$it->rewind();
				while($it->valid()) {

				    if ($it->getExtension() == "ini") {
				        echo '<li><a onclick="loadProject(\'' . $it->getSubPathName() . '\')" style="cursor:pointer">' . $it->getSubPathName() . "</a></li>";
				    }

			    $it->next();
				}
				?>
              </ul>
            </li>
			        
		    <li><a href="http://orchardcity.ca/quickstart/guide/index.php">Guide</a></li>
			
		</ul>

        </div><!--/.nav-collapse -->
      </div>

    </div>
		  <br />