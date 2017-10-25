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
        };

        reader.readAsText(file);
        displayItemById('title1');
        displayItemById('drugi', 2000);
    }

    document.getElementById('file-input')
        .addEventListener('change', readSingleFile, false);


    $(document).on("click", ".generateTable", function (event) {

        console.log("clicked generateTable");

        event.preventDefault();
        myAjax("/data-processing", null, ".data-processing");
        // document.getElementById('form-popup').style.display = 'block';
        // $('.mainPage').addClass("blocked");
        displayItemById('title2');
        displayItemById('trzeci', 2000);
    });

    $(document).on("click", ".blocked", function (event) {
        document.getElementById('form-popup').style.display = 'none';
        $('.mainPage').removeClass("blocked");

    });

    $(document).on("click", ".generateAnalysis", function (event) {

        console.log("clicked generateAnalysis");

        event.preventDefault();
        myAjax("/data-analysis", null, ".data-analysis");
        displayItemById('title3');
        displayItemById('minmax', 2000);
        displayItemById('wartOczekiwana', 3000);
        displayItemById('mediana', 4000);
        displayItemById('SD', 5000);
        displayItemById('pearson', 6000);
        displayItemById('regresja', 7000);
        displayItemById('kwartyl', 8000);
        displayItemById('pktOddalone', 9000);
        displayItemById('czwarty', 12000);
    });

    $(document).on("click", ".estymacja", function (event) {

        event.preventDefault();
        myAjax("/estimation", 5, ".data-estymacja");
        displayItemById('title4');
        displayItemById('estimationForm', 2000);
        // displayItemById('piaty', 3000);
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

    $(document).on("click", "#submit", function (event) {

        event.preventDefault();

        var form = {};
        form.formValue = $('#formValue').val();
        form.formUnit = $('#formUnit').val();

        // myAjax("/calculate", form, ".calculate");

        $.ajax({
            url: "/calculate",
            data: form,
            type: "POST",
            ajaxContentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            ajaxProcessData: true,
            success: function (response) {

                $('.calculate').html('<pre>' + response + '</pre>');
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
            $(divClass).html('<pre>' + response + '</pre>');
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