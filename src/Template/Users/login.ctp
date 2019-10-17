<style type="text/css">
	#actions-sidebar{
		display: none;
	}
</style>
<div class="users index large-4 medium-4">
	<h1>Login</h1>
	<?= $this->Form->create() ?>
	<?= $this->Form->control('email') ?>
	<?= $this->Form->control('password') ?>
	<?= $this->Form->button('Login') ?>
	<?= $this->Form->end() ?>
</div>