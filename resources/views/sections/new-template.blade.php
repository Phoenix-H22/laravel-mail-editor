@extends('dashboard.layouts.default')
@section('title', 'Create Template')
@section('content')

<div class="container-fluid">
    <div class="row">

        <div class="col-12">




            <div class="card dz-card">
                <div class="card-header">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-html-tab" data-bs-toggle="pill" href="#pills-html" role="tab" aria-controls="pills-html" aria-selected="true">HTML</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-markdown-tab" data-bs-toggle="pill" href="#pills-markdown" role="tab" aria-controls="pills-markdown" aria-selected="false">Markdown</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-html" role="tabpanel" aria-labelledby="pills-html-tab">
                        <div class="row ">

@foreach( $skeletons->get('html') as $name => $subskeleton )


       <div class="col-4">
        <div class="card">
            <div class="content template-item" data-bs-toggle="modal" data-bs-target="#select{{ $name }}Modal">
              <div class="content-overlay"></div>
                <div class="card-header embed-responsive 4by3">
                    @if ( file_exists( public_path("vendor/maileclipse/images/skeletons/html/{$name}.png") ) )

                    <img class="content-image card-img-top" src="{{ asset('vendor/maileclipse/images/skeletons/html/'.$name.'.png' ) }}" alt="{{ $name }}" style="height: 20rem;">

                  @elseif( file_exists( public_path( "vendor/maileclipse/images/skeletons/html/{$name}.jpg" ) ) )

                    <img class="content-image card-img-top" src="{{ asset('vendor/maileclipse/images/skeletons/html/'.$name.'.jpg' ) }}" alt="{{ $name }}" style="height: 20rem;">

                  @else

                  <img class="content-image card-img-top" src="{{ asset('vendor/maileclipse/images/skeletons/no-image.png' ) }}" alt="{{ $name }}" style="height: 20rem;">

                  @endif
                </div>


              <div class="card-body">
                <h4 class="card-title">{{ $name }}</h4>
              </div>

            </div>
            </div>
       </div>




<!-- Modal -->
@foreach($subskeleton as $skeleton)
<div class="modal fade" id="select{{ $name }}Modal" tabindex="-1" role="dialog" aria-labelledby="selectTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectTemplateModalLabel">{{ ucfirst($name) }}</h5>
                <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                    <span style="font-size: 1.8rem;" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Select Template:</p>
                <div class="list-group list-group-flush">
                    @foreach($subskeleton as $skeleton)
                        <a href="{{ route('newTemplate', ['type' => 'html','name' => $name, 'skeleton' => $skeleton]) }}" class="list-group-item list-group-item-action">{{ $skeleton }}</a>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- End modal -->

@endforeach


</div>
                    </div>
                    <div class="tab-pane fade" id="pills-markdown" role="tabpanel" aria-labelledby="pills-markdown-tab">
                        <div class="row">
                        <!-- markdown -->
                        @foreach( $skeletons->get('markdown') as $name => $subskeleton )

<div class="col-4">
    <div class="card">
        <!-- <img class="card-img-top" src="https://1rj8i398ld62y6ih02fyvv4k-wpengine.netdna-ssl.com/wp-content/uploads/2018/12/mantra-welcome.png" alt="Card image cap"> -->
        <div class="content template-item" data-bs-toggle="modal" data-bs-target="#{{ $name }}Modal">
          <div class="content-overlay"></div>
          <div class="card-header embed-responsive 4by3">
          @if ( file_exists( public_path("vendor/maileclipse/images/skeletons/markdown/{$name}.png") ) )

            <img class="content-image card-img-top" src="{{ asset('vendor/maileclipse/images/skeletons/markdown/'.$name.'.png' ) }}" alt="{{ $name }}" style="height: 20rem;">

          @elseif( file_exists( public_path( "vendor/maileclipse/images/skeletons/markdown/{$name}.jpg" ) ) )

            <img class="content-image card-img-top" src="{{ asset('vendor/maileclipse/images/skeletons/markdown/'.$name.'.jpg' ) }}" alt="{{ $name }}" style="height: 20rem;">

          @else

          <img class="content-image card-img-top" src="{{ asset('vendor/maileclipse/images/skeletons/no-image.png' ) }}" alt="{{ $name }}" style="height: 20rem;">

          @endif
          </div>

          <div class="card-body">
            <h4 class="card-title">{{ $name }}</h4>
          </div>

        </div>
        </div>
</div>
<!-- Modal -->

<div class="modal fade" id="{{ $name }}Modal" tabindex="-1" role="dialog" aria-labelledby="selectTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectTemplateModalLabel">{{ ucfirst($name) }}</h5>
                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn">
                    <span style="font-size: 1.8rem;" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Select Template:</p>
                <div class="list-group list-group-flush">
                    @foreach($subskeleton as $skeleton)
                  <a href="{{ route('newTemplate', ['type' => 'markdown','name' => $name, 'skeleton' => $skeleton]) }}" class="list-group-item list-group-item-action">{{ $skeleton }}</a>
                  @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End modal -->

                        @endforeach
                    </div>
                </div>
                </div>
            </div>
</div>
        </div>
    </div>
    </div>
@push('scripts')

    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/codemirror.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/mode/xml/xml.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/mode/css/css.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/mode/javascript/javascript.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/mode/htmlmixed/htmlmixed.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.43.0/addon/display/placeholder.js"></script>
@endpush
@endsection
