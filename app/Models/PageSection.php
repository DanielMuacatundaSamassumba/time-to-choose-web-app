<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    protected $fillable = ['page', 'section', 'field', 'value'];

    /**
     * Get all sections for a given page as a nested array:
     * [ 'hero' => ['title' => '...', 'subtitle' => '...'], ... ]
     */
    public static function getForPage(string $page): array
    {
        $rows = static::where('page', $page)->get();

        $result = [];
        foreach ($rows as $row) {
            $result[$row->section][$row->field] = $row->value;
        }

        return $result;
    }

    /**
     * Upsert (insert or update) a set of key-value pairs for a page/section.
     */
    public static function saveSection(string $page, string $section, array $fields): void
    {
        foreach ($fields as $field => $value) {
            static::updateOrCreate(
                ['page' => $page, 'section' => $section, 'field' => $field],
                ['value' => $value]
            );
        }
    }
}
