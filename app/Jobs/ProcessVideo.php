<?php

namespace App\Jobs;

use App\Models\Video;
use Carbon\Carbon;
use FFMpeg\Filters\Video\VideoFilters;
use FFMpeg\Format\Audio\Mp3;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ProcessVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Video
     */
    protected $video;
    protected $input;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Video $video, $input)
    {
        //
        $this->video = $video;
        $this->input = $input;
        $this->handle();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->input['type'] == 'res'){
            $this->cRes($this->video, $this->input['data']);
        }
        elseif ($this->input['type'] == 'format'){
            $this->cFormat($this->video, $this->input['data']);
        }
        elseif ($this->input['type'] == 'thumbnail'){
            $this->gThumbnail($this->video, $this->input['data']);
        }
    }

    public function cRes($video, $size)
    {
        $video->converted_at = Carbon::now()->format('Y-m-d');
        $source = 'videos/Resolution/' . $video->converted_at . "-$video->id" . ".$video->video_default_format";

        $this->size = explode(',', $size);

        FFMpeg::fromDisk($video->disk)
            ->open($video->path)
            ->addFilter(function (VideoFilters $filters) {
                $filters->resize(new \FFMpeg\Coordinate\Dimension($this->size[0], $this->size[1]));
            })
            ->export()
            ->toDisk($video->disk)
            ->inFormat(new X264())
            ->save($source);
        $video->url = Storage::disk($video->disk)->url($source);
        $video->save();
    }

    public function cFormat($video, $format)
    {
        $video->converted_at = Carbon::now()->format('Y-m-d');
        $source = 'videos/Format/' . $video->converted_at . "-$video->id" . ".$format";

        FFMpeg::fromDisk($video->disk)
            ->open($video->path)
            ->export()
            ->toDisk($video->disk)
            ->inFormat('mp3' ? new Mp3() : new X264())
            ->save($source);
        $video->url = Storage::disk($video->disk)->url($source);
        $video->save();
    }

    public function gThumbnail($video, $time)
    {
        $video->converted_at = Carbon::now()->format('Y-m-d');
        $source = 'videos/Thumbnail/' . $video->converted_at . "-$video->id" . '.jpg';

        FFMpeg::fromDisk($video->disk)
            ->open($video->path)
            ->getFrameFromSeconds($time)
            ->export()
            ->toDisk($video->disk)
            ->save($source);
        $video->url = Storage::disk($video->disk)->url($source);
        $video->save();
    }
}
