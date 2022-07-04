function setFavorite(el, schedule_id, favorite)
{
    var favInt = (favorite) ? "1" : "0";
    $(el).data("favorite", favInt)
    setFavoriteState(el, favorite);

    axios.post('/planner/setfavorite', {
        schedule_id: schedule_id,
        favorite: favorite
      })
      .then(function (response) {
        console.log(response);
      })
      .catch(function (error) {
        console.log(error);
    });
}

function setFavoriteState(el, favorite)
{
    if(favorite)
    {
        $(el).addClass("track-favorite");
        $(el).attr("data-favorite", 1);
    }
    else
    {
        $(el).removeClass("track-favorite");
        $(el).attr("data-favorite", 0);
    }

    var series_id = $(el).data("series-id");
    var series_fav_count = $("#planner-schedule-" + series_id).find(".track-container[data-favorite='1']").length;
    var planner_message = $(".planner-favorite-message[data-series-id='"+series_id+"']");
    (series_fav_count != null && series_fav_count > 0) ? planner_message.show() : planner_message.hide();
    $(".planner-favorite-count[data-series-id='"+series_id+"']").html(series_fav_count);
}

function saveSeriesNote(el)
{
    var text = $(el).val();
    var seriesId = $(el).data("series-id");

    axios.post('/planner/savenote', {
        series_id: seriesId,
        note: text
      })
      .then(function (response) {
        console.log(response);
      })
      .catch(function (error) {
        console.log(error);
    });
}

$(function() {

    $(".planner-card[data-target]").each(function(){
        $(this).on("click", function(){
            var target = $(this).data("target");
            $(".planner-visible").removeClass("planner-visible").addClass("planner-hidden");
            $(target).removeClass("planner-hidde").addClass("planner-visible");
        });
    });

    $(".track-container[data-schedule-id]").not(".track-container-inactive").not(".track-past-week").each(function(){
        setFavoriteState($(this), ($(this).data("favorite") == 1));

        $(this).on("click", function(e){
            if(e.target.nodeName != "A")
            {
                var id = $(this).data("schedule-id");
                var favorite = ($(this).data("favorite") == 1);
                setFavorite($(this), $(this).data("schedule-id"), !favorite);
            }
        });
    });

    $(".series-notes[data-series-id]").each(function(){
        $(this).on("change", function(){
            saveSeriesNote($(this));
        });
    });

});