<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
  <head>
    <meta charset="utf-8">
    <title>Select2 3.5.1</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Select2 JQuery Plugin">
    <meta name="author" content="Igor Vaynberg">

    <link href="../../bootstrap/css/bootstrap.css" rel="stylesheet"/>

      <script src="../../js/json2.js"></script>
      <script src="../../js/jquery-1.7.1.min.js"></script>
      <script src="../../js/jquery-ui-1.8.20.custom.min.js"></script> <!-- for sortable example -->
      <script src="../../bootstrap/js/bootstrap.min.js"></script>

  </head>

  <body>


    <div class="container">


<link href="../../js/select2/select2.css" rel="stylesheet"/>
<script src="../../js/select2/select2.js"></script>

<script id="script_e1">

$(function() {
 //  var opts=$("#source").html(), opts2="<option></option>"+opts;
  // $("select.populate").each(function() { var e=$(this); e.html(e.hasClass("placeholder")?opts2:opts); });
});

</script>
      <article class="row" id="basics">
        <div class="span4">
          <h3>The Basics</h3>
           <label for="source">Select2 can take a regular select box like this:</label>

           <p><select style="width:300px" id="source">
               <optgroup label="Alaskan/Hawaiian Time Zone">
                   <option value="AK">Alaska</option>
                   <option value="HI">Hawaii</option>
               </optgroup>
               <optgroup label="Pacific Time Zone">
                   <option value="CA">California</option>
                   <option value="NV">Nevada</option>
                   <option value="OR">Oregon</option>
                   <option value="WA">Washington</option>
               </optgroup>
               <optgroup label="Mountain Time Zone">
                   <option value="AZ">Arizona</option>
                   <option value="CO">Colorado</option>
                   <option value="ID">Idaho</option>
                   <option value="MT">Montana</option><option value="NE">Nebraska</option>
                   <option value="NM">New Mexico</option>
                   <option value="ND">North Dakota</option>
                   <option value="UT">Utah</option>
                   <option value="WY">Wyoming</option>
               </optgroup>
               <optgroup label="Central Time Zone">
                   <option value="AL">Alabama</option>
                   <option value="AR">Arkansas</option>
                   <option value="IL">Illinois</option>
                   <option value="IA">Iowa</option>
                   <option value="KS">Kansas</option>
                   <option value="KY">Kentucky</option>
                   <option value="LA">Louisiana</option>
                   <option value="MN">Minnesota</option>
                   <option value="MS">Mississippi</option>
                   <option value="MO">Missouri</option>
                   <option value="OK">Oklahoma</option>
                   <option value="SD">South Dakota</option>
                   <option value="TX">Texas</option>
                   <option value="TN">Tennessee</option>
                   <option value="WI">Wisconsin</option>
               </optgroup>
               <optgroup label="Eastern Time Zone">
                   <option value="CT">Connecticut</option>
                   <option value="DE">Delaware</option>
                   <option value="FL">Florida</option>
                   <option value="GA">Georgia</option>
                   <option value="IN">Indiana</option>
                   <option value="ME">Maine</option>
                   <option value="MD">Maryland</option>
                   <option value="MA">Massachusetts</option>
                   <option value="MI">Michigan</option>
                   <option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
                   <option value="NY">New York</option>
                   <option value="NC">North Carolina</option>
                   <option value="OH">Ohio</option>
                   <option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
                   <option value="VT">Vermont</option><option value="VA">Virginia</option>
                   <option value="WV">West Virginia</option>
               </optgroup>
              </select>
         </p>
        </div>
        
      </article>

      


        <article class="row" id="programmatic">
<script id="script_e8">
$(document).ready(function() {

$("#e8_2").select2({placeholder: "Select a state"});
$("#e8_2_get").click(function () { alert("Selected value is: "+$("#e8_2").select2("val"));});
$("#e8_2_set").click(function () { $("#e8_2").select2("val", ["CA","BC"]); });
$("#e8_2_get2").click(function () { alert("Selected value is: "+JSON.stringify($("#e8_2").select2("data")));});
$("#e8_2_set2").click(function () { $("#e8_2").select2("data", [{id: "CA", text: "California"},{id:"MA", text: "Massachusetts"}]); });
$("#e8_2_cl").click(function() { $("#e8_2").select2("val", ""); });
$("#e8_2_open").click(function () { $("#e8_2").select2("open"); });
$("#e8_2_close").click(function () { $("#e8_2").select2("close"); });
});
</script>
            <div class="span4">
            <h3><label for="e8">Programmatic Access</label></h3>

             </p>
                <p>
                  <input type="button" class="btn-primary" id="e8_2_get" value="Alert selected value"/>
                  <input type="button" class="btn-info" id="e8_2_set" value="Set to California and Massachusetts"/>
                  <input type="button" class="btn-primary" id="e8_2_get2" value="Alert selected value using data"/>
                  <input type="button" class="btn-info" id="e8_2_set2" value="Set to California and Massachusetts using data"/>
                    <input type="button" class="btn-info" id="e8_2_cl" value="Clear"/>
                    <input type="button" class="btn-warning" id="e8_2_open" value="Open"/>
                  <input type="button" class="btn-warning" id="e8_2_close" value="Close"/>
                </p>
             <label for="e8_2">Populate</label>

              <p>
                  <select id="e8_2" multiple style="width:300px" class="populate">
				  
				  		<option>AB</option>
						<option>BC</option>
						<option>CA</option>
						<option>MA</option>
						</select><br/>
              </p>
          </div>
        

      

      


      </section>

</div></body>