<?php

namespace Modules\School\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Support\Modules\ModuleRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\School\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $module = ModuleRegistry::find('school');
        $news = News::latest()->paginate(20);

        return view('school::erp.news.index', compact('module', 'news'));
    }

    public function create()
    {
        $module = ModuleRegistry::find('school');
        $categories = ['news', 'event', 'announcement', 'achievement'];

        return view('school::erp.news.create', compact('module', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:200',
            'excerpt'      => 'nullable|string|max:500',
            'content'      => 'required|string',
            'category'     => 'required|in:news,event,announcement,achievement',
            'author'       => 'nullable|string|max:100',
            'is_published' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . time();

        if ($data['is_published'] ?? false) {
            $data['published_at'] = now();
        }

        News::create($data);

        return redirect()->route('school.erp.news.index')->with('success', 'Article créé.');
    }

    public function edit(News $news)
    {
        $module = ModuleRegistry::find('school');
        $categories = ['news', 'event', 'announcement', 'achievement'];

        return view('school::erp.news.edit', compact('module', 'news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:200',
            'excerpt'      => 'nullable|string|max:500',
            'content'      => 'required|string',
            'category'     => 'required|in:news,event,announcement,achievement',
            'author'       => 'nullable|string|max:100',
            'is_published' => 'boolean',
        ]);

        if (($data['is_published'] ?? false) && !$news->published_at) {
            $data['published_at'] = now();
        }

        $news->update($data);

        return redirect()->route('school.erp.news.index')->with('success', 'Article mis à jour.');
    }

    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('school.erp.news.index')->with('success', 'Supprimé.');
    }
}
