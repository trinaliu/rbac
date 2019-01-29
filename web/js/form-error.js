/*jshint esversion: 6 */
$(function(){
    "use strict";
    $.error = function(inputName, message) {
        const selector = $("input[name="+inputName+"]");
        selector.next(".help-block").empty().append(message);
        selector.parents(".form-group").addClass("has-error");
    };

    $("input").on("blur", function(){
        const value = $(this).val();
        if (value) {
            $(this).next(".help-block").empty();
            $(this).parents(".form-group").removeClass("has-error");
        }
    });

    $("textarea").on("blur", function(){
        const value = $(this).val();
        if (value) {
            $(this).next(".help-block").empty();
            $(this).parents(".form-group").removeClass("has-error");
        }
    });
});