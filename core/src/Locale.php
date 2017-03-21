<?php

namespace CH\Skeleton;

use Symfony\Component\HttpFoundation\Request;

class Locale
{
    /**
     * @var     string
     */
    protected $default;

    /**
     * @var     string
     */
    protected $cookieLanguage = false;

    /**
     * @var     array
     */
    protected $locales = [
        'en' => 'English',
        'cy' => 'Cymraeg',
        'ga' => 'Gaeilge',
        'gd' => 'Gàidhlig'
    ];

    public function __construct(Request $request, string $default = 'en')
    {
        $this->default = $default;

        // From the request object, work out if we have a language cookie:
        if ($request->cookies->has('ckps_language')) {
            $portions = explode('_', $request->cookies->get('ckps_language'));
            if (in_array($portions[0], array_keys($this->locales))) {
                $this->cookieLanguage = $portions[0];
            }
        }
    }

    public function setDefault(string $locale): Locale
    {
        $this->default = $locale;
        return $this;
    }

    public function getLocales(): array
    {
        return $this->locales;
    }

    public function getLocalesWithoutCurrent(): array
    {
        $l = [];
        foreach ($this->locales as $k => $v) {
            if ($k !== $this->getCurrentLocale()) {
                $l[$k] = $v;
            }
        }
        return $l;
    }

    public function getCurrentLocale(): string
    {
        return $this->cookieLanguage ?: $this->default;
    }

    public function isValidLocale($locale): bool
    {
        $portions = explode('_', $locale);
        return array_key_exists($portions[0], $this->locales);
    }
}
