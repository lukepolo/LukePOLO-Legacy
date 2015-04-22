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
        console.log('Get Users : ' + socket.user);
        io.to(socket.id).emit('users', users);
    });

    socket.on('change_location', function (location, user)
    {

        clearTimeout(offline_timeout[user]);

        socket.user = user;
        users[socket.user] = location;

        console.log('User Joining ' + location);
        // From node join the location
        socket.join(location);

        io.emit('users', users);
    });

    socket.on('disconnect', function ()
    {
        if (socket.user)
        {
            console.log('User Leaving ' + users[socket.user]);
            socket.leave(users[socket.user]);

            // Make them offline after a certain point
            offline_timeout[socket.user] = setTimeout(
            function()
            {
                console.log('disconnected ' + socket.user);
                delete users[socket.user];
                io.emit('users', users);
            }, 5000);
        }
    });

    socket.on('create_comment', function(data)
    {
        console.log('Trying to create comment');
        io.to(data.room).emit('create_comment', data.html, data.parent_id);
    });

    socket.on('update_comment', function(data)
    {
        console.log('Trying to update comment');
        io.to(data.room).emit('update_comment', data.comment_id, data.comment);
    });

    socket.on('delete_comment', function(data)
    {
        console.log('Trying to delete comment');
        io.to(data.room).emit('delete_comment', data.comment_id);
    });
});