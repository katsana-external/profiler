<?php

namespace Laravie\Profiler;

use Orchestra\Support\Str;

class Timer
{
    use Traits\Logger;

    /**
     * Timer unique name.
     *
     * @var string
     */
    protected $name;

    /**
     * Timer message.
     *
     * @var string|null
     */
    protected $message;

    /**
     * Microtime when the timer start ticking.
     *
     * @var int
     */
    protected $startedAt;

    /**
     * Started at resolver.
     *
     * @var callable
     */
    protected $startedAtResolver;

    /**
     * Construct new timer.
     *
     * @param string  $name
     * @param int  $startedAt
     * @param string|null  $message
     */
    public function __construct($name, $startedAt, $message = null)
    {
        $this->name = $name;
        $this->startedAt = $startedAt;
        $this->message = $message;
    }

    /**
     * End the timer.
     *
     * @return void
     */
    public function end()
    {
        $this->getMonolog()->addInfo($this->message());
    }

    /**
     * End the timer if condition is matched.
     *
     * @param  bool  $condition
     * @return void
     */
    public function endIf($condition)
    {
        if ($condition !== true) {
            $this->end();
        }
    }

    /**
     * Get message.
     *
     * @return string
     */
    public function message()
    {
        $message = $this->message ?: '{name} took {seconds} seconds.';

        return Str::replace($message, ['name' => $this->name(), 'seconds' => $this->seconds()]);
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Get seconds.
     *
     * @return int
     */
    public function seconds()
    {
        $endedAt = microtime(true);

        return ($endedAt - $this->startedAt);
    }
}