<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Support\Facades\Cache;

trait ProvidesCache
{
    /**
     * Cache the result of a closure.
     *
     * @param  string  $key
     * @param  int  $ttl
     * @param  \Closure  $callback
     * @param  array|null  $tags
     * @return mixed
     */
    public function cache($key, $ttl, \Closure $callback, array $tags = null)
    {
        if ($tags) {
            return Cache::tags($tags)->remember($key, $ttl, $callback);
        }

        return Cache::remember($key, $ttl, $callback);
    }
}
