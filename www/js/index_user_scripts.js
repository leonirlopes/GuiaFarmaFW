(function()
{
    "use strict";
    /*
    hook up event handlers 
    */
    function register_event_handlers()
    {
        /* listitem  #btnSobre */
        $(document).on("click", "#btnSobre", function(evt)
        {
            /* your code goes here */
            //$.afui.loadContent(target, newTab, goBack, transition, anchor);
            $.ui.loadContent("#pgSobre",false,false,"up");
        });

        /* listitem  #btnLista */
        $(document).on("click", "#btnLista", function(evt)
        {
            /* your code goes here */
            $("#listaFarmacias").empty();
            $.getJSON('data.json', function(data) {
                var output="";
                for (var i in data.farmacias) {
                    output+="<li CODIGO=\"" + data.farmacias[i].id + "\">";
                    output+="<h2>" + data.farmacias[i].nome + "</h2>";
                    output+="<p>";
                    if(data.farmacias[i].extra.farmaciapopular == "sim"){
                        output+="<span class=\"label label-popular\""
                        output+="style=\"position:relative\">farmácia popular</span> ";
                    }
                    if(data.farmacias[i].extra.teleentrega == "sim"){
                        output+="<span class=\"label label-entrega\""
                        output+="style=\"position:relative;background-color:blue\">"
                        output+="tele-entrega</span> ";
                    }
                    if(data.farmacias[i].extra.manipulacao == "sim"){
                        output+="<span class=\"label label-manipulacao\""
                        output+="style=\"position:relative;background-color:green\">"
                        output+="farmácia de manipulação</span> ";
                    }
                    output+="</p>";
                    output+="</a>";
                }
                $("#listaFarmacias").prepend(output);
            });
            $.ui.loadContent("#pgLista",false,false,"slide");
        });

        /* listitem #listaFarmacias > li */
		$(document).on("click", "#listaFarmacias > li", function(evt)
		{
			var codigo = $(this).attr("CODIGO");
			//console.log("CODIGO recebido = "+codigo);
            $.getJSON('data.json', function(data){
                var output="";
                for (var i in data.farmacias) {
                    if(data.farmacias[i].id == codigo){
                        var nome = data.farmacias[i].nome;
                        document.getElementById("farmaNome").innerHTML=nome;
                        var endereco = data.farmacias[i].endereco;
                        document.getElementById("farmaEndereco").innerHTML=endereco;
                        var telefone = '';
                        for (var t in data.farmacias[i].telefone){
                            telefone+= "<a href=\"tel:+55"+data.farmacias[i].telefone[t].ddd
                                +data.farmacias[i].telefone[t].numero
                                +"\" rel=\"external\">("+data.farmacias[i].telefone[t].ddd
                                +") "+data.farmacias[i].telefone[t].numero
                                +"</a> "+data.farmacias[i].telefone[t].tipo+"<br>";
                        }
                        document.getElementById("farmaTelefone").innerHTML=telefone;
						var extra = '';
                        if(data.farmacias[i].extra.farmaciapopular == "sim"){
							extra+="<span class=\"label label-popular\""
                            extra+="style=\"position:relative\">farmácia popular</span> ";
						}
						if(data.farmacias[i].extra.teleentrega == "sim"){
							extra+="<span class=\"label label-entrega\""
                            extra+="style=\"position:relative;background-color:blue\">"
                            extra+="tele-entrega</span> ";
						}
						if(data.farmacias[i].extra.manipulacao == "sim"){
							extra+="<span class=\"label label-manipulacao\""
                            extra+="style=\"position:relative;background-color:green\">"
                            extra+="farmácia de manipulação</span> ";
						}
						document.getElementById("farmaExtra").innerHTML=extra;
						$("#farmaMapa").empty();
						$("#rota").empty();
						mapa(""+data.farmacias[i].latitude+"",""+data.farmacias[i].longitude+"");
                    }else{}
                }
            });
			$.ui.loadContent("#pgDetalha",false,false,"slide");
		});
    }
    document.addEventListener("app.Ready", register_event_handlers, false);
})();
