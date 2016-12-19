<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Notify Information'), ['action' => 'edit', $notifyInformation->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Notify Information'), ['action' => 'delete', $notifyInformation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $notifyInformation->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Notify Information'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Notify Information'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="notifyInformation view large-9 medium-8 columns content">
    <h3><?= h($notifyInformation->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Search Key') ?></th>
            <td><?= h($notifyInformation->search_key) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Component') ?></th>
            <td><?= h($notifyInformation->component) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Last Acquired') ?></th>
            <td><?= h($notifyInformation->last_acquired) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($notifyInformation->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($notifyInformation->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($notifyInformation->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Callback') ?></h4>
        <?= $this->Text->autoParagraph(h($notifyInformation->callback)); ?>
    </div>
</div>
