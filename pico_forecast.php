<?php

/**
* A plugin that pulls weather data from forecast.io
* @author Jeremy Ross
* @link http://jeremyrosscreative.com
* @license http://opensource.org/licenses/MIT
*/

class Pico_Forecast {
	private $config;

	private $locations;

	public function __construct() {
		$plugin_path = dirname(__FILE__);

		if(file_exists($plugin_path .'/pico_forecast_conf.php')){
			global $pico_forecast_conf;
			include_once($plugin_path .'/pico_forecast_conf.php');
			$this->config = $pico_forecast_conf['config'];
			$this->locations = $pico_forecast_conf['locations'];
		}
	}

	public function before_render(&$twig_vars, &$twig) {
		// URL format: https://api.forecast.io/forecast/0233cf355c4dfe1b6e486d034efcd680/37.8267,-122.423

		foreach ($this->locations as $k => $location) {
			$url = 'https://api.forecast.io/forecast/' . $this->config['apikey'] . '/' . $location['lat'] . ',' . $location['long'];
			$twig_vars['forecast'][$k]['name'] = $location['name'];
			$data = $this->get_forecast_data($url);
			//$twig_vars['forecast_script'] = '';

			$current_temp = round($data['currently']['temperature']) . "&deg;";
			$current_time = date('M j, Y H:i:s', $data['currently']['time']);
			$high_temp = round($data['daily']['data']['0']['temperatureMax']) . "&deg;";
			$low_temp = round($data['daily']['data']['0']['temperatureMin']) . "&deg;";

			//Elements: Pull these in to the template to create a customer theme
			//$twig_vars['forecast']['debug'] = var_dump($data['currently']);
			$twig_vars['forecast'][$k]['current_temp'] = $current_temp;
			$twig_vars['forecast'][$k]['current_time'] = $current_time;
			$twig_vars['forecast'][$k]['summary'] = $data['currently']['summary'];
			$twig_vars['forecast'][$k]['high_temp'] = $high_temp;
			$twig_vars['forecast'][$k]['low_temp'] = $low_temp;
			$twig_vars['forecast'][$k]['icon'] = $data['currently']['icon'];

			//Theme 1: a predefined layout option
			$twig_vars['forecast_theme1'][$k] = "
				<div class=\"weather\">
					<h2>{$location['name']}</h2>
					<h1>$current_temp</h1>
					<p>{$data['currently']['summary']}</p>
					<canvas id='{$data['currently']['icon']}-{$location['name']}' width=\"128\" height=\"128\"></canvas><br>
					<strong>$current_time</strong>
					<p>High: $high_temp / Low: $low_temp</p>
				</div> 
			";

			//Write JS params into script
			$twig_vars['forecast_script'] .= "skycons.add('{$data['currently']['icon']}-{$location['name']}', '{$data['currently']['icon']}');";
		}
	}	

	public function get_forecast_data($url) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		$output = curl_exec($ch);
		$output = json_decode($output, true);
		return $output;
	}
}