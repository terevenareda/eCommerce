<?php
class Feedback {
  private int $id;
  private int $userId;
  private int $productId;
  private string $date;
  private string $feedback;

  public function getId(): int {
    return $this->id;
  }

  public function getUserId(): int {
    return $this->userId;
  }

  public function setUserId(int $userId): void {
    $this->userId = $userId;
  }

  public function getProductId(): int {
    return $this->productId;
  }

  public function setProductId(int $productId): void {
    $this->productId = $productId;
  }

  public function getDate(): string {
    return $this->date;
  }

  public function setDate(string $date): void {
    $this->date = $date;
  }

  public function getFeedback(): string {
    return $this->feedback;
  }

  public function setFeedback(string $feedback): void {
    $this->feedback = $feedback;
  }
}
?>