$(document).ready(function(){
    $('video').mediaelementplayer({
    // if the <video width> is not specified, this is the default
    //defaultVideoWidth: 640,
    // if the <video height> is not specified, this is the default
    //defaultVideoHeight: 364,
    // if set, overrides <video width>
    videoWidth: $('video').width(),//-1,
    // if set, overrides <video height>
    videoHeight: $('video').height(),//-1,
    // width of audio player
    //audioWidth: 640,
    // height of audio player
    //audioHeight: 30,
    // initial volume when the player starts
    startVolume: 1,
    // useful for <audio> player loops
    loop: false,
    // enables Flash and Silverlight to resize to content size
    enableAutosize: true,
    // the order of controls you want on the control bar (and other plugins below)
    features: ['playpause','progress','current','duration','tracks','volume','fullscreen'],
    // Hide controls when playing and mouse is not over the video
    alwaysShowControls: false,
    // force iPad's native controls
    iPadUseNativeControls: false,
    // force iPhone's native controls
    iPhoneUseNativeControls: false, 
    // force Android's native controls
    AndroidUseNativeControls: false,
    // forces the hour marker (##:00:00)
    alwaysShowHours: false,
    // show framecount in timecode (##:00:00:00)
    showTimecodeFrameCount: false,
    // used when showTimecodeFrameCount is set to true
    framesPerSecond: 25,
    // turns keyboard support on and off for this instance
    enableKeyboard: true,
    // when this player starts, it will pause other players
    pauseOtherPlayers: true,
    // array of keyboard commands
    keyActions: []
 
  });

  $(document).resize(function(){

  });

  $('#upvote').click(
    function(){
        vote("up");
  });

  $('#downvote').click(
    function(){
        vote("down");
  });

});


function vote(type){
    var videoid = $('#bestvideo').attr('value');
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
        $('#alert').html("<br>you need to Sign in before you vote<br><br>");
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
