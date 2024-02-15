<?php

declare(strict_types=1);

namespace Elemix\Handler;

use Elemix\Contract\PathHandlerContract;
use Elemix\Exception\OpenCloseTagsDoNotMatch;

final class CompilationHandler implements PathHandlerContract
{
    private const COMPONENT_OPEN        = '~<\s*c-(?<tag>[a-z][a-z0-9:_-]*)(?<attr>(?:[^/>]*))>~i';
    private const COMPONENT_CLOSE       = '~</\s*c-(?<tag>[a-z][a-z0-9:_-]*)\s*>~i';
    private const COMPONENT_SELF_CLOSE  = '~<\s*c-(?<tag>[a-z][a-z0-9:_-]*)(?<attr>(?:[^/>]*))/>~i';
    private const ATTRIBUTE_INTERPOLATE = '~:(?<attr>[a-z][a-z0-9-]*)="(?<value>[^"]*)"~i';
    private const ATTRIBUTE_RAW         = '~(?<attr>[a-z][a-z0-9-]*)="(?<value>[^"]*)"~i';

    public function __construct(
        private string $component,
        private PathHandlerContract $pathHandler,
        private PathHandlerContract $cacheHandler,
    ) {
    }

    public function create(string $template): string
    {
        $templatePath = $this->pathHandler->create($template);
        $cachePath = $this->cacheHandler->create(\md5($template));

        if (\is_file($cachePath) && \filemtime($cachePath) > \filemtime($templatePath)) {
            return $cachePath;
        }

        $content = \file_get_contents($templatePath);

        if (!$this->validate($content)) {
            throw new OpenCloseTagsDoNotMatch($templatePath);
        }

        $compiled = $this->compileTemplate($content);
        \file_put_contents($cachePath, $compiled);

        return $cachePath;
    }

    private function validate(string $content): bool
    {
        \preg_match_all(self::COMPONENT_OPEN, $content, $openMatches);
        \preg_match_all(self::COMPONENT_CLOSE, $content, $closeMatches);

        $diff1 = \array_diff($openMatches['tag'] ?? [], $closeMatches['tag'] ?? []);
        $diff2 = \array_diff($closeMatches['tag'] ?? [], $openMatches['tag'] ?? []);

        return [] === $diff1 && [] === $diff2;
    }

    private function compileTemplate(string $content): string
    {
        $replacements = [
            self::COMPONENT_OPEN => fn ($match) =>
            \vsprintf("<?php /* OPEN %2\$s */ %1\$s::start('%2\$s', %3\$s) ?>", [
                $this->component,
                $match['tag'],
                $this->compileAttributes($match['attr'] ?? ''),
            ]),

            self::COMPONENT_CLOSE => fn ($match) =>
            \vsprintf("<?php /* CLOSE %2\$s */ echo %1\$s::end() ?>", [
                $this->component,
                $match['tag'],
            ]),

            self::COMPONENT_SELF_CLOSE => fn ($match) =>
            \vsprintf("<?php /* SELF CLOSING %2\$s */ echo %1\$s::render('%2\$s', %3\$s) ?>", [
                $this->component,
                $match['tag'],
                $this->compileAttributes($match['attr'] ?? ''),
            ]),

            self::ATTRIBUTE_INTERPOLATE => fn ($match) =>
            \vsprintf("%s=\"<?= htmlentities(%s ?? '') ?>\"", [
                \trim($match['attr'] ?? ''),
                \trim($match['value'] ?? ''),
            ]),
        ];

        return \preg_replace_callback_array($replacements, $content);
    }

    private function compileAttributes(string $content): string
    {
        if ('' === \trim($content)) {
            return '[]';
        }

        $replacements = [
            self::ATTRIBUTE_INTERPOLATE => fn ($match) =>
            \vsprintf(" '%s' => %s, ", [
                \trim($match['attr'] ?? ''),
                \trim($match['value'] ?? ''),
            ]),

            self::ATTRIBUTE_RAW => fn ($match) =>
            \vsprintf(" '%s' => htmlentities('%s'), ", [
                \trim($match['attr'] ?? ''),
                \trim($match['value'] ?? ''),
            ]),
        ];

        $content = \preg_replace_callback_array($replacements, $content);

        return '[' . \trim(\preg_replace('/\s+/', ' ', $content), " \n\r\t\v\x00,") . ']';
    }
}
