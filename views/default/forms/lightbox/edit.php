<?php
/**
 * Elgg album create/edit form
 *
 * @package ElggLightbox
 */

// once elgg_view stops throwing all sorts of junk into $vars, we can use 
$title = elgg_extract('title', $vars, '');
$desc = elgg_extract('description', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$container_guid = elgg_extract('container_guid', $vars);
if (!$container_guid) {
	$container_guid = elgg_get_logged_in_user_guid();
}
$guid = elgg_extract('guid', $vars, null);
?>
<div>
	<label><?php echo elgg_echo('lightbox:title'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title)); ?>
</div>

<div>
	<label><?php echo elgg_echo('lightbox:image:upload'); ?></label><br />
	<?php echo elgg_view('input/file', array('name' => 'upload0')); ?>
</div>
<div>
	<label><?php echo elgg_echo('lightbox:image:upload:another'); ?></label><br />
	<?php echo elgg_view('input/file', array('name' => 'upload1')); ?>
</div>
<div>
	<label><?php echo elgg_echo('lightbox:image:upload:another'); ?></label><br />
	<?php echo elgg_view('input/file', array('name' => 'upload2')); ?>
</div>

<?php if($guid): ?>

<div>
	<label><?php echo elgg_echo('lightbox:description'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $desc)); ?>
</div>

<?php endif; ?>

<div>
	<label><?php echo elgg_echo('lightbox:tags'); ?></label>
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'value' => $tags)); ?>
</div>
<?php

$categories = elgg_view('input/categories', $vars);
if ($categories) {
	echo $categories;
}

?>
<div>
	<label><?php echo elgg_echo('access'); ?></label><br />
	<?php echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id)); ?>
</div>
<div class="elgg-foot">
<?php

echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));

if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
}

echo elgg_view('input/submit', array('value' => elgg_echo('save')));

?>
</div>
