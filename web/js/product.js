function tabcontent(i) {
    $(".tab-contents").css("display", "none");
    $("#tab-content" + i).css("display", "block");
    $(".product-tabs").removeClass("active");
    $("#product-tab" + i).addClass("active");
}
function productpic(i) {
    $(".product-pics").removeClass("active");
    $("#product-pic" + i).addClass("active");
    $(".product-pictures").css("display", "none");
    $("#product-picture" + i).css("display", "block");
}
$(document).ready(function ()
{

    $("#num-up").click(function () {
        var $n = $("#qty");
        $n.val(Number($n.val()) + 1);
    });
    $("#num-down").click(function () {
        var $n = $("#qty");
        $n.val(Number($n.val()) - 1);
    });

    $('#collect').click(function() {
        $("#loading").css("display", "block");
        });

    $('#add-cart-button').click(function (e) {
                    e.preventDefault();
                    $this = $(this);
                    var productId = $this.attr("data-id");
                    $.ajax({
                        url:"{{path('cart_ajax_action')}}",
                        method: "POST",
                        data: {
                            id : productId,
                            no: $('#qty').val(),
                            action : "+"
                        },
                        dataType: "json"
                    })
                    .done(function (rep) {
                        console.log( rep );
                        if (rep.granted) {
                            alert("添加成功！");
                        }
                        else {
                            alert("添加失败！");
                        }
                    })
       });


   


});