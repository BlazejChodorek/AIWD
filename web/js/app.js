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

        event.preventDefault();
        myAjax("/data-processing", null, ".data-processing");
        displayItemById('title2');
        displayItemById('trzeci', 2000);
    });

    $(document).on("click", ".generateAnalysis", function (event) {

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
        // displayItemById('czwarty', 12000);
    });

    // $(document).on("click", ".estymacja", function (event) {
    //
    //     event.preventDefault();
    //     myAjax("", null, ".data-estymacja");
    //     displayItemById('title2');
    //     displayItemById('piaty', 2000);
    // });



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
            // console.log("error: ", response);
            $(divClass).html('<pre>' + 'Niepoprawny format pliku' + '</pre>');

        },
    });
}

function displayItemById(id, time) {
    setTimeout(function () {
        document.getElementById(id).style.display = 'block';
    }, time);
}