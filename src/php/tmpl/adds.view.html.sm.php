<?php

if((isset($adds->add1))&&($adds->add1!='')){
	echo $adds->add1.'<br>';
}

if((isset($adds->add2))&&($adds->add2!='')){
	echo $adds->add2.'<br>';
}
if((isset($adds->add3))&&($adds->add3!='')){
	echo $adds->add3.'<br>';
}
if((isset($adds->city))&&($adds->city!='')){
	echo $adds->city.'<br>';
}

if((isset($adds->county))&&($adds->county!='')){
	echo $adds->county.'<br>';
}

if((isset($adds->country))&&($adds->country!='')){
	echo $adds->country.'<br>';
}

if((isset($adds->postcode))&&($adds->postcode!='')){
	echo $adds->postcode.'<br>';
}

if((isset($adds->tel))&&($adds->tel!='')){
	echo 'Tel: '.$adds->tel.'<br>';
}

if((isset($adds->fax))&&($adds->fax!='')){
	echo 'Fax: '.$adds->fax.'<br>';
}

if((isset($adds->email))&&($adds->email!='')){
	echo 'Email: '.$adds->email.'<br>';
}

if((isset($adds->web))&&($adds->web!='')){
	echo 'Web: ' . $adds->web.'<br>';
}

if((isset($adds->facebook))&&($adds->facebook!='')){
	echo 'Facebook: ' . $adds->facebook.'<br>';
}

if((isset($adds->twitter))&&($adds->twitter!='')){
	echo 'Twitter: ' . $adds->twitter.'<br>';
}

if((isset($adds->linkedin))&&($adds->linkedin!='')){
	echo 'Linkedin: ' . $adds->linkedin.'<br>';
}
