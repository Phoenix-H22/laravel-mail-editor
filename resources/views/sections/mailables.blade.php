@extends('dashboard.layouts.default')
@section('title', 'View Mailables')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card dz-card" id="accordion-one">
                <div class="card-header flex-wrap">
                    <div>
                        <h4 class="card-title">{{$page_title ??  __('Mailables') }}</h4>
                    </div>
                    @if (!$mailables->isEmpty())
                        <a class="btn btn-primary" href="#newMailableModal" data-bs-toggle="modal" data-bs-target="#newMailableModal">{{ __('Add Mailable') }}</a>
                    @endif
                </div>
                <div class="card-body pt-0">
                            @if ($mailables->isEmpty())

                            @component('maileclipse::layout.emptydata')

                                <span class="mt-4">{{ __("We didn't find anything - just empty space.") }}</span><button class="btn btn-primary mt-3" data-toggle="modal" data-target="#newMailableModal">{{ __('Add New Mailable') }}</button>

                            @endcomponent

                            @endif

                            @if (!$mailables->isEmpty())
                            <!---->
                            <table id="example3" class="table table-responsive datatables-bordered dataTable table-hover table-sm mb-0 penultimate-column-right">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ config('maileclipse.display_as_subject') ? __('Subject') : __('Namespace')}}</th>
                                        <th scope="col">{{ __('Last edited') }}</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($mailables->all() as $mailable)
                                    <tr id="mailable_item_{{ $mailable['name'] }}">
                                        <td class="pr-0">
                                            {{ $mailable['name'] }}
                                        </td>
                                        <td class="text-muted" title="{{ $mailable['namespace'] }}">{{ config('maileclipse.display_as_subject') ? $mailable['subject'] : $mailable['namespace'] }}</td>

                                        <td class="table-fit"><span>{{ (\Carbon\Carbon::createFromTimeStamp($mailable['modified']))->diffForHumans() }}</span></td>

                                        <td class="table-fit">
                                            <a href="{{ route('viewMailable', ['name' => $mailable['name']]) }}" class="btn btn-primary btn-sm">
                                                <i class="far fa-eye"></i>
                                            </a>

                                            <a href="#" class="btn btn-danger btn-sm remove-item" data-mailable-name="{{ $mailable['name'] }}">
                                                <i class="far fa-trash"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>

                        <div class="modal fade" id="newMailableModal" tabindex="-1" role="dialog" aria-labelledby="newMailableModal" aria-hidden="true">
          <div class="modal-dialog" role="document">
          <form id="create_mailable" action="{{ route('generateMailable') }}" method="POST">
            @csrf
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Mailable</h5>
                <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                  <span style="font-size: 1.8rem;" aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="alert alert-warning new-mailable-alerts d-none" role="alert">

                </div>
                  <div class="form-group">
                    <label for="mailableName">Name</label>
                    <input type="text" class="form-control" id="mailableName" name="name" placeholder="Mailable name" required>
                    <small class="form-text text-muted">Enter mailable name e.g <b>Welcome User</b>, <b>WelcomeUser</b></small>
                  </div>
                  <div class="form-group">
                    <label class="checkbox-inline">
                        <input type="checkbox" class="form-check-input" id="markdown--truth" value="option1"> Markdown Template
                        <small class="form-text text-muted">Use markdown template</small>
                    </label>
                </div>
                <div class="form-group markdown-input" style="display: none;">
                    <label for="markdownView">Markdown</label>
                    <input type="text" class="form-control" name="markdown" id="markdownView" placeholder="e.g markdown.view">
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <input type="checkbox" class="form-check-input" id="forceCreation" name="force"> Force
                        <small class="form-text text-muted">Force mailable creation even if already exists</small>
                    </label>
                </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create Mailable</button>
              </div>
            </div>
        </form>

            </div>

        </div>
    </div>
    </div>

@push('scripts')
<script type="text/javascript">

    $(document).ready(function(){

        if ($('#markdown--truth').is(':checked')) {

                $('.markdown-input').show();
            } else {

                $('.markdown-input').hide();
            }

        $('#markdown--truth').change(
        function(){
            if ($(this).is(':checked')) {

                $('.markdown-input').show();
            } else {

                $('.markdown-input').hide();
            }
        });

    $('.remove-item').click(function(){
        var mailableName = $(this).data('mailable-name');
        Swal.fire({
    title: 'Are you sure?',
    text: 'Delete Mailable ' + mailableName + '?',
    type: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'No, keep it'
}).then((result) => {
    if (result.value) {
        // User confirmed, proceed with the deletion
        $.ajax({
            type: 'POST',
            url: "{{ route('deleteMailable') }}",
            data: {
                mailablename: mailableName,
                _token: "{{ csrf_token() }}",
            },
            success: function (response) {
                if (response.status == 'ok') {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Mailable deleted',
                        type: 'success',
                        confirmButtonText: 'Ok'
                    });

                    $('tr#mailable_item_' + mailableName).fadeOut('slow');

                    var tbody = $("#example3 tbody");

                    if (tbody.children().length <= 1) {
                        location.reload();
                    }
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Mailable not deleted',
                        type: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            },
            error: function (error) {
                Swal.fire({
                    title: 'Error!',
                    text: error.responseText,
                    type: 'error',
                    confirmButtonText: 'Ok'
                });
            },
        });
    }
});


    });
});

    $('form#create_mailable').on('submit', function(e){
        e.preventDefault();
        // /generateMailable
        // new-mailable-alerts
        //
        //


    if ( $('input#markdown--truth').is(':checked') && $('#markdownView').val() == '')
    {
        $('#markdownView').addClass('is-invalid');
        return;
    }


    $.ajax({
    type: 'POST',
    url: $(this).attr('action'),
    data: $(this).serialize(),
    success: function (response) {
        if (response.status == 'ok') {
            $('#newMailableModal').modal('toggle');
            Swal.fire({
                title: 'Success!',
                text: response.message,
                type: 'success',
                confirmButtonText: 'Ok'
            })

            setTimeout(function () { location.reload(); }, 1000);
        } else {
            $('.new-mailable-alerts').text(response.message);
            $('.new-mailable-alerts').removeClass('d-none');
        }
    },
    error: function (error) {
               Swal.fire({
                title: 'Error!',
                text: error.responseText,
                type: 'error',
                confirmButtonText: 'Ok'
            })
    },
});


    });


</script>
@endpush

@endsection
