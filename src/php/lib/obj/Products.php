<?php

 $productsFormats= array(
"productsid" => "i",
"name" => "s",
"price" => "d",
"setup" => "d",
"discount" => "d",
"option" => "i");


class Products
{
private $productsid;
private $name;
private $price;
private $setup;
private $discount;
private $option;
		
	public function setProductsid($productsid)
	{
		$this->productsid = $productsid;
	}

	public function getProductsid()
	{
		return $this->productsid;
	}
		
	public function setName($name)
	{
		$this->name = $name;
	}

	public function getName()
	{
		return $this->name;
	}
		
	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function getPrice()
	{
		return $this->price;
	}
		
	public function setSetup($setup)
	{
		$this->setup = $setup;
	}

	public function getSetup()
	{
		return $this->setup;
	}
		
	public function setDiscount($discount)
	{
		$this->discount = $discount;
	}

	public function getDiscount()
	{
		return $this->discount;
	}
		
	public function setOption($option)
	{
		$this->option = $option;
	}

	public function getOption()
	{
		return $this->option;
	}

	public function getAll()
	{
		$ret = array(
		'name'=>$this->getName(),
		'price'=>$this->getPrice(),
		'setup'=>$this->getSetup(),
		'discount'=>$this->getDiscount(),
		'option'=>$this->getOption());
		return $ret;
	}

	public function loadProducts() {
		global $db;
		if(!isset($this->productsid)){
			return "No Products ID";
		}		
		$res = $db->select('SELECT productsid,name,price,setup,discount,option FROM products WHERE productsid=?', array($this->productsid), 'd');
		$r=$res[0];
		$this->setProductsid($r->productsid);
		$this->setName($r->name);
		$this->setPrice($r->price);
		$this->setSetup($r->setup);
		$this->setDiscount($r->discount);
		$this->setOption($r->option);

	}


	public function updateDB() {
		global $db;
		global $productsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'productsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $productsFormats[$key];
			}
		}
		$res = $db->update('products', $data, $format, array('productsid'=>$this->productsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $productsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $productsFormats[$key];
			}
		}
		$res = $db->insert('products', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->productsid)){
			return "No Products ID";
		}
		$res = $db->delete('products', $this->productsid, 'productsid');
		return $res;
    }
}
?>