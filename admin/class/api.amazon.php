<?php
function signAmazonUrl($url, $secret_key)
{
	$original_url = $url;
    	// Decode anything already encoded
    	$url = urldecode($url);
    	// Parse the URL into $urlparts
    	$urlparts       = parse_url($url);
    	// Build $params with each name/value pair
    	foreach (explode('&', $urlparts['query']) as $part) 
    	{
        	if (strpos($part, '=')) 
        	{
            		list($name, $value) = explode('=', $part, 2);
        	} 
        	else 
        	{
            		$name = $part;
            		$value = '';
        	}
        	$params[$name] = $value;
    	}
    	// Include a timestamp if none was provided
    	if (empty($params['Timestamp'])) {
        	$params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');
    	}
    	// Sort the array by key
    	ksort($params);
    	// Build the canonical query string
    	$canonical       = '';
    	foreach ($params as $key => $val) {
        	$canonical  .= "$key=".rawurlencode(utf8_encode($val))."&";
    	}
    	// Remove the trailing ampersand
    	$canonical       = preg_replace("/&$/", '', $canonical);
    	// Some common replacements and ones that Amazon specifically mentions
    	$canonical       = str_replace(array(' ', '+', ',', ';'), array('%20', '%20', urlencode(','), urlencode(':')), $canonical);
    	// Build the sign
    	$string_to_sign             = "GET\n{$urlparts['host']}\n{$urlparts['path']}\n$canonical";
    	// Calculate our actual signature and base64 encode it
    	$signature            = base64_encode(hash_hmac('sha256', $string_to_sign, $secret_key, true));
    	// Finally re-build the URL with the proper string and include the Signature
    	$url = "{$urlparts['scheme']}://{$urlparts['host']}{$urlparts['path']}?$canonical&Signature=".rawurlencode($signature);
    	return $url;
}

$Access_Key_ID='AKIAI4G3UTQ6IYO6WM6Q';
$secret_key='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';
$AssociateTag='dukakeen-20';
$Operation = "ItemSearch";
$Version = "2013-08-01";
$ResponseGroup = "ItemAttributes,Offers";
$count=0;
$lastupdated=date('Y-m-d H:i:s');
foreach($products as $key => $value)
{ 
	$sql="SELECT * FROM product_store WHERE productid='".$value['id']."' AND storeid='".$_POST['storeid']."'";
	$products_store=$obj->get_row_by_query($sql);
	$SearchIndex='Electronics';
  	$Keywords=$value['name'];
  	$url="https://webservices.amazon.in/onca/xml"
   	. "?Service=AWSECommerceService"
  	. "&AWSAccessKeyId=" . $Access_Key_ID
   	. "&AssociateTag=". $AssociateTag
   	. "&Operation=" . $Operation
   	. "&Version=" . $Version
   	. "&SearchIndex=" . $SearchIndex
   	. "&Keywords=" . $Keywords
   	. "&Timestamp=" . rawurlencode(gmdate("Y-m-d\TH:i:s\Z")) 
   	. "&ResponseGroup=" . $ResponseGroup;
  	$xml = @file_get_contents(signAmazonUrl($url, $secret_key));
  	$arr=simplexml_load_string($xml);
  	if(@$arr->Items){
    for ($i=0; $i < count($arr->Items->Item); $i++) 
  	{ 
		//print_r($arr->Items->Item[$i]);
  	   if($products_store[0]['productcode']==$arr->Items->Item[$i]->ASIN)	
  	   {
  		$pro_url=@$arr->Items->Item[$i]->DetailPageURL;
  		$pro_name=@$arr->Items->Item[$i]->ItemAttributes->Title;
  		$pro_code=@$arr->Items->Item[$i]->ASIN;
  		//$pro_parent_code=@$arr->Items->Item[$i]->ParentASIN;
  		$pro_mrp=@$arr->Items->Item[$i]->ItemAttributes->ListPrice->Amount/100;
  		$LowestNewPrice=@$arr->Items->Item[$i]->OfferSummary->LowestNewPrice->Amount/100;
  		//$LowestUsedPrice=@$arr->Items->Item[$i]->OfferSummary->LowestUsedPrice->Amount/100;
  		//$LowestRefurbishedPrice=@$arr->Items->Item[$i]->OfferSummary->LowestRefurbishedPrice->Amount/100;
 		$pro_color=@$arr->Items->Item[$i]->ItemAttributes->Color;

  		$values=array(
    			'name' => $pro_name,
    			'productid'  => $value['id'],
    			'storeid'  => $_POST['storeid'],
    			'productcode' => $pro_code,
    			'mrp'  => $pro_mrp,
    			'offerprice' => $LowestNewPrice,
    			'color' => $pro_color,
    			'url' => $pro_url,
    			'lastupdated' => $lastupdated
  		);
  		$table='product_api';
  		$key='productcode';
  		$store='storeid';
  		$color='color';
  		$result = $obj->insert($table,$values,$key,$store);  
  		if($result) 
    			$count++;
    	    }
	}}
}?>