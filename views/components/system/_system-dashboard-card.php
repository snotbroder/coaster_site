<?php

/** @var array $card */
require_once ROOT . "/config/_.php";
?>

<article class="flex flex-col justify-between bg-(--pure-eggshell) shadow-md rounded-md p-8 w-64 h-74 relative overflow-hidden">
    <div class="flex flex-col gap-3 z-10">
        <h5 class="font-semibold!"><?php _($card["title"]) ?></h5>
        <p class="small"><?php _($card["body"]) ?></p>

    </div>
    <a class="btn-primary z-10" href="<?php _($card["cta-path"]) ?>"><?php _($card["cta"]) ?></a>
    <div class="absolute bottom-10 -right-10 z-0">
        <img class="opacity-20 w-38" src="/static/assets/icons/<?php _($card["icon"]) ?>" alt="Icon">
    </div>
</article>