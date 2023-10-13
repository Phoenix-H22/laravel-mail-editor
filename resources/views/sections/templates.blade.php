@extends('dashboard.layouts.default')
@section('title', 'View Templates')
@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card dz-card" id="accordion-one">
                <div class="card-header flex-wrap">
                    <div>
                        <h4 class="card-title">{{$page_title ??  __('Templates') }}</h4>
                    </div>
                    @if (!$templates->isEmpty())
                    <a href="{{ route('selectNewTemplate') }}" class="btn btn-primary">{{ __('Add Template') }}</a>
                    @endif
                </div>
                <div class="card-body pt-0">
                    @if ($templates->isEmpty())

                    @component('maileclipse::layout.emptydata')

                        <span class="mt-4">{{ __("We didn't find anything - just empty space.") }}</span>
                        <a class="btn btn-primary mt-3" href="{{ route('selectNewTemplate') }}">{{ __('Add New Template') }}</a>

                    @endcomponent

                    @endif

                    @if (!$templates->isEmpty())
                    <!---->
                    <table id="example3">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Description') }}</th>
                                <th scope="col">{{ __('Template') }}</th>
                                <th scope="col">{{ __('Template Skeleton') }}</th>
                                <th scope="col" class="text-center">{{ __('Type') }}</th>
                                <th scope="col">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                        @foreach($templates->all() as $template)
                            <tr id="template_item_{{ $template->template_slug }}">
                                <td>{{ ucwords($template->template_name) }}</td>
                                <td title="/tee">{{ $template->template_description }}</td>

                                <td>{{ ucfirst($template->template_view_name) }}</td>


                                <td>{{ ucfirst($template->template_skeleton) }}</td>

                                <td>{{ ucfirst($template->template_type) }}</td>

                                <td>
                                    <a href="{{ route('viewTemplate', [ 'templatename' => $template->template_slug ]) }}" class="btn btn-primary btn-sm">
                                        <i class="far fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-sm remove-item" data-template-slug="{{ $template->template_slug }}" data-template-name="{{ $template->template_name }}">
                                        <i class="far fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @endif
                    <!---->
                </div>



            </div>

        </div>
    </div>
    </div>

@push('scripts')
<script type="text/javascript">
$('.remove-item').click(function(){
    var templateSlug = $(this).data('template-slug');
    var templateName = $(this).data('template-name');

    Swal.fire({
        title: 'Are you sure?',
        html: 'Delete Template <b>' + templateName + '</b>',
        type: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, keep it'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: "{{ route('deleteTemplate') }}",
                data: {
                    templateslug: templateSlug,
                },
                success: function (response) {
                    if (response.status == 'ok') {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Template deleted',
                            type: 'success',
                            confirmButtonText: 'Ok'
                        });

                        $('tr#template_item_' + templateSlug).fadeOut('slow');

                        var tbody = $("#example3 tbody");

                        // console.log(tbody.children().length);

                        if (tbody.children().length <= 1) {
                            location.reload();
                        }
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Template not deleted',
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


</script>
@endpush

@endsection
