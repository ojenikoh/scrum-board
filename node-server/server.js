/**
 * Simple socket server for the scrum board, passes events on to all connected clients on a board
 * excluding the originator
 */

var io = require('socket.io').listen(8080);

io.sockets.on('connection', function (socket) {
  
    //Allow clients to subscribe to a specific board
    socket.on('subscribe', function(data) { 
        socket.join(data);     
    });
  
    //Allow clients to unsubscribe from a board
    socket.on('unsubscribe', function(data) { 
        socket.leave(data); 
    });
     
    //Editing a ticket
    socket.on('ticket:change', function (room, ticket) {
        io.sockets.in(room).except(socket.id).emit('ticket:change', ticket);
    });
    
    //Moving a ticket between stories
    socket.on('ticket:move', function (room, ticket, originStoryId) {
        io.sockets.in(room).except(socket.id).emit('ticket:move', ticket, originStoryId);
    });
  
    //Adding a new ticket
    socket.on('ticket:create', function (room, ticket) {
        io.sockets.in(room).except(socket.id).emit('ticket:create', ticket);
    });
  
    //Deleting a ticket
    socket.on('ticket:delete', function (room, ticketId) {
        io.sockets.in(room).except(socket.id).emit('ticket:delete', ticketId);
    });
});