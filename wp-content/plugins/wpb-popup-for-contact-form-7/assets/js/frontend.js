+(function($) {
    var WPB_PCF_Button = {

        initialize: function() {
            $('.wpb-pcf-form-fire').on('click', this.FireContactForm);
        },

        FireContactForm: function(e) {
            e.preventDefault();

            var button  = $(this),
            id          = button.attr('data-id'),
            post_id     = button.attr('data-post_id'),
            form_style  = button.attr('data-form_style') ? !0 : !1,
            width       = button.attr('data-width');

            wp.ajax.send( {
                data: {
                    action: 'wpb_pcf_fire_contact_form',
                    pcf_form_id: id,
                    wpb_pcf_post_id: post_id,
                    _wpnonce: WPB_PCF_Vars.nonce
                },
                beforeSend : function ( xhr ) {
					button.addClass('wpb-pcf-btn-loading');
				},
                success: function( res ) {
                    button.removeClass('wpb-pcf-btn-loading');
                    Swal.fire({
                        html: res,
                        showConfirmButton: false,
                        customClass: {
                            container: 'wpb-pcf-form-style-' + form_style,
                        },
                        padding: '30px',
                        width: width,
                        showCloseButton: true,
                    });
                    
                    // For CF7 5.3.1 and before
                    if ($.isFunction(wpcf7.initForm)) {
                        wpcf7.initForm( $('.wpcf7-form') );
                    }

                    // For CF7 5.4 and after
                    if ($.isFunction(wpcf7.init)) {
                        document.querySelectorAll(".wpcf7 > form").forEach(function (e) {
                            return wpcf7.init(e);
                        });
                    }
                },
                error: function(error) {
                    alert( error );
                }
            });
        },


    };

    $(function() {
        WPB_PCF_Button.initialize();
    });
})(jQuery);