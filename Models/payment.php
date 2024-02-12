<?php
class Payment {
    private int $payId;
    private int $orderId;
    private string $payStatus;
    private int $payTotal;
    private int $payBalance;
  
    public function getPayId(): int {
      return $this->payId;
    }
  
    public function setPayId(int $payId): void {
      $this->payId = $payId;
    }
  
    public function getOrderId(): int {
      return $this->orderId;
    }
  
    public function setOrderId(int $orderId): void {
      $this->orderId = $orderId;
    }
  
    public function getPayStatus(): string {
      return $this->payStatus;
    }
  
    public function setPayStatus(string $payStatus): void {
      $this->payStatus = $payStatus;
    }
  
    public function getPayTotal(): int {
      return $this->payTotal;
    }
  
    public function setPayTotal(int $payTotal): void {
      $this->payTotal = $payTotal;
    }
  
    public function getPayBalance(): int {
      return $this->payBalance;
    }
  
    public function setPayBalance(int $payBalance): void {
      $this->payBalance = $payBalance;
    }
  }
?>