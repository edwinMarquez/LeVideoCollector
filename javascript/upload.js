function ask(){
	$.get(
      'progressinfo.php',
      function(response){
      	$(".progress-bar").attr('aria-valuenow',response.toString());
      	$(".progress-bar").css("width",response.toString() + '%');
      	$(".progress-bar").empty();
      	$(".progress-bar").prepend(response.toString()+'%');

      	if(response < 100){
      	   setTimeout("ask()", 1000);
      	}else{
      	   $("#bar").css("display","none");
      	}
      }

     )
}

function startPbar(){
	$("#bar").css("display","block");
	setTimeout("ask()", 1000);
}


function processfile(){
	$("#alert").children().remove();

	thefile = document.getElementById("file");
	size = thefile.files[0].size;
	type = thefile.files[0].type;
	if(size > 943718400){
		//file to big
		$("#video_prev").children().remove();
		alert = document.createElement("div");
		$(alert).addClass("alert alert-danger");
		$(alert).prepend("File to big to send");
		$("#alert").prepend(alert);
	}else if(!(type == 'video/mp4' || type == 'video/ogg' || type == 'video/webm')){
		//not a compatible format
		$("#video_prev").children().remove();
		alert = document.createElement("div");
		$(alert).addClass("alert alert-danger");
		$(alert).prepend("No compatible format. acepted mp4, ogg or webm videos only");
		$("#alert").prepend(alert);
	}else{
		preview = document.createElement("video");
		preview.width = 320; 
		preview.height = 240; 
		preview.controls = "true";
		source = document.createElement("source");
		source.src= window.URL.createObjectURL(thefile.files[0]);
		source.type = type;
		$(preview).prepend(source);
		$("#video_prev").children().remove();
		$("#video_prev").prepend(preview);
	}
	
}