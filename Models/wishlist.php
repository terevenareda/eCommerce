<?php
class WishList {
  private $user_id;
  private $product_id;
  private $date;
  
  public function __construct($user_id, $product_id, $date) {
    $this->user_id = $user_id;
    $this->product_id = $product_id;
    $this->date = $date;
  }
  
  public function getUserId() {
    return $this->user_id;
  }
  
  public function setUserId($user_id) {
    $this->user_id = $user_id;
  }
  
  public function getProductId() {
    return $this->product_id;
  }
  
  public function setProductId($product_id) {
    $this->product_id = $product_id;
  }
  
  public function getDate() {
    return $this->date;
  }
  
  public function setDate($date) {
    $this->date = $date;
  }
}
?>