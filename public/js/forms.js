/* ================= Checkbox ================= */

$("[rel=switch]").onoff();

/* ================= Select ================= */
$(function () {
    $("[rel=select2]").select2({
    });
    $("[rel=taginput]").select2({
        tags: true,
        tokenSeparators: [',']
    });
});

/* ================= ColorPicker ================= */
$(function () {
    $("[rel=colorpicker]").each(function () {
        $(this).wrap('<div class="input-group colorpicker-component"></div>');
        $(this).after('<span class="input-group-addon"><i></i></span>');
        $(this).parent(".input-group").colorpicker({format: 'hex'});
    });

});