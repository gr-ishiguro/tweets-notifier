<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NotifyInformationTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NotifyInformationTable Test Case
 */
class NotifyInformationTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\NotifyInformationTable
     */
    public $NotifyInformation;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.notify_information'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('NotifyInformation') ? [] : ['className' => 'App\Model\Table\NotifyInformationTable'];
        $this->NotifyInformation = TableRegistry::get('NotifyInformation', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NotifyInformation);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
