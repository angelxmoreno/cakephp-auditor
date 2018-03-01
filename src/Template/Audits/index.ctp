<?php
/**
 * @var \App\View\AppView                                                       $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $audits
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="audits index large-9 medium-8 columns content">
    <h3><?= __('Audits') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('model_name') ?></th>
            <th scope="col"><?= $this->Paginator->sort('model_uid') ?></th>
            <th scope="col"><?= $this->Paginator->sort('action') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($audits as $audit): ?>
            <tr>
                <td><?= $this->Number->format($audit->id) ?></td>
                <td><?= $audit->has('user') ? $this->Html->link($audit->user->name,
                        ['controller' => 'Users', 'action' => 'view', $audit->user->id]) : '' ?></td>
                <td><?= h($audit->model_name) ?></td>
                <td><?= $this->Number->format($audit->model_uid) ?></td>
                <td><?= h($audit->action) ?></td>
                <td><?= h($audit->created) ?></td>
                <td><?= h($audit->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $audit->id]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
