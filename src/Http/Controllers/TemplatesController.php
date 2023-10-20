<?php

namespace Phoenix22h\MailEclipse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Phoenix22h\MailEclipse\Facades\MailEclipse;
use Phoenix22h\MailEclipse\Utils\TemplateSkeletons;

class TemplatesController extends Controller
{
    public function __construct()
    {
        abort_unless(
            App::environment(config('maileclipse.allowed_environments', ['local'])),
            403,
            'Environment Not Allowed'
        );
    }

    public function index()
    {
        $skeletons = TemplateSkeletons::skeletons();

        $templates = MailEclipse::getTemplates();

        return View(MailEclipse::VIEW_NAMESPACE.'::sections.templates', compact('skeletons', 'templates'));
    }

    public function new($type, $name, $skeleton)
    {
        $type = $type === 'html' ? $type : 'markdown';

        $skeleton = TemplateSkeletons::get($type, $name, $skeleton);
        $directoryPath = public_path('dashboard-debs/tinymce/plugins');
        $folderNames = File::directories($directoryPath);

        $plugins = [];
        foreach ($folderNames as $folder) {
            $folderName = pathinfo($folder, PATHINFO_FILENAME);
            $plugins[] = $folderName;
        }
        $pluginstext = implode(' ', $plugins);
        return View(MailEclipse::VIEW_NAMESPACE.'::sections.create-template', compact('skeleton', 'pluginstext', 'plugins'));
    }

    public function view($templateslug = null)
    {
        $template = MailEclipse::getTemplate($templateslug);

        if (is_null($template)) {
            return redirect()->route('templateList');
        }
        $directoryPath = public_path('dashboard-debs/tinymce/plugins');
        $folderNames = File::directories($directoryPath);

        $plugins = [];
        foreach ($folderNames as $folder) {
            $folderName = pathinfo($folder, PATHINFO_FILENAME);
            $plugins[] = $folderName;
        }
        $pluginstext = implode(' ', $plugins);
        return View(MailEclipse::VIEW_NAMESPACE.'::sections.edit-template', compact('template', 'pluginstext', 'plugins'));
    }

    public function create(Request $request)
    {
        return MailEclipse::createTemplate($request);
    }

    public function select(Request $request)
    {
        $skeletons = TemplateSkeletons::skeletons();

        return View(MailEclipse::VIEW_NAMESPACE.'::sections.new-template', compact('skeletons'));
    }

    public function previewTemplateMarkdownView(Request $request)
    {
        return MailEclipse::previewMarkdownViewContent(false, $request->markdown, $request->name, true);
    }

    public function delete(Request $request)
    {
        if (MailEclipse::deleteTemplate($request->templateslug)) {
            return response()->json([
                'status' => 'ok',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
            ]);
        }
    }

    public function update(Request $request)
    {
        return MailEclipse::updateTemplate($request);
    }
}
