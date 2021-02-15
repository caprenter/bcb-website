<?php
/*
Plugin Name:  BCB 4 Week Rotation 
Plugin URI:   N/A
Description:  Creates a list of Monday Dates and their correspoding week in the 4 week rotation
Version:      1
Author:       caprenter@gmail.com
Author URI:   n/a
License:      GPL3
License URI:  https://www.gnu.org/licenses/gpl-3.0.html
Text Domain:  n/a
Domain Path:  n/a
*/
/*
BCB 4 Week Rotation  is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.
 
BCB 4 Week Rotation  is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with BCB 4 Week Rotation. If not, see <https://www.gnu.org/licenses/>.
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );



function wp_fourweekrota_shortcode() {

	// begin output buffering
    ob_start();
    
	$str = '2020-12-21'; //week 2 NB First result will be the week after this because we increment immediately
	$week = 1; //set it two earlier because we increment straight away, and array keys start at zero, so $week = 0 returns 'one'
	$readable_week = array( 'One', 'Two', 'Three', 'Four');
	$month = "";
	$html = "";
	$time = strtotime($str);
	
	for($i=7; $i<412; $i+=7) {
		
		$week +=1;
		
		if ($week >=4) {
			$week = $week % 4;
		}
		
		$time += 7*24*60*60;
		$date = date('d-M', $time);
		
		if ($month != date('M', $time)) {
			$month = date('M', $time);
			$html .= '<p class="month">' . date('F Y', $time) . "</p>";
		}	
		$html .=  $date . " Week " . $readable_week[intval($week)] . "<br>";
	}
	print($html);
	
	// end output buffering, grab the buffer contents, and empty the buffer
    return ob_get_clean();
 }
 
 add_shortcode('fourweekrota', 'wp_fourweekrota_shortcode');
