<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Meeting;

class CalendarService
{
    /**
     * Generate a standard .ics calendar string for a meeting.
     */
    public function generateIcs(Meeting $meeting): string
    {
        $dtStart = $meeting->scheduled_start->format('Ymd\THis\Z');
        $dtEnd = $meeting->scheduled_end->format('Ymd\THis\Z');
        $dtStamp = now()->format('Ymd\THis\Z');
        $uid = $meeting->id.'@governance-portal';
        $summary = $this->escapeIcs($meeting->title);
        $url = route('meetings.show', $meeting);

        return implode("\r\n", [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//Board Governance Portal//NONSGML v1.0//EN',
            'BEGIN:VEVENT',
            "UID:{$uid}",
            "DTSTAMP:{$dtStamp}",
            "DTSTART:{$dtStart}",
            "DTEND:{$dtEnd}",
            "SUMMARY:{$summary}",
            "URL:{$url}",
            'END:VEVENT',
            'END:VCALENDAR',
        ]);
    }

    /**
     * Escape special characters for iCalendar format.
     */
    protected function escapeIcs(string $text): string
    {
        return str_replace(['\\', ';', ',', "\n"], ['\\\\', '\;', '\,', '\n'], $text);
    }
}
