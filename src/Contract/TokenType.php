<?php

declare(strict_types=1);

namespace Elemix\Contract;

use RyanChandler\Lexical\Attributes\Error;
use RyanChandler\Lexical\Attributes\Literal;
use RyanChandler\Lexical\Attributes\Regex;

enum TokenType
{
    #[Literal('<!DOCTYPE html>')]
    case HEADER;

    #[Regex(':[a-z][a-z0-9]+=".+?"')]
    case ATTRIBUTE_PHP;

    #[Regex('[a-z][a-z0-9]+=".+?"')]
    case ATTRIBUTE_RAW;

    #[Regex('<\/c-[a-z][a-z0-9-:_]*')]
    case COMPONENT_CLOSE_OPEN;

    #[Regex('<c-[a-z][a-z0-9-:_]*')]
    case COMPONENT_OPEN;

    #[Regex('<\/[a-z][a-z0-9]*')]
    case TAG_CLOSE_OPEN;

    #[Regex('<[a-z][a-z0-9]*')]
    case TAG_OPEN;

    #[Regex('<\?(.|\s)+?\?>')]
    case RAW_PHP;

    #[Literal('/>')]
    case TAG_SELF_CLOSE;

    #[Literal('>')]
    case TAG_CLOSE;

    #[Error]
    case LITERRAL;
}
