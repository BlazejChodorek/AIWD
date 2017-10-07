$(document).ready(function () {

    function smoothScroll(target, offset) {
        $('html, body').animate({
            scrollTop: $(target).offset().top - offset
        }, 1000);
    }

    $('.js-scroll').on('click', function (event) {
        event.preventDefault();
        var $this = $(this);
        var url = $this.attr('href');

        var offset = $('myPanel').outerHeight();
        if (!$('myPanel').hasClass('padded-top') && window.innerWidth < 968) {
            offset += 72;
        }

        if ($this.hasClass('arrow-down')) {
            offset = $('myPanel').outerHeight();
        }

        $this.parents('ul').removeClass('is-shown');
        smoothScroll(url, offset);
    });

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
    }

    document.getElementById('file-input')
        .addEventListener('change', readSingleFile, false);


    $(document).on("click", ".generate", function (event) {

        event.preventDefault();
        console.log("weszlo");
        myAjax("/data-processing", null, ".data-processing");

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
            // console.log("error: ", response);
            $(divClass).html('<pre>' + 'Niepoprawny format pliku' + '</pre>');

        },
    });
}