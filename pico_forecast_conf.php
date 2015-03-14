<?php

global $pico_forecast_conf;
/*
 * Get your API key from here: https://developer.forecast.io/docs/v2
 * and place it in the variable below.
 */

$apikey = 'put your api key here';

$pico_forecast_conf['config']['apikey'] = $apikey;

/*
 * Use the array format below as a template. In order to get lat/long you can simply google "lat long city"
 * and it will kick back the coordinates that you need. If you have a more specific address you can
 * use something like http://www.findlatitudeandlongitude.com/
 * 
 * 

 * $pico_forecast_conf['locations']['london'] = array( // change ['london'] to the key you wish to use to reference the location
 *		'name' => 'London', // This will be used as a display name of the location
 *		'lat' => 51.481383,
 *		'long' => -0.131836
 *		);
 */

$pico_forecast_conf['locations']['london'] = array(
 		'name' => 'London',
 		'lat' => 51.481383,
 		'long' => -0.131836
		);