<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>simple-php-proxy PHP tests</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>

  <h2>simple-php-proxy - PHP test</h2>

  <?php
  require_once(dirname(__FILE__) . '/../../simpletest/autorun.php');

  // ---------------------------
  //        this_dir_url
  // ---------------------------
  $this_dir_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  $p = strrpos($this_dir_url, '/');
  $this_dir_url = substr($this_dir_url, 0, $p + 1);
  //echo $this_dir_url;
  
  class TestCases extends UnitTestCase {
      
    // ---------------------------
    //        test cases
    // ---------------------------

    function testGet() {
      global $this_dir_url;
      $result = $this->requestGet($this_dir_url . "../simple-php-proxy.php?url=" . $this_dir_url . "json-get-post.php?a=b&c=d");
      $this->assertEqual('{"get":{"a":"b","c":"d"},"post":[]}', $result);
    }

    function testGetNoUrl() {
      global $this_dir_url;
      $result = $this->requestGet($this_dir_url . "../simple-php-proxy.php");
      $this->assertEqual('ERROR: url not specified', $result);
    }

    function testPost() {
      global $this_dir_url;
      $result = $this->requestPost($this_dir_url . "../simple-php-proxy.php?url=" . $this_dir_url . "json-get-post.php", array('a' => 'b', 'c' => 'd'));
      $this->assertEqual('{"get":[],"post":{"a":"b","c":"d"}}', $result);
    }
    
    function testPostNoUrl() {
      global $this_dir_url;
      $result = $this->requestPost($this_dir_url . "../simple-php-proxy.php", array('a' => 'b', 'c' => 'd'));
      $this->assertEqual('ERROR: url not specified', $result);
    }
    
    // ---------------------------
    //          utils
    // ---------------------------
      
    private function requestGet($url){
      return file_get_contents($url);
    }
          
    private function requestPost($url, $data){
      //$url = 'http://server.com/path';
      //$data = array('key1' => 'value1', 'key2' => 'value2');
      //
      // use key 'http' even if you send the request to https://...
      $options = array(
          'http' => array(
              'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
              'method'  => 'POST',
              'content' => http_build_query($data)
          )
      );
      $context  = stream_context_create($options);
      $result = file_get_contents($url, false, $context);      
      //
      return $result;
    }
     
  }
  ?>
    
</body>
</html>
