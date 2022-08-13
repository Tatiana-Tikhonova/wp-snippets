<?php

/**
 * вывод метабоксов поста в цикле
 */
/**
 * текст (содержимое мини-редактора выводится аналогично)
 */
?>
<div><?php echo esc_html__(get_post_meta(get_the_ID(), 'tati_text_example', true), 'tati'); ?></div>
<?php
/**
 * текстареа
 */
$text = get_post_meta(get_the_ID(), 'tati_textarea_ex');
if ($text) : ?>
    <div><?php echo get_post_meta(get_the_ID(), 'tati_textarea_ex', true); ?></div>
<?php endif; ?>

<?php

/** 
 * чекбоксы
 */
$checkboxes = get_post_meta(get_the_ID(), 'tati_checkbox_ex', true);
if (in_array('yes', $checkboxes)) : ?>
    <h2>Yes</h2>
<?php
endif;
?>
<?php
if (in_array('no', $checkboxes)) :
?>
    <h2>No</h2>
<?php
endif;
?>
<?php
/**
 * радиокнопки
 */
$radio = get_post_meta(get_the_ID(), 'tati_radio_ex');
if (in_array('yes', $radio)) : ?>
    <h2>Yes</h2>
<?php
endif;
?>
<?php
if (in_array('no', $radio)) :
?>
    <h2>No</h2>
<?php
endif;
?>