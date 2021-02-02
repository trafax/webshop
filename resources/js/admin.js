/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.sortable = require('jquery-ui/ui/widgets/sortable');

var tinymce = require('tinymce/tinymce');
require('tinymce/icons/default');
require('tinymce/themes/silver');

toggle = function(source) {
    var checkboxes = document.querySelectorAll('.check');
    for (var i = 0; i < checkboxes.length; i++) {
        if(source.is(":checked") == true) {
            checkboxes[i].checked = true;
        } else {
            checkboxes[i].checked = false;
        }
    }
}

window.sort = function()
{
    $('.sortable').sortable({
        delay: 300,
        axis: "y",
        helper: 'clone',
        helper: function (e, ui) {
            ui.children().each(function () {
                $(this).width($(this).width());
            });
            return ui;
        },

        update: function( event, ui ) {

           var action = $(this).data('action');
           var data = $(this).sortable('toArray');

           $.ajax({
              headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              data: {'items' : data},
              url: action,
              type: 'POST',
              success: function(response){},
              dataType: 'json'
           });
        }
     });
}

$(function(){

    window.sort();

    tinymce.init({
        selector: '.editor',
        language: 'nl'
    });

    $('#check-all').on('click', function(){
        var checkboxes = document.querySelectorAll('.check');
        for (var i = 0; i < checkboxes.length; i++) {
            if($(this).is(":checked") == true) {
                checkboxes[i].checked = true;
            } else {
                checkboxes[i].checked = false;
            }
        }
    });

    $('.selected').on('change', function(){

        var checkboxes = document.querySelectorAll('.check');
        var ids = [];
        for (var i = 0; i < checkboxes.length; i++) {
            if($(checkboxes[i]).is(':checked') == true) {
                ids.push($(checkboxes[i]).val());
            }
        }

        if (ids) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: $(this).val(),
                data: {ids: ids},
                dataType: "html",
                success: function (response) {
                    window.location.reload();
                }
            });
        }

        $(this).prop('selectedIndex', 0);
    });

    $('[data-delete]').on('click', function(){
        if (confirm('Verwijderen?')) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "DELETE",
                url: $(this).attr('href'),
                dataType: "html",
                success: function (response) {
                    window.location.href = response;
                }
            });
        }
        return false;
    });

    if (window.location.hash) {
        $('a[href="' + window.location.hash + '"]').tab('show');
        $('[name="hash"]').val(window.location.hash);
    }

    $('[data-bs-toggle]').on('click', function(){
        window.location.hash = $(this).attr('href');
        $('[name="hash"]').val($(this).attr('href'));
    });
})
