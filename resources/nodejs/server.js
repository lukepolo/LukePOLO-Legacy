var base_path = __dirname.replace('resources/node', '');

require('dotenv').config({
    path: base_path +'.env'
});

var
    env = process.env,
    port = env.NODE_SERVER_PORT,
    redis = require('ioredis'),
    redis_client = new redis(),
    redis_broadcast = new redis(),
    cookie = require('cookie'),
    crypto = require('crypto'),
    PHPUnserialize = require('php-unserialize'),
    fs = require('fs'),
    server = null,
    offline_timeout = {},
    users = {};


if(env.APP_ENV == 'production') {
    console.log = function(){};
}

redis_broadcast.psubscribe('*', function(err, count) {

});

redis_broadcast.on('pmessage', function(subscribed, channel, message) {
    message = JSON.parse(message);

    console.log(message);
    io.emit(channel, message.data);
});

if(env.NODE_HTTPS == 'yes') {
    console.log("HTTPS");
    server = require('https').createServer({
        key: fs.readFileSync(env.SSL_KEY),
        cert: fs.readFileSync(env.SSL_CERT)
    });
} else {
    server = require('http').createServer();
}
console.log('Server on Port : ' + port);
server.listen(port);
var io = require('socket.io')(server);

io.use(function(socket, next) {

    if(typeof socket.request.headers.cookie != 'undefined') {
        redis_client.get('forcebook:' + decryptCookie(
                cookie.parse(
                    socket.request.headers.cookie
                ).forcebook_rid
            ), function(error, result) {
            if (error) {
                console.log('ERROR');
                next(new Error(error));
            }
            else if (result) {
                console.log('Logged In');
                next();
            }
            else {
                console.log('Not Authorized');
                next(new Error('Not Authorized'));
            }
        });
    } else {
        console.log('Not Authorized');
        next(new Error('Not Authorized'));
    }
})
io.on('connection', function (client)
{
    socket.on('user_info', function (user_info) {

        clearTimeout(offline_timeout[user_info.id]);

        if(!users[user_info.id]) {
            socket.user_id = user_info.id;
        }
        else {
            socket.leave(users[user_info.id].location);
            users[user_info.id].location = user_info.location;
        }

        console.log('user joined '+user_info.location);

        socket.join(user_info.location);
    });

    socket.on('disconnect', function () {
        if (socket.user_id) {
            offline_timeout[socket.user_id] = setTimeout(
                function() {
                    console.log('user ' + socket.user_id + ' disconnected');
                    delete users[socket.user_id]
                    if (io.sockets.adapter.rooms.hasOwnProperty(admin_room))
                    {
                        io.to(admin_room).emit('users', users);
                    }
                }, 15000
            );
        }
    });

    client.on('get_users', function()
    {
        io.to(admin_room).emit('users', users);
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
    if(cookie) {
        var parsedCookie = JSON.parse(new Buffer(cookie, 'base64'));

        var iv = new Buffer(parsedCookie.iv, 'base64');
        var value = new Buffer(parsedCookie.value, 'base64');

        var decipher = crypto.createDecipheriv('aes-256-cbc', env.APP_KEY, iv);

        var resultSerialized = Buffer.concat([
            decipher.update(value),
            decipher.final()
        ]);

        return PHPUnserialize.unserialize(resultSerialized);
    }
}