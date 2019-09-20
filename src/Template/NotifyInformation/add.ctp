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
            echo $this->Form->control('search_key', ['type' => 'input']);
            echo $this->Form->control('callback', ['type' => 'input']);
            echo $this->Form->control('component', ['type' => 'input']);
            echo $this->Form->control('last_acquired', ['type' => 'input']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
