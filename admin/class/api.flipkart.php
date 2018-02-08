<?php
$lastupdated=date('Y-m-d H:i:s');
foreach($products as $key => $value)
{ 
        $sql="SELECT * FROM product_store WHERE productid='".$value['id']."' AND storeid='".$_POST['storeid']."'";
	$products_store=$obj->get_row_by_query($sql);
	$nexturl='https://affiliate-api.flipkart.net/affiliate/search/json?query='.str_replace(' ','+',$value['name']).'&resultCount=5';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$nexturl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$headers = array();
	$headers[] = 'Fk-Affiliate-Id: shijojose';
	$headers[] = 'Fk-Affiliate-Token: bad9288c61fd4e2aae5edb28847a4770';

	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$server_output = curl_exec ($ch);
	curl_close ($ch);

	$products1 = json_decode($server_output);
	if(@$products1){
  for ($i=0; $i < count(@$products1->productInfoList); $i++) 
	{ 
	    if($products_store[0]['productcode']==$products1->productInfoList[$i]->productBaseInfo->productIdentifier->productId)	
  	    {
  		$pro_name=$products1->productInfoList[$i]->productBaseInfo->productAttributes->title;
  		$pro_code=$products1->productInfoList[$i]->productBaseInfo->productIdentifier->productId;
  		$pro_mrp=$products1->productInfoList[$i]->productBaseInfo->productAttributes->maximumRetailPrice->amount;
  		$LowestNewPrice=$products1->productInfoList[$i]->productBaseInfo->productAttributes->sellingPrice->amount;
  		$pro_url=$products1->productInfoList[$i]->productBaseInfo->productAttributes->productUrl;
  		$pro_color=$products1->productInfoList[$i]->productBaseInfo->productAttributes->color;
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
//print_r($products1->productInfoList);
}
?>