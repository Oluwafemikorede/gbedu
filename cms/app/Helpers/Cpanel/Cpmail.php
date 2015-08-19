<?php

namespace Helpers\Cpanel;

class Cpmail {
  //declare public variables
  var $cpuser;    // cPanel username
  var $cppass;        // cPanel password
  var $cpdomain;      // cPanel domain or IP
  var $cpskin;        // cPanel skin. Mostly x or x2.
  
  //defining constructor
  function cpmail($cpuser,$cppass,$cpdomain,$cpskin='x'){
    $this->cpuser=$cpuser;
  	$this->cppass=$cppass;
  	$this->cpdomain=$cpdomain;
  	$this->cpskin=$cpskin;
	// See following URL to know how to determine your cPanel skin
	// http://www.zubrag.com/articles/determine-cpanel-skin.php
  }

  //now create email account, function takes three arguments
  /*
  $euser = email id
  $epass = email password
  $equota = mailbox allocated size
  */
  function create($euser,$epass,$equota){
      
      $equota = 300;
      

      $url="http://".$this->cpuser.":".$this->cppass."@".$this->cpdomain.":2082/frontend/".$this->cpskin."/mail/doaddpop.html?quota=".$equota."&email=".$euser."&domain=".$this->cpdomain."&password=".$epass;
      
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $body = curl_exec($ch);


      if($body)
        return "Email account created.";
      else if(!$body)
        return "Email account exists";
 }




}

?>