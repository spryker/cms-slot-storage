<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsSlotStorage\Communication;

use Spryker\Zed\CmsSlotStorage\CmsSlotStorageDependencyProvider;
use Spryker\Zed\CmsSlotStorage\Dependency\Facade\CmsSlotStorageToCmsSlotFacadeInterface;
use Spryker\Zed\CmsSlotStorage\Dependency\Facade\CmsSlotStorageToEventBehaviorFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \Spryker\Zed\CmsSlotStorage\CmsSlotStorageConfig getConfig()
 * @method \Spryker\Zed\CmsSlotStorage\Persistence\CmsSlotStorageRepositoryInterface getRepository()
 * @method \Spryker\Zed\CmsSlotStorage\Business\CmsSlotStorageFacadeInterface getFacade()
 * @method \Spryker\Zed\CmsSlotStorage\Persistence\CmsSlotStorageEntityManagerInterface getEntityManager()
 */
class CmsSlotStorageCommunicationFactory extends AbstractCommunicationFactory
{
    public function getCmsSlotFacade(): CmsSlotStorageToCmsSlotFacadeInterface
    {
        return $this->getProvidedDependency(CmsSlotStorageDependencyProvider::FACADE_CMS_SLOT);
    }

    public function getEventBehaviorFacade(): CmsSlotStorageToEventBehaviorFacadeInterface
    {
        return $this->getProvidedDependency(CmsSlotStorageDependencyProvider::FACADE_EVENT_BEHAVIOR);
    }
}
