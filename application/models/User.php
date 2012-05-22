<?php

class Application_Model_User extends Application_Model_AbstractModel
{
	public function getClassName(){ return 'Application_Model_User'; }
	
	protected $_uid; //customer or user id
	protected $_first_name;	// first name
	protected $_last_name;	//last name
	protected $_name; // string manipulation of First_Name Last_Name
	protected $_email;
	protected $_password;
	protected $_phone;
	protected $_ref_rid;	//reference to role id in roles_chart
	protected $_salt;
	protected $_created_at;
  
// =================================================
// ================ Getters / Setters
// =================================================
	public function setUid($uid){ $this->_uid 	= (int) $uid; return $this; }	
	public function getUid(){return $this->_uid; }
	
	public function setFirst_name($first_name){ $this->_first_name	= (string) $first_name; return $this; }
	public function getFirst_name(){ return $this->_first_name; }
	
	public function setLast_name($last_name){ $this->_last_name	= (string) $last_name; return $this; }
	public function getLast_name(){ return $this->_last_name; }

	public function getName(){ return ucfirst($this->_first_name)." ".ucfirst($this->_last_name);}
	
	public function setEmail($email){ $this->_email	= (string) $email; return $this;}
	public function getEmail(){ return $this->_email; }

	public function setPassword($d){ $this->_password = $d; return $this; }
	public function getPassword(){ return $this->_password; }
	
	public function setPhone($phone){	$this->_phone	= (float) $phone; return $this;}
	public function getPhone(){ return $this->_phone; }

	public function setRef_rid($d){ $this->_ref_rid = $d; return $this; }
	public function getRef_rid(){ return $this->_ref_rid; }
	
	public function setSalt($d){ $this->_salt = $d; return $this; }
	public function getSalt(){ $this->_salt; } 
	
	public function getCreated_at(){ return $this->_created_at; }
	
}//end class

