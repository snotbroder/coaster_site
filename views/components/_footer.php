</main>
<?php $user = $_SESSION["user_email"] ?? NULL ?>
<footer class="w-full mt-24 mb-8 px-4 ">
    <section class="relative border-t border-t-(--darkened-eggshell) py-6 pb-24 flex flex-col md:grid md:grid-cols-4 gap-12 md:gap-24 lg:gap-40">
        <div class="flex flex-col gap-4">
            <h5>Popular parks</h5>
            <ul class="flex flex-col gap-2">
                <li><a href="/parks?park=efteling" class="foot-link">Efteling</a></li>
                <li><a href="/parks?park=europa-park" class="foot-link">Europa Park</a></li>
                <li><a href="/parks?park=phantasialand" class="foot-link">Phantasialand</a></li>
                <li><a href="/parks?park=liseberg" class="foot-link">Liseberg</a></li>
            </ul>
        </div>

        <div class="flex flex-col gap-4">
            <h5>Popular coasters</h5>
            <ul class="flex flex-col gap-2">
                <li><a href="/coasters?coaster=9baff3f9c6784ebf93d3ec602a2ec694" class="foot-link">Black Mamba</a></li>
                <li><a href="/coasters?coaster=85464bace1f748999f5b265acc02f3fd" class="foot-link">Silver Star</a></li>
                <li><a href="/coasters?coaster=042fb564699e4ce2ab2dfb9510a970fb" class="foot-link">Colossos - Kampf der Giganten</a></li>
                <li><a href="/coasters?coaster=0fb9d90b86984730810134fbc911cdd8" class="foot-link">F.L.Y.</a></li>
            </ul>
        </div>
        <div class="flex flex-col gap-4">
            <h5>Utility</h5>
            <ul class="flex flex-col gap-2">
                <?php if (!$user): ?>
                    <li><a href="/login" class="foot-link">Log in</a></li>
                    <li><a href="/sign-up" class="foot-link">Sign up</a></li>
                <?php else: ?>
                    <li><a href="/account" class="foot-link">Account</a></li>

                <?php endif; ?>

                <li><a href="/parks" class="foot-link">All parks</a></li>
                <li><a href="/coasters" class="foot-link">All coasters</a></li>
                <li><a href="/map" class="foot-link">View map</a></li>
            </ul>
        </div>
        <div class="absolute h-20 bottom-22 right-0 opacity-40">
            <img src="/static/assets/logo.svg" alt="Logo">
        </div>
    </section>
    <p class="small mb-4">Coastercodex.dk &#x00A9; - <?php _(date("Y")) ?></p>
    <p class="xsmall">This is a school project - I do not own any copyright or any other intellectual property rights regarding imagery, names or copy. Icons from <a class="underline hover:text-(--pure-seagreen)" href="https://www.svgrepo.com/collection/solar-broken-line-icons/">SVGrepo</a>.</p>
    <p class="xsmall">I will not be held liable for anything LMAOO.</p>

</footer>
</body>

</html>