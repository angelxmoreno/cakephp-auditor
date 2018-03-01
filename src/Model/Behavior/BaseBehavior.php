<?php

namespace Auditor\Model\Behavior;

use Auditor\Model\Table\AuditsTable;
use Cake\ORM\Behavior;
use Cake\ORM\TableRegistry;

/**
 * Class BaseBehavior
 *
 * @package Auditor\Model\Behavior
 */
abstract class BaseBehavior extends Behavior
{
    const AUDIT_MODEL = 'Auditor.Audits';

    /**
     *
     * @var AuditsTable
     */
    protected $audit_table;

    /**
     *
     * @return AuditsTable
     */
    protected function getAuditTable()
    {
        if (!$this->audit_table) {
            $this->audit_table = TableRegistry::get(self::AUDIT_MODEL);
        }

        return $this->audit_table;
    }
}
