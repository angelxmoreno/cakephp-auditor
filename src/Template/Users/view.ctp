<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $user
 * @var \Cake\Datasource\EntityInterface[] $audits
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('List Audits'), ['controller'=>'Audits','action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($user->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
    </table>

    <div class="row">
        <h2><?= __('Audits') ?></h2>
        <? if (count($audits) === 0) : ?>
            <p class="lead">
                No audit data
            </p>
        <? else : ?>
            <? foreach ($audits as $audit): ?>
        <table class="vertical-table">
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= $this->Time->timeAgoInWords($audit->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Action') ?></th>
                <td><?= h($audit->action) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Model') ?></th>
                <td><?= h($audit->model_name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Model Id') ?></th>
                <td><?=h($audit->model_uid) ?></td>
            </tr>
            <tr>
                <td>
                    <?= $this->Html->link(__('View'), [
                            'controller' => 'audits',
                            'action'     => 'view',
                            $audit->id,
                        ]);
                    ?>
                </td>
            </tr>
        </table>
                <hr/>
            <? endforeach; ?>
            <?= $this->element('pagination') ?>
        <? endif; ?>
    </div>
</div>
