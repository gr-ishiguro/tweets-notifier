<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Notify Information'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="notifyInformation form large-9 medium-8 columns content">
    <?= $this->Form->create($notifyInformation) ?>
    <fieldset>
        <legend><?= __('Add Notify Information') ?></legend>
        <?php
            echo $this->Form->input('search_key');
            echo $this->Form->input('callback');
            echo $this->Form->input('component');
            echo $this->Form->input('last_acquired');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
