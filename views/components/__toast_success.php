<?php

/** @var string $message **/ ?>

<div class="relative opacity-0 anim-toast rounded-md bg-(--system-success)/90 border-2 border-(--system-success) p-6 my-4 text-(--pure-indigo)">
    <h5 class="mb-2 small font-bold!">Success</h5>
    <?php if (isset($message)) : ?>
        <?php _($message); ?>
    <?php else : ?>
        <p class="small">An unknown error occurred.</p>
    <?php endif; ?>
</div>