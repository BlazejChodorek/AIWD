$(window).on('load', function() {

});


$(document).ready(function () {

    function readSingleFile(e) {
        var file = e.target.files[0];
        if (!file) {
            return;
        }
        var reader = new FileReader();
        reader.onload = function (e) {
            contents = e.target.result;
            document.getElementById('file-content').style.display = 'none';
            document.getElementById('loading').style.display = 'block';

            displayItemById("preloder-wczytywanie", 2000, 5000);
            displayItemById("preloder-obrobka", 6000, 9000);
            displayItemById("preloder-analiza", 10000, 13000);

            myAjax("/file", contents, '.file-content');
            myAjax("/data-processing", null, ".data-processing");
            myAjax("/data-processing", null, ".data-analysys");
            myAjax("/data-analysis", null, ".data-analysis");
            myAjax("/estimation", 10, ".data-estymacja");
        };

        reader.readAsText(file);
    }

    document.getElementById('file-input')
        .addEventListener('change', readSingleFile, false);


    $(document).on("click", ".blocked", function (event) {
        document.getElementById('form-popup').style.display = 'none';
        $('.mainPage').removeClass("blocked");

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
        myAjaxEstimation("/estimation", form.formValue, ".data-estymacja");
        document.getElementById('form-popup').style.display = 'none';
        $('.mainPage').removeClass("blocked");
    });

    $(document).on("click", "#danePanel", function (event) {

        event.preventDefault();
        document.getElementById('regressionCanvas').style.display = 'none';
        document.getElementById('data-processing').style.display = 'block';
        document.getElementById('data-estymacja').style.display = 'none';
    });
    $(document).on("click", "#estymacjaPanel", function (event) {

        event.preventDefault();
        document.getElementById('regressionCanvas').style.display = 'none';
        document.getElementById('data-processing').style.display = 'none';
        document.getElementById('data-estymacja').style.display = 'block';
    });
    $(document).on("click", "#wizualizacjaPanel", function (event) {

        event.preventDefault();
        document.getElementById('regressionCanvas').style.display = 'block';
        document.getElementById('data-processing').style.display = 'none';
        document.getElementById('data-estymacja').style.display = 'none';
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


    var c_canvas = document.getElementById("c");
    var context = c_canvas.getContext("2d");

    var linearRegression = new LinearRegression(context, "/linearRegression");
    linearRegression.drawGrid("#d5d5d5");
    linearRegression.drawAxes("#000000");
    linearRegression.setTitlesOfAxes("moc silnika [KM]", "przyspieszenie [s]");
    linearRegression.drawLinearRegression("#2aae1e", "#bb222c");

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
            document.getElementById('estimationForm').style.display = 'block';
            document.getElementById('myPanel').style.display = 'block';
            document.getElementById('loading').style.display = 'none';
        },
        error: function (response) {
            document.getElementById('form-popup').style.display = 'block';
            $('.mainPage').addClass("blocked");
            $('.form-popup').html('Niepoprawny format pliku');
        },
    });
}

function myAjaxEstimation(myUrl, contents, divClass) {
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

function displayItemById(id, time1, time2) {
    setTimeout(function () {
        document.getElementById(id).style.display = 'block';
    }, time1);
    setTimeout(function () {
        document.getElementById(id).style.display = 'none';
    }, time2);
}