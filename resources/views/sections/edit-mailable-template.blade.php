@extends('dashboard.layouts.default')
@section('title')
Edit Mailable {{ $templateData['template_name'] }}
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-2 d-block d-lg-none">
            <div id="accordion">
              <div class="card">
                <div class="card-header" id="headingOne">
                  <h5 class="mb-0 dropdown-toggle" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Details
                  </h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-bs-parent="#accordion">
                  <div class="card-body">
                    <p style="font-size: .9em;"><b class="font-weight-sixhundred">Mailable:</b> <a href="{{ route('viewMailable', ['name' => $name]) }}">{{ $name }}</a></p>
                    <p style="font-size: .9em;"><b class="font-weight-sixhundred">Namespace:</b> {{ $templateData['namespace'] }}</p>
                    <p style="font-size: .9em;"><b class="font-weight-sixhundred">{{ $templateData['is_markdown'] ? 'Markdown' : 'View' }}:</b> {{ $templateData['template_name'] }}</p>
                </div>
                </div>
              </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-12">
            <div class="card">
                <div class="card-header p-3" style="border-bottom:1px solid #e7e7e7e6;">
                    <button type="button" class="btn btn-success float-right save-template">Update</button>
                    <button type="button" class="btn btn-secondary float-right preview-toggle mr-2"><i class="far fa-eye"></i> Preview</button>
                    <button type="button" class="btn btn-light mr-2 save-draft disabled">Save Draft</button>
                    <button type="button" class="btn btn-info float-right mr-2 send-test"><svg fill="#fff" width="20" enable-background="new 0 0 24 24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="m8.75 17.612v4.638c0 .324.208.611.516.713.077.025.156.037.234.037.234 0 .46-.11.604-.306l2.713-3.692z"/>
                            <path d="m23.685.139c-.23-.163-.532-.185-.782-.054l-22.5 11.75c-.266.139-.423.423-.401.722.023.3.222.556.505.653l6.255 2.138 13.321-11.39-10.308 12.419 10.483 3.583c.078.026.16.04.242.04.136 0 .271-.037.39-.109.19-.116.319-.311.352-.53l2.75-18.5c.041-.28-.077-.558-.307-.722z"/>
                        </svg> {{ __('Send Test') }}</button>

                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Editor</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link {{ !is_null($templateData['text_template']) ? '' : 'disabled' }}" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Plain Text</a>
                            </li>
                          </ul>
                </div>

            <div class="tab-content" id="pills-tabContent">


              <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="p-3" style="border-top: 1px solid #ccc;">
                @foreach($templateData['view_data'] as $param)

                       @if (isset($param['data']['type']) && $param['data']['type'] === 'model')
                            <div class="btn-group dropright">
                              <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" maileclipse-data-bs-toggle="tooltip" data-bs-placement="top" title="Elequent Model">
                                <i class="fas fa-database mr-1"></i>{{ $param['key'] }}
                              </button>
                              <div class="dropdown-menu">

                                <!-- Dropdown menu links -->
                                @if ( !$param['data']['attributes']->isEmpty() )
                                        <a class="dropdown-item view_data_param m-1" param-key="{{ $param['key'] }}" href="#param">{{ $param['key'] }}</a>
                                        <div class="dropdown-divider"></div>
                                    @foreach( $param['data']['attributes'] as $key => $val )
                                        <a class="dropdown-item is-attribute view_data_param m-1" param-parent-key="{{ $param['key'] }}" param-key="{{ $key }}" href="#param">{{ $key }}</a>
                                    @endforeach

                                    @else

                                    <span class="dropdown-item">No attributes found</span>

                                @endif

                              </div>
                            </div>

                            @elseif(isset($param['data']['type']) && $param['data']['type'] === 'elequent-collection')

                                <button type="button" class="btn btn-info btn-sm view_data_param m-1 m-1" maileclipse-data-bs-toggle="tooltip" data-bs-placement="top" title="Elequent Collection" param-key="{{ $param['key'] }}">
                                <i class="fa fa-table mr-1" aria-hidden="true"></i>{{ $param['key'] }}
                                </button>

                            @elseif(isset($param['data']['type']) && $param['data']['type'] === 'collection')

                                <button type="button" class="btn btn-success btn-sm view_data_param m-1" maileclipse-data-bs-toggle="tooltip" data-bs-placement="top" title="Collection" param-key="{{ $param['key'] }}">
                                <i class="fa fa-table mr-1" aria-hidden="true"></i>{{ $param['key'] }}
                                </button>

                            @else

                                <button type="button" class="btn btn-secondary btn-sm view_data_param m-1" maileclipse-data-bs-toggle="tooltip" data-bs-placement="top" title="Simple Variable" param-key="{{ $param['key'] }}">
                                <i class="fa fa-anchor mr-1" aria-hidden="true"></i>{{ $param['key'] }}
                                </button>

                            @endif

                    @endforeach
                </div>
                <textarea id="template_editor" cols="30" rows="10">{{ $templateData['template'] }}</textarea>
              </div>
              <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                @if(!is_null($templateData['text_template']))
                    <textarea id="plain_text" cols="30" rows="10">{{ $templateData['text_template'] }}</textarea>
                @endif
              </div>
            </div>

            </div>
        </div>
        <div class="col-lg-3 d-none d-lg-block">
            <div class="card">
                <div class="card-header"><h5>Details</h5></div>
                <div class="card-body">
                    <p style="font-size: .9em;"><b class="font-weight-sixhundred">Mailable:</b> <a href="{{ route('viewMailable', ['name' => $name]) }}">{{ $name }}</a></p>
                    <p style="font-size: .9em;"><b class="font-weight-sixhundred">Namespace:</b> {{ $templateData['namespace'] }}</p>
                    <p style="font-size: .9em;"><b class="font-weight-sixhundred">{{ $templateData['is_markdown'] ? 'Markdown' : 'View' }}:</b> {{ $templateData['template_name'] }}</p>
                    <!-- <p class="text-danger"><i class="fas fa-trash align-middle"></i><a href="#">Send to trash</a></p> -->
                    {{-- <p class="text-danger"><i class="fas fa-trash"></i> Delete Template</p> --}}
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
 @push('scripts')
 <script src="{{asset("dashboard-debs/tinymce/tinymce.min.js")}}"></script>
 @foreach($plugins as $plugin)
 <script src="{{asset("dashboard-debs/tinymce/plugins/".$plugin."/plugin.min.js")}}"></script>
 @endforeach
 @endpush
@push('scripts')
<script type="text/javascript">

    $(document).ready(function(){

    $('.send-test').click(function(e){
        e.preventDefault();

        Swal.fire({
            title: 'Test email recipient:',
            input: 'text',
            inputPlaceholder: 'Email'
        }).then((result) => {
            if(result.value) {
                sendTestMail(result.value);
            }
        });
    });

    function sendTestMail(email) {
        $.ajax({
            method: 'POST',
            url: "{{ route('sendTestMail') }}",
            data: {
                email: email,
                name: '{{ $name }}',
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                Swal.fire('Success', 'Test email sent', 'success');
            },
            error: function(error) {
                Swal.fire('Error', error, 'error');
            }
        });
    }

    @if ( isset($templateData['template']) )

    var templateID = "template_view_{{ $name }}_{{ $templateData['template_name'] }}";

    @if ( $templateData['is_markdown'] )

        var simplemde = new SimpleMDE(
            {
            element: $("#template_editor")[0],
            toolbar: [
            {
                    name: "bold",
                    action: SimpleMDE.toggleBold,
                    className: "fa fa-bold",
                    title: "Bold",
            },
            {
                    name: "italic",
                    action: SimpleMDE.toggleItalic,
                    className: "fa fa-italic",
                    title: "Italic",
            },
            {
                    name: "strikethrough",
                    action: SimpleMDE.toggleStrikethrough,
                    className: "fa fa-strikethrough",
                    title: "Strikethrough",
            },
            {
                    name: "heading",
                    action: SimpleMDE.toggleHeadingSmaller,
                    className: "fa fa-header",
                    title: "Heading",
            },
            {
                    name: "code",
                    action: SimpleMDE.toggleCodeBlock,
                    className: "fa fa-code",
                    title: "Code",
            },
            "|",
            {
                    name: "unordered-list",
                    action: SimpleMDE.toggleBlockquote,
                    className: "fa fa-list-ul",
                    title: "Generic List",
            },
            {
                    name: "uordered-list",
                    action: SimpleMDE.toggleOrderedList,
                    className: "fa fa-list-ol",
                    title: "Numbered List",
            },
            {
                    name: "clean-block",
                    action: SimpleMDE.cleanBlock,
                    className: "fa fa-eraser fa-clean-block",
                    title: "Clean block",
            },
            "|",
            {
                    name: "link",
                    action: SimpleMDE.drawLink,
                    className: "fa fa-link",
                    title: "Create Link",
            },
            {
                    name: "image",
                    action: SimpleMDE.drawImage,
                    className: "fa fa-picture-o",
                    title: "Insert Image",
            },
            /*{
                    name: "table",
                    action: SimpleMDE.drawTable,
                    className: "fa fa-table",
                    title: "Insert Table",
            },*/
            {
                    name: "horizontal-rule",
                    action: SimpleMDE.drawHorizontalRule,
                    className: "fa fa-minus",
                    title: "Insert Horizontal Line",
            },
            "|",
            {
                name: "button-component",
                action: setButtonComponent,
                className: "fa fa-hand-pointer-o",
                title: "Button Component",
            },
            {
                name: "table-component",
                action: setTableComponent,
                className: "fa fa-table",
                title: "Table Component",
            },
            {
                name: "promotion-component",
                action: setPromotionComponent,
                className: "fa fa-bullhorn",
                title: "Promotion Component",
            },
            {
                name: "panel-component",
                action: setPanelComponent,
                className: "fa fa-thumb-tack",
                title: "Panel Component",
            },
            "|",
            {
                    name: "side-by-side",
                    action: SimpleMDE.toggleSideBySide,
                    className: "fa fa-columns no-disable no-mobile",
                    title: "Toggle Side by Side",
            },
            {
                    name: "fullscreen",
                    action: SimpleMDE.toggleFullScreen,
                    className: "fa fa-arrows-alt no-disable no-mobile",
                    title: "Toggle Fullscreen",
            },
            {
                    name: "preview",
                    action: SimpleMDE.togglePreview,
                    className: "fa fa-eye no-disable",
                    title: "Toggle Preview",
            },
            ],
            renderingConfig: { singleLineBreaks: false, codeSyntaxHighlighting: false,},
            hideIcons: ["guide"],
            spellChecker: false,
            promptURLs: true,
            placeholder: "Write your Beautiful Email",
            previewRender: function(plainText, preview) {
                $.ajax({
                    method: "POST",
                    url: "{{ route('previewMarkdownView') }}",
                    data: {
                        markdown: plainText,
                        namespace: "{{ addslashes($templateData['namespace']) }}",
                        viewdata: "{{ preg_replace('/[\r\n]/','<br />', serialize($templateData['view_data'])) }}",
                        name: '{{ $name }}',
                        _token: '{{ csrf_token() }}',
                    }
                }).done(function( HtmledTemplate ) {
                    preview.innerHTML = HtmledTemplate;
                });

                return '';
            },

        });

        function setButtonComponent(editor) {

            var cm = editor.codemirror;
            var output = '';
            var selectedText = cm.getSelection();
            var text = selectedText || 'Button Text';

            output = `
    [component]: # ('mail::button',  ['url' => ''])
    ` + text + `
    [endcomponent]: #
            `;
            cm.replaceSelection(output);

        }

        function setPromotionComponent(editor) {

            var cm = editor.codemirror;
            var output = '';
            var selectedText = cm.getSelection();
            var text = selectedText || 'Promotion Text';

            output = `
    [component]: # ('mail::promotion')
    ` + text + `
    [endcomponent]: #
            `;
            cm.replaceSelection(output);

        }

        function setPanelComponent(editor) {

            var cm = editor.codemirror;
            var output = '';
            var selectedText = cm.getSelection();
            var text = selectedText || 'Panel Text';

            output = `
    [component]: # ('mail::panel')
    ` + text + `
    [endcomponent]: #
            `;
            cm.replaceSelection(output);

        }

        function setTableComponent(editor) {

            var cm = editor.codemirror;
            var output = '';
            var selectedText = cm.getSelection();

            output = `
    [component]: # ('mail::table')
    | Laravel       | Table         | Example  |
    | ------------- |:-------------:| --------:|
    | Col 2 is      | Centered      | $10      |
    | Col 3 is      | Right-Aligned | $20      |
    [endcomponent]: #
            `;
            cm.replaceSelection(output);

        }

        $('.preview-toggle').click(function(){
            simplemde.togglePreview();
            $(this).toggleClass('active');
        });

        simplemde.codemirror.on("change", function(){
            if ($('.save-draft').hasClass('disabled')){
                $('.save-draft').removeClass('disabled').text('Save Draft');
            }

        });

        $('.save-draft').click(function(){
            if (!$('.save-draft').hasClass('disabled')){
                localStorage.setItem(templateID, simplemde.codemirror.getValue());
                $(this).addClass('disabled').text('Draft Saved');
            }
        });

        if (localStorage.getItem(templateID) !== null) {
            simplemde.value(localStorage.getItem(templateID));
        }


        function viewMarkdownParser(plainText){

    $.ajax({
      method: "POST",
      url: "{{ route('previewMarkdownView') }}",
      data: {
        markdown: plainText,
        namespace: "{{ addslashes($templateData['namespace']) }}",
        viewdata: "{{ preg_replace('/[\r\n]/','<br />', serialize($templateData['view_data'])) }}",
        name: '{{ $name }}',
        _token: '{{ csrf_token() }}',
      }

    }).done(function( HtmledTemplate ) {
        let data = HtmledTemplate;
      });

      return data;
    }



    $('.view_data_param m-1').click(function(){
        var cm = simplemde.codemirror;
        var output = '';
        var selectedText = cm.getSelection();
        var param = $(this).attr('param-key');

        output = `\{\{ $` + param + ` \}\}`;

        if ( $(this).hasClass('is-attribute') ){

            var output = `\{\{ $` + $(this).attr('param-parent-key') + '->' + param + ` \}\}`;
        }

        cm.replaceSelection(output);
    });

    @else

    tinymce.init({
    selector: "textarea#template_editor",
    menubar : false,
    visual: false,
    height:560,
    inline_styles : true,
    plugins: "code {{$pluginstext}}",
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image fullpage | forecolor backcolor emoticons | preview | code",
    fullpage_default_encoding: "UTF-8",
    fullpage_default_doctype: "<!DOCTYPE html>",
    init_instance_callback: function (editor)
    {
    editor.on('Change', function (e) {
        if ($('.save-draft').hasClass('disabled')){
            $('.save-draft').removeClass('disabled').text('Save Draft');
        }
    });

    if (localStorage.getItem(templateID) !== null) {
        editor.setContent(localStorage.getItem(templateID));
    }

    setTimeout(function(){
        editor.execCommand("mceRepaint");
    }, 2000);
    }

    });

    simplemde = null;


    $('.view_data_param m-1').click(function(){
    var param = $(this).attr('param-key');
    output = `\{\{ $` + param + ` \}\}`;

    if ( $(this).hasClass('is-attribute') ){

    var output = `\{\{ $` + $(this).attr('param-parent-key') + '->' + param + ` \}\}`;
    }

    tinymce.activeEditor.selection.setContent(output);
    });


    $('.save-template').click(function(){
        Swal.fire({
            title: 'Are you sure you want to do that?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if(result.value) {
                if (simplemde && simplemde.codemirror) {
                    localStorage.setItem(templateID, simplemde.codemirror.getValue());
                } else if (tinymce && tinymce.get('template_editor')) {
                    localStorage.setItem(templateID, tinymce.get('template_editor').getContent());
                }

            $('.save-draft').addClass('disabled').text('Draft Saved');

                $.ajax({
                    method: 'POST',
                    url: "{{ route('parseTemplate') }}",
                    data: {
                        markdown: simplemde ? simplemde.codemirror.getValue() : tinymce.get('template_editor').getContent(),
                        viewpath: "{{ base64_encode($templateData['view_path']) }}",
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.status == 'ok') {
                            localStorage.removeItem(templateID);
                            Swal.fire('Success', 'Template updated', 'success');
                        } else {
                            Swal.fire('Error', 'Template not updated', 'error');
                        }
                    },
                    error: function(error) {
                        Swal.fire('Error', error, 'error');
                    }
                });
            }
        });
    });
    $('.save-draft').click(function(){
        if (!$('.save-draft').hasClass('disabled')){
            localStorage.setItem(templateID, tinymce.get('template_editor').getContent());
            $(this).addClass('disabled').text('Draft Saved');
        }
    });

     $('.preview-toggle').click(function(){
        tinyMCE.execCommand('mcePreview');return false;
    });

            @endif

    @if (!is_null($templateData['text_template']))

    var plaintextEditor = CodeMirror.fromTextArea(document.getElementById("plain_text"), {
        lineNumbers: false,
        mode: 'plain/text',
        placeholder: "Email Plain Text Version (Optional)",
    });

    @endif

        @endif

    });

    </script>
@endpush

@endsection
