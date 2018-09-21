$(document).ready(function(){
    let taskFields = ["userName", "email", "text", "image"];

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            if (reader.size > 10) {
                alert('max upload size is 1k')
            }
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image").change(function(){
        readURL(this);
    });


    showErrors = function(errors) {
        if(typeof errors.errors !== 'undefined' && typeof errors.errors.entity !== 'undefined') {
            taskFields.forEach(function (item, i, taskFields) {
                if(typeof errors.errors.entity[item] !== 'undefined') {
                    id = "#"+item;
                    idMessage = "#"+item+"-invalid-feedback";
                    $( id ).addClass( "is-invalid" );
                    $( idMessage ).html( errors.errors.entity[item] );
                    if (item == "image") {
                        $( idMessage ).show();
                    }
                }
            });
        }
    };

    $('#blah').on('click', function() {
        console.log("click blah");
        simulateClick();
    });
    $('#image').on('click' , function(){
        console.log("click image");
    });
    function simulateClick() {
        let event = new MouseEvent('click', {
            'view': window,
            'bubbles': true,
            'cancelable': true
        });
        let cb = document.getElementById('image');
        cb.dispatchEvent(event);
    }

    $('#createTaskButton').on('click', function() {
        $.ajax({
            url: '/taskCreate',
            type: 'POST',
            data: new FormData($('form')[0]),
            cache: false,
            contentType: false,
            processData: false,
            xhr: function() {
                $(".is-invalid").removeClass( "is-invalid" );
                $(".invalid-feedback").html("");
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    myXhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            $('progress').attr({
                                value: e.loaded,
                                max: e.total,
                            });
                        }
                    } , false);
                }
                return myXhr;
            }
        })
            .done(function( data ) {
                window.location.href = "/";
            })
            .fail(function(data) {
                showErrors(JSON.parse(data.responseText));
            })
        ;
    });
});
