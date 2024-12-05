<?php
namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MultilangSlug
{
    /**
     * It takes a request object, and a key, and returns a slug.
     * 
     * @param Request request The request object
     * @param string key The key of the request that you want to slugify.
     * 
     * @return string A string
     */
    public static function makeSlug(string $model, $slugText, string $field = '', string $divider = null): string
    {
        $slugText = match (true) {
            !empty($slugText)  => $slugText,
            empty($slugText)   => 'auto-generated-string',
        };
        return MultilangSlug::globalSlugify(model: $model, slugText: $slugText,  field: $field, divider: $divider);
    }

    /**
     * It takes a string, a model,  a field, and a divider, and returns a slugified string with a number
     * appended to it if the slug already exists in the database.
     * 
     * Here's a more detailed explanation:
     * 
     * The function takes three parameters:
     * 
     * - ``: The string to be slugified.
     * - ``: The model to check against. Model must pass as Product::class
     * - ``: The key to check The column name of the slug in the database.
     * - ``: The divider to use between the slug and the number.
     * 
     * The function first slugifies the string and then checks the database to see if the slug
     * already exists. If it doesn't, it returns the slug. If it does, it returns the slug with a
     * number appended to it.
     * 
     * Here's an example of how to use the function:
     * 
     * @param string slugText The text you want to slugify
     * @param string model The model you want to check against.
     * @param string field The column name of the slug in the database.
     * @param string divider The divider to use when appending the slug count to the slug.
     * 
     * @return string slug is being returned.
     */
    public static function globalSlugify(string $model, string $slugText,  string $field = '', string $divider = null): string
    {
        try {

            $id = 0;
            $divider = empty($divider) ? config('multilang-slug.separator') : $divider;
            $query = $model::query();

            $cleanString = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", "", $slugText);
            $cleanString = preg_replace("/[\/_|+ -]+/", '-', $cleanString);
            $slug = strtolower($cleanString);

            if ($field) {
                $slugCount = $query->where($field, $slug)->get();
            } else {
                $field = 'slug';
                $slugCount = $query->where('slug', $slug)->get();
            }
            $uniqueSlug = Str::random(config('multilang-slug.random_text'));


            if (empty($slugCount->count())) {
                $slug = is_numeric($slug) ? "{$slug}{$divider}{$uniqueSlug}" : $slug;
                return $slug;
            }


            if (config('multilang-slug.unique_slug')) {
                return "{$slug}{$divider}{$uniqueSlug}";
            } else {
                $allSlugs = MultilangSlug::getRelatedSlugs($slug, $id, $model, $field);
                for ($i = 1; $i <= config('multilang-slug.max_count'); $i++) {
                    $newSlug = $slug . $divider . $i;
                    if (!$allSlugs->contains("$field", $newSlug)) {
                        return $newSlug;
                    }
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private static function getRelatedSlugs($slug, $id, $model, $field)
    {
        if (empty($id)) {
            $id = 0;
        }
        return $model::select("$field")
            ->where("$field", 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }
}