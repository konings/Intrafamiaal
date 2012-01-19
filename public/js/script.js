/* Author: Konings Kristof
	
*/
var assert = function(value, msg) {
if ( !value )
throw(msg || (value + " does not equal true"));
};

var assertEqual = function(val1, val2, msg) {
	if (val1 !== val2)
	throw(msg || (val1 + " does not equal " + val2)); };

function togglecolor()
{
	if($(".redorgreen").attr("freeze")!="true")
	{
		if($(".redorgreen").attr("rog")=="r")
		{
			$(".redorgreen").css("background","green");
			$(".redorgreen").attr("rog","g");
		}
		else
		{
			$(".redorgreen").css("background","red");
			$(".redorgreen").attr("rog","r");		
		}
		setTimeout("togglecolor()",200);
	} 

	
	
}

function startPolling()
{
	togglecolor();
	$.getJSON("/zend-html5boilerplate-spine/public/polling/poll1?name=" + $("#name").value, function(returned){
		console.log(returned);
		if(returned.push=true)
			$(".redorgreen").attr("freeze","true");
			$(".redorgreen").css("background",returned.color);
	})    ;	
}
(function($){

	    // Game console. Bovenste holder.
		VoteConsole = Backbone.View.extend({
			el: $("#console"),
			events: {  },
			initialize: function(){ 
				$(this.el).html();
				
				this.votepolls= new VotePolls;
				this.votepolls.bind('reset',this.start, this);
				this.votepolls.bind('remove',this.next, this);
				this.votepolls.fetch();
				
				console.log("wait");
				
				},
			start: function(){ 
				this.votepolls.bind('reset',this.next, this);
				this.vpview = new VotePollView( { model:  this.votepolls.getVotePoll() });
				this.render();
				//this.votepolls.remove(this.vpview.model);
				},
			next: function(){
				//this.votepolls.remove(this.vpview.model);
				this.vpview = new VotePollView( { model:  this.votepolls.getVotePoll() });
				this.render();
			},
			render: function(){$(this.el).html(this.vpview.render().el);},
			puut: function(){alert("puut")},
			add: function() { console.log("test")}
		});
		
		
		VotePollView = Backbone.View.extend({
			events: {
				"click .vp_ja" : "clickja",
				"click .vp_nee" : "clicknee"
			},
			tagName: "div",
			waiting: false,
			template: _.template("<b><%=question %></b><br><div class='vp_ja'>Ja</div> - <div class='vp_nee'>Nee</div>"),
			render: function(){
				console.log("render vpv");

			if(!this.waiting)
					$(this.el).html(this.template(this.model.toJSON()));
				else
					$(this.el).html("even wachten" );
				return this;
			},
			clickja: function(){
				this.waiting=true;
				this.render();
				this.model.click("ja");
			},
			clicknee: function(){
				this.waiting=true;
				this.render();
				this.model.click("nee");
			},
			changed: function(){
				console.log("updated");
			}
		});


		VotePoll = Backbone.Model.extend({
		        initialize: function(){
		        	this.id= 5;
		        },
		        urlRoot: '',
		        url: '/zend-html5boilerplate-spine/public/SyncPoll/',
		        success: function(response) {
		        	this.set({finished: true});
		        	console.log(response);
		        	this.collection.next();
		        },
		        error: function(response) {
		        	console.log("fout",response);
		        },
		        click: function(jaofnee){
		        	console.log("clicked " + jaofnee);
		        	this.set({"antwoord": jaofnee});
		        	this.save();
		        }
		  });
		    
		// votepoll = new VotePoll;
		 
		 
		 VotePoll.prototype.sync = function (method, model, options) {
			 var response_ajax;
			 
			 var method;
			 switch(method){
			 //case "read": response = $.getJSON('/zend-html5boilerplate-spine/public/SyncPoll/read/' + model.id, options.success(model), options.error);
			 case "create":
				 method_ajax='POST';
				 break;
			 case "read":
				 method_ajax='GET';
				 break;
			 case "update":
				 method_ajax='GET';
				 break;
			 case "delete":
				 method_ajax='POST';
				 break;
			 }
			 
			 $.ajax({
			  url: '/zend-html5boilerplate-spine/public/SyncPoll/'+method,
			  type: method_ajax,
			  data: model.toJSON(),
			  dataType: 'json',
			  cache: false,
			  success:function(data1, data2, data3) { 
				  	  model.success(data1);
				  },
			   error:function(data1, data2, data3) { 
				  	  model.error(data1);
				  },
			 })
			 
		 }
		 
		VotePolls = Backbone.Collection.extend({
			model: VotePoll,
			url: '/zend-html5boilerplate-spine/public/SyncPoll/fetch/gameid/4/lesson/4',
			parse: function(data){
				if(data.status="ok")
					return data.data;
				//else
				//foutafhandeling
			},
			getVotePoll: function(){
				console.log(_.first(this.models));
	            return _.first(this.models);
			},
			next: function(){
				console.log("eeext");
				//this.reset();
				this.remove(this.getVotePoll());
			}
		});
		//VotePolls.prototype.sync = function (method, model, options) {
		//	console.log(method, model, options);
		//}
	
		
		
		LiveViewConsole = Backbone.View.extend({
			el: $("#console"),
			events: {  },
			initialize: function(){ 
					this.liveviewresult = new LiveViewResult();
					this.liveviewresult.fetch();
					
					this.liveviewresult.bind('showGraph',this.showGraph, this);
			
				},
			render: function(){},
			showGraph: function(){
				var bars = $("<div></div>");
				console.log("showgraph");
				$.each(this.liveviewresult.get("data"), function(index,value){
					bars.append($("<div></div>").addClass("liveboard_poll_bar" + index).attr("id","liveboard_poll_bar" + index).html(value.vote));
				});
				
				$(this.el).html(bars);
				
				$.each(this.liveviewresult.get("data"), function(index,value){
					$("#liveboard_poll_bar" + index).animate({ height: value.count*100},  value.count*1000);
				});			
				
								
			}
		});
		
		LiveViewResult = Backbone.Model.extend({
	        urlRoot: '',
	        url: '/zend-html5boilerplate-spine/public/SyncPoll/live',
			initialize: function(){ this.set({id: 3})},
		
		success: function(data){
			//gameconsole.showGraph();
			this.set({data: data.data})

			this.trigger("showGraph")
		},
		error: function(){
			console.log("error111");
		
		},
		remove: function(){
			console.log("remove");
		}
		});
		
		LiveViewResult.prototype.sync = function (method, model, options) {
			model=this;
			 $.ajax({
				  url: '/zend-html5boilerplate-spine/public/SyncPoll/live',
				  type: 'get',
				  data: model.toJSON(),
				  dataType: 'json',
				  cache: false,
				  success:function(data1, data2, data3) { 
					  	  model.success(data1);
					  },
				   error:function(data1, data2, data3) { 
					  	  model.error(data1);
					  },
				 })
		}
		 
		//page controller: links naar #iets worden hier verbonden aan een functie 
		
		var PageController = Backbone.Router.extend({
			routes: {
				"liveBoard": "liveBoard",
				"loadVote": "loadVote",
				"vote/:id": "loadVote",
				"*actions": "test"
			},
			liveBoard: function(){
				var gameconsole = new LiveViewConsole;
				
			},
			loadVote: function(id){
				var gameconsole = new VoteConsole;
			}
		})
		
		var pagacontroller = new PageController;
		Backbone.history.start();	
		
		
		
		//var gameconsole = new GameConsole;
		
})(jQuery);
















