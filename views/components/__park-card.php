<?php

/** @var array $park */ ?>

<a class="overflow-hidden shadow-sm rounded-md w-full " href="/parks?park=<?php _($park['park_slug']) ?>">
    <article class="bg-(--pure-eggshell) w-full h-full">
        <img class="block rounded-t-md w-full h-54 object-cover" src="<?php _($park['park_image_path']); ?>" alt="Park" srcset="">
        <div class="p-4 flex flex-col gap-2">
            <h4><?php _($park['park_title']); ?></h4>
            <p class="small text-(--light-indigo)!"><?php _($park['park_city']); ?>, <?php _($park['park_country']); ?></p>
        </div>
    </article>
</a>