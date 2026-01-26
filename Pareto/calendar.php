<?php
/* Database connection to test database */
$connection = mysql_connect('localhost','root','');
if (!$connection)
{
die('Could not connect: ' . mysql_error());
}
mysql_select_db("KingVision",$connection);
?>
<html>
<header>
<style type="text/css">
/* select styles*/
ol.date_select{
	margin: 0;
	padding: 0;
	list-style: none;
	display: inline;
}

/* calendar */
table.calendar { 
  border-left:1px solid #999; 
  }

tr.calendar-row	{  }

td.calendar-day	{ 
  min-height:80px; 
  font-size:11px;
  position:relative;
  }
  
* html div.calendar-day 
  { height:80px; }

td.calendar-day:hover {
  background:#eceff5;
  }
  
td.calendar-day-np {
  background:#fff;
  min-height:80px;
  } 
  
* html div.calendar-day-np {
  height:80px;
  }

td.calendar-day-head {
  text-transform: uppercase;
  background: #fff;
  font-weight: bold;
  text-align: center;
  width: 120px;
  padding: 5px;
  border-bottom: 1px solid #999;
  border-top:1px solid #999;
  border-right:1px solid #999;
  }
  
div.day-number {
  background:#FFF;
  padding: 0px;
  color:#000;
  font-weight:bold;
  float:left;
  margin: -30px 0 0 0;
  width:20px;
  /*text-align:center;*/
  }

/* shared styles */
td.calendar-day, td.calendar-day-np {
  width:120px;
  height: 120px;
  padding:5px;
  border-bottom:1px solid #999;
  border-right:1px solid #999;
  }
</style>
</header>
<body>

<!-- This code is required before the form if it posts to itself and if there is no data set to current month -->
<?php
if(isset($_POST['submit']))
{	
	$timezone = (date_default_timezone_set("America/Bogota"));
    $year_select = $_POST['year_select'];
	 $month_select = $_POST['month_select'];
 // for debug   echo "User Has submitted the form so the calendar for <b> $month_select/$year_select </b> is displayed below:";
} else if(!isset($_POST['submit']))
{
	$timezone = (date_default_timezone_set("America/Bogota"));
	$year_select = date('Y');
	$month_select = date('m');
}
?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
	<fieldset><h1>Events Calendar</h1>
		<ol class="date_select">
			<li>
				<select id="month" name="month_select" onchange='this.form.submit()'>
					<option value="">please select month</option>
					 <option value="0">January</option>
				    <option value="1">February</option>
				    <option value="2">March</option>
				    <option value="3">April</option>
				    <option value="4">May</option>
				    <option value="5">June</option>
				    <option value="6">July</option>
				    <option value="7">August</option>
				    <option value="8">September</option>
				    <option value="9">October</option>
				    <option value="10">November</option>
				    <option value="11">December</option>
				</select>
			</li>
			<li>
				<select id="year" name="year_select" onchange='this.form.submit()'>
					<option value="">please select year</option>
					<option value="2018">2018</option>
					<option value="2019">2019</option>
					<option value="2020">2020</option>
					<option value="2021">2021</option>
					<option value="2022">2022</option>
				</select>
			</li>
			<li>
				<input type="submit" name="submit" value="submit form">
			</li>
		</ol>	
	</fieldset>
	</form>
<?php
/* draws a calendar */
function draw_calendar($month,$year,$events = array()){
  /* draw table */
  $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';
  /* table headings */
  $headings = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
  $calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';
	$month = ((int) $month) + 1  ;
		if ($month < 10) {
		$month = "0" . ((string) $month);	
		}else{
			$month = (string) $month;
		}
		
  /* days and weeks vars now ... */
  $timezone = (date_default_timezone_set("Europe/London"));
  $running_day = date('w',mktime(0,0,0,$month,1,$year));
  $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
  $days_in_this_week = 1;
  $day_counter = 0;
  $dates_array = array();
  /* row for week one */
  $calendar.= '<tr class="calendar-row">';
  /* print "blank" days until the first of the current week */
  for($x = 0; $x < $running_day; $x++):
    $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
    $days_in_this_week++;
  endfor;
	//$events = array();
	
	
	
  /* keep going with days.... */
  for($list_day = 1; $list_day <= $days_in_month; $list_day++):
    $calendar.= '<td class="calendar-day">';
      /* add in the day number */
      $calendar.= '<div class="day-number">'.$list_day.'</div>';
      /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! 	echo $year; echo $month;**/
		/* Database query to get events from DB */
		
		//die((string)$month);
		//die((string)$m);
	
		//die($month);
		$day = '';
		if ($list_day < 10) {
		$day = "0" . ((string) $list_day);	
		}else{
			$day = (string) $list_day;
		}
		$event_day = $year.'-'.$month.'-'.$day;
		//die($event_day);
		if ($list_day == 24)
		{
			//die($events[$event_day]);
		}
		
		      //if(isset($events[$event_day])) {
			
		        foreach($events as $event) {
					if(($event['start_time'] == $event_day || $event['end_time'] == $event_day) || ($event['start_time'] < $event_day && $event['end_time'] > $event_day)){
						$calendar.= '<div class="event">'.$event['post_title'].'</div>';
					}
		          
		        }
		      //}
		      //else {
		
		
      //$calendar.= str_repeat('<p>&nbsp;</p>',2);
   //}
    $calendar.= '</td>';
    if($running_day == 6):
      $calendar.= '</tr>';
      if(($day_counter+1) != $days_in_month):
        $calendar.= '<tr class="calendar-row">';
      endif;
      $running_day = -1;
      $days_in_this_week = 0;
    endif;
    $days_in_this_week++; $running_day++; $day_counter++;
  endfor;
  /* finish the rest of the days in the week */
  if($days_in_this_week < 8):
    for($x = 1; $x <= (8 - $days_in_this_week); $x++):
      $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
    endfor;
  endif;
  /* final row */
  $calendar.= '</tr>';
  /* end the table */
  $calendar.= '</table>';
  
  /* all done, return result */
  return $calendar;
}
/* array so we can display the actual month instead of the integer value from the drop down */
$actual_month = array ('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
/* get the previous month function 
$previous_month = $month_select - 1;
$next_month = $month_select + 1;*/
$previous_month_link = '<a href="?month='.($month_select != 1 ? $month_select - 1 : 12).'&year='.($month_select != 1 ? $year_select : $year_select - 1).'" class="control"><<   Previous Month</a>';
$next_month_link = '<a href="?month='.($month_select != 12 ? $month_select + 1 : 1).'&year='.($month_select != 12 ? $year_select : $year_select + 1).'" class="control">Next Month >></a>';
/* draw calendar navigation */
echo $previous_month_link;
echo "<h2>". $actual_month[$month_select]; echo "&nbsp;". $year_select."</h2>";
echo $next_month_link;
$month = '';
if ($month_select < 10) {
	$month = "0".($month_select + 1);	
}else{
	$month = $month_select + 1;
}
echo $query = "SELECT descripcion as post_title, DATE_FORMAT(fecha,'%Y-%m-%d') AS start_time, DATE_FORMAT(fecha_fin,'%Y-%m-%d') AS end_time FROM pareto_actividades WHERE fecha LIKE '$year_select-$month%' and id_usuario = '15'";
$result = mysql_query($query) or die('cannot get results!');
//die(print_r(mysql_fetch_assoc($result)));
$events = array();
$count = 0;
while($row = mysql_fetch_assoc($result)) {
	//print $row['post_title'];
	//die($row['start_time']);
  //$events[$row['start_time']][] = $row;
$events[$count] = $row;
$count++;
}
//die((string)$events[0]['post_title']);
echo draw_calendar($month_select,$year_select, $events);
?>
</body>
</html>