<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessVideo;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\FFMpeg\FFProbe;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg as FFMpeg;

class VideoController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function upload_video(Request $request)
    {
        $message = [
            'video.required' => 'مقدار فیلد اجباری است'
        ];
        // Validate
        $request->validate([
            'video' => 'required | max:10000000'
        ], $message);

        //Name File Video
        $name = $request->file('video')->getClientOriginalName();

        //New Object Video
        $video = new Video();

        $video->path = Storage::disk('public')->putFileAs('videos/home', $request->file('video'), $name);
        $video->disk = 'public';
        $video->video_default_format = $request->file('video')->getClientOriginalExtension();

        $ffprobe = FFProbe::create();

        $size_res = $ffprobe->streams(public_path('storage/') . $video->path)
        ->videos()
        ->first()
        ->getDimensions();

        $width = $size_res->getWidth();
        $height = $size_res->getHeight();

        //Resolution Size
        $video->video_default_res = $width . ',' . $height;

        if ($video->save())
        {
            if ($request->type == 'cRes')
            {
                ProcessVideo::dispatch($video, [
                    'type' => 'res',
                    'data' => $request->res_size
                ]);

                return back()->with('cRes', $video->url);
            }
            elseif($request->type == 'cFormat')
            {
                ProcessVideo::dispatch($video, [
                    'type' => 'format',
                    'data' => $request->format_type
                ]);

                return back()->with('cFormat', $video->url);
            }
            elseif ($request->type == 'gThumbnail')
            {
                ProcessVideo::dispatch($video, [
                    'type' => 'thumbnail',
                    'data' => $request->thumbnail_second
                ]);

                return back()->with('gThumbnail', $video->url);
            }
        }

    }
}
