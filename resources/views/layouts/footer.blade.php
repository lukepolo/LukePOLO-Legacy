<footer class="footer">
    <div class="container">
        <div class="col-md-2 col-md-offset-2">
        </div>
        <div class="col-md-2">
            <a target="_blank" href="https://www.digitalocean.com/">
                <img src="http://lukepolo.com/assets/img/digital_ocean/digitalocean-badge-white.png?1424209025">
            </a>
        </div>
        <div class="col-md-2">
        </div>
    </div>
</footer>
<script src="https://cdn.socket.io/socket.io-1.3.5.js"></script>
<script type="text/javascript">
    @if($app->environment() == 'development')
        if (localStorage.debug != 'socket.io-client:socket')
        {
            console.log('You must reload to see socket.io messages!');
            localStorage.debug='socket.io-client:socket';
        }
    @endif
    var socket = io.connect('{{ url("/") }}:{{ env("NODE_SERVER_PORT") }}');

    socket.emit('change_location', '{{ \Request::url() }}', '{{ \Session::getId() }}' );

    socket.on('user-join', function(data)
    {
        console.log(data);
    });
</script>