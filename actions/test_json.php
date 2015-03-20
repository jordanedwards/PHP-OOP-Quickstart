<!DOCTYPE html>
<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
   $(document).ready(function() {
          $.getJSON('../projects/test_project.ini', function(jd) {
             $('#stage').html('<p>Operator: ' + jd.settings_application_name + '</p>');		  
             $('#stage').append('<p>Subsistence: ' + jd.settings_email + '</p>');
             $('#stage').append('<p>Travel : ' + jd.dev_dbname+ '</p>');
             $('#stage').append('<p>Truck: ' + jd.dev_dbpass+ '</p>');
          });
      });
   </script>
</head>
<body>

<button>Get JSON data</button>
<div id="stage"></div>

</body>
</html>
