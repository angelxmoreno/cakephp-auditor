<?php

namespace Auditor\Controller;

use App\Model\Entity\User;
use App\Model\Table\UsersTable;
use Cake\ORM\Query;

/**
 * Users Controller
 *
 * @property UsersTable $Users
 * @method User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public $modelClass = 'Users';

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = $this->Users->auditorPaginate();
        $users          = $this->paginate($this->Users);
        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     *
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id);

        $audits = $this->paginate('Audits', [
            'limit' => 10,
            'conditions' => [
                'Audits.user_id' => $id
            ],
            'order' => [
                'Audits.created' => 'DESC'
            ]
        ]);

        $this->set(compact('user', 'audits'));
    }
}
