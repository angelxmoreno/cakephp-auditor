<?php
/**
 * @var \App\View\AppView             $this
 * @var \App\Model\Entity\User        $user
 * @var \Auditor\Model\Entity\Audit[] $audits
 */
$this->extend('/Common/view');
$this->assign('title', __('User'));
$this->assign('sub_title', h($user->name));
?>
<div class="container">
    <table class="table">
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
            <th scope="row"><?= __('Is Admin') ?></th>
            <td><?= $user->is_admin ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Superadmin') ?></th>
            <td><?= $user->is_superadmin ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Active') ?></th>
            <td><?= $user->is_active ? __('Yes') : __('No'); ?></td>
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
                <ul class="list-inline">
                    <li><?= $this->Time->timeAgoInWords($audit->created) ?></li>
                    <li>
                        <?= $this->Html->link(implode(' ',
                            [
                                $audit->action,
                                $audit->model_name,
                                $audit->model_uid,
                            ]),
                            [
                                'controller' => 'audits',
                                'action'     => 'view',
                                $audit->id,
                            ]);
                        ?>
                    </li>
                </ul>
                <hr/>
            <? endforeach; ?>
            <?= $this->element('pagination') ?>
        <? endif; ?>
    </div>
</div>
<? $this->start('side_nav') ?>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?= __('Actions') ?></div>

    <!-- List group -->
    <div class="list-group">
        <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'list-group-item']) ?>
        <?= $this->Html->link(__('List Audits'), ['controller' => 'Audits'], ['class' => 'list-group-item']) ?>
    </div>
</div>
<? $this->end() ?>
