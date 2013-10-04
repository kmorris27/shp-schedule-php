<HTML>
	<HEAD>
		<TITLE>SHP Schedule</TITLE>
	</HEAD>
	<BODY>
		<P>SHP Schedule</P>
		<?php
			$what = $_SERVER['QUERY_STRING'];			
			if ($what!=="")
			{
				$day = $what;
			}
				else
			{
				$day = date("n-d-Y");
			}
			
			$date = date_parse_from_format("m-d-Y", $day);			
			$date_dmy = $date['day']."-".$date['month']."-".$date['year'];
			
			$timestamp = strtotime($date_dmy);
			
			$tomorrow_timestamp= strtotime("+1 day", $timestamp);
			$tomorrow = date("m-d-Y", $tomorrow_timestamp);
			
			$yesterday_timestamp= strtotime("-1 day", $timestamp);
			$yesterday = date("m-d-Y", $yesterday_timestamp);
			
			$day_formatted = date("l, F j", $timestamp);

			print("<P><B>$day_formatted</B>  <A HREF='index.php?$yesterday'>Yesterday</A>   <A HREF='index.php?$tomorrow'>Tomorrow</A></P>");
			
			$dates = file_get_contents("kmo/dates.txt");
			$date_array = split("\n", $dates);
			
			for ($i=0; $i<count($date_array); $i++)
			{
				$line = $date_array[$i];
				$line_array = split("\t", $line);
				if ($day == $line_array[0])
				{
					$schedule_name = trim($line_array[1]);
					print("<H2>$schedule_name</H2>");
					break;
				}
			}
			
			$schedule = file_get_contents("kmo/".$schedule_name.".txt");
			$schedule_array = split("\n", $schedule);
			for ($i=0; $i<count($schedule_array); $i++)
			{
				$schedule_parts = split("\t", $schedule_array[$i]);
				$period = $schedule_parts[0];
				$start = $schedule_parts[1];
				$start_std = date('g:i', strtotime($start));
				$end = $schedule_parts[2];
				$end_std = date('g:i', strtotime($end));
				if ($period!=="")
				{
					print("<P>$period: $start_std to $end_std</P>");
				}
			}
			print("<P><A HREF='week.php'>Week View</A>  <A HREF='month.php'>Month View</A>");
		?>
	</BODY>
</HTML>
