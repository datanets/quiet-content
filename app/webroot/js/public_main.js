$(function() {

    if ($.cookie('CakeCookie[actions]') > 0) {
        if ($('.actions').length) {
            $('.actions').toggle();
        }
    }

    $('#close_notice_box').click(function() {

        $('#notice_box').hide();

        var options = { path: '/', expires: 10 };

        // set cookie by number of days
        $.cookie('notice_box', '1', options);
        return false;

    });

    function makeMeSpanish() {
        var frontendtrans = "http://translate.google.com/translate?u=";
        var backendtrans = "&langpair=en%7Ces&hl=en&ie=UTF-8&oe=UTF-8&prev=%2Flanguage_tools";
        var whereami = window.location + "";
        var sendmehere = frontendtrans + whereami + backendtrans;

        window.open(sendmehere);

        return false;
    }

    if ($('#make_me_spanish_link').length) {
        $('#make_me_spanish_link').click(function() {
            makeMeSpanish();
        });
    }

    $(".splash_image_link").corner();
    $('.actions').corner("bl tr");
    $("#page_entry img").corner();

    $("#side_nav a.category_link").click(function() { $(this).next().slideToggle(); });


    // Find categories that need to be opened in side nav... when viewing an entry
    if ($("#parents_path").length) {
        var parents_path_array = $("#parents_path").val();
        parents_path_array = parents_path_array.split(',');

        for (var i = 0; i < parents_path_array.length; i++) {
            $('#side_nav_' + parents_path_array[i]).find('ul:first').show();
        }

    }

    // Highlight entry that is currently being viewed in side nav
    if ($("#current_id").length) {
        $('#side_nav_' + $('#current_id').val()).addClass('side_nav_highlight');
    }
  

    $("a[rel^='prettyPhoto']").prettyPhoto({social_tools:false, theme:'facebook'});

    $('#featured_entries_box a').mouseover(function(){
        $(this).parent().addClass('featured_entries_box_hover');
    });

    $('#featured_entries_box a').mouseout(function(){
        $(this).parent().removeClass('featured_entries_box_hover');
    });

    $(".zebraize li:odd").addClass("zebra-list");
    $(".zebraize tr:odd").addClass("zebra-list");

});
