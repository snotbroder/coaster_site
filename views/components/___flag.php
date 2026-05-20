<?php

/** @var array $park */
// Im sorry, I have to use echo :(

switch ($park["park_country_code"]) {
    case "NL":
        _("netherlands");
        break;
    case 1:
        echo ("<span class='text-(--pure-star)'>&#x2605;</span> &#x2605; &#x2605; &#x2605; &#x2605;");
        break;

    case 2:
        echo ("<span class='text-(--pure-star)'>&#x2605; &#x2605;</span> &#x2605; &#x2605; &#x2605;");
        break;

    case 3:
        echo ("<span class='text-(--pure-star)'>&#x2605; &#x2605; &#x2605;</span> &#x2605; &#x2605;");
        break;

    case 4:
        echo ("<span class='text-(--pure-star)'>&#x2605; &#x2605; &#x2605; &#x2605;</span> &#x2605;");
        break;

    case 5:
        echo ("<span class='text-(--pure-star)'>&#x2605; &#x2605; &#x2605; &#x2605; &#x2605;</span>");
        break;
}
