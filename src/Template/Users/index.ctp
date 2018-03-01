<?php
/**
 * @var \App\View\AppView                                                       $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $users
 */
$this->extend('/Common/index');
$this->assign('title', __('Users'));
?>

<? $this->start('table_headers'); ?>
<th><?= $this->Paginator->sort('name') ?></th>
<th><?= $this->Paginator->sort('email') ?></th>
<th><?= $this->Paginator->sort('Creates') ?></th>
<th><?= $this->Paginator->sort('Saves') ?></th>
<th><?= $this->Paginator->sort('Deletions') ?></th>
<? $this->end() ?>
<? $this->start('table_body'); ?>
<? foreach ($users as $user): ?>
    <tr>
        <td><?= $this->Html->link(h($user->name), ['action' => 'view', $user->id]) ?></td>
        <td><?= h($user->email) ?></td>
        <td><?= $user->audits_created ? $user->audits_created[0]->total : 0 ?></td>
        <td><?= $user->audits_saved ? $user->audits_saved[0]->total : 0 ?></td>
        <td><?= $user->audits_deleted ? $user->audits_deleted[0]->total : 0 ?></td>
    </tr>
<?php endforeach; ?>
<? $this->end() ?>
<? $this->start('side_nav'); ?>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?= __('Actions') ?></div>

    <!-- List group -->
    <div class="list-group">
        <?= $this->Html->link(__('List Audits'), ['controller' => 'Audits'], ['class' => 'list-group-item']) ?>
    </div>
</div>
<? $this->end() ?>
