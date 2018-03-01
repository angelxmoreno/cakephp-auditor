<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $audit
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Audits'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="audits view large-9 medium-8 columns content">
    <h3><?= h($audit->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $audit->has('user') ? $this->Html->link($audit->user->name, ['controller' => 'Users', 'action' => 'view', $audit->user->id]) : '' ?></td>
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
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($audit->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Model Uid') ?></th>
            <td><?= $this->Number->format($audit->model_uid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($audit->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($audit->modified) ?></td>
        </tr>
    </table>
</div>
