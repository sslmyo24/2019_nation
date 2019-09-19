<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>부산국제매직페스티벌</title>

	<!-- css -->
	<link rel="stylesheet" href="/style.css">

	<!-- js -->
	<script src="/js/jquery-3.4.1.min.js"></script>
	<script src="/js/apps.js"></script>

<?php if ($this->url->type === 'teaser'): ?>
	<?php if ($this->page_info->title != null): ?>
	<meta name="title" content="<?php echo $this->page_info->title ?>">
	<?php endif; ?>
	<?php if ($this->page_info->description != null): ?>
	<meta name="description" content="<?php echo $this->page_info->description ?>">
	<?php endif; ?>
	<?php if ($this->page_info->keyword != null): ?>
	<meta name="keywords" content="<?php echo $this->page_info->keyword ?>">
	<?php endif; ?>

	<style>
		header {position:fixed; width: 100%; top: 0; left: 0; z-index: 500;}
		[data-type="header"] + * {margin-top: 140px;}
	</style>
<?php endif; ?>

</head>

<?php if ($this->url->member): ?><script>timeCheck()</script><?php endif; ?>