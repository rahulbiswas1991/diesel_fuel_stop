 <footer id="footer">
                <div class="container">
                    <div class="footer-inner wow pixFadeUp">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="widget footer-widget">



                                    <h3 class="widget-title">Company</h3>
                                    <ul class="footer-menu">
                                        <li><a href="#">Legal Note</a></li>
                                        <li><a href="#">Privacy Policy</a></li>
                                        <li><a href="#">Return Policy</a></li>
                                        <li><a href="#">Company Sucessful Notes</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="widget footer-widget">
                                    <h3 class="widget-title">Quick Links</h3>
                                    <ul class="footer-menu">
                                        <li><a href="#home">Home</a></li>
                                        <li><a href="#feature">Features</a></li>
                                        <li><a href="#about">Aboot us</a></li>
                                        <li><a href="#step">Steps</a></li>
                                        <li><a href="#footer">Contact Us</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="widget footer-widget">
                                    <h3 class="widget-title">Digital Experience</h3>
                                    <ul class="footer-menu">
                                        <li><a href="#">Features</a></li>
                                        <li><a href="#">Dashboard & Tool</a></li>
                                        <li><a href="#">Our Portfolio</a></li>
                                        <li><a href="#">About Us</a></li>
                                        <li><a href="#">Get In Touch</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="widget footer-widget">
                                    <!--<h3 class="widget-title">Our Address</h3>-->
                                    <!--<p>Address: india</p>-->
                                    <!--<p>Phone: 1234567890</p>-->
                                    <ul class="footer-social-link">
                                        <li>
                                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="fab fa-twitter"></i></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="fab fa-google-plus-g"></i></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="site-info">
                        <div class="copyright">
                            <p>© 2021 All Rights Reserved Design by <a href="<?php echo base_url();?>" target="_blank">TDEX</a></p>
                        </div>
                        
                    </div>
                </div>
            </footer>
        
        
        


        </div>
        <script src="<?=$path?>dependencies/jquery/jquery.min.js"></script>
        <script src="<?=$path?>dependencies/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?=$path?>dependencies/swiper/js/swiper.min.js"></script>
        <script src="<?=$path?>dependencies/jquery.appear/jquery.appear.js"></script>
        <script src="<?=$path?>dependencies/wow/js/wow.min.js"></script>
        <script src="<?=$path?>dependencies/countUp.js/countUp.min.js"></script>
        <script src="<?=$path?>dependencies/isotope-layout/isotope.pkgd.min.js"></script>
        <script src="<?=$path?>dependencies/imagesloaded/imagesloaded.pkgd.min.js"></script>
        <script src="<?=$path?>dependencies/jquery.parallax-scroll/js/jquery.parallax-scroll.js"></script>
        <script src="<?=$path?>dependencies/magnific-popup/js/jquery.magnific-popup.min.js"></script>
        <script src="<?=$path?>dependencies/gmap3/js/gmap3.min.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDk2HrmqE4sWSei0XdKGbOMOHN3Mm2Bf-M&amp;ver=2.1.6"></script>
        <script src="<?=$path?>js/header.js"></script>
        <script src="<?=$path?>js/app.js"></script>
        <script type="text/javascript" src="<?=$path?>js/jquery-1.12.4.min.js"></script>
        <script type="text/javascript" src="<?=$path?>js/jquery.waterwheelCarousel.min.js"></script>
        
        <!--<script type="text/javascript" src="<?=$path?>js/index.js"></script>-->
        <!--<script type="text/javascript" src="<?=$path?>js/main.js"></script>-->
        <!--<script type="text/javascript" src="https://static.cryptowat.ch/assets/scripts/embed.bundle.js"></script>-->

        <script>
            var chart = new cryptowatch.Embed('bitfinex', 'btcusd', {
	timePeriod: '1d',
  width: 650,
  presetColorScheme: 'delek'
});
chart.mount('#chart-container');
        </script>
        <script type="text/javascript">
            /*
    * Application state
    */
    const state = {
      items: [],
      count: 0,
      isDone: false
    }

    function drawLine(theBox) {
      var connector = theBox.children[0];
      var item = document.querySelector('.__item');
      var text = document.querySelector('.__item .text');

      var distanceBetweenItemAndLine = (item.offsetWidth / 2) - text.offsetWidth;

      if (theBox.classList.contains('__left')) {
        connector.style.left = text.offsetWidth + 'px';
      } else {
        connector.style.right = text.offsetWidth + 'px';
      }

      // Adds line after transition time specified in CSS is done
      setTimeout(function () { connector.style.width = distanceBetweenItemAndLine + 'px'; }, 600);
    }

    function shouldItemAppear(item) {
      let x = item.getBoundingClientRect().top;
      if (x <= (window.innerHeight - item.offsetHeight)) {

        //Is the item a goal?
        //If so apply a different transformation
        if (item.classList.contains('__goals')) {

          //Bring in the coin first
          item.children[1].style.opacity = '1'
          //Then the rest
          setTimeout(() => { item.children[2].style.opacity = '1'; }, 500);

        } else {

          item.style.transform = 'translateX(0)'
          drawLine(item)

        }

        //Count items then call isDone
        state.count++;
        state.count == state.items.length ? state.isDone = true : null;
      }
    }

    function isScrolling() {
      //Stop firing
      if (state.isDone == true) {
        window.removeEventListener('scroll', isScrolling);
        window.cancelAnimationFrame(isScrolling);
        return;
      }

      shouldItemAppear(state.items[state.count]);
      window.requestAnimationFrame(isScrolling);
    }

    function getAllItems() {
      var scrollY = window.scrollY + window.innerHeight;
      var items = document.querySelectorAll('#roadmap .__item');

      for (var x = 0; x < items.length; x++) {
        state.items.push(items[x])
      }

    }

    function drawLinesMobile() {
      var connectors = document.querySelectorAll('.__item .connector');
      var item = document.querySelector('.__item');
      var text = document.querySelector('.__item .text');

      var distanceBetweenItemAndLine = (item.offsetWidth / 2) - text.offsetWidth;

      for (var x = 0; x < connectors.length; x++) {
        connectors[x].style.width = item.offsetWidth - text.offsetWidth + 'px';
      }
    }


    function checkResolution() {
      if (window.innerWidth > 850) {
        getAllItems();
        window.addEventListener('scroll', isScrolling);
      } else {
        drawLinesMobile();
      }
    }

    window.addEventListener('load', checkResolution);
    window.requestAnimationFrame(isScrolling);
        </script>
                    <script type="text/javascript">
 $('#myCarousel').carousel({
    interval: 3000,
 })
    </script>
        <script type="text/javascript" charset="utf-8">
var $ = jQuery.noConflict(); 
$(document).ready(function () {
$("#frame").attr("src", "<?= base_url('frontend/ticker_mobile') ?>");
});
var $ = jQuery.noConflict(); 
$(document).ready(function () {
$("#frame-sec").attr("src", "<?= base_url('frontend/ticker_mobile_second') ?>");
});
var $ = jQuery.noConflict(); 
$(document).ready(function () {
$("#frame-third").attr("src", "<?= base_url('frontend/ticker_mobile_third') ?>");
});
</script> 
    </body>
  
</html>
