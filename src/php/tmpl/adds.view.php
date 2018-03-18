<?php

echo '<h3>Address</h3>';


tablerow('Address', $adds->add1);
if((isset($adds->add2))&&($adds->add2!='')){
	tablerow('&nbsp;', $adds->add2);
}
if((isset($adds->add3))&&($adds->add3!='')){
	tablerow('&nbsp;', $adds->add3);
}
tablerow('City', $adds->city);
tablerow('County', $adds->county);
tablerow('Country', $adds->country);
tablerow('Postcode',$adds->postcode );


echo '<h3>Contact Details</h3>';


tablerow('Tel', $adds->tel);
tablerow('Fax',$adds->fax );
tablerow('Email',$adds->email );
tablerow('Web', $adds->web);
tablerow('Facebook', $adds->facebook);
tablerow('Twitter', $adds->twitter);
tablerow('Linkedin', $adds->linkedin);
