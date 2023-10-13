@extends('dashboard.layouts.default')
@section('title')
Edit Template {{ $template['name'] }}
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
                    <p style="font-size: .9em;"><b class="font-weight-sixhundred">Name:</b> {{ ucfirst($template['name']) }}</p>
                    <p style="font-size: .9em;"><b class="font-weight-sixhundred">Slug:</b> {{ $template['slug'] }}</p>
                    <p style="font-size: .9em;"><b class="font-weight-sixhundred">Description:</b> {{ $template['description'] }}</p>

                    <p style="font-size: .9em;"><b class="font-weight-sixhundred">Template View:</b> {{ 'maileclipse::templates.'.$template['slug'] }}</p>

                    <p style="font-size: .9em;"><b class="font-weight-sixhundred">Template Type:</b> {{ ucfirst($template['template_type']) }}</p>
                    <p style="font-size: .9em;"><b class="font-weight-sixhundred">Template Name:</b> {{ ucfirst($template['template_view_name']) }}</p>
                    <p style="font-size: .9em;"><b class="font-weight-sixhundred">Template Skeleton:</b> {{ ucfirst($template['template_skeleton']) }}</p>
                    <p class="text-primary edit-template" style="cursor:pointer;"><i class="fas fa-trash"></i> Edit Details</p>
                    <p class="text-danger delete-template" style="cursor:pointer;"><i class="fas fa-trash "></i> Delete Template</p>
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
                    <button type="button" class="btn btn-light float-right mr-2 save-draft disabled">Save Draft</button>
                </div>
            <div class="card-body">
                <textarea id="template_editor" cols="30" rows="10">{{ $template['template'] }}</textarea>
            </div>

            </div>
        </div>
        <div class="col-lg-3 d-none d-lg-block">
            <div class="card">
                <div class="card-header"><h5>Details</h5></div>
                <div class="card-body">
                    <p style="font-size: .9em;"><b class="font-weight-sixhundred">Name:</b> {{ ucfirst($template['name']) }}</p>
                    <p style="font-size: .9em;"><b class="font-weight-sixhundred">Slug:</b> {{ $template['slug'] }}</p>
                    <p style="font-size: .9em;"><b class="font-weight-sixhundred">Description:</b> {{ $template['description'] }}</p>

                    <p style="font-size: .9em;"><b class="font-weight-sixhundred">Template View:</b> {{ 'maileclipse::templates.'.$template['slug'] }}</p>

                    <p style="font-size: .9em;"><b class="font-weight-sixhundred">Template Type:</b> {{ ucfirst($template['template_type']) }}</p>
                    <p style="font-size: .9em;"><b class="font-weight-sixhundred">Template Name:</b> {{ ucfirst($template['template_view_name']) }}</p>
                    <p style="font-size: .9em;"><b class="font-weight-sixhundred">Template Skeleton:</b> {{ ucfirst($template['template_skeleton']) }}</p>
                    <p class="text-primary edit-template" style="cursor:pointer;"><i class="fas fa-trash"></i> Edit Details</p>
                    <span class="text-danger delete-template" style="cursor:pointer;"><i class="fas fa-trash "></i> Delete Template</p>
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

    $(document).ready(function() {

    var templateID = "{{ 'template_view_' . $template['slug'] }}";

    $('.edit-template').click(function() {

        Swal.fire({
            title: 'New template name:',
            input: 'text',
            inputAttributes: {
                pattern: '^[a-zA-Z0-9 ]*$'
            },
            showCancelButton: true
        }).then(result => {
            if (result.value) {
                let templatename = result.value;

                Swal.fire({
                    title: 'NEW template description:',
                    input: 'text',
                    inputAttributes: {
                        pattern: '^[a-zA-Z0-9 ]*$'
                    },
                    showCancelButton: true
                }).then(result => {
                    if (result.value) {
                        let templatedescription = result.value;

                        $.ajax({
                            type: "POST",
                            url: "{{ route('updateTemplate') }}",
                            data: {
                                templateslug: "{{ $template['slug'] }}",
                                title: templatename,
                                description: templatedescription,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if (response.status == 'ok') {
                                    window.location.replace(response.template_url);
                                } else {
                                    Swal.fire('Error', response.message, 'error');
                                }
                            },
                            error: function(error) {
                                Swal.fire('Error', error.responseText, 'error');
                            }
                        });
                    }
                });
            }
        });
    });

    $('.delete-template').click(function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure you want to do that?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('deleteTemplate') }}",
                    data: {
                        templateslug: "{{ $template['slug'] }}",
                        _token: "{{ csrf_token() }}"

                    },
                    success: function(response) {
                        if (response.status == 'ok') {
                            Swal.fire({
                                type: 'success',
                                title: 'Template Deleted',
                                html: 'Redirecting...<br><small>Redirecting in 3 seconds...</small>',
                                timer: 3000
                            }).then(() => {
                                window.location.replace("{{ route('templateList') }}");
                            });
                        } else {
                            Swal.fire('Error', 'Template not deleted', 'error');
                        }
                    },
                    error: function(error) {
                        Swal.fire('Error', error.responseText, 'error');
                    }
                });
            }
        });
    });

    @if ($template['template_type'] === 'markdown')
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
            /*{
                    name: "quote",
                    action: SimpleMDE.toggleBlockquote,
                    className: "fa fa-quote-left",
                    title: "Quote",
            },*/
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
                      data: { markdown: plainText, name: "{{ $template['slug'] }}",
                        _token: "{{ csrf_token() }}"
                        }

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

        simplemde.codemirror.on("change", function(){
            if ($('.save-draft').hasClass('disabled')){
                $('.save-draft').removeClass('disabled').text('Save Draft');
            }
            // alert('Hello');
        });

    $('.save-template').click(function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure you want to do that?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('parseTemplate') }}",
                    data: {
                        markdown: simplemde.codemirror.getValue(),
                        viewpath: "{{ $template['slug'] }}",
                        template: true,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status == 'ok') {
                            Swal.fire('Success', 'Template updated', 'success');
                            localStorage.removeItem(templateID);
                        } else {
                            Swal.fire('Error', 'Template not updated', 'error');
                        }
                    },
                    error: function(error) {
                        Swal.fire('Error', error.responseText, 'error');
                    }
                });
            }
        });
    });

    $('.preview-toggle').click(function(){
            simplemde.togglePreview();
            $(this).toggleClass('active');
        });

    @else
    tinymce.init({
            selector: "textarea#template_editor",
            menubar: false,
            visual: false,
            height: 600,
            inline_styles: true,
            plugins: "code {{$pluginstext}}",
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image fullpage table | forecolor backcolor emoticons | preview | code",
            fullpage_default_encoding: "UTF-8",
            fullpage_default_doctype: "<!DOCTYPE html>",
            init_instance_callback: function(editor) {
                editor.on('Change', function(e) {
                    if ($('.save-draft').hasClass('disabled')) {
                        $('.save-draft').removeClass('disabled').text('Save Draft');
                    }
                });

                if (localStorage.getItem(templateID) !== null) {
                    editor.setContent(localStorage.getItem(templateID));
                }

                setTimeout(function() {
                    editor.execCommand("mceRepaint");
                }, 2000);

            }
        });

        $('.save-template').click(function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to save this template?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, save it!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('parseTemplate') }}",
                        data: {
                            markdown: tinymce.get('template_editor').getContent(),
                            viewpath: "{{ $template['slug'] }}",
                            template: true,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.status == 'ok') {
                                Swal.fire('Success', 'Template updated', 'success');
                                localStorage.removeItem(templateID);
                            } else {
                                Swal.fire('Error', 'Template not updated', 'error');
                            }
                        },
                        error: function(error) {
                            Swal.fire('Error', error.responseText, 'error');
                        }
                    });
                }
            });
        });

        $('.save-draft').click(function() {
            if (!$('.save-draft').hasClass('disabled')) {
                localStorage.setItem(templateID, tinymce.get('template_editor').getContent());
                $(this).addClass('disabled').text('Draft Saved');
            }
        });

        $('.preview-toggle').click(function() {
            tinyMCE.execCommand('mcePreview');
            return false;
        });
    @endif

    });

    </script>

@endpush

@endsection
