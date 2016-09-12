<div class="btn-group-xs">
    <a href="{{ $show_url }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
    <a href="{{ $edit_url }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
    <button type="button" class="btn btn-danger"
            id="btn_destroy_{{ $element_id }}">
        <i class="fa fa-times"></i>
    </button>
</div>

<script>
    $('#btn_destroy_{{ $element_id }}').click(function() {
        swal({
            title: "Êtes vous sûr ?",
            text: "Voulez vous vraiment supprimer {{ $element_title }} ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Oui, je le veux !",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                type: "DELETE",
                url: "{{ $destroy_url }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            })
            .done(function (data) {
                swal("Supprimé !", "{{ $element_title }} a été supprimé !", "success");
                $("#index").DataTable().ajax.reload(null, false);
            })
            .error(function (data) {
                if (data.status == 400) {
                    var res = data.responseJSON;
                    swal({
                        title: res.title,
                        text: res.message,
                        type: res.type,
                        confirmButtonText: "OK"
                    });
                }
                else {
                    swal("Oups !", "Un problème est survenu, merci de contacter un admin.", "error");
                }
            });
        });
    });
</script>
