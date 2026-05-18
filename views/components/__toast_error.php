<?php

/** @var string $message **/ ?>

<div class="anim-slide-in rounded-md bg-(--system-failure)/70 border-2 border-(--system-failure) p-6 my-4 text-(--pure-indigo)">
    <h5 class="mb-2 small font-bold!">Error:</h5>
    <?php if (isset($message)) : ?>
        <?php _($message); ?>
    <?php else : ?>
        <p class="small">An unknown error occurred.</p>
    <?php endif; ?>
</div>