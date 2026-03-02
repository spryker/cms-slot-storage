<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\CmsSlotStorage;

use Spryker\Client\CmsSlotStorage\Dependency\Client\CmsSlotStorageToStorageClientInterface;
use Spryker\Client\CmsSlotStorage\Dependency\Service\CmsSlotStorageToSynchronizationServiceInterface;
use Spryker\Client\CmsSlotStorage\Reader\CmsSlotStorageReader;
use Spryker\Client\CmsSlotStorage\Reader\CmsSlotStorageReaderInterface;
use Spryker\Client\Kernel\AbstractFactory;

class CmsSlotStorageFactory extends AbstractFactory
{
    public function createCmsSlotStorageReader(): CmsSlotStorageReaderInterface
    {
        return new CmsSlotStorageReader(
            $this->getStorageClient(),
            $this->getSynchronizationService(),
        );
    }

    public function getStorageClient(): CmsSlotStorageToStorageClientInterface
    {
        return $this->getProvidedDependency(CmsSlotStorageDependencyProvider::CLIENT_STORAGE);
    }

    public function getSynchronizationService(): CmsSlotStorageToSynchronizationServiceInterface
    {
        return $this->getProvidedDependency(CmsSlotStorageDependencyProvider::SERVICE_SYNCHRONIZATION);
    }
}
