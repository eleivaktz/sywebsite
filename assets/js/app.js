import "jquery";
import Popper from "popper.js";
window.Popper = Popper;

require("bootstrap");
//require('propper.js');
require('../css/app.scss');
const routes = require('../../web/js/fos_js_routes.json')
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js'
import UnnameGame from '../images/unnamedgame.png';
import Chart from 'chart.js'
import 'bootstrap'
// import the function from greet.js (the .js extension is optional)
// ./ (or ../) means to look for a local file


$(document).ready(function() {
	var myChart =null;
	Routing.setRoutingData(routes);
	$.ajax({
                method: "POST",
                url: Routing.generate('ajax_votestatus', true),                
                dataType: 'json',
                success: function(data)
                {
                    if(data.hasOwnProperty("response") && data.response === "success")
                    {
                        if(data.hasOwnProperty("response") && data.response === "success")
	                    {
	                    	var schudlepoolupdate = JSON.parse(data.schudlepoolupdate);
	                    	var arraylabels = [];
						    var arrayvotes = [];
						    $(schudlepoolupdate).each(function(key,value){
						    	arraylabels.push(value.game.name);	
						    	arrayvotes.push(value.votes);
						    });

					    	var ctx = document.getElementById("myChart").getContext("2d");
							ctx.canvas.width = 300;
							ctx.canvas.height = 300;
							myChart = new Chart(ctx, {
							    type: 'pie',
							    responsive: true,
							    maintainAspectRatio: false,
							    data: {
							        labels: arraylabels,
							        datasets: [{
							            label: '# of Votes',
							            data: arrayvotes,
							            backgroundColor: [
							                'rgba(255, 99, 132, 0.2)',
							                'rgba(54, 162, 235, 0.2)',
							                'rgba(255, 206, 86, 0.2)',
							                'rgba(75, 192, 192, 0.2)',
							                'rgba(153, 102, 255, 0.2)',
							                'rgba(255, 159, 64, 0.2)'
							            ],
							            borderColor: [
							                'rgba(255,99,132,1)',
							                'rgba(54, 162, 235, 1)',
							                'rgba(255, 206, 86, 1)',
							                'rgba(75, 192, 192, 1)',
							                'rgba(153, 102, 255, 1)',
							                'rgba(255, 159, 64, 1)'
							            ],
							            borderWidth: 1
							        }]
							    },
							    options: {
							        scales: {
							            xAxes: [{
							                display: false
							            }],
							            yAxes: [{
							                display: false
							            }]
							        }
							    }
							});	                    	
	                    }
                    }
                    else
                    {
                        if(data.hasOwnProperty("response") && data.response === "fail")
                        {

                        }
                    }
                },
                error: function(jqXHR, exception)
                {
                    if(jqXHR.status === 405)
                    {
                        console.error("METHOD NOT ALLOWED!");
                    }
                }
            });
	


    $("#game_save").click(function(event){
            event.preventDefault();

            $.ajax({
                method: "POST",
                url: Routing.generate('ajax_savegame', true),
                data : {"game_name" : $("#game_name").val()},
                dataType: 'json',
                success: function(data)
                {
                    if(data.hasOwnProperty("response") && data.response === "success")
                    {
                        if(data.hasOwnProperty("gamelist"))
                        {
                            var gamelist = JSON.parse(data.gamelist);
                            if(gamelist.length > 0)
                            {
                               $("#gamelist").empty();
                               $(gamelist).each(function(key, value){
                                  $("#gamelist").append("<div class='row game-item' id='"+value["id"]+"'>"+
                                        "<div class='col-6'><p class='game-name'>"+value["name"]+"</p></div>"+
                                        "<div class='col-6'>"+
                                            "<div class='row'>"+
                                                "<div id='categories-container-"+value["id"]+"' class='col-8 padding-4x'>"+                                                    
                                                "</div>"+
                                                "<div class='col-1'>"+
                                                "</div>"+
                                                "<div clas='col-3' style='padding:4px;'>"+
                                                    "<button class='btn btn-primary' name='"+value["id"]+"' id='votar"+value["id"]+"' >Votar</button>"+
                                                "</div>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>");
                                  var categoriesHTML = '<div class="col-10">';
                                  $(value["categoriesArray"]["0"]).each(function(key, value){
                                        categoriesHTML = categoriesHTML+"<span class='badge badge-pill badge-info'>"+value["description"]+"</span>"
                                  });
                                  categoriesHTML = categoriesHTML+"</div>"
                                  var steamlinkHTML = '<div class="col-2">';
                                  if(value["steamlink"] != null)
                                  {
                                    steamlinkHTML = "<a href='http://store.steampowered.com/app/"+value["steamlink"]+"'"+
                                                     "target='_blank'><div class='steamlink'></div></a>";
                                  }
                                  else
                                  {
                                    steamlinkHTML = "<div class='steamlink disable'></div>"
                                  }
                                  steamlinkHTML = steamlinkHTML+"</div>";
                                  $("#categories-container-"+value["id"]).append("<div class='row'>"+categoriesHTML+steamlinkHTML)+"</div>";
                               });
                            }
                        }
                        else
                        {
                            console.log("POSTS NOT FOUND");
                        }
                    }
                    else
                    {
                        if(data.hasOwnProperty("response") && data.response === "fail")
                        {                        	
                            var error = JSON.parse(data.error);
                        	$("#error_add_game").html(error)
                        	$("#game_name").val("");
                        }
                    }
                },
                error: function(jqXHR, exception)
                {
                    if(jqXHR.status === 405)
                    {
                        console.error("METHOD NOT ALLOWED!");
                    }
                }
            });    
        });

    $("button[id*='votar']").click(function(event){    	
    	event.preventDefault();

    	var game_id = $(this).attr("name");

            $.ajax({
                method: "POST",
                url: Routing.generate('ajax_votegame', true),
                data : {"game_id" : game_id},
                dataType: 'json',
                success: function(data)
                {
                    if(data.hasOwnProperty("response") && data.response === "success")
                    {
                    	var schudlepoolupdate = JSON.parse(data.schudlepoolupdate);
                    	updateConfigAsNewObject(myChart,schudlepoolupdate);
                    }
                    else
                    {                        
                        var error = JSON.parse(data.error);
                        $("#error_vote_game").html(error)                        
                    }
                },
                error: function(jqXHR, exception)
                {
                    if(jqXHR.status === 405)
                    {
                        console.error("METHOD NOT ALLOWED!");
                    }
                }
            });

    });

    function updateConfigAsNewObject(chart,updatepool) {
	    
	    var arraylabels = [];
	    var arrayvotes = [];
	    $(updatepool).each(function(key,value){
	    	arraylabels.push(value.game.name);	
	    	arrayvotes.push(value.votes);
	    });

	    chart.data  =  {
	        labels: arraylabels,
	        datasets: [{
	            label: '# of Votes',
	            data: arrayvotes,
	            backgroundColor: [
	                'rgba(255, 99, 132, 0.2)',
	                'rgba(54, 162, 235, 0.2)',
	                'rgba(255, 206, 86, 0.2)',
	                'rgba(75, 192, 192, 0.2)',
	                'rgba(153, 102, 255, 0.2)',
	                'rgba(255, 159, 64, 0.2)'
	            ],
	            borderColor: [
	                'rgba(255,99,132,1)',
	                'rgba(54, 162, 235, 1)',
	                'rgba(255, 206, 86, 1)',
	                'rgba(75, 192, 192, 1)',
	                'rgba(153, 102, 255, 1)',
	                'rgba(255, 159, 64, 1)'
	            ],
	            borderWidth: 1
	        }]
	    }
	    chart.update();
	}

       
        $.ajax({
                method: "GET",
                url: Routing.generate('ajax_schudlegameday', true),                
                dataType: 'json',
                success: function(data)
                {
                    if(data.hasOwnProperty("response") && data.response === "success")
                    {
                        if(data.hasOwnProperty("response") && data.response === "success")
                        {                            
                            if(data.lunes != null) 
                            {

                                var lunesgameinfo = JSON.parse(data.lunes.game);                                
                                console.log(lunesgameinfo);
                                $("#lunes").css('background-image', 'url(' + lunesgameinfo.headerImage + ')');
                                $("#lunes").attr("data_game",lunesgameinfo.id);
                                
                            }
                            else
                            {
                                $("#lunes").css('background-image', 'url(' + UnnameGame + ')');                                   
                            }
                            
                            if(data.martes != null) 
                            {
                                var martesgameinfo = JSON.parse(data.martes.game);
                                
                                $("#martes").css('background-image', 'url(' + martesgameinfo.headerImage + ')');
                                $("#martes").attr("data_game",martesgameinfo.id);
                            }
                            else
                            {
                                $("#martes").css('background-image', 'url(' + UnnameGame + ')');   
                            }

                            if(data.miercoles != null) 
                            {
                                var xgameinfo = JSON.parse(data.miercoles.game);                                
                                $("#miercoles").css('background-image', 'url(' + xgameinfo.headerImage + ')');
                                $("#miercoles").attr("data_game",xgameinfo.id);
                            }
                            else
                            {
                                $("#miercoles").css('background-image', 'url(' + UnnameGame + ')');   
                            }

                            if(data.jueves != null) 
                            {
                                var jgameinfo = JSON.parse(data.jueves.game);                                
                                $("#jueves").css('background-image', 'url(' + jgameinfo.headerImage + ')');
                                $("#jueves").attr("data_game",jgameinfo.id);
                            }
                            else
                            {
                                $("#jueves").css('background-image', 'url(' + UnnameGame + ')');   
                            }
                            if(data.viernes != null) 
                            {
                                var vgameinfo = JSON.parse(data.viernes.gameinfo);                                
                                $("#viernes").css('background-image', 'url(' + vgameinfo.headerImage + ')');
                                $("#viernes").attr("data_game",vgameinfo.id);
                            }
                            else
                            {
                                $("#viernes").css('background-image', 'url(' + UnnameGame + ')');   
                            }
                            if(data.sabado != null) 
                            {
                                var sgameinfo = JSON.parse(data.sabado.gameinfo);                                
                                $("#sabado").css('background-image', 'url(' + sgameinfo.headerImage + ')');
                                $("#sabado").attr("data_game",sgameinfo.id);
                            }
                            else
                            {
                                $("#sabado").css('background-image', 'url(' + UnnameGame + ')');   
                            }
                            if(data.domingo != null) 
                            {
                                var dgameinfo = JSON.parse(data.domingo.gameinfo);                                
                                $("#domingo").css('background-image', 'url(' + dgameinfo.headerImage + ')');
                                $("#domingo").attr("data_game",dgameinfo.id);
                            }
                            else
                            {
                                $("#domingo").css('background-image', 'url(' + UnnameGame + ')');   
                            }
                            
                        }
                    }
                    else
                    {                        
                        var error = JSON.parse(data.error);
                        $("#error_getinfogame").html(error)                        
                    }
                },
                error: function(jqXHR, exception)
                {
                    if(jqXHR.status === 405)
                    {
                        console.error("METHOD NOT ALLOWED!");
                    }
                }

        });
        $(".daycard").click(function(){
            var id = $(this).attr("data_game"); //$(this).attr("id");        
            $.ajax({
                    method: "POST",
                    url: Routing.generate('ajax_getinfogame', true),
                    data : {"game_id" : id},
                    dataType: 'json',
                    success: function(data)
                    {
                        if(data.hasOwnProperty("response") && data.response === "success")
                        {
                            if(data.hasOwnProperty("response") && data.response === "success")
                            {
                                var game = JSON.parse(data.game);                                
                                $("#game_portrait").css('background-image', 'url(' + game.headerImage + ')');

                                $("#game_info").html(game.gameDescription);                                                                
                                $('.collapse').collapse()
                                
                            }
                        }
                        else
                        {                        
                            var error = JSON.parse(data.error);
                            $("#error_getinfogame").html(error)                        
                        }
                    },
                    error: function(jqXHR, exception)
                    {
                        if(jqXHR.status === 405)
                        {
                            console.error("METHOD NOT ALLOWED!");
                        }
                    }
            });

                    
        });
    
        $("#game_filter" ).keyup(function() {
            if($(this).val() == "")
            {
                $(".game-name").parent().parent().removeClass("d-none");
            }
            else
            {                
                $(".game-name:contains("+$(this).val()+")").parent().parent().removeClass("d-none");
                $(".game-name:not(:contains("+$(this).val()+"))").parent().parent().addClass("d-none");
            }
            
        });
        
    
    
});