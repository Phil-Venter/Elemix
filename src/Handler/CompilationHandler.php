<?php

declare(strict_types=1);

namespace Elemix\Handler;

use RyanChandler\Lexical\LexicalBuilder;

use Elemix\Contract\PathHandlerContract;
use Elemix\Contract\TokenType;

final class CompilationHandler implements PathHandlerContract
{
    private const ATTRIBUTE = '/(?<key>[a-z][a-z0-9]+)="(?<val>[^"]+)"/';

    private ?string $tag = null;
    private bool $component = false;
    private bool $close = false;
    private array $attributes = [];
    private string $output = '';

    public function __construct(
        private PathHandlerContract $templateHandler,
        private PathHandlerContract $cacheHandler,
    ) {
    }

    public function create(string $template): string
    {
        $templatePath = $this->templateHandler->create($template);
        $cachePath = $this->cacheHandler->create(\sha1($template));

        if (\is_file($cachePath) && \filemtime($templatePath) < \filemtime($cachePath)) {
            return $cachePath;
        }

        $content = \file_get_contents($templatePath);

        $tokens = (new LexicalBuilder)
            ->readTokenTypesFrom(TokenType::class)
            ->produceTokenUsing(fn (TokenType $type, string $literal) => [$type, $literal])
            ->build()
            ->tokenise($content);

        $compiled = $this->compile($tokens);

        \file_put_contents($cachePath, $compiled);
        return $cachePath;
    }

    private function compile(array $tokens): string
    {
        $this->output = '';
        $this->reset();

        foreach ($tokens as [$token, $literal]) {
            if (\in_array($token, [
                TokenType::HEADER,
                TokenType::RAW_PHP,
                TokenType::LITERRAL,
            ])) {
                if (null !== $this->tag) {
                    continue;
                }

                $this->output .= $literal;

                continue;
            }

            if (\in_array($token, [
                TokenType::COMPONENT_OPEN,
                TokenType::COMPONENT_CLOSE_OPEN,
                TokenType::TAG_OPEN,
                TokenType::TAG_CLOSE_OPEN,
            ])) {
                $this->reset();

                $this->tag = match ($token) {
                    TokenType::COMPONENT_OPEN => str_replace('<c-', '', $literal),
                    TokenType::COMPONENT_CLOSE_OPEN => str_replace('</c-', '', $literal),
                    TokenType::TAG_OPEN => str_replace('<', '', $literal),
                    TokenType::TAG_CLOSE_OPEN => str_replace('</', '', $literal),
                };

                $this->component = \in_array($token, [
                    TokenType::COMPONENT_OPEN,
                    TokenType::COMPONENT_CLOSE_OPEN
                ]);

                $this->close = \in_array($token, [
                    TokenType::COMPONENT_CLOSE_OPEN,
                    TokenType::TAG_CLOSE_OPEN
                ]);

                continue;
            }

            if (TokenType::ATTRIBUTE_RAW === $token) {
                \preg_match(self::ATTRIBUTE, $literal, $matches);

                $format = $this->component
                    ? "'%s' => '%s'"
                    : '%s="%s"';

                $this->attributes[] = \sprintf(
                    $format,
                    $matches['key'],
                    $matches['val'],
                );

                continue;
            }

            if (TokenType::ATTRIBUTE_PHP === $token) {
                \preg_match(self::ATTRIBUTE, $literal, $matches);

                $format = $this->component
                    ? "'%s' => %s"
                    : '%s="<?= %s ?? \'\' ?>"';

                $this->attributes[] = \sprintf(
                    $format,
                    $matches['key'],
                    $matches['val'],
                );

                continue;
            }

            if (TokenType::TAG_CLOSE === $token && $this->component && !$this->close) {
                $format = \count($this->attributes) > 0
                    ? "<?php start('%s', [%s]) ?>"
                    : "<?php start('%s') ?>";

                $this->output .= \sprintf(
                    $format,
                    $this->tag,
                    \implode(', ', $this->attributes),
                );

                $this->reset();

                continue;
            }

            if (TokenType::TAG_CLOSE === $token && $this->component && $this->close) {
                $this->output .= \sprintf(
                    "<?= stop('%s') ?>",
                    $this->tag,
                );

                $this->reset();

                continue;
            }

            if (TokenType::TAG_SELF_CLOSE === $token && $this->component) {
                $format = \count($this->attributes) > 0
                    ? "<?php render('%s', [%s]) ?>"
                    : "<?php render('%s') ?>";

                $this->output .= \sprintf(
                    $format,
                    $this->tag,
                    \implode(', ', $this->attributes)
                );

                $this->reset();

                continue;
            }

            if (TokenType::TAG_CLOSE === $token && !$this->component && !$this->close) {
                $format = \count($this->attributes) > 0
                    ? '<%s %s>'
                    : '<%s>';

                $this->output .= \sprintf(
                    $format,
                    $this->tag,
                    \implode(' ', $this->attributes),
                );

                $this->reset();

                continue;
            }

            if (TokenType::TAG_CLOSE === $token && !$this->component && $this->close) {
                $this->output .= \sprintf(
                    '</%s>',
                    $this->tag,
                );

                $this->reset();

                continue;
            }

            if (TokenType::TAG_SELF_CLOSE === $token && !$this->component) {
                $format = \count($this->attributes) > 0
                    ? '<%s %s/>'
                    : '<%s/>';

                $this->output .= \sprintf(
                    $format,
                    $this->tag,
                    \implode(' ', $this->attributes),
                );

                $this->reset();

                continue;
            }
        }

        return $this->output;
    }

    private function reset(): void
    {
        $this->tag = null;
        $this->component = false;
        $this->close = false;
        $this->attributes = [];
    }
}
