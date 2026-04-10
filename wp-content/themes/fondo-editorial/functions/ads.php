<?php 

function expreso_cargar_anuncios() {
    if (is_admin()) return;
    if (is_amp()) return; // No cargar anuncios en AMP
    ?>
<div class="uk-ad-container"> <ins class="adsbygoogle"  style="display:block" data-ad-client="ca-pub-5091050448793286" data-ad-slot="5621870724" data-ad-format="auto" data-full-width-responsive="true"></ins></div>
    <?php
}

