<?php
class CartItem {
    private $id;
    private $product_id;
    private $user_id;
    private $title;
    private $price;
    private $quantity;

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getProductId() {
        return $this->product_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setProductId($product_id) {
        $this->product_id = $product_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }
}

?>