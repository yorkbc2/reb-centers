<?php 
    /** 
     * Archive page for psychology
     */
?>

<?php get_header(); ?>

<div class="container">
    <?php if (function_exists('kama_breadcrumbs')) kama_breadcrumbs('  /  '); ?>
    <h1 class="archive-header">
        <?php _e("Психологи", "brainworks"); ?>
    </h1>
    <?php 
        $prefix = "bw-psycho-";
        get_template_part('loops/content', "rehab");
    ?>
</div>

<?php get_footer(); ?>

