<?php

namespace Otus\Crm\Service\Factory\Dynamic;

use Bitrix\Crm\Item;
use Bitrix\Crm\Service\Context;
use Bitrix\Crm\Service\Operation;
use Bitrix\Main\Result;
use Bitrix\Crm\Service\Factory\Dynamic as BitrixDynamic;
use Bitrix\Crm\Service\Operation\Action;

class DomainFactory extends BitrixDynamic
{
    public function getAddOperation(Item $item, Context $context = null): Operation\Add
    {
        $addOperation = parent::getAddOperation($item, $context);

        $addOperation->addAction($addOperation::ACTION_AFTER_SAVE, new class extends Action {
            public function process(Item $item): Result
            {
                $result = new Result();

                $item->setTitle(sprintf('Продление домена: %s', $item->getTitle()));
                $item->save();
                $result->setData([
                    'item' => $item,
                ]);

                return $result;
            }
        });

        return $addOperation;
    }
}
