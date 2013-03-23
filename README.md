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

The Geopoint class allows you to calculate the distance to another point. The default response returns meters.

	$there = new Geopoint(33.81,-117.92);
	$distance = $here->distanceToPoint($there); 
	// returns 53707.148901519 (or 33.37 miles)

	// to return miles instead of meters
	$distance = $here->distanceToPoint($there, 'mi');
	// returns 33.372075144605

To calculate distance, the Geopoint class uses the haversine formula, which takes into account the curvature of the planet.

## Customizing the Radius ##

The Geopoint class uses the Earth's radius as the default, but allows you to customize the radius of the planet if necessary.

	// say we're on Mars
	$here->setSphericalRadius(3389500);

	$distance = $here->distanceToPoint($there);
	// returns 28573.241883931 (17.75 miles)

## Calculating Compass Heading to Another Point ##

The Geopoint class allows you to calculate the compass heading to another point.
The value returned is the heading in degrees, with 0˚ being North, 90˚ East, 180˚ South, and 270˚ West.
	
	$distance = $here->compassHeadingToPoint($there); 
	// returns 108.43494882292 (East Souteast)
