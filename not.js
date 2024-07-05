let notif = document.getElementById('notif');
let conte = document.getElementById('notif-content');
notif.addEventListener("click", () => {

    if (conte.classList.contains("expanded")) {
        conte.classList.remove("expanded")
    } else {
        conte.classList.add("expanded")
    }
})
$(".markAsRead").click(function a()
{
    let oh = $(this);
    let ReadId = $(this).data("id")
    $.ajax({
        url: '',
        data: {"ReadID": ReadId},
        type: 'POST',
        success: function(result)
        {
            if (result==="ok") {
                let par = oh.parent().parent();
                par.removeClass("new")
                par.find("i").remove()
            }
        }
    });
})

$("#clear").click(function a()
{
    $.ajax({
        url: '',
        data: {"Clear": "true"},
        type: 'POST',
        success: function(result)
        {
            if (result === "ok") {
                console.log("kk")
                $(".empty").siblings().remove()
                $(".empty").parent().siblings().remove()
                $(".empty").addClass("visible")
            }
        }
    });
})
