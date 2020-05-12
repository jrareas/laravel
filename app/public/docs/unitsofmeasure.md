## Introduction
This API purpose is to convert supported Physical units of measure. 
## RESTFull API
This is a RESTFull api and it will respond to requests as per its concepts
## Supported Physical Quantities
This are accepted values for the units of measure

|Phisical Quantities|Terms Accepted|
|---|---|
|Accelaration|`m/s^2`, `m/s²`,`meter per second squared`|
|Angle|`rad`,`deg`,`arcmin`,`arcsec`|
|Area|`m^2`,`mm^2`,`cm^2`,`dm^2`,`km^2`,`ft^2`,`in^2`,`mi^2`,`yd^2`,`are`,`decare`,`hectare`,`acres`|
|Eletric Current|`amps`|
|Energy|`joule`,`watt hour`|
|Length|`meter`,`foot`,`inch`,`mile`,`yard`,`nautical mile`,`mil`,`astronomical unit`|
|Mass|`lb`,`kg`,`tons`,`ounce`,`stones`|
|Press|`pascal`,`atmospheres`,`inches of mercury`,`millimeters of mercury`,`pounds per square inch`|
|Quantity|`moles`|
|Solid Angle|`steradians`|
|Temperature|`kelvin`,`celsius`,`C`,`fahrenheit`,`F`,`delisle`,`D`,`newton`,`N`,`°Ro`,`°Re`|
|Time|`sec`,`s`,`min`,`m`,`hr`,`h`,`day`,`d`,`wk`,`w`,`year`,`y`,`decade`,`century`,`millennium`,`julian year`,`jyr`|
|Velocity|, Meters per second(`m/s`,`meters per second`,`meter per second`,`metres per second`,`metre per second`), Kilometers per hour:(`km/h`,`km/hour`,`kilometer per hour`,`kilometers per hour`,`kilometre per hour`,`kilometres per hour`), Feet per second:(`ft/s`,`feet/sec`,`feet/second`), Miles per hour: (`mph`,`miles/hour`,`miles per hour`), Knots: (`knot`,`knot2`)|
|Volume|`m^3`,`m³`,`mm^3`,`cubic millimeter`,`cm^3`,`cubic centimeter`,`dm^3`,`cubic decimeter`,`km^3`,`cubic kilometer`,`ft^3`,`cubic foot`,`in^3`,`cubic inch`,`yd^3`,`cubic yard`,`ml`,`milliliter`, `cl`,`centiliter`,`dl`,`deciliter`,`l`,`liter`,`dal`,`decaliter`,`hl`,`hectoliter`,`cup`,`cups`,`tsp`,`teaspoon`,`tbsp`,`tablespoon`,`gal`,`gallon`,`qt`,`quart`,`fl oz`,`fluid ounce`,`pt`,`pint`|

## Physical Quantities supported
* accelaration
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

## Authorization
This Api is protect by authorization layer. If you are accessing through RapidApi, you dont need to worry about this as RapidApi will provide the necessary authorization.

To make a request to the API you will need to be a registered customer and subscribe at [the api toolbox website](https://theapitoolbox.com/register).

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

## Example Request

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

## Example Response

```$xslt
{
    "data": 2.7215542200000002
}
```

