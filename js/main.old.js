function renderFromApi(el,url,template){
        $.getJSON(url, function(data){
            el.empty().append(Mustache.render(template, data));
        } );
        
}

function updateFiske(uke) {
    $.ajax({
        type: 'PUT',
        contentType: 'application/json',
        url: 'http://localhost/Mo-G-rd/api/fiske/'+uke.year+'/'+uke.nr,
        dataType: "json",
        data: '{"Solgt":"'+uke.solgt+'","Pris":'+uke.pris+'}',
        success: function(data, textStatus, jqXHR){
            alert('Wine updated successfully');
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('updateWine error: ' + textStatus);
        }
    });
}


function updateFiskeTest(uke) {
    $.ajax({
        type: 'PUT',
        contentType: 'application/json',
        url: 'http://localhost/Mo-G-rd/api/fiske/'+2013+'/'+26,
        dataType: "json",
        data: '{"Solgt":"Nei","Pris":77777}',
        success: function(data, textStatus, jqXHR){
            alert('Wine updated successfully');
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('updateWine error: ' + textStatus);
        }
    });
}


var ukeView = function(el, uke){
    this.el= $(el);
    this.uke = {};
    
    this.uke.nr=this.el.find('.ukenr').html();
    this.uke.pris=this.el.find('.belop').html();
    
    var status = this.el.find('.status').html();
    if ( status == "Solgt") {
        this.uke.solgt = "Nei";
    } else {
        this.uke.solgt = "Ja";
    }
    
    this.uke.year = 2013;
    
    var that = this;
    
    this.el.find('.button').click(function(){
       updateFiske(that.uke) ;
    });
   
}



var fiskeView = function(){
    el = $('.priser');   
    url = 'http://localhost/Mo-G-rd/api/fiske/'+2013;
    template = $("#allePriser").html();
    
    this.render = render;
    function render(){
        $.get(url, function(data){
            el.empty().append(Mustache.render(template, data));
        } )
        
    }           
}

var yearView = function(data){
    var template = $("#year").html();

    this.render = render;
    function render(){
        var html =Mustache.render(template, data); 
        $(html).click(function(){alert("hei")});
        return html;                
    }
    
}


var yearsView = function(){
    var el = $(".years");
    var url= 'http://localhost/Mo-G-rd/api/fiske';
    
    this.render = render;
    function render(){
        el.empty();
        $.getJSON(url, function(data){
            for (var i = 0 ;i < data.length; i++){
                var view = new yearView(data[i]);
                
                el.append(view.render()); 
                
            }
            
                  
            
        } );
    }
    
    
    
}


var view = new yearsView();
view.render();


