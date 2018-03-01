<?php

namespace Auditor\Controller;

use Cake\ORM\ResultSet;

/**
 * Audits Controller
 *
 * @property \Auditor\Model\Table\AuditsTable $Audits
 *
 * @method \Auditor\Model\Entity\Audit[] paginate($object = null, array $settings = [])
 */
class AuditsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = ['contain' => ['Users']];
        /** @var ResultSet $paginated */
        $paginated = $this->paginate($this->Audits);
        $audits    = $this->Audits->attachForeignEntities($paginated);

        $this->set(compact('audits'));
        $this->set('_serialize', ['audits']);
    }

    /**
     * View method
     *
     * @param string|null $id Audit id.
     *
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $audit = $this->Audits->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set('audit', $audit);
        $this->set('_serialize', ['audit']);
    }
}
