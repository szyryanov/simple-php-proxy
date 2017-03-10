# simple-php-proxy
Very simple PHP proxy (e.g. to call API from JavaScript bypassing SameOrigin restriction).

## Usage
1. Copy `simple-php-proxy.php` to your webserver (e.g. to `/php/simple-php-proxy.php`
2. **Change `$URL_START` variable (line 6) to your API server address!** You can skip this step, but it is strongly recommended.
3. Call the API like following: `php/simple-php-proxy.php?url=api-method&parameter=value`. You can use GET and POST requests.

## Examples

### GET request

It's assumed that `$URL_START` is set to something like `http://api.myservice.com/`

    $.get(
	    "/php/simple-php-proxy.php?url=get-item&id=101"
	)
	.done(function(data) {
      processResult(data);
	})
	.fail(function(jqXHR, textStatus, error) {
	  console.log("jqXHR:", jqXHR, "\r\n", "textStatus:", textStatus, "\r\n", "error:", error);
	});

### POST request

It's assumed that `$URL_START` is set to something like `http://api.myservice.com/`

    $.ajax({
        method: 'POST',
        url: "/php/simple-php-proxy.php?url=save-item,
        data: {'id': '101', 'text': 'new item text'}, 
    })        
    .done(function(data) {
      processResult(data);
    })
    .fail(function(jqXHR, textStatus, error) {
      console.log("jqXHR:", jqXHR, "\r\n", "textStatus:", textStatus, "\r\n", "error:", error);
    });        


## Acknowledgements

The code is based on [https://github.com/cowboy/php-simple-proxy](https://github.com/cowboy/php-simple-proxy) project. 
You can use the project if you need a more powerful proxy.