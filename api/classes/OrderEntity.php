<?php
class OrderEntity
{
    protected $name;
    protected $phone;
    protected $email;
    protected $address;
    protected $tid;
    protected $amount;
    protected $soups;
    protected $proteins;
    protected $delivery_date;

    /**
     * Accept an array of data matching properties of this class
     * and create the class
     *
     * @param array $data The data to use to create
     */
    public function __construct(array $data) {
        $this->name = $data['name'];
        $this->phone = $data['phone'];
        $this->email = $data['email'];
        $this->address = $data['address'];
        $this->tid = $data['tId'];
        $this->amount = $data['amount'];
        $this->soups = $data['soups'];
        $this->proteins = $data['proteins'];
        //$this->delivery_date = $data['delivery_date'];
    }
    /*public function getId() {
        return $this->id;
    }*/
    public function getName() {
        return $this->name;
    }
    public function getPhone() {
        return $this->phone;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getAddress() {
        return $this->address;
    }
    public function getTid() {
        return $this->tid;
    }
    public function getAmount() {
        return $this->amount;
    }
    public function getSoups() {
        return $this->soups;
    }
    public function getProteins() {
        return $this->proteins;
    }
    public function getDeliveryDate() {
        return $this->delivery_date;
    }
}