<?php

/** @var array $coaster */ ?>

<a class="overflow-hidden shadow-sm rounded-md w-full anim-slide-in min-h-fit coaster-card bg-(--pure-eggshell)" href="/coasters?coaster=<?php _($coaster["coaster_pk"]) ?>">
    <article class=" w-full group">
        <img class="block rounded-t-md w-full h-54 object-cover group-hover:scale-103 duration-200" src="<?php if ($coaster['coaster_image_path'] !== ""): ?><?php _($coaster["coaster_image_path"]) ?> <?php else: ?><?php _("static/assets/images/coaster-placeholder.webp") ?> <?php endif; ?>" alt="Coaster" srcset="">
        <div class="p-4 flex flex-col gap-2">
            <h4><?php _($coaster["coaster_title"]); ?>
                <?php if ($coaster["coaster_is_operational"] == 0): ?>
                    <span class="text-(--system-failure)">(Defunct)</span>
                <?php endif; ?>
            </h4>
            <p class="small text-(--light-indigo)!"><?php _($coaster["coaster_model"]); ?></p>
        </div>
    </article>
</a>