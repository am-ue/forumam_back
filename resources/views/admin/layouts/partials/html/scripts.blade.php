<!-- REQUIRED JS SCRIPTS -->

<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script>$.fn.modal.Constructor.prototype.enforceFocus = function() {};</script>

<!-- select2 -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/fr.js"></script>

<!-- jquery-toggles -->
<script type="text/javascript" src="{{ asset('plugins/onoff/jquery.onoff.min.js')}}"></script>

<script src="{{ asset('plugins/bootstrap-datetimepicker/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/colorpicker/bootstrap-colorpicker.min.js') }}" type="text/javascript"></script>

<!-- SweetAlert -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte/app.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>

<!-- Custom -->
<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

<!-- Loaded by page -->
@stack('scripts')
