$(document).ready(function () {

    // myAjax("/login", "POST");

    $(document).on("click", ".generateTable", function (event) {

        event.preventDefault();
        myAjax("/login", "POST");

        document.getElementById('form-popup').style.display = 'block';
        $('.mainPage').addClass("blocked");

    });

    $(document).on("click", ".blocked", function (event) {
        myAjax("/login", "POST");
        document.getElementById('form-popup').style.display = 'none';
        $('.mainPage').removeClass("blocked");

    });


});

function myAjax(myUrl, myType) {

    $.ajax({
        url: myUrl,
        type: myType,
        async: true,
        ajaxContentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        ajaxProcessData: true,
        success: function (response) {

            $('.form-popup').html(response);

        },
        error: function (response) {
            // console.log("error: ", response);

        },
    });


}
