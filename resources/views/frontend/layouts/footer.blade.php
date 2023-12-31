

<script src="{{url('frontend/js/script.js')}}"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> -->
<script>
    $(document).ready(function(){
        getMessage();
        
        $('#messageSent').on('submit',function(e){
            e.preventDefault();
            jQuery.ajax({
                url:"{{url('/message-sent')}}",
                data:jQuery('#messageSent').serialize(),
                type:'post',
                
                success:function(response)
                {
                    jQuery('#messageSent')[0].reset();
                    getMessage();
                }
            });


        });
        function getMessage(){
            var id = {{request('id')}}
            $.ajax({
            type: 'GET',
            url: '/chat/'+id, 
            success: function (data) {
                $('#messageContainer').empty();
                $.each(data.messages, function(key,item){
                    var messageClass = item.user_id === {{session('user_id')}}? 'bg-dark': 'bg-secondary';
                    var messageStyle = item.user_id === {{session('user_id')}}? 'margin-left:auto;': '';
                    $('#messageContainer').append('<div class="message '+messageClass+' px-2 py-1 mb-3  mt-3 rounded " style="width:max-content;'+messageStyle+'max-width:75%;">\
                        <p class="text-center text-white">'+item.message+'</p>\
                        </div>');
                    $("#messageContainer").scrollTop($("#messageContainer")[0].scrollHeight);

                });
            },
            error: function (xhr, status, error) {
            console.error('Error fetching data:', error);
            }
            });
        }


            function fetchData() {
            var id = {{request('id')}}
            $.ajax({
            type: 'GET',
            url: '/chat/'+id, 
            success: function (data) {
                $('#messageContainer').empty();
                $.each(data.messages, function(key,item){
                    var messageClass = item.user_id === {{session('user_id')}}? 'bg-dark': 'bg-secondary';
                    var messageStyle = item.user_id === {{session('user_id')}}? 'margin-left:auto;': '';
                    var imageClass = item.user_id === {{session('user_id')}}?'position-absolute end-0': 'position-absolute start-10';
                    $('#messageContainer').append('<div class"position-relative" style="width:max-content;'+messageStyle+'max-width:75%;">\
                    <div class="message '+messageClass+' px-2 py-1 mb-3  mt-3 rounded " >\
                        <p class="text-center text-white">'+item.message+'</p>\
                        </div></div>');
                });
            },
            error: function (xhr, status, error) {
            console.error('Error fetching data:', error);
            }
            });
            }

            // Call the fetchData function initially
            // fetchData();

            // Set up a recurring timer to fetch data every 3 seconds (3000 milliseconds)
            setInterval(fetchData, 3000);


    });
</script>
</body>
</html>