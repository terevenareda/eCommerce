<?php
class Product {
    private $id;
    private $amount;
    private $price;
    private $description;
    private $categoryId;
    private $title;
    private $details;
    private $sale;
    private $finalPrice;
    private $barcode;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getCategoryId() {
        return $this->categoryId;
    }

    public function setCategoryId($categoryId) {
        $this->categoryId = $categoryId;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getDetails() {
        return $this->details;
    }

    public function setDetails($details) {
        $this->details = $details;
    }

    public function getSale() {
        return $this->sale;
    }

    public function setSale($sale) {
        $this->sale = $sale;
    }

    public function getFinalPrice() {
        return $this->finalPrice;
    }

    public function setFinalPrice($finalPrice) {
        $this->finalPrice = $finalPrice;
    }

    public function getBarcode() {
        return $this->barcode;
    }

    public function setBarcode($barcode) {
        $this->barcode = $barcode;
    }
}

?>