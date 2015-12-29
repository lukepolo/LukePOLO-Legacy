var base_path = __dirname.replace('resources/nodejs', '');

require('dotenv').config({
    path: base_path+'.env'
});

var port = process.env.NODE_SERVER_PORT,
redis = require('redis'),
cookie = require('cookie'),
MCrypt = require('mcrypt').MCrypt,
PHPUnserialize = require('php-unserialize'),
fs = require('fs');

if(process.env.NODE_HTTPS == 'true') {
    server = require('https').createServer({
        key:    fs.readFileSync(process.env.SSL_KEY),
        cert:   fs.readFileSync(process.env.SSL_CERT),
    });
} else {
    server = require('http').createServer();
}


io = require('socket.io')(server);

server.listen(port, function()
{
    console.log('listening on '+ port);
});

var admin_room =  process.env.ADMIN_ROOM;

var users = {};
var offline_timeout = {};

io.on('connection', function (client)
{
    if(client.request.headers.cookie)
    {
        var session_id = decryptCookie(cookie.parse(client.request.headers.cookie).lukepolo_session);

        clearTimeout(offline_timeout[session_id]);

        var url = client.request.headers.referer;

        client.join(url);

        users[session_id] = url;

        if (io.sockets.adapter.rooms.hasOwnProperty(admin_room))
        {
            io.to(admin_room).emit('users', users);
        }
    }
    
    client.on('get_users', function()
    {
        io.to(admin_room).emit('users', users);
    });

    client.on('disconnect', function ()
    {
        client.leave(url);
        if(users[session_id])
        {
            // Make them offline after a certain point
            offline_timeout[session_id] = setTimeout(
                function ()
                {
                    delete users[session_id];
                    if (io.sockets.adapter.rooms.hasOwnProperty(admin_room))
                    {
                        io.to(admin_room).emit('users', users);
                    }
                }, 10000
            );
        }

    });

    client.on('create_comment', function(data)
    {
        if(io.sockets.adapter.rooms.hasOwnProperty(admin_room))
        {
            io.to(admin_room).emit('create_comment', data.comment_id);
        }

        io.to(data.room).emit('create_comment', data.comment_id, data.parent_id);
    });

    client.on('update_comment', function(data)
    {
        if(io.sockets.adapter.rooms.hasOwnProperty(admin_room))
        {
            io.to(admin_room).emit('update_comment', data.comment_id, data.comment);
        }

        io.to(data.room).emit('update_comment', data.comment_id, data.comment);
    });

    client.on('delete_comment', function(data)
    {
        if(io.sockets.adapter.rooms.hasOwnProperty(admin_room))
        {
            io.to(admin_room).emit('delete_comment', data.comment_id);
        }

        io.to(data.room).emit('delete_comment', data.comment_id);
    });

    client.on('update_votes', function(data)
    {
        io.to(data.room).emit('update_votes', data.comment_id, data.votes);
    });
});

function decryptCookie(cookie)
{
    var parsed_cookie = JSON.parse(new Buffer(cookie, 'base64'));

    var iv = new Buffer(parsed_cookie.iv, 'base64');
    var value = new Buffer(parsed_cookie.value, 'base64');
    var key = "Hm#s.yLK3@rT3z89>^4XX)$Rsqwp,+=z";

    var rijCbc = new MCrypt('rijndael-256', 'cbc');
    rijCbc.open(key, iv);

    var decrypted = rijCbc.decrypt(value).toString();

    var len = decrypted.length - 1;
    var pad = decrypted.charAt(len).charCodeAt(0);

    return PHPUnserialize.unserialize(decrypted.substr(0, decrypted.length - pad));
}