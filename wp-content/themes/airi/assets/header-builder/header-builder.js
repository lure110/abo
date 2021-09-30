(function ($) {
    "use strict";

    // Initialize global variable
    var LaStudio = {
        component 	: {}
    };

    window.LaStudio = LaStudio;

    var $document = $(document),
        $window = $(window),
        $body = $('body');

    // Initialize global variable

    function clone_widget() {
        var $header_builder = $('#lastudio-header-builder');
        var $element_placeholders = $('.lahb-element--placeholder', $header_builder);
        var $element2_placeholders = $('.lahb-element--placeholder2', $header_builder);


        //Move Header Vertical element keep stylesheet;
        if($('.lahb-vcom', $header_builder).length){
            $('<div/>', {
                "class": 'lahb-screen-view lahb-desktop-view lahb-varea'
            }).appendTo($header_builder);
            $('.lahb-vcom', $header_builder).appendTo($('.lahb-varea'));
        }
        $('.lahb-varea .lahb-vertical .lahb-content-wrap').append('<div class="lahb-voverlay"></div>');

        $element_placeholders.each(function () {
            var _elmID = $(this).data('element-id');
            var $target_elm = $('.lahb-element[data-element-id="'+_elmID+'"]:not(.lahb-element--placeholder)', $header_builder).first();
            var $elm_clone = $target_elm.clone();
            $elm_clone.removeAttr('itemscope').removeAttr('itemtype');
            $elm_clone.find('.la-ajax-searchform').removeClass('has-init');
            $elm_clone.find('.lahb-element--dontcopy').remove();

            //do not copy primary menu on mobile panel
            if($(this).closest('.lahb-mobiles-view').length && $elm_clone.hasClass('lahb-nav-wrap') && $('.lahb-element.lahb-element--placeholder2[data-element2-id="'+_elmID+'"]', $header_builder).length){
                $(this).remove();
            }
            else{
                $(this).replaceWith($elm_clone);
            }
        });

        // Copy icon of primary for mobile panel
        $element2_placeholders.each(function () {
            var _elmID = $(this).data('element2-id');
            var $target_elm = $('.lahb-element[data-element2-id="'+_elmID+'"]:not(.lahb-element--placeholder2)', $header_builder).first();
            var $elm_clone = $target_elm.clone();
            $(this).replaceWith($elm_clone);
        });
        // Remove the target when the copy is complete
        //$('.lahb-desktop-view .lahb-element[data-element2-id]', $header_builder).remove();
    }

    $document.on('LaStudio:Document:BeforeRunScript', function (e) {
        clone_widget();
    });

    var HeaderBuilder = {

        init: function(){

            var $header_builder = $('#lastudio-header-builder');

            // Navigation Current Menu
            $('.menu li.current-menu-item, .menu li.current_page_item, #side-nav li.current_page_item, .menu li.current-menu-ancestor, .menu li ul li ul li.current-menu-item , .hamburger-nav li.current-menu-item, .hamburger-nav li.current_page_item, .hamburger-nav li.current-menu-ancestor, .hamburger-nav li ul li ul li.current-menu-item, .full-menu li.current-menu-item, .full-menu li.current_page_item, .full-menu li.current-menu-ancestor, .full-menu li ul li ul li.current-menu-item ').addClass('current');
            $('.menu li ul li:has(ul)').addClass('submenu');


            // Social modal
            var header_social = $('.header-social-modal-wrap').html();
            $('.header-social-modal-wrap').remove();
            $('.main-slide-toggle').append(header_social);

            // Search modal Type 2
            var header_search_type2 = $('.header-search-modal-wrap').html();
            $('.header-search-modal-wrap').remove();
            $('.main-slide-toggle').append(header_search_type2);

            // Search Full
            var $header_search_typefull = $('.header-search-full-wrap').first();

            if($header_search_typefull.length){
                $('.searchform-fly > p').replaceWith($header_search_typefull.find('.searchform-fly-text'));
                $('.searchform-fly > .search-form').replaceWith($header_search_typefull.find('.search-form'));
                $('.header-search-full-wrap').remove();
                $('.searchform-fly-overlay').removeClass('has-init');
            }

            // Moving Hamburger
            $('.la-hamburger-wrap').each(function () {
                $(this).appendTo($body);
            });

            // Social dropdown
            $document.on('click', '.lahb-social .js-social_trigger_dropdown', function (e) {
                e.preventDefault();
                $(this).siblings('.header-social-dropdown-wrap').fadeToggle('fast');
            });
            $document.on('click', '.header-social-dropdown-wrap a', function (e) {
                $('.header-social-dropdown-wrap').css({
                    display: 'none'
                });
            });

            // Social Toggles
            $document.on('click', '.lahb-social .js-social_trigger_slide', function (e) {
                e.preventDefault();
                if( $header_builder.find('.la-header-social').hasClass('opened') ) {
                    $header_builder.find('.main-slide-toggle').slideUp('opened');
                    $header_builder.find('.la-header-social').removeClass('opened');
                }
                else{
                    $header_builder.find('.main-slide-toggle').slideDown(240);
                    $header_builder.find('#header-search-modal').slideUp(240);
                    $header_builder.find('#header-social-modal').slideDown(240);
                    $header_builder.find('.la-header-social').addClass('opened');
                    $header_builder.find('.la-header-search').removeClass('opened');
                }
            });

            $document.on('click', function (e) {
                if( $(e.target).hasClass('js-social_trigger_slide')){
                    return;
                }
                if ($header_builder.find('.la-header-social').hasClass('opened')) {
                    $header_builder.find('.main-slide-toggle').slideUp('opened');
                    $header_builder.find('.la-header-social').removeClass('opened');
                }
            });

            // Search full

            $document.on('click', '.lahb-cart > a', function (e) {
                if(!$(this).closest('.lahb-cart').hasClass('force-display-on-mobile')){
                    if($window.width() > 767){
                        e.preventDefault();
                        $body.toggleClass('open-cart-aside');
                    }
                }
                else{
                    e.preventDefault();
                    $body.toggleClass('open-cart-aside');
                }
            });

            $document.on('click', '.lahb-search.lahb-header-full > a', function (e) {
                e.preventDefault();
                $body.addClass('open-search-form');
                setTimeout(function(){
                    $('.searchform-fly .search-field').focus();
                }, 600);
            });

            // Search Toggles
            $document.on('click', '.lahb-search .js-search_trigger_slide', function (e) {

                if ($header_builder.find('.la-header-search').hasClass('opened')) {
                    $header_builder.find('.main-slide-toggle').slideUp('opened');
                    $header_builder.find('.la-header-search').removeClass('opened');
                }
                else {
                    $header_builder.find('.main-slide-toggle').slideDown(240);
                    $header_builder.find('#header-social-modal').slideUp(240);
                    $header_builder.find('#header-search-modal').slideDown(240);
                    $header_builder.find('.la-header-search').addClass('opened');
                    $header_builder.find('.la-header-social').removeClass('opened');
                    $header_builder.find('#header-search-modal .search-field').focus();
                }
            });

            $document.on('click', function (e) {
                if( $(e.target).hasClass('js-search_trigger_slide') || $(e.target).closest('.js-search_trigger_slide').length ) {
                    return;
                }
                if($('.lahb-search .js-search_trigger_slide').length){
                    if ($header_builder.find('.la-header-search').hasClass('opened')) {
                        $header_builder.find('.main-slide-toggle').slideUp('opened');
                        $header_builder.find('.la-header-search').removeClass('opened');
                    }
                }
            });


            if ($.fn.niceSelect) {
                $('.la-polylang-switcher-dropdown select').niceSelect();
            }

            if ($.fn.superfish) {
                $('.lahb-area:not(.lahb-vertical) .lahb-nav-wrap:not(.has-megamenu) ul.menu').superfish({
                    delay: 300,
                    hoverClass: 'la-menu-hover',
                    animation: {
                        opacity: "show",
                        height: 'show'
                    },
                    animationOut: {
                        opacity: "hide",
                        height: 'hide'
                    },
                    easing: 'easeOutQuint',
                    speed: 100,
                    speedOut: 0,
                    pathLevels: 2
                });
            }

            $('.lahb-nav-wrap .menu li a').addClass('hcolorf');

            // Hamburger Menu
            var $hamurgerMenuWrapClone = $('.hamburger-type-toggle').find('.hamburger-menu-wrap');
            if ($hamurgerMenuWrapClone.length > 0) {
                $hamurgerMenuWrapClone.appendTo('body');
                $('.hamburger-type-toggle .la-hamuburger-bg').remove();
            }

            if ($('.hamburger-menu-wrap').hasClass('toggle-right')) {
                $body.addClass('lahb-body lahmb-right');
            }
            else if ($('.hamburger-menu-wrap').hasClass('toggle-left')) {
                $body.addClass('lahb-body lahmb-left');
            }

            if ($.fn.niceScroll) {
                //Hamburger Nicescroll
                $('.hamburger-menu-main').niceScroll({
                    scrollbarid: 'lahb-hamburger-scroll',
                    cursorwidth: "5px",
                    autohidemode: true
                });
            }

            $document.on('click', '.btn-close-hamburger-menu', function (e) {
                e.preventDefault();
                $body.removeClass('is-open');
                $('.lahb-hamburger-menu').removeClass('is-open');
                $('.hamburger-menu-wrap').removeClass('hm-open');
                if($.fn.getNiceScroll){
                    $('.hamburger-menu-main').getNiceScroll().resize();
                }
            });

            $document.on('click', '.hamburger-type-toggle a.lahb-icon-element', function (e) {
                e.preventDefault();
                var $that = $(this),
                    $_parent = $that.closest('.lahb-hamburger-menu'),
                    _cpt_id = $that.attr('data-id');

                if($_parent.hasClass('is-open')){
                    $('.btn-close-hamburger-menu').trigger('click');
                }
                else{
                    $_parent.addClass('is-open');
                    $body.addClass('is-open');
                    $body.find('.hamburger-menu-wrap.hamburger-menu-wrap-' + _cpt_id).addClass('hm-open');
                    if($.fn.getNiceScroll){
                        $('.hamburger-menu-main').getNiceScroll().resize();
                    }
                }

            });



            $('.hamburger-nav.toggle-menu').find('li').each(function () {
                var $list_item = $(this);

                if ($list_item.children('ul').length) {
                    $list_item.children('a').append('<i class="hamburger-nav-icon lastudioicon-down-arrow"></i>');
                }

                $('> a > .hamburger-nav-icon', $list_item).on('click', function (e) {
                    e.preventDefault();
                    var $that = $(this);
                    if( $that.hasClass('active') ){
                        $that.removeClass('active lastudioicon-up-arrow').addClass('lastudioicon-down-arrow');
                        $('>ul', $list_item).stop().slideUp();
                    }
                    else{
                        $that.removeClass('lastudioicon-down-arrow').addClass('lastudioicon-up-arrow active');
                        $('>ul', $list_item).stop().slideDown(350, function () {
                            if($.fn.getNiceScroll){
                                $('.hamburger-menu-main').getNiceScroll().resize();
                            }
                        });
                    }
                })
            });

            //Full hamburger Menu
            $document.on('click', '.hamburger-type-full .js-hamburger_trigger', function (e) {
                e.preventDefault();
                var $that = $(this);
                if( $that.hasClass('open-button') ){
                    $('.la-hamburger-wrap-' + $that.data('id')).removeClass('open-menu');
                    $that.removeClass('open-button').addClass('close-button');
                    $body.removeClass('opem-lahb-iconmenu');
                }
                else{
                    $('.la-hamburger-wrap-' + $that.data('id')).addClass('open-menu');
                    $that.removeClass('close-button').addClass('open-button');
                    $body.addClass('opem-lahb-iconmenu');
                }
            });

            $document.on('click', '.btn-close-hamburger-menu-full', function (e) {
                e.preventDefault();
                $('.js-hamburger_trigger').removeClass('open-button').addClass('close-button');
                $('.la-hamburger-wrap').removeClass('open-menu');
                $body.removeClass('opem-lahb-iconmenu');
            });

            $('.full-menu li > ul').each(function () {
                var $ul = $(this);
                $ul.prev('a').append('<i class="hamburger-nav-icon lastudioicon-down-arrow"></i>');
            });

            $('.full-menu').on('click', 'li .hamburger-nav-icon', function (e) {
                e.preventDefault();
                var $that = $(this),
                    $li_parent = $that.closest('li');

                if ($li_parent.hasClass('open')) {
                    $that.removeClass('active lastudioicon-up-arrow').addClass('lastudioicon-down-arrow');
                    $li_parent.removeClass('open');
                    $li_parent.find('li').removeClass('open');
                    $li_parent.find('ul').stop().slideUp();
                    $li_parent.find('.hamburger-nav-icon').removeClass('active lastudioicon-up-arrow').addClass('lastudioicon-down-arrow');
                }
                else {
                    $li_parent.addClass('open');
                    $that.removeClass('lastudioicon-down-arrow').addClass('active lastudioicon-up-arrow');
                    $li_parent.find('>ul').stop().slideDown();
                    $li_parent.siblings().removeClass('open').find('ul').stop().slideUp();
                    $li_parent.siblings().find('li').removeClass('open');
                    $li_parent.siblings().find('.hamburger-nav-icon').removeClass('active lastudioicon-up-arrow').addClass('lastudioicon-down-arrow');
                }
            });

            $('.touchevents .full-menu').on('touchend', 'li .hamburger-nav-icon', function (e) {
                e.preventDefault();
                var $that = $(this),
                    $li_parent = $that.closest('li');

                if ($li_parent.hasClass('open')) {
                    $that.removeClass('active lastudioicon-up-arrow').addClass('lastudioicon-down-arrow');
                    $li_parent.removeClass('open');
                    $li_parent.find('li').removeClass('open');
                    $li_parent.find('ul').stop().slideUp();
                    $li_parent.find('.hamburger-nav-icon').removeClass('active lastudioicon-up-arrow').addClass('lastudioicon-down-arrow');
                }
                else {
                    $li_parent.addClass('open');
                    $that.removeClass('lastudioicon-down-arrow').addClass('active lastudioicon-up-arrow');
                    $li_parent.find('>ul').stop().slideDown();
                    $li_parent.siblings().removeClass('open').find('ul').stop().slideUp();
                    $li_parent.siblings().find('li').removeClass('open');
                    $li_parent.siblings().find('.hamburger-nav-icon').removeClass('active lastudioicon-up-arrow').addClass('lastudioicon-down-arrow');
                }
            });

            // Toggle search form
            $document.on('click', '.lahb-search .js-search_trigger_toggle', function (e) {
                e.preventDefault();
                $(this).siblings('.lahb-search-form-box').toggleClass('show-sbox');
            });

            $document.on('click', function (e) {
                if( $(e.target).hasClass('js-search_trigger_toggle') || $(e.target).closest('.js-search_trigger_toggle').length){
                    return;
                }
                if( $('.lahb-search-form-box').length ) {
                    if( $(e.target).closest('.lahb-search-form-box').length == 0){
                        $('.lahb-search-form-box').removeClass('show-sbox');
                    }
                }
            });

            // Responsive Menu
            $document.on('click', '.lahb-responsive-menu-icon-wrap', function (e) {
                e.preventDefault();
                var $toggleMenuIcon = $(this),
                    uniqid = $toggleMenuIcon.data('uniqid'),
                    $responsiveMenu = $('.lahb-responsive-menu-wrap[data-uniqid="' + uniqid + '"]'),
                    $closeIcon = $responsiveMenu.find('.close-responsive-nav');

                if ($responsiveMenu.hasClass('open') === false) {
                    $toggleMenuIcon.addClass('open-icon-wrap').children().addClass('open');
                    $closeIcon.addClass('open-icon-wrap').children().addClass('open');

                    if(LA.utils.isRTL()){
                        $responsiveMenu.animate({'right': 0}, 350)
                    }
                    else{
                        $responsiveMenu.animate({'left': 0}, 350)
                    }
                    $responsiveMenu.addClass('open');
                }
                else {
                    $toggleMenuIcon.removeClass('open-icon-wrap').children().removeClass('open');
                    $closeIcon.removeClass('open-icon-wrap').children().removeClass('open');

                    if(LA.utils.isRTL()){
                        $responsiveMenu.animate({'right': -1 * $responsiveMenu.outerWidth()}, 350)
                    }
                    else{
                        $responsiveMenu.animate({'left': -1 * $responsiveMenu.outerWidth()}, 350)
                    }
                    $responsiveMenu.removeClass('open');
                }
            });

            $('.lahb-responsive-menu-wrap').each(function () {
                var $this = $(this),
                    uniqid = $this.data('uniqid'),
                    $responsiveMenu = $this.clone(),
                    $closeIcon = $responsiveMenu.find('.close-responsive-nav'),
                    $toggleMenuIcon = $('.lahb-responsive-menu-icon-wrap[data-uniqid="' + uniqid + '"]');

                // append responsive menu to lastudio header builder wrap
                $this.remove();
                $('#lastudio-header-builder').append($responsiveMenu);

                // add arrow down to parent menus
                $responsiveMenu.find('li').each(function () {
                    var $list_item = $(this);

                    if ($list_item.children('ul').length) {
                        $list_item.children('a').append('<i class="lastudioicon-down-arrow respo-nav-icon"></i>');
                    }

                    $('> a > .respo-nav-icon', $list_item).on('click', function (e) {
                        e.preventDefault();
                        var $that = $(this);
                        if( $that.hasClass('active') ){
                            $that.removeClass('active lastudioicon-up-arrow').addClass('lastudioicon-down-arrow');
                            $('>ul', $list_item).stop().slideUp(350);
                        }
                        else{
                            $that.removeClass('lastudioicon-down-arrow').addClass('lastudioicon-up-arrow active');
                            $('>ul', $list_item).stop().slideDown(350);
                        }
                    });
                });

                // close responsive menu
                $closeIcon.on('click', function () {
                    if ($toggleMenuIcon.hasClass('open-icon-wrap')) {
                        $toggleMenuIcon.removeClass('open-icon-wrap').children().removeClass('open');
                        $closeIcon.removeClass('open-icon-wrap').children().removeClass('open');
                    }
                    else {
                        $toggleMenuIcon.addClass('open-icon-wrap').children().addClass('open');
                        $closeIcon.addClass('open-icon-wrap').children().addClass('open');
                    }

                    if ($responsiveMenu.hasClass('open') === true) {
                        if(LA.utils.isRTL()){
                            $responsiveMenu.animate({'right': -1 * $responsiveMenu.outerWidth() }, 350)
                        }
                        else{
                            $responsiveMenu.animate({'left': -1 * $responsiveMenu.outerWidth() }, 350)
                        }
                        $responsiveMenu.removeClass('open')
                    }
                });

                $responsiveMenu.on('click', 'li.menu-item:not(.menu-item-has-children) > a', function (e) {
                    $toggleMenuIcon.removeClass('open-icon-wrap').children().removeClass('open');
                    $closeIcon.removeClass('open-icon-wrap').children().removeClass('open');
                    if(LA.utils.isRTL()){
                        $responsiveMenu.animate({'right': -1 * $responsiveMenu.outerWidth() }, 350)
                    }
                    else{
                        $responsiveMenu.animate({'left': -1 * $responsiveMenu.outerWidth() }, 350)
                    }
                    $responsiveMenu.removeClass('open')
                });
            });

            // Login Dropdown

            $('.lahb-login .js-login_trigger_dropdown').each(function () {
                var $this = $(this);
                if($this.siblings('.lahb-modal-login').length == 0){
                    $('.lahb-modal-login.la-element-dropdown').first().clone().appendTo($this.parent());
                }
            });

            $document.on('click', '.lahb-login .js-login_trigger_dropdown', function (e) {
                e.preventDefault();
                $(this).siblings('.lahb-modal-login').fadeToggle('fast');
            });


            // Contact Dropdown
            $document.on('click', '.lahb-contact .js-contact_trigger_dropdown', function (e) {
                e.preventDefault();
                $(this).siblings('.la-contact-form').fadeToggle('fast');
            });
            $document.on('click', function (e) {
                if( $(e.target).hasClass('js-contact_trigger_dropdown')){
                    return;
                }
                if( $('.la-contact-form.la-element-dropdown').length ) {
                    if($(e.target).closest('.la-contact-form.la-element-dropdown').length == 0){
                        $('.la-contact-form.la-element-dropdown').css({
                            'display': 'none'
                        })
                    }
                }
            });


            // Icon Menu Dropdown

            $document.on('click', '.lahb-icon-menu .js-icon_menu_trigger', function (e) {
                e.preventDefault();
                $(this).siblings('.lahb-icon-menu-content').fadeToggle('fast');
            });

            $document.on('click', function (e) {
                if( $(e.target).hasClass('js-icon_menu_trigger')){
                    return;
                }
                if( $('.la-element-dropdown.lahb-icon-menu-content').length ) {
                    if($(e.target).closest('.la-element-dropdown.lahb-icon-menu-content').length == 0){
                        $('.la-element-dropdown.lahb-icon-menu-content').css({
                            'display': 'none'
                        })
                    }
                }
            });

            // Wishlist Dropdown
            $('.lahb-wishlist').each(function (index, el) {
                $(this).find('#la-wishlist-icon').on('click', function (event) {
                    $(this).siblings('.la-header-wishlist-wrap').fadeToggle('fast', function () {
                        if ($(".la-header-wishlist-wrap").is(":visible")) {
                            $document.on('click', function (e) {
                                var target = $(e.target);
                                if (target.parents('.lahb-wishlist').length)
                                    return;
                                $(".la-header-wishlist-wrap").css({
                                    display: 'none'
                                });
                            });
                        }
                    });
                });
            });

            $('.la-header-wishlist-content-wrap').find('.la-wishlist-total').addClass('colorf');


            /* Profile Socials */

            $('.lahb-profile-socials-text')
                .on('mouseenter', function () {
                    $(this).closest('.lahb-profile-socials-wrap').find('.lahb-profile-socials-icons').removeClass('profile-socials-hide').addClass('profile-socials-show');
                })
                .on('mouseleave', function () {
                    $(this).closest('.lahb-profile-socials-wrap').find('.lahb-profile-socials-icons').removeClass('profile-socials-show').addClass('profile-socials-hide');
                });


            /* Vertical Header */

            var _sopt_offset = LA.utils.getAdminbarHeight();

            _sopt_offset += parseInt($('.header-type-vertical .lahb-row1-area').css('paddingTop'));

            var sopt = {
                to: 'top',
                offset: _sopt_offset,
                effectsOffset: 0,
                parent: '#main',
                classes: {
                    sticky: 'elementor-sticky',
                    stickyActive: 'elementor-sticky--active elementor-section--handles-inside',
                    stickyEffects: 'elementor-sticky--effects',
                    spacer: 'elementor-sticky__spacer'
                }
            };

            //$('.header-type-vertical--default .lahb-wrap .lahb-vertical .lahb-content-wrap').lasfsticky(sopt);

            // Toggle Vertical
            $document.on('click', '.lahb-vertical-toggle-wrap .vertical-toggle-icon', function (e) {
                e.preventDefault();
                if($body.hasClass('open-lahb-vertical')){
                    $body.removeClass('open-lahb-vertical');
                }
                else{
                    $body.addClass('open-lahb-vertical');
                }
            });

            // Vertical Menu
            $('.lahb-vertical .lahb-nav-wrap:not(.lahb-vertital-menu_nav)').removeClass('has-megamenu has-parent-arrow').closest('.lahb-col').addClass('colmaxheight');
            $('.lahb-vertical .lahb-nav-wrap:not(.lahb-vertital-menu_nav) li.mega').removeClass('mega');
            $('.lahb-vertical .lahb-nav-wrap:not(.lahb-vertital-menu_nav) li.mm-popup-wide').removeClass('mm-popup-wide');
            $('.lahb-vertical .lahb-nav-wrap:not(.lahb-vertital-menu_nav) .menu li').each(function () {
                var $list_item = $(this);

                if ($list_item.children('ul').length) {
                    $list_item.children('a').removeClass('sf-with-ul').append('<i class="lastudioicon-down-arrow lahb-vertical-nav-icon"></i>');
                }

                $('> a > .lahb-vertical-nav-icon', $list_item).on('click', function (e) {
                    e.preventDefault();
                    var $that = $(this);
                    if( $that.hasClass('active') ){
                        $that.removeClass('active lastudioicon-up-arrow').addClass('lastudioicon-down-arrow');
                        $('>ul', $list_item).stop().slideUp();
                    }
                    else {
                        $that.removeClass('lastudioicon-down-arrow').addClass('lastudioicon-up-arrow active');
                        $('>ul', $list_item).stop().slideDown();
                    }
                });

            });

            $document.on('keyup', function (e) {
                if(e.keyCode == 27){
                    $body.removeClass('is-open open-search-form open-cart-aside open-lahb-vertical');
                    $('.hamburger-menu-wrap').removeClass('hm-open');
                    $('.lahb-hamburger-menu.hamburger-type-toggle').removeClass('is-open');
                    $('.lahb-hamburger-menu.hamburger-type-full .hamburger-op-icon').removeClass('open-button').addClass('close-button');
                    $('.la-hamburger-wrap').removeClass('open-menu');
                }
            });

            $('.lahb-mobiles-view .lahb-vertital-menu_nav').removeClass('has-parent-arrow');
            var $mb_vertial_menus = $('.lahb-mobiles-view .lahb-vertital-menu_nav > .menu');
            if($mb_vertial_menus.length){
                $mb_vertial_menus.each(function () {
                    var $_that = $(this).clone();
                    var $mb_v_parent = $(this).parent();
                    $(this).remove();
                    $_that.find('.mm-popup-wide').removeClass('mm-popup-wide mega');
                    $_that.find('.mm-popup-narrow').removeClass('mm-popup-narrow');
                    $_that.find('.mm-mega-ul').each(function () {
                        $(this).unwrap().unwrap().removeClass('mm-mega-ul').addClass('sub-menu');
                        $('>li', $(this)).removeAttr('style').removeClass('submenu');
                    });
                    $_that.find('> li > ul').each(function () {
                        $(this).before('<span class="narrow"><i></i></span>');
                    });
                    $_that.on('click', 'li > .narrow', function (e) {
                        e.preventDefault();
                        var $parent = $(this).parent();
                        if ($parent.hasClass('open')) {
                            $parent.removeClass('open');
                            $parent.find('>ul').stop().slideUp();
                        }
                        else {
                            $parent.addClass('open');
                            $parent.find('>ul').stop().slideDown();
                            $parent.siblings().removeClass('open').find('>ul').stop().slideUp();
                        }
                    });
                    $_that.appendTo($mb_v_parent);
                });
            }


            $( '.la-ajax-searchform' ).each(function () {
                LA.core.InstanceSearch($(this));
            });

            $document.on('click', function (e) {
                if( $(e.target).closest('.la-ajax-searchform').length ) {
                    return;
                }
                $('.la-ajax-searchform .results-container').hide();
            })

        },

        HeaderSticky: function(){
            var $header_builder = $('#lastudio-header-builder');

            var scroll_direction = 'none',
                last_scroll = $window.scrollTop();

            $window.on('scroll', function(){
                var currY = $window.scrollTop();
                scroll_direction = (currY > last_scroll) ? 'down' : ((currY === last_scroll) ? 'none' : 'up');
                last_scroll = currY;
            });

            var prepareHeightForHeader = function (){
                var _current_height = 0;
                if( $.exists($header_builder) ){
                    _current_height = $('.lahbhinner').outerHeight();
                    document.documentElement.style.setProperty('--header-height', _current_height + 'px');
                }
            };
            prepareHeightForHeader();
            $window.on('resize', prepareHeightForHeader);

            var sticky_auto_hide = !!$body.hasClass('header-sticky-type-auto');
            function init_builder_sticky() {
                if( ! $.exists($header_builder) ) {
                    return;
                }

                var $_header = $header_builder,
                    $_header_outer = $('.lahbhouter', $header_builder),
                    $_header_inner = $('.lahbhinner', $header_builder);

                var lastY = 0,
                    offsetY = LA.utils.getOffset($_header_outer).y;

                $window
                    .on('resize', function(e){
                        offsetY = LA.utils.getOffset($_header_outer).y;
                    })
                    .on('scroll', function(e){

                        var currentScrollY = $window.scrollTop();

                        var _breakpoint = offsetY - LA.utils.getAdminbarHeight();

                        if(sticky_auto_hide){
                            _breakpoint = offsetY - LA.utils.getAdminbarHeight() + $_header_inner.outerHeight();
                        }

                        if( currentScrollY > _breakpoint ) {
                            $_header_inner.css('top', LA.utils.getAdminbarHeight());

                            if( !$_header.hasClass('is-sticky') ) {
                                $_header.addClass('is-sticky');
                            }

                            if(sticky_auto_hide){
                                if(currentScrollY < $body.height() && lastY > currentScrollY){
                                    if($_header_inner.hasClass('sticky--unpinned')){
                                        $_header_inner.removeClass('sticky--unpinned');
                                    }
                                    if(!$_header_inner.hasClass('sticky--pinned')){
                                        $_header_inner.addClass('sticky--pinned');
                                    }
                                }
                                else{
                                    if($_header_inner.hasClass('sticky--pinned')){
                                        $_header_inner.removeClass('sticky--pinned');
                                    }
                                    if(!$_header_inner.hasClass('sticky--unpinned')){
                                        $_header_inner.addClass('sticky--unpinned');
                                    }
                                }
                            }
                            else{
                                $_header_inner.addClass('sticky--pinned');
                            }
                        }
                        else{
                            if(sticky_auto_hide){
                                if($_header.hasClass('is-sticky')){
                                    if(_breakpoint - currentScrollY < $_header_inner.outerHeight()){
                                    }
                                    else{
                                        /** remove stuck **/
                                        $_header.removeClass('is-sticky');
                                        $_header_inner.css('top','0').removeClass('sticky--pinned sticky--unpinned');
                                    }
                                }
                            }
                            else{
                                if($_header.hasClass('is-sticky')){
                                    $_header.removeClass('is-sticky');
                                    $_header_inner.css('top','0').removeClass('sticky--pinned sticky--unpinned');
                                }
                            }
                        }

                        lastY = currentScrollY;
                    })
            }

            if(!$body.hasClass('enable-header-sticky')) return;

            init_builder_sticky();
        },

        MegaMenu: function(){
            function fix_megamenu_position( $elem, $container, container_width, isVerticalMenu) {

                if($('.megamenu-inited', $elem).length){
                    return false;
                }
                var $popup = $('> .sub-menu', $elem);

                if ($popup.length == 0) return;
                var megamenu_width = $popup.outerWidth();

                if (megamenu_width > container_width) {
                    megamenu_width = container_width;
                }
                if (!isVerticalMenu) {

                    var container_padding_left = parseInt($container.css('padding-left')),
                        container_padding_right = parseInt($container.css('padding-right')),
                        parent_width = $popup.parent().outerWidth(),
                        left = 0,
                        container_offset = LA.utils.getOffset($container),
                        megamenu_offset = LA.utils.getOffset($popup);

                    var megamenu_offset_x = megamenu_offset.x,
                        container_offset_x = container_offset.x;

                    if (megamenu_width > parent_width) {
                        left = -(megamenu_width - parent_width) / 2;
                    }
                    else{
                        left = 0
                    }

                    if(LA.utils.isRTL()){
                        var megamenu_offset_x_swap = $window.width() - ( megamenu_width + megamenu_offset_x ),
                            container_offset_x_swap = $window.width() - ( $container.outerWidth() + container_offset_x );

                        if ((megamenu_offset_x_swap - container_offset_x_swap - container_padding_right + left) < 0) {
                            left = -(megamenu_offset_x_swap - container_offset_x_swap - container_padding_right);
                        }
                        if ((megamenu_offset_x_swap + megamenu_width + left) > (container_offset_x + $container.outerWidth() - container_padding_left)) {
                            left -= (megamenu_offset_x_swap + megamenu_width + left) - (container_offset_x + $container.outerWidth() - container_padding_left);
                        }
                        $popup.css('right', left).css('right');
                    }
                    else{

                        if ((megamenu_offset_x - container_offset_x - container_padding_left + left) < 0) {
                            left = -1 * (megamenu_offset_x - container_offset_x - container_padding_left);
                        }

                        if ((megamenu_offset_x + megamenu_width + left) > (container_offset_x + $container.outerWidth() - container_padding_right)) {
                            left = 0;
                            left = -1 * ((megamenu_offset_x + megamenu_width + left) - (container_offset_x + $container.outerWidth() - container_padding_right));
                        }

                        if($container.is('body')){
                            left = -1 * megamenu_offset_x;
                        }

                        $popup.css('left', left).css('left');
                    }
                }

                if (isVerticalMenu) {
                    var clientHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight,
                        itemOffset = $popup.offset(),
                        itemHeight = $popup.outerHeight(),
                        scrollTop = $window.scrollTop();

                    if ((itemOffset.top - scrollTop) + itemHeight > clientHeight) {
                        var __top = clientHeight - (itemOffset.top + scrollTop + itemHeight + 50);
                        if(itemHeight >= clientHeight){
                            //__top = 1 - itemOffset.top - scrollTop;
                            $popup.offset({top: LA.utils.getAdminbarHeight()});
                        }
                        else{
                            $popup.css({top: __top});
                        }
                    }
                }
                $popup.addClass('megamenu-inited');
            }

            LA.utils.eventManager.subscribe('LaStudio:MegaMenuBuilder:MenuPosition', function(e, $megamenu){
                if($.exists($megamenu)){

                    $megamenu.closest('.lahb-content-wrap').addClass('position-relative');

                    $megamenu.each(function(){
                        var _that = $(this),
                            container_width = 0,
                            $container = _that.closest('.lahb-content-wrap'),
                            isVerticalMenu = false;

                        container_width = $container.width();

                        if( _that.closest('.lahb-vertital-menu_nav').length ) {
                            isVerticalMenu = true;
                        }

                        if($body.hasClass('header-type-vertical')){
                            container_width = 1200;
                            if( $window.width() < 1500 ) {
                                container_width = $window.width() -  $('#lastudio-header-builder').outerWidth();
                            }
                        }
                        else{
                            if( _that.hasClass('lahb-vertital-menu_nav')){
                                container_width = container_width - _that.outerWidth();
                            }
                        }

                        $('li.mega .megamenu-inited', _that).removeClass('megamenu-inited');

                        $('li.mega > .sub-menu', _that).removeAttr('style');

                        $('li.mega', _that).each(function(){
                            var $menu_item = $(this),
                                $popup = $('> .sub-menu', $menu_item),
                                $inner_popup = $('> .sub-menu > .mm-mega-li', $menu_item),
                                item_max_width = parseInt(!!$inner_popup.data('maxWidth') ? $inner_popup.data('maxWidth') : $inner_popup.css('maxWidth') ),
                                $_container = $container;

                            var default_width = 1200;

                            if(container_width < default_width){
                                default_width = container_width;
                            }

                            if(isNaN(item_max_width)){
                                item_max_width = default_width;
                            }

                            if(default_width > item_max_width){
                                default_width = parseInt(item_max_width);
                            }

                            if( $menu_item.hasClass('mm-popup-force-fullwidth')){
                                $inner_popup.data('maxWidth', item_max_width).css('maxWidth', 'none');
                                $('> ul', $inner_popup).css('width', item_max_width);
                                if(!isVerticalMenu){
                                    default_width = $window.width();
                                    $_container = $body;
                                }
                                else{
                                    if( _that.closest('.vertital-menu_nav-hastoggle').length == 0 ){
                                        default_width = $('#page > .site-inner').width();
                                    }
                                }
                            }
                            $popup.width(default_width);
                            fix_megamenu_position( $menu_item, $_container, container_width, isVerticalMenu);
                        });
                    })
                }
            });

            LA.utils.eventManager.publish('LaStudio:MegaMenuBuilder:MenuPosition', [ $('body .lahb-nav-wrap.has-megamenu') ]);

            $window.on('resize', function(){
                LA.utils.eventManager.publish('LaStudio:MegaMenuBuilder:MenuPosition', [ $('body .lahb-nav-wrap.has-megamenu') ]);
            });

            $document.on('click', '.lahb-vertital-menu_nav .lahb-vertital-menu_button button', function (e) {
                e.preventDefault();
                var $parent = $(this).closest('.lahb-vertital-menu_nav');
                $parent.hasClass('open') ? $parent.removeClass('open') : $parent.addClass('open');
            });
        },

        reloadAllEvents: function () {
            clone_widget();
            $('body > .hamburger-menu-wrap').remove();
            LaStudio.component.HeaderBuilder.init();
            LaStudio.component.HeaderBuilder.HeaderSticky();
            LaStudio.component.HeaderBuilder.MegaMenu();
            $window.trigger('scroll');
            //console.log('ok -- reloadAllEvents!');
        }
    }

    LaStudio.component.HeaderBuilder = HeaderBuilder;

    $(function () {
        $document.on('LaStudio:Document:AfterRunScript', function (e) {
            LaStudio.component.HeaderBuilder.HeaderSticky();
            $window.trigger('scroll');
        });
        LaStudio.component.HeaderBuilder.init();
        LaStudio.component.HeaderBuilder.MegaMenu();
    });

})(jQuery);