<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * NotifyInformation Controller
 *
 * @property \App\Model\Table\NotifyInformationTable $NotifyInformation
 */
class NotifyInformationController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $notifyInformation = $this->paginate($this->NotifyInformation);

        $this->set(compact('notifyInformation'));
        $this->set('_serialize', ['notifyInformation']);
    }

    /**
     * View method
     *
     * @param string|null $id Notify Information id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $notifyInformation = $this->NotifyInformation->get($id, [
            'contain' => []
        ]);

        $this->set('notifyInformation', $notifyInformation);
        $this->set('_serialize', ['notifyInformation']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $notifyInformation = $this->NotifyInformation->newEntity();
        if ($this->request->is('post')) {
            $notifyInformation = $this->NotifyInformation->patchEntity($notifyInformation, $this->request->getData());
            if ($this->NotifyInformation->save($notifyInformation)) {
                $this->Flash->success(__('The notify information has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The notify information could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('notifyInformation'));
        $this->set('_serialize', ['notifyInformation']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Notify Information id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $notifyInformation = $this->NotifyInformation->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $notifyInformation = $this->NotifyInformation->patchEntity($notifyInformation, $this->request->data);
            if ($this->NotifyInformation->save($notifyInformation)) {
                $this->Flash->success(__('The notify information has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The notify information could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('notifyInformation'));
        $this->set('_serialize', ['notifyInformation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Notify Information id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notifyInformation = $this->NotifyInformation->get($id);
        if ($this->NotifyInformation->delete($notifyInformation)) {
            $this->Flash->success(__('The notify information has been deleted.'));
        } else {
            $this->Flash->error(__('The notify information could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
