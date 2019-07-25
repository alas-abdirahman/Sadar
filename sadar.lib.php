<?php

    class SadarSMS {

        static $baseUrl = "https://yooltech.com/sadar/portal/smsAPI";


        function __construct($apikey,$apitoken) {
            $this->apikey = $apikey;
            $this->apitoken = $apitoken;
        }
		
	   // Prepare data for request
	   
	    function createPhonebook ($titel,$description,$message="") {
            return $this->makeRequest('contacts_phonebook','GET',[ 'titel' => $titel, 'description' => $description, 'message' => $message]);
        }
		Function createContact ($phonebook_id,$fname,$lname,$number,$dob="") {
            return $this->makeRequest('contacts_create','GET',
									['phonebook_id' => $phonebook_id, 'fname' => $fname, 'lname' => $lname, 'number' => $number,'dob' => $dob]);
        }
		
		function check_balance(){
            return $this->makeRequest('balance','GET','');
        }

        function sendMessageToNumber($to, $message, $sender) {
            $query = array_merge(['type'=>'sms','from'=>$sender, 'to'=>$to, 'text' => $message]);
            return $this->makeRequest('sendsms','GET',$query);
        }

       // Send the request with cURL
        private function makeRequest ($page, $method, $fields=[]) {
           
		   $fields[$page] ="";
            $fields['apikey'] = $this->apikey;
            $fields['apitoken'] = $this->apitoken;

            $url = SadarSMS::$baseUrl;

           
			$fieldsString = http_build_query($fields);


            $ch = curl_init();

            if($method == 'POST')
            {			
                curl_setopt($ch,CURLOPT_POST, count($fields));
                curl_setopt($ch,CURLOPT_POSTFIELDS, $fieldsString);
            }
            else
            {
                $url .= '?'.$fieldsString;
            }
			
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_HEADER , false);  // we want headers
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $result = curl_exec ($ch);

            $result = json_decode($result,true);
			
            curl_close ($ch);

            return $result;
        }
    }

?>
