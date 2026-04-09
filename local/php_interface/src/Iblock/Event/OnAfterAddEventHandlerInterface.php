<?php

namespace Otus\Iblock\Event;

interface OnAfterAddEventHandlerInterface
{
    /**
     * Метод вызывается после добавления элемента
     *
     * @param array $element Ссылка на добавленный элемент
     * @return void
     */
    public function onAfterAdd(array &$element);
}
