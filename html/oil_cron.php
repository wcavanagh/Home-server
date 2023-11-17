<?php

$command = 'curl -i -X POST \
   -H "Content-Type:application/x-www-form-urlencoded" \
   -d "is_admin_user=1" \
   -d "last_page=CURRENT_STATUS" \
   -d "prev_tank_number=1" \
   -d "last_tank_number=1" \
   -d "last_fuel_number=1" \
   -d "last_meter_number=1" \
   -d "last_total_tanks=1" \
   -d "current_status=Current Status" \
 http://192.168.5.50/cgi-bin/main.pl';
 
 $response = exec( $command );
 //echo $response;

 require dirname ( __FILE__ )."/simple_html_dom.php";
 $html = str_get_html($response);
 $values = array();
 foreach($html->find('.labelvaluenumberex') as $element){
	 //echo $element."<br>";
	 $values[] = trim($element->innertext());
 }
 foreach($html->find('.labelvaluenumber') as $element){
	 //echo $element."<br>";
	 $values[] = trim($element->innertext());
 }

 $nice_values = array();
 //var_dump( $values );
 $nice_values['tank_name'] = $values[0];
 $nice_values['product_height'] = $values[1];
 $nice_values['volume'] = $values[2];
 $nice_values['weight'] = $values[3];
 $nice_values['volume2'] = $values[4];
 $nice_values['ullage'] = $values[5];
 $nice_values['density'] = $values[6];
 $nice_values['water'] = $values[7];
 $nice_values['water_volume'] = $values[8];
 $nice_values['temperature'] = $values[9];

$html = "<html><body>";
$html.="Oil_Volume <span class='Oil_Volume'>$nice_values[volume]</span><br>";
$html.="Oil_Temperature <span class='Oil_Temperature'>$nice_values[temperature]</span><br>";
$html.="Water_Volume <span class='Water_Volume'>$nice_values[water_volume]</span><br>";
$html.="Ullage <span class='Ullage'>$nice_values[ullage]</span><br>";
$html.="</body></html>";

file_put_contents("oil-stats.html", $html);

echo "oil-stats.html generated";


