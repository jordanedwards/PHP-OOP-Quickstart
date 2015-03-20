<?php 
 class Project {
 
		private $settings_application_name;
		private $settings_project_file;		
		private $settings_email;
		private $settings_timezone;
		private $settings_framework;
		private $url_routing;
		private $access_protocol;
		private $pro_use;
		private $pro_dbname;
		private $pro_dbuser;
		private $pro_dbpass;
		private $pro_dbhost;
		private $dev_url;
		private $dev_dbname;
		private $dev_dbuser;
		private $dev_dbpass;
		private $dev_dbhost;
		private $local_dbname;
		private $local_dbuser;
		private $local_dbpass;
		private $local_dbhost;
		private $dbname;
		private $dbuser;
		private $dbhost;
		private $dbpass;
		private $base_url;
		private $includes_url;
		private $class_url;
		private $actions_url;
		private $use_LESS;
		private $output_type;
		private $selected_environment;
		private $attributes;
																										 		
	function __construct() {
	
	}
		public function get_settings_application_name() { return $this->settings_application_name;}
		public function set_settings_application_name($value) {$this->settings_application_name=$value;}
		
		public function get_settings_project_file() { return $this->settings_project_file;}
		public function set_settings_project_file($value) {$this->settings_project_file=$value;}
		
		public function get_settings_email() { return $this->settings_email;}
		public function set_settings_email($value) {$this->settings_email=$value;}
		
		public function get_settings_timezone() { return $this->settings_timezone;}
		public function set_settings_timezone($value) {$this->settings_timezone=$value;}
		
		public function get_settings_framework() { return $this->settings_framework;}
		public function set_settings_framework($value) {$this->settings_framework=$value;}
		
		public function get_url_routing() { return $this->url_routing;}
		public function set_url_routing($value) {$this->url_routing=$value;}
		
		public function get_access_protocol() { return $this->access_protocol;}
		public function set_access_protocol($value) {$this->access_protocol=$value;}
		
		// These are the config settings for the different databases for the different environments: 
		public function get_pro_use() { return $this->pro_use;}
		public function set_pro_use($value) {$this->pro_use=$value;}
		
		public function get_pro_dbname() { return $this->pro_dbname;}
		public function set_pro_dbname($value) {$this->pro_dbname=$value;}
		
		public function get_pro_dbuser() { return $this->pro_dbuser;}
		public function set_pro_dbuser($value) {$this->pro_dbuser=$value;}
		
		public function get_pro_dbpass() { return $this->pro_dbpass;}
		public function set_pro_dbpass($value) {$this->pro_dbpass=$value;}
		
		public function get_pro_dbhost() { return $this->pro_dbhost;}
		public function set_pro_dbhost($value) {$this->pro_dbhost=$value;}
		
		public function get_dev_url() { return $this->dev_url;}
		public function set_dev_url($value) {$this->dev_url=$value;}
		
		public function get_dev_dbname() { return $this->dev_dbname;}
		public function set_dev_dbname($value) {$this->dev_dbname=$value;}
		
		public function get_dev_dbuser() { return $this->dev_dbuser;}
		public function set_dev_dbuser($value) {$this->dev_dbuser=$value;}
		
		public function get_dev_dbpass() { return $this->dev_dbpass;}
		public function set_dev_dbpass($value) {$this->dev_dbpass=$value;}
		
		public function get_dev_dbhost() { return $this->dev_dbhost;}
		public function set_dev_dbhost($value) {$this->dev_dbhost=$value;}
		
		public function get_local_dbname() { return $this->local_dbname;}
		public function set_local_dbname($value) {$this->local_dbname=$value;}
		
		public function get_local_dbuser() { return $this->local_dbuser;}
		public function set_local_dbuser($value) {$this->local_dbuser=$value;}
		
		public function get_local_dbpass() { return $this->local_dbpass;}
		public function set_local_dbpass($value) {$this->local_dbpass=$value;}
		
		public function get_local_dbhost() { return $this->local_dbhost;}
		public function set_local_dbhost($value) {$this->local_dbhost=$value;}
		// End database config settings
		
		// These are the settings for the database selected by setting the environment. 
		public function get_dbname() { return $this->dbname;}
		public function set_dbname($value) {$this->dbname=$value;}
		
		public function get_dbuser() { return $this->dbuser;}
		public function set_dbuser($value) {$this->dbuser=$value;}
		
		public function get_dbpass() { return $this->dbpass;}
		public function set_dbpass($value) {$this->dbpass=$value;}
		
		public function get_dbhost() { return $this->dbhost;}
		public function set_dbhost($value) {$this->dbhost=$value;}		
		// End selected database settings
		
		public function get_base_url() { return $this->base_url;}
		public function set_base_url($value) {$this->base_url=$value;}
		
		public function get_includes_url() { return $this->includes_url;}
		public function set_includes_url($value) {$this->includes_url=$value;}
		
		public function get_class_url() { return $this->class_url;}
		public function set_class_url($value) {$this->class_url=$value;}
		
		public function get_actions_url() { return $this->actions_url;}
		public function set_actions_url($value) {$this->actions_url=$value;}
		
		public function get_use_LESS() { return $this->use_LESS;}
		public function set_use_LESS($value) {$this->use_LESS=$value;}
		
		public function get_output_type() { return $this->output_type;}
		public function set_output_type($value) {$this->output_type=$value;}

		// Returns an associative array of all attributes.
		public function get_attributes() { return $this->attributes;}
		public function set_attributes($value) {$this->attributes=$value;}
				
		// This is important. The selected environment can be set in the .ini file, or can bew set at runtime. Setting it determines which db to use, and which project url
		public function get_selected_environment() { return $this->selected_environment;}
		public function set_selected_environment($value) {
			$this->environment=$value;	
				
			// Pull the correct database parameters and write to object:
			switch ($value){
				case "Development":
					$this->set_dbhost($this->get_dev_dbhost());
					$this->set_dbuser($this->get_dev_dbuser());
					$this->set_dbpass($this->get_dev_dbpass());
					$this->set_dbname($this->get_dev_dbname());
				break;
				
				case "Production":
					$this->set_dbhost($this->get_pro_dbhost());
					$this->set_dbuser($this->get_pro_dbuser());
					$this->set_dbpass($this->get_pro_dbpass());
					$this->set_dbname($this->get_pro_dbname());
				break;
				
				case "Local":
					$this->set_dbhost($this->get_local_dbhost());
					$this->set_dbuser($this->get_local_dbuser());
					$this->set_dbpass($this->get_local_dbpass());
					$this->set_dbname($this->get_local_dbname());
				break;
			}
		
		}
	
	public function __toString(){
		// Debugging tool
		// Dumps out the attributes and method names of this object
		// To implement:
		// $a = new SomeClass();
		// echo $a;
		
		// Get Class name:
		$class = get_class($this);
		
		// Get attributes:
		$attributes = get_object_vars($this);
		
		// Get methods:
		$methods = get_class_methods($this);
		
		echo "<h2>Information about the $class object</h2>";
		echo '<h3>Attributes</h3><ul>';
		foreach ($attributes as $key => $value){
			echo "<li>$key: $value</li>";
		}
		echo "</ul>";
		
		echo "<h3>Methods</h3><ul>";
		foreach ($methods as $value){
			echo "<li>$value</li>";
		}
		echo "</ul>";
	
	}
		 
	public function save() {

	try{
		//Still to do:
			if ($this->get_settings_project_file() == NULL){
				$this->set_settings_project_file(str_replace(" ","_", $this->get_settings_application_name()));
			} else {
				// $this->get_settings_project_file() already is set
			}
			$result = false;
			
			/*$out = "{";
			foreach ($_POST as $key => $val){
			$out .= '"' . $key . '":"' . $val . '",';
			}
			$out = rtrim($out, ",");
			$out .= "}";
			
			$file_name = "../projects/" . $project_name . ".ini";
			$fp = fopen($file_name,'w+'); 
			if (fwrite($fp, $out))
			{
				$result = true;
			}
			fclose($fp);*/
					    
      
			return $result;

		}
		catch(Exception $e) {
			include_once($_SERVER['DOCUMENT_ROOT'] . '/quickstart/classes/class_error_handler.php');
			$errorVar = new ErrorHandler();
			$errorVar->notifyAdminException($e);
			exit;
		}

	}

	// function to delete the record
	public function delete_by_name($id) {
		try{
			$result = false;
			$file = $this->get_settings_application_name();
			if (!unlink($file))
			{ $result = true; }
		}
		catch(Exception $e) {
			// CATCH EXCEPTION HERE -- DISPLAY ERROR MESSAGE & EMAIL ADMINISTRATOR
			include_once($_SERVER['DOCUMENT_ROOT'] . '/quickstart/classes/class_error_handler.php');
			$errorVar = new ErrorHandler();
			$errorVar->notifyAdminException($e);
			exit;
		}
	}

	public function get_by_name($project_file_name) {
		try{
			$status = false;
			
			$project = '../projects/'.$project_file_name;
			$project = file_get_contents($project);
			$json_project_settings=json_decode($project,true);
			
			if (!empty($json_project_settings)){
        		$this->load($json_project_settings);
				$this->set_attributes($json_project_settings);
				$status = true;
			}

			return $status;
		}
		catch(Exception $e) {
			// CATCH EXCEPTION HERE -- DISPLAY ERROR MESSAGE & EMAIL ADMINISTRATOR
			include_once($_SERVER['DOCUMENT_ROOT'] . '/quickstart/classes/class_error_handler.php');
			$errorVar = new ErrorHandler();
			$errorVar->notifyAdminException($e);
			exit;
		}
	}

	
	private function load($row){
		$this->set_settings_application_name($row['settings_application_name']);
		$this->set_settings_project_file($row['settings_project_file']);
		$this->set_settings_email($row['settings_email']);
		$this->set_settings_timezone($row['settings_timezone']);
		$this->set_settings_framework($row['settings_framework']);
		$this->set_url_routing($row['url_routing']);
		$this->set_access_protocol($row['access_protocol']);
		$this->set_pro_use($row['pro_use']);
		$this->set_pro_dbname($row['pro_dbname']);
		$this->set_pro_dbuser($row['pro_dbuser']);
		$this->set_pro_dbpass($row['pro_dbpass']);
		$this->set_pro_dbhost($row['pro_dbhost']);
		$this->set_dev_url($row['dev_url']);
		$this->set_dev_dbname($row['dev_dbname']);
		$this->set_dev_dbuser($row['dev_dbuser']);
		$this->set_dev_dbpass($row['dev_dbpass']);
		$this->set_dev_dbhost($row['dev_dbhost']);
		$this->set_local_dbname($row['local_dbname']);
		$this->set_local_dbuser($row['local_dbuser']);
		$this->set_local_dbpass($row['local_dbpass']);
		$this->set_local_dbhost($row['local_dbhost']);
		$this->set_base_url($row['base_url']);
		$this->set_includes_url($row['includes_url']);
		$this->set_class_url($row['class_url']);
		$this->set_actions_url($row['actions_url']);
		$this->set_use_LESS($row['use_LESS']);
		$this->set_output_type($row['output_type']);
		$this->set_selected_environment($row['selected_environment']);
	}

}