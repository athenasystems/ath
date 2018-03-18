<?php


echo '<h3>Contact Details</h3>';

html_text("Email", "email", $_POST['email']);

html_text("Mobile", "mob", $_POST['mob']);

html_text("Tel", "tel", $_POST['tel']);

html_text("Fax", "fax", $_POST['fax']);

echo '<h3>Address</h3>';

html_text("Address", "add1", $_POST['add1']);

html_text("&nbsp;", "add2", $_POST['add2']);

html_text("&nbsp;", "add3", $_POST['add3']);

html_text("City", "city", $_POST['city']);

html_text("County", "county", $_POST['county']);

html_text("Country", "country", $_POST['country']);

html_text("Postcode", "postcode", $_POST['postcode']);

html_text("Web", "web", $_POST['web']);

html_text("Facebook", "facebook", $_POST['facebook']);

html_text("Twitter", "twitter", $_POST['twitter']);

html_text("Linkedin", "linkedin", $_POST['linkedin']);
