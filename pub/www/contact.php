<?php include '/srv/ath/src/php/www/header.php';?>

        <!-- Global Page Section Start -->
        <section class="global-page-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            <h2>Contact</h2>
                            <ol class="breadcrumb">
                                <li>
                                    <a href="index.php">
                                        <i class="ion-ios-home"></i>
                                        Home
                                    </a>
                                </li>
                                <li class="active">Contact</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </section><!--/#page-header-->


        <!-- Contact Section Start -->
        <section id="contact-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="block">
                            <h2 class="subtitle wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".3s">Contact Us</h2>
                            <p class="subtitle-des wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".5s">
                                Get in touch today! Email or WebChat availible.
                            </p>
                            <div class="contact-form">
                                <form id="contact-form" method="post" action="sendmail.php" role="form">

                                    <div class="form-group wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".6s">
                                        <input type="text" placeholder="Your Name" class="form-control" name="name" id="name">
                                    </div>

                                    <div class="form-group wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".8s">
                                        <input type="email" placeholder="Your Email" class="form-control" name="email" id="email" >
                                    </div>

                                    <div class="form-group wow fadeInDown" data-wow-duration="500ms" data-wow-delay="1s">
                                        <input type="text" placeholder="Subject" class="form-control" name="subject" id="subject">
                                    </div>

                                    <div class="form-group wow fadeInDown" data-wow-duration="500ms" data-wow-delay="1.2s">
                                        <textarea rows="6" placeholder="Message" class="form-control" name="message" id="message"></textarea>
                                    </div>


                                    <div id="submit" class="wow fadeInDown" data-wow-duration="500ms" data-wow-delay="1.4s">
                                        <input type="submit" id="contact-submit" class="btn btn-default btn-send" value="Send Message">
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                         <div class="map-area">
                            <h2 class="subtitle  wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".3s">Location</h2>
                            <p class="subtitle-des wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".5s">
                                We are based in Leicestershire, England. For tailored solutions we arrange travel expenses on a per customer basis.

                            </p>
                            <div class="map">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d77476.8377390061!2d-1.1290419696402054!3d52.63918165384813!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x487742ab49b76c73%3A0x9a151d2a6fb49cb8!2sLeicester!3m2!1d52.6368778!2d-1.1397591999999999!5e0!3m2!1sen!2suk!4v1456059808606" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
<!--                 <div class="row address-details">
                    <div class="col-md-6">
                        <div class="email wow fadeInLeft" data-wow-duration="500ms" data-wow-delay=".7s">
                            <i class="ion-ios-email-outline"></i>
                            <p>sales@xxxxx.co.uk<br>support@xxxxx.co.uk</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="phone wow fadeInLeft" data-wow-duration="500ms" data-wow-delay=".9s">
                            <i class="ion-ios-telephone-outline"></i>
                            <p>+44 116 xxx xxx<br>+447 756 991 615</p>
                        </div>
                    </div>
                </div> -->
            </div>
        </section>

<?php include '/srv/ath/src/php/www/footer.php';?>
