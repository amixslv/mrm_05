<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Resource;
use Illuminate\Support\Facades\DB;

class EventService
{
    public function createEvent(array $data)
    {
        return Event::create($data);
    }

    public function addResourcesToEvent(Event $event, array $resources)
    {
        DB::transaction(function () use ($event, $resources) {
            $resourceData = [];
            foreach ($resources as $resource) {
                $resourceData[$resource['id']] = ['quantity' => $resource['quantity']];

                // Atjaunina atlikušos resursus
                Resource::where('id', $resource['id'])
                    ->decrement('quantity', $resource['quantity']);
            }
            $event->resources()->attach($resourceData);
        });
    }

    public function returnResources(Event $event)
    {
        DB::transaction(function () use ($event) {
            foreach ($event->resources as $resource) {
                // Palielina resursa daudzumu
                Resource::where('id', $resource->id)
                    ->increment('quantity', $resource->pivot->quantity);
            }
        });
    }

    public function discardResources(Event $event)
    {
        DB::transaction(function () use ($event) {
            // Šeit jūs varat veikt papildu darbības, piemēram, atzīmēt resursus kā norakstītus
            // vai dzēst tos no datubāzes, atkarībā no jūsu prasībām.
            foreach ($event->resources as $resource) {
                // Šis piemērs neietver dzēšanu, bet jūs varat to pievienot.
                Resource::where('id', $resource->id)
                    ->decrement('quantity', $resource->pivot->quantity);
            }
        });
    }
}
