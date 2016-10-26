var base_path = __dirname.replace('resources/nodejs', '');

require('dotenv').config({
    path: base_path + '.env'
});

var env = process.env,
    port = env.NODE_SERVER_PORT,
    ioredis = require('ioredis'),
    redis_socket = new ioredis(),
    redis_broadcast = new ioredis(),
    cookie = require('cookie'),
    crypto = require('crypto'),
    PHPUnserialize = require('php-serialize'),
    fs = require('fs'),
    server = null,
    offlineTimeout = {},
    users = {},
    adminRoom = env.ADMIN_ROOM;

if (env.APP_DEBUG !== 'true') {
    console.log = function () {};
}

if (env.NODE_HTTPS === 'true') {
    console.log("HTTPS");
    server = require('https').createServer({
        key: fs.readFileSync(env.SSL_KEY),
        cert: fs.readFileSync(env.SSL_CERT),
        ca : fs.readFileSync(env.SSL_CA),
    });
} else {
    server = require('http').createServer();
}

console.log('Server on Port : ' + port);
server.listen(port);
var io = require('socket.io')(server);

redis_broadcast.psubscribe('*', function (err, count) {});
redis_broadcast.on('pmessage', function (fromSubscription, channel, message) {
    console.log(message);
    data = JSON.parse(message).data;
    if (data.rooms) {
        data.rooms.forEach(function (room) {
            if (io.sockets.adapter.rooms.hasOwnProperty(room)) {
                io.to(room).emit(channel, data);
            }
        });
    } else {
        io.emit(channel, data);
    }
});

io.use(function (socket, next) {
    if (typeof socket.request.headers.cookie != 'undefined') {
        redis_socket.get(getLaravelSessionIDFromCookie(socket.request.headers.cookie), function (error, session) {
            if (error) {
                console.log('ERROR :' + error);
            } else {

                var userIdentifier = getUserIDFromSession(session) || socket.handshake.address;

                socket.join(users[userIdentifier] = socket.request.headers.referer);
                clearTimeout(offlineTimeout[userIdentifier]);

                console.log(userIdentifier + ' logged in : joined ' + users[userIdentifier]);

                if (io.sockets.adapter.rooms.hasOwnProperty(adminRoom)) {
                    io.to(adminRoom).emit('users', users);
                }

                socket.on('disconnect', function () {
                    console.log(userIdentifier + ' disconnected');
                    socket.leave(users[userIdentifier]);
                    offlineTimeout[userIdentifier] = setTimeout(
                        function () {
                            console.log(userIdentifier + ' user left');
                            delete users[userIdentifier];
                            if (io.sockets.adapter.rooms.hasOwnProperty(adminRoom)) {
                                io.to(adminRoom).emit('users', users);
                            }
                        }, 3000
                    );
                });
                next();
            }
        });
    } else {
        console.log('Not Authorized');
        next(new Error('Not Authorized'));
    }
});

io.on('connection', function (socket) {
    socket.on('get_users', function () {
        io.to(adminRoom).emit('users', users);
    });
});

function getLaravelSessionIDFromCookie(SocketCookie)
{
    if(cookie.parse(SocketCookie).hasOwnProperty(env.APP_SESSION_COOKIE_NAME)) {
        return env.APP_CACHE_PREFIX + ':' + decryptLaravelCookie(cookie.parse(SocketCookie)[env.APP_SESSION_COOKIE_NAME]);
    }
}

function decryptLaravelCookie(cookie) {
    if (cookie) {
        var parsedCookie = JSON.parse(new Buffer(cookie, 'base64'));

        var iv = new Buffer(parsedCookie.iv, 'base64');
        var value = new Buffer(parsedCookie.value, 'base64');

        var decipher = crypto.createDecipheriv('aes-256-cbc', env.APP_KEY, iv);

        var resultSerialized = Buffer.concat([
            decipher.update(value),
            decipher.final()
        ]);

        return PHPUnserialize.unserialize(resultSerialized.toString('utf8'));
    }
}

function getUserIDFromSession(session) {
    if(session) {
        try {
            var decryptedSession = PHPUnserialize.unserialize(decryptLaravelCookie(PHPUnserialize.unserialize(session).toString('utf8')), {}, {strict: false});
            if (decryptedSession.hasOwnProperty('userID')) {
                return decryptedSession.userID;
            }
        } catch(e) {
            console.log('Session data has object, cannot deserialize', e);
        }
    }
}
