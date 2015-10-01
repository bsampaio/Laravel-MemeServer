@extends('layouts.wizard.base')

<?php
/**
 * Created by PhpStorm.
 * User: criativa
 * Date: 01/10/15
 * Time: 14:08
 */

$encrypter = app('Illuminate\Encryption\Encrypter');
$encrypted_token = $encrypter->encrypt(csrf_token());

?>

@section('custom-styles')
    @parent
    <style>
        img.image_picker_image {
            width: 165px;
        }
        #selected-img {
            margin: 0 auto;
            text-align: center;
            width: 61%;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        img.center {
            margin: 0 auto;
        }
    </style>
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="{{asset('css/social-buttons.css')}}" rel="stylesheet" />
@endsection

@section('content')
    <a class="btn" href="https://github.com/amoffat/bootstrap-application-wizard">Back to docs</a>
    <button id="open-wizard" class="btn btn-primary">
        Open wizard
    </button>

    <div class="wizard" id="satellite-wizard" data-title="Criar Meme">

        @include('images.partials.selector')

        @include('images.partials.editor')
    </div>

    @section('custom-scripts')
        <script src="{{asset('js/image-picker.min.js')}}"></script>

        <script type="text/javascript">
            jQuery(document).ready(function() {

                function removeSelected() {
                    $('ul.thumbnails li div').toArray().forEach(function(e){
                        $(e).removeClass("selected");
                    });
                }

                jQuery.fn.wizard.logging = true;
                var wizard = jQuery('#satellite-wizard').wizard({
                    keyboard : true,
                    contentHeight : 700,
                    contentWidth : 1000,
                    backdrop: 'static'
                });

                wizard.on('hide', removeSelected);

                wizard.on('closed', function() {
                    wizard.reset();
                });

                wizard.on("reset", function() {
                    wizard.modal.find(':input').val('').removeAttr('disabled');
                    wizard.modal.find('.form-group').removeClass('has-error').removeClass('has-success');

                });

                wizard.on("submit", function(wizard) {
                    var submit = {
                        "image" : jQuery("select#images").val(),
                        "top"   : jQuery('input#top-text').val(),
                        "bottom": jQuery('input#bottom-text').val()
                    };

                    jQuery.ajax({
                        type    : "POST",
                        url     : "{{route('image.store')}}",
                        data    : submit,
                        success : function(data) {
                            wizard.trigger("success");
                            wizard.hideButtons();
                            wizard._submitting = false;
                            wizard.showSubmitCard("success");
                            wizard.updateProgressBar(0);
                            jQuery('#success-message').html(data.message);
                            jQuery('#success-image').attr('src', data.image_src);
                            jQuery('a#download-button').attr('href', data.image_src);

                            $('.btn-facebook').click(function(){
                               var baseUrl = 'https://facebook.com/sharer.php?u=';
                               window.open(baseUrl + data.image_src);
                            });

                            $('.btn-twitter').click(function(){
                                var baseUrl = 'https://twitter.com/intent/tweet?url=';
                                var text = "&text=" + "Vejam o meme que criei!";
                                var via  = "&via=" + "faesa";
                                window.open(baseUrl + data.image_src);
                            });

                            $('.btn-google-plus').click(function(){
                                var baseUrl = 'https://plus.google.com/share?url=';
                                window.open(baseUrl + data.image_src);
                            });
                        },
                        error   : function(data){
                            jQuery('#error-message').html(data.responseText);
                            wizard.trigger("error");
                            wizard._submitting = false;
                            wizard.showSubmitCard("error");
                            wizard.updateProgressBar(0);
                        }
                    })
                });

                wizard.el.find(".wizard-success .im-done").click(function() {
                    wizard.hide();
                    setTimeout(function() {
                        wizard.reset();
                    }, 250);
                });

                wizard.el.find(".wizard-error .im-done").click(function() {
                    wizard.hide();
                    setTimeout(function() {
                        wizard.reset();
                    }, 250);
                });

                jQuery('#open-wizard').click(function(e) {
                    e.preventDefault();
                    wizard.show();
                });

                jQuery('button.wizard-next').click(function(){
                    var images  = jQuery('#images');
                    var selected = images.find('option:selected');
                    jQuery('img#selected-img').attr('src', jQuery(selected).attr('data-img-src'));
                });

                wizard._cards[0].on("selected", removeSelected);
            });
        </script>
        <script>
            jQuery(document).ready(function(){
                jQuery('#images').imagepicker();
            });
        </script>
    @endsection
@endsection