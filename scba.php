<title>Amazon ASIN search</title>
URL: 
<form id="form1" name="form1" method="post" action="index.php">
  <label for="url">url</label>
  <input type="text" name="url" id="url" />
submit
<input type="submit" name="submit" id="submit" value="Submit" />
</form>
<?php

//$example_url ='http://www.amazon.com/Jawbone-JAMBOX-Wireless-Bluetooth-Speaker/dp/B004E10KI8/ref=sr_1_1?ie=UTF8&qid=1379377825&sr=8-1&keywords=jam+box';
//$reg = '#(?:http://(?:www\.){0,1}amazon\.com(?:/.*){0,1}(?:/dp/|/gp/product/))(.*?)(?:/.*|$)#';
//echo 'test<br/>';

//$matches = array();
//echo preg_match($reg,$example_url, $matches);

//var_dump($matches);



// create a new cURL resource
$ch = curl_init();

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, 'https://www.skincarebyalana.com/index.php/admin/sales_order/view/order_id/63251/');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");

// grab URL and pass it to the browser
$page = curl_exec ($ch);
curl_close($ch);
// grab ASIN
$pattern = '/id="ASIN" name="ASIN" value="(.*)"/';
preg_match($pattern,$page,$result);
// grab title
$pattern2 = '/<span id="btAsinTitle"  >(.*)</';
preg_match($pattern2,$page,$title);

$pattern3 = '/productDescriptionWrapper">\s*(.*)\s*</';
preg_match($pattern3,$page,$desc);

print "<html> <p>";
print "URL: $url <br />contains the ASIN: ";
print_r ($result[1]);
print "<br />Title: ";
print_r ($title[1]);
print "<br />";
print "description: <br />";
print_r ($desc[1]);
print "</p> </html>";
print $page;


// Create a stream
$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: enrn" .
              "Cookie: mauuid=4d69a071-b308-41f1-8ba8-6477f558ee1f"
  )
);

$context = stream_context_create($opts);

// Open the file using the HTTP headers set above
$file = file_get_contents('https://www.skincarebyalana.com/index.php/admin/sales_order/view/order_id/63251/', false, $context);

echo $file;
// close cURL resource, and free up system resources

?>