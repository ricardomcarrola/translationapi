# translationapi

This is a sample application to show the way a new API could be structured. Allows translating strings using 
a free translation engine. Neither Google&trade; Translate neither Microsoft&trade; BING now offer free tiers(at least without credit card registering) for their translations services so I ended up
using a free webservice for translation.

## Configuration

check /config.ini for more configuration options

## Documentation

Check /docs for more information

## Authentication

Any request can have a set of
 * username and password
 * token
 
Note: As stated in the documentation. The right way to go would be OAUTH. Also signing the requests could be a way to
go, but these solutions offer few protection agains repetition attacks.

As it is right now :
You can issue a request for a new token and use it in subsequent requests OR make a request with the user and password.


## Routes enabled

For now the supported routes are :

 _Note: Format is optional for these both routes_

 * _GET_ /translate/?token=[USER_TOKEN]&q=[STRING_TO_TRANSLATE]&language=[LANGUAGE]&format=[OUTPUT]
 * _GET_ /token/?username=[username]&password=[password]