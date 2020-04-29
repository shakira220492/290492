function update_songInfo()
{
    document.getElementById("videoUpdatedate").innerHTML = current_video_updateDate;
    document.getElementById("videoAmountViews").innerHTML = current_video_amount_views + " views";
    document.getElementById("videoAmountComments").innerHTML = current_video_amount_comments + " comments";
    document.getElementById("videoPunctuation").innerHTML = 
            " <div style='height: 5px; width: 100%;'>"
                +"<div style='display: inline-block; height: 5px; width: 50%; background-color: blue; '></div>"
                +"<div style='display: inline-block; height: 5px; width: 50%; background-color: red; '></div>"
            +" </div>";
    
    document.getElementById("songIconButton").innerHTML = current_video_name;
    document.getElementById("artistIconButton").innerHTML = current_video_userName;
}