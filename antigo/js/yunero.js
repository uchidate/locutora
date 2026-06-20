if (null == yuneroWidgetHeight || yuneroWidgetHeight == "" || yuneroWidgetHeight == "undefined") var yuneroWidgetHeight = 400;
if (null == yuneroWidgetWidth || yuneroWidgetWidth == "" || yuneroWidgetWidth == "undefined") var yuneroWidgetWidth = 280;
if (null == yuneroVideoHeight || yuneroVideoHeight == "" || yuneroVideoHeight == "undefined") var yuneroVideoHeight = 200;
var yuneroUser = "";
var yuneroListId = "";

function createAPI() {
    var apiURL = "";
    if (youTubeURL.indexOf("youtube.com/user/") != -1) {
        if (youTubeURL.indexOf("?feature") != -1) yuneroUser = youTubeURL.substring(youTubeURL.indexOf("youtube.com/user/") + 17, youTubeURL.indexOf("?feature"));
        else yuneroUser = youTubeURL.substring(youTubeURL.indexOf("youtube.com/user/") + 17);
        apiURL = "http://gdata.youtube.com/feeds/api/users/" + yuneroUser + "/uploads/?v=2&alt=jsonc"
    } else if (youTubeURL.indexOf("youtube.com/playlist?list=") != -1) {
        yuneroListId = youTubeURL.substring(youTubeURL.indexOf("youtube.com/playlist?list=") + 26);
        apiURL = "http://gdata.youtube.com/feeds/api/playlists/" + yuneroListId + "?v=2&alt=jsonc"
    }
    return apiURL
}
function secondsToTime(duration) {
    var minutes = Math.floor(duration / 60);
    var seconds = duration % 60;
    if (seconds < 10) seconds = "0" + seconds;
    var time = minutes + ":" + seconds;
    return time
}
function showWidget(response) {
    var id;
    var image;
    var title;
    var views;
    var duration;
    var clear;
    var subscribtionUser;
    var $yunero = $('#yunero');
    $yunero.empty();
    $yunero.append('<iframe id="yuneroVideoFrame" width="100%" src="" height="' + yuneroVideoHeight + '" frameborder="0"></iframe>');
    $('#yuneroVideoFrame').hide();
    if (null != yuneroUser && yuneroUser != "" && yuneroUser != "undefined") subscribtionUser = yuneroUser;
    else subscribtionUser = response.data.author;
    $yunero.append('<div style="margin:10px; margin-bottom:2px;"><iframe frameborder="0" id="fr" scrolling="no" src="http://www.youtube.com/subscribe_widget?p=' + subscribtionUser + '" style="border: 0px; height: 104px; background:#FFF; overflow-x: hidden; overflow-y: hidden;  width: 100%;"></iframe></div>');
    $yunero.append('<div id="yuneroFeeds"></div>');
    $yuneroFeeds = $('#yuneroFeeds');
    itemArray = response.data.items;
    for (var i = 0; i < itemArray.length; i++) {
        if (null != yuneroListId && yuneroListId != "" && yuneroListId != "undefined") {
            id = itemArray[i].video.id;
            image = itemArray[i].video.thumbnail.sqDefault;
            title = itemArray[i].video.title;
            views = itemArray[i].video.viewCount;
            duration = itemArray[i].video.duration
        } else if (null != yuneroUser && yuneroUser != "" && yuneroUser != "undefined") {
            id = itemArray[i].id;
            image = itemArray[i].thumbnail.sqDefault;
            title = itemArray[i].title;
            views = itemArray[i].viewCount;
            duration = itemArray[i].duration
        }
        if (i % 2 == 0) clear = 'both';
        else clear = 'none';
        $yuneroFeeds.append('<div class="yunero-feed" id="' + id + '" style="clear:' + clear + '; background-image:url(\'' + image + '\'); background-size:cover; float:left; width:120px; height:90px;"></div>');
        $('#' + id).append('<div id="' + id + '-descriptor" class="descriptor"><div class="descriptor-title">' + title + '</div><div class="descriptor-views">' + views + ' <span class="descriptor-view-span">views</span></div><div class="descriptor-duration">' + secondsToTime(duration) + '</div></div>');
        $('#' + id + '-descriptor').hide()
    }
    $('.yunero-feed').mouseenter(function () {
        $('#' + this.id + '-descriptor').show()
    });
    $('.yunero-feed').mouseleave(function () {
        $('#' + this.id + '-descriptor').hide()
    });
    $('.yunero-feed').click(function () {
        $('#yuneroVideoFrame').attr('src', 'http://www.youtube.com/embed/' + this.id + '?rel=0&amp;showinfo=0');
        $('#yuneroVideoFrame').show();
        $('#yunero').animate({
            scrollTop: 0
        }, 'slow')
    })
}
function loadYunero() {
    var style = '<style>#yunero {width:' + yuneroWidgetWidth + 'px; height:' + yuneroWidgetHeight + 'px; margin:0px auto;border:1px solid rgb(215,215,215);overflow-y:auto;overflow-x:hidden;}#yuneroFeeds {width:260px;margin:0px auto;}#yuneroFeedName {background-color:rgb(242,242,242);color:#3b5998;line-height:20px;}#yuneroVideoDiv {width:100%;}.yunero-feed {cursor:pointer;cursor:hand;margin:5px;}.descriptor {color:white;background-color:black;opacity:0.8;width:100%;height:100%;overflow:hidden;font-family: Calibri;font-size: 12px;text-align:center;}.descriptor-title {height:75%;padding-top:5px;padding-left:5px;padding-right:5px;overflow:hidden;}.descriptor-views {height:25%;width:60%;float:left;text-align:left;padding-left:5px;overflow:hidden;}.descriptor-duration {height:30%;width:30%;float:left;text-align:right;padding-right: 5px;overflow:hidden;}.descriptor-view-span {font-size:10px;}</style>';
    $('html > head').append(style);
    var apiURL = createAPI();
    $.ajax({
        url: apiURL,
        type: "GET",
        cache: false,
        dataType: 'json',
        success: function (response) {
            showWidget(response)
        },
        error: function (html) {
            alert(html)
        },
        beforeSend: setHeader
    });

    function setHeader(xhr) {
        if (xhr && xhr.overrideMimeType) {
            xhr.overrideMimeType("application/j-son;charset=UTF-8")
        }
    }
}
$(window).load(function () {
    loadYunero()
});