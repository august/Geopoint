<?php
/**
 * A small class that helps manage latitude, longitude, and altitude points
 * and calculates distance and compass heading between points
 *
 * @author August Trometer (http://getyowza.com/contact)
 */

class Geopoint {

    public $latitude;
    public $longitude;
    public $altitude;

    private $_sphericalRadius;

    // the mean radius of the earth in meters
    // http://en.wikipedia.org/wiki/Earth_radius#Mean_radius
    const EARTH_RADIUS = 6371009; // meters
    

    // latitude, longitude is the ISO standard
    // http://en.wikipedia.org/wiki/ISO_6709
    function __construct($latitude, $longitude, $altitude = 0) {

        $this->latitude = floatval($latitude);
        $this->longitude = floatval($longitude);
        $this->altitude = floatval($altitude);

    } // __construct()


    /**
     * The distance between two points, calculated using the
     * haversine formula which accounts for the spherical shape of the earth
     * http://en.wikipedia.org/wiki/Haversine_formula
     * @param  Geopoint $geopoint The point to calculate the distance to
     * @param  string $unit The unit of measurement (m = meters, mi = miles)
     * @return float Distance in meters
     */
    public function distanceToPoint(Geopoint $geopoint, $unit = 'm') {

        $lat_1 = $this->latitude;
        $lon_1 = $this->longitude;
        $lat_2 = $geopoint->latitude;
        $lon_2 = $geopoint->longitude;
        $alt_1 = $this->altitude;
        $alt_2 = $geopoint->altitude;


        // the default is meters
        if (!in_array($unit, array('m','mi')))
            $unit = 'm';

        $lat_delta = $lat_1 - $lat_2;
        $lon_delta = $lon_1 - $lon_2;

        $fraction = 2 * asin(sqrt(pow(sin(deg2rad($lat_delta / 2)), 2) + cos(deg2rad($lat_1)) * cos(deg2rad($lat_2)) * pow(sin(deg2rad($lon_delta / 2)), 2)));

        $distance = $this->sphericalRadius() * $fraction;

        // take into account the altitude
        $altitude_delta = abs($alt_1 - $alt_2);

        // while not wholly accurate (it does not take into consideration possible line-of-sight)
        // distances, in most situations, this is more than accurate enough
        $distance = sqrt(pow($distance, 2) + pow($altitude_delta, 2));

        // convert to miles, if necessary
        if ($unit == 'mi')
            $distance = $distance / 1609.344;

        return $distance;

    } // distanceToPoint()


    /**
     * Returns the compass heading to the new point in degrees
     * 0 = North, 90 = East, 180 = South, 270 = West
     * @param  Geopoint $point The point to calculate the heading to
     * @return float The heading angle in degrees
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


    /**
     * Returns the spherical radius to use for calculations
     * The default is to return the Earth's radius
     * @return float The radius of the sphere
     */
    public function sphericalRadius() {

        if (isset($this->_sphericalRadius))
            return $this->_sphericalRadius;

        // the default is to use the earth's radius
        return self::EARTH_RADIUS;

    } // sphericalRadius()


    /**
     * Sets the spherical radius of the globe to use in calculations
     * @param  float $radius The radius of the globe
     * @return void
     */
    public function setSphericalRadius($radius) {

        $this->_sphericalRadius = $radius;

    } // setSphericalRadius()

} // class Geopoint
