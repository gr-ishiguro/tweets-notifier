<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $notifyInformation->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $notifyInformation->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Notify Information'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="notifyInformation form large-9 medium-8 columns content">
    <?= $this->Form->create($notifyInformation) ?>
    <fieldset>
        <legend><?= __('Edit Notify Information') ?></legend>
        <?php
            echo $this->Form->control('search_key');
            echo $this->Form->control('callback');
            echo $this->Form->control('component');
            echo $this->Form->control('last_acquired');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
