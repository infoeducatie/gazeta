<?php
/* ------------------------------------------------------------------------- *
 *  Footer template
/* ------------------------------------------------------------------------- */

//  Variables
$disable_stuff    = of_get_option( 'ac_disable_elements' );
$disable_credit   = $disable_stuff['credit'];
$credit_link    = 'http://www.acosmin.com/';
$the_wp_link    = 'http://wordpress.org/';
$copyright_text   = get_theme_mod( 'ac_footer_copyright_text', 'Copyright 2013 JUSTWRITE. All rights reserved.' );
$logo_text      = get_theme_mod( 'ac_footer_logo_text', 'JustWrite' );
?>
    <?php
      // Before the main <header> tag
      ac_before_footer();
    ?>
    <footer id="main-footer" class="footer-wrap<?php ac_mini_disabled() ?> clearfix">
      <aside class="footer-credits footer-partners">
        <p>Parteneri</p>
        <ul>
          <li><a href="http://presslabs.com"><img src="http://cdn.gazeta.info.ro/wp-content/uploads/2015/04/pl.png" alt="PressLabs" title="PressLabs"></a></li>
          <li><a href="http://upir.ro"><img src="http://cdn.gazeta.info.ro/wp-content/uploads/2015/04/upir.png" alt="UPIR" title="Uniunea Profesorilor de Informatică din România"></a></li>
          <li><a href="http://agora.ro"><img src="http://cdn.gazeta.info.ro/wp-content/uploads/2015/04/11050659_426510460862550_3037354345692282831_n-e1430007927965.jpg" alt="Agora" title="Agora"></a></li>
        </ul>
      </aside><!-- END .footer-credits -->
    </footer><!-- END .footer-wrap -->

    </div><!-- END .wrap -->

    <?php
    // Before the <body> tag closes hook
    ac_before_body_closed();
    ?>


    <?php
    wp_footer();
    ?>

</body>
</html>
