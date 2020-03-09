## Introduction
This API purpose is to convert supported Physical units of measure. 
## RESTFull API
This is a RESTFull api and it will respond to requests as per its concepts
## Supported Physical Quantities
This are accepted values for the units of measure
* Accelaration
    * Meters per second
        * m/s^2
        * m/s²
        * meter per second squared
        * meters per second squared
        * metre per second squared
        * metres per second squared
* Angle
    * rad
    * deg
    * arcmin
    * arcsec
* Area
    * m^2
    * mm^2
    * cm^2
    * dm^2
    * km^2
    * ft^2
    * in^2
    * mi^2
    * yd^2
    * are
    * decare
    * hectare
    * acres
* Eletric Current
    * amps
* Energy
    * joule
    * watt hour
* Length
    * meter
    * foot
    * inch
    * mile
    * yard
    * nautical mile
    * mil
    * astronomical unit
* Velocity
    * Meters per second
        * m/s
        * meters per second
        * meter per second
        * metres per second
        * metre per second
    * Kilometers per hour
        * km/h
        * km/hour
        * kilometer per hour
        * kilometers per hour
        * kilometre per hour
        * kilometres per hour
    * Feet per second
        * ft/s
        * feet/sec
        * feet/second
    * Miles per hour
        * mph
        * miles/hour
        * miles per hour
    * Knots
        * knot
        * knot2
* Mass

# Physical Quantity
* accelaration
* angle
* area
* eletric_current
* energy
* length
* luminosity_intensit
* mass
* press
* quantity
* solid_angle
* temperature
* time
* velocity
* volume

# Authorization
This Api is protect by authorization layer. If you are accessing through RapidApi, you dont need to worry about this as RapidApi will provide the necessary authorization.

To make a request to the API you will need to be a registered customer. The registration is a work in progress and access through RapidAPI is the only available so far.

## Authorization Endpoint
```
curl --location --request POST 'https://theapitoolbox.com/oauth/token' \
--header 'Content-Type: application/json' \
--data-raw '{
	"grant_type" : "client_credentials",
    "client_id" : "<client_id>",
    "client_secret" : "<client_secret>"
}'
```

# Example Request

```$xslt
curl --location --request GET 'https://theapitoolbox.com/api/unitsofmeasure/mass?unitFrom=lbs&unitTo=kg&value=6' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json'
--header 'Authorization: Bearer <token>
```

In this example, a call to the API to convert 6 `lbs` to `kg`

- URI -  `api/unitsofmeasure{physical_quantity}`
- unitFrom - The unit you are making the convertion from
- unitTo - The unit you are making the convertion to
- value - the value you want to be converted

# Example Response

```$xslt
{
    "data": 2.7215542200000002
}
```

