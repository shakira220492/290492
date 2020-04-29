var resultStatus = "";
var totalVideos = 0;

var videoOrderPosition_searchResults = 0; // SearchResults.html.twig
var videoOrderPosition_dataminingResults = 0; //DataminingResults.html.twig

function appendVideoToSearchEngineDiv(
    videoId,
    videoName,
    videoDescription,
    videoImage,
    videoContent,
    videoUpdatedate,
    videoAmountViews,
    videoAmountComments,
    videoScore,
    userId,
    userName,
    amountVideos,
    respectlyId,
    kindOfList,
    listId,
    videoOrderPosition
    )
{
        
    $("#searchResults").append(
//            "<a href=\"f_Presentation/newVideo\" "+
//        "<a href=\""+videoId+".mp4\">"+
        "<div id='videoPortrait_div"+respectlyId+"' style='position: relative; width:100%; cursor: pointer;' "
            +" data-id1='"+videoId+"'"
            +" data-id2='"+videoName+"'"
            +" data-id3='"+videoDescription+"'"
            +" data-id4='"+videoImage+"'"
            +" data-id5='"+videoContent+"'"
            +" data-id6='"+videoUpdatedate+"'"
            +" data-id7='"+videoAmountViews+"'"
            +" data-id8='"+videoAmountComments+"'"
            +" data-id9='"+videoScore+"'"
            +" data-id10='0'"
            +" data-id11='"+userId+"'"
            +" data-id12='"+userName+"'"
            +" data-id13='"+amountVideos+"'"
            +" data-id14='0'"
            +" data-id15='0'"
            +" >"

            +"<table border='0' width='100%'>"
            +"<tr height='120px'>"
                +"<td width='170px' height='100px'>"
                    +"<div id='videoPortrait_"+respectlyId+"' class='videoPortrait_'>"
                        +"<img style='"
                        +"height:100%; cursor: pointer;"
                        +"opacity: 0.9; "
                        +"z-index: 1;' "
                        +"src='files/"+userId+"/"+videoId+"/"+videoImage+"' "
                        +"alt='Mountain View'>"
                    +"</div>"
                    +"<div id='videoContaint_"+respectlyId+"' class='videoContaint_'>"
                        +" <b>"+videoName+"</b><br>"
                        +" "+userName+"<br>"
                        +" "+videoUpdatedate+"<br>"
                        +" "+videoAmountViews+" views<br>"
                        +" "+videoAmountComments+" comments<br>"
                        +" <div style='height: 5px; width: 100%;'>"
                            +"<div style='display: inline-block; height: 5px; width: 50%; background-color: blue; '></div>"
                            +"<div style='display: inline-block; height: 5px; width: 50%; background-color: red; '></div>"
                        +" </div>"
                    +"</div>"
                +"</td>"
            +"</tr>"
            +"</table>"

        +"</div>"
//        +"</div></a>"
    );

    $('#videoPortrait_div'+respectlyId)
    .mouseover(function () {

        document.getElementById("videoPortrait_"+respectlyId).style.opacity = 0.5;
        document.getElementById("videoContaint_"+respectlyId).style.opacity = 1;
        document.getElementById("searchResults").style.opacity = 1;
//        document.getElementById("searchBar").style.opacity = 1;
    })
    .click(function () {

        showVideo(
            videoId,
            videoName,
            videoDescription,
            videoImage,
            videoContent,
            videoUpdatedate,
            videoAmountViews,
            videoAmountComments,
            videoScore,
            userId,
            userName,
            kindOfList,
            listId,
            videoOrderPosition
        );

    })
    .mouseout(function () {
        document.getElementById("videoPortrait_"+respectlyId).style.opacity = 1;
        document.getElementById("videoContaint_"+respectlyId).style.opacity = 0;
        document.getElementById("searchResults").style.opacity = 0.5;
//        document.getElementById("searchBar").style.opacity = 0.5;
    });
    
    $('#searchResults')
    .mouseover(function () {
        var staticCommentVideoSection = document.getElementById("searchResults");
        staticCommentVideoSection.classList.add("visibleScroll");
    })
    .mouseout(function () {
        var staticCommentVideoSection = document.getElementById("searchResults");
        staticCommentVideoSection.classList.remove("visibleScroll");
    });
    
}

function drawNoResult(event, amountVideos) 
{
    if(event != "scroll" && amountVideos === 0)
    {
        $("#searchResults").append(
            "<div>"
                +"<table border='0' width='100%'>"
                +"<tr height='150px'>"
                    +"<td width='250px' height='150px'>"
                        +"<div>"
                            +" <b>There isn't more results for this search.</b><br>"
                        +"</div>"
                    +"</td>"
                +"</tr>"
                +"</table>"
            +"</div>"
        );
    }
}