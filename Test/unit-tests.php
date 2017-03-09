<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>simple-php-proxy unit tests</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>

  <h2>simple-php-proxy - test</h2>

  <?php
  require_once(dirname(__FILE__) . '/../../simpletest/autorun.php');

  class TestCases extends UnitTestCase {
      
      function testGet() {
        $result_get = $this->requestGet("http://projects/simple-php-proxy/Test/simple-php-proxy.php?url=Test/return-url.php?a=b%26c=d");
        $this->assertEqual('projects/simple-php-proxy/Test/return-url.php?a=b&c=d', $result_get);
      }

      function testPost() {
        $result_post = $this->requestPost("http://projects/simple-php-proxy/Test/simple-php-proxy.php?url=Test/return-post.php", array('key1' => 'value1', 'key2' => 'value2'));
        $result_post = $this->removeSpaces($result_post);
        $this->assertEqual('Array([key1]=>value1[key2]=>value2)', $result_post);
      }
      
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
      
      private function removeSpaces($str){
        $str = str_replace("\r","",$str);
        $str = str_replace("\n","",$str);
        $str = str_replace(" ","",$str);
        return $str;
      }
     
     
  }
  ?>
    
</body>
</html>
