
<div class="tags form large-9 medium-8 columns content">
    <?= $this->Form->create($article) ?>
    <fieldset>
        <legend><?= __('Edit Article') ?></legend>
        <?php
		    echo $this->Form->control('title');
		    echo $this->Form->control('body', ['rows' => '3']);
		    //echo $this->Form->control('tags._ids', ['options' => $tags]);
		    echo $this->Form->control('tag_string', ['type' => 'text']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Save Article')) ?>
    <?= $this->Form->end() ?>
</div>
