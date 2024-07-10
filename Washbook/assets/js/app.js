/*!
 * app.js
 * Version 1.0 - built in 2023
 * https://dottedcraft.com
 * Dotted Craft Limited - <hello@dottedcraft.com>
 * Private License
 */
var DottedCraft = (function($) {
"use strict";

    /*
    * Initialize popover
    */
    $('[data-toggle="popover"]').popover({ trigger: 'hover' });


    /*
    * Initialize tooltip
    */
    $('[data-toggle="tooltip"]').tooltip();


    /*
    * Initialize international phone
    */
    function initPhoneInput() {
        $(".phone-input").intlTelInput({
            autoPlaceholder: "polite",
            initialCountry: "ke",
            placeholderNumberType: "FIXED_LINE",
            utilsScript: "https://cdn.dottedcraft.com/utils.js"
        });
    }
    initPhoneInput();

    /*
    * Detect Active Link
    */
    function activeLink() {
        var currenturl = window.location.href,
            pathname = currenturl.substring(0, (currenturl.indexOf("#") == -1) ? currenturl.length : currenturl.indexOf("#")), 
            pathname = pathname.substring(0, (pathname.indexOf("?") == -1) ? pathname.length : pathname.indexOf("?"));

        $(".aside-link").each(function() {
            var linkurl = $(this).attr('href');
            if (pathname.match(linkurl)) {
                if($(this).hasClass("overview") && currenturl === linkurl+"/"){
                    $(this).addClass('active');
                }else if($(this).hasClass("overview") && currenturl !== linkurl+"/"){
                    $(this).closest("li").removeClass('active current-page').parents().closest("li:not(.current-page)").removeClass("active");
                }else{
                    $(this).addClass('active');
                }
            } else {
                $(this).removeClass('active');
            }
        });
    }
    activeLink();


    /*
    * Get international phone 
    */
    $("body").on("change", ".phone-input", function() {
        $(this).closest(".intl-tel-input").siblings(".hidden-phone").val($(this).intlTelInput("getNumber"));
    });

    /*
    * Detect phone number change
    */
    $("body").on("blur", ".phone-input", function() {
        if ($.trim($(this).val())) {
            if (!$(this).intlTelInput("isValidNumber")) {
                $(this).val('');
                toastr.error("Invalid phone number.", "Oops!", {
                    timeOut: null,
                    closeButton: true
                });
            } else {
                toastr.clear();
            }
        }
    });

    /*
    * Initislize Date Picker
    */
    if ($(".date-input")) {
        $(".date-input").datepicker({
            "autoclose": true,
            "todayHighlight": true,
        });
    }

    /*
    * Toggle Mobile menu
    */
    $("body").on("click", ".mobile-nav", function (event) {
        event.preventDefault();
        $("aside.aside").toggleClass("show");
    });



    /*
    * Toggle Thank you message
    */
    $("body").on("change", "input[name=send_thankyou]", function(){
        if($(this).prop("checked")){
            $(".thankyou-message").show();
            $("textarea[name=thankyou_message]").attr("required", true);
        }else{
            $(".thankyou-message").hide();
            $("textarea[name=thankyou_message]").attr("required", false);
        }
    });


    /*
    * Toggle Thank you message
    */
    $("body").on("change",".sms-provider-select", function(){

        var provider = $(this).val();
        
        if (provider === "twillio") {
            $(".twilio-input").show();
            $(".twilio-input input").attr("required", true);
            $(".africastalking-input").hide();
            $(".africastalking-input input").attr("required", false);
        }else{
            $(".africastalking-input").show();
            $(".africastalking-input input").attr("required", true);
            $(".twilio-input").hide();
            $(".twilio-input input").attr("required", false);

        }

    });



    /*
    * Send SMS
    */
    $("body").on("click", ".send-sms", function(event){
        event.preventDefault();

        var phonenumber = $(this).attr("data-phonenumber");
        var name = $(this).attr("data-name");

        $("#sendsms").find("input[name=phonenumber]").val(phonenumber);
        $("#sendsms").find("input[name=name]").val(name);

        $("#sendsms").modal("show");

    });

    /*
    * Select campagn receivers
    */
    $("body").on("change", "select[name=sendto]", function(event){

        var sendto = $(this).val();

        if (sendto === "" || sendto === "clients" || sendto === "members") {
            $(".campaign-sendto").hide();
            $(".campaign-sendto").find("select, input").attr("required", false);
        }else if (sendto === "selectedclients") {
            $(".campaign-sendto").hide();
            $(".campaign-sendto").find("select, input").attr("required", false);

            $(".campaign-sendto[data-type=clients]").find("select").attr("required", true);
            $(".campaign-sendto[data-type=clients]").show();
        }else if (sendto === "selectedmembers") {
            $(".campaign-sendto").hide();
            $(".campaign-sendto").find("select, input").attr("required", false);

            $(".campaign-sendto[data-type=members]").find("select").attr("required", true);
            $(".campaign-sendto[data-type=members]").show();
        }else if (sendto === "enternumber") {
            $(".campaign-sendto").hide();
            $(".campaign-sendto").find("select, input").attr("required", false);

            $(".campaign-sendto[data-type=manually]").find("input[type=text]").attr("required", true);
            $(".campaign-sendto[data-type=manually]").show();
        }

    });


    /*
    * Create a sale
    */
    function createsale() {

        $("body").on("change", ".service-offered", function() {
            
            if ($(this).prop("checked")) {
                $(this).closest(".sale-service-card").addClass("selected-service");
                $(this).closest(".sale-service-card").find("input, select").attr("required", true);
            }else{
                $(this).closest(".sale-service-card").removeClass("selected-service");
                $(this).closest(".sale-service-card").find("input, select").attr("required", false);
            }
            
            saleTotal();
            
        });

        $("body").on("change", ".service-paid", function() {
        
            if ($(this).prop("checked")) {
                $(".service-payment-method").show();
            }else{
                $(".service-payment-method").hide();
            }
            
        });

    }

    /*
    * When a service is paid
    */
    $("body").on("change", ".service-paid", function() {
        
        if ($(this).prop("checked")) {
            $(".service-payment-method").show();
        }else{
            $(".service-payment-method").hide();
        }
        
    });

        /*
    * Calculate sale total
    */
    function saleTotal(){
        
        var total = 0;
        
        $("body").find(".service-offered:checked").each(function () {
            
            var serviceHolder = $(this).closest(".sale-service-card");
            var cost = total = 0
            
            if ($(this).prop("checked")) {
                cost = $(serviceHolder).find("input.sale-cost").val();
                total = total + parseFloat(cost);
            }
            
        });
        
        $(".sale-total").text(number_format(total, 2));
    }

    /*
    * Calculate sale total on cost change
    */
    $("body").on("keyup", "input.sale-cost", function(event){

        saleTotal();

    });


    /*
    * Delete a sale
    */
    $("body").on("click", ".delete-sale", function(event){
        event.preventDefault();

        $("#deletesale").find("input[name=saleid]").val($(this).attr("data-id"));
        $("#deletesale").modal("show");

    });


    /*
    * Create jobcard
    */
    $("body").on("click", ".mark-as-paid", function(event){
        event.preventDefault();

        $("#markaspaid").find(".close-sale-total").text($(this).attr("data-total"));
        $("#markaspaid").find("input[name=saleid]").val($(this).attr("data-id"));
        $("#markaspaid").modal("show");

    });

    /*
    * Number format
    */
    function number_format (number, decimals, dec_point, thousands_sep) {
        // Strip all characters but numerical ones.
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    /*
    * Initislize Datatable
    */
    if ($(".datatable")) {
        $(".datatable").dataTable({
            language: { search: "", lengthMenu: "_MENU_" },
        });
    }

    return { initPhoneInput, createsale }

})(jQuery);