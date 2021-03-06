<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Notify Information'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="notifyInformation index large-9 medium-8 columns content">
    <h3><?= __('Notify Information') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('search_key') ?></th>
                <th scope="col"><?= $this->Paginator->sort('component') ?></th>
                <th scope="col"><?= $this->Paginator->sort('last_acquired') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notifyInformation as $notifyInformation): ?>
            <tr>
                <td><?= $this->Number->format($notifyInformation->id) ?></td>
                <td><?= h($notifyInformation->created) ?></td>
                <td><?= h($notifyInformation->modified) ?></td>
                <td><?= h($notifyInformation->search_key) ?></td>
                <td><?= h($notifyInformation->component) ?></td>
                <td><?= h($notifyInformation->last_acquired) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $notifyInformation->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $notifyInformation->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $notifyInformation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $notifyInformation->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
