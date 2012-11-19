var heading = $$(
    {},
    $('#header').html(),
    {}
);

var year = $$(
    {},
    $('#year').html(),
    {
        'click &' : function(){
            this.trigger('newYear',this.model.get('id'));
        },
        
        'persist:save:success':function(){
            this.view.sync();
        },

        'doSave': function(){
            this.save();            
        }
    }
).persist($$.adapter.restful, {collection: 'years'});


var yearPicker = $$(
    {},
    $('#yearPicker').html(),
    {
        'click button': function(){
            var newYear = $$(year);
            newYear.controller.doSave();
            this.append(newYear,'ul');
        },
        
        'create' : function(){
            if (loggedIn != "Jepp"){
                this.view.$('button').addClass('hide');
               
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
                this.view.$('.prisboks').removeClass('hide');
            }
        },
        
        'blur .prisboks' : function(){
            this.view.$('.prisboks').addClass('hide');
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
        'newYear': function(year) {
            this.model.set({"year":year});
            ukePris.persist($$.adapter.restful, {collection:'years/'+ year});
            this.empty();
            this.gather(ukePris,'append', 'ul.priser');
        }
    }
).persist();

var main = $$({
    model: {},
    view: {},
    controller:{ 
        'create': function(){
            headingView = $$(heading);
            yearPickerView = $$(yearPicker);
            priserView = $$(priser);
            
            this.append(headingView);
            this.append(yearPickerView);
            yearPickerView.gather(year,'append','ul');
            
            
            
            this.append(priserView);
            
            var firstYear = new Date().getFullYear();
            
            
            if (new Date().getMonth() > 7 ) {
                firstYear++;
            }
                
            priserView.controller.newYear(firstYear);
            
        },
        'child:newYear': function(){
            priserView.controller.newYear(arguments[1]);
        }
    }
});

$$.document.append(main,'div.priser');
