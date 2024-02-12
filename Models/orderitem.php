<?php
class OrderItem {
    private int $productId;
    private int $orderId;
    private string $title;
    private int $price;
    private int $quantity;
  
    public function getProductId(): int {
      return $this->productId;
    }
  
    public function setProductId(int $productId): void {
      $this->productId = $productId;
    }
  
    public function getOrderId(): int {
      return $this->orderId;
    }
  
    public function setOrderId(int $orderId): void {
      $this->orderId = $orderId;
    }
  
    public function getTitle(): string {
      return $this->title;
    }
  
    public function setTitle(string $title): void {
      $this->title = $title;
    }
  
    public function getPrice(): int {
      return $this->price;
    }
  
    public function setPrice(int $price): void {
      $this->price = $price;
    }
  
    public function getQuantity(): int {
      return $this->quantity;
    }
  
    public function setQuantity(int $quantity): void {
      $this->quantity = $quantity;
    }
  }
?>