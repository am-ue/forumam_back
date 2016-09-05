@if (empty($option->type))
    <div id="price" class="script-option">
        Merci de choisir un type.
    </div>
@elseif($option->type == 'select')
    <div id='price' class='script-option row'>
        <div class="col-xs-12" style="margin-bottom: 5px;">
            <button type="button" class="btn btn-xs btn-default script-option add_price">
                Ajouter une ligne (laisser vide pour supprimer)
            </button>
        </div>
        @foreach($option->details as $detail)
            <div class='col-sm-8' style='margin-bottom: 5px;'>
                <input class='form-control' name='label[]' value='{{$detail->label}}' placeholder='Label' type='text'>
            </div>
            <div class='col-sm-4'>
                <input class='form-control' placeholder='Prix' value='{{$detail->price}}'
                       name='price[]' type='number' step='0.01'>
            </div>
        @endforeach
    </div>
@else
    <div id='price' class='script-option'>
        <input class='form-control' name='price' value='{{$option->details()->first()->price}}'
               type='number' step='0.01'>
    </div>
@endif

