/*!
 * Adapted from :
 * Laravel-Bootstrap-Modal-Form (https://github.com/JerseyMilker/Laravel-Bootstrap-Modal-Form)
 */

$('document').ready(function() {

    // Intercept submit.
    $('form').on('submit', function(submission) {
        submission.preventDefault();

        // Set vars.
        var form   = $(this),
          url    = form.attr('action'),
          submit = form.find('[type=submit]');

        // Check for file inputs.
        if (form.find('[type=file]').length) {

            // If found, prepare submission via FormData object.
            var input       = form.serializeArray(),
              data        = new FormData(),
              contentType = false;

            // Append input to FormData object.
            $.each(input, function(index, input) {
                data.append(input.name, input.value);
            });

            // Append files to FormData object.
            $.each(form.find('[type=file]'), function(index, input) {
                if (input.files.length == 1) {
                    data.append(input.name, input.files[0]);
                } else if (input.files.length > 1) {
                    data.append(input.name, input.files);
                }
            });
        }

        // If no file input found, do not use FormData object (better browser compatibility).
        else {
            var data        = form.serialize(),
              contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
        }

        // Please wait.
        if (submit.is('button')) {
            var submitOriginal = submit.html();
            submit.html('Traitement en cours...');
        } else if (submit.is('input')) {
            var submitOriginal = submit.val();
            submit.val('Traitement en cours...');
        }

        // Request.
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: 'json',
            cache: false,
            contentType: contentType,
            processData: false

            // Response.
        }).always(function(response, status) {

            // Reset errors.
            $('.form-group').removeClass('has-error').find('.help-block').remove();


            if (response.status == 200) {
                location.reload();
            } else {
                // Reset submit.
                if (submit.is('button')) {
                    submit.html('Renvoyer');
                } else if (submit.is('input')) {
                    submit.val('Renvoyer');
                }
                // Check for errors.
                if (response.status == 422) {
                    var errors = $.parseJSON(response.responseText);

                    // Iterate through errors object.
                    $.each(errors, function (field, message) {
                        console.error(field + ': ' + message);
                        var formGroup = $('[name="' + field + '"]', form).closest('.form-group');
                        formGroup.addClass('has-error').append('<p class="help-block">' + message + '</p>');
                    });

                } else if (response.status == 413) {
                    var formGroup = $('[type=file]', form).closest('.form-group');
                    formGroup.addClass('has-error').append('<p class="help-block">Le fichier semble trop gros, merci de réessayer avec un fichier plus léger.</p>');

                } else {
                    swal("Oups !", "Un problème est survenu...", "error");
                }
            }
        });
    });

});
