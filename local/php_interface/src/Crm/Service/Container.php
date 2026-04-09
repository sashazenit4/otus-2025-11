<?php

namespace Otus\Crm\Service;

use Bitrix\Crm\Model\Dynamic\TypeTable;
use Bitrix\Crm\Service\Container as CrmServiceContainer;
use Bitrix\Crm\Service\Factory;
use Otus\Crm\Service\Factory\Dynamic\DomainFactory;

class Container extends CrmServiceContainer
{
    public function getFactory(int $entityTypeId): ?Factory
    {
        $domainProlongationEntityTypeId = self::getEntityTypeIdByCode('domainProlongation');
        if ($domainProlongationEntityTypeId === $entityTypeId) {
            return new DomainFactory($this->getTypeByEntityTypeId($domainProlongationEntityTypeId));
        }

        return parent::getFactory($entityTypeId);
    }

    public static function getEntityTypeIdByCode(string $code): int
    {
        return TypeTable::getList([
            'filter' => [
                'CODE' => $code,
            ],
            'cache' => [
                'ttl' => 3600000,
            ],
            'select' => [
                'ENTITY_TYPE_ID',
            ],
        ])->fetch()['ENTITY_TYPE_ID'] ?? 0;
    }
}
