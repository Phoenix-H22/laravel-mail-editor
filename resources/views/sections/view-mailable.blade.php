@extends('dashboard.layouts.default')
@section('title')
View {{ $resource['name'] }}
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card dz-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5>Details</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="table-fit font-weight-sixhundred">Name</td>
                                <td>
                                    {{ $resource['name'] }}
                                </td>
                            </tr>
                            <tr>
                                <td class="table-fit font-weight-sixhundred">Namespace</td>
                                <td>
                                    {{ $resource['namespace'] }}
                                </td>
                            </tr>

                            <tr>
                                <td class="table-fit font-weight-sixhundred">Subject</td>
                                @if ( empty($resource['data']->subject) )
                                    <td>
                                        <span class="text-muted">No Subject Set, The default Namespace will be used. See <a href="https://laravel.com/docs/9.x/notifications#customizing-the-subject">Customize the subject</a></span>
                                    </td>
                                @else
                                    <td>
                                        {{ $resource['data']->subject }}
                                    </td>

                                @endif
                            </tr>


                            @if ( !empty($resource['data']->locale) )
                                <tr>
                                    <td class="table-fit font-weight-sixhundred">Locale</td>
                                    <td>
                                        {{ $resource['data']->locale }}
                                    </td>
                                </tr>
                            @endif

                                <tr>
                                    <td class="table-fit font-weight-sixhundred">From</td>
                                    <td><a href="mailto:{{ !collect($resource['data']->from)->isEmpty() ? collect($resource['data']->from)->first()['address'] : config('mail.from.address') }}" class="badge badge-info mr-1 font-weight-light">
                                        @if (!collect($resource['data']->from)->isEmpty())

                                            {{ collect($resource['data']->from)->first()['address'] }}

                                            @else

                                            {{ config('mail.from.address') }} (default)

                                        @endif
                                    </a></td>
                                </tr>

                                <tr>
                                    <td class="table-fit font-weight-sixhundred">Reply To</td>
                                    <td><a href="mailto:{{ !collect($resource['data']->replyTo)->isEmpty() ? collect($resource['data']->replyTo)->first()['address'] : config('mail.reply_to.address') }}" class="badge badge-info mr-1 font-weight-light">
                                        @if (!collect($resource['data']->replyTo)->isEmpty())

                                            {{ collect($resource['data']->replyTo)->first()['address'] }}

                                            @else

                                            {{ config('mail.reply_to.address') }} (default)

                                        @endif
                                    </a></td>

                                </tr>

                            @if ( !empty($resource['data']->cc) )
                            <tr>
                                <td class="table-fit font-weight-sixhundred">cc</td>
                                <td>
                                    @foreach( $resource['data']->cc as $cc )
                                    <a href="mailto:{{ $cc['address'] }}" class="badge badge-info mr-1 font-weight-light">{{ $cc['address'] }}</a>
                                    @endforeach
                                </td>
                            </tr>
                            @endif
                            @if ( !empty($resource['data']->bcc) )
                            <tr>
                                <td class="table-fit font-weight-sixhundred">bcc</td>
                                <td>
                                    @foreach( $resource['data']->bcc as $bcc )
                                    <a href="mailto:{{ $bcc['address'] }}" class="badge badge-info mr-1 font-weight-light">{{ $bcc['address'] }}</a>
                                    @endforeach
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card dz-card" id="accordion-one">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5>Preview</h5>
                    <div>
                        @if ( $resource['view_path'] !== null )
                        <button type="button" class="btn btn-info send-test"><svg fill="#fff" width="20" enable-background="new 0 0 24 24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="m8.75 17.612v4.638c0 .324.208.611.516.713.077.025.156.037.234.037.234 0 .46-.11.604-.306l2.713-3.692z"/>
                                <path d="m23.685.139c-.23-.163-.532-.185-.782-.054l-22.5 11.75c-.266.139-.423.423-.401.722.023.3.222.556.505.653l6.255 2.138 13.321-11.39-10.308 12.419 10.483 3.583c.078.026.16.04.242.04.136 0 .271-.037.39-.109.19-.116.319-.311.352-.53l2.75-18.5c.041-.28-.077-.558-.307-.722z"/>
                            </svg> {{ __('Send Test') }}</button>
                            <a class="btn btn-primary"
                               href="{{ route('editMailable', ['name' => $resource['name']]) }}">Edit Template</a>
                        @endif
                    </div>

                </div>
                <div class="card-body ratio ratio-16x9">
                  <iframe class="w-100" src="{{ route('previewMailable', [ 'name' => $resource['name'] ]) }}" allowfullscreen></iframe>
                </div>
            </div>

        </div>
    </div>
    </div>
@push('scripts')
<script type="text/javascript">
 $(document).ready(function(){
    $('.send-test').click(function(e){
        e.preventDefault();

        Swal.fire({
            title: 'Test email recipient:',
            input: 'text',
            inputPlaceholder: 'Email',
            showCancelButton: true,
            confirmButtonText: 'Send',
            cancelButtonText: 'Cancel',
            inputValidator: (value) => {
                if (!value) {
                    return 'Please enter an email address';
                }
            }
        }).then((result) => {
            if (result) {
                sendTestMail(result.value);
            }
        });
    });

    function sendTestMail(email) {
        $.ajax({
            type: 'POST',
            url: "{{ route('sendTestMail') }}",
            data: {
                email: email,
                name: "{{ $resource['name'] }}",
                _token: "{{ csrf_token() }}",
            },
            success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Test email sent',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    });

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

</script>
@endpush
@endsection
