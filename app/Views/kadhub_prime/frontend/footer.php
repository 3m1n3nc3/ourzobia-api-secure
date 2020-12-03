    <?php
        $param1 = array(
            'modal_target'  => 'uploadModal', 
            'modal_size'    => 'modal-md',
            'modal_content' => '
            <div class="m-0 p-0 text-center" id="upload_loader">
                <div class="loader">
                    <div class="spinner-grow text-warning"></div>
                </div> 
            </div>'
        );    
        echo view('default/frontend/modal', $param1);
    ?> 

    <?php
        $param = array(
            'modal_target'  => 'actionModal',
            'modal_title'   => 'Action Modal',
            'modal_size'    => 'modal-sm',
            'modal_content' => '
            <div class="m-0 p-0 text-center" id="upload_loader1">
                <div class="loader">
                    <div class="spinner-grow text-warning"></div>
                </div> 
            </div>'
        );
        echo view('default/frontend/modal', $param);
    ?> 

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="social-icons">
                        <ul>
                            <li class="facebook"><a href="<?=my_config('contact_facebook')?>"><i class="fab fa-facebook"></i></a></li>
                            <li class="twitter"><a href="<?=my_config('contact_twitter')?>"><i class="fab fa-twitter"></i></a></li> 
                            <li class="dribbble"><a href="<?=my_config('contact_instagram')?>"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                    <div class="site-info">
                        <p>All copyrights reserved &copy; 2020 - Designed & Developed by <a rel="nofollow" href="https://hoolicontech.com/">Hoolicontech</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <a href="#" class="back-to-top">
        <i class="lnr lnr-arrow-up"></i>
    </a>
<!--     <div id="loader">
        <div class="spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div> -->
    <script src="<?=base_url('resources/theme/kadhub_prime/js/jquery-min.js')?>" type="text/javascript"></script>
    <script src="<?=base_url('resources/js/jquery-ui.min.js')?>"></script>
    <script src="<?=base_url('resources/js/jquery.form.js')?>"></script> 
    <script src="<?=base_url('resources/plugins/toastr/toastr.min.js')?>"></script>
    <script src="<?=base_url('resources/theme/kadhub_prime/js/popper.min.js')?>" type="text/javascript"></script>
    <script src="<?=base_url('resources/theme/kadhub_prime/js/bootstrap.min.js')?>" type="text/javascript"></script>
    <script src="<?=base_url('resources/theme/kadhub_prime/js/classie.js')?>" type="text/javascript"></script>
    <script src="<?=base_url('resources/theme/kadhub_prime/js/jquery.mixitup.js')?>" type="text/javascript"></script>
    <script src="<?=base_url('resources/theme/kadhub_prime/js/nivo-lightbox.js')?>" type="text/javascript"></script>
    <script src="<?=base_url('resources/theme/kadhub_prime/js/owl.carousel.js')?>" type="text/javascript"></script>  
    <script src="<?=base_url('resources/theme/kadhub_prime/js/jquery.stellar.min.js')?>" type="text/javascript"></script>  
    <script src="<?=base_url('resources/theme/kadhub_prime/js/jquery.nav.js')?>" type="text/javascript"></script>  
    <script src="<?=base_url('resources/theme/kadhub_prime/js/scrolling-nav.js')?>" type="text/javascript"></script>  
    <script src="<?=base_url('resources/theme/kadhub_prime/js/jquery.easing.min.js')?>" type="text/javascript"></script>  
    <script src="<?=base_url('resources/theme/kadhub_prime/js/wow.js')?>" type="text/javascript"></script>     
    <script src="<?=base_url('resources/theme/kadhub_prime/js/jquery.counterup.min.js')?>" type="text/javascript"></script>   
    <script src="<?=base_url('resources/theme/kadhub_prime/js/jquery.magnific-popup.min.js')?>" type="text/javascript"></script>
    <script src="<?=base_url('resources/theme/kadhub_prime/js/waypoints.min.js')?>" type="text/javascript"></script>  
    <script src="<?=base_url('resources/theme/kadhub_prime/js/form-validator.min.js')?>" type="text/javascript"></script>    
    <script src="<?=base_url('resources/theme/kadhub_prime/js/contact-form-script.js')?>" type="text/javascript"></script>    
    <script src="<?=base_url('resources/theme/kadhub_prime/js/main.js')?>" type="text/javascript"></script>    
     
    <!-- Custom Functions -->
    <script src="<?=base_url('resources/js/custom.components.js')?>"></script> 
    <script src="<?=base_url('resources/js/custom.functions.js')?>"></script>
    <script src="<?=base_url('resources/js/button.loader.js')?>"></script>

    <script src="<?=base_url('resources/plugins/plyr/plyr.js')?>"></script>
    <script src="<?=base_url('resources/js/custom.scripts.js')?>"></script>  
    <script src="<?=base_url('resources/js/custom.forms.js')?>"></script> 

    <!-- Tooltips and toggle Initialization -->
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip(); 
     
            $('[data-toggle="popover"]').popover();
        });
    </script>

<?php if (!empty($content['contact']) && my_config('google_api_key') && (my_config('contact_address') || my_config('contact_email') || my_config('contact_phone'))): 
    $latLang = explode(',', my_config('google_maps_latlang', null, '44.2072183, -101.3681486'));
    $lat = $latLang[0] ?? "44.2072183";
    $lng = $latLang[1] ?? "-101.3681486";
    ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?=str_ireplace('demo', '', my_config('google_api_key'))?>" type="text/javascript"></script>

    <script type="text/javascript">
        var map;
        let lat    = Number(<?=$lat?>);
        let lng    = Number(<?=$lng?>);
        var defult = new google.maps.LatLng(lat, lng);
        var mapCoordinates = new google.maps.LatLng(lat, lng);
    
    
        var markers = [];
        var image = new google.maps.MarkerImage(
          '<?=base_url('resources/theme/kadhub_prime/img/map-marker.png')?>',
          new google.maps.Size(84, 70),
          new google.maps.Point(0, 0),
          new google.maps.Point(60, 60)
        );
    
        function addMarker() {
          markers.push(new google.maps.Marker({
            position: defult,
            raiseOnDrag: false,
            icon: image,
            map: map,
            draggable: false
          }));
    
        }
    
        function initialize() {
          var mapOptions = {
            backgroundColor: "#fff",
            zoom: 8,
            disableDefaultUI: true,
            center: mapCoordinates,
            zoomControl: false,
            scaleControl: false,
            scrollwheel: false,
            disableDoubleClickZoom: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: [{
                "featureType": "landscape.natural",
                "elementType": "geometry.fill",
                "stylers": [{
                  "color": "#ffffff"
                }]
              }, {
                "featureType": "landscape.man_made",
                "stylers": [{
                  "color": "#ffffff"
                }, {
                  "visibility": "off"
                }]
              }, {
                "featureType": "water",
                "stylers": [{
                  "color": "#80C8E5"
                }, {
                  "saturation": 0
                }]
              }, {
                "featureType": "road.arterial",
                "elementType": "geometry",
                "stylers": [{
                  "color": "#999999"
                }]
              }, {
                "elementType": "labels.text.stroke",
                "stylers": [{
                  "visibility": "off"
                }]
              }, {
                "elementType": "labels.text",
                "stylers": [{
                  "color": "#333333"
                }]
              }
    
              , {
                "featureType": "road.local",
                "stylers": [{
                  "color": "#dedede"
                }]
              }, {
                "featureType": "road.local",
                "elementType": "labels.text",
                "stylers": [{
                  "color": "#666666"
                }]
              }, {
                "featureType": "transit.station.bus",
                "stylers": [{
                  "saturation": -57
                }]
              }, {
                "featureType": "road.highway",
                "elementType": "labels.icon",
                "stylers": [{
                  "visibility": "off"
                }]
              }, {
                "featureType": "poi",
                "stylers": [{
                  "visibility": "off"
                }]
              }
    
            ]
          };
          map = new google.maps.Map(document.getElementById('google-map'), mapOptions);
          addMarker();
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script> 
<?php endif;?>  

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