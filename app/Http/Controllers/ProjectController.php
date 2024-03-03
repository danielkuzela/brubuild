<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProjectController extends Controller
{
    public function index(): Response
    {
        $media = Media::where('model_type', '=', 'App\Models\Project')
            ->with(['model'])
            ->whereHas('model', function ($query) {
                $query->where('visible', true);
            })
            ->inRandomOrder()
            ->get();

        return Inertia::render('Homepage/Index', [
            'media' => $media
        ]);
    }
}
