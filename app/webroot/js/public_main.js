$(function() {

    // Redirect iPhone/iPod visitors
    function isiPhone(){
        return (
            (navigator.platform.indexOf("iPhone") != -1) ||
            (navigator.platform.indexOf("iPod") != -1)
        );
    }

    // Figure out if we want mobile version or full version...
    // depending on if user is on a phone... and if user wants full version...
    //
    // http://www.netlobo.com/url_query_string_javascript.html
    function get_url_parameters(name) {
        name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
        var regexS = "[\\?&]"+name+"=([^&#]*)";
        var regex = new RegExp( regexS );
        var results = regex.exec( window.location.href );
        if( results == null )
        return "";
        else
        return results[1];
    }

    var temp = window.location.href;
    if(isiPhone() && (get_url_parameters('full') != 'true') && ($.cookie('phone_but_full_version') !== '1')){
        window.location = window.location + "mobile/m_welcome";
    }

    if (get_url_parameters('full') == 'true') {
        var options = { path: '/', expires: 5 };
        $.cookie('phone_but_full_version', '1', options);
    }

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
        //window.open = 'http://translate.google.com/translate?u=http%3A%2F%2F', whereami, '%2F&langpair=en%7Ces&hl=en&ie=UTF-8&oe=UTF-8&prev=%2Flanguage_tools';

        return false;
    }

    if ($('#make_me_spanish_link').length) {
        $('#make_me_spanish_link').click(function() {
            makeMeSpanish();
        });
    }

    // if there is a cookie for fontsize changes...
    if ($.cookie('fontsize') > '') {
        var fontSizeIncrement = 1;
        var fontSizeCurrent = 1;
        if ($.cookie('fontsize') > '') {
            fontSizeCurrent = parseInt($.cookie('fontsize'));
        }

        $('body *').each(function() {
            var fontSize = $(this).css('font-size').replace(/px;/i, "");
            fontSize = parseInt(fontSize);
            fontSize += fontSizeIncrement;
            $(this).css('font-size', fontSize + 'px');
        });
    }

    if ($('#small_text').length) {
        $('#small_text').click(function() {

            // just reset text size to original size, for now
            $.removeCookie('fontsize', { path: '/' });
            location.reload();
        });
    }



    if ($('#large_text').length) {
        $('#large_text').click(function() {

            // increment font size depending on stored cookie fontsize
            var fontSizeIncrement = 1;
            var fontSizeCurrent = 1;
            if ($.cookie('fontsize') > '') {
                fontSizeCurrent = parseInt($.cookie('fontsize'));
            }

            $('body *').each(function() {
                var fontSize = $(this).css('font-size').replace(/px;/i, "");
                fontSize = parseInt(fontSize);
                fontSize += fontSizeIncrement;
                $(this).css('font-size', fontSize + 'px');
            });

            fontSizeCurrent++;

            $.cookie('fontsize', fontSizeCurrent, { path: '/' });

        });
    }

    $("#search_box").corner();

    $(".splash_image_link").corner();
    $(".welcome_side_box").corner();
    $(".welcome_side_box_header").corner({
        bl: { radius: 0 },
        br: { radius: 0 }
    });

    $("#announcements_icon").corner();
    $("#calendar_icon").corner();
    /*$("#calendar_icon").corner({
                                tl: false,
                                tr: false,
                                bl: false,
                                br: { radius: 3 }
                                });*/
    var current_date = new Date();
    var current_month = current_date.getMonth();
    var current_day = current_date.getDate();
    var current_day_text = '';

    if (current_day < 10)
        current_day_text = '&nbsp;' + current_day + '&nbsp;';
    else
        current_day_text = current_day;

    var months = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
    $('#calendar_icon_month').text(months[current_month]);
    $('#calendar_icon_day').html(current_day_text);

    //$("#featured_entries_box img").corner();

    $("#search_query").click(function() {
        $(this).val('');
    });

    $("#search_query").blur(function() {
        if ($('#search_query').val() == '') {
            $('#search_query').val('Search')
        };
    });

    if ($("#site_avatar").length) {
        //$("#site_avatar").corner();
    }

    $("#side_nav").corner("bl tr");



    $('.actions').corner("bl tr");


    function menuHoverOver() {
        /*
        var middle_of_page = $(document).width() / 2;

        if ($(this).position().left > middle_of_page - (middle_of_page / 3)) {
            $(this).find('div:first').css('left', $(this).position().left - ($(this).find('div:first').width() / 3));
        } else {

            $(this).find('div:first').css('left', $(this).position().left);
        }
        */
        $(this).find('div:first').css('left', $(this).position().left);

        $(this).find('div:first').show();
        $(this).find('a:first').css('color', $('#inverse_link_color').css('color'));
    }

    function menuHoverOut() {
        $(this).find('div:first').css('left', $(this).position().left);
        $(this).find('div:first').hide();
        $(this).find('a:first').css('color', $('#original_link_color').css('color'));
    }



    var config = {
         sensitivity: 2, // number = sensitivity threshold (must be 1 or higher)
         interval: 100, // number = milliseconds for onMouseOver polling interval
         over: menuHoverOver, // function = onMouseOver callback (REQUIRED)
         timeout: 200, // number = milliseconds delay before onMouseOut
         out: menuHoverOut // function = onMouseOut callback (REQUIRED)
    };

    $('.main_category').hoverIntent(config);
    $('.link_pulldown').hoverIntent(config);


    /*
    $('.main_category').hover( function() { $(this).find('div:first').show(); },
                       function() { $(this).find('div:first').hide(); } );
    */


    // $("#side_nav a.category_link").next().hide(); /* testing if this works better for users */
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
  

    $("a[rel^='prettyPhoto']").prettyPhoto({theme:'facebook'});

    $(".main_category_box").corner();
    $(".link_pulldown_box").corner();

    $('#featured_entries_box a').mouseover(function(){
        $(this).parent().addClass('featured_entries_box_hover');
    });

    $('#featured_entries_box a').mouseout(function(){
        $(this).parent().removeClass('featured_entries_box_hover');
    });


});
