<?php
include 'config.php';
include 'db.php';
    class Product extends Db{
        public function insert($table,$values,$check)
        {
            $sql="SELECT * FROM ".$table." WHERE ".$check."='".$values[$check]."'";
            $check =  $this->execute_query($sql);
            $count_row = $check->num_rows;
            if ($count_row == 0){
                $sql="INSERT INTO ".$table." SET ";
                foreach ($values as $key => $value) {
                    $arr[] =$key."='$value'";
                }
                $sql .= implode(',', $arr);
                $result = $this->execute_query($sql);
                return $result;
            }
            else { return false;}
        }
        /*** for edi row process ***/
        public function update($table,$values,$check,$keyValue){
            $sql="SELECT * FROM ".$table." WHERE ".$check."='".$values[$check]."' AND id!=".$keyValue;
            //checking if the username or email is available in db
            $check =  $this->db->query($sql) ;
            $count_row = $check->num_rows;
            //if the username is not in db then insert to the table
            if ($count_row == 0){
                $sql="UPDATE ".$table." SET ";
                foreach ($values as $key => $value) {
                    $arr[] =$key."='$value'";
                }
                $sql .= implode(',', $arr);
                $sql.=" WHERE id=".$keyValue;
                $result = $this->execute_query($sql);
                return $result;
            }
            else { return false;}
        }
        public function last_inserted_id($table){
            $sql="SELECT MAX(id) as id FROM ".$table;
            $result =  $this->execute_query($sql);
            while($row=mysqli_fetch_array($result,MYSQL_ASSOC))
            {
                $output[]=$row;
            }
            return $output;
        }
        public function update_product_store($table,$productid,$storeid,$productcode='')
        {
            $sql="SELECT * FROM ".$table." WHERE productid='".$productid."' AND storeid='".$storeid."'";
            $check =  $this->execute_query($sql);
            $count_row = $check->num_rows;
            if ($count_row == 0){
                $sql="INSERT INTO ".$table." SET productid='".$productid."', storeid='".$storeid."', productcode='".$productcode."'";
                $result = $this->execute_query($sql);
                return $result;
            }
            else { 
                $sql="UPDATE ".$table." SET productcode='".$productcode."' WHERE productid='".$productid."' AND storeid='".$storeid."'";
                $result = $this->execute_query($sql);
                return $result;
            }
        }
        public function insert_product_category($productid,$categoryid)
        {
            $sql="INSERT INTO product_category SET productid='".$productid."', categoryid='".$categoryid."'";
            $result = $this->execute_query($sql);
            return $result;
        }
    }
$obj = new Product();
$products=$obj->get_rows('product');
$stores=$obj->get_row_by_col('store','status','1');
//add store info
if (isset($_POST['submit'])) 
{
    extract($_REQUEST);
    @$edit_id=$id;
    if($name!='')
    {
        $notempty=0;  $ImageError=0;  $flag=0;
        for ($i=1; $i <= 6; $i++) 
        {
            $attachment='file'.$i;
            if(!empty($_FILES[$attachment]['name'])) 
            {
                $allowedExts = array("jpeg","jpg","png");
                $temp = explode(".", $_FILES[$attachment]["name"]);
                $extension = end($temp);
                if((($_FILES[$attachment]["type"] == "image/jpeg")|| ($_FILES[$attachment]["type"] == "image/jpg")|| ($_FILES[$attachment]["type"] == "image/png"))&& in_array($extension, $allowedExts))
                {
                    if($_FILES[$attachment]["size"] > 1024000)
                    {
                        $ImageError=1;
                    }
                    else 
                        $notempty=1;
                }
                else
                {
                   $ImageError=1;
                }
            }
        }
        if($ImageError==1)
        {
            $error="Upload a valid image file <small>(jpg/png)</small>";  
        }
        else
        {
            if($notempty==1)
            {
                if($old_image)
                   $picname=$old_image;
                else
                   $picname=str_replace(' ','-',$name).rand(100,1000);
                $values=array(
                'name' => $name,
                'description'  => $description,
                'highlight'  => $highlight,
                'dealtype'  => $dealtype,
                'file' => $picname,
                'meta_title'  => $meta_title,
                'meta_description'  => $meta_description,
                'status' => $status
                );

                $table='product';
                $key='name';
                if($edit_id)
                    $result = $obj->update($table,$values,$key,$edit_id);
                else
                    $result = $obj->insert($table,$values,$key);  
                if($result) 
                {
                    $res=$obj->last_inserted_id($table);   
                    if($edit_id)
            	          $prid=$edit_id;
                    else
            	          $prid=$res[0]['id'];
                    foreach($stores as $key => $value)
                    { 
            	          $code='productcode_'.$value['name'];
            	          $storeid=$value['id'];
                            if($_POST[$code])
                            {
                                $productcode=$_POST[$code];
               	                $obj->update_product_store('product_store',$prid,$storeid,$productcode);
                            }
                            else
                            {
                                $productcode='';
                           	    if($edit_id)
                           	        $obj->update_product_store('product_store',$prid,$storeid,$productcode);
                            }
                    }
                    if($category)
                    {
                        $obj->delete_row_by_col('product_category','productid',$prid);
                        foreach($category as $key => $val) 
                        {
                            $obj->insert_product_category($prid,$val);
                        }          
                    } 
                    $allowedExts = array("jpeg","jpg","png");               
                    $width = 450; // new image width
                    $height = 450; // new image height
                    for ($i=1; $i <= 6; $i++) 
                    {
                        $attachment='file'.$i;
                        if(!empty($_FILES[$attachment]['name'])) 
                        {
                            if($old_image)
                                @unlink(DOCUMENT_ROOT."/images/product/".$old_image."_".$i.".jpg");
                            $temp = explode(".", $_FILES[$attachment]["name"]);
                            $extension = end($temp);
                            if( ($extension=='jpeg') || ($extension=='jpg'))
                            {
                                $sourcefilePath=DOCUMENT_ROOT."/images/product/".$picname."_".$i.".".$extension;
                                $destfilePath=DOCUMENT_ROOT."/images/product/".$picname."_".$i.".".$extension;
                                $filename=$_FILES[$attachment]["tmp_name"];
                                $obj->jpgtojpg($sourcefilePath,$destfilePath,$filename,$width,$height);
                            }
                            else if( $extension=='png') 
                            {
                                $sourcefilePath=DOCUMENT_ROOT."/images/product/".$picname."_".$i.".".$extension;
                                $destfilePath=DOCUMENT_ROOT."/images/product/".$picname."_".$i;
                                $filename=$_FILES[$attachment]["tmp_name"];
                                $obj->pngtojpg($sourcefilePath,$destfilePath,$filename,$width,$height);
                                unlink(DOCUMENT_ROOT."/images/product/".$picname."_".$i.".".$extension);
                            }
                        }
                    }
                    $success='Product details saved';
                }
                else 
                    $error= 'Product Name already exist';
            }
            else
            {
                $values=array(
                'name' => $name,
                'description'  => $description,
                'highlight'  => $highlight,
                'dealtype'  => $dealtype,
                'meta_title'  => $meta_title,
                'meta_description'  => $meta_description,
                'status' => $status
                );
                $table='product';
                $key='name';
                if($edit_id)
                    $result = $obj->update($table,$values,$key,$edit_id);
                else
                    $result = $obj->insert($table,$values,$key);  
                if($result) 
                {
            	    $res=$obj->last_inserted_id($table);   
            	    if($edit_id)
            	        $prid=$edit_id;
            	    else
            	        $prid=$res[0]['id'];
            	    foreach($stores as $key => $value)
            	    { 
            	        $code='productcode_'.$value['name'];
            	        $storeid=$value['id'];
                        if($_POST[$code])
                        {
                            $productcode=$_POST[$code];
               	            $obj->update_product_store('product_store',$prid,$storeid,$productcode);
                        }
                        else
                        {
                            $productcode='';
                    	    if($edit_id)
                    	        $obj->update_product_store('product_store',$prid,$storeid,$productcode);
                        }
                    }
                    if($category)
                    {
                        $obj->delete_row_by_col('product_category','productid',$prid);
                        foreach($category as $key => $val) 
                        {
                            $obj->insert_product_category($prid,$val);
                        }          
                    } 
                    $success='Product details saved';
                }
                else 
                    $error= 'Product Name already exist';
            }
        }
        
    }
    else
        $error= 'Product Name must not be empty';
}?>