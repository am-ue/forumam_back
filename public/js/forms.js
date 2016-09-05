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

/* ================= Option form ================= */
$(function () {
    if($(".script-option").length) {
        var $price_div = $("#price.script-option");
        var $inputs = '<div class="col-sm-8" style="margin-bottom: 5px;"><input class="form-control" name="label[]" placeholder="Label" type="text"></div><div class="col-sm-4"><input class="form-control" placeholder="Prix" name="price[]" type="number" step="0.01"></div>';
        var $add_btn = '<div class="col-xs-12" style="margin-bottom: 5px;"><button type="button" class="btn btn-xs btn-default script-option add_price">Ajouter une ligne (laisser vide pour supprimer)</button></div>';

        $("select[name=type].script-option").change(function () {
            if (this.value == 'select') {
                $($price_div).addClass('row');
                $($price_div).fadeIn('slow').html($add_btn);
                $($inputs).fadeIn('slow').appendTo($price_div);
                $($inputs).fadeIn('slow').appendTo($price_div);
            } else {
                $($price_div).removeClass('row');
                $($price_div).html('<input class="form-control" name="price" type="number" step="0.01">');
            }
            $($price_div).closest('.form-group').removeClass('has-error').find('.help-block').remove();

        });
        $price_div.on('click', "button.script-option.add_price", function() {
            $($inputs).fadeIn('slow').appendTo($price_div);
        });
    }
});

