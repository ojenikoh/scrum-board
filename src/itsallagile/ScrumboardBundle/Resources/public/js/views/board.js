/**
 * Board view
 */
itsallagile.View.Board = Backbone.View.extend({
    
    tagName: 'table',
    className: 'board',
    statuses: [],
    statusHeaderView: null,
    storyViews: {},
    
    
    /**
     * Load the fixed elements on the board
     * and do initial bindings
     */
    initialize: function(options) { 
        this.statuses = options.statuses;
        this.statusHeaderView = new itsallagile.View.StatusHeader({statuses : this.statuses});
        this.model.bind('change', this.render, this);
        var stories = this.model.get('stories')
        stories.bind('add', this.render, this);
        stories.bind('remove', this.render, this);
        stories.bind('reset', this.render, this);        

        _.bindAll(this);
        
        return this;
    },
    
    /**
     * Bind to events coming in from the socket connection
     * We do this at board level as it has the easiest access
     * to sub objects
     */
    bindSocketEvents: function() {
        var socket = itsallagile.socket;        
        if (typeof socket !== 'undefined') {
            socket.on('ticket:change', this.onRemoteTicketChange);
            socket.on('ticket:move', this.onRemoteTicketMove);
            socket.on('ticket:create', this.onRemoteTicketCreate);
            socket.on('ticket:delete', this.onRemoteTicketDelete);
        }
    },
    
    /**
     * Render the board by rendering its toolbar and header
     * and calling render on all stories
     */
    render: function() {      
        this.$el.html('');
        this.$el.append($('<thead>').append(this.statusHeaderView.render().el));
        var stories = this.model.get('stories');
        if (stories !== null) {
            stories.forEach(function(story, key) {
                var storyView = new itsallagile.View.Story({model: story, statuses: this.statuses});
                storyView.on('moveTicket', this.onMoveTicket, this);
                storyView.on('deleteStory', this.onDeleteStory, this);
                this.storyViews[story.get('id')] = storyView;                
                this.$el.append(storyView.render().el);
            }, this);
        }
        
        return this;
    }, 
    
    /**
     * Handle moving a ticket between stories
     * Looks at bit hacky, but I couldnt find an easier way
     * of moving an object between collections
     */
    onMoveTicket: function(ticketCid, originStoryId, status, newStoryId) {
        var stories = this.model.get('stories');
        var originStory = stories.get(originStoryId);
        var newStory = stories.get(newStoryId);
        var oldTicket = originStory.get('tickets').getByCid(ticketCid);
        var newTicket = new itsallagile.Model.Ticket(oldTicket.toJSON());
        
        newTicket.set('story', newStoryId);
        newTicket.set('status', status);
        newTicket.save(null, {success: this.onMoveSuccess});
        newStory.get('tickets').add(newTicket);
        originStory.get('tickets').remove(oldTicket);    
        if (typeof itsallagile.socket !== 'undefined') {
            itsallagile.socket.emit('ticket:move', itsallagile.roomId, newTicket, originStoryId);
        }
    },
    
    
    //REMOTE EVENTS
    //--------------------------------------------------------
    
    /**
     * Handle a ticket moved between stories by another user
     */
    onRemoteTicketMove: function(ticket, originStoryId) {
        console.log(ticket);
        var stories = this.model.get('stories');
        var originStory = stories.get(originStoryId);
        var newStory = stories.get(ticket.story);
        var oldTicket = originStory.get('tickets').get(ticket.id);
        var newTicket = new itsallagile.Model.Ticket(ticket);
        
        newStory.get('tickets').add(newTicket);
        originStory.get('tickets').remove(oldTicket);    
    },
        
    /**
     * Handle ticket change from a different user
     */
    onRemoteTicketChange: function(ticketData) {
        var ticketId = ticketData.id;
        var storyId = ticketData.story;
        
        var stories = this.model.get('stories');
        var story = stories.get(storyId);
        var ticket = story.get('tickets').get(ticketId);        
        ticket.set(ticketData);
    },   
    
    /**
     * Handle ticket created by a different user
     */
    onRemoteTicketCreate: function(ticketData) {
        var ticket = new itsallagile.Model.Ticket(ticketData);
        var storyId = ticketData.story;
        
        var stories = this.model.get('stories');
        var story = stories.get(storyId);
        story.get('tickets').add(ticket);        
    }, 
    
    /**
     * Handle ticket deleted by a different user
     */
    onRemoteTicketDelete: function(ticketData) {
        var ticketId = ticketData.id;
        var storyId = ticketData.story;
        
        var stories = this.model.get('stories');
        var story = stories.get(storyId);
        var ticket = story.get('tickets').get(ticketId);        
        ticket.destroy();     
    }
        
});



