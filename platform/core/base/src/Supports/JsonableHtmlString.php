<?php

namespace Botble\Base\Supports;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\HtmlString;
use JsonSerializable;

class JsonableHtmlString extends HtmlString implements Jsonable, JsonSerializable
{
    public function toJson($options = 0): string
    {
        return $this->toHtml();
    }

    public function jsonSerialize(): string
    {
        return html_entity_decode($this->toHtml());
    }
}
