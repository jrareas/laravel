## Address Validation
Return whether the domain is available or not. When taken, it will return some basic owner data


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
curl --location --request GET 'https://theapitoolbox.com/api/whois/google.ca' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json'
--header 'Authorization: Bearer <token>
```

## Example Response

```$xslt
{
    "available": false,
    "data": {
        "Domain created": "2020-02-22",
        "Domain expires": "2022-02-22",
        "Domain owner": "OWNER NAME"
    }
}
```