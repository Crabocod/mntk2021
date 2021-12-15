<!doctype html>
<html lang="en">
<head>
    <?php echo $this->renderSection('scripts'); ?>
    <?php echo $this->renderSection('head'); ?>
</head>
<body>
<?php echo $this->renderSection('header'); ?>
<div class="wrapper">
    <?php echo $this->renderSection('nav'); ?>

    <?php echo $this->renderSection('main'); ?>
    <div class="full-width -flex">
    </div>
</div>
<?php echo $this->renderSection('footer'); ?>
<?php echo $this->renderSection('modals'); ?>
</body>
</html>