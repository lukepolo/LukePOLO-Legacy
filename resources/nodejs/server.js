var base_path = __dirname.replace('resources/nodejs', '');

require('dotenv').config({
    path: base_path +'.env'
});

var
    env = process.env,
    port = env.NODE_SERVER_PORT,
    redis = require('ioredis'),
    redis_socket = new redis(),
    redis_broadcast = new redis(),
    cookie = require('cookie'),
    crypto = require('crypto'),
    PHPUnserialize = require('php-unserialize'),
    fs = require('fs'),
    server = null,
    offline_timeout = {},
    users = {};

if (env.APP_ENV == 'production') {
    console.log('removing console log');
    console.log = function () {
    };
}

redis_broadcast.psubscribe('*', function (err, count) {

});

redis_broadcast.on('pmessage', function (subscribed, channel, message) {
    message = JSON.parse(message);

    console.log(message);
    io.emit(channel, message.data);
});

if (env.NODE_HTTPS == 'yes') {
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

var admin_room = env.ADMIN_ROOM;

io.use(function (socket, next) {

    if (typeof socket.request.headers.cookie != 'undefined') {
        redis_socket.get('lukepolo:' + decryptCookie(
                cookie.parse(
                    socket.request.headers.cookie
                ).lukepolo_session
            ), function (error, result) {
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
});

io.on('connection', function (socket) {

    if(socket.request.headers.cookie) {
        var session_id = decryptCookie(cookie.parse(socket.request.headers.cookie).lukepolo_session);
        clearTimeout(offline_timeout[session_id]);
        var url = socket.request.headers.referer;
        socket.join(url);
        users[session_id] = url;
        if (io.sockets.adapter.rooms.hasOwnProperty(admin_room)) {
            io.to(admin_room).emit('users', users);
        }
    }

    socket.on('disconnect', function () {
        if (socket.user_id) {
            offline_timeout[socket.user_id] = setTimeout(
                function () {
                    console.log('user ' + socket.user_id + ' disconnected');
                    delete users[socket.user_id]
                    if (io.sockets.adapter.rooms.hasOwnProperty(admin_room)) {
                        io.to(admin_room).emit('users', users);
                    }
                }, 15000
            );
        }
    });

    socket.on('get_users', function () {
        io.to(admin_room).emit('users', users);
    });

    socket.on('create_comment', function (data) {
        if (io.sockets.adapter.rooms.hasOwnProperty(admin_room)) {
            io.to(admin_room).emit('create_comment', data.comment_id);
        }

        io.to(data.room).emit('create_comment', data.comment_id, data.parent_id);
    });

    socket.on('update_comment', function (data) {
        if (io.sockets.adapter.rooms.hasOwnProperty(admin_room)) {
            io.to(admin_room).emit('update_comment', data.comment_id, data.comment);
        }

        io.to(data.room).emit('update_comment', data.comment_id, data.comment);
    });

    socket.on('delete_comment', function (data) {
        if (io.sockets.adapter.rooms.hasOwnProperty(admin_room)) {
            io.to(admin_room).emit('delete_comment', data.comment_id);
        }

        io.to(data.room).emit('delete_comment', data.comment_id);
    });

    socket.on('update_votes', function (data) {
        io.to(data.room).emit('update_votes', data.comment_id, data.votes);
    });
});

function decryptCookie(cookie) {
    if (cookie) {
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
