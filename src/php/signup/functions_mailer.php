<?php
# Sends HTML / non-html emails out
function send_email($type, $params = array()) {

	global $owner;
	global $domain;

	switch($type){

		case "signup":

			$email = $params['email'];
			$subject = "Newsletter sign up";
			$body = <<<EOD

Newsletter Sign Up

We're just letting you know that someone who visited your site has signed up to the Newsletter.

Their Email is : $email


EOD;

        break;

		case "apply":

		$to[] = $owner->email;
		$subject = 'Application from the web site ...';
		$body = <<< EOM
		Below is an application made online at the web site.
		Application Type: {$params['role']}
		Name: {$params['name']}
		Email: {$params['email']}
		Telephone: {$params['tel']}
		Introduction: {$params['intro']}

EOM;

        break;

	}


		sendGmailEmail("{$owner->co_nick} Web Site", "website@$domain", $subject, $body);


}

