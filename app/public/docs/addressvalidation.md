## Address Validation
Return a set of adresses found for a specific set of parameters
## Countries Supported
* Canada
* USA
## Valid parameters

|Parameter|Required| Type| Description  | Examples   |
|---|---|---|---|---|
|country   |Y| String   | Expects the country iso 3 chars code   | CAN  |
|street_1   |Y| String   | The street name   | Dundas Street West  |
|street_2   | |String   | The street complement   | Unit 1306  |
|street_number |Y  | String   | The street address number   | 55  |
|postal_code  |Y| String   | The postal code/zip code  | M6K 0H9  |
|province   | |String   | The address province  | ON  |
|city   | |String   | The address city  | Toronto  |


## Authorization Endpoint

This Api is protect by authorization layer. If you are accessing through RapidApi, you dont need to worry about this as RapidApi will provide the necessary authorization.
To make a request to the API you will need to be a registered customer and subscribe at [the api toolbox website](https://theapitoolbox.com/register).

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
curl --location --request GET 'https://theapitoolbox.com/api/addressvalidation/validate_address?country=CAN&street_1=Speers Rd&street_number=55&postal_code=L6K 0H9' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json'
--header 'Authorization: Bearer <token>
```

## Example Response

```$xslt
{
    "addresses": [
        {
            "street_1": {
                "0": "55 Speers Rd"
            },
            "street_2": null,
            "street_number": "55",
            "city": "Oakville",
            "province": " ON",
            "country": "CAN",
            "postal_code": " L6K 0H9"
        },
        {
            "street_1": {
                "0": "55 Speers Rd"
            },
            "street_2": null,
            "street_number": "55",
            "city": "Oakville",
            "province": " ON",
            "country": "CAN",
            "postal_code": " L6K 0H9 - 252 Addresses"
        },
        {
            "street_1": {
                "0": "55 Speers Road"
            },
            "street_2": null,
            "street_number": "55",
            "city": "Oakville",
            "province": " ON",
            "country": "CAN",
            "postal_code": " L6K 0H9 - 6 Addresses"
        }
    ],
    "status": true
}
```