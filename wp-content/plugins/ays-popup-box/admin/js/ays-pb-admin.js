(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
    $(document).ready(function (){
        $('.apm-pro-feature-link').on('click', goToPro);
        $(document).find('.nav-tab-wrapper a.nav-tab').on('click', function(e){            
            let elemenetID = $(this).attr('href');
            let active_tab = $(this).attr('data-tab');
            $(document).find('.nav-tab-wrapper a.nav-tab').each(function(){
            if( $(this).hasClass('nav-tab-active') ){
                $(this).removeClass('nav-tab-active');
            }
            });
            $(this).addClass('nav-tab-active');
                $(document).find('.ays-pb-tab-content').each(function(){
                if( $(this).hasClass('ays-pb-tab-content-active') )
                    $(this).removeClass('ays-pb-tab-content-active');
            });
            $(document).find("[name='ays_pb_tab']").val(active_tab);
            $('.ays-pb-tab-content' + elemenetID).addClass('ays-pb-tab-content-active');
            e.preventDefault();
        });
         
        $(document).find('.ays_pb_color_input').wpColorPicker();
         
        $(document).find('.ays-pb-tab-content select').select2();
        var ays_pb_view_place = $(document).find('#ays-pb-ays_pb_view_place').select2({
            placeholder: 'Select page',
            multiple: true,
            matcher: searchForPage
        });
         
        $(document).find('.ays_view_place_clear').on('click', function(){
            ays_pb_view_place.val(null).trigger('change');
        });

        
        $(document).on('click', '.cat-filter-apply', function(e){
            e.preventDefault();
            let catFilter = $(document).find('select[name="filterby"]').val();
            let link = location.href;
            let linkFisrtPart = link.split('?')[0];
            let linkModified = link.split('?')[1].split('&');
            for(let i = 0; i < linkModified.length; i++){
                if(linkModified[i].split("=")[0] == "filterby"){
                    linkModified.splice(i, 1);
                }
            }
            link = linkFisrtPart + "?" + linkModified.join('&');
            if( catFilter != '' ){
                catFilter = "&filterby="+catFilter;
                document.location.href = link+catFilter;
            }else{
                document.location.href = link;
            }
        });
        
        $(document).on('click', '.ays-remove-bg-img', function () {
            $('img#ays-pb-bg-img').attr('src', '');
            $('input#ays-pb-bg-image').val('');
            $('.ays-pb-bg-image-container').parent().fadeOut();
            $('a.ays-pb-add-bg-image').text('Add Image');
            $('.box-apm').css('background-image', 'unset');
            $('.ays_bg_image_box').css('background-image', 'unset');
            $('.ays_lil_window').css('background-image', 'unset');
            if ($(document).find('#ays-enable-background-gradient').prop('checked')) {
                toggleBackgrounGradient();
            }
            if ($(document).find(".ays_template_window").is(":visible")) {
                var bg_img_default="https://quiz-plugin.com/wp-content/uploads/2020/02/girl-scaled.jpg";
                $(document).find('.ays_bg_image_box').css({
                    'background-image' : 'url(' + bg_img_default + ')',
                    'background-repeat' : 'no-repeat',
                    'background-size' : 'cover',
                    'background-position' : 'center center'
                });
            }
            if ($(document).find(".ays_image_window").is(":visible")) {
                var bg_img_default="https://quiz-plugin.com/wp-content/uploads/2020/02/elefante.jpg";
                $(document).find('.ays_bg_image_box').css({
                    'background-image' : 'url(' + bg_img_default + ')',
                    'background-repeat' : 'no-repeat',
                    'background-size' : 'cover',
                    'background-position' : 'center center'
                });
            }
        });
        $(document).on('click', '.ays_remove_bg_img', function () {
            $('img#ays_close_btn_bg_img').attr('src', '');
            $('input#close_btn_bg_img').val('');
            $('.ays_pb_close_btn_bg_img').parent().fadeOut();
            $('a.ays_pb_add_close_btn_bg_image').text('Add Image');

            $(document).find('img.close_btn_img').css('display','none');
            $(document).find('label.close_btn_label > .close_btn_text').css('display','block');

        });

        let heart_interval = setInterval(function () {
            $(document).find('.ays_heart_beat i.ays_fa').toggleClass('ays_pulse');
        }, 1000);

        var ays_pb_overlay_color = $(document).find('#ays-pb-overlay_color').val();
        $(document).find('.ays-pb-modals').css("background-color", ays_pb_overlay_color);

        let ays_pb_box_gradient_color1_picker = {
            change: function (e) {
                setTimeout(function () {
                    toggleBackgrounGradient();
                }, 1);
            }
        };
        let ays_pb_box_gradient_color2_picker = {
            change: function (e) {
                setTimeout(function () {
                    toggleBackgrounGradient();
                }, 1);
            }
        };
        $(document).find('#ays_pb_gradient_direction').on('change', function () {
            toggleBackgrounGradient();
        });

        $(document).find('#ays-background-gradient-color-1').wpColorPicker(ays_pb_box_gradient_color1_picker);
        $(document).find('#ays-background-gradient-color-2').wpColorPicker(ays_pb_box_gradient_color2_picker);

        $(document).find('input#ays-enable-background-gradient').on('change', function () {
            toggleBackgrounGradient()
        });
        toggleBackgrounGradient();
        function toggleBackgrounGradient() {
                let pb_gradient_direction = $(document).find('#ays_pb_gradient_direction').val();
                var checked = $(document).find('input#ays-enable-background-gradient').prop('checked');
                switch(pb_gradient_direction) {
                    case "horizontal":
                        pb_gradient_direction = "to right";
                        break;
                    case "diagonal_left_to_right":
                        pb_gradient_direction = "to bottom right";
                        break;
                    case "diagonal_right_to_left":
                        pb_gradient_direction = "to bottom left";
                        break;
                    default:
                        pb_gradient_direction = "to bottom";
                }
            if($(document).find('input#ays-pb-bg-image').val() == '') {
                if(checked){
                    $(document).find('.ays-pb-live-container').css({'background-image': "linear-gradient(" + pb_gradient_direction + ", " + $(document).find('input#ays-background-gradient-color-1').val() + ", " + $(document).find('input#ays-background-gradient-color-2').val()+")"});
                     $(document).find('#ays-image-window').css({'background-image': 'url("https://quiz-plugin.com/wp-content/uploads/2020/02/elefante.jpg','background-size': 'cover','background-repeat': 'no-repeat','background-position': 'center'});
                }else{
                        $(document).find('.ays-pb-live-container').css({'background-image': "none"});
                        $(document).find('#ays-image-window').css({'background-image': 'url("https://quiz-plugin.com/wp-content/uploads/2020/02/elefante.jpg','background-size': 'cover','background-repeat': 'no-repeat','background-position': 'center'});
                }
            }
            // else if ($(document).find(".ays_template_window").hasClass("ays_active") 
            //     && $(document).find('input#ays-enable-background-gradient').attr('checked') == 'checked' 
            //     && $(document).find('input#ays-pb-bg-image').val() != '') {
            //      $(document).find('.ays-pb-live-container').css({'background-image': "linear-gradient(" + pb_gradient_direction + ", " + $(document).find('input#ays-background-gradient-color-1').val() + ", " + $(document).find('input#ays-background-gradient-color-2').val()+")"});
     
            // }
        }


         
        $(document).on('change', '.ays_toggle', function (e) {
            let state = $(this).prop('checked');
            if($(this).hasClass('ays_toggle_slide')){
                switch (state) {
                    case true:
                        $(this).parent().find('.ays_toggle_target').slideDown(250);
                        break;
                    case false:
                        $(this).parent().find('.ays_toggle_target').slideUp(250);
                        break;
                }
            }else{
                switch (state) {
                    case true:
                        $(this).parent().find('.ays_toggle_target').show(250);
                        break;
                    case false:
                        $(this).parent().find('.ays_toggle_target').hide(250);
                        break;
                }
            }
        });

        $(document).on('change', '.ays_toggle_checkbox', function (e) {
            let state = $(this).prop('checked');
            let parent = $(this).parents('.ays_toggle_parent');
            if($(this).hasClass('ays_toggle_slide')){
                switch (state) {
                    case true:
                        parent.find('.ays_toggle_target').slideDown(250);
                        break;
                    case false:
                        parent.find('.ays_toggle_target').slideUp(250);
                        break;
                }
            }else{
                switch (state) {
                    case true:
                        parent.find('.ays_toggle_target').show(250);
                        break;
                    case false:
                        parent.find('.ays_toggle_target').hide(250);
                        break;
                }
            }
        });

        $(document).find('#ays-pb-popup_title').on('input', function(e){
            var pbTitleVal = $(this).val();
            var pbTitle = aysPopupstripHTML( pbTitleVal );
            $(document).find('.ays_pb_title_in_top').html( pbTitle );
        });


        function aysPopupstripHTML( dirtyString ) {
        var container = document.createElement('div');
        var text = document.createTextNode(dirtyString);
        container.appendChild(text);

        return container.innerHTML; // innerHTML will be a xss safe string
        }

        $(document).find('#ays_pb_form').on('submit', function(e){
            
            if($(document).find('#ays-pb-popup_title').val() == ''){
                $(document).find('#ays-pb-popup_title').val('Demo Title').trigger('input');
            }

            var $this = $(this)[0];
            if($(document).find('#ays-pb-popup_title').val() != ""){
                $this.submit();
            }else{
                e.preventDefault();
                $this.submit();
            }
        });

        $(document).find('#ays_pb_posts').select2({
            placeholder: 'Select page',
            multiple: true,
            matcher: searchForPage
        });
        var ays_pb_post_types = $(document).find('#ays_pb_post_types').select2({
            placeholder: 'Select page',
            multiple: true,
            matcher: searchForPage
        });

        $(document).on('change', '#ays_pb_post_types', function () {

            var selected = $('.select2-selection__choice');
            var arr = pb.post_types;
            
            var types_arr = [];
            for (var i = 0; i < selected.length; i++) {
                var name = selected[i].innerText;
                name = name.substring(1, name.length);
                for (var j = 0; j < arr.length; j++) {
                    if (name == arr[j][1]) {
                        types_arr.push(arr[j][0])
                    }
                }
            }
            var get_hidden_val = $('#ays_pb_except_posts_id');
            var posts = $(document).find('#ays_pb_posts option:selected');
            var posts_ids = [];
            posts.each(function(){
                posts_ids.push($(this).attr('value'));
            });
            posts_ids = posts_ids.join(',');
            get_hidden_val.val(posts_ids);
            $.ajax({
                url: pb.ajax,
                method: 'post',
                dataType: 'text',
                data: {
                    action: 'get_selected_options_pb',
                    data: types_arr,
                },
                success: function (resp) {
                    var inp = $('#ays_pb_posts');
                    var data = JSON.parse(resp);
                    inp.html('');
                    inp.val(null).trigger('change');

                    var new_hidden_val = get_hidden_val.val();
                    var get_hidden_val_arr = new_hidden_val.split(',');

                    for (var i = 0; i < data.length; i++) {
                        inp.append("<option value='" + data[i][0] + "'>" + data[i][1] + "</option>");
                    }
                   
                    for(var k = 0; k < get_hidden_val_arr.length; k++){
                        inp.select2( "val", get_hidden_val_arr );
                    }
                },
            });

        });

        $(document).find('.ays_pb_act_dect').datetimepicker({
            controlType: 'select',
            oneLine: true,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss"
        });

        $(document).on('click', 'a.add-pb-bg-music', function (e) {
            openMusicMediaUploader(e, $(this));
        });     

        function openMusicMediaUploader(e, element) {
            e.preventDefault();
            let aysUploader = wp.media({
                title: 'Upload music',
                button: {
                    text: 'Upload'
                },
                library: {
                    type: 'audio'
                },
                multiple: false
            }).on('select', function () {
                let attachment = aysUploader.state().get('selection').first().toJSON();
                element.next().attr('src', attachment.url);
                element.parent().find('input.ays_pb_bg_music').val(attachment.url);
                element.parent().find('.ays_pb_sound_close_btn').show();
            }).open();
            return false;
        }  

        $(document).find('.ays_pb_sound_opening_btn').on('click', function(){
            var pb_opening_audio = $('.ays-bg-opening-music-audio');
            var pb_opening_audio_src = pb_opening_audio.prop('src','');
            $('input.ays_pb_bg_music_opening_input').val('');
            $('.ays_pb_sound_opening_btn').hide();          
            
        }); 
        $(document).find('.ays_pb_sound_closing_btn').on('click', function(){
            var pb_opening_audio = $('.ays-bg-closing-music-audio');
            var pb_opening_audio_src = pb_opening_audio.prop('src',''); 
            $('input.ays_pb_bg_music_closing_input').val('');
            $('.ays_pb_sound_closing_btn').hide();               
        }); 

        $(document).find('#ays_popup_width_by_percentage_px').select2({
            minimumResultsForSearch: -1
        }) 

        $(document).find('#open_pb_fullscreen').on('click',function(){
            var inpFullScreenChecked = $(document).find('#open_pb_fullscreen').prop('checked');
            if(inpFullScreenChecked){
                $(document).find('.ays_pb_width').prop( "readonly", true );
                $(document).find('.ays_pb_height').prop( "readonly", true );
            }else{
                $(document).find('.ays_pb_width').prop( "readonly", false );
                $(document).find('.ays_pb_height').prop( "readonly", false );
            }
        })

        $(document).find('.ays_pb_hide_timer').on('click',function(){
            var inpHideTimer = $(document).find('.ays_pb_hide_timer').prop('checked');
            if(inpHideTimer){
                $(document).find('.ays_pb_timer').css( {"visibility":"hidden" });
            }else{
                $(document).find('.ays_pb_timer').css( {"visibility":"visible" });
            }
        })

        $(document).find('#ays-pb-close-button').on('change',function(){
            var inpHideCloseBtn = $(document).find('#ays-pb-close-button').prop('checked');
            if(inpHideCloseBtn){
                $(document).find('.close_btn_label').css( {"display":"none" });
            }else{
                $(document).find('.close_btn_label').css( {"display":"block" });
            }
        })


        $(document).find('.ays_pb_layer_button').on('click',function(){
            $('.ays_pb_layer_container').css({'position':'unset' , 'display':'none'});

            var checkedInp = $('.ays_pb_layer_box input:checked').val();

            switch ( checkedInp ) {
                    case 'shortcode':
                        $('#ays_custom_html').hide();
                        $('#ays_shortcode').show();
                        $('#ays_shortcode').before('<hr>');
                        break;
                    case 'custom_html':
                        $('#ays_custom_html').show();
                        $('#ays_shortcode').hide();
                        $('#ays_shortcode').before('<hr>');
                        break;
                    default: 
                        $('#ays_custom_html').show();
                        $('#ays_shortcode').hide();
                        $('#ays_custom_html').before('<hr>');
            } 
        })

        // Code Mirror
             
      setTimeout(function(){
        if($(document).find('#ays-pb-custom-css').length > 0){
            let CodeEditor = null;
            if(wp.codeEditor){
                CodeEditor = wp.codeEditor.initialize($(document).find('#ays-pb-custom-css'), cm_settings);
            }
            if(CodeEditor !== null){
                CodeEditor.codemirror.on('change', function(e, ev){
                    $(CodeEditor.codemirror.display.input.div).find('.CodeMirror-linenumber').remove();
                    $(document).find('#ays-pb-custom-css').val(CodeEditor.codemirror.display.input.div.innerText);
                        
                });
            }
        

        }
        }, 500);
       
        $(document).find('a[href="#tab3"]').on('click', function (e) {        
            setTimeout(function(){
                if($(document).find('#ays-pb-custom-css').length > 0){
                    var ays_pb_custom_css = $(document).find('#ays-pb-custom-css').html();
                    if(wp.codeEditor){
                        $(document).find('#ays-pb-custom-css').next('.CodeMirror').remove();
                        var CodeEditor = wp.codeEditor.initialize($(document).find('#ays-pb-custom-css'), cm_settings);

                        CodeEditor.codemirror.on('change', function(e, ev){
                            $(CodeEditor.codemirror.display.input.div).find('.CodeMirror-linenumber').remove();
                            $(document).find('#ays-pb-custom-css').val(CodeEditor.codemirror.display.input.div.innerText);
                        });
                        ays_pb_custom_css = CodeEditor.codemirror.getValue();
                        $(document).find('#ays-pb-custom-css').html(ays_pb_custom_css);
                    }
                }
            }, 500);
           
        });



        $(document).find('.ays_pb_title').on('change',function(){
            var inpHideTitle = $(document).find('.ays_pb_title').prop('checked');
            if(inpHideTitle){
                $(document).find('.ays_title').css( {"display":"block" });
                $(document).find('.ays_template_head').css( {"height":"15%","display":"flex", "justify-content":"center","align-items":"center"});
                $(document).find('.ays_template_footer').css( {"height":"100%" });
                $(document).find('.title_hr').css( {"display":"block" });
            }else{
                $(document).find('.ays_title').css( {"display":"none" });
                $(document).find('.ays_template_head').css( {"height":"0"});
                $(document).find('.ays_template_footer').css( {"height":"85%" });
                $(document).find('.title_hr').css( {"display":"none" });
            }
        })
        
        $(document).find('.ays_pb_desc').on('change',function(){
            var inpHideDesc = $(document).find('.ays_pb_desc').prop('checked');
            if(inpHideDesc){
                $(document).find('.desc').css( {"display":"block" });
            }else{
                $(document).find('.desc').css( {"display":"none" });
            }
        })

        $(document).find('#ays_pb_border_style').on('change',function(){
            var borderStyle = $(document).find('#ays_pb_border_style').val();
            $(document).find('.ays-pb-live-container').css('border-style',borderStyle);
        })

        // $(document).find('input#ays-enable-background-gradient').on('change',function(){
        //     var backgroundGradient = $(document).find('input#ays-enable-background-gradient').prop('checked');
        //     if(backgroundGradient){
        //         var pb_gradient_direction = $(document).find('#select2-ays_pb_gradient_direction-container').val();
        //         $(document).find('.ays-pb-live-container').css({'background-image': "linear-gradient(" + pb_gradient_direction + ", " + $(document).find('input#ays-background-gradient-color-1').val() + ", " + $(document).find('input#ays-background-gradient-color-2').val()+")"});
        //     }else{
        //         var bgColor = $(document).find('.ays_pb_background_color').val();
        //         $(document).find('.ays-pb-live-container').css('background', bgColor);
        //         $(document).find('#ays-image-window').css({'background-image': 'url("https://quiz-plugin.com/wp-content/uploads/2020/02/elefante.jpg','background-size': 'cover','background-repeat': 'no-repeat','background-position': 'center'});
        //     }
        // })


          let toggle_ddmenu = $(document).find('.toggle_ddmenu');
        toggle_ddmenu.on('click', function () {
            let ddmenu = $(this).next();
            let state = ddmenu.attr('data-expanded');
            switch (state) {
                case 'true':
                    $(this).find('.ays_fa').css({
                        transform: 'rotate(0deg)'
                    });
                    ddmenu.attr('data-expanded', 'false');
                    break;
                case 'false':
                    $(this).find('.ays_fa').css({
                        transform: 'rotate(90deg)'
                    });
                    ddmenu.attr('data-expanded', 'true');
                    break;
            }
        });


        $(document).find('table#ays-pb-position-table tr td').on('click', function(e){
            var val = $(this).data('value');
            $(document).find('.pb_position_block #ays-pb-position-val').val(val);
            aysCheckPopupPosition();
        });

        aysCheckPopupPosition();
        function aysCheckPopupPosition(){
            var hiddenVal = $(document).find('.pb_position_block #ays-pb-position-val').val();
           
            if (hiddenVal == "") {
                var $this = $(document).find('table#ays-pb-position-table tr td[data-value="center-center"');
            }else{
                var $this = $(document).find('table#ays-pb-position-table tr td[data-value='+ hiddenVal +']');
            }

            if (hiddenVal == 'center-center' || hiddenVal == ''){
                $(document).find("#popupMargin").hide(500);
                $(document).find(".ays_pb_hr_hide").hide(500);
            }
            else{
                $(document).find("#popupMargin").show(500);
                $(document).find(".ays_pb_hr_hide").show(500);
            }

            $(document).find('table#ays-pb-position-table td').removeAttr('style');
            $this.css('background-color','#a2d6e7');
        }

        $(document).find('.ays_pb_layer_box_blocks label.ays-pb-dblclick-layer').on('dblclick',function(){
            $(this).parents('.ays_pb_layer_container').find('.ays_pb_select_button_layer input.ays_pb_layer_button').trigger('click');
        });
        $(document).find('.ays-pb-content-type').on('change',function(){
            $(this).parents('.ays_pb_layer_container').find('.ays_pb_select_button_layer input.ays_pb_layer_button').prop('disabled',false);
        });
    });
    $(document).on('click', 'a.ays-pb-add-bg-image', function (e) {
        openMediaUploaderBg(e, $(this));
    });
    $(document).on('click', 'a.ays_pb_add_close_btn_bg_image', function (e) {
        openMediaUploaderCloseBtn(e, $(this));
    });

    $(document).on('change', '.ays_toggle_checkbox', function (e) {
        let state = $(this).prop('checked');
        let parent = $(this).parents('.ays_toggle_parent');

        if($(this).hasClass('ays_toggle_slide')){
            switch (state) {
                case true:
                    parent.find('.ays_toggle_target').slideDown(250);
                    break;
                case false:
                    parent.find('.ays_toggle_target').slideUp(250);
                    break;
            }
        }else{
            switch (state) {
                case true:
                    parent.find('.ays_toggle_target').show(250);
                    break;
                case false:
                    parent.find('.ays_toggle_target').hide(250);
                    break;
            }
        }
    });

    $(document).keydown(function(event) {
        var editButton = $(document).find("input#ays-button-top-apply , input#ays-cat-button-apply , input#ays-button-apply, input#ays_submit_settings");
        if (!(event.which == 83 && event.ctrlKey) && !(event.which == 19)){
            return true;  
        }
        editButton.trigger("click");
        event.preventDefault();
        return false;
    });

    

    function openMediaUploaderBg(e, element) {
        e.preventDefault();
        let aysUploader = wp.media({
            title: 'Upload',
            button: {
                text: 'Upload'
            },
            library: {
                type: 'image'
            },
            multiple: false
        }).on('select', function () {
            let attachment = aysUploader.state().get('selection').first().toJSON();
            element.text('Edit Image');
            $('.ays-pb-bg-image-container').parent().fadeIn();
            $('img#ays-pb-bg-img').attr('src', attachment.url);
            $('input#ays-pb-bg-image').val(attachment.url);
            $('.box-apm').css('background-image', `url('${attachment.url}')`);
            $('.ays_bg_image_box').css({
                'background-image' : `url('${attachment.url} ')`,
                'background-repeat' : 'no-repeat',
                'background-size' : 'cover',
                'background-position' : 'center center'
            });
            ////
        }).open();
        return false;
    }
    function openMediaUploaderCloseBtn(e, element) {
        e.preventDefault();
        let aysUploader = wp.media({
            title: 'Upload',
            button: {
                text: 'Upload'
            },
            library: {
                type: 'image'
            },
            multiple: false
        }).on('select', function () {
            let attachment = aysUploader.state().get('selection').first().toJSON();
            
            element.text('Edit Image');
            
            $('.ays_pb_close_btn_bg_img').parent().fadeIn();
            $('img#ays_close_btn_bg_img').attr('src', attachment.url);
            $('input#close_btn_bg_img').val(attachment.url);
            
            $('img.close_btn_img').attr('src', attachment.url);
            $(document).find('img.close_btn_img').css('display','block');

            $(document).find('label.close_btn_label > .close_btn_text').css('display','none');

            ////
        }).open();
        return false;
    }

    function goToPro() {
        window.open(
            'https://ays-pro.com/wordpress/popup-box',
            '_blank'
        );
        return false;
    }

    function searchForPage(params, data) {
        // If there are no search terms, return all of the data
        if ($.trim(params.term) === '') {
          return data;
        }

        // Do not display the item if there is no 'text' property
        if (typeof data.text === 'undefined') {
          return null;
        }
        var searchText = data.text.toLowerCase();
        // `params.term` should be the term that is used for searching
        // `data.text` is the text that is displayed for the data object
        if (searchText.indexOf(params.term) > -1) {
          var modifiedData = $.extend({}, data, true);
          modifiedData.text += ' (matched)';

          // You can return modified objects from here
          // This includes matching the `children` how you want in nested data sets
          return modifiedData;
        }

        // Return `null` if the term should not be displayed
        return null;
    }

    // Delete confirmation
    $(document).on('click', '.ays_pb_confirm_del', function(e){            
        e.preventDefault();
        var message = $(this).data('message');
        var confirm = window.confirm('Are you sure you want to delete '+message+'?');
        if(confirm === true){
            window.location.replace($(this).attr('href'));
        }
    });

           // Submit buttons disableing with loader
    var subButtons = '.button#ays-button-top,.button#ays-button-top-apply,.button#ays-button,.button#ays-button-apply,.button#ays_submit_settings';
    $(document).on('click', subButtons ,function () {     
        var $this = $(this);
        submitOnce($this);
    });
    $(document).on("click" ,".button#ays-cat-button-apply", function(){
        var catTitle = $(document).find("#ays-title").val();
        if(catTitle != ''){
            var $this = $(this);
            subButtons += ',.button#ays-cat-button-apply';
            submitOnce($this);
        }
    });
    function submitOnce(subButton){
        var subLoader = subButton.siblings(".display_none");
        subLoader.removeClass("display_none");
        subLoader.css("padding-left" , "8px");
        subLoader.css("display" , "inline-flex");
        setTimeout(function() {
            $(subButtons).attr('disabled', true);
        }, 50);
        setTimeout(function() {
            $(subButtons).attr('disabled', false);
            subLoader.addClass("display_none");
        }, 5000);
    }

})( jQuery );
