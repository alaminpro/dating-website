var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
// var port = process.env.PORT || 2888;

io.on('connection', function(socket){ 
    socket.on('send-message', function(data){
        socket.broadcast.emit('receive-message', data);
    });
    socket.on('typing-message', function(data){
        socket.broadcast.emit('receive-typing-message', data);
    });
    socket.on('stop-typing', function(data){
        socket.broadcast.emit('receive-stop-typing', data);
    });
    socket.on('seen-all-message', function(data){
        socket.broadcast.emit('seen-all-message', data);
    });
    socket.on('seen-message', function(data){
        socket.broadcast.emit('seen-message', data);
    });
    socket.on('delete_conversation', function(data){
        socket.broadcast.emit('delete_conversation', data);
    });
    socket.on('call-incoming', function(data){
        socket.broadcast.emit('call-incoming', data);
    });
    socket.on('reject-call', function(data){
        socket.broadcast.emit('reject-call', data);
    });
    socket.on('camera-not-found', function(data){
        socket.broadcast.emit('camera-not-found', data);
    });
    socket.on('cancel-call', function(data){
        socket.broadcast.emit('cancel-call', data);
    });
    socket.on('notifications', function(data){
        socket.broadcast.emit('notifications', data);
    });
});
 
http.listen(8000, '127.0.0.1', function(){
    console.log('listening on *:' + 8000);
});