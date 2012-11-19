var year = $$(
    {},
    $('#year').html(),
    {
        'click div' : function(){
            this.trigger('newYear',this.model.get('id'));
        },
        
        'click button':function(){
            this.erase();
            this.destroy();
        },
        
        'persist:save:success':function(){
            this.view.sync();
        },

        'doSave': function(){
            this.save();            
        },
        
        'create': function(){
            if (loggedIn != "Jepp"){
                this.view.$('button').addClass('hide');
               
            }            
        }
    }
).persist($$.adapter.restful, {collection: 'years'});


var yearPicker = $$(
    {},
    $('#yearPicker').html(),
    {
        'click .createNewYear': function(){
            var newYear = $$(year);
            newYear.controller.doSave();
            this.append(newYear,'ul');
        },
        
        'create' : function(){
            if (loggedIn != "Jepp"){
                this.view.$('.createNewYear').addClass('hide');
               
            }
        }
    }
).persist();




var ukePris = $$
(
    {},

    $('#ukePris').html(),

    {
        'click .pris' : function(){
            if (loggedIn == "Jepp"){
                this.view.$('.pris').addClass('hide');
                this.view.$('.prisboksli').removeClass('hide');
                this.view.$('.prisboks').focus();
                this.view.$('.prisboks').select();
                
            }
        },
        
        'blur .prisboksli' : function(){
            this.view.$('.prisboksli').addClass('hide');
            this.view.$('.pris').removeClass('hide');              
            this.save();
        },
                
        'click .book' : function(){
            this.model.set({"Solgt": "Ja"});
            this.controller.toggleButtons();
            this.save();
        },
        
        'click .unbook' : function(){
            this.model.set({"Solgt": "Nei"});
            this.controller.toggleButtons();
            this.save();
        },
        
        'setBenevning': function(){
            if (this.model.get('antDager') == 1) {
                this.model.set({'benevning':'dag'});
            }
        },
        
        'toggleButtons' : function(){
            if (this.model.get('Solgt') == 'Ja'){
                this.view.$('.pris').addClass('hide');
                this.view.$('.solgt').removeClass('hide');
                this.view.$('button.book').addClass('hide');
                this.view.$('button.unbook').removeClass('hide');
            } 
            else {
                this.view.$('.pris').removeClass('hide');
                this.view.$('.solgt').addClass('hide');
                this.view.$('button.unbook').addClass('hide');
                this.view.$('button.book').removeClass('hide');
            }
            if (loggedIn != "Jepp"){
                this.view.$('button').addClass('hide');
               
            }
        },
        
         'create' : function () {
            this.controller.toggleButtons();
            this.controller.setBenevning();
        }
    }
);

var priser = $$(
    {},
    $('#priser').html(),
    {
        'change': function() {
            ukePris.persist($$.adapter.restful, {collection:'years/'+ this.model.get("year")});
            this.empty();
            this.gather(ukePris,'append', 'ul.priser');
        }
    }
).persist();

var heading = $$(
    {},
    $('#header').html(),
    {}
);

var main = $$({
    model: {},
    view: {},
    controller:{ 
        'create': function(){
            var firstYear = new Date().getFullYear();
            if (new Date().getMonth() > 7 ) {
                firstYear++;
            }

            headingView = $$(heading,{'year':firstYear});
            this.append(headingView);
            
            
            yearPickerView = $$(yearPicker);
            this.append(yearPickerView);
            yearPickerView.gather(year,'append','ul');
            
            priserView = $$(priser,{'year':firstYear});
            this.append(priserView);
            priserView.model.reset();
        },
        
        'child:newYear': function(){
            headingView.model.set({'year': arguments[1]});
            priserView.model.set({'year': arguments[1]});
        }
    }
});

$$.document.append(main,'div.priser');
