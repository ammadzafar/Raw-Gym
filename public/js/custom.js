function toastrErrors(error) {
    if (!error.responseJSON.errors) {
        toastr.error(error.responseJSON.message);
    } else if (error.responseJSON.errors) {
        $.each(error.responseJSON.errors, function (key, value) {
            toastr.error(value);
        });
    }
}

function loading(key, value) {

    var ladda = Ladda.create(key.find(':submit')[0]);

    if (!value) {
        ladda.stop();
    } else {
        ladda.start();
    }
}

function refreshDiv(className) {
    $(className).load(location.href + " " + className + ">*", "");
}
