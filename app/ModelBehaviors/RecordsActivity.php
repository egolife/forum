<?php

namespace App\ModelBehaviors;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait RecordsActivity
{
    /**
     *
     */
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) {
            return;
        }

        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function (Model $model) use ($event) {
                $model->recordActivity($event . '_');
            });
        }
    }

    public static function getActivitiesToRecord()
    {
        return ['created'];
    }

    /**
     * @param $event
     */
    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type'    => $event . strtolower(class_basename($this)),
        ]);
    }

    /**
     * @return MorphMany
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}