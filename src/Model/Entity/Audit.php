<?php

namespace Auditor\Model\Entity;

use App\Model\Entity\AppEntity;

/**
 * Audit Entity
 *
 * @property int                        $id
 * @property int                        $user_id
 * @property string                     $model_name
 * @property int                        $model_uid
 * @property string                     $action
 * @property array                      $previous
 * @property array                      $current
 * @property \Cake\I18n\FrozenTime      $created
 * @property \Cake\I18n\FrozenTime      $modified
 *
 * @property \Auditor\Model\Entity\User $user
 */
class Audit extends AppEntity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible
        = [
            'user_id'    => true,
            'model_name' => true,
            'model_uid'  => true,
            'action'     => true,
            'previous'   => true,
            'current'    => true,
            'created'    => true,
            'modified'   => true,
            'user'       => true,
        ];
}
