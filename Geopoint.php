<?php

/**
 * A small class that helps manage lat/lon pairs
 * that includes distance and compass heading methods
 */
class Geopoint {

    public $latitude;
    public $longitude;

    // we use the mean radius of the earth in meters
    // http://en.wikipedia.org/wiki/Earth_radius#Mean_radius
    const EARTH_RADIUS = 6371009; // meters

    function __construct($latitude, $longitude) {

        $this->latitude = $latitude;
        $this->longitude = $longitude;

    } // __construct()

    /**
     * The distance between two points, calculated using the
     * haversine formula which accounts for the spherical shape of the earth
     * http://en.wikipedia.org/wiki/Haversine_formula
     * @param  Geopoint $geopoint The point to calculate the distance to
     * @return float              Distance in meters
     */
    public function distanceToPoint(Geopoint $geopoint) {

        $lat_1 = $this->latitude;
        $lon_1 = $this->longitude;
        $lat_2 = $geopoint->latitude;
        $lon_2 = $geopoint->longitude;

        $lat_delta = $lat_1 - $lat_2;
        $lon_delta = $lon_1 - $lon_2;

        $fraction = 2 * asin(sqrt(pow(sin(deg2rad($lat_delta / 2)), 2) + cos(deg2rad($lat_1)) * cos(deg2rad($lat_2)) * pow(sin(deg2rad($lon_delta / 2)), 2)));

        $distance = self::EARTH_RADIUS * $fraction;

        return $distance;

    } // distanceToPoint()


    /**
     * Returns the compass heading to the new point in degrees
     * 0 = North, 90 = East, 180 = South, 270 = West
     * @param  Geopoint $point The point to calculate the heading to
     * @return float         The heading angle in degrees
     */
    public function compassHeadingToPoint(Geopoint $point) {

        // normalize the points so 'here' is the origin (0,0)
        $x = $point->longitude - $this->longitude;
        $y = $point->latitude - $this->latitude;

        // if we're at (0,0)
        if ($x == 0 && $y == 0)
            return 0;

        // we only want positive angle values
        $angular_offset = ($x < 0 ? 360 : 0);

        $angle = rad2deg(atan2($x, $y)) + $angular_offset;

        return $angle;

    } // compassHeadingToPoint()

} // class Geopoint