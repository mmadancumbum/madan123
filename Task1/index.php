<!DOCTYPE html>
<html>
<header>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</header>
<body>
<center>
<form action="" id="form1" style="margin-top:50px">
  <label for="week">Select a week:</label>
  <input type="week" id="week" name="week" min='2022-W32' max='2022-W34' onchange='this.form.submit()'>
</form>
</center>

  <?php

	if(isset($_GET['week'])) {
		$week = $_GET['week'];
		$week_no = substr($week,6);
		//echo $week_no;
		if($week_no <= 31 || $week_no > 34)
		{
  ?>
			<script>alert('Select Week between 31 and 33');</script>
  <?php
        }		
		$xmlfile = file_get_contents('data.xml');
		$new = simplexml_load_string($xmlfile);
		$con = json_encode($new);
		$newArr = json_decode($con, true);
		
		$market_team_emp = ['emp1','emp2','emp3'];
		$technical_team_emp = ['emp4','emp5','emp6'];
	?>
	
  <table id="main_table" align="center" border="1" style="margin-top:20px;width:70%" class="table">
	<thead class="thead-dark">
	<tr>
		<th colspan=9 style="text-align:center"><?php echo "Week No: ".$week_no ?></th>
    </tr>
    <tr>
		<th>#</th>
		<th scope="col">Monday</th>
		<th scope="col">Tuesday</th>
		<th scope="col">Wednesday</th>
		<th scope="col">Thurday</th>
		<th scope="col">Friday</th>
		<th scope="col">Saturday</th>
		<th scope="col">Sunday</th>
		<th scope="col">Total</th>
    </tr>
   </thead>
	<tr style="background-color:grey;color:white">
		<th>Marketing Team</th>
		<th>24:00</th>
		<th>24:00</th>
		<th>24:00</th>
		<th>24:00</th>
		<th>24:00</th>
		<th>00:00</th>
		<th>00:00</th>
		<th>Marketing Total</th>
	</tr>
	<?php
	$week_val = "week".$week_no;
	
	foreach($market_team_emp as $emp1)
	{
		$market_list = $newArr['Marketing_Team'][$week_val][$emp1];
		
	?>
	
	<tr id="row1">
		<td style="text-align:center"><?php echo $emp1; ?></th>
		<td contenteditable='true' id="<?php echo $emp1.'1'; ?>"><?php echo $market_list['monday']; ?></td>
		<td contenteditable='true' id="<?php echo $emp1.'2'; ?>"><?php echo $market_list['tuesday']; ?></td>
		<td contenteditable='true' id="<?php echo $emp1.'3'; ?>"><?php echo $market_list['wednesday']; ?></td>
		<td contenteditable='true' id="<?php echo $emp1.'4'; ?>"><?php echo $market_list['thursday']; ?></td>
		<td contenteditable='true' id="<?php echo $emp1.'5'; ?>"><?php echo $market_list['friday']; ?></td>
		<td contenteditable='true' id="<?php echo $emp1.'6'; ?>"><?php echo $market_list['saturday']; ?></td>
		<td contenteditable='true' id="<?php echo $emp1.'7'; ?>"><?php echo $market_list['sunday']; ?></td>
		<td contenteditable='true' id="<?php echo $emp1.'total'; ?>"></td>
	</tr>
	
	<?php
	}
	?>
	
	<tr style="background-color:grey;color:white">
		<th>Technical Team</th>
		<th>24:00</th>
		<th>24:00</th>
		<th>24:00</th>
		<th>24:00</th>
		<th>24:00</th>
		<th>00:00</th>
		<th>00:00</th>
		<th>Technical Total</th>
	</tr>
	
	<?php
	
	foreach($technical_team_emp as $emp2)
	{
		$technical_list = $newArr['Technical_Team'][$week_val][$emp2];
	?>
	<tr>		
		<td style="text-align:center"><?php echo $emp2; ?></th>
		<td contenteditable='true' id="<?php echo $emp2.'1'; ?>"><?php echo $technical_list['monday']; ?></td>
		<td contenteditable='true' id="<?php echo $emp2.'2'; ?>"><?php echo $technical_list['tuesday']; ?></td>
		<td contenteditable='true' id="<?php echo $emp2.'3'; ?>"><?php echo $technical_list['wednesday']; ?></td>
		<td contenteditable='true' id="<?php echo $emp2.'4'; ?>"><?php echo $technical_list['thursday']; ?></td>
		<td contenteditable='true' id="<?php echo $emp2.'5'; ?>"><?php echo $technical_list['friday']; ?></td>
		<td contenteditable='true' id="<?php echo $emp2.'6'; ?>"><?php echo $technical_list['saturday']; ?></td>
		<td contenteditable='true' id="<?php echo $emp2.'7'; ?>"><?php echo $technical_list['sunday']; ?></td>
		<td contenteditable='true' id="<?php echo $emp2.'total'; ?>"></td>		
	</tr>

	<?php	
	}
	?>
	
	<tr style="background-color:grey;color:white">		
		<td colspan = 7></td>
		<td>Total Time</td>
		<td id="grand_total"></td>		
	</tr>
	<?php
	}
	?>
</table>

</body>
</html>

<script type="text/javascript">
	  
	 $(document).ready(function () {
        additionFunction();
    });
	
	$("td").blur(function () {
        additionFunction();
    });
	
	function additionFunction(){
		
		  let market_team_emp = ['emp1','emp2','emp3'];
		  let technical_team_emp = ['emp4','emp5','emp6'];
		  let total_team_emp = market_team_emp.concat(technical_team_emp);
		  
		  const total_hours_list = [];
		  const total_mins_list = [];
		  
		 for (let i = 0; i < total_team_emp.length; i++) 
		 {	
			  var col1 = (document.getElementById(total_team_emp[i]+1)).innerText;
			  var col2 = (document.getElementById(total_team_emp[i]+2)).innerText;
			  var col3 = (document.getElementById(total_team_emp[i]+3)).innerText;
			  var col4 = (document.getElementById(total_team_emp[i]+4)).innerText;
			  var col5 = (document.getElementById(total_team_emp[i]+5)).innerText;
			  var col6 = (document.getElementById(total_team_emp[i]+6)).innerText;
			  var col7 = (document.getElementById(total_team_emp[i]+7)).innerText;
			  
			  var hour1 = parseInt(col1.substr(0,2));
			  var hour2 = parseInt(col2.substr(0,2));
			  var hour3 = parseInt(col3.substr(0,2));
			  var hour4 = parseInt(col4.substr(0,2));
			  var hour5 = parseInt(col5.substr(0,2));
			  var hour6 = parseInt(col6.substr(0,2));
			  var hour7 = parseInt(col7.substr(0,2));
			  
			  var total_hour = hour1 + hour2 + hour3 + hour4 + hour5 + hour6 + hour7;
			  //alert(total_hour);
			  
			  var min1 = parseInt(col1.substr(col1.indexOf(':') + 1));
			  var min2 = parseInt(col2.substr(col2.indexOf(':') + 1));
			  var min3 = parseInt(col3.substr(col3.indexOf(':') + 1));
			  var min4 = parseInt(col4.substr(col4.indexOf(':') + 1));
			  var min5 = parseInt(col5.substr(col5.indexOf(':') + 1));
			  var min6 = parseInt(col6.substr(col6.indexOf(':') + 1));
			  var min7 = parseInt(col7.substr(col7.indexOf(':') + 1));
			  
			  var total_min = min1 + min2 + min3 + min4 + min5 + min6 + min7;
			  
			  if((total_min < 60) && (total_min.toString().length < 2))
			  {
				total_min = '0'+ total_min;
			  }
			  
			  if(total_min >= 60)
			  {
				var res = mintohour(total_min);
				console.log(res);
				total_hour = total_hour + res[0];
				total_min = res[1];
				
				if(total_min.toString().length < 2)
				{
					total_min = '0'+ total_min;
				}

				total_time = total_hour + ':' + total_min;
			 }
		  
		  total_time = total_hour + ':' + total_min;
		  document.getElementById(total_team_emp[i]+"total").innerHTML = total_time;		  
		 
		  total_hours_list[i] = total_hour;
		  total_mins_list[i] = total_min;		  
		 }
		 
		 function1(total_hours_list, total_mins_list);
	  };
	  
	  function function1(total_hours_list, total_mins_list)
	  {
		 var Grand_total_hours = total_hours_list.reduce(function(a, b){
         return a + b;
		 }, 0);
		 
		var total_mins_list1 = total_mins_list.map(function (x) { 
		  return parseInt(x, 10); 
		});
		
		  var Grand_total_mins = total_mins_list1.reduce(function(a, b){
         return a + b;
		 }, 0);
		 
		 if((Grand_total_mins < 60) && (Grand_total_mins.toString().length < 2))
		 {
			Grand_total_mins = '0'+ Grand_total_mins;
		 }
		 
		 if(Grand_total_mins >= 60)
		 {
			var res1 = mintohour(Grand_total_mins);
			Grand_total_hours = Grand_total_hours + res1[0];
			Grand_total_mins = res1[1];
			
			if(Grand_total_mins.toString().length < 2)
			{
				Grand_total_mins = '0'+ Grand_total_mins;
			}

			gramd_total_time = Grand_total_hours + ':' + Grand_total_mins;
		 }
		 
		 gramd_total_time = Grand_total_hours + ':' + Grand_total_mins;		 
		 console.log(Grand_total_mins);
		 document.getElementById("grand_total").innerHTML = gramd_total_time;
		 
	  }
	  
	  //convert mins more than 60 to hour and min
	  function mintohour(mins)
	  {
		  var quo = Math.floor(mins/60);
		  var rem = mins%60;
		  var res = [quo, rem]; 
		  return res;
	  }
</script>
