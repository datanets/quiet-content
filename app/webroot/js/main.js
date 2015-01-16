$(function() {

    $.url = function(url) {
        return $('base').attr('href')+url.substr(1);
    }

    //$('#nav').droppy({speed: 100});

    /*var options = {minWidth: 120, arrowSrc: '..' + $('base').attr('href') + 'img/arrow_right.gif', onClick: function(e, menuItem){
        alert('you clicked item "' + $(this).text() + '"');
    }};*/

    var options = {minWidth: 120, arrowSrc: '..' + $('base').attr('href') + 'img/arrow_right.gif'};
    $('#nav').menu(options);


    // time picker for schedule events
    $('.time-selection').timePicker();

    $('.date-selection').datepicker({ dateFormat: 'yy-mm-dd' });


    // check if we really want to delete something from an index page
    $('#index_delete').click(function(){

        var answer = confirm('Are you sure you want to delete this?');

        if (answer) {
        } else {
            return false;
        }

    });

    $('#select_all_checkboxes').click(function() {
        $(":checkbox").attr("checked", true);
        return false;
    });

    $('#select_none_checkboxes').click(function() {
        $(":checkbox").attr("checked", false);
        return false;
    });



    //$(".record").corner("dog tr");
    $("#dashboard_search_box").corner();
    $("#indoor_search_box").corner();


    //$('#page_top_link').scrollTo('#page_top');


    /* Address Book */

    $("#table_list_address_book").dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "bStateSave": true,
        "aoColumns": [
                { "sWidth": "1%" },
                { "sType": "html" },
                null,
                null,
                null,
                null,
                null,
                { "sClass": "datatables_column_centered" }
                ]
    });


    /* Contact Types */
    
    $("#table_list_contact_types").dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "bStateSave": true,
        "aoColumns": [
                { "sWidth": "1%" },
                { "sType": "html" },
                { "sClass": "datatables_column_centered" }
                ]
    });


    /* Countries */

    $("#table_list_countries").dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "bStateSave": true,
        "aoColumns": [
                { "sWidth": "1%" },
                { "sType": "html" },
                { "sClass": "datatables_column_centered" }
                ]
    });



    /* Equipment Types */

    $("#table_list_equipment_types").dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "bStateSave": true,
        "aoColumns": [
                { "sWidth": "1%" },
                { "sType": "html" },
                { "sClass": "datatables_column_centered" }
                ]
    });


    /* Events */

    $("#table_list_events").dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "bStateSave": true,
        "aoColumns": [
                { "sWidth": "1%" },
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null
                ]
    });


    /* Event Types */
    
    $("#table_list_event_types").dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "bStateSave": true,
        "aoColumns": [
                { "sWidth": "1%" },
                { "sType": "html" },
                { "sClass": "datatables_column_centered" }
                ]
    });


    /* Locations */

    $("#table_list_locations").dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "bStateSave": true,
        "aoColumns": [
                { "sWidth": "1%" },
                null,
                { "sClass": "datatables_column_centered" }
                ]
    });
 

    /* Mailings */

    $("#table_list_mailings").dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "bStateSave": true,
        "aoColumns": [
                { "sWidth": "1%" },
                { "sType": "html" },
                null,
                null,
                { "sClass": "datatables_column_centered" }
                ]
    });


    // install the event handler for #debug #output
    $('textarea').keydown(update).keyup(update).mousedown(update).mouseup(update).mousemove(update);

    // Add template tags
    $('#mailing_first_name').click(function(e) {
        $('#MailingBody').replaceSelection('{{first_name}}', true);
        $.each($('#MailingBody'), update);
        e.preventDefault();
    });

    $('#mailing_last_name').click(function(e) {
        $('#MailingBody').replaceSelection('{{last_name}}', true);
        $.each($('#MailingBody'), update);
        e.preventDefault();
    });

    $('#mailing_full_name').click(function(e) {
        $('#MailingBody').replaceSelection('{{full_name}}', true);
        $.each($('#MailingBody'), update);
        e.preventDefault();
    });

    $('#mailing_repeat_event_template').click(function(e) {
        $('#MailingBody').replaceSelection('{{repeat}}', true);
        $.each($('#MailingBody'), update);
        e.preventDefault();
    });

    $('#mailing_end_repeat_event_template').click(function(e) {
        $('#MailingBody').replaceSelection('{{endrepeat}}', true);
        $.each($('#MailingBody'), update);
        e.preventDefault();
    });

    $('#mailing_event_id').click(function(e) {
        $('#MailingBody').replaceSelection('{{event_id}}', true);
        $.each($('#MailingBody'), update);
        e.preventDefault();
    });

    $('#mailing_event_title').click(function(e) {
        $('#MailingBody').replaceSelection('{{event_title}}', true);
        $.each($('#MailingBody'), update);
        e.preventDefault();
    });

    $('#mailing_event_description').click(function(e) {
        $('#MailingBody').replaceSelection('{{event_description}}', true);
        $.each($('#MailingBody'), update);
        e.preventDefault();
    });

    $('#mailing_event_date').click(function(e) {
        $('#MailingBody').replaceSelection('{{event_date}}', true);
        $.each($('#MailingBody'), update);
        e.preventDefault();
    });

    $('#mailing_event_time').click(function(e) {
        $('#MailingBody').replaceSelection('{{event_time}}', true);
        $.each($('#MailingBody'), update);
        e.preventDefault();
    });

    $('#mailing_event_location').click(function(e) {
        $('#MailingBody').replaceSelection('{{event_location}}', true);
        $.each($('#MailingBody'), update);
        e.preventDefault();
    });

    $('#mailing_event_room').click(function(e) {
        $('#MailingBody').replaceSelection('{{event_room}}', true);
        $.each($('#MailingBody'), update);
        e.preventDefault();
    });

    $('#mailing_event_equipment_needs').click(function(e) {
        $('#MailingBody').replaceSelection('{{event_equipment_needs}}', true);
        $.each($('#MailingBody'), update);
        e.preventDefault();
    });

    function update() {

        // here we fetch our text range object
        var range = $(this).getSelection();

        // just dump the values
        $('#output').html(
            "hexdump:\n" + hexdump(this.value, range.start, (range.end != range.start) ? range.end - 1 : range.end) + "\n\n" +
            "id: " + this.id + "\n" +
            "start: " + range.start + "\n" +
            "length: " + range.length + "\n" +
            "end: " + range.end + "\n" +
            ((typeof range['row'] != 'undefined') ? "caret row: " + range.row + "\n" : '') +
            ((typeof range['col'] != 'undefined') ? "caret col: " + range.col + "\n" : '') +
            "selected text:\n<span class=\"txt\">" + (range.text) + "</span>\n\n"
        );

    }

    function hexdump(txt, hi_f, hi_t) {
        var hex = '', tmp;

        if (txt) {

            for (var i = 0, j = txt.length; i <= j; i++) {

                tmp = txt.charCodeAt(i).toString(16);

                if (i == hi_f)
                    hex += '<span class="hi">';

                if (i < txt.length)
                    hex += ( (tmp.length == 2) ? tmp : '0' + tmp );
                else
                    hex += "&nbsp;&nbsp;";

                if (i == hi_t)
                    hex += '</span>';

                if ((i+1) % 16 == 0)
                    hex += "\n";
                else
                    hex += ' ';

            }

        }

        return hex;

    }


    $("a#add_mailing_filter").click(function(){

        // this is for temporarily-assigned ids for added mailing filters (that may or many not be saved in the end)
        var temp_id_count = parseInt($('#add_mailing_filter_temporary_id_count').val()) + 1;

        $('#add_mailing_filter_temporary_id_count').val(temp_id_count);

        var do_not_reset_these_values = [ "MailingRecipientFilter0MailingId" ];

        // check if there are any existing items
        if ($('#sortable > li').size() > 0) {

            $('#mrg_' + ($('#sortable > li').size()-1)).clone().
            removeAttr("id").attr('id','mrg_' + $('#sortable > li').size()).
            find("input,textarea,select").each(function() {

                for ( var i in do_not_reset_these_values ) {
                    do_not_reset_these_values[i] = do_not_reset_these_values[i].replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#sortable > li').size()) + "$2");
                }

                if ($(this).attr('id')) {
                    $(this).attr('id', function() {
                        return this.id.replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#sortable > li').size()) + "$2");
                    });
                }

                if ($(this).attr('name')) {
                    $(this).attr('name', function() {
                        return this.name.replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#sortable > li').size()) + "$2");
                    });
                }

                if ($(this).attr('selected')) {
                    $(this).removeAttr('selected');
                }

                // check if this item is something we want to reset or not
                if ($(this).attr('value') && ($.inArray($(this).attr('id'), do_not_reset_these_values) == -1)) {
                    $(this).removeAttr('value');
                }

            }).end().
            find("option").each(function() {

                if ($(this).attr('selected')) {
                    $(this).removeAttr('selected');
                }

            }).end().
            find('.delete_mailing_filter').removeClass().attr('class', 'delete_mailing_filter temporary temporary_' + $('#add_mailing_filter_temporary_id_count').val()).end().
            find('.delete_mailing_filter').bind('click', function(){
                delete_mailing_filter_logic(this);
            }).end().
            find('.item_id').empty().end().
            find('.weight_box input').val($('#sortable > li').size()+1).end().
            appendTo('#sortable');

        } else {

            // get a dummy item
            $('#dummy_item_mailing_recipient_filter > li:first').clone().
            find('.delete_mailing_filter').bind('click', function(){
                delete_mailing_filter_logic(this);
            }).end().
            appendTo('#sortable');
        }

    });

    function delete_mailing_filter_logic(logics_this)
    {
        var really_delete = confirm("Are you sure you want to delete this member from the filter?");

        if (really_delete) {

            //alert($(logics_this).attr('class'));
            if ($(logics_this).is('.temporary')) {
                //alert('this is temporary');
                $(logics_this).closest('li').remove();
                return;
            }

            if ($(logics_this).attr("class") && $('#delete_these_mailing_filters').val()) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_mailing_filter ', ''));
                $('#delete_these_mailing_filters').val($('#delete_these_mailing_filters').val() + "," + number_from_class);
            } else if ($(logics_this).attr("class")) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_mailing_filter ', ''));
                $('#delete_these_mailing_filters').val(number_from_class);
            }

            if ($('#' + $(logics_this).closest('li').attr('id')))
                $('#' + $(logics_this).closest('li').attr('id')).remove();

        } else {
            return false;
        }

    }

 
    $(".delete_mailing_filter").click(function(){
        delete_mailing_filter_logic(this);
    });


    $("a#add_mailing_group").click(function(){

        // this is for temporarily-assigned ids for added mailing groups (that may or many not be saved in the end)
        var temp_id_count = parseInt($('#add_mailing_group_temporary_id_count').val()) + 1;

        $('#add_mailing_group_temporary_id_count').val(temp_id_count);

        var do_not_reset_these_values = [ "MailingRecipientGroup0MailingId" ];

        // check if there are any existing items
        if ($('#sortable2 > li').size() > 0) {

            $('#mrg_' + ($('#sortable2 > li').size()-1)).clone().
            removeAttr("id").attr('id','mrg_' + $('#sortable2 > li').size()).
            find("input,textarea,select").each(function() {

                for ( var i in do_not_reset_these_values ) {
                    do_not_reset_these_values[i] = do_not_reset_these_values[i].replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#sortable2 > li').size()) + "$2");
                }

                if ($(this).attr('id')) {
                    $(this).attr('id', function() {
                        return this.id.replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#sortable2 > li').size()) + "$2");
                    });
                }

                if ($(this).attr('name')) {
                    $(this).attr('name', function() {
                        return this.name.replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#sortable2 > li').size()) + "$2");
                    });
                }

                if ($(this).attr('selected')) {
                    $(this).removeAttr('selected');
                }

                // check if this item is something we want to reset or not
                if ($(this).attr('value') && ($.inArray($(this).attr('id'), do_not_reset_these_values) == -1)) {
                    $(this).removeAttr('value');
                }

            }).end().
            find("option").each(function() {

                if ($(this).attr('selected')) {
                    $(this).removeAttr('selected');
                }

            }).end().
            find('.delete_mailing_group').removeClass().attr('class', 'delete_mailing_group temporary temporary_' + $('#add_mailing_group_temporary_id_count').val()).end().
            find('.delete_mailing_group').bind('click', function(){
                delete_mailing_group_logic(this);
            }).end().
            find('.item_id').empty().end().
            find('.weight_box input').val($('#sortable2 > li').size()+1).end().
            appendTo('#sortable2');

        } else {

            // get a dummy item
            $('#dummy_item_mailing_recipient_group > li:first').clone().
            find('.delete_mailing_group').bind('click', function(){
                delete_mailing_group_logic(this);
            }).end().
            appendTo('#sortable2');
        }

    });

    function delete_mailing_group_logic(logics_this)
    {
        var really_delete = confirm("Are you sure you want to delete this member from the group?");

        if (really_delete) {

            //alert($(logics_this).attr('class'));
            if ($(logics_this).is('.temporary')) {
                //alert('this is temporary');
                $(logics_this).closest('li').remove();
                return;
            }

            if ($(logics_this).attr("class") && $('#delete_these_mailing_groups').val()) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_mailing_group ', ''));
                $('#delete_these_mailing_groups').val($('#delete_these_mailing_groups').val() + "," + number_from_class);
            } else if ($(logics_this).attr("class")) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_mailing_group ', ''));
                $('#delete_these_mailing_groups').val(number_from_class);
            }

            if ($('#' + $(logics_this).closest('li').attr('id')))
                $('#' + $(logics_this).closest('li').attr('id')).remove();

        } else {
            return false;
        }

    }

 
    $(".delete_mailing_group").click(function(){
        delete_mailing_group_logic(this);
    });


    $("a#add_mailing_individual").click(function(){

        // this is for temporarily-assigned ids for added mailing individuals (that may or many not be saved in the end)
        var temp_id_count = parseInt($('#add_mailing_individual_temporary_id_count').val()) + 1;

        $('#add_mailing_individual_temporary_id_count').val(temp_id_count);

        var do_not_reset_these_values = [ "MailingRecipientIndividual0MailingId" ];

        // check if there are any existing items
        if ($('#sortable3 > li').size() > 0) {

            $('#mri_' + ($('#sortable3 > li').size()-1)).clone().
            removeAttr("id").attr('id','mri_' + $('#sortable3 > li').size()).
            find("input,textarea,select").each(function() {

                for ( var i in do_not_reset_these_values ) {
                    do_not_reset_these_values[i] = do_not_reset_these_values[i].replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#sortable3 > li').size()) + "$2");
                }

                if ($(this).attr('id')) {
                    $(this).attr('id', function() {
                        return this.id.replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#sortable3 > li').size()) + "$2");
                    });
                }

                if ($(this).attr('name')) {
                    $(this).attr('name', function() {
                        return this.name.replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#sortable3 > li').size()) + "$2");
                    });
                }

                if ($(this).attr('selected')) {
                    $(this).removeAttr('selected');
                }

                // check if this item is something we want to reset or not
                if ($(this).attr('value') && ($.inArray($(this).attr('id'), do_not_reset_these_values) == -1)) {
                    $(this).removeAttr('value');
                }

            }).end().
            find("option").each(function() {

                if ($(this).attr('selected')) {
                    $(this).removeAttr('selected');
                }

            }).end().
            find('.delete_mailing_individual').removeClass().attr('class', 'delete_mailing_individual temporary temporary_' + $('#add_mailing_individual_temporary_id_count').val()).end().
            find('.delete_mailing_individual').bind('click', function(){
                delete_mailing_individual_logic(this);
            }).end().
            find('.item_id').empty().end().
            find('.weight_box input').val($('#sortable3 > li').size()+1).end().
            appendTo('#sortable3');

        } else {

            // get a dummy item
            $('#dummy_item_mailing_recipient_individual > li:first').clone().
            find('.delete_mailing_individual').bind('click', function(){
                delete_mailing_individual_logic(this);
            }).end().
            appendTo('#sortable3');
        }

    });

    function delete_mailing_individual_logic(logics_this)
    {
        var really_delete = confirm("Are you sure you want to delete this member from the group?");

        if (really_delete) {

            //alert($(logics_this).attr('class'));
            if ($(logics_this).is('.temporary')) {
                //alert('this is temporary');
                $(logics_this).closest('li').remove();
                return;
            }

            if ($(logics_this).attr("class") && $('#delete_these_mailing_individuals').val()) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_mailing_individual ', ''));
                $('#delete_these_mailing_individuals').val($('#delete_these_mailing_individuals').val() + "," + number_from_class);
            } else if ($(logics_this).attr("class")) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_mailing_individual ', ''));
                $('#delete_these_mailing_individuals').val(number_from_class);
            }

                //alert($('#' + $(logics_this).closest('li').attr('id')).html());
            if ($('#' + $(logics_this).closest('li').attr('id')))
                $('#' + $(logics_this).closest('li').attr('id')).remove();

        } else {
            return false;
        }

    }

 
    $(".delete_mailing_individual").click(function(){
        delete_mailing_individual_logic(this);
    });


    /* Mailing Filters */

    $("#table_list_mailing_filters").dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "bStateSave": true,
        "aoColumns": [
                { "sWidth": "1%" },
                { "sType": "html" },
                { "sClass": "datatables_column_centered" }
                ]
    });


    /* Mailing Groups */

    $("#table_list_mailing_groups").dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "bStateSave": true,
        "aoColumns": [
                { "sWidth": "1%" },
                null,
                { "sClass": "datatables_column_centered" }
                ]
    });


    $("a#add_group_member").click(function(){

        // this is for temporarily-assigned ids for new group_members (that may or many not be saved in the end)
        var temp_id_count = parseInt($('#new_group_member_temporary_id_count').val()) + 1;

        $('#new_group_member_temporary_id_count').val(temp_id_count);


        var do_not_reset_these_values = [ "MailingGroupMember0MailingGroupId" ];

        // check if there are any existing items
        if ($('#sortable > li').size() > 0) {

            $('#cs_' + ($('#sortable > li').size()-1)).clone().
            removeAttr("id").attr('id','cs_' + $('#sortable > li').size()).
            find("input,textarea,select").each(function() {

                for ( var i in do_not_reset_these_values ) {
                    do_not_reset_these_values[i] = do_not_reset_these_values[i].replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#sortable > li').size()) + "$2");
                }

                if ($(this).attr('id')) {
                    $(this).attr('id', function() {
                        return this.id.replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#sortable > li').size()) + "$2");
                    });
                }

                if ($(this).attr('name')) {
                    $(this).attr('name', function() {
                        return this.name.replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#sortable > li').size()) + "$2");
                    });
                }

                if ($(this).attr('selected')) {
                    $(this).removeAttr('selected');
                }

                // check if this item is something we want to reset or not
                if ($(this).attr('value') && ($.inArray($(this).attr('id'), do_not_reset_these_values) == -1)) {
                    $(this).removeAttr('value');
                }

            }).end().
            find("option").each(function() {

                if ($(this).attr('selected')) {
                    $(this).removeAttr('selected');
                }

            }).end().
            find('.delete_group_member').removeClass().attr('class', 'delete_group_member temporary temporary_' + $('#new_group_member_temporary_id_count').val()).end().
            find('.delete_group_member').bind('click', function(){
                delete_group_member_logic(this);
            }).end().
            find('.item_id').empty().end().
            find('.weight_box input').val($('#sortable > li').size()+1).end().
            appendTo('#sortable');

        } else {

            // get a dummy item
            $('#dummy_item > li:first').clone().
            find('.delete_group_member').bind('click', function(){
                delete_group_member_logic(this);
            }).end().
            appendTo('#sortable');

        }

    });


    function delete_group_member_logic(logics_this)
    {
        var really_delete = confirm("Are you sure you want to delete this member from the group?");

        if (really_delete) {

            if ($(logics_this).is('.temporary')) {
                //alert('this is temporary');
                $(logics_this).closest('li').remove();
                return;
            }

            if ($(logics_this).attr("class") && $('#delete_these_group_members').val()) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_group_member ', ''));
                $('#delete_these_group_members').val($('#delete_these_group_members').val() + "," + number_from_class);
            } else if ($(logics_this).attr("class")) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_group_member ', ''));
                $('#delete_these_group_members').val(number_from_class);
            }

            if ($('#' + $(logics_this).closest('li').attr('id')))
                $('#' + $(logics_this).closest('li').attr('id')).remove();

        } else {
            return false;
        }

    }

 
    $(".delete_group_member").click(function(){
        delete_group_member_logic(this);
    });



    /* Range Record Templates */

    $("#table_list_range_record_templates").dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "bStateSave": true,
        "aoColumns": [
                { "sWidth": "1%" },
                { "sType": "html" },
                { "sClass": "datatables_column_centered" }
                ]
    });


    $('#refresh_preview').click(function() {

        var refreshed_textarea = $('#RangeRecordTemplateFormat').val();

        $('#range_record_template_preview > pre:first').html(refreshed_textarea);

    });


    /* Rooms */

    $("#table_list_rooms").dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "bStateSave": true,
        "aoColumns": [
                { "sWidth": "1%" },
                null,
                { "sClass": "datatables_column_centered" }
                ]
    });


    /* Schedules */

    $("#table_list_schedules").dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "bStateSave": true,
        "aoColumns": [
                { "sWidth": "1%" },
                { "sType": "html" },
                null,
                null,
                { "sClass": "datatables_column_centered" },
                { "sClass": "datatables_column_centered" },
                { "sClass": "datatables_column_centered" }
                ]
    });

    function extra_equipment_logic(logics_this) {
        $(logics_this).parent().parent().find(".extra_equipment").toggle().end();
        return false;
    }

    $(".extra_equipment_link").click(function(){ $(this).parent().parent().find(".extra_equipment").toggle().end(); return false; });
    
    $(".sortable").sortable({
        start: function(e, ui) {
        },
        update: function(e, ui) {

            var newOrderArray = new Array();
            var newOrderArrayTemp = new Array();

            // first, find all of the weight-related list items
            newOrderArrayTemp = $(".sortable").find("input[id*='Weight']");

            // just get the id from the key/value for each list item
            for (var i = 0, len = newOrderArrayTemp.length; i < len; i++) {
                newOrderArray[i] = $(newOrderArrayTemp[i]).attr('id');
            }

            // then make changes to weight value in DOM (numbering starts 1, 2, 3...)
            for (var i = 0, len = newOrderArray.length; i < len; i++) {
                $("#" + newOrderArray[i]).val(i+1);
            }
            
        }
    });

    $(".sortable").disableSelection();


    $(".sortable2").sortable({
        start: function(e, ui) {
        },
        update: function(e, ui) {

            var newOrderArray = new Array();
            var newOrderArrayTemp = new Array();

            // first, find all of the weight-related list items
            newOrderArrayTemp = $(".sortable2").find("input[id*='Weight']");

            // just get the id from the key/value for each list item
            for (var i = 0, len = newOrderArrayTemp.length; i < len; i++) {
                newOrderArray[i] = $(newOrderArrayTemp[i]).attr('id');
            }

            // then make changes to weight value in DOM (numbering starts 1, 2, 3...)
            for (var i = 0, len = newOrderArray.length; i < len; i++) {
                $("#" + newOrderArray[i]).val(i+1);
            }
            
        }
    });

    $(".sortable2").disableSelection();


    $("a#add_item").click(function(){

        // this is for temporarily-assigned ids for new events (that may or many not be saved in the end)
        var temp_id_count = parseInt($('#new_event_temporary_id_count').val()) + 1;

        $('#new_event_temporary_id_count').val(temp_id_count);


        var do_not_reset_these_values = [ "ScheduleEvent0ScheduleId", "ScheduleEvent0EventDate" ];

        // check if there are any existing items
        if ($('#sortable > li').size() > 0) {

            $('#cs_' + ($('#sortable > li').size()-1)).clone().
            removeAttr("id").attr('id','cs_' + $('#sortable > li').size()).
            find("input,textarea,select,a").each(function() {

                for ( var i in do_not_reset_these_values ) {
                    do_not_reset_these_values[i] = do_not_reset_these_values[i].replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#sortable > li').size()) + "$2");
                }

                if ($(this).attr('id')) {
                    $(this).attr('id', function() {
                        return this.id.replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#sortable > li').size()) + "$2");
                    });
                }

                if ($(this).attr('name')) {
                    $(this).attr('name', function() {

                        // this is so html tags don't get changed by accident
                        if (this.name != 'h1' && this.name != 'h2' && this.name != 'h3' && this.name != 'h4' && this.name != 'h5' && this.name != 'h6') {
                            return this.name.replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#sortable > li').size()) + "$2");
                        }
                    });
                }

                if ($(this).attr('href')) {
                    $(this).attr('href', function() {
                        return $(this).attr('href').replace(/\#.*$/, "#event" + ($('#sortable > li').size()));
                    });
                }

                if ($(this).attr('class')) {
                    $(this).attr('class', function() {
                        return $(this).attr('class').replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#sortable > li').size()) + "$2");
                    });
                }

                if ($(this).attr('selected')) {
                    $(this).removeAttr('selected');
                }

                // check if this item is something we want to reset or not
                if ($(this).attr('value') && ($.inArray($(this).attr('id'), do_not_reset_these_values) == -1)) {
                    $(this).removeAttr('value');
                }

            }).end().
            find("option").each(function() {

                if ($(this).attr('selected')) {
                    $(this).removeAttr('selected');
                }

            }).end().
            find('.delete_event').removeClass().attr('class', 'delete_event temporary temporary_' + $('#new_group_member_temporary_id_count').val()).end().
            find('.delete_event').bind('click', function(){
                delete_event_logic(this);
            }).end().
            find('.html_tag').bind('click', function(){
                html_tag_logic(this);
            }).end().
            find('.extra_equipment_link').bind('click', function(){
                extra_equipment_logic(this);
                return false;
            }).end().
            find('.time-selection').bind('click', function(){
                $(this).timePicker();
            }).end().
            find('.item_id').empty().end().
            find('.weight_box input').val($('#sortable > li').size()+1).end().
            appendTo('#sortable');

        } else {

            // get a dummy item
            $('#dummy_item_event > li:first').clone().
            find('.delete_event').bind('click', function(){
                delete_group_member_logic(this);
            }).end().
            find('.html_tag').bind('click', function(){
                html_tag_logic(this);
            }).end().
            find('.extra_equipment_link').bind('click', function(){
                extra_equipment_logic(this);
                return false;
            }).end().
            find('.time-selection').bind('click', function(){
                $(this).timePicker();
            }).end().
            appendTo('#sortable');

        }

        // time picker for schedule events (yes, again... because otherwise you have to click twice for some odd reason)
        $('.time-selection').timePicker();
        $('#sortable .date-selection').each(function() {
            //alert($(this).attr('id'));
            $(this).removeClass();
            $(this).datepicker({ dateFormat: 'yy-mm-dd' });
            $(this).addClass('date-selection');
        });
    });


    function delete_event_logic(logics_this)
    {
        var really_delete = confirm("Are you sure you want to delete this event?");

        if (really_delete) {

            //alert($(logics_this).attr('class'));
            if ($(logics_this).is('.temporary')) {
                //alert('this is temporary');
                $(logics_this).closest('li').remove();
                return;
            }

            if ($(logics_this).attr("class") && $('#delete_these_events').val()) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_event ', ''));
                $('#delete_these_events').val($('#delete_these_events').val() + "," + number_from_class);
            } else if ($(logics_this).attr("class")) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_event ', ''));
                $('#delete_these_events').val(number_from_class);
            }

            if ($('#' + $(logics_this).closest('li').attr('id')))
                $('#' + $(logics_this).closest('li').attr('id')).remove();

        } else {
            return false;
        }

    }

 
    $(".delete_event").click(function(){
        delete_event_logic(this);
    });



    $("a#add_page").click(function(){

        // this is for temporarily-assigned ids for new events (that may or many not be saved in the end)
        var temp_id_count = parseInt($('#new_page_temporary_id_count').val()) + 1;

        $('#new_page_temporary_id_count').val(temp_id_count);


        var do_not_reset_these_values = [ "SchedulePage0ScheduleId", "SchedulePage0EventDate" ];

        // check if there are any existing items
        if ($('#sortable > li').size() > 0) {

            $('#cs_' + ($('#sortable > li').size()-1)).clone().
            removeAttr("id").attr('id','cs_' + $('#sortable > li').size()).
            find("input,textarea,select,a").each(function() {

                for ( var i in do_not_reset_these_values ) {
                    do_not_reset_these_values[i] = do_not_reset_these_values[i].replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#sortable > li').size()) + "$2");
                }

                if ($(this).attr('id')) {
                    $(this).attr('id', function() {
                        return this.id.replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#sortable > li').size()) + "$2");
                    });
                }

                if ($(this).attr('name')) {
                    $(this).attr('name', function() {

                        // this is so html tags don't get changed by accident
                        if (this.name != 'h1' && this.name != 'h2' && this.name != 'h3' && this.name != 'h4' && this.name != 'h5' && this.name != 'h6') {
                            return this.name.replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#sortable > li').size()) + "$2");
                        }
                    });
                }

                if ($(this).attr('href')) {
                    $(this).attr('href', function() {
                        return $(this).attr('href').replace(/\#.*$/, "#page" + ($('#sortable > li').size()));
                    });
                }

                if ($(this).attr('class')) {
                    $(this).attr('class', function() {
                        return $(this).attr('class').replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#sortable > li').size()) + "$2");
                    });
                }

                if ($(this).attr('selected')) {
                    $(this).removeAttr('selected');
                }

                // check if this item is something we want to reset or not
                if ($(this).attr('value') && ($.inArray($(this).attr('id'), do_not_reset_these_values) == -1)) {
                    $(this).removeAttr('value');
                }

            }).end().
            find("option").each(function() {

                if ($(this).attr('selected')) {
                    $(this).removeAttr('selected');
                }

            }).end().
            find('.delete_event').removeClass().attr('class', 'delete_event temporary temporary_' + $('#new_group_member_temporary_id_count').val()).end().
            find('.delete_event').bind('click', function(){
                delete_event_logic(this);
            }).end().
            find('.html_tag').bind('click', function(){
                html_tag_logic(this);
            }).end().
            find('.extra_equipment_link').bind('click', function(){
                extra_equipment_logic(this);
                return false;
            }).end().
            find('.name_label > a').attr('name', 'page' + ($('#sortable > li').size())).end().
            find('.time-selection').bind('click', function(){
                $(this).timePicker();
            }).end().
           find('.item_id').empty().end().
            find('.weight_box input').val($('#sortable > li').size()+1).end().
            appendTo('#sortable');

        } else {

            // get a dummy item
            $('#dummy_item_page > li:first').clone().
            find('.delete_event').bind('click', function(){
                delete_event_logic(this);
            }).end().
            find('.html_tag').bind('click', function(){
                html_tag_logic(this);
            }).end().
            find('.date-selection').bind('click', function(){
                $(this).datepicker({ dateFormat: 'yy-mm-dd' });
            }).end().
            find('.hidden_schedule_id > input:first').val($('#ScheduleId').val()).end().
            appendTo('#sortable');

        }

        // time picker for schedule events (yes, again... because otherwise you have to click twice for some odd reason)
        $('.time-selection').timePicker();
        $('#sortable .date-selection').each(function() {
            //alert($(this).attr('id'));
            $(this).removeClass();
            $(this).datepicker({ dateFormat: 'yy-mm-dd' });
            $(this).addClass('date-selection');
        });
    });







    /* Schedule Templates */

    $("#table_list_schedule_templates").dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "bStateSave": true,
        "aoColumns": [
                { "sWidth": "1%" },
                null,
                { "sClass": "datatables_column_centered" }
                ]
    });

    
    function template_tag_logic(logics_this)
    {
        var css_class_array = $(logics_this).attr('class').split(' ');
        var textbox_id = css_class_array[css_class_array.length - 1];
        var replace_logics_this = $(logics_this).attr('name');

        $('#' + textbox_id).replaceSelection('{{' + replace_logics_this + '}}', true);
        $.each($('#' + textbox_id), update);
        e.preventDefault();
    }

    function html_tag_logic(logics_this)
    {

        var css_class_array = $(logics_this).attr('class').split(' ');
        var textbox_id = css_class_array[css_class_array.length - 1];
        var selection = $('#' + textbox_id).getSelectionText();
        var tag = $(logics_this).attr('name');

        $('#' + textbox_id).addHTMLTags(selection, tag);
        $.each($('#' + textbox_id), update);
        e.preventDefault();
    }


    // Add template tags
    $('.template_tag').click(function(e) {
        template_tag_logic(this);
    });

    // Add HTML tags
    $('.html_tag').click(function(e) {
        html_tag_logic(this);
    });



    /**
     * BLOCKS
     *
     * This mostly deals with anything that is common to all blocks (such as deletion)
     */
 
    function delete_block_logic(logics_this)
    {
        var really_delete = confirm("Are you sure you want to delete this block?");

        if (really_delete) {

            if ($(logics_this).is('.temporary')) {

                var update_blocks_array_string = $('#newly_added_blocks').val();
                var update_blocks_array = update_blocks_array_string.split(',');

                /*  for debug

                    alert('update_blocks_array_string: ' + update_blocks_array_string);    // for debug

                    for( var i in update_blocks_array) {
                        alert('i: ' + update_blocks_array[i]);
                    }

                */

                var new_update_blocks_string = '';
                var found_it = 0;

                for( var i in update_blocks_array) {

                    // alert ('i in update_blocks_array: ' + update_blocks_array[i]);   // for debug

                    $(logics_this).closest('li').find('.item_id > input:first').each(function(){

                        if ($(this).val() == update_blocks_array[i]) {
                            // alert('found it');   // for debug
                            found_it = 1;
                        }
                        
                    }).end();

                    if (found_it == 1) {

                    } else {

                        if (new_update_blocks_string > '') {
                            new_update_blocks_string += ',' + update_blocks_array[i];
                        } else {
                            new_update_blocks_string = update_blocks_array[i];
                        }
                    }

                    found_it = 0;   // reset found_it

                }

                $('#newly_added_blocks').val(new_update_blocks_string);

                // update for future:
                // rewrite the weight values for table blocks when a LI is deleted
                // at the moment it doesn't make a difference because the table blocks are not rearrangeable


                // remove LI item
                $(logics_this).closest('li').remove();

                $('#new_block_starting_inner_id_count').val(parseInt($('#new_block_starting_inner_id_count').val()) - 1);

                return;
            }

            if ($(logics_this).attr("class") && $('#delete_these_blocks').val()) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_block ', ''));
                $('#delete_these_blocks').val($('#delete_these_blocks').val() + "," + number_from_class);
            } else if ($(logics_this).attr("class")) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_block ', ''));
                $('#delete_these_blocks').val(number_from_class);
            }

            if ($('#' + $(logics_this).closest('li').attr('id')))
                $('#' + $(logics_this).closest('li').attr('id')).remove();

            $('#new_block_starting_inner_id_count').val(parseInt($('#new_block_starting_inner_id_count').val()) - 1);

        } else {
            return false;
        }
 
    }

    $(".delete_block").click(function(){
        delete_block_logic(this);
    });


    /**
     * TEXT BOXES
     */

    $("a#add_template_text_box").click(function(){

        // update new_block_starting_id_count counter
        var temp_id_count = $('#new_block_starting_inner_id_count').val();

        // var temp_id_count = $('#new_block_starting_id_count').val(); // pre-May 30 way

        var do_not_reset_these_values = [ "ScheduleTemplateBlock0ScheduleTemplateId", "ScheduleTemplateBlock0ScheduleTemplateBlockType" ];

        // get a dummy item
        $('#dummy_item_template_text > li:first').clone().
        removeAttr("id").attr('id','cs_' + temp_id_count).
        find("input,textarea,select,a").each(function() {

            for ( var i in do_not_reset_these_values ) {
                do_not_reset_these_values[i] = do_not_reset_these_values[i].replace(/([^\d]*)\d+([^\d]*)/, "$1" + temp_id_count + "$2");
            }

            if ($(this).attr('id')) {
                $(this).attr('id', function() {
                    return this.id.replace(/([^\d]*)\d+([^\d]*)/, "$1" + temp_id_count + "$2");
                });
            }

            if ($(this).attr('name')) {
                $(this).attr('name', function() {
                    return this.name.replace(/([^\d]*)\d+([^\d]*)/, "$1" + temp_id_count + "$2");
                });
            }

            if ($(this).attr('href')) {
                $(this).attr('href', function() {
                    return $(this).attr('href').replace(/\#.*$/, "#block" + temp_id_count);
                });
            }

            if ($(this).attr('class')) {
                $(this).attr('class', function() {
                    return $(this).attr('class').replace(/([^\d]*)\d+([^\d]*)/, "$1" + temp_id_count + "$2");
                });
            }

            if ($(this).attr('selected')) {
                $(this).removeAttr('selected');
            }

            // check if this item is something we want to reset or not
            if ($(this).attr('value') && ($.inArray($(this).attr('id'), do_not_reset_these_values) == -1)) {
                $(this).removeAttr('value');
            }

        }).end().
        find("option").each(function() {

            if ($(this).attr('selected')) {
                $(this).removeAttr('selected');
            }

        }).end().

        find('.delete_block').removeClass().attr('class', 'delete_block temporary temporary_' + $('#new_block_starting_id_count').val()).end().
        find('.aname').attr('name', 'cs_' + temp_id_count).end().
        find('.delete_block').bind('click', function(){
            delete_block_logic(this);
        }).end().
        find('.add_column').bind('click', function(){
            add_column_logic(this);
        }).end().
        find('.template_tag').bind('click', function(){
            template_tag_logic(this);
        }).end().
        find('.html_tag').bind('click', function(){
            html_tag_logic(this);
        }).end().
        find('.name_label > a').attr('name', 'page' + ($('#sortable > li').size())).end().
        find('.item_id').
            find('input').each(function() {
                if ($(this).attr('id')) {
                    return $(this).val(parseInt($('#new_block_starting_id_count').val()) + 1);
                }
            }).end().
        end().
        find('.weight_box input').val($('#sortable > li').size() + 1).end().
        appendTo('#sortable');



        // update new_block_starting_id_count counter
        temp_id_count = parseInt($('#new_block_starting_id_count').val()) + 1;

        $('#new_block_starting_id_count').val(temp_id_count);

        // inner id count is used when setting up $this->data array to start at 0 for sure...
        $('#new_block_starting_inner_id_count').val(parseInt($('#new_block_starting_inner_id_count').val()) + 1);

        // update what blocks are new
        if ($('#newly_added_blocks').val()) {
            $('#newly_added_blocks').val($('#newly_added_blocks').val() + ',' + $('#new_block_starting_id_count').val());
        } else {
            $('#newly_added_blocks').val($('#new_block_starting_id_count').val());
        }

    });



    /**
     * DATA TABLES
     */

    $("a#add_template_data_table").click(function(){

        // update new_block_starting_id_count counter
        var temp_id_count = $('#new_block_starting_inner_id_count').val();

        // var temp_id_count = $('#new_block_starting_id_count').val(); // pre-May 30 way

        var do_not_reset_these_values = [ "ScheduleTemplateBlock0ScheduleTemplateId", "ScheduleTemplateBlock0ScheduleTemplateBlockType" ];

        // get a dummy item
        $('#dummy_item_template_table > li:first').clone().
        removeAttr("id").attr('id','cs_' + temp_id_count).
        find('.table_column').empty().end().
        find("input,textarea,select").each(function() {

            for ( var i in do_not_reset_these_values ) {
                do_not_reset_these_values[i] = do_not_reset_these_values[i].replace(/([^\d]*)\d+([^\d]*)/, "$1" + temp_id_count + "$2");
            }

            if ($(this).attr('id')) {
                $(this).attr('id', function() {
                    return this.id.replace(/([^\d]*)\d+([^\d]*)/, "$1" + temp_id_count + "$2");
                });
            }

            if ($(this).attr('name')) {
                $(this).attr('name', function() {
                    return this.name.replace(/([^\d]*)\d+([^\d]*)/, "$1" + temp_id_count + "$2");
                });
            }

            if ($(this).attr('href')) {
                $(this).attr('href', function() {
                    return $(this).attr('href').replace(/\#.*$/, "#block" + temp_id_count);
                });
            }

            if ($(this).attr('class')) {
                $(this).attr('class', function() {
                    return $(this).attr('class').replace(/([^\d]*)\d+([^\d]*)/, "$1" + temp_id_count + "$2");
                });
            }

            if ($(this).attr('selected')) {
                $(this).removeAttr('selected');
            }

            // check if this item is something we want to reset or not
            if ($(this).attr('value') && ($.inArray($(this).attr('id'), do_not_reset_these_values) == -1)) {
                $(this).removeAttr('value');
            }

        }).end().
        find("option").each(function() {

            if ($(this).attr('selected')) {
                $(this).removeAttr('selected');
            }

        }).end().

        find('.delete_block').removeClass().attr('class', 'delete_block temporary temporary_' + $('#new_block_starting_id_count').val()).end().
        find('.add_column').attr('href', this.href.replace(/([^\#]*)\#(.*)$/, "$1" + "#cs_" + temp_id_count)).removeClass().attr('class', 'add_column table_columns_' + temp_id_count).end().
        find('.table_column').attr('id', 'table_columns_' + temp_id_count).end().
        find('.aname').attr('name', 'cs_' + temp_id_count).end().
        find('.delete_block').bind('click', function(){
            delete_block_logic(this);
        }).end().
        find('.add_column').bind('click', function(){
            add_column_logic(this);
        }).end().
        find('.name_label > a').attr('name', 'page' + ($('#sortable > li').size())).end().
        find('.item_id').
            find('input').each(function() {
                if ($(this).attr('id')) {
                    return $(this).val(parseInt($('#new_block_starting_id_count').val()) + 1);
                }
            }).end().
        end().
        find('.weight_box input').val($('#sortable > li').size() + 1).end().
        appendTo('#sortable');



        // update new_block_starting_id_count counter
        temp_id_count = parseInt($('#new_block_starting_id_count').val()) + 1;

        $('#new_block_starting_id_count').val(temp_id_count);

        // inner id count is used when setting up $this->data array to start at 0 for sure...
        $('#new_block_starting_inner_id_count').val(parseInt($('#new_block_starting_inner_id_count').val()) + 1);


        // update what blocks are new
        if ($('#newly_added_blocks').val()) {
            $('#newly_added_blocks').val($('#newly_added_blocks').val() + ',' + $('#new_block_starting_id_count').val());
        } else {
            $('#newly_added_blocks').val($('#new_block_starting_id_count').val());
        }

    });

    function add_column_logic(logics_this)
    {
        // update new_column_starting_id_count counter
        var temp_id_count = parseInt($('#new_column_starting_id_count').val()) + 1;

        $('#new_column_starting_id_count').val(temp_id_count);

        var new_id = temp_id_count - 1;

        var current_table = $(logics_this).attr('class');

        var current_block_id = $(logics_this).attr('class');
        current_block_id = current_block_id.replace(/[^\d]*(\d+)$/, "$1");
        current_block_id = $('#ScheduleTemplateBlock' + current_block_id + 'Id').val();

        var current_last_li = $(logics_this).attr('class');
        current_table = current_table.replace('add_column ', '');
        current_last_li = current_last_li.replace('add_column ', '');

current_last_li = 'current_table_0_0';

        //current_last_li = current_last_li.replace('table_columns', 'current_table') + '_' + ($('#' + current_table + ' > li').size()-1);
        var replacement_id = current_table.replace('table_columns', 'current_table') + '_' + ($('#' + current_table + ' > li').size());

        var do_not_reset_these_values = [ "ScheduleTemplateBlockTableColumn0ScheduleTemplateBlockId" ];

        // for debugging purposes
        //alert('temp_id_count: ' + temp_id_count + "\n" + 'current_table: ' + current_table + "\n" + 'current_block_id: ' + current_block_id + "\n" + 'current_last_li: ' + current_last_li + "\n" + current_table + '_' + $('#' + current_table + ' > li').size() + "\n" + replacement_id + "\n" + $('#new_column_starting_id_count').val());


        // get a dummy item

        $('#dummy_item_template_table_column > li:first').clone().
        removeAttr("id").attr('id', replacement_id).
        find("input,textarea,select,a").each(function() {

            for ( var i in do_not_reset_these_values ) {
                do_not_reset_these_values[i] = do_not_reset_these_values[i].replace(/([^\d]*)\d+([^\d]*)/, "$1" + new_id + "$2");
            }

            if ($(this).attr('id')) {
                $(this).attr('id', function() {
                    return this.id.replace(/([^\d]*)\d+([^\d]*)/, "$1" + new_id + "$2");
                });
            }

            if ($(this).attr('name')) {
                $(this).attr('name', function() {
                    return this.name.replace(/([^\d]*)\d+([^\d]*)/, "$1" + new_id + "$2");
                });
            }

            if ($(this).attr('class')) {
                $(this).attr('class', function() {
                    return $(this).attr('class').replace(/([^\d]*)\d+([^\d]*)/, "$1" + new_id + "$2");
                });
            }

            if ($(this).attr('selected')) {
                $(this).removeAttr('selected');
            }

            // check if this item is something we want to reset or not
            if ($(this).attr('value') && ($.inArray($(this).attr('id'), do_not_reset_these_values) == -1)) {
                $(this).removeAttr('value');
            }

        }).end().
        find("option").each(function() {

            if ($(this).attr('selected')) {
                $(this).removeAttr('selected');
            }

        }).end().
        find('.delete_column').removeClass().attr('class', 'delete_column temporary').end().
        find('.add_column').removeClass().attr('class', 'add_column table_columns_' + $('#sortable > li').size()).end().
        find('.add_column').bind('click', function(){
            add_column_logic(this);
        }).end().
        find('.template_tag').bind('click', function(){
            template_tag_logic(this);
        }).end().
        find('.html_tag').bind('click', function(){
            html_tag_logic(this);
        }).end().
        find('.item_id').
            find('input').each(function() {
                if ($(this).attr('id')) {
                    return $(this).val(temp_id_count);
                }
            }).end().
        end().
        find('.schedule_template_block_id').
            find('input').each(function() {
                if ($(this).attr('id')) {
                    return $(this).val(current_block_id);
                }
            }).end().
        end().
        find('.time-selection').bind('click', function(){
            $(this).timePicker();
        }).end().
        find('.weight_box input').val($('#' + current_table + ' > li').size()+1).end().
        find('.column_order_box input').val($('#' + current_table + ' > li').size()+1).end().
        find('.delete_link').html('<a href="#" class="delete_column 0">Delete</a>').end().
        find('.delete_column').bind('click', function(){
            delete_column_logic(this);
        }).end().
        appendTo('#' + current_table);


        // time picker for column time_from and time_to (yes, again... because otherwise you have to click twice for some odd reason)
        $('.time-selection').timePicker();

        // update what columns are new
        if ($('#newly_added_columns').val()) {
            $('#newly_added_columns').val($('#newly_added_columns').val() + ',' + $('#new_column_starting_id_count').val());
        } else {
            $('#newly_added_columns').val($('#new_column_starting_id_count').val());
        }

    }

    $(".add_column").click(function(){
        add_column_logic(this);
    });



    function delete_column_logic(logics_this)
    {
        var really_delete = confirm("Are you sure you want to delete this column?");

        if (really_delete) {

            //alert($(logics_this).attr('class'));
            if ($(logics_this).is('.temporary')) {
                //alert('this is temporary');

                var update_columns_array_string = $('#newly_added_columns').val();
                var update_columns_array = update_columns_array_string.split(',');

                var new_update_columns_string = '';
                var found_it = 0;


                for( var i in update_columns_array) {
                    $(logics_this).closest('li').find('#ScheduleTemplateBlockTableColumn' + (update_columns_array[i] - 1) + 'ListBy').each(function(){
                        //alert('found it');
                        found_it = 1;
                        
                    }).end();

                    if (found_it == 1) {

                    } else {

                        if (new_update_columns_string > '') {
                            new_update_columns_string += ',' + update_columns_array[i];
                        } else {
                            new_update_columns_string = update_columns_array[i];
                        }
                    }

                    found_it = 0;   // reset found_it

                }

                $('#newly_added_columns').val(new_update_columns_string);

                // update for future:
                // rewrite the weight values for table columns when a LI is deleted
                // at the moment it doesn't make a difference because the table columns are not rearrangeable


                // remove LI item
                $(logics_this).closest('li').remove();
                return;
            }

            if ($(logics_this).attr("class") && $('#delete_these_columns').val()) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_column ', ''));
                $('#delete_these_columns').val($('#delete_these_columns').val() + "," + number_from_class);
            } else if ($(logics_this).attr("class")) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_column ', ''));
                $('#delete_these_columns').val(number_from_class);
            }

            if ($('#' + $(logics_this).closest('li').attr('id')))
                $('#' + $(logics_this).closest('li').attr('id')).remove();

        } else {
            return false;
        }
 
    }

    $(".delete_column").click(function(){
        delete_column_logic(this);
    });





    /**
     * RANGE RECORDS
     */

    $("a#add_template_range_record").click(function(){

        // update new_block_starting_id_count counter
        var temp_id_count = $('#new_block_starting_inner_id_count').val();

        // var temp_id_count = $('#new_block_starting_id_count').val(); // pre-May 30 way

        var do_not_reset_these_values = [ "ScheduleTemplateBlock0ScheduleTemplateId", "ScheduleTemplateBlock0ScheduleTemplateBlockType" ];

        // get a dummy item
        $('#dummy_item_template_range_record > li:first').clone().
        removeAttr("id").attr('id','cs_' + temp_id_count).
        find("input,textarea,select").each(function() {

            for ( var i in do_not_reset_these_values ) {
                do_not_reset_these_values[i] = do_not_reset_these_values[i].replace(/([^\d]*)\d+([^\d]*)/, "$1" + temp_id_count + "$2");
            }

            if ($(this).attr('id')) {
                $(this).attr('id', function() {
                    return this.id.replace(/([^\d]*)\d+([^\d]*)/, "$1" + temp_id_count + "$2");
                });
            }

            if ($(this).attr('name')) {
                $(this).attr('name', function() {
                    return this.name.replace(/([^\d]*)\d+([^\d]*)/, "$1" + temp_id_count + "$2");
                });
            }

            if ($(this).attr('href')) {
                $(this).attr('href', function() {
                    return $(this).attr('href').replace(/\#.*$/, "#block" + temp_id_count);
                });
            }

            if ($(this).attr('class')) {
                $(this).attr('class', function() {
                    return $(this).attr('class').replace(/([^\d]*)\d+([^\d]*)/, "$1" + temp_id_count + "$2");
                });
            }

            if ($(this).attr('selected')) {
                $(this).removeAttr('selected');
            }

            // check if this item is something we want to reset or not
            if ($(this).attr('value') && ($.inArray($(this).attr('id'), do_not_reset_these_values) == -1)) {
                $(this).removeAttr('value');
            }

        }).end().
        find("option").each(function() {

            if ($(this).attr('selected')) {
                $(this).removeAttr('selected');
            }

        }).end().

        find('.delete_block').removeClass().attr('class', 'delete_block temporary').end().
        find('.add_cell').attr('href', this.href.replace(/([^\#]*)\#(.*)$/, "$1" + "#cs_" + temp_id_count)).removeClass().attr('class', 'add_cell range_record_cells_' + temp_id_count).end().
        find('.range_record_cell').attr('id', 'range_record_cells_' + temp_id_count).end().
        find('.aname').attr('name', 'cs_' + temp_id_count).end().
        find('.delete_block').bind('click', function(){
            delete_block_logic(this);
        }).end().
        find('.add_cell').bind('click', function(){
            add_cell_logic(this);
        }).end().
        find('.range_template_type').bind('change', function(){
            range_template_type_logic(this);
        }).end().
        find('.name_label > a').attr('name', 'page' + ($('#sortable > li').size())).end().
        find('.item_id').
            find('input').each(function() {
                if ($(this).attr('id')) {
                    return $(this).val(parseInt($('#new_block_starting_id_count').val()) + 1);
                }
            }).end().
        end().
        find('.weight_box input').val($('#sortable > li').size() + 1).end().
        find('.range_template_preview_box').
            find('div:first').attr('id', 'range_template_preview_' + temp_id_count).end().
        end().
        appendTo('#sortable');


        // update new_block_starting_id_count counter
        temp_id_count = parseInt($('#new_block_starting_id_count').val()) + 1;

        $('#new_block_starting_id_count').val(temp_id_count);

        // inner id count is used when setting up $this->data array to start at 0 for sure...
        $('#new_block_starting_inner_id_count').val(parseInt($('#new_block_starting_inner_id_count').val()) + 1);

        // update what blocks are new
        if ($('#newly_added_blocks').val()) {
            $('#newly_added_blocks').val($('#newly_added_blocks').val() + ',' + $('#new_block_starting_id_count').val());
        } else {
            $('#newly_added_blocks').val($('#new_block_starting_id_count').val());
        }

    });


    function range_template_type_logic(logics_this)
    {

        var current_block = 0;
        var new_selection = $(logics_this).val();

        $(logics_this).parent().find('div.range_template_preview_box > div:first').each(function() {
                                                                                current_block = $(this).attr('id');
                                                                            }).end();


        // erase previous preview
        $('#' + current_block).empty();

        // get preview from dummy below and append it into the template_preview div
        $('#dummy_range_template_preview_' + new_selection + ' > pre:first').clone().
        appendTo('#' + current_block);

    }


    // refresh range template preview when user selects another template for a partciular range record
    $('.range_template_type').change(function(){
        range_template_type_logic(this);
    });


    // add ability to show range template preview to any pre-existing range records on page's first load
    $('.range_template_type').each(function(index) {
        range_template_type_logic($(this).attr('id'));
    }); 



    function add_cell_logic(logics_this)
    {
        // update new_cell_starting_id_count counter
        var temp_id_count = parseInt($('#new_cell_starting_id_count').val()) + 1;

        $('#new_cell_starting_id_count').val(temp_id_count);

        var new_id = temp_id_count - 1;

        var current_range_record = $(logics_this).attr('class');

        var current_block_id = $(logics_this).attr('class');
        current_block_id = current_block_id.replace(/[^\d]*(\d+)$/, "$1");
        current_block_id = $('#ScheduleTemplateBlock' + current_block_id + 'Id').val();

        var current_last_li = $(logics_this).attr('class');
        current_range_record = current_range_record.replace('add_cell ', '');
        current_last_li = current_last_li.replace('add_cell ', '');


current_last_li = 'current_range_record_0_0';

        //current_last_li = current_last_li.replace('range_record_cells', 'current_range_record') + '_' + ($('#' + current_range_record + ' > li').size()-1);
        var replacement_id = current_range_record.replace('range_record_cells', 'current_range_record') + '_' + ($('#' + current_range_record + ' > li').size());

        var do_not_reset_these_values = [ "ScheduleTemplateBlockRangeRecordCell0ScheduleTemplateBlockId" ];

        // for debugging purposes
        //alert('temp_id_count: ' + temp_id_count + "\n" + 'current_range_record: ' + current_range_record + "\n" + 'current_block_id: ' + current_block_id + "\n" + 'current_last_li: ' + current_last_li + "\n" + current_range_record + '_' + $('#' + current_range_record + ' > li').size() + "\n" + replacement_id + "\n" + $('#new_cell_starting_id_count').val());


        // get a dummy item
        $('#dummy_item_template_range_record_cell > li:first').clone().
        removeAttr("id").attr('id', replacement_id).
        find("input,textarea,select").each(function() {

            for ( var i in do_not_reset_these_values ) {
                do_not_reset_these_values[i] = do_not_reset_these_values[i].replace(/([^\d]*)\d+([^\d]*)/, "$1" + new_id + "$2");
            }

            if ($(this).attr('id')) {
                $(this).attr('id', function() {
                    return this.id.replace(/([^\d]*)\d+([^\d]*)/, "$1" + new_id + "$2");
                });
            }

            if ($(this).attr('name')) {
                $(this).attr('name', function() {
                    return this.name.replace(/([^\d]*)\d+([^\d]*)/, "$1" + new_id + "$2");
                });
            }

            if ($(this).attr('selected')) {
                $(this).removeAttr('selected');
            }

            // check if this item is something we want to reset or not
            if ($(this).attr('value') && ($.inArray($(this).attr('id'), do_not_reset_these_values) == -1)) {
                $(this).removeAttr('value');
            }

        }).end().
        find("option").each(function() {

            if ($(this).attr('selected')) {
                $(this).removeAttr('selected');
            }

        }).end().
        find('.delete_cell').removeClass().attr('class', 'delete_cell temporary temporary_' + $('#new_cell_temporary_id_count').val()).end().
        find('.add_cell').removeClass().attr('class', 'add_cell range_record_cells_' + $('#sorrange_record > li').size()).end().
        find('.add_cell').bind('click', function(){
            add_cell_logic(this);
        }).end().
        find('.item_id').
            find('input').each(function() {
                if ($(this).attr('id')) {
                    return $(this).val(temp_id_count);
                }
            }).end().
        end().
        find('.schedule_template_block_id').
            find('input').each(function() {
                if ($(this).attr('id')) {
                    return $(this).val(current_block_id);
                }
            }).end().
        end().
        find('.cell_title_box h4:first').html('Cell ' + ($('#' + current_range_record + ' > li').size()+1)).end().
        find('.cell_order_box input').val($('#' + current_range_record + ' > li').size()+1).end().
        find('.delete_link').html('<a href="#" class="delete_cell 0 temporary">Delete</a>').end().
        find('.delete_cell').bind('click', function(){
            delete_cell_logic(this);
        }).end().
        appendTo('#' + current_range_record);


        // update what cells are new
        if ($('#newly_added_cells').val()) {
            $('#newly_added_cells').val($('#newly_added_cells').val() + ',' + $('#new_cell_starting_id_count').val());
        } else {
            $('#newly_added_cells').val($('#new_cell_starting_id_count').val());
        }

    }


    $(".add_cell").click(function(){
        add_cell_logic(this);
    });


    function reorganize_cells(current_record)
    {
        // reorganize cell titles and orders
        var index = 1;
        $('#' + current_record).find('.cell_title_box').each(function() {
            $(this).html('<label>Cell ' + index + '</label>');
            index++;
        }).end();

        index = 1;
        $('#' + current_record).find('.cell_order_box > input').each(function() {
            $(this).val(index);
            index++;
        }).end();
    }


    function delete_cell_logic(logics_this)
    {
        var really_delete = confirm("Are you sure you want to delete this cell?");

        current_record = $(logics_this).parent().parent().parent().attr('id');
//alert($(logics_this).attr('class'));
        if (really_delete) {

            //alert($(logics_this).attr('class'));
            if ($(logics_this).is('.temporary')) {
                //alert('this is temporary');

                var update_cells_array_string = $('#newly_added_cells').val();
                var update_cells_array = update_cells_array_string.split(',');

                var new_update_cells_string = '';
                var found_it = 0;


                for( var i in update_cells_array) {
                    $(logics_this).closest('li').find('#ScheduleTemplateBlockRangeRecordCell' + (update_cells_array[i] - 1) + 'CellOrder').each(function(){
                        //alert('found it');
                        found_it = 1;
                        
                    }).end();

                    if (found_it == 1) {

                    } else {

                        if (new_update_cells_string > '') {
                            new_update_cells_string += ',' + update_cells_array[i];
                        } else {
                            new_update_cells_string = update_cells_array[i];
                        }
                    }

                    found_it = 0;   // reset found_it

                }

                $('#newly_added_cells').val(new_update_cells_string);

                // update for future:
                // rewrite the weight values for table cells when a LI is deleted
                // at the moment it doesn't make a difference because the table cells are not rearrangeable


                // remove LI item
                $(logics_this).closest('li').remove();


/*
                // reorganize cell titles and orders
                var index = 1;
                $('#' + current_record).find('.cell_title_box').each(function() {
                    $(this).html('<label>Cell ' + index + '</label>');
                    index++;
                }).end();

                index = 1;
                $('#' + current_record).find('.cell_order_box > input').each(function() {
                    $(this).val(index);
                    index++;
                }).end();
*/

                // reorganize cell titles and orders
                reorganize_cells(current_record);
                return;
            }

            if ($(logics_this).attr("class") && $('#delete_these_cells').val()) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_cell ', ''));
                $('#delete_these_cells').val($('#delete_these_cells').val() + "," + number_from_class);
            } else if ($(logics_this).attr("class")) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_cell ', ''));
                $('#delete_these_cells').val(number_from_class);
            }

            if ($('#' + $(logics_this).closest('li').attr('id')))
                $('#' + $(logics_this).closest('li').attr('id')).remove();


            // reorganize cell titles and orders
            reorganize_cells(current_record);

        } else {
            return false;
        }
 
    }

    $(".delete_cell").click(function(){
        delete_cell_logic(this);
    });





    /* States */

    $("#table_list_states").dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "bStateSave": true,
        "aoColumns": [
                { "sWidth": "1%" },
                { "sType": "html" },
                { "sClass": "datatables_column_centered" }
                ]
    });


    /* Users */

    $("#table_list_users").dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "bStateSave": true,
        "aoColumns": [
                { "sWidth": "1%" },
                { "sType": "html" },
                null,
                null,
                null,
                null,
                { "sClass": "datatables_column_centered" }
                ]
    });



    /* View Events */

     $("#table_list_view_schedule_events").dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "bStateSave": true,
        "aoColumns": [
                { "sWidth": "1%" },
                { "sType": "html" },
                null,
                null,
                null,
                null,
                null,
                null,
                null
                ]
    });


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
