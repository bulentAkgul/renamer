<?php

namespace Bakgul\Renamer\Services;

use Bakgul\Renamer\Contracts\Modifier;
use Bakgul\Renamer\Contracts\Updater;
use Bakgul\Renamer\Services\UpdateServices\UpdateUsingNamespaceService;

class UpdateService extends Modifier
{
    public function __invoke(Updater $service, array $props): array
    {
        foreach ($this->pipeline($service) as $updater) {
            $props = $updater->handle($props);
        }

        return $props;
    }

    private function pipeline(Updater $service)
    {
        return [$service, new UpdateUsingNamespaceService];
    }
}
