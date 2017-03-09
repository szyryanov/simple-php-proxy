<?PHP
//
// Simple PHP proxy, based on http://benalman.com/projects/php-simple-proxy/
//
// Allowing any URL leads to "open proxy" behavior! Don't be lazy to set $URL_START for your service address!
$URL_START = 'http://projects/simple-php-proxy/'; 
//
// prepare URL:
$url = $_GET['url'];
if (!isset($url)) exit('ERROR: url not specified');
$url = $URL_START . $url;
//
// prepare request:
$ch = curl_init($url);
if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
} 
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt( $ch, CURLOPT_HEADER, true);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER,array("Expect:"));
//curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888'); // uncomment to check local requests using Fiddler
//
// perform request:
$response = curl_exec($ch);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header_string = substr($response, 0, $header_size);           
$content_string = substr($response, $header_size);           
curl_close($ch);
//  
// response header
$header_text = preg_split('/[\r\n]+/', $header_string);
foreach ($header_text as $header) {
  if (preg_match('/^(?:Content-Type|Content-Language|Set-Cookie):/i', $header)) {
    header($header);
  }
}
// response body
print $content_string;
  
?>