<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\CmsSlotStorage\Communication\Plugin\Event\Listener;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CmsSlotTransfer;
use Generated\Shared\Transfer\EventEntityTransfer;
use Orm\Zed\CmsSlotStorage\Persistence\SpyCmsSlotStorageQuery;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Queue\QueueDependencyProvider;
use Spryker\Zed\CmsSlot\Dependency\CmsSlotEvents;
use Spryker\Zed\CmsSlotStorage\Communication\Plugin\Event\Listener\CmsSlotStoragePublishListener;
use Spryker\Zed\CmsSlotStorage\Persistence\CmsSlotStorageEntityManager;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group CmsSlotStorage
 * @group Communication
 * @group Plugin
 * @group Event
 * @group Listener
 * @group CmsSlotStoragePublishListenerTest
 * Add your own group annotations below this line
 */
class CmsSlotStoragePublishListenerTest extends Unit
{
    /**
     * @var string
     */
    protected const CMS_SLOT_KEY = 'test_cms_slot_key';

    /**
     * @var \SprykerTest\Zed\CmsSlotStorage\CmsSlotStorageCommunicationTester
     */
    protected $tester;

    /**
     * @var \Spryker\Zed\CmsSlotStorage\Persistence\CmsSlotStorageEntityManagerInterface
     */
    protected $cmsSlotStorageEntityManager;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->tester->setDependency(QueueDependencyProvider::QUEUE_ADAPTERS, function (Container $container) {
            return [
                $container->getLocator()->rabbitMq()->client()->createQueueAdapter(),
            ];
        });

        $this->cmsSlotStorageEntityManager = new CmsSlotStorageEntityManager();
    }

    /**
     * @return void
     */
    public function testCmsSlotStoragePublishListenerStoreDataIfCmsSlotIsActive(): void
    {
        // Arrange
        $cmsSlotTransfer = $this->tester->haveCmsSlotInDb([
            CmsSlotTransfer::KEY => static::CMS_SLOT_KEY,
            CmsSlotTransfer::IS_ACTIVE => true,
        ]);
        $beforeCount = count(SpyCmsSlotStorageQuery::create()->filterByCmsSlotKey_In([static::CMS_SLOT_KEY])->find());
        $cmsSlotStoragePublishListener = new CmsSlotStoragePublishListener();
        $cmsSlotStoragePublishListener->setFacade($this->tester->getFacade());

        $eventTransfers = [
            (new EventEntityTransfer())->setId($cmsSlotTransfer->getIdCmsSlot()),
        ];

        // Act
        $cmsSlotStoragePublishListener->handleBulk($eventTransfers, CmsSlotEvents::CMS_SLOT_PUBLISH);

        // Assert
        $this->assertCmsSlotStorage($beforeCount, $cmsSlotTransfer);
    }

    /**
     * @param int $beforeCount
     * @param \Generated\Shared\Transfer\CmsSlotTransfer $cmsSlotTransfer
     *
     * @return void
     */
    protected function assertCmsSlotStorage(int $beforeCount, CmsSlotTransfer $cmsSlotTransfer): void
    {
        $cmsSlotStorageEntities = SpyCmsSlotStorageQuery::create()->filterByCmsSlotKey_In([$cmsSlotTransfer->getKey()])->find();

        /** @var array $cmsSlotStorageData */
        $cmsSlotStorageData = $cmsSlotStorageEntities[0]->getData();

        $this->assertGreaterThan($beforeCount, count($cmsSlotStorageEntities));
        $this->assertEquals($cmsSlotStorageData['key'], $cmsSlotTransfer->getKey());
        $this->assertEquals($cmsSlotStorageData['name'], $cmsSlotTransfer->getName());
        $this->assertEquals($cmsSlotStorageData['description'], $cmsSlotTransfer->getDescription());
        $this->assertEquals($cmsSlotStorageData['content_provider_type'], $cmsSlotTransfer->getContentProviderType());
    }
}
