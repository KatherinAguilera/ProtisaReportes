$(document).on("ready", inicio);
function inicio () 
{
	//Aqui va todo el codigo relacionado con DOM
	$(".main_content").on("click", movida);
	//$("#cssmenu").on("click", movida);
}
function movida () 
{
	//JSON
	var cambiosCSS =
	{
		//display: inline-block;
	    margin:0,
	    //vertical-align: top;
		margin: 0,
		//overflow: "scroll",
		padding: 0,
		width: "150%"
	};
	$(".main_content").css(cambiosCSS);
}
