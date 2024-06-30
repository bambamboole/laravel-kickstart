<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Bambamboole\LaravelTranslationDumper\ArrayExporter;
use Bambamboole\LaravelTranslationDumper\TranslationDumper;
use Illuminate\Http\Request;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

class TranslationsController
{
    /**
     * @var Filesystem
     */
    private $files;

    /**
     * @var FileLoader
     */
    private $translationLoader;

    public function __construct()
    {
        $this->files = app()['files'];
        $this->translationLoader = app()['translation.loader'];
    }

    public function store(Request $request, string $locale)
    {
        $translations = $request->json()->all();
        dump($locale, $translations);
        $dumper = new TranslationDumper($this->files, new ArrayExporter(), base_path('lang'), $locale, 'x-');
        $dumper->dump($translations);

        return ['status' => 'ok'];
    }

    public function index(string $locale)
    {
        $translations = $this->translationLoader->load($locale, '*', '*');
        $groups = array_map(fn (\SplFileInfo $file) => $file->getBasename('.php'), $this->files->files(base_path('lang/'.$locale)));
        foreach ($groups as $group) {
            $nonPrefixedGroupTranslations = $this->translationLoader->load($locale, $group);
            $groupTranslations = [];
            foreach ($nonPrefixedGroupTranslations as $key => $translation) {
                $groupTranslations[$group.'.'.$key] = $translation;
            }
            $translations = array_merge($translations, $groupTranslations);
        }

        return $this->prepare($translations);
    }

    private function prepare($translations)
    {
        $i18nTranslations = [];
        $keys = array_keys($translations);

        for ($i = 0; $i < count($keys); $i++) {
            $laravelKey = $keys[$i];
            $i18nKey = preg_replace("/:([\w\d]+)/", '{{$1}}', $laravelKey);
            $laravelValue = $translations[$laravelKey];

            if (is_array($laravelValue)) {
                $i18nTranslations[$i18nKey] = $this->prepare($laravelValue);
            } else {
                $i18nTranslations[$i18nKey] = preg_replace("/:([\w\d]+)/", '{{$1}}', $laravelValue);
            }
        }

        return $this->flatten($i18nTranslations);
    }

    private function flatten($translations)
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($translations));
        $flattened = [];

        foreach ($iterator as $leafValue) {
            $keys = [];

            foreach (range(0, $iterator->getDepth()) as $depth) {
                $keys[] = $iterator->getSubIterator($depth)->key();
            }

            $flattened[implode('.', $keys)] = $leafValue;
        }

        return $flattened;
    }
}
