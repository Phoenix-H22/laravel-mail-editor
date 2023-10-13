@extends('dashboard.layouts.default')
@section('title', 'Create Template')
@section('content')
<div class="container-fluid">
         <div class="row my-4">

            <div class="col-md-12">
                <div class="card mb-2">
                    <div class="card-header p-3" style="border-bottom:1px solid #e7e7e7e6;">
                        <button type="button" class="btn btn-primary float-right save-template">Create</button>
                        <button type="button" class="btn btn-secondary float-right preview-toggle mr-2"><i class="far fa-eye"></i> Preview</button>
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Editor</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Plain Text</a>
                            </li>
                          </ul>
                    </div>
                    <div class="card-body">

                          <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                              <textarea id="template_editor" cols="30" rows="10">{{ $skeleton['template'] }}</textarea>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                              <textarea id="plain_text" cols="30" rows="10"></textarea>
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
 @push('scripts')
 <script src="{{asset("dashboard-debs/tinymce/tinymce.min.js")}}"></script>
 @foreach($plugins as $plugin)
 <script src="{{asset("dashboard-debs/tinymce/plugins/".$plugin."/plugin.min.js")}}"></script>
 @endforeach
 @endpush
@push('scripts')
<script type="text/javascript"8>

    $(document).ready(function(){

    @if ($skeleton['type'] === 'markdown')


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
                    renderingConfig: { singleLineBreaks: true, codeSyntaxHighlighting: true,},
                    hideIcons: ["guide"],
                    spellChecker: false,
                    promptURLs: true,
                    placeholder: "Write your Beautiful Email",

                    previewRender: function(plainText, preview) {
                         // return preview.innerHTML = 'sacas';
                        $.ajax({
                              method: "POST",
                              url: "{{ route('previewTemplateMarkdownView') }}",
                              data: { markdown: plainText, name: 'new' }

                        }).done(function( HtmledTemplate ) {
                            preview.innerHTML = HtmledTemplate;
                        });

                        return '';
                    },

                });

                function setButtonComponent(editor) {

                    link = prompt('Button Link');

                    var cm = editor.codemirror;
                    var output = '';
                    var selectedText = cm.getSelection();
                    var text = selectedText || 'Button Text';

                    output = `
    [component]: # ('mail::button',  ['url' => '`+ link +`'])
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

    @else

    tinymce.init({
                    selector: "textarea#template_editor",
                    menubar : false,
                    visual: false,
                    height:600,
                    inline_styles : true,
                    plugins: "code {{$pluginstext}}",
                   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image fullpage | forecolor backcolor emoticons | preview | code",
                   fullpage_default_encoding: "UTF-8",
                   fullpage_default_doctype: "<!DOCTYPE html>",
                   init_instance_callback: function (editor)
                   {
                    setTimeout(function(){
                        editor.execCommand("mceRepaint");
                    }, 5000);
                   }
                });



    $('.preview-toggle').click(function(){
        tinyMCE.execCommand('mcePreview');return false;
    });

    @endif

    $('.save-template').click(function(){

        Swal.fire({
            title: 'Enter the template name:',
            input: 'text',
            type: 'question',
            inputPlaceholder: 'e.g. Weekly Newsletter',
            showCancelButton: true,
            confirmButtonText: 'Ok',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
        }).then((result) => {
            if(result.value) {
                Swal.fire({
                    title: 'Enter the template description:',
                    input: 'text',
                    showCancelButton: true,
                    confirmButtonText: 'Create Template',
                    cancelButtonText: 'Cancel',
                }).then((resultDesc) => {
                    if(resultDesc.value) {

                        @if ($skeleton['type'] === 'markdown')

                        var postData = {
                            content: simplemde.codemirror.getValue(),
                            template_name: result.value,
                            template_description: resultDesc.value,
                            plain_text: plaintextEditor.getValue(),
                            template_view_name: "{{ $skeleton['name'] }}",
                            template_type: "{{ $skeleton['type'] }}",
                            template_skeleton: "{{ $skeleton['skeleton'] }}",
                            _token: "{{ csrf_token() }}"
                        }

                        @else

                        var postData = {
                            content: tinymce.get('template_editor').getContent(),
                            template_name: result.value,
                            template_description: resultDesc.value,
                            plain_text: plaintextEditor.getValue(),
                            template_view_name: "{{ $skeleton['name'] }}",
                            template_type: "{{ $skeleton['type'] }}",
                            template_skeleton: "{{ $skeleton['skeleton'] }}",
                            _token: "{{ csrf_token() }}"
                        }

                        @endif

                        $.ajax({
                            method: 'POST',
                            url: "{{ route('createNewTemplate') }}",
                            data: postData,
                            success: function(response) {
                                if (response.status == 'ok'){
                                    window.location.replace(response.template_url);
                                } else {
                                    Swal.fire('Error', response.message, 'error');
                                }
                            },
                            error: function(error) {
                                Swal.fire('Error', 'There was an error processing the request.', 'error');
                            }
                        });
                    }
                });
            }
        });
    });

    var plaintextEditor = CodeMirror.fromTextArea(document.getElementById("plain_text"), {
        lineNumbers: false,
        mode: 'plain/text',
        placeholder: "Email Plain Text Version (Optional)",
    });
    });

    </script>
@endpush

@endsection
