<?php
/**
 * @var \App\View\AppView                                                       $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $audits
 */
$this->extend('/Common/index');
$this->assign('title', __('Audits'));
?>

<? $this->start('table_headers'); ?>
<th><?= $this->Paginator->sort('user_id') ?></th>
<th><?= $this->Paginator->sort('action') ?></th>
<th><?= $this->Paginator->sort('model_name') ?></th>
<th><?= $this->Paginator->sort('model_uid') ?></th>
<th><?= $this->Paginator->sort('created') ?></th>
<? $this->end() ?>
<? $this->start('table_body'); ?>
<? foreach ($audits as $audit): ?>
    <tr>
        <td><?= $audit->has('user') ? $this->Html->link($audit->user->name, [
                'controller' => 'Users',
                'action'     => 'view',
                h($audit->user->id),
            ]) : ''
            ?>
        </td>
        <td><?= $this->Html->link($audit->action, ['action'=>'view',$audit->id]) ?></td>
        <td><?= str_replace('Model\Entity\\', '', $audit->model_name) ?></td>
        <td>
            <?= h($audit->attached) ?>
        </td>
        <td><?= h($audit->created) ?></td>
    </tr>
<?php endforeach; ?>
<? $this->end() ?>
<? $this->start('side_nav'); ?>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?= __('Actions') ?></div>

    <!-- List group -->
    <div class="list-group">
        <?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index'],
            ['class' => 'list-group-item']) ?>
    </div>
</div>
<? $this->end() ?>
