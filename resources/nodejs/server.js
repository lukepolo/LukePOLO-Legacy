var base_path = __dirname.replace('resources/nodejs', '');
require('dotenv').config({
    path: base_path+'.env'
});

server = require('http').createServer();
io = require('socket.io')(server);

server.listen(process.env.NODE_SERVER_PORT, function()
{
    console.log('listening on '+ process.env.NODE_SERVER_PORT);
});

var users = {};
offline_timeout = {};

io.on('connection', function (socket)
{
    socket.on('get_users', function()
    {
        io.to(socket.id).emit('users', users);
    });

    socket.on('change_location', function (location, user)
    {

        clearTimeout(offline_timeout[user.session]);

        socket.user = user.session;
        users[socket.user] = location;

        // From node join the location
        socket.join(location);

        io.emit('users', users);
    });

    socket.on('disconnect', function ()
    {
        if (socket.user)
        {
            socket.leave(users[socket.user]);

            // Make them offline after a certain point
            offline_timeout[socket.user] = setTimeout(
                function ()
                {
                    delete users[socket.user];
                    io.emit('users', users);
                }, 10000
            );
        }
    });

    socket.on('create_comment', function(data)
    {
        io.to(data.room).emit('create_comment', data.comment_id, data.parent_id);
    });

    socket.on('update_comment', function(data)
    {
        io.to(data.room).emit('update_comment', data.comment_id, data.comment);
    });

    socket.on('delete_comment', function(data)
    {
        io.to(data.room).emit('delete_comment', data.comment_id);
    });

    socket.on('update_votes', function(data)
    {
        io.to(data.room).emit('update_votes', data.comment_id);
    });
});