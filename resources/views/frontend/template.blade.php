<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">
    <link rel="shortcut icon" href="{{url('frontend/favicon.ico')}}">
    <title>Game guide</title>
    <!-- Sweet Alert CSS -->
    <link href="{{url('frontend/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{url('frontend/css/jquery-ui.css')}}">
    <link href="{{url('frontend/css/style.css')}}" rel="stylesheet" type="text/css">


    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<div class="wrapper">


    <div class="header">
        <div class="searchbox">
            <input placeholder="Tìm kiếm tướng" id="championsearch">
        </div>
    </div>
    <div class="clearfix"></div>

    <div id="content">
    @yield('content')
    </div>
    <div class="clearfix"></div>
</div>
<!-- Modal -->
@yield('modal')
<div style="display: none">
    <a href="#" data-toggle="modal" id="notice" data-target="#myModal">Click</a>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    Thông báo</h4>
            </div>
            <div class="modal-body">
                <p>Chưa có guide cho vị tướng này</p>
            </div>

        </div>
    </div>
</div>
<script src="{{url('frontend/js/jquery.min.js')}}"></script>
<script src="{{url('frontend/js/bootstrap.min.js')}}"></script>

<script src="{{url('frontend/js/jquery-1.12.4.js')}}"></script>
<script src="{{url('frontend/js/jquery-ui.js')}}"></script>
<script src="{{url('frontend/js/main.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=csrf_token]').attr('content') }
    });
    var baseUrl = "{{url('/')}}";

</script>
<script>

    jQuery(function(){
        jQuery( "#championsearch" ).autocomplete({
            source: function( request, response ) {
                jQuery.ajax({
                    dataType: "json",
                    type : 'Get',
                    data: "q=" + request.term,
                    url: baseUrl + '/ajax',
                    success: function(data) {
                        response( jQuery.map(data, function(item) {
                            return {
                                label : item.title,
                                value : item.title,
                                id : item.id,
                                image : item.image,
                            }
                        }));
                    }
                });
            },

            select: function (event, ui) {

                jQuery.get(baseUrl + '/ajaxChamp/' + ui.item.id, function(res){
                    if (res) {
                        jQuery('#content').html(res);
                    } else {
                        jQuery.noConflict();
                        $('#myModal').modal('show');
                    }
                });

            }
        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
            return jQuery( "<li>" )
                    .data( "item.autocomplete", item )
                    .append( "<div><img src='" + baseUrl + "/img/cache/49x47/" + item.image + "'/>" + item.label + "</div>" )
                    .appendTo( ul );
        };
    });
</script>

</body>

</html>