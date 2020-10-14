<!DOCTYPE html>
<html lang="en">
    <?=view('kadhub/frontend/header'); ?>
    <body>
        <?=view('kadhub/frontend/navbar'); ?>

        <!--The carousel slides-->
        <div class="slider" id="slider">
            <div class="slide current">
                <div class="contentSlider">
                    <h1>KADHUB</h1>
                    <p>Easily reserve space 
                    </p>
                </div>
            </div>
            <div class="slide">
                <div class="contentSlider">
                    <h1>KADHUB</h1>
                    <p>Simple and secure access 
                    </p>
                </div>
            </div>
            <div class="slide">
                <div class="contentSlider">
                    <h1>KADHUB</h1>
                    <p>Professional Workspace
                    </p>
                </div>
            </div>
        </div>
        <div class="buttons">
            <button id="prev"><img src="<?=base_url('resources/theme/kadhub/images')?>/back.png" alt=""></button>
            <button id="next"><img src="<?=base_url('resources/theme/kadhub/images')?>/next.png" alt=""></button>
        </div>

        <!--welcome text-->
        <div class="center-txt">
            <h1>WELCOME TO KADHUB</h1>
            <P>Making It Easy For Our Client</P>
            <a href="#" class="center-btn">Discover more</a>
        </div>

        <!--home wirte-up-->
        <section class="heroWrite-head" id="heroWrite-head">
            <div class="heading white">
                <h2 class="text-0">Kadhub</h2>
            </div>
            <div class="content">
                <div class="heroWrite-Up">
                    <p class="text-1">Kadhub is Kaduna state innovative, 
                        incubator and office work space that 
                        aims to provide an open ecosystem environment 
                        for entrepreneurs, innovators and young minds 
                        in the Northern part of Nigeria, where people 
                        could have a platform to work and learn from 
                        kadhub incubation training platform.
                    </p>
                    <p class="text-2">Kadhub is working to groom a collaborative 
                        community of tech enthusiast, developers, 
                        programmers, designers, entrepreneurs, 
                        startup and freelancers within and outside 
                        Kaduna state, making Kaduna State an I.T 
                        hub center and a tech ecosystem environment 
                        in the Northern part of Nigeria. </p>
                </div>
            </div>
        </section>

        <!--The service section-->
        <section class="services" id="services">
            <div class="heading white">
                <h2 class="text-0">Our Services</h2>
            </div>
            <div class="content">
                <div class="serviceBx">
                    <img src="<?=base_url('resources/theme/kadhub/images')?>/rent.png" alt="">
                    <h2>Rentals</h2>
                    <hr>
                    <p>
                        kadhub give you access to rent and use our 
                        ecosystem office environment suitable to meet 
                        your work flow with good internet facilities 
                        and great social amenities in order to meet 
                        your work objectives and goals.
                    </p>
                </div>
                <div class="serviceBx">
                    <img src="<?=base_url('resources/theme/kadhub/images')?>/collaboration.png" alt="">
                    <h2>Collaboration</h2>
                    <hr>
                    <p>
                        At kadhub, we collaborate/partner with clients, 
                        government, business, schools, institutions and 
                        organizations in carrying out outlined goals and 
                        objectives where it is deemed fit.
                    </p>
                </div>
                <div class="serviceBx">
                    <img src="<?=base_url('resources/theme/kadhub/images')?>/training.png" alt="">
                    <h2>Incubation(training)</h2>
                    <hr>
                    <p>
                        kadhub create an environment/platform that 
                        allows natural curiosity to foster learning, 
                        inspire creativity and innovation for tech community, 
                        young minds, startups, innovators and entrepreneurs 
                        through kadhub incubation training platform.
                    </p>
                </div>
                <div class="serviceBx">
                    <img src="<?=base_url('resources/theme/kadhub/images')?>/innovation.png" alt="">
                    <h2>Innovation</h2>
                    <hr>
                    <p>
                        kadhub is setup on a long term goal to create an ecosystem, 
                        innovative idea, product and services to Kaduna state, making 
                        Kaduna an I.T hub/friendly working space environment.
                    </p>
                </div>
            </div>
        </section>

        <!--Feature-head-->
        <section class="features-head" id="features-head">
            <div class="heading white">
                <h2 class="text-0">kadhub Key Features</h2>
            </div>
            <div class="content">
                <div class="features">
                    <img src="<?=base_url('resources/theme/kadhub/images')?>/customer care.png" alt="">
                    <h4>Good Custommer Care services online and offline</h4>
                </div>
                <div class="features">
                    <img src="<?=base_url('resources/theme/kadhub/images')?>/wifi.png" alt="">
                    <h4>High Speed Wi-Fi</h4>
                </div>
                <div class="features">
                    <img src="<?=base_url('resources/theme/kadhub/images')?>/cold.png" alt="">
                    <h4>Air-conditioning</h4>
                </div>
                <div class="features">
                    <img src="<?=base_url('resources/theme/kadhub/images')?>/power.png" alt="">
                    <h4>24/7 Power Supply</h4>
                </div>
                <div class="features">
                    <img src="<?=base_url('resources/theme/kadhub/images')?>/printer.png" alt="">
                    <h4>Printer & Photocopier</h4>
                </div>
                <div class="features">
                    <img src="<?=base_url('resources/theme/kadhub/images')?>/scanner.png" alt="">
                    <h4>Scanner</h4>
                </div>
            </div>
        </section>

        <!--The booking section-->
        <section class="booking" id="booking">
            <div class="heading">
                <h2 class="text-0">Our Office Space</h2>
            </div>
            <div class="content">
                <div class="bookingBx">
                    <div class="bookingDetails">
                        <h4>DEDICATED WORKSTATION</h4>
                        <p>A Dedicate Desk</p>
                        <p>Access to the cafeteria</p>
                        <p>Suitable for freelance</p>
                        <hr>
                        <h4>N1,500 <span>Daily</span></h4>
                    </div>
                    <div class="bookingDetails">
                        <h4>CO-WORKING SPACE</h4>
                        <p>A Dedicate Desk</p>
                        <p>Access to the cafeteria</p>
                        <p>Suitable for freelance</p>
                        <hr>
                        <h4>N1,500 <span>Daily</span></h4>
                        </div>
                </div>
                <div class="bookingBx">
                    <div class="bookingDetails">
                        <h4>MEETING / CONFERENCE ROOM</h4>
                        <p>A Dedicate Desk</p>
                        <p>Access to the cafeteria</p>
                        <p>Suitable for freelance</p>
                        <p>A Dedicate Desk</p>
                        <p>Access to the cafeteria</p>
                        <p>Suitable for freelance</p>
                        <hr>
                        <h4>N2,500 <span>Daily</span></h4>
                    </div>
                </div>
                <div class="bookingBx">
                    <div class="bookingForm">
                        <form action="">
                            <div class="row">
                                <div class="col-25">
                                    <label for="fname">Full Name</label>
                              </div>
                              <div class="col-75">
                                  <input type="text" name="Full Name" placeholder="Full Name" class="mytxt">
                              </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="email">Email</label>
                                </div>
                                <div class="col-75">
                                    <input type="email" name="Email" placeholder="Email">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="phone-call">Phone Number</label>
                                </div>
                                <div class="col-75">
                                    <input type="number" name="Phone Number" placeholder="Phone Number">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="Booking">Booking</label>
                                </div>
                                <div class="col-75">
                                    <select name="Booking" id="Booking">
                                        <option value="Daily">Daily</option>
                                        <option value="Monthly">Monthly</option>
                                        <option value="Daily">Monthly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row bookingbtn">
                                <input type="submit" value="Submit">
                            </div>
                        </form>             
                    </div>
                </div>
        </section>

        <!--The contact sesction-->
        <section class="contact" id="contact">
            <div class="heading">
                <h2 class="text-0">contact us</h2>
            </div>
            <div class="contactSec">
                <div class="container">
                    <div class="contactinfo">
                        <div>
                            <h2>Contact Info</h2>
                            <ul class="info">
                                <li>
                                    <span><img src="<?=base_url('resources/theme/kadhub/images')?>/email.png"></span>
                                    <span>4 John-Auta Road <br>
                                        Narayi-Highcost, <br>
                                        Barnawa, Kaduna State.
                                    </span>
                                </li>
                                <li>
                                    <span><img src="<?=base_url('resources/theme/kadhub/images')?>/placeholder.png"></span>
                                    <span>Eworlddata2018@yahoo.com</span>
                                </li>
                                <li>
                                    <span><img src="<?=base_url('resources/theme/kadhub/images')?>/phone-call.png"></span>
                                    <span>+2347068126116</span>
                                </li>
                            </ul>
                        </div>
                        <ul class="sci">
                            <li><a href=""><img src="<?=base_url('resources/theme/kadhub/images')?>/facebook-f.png"></a></li>
                            <li><a href=""><img src="<?=base_url('resources/theme/kadhub/images')?>/twitter.png"></a></li>
                            <li><a href=""><img src="<?=base_url('resources/theme/kadhub/images')?>/instagram-new.png"></a></li>
                            <li><a href=""><img src="<?=base_url('resources/theme/kadhub/images')?>/linkedin-2.png"></a></li>
                        </ul>
                    </div>
                    <div class="contactForm">
                        <h2>Send a Message</h2>
                        <div class="formBox">
                            <div class="inputBox w50">
                                <input type="text" name="" required>
                                <span>First Name</span>
                            </div>
                            <div class="inputBox w50">
                                <input type="text" name="" required>
                                <span>Last Name</span>
                            </div>
                            <div class="inputBox w50">
                                <input type="email" name="" required>
                                <span>Email Address</span>
                            </div>
                            <div class="inputBox w50">
                                <input type="number" name="" required>
                                <span>Mobile</span>
                            </div>
                            <div class="inputBox w100">
                                <textarea name="" required></textarea>
                                <span>Write Your Message Here...</span>
                            </div>
                            <div class="inputBox w100">
                                <input type="submit" value="Send">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?=view('kadhub/frontend/footer'); ?>
          
        <script src="<?=base_url('resources/theme/kadhub/scripts/main.js')?>"></script>

        <?php if (my_config('tawk_id')): ?>
            <!--Start of Tawk.to Script-->
            <script type="text/javascript">
                var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
                (function(){
                    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                    s1.async=true;
                    s1.src='https://embed.tawk.to/<?=my_config('tawk_id')?>/default';
                    s1.charset='UTF-8';
                    s1.setAttribute('crossorigin','*');
                    s0.parentNode.insertBefore(s1,s0);
                })();
            </script>
            <!--End of Tawk.to Script-->
        <?php endif ?>
    </body>
</html>