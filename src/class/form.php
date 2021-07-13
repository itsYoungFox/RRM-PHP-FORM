<?php
class Form
{
    private $firstname;
    private $lastname;
    private $email;
    private $teleNumber;
    private $address1;
    private $address2;
    private $postcode;
    private $town;
    private $county;
    private $country;
    private $description;
    private $cv_path;
    
    function __construct($formObj = null) {
        if ($formObj !== null) {
            foreach ($formObj as $key => $value) {
                if ($key == 'firstname')    $this->set_firstname($value);
                if ($key == 'lastname')     $this->set_lastname($value);
                if ($key == 'email')        $this->set_email($value);
                if ($key == 'teleNumber')   $this->set_teleNumber($value);
                if ($key == 'address1')     $this->set_address1($value);
                if ($key == 'address2')     $this->set_address2($value);
                if ($key == 'postcode')     $this->set_postcode($value);
                if ($key == 'town')         $this->set_town($value);
                if ($key == 'county')       $this->set_county($value);
                if ($key == 'country')      $this->set_country($value);
                if ($key == 'description')  $this->set_description($value);
                if ($key == 'cv_path')      $this->set_cv_path($value);
            }
        }
    }

    // Get and Set firstname
    public function set_firstname(String $firstname) {
        $this->firstname = $firstname;
        // return $this;
    }
    public function get_firstname() {
        return $this->firstname;
    }

    // Get and Set lastname
    public function set_lastname(String $lastname) {
        $this->lastname = $lastname;
        // return $this;
    }
    public function get_lastname() {
        return $this->lastname;
    }

    // Get and Set Email
    public function set_email(String $email) {
        if (preg_match("/(?:[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@((?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/i",
        $email)) {
            $this->email = filter_var($email, FILTER_SANITIZE_EMAIL);
            // return $this;
        }
    }
    public function get_email() {
        return $this->email;
    }

    // Get and Set Telephone Number
    public function set_teleNumber(String $teleNumber) {
        $this->teleNumber = $teleNumber;
        // return $this;
    }
    public function get_teleNumber() {
        return $this->teleNumber;
    }

    // Get and Set Address 1
    public function set_address1(String $address1) {
        $this->address1 = $address1;
        // return $this;
    }
    public function get_address1() {
        return $this->address1;
    }

    // Get and Set Address 2
    public function set_address2(String $address2) {
        $this->address2 = $address2;
        // return $this;
    }
    public function get_address2() {
        return $this->address2;
    }

    // Get and Set Town
    public function set_town(String $town) {
        $this->town = $town;
        // return $this;
    }
    public function get_town() {
        return $this->town;
    }

    // Get and Set County
    public function set_county(String $county) {
        $this->county = $county;
        // return $this;
    }
    public function get_county() {
        return $this->county;
    }

    // Get and Set Postcode
    public function set_postcode(String $postcode) {
        $this->postcode = $postcode;
        // return $this;
    }
    public function get_postcode() {
        return $this->postcode;
    }

    // Get and Set Country
    public function set_country(String $country) {
        $this->country = $country;
        // return $this;
    }
    public function get_country() {
        return $this->country;
    }

    // Get and Set description
    public function set_description(String $description) {
        $this->description = $description;
        // return $this;
    }
    public function get_description() {
        return $this->description;
    }

    // GET and SET CV
    public function set_cv_path(String $cv_path) {
        $this->cv_path = $cv_path;
        // return $this;
    }
    public function get_cv_path() {
        return $this->cv_path;
    }
}
?>