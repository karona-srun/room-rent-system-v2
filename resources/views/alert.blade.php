@if ($message = Session::get('success'))
<div class="alert alert-solid-success" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
    <strong class="me-3">អបអរសាទរ!</strong>{{ $message }}
</div>
@endif
@if ($message = Session::get('delete'))
<div class="alert alert-solid-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
    <strong class="me-3">អបអរសាទរ!</strong>{{ $message }}
</div>
@endif