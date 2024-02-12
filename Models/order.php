<?php

class TheOrder {
    private $id;
    private $user_id;
    private $full_name;
    private $address;
    private $phone_number;
    private $code;
    private $card_number;
    private $date;
    private $status;
    
    public function __construct($id, $user_id, $full_name, $address, $phone_number, $code, $card_number, $date, $status) {
      $this->id = $id;
      $this->user_id = $user_id;
      $this->full_name = $full_name;
      $this->address = $address;
      $this->phone_number = $phone_number;
      $this->code = $code;
      $this->card_number = $card_number;
      $this->date = $date;
      $this->status = $status;
    }
    
    public function getId() {
      return $this->id;
    }
    
    public function setId($id) {
      $this->id = $id;
    }
    
    public function getUserId() {
      return $this->user_id;
    }
    
    public function setUserId($user_id) {
      $this->user_id = $user_id;
    }
    
    public function getFullName() {
      return $this->full_name;
    }
    
    public function setFullName($full_name) {
      $this->full_name = $full_name;
    }
    
    public function getAddress() {
      return $this->address;
    }
    
    public function setAddress($address) {
      $this->address = $address;
    }
    
    public function getPhoneNumber() {
      return $this->phone_number;
    }
    
    public function setPhoneNumber($phone_number) {
      $this->phone_number = $phone_number;
    }
    
    public function getCode() {
      return $this->code;
    }
    
    public function setCode($code) {
        $this->code = $code;
}

    public function getCardNumber() {
    return $this->card_number;
    }

    public function setCardNumber($card_number) {
    $this->card_number = $card_number;
    }

    public function getDate() {
    return $this->date;
    }

    public function setDate($date) {
    $this->date = $date;
}

public function getStatus() {
return $this->status;
}

public function setStatus($status) {
$this->status = $status;
}
}

?>