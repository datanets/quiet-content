$(function() {

    $.url = function(url) {
        return $('base').attr('href')+url.substr(1);
    }

    var options = {minWidth: 120, arrowSrc: '..' + $('base').attr('href') + 'img/arrow_right.gif'};
    $('#admin_nav').menu(options);

    if ($("#right_column").length) {
        $('#right_column').corner('bl');
    }

    $(".entry_body").markItUp(mySettings);
    $(".announcement_body").markItUp(mySettings);
    $(".news_body").markItUp(mySettings);

    // time picker for schedule events
    $('.time-selection').timePicker();

    $('.date-selection').datepicker({ dateFormat: 'yy-mm-dd' });


    var site_base_url = '';
    if ($("#site_base_url").length) {
        site_base_url = $("#site_base_url").val();
    }

    var uploads_base_url = '';
    if ($("#uploads_base_url").length) {
        uploads_base_url = $("#uploads_base_url").val();
    }

    var uploads_base_dir = '';
    if ($("#uploads_base_dir").length) {
        uploads_base_dir = $("#uploads_base_dir").val();
    }


    if ($('#file_manager_box').length) {
        //var current_height = $('#file_manager_box').height();
        //$('#file_manager_box').css('height', current_height * 2);
    }


    $("a[rel^='prettyPhoto']").prettyPhoto({theme:'facebook'});


    $('#sortable_tree_box').height($('#sortable_tree_box').height());
    //$('#sortable_tree_box').height($('#sortable_tree_box').height() + 200);

    function init_sortable_tree() {

        $(".sortable_tree").sortable({
            connectWith: '.connectedSortable',
            placeholder: 'ui-state-highlight',
            helper: 'clone',
            grid: [10, 10],
            delay: 10,
            zIndex: 5,
            //containment: '#sortable_tree_box',
            opacity: 0.5,
            start: function(event, ui) {

                // open all folder_place_holder to drag into
                $('#sortable_tree_box .folder_place_holder').slideToggle(200);

            },
            stop: function(event, ui) {
                placeholder: 'ui-state-highlight'

                // close all opened folder_place_holder
                $('#sortable_tree_box .folder_place_holder').slideToggle(200);

                //alert($(ui.item).attr('id'))


                var new_parent_id = 0;

               /* // if this is a place right after a placeholder...
                if ($('#' + $(ui.item).attr('id')).parent().parent().parent().parent().attr('id') > '') {

                    new_parent_id = $('#' + $(ui.item).attr('id')).parent().parent().parent().parent().attr('id');

                    //alert($('#' + $(ui.item).attr('id')).parent().parent().parent().attr('id'));
                 
                // if this is a child
                } else*/
                if ($('#' + $(ui.item).attr('id')).parent().parent().parent().attr('id') > '') {

                    new_parent_id = $('#' + $(ui.item).attr('id')).parent().parent().parent().attr('id');

                    //alert($('#' + $(ui.item).attr('id')).parent().parent().parent().attr('id'));
                    
                // if this is a child of a child
                } else if ($('#' + $(ui.item).attr('id')).parent().parent().attr('id') > '') {

                    new_parent_id = $('#' + $(ui.item).attr('id')).parent().parent().attr('id');

                    //alert($('#' + $(ui.item).attr('id')).parent().parent().attr('id'));

                }


                if (new_parent_id == 0) {

                    if ($('#' + $(ui.item).attr('id')).parent().parent().parent().parent().attr('id') > '') {
                        new_parent_id = $('#' + $(ui.item).attr('id')).parent().parent().parent().parent().attr('id');
                    }

                }



                var total_li = 0;
                var found_at_index = 0;

                if (new_parent_id > '') {

                    var category_root = $('#category_root').parent().attr('id');


                    if (new_parent_id == category_root) {

                        // this part works for the main directory 
                        $('#' + new_parent_id).children("ul").children("li").each(function(i) {

                            if ($(this).find('p:first').text() > '') {

                                if ($(this).find('p:first').text() == $(ui.item).find('p:first').text()) {
                                    found_at_index = i + 1;
                                }
                                total_li += 1;
                            }
                        });


                    } else {

                        // this part works for any sub directories
                        $('#' + new_parent_id).children("ul").children("li").children("ul").children("li").each(function(i) {

                            if ($(this).find('p:first').text() > '') {

                                if ($(this).find('p:first').text() == $(ui.item).find('p:first').text()) {
                                    found_at_index = i + 1;
                                }
                                total_li += 1;
                            }
                        });

                    }

                }

                var move_up_total = 0;
                if ((total_li - found_at_index) > 0) {
                    move_up_total = total_li - found_at_index;
                }

                // get current (dragged) id
                var id = $(ui.item).attr('id');

                // for debug
                //alert("id: " + id + "\nnew_parent_id: " + new_parent_id + "\ntotal_li: " + total_li + "\nfound_at_index: " + found_at_index + "\nmove up:" + move_up_total);



                $.ajax({
                    type: "GET",
                    url: site_base_url + $('#ajax_action_url').val() + "/update",
                    //url: site_base_url + "entry_categories/update",
                    data: 'id=' + id + '&new_parent_id=' + new_parent_id + '&move_up_total=' + move_up_total + '&total_li=' + total_li,
                    success: function() {
                        $('#sortable_tree_box').load(site_base_url + $('#ajax_action_url').val() + "/get_updated_categories", function() {
                        //$('#sortable_tree_box').load(site_base_url + "entry_categories/get_updated_categories", function() {
                            init_sortable_tree();
                            init_rename_category();
                            init_delete_category();
                        });
                    }

                    //data: $("#sortable_tree_box").sortable("serialize")
                });
            }
        });
        $(".sortable_tree").disableSelection();

    }

    init_sortable_tree();


    if ($("#add_category").length) {
        $('#add_category').bind('click', function() {
            $.ajax({
                type: "GET",
                url: site_base_url + $('#ajax_action_url').val() + "/create",
                //url: site_base_url + "entry_categories/create",
                success: function() {
                    $('#sortable_tree_box').load(site_base_url + $('#ajax_action_url').val() + "/get_updated_categories", function() {
                    //$('#sortable_tree_box').load(site_base_url + "entry_categories/get_updated_categories", function() {
                        init_sortable_tree();
                        init_rename_category();
                        init_delete_category();
                    });
                }

                //data: $("#sortable_tree_box").sortable("serialize")
            });

            return false;
        });
    }


    init_rename_category();


    function init_rename_category() {

        // check if we really want to edit a category
        if ($(".rename_category").length) {
            $('.rename_category').click(function(){

                //alert($(this).parent().parent().find('p:first').html());
                $(this).parent().parent().find('p:first').html('<input type="text" name="category_name" value="' + $(this).parent().parent().find('p:first').text() + '" /><button type="submit" name="save" value="1">Save</button>');

                //alert($(this).parent().parent().parent().find('li:first').attr('id'));


                id = '';
                if ($(this).parent().parent().parent().find('li:first').attr('id') > '') {
                    id = $(this).parent().parent().parent().find('li:first').attr('id');
                }


                // Check if return key pressed
                $(this).parent().parent().find('input:first').bind('keypress', function(e) {
                
                    if (e.keyCode == 13) {
                        new_name = '';
                        if ($(this).parent().parent().find('input:first').val() > '') {
                            new_name = $(this).parent().parent().find('input:first').val();
                        }


                        $.ajax({
                            type: "GET",
                            url: site_base_url + $('#ajax_action_url').val() + "/rename",
                            //url: site_base_url + "entry_categories/rename",
                            data: 'id=' + id + '&new_name=' + new_name,
                            success: function() {
                                $('#sortable_tree_box').load(site_base_url + $('#ajax_action_url').val() + "/get_updated_categories", function() {
                                //$('#sortable_tree_box').load(site_base_url + "entry_categories/get_updated_categories", function() {
                                    init_sortable_tree();
                                    init_rename_category();
                                    init_delete_category();
                                });
                            }

                        });

                        return false;
                    }

                });


                // Check if Save button clicked
                $(this).parent().parent().find('button:first').bind('click', function(e) {

                    new_name = '';
                    if ($(this).parent().parent().find('input:first').val() > '') {
                        new_name = $(this).parent().parent().find('input:first').val();
                    }


                    $.ajax({
                        type: "GET",
                        url: site_base_url + $('#ajax_action_url').val() + "/rename",
                        //url: site_base_url + "entry_categories/rename",
                        data: 'id=' + id + '&new_name=' + new_name,
                        success: function() {
                            $('#sortable_tree_box').load(site_base_url + $('#ajax_action_url').val() + "/get_updated_categories", function() {
                            //$('#sortable_tree_box').load(site_base_url + "entry_categories/get_updated_categories", function() {
                                init_sortable_tree();
                                init_delete_category();
                            });
                        }

                    });

                    return false;

                });


                return false;

            });
        }

    }




    init_delete_category();


    function init_delete_category() {

        // check if we really want to delete a category
        if ($(".delete_category").length) {
            $('.delete_category').click(function(){

                var answer = confirm('Are you sure you want to delete this?');

                if (answer) {
                } else {
                    return false;
                }

            });
        }

    }


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


    if ($("#EntryCategoryCategoryType").length) {

        $('#category_li_' + $('#EntryCategoryCategoryType').val()).show();

        $('#EntryCategoryCategoryType').change(function() {
            $('.big_list_boxes li ').hide();
            $('#category_li_' + $(this).val()).toggle();
        });
    }

    if ($("#add_entry_category_label").length) {
        $('#add_entry_category_label').click(function() {

            // this is for temporarily-assigned ids for added mailing filters (that may or many not be saved in the end)
            var temp_id_count = parseInt($('#add_link_temporary_id_count').val()) + 1;

            $('#add_link_temporary_id_count').val(temp_id_count);


            var do_not_reset_these_values = [ "EntryCategoryMenuItem0Id", "EntryCategoryMenuItem0ItemType", "EntryCategoryMenuItem0Weight" ];

                // get a dummy item
                $('#dummy_item_add_label > li:first').clone().
                removeAttr("id").attr('id','ecl_' + temp_id_count).
                //removeAttr("id").attr('id','ecl_' + $('#entry_category_menu > ul > li').size()).
                find("input,textarea,select").each(function() {

                    for ( var i in do_not_reset_these_values ) {
                        do_not_reset_these_values[i] = do_not_reset_these_values[i].replace(/([^\d]*)\d+([^\d]*)/, "$1" + (temp_id_count) + "$2");
                    }

                    if ($(this).attr('id')) {
                        $(this).attr('id', function() {
                            return this.id.replace(/([^\d]*)\d+([^\d]*)/, "$1" + (temp_id_count) + "$2");
                        });
                    }

                    if ($(this).attr('name')) {
                        $(this).attr('name', function() {
                            return this.name.replace(/([^\d]*)\d+([^\d]*)/, "$1" + (temp_id_count) + "$2");
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
                find('.delete_label').removeClass().attr('class', 'delete_label temporary temporary_' + $('#add_label_temporary_id_count').val()).end().
                find('.delete_label').bind('click', function(){
                    delete_label_logic(this);
                }).end().
                find('.item_id').empty().end().
                find('.weight_box input').val($('#entry_category_menu > ul > li').size()+1).end().
                appendTo('#entry_category_menu > .sortable');

        });
    }

    function delete_label_logic(logics_this)
    {
        var really_delete = confirm("Are you sure you want to delete this?");

        if (really_delete) {

            //alert($(logics_this).attr('class'));
            if ($(logics_this).is('.temporary')) {
                //alert('this is temporary');
                $(logics_this).closest('li').remove();
                return;
            }

            if ($(logics_this).attr("class") && $('#delete_these_labels').val()) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_label ', ''));
                $('#delete_these_labels').val($('#delete_these_labels').val() + "," + number_from_class);
            } else if ($(logics_this).attr("class")) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_label ', ''));
                $('#delete_these_labels').val(number_from_class);
            }

            if ($('#' + $(logics_this).closest('li').attr('id')))
                $('#' + $(logics_this).closest('li').attr('id')).remove();

        } else {
            return false;
        }

    }

 
    $(".delete_label").click(function(){
        delete_label_logic(this);
    });



    function have_another_link_to_use_logic(logics_this)
    {
        if ($(logics_this).parent().parent().find('.category_menu_other_link_box').css('display') == 'none') {
            $(logics_this).parent().parent().find('.category_menu_other_link_box').css('display', 'block');
        } else {
            $(logics_this).parent().parent().find('.category_menu_other_link_box').css('display', 'none');
        }
    }


    if ($(".have_another_link_to_use").length) {
        $(".have_another_link_to_use").click(function(){
            have_another_link_to_use_logic(this);
        });
    }



    if ($("#add_entry_category_link").length) {
        $('#add_entry_category_link').click(function() {

            // this is for temporarily-assigned ids for added mailing filters (that may or many not be saved in the end)
            var temp_id_count = parseInt($('#add_link_temporary_id_count').val()) + 1;

            $('#add_link_temporary_id_count').val(temp_id_count);

            var do_not_reset_these_values = [ "EntryCategoryMenuItem0Id", "EntryCategoryMenuItem0ItemType", "EntryCategoryMenuItem0Weight" ];

                // get a dummy item
                $('#dummy_item_add_link > li:first').clone().
                removeAttr("id").attr('id','ecl_' + temp_id_count).
                //removeAttr("id").attr('id','ecl_' + $('#entry_category_menu > ul > li').size()).
                find("input,textarea,select").each(function() {

                    for ( var i in do_not_reset_these_values ) {
                        do_not_reset_these_values[i] = do_not_reset_these_values[i].replace(/([^\d]*)\d+([^\d]*)/, "$1" + (temp_id_count) + "$2");
                    }

                    if ($(this).attr('id')) {
                        $(this).attr('id', function() {
                            return this.id.replace(/([^\d]*)\d+([^\d]*)/, "$1" + (temp_id_count) + "$2");
                        });
                    }

                    if ($(this).attr('name')) {
                        $(this).attr('name', function() {
                            return this.name.replace(/([^\d]*)\d+([^\d]*)/, "$1" + (temp_id_count) + "$2");
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
                find('.delete_link').removeClass().attr('class', 'delete_link temporary temporary_' + $('#add_link_temporary_id_count').val()).end().
                find('.delete_link').bind('click', function(){
                    delete_link_logic(this);
                }).end().
                find('.have_another_link_to_use').bind('click', function(){
                    have_another_link_to_use_logic(this);
                }).end().
                find('.item_id').empty().end().
                find('.weight_box input').val($('#entry_category_menu > ul > li').size()+1).end().
                appendTo('#entry_category_menu > .sortable');

        });
    }



        function delete_link_logic(logics_this)
        {
            var really_delete = confirm("Are you sure you want to delete this?");

            if (really_delete) {

                //alert($(logics_this).attr('class'));
                if ($(logics_this).is('.temporary')) {
                    //alert('this is temporary');
                    $(logics_this).closest('li').remove();
                    return;
                }

                if ($(logics_this).attr("class") && $('#delete_these_links').val()) {
                    var number_from_class = parseInt($(logics_this).attr("class").replace('delete_link ', ''));
                    $('#delete_these_links').val($('#delete_these_links').val() + "," + number_from_class);
                } else if ($(logics_this).attr("class")) {
                    var number_from_class = parseInt($(logics_this).attr("class").replace('delete_link ', ''));
                    $('#delete_these_links').val(number_from_class);
                }

                if ($('#' + $(logics_this).closest('li').attr('id')))
                    $('#' + $(logics_this).closest('li').attr('id')).remove();

            } else {
                return false;
            }

        }

     
        $(".delete_link").click(function(){
            delete_link_logic(this);
        });







    //$(".record").corner("dog tr");
    $("#dashboard_search_box").corner();
    $("#indoor_search_box").corner();


    $('#page_top_link').scrollTo('#page_top');


    /* Ads */

    if ($("#table_list_ads").length) {
        $("#table_list_ads").dataTable({
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
        }).fnSort( [ [2,'desc'], [3,'desc'] ] );
    }
 

    /* Announcements */

    if ($("#table_list_announcements").length) {
        $("#table_list_announcements").dataTable({
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
        }).fnSort( [ [2,'desc'], [3,'desc'] ] );
    }
    

    /* Entries */

    if ($("#table_list_entries").length) {
        $("#table_list_entries").dataTable({
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
        }).fnSort( [ [2,'desc'], [3,'desc'] ] );
    }


    if ($('.page_type').length) {


        // display entry link information if selected
        if ($('#EntryLink').attr('checked')) {
            $('#link_details').show();
        }


        $('.page_type input:checkbox').click(function() {

            var clicked_id = $(this).attr('id');

            $('.page_type input:checkbox').each(function() {

                if ($(this).attr('id') != clicked_id) {

                    $(this).attr('checked', false);

                } else {

                    if ($(this).attr('id') == 'EntryLink') {

                        $('#link_details').toggle();

                    } else {

                        $('#link_details').hide();

                    }

                }

            }).end();

        });

    }


 
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




    $("a#add_image").click(function(){

        // this is for temporarily-assigned ids for added mailing filters (that may or many not be saved in the end)
        var temp_id_count = parseInt($('#add_image_temporary_id_count').val()) + 1;

        $('#add_image_temporary_id_count').val(temp_id_count);

        var do_not_reset_these_values = [ "EventImage0Id" ];

            // get a dummy item
            $('#dummy_item_add_image > li:first').clone().
            removeAttr("id").attr('id','img_' + $('#details_images > li').size()).
            find("input,textarea,select").each(function() {

                for ( var i in do_not_reset_these_values ) {
                    do_not_reset_these_values[i] = do_not_reset_these_values[i].replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#details_images > li').size()) + "$2");
                }

                if ($(this).attr('id')) {
                    $(this).attr('id', function() {
                        return this.id.replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#details_images > li').size()) + "$2");
                    });
                }

                if ($(this).attr('name')) {
                    $(this).attr('name', function() {
                        return this.name.replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#details_images > li').size()) + "$2");
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
            find('.delete_image').removeClass().attr('class', 'delete_image temporary temporary_' + $('#add_image_temporary_id_count').val()).end().
            find('.delete_image').bind('click', function(){
                delete_image_logic(this);
            }).end().
            find('.item_id').empty().end().
            find('.weight_box input').val($('#details_images > li').size()+1).end().
            appendTo('#details_images');

    });

    function delete_image_logic(logics_this)
    {
        var really_delete = confirm("Are you sure you want to delete this?");

        if (really_delete) {

            //alert($(logics_this).attr('class'));
            if ($(logics_this).is('.temporary')) {
                //alert('this is temporary');
                $(logics_this).closest('li').remove();
                return;
            }

            if ($(logics_this).attr("class") && $('#delete_these_images').val()) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_image ', ''));
                $('#delete_these_images').val($('#delete_these_images').val() + "," + number_from_class);
            } else if ($(logics_this).attr("class")) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_image ', ''));
                $('#delete_these_images').val(number_from_class);
            }

            if ($('#' + $(logics_this).closest('li').attr('id')))
                $('#' + $(logics_this).closest('li').attr('id')).remove();

        } else {
            return false;
        }

    }

 
    $(".delete_image").click(function(){
        delete_image_logic(this);
    });


    $("a#add_attachment").click(function(){

        // this is for temporarily-assigned ids for added mailing filters (that may or many not be saved in the end)
        var temp_id_count = parseInt($('#add_attachment_temporary_id_count').val()) + 1;

        $('#add_attachment_temporary_id_count').val(temp_id_count);

        var do_not_reset_these_values = [ "EventAttachment0Id" ];

            // get a dummy item
            $('#dummy_item_add_attachment > li:first').clone().
            removeAttr("id").attr('id','atm_' + $('#details_attachments > li').size()).
            find("input,textarea,select").each(function() {

                for ( var i in do_not_reset_these_values ) {
                    do_not_reset_these_values[i] = do_not_reset_these_values[i].replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#details_attachments > li').size()) + "$2");
                }

                if ($(this).attr('id')) {
                    $(this).attr('id', function() {
                        return this.id.replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#details_attachments > li').size()) + "$2");
                    });
                }

                if ($(this).attr('name')) {
                    $(this).attr('name', function() {
                        return this.name.replace(/([^\d]*)\d+([^\d]*)/, "$1" + ($('#details_attachments > li').size()) + "$2");
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
            find('.delete_attachment').removeClass().attr('class', 'delete_attachment temporary temporary_' + $('#add_attachment_temporary_id_count').val()).end().
            find('.delete_attachment').bind('click', function(){
                delete_attachment_logic(this);
            }).end().
            find('.item_id').empty().end().
            find('.weight_box input').val($('#details_attachments > li').size()+1).end().
            appendTo('#details_attachments');

    });

    function delete_attachment_logic(logics_this)
    {
        var really_delete = confirm("Are you sure you want to delete this?");

        if (really_delete) {

            //alert($(logics_this).attr('class'));
            if ($(logics_this).is('.temporary')) {
                //alert('this is temporary');
                $(logics_this).closest('li').remove();
                return;
            }

            if ($(logics_this).attr("class") && $('#delete_these_attachments').val()) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_attachment ', ''));
                $('#delete_these_attachments').val($('#delete_these_attachments').val() + "," + number_from_class);
            } else if ($(logics_this).attr("class")) {
                var number_from_class = parseInt($(logics_this).attr("class").replace('delete_attachment ', ''));
                $('#delete_these_attachments').val(number_from_class);
            }

            if ($('#' + $(logics_this).closest('li').attr('id')))
                $('#' + $(logics_this).closest('li').attr('id')).remove();

        } else {
            return false;
        }

    }

 
    $(".delete_attachment").click(function(){
        delete_attachment_logic(this);
    });




    /* File Manager */

    init_directory_click();
    init_directory_open();
    init_file_manager();
    init_file_details();


    //$('#file_manager_box').height($('#file_manager_box').height() * 10);

    function init_directory_click() {

        $(".directory").click(function(){

            var path = $(this).parent().attr('id');

            // while loading show throbber
            $(this).parent().find('div.throbber:first').html("<img src=\"" + site_base_url + "img/ajax-loader.gif\" />");

            $.ajax({
                type: "GET",
                url: site_base_url + "file_managers/get_directory",
                data: 'path=' + path,
                success: function() {
                    $('#' + path).load(site_base_url + "file_managers/get_directory?path=" + path, function() {
                        init_directory_click2(this);
                        init_directory_open();
                        init_file_manager();
                        init_file_details();
                        init_delete_item();
                        init_rename_item();
                    });
                }

            });


            return false;
        });

    }


    function init_directory_click2(logics_this) {

//alert($(logics_this).attr('id'));

var current_id = $(logics_this).attr('id');

        $('#' + current_id + ' .directory').each(function(){
            //alert($(this).parent().attr('id'));
            //alert($(this).text());
            $(this).click(function(){

                /*
                next_folder = $(this).text();
                next_folder = next_folder.replace("\ ", "----");
                path = current_id + '__' + next_folder;
                */

                path = $(this).parent().attr('id');

                // while loading show throbber
                $(this).parent().find('div.throbber:first').html("<img src=\"" + site_base_url + "img/ajax-loader.gif\" />");

    
                $.ajax({
                    type: "GET",
                    url: site_base_url + "file_managers/get_directory",
                    data: 'path=' + path,
                    success: function() {

                        $('#' + path).load(site_base_url + "file_managers/get_directory?path=" + path, function() {
                            init_directory_click2(this);
                            init_directory_open();
                            init_file_manager();
                            init_file_details();
                            init_delete_item();
                            init_rename_item();
                           
                        });
                    }

                });

            return false;

    

            });
        }).end();

/*
        //$(this).parent().find(".directory").click(function(){

            var path = $(this).parent().attr('id');

            // while loading show throbber
            $(this).parent().find('div.throbber:first').html("<img src=\"" + site_base_url + "img/ajax-loader.gif\" />");
alert(this);
                        init_directory_click2();
/*
            $.ajax({
                type: "GET",
                url: site_base_url + "file_managers/get_directory",
                data: 'path=' + path,
                success: function() {
                    $('#' + path).load(site_base_url + "file_managers/get_directory?path=" + path, function() {
                        init_directory_click2();
                        
                        init_directory_open();
                        init_file_manager();
                        init_file_details();
                        init_delete_item();
                        init_rename_item();
                       
                    });
                }

            });

*/
  //      });

    }




    function init_directory_open() {

        if ($(".directory_open").length) {
            $('.directory_open').click(function(){

                $(this).parent().find('ul:first').empty();
                $(this).parent().find('ul:first').html('<li class="folder_place_holder"></li>');
                $(this).removeClass();
                $(this).addClass('directory');

                init_directory_click();
                init_directory_open();
                init_file_manager();
                init_file_details();

                return false;

            });
        }

    }


    function init_file_manager() {

        $(".file_manager").sortable({
            connectWith: '.connectedSortable',
            placeholder: 'ui-state-highlight',
            helper: 'clone',
            grid: [10, 10],
            delay: 10,
            zIndex: 5,
            opacity: 0.5,
            start: function(event, ui) {

                //var current_height = $('#file_manager_box').height();
                //$('#file_manager_box').css('height', current_height * 2);
    //$('#file_manager_box').height($('#file_manager_box').height() * 10);

                // open all folder_place_holder to drag into
                $('#file_manager_box .folder_place_holder').slideToggle(200);

            },
            stop: function(event, ui) {
                placeholder: 'ui-state-highlight'

                // close all opened folder_place_holder
                $('#file_manager_box .folder_place_holder').slideToggle(200);

                //alert($(ui.item).attr('id'));


                // find out what the new parent item is of the container we just dragged item into

                var new_parent_item = '';

                // is this item dragged into an already-opened directory?
                // else this is probably dragged into an unopened directory...
                //if ($(ui.item).parent().parent().parent().closest('li').attr('id')) {
                //    new_parent_item = $(ui.item).parent().parent().parent().closest('li').attr('id');

                //} else if ($(ui.item).parent().closest('li').attr('id')) {
                    //new_parent_item = $(ui.item).parent().closest('li').attr('id');

                //} 

                new_parent_item = $(ui.item).parent().parent().attr('id');


/*
                if (new_parent_item == 'file_manager_box') {

                    // page reload
                    location.reload(true);
                    
                } else {
*/
                    
                    //var source = $(ui.item).attr('id').replace(/\_\_/g, "\/");
                    //var destination = new_parent_item.replace(/\_\_/g, "\/");

                    var source = $(ui.item).attr('id');
                    var destination = new_parent_item;

                    if (new_parent_item == 'file_manager_box') {
                        destination = "_BASEDIR_";
                    }

                    // for debug
                    // alert("source:" + source + "\n" + "destination:" + destination);

                    $.ajax({
                        type: "GET",
                        url: site_base_url + "file_managers/move_item",
                        data: 'source=' + source + '&destination=' + destination,
                        success: function() {
                            //$('#file_manager_box').load(site_base_url + "file_managers/get_directory", function() {
                                init_directory_click2();
                                init_directory_open();
                                init_file_manager();
                                init_file_details();
                                init_delete_item();
                                init_rename_item();
                            //});
                        }

                    });



                    // Then refresh the newly-changed directory

                    if (destination == "_BASEDIR_") {
                        // FIXME: this actually doesn't do anything at the moment...
                        // if we completely refresh the root tree, it will close any opened folders...
                        // which may not be useful for user at the moment
                        destination = '/';
                    }

                    var path = $('#' + destination).attr('id');

                    // while loading show throbber
                    $('#' + destination).find('div.throbber:first').html("<img src=\"" + site_base_url + "img/ajax-loader.gif\" />");

                    $.ajax({
                        type: "GET",
                        url: site_base_url + "file_managers/get_directory",
                        data: 'path=' + path,
                        success: function() {
                            $('#' + path).load(site_base_url + "file_managers/get_directory?path=" + path, function() {
                                init_directory_click2();
                                init_directory_open();
                                init_file_manager();
                                init_file_details();
                                init_delete_item();
                                init_rename_item();
                            });
                        }

                    });


                    // Re-open previously-open folders here?


                //}

            }

        });
        $(".file_manager").disableSelection();

    }

    function init_file_details() {

        if ($(".file_details").length) {
            $('.file_details').click(function() {

                var source = $(this).parent().parent().attr('id');
                source = source.replace(/\_\_/g, "\/");
                source = source.replace(uploads_base_dir, "");

                $('#details_message').html('<label>File Link (copy this)</label><input type="text" value="' + uploads_base_url + source + '" style="width:500px;" /><br /><br /><a href="' + uploads_base_url + source + '" target="_blank"><img src="' + uploads_base_url + source + '" style="width:200px;border:0;" /></a>');

                $('#details_message').dialog({ width:600 });
            });
        }

    }



    init_rename_item();


    function init_rename_item() {

        // check if we really want to edit an item
        if ($(".rename_item").length) {
            $('.rename_item').click(function(){

                var parent_container = $(this).parent().parent().parent().parent().attr('id');
                //var parent_container = $(this).parent().parent().attr('id');

                var source_path = $(this).parent().parent().attr('id');
                source_path_array = source_path.split("__");

                var old_name = source_path_array[source_path_array.length - 1];
                old_name = old_name.replace(/\-\-\-\-/g, " ");
                

                var destination_path = '';
                for (var i = 1; i < source_path_array.length - 1; i++ ) {
                    destination_path = destination_path + '__' + source_path_array[i];
                }


                // escape characters for URI
                source_path = escape(source_path);
                old_name = escape(old_name);
                destination_path = escape(destination_path);


                $('#rename_message').html('<label>Old Name:</label>' + old_name + '<br /><label>New Name:</label><input type="text" id="rename_new_name" value="' + old_name + '" style="width:500px;" />');
                //$('#rename_message').html('<label>Old Name:</label>' + source_path_array[source_path_array.length - 1] + '<br /><label>New Name:</label><input type="text" id="rename_new_name" value="' + source_path_array[source_path_array.length - 1] + '" style="width:500px;" />');



                // Check if return key pressed
                $('#rename_message').find('input:first').bind('keypress', function(e) {
                
                    if (e.keyCode == 13) {

                       $.ajax({
                            type: "GET",
                            url: site_base_url + "file_managers/rename_item",
                            data: 'source_path=' + source_path + '&destination_path=' + destination_path + "__" + $('#rename_new_name').val(),
                            success: function() {

                                if (parent_container == 'file_manager_box') {

                                    // page reload
                                    location.reload(true);
                                    
                                } else {

                                    $('#' + parent_container).load(site_base_url + "file_managers/get_directory?path=" + parent_container, function() {
                                        init_directory_click();
                                        init_directory_open();
                                        init_file_manager();
                                        init_file_details();
                                        init_delete_item();
                                        init_rename_item();
                                    });

                                    $('#rename_message').dialog('close');

                                }
                            }

                        });


                        $(this).dialog('close');



                    }

                });



                $('#rename_message').dialog({   width:600,
                                                buttons: {
                                                    'Save': function()
                                                    {

                                                        /*
                                                        // for debug
                                                        alert($('#rename_new_name').val() + "\n" +
                                                                source_path + "\n" +
                                                                destination_path + "\n" +
                                                                destination_path + "__" + $('#rename_new_name').val());
                                                        */


                                                        $.ajax({
                                                            type: "GET",
                                                            url: site_base_url + "file_managers/rename_item",
                                                            data: 'source_path=' + source_path + '&destination_path=' + destination_path + "__" + $('#rename_new_name').val(),
                                                            success: function() {

                                                                if (parent_container == 'file_manager_box') {

                                                                    // page reload
                                                                    location.reload(true);
                                                                    
                                                                } else {

                                                                    $('#' + parent_container).load(site_base_url + "file_managers/get_directory?path=" + parent_container, function() {

                                                                        init_directory_click();
                                                                        init_directory_open();
                                                                        init_file_manager();
                                                                        init_file_details();
                                                                        init_delete_item();
                                                                        init_rename_item();
                                                                    });

                                                                    $('#rename_message').dialog('close');

                                                                }
                                                            }

                                                        });


                                                        $(this).dialog('close');

                                                    },
                                                    'Cancel': function()
                                                    {
                                                        $(this).dialog('close');
                                                    }
                                                }
                                            });

                $('#rename_new_name').focus();
 
            });

        }

    }



    init_delete_item();


    function init_delete_item() {

        // check if we really want to delete a item
        if ($(".delete_item").length) {
            $('.delete_item').click(function(){

                var answer = confirm('Are you sure you want to delete this?');

                if (answer) {

                    //var path = $('#' + destination).attr('id');

                    var item = $(this).parent().parent().attr('id');
                    var parent_container = $(this).parent().parent().parent().parent().attr('id');
                    item = escape(item);    // clean the filename for URI

                    $.ajax({
                        type: "GET",
                        url: site_base_url + "file_managers/delete_item",
                        data: 'item=' + item,
                        success: function() {

                            if (parent_container == 'file_manager_box') {

                                // page reload
                                location.reload(true);
                                
                            } else {

                                $('#' + parent_container).load(site_base_url + "file_managers/get_directory?path=" + parent_container, function() {
                                    init_directory_click();
                                    init_directory_open();
                                    init_file_manager();
                                    init_file_details();
                                    init_delete_item();
                                    init_rename_item();
                                });

                            }
                        }

                    });

                } else {
                }

                return false;

            });
        }

    }


    init_new_folder();


    function init_new_folder() {

        // check if we really want to edit an item
        if ($("#new_folder").length) {
            $('#new_folder').click(function(){

                var parent_container = 'file_manager_box';

                $.ajax({
                    type: "GET",
                    url: site_base_url + "file_managers/new_folder",
                    data: '',
                    success: function() {

                        if (parent_container == 'file_manager_box') {

                            // page reload
                            location.reload(true);
                            
                        } else {

                            $('#' + parent_container).load(site_base_url + "file_managers/get_directory?path=" + parent_container, function() {
                                init_directory_click();
                                init_directory_open();
                                init_file_manager();
                                init_file_details();
                                init_delete_item();
                                init_rename_item();
                            });

                        }
                    }

                });

            });

        }

    }

    init_upload_file();


    function init_upload_file() {

        // check if we really want to edit an item
        if ($("#upload_file").length) {
            $('#upload_file').click(function(){

                $('#upload_file_message').dialog({  width:600,
                                            buttons: {
                                                    'Upload': function()
                                                    {

                                                        // while uploading, show throbber
                                                        $('#upload_file_throbber').html("<img src=\"" + site_base_url + "img/ajax-loader.gif\" /> Uploading File (this might take a little while...)");
                                                        $('#FileUploadForm').delay(800).submit();

                                                        //$(this).dialog('close');
                                                    },
                                                    'Cancel': function()
                                                    {
                                                        $(this).dialog('close');
                                                    }
                                                    }
                                            });
 

            });

        }

    }




    /* News */

    if ($("#table_list_news").length) {
        $("#table_list_news").dataTable({
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
        }).fnSort( [ [2,'desc'], [3,'desc'] ] );
    }


    /* Emergency Alerts */

    if ($("#table_list_emergency_alerts").length) {
        $("#table_list_emergency_alerts").dataTable({
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
        }).fnSort( [ [2,'desc'], [3,'desc'] ] );
    }


    /* Mini Menus */

    if ($("#table_list_mini_menus").length) {
        $("#table_list_mini_menus").dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bStateSave": true,
            "aoColumns": [
                    { "sWidth": "1%" },
                    { "sType": "html" },
                    null,
                    { "sClass": "datatables_column_centered" }
                    ]
        }).fnSort( [ [2,'desc'] ] );
    }




    /* Users */

    if ($("#table_list_users").length) {
        $("#table_list_users").dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bStateSave": true,
            "aoColumns": [
                    { "sWidth": "1%" },
                    { "sType": "html" },
                    null,
                    { "sClass": "datatables_column_centered" }
                    ]
        }).fnSort( [ [1,'asc'] ] );
    }

});

