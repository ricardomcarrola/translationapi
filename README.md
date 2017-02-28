# Simple Translation API

 #### Author : Ricardo Carrola <ricardo.carrola@gmail.com> 
 
 &copy; All rights reserved

_This is a sample application to show the way a new API could be structured. Allows translating strings using 
a free translation engine. Neither Google&trade; Translate neither Microsoft&trade; BING now offer free tiers(at least without credit card registering) for their translations services so I ended up
using a free webservice for translation._

## Base Uri for the service

https://translationapi-carrola.c9users.io

It will be public during this stage

## API Configuration

Check config.ini for more configuration options

## Online Documentation

Check https://translationapi-carrola.c9users.io/docs for more information

## Authentication information

All requests for the API should go through one of the following authentication schemas

Any request can have a set of
 * username and password
 * token
 
Note: As stated in the documentation. The right way to go would be OAUTH. Also signing the requests could be a way to
go, but these solutions offer few protection agains repetition attacks.

As it is right now :
You can issue a request for a new token and use it in subsequent requests OR make a request with the user and password.


## Routes enabled

For now the supported routes are :

 _Note: Format is optional for these both routes and language follows the ISO 639-1 code_
 
 * _GET_ https://translationapi-carrola.c9users.io//translate/?token=[USER_TOKEN]&q=[STRING_TO_TRANSLATE]&language=[LANGUAGE]&format=[OUTPUT]
 * _GET_ https://translationapi-carrola.c9users.io//token/?username=[username]&password=[password]
  
## Sample Valid Calls

* [Translate String "Casa" from PT To EN](https://translationapi-carrola.c9users.io/translate?username=admin&password=admin&q=casa&language=pt)
* [Translate String "Casa" from PT To Piglatin](https://translationapi-carrola.c9users.io/translate?username=admin&password=admin&q=casa&language=piglatin)
* [Grab a new Token for admin user](https://translationapi-carrola.c9users.io/token?username=admin&password=admin)
