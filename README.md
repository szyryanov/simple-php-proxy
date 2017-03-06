# simple-php-proxy
Very simple PHP proxy (e.g. to call API from JavaScript bypassing SameOrigin restriction)

## Usage
1. Copy `simple-php-proxy.php` to your webserver (e.g. to `/php/simple-php-proxy.php`
2. **Change `$URL_START` variable (line 6) to your API address!** By default it's set to `'http://google.com/'`, so your API calls will don't work.
3. Call the API like following: `php/simple-php-proxy.php?url=api-method`. You can use GET and POST requests.

## Acknowledgements

The code is based on [https://github.com/cowboy/php-simple-proxy](https://github.com/cowboy/php-simple-proxy) project. 
You can use the project if you need a more powerful proxy.