<?php
namespace Auditor\Test\TestCase\Model\Table;

use Auditor\Model\Table\AuditsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Auditor\Model\Table\AuditsTable Test Case
 */
class AuditsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Auditor\Model\Table\AuditsTable
     */
    public $Audits;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.auditor.audits',
        'plugin.auditor.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Audits') ? [] : ['className' => AuditsTable::class];
        $this->Audits = TableRegistry::get('Audits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Audits);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
