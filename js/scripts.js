(function ($) {
    'use strict';

    $(document).on('ready', function () {
        
        // Nice Select
        $('select').niceSelect();
        // -----------------------------
        //  Client Slider
        // -----------------------------
        $('.category-slider').slick({
            slidesToShow:8,
            infinite: true,
            arrows:false,
            autoplay: false,
            autoplaySpeed: 2000
        });
        // -----------------------------
        //  Select Box
        // -----------------------------
        // $('.select-box').selectbox();
        // -----------------------------
        //  Video Replace
        // -----------------------------
        $('.video-box img').click(function() {
            var video = '<iframe allowfullscreen src="' + $(this).attr('data-video') + '"></iframe>';
            $(this).replaceWith(video);
        });
        // -----------------------------
        //  Coupon type Active switch
        // -----------------------------
        $('.coupon-types li').click(function () {
            $('.coupon-types li').not(this).removeClass('active');
            $(this).addClass('active');
        });
        // -----------------------------
        // Datepicker Init
        // -----------------------------
        $('.input-group.date').datepicker({
            format: 'dd/mm/yy'
        });
        // -----------------------------
        // Datepicker Init
        // -----------------------------
        $('#top').click(function() {
          $('html, body').animate({ scrollTop: 0 }, 'slow');
          return false;
        });
        // -----------------------------
        // Button Active Toggle
        // -----------------------------
        $('.btn-group > .btn').click(function(){
            $(this).find('i').toggleClass('btn-active');
        });
        // -----------------------------
        // Coupon Type Select
        // -----------------------------
        $('#online-code').click(function(){
            $('.code-input').fadeIn(500);
        });
        $('#store-coupon, #online-sale').click(function(){
            $('.code-input').fadeOut(500);
        });
        /***ON-LOAD***/
        jQuery(window).on('load', function () {
            
        });

    });

})(jQuery);



 $(document).ready(function() {
  $('select:not(.ignore)').niceSelect();      
});



// GOogle Map

window.marker = null;

function initialize() {
    var map;

    var nottingham = new google.maps.LatLng(51.507351, -0.127758);

    var style = [
    {
        "stylers": [
            {
                "hue": "#ff61a6"
            },
            {
                "visibility": "on"
            },
            {
                "invert_lightness": true
            },
            {
                "saturation": 40
            },
            {
                "lightness": 10
            }
        ]
    }
];

    var mapOptions = {
        // SET THE CENTER
        center: nottingham,

        // SET THE MAP STYLE & ZOOM LEVEL
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        zoom:9,

        // SET THE BACKGROUND COLOUR
        backgroundColor:"#000",

        // REMOVE ALL THE CONTROLS EXCEPT ZOOM
        zoom:17,
        panControl:false,
        zoomControl:true,
        mapTypeControl:false,
        scaleControl:false,
        streetViewControl:false,
        overviewMapControl:false,
        zoomControlOptions: {
            style:google.maps.ZoomControlStyle.LARGE
        }

    }
    map = new google.maps.Map(document.getElementById('map'), mapOptions);

    // SET THE MAP TYPE
    var mapType = new google.maps.StyledMapType(style, {name:"Grayscale"});
    map.mapTypes.set('grey', mapType);
    map.setMapTypeId('grey');

    //CREATE A CUSTOM PIN ICON
    var marker_image ='plugins/google-map/images/marker.png';
    var pinIcon = new google.maps.MarkerImage(marker_image,null,null, null,new google.maps.Size(74, 73));

    marker = new google.maps.Marker({
        position: nottingham,
        map: map,
        icon: pinIcon,
        title: 'eventre'
    });
}

google.maps.event.addDomListener(window, 'load', initialize);




var slider = new Slider('#ex2', {});

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

document.addEventListener('DOMContentLoaded', function () {
  const carousels = document.querySelectorAll('.carousel');
  carousels.forEach(function (carouselEl) {
    new bootstrap.Carousel(carouselEl, {
      interval: 5000, // 5 secondes entre les slides
      ride: 'carousel'
    });
  });
});
document.addEventListener('DOMContentLoaded', function() {
  
  // Toggle menu mobile
  const mobileMenuButton = document.getElementById('mobile-menu-button');
  if (mobileMenuButton) {
    mobileMenuButton.addEventListener('click', function(e) {
      e.stopPropagation();
      const menu = document.getElementById('mobile-menu');
      const openIcon = document.getElementById('menu-open-icon');
      const closeIcon = document.getElementById('menu-close-icon');
      
      if (menu) menu.classList.toggle('hidden');
      if (openIcon) openIcon.classList.toggle('hidden');
      if (closeIcon) closeIcon.classList.toggle('hidden');
    });
  }

  // Toggle menu utilisateur
  const userMenuButton = document.getElementById('user-menu-button');
  if (userMenuButton) {
    userMenuButton.addEventListener('click', function(e) {
      e.stopPropagation();
      const menu = document.getElementById('user-menu');
      if (menu) menu.classList.toggle('hidden');
    });
  }

  // Fermer le menu utilisateur si on clique ailleurs
  document.addEventListener('click', function(event) {
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');
    
    if (userMenuButton && userMenu && 
        !userMenuButton.contains(event.target) && 
        !userMenu.contains(event.target)) {
      userMenu.classList.add('hidden');
    }
  });

  // Fermer le menu mobile en cliquant sur un lien
  const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
  mobileNavLinks.forEach(function(link) {
    link.addEventListener('click', function() {
      const menu = document.getElementById('mobile-menu');
      const openIcon = document.getElementById('menu-open-icon');
      const closeIcon = document.getElementById('menu-close-icon');
      
      if (menu) menu.classList.add('hidden');
      if (openIcon) openIcon.classList.remove('hidden');
      if (closeIcon) closeIcon.classList.add('hidden');
    });
  });
  
});