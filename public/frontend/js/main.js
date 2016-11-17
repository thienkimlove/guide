/**
 * Created by TonyVN on 05/03/2016.
 */


$( document ).ready(function() {
    var srw = $( window ).width();
    if(srw > 1024){
        $('.wrapper').width(srw/2.5);
    }
    else
    {
        $('.wrapper').width(srw);
        $('#video').width(srw);
    }

});