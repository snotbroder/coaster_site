<?php

/** @var array $coaster */

?>

<a class="overflow-hidden shadow-sm rounded-md w-full anim-slide-in min-h-fit coaster-card bg-(--pure-eggshell)" href="/coasters?coaster=<?php _($coaster["coaster_pk"]) ?>">
    <article class=" w-full group relative">
        <img class="block rounded-t-md w-full h-54 object-cover group-hover:scale-103 duration-200 bg-(--pure-indigo)"
            src="<?php _($coaster["coaster_image_path"] ?: "/static/assets/images/coaster-placeholder.webp") ?>"
            onerror="this.onerror=null; this.src='/static/assets/images/coaster-placeholder.webp'"
            alt="Coaster">
        <div class="w-5 aspect-square rounded-full absolute top-2 right-2 bg-transparent shadow-md shadow-black/80">
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
        </div>
    </article>
</a>