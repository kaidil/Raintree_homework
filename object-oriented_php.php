<?php

interface PatientRecord {
    public function getRecordId(): int;
    public function getPatientNumber(): string;
  }
  
  class Patient implements PatientRecord {

    // Properties to represent fields of the corresponding database table
    private $_id;
    private $pn;
    private $first;
    private $last;
    private $dob;
    private $insurance_records = array();
    
    // Constructor method to set the initial property values
    public function __construct($pn, $_id, $first, $last, $dob, $insurance_records) {
      $this->pn = $pn;
      $this->_id = $_id;
      $this->first = $first;
      $this->last = $last;
      $this->dob = $dob;
      $this->insurance_records = $insurance_records;
    }
    
    // Method to return Patient record '_id' property
    public function getRecordId(): int {
      return $this->_id;
    }
    
    // Method to return Patient record 'pn' property
    public function getPatientNumber(): string {
      return $this->pn;
    }
    
    // Method to return Patient name in format "First Last"
    public function getFullName() {
      return $this->first . " " . $this->last;
    }
    
    // Method to return an array of patient Insurance record instances
    public function getInsuranceRecords() {
      return $this->insurance_records;
    }
    
    // Method to print a table with patient's insurance information
    public function printInsuranceTable($date) {
      echo "<table>";
      echo "<tr><th>Patient Number</th><th>Name</th><th>Insurance</th><th>Is Valid</th></tr>";
      
      foreach ($this->insurance_records as $insurance_record) {
        $insurance_name = $insurance_record->getName();
        $is_valid = $insurance_record->isValid($date) ? "Yes" : "No";
        echo "<tr><td>".$this->pn."</td><td>".$this->getFullName()."</td><td>".$insurance_name."</td><td>".$is_valid."</td></tr>";
      }
      
      echo "</table>";
    }
  }
  
  
  

?>