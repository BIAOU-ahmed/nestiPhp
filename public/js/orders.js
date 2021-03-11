$(document).ready(function() {
    $('.order').click(function() {
        $('#orderLineDetail').html("")
        var order = $(this).data("id");
        let barUrl = $(this).data("url");
        $(".order").css("background-color", "white");
        $(this).css("background-color", "#fac02e");
        console.log(barUrl)
        if (order != "") {
            $.ajax({
                type: 'POST',
                url: barUrl + '/user/orderLines',
                data: 'order=' + encodeURIComponent(order),
                success: function(data) {
                    if (data != "") {
                        console.log(data)

                        let n = JSON.parse(data)
                            // console.log(n)

                        for (var k in n) {
                            let orderline = "<span>" + n[k].unitQuantity + ' ' + n[k].unitName + ' de ' + n[k].productName + " x " + n[k].quantity + "</span><br>"
                            $('#orderLineDetail').append(orderline);
                            $('#order-id').html('N°' + order);
                        }
                    }

                }

            })
        }
    })
})