$(document).ready(function () {

    function readSingleFile(e) {
        var file = e.target.files[0];
        if (!file) {
            return;
        }
        var reader = new FileReader();
        reader.onload = function (e) {
            contents = e.target.result;
            myAjax("/file", contents, '.file-content');

            myAjax("/data-processing", null, ".data-processing");

            myAjax("/data-processing", null, ".data-analysys");

            myAjax("/data-analysis", null, ".data-analysis");
            myAjax("/estimation", 5, ".data-estymacja");

            displayItemById('estimationForm', 7000);

        };

        reader.readAsText(file);
    }

    document.getElementById('file-input')
        .addEventListener('change', readSingleFile, false);



    $(document).on("click", ".blocked", function (event) {
        document.getElementById('form-popup').style.display = 'none';
        $('.mainPage').removeClass("blocked");

    });

    $(document).on("click", ".generateAnalysis", function (event) {

    });


    $(document).on("click", ".estymacjaZmien", function (event) {

        event.preventDefault();
        popup("estimation");
    });

    $(document).on("click", "#submitEstimation", function (event) {

        event.preventDefault();
        var form = {};
        form.formValue = $('#formValueEstimation').val();
        form.formValue = parseFloat(form.formValue);
        myAjax("/estimation", form.formValue, ".data-estymacja");
        document.getElementById('form-popup').style.display = 'none';
        $('.mainPage').removeClass("blocked");
    });

    $(document).on("mouseenter", ".logout", function (event) {

        var img = $("img", this);
        var old_src = img.attr("src").split(".");
        var new_src = old_src[0] + "-hover." + old_src[1];
        img.attr("src", new_src);
    });

    $(document).on("mouseleave", ".logout", function (event) {

        var class_name = $(this).attr("class");
        var img = $("img", this);
        img.attr("src", "img/" + class_name + ".png");

    });

    $(document).on("click", ".logout", function (event) {

        event.preventDefault();
        popup("logout");
    });

    //formularz estymacja panel
    $(document).on("click", "#submit", function (event) {

        event.preventDefault();

        var form = {};
        form.formValue = $('#formValue').val();
        form.formUnit = $('#formUnit').val();

        $.ajax({
            url: "/calculate",
            data: form,
            type: "POST",
            ajaxContentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            ajaxProcessData: true,
            success: function (response) {

                $('.calculate').html(response);
            },
            error: function (response) {
                // console.log("error: ", response);
            },
        });

    });
});

function myAjax(myUrl, contents, divClass) {
    $.ajax({
        url: myUrl,
        data: {data: contents},
        type: "POST",
        async: true,
        ajaxContentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        ajaxProcessData: true,
        success: function (response) {
            $(divClass).html(response);
        },
        error: function (response) {
            document.getElementById('form-popup').style.display = 'block';
            $('.mainPage').addClass("blocked");
            $('.form-popup').html('Niepoprawny format pliku');
        },
    });
}

function popup(action) {
    $.ajax({
        url: "/popup",
        data: {action: action},
        type: "POST",
        async: true,
        ajaxContentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        ajaxProcessData: true,
        success: function (response) {
            $('.form-popup').html(response);
            document.getElementById('form-popup').style.display = 'block';
            $('.mainPage').addClass("blocked");
        },
        error: function (response) {
            $('.form-popup').html(response);
            document.getElementById('form-popup').style.display = 'block';
            $('.mainPage').addClass("blocked");
        },
    });
}

function displayItemById(id, time) {
    setTimeout(function () {
        document.getElementById(id).style.display = 'block';
    }, time);
}