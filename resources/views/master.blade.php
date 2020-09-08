<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{asset('js/jquery-ui.min_1.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
    @yield('content')
</body>
<script>
$(document).ready(function(){
    $("#myBtn").click(function(){
        $("#myModal").modal();
    });
});
</script>
<script>
$(document).ready(function(){
    $(".show-cd").click(function(){
        var max = 0;
        $('.show-cd').each(function() {
            var value = parseInt($(this).data('id'));
            max = (value > max) ? value : max;
        });

        for (var i = 1; i <= max; i++) {
            $(".hidden" + i).removeClass('hidden');
        }
        
        $(".show-more").removeClass('hidden');
        $(".number-cd").addClass('hidden');
    });
});
</script>
<script type="text/javascript">
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $( ".row_position" ).sortable({
        delay: 50,
        stop: function() {
            var selectedData = new Array();
            $('.row_position>tr').each(function() {
                selectedData.push($(this).attr("id"));
            });
            updateOrder(selectedData);
        }
    });

    function updateOrder(data) {
        $.ajax({
            url:"/ajaxmove",
            type:'post',
            data:{position:data},
            success:function(){
                alert('Đổi thứ tự thành công');
            }
        })
    }
</script>
</html>