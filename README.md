# Geopoint

This is a small class that allows the management of latitude/longtude pairs as well as providing methods to determine the distance and compass heading to other points.

## Usage

Creating a Geopoint is simple. Simply use the latitude and longitude:

	$here = new Geopoint(33.99,-118.46); // latitude, longitude
You may also set the latitude and longitude manually:

	$here = new Geopoint();
	$here->latitude = 33.9;
	$here->longitude = -118.46;

## Calculating Distance to Another Point ##

The Geopoint class allows you to calculate the distance, in meters, to another point.

	$there = new Geopoint(33.81,-117.92);
	$distance = $here->distanceToPoint($there); 
	// returns 53707.148901519 (or 33.37 miles)

To calculate distance, the Geopoint class uses the haversine formula, which takes into account the curvature of the Earth.

## Calculating Compass Heading to Another Point ##

The Geopoint class allows you to calculate the compass heading to another point.
The value returned is the heading in degrees, with 0˚ being North, 90˚ East, 180˚ South, and 270˚ West.
	
	$distance = $here->compassHeadingToPoint($there); 
	// returns 108.43494882292 (East Souteast)

