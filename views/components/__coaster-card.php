<?php

/** @var array $coaster */ ?>

<a class="overflow-hidden shadow-sm rounded-md w-full" href="/coasters?coaster=<?= $coaster['coaster_title'] ?>">
    <article class="bg-(--pure-eggshell) w-full">
        <img class="block rounded-t-md w-full" src="<?php _($coaster['coaster_image_path']); ?>" alt="Coaster" srcset="">
        <div class="p-4 flex flex-col gap-2">
            <h4><?php _($coaster['coaster_title']); ?></h4>
            <p class="small text-(--light-indigo)!"><?php _($coaster['coaster_model']); ?></p>
        </div>
    </article>
</a>