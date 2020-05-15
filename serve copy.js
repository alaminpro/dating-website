var fs = require("fs"); 
var express    = require("express");
var app = express(); 
var https = require('https');  
 
function read(f) {return fs.readFileSync(f).toString();} 
 

var pkey = fs.readFileSync('/home/datev2/public_html/certificates/server.key');
var pcert = fs.readFileSync('/home/datev2/public_html/certificates/final.crt')

var SERVER_PORT = 8080;
 var options = {
    hostname: 'datev2.com',
    port: 8080,  
    key: pkey, 
    cert: pcert,
    requestCert: true,
    rejectUnauthorized: false,
};

app.get('/a', function(req, res){
    res.send('asdfs');
})

var server = https.createServer(options, app).listen(SERVER_PORT, function(){
    console.log("Express server listening on port " + SERVER_PORT);
  });  

var io = require('socket.io').listen(server);
 
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
});
 