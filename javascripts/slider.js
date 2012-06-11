/*
* jQuery-plugin to display "anything" in a carousel.
* Used on the get.no frontpage-banner
*
* example of usage:
*
*  jQuery("#myListOfImages").slider(); // starts the carousel
*  jQuery.slider.slide('left');   // slides one item to the left
*  jQuery.slider.slide('right');  // slides one item to the right
*  jQuery.slider.slideTo(0);      // slides from the current location to item 0 in the list
*  jQuery.slider.slideTo(1);      // slides from the current location to item 1 in the list
* */
(function(jQuery){
	// globally accessable parameters
	var globals = {
		paused : false,		// 
		jQuerycontainer : null,	// 
		jQueryitems : null,		// 
		opts : {}			// custom plugin configuration
	};

	// **************
	// private methods 
	// **************
	
	var methods = {
		"init" : function(){
			// setup wrapper(s)
			var jQuerywrapper = jQuery('<div id="wrapper"><div id="view" style="width:'+globals['opts'].itemWidth+'px;"></div></div>');
			globals['jQuerycontainer'].wrap(jQuerywrapper);					
			globals['jQuerycontainer'].children().remove(); // removing items from dom, but we still have ref's in globals['jQueryitems']
			
			// numbering items, so we easily can identify the ordering
			jQuery.each(globals['jQueryitems'],function(i, item){
				jQuery(item).attr("data-index",i); // enables jQuery.data("index")
			});
			
			// setup container with items
			globals['jQuerycontainer']
				.css({ 
					"position"	: "relative", 
					"width" 	: (globals['opts'].itemWidth*globals['jQueryitems'].size()),
					"margin-left" : "-" + globals['opts'].itemWidth + "px"
				})
				.append(globals['jQueryitems'].last())
				.append(globals['jQueryitems'].eq(0))
				.append(globals['jQueryitems'].eq(1));

            globals['opts'].indexUpdateStart(methods.currentIndex(), methods.currentItem()); // set first item as selected
            globals['opts'].indexUpdate(methods.currentIndex(), methods.currentItem()); // set first item as selected
		},
        "currentItem" : function(){
			return jQuery(globals['jQuerycontainer'].children(':eq(1)'));
		},
		// finds the index of the active item
		// returns integer
		"currentIndex" : function(){
			return jQuery(globals['jQuerycontainer'].children(':eq(1)')).data('index');
		},
		// calculates the next visible item to append when 'sliding' to the right
		// returns jQuery-wrapped dom-element
		"itemToAppend" : function(){
			var index = methods.currentIndex();
			var indexToAppend = (globals['jQueryitems'].size() > (index+2)) ? (index+2) : (index+2)-(globals['jQueryitems'].size());
			return globals['jQueryitems'].eq(indexToAppend);
		},
		// calculates the next visible item to append when 'sliding' to the left
		// returns jQuery-wrapped dom-element
		"itemToPrepend" : function(){
			var index = methods.currentIndex();
			var indexToPrepend = (0 <= (index-2)) ? index-2 : globals['jQueryitems'].size()+(index-2);
			return globals['jQueryitems'].eq(indexToPrepend);
		},
		// slides a item to the right
		"slideright" : function(customParams){
			var params = {
				'easing' : 'swing',						// transition easing function
				'speed' : globals['opts'].speed,  // transition duration
				'complete' : function(){} 				// callback
			};
			jQuery.extend( params, customParams);
			
			var removeFirstItem = function(){
				globals['jQuerycontainer'].css({ left: 0}).children(':eq(0)').remove();
			};

			// 1) appends an item at the rightmost position 
			// 2) slides an item to the right (the item appended in step 1, is now partially visible)
			globals['jQuerycontainer']
			.queue(function(next){
                var jQueryitemToAppend = methods.itemToAppend();
				globals['jQuerycontainer']
				.append(jQueryitemToAppend)
				.animate(
					{  'left' : -globals['opts'].itemWidth },
					{ 
						'duration':params.speed, 
						'easing' : params.easing,
						'queue':false, // we want to run the transition straight away
						'complete':function(){ 
							removeFirstItem(); 	// remove invisible item from the leftmost position
							next(); 			// invoke next in queue (see jQuery.queue(..))
							params.complete();  // callback
							globals['opts'].indexUpdate(methods.currentIndex(), methods.currentItem()); // callback for use in UI
						}
					}
				);

                var jQuerynextItem = jQueryitemToAppend.prev();
                globals['opts'].indexUpdateStart(jQuerynextItem.data("index"), jQuerynextItem);

			});			
		},
		// slides an item to the left
		"slideleft" : function(customParams){
			var params = {
				'easing' : 'easeOutSine',				// transition easing function
				'speed' : globals['opts'].speed,  // transition duration
				'complete' : function(){} 				//callback
			};
			jQuery.extend( params, customParams);
			
			var removeLastItem = function(){
				globals['jQuerycontainer'].css({ 'left': 0}).children().last().remove();
			};
		
			// 1) prepends an item at the leftmost position
			// 2)  
			// 3) slides an item to the left (the item prepended in step 1, is now partially visible)
			globals['jQuerycontainer']
			.queue(function(next){
                var jQueryitemToPrepend = methods.itemToPrepend();
				globals['jQuerycontainer']
				.prepend(jQueryitemToPrepend) // add a item within the slide-to-path
				.css({'left':-globals['opts'].itemWidth+'px'})
				.animate(
					{  'left' : 0 },
					{ 
						'duration':params.speed, 
						'easing' : params.easing,
						'queue':false, // we want not want to queue this function in isolation
						'complete':function(){ 
							removeLastItem();   // remove invisible item from the rightmost position
							next(); 			// invoke next in queue (see jQuery.queue(..))
							params.complete(); 	// callback
							globals['opts'].indexUpdate(methods.currentIndex(), methods.currentItem());
						}
					}
				);

                var jQuerynextItem = jQueryitemToPrepend.next();
                globals['opts'].indexUpdateStart(jQuerynextItem.data("index"),jQuerynextItem);

			});			
		},
		// starts a continous loop/carousel
		"startloop" : function(){
			var goleft = function(){					
				if(globals['paused']){
					return;
				}
				methods.slideright(	{ 'complete' : methods.startloop} );
			};
		
			setTimeout(goleft,globals['opts'].delay);
		},
		// slides into the position of the provided index
		"slideTo" : function(gotoIndex){
			var index = methods.currentIndex();
			if(index == gotoIndex){return;} // skip if the current step is the same
			
			if(index < gotoIndex){
				for(var i=index;i<gotoIndex-1;i++){ // slide with linear speed until last item
					methods.slideright({'easing':'linear', 'speed':globals['opts'].marchspeed}); 
				}
				methods.slideright(); // stop smoothly
			}
			else {
				for(var i=gotoIndex;i<index-1;i++){ // slide with linear speed until last item
					methods.slideleft({'easing':'linear', 'speed':globals['opts'].marchspeed}); 
				}
				methods.slideleft(); // stop smoothly
			}
		}
	};
		
	// **************
	// public methods
	//
	// **************
	jQuery.fn.slider = function(customOpts){
		var opts = {
			speed 			    : 500, // animation duration
			marchspeed	 	    : 0, 	// animation duration when sliding 1 > items
			delay 			    : 10000, // delay between items in carousel-loop
			itemWidth		    : this.children(':eq(0)').width(),  // item outerwith
			startIndex  	    : 0,
			indexUpdateStart    : function(index, currentitem){}, // callback when index is updated
			indexUpdate 	    : function(index, currentitem){} // callback when index is updated
		};
		jQuery.extend( opts, customOpts);
		
		// init global params
		globals['opts'] = opts;
		globals['jQuerycontainer'] = this;
		globals['jQueryitems'] = this.children();
		
		// init plugin
		methods.init();
		
		// start pos
		methods.slideTo(globals['opts'].startIndex)
		
		// starting carousel
		//methods.startloop();
	}

    // setup "static" methods, eg:
    // jQuery.slider.slide('left');   // slides one item to the left
	// jQuery.slider.slide('right');  // slides one item to the right
	// jQuery.slider.slideTo(0);      // slides from the current location to item 0 in the list
	// jQuery.slider.slideTo(1);      // slides from the current location to item 1 in the list
	jQuery.slider = {
		"slide" : function(direction){
			globals['paused'] = true;
			if(direction == 'left'){
				methods.slideleft();
			} else {
				methods.slideright();
			}
		},
		"slideTo" : function(gotoIndex){
			globals['paused'] = true;
			methods.slideTo(gotoIndex);
		}
	};
}(jQuery));	

