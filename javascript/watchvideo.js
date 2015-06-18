$(document).ready(function(){

  $('#upvote').click(
    function(){
        vote("up");
  });

  $('#downvote').click(
    function(){
        vote("down");
  });

  $('#post').click(
    function(){
        comment();
    });
});


function vote(type){
    var videoid = $('#video_watch').attr('value');
    $.ajax({
        url: './updownvote.php',
        data: {action: type, video: videoid},
        type:'post',
        success: function(output){
            if(output == "yes") updatevotes(type);
            if(output == "nolog") updatevotes("nolog");
            if(output == "changedu") updatevotes("changedu");
            if(output == "changedd") updatevotes("changedd");
        }
    });
}

function updatevotes(type){
    if(type == "up"){
        var up = parseInt($('#upnumber').html()) + 1;
        $("#upnumber").html(up);
        $('#upvote').attr("class","btn btn-success");
    }else if(type == "down"){
        var down = parseInt($('#downnumber').html()) + 1;
        $('#downnumber').html(down);
        $('#downvote').attr("class","btn btn-danger");
    }else if(type == "nolog"){
        if($('#alert').css('display') == 'none'){
            $('#alert').show('fast');
        }else{
            $('#alert').hide('fast');
        }
        
    }else if(type == "changedu"){
        var up = parseInt($('#upnumber').html()) + 1;
        var down = parseInt($('#downnumber').html()) - 1;
        $('#upnumber').html(up);
        $('#downnumber').html(down);
        $('#upvote').attr("class", "btn btn-success");
        $('#downvote').attr("class","btn btn-default");
    }else if(type == "changedd"){
        var up = parseInt($('#upnumber').html()) - 1;
        var down = parseInt($('#downnumber').html()) + 1;
        $('#upnumber').html(up);
        $('#downnumber').html(down);
        $('#upvote').attr("class", "btn btn-default");
        $('#downvote').attr("class","btn btn-danger");
    }
}


function comment(){
    var videoid = $('#video_watch').attr('value');
    var commenttext = $('#commenttext').val();
    $.ajax({
        url: './comment.php',
        data: {comment: commenttext, idvideo: videoid},
        type: 'post',
        success: function(output){
            updatecomments(output);
        }

    });

}


function updatecomments(output){
    if(output == 'nolog'){
        if($('#alert-comment').css('display') == 'none'){
            $('#alert-comment').show('fast');
        }else{
            $('#alert-comment').hide('fast');
        }
    }

    if(output.substring(0,7) == 'posted '){
        $('#commentpart').html(output.substring(7));
        $('#commenttext').val('');
    }
}
