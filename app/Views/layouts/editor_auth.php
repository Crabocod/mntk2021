<!doctype html>
<html lang="en">
<head>
    <?php echo $this->renderSection('head'); ?>
</head>
<body>
<div class="wrapper auth__wrapper -flex -center -justify-center">
    <?php echo $this->renderSection('main'); ?>
</div>

<?php echo $this->renderSection('footer'); ?>

<?php echo $this->renderSection('scripts'); ?>
</body>
<?php echo $this->renderSection('modals'); ?>
</html>