<?php

/** @var array $coaster */

?>

<a class="@container overflow-hidden group shadow-sm rounded-md min-w-36 md:min-w-58 lg:w-full anim-slide-in min-h-36 lg:min-h-fit coaster-card bg-(--pure-eggshell)" href="/coasters?coaster=<?php _($coaster["coaster_pk"]) ?>">
    <article class="w-full group relative">
        <img class="block rounded-t-md w-full h-36 md:h-54 object-cover group-hover:scale-103 duration-200 bg-(--pure-indigo)"
            src="<?php _($coaster["coaster_image_path"] ?: "/static/assets/images/coaster-placeholder.webp") ?>"
            onerror="this.onerror=null; this.src='/static/assets/images/coaster-placeholder.webp'"
            alt="Coaster">
        <div class="w-5 aspect-square rounded-full absolute top-2 right-2 bg-transparent shadow-md shadow-black/80 opacity-70 transition-ease duration-100 group-hover:opacity-100">
            <?php require __DIR__ . "/___flag.php"; ?>
        </div>
        <div class="p-4 flex flex-col gap-2">
            <h4>
                <?php _($coaster["coaster_title"]); ?>
                <?php if ($coaster["coaster_is_operational"] == 0): ?>
                    <span class="text-(--system-failure)">(Defunct)</span>
                <?php endif; ?>

            </h4>
            <p class="small text-(--light-indigo)!"><?php _($coaster["coaster_model"]); ?></p>
            <div class="hidden @xs:grid grid-cols-3 gap-2 border-t border-(--darkened-eggshell) pt-2">
                <div>
                    <p class="xsmall text-(--light-indigo)!">Speed</p>
                    <h5><?php _($coaster["coaster_top_speed"]); ?> km/h</h5>
                </div>
                <div>
                    <p class="xsmall text-(--light-indigo)!">Height</p>
                    <h5><?php _(round($coaster["coaster_height"], 0)); ?> m</h5>
                </div>
                <div>
                    <p class="xsmall text-(--light-indigo)!">Length</p>
                    <h5><?php _(round($coaster["coaster_length"], 0)); ?> m</h5>
                </div>
            </div>
        </div>
    </article>
</a>