<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsSlotStorage\Business\Publisher;

interface CmsSlotStoragePublisherInterface
{
    /**
     * @param array<int> $cmsSlotIds
     *
     * @return void
     */
    public function publishByCmsSlotIds(array $cmsSlotIds): void;
}
