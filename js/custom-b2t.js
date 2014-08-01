 ;var height = ab2t_str.height;
jQuery(document).ready(function() {

     jQuery("#back-to-top, #rocket").tooltip({
        placement: "left",
        trigger: "hover",
        delay: { show: 100 }, container: "#back-to-top"  }).click(function() {
        jQuery(this).children(".tooltip").removeClass("in")
    });

jQuery(window).scroll(function() {
    jQuery(window).scrollTop() > height ? jQuery("#back-to-top").fadeIn() : jQuery("#back-to-top").fadeOut()
});

});

jQuery(function($){
    $("#back-to-top").click(function() {
    $body = window.opera ? "CSS1Compat" == document.compatMode ? $("html") : $("body") : $("html, body");
    $body.animate({ scrollTop: 0 }, 800);
});
});