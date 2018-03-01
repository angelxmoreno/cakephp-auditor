<?php
/**
 * @var \App\View\AppView                $this
 * @var \Cake\Datasource\EntityInterface $audit
 */
$this->extend('/Common/view');
$this->assign('title', __('Audit'));
$this->assign('sub_title', h($audit->action) . ' ' . h($audit->model_name));
?>
<div class="container">
    <table class="table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $audit->has('user') ? $this->Html->link($audit->user->name,
                    ['controller' => 'Users', 'action' => 'view', $audit->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Model Name') ?></th>
            <td><?= h($audit->model_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Action') ?></th>
            <td><?= h($audit->action) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($audit->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Previous') ?></th>
            <td>
                <xmp>
                    <?= print_r($audit->previous, true) ?>
                </xmp>
            </td>
        </tr>
        <tr>
            <th scope="row"><?= __('Current') ?></th>
            <td>
                <xmp>
                    <?= print_r($audit->current, true) ?>
                </xmp>
            </td>
        </tr>
    </table>
</div>
<? $this->start('side_nav') ?>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?= __('Actions') ?></div>

    <!-- List group -->
    <div class="list-group">
        <?= $this->Html->link(__('List Audits'), ['action' => 'index'], ['class' => 'list-group-item']) ?>
        <?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index'],
            ['class' => 'list-group-item']) ?>
    </div>
</div>
<? $this->end() ?>
