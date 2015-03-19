# Pico Forecast Plugin
This plugin is for the flat file CMS [pico](https://github.com/picocms/Pico)

This plugin pull weather data from the [forecast.io](https://developer.forecast.io/docs/v2) api. All you need to do is get an api key, and provide latitude and longitude coordinates.

Animated icons by the developers of forecast.io [skycons.js](https://github.com/darkskyapp/skycons) are also supported.

##Use
###Configuration
To configure the plugin edit the pico-forecast-conf.php file and add your api key, and an array of the locations and lat/long coordinates.

###Using template tags
There is a lot of data that can be accessed. At this time, I've only exposed a few but will add more as needed.

```twig	
{{ forecast.locationName.current_temp }}
{{ forecast.locationName.current_time }
{{ forecast.locationName.summary }}
{{ forecast.locationName.high_temp }}
{{ forecast.locationName.low_temp }}
{{ forecast.locationName.icon }}
```

Another way to pull the data into the template as a widget. I've currently created one widget and may add more.

```twig
{{ forecast_widget1.locationName }}
```

###Using Skycons
In order to use the skycons, you'll need to:

1. Download [skycons.js](https://github.com/darkskyapp/skycons) and put it in the scripts folder of the active pico theme.
2. Add this line in the header of the page templates where you'd like to display the skycons

```javascript
<script src="{{ theme_url }}/scripts/skycons.js"></script>
```
	
3. Add this script to the footer of the page templates where you'd like to display the skycons

```javascript
    <script>
		var skycons = new Skycons({"color": "#404040"}); //choose any color that fits your theme.
		{{ forecast_script }}		
		skycons.play();
	</script>
```

##Styling
Obviously you can style the widgets however you see fit, but here's a generic starting point.

```
	<style type="text/css">
		.weather {
		  width: 15%;
		  display: inline-block;
		  text-align: center;
		  border: 2px solid;
		  background: #eee;
		}
	</style>
```