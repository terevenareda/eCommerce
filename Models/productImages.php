<?php
class ProductImages {
  private $images_id;
  private $product_id;
  private $image1;
  private $image2;
  private $image3;
  
  public function __construct($images_id, $product_id, $image1, $image2, $image3) {
    $this->images_id = $images_id;
    $this->product_id = $product_id;
    $this->image1 = $image1;
    $this->image2 = $image2;
    $this->image3 = $image3;
  }
  
  public function getImagesId() {
    return $this->images_id;
  }
  
  public function setImagesId($images_id) {
    $this->images_id = $images_id;
  }
  
  public function getProductId() {
    return $this->product_id;
  }
  
  public function setProductId($product_id) {
    $this->product_id = $product_id;
  }
  
  public function getImage1() {
    return $this->image1;
  }
  
  public function setImage1($image1) {
    $this->image1 = $image1;
  }
  
  public function getImage2() {
    return $this->image2;
  }
  
  public function setImage2($image2) {
    $this->image2 = $image2;
  }
  
  public function getImage3() {
    return $this->image3;
  }
  
  public function setImage3($image3) {
    $this->image3 = $image3;
  }
}
?>