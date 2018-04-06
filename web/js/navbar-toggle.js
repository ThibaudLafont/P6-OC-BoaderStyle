// Hide all blocks with openbox class attribute (all are subjects for slide up accordion display
$('.openbox').hide();

// Detect and put a timer on flash-messages for hide them
$('.flash').delay(5000).fadeOut( 500 );

// Openbox function for navbar
function opennavbar(){
    if($('#navbar .openbox').is(':visible')){
        $('#navbar .openbox').hide();
    }else{
        $('#navbar .openbox').show();
    }
}

// Hide cookie warning on click
function hideCookieBox(){
    $('#cookies_warning').hide();
}