<?php

namespace App\Services;

use Illuminate\Support\Collection;

class NotificationGrouper
{
    /**
     * Group notifications for display.
     *
     * @param Collection $notifications
     * @return Collection
     */
    public static function group(Collection $notifications): Collection
    {
        $grouped = collect();
        $skipIds = [];

        foreach ($notifications as $notification) {
            if (in_array($notification->id, $skipIds)) {
                continue;
            }

            $data = $notification->data;
            
            // Define grouping rules
            if (self::isGroupable($data)) {
                $related = $notifications->filter(function ($n) use ($data, $notification) {
                    return $n->id !== $notification->id && self::isSameGroup($n->data, $data);
                });

                if ($related->isNotEmpty()) {
                    $group = collect([$notification])->merge($related);
                    $grouped->push(self::mergeGroup($group));
                    $skipIds = array_merge($skipIds, $group->pluck('id')->toArray());
                    continue;
                }
            }

            $grouped->push($notification);
        }

        return $grouped;
    }

    protected static function isGroupable(array $data): bool
    {
        return isset($data['type']) && (
            ($data['type'] === 'engagement' && in_array($data['engagement_type'], ['reaction', 'comment', 'reply'])) ||
            ($data['type'] === 'reader' && in_array($data['reader_type'], ['reaction', 'reply']))
        );
    }

    protected static function isSameGroup(array $data1, array $data2): bool
    {
        if ($data1['type'] !== $data2['type']) return false;

        if ($data1['type'] === 'engagement') {
            return $data1['engagement_type'] === $data2['engagement_type'] 
                && ($data1['article_id'] ?? null) === ($data2['article_id'] ?? null);
        }

        if ($data1['type'] === 'reader') {
            return $data1['reader_type'] === $data2['reader_type']
                && ($data1['data']['comment_id'] ?? null) === ($data2['data']['comment_id'] ?? null);
        }

        return false;
    }

    protected static function mergeGroup(Collection $group): object
    {
        $base = $group->first();
        $data = $base->data;
        $count = $group->count();
        
        $names = $group->pluck('data.trigger_user_name')->unique()->filter()->values();
        $nameCount = $names->count();

        $subject = "";
        if ($nameCount === 1) {
            $subject = $names[0] . " and " . ($count - 1) . " others";
        } elseif ($nameCount === 2) {
            $subject = $names[0] . ", " . $names[1] . " and " . ($count - 2) . " others";
        } else {
            $subject = $names[0] . ", " . $names[1] . " and " . ($count - 2) . " others";
        }

        if ($count <= 2 && $nameCount === $count) {
             if ($count === 2) {
                 $subject = $names[0] . " and " . $names[1];
             } else {
                 $subject = $names[0];
             }
        }

        $verb = "";
        $type = $data['engagement_type'] ?? $data['reader_type'] ?? '';
        
        switch ($type) {
            case 'reaction': $verb = "reacted to"; break;
            case 'comment': $verb = "commented on"; break;
            case 'reply': $verb = "replied to"; break;
            default: $verb = "interacted with";
        }

        $target = $data['article_title'] ?? "your content";
        $data['message'] = "$subject $verb $target";
        
        // Return a proxy object that looks like a notification but has merged data
        return (object) [
            'id' => $base->id,
            'type' => $base->type,
            'data' => $data,
            'read_at' => $base->read_at,
            'created_at' => $base->created_at,
            'is_grouped' => true,
            'group_count' => $count,
            'ids' => $group->pluck('id')->toArray()
        ];
    }
}
